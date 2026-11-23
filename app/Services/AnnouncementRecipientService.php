<?php

namespace App\Services;

use App\Models\Resident;
use App\Support\PhilippineMobileNumberFormatter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AnnouncementRecipientService
{
    /**
     * @param  array<string, mixed>  $validated
     * @return array{qualifying_residents: Collection, sms_recipients: Collection}
     */
    public function resolve(array $validated): array
    {
        $targetType = $validated['target_type'];

        $qualifyingResidents = match ($targetType) {
            'specific' => $this->resolveSpecific($validated),
            'senior' => $this->resolveSenior(),
            'children' => $this->resolveChildren(),
            'pregnant' => $this->resolvePregnant(),
            'postnatal' => $this->resolvePostnatal(),
            'general' => $this->resolveGeneral(),
            'age_bracket' => $this->resolveAgeBracket(
                (int) $validated['min_age'],
                (int) $validated['max_age']
            ),
        };
        $qualifyingResidents = $qualifyingResidents->unique('id')->values();

        $smsRecipients = match ($targetType) {
            'specific', 'pregnant', 'postnatal' => $this->resolveDirectResidents($qualifyingResidents),
            default => $this->resolveHouseholdHeads($qualifyingResidents),
        };

        return [
            'qualifying_residents' => $qualifyingResidents,
            'sms_recipients' => $smsRecipients,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function buildPreview(array $resolved): array
    {
        /** @var Collection<int, Resident> $residents */
        $residents = $resolved['qualifying_residents'];
        /** @var Collection<int, array<string, mixed>> $smsRecipients */
        $smsRecipients = $resolved['sms_recipients'];
        $message = 'SMS messages are prepared when the announcement is published and sent only after confirmation.';

        if ($smsRecipients->isEmpty()) {
            $message = 'No eligible recipients with valid Philippine mobile numbers were found.';
        }

        $households = $residents
            ->filter(fn (Resident $resident): bool => (bool) $resident->household)
            ->groupBy('household_id')
            ->map(function (Collection $members): array {
                $household = $members->first()->household;

                return [
                    'household_id' => $household->id,
                    'household_code' => $household->household_code,
                    'qualifying_members' => $members->map(fn (Resident $resident): array => [
                        'id' => $resident->id,
                        'name' => $resident->full_name,
                        'age' => $this->residentAge($resident),
                    ])->values()->all(),
                ];
            })
            ->values();

        return [
            'qualifying_residents' => $residents->count(),
            'sms_recipients' => $smsRecipients->count(),
            'affected_households' => $households->count(),
            'message' => $message,
            'preview_hash' => $this->previewHash($resolved),
            'households' => $households->all(),
            'residents' => $residents->map(fn (Resident $resident): array => [
                'id' => $resident->id,
                'name' => $resident->full_name,
            ])->values()->all(),
            'recipients' => $smsRecipients
                ->map(fn (array $recipient): array => [
                    'resident_id' => $recipient['resident_id'] ?? null,
                    'household_id' => $recipient['household_id'] ?? null,
                    'household_head_resident_id' => $recipient['household_head_resident_id'] ?? null,
                    'name' => $recipient['name'],
                    'contact_number' => $recipient['contact_number'],
                    'recipient_type' => $recipient['recipient_type'],
                ])
                ->values()
                ->all(),
        ];
    }

    public function previewHash(array $resolved): string
    {
        $residentIds = $resolved['qualifying_residents']->pluck('id')->sort()->values()->all();
        $recipients = $resolved['sms_recipients']->map(fn (array $recipient): array => [
            $recipient['resident_id'],
            $recipient['household_id'],
            $recipient['household_head_resident_id'],
            $recipient['contact_number'],
        ])->sort()->values()->all();

        return hash('sha256', json_encode([$residentIds, $recipients], JSON_THROW_ON_ERROR));
    }

    private function resolveSpecific(array $validated): Collection
    {
        $residentIds = collect($validated['resident_ids'] ?? [])
            ->push($validated['resident_id'] ?? null)
            ->filter(fn ($id) => is_numeric($id))
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values();

        if ($residentIds->isEmpty()) {
            return collect();
        }

        return $this->activeResidentQuery()
            ->whereKey($residentIds)
            ->get();
    }

    private function resolveSenior(): Collection
    {
        return $this->activeResidentQuery()
            ->whereHas('seniorCitizen', function (Builder $query) {
                $query->where('senior_status', 'Active');
            })
            ->get();
    }

    private function resolveChildren(): Collection
    {
        return $this->activeResidentQuery()
            ->get()
            ->filter(fn (Resident $resident): bool => $this->ageInRange($resident, 0, 5))
            ->values();
    }

    private function resolvePregnant(): Collection
    {
        return $this->activeResidentQuery()
            ->whereHas('healthVisits', fn (Builder $query) => $query->where('visit_type', 'Prenatal'))
            ->get();
    }

    private function resolvePostnatal(): Collection
    {
        return $this->activeResidentQuery()
            ->whereHas('healthVisits', fn (Builder $query) => $query->where('visit_type', 'Postnatal'))
            ->get();
    }

    private function resolveGeneral(): Collection
    {
        return $this->activeResidentQuery()
            ->get();
    }

    private function resolveAgeBracket(int $minimumAge, int $maximumAge): Collection
    {
        return $this->activeResidentQuery()
            ->get()
            ->filter(
                fn (Resident $resident): bool => $this->ageInRange(
                    $resident,
                    $minimumAge,
                    $maximumAge
                )
            )
            ->values();
    }

    private function activeResidentQuery(): Builder
    {
        return Resident::query()
            ->where('status', 'Active')
            ->with('household.residents')
            ->orderBy('id');
    }

    private function ageInRange(Resident $resident, int $minimumAge, int $maximumAge): bool
    {
        $age = $this->residentAge($resident);

        return $age !== null && $age >= $minimumAge && $age <= $maximumAge;
    }

    private function residentAge(Resident $resident): ?int
    {
        $date = $resident->getRawOriginal('birth_date');

        if (! is_string($date) || preg_match('/\A(\d{4})-(\d{2})-(\d{2})(?: 00:00:00)?\z/', $date, $parts) !== 1
            || ! checkdate((int) $parts[2], (int) $parts[3], (int) $parts[1])) {
            return null;
        }

        $birthDate = Carbon::createFromFormat('!Y-m-d', substr($date, 0, 10));

        return $birthDate->isFuture() ? null : $birthDate->age;
    }

    /**
     * @param  Collection<int, Resident>  $residents
     * @return Collection<int, array<string, mixed>>
     */
    private function resolveDirectResidents(Collection $residents): Collection
    {
        $seenPhones = [];

        return $residents
            ->map(function (Resident $resident) use (&$seenPhones): ?array {
                $contact = $resident->household_id
                    ? $resident->household?->residents->first(fn (Resident $member): bool => $member->is_household_head && $member->status === 'Active')?->contact_number
                    : $resident->contact_number;
                $normalized = PhilippineMobileNumberFormatter::normalize(trim((string) $contact));

                if (! PhilippineMobileNumberFormatter::isValid($normalized)) {
                    return null;
                }

                if (isset($seenPhones[$normalized])) {
                    return null;
                }

                $seenPhones[$normalized] = true;

                return [
                    'resident_id' => $resident->id,
                    'household_id' => null,
                    'household_head_resident_id' => null,
                    'name' => $resident->full_name,
                    'contact_number' => $normalized,
                    'recipient_type' => 'resident',
                ];
            })
            ->filter()
            ->values();
    }

    /**
     * @param  Collection<int, Resident>  $residents
     * @return Collection<int, array<string, mixed>>
     */
    private function resolveHouseholdHeads(Collection $residents): Collection
    {
        $seenPhones = [];

        $householdRecipients = $residents
            ->filter(fn (Resident $resident): bool => (bool) $resident->household)
            ->groupBy('household_id')
            ->map(function (Collection $members) use (&$seenPhones): ?array {
                $household = $members->first()->household;

                $householdHead = $household->residents
                    ->first(
                        fn (Resident $resident): bool => $resident->is_household_head
                            && $resident->status === 'Active'
                    );

                if (! $householdHead) {
                    return null;
                }

                $normalized = PhilippineMobileNumberFormatter::normalize(
                    trim((string) $householdHead->contact_number)
                );

                if (! PhilippineMobileNumberFormatter::isValid($normalized)) {
                    return null;
                }

                if (isset($seenPhones[$normalized])) {
                    return null;
                }

                $seenPhones[$normalized] = true;

                return [
                    'resident_id' => null,
                    'household_id' => $household->id,
                    'household_head_resident_id' => $householdHead->id,
                    'name' => $householdHead->full_name,
                    'contact_number' => $normalized,
                    'recipient_type' => 'household_head',
                ];
            })
            ->filter()
            ->values();

        $independentRecipients = $this->resolveDirectResidents($residents->whereNull('household_id'))
            ->filter(function (array $recipient) use (&$seenPhones): bool {
                if (isset($seenPhones[$recipient['contact_number']])) {
                    return false;
                }

                $seenPhones[$recipient['contact_number']] = true;

                return true;
            });

        return $householdRecipients->concat($independentRecipients)->values();
    }
}
