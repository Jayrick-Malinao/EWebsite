<?php

namespace App\Console\Commands;

use App\Services\EventReminderService;
use Illuminate\Console\Command;

class CheckEventReminders extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'schedule:check-reminders';

    /**
     * The console command description.
     */
    protected $description = 'Check scheduled events and create reminder notifications';

    /**
     * Execute the console command.
     */
    public function handle(
        EventReminderService $reminderService
    ): int {
        $this->info('Checking scheduled events for reminders...');

        $notificationsSent = $reminderService->check();

        if ($notificationsSent === 0) {
            $this->info('No new schedule notifications were generated.');

            return self::SUCCESS;
        }

        $this->info(
            "{$notificationsSent} schedule notification(s) generated successfully."
        );

        return self::SUCCESS;
    }
}
