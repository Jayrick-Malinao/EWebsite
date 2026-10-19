<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Household extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_code',
        'household_head_name',
        'address',
        'contact_number',
        'status',
    ];

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function announcementSmsDeliveries(): HasMany
    {
        return $this->hasMany(AnnouncementSmsDelivery::class);
    }
}

