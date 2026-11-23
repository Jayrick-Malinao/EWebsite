<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MedicalInventoryTransaction extends Model
{
    protected $fillable = [
        'medical_inventory_id',
        'resident_id',
        'released_by_id',
        'method',
        'purpose',
        'quantity',
        'released_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'released_at' => 'datetime',
        ];
    }

    public function medicalInventory(): BelongsTo
    {
        return $this->belongsTo(MedicalInventory::class);
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function releasedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'released_by_id');
    }
}
