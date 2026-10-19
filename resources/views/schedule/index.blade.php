<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Schedule | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Health center schedule and community events calendar."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           SCHEDULE & CALENDAR
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

        /* ---------- Header ---------- */
        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 0 5px 18px rgba(107, 134, 124, 0.08), 0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-mobile-button {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark);
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition: transform 0.18s ease, box-shadow 0.18s ease, color 0.18s ease;
        }
        .clay-mobile-button:hover { transform: translateY(-1px); color: var(--primary); }

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

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.94);
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }
        .clay-secondary:hover { transform: translateY(-1px); background: linear-gradient(145deg, #FFFFFF, #EEF6F2); }

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

        .clay-edit { background: linear-gradient(145deg, #EDF8F2, #DDEFE6); color: #216B53 !important; border-color: rgba(18, 140, 90, 0.13); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.11), -3px -3px 7px rgba(255, 255, 255, 0.88); }
        .clay-delete { background: linear-gradient(145deg, #FCEFED, #F5E2E0); color: var(--danger) !important; border-color: rgba(180, 35, 35, 0.14); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.84); }

        /* ---------- Modal ---------- */
        .clay-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 1rem;
            background: rgba(22, 66, 56, 0.34);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        .clay-confirm-overlay.is-open { display: flex; }

        .clay-confirm-box {
            width: min(100%, 480px);
            border-radius: 24px;
            padding: 1.5rem;
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 14px 14px 30px rgba(57, 85, 75, 0.24), -12px -12px 28px rgba(255, 255, 255, 0.94);
        }

        /* ---------- Calendar Custom Styles ---------- */
        .clay-calendar-cell {
            min-height: 110px;
            background: rgba(255, 255, 255, 0.45);
            border-bottom: 1px solid rgba(210, 225, 218, 0.5);
            border-right: 1px solid rgba(210, 225, 218, 0.5);
            transition: background 0.18s ease;
        }
        .clay-calendar-cell:hover { background: rgba(255, 255, 255, 0.85); }
        .clay-calendar-cell-other {
            min-height: 110px;
            background: rgba(237, 245, 240, 0.4);
            border-bottom: 1px solid rgba(210, 225, 218, 0.3);
            border-right: 1px solid rgba(210, 225, 218, 0.3);
        }

        .clay-badge-event {
            background: linear-gradient(145deg, #E7F5EE, #D9ECE4);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.82);
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.08), -2px -2px 5px rgba(255, 255, 255, 0.85);
            transition: transform 0.15s ease;
        }
        .clay-badge-event:hover { transform: translateY(-1px); }

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
                        aria-controls="sidebar-overlay"
                        aria-expanded="false"
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
                            Schedule
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

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Schedule Management</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Health Center Calendar
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Manage health programs, community activities, meetings, immunization schedules, and other important events.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <div class="clay-inset inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold text-[#164238]">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#168B70]"></span>
                        {{ $events->count() }} {{ Str::plural('event', $events->count()) }}
                    </div>

                    <a
                        href="{{ route('schedule.create') }}"
                        class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                        </svg>
                        Add Event
                    </a>
                </div>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="clay-card mb-6 rounded-2xl border-l-4 border-l-[#168B70] p-4 text-sm text-[#0F6F5A]">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-8 w-8 rounded-xl">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </div>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- CALENDAR + UPCOMING EVENTS GRID --}}
            <section class="grid gap-6 xl:grid-cols-[minmax(0,1fr)_360px]">

                {{-- CALENDAR CARD --}}
                <div class="clay-card overflow-hidden">

                    <div class="flex flex-col gap-4 border-b border-white/70 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="clay-category text-xs font-bold uppercase tracking-wider">Calendar</p>
                            <h3 id="calendarTitle" class="mt-1 text-xl font-bold text-[#164238]"></h3>
                        </div>

                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                id="previousMonth"
                                class="clay-secondary flex h-9 w-9 items-center justify-center rounded-xl"
                                aria-label="Previous month"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6" />
                                </svg>
                            </button>

                            <button
                                type="button"
                                id="todayButton"
                                class="clay-secondary rounded-xl px-4 py-2 text-xs font-bold"
                            >
                                Today
                            </button>

                            <button
                                type="button"
                                id="nextMonth"
                                class="clay-secondary flex h-9 w-9 items-center justify-center rounded-xl"
                                aria-label="Next month"
                            >
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 18l6-6-6-6" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Weekdays Header --}}
                    <div class="grid grid-cols-7 border-b border-white/70 bg-[#EDF5F0]/60">
                        @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                            <div class="px-2 py-3 text-center text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                {{ $day }}
                            </div>
                        @endforeach
                    </div>

                    {{-- Calendar Grid --}}
                    <div id="calendarGrid" class="grid grid-cols-7"></div>

                </div>

                {{-- UPCOMING EVENTS SIDEBAR --}}
                <aside class="clay-card overflow-hidden">

                    <div class="border-b border-white/70 p-5">
                        <div class="flex items-center gap-3">
                            <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-[#164238]">Upcoming Events</h3>
                                <p class="text-xs text-[#6D817A]">Scheduled activities and health programs.</p>
                            </div>
                        </div>
                    </div>

                    <div class="divide-y divide-white/60">
                        @forelse ($upcomingEvents as $event)
                            <div class="p-4 transition hover:bg-white/40">
                                <div class="flex gap-3">
                                    <button
                                        type="button"
                                        onclick="showEventDetails({{ $event->id }})"
                                        class="clay-inset flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl transition hover:scale-105"
                                    >
                                        <span class="text-[10px] font-bold uppercase text-[#168B70]">
                                            {{ $event->event_date->format('M') }}
                                        </span>
                                        <span class="text-base font-bold leading-none text-[#164238]">
                                            {{ $event->event_date->format('d') }}
                                        </span>
                                    </button>

                                    <div class="min-w-0 flex-1">
                                        <button
                                            type="button"
                                            onclick="showEventDetails({{ $event->id }})"
                                            class="block w-full text-left"
                                        >
                                            <h4 class="truncate text-sm font-bold text-[#164238]">
                                                {{ $event->title }}
                                            </h4>
                                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                                {{ $event->event_type }}
                                            </p>
                                        </button>

                                        <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-[#6D817A]">
                                            @if ($event->start_time)
                                                <span class="inline-flex items-center gap-1 font-semibold">
                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                                        <circle cx="12" cy="12" r="9" />
                                                        <path stroke-linecap="round" d="M12 7v5l3 2" />
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                                </span>
                                            @endif

                                            @if ($event->location)
                                                <span class="inline-flex max-w-[180px] items-center gap-1 truncate font-semibold">
                                                    <svg class="h-3.5 w-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-6.1 7-12a7 7 0 10-14 0c0 5.9 7 12 7 12z" />
                                                        <circle cx="12" cy="9" r="2" />
                                                    </svg>
                                                    {{ $event->location }}
                                                </span>
                                            @endif
                                        </div>

                                        {{-- Actions --}}
                                        <div class="mt-3 flex items-center gap-2">
                                            <a
                                                href="{{ route('schedule.edit', $event) }}"
                                                class="clay-action clay-edit"
                                            >
                                                Edit
                                            </a>

                                            <button
                                                type="button"
                                                onclick="triggerDeleteModal('{{ route('schedule.destroy', $event) }}', '{{ escape_javascript_string($event->title) }}')"
                                                class="clay-action clay-delete"
                                            >
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <div class="clay-icon clay-icon-green mx-auto h-12 w-12 rounded-2xl">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="4" width="18" height="17" rx="2" />
                                        <path stroke-linecap="round" d="M16 2v4M8 2v4M3 9h18" />
                                    </svg>
                                </div>

                                <p class="mt-3 text-sm font-bold text-[#164238]">
                                    No upcoming events
                                </p>
                                <p class="mt-1 text-xs text-[#6D817A]">
                                    Add an event to start building the schedule.
                                </p>

                                <a
                                    href="{{ route('schedule.create') }}"
                                    class="clay-primary mt-4 inline-flex items-center gap-1.5 rounded-xl px-4 py-2 text-xs font-bold"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" d="M12 5v14M5 12h14" />
                                    </svg>
                                    Add Event
                                </a>
                            </div>
                        @endforelse
                    </div>

                </aside>

            </section>

        </div>
    </main>

    {{-- EVENT DETAILS MODAL --}}
    <div
        id="eventDetailsModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
    >
        <div class="clay-confirm-box" role="document">
            <div class="flex items-start justify-between border-b border-white/70 pb-4">
                <div class="min-w-0 pr-4">
                    <p id="detailsType" class="clay-category text-xs font-bold uppercase tracking-wider"></p>
                    <h2 id="detailsTitle" class="mt-1 text-xl font-bold text-[#164238]"></h2>
                </div>

                <button
                    type="button"
                    onclick="closeEventDetails()"
                    class="clay-secondary flex h-8 w-8 items-center justify-center rounded-xl text-[#6D817A]"
                    aria-label="Close modal"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-3 py-4">
                <div class="grid gap-3 sm:grid-cols-2">
                    <div class="clay-inset rounded-xl p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Date</p>
                        <p id="detailsDate" class="mt-1 text-xs font-bold text-[#164238]"></p>
                    </div>

                    <div class="clay-inset rounded-xl p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Time</p>
                        <p id="detailsTime" class="mt-1 text-xs font-bold text-[#164238]"></p>
                    </div>
                </div>

                <div id="detailsLocationWrapper" class="clay-inset rounded-xl p-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Location</p>
                    <p id="detailsLocation" class="mt-1 text-xs font-bold text-[#164238]"></p>
                </div>

                <div id="detailsDescriptionWrapper" class="clay-inset rounded-xl p-3">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Description</p>
                    <p id="detailsDescription" class="mt-1 whitespace-pre-line text-xs leading-5 text-[#385C52]"></p>
                </div>
            </div>

            <div class="mt-2 flex flex-col gap-2 pt-2 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    onclick="closeEventDetails()"
                    class="clay-secondary inline-flex min-h-[42px] items-center justify-center rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    Close
                </button>

                <a
                    id="detailsEditButton"
                    href="#"
                    class="clay-primary inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    Edit Event
                </a>
            </div>
        </div>
    </div>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div
        id="deleteScheduleModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
    >
        <div class="clay-confirm-box" role="document">
            <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCEFED] text-[#B42323]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14a2 2 0 0 0 1.73 3h16.32a2 2 0 0 0 1.73-3l-8.18-14a2 2 0 0 0-3.42 0Z" />
                </svg>
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-bold text-[#164238]">Delete Scheduled Event?</h2>
                <p class="mt-2 text-sm leading-6 text-[#6D817A]">
                    This action will permanently delete the event from the health center schedule.
                </p>
            </div>

            <div class="clay-inset mt-4 rounded-xl p-4">
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Event Title</p>
                <p id="deleteEventTitle" class="mt-1 break-words text-sm font-bold text-[#164238]">—</p>
            </div>

            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    id="deleteScheduleCancel"
                    class="clay-secondary inline-flex min-h-[42px] items-center justify-center rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    Cancel
                </button>

                <form id="deleteScheduleForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button
                        type="submit"
                        class="clay-primary inline-flex min-h-[42px] w-full sm:w-auto items-center justify-center gap-2 rounded-xl !bg-gradient-to-r !from-[#DC2626] !to-[#B42323] px-4 py-2.5 text-sm font-bold"
                    >
                        Delete Event
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- PHP DATA MAP --}}
    @php
        function escape_javascript_string($string) {
            return str_replace(["\\", "'", "\"", "\r", "\n"], ["\\\\", "\\'", "\\\"", "", ""], $string);
        }

        $calendarEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'event_type' => $event->event_type,
                'event_date' => $event->event_date->format('Y-m-d'),
                'start_time' => $event->start_time
                    ? \Carbon\Carbon::parse($event->start_time)->format('H:i')
                    : null,
                'end_time' => $event->end_time
                    ? \Carbon\Carbon::parse($event->end_time)->format('H:i')
                    : null,
                'location' => $event->location,
                'description' => $event->description,
            ];
        })->values();
    @endphp

    {{-- SCRIPTS --}}
    <script>
        const events = @json($calendarEvents);
        let currentDate = new Date();

        const calendarTitle = document.getElementById('calendarTitle');
        const calendarGrid = document.getElementById('calendarGrid');

        const monthFormatter = new Intl.DateTimeFormat('en-US', { month: 'long', year: 'numeric' });
        const fullDateFormatter = new Intl.DateTimeFormat('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        const timeFormatter = new Intl.DateTimeFormat('en-US', { hour: 'numeric', minute: '2-digit' });

        function escapeHtml(value) {
            if (!value) return '';
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function formatTime(time) {
            if (!time) return '';
            const parts = time.split(':');
            const date = new Date();
            date.setHours(Number(parts[0]), Number(parts[1]), 0, 0);
            return timeFormatter.format(date);
        }

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            calendarTitle.textContent = monthFormatter.format(currentDate);

            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const previousMonthLastDay = new Date(year, month, 0);

            const firstWeekday = firstDay.getDay();
            const daysInMonth = lastDay.getDate();
            const previousMonthDays = previousMonthLastDay.getDate();

            calendarGrid.innerHTML = '';

            /* Previous month padding */
            for (let i = firstWeekday - 1; i >= 0; i--) {
                const day = previousMonthDays - i;
                const cell = document.createElement('div');
                cell.className = 'clay-calendar-cell-other p-2';
                cell.innerHTML = `<div class="text-xs font-semibold text-[#9AA9A4]">${day}</div>`;
                calendarGrid.appendChild(cell);
            }

            /* Current month days */
            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month, day);
                const dateString = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
                const dayEvents = events.filter(e => e.event_date === dateString);
                const today = new Date();
                const isToday = date.toDateString() === today.toDateString();

                const cell = document.createElement('div');
                cell.className = 'clay-calendar-cell p-2';

                let eventsHtml = '';
                dayEvents.slice(0, 3).forEach(event => {
                    eventsHtml += `
                        <button
                            type="button"
                            onclick="showEventDetails(${event.id})"
                            class="clay-badge-event mt-1.5 block w-full truncate rounded-lg px-2 py-1 text-left text-[10px] font-bold"
                            title="${escapeHtml(event.title)}"
                        >
                            ${escapeHtml(event.title)}
                        </button>
                    `;
                });

                if (dayEvents.length > 3) {
                    eventsHtml += `<div class="mt-1 px-1 text-[10px] font-bold text-[#6D817A]">+${dayEvents.length - 3} more</div>`;
                }

                const dayNumberClass = isToday
                    ? 'flex h-7 w-7 items-center justify-center rounded-xl bg-gradient-to-r from-[#168B70] to-[#0F6F5A] text-xs font-bold text-white shadow-sm'
                    : 'text-xs font-bold text-[#164238]';

                const eventIndicator = dayEvents.length
                    ? '<span class="h-2 w-2 rounded-full bg-[#E87928]"></span>'
                    : '';

                cell.innerHTML = `
                    <div class="flex items-center justify-between">
                        <span class="${dayNumberClass}">${day}</span>
                        ${eventIndicator}
                    </div>
                    <div class="mt-1">${eventsHtml}</div>
                `;

                calendarGrid.appendChild(cell);
            }

            /* Next month padding */
            const totalCells = firstWeekday + daysInMonth;
            const remainingCells = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);

            for (let day = 1; day <= remainingCells; day++) {
                const cell = document.createElement('div');
                cell.className = 'clay-calendar-cell-other p-2';
                cell.innerHTML = `<div class="text-xs font-semibold text-[#9AA9A4]">${day}</div>`;
                calendarGrid.appendChild(cell);
            }
        }

        /* Calendar Nav Controls */
        document.getElementById('previousMonth')?.addEventListener('click', () => {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
            renderCalendar();
        });

        document.getElementById('nextMonth')?.addEventListener('click', () => {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
            renderCalendar();
        });

        document.getElementById('todayButton')?.addEventListener('click', () => {
            currentDate = new Date();
            renderCalendar();
        });

        /* Show Details Modal */
        function showEventDetails(eventId) {
            const event = events.find(item => Number(item.id) === Number(eventId));
            if (!event) return;

            document.getElementById('detailsType').textContent = event.event_type;
            document.getElementById('detailsTitle').textContent = event.title;

            const eventDate = new Date(event.event_date + 'T00:00:00');
            document.getElementById('detailsDate').textContent = fullDateFormatter.format(eventDate);

            let timeText = 'All day';
            if (event.start_time && event.end_time) {
                timeText = formatTime(event.start_time) + ' – ' + formatTime(event.end_time);
            } else if (event.start_time) {
                timeText = formatTime(event.start_time);
            }
            document.getElementById('detailsTime').textContent = timeText;

            const locWrap = document.getElementById('detailsLocationWrapper');
            if (event.location) {
                locWrap.classList.remove('hidden');
                document.getElementById('detailsLocation').textContent = event.location;
            } else {
                locWrap.classList.add('hidden');
            }

            const descWrap = document.getElementById('detailsDescriptionWrapper');
            if (event.description) {
                descWrap.classList.remove('hidden');
                document.getElementById('detailsDescription').textContent = event.description;
            } else {
                descWrap.classList.add('hidden');
            }

            document.getElementById('detailsEditButton').href = '{{ url('/schedule') }}/' + event.id + '/edit';
            document.getElementById('eventDetailsModal').classList.add('is-open');
        }

        function closeEventDetails() {
            document.getElementById('eventDetailsModal').classList.remove('is-open');
        }

        /* Trigger Delete Modal */
        function triggerDeleteModal(actionUrl, title) {
            const modal = document.getElementById('deleteScheduleModal');
            document.getElementById('deleteScheduleForm').action = actionUrl;
            document.getElementById('deleteEventTitle').textContent = title;
            modal.classList.add('is-open');
        }

        document.addEventListener('DOMContentLoaded', () => {
            /* Sidebar Toggle */
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

            /* Delete Modal Cancel */
            const cancelDeleteBtn = document.getElementById('deleteScheduleCancel');
            if (cancelDeleteBtn) {
                cancelDeleteBtn.addEventListener('click', () => {
                    document.getElementById('deleteScheduleModal').classList.remove('is-open');
                });
            }

            renderCalendar();
        });
    </script>
</body>
</html>