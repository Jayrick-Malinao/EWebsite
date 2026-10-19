<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // ---------------------------------------------------------
            // Health Center Information
            // ---------------------------------------------------------
            [
                'key' => 'health_center_name',
                'value' => 'Barangay Esperanza Health Center',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'barangay',
                'value' => 'Esperanza',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'municipality',
                'value' => 'Pilar',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'province',
                'value' => 'Sorsogon',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'health_center_address',
                'value' => 'Barangay Esperanza, Pilar, Sorsogon',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'contact_number',
                'value' => '',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'email',
                'value' => '',
                'group' => 'health_center',
                'type' => 'string',
            ],

            // ---------------------------------------------------------
            // System Preferences
            // ---------------------------------------------------------
            [
                'key' => 'timezone',
                'value' => 'Asia/Manila',
                'group' => 'preferences',
                'type' => 'string',
            ],
            [
                'key' => 'locale',
                'value' => 'en',
                'group' => 'preferences',
                'type' => 'string',
            ],
            [
                'key' => 'date_format',
                'value' => 'F d, Y',
                'group' => 'preferences',
                'type' => 'string',
            ],
            [
                'key' => 'records_per_page',
                'value' => '20',
                'group' => 'preferences',
                'type' => 'integer',
            ],

            // ---------------------------------------------------------
            // Notification Settings
            // ---------------------------------------------------------
            [
                'key' => 'event_reminders_enabled',
                'value' => '1',
                'group' => 'notifications',
                'type' => 'boolean',
            ],
            [
                'key' => 'event_reminder_days',
                'value' => '7',
                'group' => 'notifications',
                'type' => 'integer',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                    'type' => $setting['type'],
                ]
            );
        }
    }
}

