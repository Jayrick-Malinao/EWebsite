<?php

namespace App\Http\Controllers;

use App\Services\AuditLogService;
use App\Services\SystemSettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SystemSettingController extends Controller
{
    /**
     * Display the system settings page.
     */
    public function index(
        SystemSettingService $settings
    ): View {
        return view('settings.index', [
            'settings' => $settings->all(),
        ]);
    }

    /**
     * Update system settings.
     */
    public function update(
        Request $request,
        SystemSettingService $settings
    ): RedirectResponse {
        $validated = $request->validate([
            'health_center_name' => [
                'required',
                'string',
                'max:255',
            ],

            'barangay' => [
                'required',
                'string',
                'max:100',
            ],

            'municipality' => [
                'required',
                'string',
                'max:100',
            ],

            'province' => [
                'required',
                'string',
                'max:100',
            ],

            'health_center_address' => [
                'required',
                'string',
                'max:500',
            ],

            'contact_number' => [
                'nullable',
                'string',
                'max:50',
            ],

            'email' => [
                'nullable',
                'email',
                'max:255',
            ],

            'timezone' => [
                'required',
                'string',
                'timezone:all',
            ],

            'locale' => [
                'required',
                'string',
                'max:10',
            ],

            'date_format' => [
                'required',
                'string',
                'max:50',
            ],

            'records_per_page' => [
                'required',
                'integer',
                'min:10',
                'max:100',
            ],

            'event_reminders_enabled' => [
                'nullable',
                'boolean',
            ],

            'event_reminder_days' => [
                'required',
                'integer',
                'min:1',
                'max:30',
            ],
        ]);

        $validated['event_reminders_enabled'] =
            $request->boolean('event_reminders_enabled');

        $oldSettings = $settings->all();

        $settings->setMany([
            [
                'key' => 'health_center_name',
                'value' => $validated['health_center_name'],
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'barangay',
                'value' => $validated['barangay'],
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'municipality',
                'value' => $validated['municipality'],
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'province',
                'value' => $validated['province'],
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'health_center_address',
                'value' => $validated['health_center_address'],
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'contact_number',
                'value' => $validated['contact_number'] ?? '',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'email',
                'value' => $validated['email'] ?? '',
                'group' => 'health_center',
                'type' => 'string',
            ],
            [
                'key' => 'timezone',
                'value' => $validated['timezone'],
                'group' => 'preferences',
                'type' => 'string',
            ],
            [
                'key' => 'locale',
                'value' => $validated['locale'],
                'group' => 'preferences',
                'type' => 'string',
            ],
            [
                'key' => 'date_format',
                'value' => $validated['date_format'],
                'group' => 'preferences',
                'type' => 'string',
            ],
            [
                'key' => 'records_per_page',
                'value' => $validated['records_per_page'],
                'group' => 'preferences',
                'type' => 'integer',
            ],
            [
                'key' => 'event_reminders_enabled',
                'value' => $validated['event_reminders_enabled'],
                'group' => 'notifications',
                'type' => 'boolean',
            ],
            [
                'key' => 'event_reminder_days',
                'value' => $validated['event_reminder_days'],
                'group' => 'notifications',
                'type' => 'integer',
            ],
        ]);

        $newSettings = $settings->all();

        $changes = [];

        foreach ($newSettings as $key => $value) {
            if (($oldSettings[$key] ?? null) !== $value) {
                $changes[] = $key;
            }
        }

        if ($changes !== []) {
            AuditLogService::log(
                action: 'updated',
                module: 'System Settings',
                description:
                    'System settings updated: '
                    . implode(', ', $changes)
                    . '.',
            );
        }

        return redirect()
            ->route('settings.index')
            ->with(
                'success',
                'System settings updated successfully.'
            );
    }
}

