<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display the notifications page.
     */
    public function index(): View
    {
        $user = Auth::user();

        $notifications = $user
            ->notifications()
            ->latest()
            ->paginate(15);

        $unreadNotificationCount = $user
            ->unreadNotifications()
            ->count();

        return view('notifications.schedule', [
            'notifications' => $notifications,
            'unreadNotificationCount' => $unreadNotificationCount,
        ]);
    }

    /**
     * Mark one notification as read.
     */
    public function markAsRead(
        DatabaseNotification $notification
    ): RedirectResponse {
        /*
         * Security check:
         * A logged-in user can only mark their own
         * notifications as read.
         */
        abort_unless(
            $notification->notifiable_type === Auth::user()->getMorphClass()
                && $notification->notifiable_id === Auth::id(),
            403
        );

        $notification->markAsRead();

        return back();
    }

    /**
     * Mark all notifications belonging to
     * the currently authenticated user as read.
     */
    public function markAllAsRead(): RedirectResponse
    {
        Auth::user()
            ->unreadNotifications
            ->markAsRead();

        return back();
    }
}