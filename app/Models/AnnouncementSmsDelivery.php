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
        'resident_id',
        'recipient_type',
        'contact_number',
        'sent_at',
        'status',
        'failure_reason',
        'provider_reference',
        'provider_status',
        'provider_http_status',
        'status_lookup_http_status',
        'attempt_started_at',
        'status_checked_at',
        'status_check_attempted_at',
        'status_check_result',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'attempt_started_at' => 'datetime',
        'status_checked_at' => 'datetime',
        'status_check_attempted_at' => 'datetime',
        'provider_http_status' => 'integer',
    ];

    public function canPrepareRetry(): bool
    {
        return $this->status === 'Failed'
            && $this->attempt_started_at !== null
            && $this->provider_reference === null
            && $this->provider_status === null
            && in_array($this->provider_http_status, [401, 422], true);
    }

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

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
