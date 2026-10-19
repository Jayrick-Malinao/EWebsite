<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthVisit extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'visit_date',
        'visit_type',
        'chief_complaint',
        'assessment',
        'treatment',
        'remarks',
        'attended_by',
    ];

    protected function casts(): array
    {
        return [
            'visit_date' => 'datetime',
        ];
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}