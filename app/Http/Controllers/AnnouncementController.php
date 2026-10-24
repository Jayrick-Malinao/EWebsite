<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementRecipient;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Resident;
use App\Models\User;
use App\Notifications\AnnouncementPublishedNotification;
use App\Services\PhilSmsService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::query()
            ->with('creator')
            ->withCount([
                'recipients',
                'smsDeliveries',
            ])
            ->latest()
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $residents = Resident::query()
            ->where('status', 'Active')
            ->with('household')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('announcements.create', compact('residents'));
    }

    public function preview(Request $request): JsonResponse
    {
        $validated = $this->validateAnnouncement($request);

        $residents = $this->resolveTargetResidents($validated);

        return response()->json(
            $this->buildPreview($residents)
        );
    }

    public function store(Request $request)
    {
        $validated = $this->validateAnnouncement($request);

        $residents = $this->resolveTargetResidents($validated);

        if ($residents->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors([
                    'target_type' => 'No residents match the selected announcement target.',
                ]);
        }

        $announcement = DB::transaction(function () use ($validated, $residents) {
            $announcement = Announcement::create([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'target_type' => $validated['target_type'],
                'min_age' => $validated['min_age'] ?? null,
                'max_age' => $validated['max_age'] ?? null,
                'priority' => $validated['priority'],
                'status' => 'Published',
                'published_at' => now(),
                'created_by' => auth()->id(),
            ]);

            $this->createRecipients($announcement, $residents);
            $this->createSmsDeliveries($announcement, $residents);

            return $announcement;
        });

        /*
         * Notify system users after the announcement and its
         * recipient/SMS delivery records have been committed.
         *
         * This creates database notifications only.
         * It does not send SMS messages.
         */
        $users = User::query()
            ->whereIn('role', [
                'System Administrator',
                'Official',
                'Health Worker',
            ])
            ->get();

        foreach ($users as $user) {
            $user->notify(
                new AnnouncementPublishedNotification($announcement)
            );
        }

        return redirect()
            ->route('announcements.show', $announcement)
            ->with(
                'success',
                'Announcement published successfully. SMS delivery records were prepared; no SMS messages were sent.'
            );
    }

    /**
     * Send pending SMS messages for an announcement.
     *
     * Real SMS sending is disabled unless PHILSMS_SMS_ENABLED=true.
     */
    public function sendPendingSms(
        Request $request,
        Announcement $announcement,
        PhilSmsService $smsService
    ) {
        // Keep actual SMS sending disabled until explicitly enabled.
        if (! config('services.philsms.enabled', false)) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with(
                    'error',
                    'SMS sending is disabled. Enable PHILSMS_SMS_ENABLED only when you are ready to send real messages.'
                );
        }

        // Verify the required PhilSMS configuration.
        if (
            empty(config('services.philsms.api_token'))
            || empty(config('services.philsms.sender_id'))
        ) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with(
                    'error',
                    'PhilSMS API token or sender ID is not configured.'
                );
        }

        $deliveries = $announcement->smsDeliveries()
            ->where('status', 'Pending')
            ->orderBy('id')
            ->get();

        if ($deliveries->isEmpty()) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with(
                    'info',
                    'There are no pending SMS messages for this announcement.'
                );
        }

        $sentCount = 0;
        $failedCount = 0;
        $skippedCount = 0;

        foreach ($deliveries as $delivery) {
            $number = trim((string) $delivery->contact_number);

            // Do not call PhilSMS when the recipient number is missing.
            if ($number === '') {
                $delivery->update([
                    'status' => 'Failed',
                    'failure_reason' =>
                        'No contact number is recorded for this household head.',
                    'sent_at' => null,
                ]);

                $failedCount++;

                continue;
            }

            /*
             * Recheck the delivery status before sending.
             * This is a safeguard against processing an already-updated record.
             */
            $delivery->refresh();

            if ($delivery->status !== 'Pending') {
                $skippedCount++;

                continue;
            }

            $message = $this->buildSmsMessage($announcement);

            $result = $smsService->send($number, $message);

            if (($result['success'] ?? false) === true) {
                $delivery->update([
                    'status' => 'Sent',
                    'sent_at' => now(),
                    'failure_reason' => null,
                ]);

                $sentCount++;
            } else {
                $delivery->update([
                    'status' => 'Failed',
                    'sent_at' => null,
                    'failure_reason' => mb_substr(
                        (string) (
                            $result['message']
                            ?? 'PhilSMS did not accept the SMS request.'
                        ),
                        0,
                        5000
                    ),
                ]);

                $failedCount++;
            }
        }

        $summary = "SMS processing finished. Accepted: {$sentCount}; failed: {$failedCount}.";

        if ($skippedCount > 0) {
            $summary .= " Skipped: {$skippedCount}.";
        }

        return redirect()
            ->route('announcements.show', $announcement)
            ->with(
                $failedCount > 0 ? 'warning' : 'success',
                $summary
            );
    }

    public function show(Announcement $announcement)
    {
        $announcement->load([
            'creator',
            'recipients.resident.household',
            'smsDeliveries.household',
            'smsDeliveries.householdHead',
        ]);

        return view('announcements.show', compact('announcement'));
    }

    public function markAsRead(AnnouncementRecipient $recipient)
    {
        abort_unless(
            auth()->user()?->resident_id !== null
                && $recipient->resident_id === auth()->user()->resident_id,
            403
        );

        $recipient->update([
            'read_at' => now(),
        ]);

        return back();
    }

    private function buildSmsMessage(Announcement $announcement): string
    {
        $priority = strtoupper((string) $announcement->priority);
        $title = trim((string) $announcement->title);
        $body = trim((string) $announcement->message);

        return "BARANGAY ESPERANZA HEALTH CENTER\n"
            . "[{$priority}] {$title}\n"
            . $body;
    }

    private function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'target_type' => [
                'required',
                Rule::in([
                    'specific',
                    'senior',
                    'children',
                    'pregnant',
                    'general',
                    'age_bracket',
                ]),
            ],
            'resident_id' => ['nullable', 'integer', 'exists:residents,id'],
            'min_age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'max_age' => ['nullable', 'integer', 'min:0', 'max:120', 'gte:min_age'],
            'priority' => [
                'required',
                Rule::in(['Normal', 'Important', 'Urgent']),
            ],
        ]);
    }

    private function resolveTargetResidents(array $validated): Collection
    {
        $query = Resident::query()
            ->where('status', 'Active')
            ->with([
                'household',
                'seniorCitizen',
                'maternalCares',
                'childHealths',
            ]);

        return match ($validated['target_type']) {
            'specific' => $this->resolveSpecificResident($query, $validated),
            'senior' => $this->resolveSeniorResidents($query),
            'children' => $this->resolveChildren($query, $validated),
            'pregnant' => $this->resolvePregnantResidents($query),
            'general' => $query->get(),
            'age_bracket' => $this->resolveAgeBracket($query, $validated),
        };
    }

    private function resolveSpecificResident($query, array $validated): Collection
    {
        if (empty($validated['resident_id'])) {
            return collect();
        }

        return $query->whereKey($validated['resident_id'])->get();
    }

    private function resolveSeniorResidents($query): Collection
    {
        return $query->get()
            ->filter(function (Resident $resident) {
                return $this->calculateAge($resident) >= 60
                    || $resident->seniorCitizen?->senior_status === 'Active';
            })
            ->values();
    }

    private function resolveChildren($query, array $validated): Collection
    {
        $minAge = $validated['min_age'] ?? 0;
        $maxAge = $validated['max_age'] ?? 5;

        return $query->get()
            ->filter(function (Resident $resident) use ($minAge, $maxAge) {
                $age = $this->calculateAge($resident);

                return $age >= $minAge && $age <= $maxAge;
            })
            ->values();
    }

    private function resolvePregnantResidents($query): Collection
    {
        return $query->get()
            ->filter(function (Resident $resident) {
                return $resident->maternalCares->contains(
                    function ($maternalCare) {
                        return $maternalCare->pregnancy_status === 'Pregnant'
                            && is_null($maternalCare->actual_delivery_date);
                    }
                );
            })
            ->values();
    }

    private function resolveAgeBracket($query, array $validated): Collection
    {
        $minAge = $validated['min_age'];
        $maxAge = $validated['max_age'];

        return $query->get()
            ->filter(function (Resident $resident) use ($minAge, $maxAge) {
                $age = $this->calculateAge($resident);

                return $age >= $minAge && $age <= $maxAge;
            })
            ->values();
    }

    private function calculateAge(Resident $resident): int
    {
        if (!$resident->birth_date) {
            return 0;
        }

        return Carbon::parse($resident->birth_date)->age;
    }

    private function buildPreview(Collection $residents): array
    {
        $households = $residents
            ->filter(fn (Resident $resident) => $resident->household)
            ->groupBy('household_id');

        $householdPreview = $households->map(function (Collection $members) {
            $household = $members->first()->household;

            $householdHead = $members->firstWhere('is_household_head', true);

            if (!$householdHead) {
                $householdHead = $household->residents?->firstWhere('is_household_head', true);
            }

            return [
                'household_id' => $household->id,
                'household_code' => $household->household_code,
                'household_head' => $householdHead?->full_name,
                'contact_number' => $householdHead?->contact_number,
                'qualifying_members' => $members->map(
                    fn (Resident $resident) => [
                        'id' => $resident->id,
                        'name' => $resident->full_name,
                        'age' => $this->calculateAge($resident),
                    ]
                )->values()->all(),
            ];
        })->values();

        return [
            'qualifying_residents' => $residents->count(),
            'affected_households' => $households->count(),
            'sms_recipients' => $householdPreview->count(),
            'households' => $householdPreview->all(),
        ];
    }

    private function createRecipients(
        Announcement $announcement,
        Collection $residents
    ): void {
        $rows = $residents->unique('id')->map(fn (Resident $resident) => [
            'announcement_id' => $announcement->id,
            'resident_id' => $resident->id,
            'created_at' => now(),
            'updated_at' => now(),
        ])->values()->all();

        if (!empty($rows)) {
            AnnouncementRecipient::insert($rows);
        }
    }

    private function createSmsDeliveries(
        Announcement $announcement,
        Collection $residents
    ): void {
        $residents
            ->filter(fn (Resident $resident) => $resident->household)
            ->groupBy('household_id')
            ->each(function (Collection $members) use ($announcement) {
                $household = $members->first()->household;

                $householdHead = $household->residents
                    ->firstWhere('is_household_head', true);

                if (!$householdHead) {
                    return;
                }

                $contactNumber = trim((string) $householdHead->contact_number);

                AnnouncementSmsDelivery::firstOrCreate(
                    [
                        'announcement_id' => $announcement->id,
                        'household_id' => $household->id,
                    ],
                    [
                        'household_head_resident_id' => $householdHead->id,
                        'contact_number' => $contactNumber,
                        'status' => 'Pending',
                        'failure_reason' => $contactNumber === ''
                            ? 'Household head has no contact number.'
                            : null,
                    ]
                );
            });
    }
}