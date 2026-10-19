<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaternalCare extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'pregnancy_number',
        'last_menstrual_period',
        'expected_delivery_date',
        'actual_delivery_date',
        'pregnancy_status',
        'last_prenatal_visit',
        'prenatal_visit_count',
        'delivery_type',
        'place_of_delivery',
        'birth_outcome',
        'pregnancy_risk_factors',
        'medical_conditions',
        'medications',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'pregnancy_number' => 'integer',
            'last_menstrual_period' => 'date',
            'expected_delivery_date' => 'date',
            'actual_delivery_date' => 'date',
            'last_prenatal_visit' => 'date',
            'prenatal_visit_count' => 'integer',
        ];
    }

    /**
     * The resident who owns this maternal care record.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}