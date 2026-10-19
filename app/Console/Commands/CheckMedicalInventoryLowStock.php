<?php

namespace App\Console\Commands;

use App\Models\MedicalInventory;
use App\Services\MedicalInventoryLowStockService;
use Illuminate\Console\Command;

class CheckMedicalInventoryLowStock extends Command
{
    protected $signature = 'medical-inventory:check-low-stock';

    protected $description = 'Check medical inventory and notify administrators about low stock';

    public function handle(MedicalInventoryLowStockService $service): int
    {
        $count = $service->check();

        $this->info("Low-stock alerts processed: {$count}");

        return self::SUCCESS;
    }
}
