<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChildHealth extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'assessment_date',
        'weight_kg',
        'height_cm',
        'nutritional_status',
        'breastfeeding_status',
        'vitamin_a_status',
        'vitamin_a_date',
        'deworming_status',
        'deworming_date',
        'developmental_milestones',
        'health_assessment',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'assessment_date' => 'date',
            'vitamin_a_date' => 'date',
            'deworming_date' => 'date',
            'weight_kg' => 'decimal:2',
            'height_cm' => 'decimal:2',
        ];
    }

    /**
     * Get the resident associated with this child health record.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}