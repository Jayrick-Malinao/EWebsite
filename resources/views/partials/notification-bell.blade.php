 @auth
    @php
        $user = auth()->user();

        $unreadNotifications = $user
            ->unreadNotifications()
            ->latest()
            ->take(20)
            ->get();

        $readNotifications = $user
            ->readNotifications()
            ->latest('created_at')
            ->take(20)
            ->get();

        $unreadNotificationCount = $user
            ->unreadNotifications()
            ->count();

        $notifications = $unreadNotifications
            ->concat($readNotifications)
            ->unique('id')
            ->sortByDesc('created_at')
            ->take(20);

        $notificationLabels = [
            'schedule_event' => 'Upcoming Event Reminder',
            'schedule_event_created' => 'Event Created',
            'schedule_event_updated' => 'Event Updated',
            'schedule_event_cancelled' => 'Event Cancelled',
            'medical_inventory_expiry' => 'Medical Inventory Expiry Alert',
            'medical_inventory_low_stock' => 'Low Stock Alert',
            'announcement_published' => 'New Announcement Published',
            'announcement_important' => 'Important Announcement',
            'household_registered' => 'Household Registered',
            'household_updated' => 'Household Record Updated',
            'resident_registered' => 'Resident Registered',
            'resident_updated' => 'Resident Record Updated',
            'maternal_prenatal_reminder' => 'Prenatal Appointment Reminder',
            'maternal_follow_up' => 'Maternal Care Follow-up',
            'senior_citizen_registered' => 'Senior Citizen Registered',
            'certificate_submitted' => 'Certificate Request Submitted',
            'certificate_status_changed' => 'Certificate Status Updated',
            'staff_account_created' => 'New Staff Account Created',
            'staff_status_changed' => 'Staff Account Status Changed',
            'security_access_alert' => 'Security or Access Alert',
        ];
    @endphp

    <div
        x-data="{ notificationOpen: false }"
        @click.outside="notificationOpen = false"
        @keydown.escape.window="notificationOpen = false"
        class="notification-bell relative"
    >
        <button
            type="button"
            @click="notificationOpen = !notificationOpen"
            :aria-expanded="notificationOpen.toString()"
            aria-label="Notifications"
            class="notification-bell-trigger relative flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-[#0F4C3A] focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0M18 8A6 6 0 0 0 6 8c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h4" />
            </svg>

            @if ($unreadNotificationCount > 0)
                <span class="notification-bell-count absolute -right-1 -top-1 flex min-h-[18px] min-w-[18px] items-center justify-center rounded-full bg-[#E87928] px-1 text-[9px] font-bold leading-none text-white ring-2 ring-white">
                    {{ $unreadNotificationCount > 99 ? '99+' : $unreadNotificationCount }}
                </span>
            @endif
        </button>

        <div
            x-cloak
            x-show="notificationOpen"
            x-transition
            class="notification-bell-panel absolute right-0 top-12 z-[100] w-[min(92vw,400px)] overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl"
            style="display: none;"
        >
            <div class="flex items-center justify-between border-b border-slate-100 bg-[#F5FAF7] px-4 py-4">
                <div>
                    <h3 class="text-sm font-bold text-[#164238]">Notifications</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">
                        @if ($unreadNotificationCount > 0)
                            {{ $unreadNotificationCount }}
                            unread notification{{ $unreadNotificationCount === 1 ? '' : 's' }}
                        @else
                            You're all caught up
                        @endif
                    </p>
                </div>

                @if ($unreadNotificationCount > 0 && \Illuminate\Support\Facades\Route::has('notifications.read-all'))
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button type="submit" class="rounded-lg px-2.5 py-2 text-xs font-semibold text-[#0F6F5A] transition hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            Mark all read
                        </button>
                    </form>
                @endif
            </div>

            <div class="max-h-[min(70vh,500px)] overflow-y-auto">
                @forelse ($notifications as $notification)
                    @php
                        $data = $notification->data ?? [];
                        $isUnread = is_null($notification->read_at);

                        $notificationType = $data['type'] ?? 'general';
                        $alertType = $data['alert_type'] ?? null;
                        $priority = strtolower($data['priority'] ?? 'normal');

                        $notificationTitle = $data['title']
                            ?? $notificationLabels[$notificationType]
                            ?? 'System Notification';

                        $module = match (true) {
                            str_starts_with($notificationType, 'schedule_event') => 'Schedule Management',
                            str_starts_with($notificationType, 'medical_inventory') => 'Medical Inventory',
                            str_starts_with($notificationType, 'announcement') => 'Announcements',
                            str_starts_with($notificationType, 'household') => 'Household Management',
                            str_starts_with($notificationType, 'resident') => 'Resident Management',
                            str_starts_with($notificationType, 'maternal') => 'Maternal Care',
                            str_starts_with($notificationType, 'senior_citizen') => 'Senior Citizens',
                            str_starts_with($notificationType, 'certificate') => 'Certificates',
                            str_starts_with($notificationType, 'staff') => 'User Management',
                            str_starts_with($notificationType, 'security') => 'System Administration',
                            default => $data['module'] ?? 'System Notification',
                        };

                        $alertLabel = match ($alertType) {
                            '1_month' => 'Expires within 30 days',
                            '15_days' => 'Expires within 15 days',
                            '7_days' => 'Expires within 7 days',
                            'expiry' => 'Expires today',
                            'expired' => 'Expired',
                            default => null,
                        };

                        $iconStyle = match (true) {
                            str_starts_with($notificationType, 'schedule_event') =>
                                'bg-blue-50 text-blue-700',
                            str_starts_with($notificationType, 'medical_inventory') =>
                                'bg-orange-50 text-orange-700',
                            str_starts_with($notificationType, 'announcement') =>
                                'bg-purple-50 text-purple-700',
                            str_starts_with($notificationType, 'security') =>
                                'bg-red-50 text-red-700',
                            default => 'bg-emerald-50 text-[#0F6F5A]',
                        };

                        $priorityStyle = match ($priority) {
                            'urgent' => 'bg-red-100 text-red-800',
                            'important' => 'bg-orange-100 text-orange-800',
                            default => 'bg-slate-100 text-slate-600',
                        };

                        $metadata = [];

                        foreach ([
                            'event_title' => 'Event',
                            'event_type' => 'Event Type',
                            'event_date' => 'Date',
                            'start_time' => 'Start Time',
                            'end_time' => 'End Time',
                            'location' => 'Location',
                            'medicine_name' => 'Medicine or Supply',
                            'expiry_date' => 'Expiry Date',
                            'quantity' => 'Quantity',
                            'announcement_title' => 'Announcement',
                            'household_code' => 'Household Code',
                            'resident_name' => 'Resident',
                            'appointment_date' => 'Appointment Date',
                            'certificate_type' => 'Certificate',
                            'status' => 'Status',
                        ] as $key => $label) {
                            if (
                                isset($data[$key])
                                && is_scalar($data[$key])
                                && trim((string) $data[$key]) !== ''
                            ) {
                                $metadata[$label] = (string) $data[$key];
                            }
                        }
                    @endphp

                    <article
                        class="border-b border-slate-100 px-4 py-4 last:border-b-0 {{ $isUnread ? 'bg-emerald-50/40' : 'bg-white' }}"
                    >
                        <div class="flex gap-3">
                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $iconStyle }}">
                                @if (str_starts_with($notificationType, 'schedule_event'))
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="4" width="18" height="17" rx="2" />
                                        <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                                    </svg>
                                @elseif (str_starts_with($notificationType, 'medical_inventory'))
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 3h4v4l5 5a5 5 0 0 1-4 8H9a5 5 0 0 1-4-8l5-5V3Z" />
                                        <path stroke-linecap="round" d="M8 14h8" />
                                    </svg>
                                @elseif (str_starts_with($notificationType, 'announcement'))
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 11v2a2 2 0 0 0 2 2h2l3 5h3l-2-6 8-4V4L7 9H5a2 2 0 0 0-2 2Z" />
                                        <path stroke-linecap="round" d="M19 9v4" />
                                    </svg>
                                @elseif (str_starts_with($notificationType, 'security'))
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 20 6v5c0 5-3.5 8-8 10-4.5-2-8-5-8-10V6l8-3Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M10.3 3.9l-8.8 15a2 2 0 0 0 1.7 3h17.6a2 2 0 0 0 1.7-3l-8.8-15a2 2 0 0 0-3.4 0Z" />
                                    </svg>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-sm {{ $isUnread ? 'font-bold text-[#164238]' : 'font-semibold text-slate-600' }}">
                                            {{ $notificationTitle }}
                                        </p>
                                        <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-[#6D817A]">
                                            {{ $module }}
                                        </p>
                                    </div>

                                    @if ($isUnread)
                                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="shrink-0">
                                            @csrf
                                            <button type="submit" class="flex h-7 w-7 items-center justify-center rounded-full border border-emerald-200 bg-white text-[#0F6F5A] shadow-sm transition hover:bg-emerald-50 focus:outline-none focus:ring-2 focus:ring-emerald-500" title="Mark as read" aria-label="Mark notification as read">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="shrink-0 text-[10px] font-semibold text-slate-400">Read</span>
                                    @endif
                                </div>

                                <p class="mt-2 text-sm leading-5 text-slate-600">
                                    {{ $data['message'] ?? 'A notification requires your attention.' }}
                                </p>

                                @if ($priority !== 'normal' || $alertLabel)
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        @if ($priority !== 'normal')
                                            <span class="inline-flex rounded-full px-2 py-1 text-[10px] font-bold {{ $priorityStyle }}">
                                                {{ ucfirst($priority) }} Priority
                                            </span>
                                        @endif

                                        @if ($alertLabel)
                                            <span class="inline-flex rounded-full px-2 py-1 text-[10px] font-semibold {{ $alertType === 'expired' || $alertType === 'expiry' ? 'bg-red-100 text-red-800' : 'bg-orange-50 text-orange-800' }}">
                                                {{ $alertLabel }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                @if (!empty($metadata))
                                    <div class="mt-3 space-y-2 rounded-xl border border-slate-100 bg-slate-50 px-3 py-3">
                                        @foreach ($metadata as $label => $value)
                                            <div class="flex items-start justify-between gap-3">
                                                <span class="shrink-0 text-xs text-slate-500">{{ $label }}</span>
                                                <span class="max-w-[65%] break-words text-right text-xs font-semibold text-slate-700">{{ $value }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="mt-3 text-[10px] text-slate-400">
                                    {{ $notification->created_at?->timezone('Asia/Manila')->format('M j, Y · g:i A') }}
                                    <span class="mx-1">·</span>
                                    {{ $isUnread ? 'Unread' : 'Read' }}
                                </p>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="px-6 py-10 text-center">
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-[#EEF5F1] text-[#6D817A]">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0M18 8A6 6 0 0 0 6 8c0 7-3 7-3 9h18c0-2-3-2-3-9" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h4" />
                            </svg>
                        </div>
                        <p class="mt-3 text-sm font-bold text-[#164238]">No notifications</p>
                        <p class="mt-1 text-xs text-[#6D817A]">New alerts and updates will appear here.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endauth