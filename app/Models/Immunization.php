<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Immunization extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'vaccine_name',
        'vaccine_type',
        'dose_number',
        'date_administered',
        'next_dose_date',
        'batch_number',
        'administered_by',
        'site_of_administration',
        'remarks',
    ];

    protected function casts(): array
    {
        return [
            'date_administered' => 'date',
            'next_dose_date' => 'date',
        ];
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}

