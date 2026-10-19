<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>System Administrator Dashboard | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="System Administrator Dashboard for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* =========================================================
           GOVERNMENT-STYLE CLAYMORPHISM
           Frontend only.

           Backend variables, routes, authentication, queries,
           forms, chart data and dashboard structure are unchanged.
        ========================================================== */

        .clay-dashboard {
            --gov-primary: #168B70;
            --gov-primary-dark: #0F6F5A;
            --gov-primary-light: #2A9B80;

            --gov-bg: #EEF5F1;
            --gov-surface: #F5FAF7;
            --gov-surface-soft: #EDF5F0;

            --gov-text: #164238;
            --gov-muted: #6D817A;
            --gov-placeholder: #9AA9A4;

            --gov-orange: #E87928;
            --gov-danger: #DC2626;
            --gov-warning: #B7791F;

            --gov-highlight: rgba(255, 255, 255, 0.94);
            --gov-shadow: rgba(107, 134, 124, 0.24);

            min-height: 100vh;

            font-family: Arial, Helvetica, sans-serif !important;

            color: var(--gov-text);

            background:
                radial-gradient(
                    circle at 10% 5%,
                    rgba(255, 255, 255, 0.68),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 90% 12%,
                    rgba(42, 155, 128, 0.07),
                    transparent 24%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1 0%,
                    #F5FAF7 52%,
                    #EDF5F0 100%
                );
        }

        .clay-dashboard main {
            background: transparent;
        }

        /* =========================================================
           GLOBAL TYPOGRAPHY
        ========================================================== */

        .clay-dashboard,
        .clay-dashboard button,
        .clay-dashboard input,
        .clay-dashboard select,
        .clay-dashboard textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-dashboard h1,
        .clay-dashboard h2,
        .clay-dashboard h3 {
            color: var(--gov-text);
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-dashboard .text-slate-900 {
            color: #164238 !important;
        }

        .clay-dashboard .text-slate-800 {
            color: #234E43 !important;
        }

        .clay-dashboard .text-slate-700 {
            color: #385C52 !important;
        }

        .clay-dashboard .text-slate-600 {
            color: #557067 !important;
        }

        .clay-dashboard .text-slate-500 {
            color: #6D817A !important;
        }

        .clay-dashboard .text-slate-400 {
            color: #9AA9A4 !important;
        }

        /* =========================================================
           MAIN CONTENT HEADER
        ========================================================== */

        .clay-dashboard main > .mx-auto {
            position: relative;
            z-index: 1;
        }

        .clay-dashboard main > .mx-auto::before {
            content: "";
            position: absolute;
            top: -60px;
            right: 2%;
            width: 170px;
            height: 170px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.24);
            pointer-events: none;
        }

        .clay-dashboard h1 {
            text-shadow:
                0 1px 0 rgba(255, 255, 255, 0.88);
        }

        /* =========================================================
           HEADER DATE CARD
        ========================================================== */

        .clay-dashboard .rounded-xl.border.px-4.py-2\.5 {
            background: var(--gov-surface) !important;

            border: 1px solid rgba(255, 255, 255, 0.76) !important;

            border-radius: 16px !important;

            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.18),
                -5px -5px 11px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.70);
        }

        /* =========================================================
           SYSTEM ONLINE STATUS
        ========================================================== */

        .clay-dashboard .bg-emerald-50 {
            background: var(--gov-surface-soft) !important;
        }

        .clay-dashboard .border-emerald-100 {
            border-color: rgba(255, 255, 255, 0.76) !important;
        }

        .clay-dashboard .text-emerald-700 {
            color: var(--gov-primary-dark) !important;
        }

        .clay-dashboard .bg-emerald-500 {
            background-color: var(--gov-primary) !important;
        }

        .clay-dashboard .bg-emerald-400 {
            background-color: var(--gov-primary-light) !important;
        }

        .clay-dashboard .rounded-xl.border.px-3.py-2\.5 {
            background: var(--gov-surface-soft) !important;

            border: 1px solid rgba(255, 255, 255, 0.76) !important;

            border-radius: 16px !important;

            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.16),
                -5px -5px 11px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.68);
        }

        /* =========================================================
           MAIN CARDS / PANELS
        ========================================================== */

        .clay-dashboard .rounded-xl.border.bg-white,
        .clay-dashboard .rounded-xl.border.border-slate-200.bg-white {
            position: relative;

            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border: 1px solid rgba(255, 255, 255, 0.82) !important;

            border-radius: 24px !important;

            box-shadow:
                10px 10px 22px var(--gov-shadow),
                -10px -10px 22px var(--gov-highlight),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84) !important;
        }

        /* =========================================================
           KPI CARDS
        ========================================================== */

        .clay-dashboard .grid.grid-cols-2.gap-3 > div.rounded-xl {
            position: relative;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border: 1px solid rgba(255, 255, 255, 0.86) !important;

            border-radius: 22px !important;

            box-shadow:
                8px 8px 18px rgba(107, 134, 124, 0.21),
                -8px -8px 18px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.80) !important;

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-dashboard .grid.grid-cols-2.gap-3 > div.rounded-xl::after {
            content: "";

            position: absolute;

            top: -30px;
            right: -25px;

            width: 90px;
            height: 90px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.25);

            pointer-events: none;
        }

        .clay-dashboard .grid.grid-cols-2.gap-3 > div.rounded-xl:hover {
            transform: translateY(-2px);

            box-shadow:
                10px 10px 23px rgba(107, 134, 124, 0.24),
                -10px -10px 23px rgba(255, 255, 255, 0.95),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84) !important;
        }

        /* =========================================================
           KPI ICON BUBBLES
        ========================================================== */

        .clay-dashboard [class*="flex h-9 w-9"][class*="rounded-lg"],
        .clay-dashboard [class*="flex h-8 w-8"][class*="rounded-lg"] {
            border: 1px solid rgba(255, 255, 255, 0.74);

            box-shadow:
                4px 4px 8px rgba(107, 134, 124, 0.18),
                -4px -4px 8px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-dashboard svg {
            filter:
                drop-shadow(
                    0 1px 0 rgba(255, 255, 255, 0.55)
                );
        }

        /* =========================================================
           GREEN ICONS
        ========================================================== */

        .clay-dashboard .text-\[\#0F4C3A\],
        .clay-dashboard .text-\[\#128C5A\] {
            color: var(--gov-primary-dark) !important;
        }

        .clay-dashboard .text-\[\#168B70\] {
            color: var(--gov-primary) !important;
        }

        /* =========================================================
           BLUE / VIOLET / AMBER ICONS
           Restrained for accessibility and information distinction.
        ========================================================== */

        .clay-dashboard .bg-blue-50 {
            background: #EDF5F0 !important;
        }

        .clay-dashboard .text-blue-700 {
            color: #3E6F62 !important;
        }

        .clay-dashboard .bg-violet-50 {
            background: #EEF5F1 !important;
        }

        .clay-dashboard .text-violet-700 {
            color: #536F66 !important;
        }

        .clay-dashboard .bg-amber-50 {
            background: #F5F3EA !important;
        }

        .clay-dashboard .text-amber-700 {
            color: #8A6A28 !important;
        }

        /* =========================================================
           ORANGE ACCENT
        ========================================================== */

        .clay-dashboard .bg-orange-50 {
            background: #FBF1E8 !important;
        }

        .clay-dashboard .text-\[\#E87928\] {
            color: var(--gov-orange) !important;
        }

        /* =========================================================
           CHART CARDS
        ========================================================== */

        .clay-chart-card {
            position: relative;

            overflow: hidden;

            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                );

            border: 1px solid rgba(255, 255, 255, 0.88);

            border-radius: 26px;

            box-shadow:
                10px 10px 22px rgba(107, 134, 124, 0.22),
                -10px -10px 22px rgba(255, 255, 255, 0.94),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-chart-card::before {
            content: "";

            position: absolute;

            top: -55px;
            right: -50px;

            width: 150px;
            height: 150px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.28);

            pointer-events: none;
        }

        .clay-chart-card .clay-chart-icon {
            border-radius: 14px;

            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #E6EFEA
                );

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.18),
                -5px -5px 10px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.80);
        }

        /* =========================================================
           NESTED SUMMARY CARDS
        ========================================================== */

        .clay-dashboard [class*="rounded-lg"][class*="bg-slate-50"],
        .clay-dashboard [class*="rounded-lg"][class*="bg-white"] {
            background:
                linear-gradient(
                    145deg,
                    #F5FAF7,
                    #E7F0EB
                ) !important;

            border-color: rgba(255, 255, 255, 0.72) !important;

            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.15),
                -5px -5px 11px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           RECENT LISTS
        ========================================================== */

        .clay-dashboard .divide-y > div {
            transition:
                background 0.18s ease,
                transform 0.18s ease;
        }

        .clay-dashboard .divide-y > div:hover {
            background: rgba(255, 255, 255, 0.34);
        }

        .clay-dashboard .divide-slate-100 > :not([hidden]) ~ :not([hidden]) {
            border-color: rgba(210, 225, 218, 0.62) !important;
        }

        /* =========================================================
           QUICK ACTIONS
           Responsive grid: 2 columns (phone), 4 (tablet), 7 (wide).
           Every action card has the same size, icon and label layout.
        ========================================================== */

        .clay-quick-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        @media (min-width: 640px) {
            .clay-quick-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }

        @media (min-width: 1280px) {
            .clay-quick-grid {
                grid-template-columns: repeat(7, minmax(0, 1fr));
            }
        }

        /* Phones: the odd last card spans the full row */
        @media (max-width: 639px) {
            .clay-quick-grid > .clay-quick-action:last-child {
                grid-column: 1 / -1;
            }
        }

        .clay-quick-action {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;

            min-height: 98px;
            padding: 14px 8px;

            text-align: center;
            text-decoration: none;

            border-radius: 20px;

            background:
                linear-gradient(
                    145deg,
                    #F7FBF9,
                    #E8F1EC
                );

            border: 1px solid rgba(255, 255, 255, 0.86);

            box-shadow:
                6px 6px 12px rgba(107, 134, 124, 0.17),
                -6px -6px 12px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-quick-action:hover {
            transform: translateY(-2px);

            box-shadow:
                8px 8px 15px rgba(107, 134, 124, 0.20),
                -8px -8px 15px rgba(255, 255, 255, 0.94),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-quick-action:active {
            transform: translateY(0);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.14),
                inset -3px -3px 7px rgba(255, 255, 255, 0.78);
        }

        .clay-quick-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;

            width: 40px;
            height: 40px;

            border-radius: 14px;

            border: 1px solid rgba(255, 255, 255, 0.78);

            box-shadow:
                4px 4px 8px rgba(107, 134, 124, 0.16),
                -4px -4px 8px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-quick-icon svg {
            display: block;
            width: 20px;
            height: 20px;
        }

        .clay-quick-icon--green {
            background: #E7F3EE;
            color: var(--gov-primary-dark);
        }

        .clay-quick-icon--orange {
            background: #FBF1E8;
            color: var(--gov-orange);
        }

        .clay-quick-label {
            font-size: 12px;
            line-height: 1.3;
            font-weight: 600;
            color: #385C52;
            transition: color 0.18s ease;
        }

        .clay-quick-action:hover .clay-quick-label {
            color: var(--gov-primary-dark);
        }

        /* =========================================================
           STATUS DOTS
        ========================================================== */

        .clay-dashboard .rounded-full.bg-emerald-500 {
            background-color: var(--gov-primary) !important;

            box-shadow:
                0 0 0 4px rgba(22, 139, 112, 0.07),
                0 1px 3px rgba(22, 139, 112, 0.20);
        }

        /* =========================================================
           PROGRESS BARS
        ========================================================== */

        .clay-dashboard .overflow-hidden.rounded-full.bg-slate-200 {
            background: #E1EBE6 !important;

            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, 0.14),
                inset -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        .clay-dashboard .bg-\[\#128C5A\] {
            background-color: var(--gov-primary) !important;
        }

        .clay-dashboard .bg-\[\#0F4C3A\] {
            background-color: var(--gov-primary-dark) !important;
        }

        /* =========================================================
           FOOTER
        ========================================================== */

        .clay-dashboard footer,
        .clay-dashboard .text-center {
            text-shadow:
                0 1px 0 rgba(255, 255, 255, 0.68);
        }

        /* =========================================================
           LINKS
        ========================================================== */

        .clay-dashboard a {
            transition:
                color 0.16s ease,
                transform 0.16s ease;
        }

        .clay-dashboard a.text-\[\#128C5A\] {
            color: var(--gov-primary) !important;
        }

        .clay-dashboard a.text-\[\#128C5A\]:hover {
            color: var(--gov-primary-dark) !important;
        }

        /* =========================================================
           CHART WRAPPERS
        ========================================================== */

        .clay-chart-wrap {
            position: relative;
            height: 255px;
        }

        .clay-doughnut-wrap {
            position: relative;
            height: 245px;
            max-width: 330px;
            margin: 0 auto;
        }

        @media (max-width: 640px) {
            .clay-chart-wrap {
                height: 225px;
            }

            .clay-doughnut-wrap {
                height: 220px;
            }
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================== */

        .clay-dashboard a:focus-visible,
        .clay-dashboard button:focus-visible {
            outline: 2px solid var(--gov-primary);

            outline-offset: 2px;

            box-shadow:
                0 0 0 4px rgba(22, 139, 112, 0.10),
                4px 4px 9px rgba(107, 134, 124, 0.18),
                -4px -4px 9px rgba(255, 255, 255, 0.90);
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {
            .clay-quick-action,
            .clay-quick-label,
            .clay-dashboard .grid.grid-cols-2.gap-3 > div.rounded-xl,
            .clay-dashboard .divide-y > div,
            .clay-dashboard a {
                transition: none !important;
            }
        }
    </style>
</head>

<body class="clay-dashboard min-h-screen bg-[#EEF5F1] text-[#164238]">

    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    @include('dashboard.sidebar')


    {{-- =========================================================
        MAIN CONTENT
    ========================================================== --}}
    <main class="min-h-screen w-full lg:pl-72">

        <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-7 lg:py-6">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                {{-- Page heading --}}
                <div>

                    <p class="text-xs font-medium uppercase tracking-wide text-[#168B70]">
                        System Administrator
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-[#164238] sm:text-2xl">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-1 text-xs text-[#6D817A] sm:text-sm">
                        Monitor and manage Barangay Esperanza Health Center records.
                    </p>

                </div>


                {{-- =================================================
                    HEADER ACTIONS
                ================================================== --}}
                <div class="flex items-center gap-2 sm:gap-3">

                    {{-- =================================================
                        REAL NOTIFICATION BELL
                    ================================================== --}}
                    @include('partials.notification-bell')


                    {{-- =================================================
                        DATE
                    ================================================== --}}
                    <div class="hidden rounded-xl border border-slate-200 bg-white px-4 py-2.5 shadow-sm sm:block">

                        <p class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            Today
                        </p>

                        <p class="mt-0.5 text-sm font-semibold text-[#164238]">
                            {{ now()->format('M d, Y') }}
                        </p>

                    </div>


                    {{-- =================================================
                        SYSTEM STATUS
                    ================================================== --}}
                    <div class="flex items-center gap-2 rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2.5">

                        <span class="relative flex h-2.5 w-2.5">

                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-50"
                            ></span>

                            <span
                                class="relative inline-flex h-2.5 w-2.5 rounded-full bg-emerald-500"
                            ></span>

                        </span>

                        <span class="text-xs font-semibold text-[#0F6F5A]">
                            System Online
                        </span>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                STATISTIC CARDS
            ====================================================== --}}
            <div class="mb-5 grid grid-cols-2 gap-3 lg:grid-cols-5">

                {{-- Residents --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                    <div class="flex items-center justify-between">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-[#0F6F5A]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                />

                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                                />
                            </svg>

                        </div>

                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            Total
                        </span>

                    </div>

                    <p class="mt-3 text-2xl font-bold text-[#164238]">
                        {{ number_format($totalResidents) }}
                    </p>

                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">
                        Residents
                    </p>

                </div>


                {{-- Households --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                    <div class="flex items-center justify-between">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-[#168B70]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 21h18"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 21V10l7-5 7 5v11"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 21v-5h6v5M9 11h.01M15 11h.01M9 14h.01M15 14h.01"
                                />
                            </svg>

                        </div>

                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            Total
                        </span>

                    </div>

                    <p class="mt-3 text-2xl font-bold text-[#164238]">
                        {{ number_format($totalHouseholds) }}
                    </p>

                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">
                        Households
                    </p>

                </div>


                {{-- Health Visits --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                    <div class="flex items-center justify-between">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50 text-[#E87928]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 12h4l2-7 4 14 2-7h6"
                                />
                            </svg>

                        </div>

                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            All Time
                        </span>

                    </div>

                    <p class="mt-3 text-2xl font-bold text-[#164238]">
                        {{ number_format($totalHealthVisits) }}
                    </p>

                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">
                        Health Visits
                    </p>

                </div>


                {{-- Today's Visits --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                    <div class="flex items-center justify-between">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-[#0F6F5A]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <rect
                                    x="3"
                                    y="4"
                                    width="18"
                                    height="18"
                                    rx="2"
                                    ry="2"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M16 2v4M8 2v4M3 10h18"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 14h2M14 14h2M8 18h2"
                                />
                            </svg>

                        </div>

                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            Today
                        </span>

                    </div>

                    <p class="mt-3 text-2xl font-bold text-[#164238]">
                        {{ number_format($todayHealthVisits) }}
                    </p>

                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">
                        Today's Visits
                    </p>

                </div>


                {{-- Senior Citizens --}}
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">

                    <div class="flex items-center justify-between">

                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-50 text-[#0F6F5A]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5.5 21a6.5 6.5 0 0113 0"
                                />
                            </svg>

                        </div>

                        <span class="text-[10px] font-medium uppercase tracking-wide text-[#9AA9A4]">
                            Registered
                        </span>

                    </div>

                    <p class="mt-3 text-2xl font-bold text-[#164238]">
                        {{ number_format($totalSeniorCitizens) }}
                    </p>

                    <p class="mt-0.5 text-xs font-medium text-[#6D817A]">
                        Senior Citizens
                    </p>

                </div>

            </div>


            {{-- =====================================================
                MONTHLY HEALTH VISITS GRAPH
            ====================================================== --}}
            <div class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="mb-3 flex items-start justify-between gap-3">

                    <div>

                        <h2 class="text-sm font-semibold text-[#164238]">
                            Monthly Health Visits
                        </h2>

                        <p class="mt-0.5 text-xs text-[#6D817A]">
                            Health visits recorded in {{ now()->year }}
                        </p>

                    </div>

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-[#168B70]">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 19V5"
                            />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 17h4v-5h4v3h4V7h4"
                            />
                        </svg>

                    </div>

                </div>

                <div class="h-48 sm:h-56">

                    <canvas id="monthlyHealthVisitChart"></canvas>

                </div>

            </div>


            {{-- =====================================================
                ADDITIONAL DASHBOARD CHARTS
                Uses only data already supplied to this Blade view.
            ====================================================== --}}
            <div class="mb-5 grid grid-cols-1 gap-5 xl:grid-cols-2">

                {{-- Recent Visit Types --}}
                <div class="clay-chart-card p-5">

                    <div class="mb-4 flex items-start justify-between gap-3">

                        <div>

                            <h2 class="text-sm font-semibold text-[#164238]">
                                Recent Visit Types
                            </h2>

                            <p class="mt-1 text-xs text-[#6D817A]">
                                Breakdown of the latest recorded health visits
                            </p>

                        </div>

                        <div class="clay-chart-icon flex h-9 w-9 shrink-0 items-center justify-center text-[#168B70]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <circle cx="12" cy="12" r="9"></circle>

                                <path
                                    stroke-linecap="round"
                                    d="M12 3v9h9"
                                ></path>
                            </svg>

                        </div>

                    </div>

                    <div class="clay-doughnut-wrap">
                        <canvas id="visitTypeChart"></canvas>
                    </div>

                </div>


                {{-- Resident Profile --}}
                <div class="clay-chart-card p-5">

                    <div class="mb-4 flex items-start justify-between gap-3">

                        <div>

                            <h2 class="text-sm font-semibold text-[#164238]">
                                Resident Profile
                            </h2>

                            <p class="mt-1 text-xs text-[#6D817A]">
                                Senior citizens compared with the rest of the registered residents
                            </p>

                        </div>

                        <div class="clay-chart-icon flex h-9 w-9 shrink-0 items-center justify-center text-[#E87928]">

                            <svg
                                class="h-4.5 w-4.5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                ></circle>

                                <path
                                    stroke-linecap="round"
                                    d="M5.5 21a6.5 6.5 0 0113 0"
                                ></path>
                            </svg>

                        </div>

                    </div>

                    <div class="clay-doughnut-wrap">
                        <canvas id="residentProfileChart"></canvas>
                    </div>

                </div>

            </div>


            {{-- =====================================================
                TODAY'S HEALTH CENTER SUMMARY
            ====================================================== --}}
            <div class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="mb-4 flex items-center justify-between">

                    <div>

                        <h2 class="text-sm font-semibold text-[#164238]">
                            Today's Health Center Summary
                        </h2>

                        <p class="mt-0.5 text-xs text-[#6D817A]">
                            Current activity for {{ now()->format('F d, Y') }}
                        </p>

                    </div>

                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-orange-50 text-[#E87928]">

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 12h4l2-7 4 14 2-7h6"
                            />
                        </svg>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

                    {{-- Today's visits --}}
                    <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">

                        <div class="flex items-center justify-between">

                            <span class="text-xs font-medium text-[#6D817A]">
                                Today's Visits
                            </span>

                            <span class="text-xs font-semibold text-[#0F6F5A]">
                                {{ number_format($todayHealthVisits) }}
                            </span>

                        </div>

                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-200">

                            <div
                                class="h-full rounded-full bg-[#168B70]"
                                style="width: {{ $todayHealthVisits > 0 ? '100%' : '0%' }}"
                            ></div>

                        </div>

                    </div>


                    {{-- Total residents --}}
                    <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">

                        <div class="flex items-center justify-between">

                            <span class="text-xs font-medium text-[#6D817A]">
                                Registered Residents
                            </span>

                            <span class="text-xs font-semibold text-[#0F6F5A]">
                                {{ number_format($totalResidents) }}
                            </span>

                        </div>

                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-200">

                            <div
                                class="h-full w-full rounded-full bg-[#0F6F5A]"
                            ></div>

                        </div>

                    </div>


                    {{-- Senior citizens --}}
                    <div class="rounded-lg border border-slate-100 bg-slate-50 p-3">

                        <div class="flex items-center justify-between">

                            <span class="text-xs font-medium text-[#6D817A]">
                                Senior Citizens
                            </span>

                            <span class="text-xs font-semibold text-[#E87928]">
                                {{ number_format($totalSeniorCitizens) }}
                            </span>

                        </div>

                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-slate-200">

                            <div
                                class="h-full rounded-full bg-[#E87928]"
                                style="width: {{ $totalResidents > 0 ? min(100, ($totalSeniorCitizens / $totalResidents) * 100) : 0 }}%"
                            ></div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                RECENT HEALTH VISITS + RECENT RESIDENTS
            ====================================================== --}}
            <div class="mb-5 grid grid-cols-1 gap-5 xl:grid-cols-2">

                {{-- =================================================
                    RECENT HEALTH VISITS
                ================================================== --}}
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">

                        <div>

                            <h2 class="text-sm font-semibold text-[#164238]">
                                Recent Health Visits
                            </h2>

                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                Latest recorded patient visits
                            </p>

                        </div>

                        <a
                            href="{{ route('health-visits.index') }}"
                            class="text-xs font-semibold text-[#168B70] transition hover:text-[#0F6F5A]"
                        >
                            View all
                        </a>

                    </div>


                    <div class="divide-y divide-slate-100">

                        @forelse ($recentHealthVisits as $visit)

                            <div class="flex items-center justify-between gap-3 px-4 py-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-xs font-bold text-[#0F6F5A]">

                                        {{ strtoupper(substr($visit->resident?->first_name ?? 'N', 0, 1)) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#385C52]">
                                            {{ $visit->resident?->full_name ?? 'Unknown Resident' }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-[#6D817A]">
                                            {{ $visit->visit_type ?: 'Health Visit' }}
                                        </p>

                                    </div>

                                </div>


                                <div class="shrink-0 text-right">

                                    <p class="text-xs font-medium text-[#557067]">
                                        {{ $visit->visit_date?->format('M d, Y') ?? '—' }}
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-[#9AA9A4]">
                                        {{ $visit->visit_date?->format('h:i A') ?? '' }}
                                    </p>

                                </div>

                            </div>

                        @empty

                            <div class="px-4 py-8 text-center">

                                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-[#9AA9A4]">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M9 12h6M9 16h6M8 4h8a2 2 0 012 2v14H6V6a2 2 0 012-2z"
                                        />
                                    </svg>

                                </div>

                                <p class="mt-2 text-sm font-medium text-[#557067]">
                                    No health visits yet
                                </p>

                                <p class="mt-1 text-xs text-[#9AA9A4]">
                                    Recorded visits will appear here.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- =================================================
                    RECENT RESIDENTS
                ================================================== --}}
                <div class="rounded-xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3">

                        <div>

                            <h2 class="text-sm font-semibold text-[#164238]">
                                Recently Added Residents
                            </h2>

                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                Latest registered residents
                            </p>

                        </div>

                        <a
                            href="{{ route('residents.index') }}"
                            class="text-xs font-semibold text-[#168B70] transition hover:text-[#0F6F5A]"
                        >
                            View all
                        </a>

                    </div>


                    <div class="divide-y divide-slate-100">

                        @forelse ($recentResidents as $resident)

                            <div class="flex items-center justify-between gap-3 px-4 py-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-50 text-xs font-bold text-[#0F6F5A]">

                                        {{ strtoupper(substr($resident->first_name ?? 'N', 0, 1)) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-semibold text-[#385C52]">
                                            {{ $resident->full_name }}
                                        </p>

                                        <p class="mt-0.5 truncate text-xs text-[#6D817A]">

                                            {{ $resident->gender ?? 'Resident' }}

                                            @if ($resident->birth_date)
                                                · {{ $resident->birth_date->age }} years old
                                            @endif

                                        </p>

                                    </div>

                                </div>


                                <div class="shrink-0 text-right">

                                    <p class="text-xs font-medium text-[#557067]">
                                        {{ $resident->created_at?->format('M d, Y') }}
                                    </p>

                                    <p class="mt-0.5 text-[10px] text-[#9AA9A4]">
                                        Registered
                                    </p>

                                </div>

                            </div>

                        @empty

                            <div class="px-4 py-8 text-center">

                                <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-[#9AA9A4]">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                        />

                                        <circle
                                            cx="9"
                                            cy="7"
                                            r="4"
                                        />

                                    </svg>

                                </div>

                                <p class="mt-2 text-sm font-medium text-[#557067]">
                                    No residents yet
                                </p>

                                <p class="mt-1 text-xs text-[#9AA9A4]">
                                    Newly registered residents will appear here.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- =====================================================
                QUICK ACTIONS
                Full-width card, outside the two-column grid above.
            ====================================================== --}}
            <div class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                <div class="mb-4">

                    <h2 class="text-sm font-semibold text-[#164238]">
                        Quick Actions
                    </h2>

                    <p class="mt-0.5 text-xs text-[#6D817A]">
                        Frequently used health center functions
                    </p>

                </div>


                <div class="clay-quick-grid">

                    {{-- Add Resident --}}
                    <a
                        href="{{ route('residents.create') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--green">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M15 19a4 4 0 00-8 0"
                                />

                                <circle
                                    cx="11"
                                    cy="7"
                                    r="4"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M19 8v6M16 11h6"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Add Resident
                        </span>

                    </a>


                    {{-- Record Visit --}}
                    <a
                        href="{{ route('health-visits.create') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--orange">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 12h4l2-7 4 14 2-7h6"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Record Visit
                        </span>

                    </a>


                    {{-- Households --}}
                    <a
                        href="{{ route('households.index') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--green">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 21h18M5 21V10l7-5 7 5v11"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 21v-5h6v5"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Households
                        </span>

                    </a>


                    {{-- Senior Citizens --}}
                    <a
                        href="{{ route('senior-citizens.index') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--green">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <circle
                                    cx="12"
                                    cy="7"
                                    r="4"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5.5 21a6.5 6.5 0 0113 0"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Senior Citizens
                        </span>

                    </a>


                    {{-- Reports --}}
                    <a
                        href="{{ route('reports.index') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--green">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M7 3h10a2 2 0 012 2v16H5V5a2 2 0 012-2z"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M8 8h8M8 12h8M8 16h5"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Reports
                        </span>

                    </a>


                    {{-- Immunizations --}}
                    <a
                        href="{{ route('immunizations.index') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--green">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18 2l4 4M17 7l3-3M19 9l-8.7 8.7a1 1 0 01-1.4 0l-2.6-2.6a1 1 0 010-1.4L15 5M9 11l4 4M5 19l-3 3M14 4l6 6"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Immunizations
                        </span>

                    </a>


                    {{-- Analytics --}}
                    <a
                        href="{{ route('analytics.index') }}"
                        class="clay-quick-action"
                    >

                        <span class="clay-quick-icon clay-quick-icon--green">

                            <svg
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 19V5"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 17h4v-5h4v3h4V7h4"
                                />
                            </svg>

                        </span>

                        <span class="clay-quick-label">
                            Analytics
                        </span>

                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div class="py-5 text-center">

                <p class="text-[11px] text-[#9AA9A4]">

                    Barangay Esperanza Health Center

                    <span class="mx-1">
                        •
                    </span>

                    Health Records Management System

                </p>

            </div>

        </div>

    </main>


    {{-- =========================================================
        DASHBOARD CHARTS
        Frontend chart configuration only. Data comes from existing
        Blade variables already used by this dashboard.
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const clayColors = {
                primary: '#168B70',
                primaryDark: '#0F6F5A',
                accent: '#E87928',
                blue: '#4F7CAC',
                violet: '#7C6FB0',
                mint: '#66A88E',
                grid: 'rgba(101, 126, 117, 0.14)',
                text: '#6D817A'
            };

            const commonFont = {
                family: 'Arial, Helvetica, sans-serif'
            };

            /* =====================================================
               1. MONTHLY HEALTH VISITS — LINE CHART
            ====================================================== */
            const monthlyCanvas = document.getElementById('monthlyHealthVisitChart');

            if (monthlyCanvas) {
                const monthlyData = @json($monthlyHealthVisits);

                new Chart(monthlyCanvas, {
                    type: 'line',
                    data: {
                        labels: monthlyData.map(item => item.month),
                        datasets: [{
                            label: 'Health Visits',
                            data: monthlyData.map(item => item.count),
                            borderColor: clayColors.primary,
                            backgroundColor: 'rgba(22, 139, 112, 0.10)',
                            borderWidth: 2.5,
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointBackgroundColor: '#F5FAF7',
                            pointBorderColor: clayColors.primary,
                            pointBorderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                displayColors: false,
                                backgroundColor: '#164238',
                                titleColor: '#FFFFFF',
                                bodyColor: '#FFFFFF',
                                cornerRadius: 10,
                                padding: 11,
                                callbacks: {
                                    label: function (context) {
                                        return ' Health Visits: ' + context.parsed.y;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0,
                                    color: clayColors.text,
                                    font: commonFont
                                },
                                title: {
                                    display: true,
                                    text: 'Visits',
                                    color: clayColors.text,
                                    font: {
                                        ...commonFont,
                                        size: 11,
                                        weight: '600'
                                    }
                                },
                                grid: {
                                    color: clayColors.grid,
                                    drawBorder: false
                                }
                            },
                            x: {
                                ticks: {
                                    color: clayColors.text,
                                    font: commonFont
                                },
                                title: {
                                    display: true,
                                    text: 'Month',
                                    color: clayColors.text,
                                    font: {
                                        ...commonFont,
                                        size: 11,
                                        weight: '600'
                                    }
                                },
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            }

            /* =====================================================
               2. RECENT VISIT TYPES — DOUGHNUT CHART
            ====================================================== */
            const visitTypeCanvas = document.getElementById('visitTypeChart');

            if (visitTypeCanvas) {
                const visitTypes = @json(
                    $recentHealthVisits
                        ->map(fn ($visit) => $visit->visit_type ?: 'Health Visit')
                        ->values()
                );

                const visitTypeCounts = {};

                visitTypes.forEach(function (type) {
                    visitTypeCounts[type] =
                        (visitTypeCounts[type] || 0) + 1;
                });

                const visitTypeLabels = Object.keys(visitTypeCounts);
                const visitTypeValues = Object.values(visitTypeCounts);

                new Chart(visitTypeCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: visitTypeLabels.length
                            ? visitTypeLabels
                            : ['No visits yet'],

                        datasets: [{
                            data: visitTypeLabels.length
                                ? visitTypeValues
                                : [1],

                            backgroundColor: visitTypeLabels.length
                                ? [
                                    clayColors.primary,
                                    clayColors.accent,
                                    clayColors.blue,
                                    clayColors.violet,
                                    clayColors.mint
                                ]
                                : ['#D9E5DF'],

                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 16,
                                    color: '#536B63',
                                    font: {
                                        ...commonFont,
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#164238',
                                cornerRadius: 10,
                                padding: 10,
                                callbacks: {
                                    label: function (context) {
                                        return ' ' +
                                            context.label +
                                            ': ' +
                                            context.parsed;
                                    }
                                }
                            }
                        }
                    }
                });
            }

            /* =====================================================
               3. RESIDENT PROFILE — DOUGHNUT CHART
            ====================================================== */
            const residentProfileCanvas =
                document.getElementById('residentProfileChart');

            if (residentProfileCanvas) {

                const totalResidents =
                    Number(@json($totalResidents));

                const seniorCitizens =
                    Number(@json($totalSeniorCitizens));

                const otherResidents =
                    Math.max(
                        totalResidents - seniorCitizens,
                        0
                    );

                new Chart(residentProfileCanvas, {
                    type: 'doughnut',

                    data: {
                        labels: [
                            'Senior Citizens',
                            'Other Residents'
                        ],

                        datasets: [{
                            data: [
                                seniorCitizens,
                                otherResidents
                            ],

                            backgroundColor: [
                                clayColors.accent,
                                '#BFD6CC'
                            ],

                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',

                        plugins: {
                            legend: {
                                position: 'bottom',

                                labels: {
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 18,
                                    color: '#536B63',

                                    font: {
                                        ...commonFont,
                                        size: 11
                                    }
                                }
                            },

                            tooltip: {
                                backgroundColor: '#164238',
                                cornerRadius: 10,
                                padding: 10,

                                callbacks: {
                                    label: function (context) {
                                        return ' ' +
                                            context.label +
                                            ': ' +
                                            context.parsed;
                                    }
                                }
                            }
                        }
                    }
                });
            }

        });
    </script>

</body>
@include('partials.database-assistant')

</html>