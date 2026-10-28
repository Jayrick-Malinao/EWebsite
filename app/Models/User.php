<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'status',
])]
#[Hidden([
    'password',
    'remember_token',
])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public static function makeFullName(array $parts): string
    {
        $normalized = [];

        foreach ($parts as $part) {
            $value = trim((string) $part);

            if ($value === '') {
                continue;
            }

            $normalized[] = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
        }

        return implode(' ', $normalized);
    }

    public static function splitFullName(string $fullName): array
    {
        $tokens = preg_split('/\s+/', trim((string) $fullName), -1, PREG_SPLIT_NO_EMPTY) ?: [];

        if ($tokens === []) {
            return [
                'first_name' => '',
                'middle_name' => '',
                'last_name' => '',
            ];
        }

        if (count($tokens) === 1) {
            return [
                'first_name' => $tokens[0],
                'middle_name' => '',
                'last_name' => '',
            ];
        }

        if (count($tokens) === 2) {
            return [
                'first_name' => $tokens[0],
                'middle_name' => '',
                'last_name' => $tokens[1],
            ];
        }

        $lastName = array_pop($tokens);
        $middleName = count($tokens) > 1 ? implode(' ', array_slice($tokens, 1)) : '';

        return [
            'first_name' => $tokens[0] ?? '',
            'middle_name' => $middleName,
            'last_name' => $lastName,
        ];
    }

    protected function setNameAttribute($value): void
    {
        $cleanValue = preg_replace('/\s+/', ' ', trim((string) $value));

        if ($cleanValue === '') {
            $this->attributes['name'] = '';

            return;
        }

        $parts = preg_split('/\s+/', $cleanValue, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        $this->attributes['name'] = implode(' ', array_map(
            fn (string $part): string => mb_convert_case($part, MB_CASE_TITLE, 'UTF-8'),
            $parts,
        ));
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
