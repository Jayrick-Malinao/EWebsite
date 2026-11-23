<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MedicalInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_name',
        'expiry_date',
        'quantity',
        'alert_1_month_sent',
        'alert_15_days_sent',
        'alert_7_days_sent',
        'alert_expiry_sent',
        'alert_low_stock_sent',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'quantity' => 'integer',
            'alert_1_month_sent' => 'boolean',
            'alert_15_days_sent' => 'boolean',
            'alert_7_days_sent' => 'boolean',
            'alert_expiry_sent' => 'boolean',
            'alert_low_stock_sent' => 'boolean',
        ];
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MedicalInventoryTransaction::class);
    }
}
