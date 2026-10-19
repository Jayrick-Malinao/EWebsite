<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'message',
        'target_type',
        'min_age',
        'max_age',
        'priority',
        'status',
        'published_at',
        'created_by',
    ];

    protected $casts = [
        'min_age' => 'integer',
        'max_age' => 'integer',
        'published_at' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(AnnouncementRecipient::class);
    }

    public function smsDeliveries(): HasMany
    {
        return $this->hasMany(AnnouncementSmsDelivery::class);
    }
}

