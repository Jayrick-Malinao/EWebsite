<?php

namespace App\Services;

use App\Models\MedicalInventory;
use App\Models\User;
use App\Notifications\MedicalInventoryLowStockNotification;
use Illuminate\Support\Facades\DB;

class MedicalInventoryLowStockService
{
    /**
     * Notify System Administrators and Health Workers when
     * inventory reaches 10 units or fewer.
     *
     * Returns the number of inventory alerts processed.
     */
    public function check(): int
    {
        $administrators = User::query()
            ->whereIn('role', [
                'System Administrator',
                'Health Worker',
            ])
            ->where('status', 'active')
            ->get();

        if ($administrators->isEmpty()) {
            return 0;
        }

        $inventories = MedicalInventory::query()->get();

        $alertsProcessed = 0;

        foreach ($inventories as $inventory) {
            $quantity = (int) $inventory->quantity;

            /*
             * If stock has recovered above the threshold,
             * allow a future low-stock alert.
             */
            if ($quantity > 10) {
                if ($inventory->alert_low_stock_sent) {
                    $inventory->update([
                        'alert_low_stock_sent' => false,
                    ]);
                }

                continue;
            }

            /*
             * Do not repeatedly notify for the same low-stock period.
             */
            if ($inventory->alert_low_stock_sent) {
                continue;
            }

            DB::transaction(function () use (
                $inventory,
                $administrators,
                &$alertsProcessed
            ): void {
                $lockedInventory = MedicalInventory::query()
                    ->whereKey($inventory->id)
                    ->lockForUpdate()
                    ->first();

                if (
                    ! $lockedInventory ||
                    (int) $lockedInventory->quantity > 10 ||
                    $lockedInventory->alert_low_stock_sent
                ) {
                    return;
                }

                foreach ($administrators as $administrator) {
                    $administrator->notify(
                        new MedicalInventoryLowStockNotification(
                            $lockedInventory
                        )
                    );
                }

                $lockedInventory->update([
                    'alert_low_stock_sent' => true,
                ]);

                $alertsProcessed++;
            });
        }

        return $alertsProcessed;
    }
}