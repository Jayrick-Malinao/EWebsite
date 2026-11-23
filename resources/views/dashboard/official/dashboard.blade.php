<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Official Dashboard | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Barangay Official dashboard for community monitoring and health center coordination."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="clay-dashboard min-h-screen bg-[#EEF5F1] text-[#164238]">

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Content --}}
    <div class="min-h-screen lg:pl-72">

        <main class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-7 lg:py-6">

            {{-- Page Header --}}
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-center gap-3">

                    @include('dashboard.mobile-menu-button', ['sidebarId' => 'officialSidebar'])

                    <div class="min-w-0">
                        <p class="text-xs font-medium uppercase tracking-wide text-[#168B70]">
                            Barangay Official
                        </p>

                        <h1 class="mt-1 text-xl font-bold tracking-tight text-[#164238] sm:text-2xl">
                            Welcome back, {{ auth()->user()->name }}
                        </h1>

                        <p class="mt-1 text-xs text-[#6D817A] sm:text-sm">
                            Monitor barangay residents, households, schedules, and health center activities.
                        </p>
                    </div>

                </div>

                <div class="flex items-center gap-2 sm:gap-3">

                    @include('partials.notification-bell')

                    <div class="hidden rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm sm:block">
                        <p class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            Today
                        </p>
                        <p class="mt-0.5 text-sm font-semibold text-[#164238]">
                            {{ now()->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2 rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2.5">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-50"></span>
                            <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-[#0F6F5A]">
                            System Online
                        </span>
                    </div>

                </div>

            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

                {{-- Residents --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">Total</span>
                    </div>
                    <p class="mt-3 text-2xl font-bold text-[#164238]">{{ number_format($totalResidents ?? 0) }}</p>
                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">Residents</p>
                    <p class="mt-3 text-xs text-slate-500">Registered community residents</p>
                </div>

                {{-- Households --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 21V8l7-4 7 4v13"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-5h6v5"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">Total</span>
                    </div>
                    <p class="mt-3 text-2xl font-bold text-[#164238]">{{ number_format($totalHouseholds ?? 0) }}</p>
                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">Households</p>
                    <p class="mt-3 text-xs text-slate-500">Registered households</p>
                </div>

                {{-- Upcoming Events --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <rect width="18" height="18" x="3" y="4" rx="2"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">Upcoming</span>
                    </div>
                    <p class="mt-3 text-2xl font-bold text-[#164238]">{{ number_format($upcomingEventsCount ?? 0) }}</p>
                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">Upcoming Events</p>
                    <p class="mt-3 text-xs text-slate-500">Scheduled activities</p>
                </div>

                {{-- Announcements --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-purple-50 text-purple-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5a2.5 2.5 0 0 1 2.5-2.5H9l6-4v13l-6-4H5.5A2.5 2.5 0 0 1 3 11.5Z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9a4 4 0 0 1 0 5"/>
                            </svg>
                        </div>
                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">Total</span>
                    </div>
                    <p class="mt-3 text-2xl font-bold text-[#164238]">{{ number_format($announcementCount ?? 0) }}</p>
                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">Announcements</p>
                    <p class="mt-3 text-xs text-slate-500">Published announcements</p>
                </div>
            </div>

            {{-- Main Dashboard Grid --}}
            <div class="mt-6 grid gap-6 xl:grid-cols-3">

                {{-- Upcoming Schedule --}}
                <section class="rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">

                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div>
                            <h2 class="font-semibold text-slate-900">
                                Upcoming Schedule
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Community and health center activities
                            </p>
                        </div>

                        <a
                            href="{{ route('schedule.index') }}"
                            class="text-sm font-semibold text-emerald-700 hover:text-emerald-800"
                        >
                            View all
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">

                        @forelse ($upcomingEvents ?? [] as $event)

                            <div class="flex items-center gap-4 px-5 py-4">

                                <div class="flex h-12 w-12 shrink-0 flex-col items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                                    <span class="text-[10px] font-semibold uppercase">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M') }}
                                    </span>

                                    <span class="text-lg font-bold leading-none">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('d') }}
                                    </span>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-slate-900">
                                        {{ $event->title }}
                                    </p>

                                    <p class="mt-1 truncate text-xs text-slate-500">
                                        {{ $event->event_type }}
                                        @if ($event->location)
                                            • {{ $event->location }}
                                        @endif
                                    </p>
                                </div>

                                <div class="hidden text-right sm:block">
                                    <p class="text-xs font-medium text-slate-600">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                    </p>

                                    @if ($event->start_time)
                                        <p class="mt-1 text-xs text-slate-400">
                                            {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                        </p>
                                    @endif
                                </div>
                            </div>

                        @empty

                            <div class="px-5 py-10 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <rect width="18" height="18" x="3" y="4" rx="2"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
                                    </svg>
                                </div>

                                <p class="mt-3 text-sm font-medium text-slate-700">
                                    No upcoming events
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    There are no scheduled activities at the moment.
                                </p>
                            </div>

                        @endforelse

                    </div>
                </section>

                {{-- Recent Residents --}}
                <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div>
                            <h2 class="font-semibold text-slate-900">
                                Recent Residents
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Recently registered residents
                            </p>
                        </div>

                        <a
                            href="{{ route('residents.index') }}"
                            class="text-sm font-semibold text-emerald-700 hover:text-emerald-800"
                        >
                            View all
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100">

                        @forelse ($recentResidents ?? [] as $resident)

                            <div class="flex items-center gap-3 px-5 py-4">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-xs font-bold text-emerald-700">
                                    {{ strtoupper(substr($resident->first_name ?? 'R', 0, 1)) }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-semibold text-slate-800">
                                        {{ $resident->full_name ?? trim(($resident->first_name ?? '') . ' ' . ($resident->last_name ?? '')) }}
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-500">
                                        {{ $resident->created_at?->format('M d, Y') ?? 'Recently added' }}
                                    </p>
                                </div>

                            </div>

                        @empty

                            <div class="px-5 py-10 text-center">
                                <p class="text-sm font-medium text-slate-700">
                                    No residents found
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Registered residents will appear here.
                                </p>
                            </div>

                        @endforelse

                    </div>
                </section>
            </div>

            {{-- Announcements --}}
            <section class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h2 class="font-semibold text-slate-900">
                            Community Announcements
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Latest announcements from the health center
                        </p>
                    </div>

                    <a
                        href="{{ route('announcements.index') }}"
                        class="text-sm font-semibold text-emerald-700 hover:text-emerald-800"
                    >
                        View all
                    </a>
                </div>

                <div class="grid gap-4 p-5 md:grid-cols-2 lg:grid-cols-3">

                    @forelse ($announcements ?? [] as $announcement)

                        <article class="rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50/30">

                            <div class="mb-3 flex items-center justify-between gap-3">
                                <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700">
                                    Announcement
                                </span>

                                @if ($announcement->created_at)
                                    <span class="text-[11px] text-slate-400">
                                        {{ $announcement->created_at->format('M d, Y') }}
                                    </span>
                                @endif
                            </div>

                            <h3 class="line-clamp-2 text-sm font-semibold text-slate-900">
                                {{ $announcement->title }}
                            </h3>

                            <p class="mt-2 line-clamp-3 text-xs leading-5 text-slate-500">
                                {{ $announcement->content ?? $announcement->description ?? 'No announcement details available.' }}
                            </p>
                        </article>

                    @empty

                        <div class="md:col-span-2 lg:col-span-3 rounded-xl border border-dashed border-slate-200 px-5 py-8 text-center">
                            <p class="text-sm font-medium text-slate-700">
                                No announcements available
                            </p>

                            <p class="mt-1 text-xs text-slate-500">
                                Published announcements will appear here.
                            </p>
                        </div>

                    @endforelse

                </div>
            </section>

            {{-- Shared Database Notice --}}
            <section class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                    <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M3 12h18"/>
                            <circle cx="12" cy="12" r="9"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="text-sm font-semibold text-emerald-900">
                            Shared Health Center Database
                        </h2>

                        <p class="mt-1 text-xs leading-5 text-emerald-800/80">
                            Community information is shared across authorized system roles.
                            Updates made by health center personnel are reflected in the same
                            central database used for barangay monitoring.
                        </p>
                    </div>

                </div>
            </section>

            {{-- Footer --}}
            <footer class="mt-8 border-t border-slate-200 pt-5 text-center text-xs text-slate-400">
                Barangay Esperanza Health Center • Community Monitoring System
            </footer>

        </main>
    </div>

</body>

</html>
