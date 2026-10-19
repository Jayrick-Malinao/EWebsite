<?php

namespace App\Notifications;

use App\Models\MedicalInventory;
use Illuminate\Notifications\Notification;

class MedicalInventoryExpiryNotification extends Notification
{
    public function __construct(
        public MedicalInventory $medicalInventory,
        public string $alertType,
    ) {
    }

    /**
     * Determine which channels the notification should use.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Database notification payload.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'medical_inventory_expiry',
            'title' => $this->title(),
            'medicine_name' => $this->medicalInventory->medicine_name,
            'expiry_date' => $this->medicalInventory->expiry_date
                ? $this->medicalInventory->expiry_date->format('F j, Y')
                : null,
            'quantity' => $this->medicalInventory->quantity,
            'alert_type' => $this->alertType,
            'message' => $this->message(),
        ];
    }

    /**
     * Notification title based on the alert type.
     */
    private function title(): string
    {
        return match ($this->alertType) {
            'expired' => 'Expired Medical Inventory Warning',
            'expiry' => 'Medical Inventory Expiry Today',
            default => 'Medical Inventory Expiry Alert',
        };
    }

    /**
     * Human-readable notification message.
     */
    private function message(): string
    {
        $medicineName = $this->medicalInventory->medicine_name;

        $expiryDate = $this->medicalInventory->expiry_date
            ? $this->medicalInventory->expiry_date->format('F j, Y')
            : 'an unknown date';

        return match ($this->alertType) {
            '1_month' => "{$medicineName} will expire within 30 days ({$expiryDate}).",

            '15_days' => "{$medicineName} will expire within 15 days ({$expiryDate}).",

            '7_days' => "{$medicineName} will expire within 7 days ({$expiryDate}).",

            'expiry' => "WARNING: {$medicineName} expires today ({$expiryDate}). Check its usability before dispensing.",

            'expired' => "URGENT: {$medicineName} expired on {$expiryDate}. Do not dispense it; check and remove it from usable stock according to health center procedures.",

            default => "{$medicineName} has an expiry alert. Expiry date: {$expiryDate}.",
        };
    }
}
