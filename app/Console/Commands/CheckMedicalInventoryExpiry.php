<?php

namespace App\Console\Commands;

use App\Services\MedicalInventoryExpiryService;
use Illuminate\Console\Command;

class CheckMedicalInventoryExpiry extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'medical-inventory:check-expiry';

    /**
     * The console command description.
     */
    protected $description = 'Check medical inventory expiry dates and create notifications';

    /**
     * Execute the console command.
     */
    public function handle(
        MedicalInventoryExpiryService $expiryService
    ): int {
        $this->info('Checking medical inventory expiry dates...');

        $notificationsSent = $expiryService->check();

        if ($notificationsSent === 0) {
            $this->info('No new expiry notifications were generated.');

            return self::SUCCESS;
        }

        $this->info(
            "{$notificationsSent} expiry notification(s) generated successfully."
        );

        return self::SUCCESS;
    }
}