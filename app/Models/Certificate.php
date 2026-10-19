<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_number',
        'resident_id',
        'certificate_type',
        'purpose',
        'date_issued',
        'issued_by',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date_issued' => 'date',
    ];

    /**
     * Resident who received the certificate.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * User who issued the certificate.
     */
    public function issuer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'issued_by');
    }
}