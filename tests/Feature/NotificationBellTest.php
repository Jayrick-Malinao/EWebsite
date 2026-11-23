<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class NotificationBellTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_bell_renders_navigation_and_read_actions_for_recent_notifications(): void
    {
        $user = User::factory()->create();
        $user->notifications()->create([
            'id' => (string) Str::uuid(),
            'type' => 'event',
            'data' => [
                'type' => 'schedule_event_updated',
                'title' => 'First event',
                'message' => 'First update',
                'event_title' => 'Health checkup',
                'event_date' => 'November 22, 2026',
                'location' => 'Barangay Hall',
            ],
            'read_at' => null,
        ]);
        $user->notifications()->create([
            'id' => (string) Str::uuid(),
            'type' => 'event',
            'data' => ['type' => 'schedule_event_updated', 'title' => 'Second event', 'message' => 'Second update'],
            'read_at' => now(),
        ]);

        $this->actingAs($user);
        $view = $this->view('partials.notification-bell');

        $view->assertSee('First event')
            ->assertSee('Second event')
            ->assertSee('Barangay Hall')
            ->assertSee('Previous notification')
            ->assertSee('Next notification')
            ->assertSee('Mark notification as read')
            ->assertSee('Mark all read');
    }

    public function test_empty_notification_bell_has_no_navigation_buttons(): void
    {
        $this->actingAs(User::factory()->create());

        $view = $this->view('partials.notification-bell');

        $view->assertSee('No notifications')
            ->assertDontSee('Previous notification')
            ->assertDontSee('Next notification');
    }
}
