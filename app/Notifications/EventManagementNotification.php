<?php

namespace App\Notifications;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

class EventManagementNotification extends Notification
{
    public function __construct(
        public Event $event,
        public string $type,
        public string $title,
        public string $message,
    ) {}

    /**
     * Store the notification in the database.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Notification data used by the notification bell.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'priority' => 'Important',

            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'event_type' => $this->event->event_type,

            'event_date' => $this->event->event_date
                ? Carbon::parse(
                    $this->event->event_date,
                    'Asia/Manila'
                )->format('F j, Y')
                : null,

            'start_time' => $this->formatTime(
                $this->event->start_time
            ),

            'end_time' => $this->formatTime(
                $this->event->end_time
            ),

            'location' => $this->event->location,
        ];
    }

    /**
     * Format the event time for display.
     */
    private function formatTime(?string $time): ?string
    {
        if (! $time) {
            return null;
        }

        return Carbon::parse($time)->format('g:i A');
    }
}
