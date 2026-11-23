<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Services\AnnouncementSmsStatusSyncService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncAnnouncementSmsStatuses extends Command
{
    protected $signature = 'announcements:sync-sms-status';

    protected $description = 'Check existing pending and unknown announcement SMS statuses without sending messages';

    public function handle(AnnouncementSmsStatusSyncService $sync): int
    {
        $overview = $sync->overview();
        $updated = 0;
        $unavailable = 0;
        $locked = 0;
        $remaining = 25;
        $deferred = false;

        foreach ($overview['announcement_ids'] as $id) {
            $announcement = Announcement::find($id);
            if (! $announcement) {
                continue;
            }

            $result = $sync->synchronize($announcement, true, $remaining);
            $updated += $result['updated'];
            $unavailable += $result['unavailable'];
            $locked += (int) $result['locked'];
            $remaining -= $result['attempted'];
            $deferred = $result['deferred'];

            if ($result['deferred'] || $remaining <= 0) {
                break;
            }
        }

        $skipped = max(0, $overview['due'] - $updated - $unavailable);
        $nextDue = $sync->overview()['next_due']?->format('Y-m-d H:i:s T');
        Log::info('Announcement SMS status synchronization completed.', [
            'updated' => $updated,
            'skipped' => $skipped,
            'not_due' => $overview['not_due'],
            'unavailable' => $unavailable,
            'missing_reference' => $overview['missing'],
            'invalid_reference' => $overview['invalid'],
            'locked' => $locked,
            'next_due' => $nextDue,
        ]);
        $this->info("UniSMS status checks: {$updated} updated; {$skipped} skipped; {$overview['not_due']} not yet due; {$unavailable} unavailable; {$overview['missing']} missing references; {$overview['invalid']} invalid references; {$locked} locked.");
        if ($nextDue !== null) {
            $this->line("Next eligibility for not-yet-due records: {$nextDue}.");
        }

        return $unavailable > 0 || $deferred ? self::FAILURE : self::SUCCESS;
    }
}
