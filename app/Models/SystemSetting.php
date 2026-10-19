<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
    ];

    /**
     * Get the setting's value converted to its configured type.
     */
    public function typedValue(): mixed
    {
        return match ($this->type) {
            'boolean' => filter_var(
                $this->value,
                FILTER_VALIDATE_BOOLEAN
            ),
            'integer' => (int) $this->value,
            'float' => (float) $this->value,
            'json' => json_decode($this->value ?? 'null', true),
            default => $this->value,
        };
    }
}

