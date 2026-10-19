<?php

namespace App\Services;

use App\Models\SystemSetting;
use Illuminate\Support\Facades\Cache;

class SystemSettingService
{
    private const CACHE_KEY = 'system_settings';

    /**
     * Get a setting by key.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        if (! isset($settings[$key])) {
            return $default;
        }

        return $settings[$key];
    }

    /**
     * Get all settings as key => typed value.
     */
    public function all(): array
    {
        return Cache::remember(
            self::CACHE_KEY,
            now()->addHours(12),
            function (): array {
                return SystemSetting::query()
                    ->get()
                    ->mapWithKeys(function (SystemSetting $setting): array {
                        return [
                            $setting->key => $setting->typedValue(),
                        ];
                    })
                    ->all();
            }
        );
    }

    /**
     * Get settings grouped by their group name.
     */
    public function grouped(): array
    {
        return SystemSetting::query()
            ->orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group')
            ->map(function ($settings): array {
                return $settings
                    ->mapWithKeys(function (SystemSetting $setting): array {
                        return [
                            $setting->key => $setting->typedValue(),
                        ];
                    })
                    ->all();
            })
            ->all();
    }

    /**
     * Create or update a setting.
     */
    public function set(
        string $key,
        mixed $value,
        string $group = 'general',
        string $type = 'string',
    ): SystemSetting {
        $storedValue = $this->serializeValue($value, $type);

        $setting = SystemSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => $storedValue,
                'group' => $group,
                'type' => $type,
            ]
        );

        $this->clearCache();

        return $setting;
    }

    /**
     * Save multiple settings at once.
     */
    public function setMany(array $settings): void
    {
        foreach ($settings as $setting) {
            $this->set(
                key: $setting['key'],
                value: $setting['value'],
                group: $setting['group'] ?? 'general',
                type: $setting['type'] ?? 'string',
            );
        }

        $this->clearCache();
    }

    /**
     * Clear cached settings.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Convert a value into the database representation.
     */
    private function serializeValue(
        mixed $value,
        string $type,
    ): ?string {
        if ($value === null) {
            return null;
        }

        return match ($type) {
            'boolean' => $value ? '1' : '0',
            'integer' => (string) ((int) $value),
            'float' => (string) ((float) $value),
            'json' => json_encode(
                $value,
                JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR
            ),
            default => (string) $value,
        };
    }
}

