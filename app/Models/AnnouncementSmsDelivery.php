<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnnouncementSmsDelivery extends Model
{
    protected $fillable = [
        'announcement_id',
        'household_id',
        'household_head_resident_id',
        'contact_number',
        'sent_at',
        'status',
        'failure_reason',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class);
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function householdHead(): BelongsTo
    {
        return $this->belongsTo(
            Resident::class,
            'household_head_resident_id'
        );
    }
}

