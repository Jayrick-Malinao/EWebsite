<?php

namespace App\Notifications;

use App\Models\MedicalInventory;
use Illuminate\Notifications\Notification;

class MedicalInventoryLowStockNotification extends Notification
{
    public function __construct(
        public MedicalInventory $inventory
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $quantity = (int) $this->inventory->quantity;

        return [
            'type' => 'medical_inventory_low_stock',
            'title' => $quantity === 0
                ? 'Out of Stock Alert'
                : 'Low Stock Alert',
            'priority' => $quantity === 0 ? 'Urgent' : 'Important',
            'inventory_id' => $this->inventory->id,
            'medicine_name' => $this->inventory->medicine_name,
            'quantity' => $quantity,
            'threshold' => 10,
            'message' => $quantity === 0
                ? "{$this->inventory->medicine_name} is out of stock. Please arrange replenishment immediately."
                : "{$this->inventory->medicine_name} has only {$quantity} units remaining. The low-stock threshold is 10 units.",
        ];
    }
}
