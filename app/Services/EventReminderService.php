<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use App\Notifications\EventReminderNotification;
use Carbon\Carbon;

class EventReminderService
{
    /**
     * Check events scheduled for today or tomorrow
     * and notify eligible users before the event starts.
     */
    public function check(): int
    {
        $now = Carbon::now('Asia/Manila');
        $today = $now->copy()->startOfDay();
        $tomorrow = $today->copy()->addDay();

        /*
         * Schedule notifications are sent to:
         * - System Administrator
         * - Official
         * - Health Worker
         */
        $users = User::query()
            ->whereIn('role', [
                'System Administrator',
                'Official',
                'Health Worker',
            ])
            ->get();

        if ($users->isEmpty()) {
            return 0;
        }

        /*
         * Process events scheduled for today or tomorrow
         * that have not already been notified.
         */
        $events = Event::query()
            ->where('reminder_sent', false)
            ->whereDate('event_date', '>=', $today->toDateString())
            ->whereDate('event_date', '<=', $tomorrow->toDateString())
            ->get();

        $notificationsSent = 0;

        foreach ($events as $event) {
            /*
             * Events without a start time cannot be checked.
             */
            if (! $event->start_time) {
                continue;
            }

            $eventDateTime = Carbon::parse(
                $event->event_date->format('Y-m-d')
                    . ' ' . $event->start_time,
                'Asia/Manila'
            );

            /*
             * Do not notify for events that have already started.
             */
            if ($eventDateTime->lessThanOrEqualTo($now)) {
                continue;
            }

            /*
             * Send a database notification to every eligible user.
             */
            foreach ($users as $user) {
                $user->notify(
                    new EventReminderNotification($event)
                );

                $notificationsSent++;
            }

            /*
             * Prevent duplicate reminders for the same event.
             */
            $event->update([
                'reminder_sent' => true,
            ]);
        }

        return $notificationsSent;
    }
}