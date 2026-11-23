```php
<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Existing Laravel Command
|--------------------------------------------------------------------------
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Barangay Esperanza Automatic Notifications
|--------------------------------------------------------------------------
| All schedules use Philippine time (Asia/Manila).
*/

/*
|--------------------------------------------------------------------------
| Medical Inventory Expiry Notifications
|--------------------------------------------------------------------------
| Check expiry dates daily at 8:00 AM.
*/

Schedule::command('medical-inventory:check-expiry')
    ->dailyAt('08:00')
    ->timezone('Asia/Manila')
    ->withoutOverlapping();

/*
|--------------------------------------------------------------------------
| Schedule Event Reminders
|--------------------------------------------------------------------------
| Check upcoming events daily at 8:00 AM.
*/

Schedule::command('schedule:check-reminders')
    ->dailyAt('08:00')
    ->timezone('Asia/Manila')
    ->withoutOverlapping();

/*
|--------------------------------------------------------------------------
| Medical Inventory Low-Stock Notifications
|--------------------------------------------------------------------------
| Check inventory quantities every 30 minutes.
*/

Schedule::command('medical-inventory:check-low-stock')
    ->everyThirtyMinutes()
    ->timezone('Asia/Manila')
    ->withoutOverlapping();

Schedule::command('announcements:sync-sms-status')
    ->everyFiveMinutes()
    ->withoutOverlapping(15);
