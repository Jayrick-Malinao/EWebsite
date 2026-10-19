<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Notifications\EventManagementNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display the schedule.
     */
    public function index(): View
    {
        $events = Event::query()
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        $upcomingEvents = Event::query()
            ->whereDate('event_date', '>=', today())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->limit(10)
            ->get();

        return view('schedule.index', compact(
            'events',
            'upcomingEvents'
        ));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('schedule.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        if (
            !empty($validated['start_time']) &&
            !empty($validated['end_time']) &&
            $validated['end_time'] <= $validated['start_time']
        ) {
            return back()
                ->withErrors([
                    'end_time' => 'The end time must be later than the start time.',
                ])
                ->withInput();
        }

        $event = Event::create([
            'title' => $validated['title'],
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,
            'reminder_sent' => false,
            'created_by' => auth()->id(),
        ]);

        $this->notifyScheduleUsers(
            $event,
            'schedule_event_created',
            'Event Created',
            "A new event, {$event->title}, has been added to the schedule."
        );

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event): View
    {
        return view('schedule.edit', compact('event'));
    }

    /**
     * Update an existing event.
     */
    public function update(
        Request $request,
        Event $event
    ): RedirectResponse {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_type' => ['required', 'string', 'max:100'],
            'event_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['nullable', 'date_format:H:i'],
            'end_time' => ['nullable', 'date_format:H:i'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
        ]);

        if (
            !empty($validated['start_time']) &&
            !empty($validated['end_time']) &&
            $validated['end_time'] <= $validated['start_time']
        ) {
            return back()
                ->withErrors([
                    'end_time' => 'The end time must be later than the start time.',
                ])
                ->withInput();
        }

        $dateChanged = Carbon::parse(
            $event->event_date,
            'Asia/Manila'
        )->format('Y-m-d') !== $validated['event_date'];

        $event->update([
            'title' => $validated['title'],
            'event_type' => $validated['event_type'],
            'event_date' => $validated['event_date'],
            'start_time' => $validated['start_time'] ?? null,
            'end_time' => $validated['end_time'] ?? null,
            'location' => $validated['location'] ?? null,
            'description' => $validated['description'] ?? null,

            // Reset the reminder when the event date changes.
            'reminder_sent' => $dateChanged
                ? false
                : $event->reminder_sent,
        ]);

        $event->refresh();

        $this->notifyScheduleUsers(
            $event,
            'schedule_event_updated',
            'Event Updated',
            "The scheduled event, {$event->title}, has been updated. Please review its latest details."
        );

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Delete an event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->notifyScheduleUsers(
            $event,
            'schedule_event_cancelled',
            'Event Cancelled',
            "The scheduled event, {$event->title}, has been cancelled."
        );

        $event->delete();

        return redirect()
            ->route('schedule.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Notify all eligible system users.
     */
    private function notifyScheduleUsers(
        Event $event,
        string $type,
        string $title,
        string $message
    ): void {
        User::query()
            ->whereIn('role', [
                'System Administrator',
                'Official',
                'Health Worker',
            ])
            ->each(function (User $user) use (
                $event,
                $type,
                $title,
                $message
            ): void {
                $user->notify(
                    new EventManagementNotification(
                        $event,
                        $type,
                        $title,
                        $message
                    )
                );
            });
    }
}
