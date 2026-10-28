<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Health Worker Dashboard | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Health Worker dashboard for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="clay-dashboard min-h-screen bg-[#EEF5F1] text-[#164238]">

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}
    @include('dashboard.sidebar')


    {{-- =========================================================
         MOBILE OVERLAY
    ========================================================== --}}
    <div
        id="sidebarOverlay"
        class="fixed inset-0 z-40 hidden bg-slate-900/40 lg:hidden"
    ></div>


    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <main class="min-h-screen w-full lg:pl-72">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-7 lg:py-6">


            {{-- =================================================
                 PAGE HEADER
            ================================================== --}}
            <section class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div class="flex min-w-0 items-center gap-3">

                    <button
                        id="sidebarOpen"
                        type="button"
                        class="dashboard-menu-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#dce9e2] bg-[#f9fcfa] text-[#0f6f5a] shadow-sm transition hover:border-[#b8d8ca] hover:bg-[#eaf5ef] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#168b70] lg:hidden"
                        aria-label="Open navigation"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            aria-hidden="true"
                        >
                            <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="text-xs font-medium uppercase tracking-wide text-[#168B70]">
                            Health Worker
                        </p>

                        <h1 class="mt-1 text-xl font-bold tracking-tight text-[#164238] sm:text-2xl">
                            Welcome back, {{ auth()->user()->name }}
                        </h1>

                        <p class="mt-1 text-xs text-[#6D817A] sm:text-sm">
                            Manage residents, households, health records, and community health services.
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

            </section>


            {{-- =================================================
                 SUMMARY CARDS
            ================================================== --}}
            <section class="mb-6">

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


                    {{-- Residents --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm font-medium text-slate-500">
                                    Total Residents
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[#0F4C3A]">
                                    {{ number_format($totalResidents) }}
                                </p>

                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">

                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle
                                        cx="9"
                                        cy="8"
                                        r="3"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M16 5.5a3 3 0 0 1 0 5.8"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M18 14c1.8.8 3 2.5 3 4.5"
                                    />
                                </svg>

                            </div>

                        </div>

                        <a
                            href="{{ route('residents.index') }}"
                            class="mt-4 inline-flex text-xs font-semibold text-emerald-700 hover:text-emerald-800"
                        >
                            View residents
                            <span class="ml-1">→</span>
                        </a>

                    </div>


                    {{-- Households --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm font-medium text-slate-500">
                                    Total Households
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[#0F4C3A]">
                                    {{ number_format($totalHouseholds) }}
                                </p>

                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">

                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 20h18"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M5 20V9l7-5 7 5v11"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 20v-6h6v6"
                                    />
                                </svg>

                            </div>

                        </div>

                        <a
                            href="{{ route('households.index') }}"
                            class="mt-4 inline-flex text-xs font-semibold text-emerald-700 hover:text-emerald-800"
                        >
                            View households
                            <span class="ml-1">→</span>
                        </a>

                    </div>


                    {{-- Senior Citizens --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm font-medium text-slate-500">
                                    Senior Citizens
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[#0F4C3A]">
                                    {{ number_format($totalSeniorCitizens) }}
                                </p>

                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600">

                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle
                                        cx="12"
                                        cy="9"
                                        r="4"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M5 21c1-4 3.3-6 7-6s6 2 7 6"
                                    />
                                </svg>

                            </div>

                        </div>

                        <a
                            href="{{ route('senior-citizens.index') }}"
                            class="mt-4 inline-flex text-xs font-semibold text-emerald-700 hover:text-emerald-800"
                        >
                            View senior citizens
                            <span class="ml-1">→</span>
                        </a>

                    </div>


                    {{-- Health Services --}}
                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="text-sm font-medium text-slate-500">
                                    Health Services
                                </p>

                                <p class="mt-2 text-3xl font-bold text-[#0F4C3A]">
                                    4
                                </p>

                            </div>

                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-purple-700">

                                <svg
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21s-7-4.35-9.5-9.1C.7 8.3 3.1 4.5 7 4.5c2.1 0 4 1.15 5 2.9 1-1.75 2.9-2.9 5-2.9 3.9 0 6.3 3.8 4.5 7.4C19 16.65 12 21 12 21Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M12 8v7M8.5 11.5h7"
                                    />
                                </svg>

                            </div>

                        </div>

                        <p class="mt-4 text-xs text-slate-500">
                            Immunization, maternal, child, and senior care
                        </p>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 MAIN GRID
            ================================================== --}}
            <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">


                {{-- =============================================
                     RECENT RESIDENTS
                ============================================== --}}
                <div class="xl:col-span-2 rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">

                        <div>
                            <h2 class="text-base font-bold text-[#0F4C3A]">
                                Recently Added Residents
                            </h2>

                            <p class="mt-1 text-xs text-slate-500">
                                Latest residents registered in the health center system.
                            </p>
                        </div>

                        <a
                            href="{{ route('residents.index') }}"
                            class="text-xs font-semibold text-emerald-700 hover:text-emerald-800"
                        >
                            View all
                        </a>

                    </div>


                    <div class="divide-y divide-slate-100">

                        @forelse ($recentResidents as $resident)

                            <div class="flex items-center justify-between gap-4 px-5 py-4">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700">
                                        {{ strtoupper(substr($resident->first_name ?? 'R', 0, 1)) }}
                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-slate-800">
                                            {{ $resident->full_name }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-slate-500">
                                            {{ $resident->gender ?? '—' }}
                                            @if ($resident->birth_date)
                                                • {{ \Carbon\Carbon::parse($resident->birth_date)->age }} years old
                                            @endif
                                        </p>

                                    </div>

                                </div>

                                <div class="shrink-0 text-right">

                                    <p class="text-xs font-medium text-slate-500">
                                        Registered
                                    </p>

                                    <p class="mt-0.5 text-xs text-slate-400">
                                        {{ $resident->created_at?->format('M d, Y') ?? '—' }}
                                    </p>

                                </div>

                            </div>

                        @empty

                            <div class="px-5 py-10 text-center">

                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">

                                    <svg
                                        class="h-6 w-6"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                    >
                                        <circle
                                            cx="9"
                                            cy="8"
                                            r="3"
                                        />

                                        <path
                                            stroke-linecap="round"
                                            d="M3 20c0-3.3 2.7-6 6-6"
                                        />
                                    </svg>

                                </div>

                                <p class="mt-3 text-sm font-semibold text-slate-700">
                                    No residents yet
                                </p>

                                <p class="mt-1 text-xs text-slate-500">
                                    Registered residents will appear here.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- =============================================
                     QUICK ACTIONS
                ============================================== --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="border-b border-slate-100 px-5 py-4">

                        <h2 class="text-base font-bold text-[#0F4C3A]">
                            Quick Actions
                        </h2>

                        <p class="mt-1 text-xs text-slate-500">
                            Common health worker tasks.
                        </p>

                    </div>


                    <div class="grid grid-cols-2 gap-3 p-5">


                        {{-- Add Resident --}}
                        <a
                            href="{{ route('residents.create') }}"
                            class="group rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50"
                        >
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100 text-emerald-700">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle
                                        cx="9"
                                        cy="8"
                                        r="3"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M3 20c0-3.3 2.7-6 6-6"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M18 13v7M14.5 16.5h7"
                                    />
                                </svg>

                            </div>

                            <p class="mt-3 text-xs font-bold text-slate-700 group-hover:text-emerald-700">
                                Add Resident
                            </p>

                        </a>


                        {{-- Health Visit --}}
                        <a
                            href="{{ route('health-visits.create') }}"
                            class="group rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50"
                        >
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100 text-blue-700">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        d="M12 5v14M5 12h14"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                    />
                                </svg>

                            </div>

                            <p class="mt-3 text-xs font-bold text-slate-700 group-hover:text-emerald-700">
                                Record Visit
                            </p>

                        </a>


                        {{-- Immunization --}}
                        <a
                            href="{{ route('immunizations.index') }}"
                            class="group rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50"
                        >
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100 text-purple-700">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 3v18M5 8h14M5 16h14"
                                    />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="9"
                                    />
                                </svg>

                            </div>

                            <p class="mt-3 text-xs font-bold text-slate-700 group-hover:text-emerald-700">
                                Immunization
                            </p>

                        </a>


                        {{-- Schedule --}}
                        <a
                            href="{{ route('schedule.index') }}"
                            class="group rounded-xl border border-slate-200 p-4 transition hover:border-emerald-200 hover:bg-emerald-50"
                        >
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100 text-orange-600">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect
                                        x="3"
                                        y="4"
                                        width="18"
                                        height="17"
                                        rx="2"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M16 2v4M8 2v4M3 9h18"
                                    />

                                </svg>

                            </div>

                            <p class="mt-3 text-xs font-bold text-slate-700 group-hover:text-emerald-700">
                                Schedule
                            </p>

                        </a>


                    </div>

                </div>

            </section>


            {{-- =================================================
                 HEALTH PROGRAMS
            ================================================== --}}
            <section class="mt-6">

                <div class="mb-4">

                    <h2 class="text-base font-bold text-[#0F4C3A]">
                        Health Programs
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Access the main community health programs.
                    </p>

                </div>


                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">


                    {{-- Immunization --}}
                    <a
                        href="{{ route('immunizations.index') }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-purple-700">

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 3v18M5 8h14M5 16h14"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-bold text-slate-800 group-hover:text-emerald-700">
                            Immunization
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Manage immunization records and services.
                        </p>

                    </a>


                    {{-- Maternal Care --}}
                    <a
                        href="{{ route('maternal-care.index') }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-pink-50 text-pink-600">

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="8"
                                    r="3"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 21c1-4.3 3.3-6.5 7-6.5s6 2.2 7 6.5"
                                />

                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-bold text-slate-800 group-hover:text-emerald-700">
                            Maternal Care
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Monitor maternal and prenatal health services.
                        </p>

                    </a>


                    {{-- Child Health --}}
                    <a
                        href="{{ route('child-health.index') }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-700">

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="8"
                                    r="3"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 21c.8-4.3 3.1-6.5 7-6.5s6.2 2.2 7 6.5"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M19 5v4M17 7h4"
                                />

                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-bold text-slate-800 group-hover:text-emerald-700">
                            Child Health
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Monitor child health and development records.
                        </p>

                    </a>


                    {{-- Senior Citizens --}}
                    <a
                        href="{{ route('senior-citizens.index') }}"
                        class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-emerald-200 hover:shadow-md"
                    >

                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600">

                            <svg
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="9"
                                    r="4"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M5 21c1-4 3.3-6 7-6s6 2 7 6"
                                />

                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-bold text-slate-800 group-hover:text-emerald-700">
                            Senior Citizens
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-slate-500">
                            Manage senior citizen program records.
                        </p>

                    </a>

                </div>

            </section>


            {{-- =================================================
                 SYSTEM INFORMATION
            ================================================== --}}
            <section class="mt-6">

                <div class="rounded-2xl border border-emerald-100 bg-emerald-50/70 p-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-start gap-3">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-white text-emerald-700 shadow-sm">

                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 21s-7-4.35-9.5-9.1C.7 8.3 3.1 4.5 7 4.5c2.1 0 4 1.15 5 2.9 1-1.75 2.9-2.9 5-2.9 3.9 0 6.3 3.8 4.5 7.4C19 16.65 12 21 12 21Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        d="M12 8v7M8.5 11.5h7"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="text-sm font-bold text-[#0F4C3A]">
                                    Health Center Information
                                </h2>

                                <p class="mt-1 max-w-2xl text-xs leading-5 text-slate-600">
                                    Health Worker activities are connected to the same
                                    Barangay Esperanza Health Center database used by
                                    the System Administrator and Barangay Official.
                                </p>

                            </div>

                        </div>

                        <div class="flex items-center gap-2">

                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>

                            <span class="text-xs font-semibold text-emerald-700">
                                Shared Database Active
                            </span>

                        </div>

                    </div>

                </div>

            </section>


            {{-- =================================================
                 FOOTER
            ================================================== --}}
            <footer class="mt-8 border-t border-slate-200 pt-5">

                <div class="flex flex-col gap-2 text-xs text-slate-400 sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        Barangay Esperanza Health Center
                    </p>

                    <p>
                        Health Center Records Management System
                    </p>

                </div>

            </footer>

        </div>

    </main>


    {{-- =========================================================
         MOBILE SIDEBAR SCRIPT
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.getElementById('healthworkerSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openButton = document.getElementById('sidebarOpen');

            if (!sidebar || !overlay || !openButton) {
                return;
            }

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            openButton.addEventListener('click', openSidebar);

            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });

        });
    </script>

</body>

</html>