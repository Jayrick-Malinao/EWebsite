<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'blood_type',
        'allergies',
        'chronic_conditions',
        'medical_history',
        'current_medications',
        'disabilities',
        'family_medical_history',
        'emergency_contact_name',
        'emergency_contact_number',
        'emergency_contact_relationship',
        'notes',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
