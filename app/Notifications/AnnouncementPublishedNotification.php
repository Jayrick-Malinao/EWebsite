<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Notifications\Notification;

class AnnouncementPublishedNotification extends Notification
{
    public function __construct(
        public Announcement $announcement
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $priority = (string) $this->announcement->priority;

        $isImportant = in_array(
            $priority,
            ['Important', 'Urgent'],
            true
        );

        return [
            'type' => $isImportant
                ? 'announcement_important'
                : 'announcement_published',

            'title' => match ($priority) {
                'Urgent' => 'Urgent Announcement',
                'Important' => 'Important Announcement',
                default => 'New Announcement Published',
            },

            'priority' => $priority,
            'announcement_id' => $this->announcement->id,
            'announcement_title' => $this->announcement->title,
            'target_type' => $this->announcement->target_type,

            'published_at' => $this->announcement->published_at
                ? $this->announcement->published_at->toDateTimeString()
                : now()->toDateTimeString(),

            'message' => $this->announcement->message,
        ];
    }
}
