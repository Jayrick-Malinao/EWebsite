<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'household_id',
        'is_household_head',
        'relationship_to_head',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'birth_date',
        'gender',
        'contact_number',
        'email',
        'household_address',
        'civil_status',
        'philhealth_number',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'birth_date' => 'date',
            'is_household_head' => 'boolean',
        ];
    }

    public function household(): BelongsTo
    {
        return $this->belongsTo(Household::class);
    }

    public function healthRecord(): HasOne
    {
        return $this->hasOne(HealthRecord::class);
    }

    public function healthVisits(): HasMany
    {
        return $this->hasMany(HealthVisit::class);
    }

    public function immunizations(): HasMany
    {
        return $this->hasMany(Immunization::class);
    }

    public function maternalCares(): HasMany
    {
        return $this->hasMany(MaternalCare::class);
    }

    public function childHealths(): HasMany
    {
        return $this->hasMany(ChildHealth::class);
    }

    public function seniorCitizen(): HasOne
    {
        return $this->hasOne(SeniorCitizen::class);
    }

    public function announcementRecipients(): HasMany
    {
        return $this->hasMany(AnnouncementRecipient::class);
    }

    public function announcementSmsDeliveries(): HasMany
    {
        return $this->hasMany(
            AnnouncementSmsDelivery::class,
            'household_head_resident_id'
        );
    }

    public function getFullNameAttribute(): string
    {
        return trim(
            $this->first_name.' '.
            ($this->middle_name ? $this->middle_name.' ' : '').
            $this->last_name.
            ($this->suffix ? ', '.$this->suffix : '')
        );
    }
}
