<?php

namespace App\Support;

class PhilippineMobileNumberFormatter
{
    public static function normalize(string $number): string
    {
        $trimmedNumber = trim($number);

        if (preg_match('/\A[+0-9\s().-]+\z/', $trimmedNumber) !== 1) {
            return $number;
        }

        $digits = preg_replace('/\D/', '', $trimmedNumber);

        if (! is_string($digits)) {
            return $number;
        }

        if (str_starts_with($digits, '0063')) {
            $digits = substr($digits, 2);
        }

        if (preg_match('/\A09\d{9}\z/', $digits) === 1) {
            return '63'.substr($digits, 1);
        }

        if (preg_match('/\A9\d{9}\z/', $digits) === 1) {
            return '63'.$digits;
        }

        if (self::isValid($digits)) {
            return $digits;
        }

        return $number;
    }

    public static function isValid(string $number): bool
    {
        return preg_match('/\A639\d{9}\z/', $number) === 1;
    }

    public static function formatForDisplay(?string $number): ?string
    {
        if ($number === null) {
            return null;
        }

        $normalizedNumber = self::normalize($number);

        if (! self::isValid($normalizedNumber)) {
            return $number;
        }

        return '+'.substr($normalizedNumber, 0, 4)
            .' '.substr($normalizedNumber, 4, 4)
            .' '.substr($normalizedNumber, 8, 4);
    }
}
