<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeniorCitizen extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'osca_id_number',
        'osca_registration_date',
        'senior_status',
        'classification',
        'blood_type',
        'medical_conditions',
        'maintenance_medications',
        'disabilities',
        'living_arrangement',
        'primary_caregiver',
        'caregiver_contact',
        'receives_social_pension',
        'receives_health_assistance',
        'receives_other_benefits',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'osca_registration_date' => 'date',
            'receives_social_pension' => 'boolean',
            'receives_health_assistance' => 'boolean',
            'receives_other_benefits' => 'boolean',
        ];
    }

    /**
     * Senior citizen belongs to an existing resident.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}