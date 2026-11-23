<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementRecipient;
use App\Models\AnnouncementSmsDelivery;
use App\Models\Resident;
use App\Models\User;
use App\Notifications\AnnouncementPublishedNotification;
use App\Services\AnnouncementRecipientService;
use App\Services\AnnouncementSmsStatusSyncService;
use App\Services\UniSmsService;
use App\Support\PhilippineMobileNumberFormatter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AnnouncementController extends Controller
{
    public function index(UniSmsService $smsService)
    {
        $announcements = Announcement::query()
            ->with('creator')
            ->withCount('recipients')
            ->latest()
            ->paginate(10);

        $smsBalance = $smsService->accountBalance();

        return view('announcements.index', compact(
            'announcements',
            'smsBalance'
        ));
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

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement deleted successfully.');
    }

    public function preview(
        Request $request,
        AnnouncementRecipientService $recipientService
    ): JsonResponse {
        $validated = $this->validatePreview($request);
        $resolved = $recipientService->resolve($validated);

        return response()->json(
            $recipientService->buildPreview($resolved)
        );
    }

    public function store(
        Request $request,
        AnnouncementRecipientService $recipientService
    ) {
        $validated = $this->validateAnnouncement($request);
        $resolved = $recipientService->resolve($validated);
        $residents = $resolved['qualifying_residents'];
        $smsRecipients = $resolved['sms_recipients'];

        if (isset($validated['preview_hash']) && ! hash_equals($recipientService->previewHash($resolved), $validated['preview_hash'])) {
            return back()->withInput()->withErrors([
                'target_type' => 'The recipient list changed. Please review the updated preview before publishing.',
            ]);
        }

        if ($residents->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors([
                    'target_type' => 'No residents match the selected announcement target.',
                ]);
        }

        $announcement = DB::transaction(function () use ($validated, $residents, $smsRecipients) {
            $announcement = Announcement::create([
                'title' => $validated['title'],
                'message' => $validated['message'],
                'target_type' => $validated['target_type'],
                'min_age' => match ($validated['target_type']) {
                    'children' => 0,
                    'age_bracket' => $validated['min_age'],
                    default => null,
                },
                'max_age' => match ($validated['target_type']) {
                    'children' => 5,
                    'age_bracket' => $validated['max_age'],
                    default => null,
                },
                'priority' => $validated['priority'],
                'status' => 'Published',
                'published_at' => now(),
                'created_by' => auth()->id(),
            ]);

            $this->createRecipients($announcement, $residents);
            $this->createSmsDeliveries($announcement, $smsRecipients);

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
            ->with('success', 'Announcement published successfully. No SMS messages were sent.');
    }

    /**
     * Send prepared SMS messages for an announcement.
     *
     * Real SMS sending is disabled unless UNISMS_SMS_ENABLED=true.
     */
    public function sendPendingSms(
        Request $request,
        Announcement $announcement,
        UniSmsService $smsService
    ) {
        // Keep actual SMS sending disabled until explicitly enabled.
        if (! config('services.unisms.enabled', false)) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with(
                    'error',
                    'SMS sending is disabled. Configure UniSMS and enable UNISMS_SMS_ENABLED only when you are ready to send real messages.'
                );
        }

        // Verify the required UniSMS configuration.
        if (
            empty(config('services.unisms.secret_key'))
            || empty(config('services.unisms.sender_id'))
        ) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with(
                    'error',
                    'UniSMS secret key or sender ID is not configured.'
                );
        }

        $deliveries = $announcement->smsDeliveries()
            ->where('status', 'Prepared')
            ->whereNull('attempt_started_at')
            ->orderBy('id')
            ->get();

        if ($deliveries->isEmpty()) {
            return redirect()
                ->route('announcements.show', $announcement)
                ->with(
                    'info',
                    'There are no prepared SMS messages for this announcement.'
                );
        }

        $sentCount = 0;
        $failedCount = 0;
        $unknownCount = 0;
        $skippedCount = 0;

        foreach ($deliveries as $delivery) {
            $number = PhilippineMobileNumberFormatter::normalize(
                trim((string) $delivery->contact_number)
            );
            $claimed = DB::transaction(function () use ($announcement, $delivery, $number): bool {
                Announcement::query()->whereKey($announcement->id)->lockForUpdate()->firstOrFail();

                $alreadyAttempted = $announcement->smsDeliveries()
                    ->where('id', '!=', $delivery->id)
                    ->where('status', '!=', 'Prepared')
                    ->get(['contact_number'])
                    ->contains(fn (AnnouncementSmsDelivery $other): bool => PhilippineMobileNumberFormatter::normalize(
                        trim((string) $other->contact_number)
                    ) === $number);

                if ($alreadyAttempted) {
                    $announcement->smsDeliveries()
                        ->whereKey($delivery->id)
                        ->where('status', 'Prepared')
                        ->whereNull('attempt_started_at')
                        ->update([
                            'status' => 'Failed',
                            'failure_reason' => 'A delivery for this number has already been processed for this announcement.',
                        ]);

                    return false;
                }

                return $announcement->smsDeliveries()
                    ->whereKey($delivery->id)
                    ->where('status', 'Prepared')
                    ->whereNull('attempt_started_at')
                    ->update([
                        'status' => 'Unknown',
                        'attempt_started_at' => now(),
                        'failure_reason' => 'Submission started; provider acceptance is not yet confirmed.',
                    ]) === 1;
            });

            if (! $claimed) {
                $skippedCount++;

                continue;
            }

            if (! PhilippineMobileNumberFormatter::isValid($number)) {
                $failureReason = trim((string) $delivery->contact_number) === ''
                    ? 'No valid recipient contact number is recorded.'
                    : 'The recipient contact number is not a valid Philippine mobile number.';

                $delivery->update([
                    'status' => 'Failed',
                    'failure_reason' => $failureReason,
                    'sent_at' => null,
                ]);

                $failedCount++;

                continue;
            }

            $message = $this->buildSmsMessage($announcement);

            $result = $smsService->send(
                $number,
                $message,
                $delivery->id
            );

            if (($result['success'] ?? false) === true) {
                $delivery->update([
                    'status' => 'Pending',
                    'sent_at' => now(),
                    'failure_reason' => null,
                    'provider_reference' => $result['message_id'],
                    'provider_status' => $result['provider_status'],
                    'provider_http_status' => $result['http_status'],
                ]);

                $sentCount++;
            } else {
                $delivery->update([
                    'status' => ($result['outcome_uncertain'] ?? false) ? 'Unknown' : 'Failed',
                    'sent_at' => null,
                    'provider_reference' => $result['message_id'] ?? null,
                    'provider_status' => $result['provider_status'] ?? null,
                    'provider_http_status' => $result['http_status'] ?? null,
                    'failure_reason' => mb_substr(
                        (string) (
                            $result['message']
                            ?? 'UniSMS did not accept the SMS request.'
                        ),
                        0,
                        5000
                    ),
                ]);

                if ($result['outcome_uncertain'] ?? false) {
                    $unknownCount++;
                } else {
                    $failedCount++;
                }
            }
        }

        $summary = "SMS processing finished. Accepted: {$sentCount}; failed: {$failedCount}.";

        if ($unknownCount > 0) {
            $summary .= " Unknown: {$unknownCount}.";
        }

        if ($skippedCount > 0) {
            $summary .= " Skipped: {$skippedCount}.";
        }

        return redirect()
            ->route('announcements.show', $announcement)
            ->with(
                $failedCount > 0 || $unknownCount > 0 ? 'warning' : 'success',
                $summary
            );
    }

    public function refreshSmsStatus(Announcement $announcement, AnnouncementSmsStatusSyncService $sync)
    {
        $result = $sync->synchronize($announcement);

        if ($result['locked']) {
            return back()->with('warning', 'A UniSMS status check is already in progress for this announcement.');
        }

        $updated = $result['updated'];
        $failed = $result['unavailable'];
        $missingReferences = $result['missing'];
        $invalidReferences = $result['invalid'];

        $summary = "UniSMS status checks: {$updated} updated; {$result['skipped']} skipped; {$result['not_due']} not yet due; {$failed} unavailable; {$missingReferences} missing references; {$invalidReferences} invalid references.";
        if ($updated === 0 && $failed === 0 && $missingReferences === 0 && $invalidReferences === 0 && $result['skipped'] === 0 && ! $result['deferred']) {
            return back()->with('info', $summary.' No SMS messages are available for a manual status check.');
        }
        if ($result['errors'] !== []) {
            $summary .= ' '.implode(' ', array_unique($result['errors']));
        }
        if ($result['deferred']) {
            $summary .= ' Remaining checks were deferred.';
        }

        return back()->with($failed > 0 || $missingReferences > 0 || $invalidReferences > 0 || $result['deferred'] ? 'warning' : 'success', $summary);
    }

    public function prepareSmsRetry(Announcement $announcement, int $deliveryId)
    {
        $prepared = DB::transaction(function () use ($announcement, $deliveryId): bool {
            $announcement = Announcement::query()->whereKey($announcement->id)->lockForUpdate()->firstOrFail();
            $delivery = $announcement->smsDeliveries()->whereKey($deliveryId)->lockForUpdate()->firstOrFail();

            if (! $delivery->canPrepareRetry()) {
                return false;
            }

            DB::table('announcement_sms_retry_history')->insert([
                'announcement_sms_delivery_id' => $delivery->id,
                'requested_by' => auth()->id(),
                'provider_reference' => $delivery->provider_reference,
                'provider_status' => $delivery->provider_status,
                'provider_http_status' => $delivery->provider_http_status,
                'attempt_started_at' => $delivery->attempt_started_at,
                'sent_at' => $delivery->sent_at,
                'failure_reason' => $delivery->failure_reason,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $delivery->update([
                'status' => 'Prepared',
                'failure_reason' => null,
                'attempt_started_at' => null,
                'sent_at' => null,
                'provider_reference' => null,
                'provider_status' => null,
                'provider_http_status' => null,
                'status_checked_at' => null,
                'status_check_attempted_at' => null,
                'status_check_result' => null,
                'status_lookup_http_status' => null,
            ]);

            return true;
        });

        if (! $prepared) {
            return back()->with('warning', 'This SMS is not eligible for a safe retry. Pending and uncertain submissions must not be resent.');
        }

        return back()->with('success', 'The rejected SMS is prepared for retry. No SMS was sent; use the send button to confirm submission.');
    }

    public function smsWebhook(Request $request, UniSmsService $smsService): JsonResponse
    {
        $secret = config('services.unisms.webhook_secret');
        $providedSecret = $request->header('webhook-secret-key');

        if (! is_string($secret) || trim($secret) === '') {
            return response()->json(['error' => 'Webhook is not configured.'], 503);
        }

        if (! is_string($providedSecret) || ! hash_equals($secret, $providedSecret)) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        $payload = $request->validate([
            'id' => ['required', 'string', 'max:128'],
            'event' => ['required', Rule::in(['message.sent', 'message.failed', 'message.retrying'])],
            'message' => ['required', 'array'],
            'message.reference_id' => ['required', 'string', 'max:128'],
            'message.status' => ['required', 'string'],
            'message.fail_reason' => ['nullable', 'string'],
            'message.recipient' => ['nullable', 'string'],
            'message.content' => ['nullable', 'string'],
        ]);
        $message = $payload['message'];
        $expectedStatus = match ($payload['event']) {
            'message.sent' => 'sent',
            'message.failed' => 'failed',
            'message.retrying' => 'retrying',
        };

        if ($payload['id'] !== $message['reference_id'] || $message['status'] !== $expectedStatus
            || ! $smsService->isValidReference($message['reference_id'])) {
            return response()->json(['error' => 'Inconsistent message status.'], 422);
        }

        return DB::transaction(function () use ($smsService, $message, $expectedStatus): JsonResponse {
            $delivery = AnnouncementSmsDelivery::query()
                ->where('provider_reference', $message['reference_id'])
                ->lockForUpdate()
                ->first();

            if (! $delivery) {
                return response()->json(['error' => 'Message reference not found.'], 404);
            }

            if (($expectedStatus === 'sent' && $delivery->status === 'Unknown' && $delivery->provider_status === 'sent')
                || ($expectedStatus === 'retrying' && $delivery->status === 'Pending' && $delivery->provider_status === 'retrying')) {
                return response()->json(['status' => 'processed']);
            }

            $result = $smsService->updateDeliveryStatus($delivery, $message);

            if ($result === null) {
                return response()->json(['error' => 'Invalid message status.'], 422);
            }

            if ($result === false
                && ! in_array($delivery->status, ['Failed', 'Delivered'], true)
                && ! ($expectedStatus === 'retrying' && in_array($delivery->provider_status, ['sent', 'failed'], true))) {
                return response()->json(['error' => 'Message status could not be updated.'], 503);
            }

            return response()->json(['status' => 'processed']);
        });
    }

    public function show(Announcement $announcement, AnnouncementSmsStatusSyncService $sync, UniSmsService $smsService)
    {
        $announcement->load([
            'creator',
            'recipients.resident.household',
            'smsDeliveries.household',
            'smsDeliveries.householdHead',
            'smsDeliveries.resident',
        ]);

        $directoryAnnouncements = Announcement::query()
            ->withCount('recipients')
            ->latest()
            ->paginate(8, ['*'], 'directory_page')
            ->withQueryString();

        $lastSuccessfulSmsChecks = DB::table('announcement_sms_status_checks')
            ->whereIn('announcement_sms_delivery_id', $announcement->smsDeliveries->modelKeys())
            ->where('result', 'success')
            ->selectRaw('announcement_sms_delivery_id, MAX(checked_at) as checked_at')
            ->groupBy('announcement_sms_delivery_id')
            ->pluck('checked_at', 'announcement_sms_delivery_id')
            ->map(fn (string $checkedAt): Carbon => Carbon::parse($checkedAt));
        $latestSmsReasons = DB::table('announcement_sms_status_checks')
            ->whereIn('id', DB::table('announcement_sms_status_checks')
                ->whereIn('announcement_sms_delivery_id', $announcement->smsDeliveries->modelKeys())
                ->whereNotNull('provider_reason')
                ->selectRaw('MAX(id)')
                ->groupBy('announcement_sms_delivery_id'))
            ->get()
            ->keyBy('announcement_sms_delivery_id');
        $smsSyncOverview = $sync->overview($announcement);

        // Read the existing UniSMS configuration without enabling SMS.
        $smsEnabled = (bool) config('services.unisms.enabled', false);
        $smsConfigured = filled(config('services.unisms.secret_key'))
            && filled(config('services.unisms.sender_id'));
        $smsStatusConfigured = filled(config('services.unisms.secret_key'));

        return view('announcements.show', compact(
            'announcement',
            'smsEnabled',
            'smsConfigured',
            'smsStatusConfigured',
            'directoryAnnouncements',
            'lastSuccessfulSmsChecks',
            'latestSmsReasons',
            'smsSyncOverview',
            'smsService'
        ));
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
            ."[{$priority}] {$title}\n"
            .$body;
    }

    private function validatePreview(Request $request): array
    {
        $validated = $request->validate([
            'target_type' => [
                'required',
                Rule::in([
                    'specific',
                    'senior',
                    'children',
                    'pregnant',
                    'postnatal',
                    'general',
                    'age_bracket',
                ]),
            ],
            'resident_id' => [
                'nullable',
                'integer',
                Rule::exists('residents', 'id')->where('status', 'Active'),
            ],
            'resident_ids' => ['nullable', 'array'],
            'resident_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('residents', 'id')->where('status', 'Active'),
            ],
            'min_age' => [
                'required_if:target_type,age_bracket',
                'nullable',
                'integer',
                'min:0',
                'max:255',
            ],
            'max_age' => [
                'required_if:target_type,age_bracket',
                'nullable',
                'integer',
                'min:0',
                'max:255',
                'gte:min_age',
            ],
        ]);

        if (
            $validated['target_type'] === 'specific'
            && empty($validated['resident_ids'])
            && empty($validated['resident_id'])
        ) {
            throw ValidationException::withMessages([
                'resident_ids' => 'Select at least one active resident.',
            ]);
        }

        return $validated;
    }

    private function validateAnnouncement(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'target_type' => [
                'required',
                Rule::in([
                    'specific',
                    'senior',
                    'children',
                    'pregnant',
                    'postnatal',
                    'general',
                    'age_bracket',
                ]),
            ],
            'resident_id' => [
                'nullable',
                'integer',
                Rule::exists('residents', 'id')->where('status', 'Active'),
            ],
            'resident_ids' => [
                'nullable',
                'array',
            ],
            'resident_ids.*' => [
                'required',
                'integer',
                'distinct',
                Rule::exists('residents', 'id')->where('status', 'Active'),
            ],
            'min_age' => [
                'required_if:target_type,age_bracket',
                'nullable',
                'integer',
                'min:0',
                'max:255',
            ],
            'max_age' => [
                'required_if:target_type,age_bracket',
                'nullable',
                'integer',
                'min:0',
                'max:255',
                'gte:min_age',
            ],
            'priority' => [
                'required',
                Rule::in(['Normal', 'Important', 'Urgent']),
            ],
            'preview_hash' => ['nullable', 'string', 'size:64'],
        ]);

        if (
            $validated['target_type'] === 'specific'
            && empty($validated['resident_ids'])
            && empty($validated['resident_id'])
        ) {
            throw ValidationException::withMessages([
                'resident_ids' => 'Select at least one active resident.',
            ]);
        }

        return $validated;
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

        if (! empty($rows)) {
            AnnouncementRecipient::insert($rows);
        }
    }

    private function createSmsDeliveries(
        Announcement $announcement,
        Collection $smsRecipients
    ): void {
        foreach ($smsRecipients as $recipient) {
            AnnouncementSmsDelivery::create([
                'announcement_id' => $announcement->id,
                'household_id' => $recipient['household_id'],
                'household_head_resident_id' => $recipient['household_head_resident_id'],
                'resident_id' => $recipient['resident_id'],
                'recipient_type' => $recipient['recipient_type'],
                'contact_number' => $recipient['contact_number'],
                'status' => 'Prepared',
            ]);
        }
    }
}
