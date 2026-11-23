<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Notifications | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="System notifications for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           NOTIFICATIONS
        ========================================================= */

        :root {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;
            --primary-deep: #0F4C3A;
            --accent: #E87928;

            --bg: #EEF5F1;
            --surface: #F5FAF7;
            --surface-soft: #EDF5F0;
            --surface-raised: #F8FCFA;

            --text: #164238;
            --text-heading: #234E43;
            --text-secondary: #385C52;
            --text-muted: #6D817A;
            --text-soft: #9AA9A4;

            --danger: #B42323;
            --danger-bright: #DC2626;

            --border-soft: rgba(210, 225, 218, 0.65);
            --border-white: rgba(255, 255, 255, 0.90);

            --shadow-dark: rgba(107, 134, 124, 0.18);
            --shadow-medium: rgba(107, 134, 124, 0.12);
            --shadow-light: rgba(255, 255, 255, 0.92);

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 24px;
            --radius-2xl: 28px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; }

        .clay-households,
        .clay-households *,
        .clay-households input,
        .clay-households button,
        .clay-households select,
        .clay-households textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-households {
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.92), transparent 34%),
                radial-gradient(circle at 100% 0%, rgba(22, 139, 112, 0.055), transparent 32%),
                linear-gradient(135deg, #EEF5F1 0%, #F5FAF7 52%, #EDF5F0 100%);
        }

        ::selection { color: #FFFFFF; background: var(--primary-dark); }

        [x-cloak] { display: none !important; }

        /* ---------- Header ---------- */
        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 0 5px 18px rgba(107, 134, 124, 0.08), 0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88);
        }

        /* ---------- Heading ---------- */
        .clay-category { color: var(--primary); letter-spacing: 0.08em; }
        .clay-title { color: var(--text); }
        .clay-description { color: var(--text-muted); }
        .clay-heading-wrap { position: relative; }
        .clay-heading-accent {
            position: absolute;
            left: -16px;
            top: 4px;
            width: 4px;
            height: calc(100% - 8px);
            min-height: 62px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--primary-light), var(--primary-dark));
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.16), -1px -1px 3px rgba(255, 255, 255, 0.82);
        }

        /* ---------- Clay Surfaces ---------- */
        .clay-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow: 8px 8px 18px var(--shadow-dark), -8px -8px 18px var(--shadow-light), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            border-radius: 24px;
        }

        .clay-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: inset 3px 3px 7px rgba(107, 134, 124, 0.10), inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        .clay-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88), inset 1px 1px 0 rgba(255, 255, 255, 0.42);
        }
        .clay-icon-green { background: linear-gradient(145deg, #E7F5EE, #D9ECE4); color: var(--primary-dark); }

        /* ---------- Table & Actions ---------- */
        .clay-table {
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 26px;
            box-shadow: 8px 8px 18px rgba(107, 134, 124, 0.18), -8px -8px 18px rgba(255, 255, 255, 0.92), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }
        .clay-table-row { background: rgba(255, 255, 255, 0.48); transition: background 0.18s ease; }
        .clay-table-row:hover { background: rgba(255, 255, 255, 0.78); }

        .clay-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 32px;
            border-radius: 10px;
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.82);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .clay-action:hover { transform: translateY(-1px); }

        .clay-view { background: linear-gradient(145deg, #E8F6EF, #DDEEE6); color: var(--primary-dark) !important; border-color: rgba(22, 139, 112, 0.14); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.88); }

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        /* ---------- Status tints (aligned to design tokens) ---------- */
        .clay-unread-row { background: rgba(232, 245, 238, 0.55); }
        .clay-read-row { background: rgba(255, 255, 255, 0.48); }

        @media (max-width: 1023px) {
            .clay-heading-accent { display: none; }
            main { padding-left: 0; }
        }
    </style>
</head>

<body class="clay-households antialiased">

    {{-- Mobile Sidebar Overlay --}}
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-[#164238]/40 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Content --}}
    <main class="min-h-screen lg:pl-72">

        {{-- TOP HEADER --}}
        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Left --}}
                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-category text-xs font-bold uppercase tracking-wider">
                            System Administrator
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Notifications
                        </h1>
                    </div>
                </div>

                {{-- Right --}}
                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="max-w-40 truncate text-sm font-bold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs font-medium text-[#6D817A]">
                                System Administrator
                            </p>
                        </div>

                        <div class="clay-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Notification Center</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        All Notifications
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        View schedule reminders, medical inventory alerts, and other system notifications.
                    </p>
                </div>

                {{-- Mark All as Read --}}
                @if ($unreadNotificationCount > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}" class="w-full sm:w-auto">
                        @csrf
                        <button
                            type="submit"
                            class="clay-primary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                        >
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Mark all as read
                        </button>
                    </form>
                @endif
            </div>

            {{-- SUMMARY STATS --}}
            <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Total Notifications</p>
                            <p class="mt-2 text-3xl font-bold text-[#164238]">{{ $notifications->total() }}</p>
                        </div>
                        <div class="clay-icon clay-icon-green h-12 w-12 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Unread Notifications</p>
                            <p class="mt-2 text-3xl font-bold text-[#E87928]">{{ $unreadNotificationCount }}</p>
                        </div>
                        <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            {{-- NOTIFICATION LIST --}}
            <section class="clay-table">

                {{-- List Header --}}
                <div class="flex items-center justify-between gap-4 border-b border-white/70 px-5 py-5 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Notification History</h3>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Your latest system notifications</p>
                        </div>
                    </div>

                    @if ($notifications->total() > 0)
                        <div class="hidden text-xs font-semibold text-[#6D817A] sm:block">
                            Showing <span class="font-bold text-[#164238]">{{ $notifications->firstItem() }}</span>
                            – <span class="font-bold text-[#164238]">{{ $notifications->lastItem() }}</span>
                            of <span class="font-bold text-[#164238]">{{ $notifications->total() }}</span>
                        </div>
                    @endif
                </div>

                {{-- NOTIFICATIONS --}}
                @if ($notifications->count() > 0)

                    <div class="divide-y divide-[#D2E1DA]/60">

                        @foreach ($notifications as $notification)

                            @php
                                $data = $notification->data ?? [];
                                $type = $data['type'] ?? 'general';
                                $isUnread = is_null($notification->read_at);
                            @endphp

                            <div class="{{ $isUnread ? 'clay-unread-row' : 'clay-read-row' }} clay-table-row px-5 py-5 transition sm:px-6">

                                <div class="flex gap-4">

                                    {{-- Notification Icon --}}
                                    <div class="shrink-0">

                                        @if ($type === 'schedule_event')
                                            <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>

                                        @elseif ($type === 'medical_inventory_expiry')
                                            <div class="clay-icon h-11 w-11 rounded-2xl bg-[#FCF7ED] text-[#E87928]">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                                                </svg>
                                            </div>

                                        @else
                                            <div class="clay-icon clay-inset h-11 w-11 rounded-2xl text-[#6D817A]">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z" />
                                                </svg>
                                            </div>
                                        @endif

                                    </div>

                                    {{-- Notification Content --}}
                                    <div class="min-w-0 flex-1">

                                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">

                                            <div class="min-w-0">

                                                <div class="flex flex-wrap items-center gap-2">
                                                    <h4 class="font-bold text-[#164238]">
                                                        {{ $data['title'] ?? 'Notification' }}
                                                    </h4>

                                                    @if ($isUnread)
                                                        <span class="inline-flex items-center rounded-full border border-[#168B70]/20 bg-[#E7F5EE] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#0F6F5A]">
                                                            Unread
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-full border border-[#6D817A]/20 bg-[#EDF5F0] px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-[#6D817A]">
                                                            Read
                                                        </span>
                                                    @endif
                                                </div>

                                                <p class="mt-1 text-sm leading-6 text-[#385C52]">
                                                    {{ $data['message'] ?? 'You have a new notification.' }}
                                                </p>

                                            </div>

                                            <div class="shrink-0">
                                                <span class="text-xs text-[#9AA9A4]">
                                                    {{ $notification->created_at?->diffForHumans() }}
                                                </span>
                                            </div>

                                        </div>

                                        {{-- SCHEDULE DETAILS --}}
                                        @if ($type === 'schedule_event')

                                            <div class="clay-inset mt-4 grid gap-3 rounded-2xl p-4 sm:grid-cols-2 lg:grid-cols-4">

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Event</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['event_title'] ?? '—' }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Type</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['event_type'] ?? '—' }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Date</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['event_date'] ?? '—' }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Time</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">
                                                        @if (!empty($data['start_time']))
                                                            {{ $data['start_time'] }}
                                                            @if (!empty($data['end_time']))
                                                                – {{ $data['end_time'] }}
                                                            @endif
                                                        @else
                                                            All day
                                                        @endif
                                                    </p>
                                                </div>

                                                @if (!empty($data['location']))
                                                    <div class="sm:col-span-2 lg:col-span-4">
                                                        <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Location</p>
                                                        <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['location'] }}</p>
                                                    </div>
                                                @endif

                                            </div>

                                        {{-- MEDICAL INVENTORY DETAILS --}}
                                        @elseif ($type === 'medical_inventory_expiry')

                                            <div class="clay-inset mt-4 grid gap-3 rounded-2xl p-4 sm:grid-cols-3">

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Medicine / Supply</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['medicine_name'] ?? '—' }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Expiry Date</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['expiry_date'] ?? '—' }}</p>
                                                </div>

                                                <div>
                                                    <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Quantity</p>
                                                    <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $data['quantity'] ?? '—' }}</p>
                                                </div>

                                                @if (!empty($data['alert_type']))
                                                    <div class="sm:col-span-3">
                                                        <span class="inline-flex items-center rounded-full border border-[#E87928]/20 bg-[#FCF7ED] px-3 py-1 text-xs font-bold text-[#E87928]">
                                                            @switch($data['alert_type'])
                                                                @case('1_month')
                                                                    1 month before expiry
                                                                    @break
                                                                @case('15_days')
                                                                    15 days before expiry
                                                                    @break
                                                                @case('7_days')
                                                                    7 days before expiry
                                                                    @break
                                                                @case('expiry')
                                                                    Expires today
                                                                    @break
                                                                @default
                                                                    Expiry alert
                                                            @endswitch
                                                        </span>
                                                    </div>
                                                @endif

                                            </div>

                                        @endif

                                        {{-- ACTIONS --}}
                                        <div class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                            <p class="text-xs text-[#9AA9A4]">
                                                {{ $notification->created_at?->format('F j, Y • g:i A') }}
                                            </p>

                                            <div class="flex flex-wrap items-center gap-2">
                                                <button
                                                    type="button"
                                                    class="clay-action clay-view"
                                                    data-notification-view
                                                    aria-expanded="false"
                                                    aria-controls="notification-details-{{ $notification->id }}"
                                                >
                                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.5-6 9.75-6 9.75 6 9.75 6-3.5 6-9.75 6-9.75-6-9.75-6Z" />
                                                        <circle cx="12" cy="12" r="2.5" />
                                                    </svg>
                                                    View
                                                </button>

                                                @if ($isUnread)
                                                    <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                                        @csrf
                                                        <button
                                                            type="submit"
                                                            class="clay-action clay-view"
                                                        >
                                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                            Mark as read
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 text-xs font-medium text-[#9AA9A4]">
                                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                        Already read
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div
                                            id="notification-details-{{ $notification->id }}"
                                            class="clay-inset mt-4 hidden rounded-2xl p-4"
                                            data-notification-details
                                        >
                                            <h5 class="text-sm font-bold text-[#164238]">
                                                {{ $data['title'] ?? 'Notification' }}
                                            </h5>
                                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-[#385C52]">
                                                {{ $data['message'] ?? 'You have a new notification.' }}
                                            </p>
                                            <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                                                <div>
                                                    <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Type</dt>
                                                    <dd class="mt-1 font-semibold text-[#234E43]">{{ $type }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Read status</dt>
                                                    <dd class="mt-1 font-semibold text-[#234E43]">{{ $isUnread ? 'Unread' : 'Read' }}</dd>
                                                </div>
                                                <div>
                                                    <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Received</dt>
                                                    <dd class="mt-1 font-semibold text-[#234E43]">
                                                        {{ $notification->created_at?->format('F j, Y g:i A') ?? '—' }}
                                                    </dd>
                                                </div>
                                                @if (! empty($data['event_id']) || ! empty($data['record_id']))
                                                    <div>
                                                        <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Related record</dt>
                                                        <dd class="mt-1 font-semibold text-[#234E43]">
                                                            {{ $data['event_id'] ?? $data['record_id'] }}
                                                        </dd>
                                                    </div>
                                                @endif
                                            </dl>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @endforeach

                    </div>

                    {{-- PAGINATION --}}
                    @if ($notifications->hasPages())
                        <div class="border-t border-white/70 px-5 py-4 sm:px-6">
                            {{ $notifications->links() }}
                        </div>
                    @endif

                @else

                    {{-- EMPTY STATE --}}
                    <div class="px-6 py-16 text-center">
                        <div class="clay-icon clay-icon-green mx-auto h-16 w-16 rounded-2xl">
                            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-base font-bold text-[#164238]">No notifications yet</h3>
                        <p class="mx-auto mt-1 max-w-md text-xs text-[#6D817A]">
                            You don't have any system notifications at the moment.
                            Schedule reminders and medical inventory alerts will appear here.
                        </p>
                    </div>

                @endif

            </section>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-notification-view]').forEach((button) => {
                button.addEventListener('click', () => {
                    const details = document.getElementById(button.getAttribute('aria-controls'));
                    const isExpanded = button.getAttribute('aria-expanded') === 'true';

                    details.classList.toggle('hidden', isExpanded);
                    button.setAttribute('aria-expanded', String(!isExpanded));
                });
            });

            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (menuButton && overlay && sidebar) {
                menuButton.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
        });
    </script>
</body>
</html>