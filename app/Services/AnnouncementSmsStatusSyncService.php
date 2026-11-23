<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\AnnouncementSmsDelivery;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class AnnouncementSmsStatusSyncService
{
    public function __construct(private UniSmsService $smsService) {}

    private function candidates(?Announcement $announcement = null): Builder
    {
        return AnnouncementSmsDelivery::query()
            ->whereIn('status', ['Pending', 'Unknown'])
            ->when($announcement, fn (Builder $query) => $query->where('announcement_id', $announcement->id))
            ->orderBy('status_check_attempted_at')
            ->orderBy('id');
    }

    public function nextEligibleCheckAt(AnnouncementSmsDelivery $delivery): ?CarbonInterface
    {
        if ($delivery->status_check_attempted_at === null) {
            return null;
        }

        $fiveMinutes = $delivery->status_check_attempted_at->copy()->addMinutes(5);
        $dayOld = $delivery->created_at?->copy()->addDay();

        if ($dayOld !== null && now()->lte($dayOld) && $fiveMinutes->lte($dayOld)) {
            return $fiveMinutes;
        }

        return $delivery->status_check_attempted_at->copy()->addHour();
    }

    /**
     * @return array{due: int, not_due: int, missing: int, invalid: int, next_due: CarbonInterface|null, announcement_ids: array<int>}
     */
    public function overview(?Announcement $announcement = null): array
    {
        $summary = ['due' => 0, 'not_due' => 0, 'missing' => 0, 'invalid' => 0, 'next_due' => null, 'announcement_ids' => []];

        foreach ($this->candidates($announcement)
            ->select(['id', 'announcement_id', 'status', 'provider_reference', 'status_check_attempted_at', 'created_at'])
            ->cursor() as $delivery) {
            if ($delivery->provider_reference === null || $delivery->provider_reference === '') {
                $summary['missing']++;

                continue;
            }
            if (! $this->smsService->isValidReference($delivery->provider_reference)) {
                $summary['invalid']++;

                continue;
            }

            $next = $this->nextEligibleCheckAt($delivery);
            if ($next !== null && $next->isFuture()) {
                $summary['not_due']++;
                if ($summary['next_due'] === null || $next->lt($summary['next_due'])) {
                    $summary['next_due'] = $next;
                }

                continue;
            }

            $summary['due']++;
            $summary['announcement_ids'][$delivery->announcement_id] = $delivery->announcement_id;
        }

        $summary['announcement_ids'] = array_values($summary['announcement_ids']);

        return $summary;
    }

    /**
     * @return array{updated: int, skipped: int, unavailable: int, attempted: int, not_due: int, missing: int, invalid: int, next_due: CarbonInterface|null, errors: array<int, string>, locked: bool, deferred: bool}
     */
    public function synchronize(Announcement $announcement, bool $automatic = false, ?int $limit = null): array
    {
        $count = $limit ?? $announcement->smsDeliveries()->count();
        $lock = Cache::lock('announcement-sms-status-'.$announcement->id, 60 + (25 * $count));
        $summary = ['updated' => 0, 'skipped' => 0, 'unavailable' => 0, 'attempted' => 0, 'not_due' => 0, 'missing' => 0, 'invalid' => 0, 'next_due' => null, 'errors' => [], 'locked' => false, 'deferred' => false];

        if (! $lock->get()) {
            $summary['locked'] = true;

            return $summary;
        }

        try {
            $overview = $this->overview($announcement);
            $summary['missing'] = $overview['missing'];
            $summary['invalid'] = $overview['invalid'];
            $summary['not_due'] = $automatic ? $overview['not_due'] : 0;
            $summary['next_due'] = $automatic ? $overview['next_due'] : null;

            if (Cache::has('unisms-status-check-cooldown')) {
                $summary['skipped'] = $automatic ? $overview['due'] : $overview['due'] + $overview['not_due'];
                $summary['errors'][] = 'UniSMS status checks are temporarily paused after a provider or connection error.';
                $summary['deferred'] = true;

                return $summary;
            }

            $attempted = 0;
            foreach ($this->candidates($announcement)->get() as $delivery) {
                if (! $this->smsService->isValidReference($delivery->provider_reference)) {
                    continue;
                }
                $next = $this->nextEligibleCheckAt($delivery);
                if ($automatic && $next !== null && $next->isFuture()) {
                    continue;
                }
                if (! $automatic && $delivery->provider_status === 'sent') {
                    $summary['skipped']++;

                    continue;
                }
                if ($limit !== null && $attempted >= $limit) {
                    $summary['skipped']++;

                    continue;
                }

                $attempted++;
                $summary['attempted']++;
                $result = $this->smsService->refreshDeliveryStatus($delivery);
                if ($result['updated']) {
                    $summary['updated']++;
                } elseif ($result['success']) {
                    $summary['skipped']++;
                } else {
                    $summary['unavailable']++;
                    $summary['errors'][] = $result['message'];
                }

                if ($result['retry_later']) {
                    Cache::put('unisms-status-check-cooldown', true, now()->addMinutes(5));
                    $summary['deferred'] = true;
                    break;
                }
            }

            if ($summary['deferred']) {
                $eligible = $automatic ? $overview['due'] : $overview['due'] + $overview['not_due'];
                $summary['skipped'] = max($summary['skipped'], $eligible - $summary['updated'] - $summary['unavailable']);
            }

            return $summary;
        } finally {
            $lock->release();
        }
    }
}
