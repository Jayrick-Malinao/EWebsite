<?php

namespace App\Notifications;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class EventReminderNotification extends Notification
{
    public function __construct(
        public Event $event,
    ) {
    }

    /**
     * Store notifications in the database.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Notification data displayed by the notification bell.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'schedule_event',

            'title' => 'Upcoming Event Reminder',

            'priority' => 'Important',

            'event_id' => $this->event->id,

            'event_title' => $this->event->title,

            'event_type' => $this->event->event_type,

            'event_date' => $this->event->event_date
                ? Carbon::parse($this->event->event_date, 'Asia/Manila')
                    ->format('F j, Y')
                : null,

            'start_time' => $this->formatTime(
                $this->event->start_time
            ),

            'end_time' => $this->formatTime(
                $this->event->end_time
            ),

            'location' => $this->event->location,

            'message' => $this->message(),
        ];
    }

    /**
     * Generate a message appropriate to the event date.
     */
    private function message(): string
    {
        $eventTitle = $this->event->title;

        if (! $this->event->event_date) {
            return "{$eventTitle} has an upcoming schedule. Please check the event details.";
        }

        $eventDate = Carbon::parse(
            $this->event->event_date,
            'Asia/Manila'
        )->startOfDay();

        $today = Carbon::now('Asia/Manila')->startOfDay();

        if ($eventDate->equalTo($today)) {
            $dateDescription = 'today';
        } elseif ($eventDate->equalTo($today->copy()->addDay())) {
            $dateDescription = 'tomorrow';
        } else {
            $dateDescription = 'on ' . $eventDate->format('F j, Y');
        }

        $message = "{$eventTitle} is scheduled {$dateDescription}";

        if ($this->event->start_time) {
            $message .= ' at ' . $this->formatTime(
                $this->event->start_time
            );
        }

        return $message . '. Please check the event details.';
    }

    /**
     * Format a database TIME value for display.
     */
    private function formatTime(?string $time): ?string
    {
        if (! $time) {
            return null;
        }

        return Carbon::parse($time)->format('g:i A');
    }
}