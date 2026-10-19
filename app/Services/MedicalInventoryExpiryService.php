<?php

namespace App\Services;

use App\Models\MedicalInventory;
use App\Models\User;
use App\Notifications\MedicalInventoryExpiryNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MedicalInventoryExpiryService
{
    /**
     * Check medical inventory records and send expiry alerts
     * to active System Administrators and Health Workers.
     */
    public function check(): int
    {
        $today = Carbon::today('Asia/Manila');

        $recipients = User::query()
            ->whereIn('role', [
                'System Administrator',
                'Health Worker',
            ])
            ->where('status', 'active')
            ->get();

        if ($recipients->isEmpty()) {
            return 0;
        }

        $medicalInventories = MedicalInventory::query()
            ->whereNotNull('expiry_date')
            ->get();

        $notificationsSent = 0;

        foreach ($medicalInventories as $inventory) {
            $expiryDate = Carbon::parse(
                $inventory->expiry_date->toDateString(),
                'Asia/Manila'
            )->startOfDay();

            $daysUntilExpiry = (int) $today->diffInDays(
                $expiryDate,
                false
            );

            $alertType = null;
            $alertFlag = null;

            if ($daysUntilExpiry < 0 || $daysUntilExpiry === 0) {
                $alertType = $daysUntilExpiry < 0
                    ? 'expired'
                    : 'expiry';

                $alertFlag = 'alert_expiry_sent';
            } elseif ($daysUntilExpiry <= 7) {
                $alertType = '7_days';
                $alertFlag = 'alert_7_days_sent';
            } elseif ($daysUntilExpiry <= 15) {
                $alertType = '15_days';
                $alertFlag = 'alert_15_days_sent';
            } elseif ($daysUntilExpiry <= 30) {
                $alertType = '1_month';
                $alertFlag = 'alert_1_month_sent';
            }

            if ($alertType === null || $alertFlag === null) {
                continue;
            }

            /*
             * Send only to recipients who have not already received
             * this alert for this inventory item.
             */
            foreach ($recipients as $recipient) {
                $alreadyNotified = DB::table('notifications')
                    ->where('notifiable_type', $recipient->getMorphClass())
                    ->where('notifiable_id', $recipient->getKey())
                    ->where('data->type', 'medical_inventory_expiry')
                    ->where('data->medicine_name', $inventory->medicine_name)
                    ->where('data->alert_type', $alertType)
                    ->where('data->expiry_date', $expiryDate->format('F j, Y'))
                    ->exists();

                if ($alreadyNotified) {
                    continue;
                }

                $recipient->notify(
                    new MedicalInventoryExpiryNotification(
                        $inventory,
                        $alertType
                    )
                );

                $notificationsSent++;
            }

            /*
             * Preserve the existing flag to prevent the original
             * alert from being repeatedly processed.
             */
            if (! $inventory->{$alertFlag}) {
                $inventory->update([
                    $alertFlag => true,
                ]);
            }
        }

        return $notificationsSent;
    }
}
