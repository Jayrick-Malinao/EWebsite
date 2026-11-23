<?php

namespace App\Support;

class BarangayAddress
{
    private const LOCALITY = 'Esperanza, Pilar, Sorsogon';

    /**
     * @return list<string>
     */
    public static function puroks(): array
    {
        return [
            'Purok 1',
            'Purok 2',
            'Purok 3',
            'Purok 4',
            'Purok 5',
            'Purok 6',
        ];
    }

    /**
     * @return array{Barangay: string, Municipality: string, Province: string}
     */
    public static function localityParts(): array
    {
        return [
            'Barangay' => 'Esperanza',
            'Municipality' => 'Pilar',
            'Province' => 'Sorsogon',
        ];
    }

    public static function format(string $purok): string
    {
        return $purok.', '.self::LOCALITY;
    }

    /**
     * @return array{address: string, purok: ?string}
     */
    public static function split(?string $address): array
    {
        $address = trim((string) $address);

        foreach (self::puroks() as $purok) {
            $suffix = ', '.$purok.', '.self::LOCALITY;

            if (str_ends_with($address, $suffix)) {
                return [
                    'address' => substr($address, 0, -strlen($suffix)),
                    'purok' => $purok,
                ];
            }

            $legacySuffix = ', '.$purok;

            if (str_ends_with($address, $legacySuffix)) {
                return [
                    'address' => substr($address, 0, -strlen($legacySuffix)),
                    'purok' => $purok,
                ];
            }
        }

        $suffix = ', '.self::LOCALITY;

        if (str_ends_with($address, $suffix)) {
            $address = substr($address, 0, -strlen($suffix));
        }

        if (in_array($address, self::puroks(), true)) {
            return [
                'address' => '',
                'purok' => $address,
            ];
        }

        return [
            'address' => $address,
            'purok' => null,
        ];
    }

    public static function fitsStorage(string $purok): bool
    {
        return mb_strlen(self::format($purok)) <= 255;
    }
}
