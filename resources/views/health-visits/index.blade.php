<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Health Visits | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM
        ========================================================= */

        .clay-health-visits {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;
            --accent: #E87928;

            --bg: #EEF5F1;
            --surface: #F5FAF7;
            --surface-soft: #EDF5F0;

            --text: #164238;
            --text-dark: #234E43;
            --text-muted: #6D817A;
            --text-soft: #9AA9A4;

            --danger: #B42323;
            --danger-light: #FEF2F2;

            font-family: Arial, Helvetica, sans-serif !important;
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 0% 0%,
                    rgba(255, 255, 255, 0.82),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(42, 155, 128, 0.08),
                    transparent 30%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                );
        }

        .clay-health-visits *,
        .clay-health-visits *::before,
        .clay-health-visits *::after {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        /* =========================================================
           TOP HEADER
        ========================================================= */

        .clay-top-header {
            background: rgba(245, 250, 247, 0.94) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.85) !important;
            box-shadow:
                0 5px 18px rgba(107, 134, 124, 0.10),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .clay-mobile-menu {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.16),
                -4px -4px 9px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-mobile-menu:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        .clay-role-label {
            color: var(--primary-dark) !important;
            letter-spacing: 0.12em;
        }

        .clay-header-title {
            color: var(--text-dark) !important;
        }

        .clay-profile {
            border-color: rgba(210, 225, 218, 0.72) !important;
        }

        .clay-profile-name {
            color: var(--text-dark) !important;
        }

        .clay-profile-role {
            color: var(--text-muted) !important;
        }

        .clay-profile-avatar {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.18),
                -4px -4px 9px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.22);
        }

        /* =========================================================
           PAGE HEADING
        ========================================================= */

        .clay-page-heading {
            position: relative;
            padding-left: 17px;
        }

        .clay-page-heading::before {
            content: "";
            position: absolute;
            left: 0;
            top: 4px;
            bottom: 4px;
            width: 4px;
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow: 2px 2px 5px rgba(15, 111, 90, 0.18);
        }

        .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-page-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           PRIMARY ACTION
        ========================================================= */

        .clay-primary-button {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.28) !important;
            border-radius: 13px !important;
            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.22),
                -4px -4px 10px rgba(255, 255, 255, 0.80),
                inset 1px 1px 0 rgba(255, 255, 255, 0.22);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-primary-button:hover {
            transform: translateY(-2px);
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, 0.25),
                -5px -5px 11px rgba(255, 255, 255, 0.84),
                inset 1px 1px 0 rgba(255, 255, 255, 0.24);
        }

        /* =========================================================
           SUCCESS ALERT
        ========================================================= */

        .clay-success-alert {
            background: linear-gradient(
                145deg,
                #F3FBF7,
                #E1F2EA
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 17px !important;
            box-shadow:
                6px 6px 13px rgba(107, 134, 124, 0.14),
                -6px -6px 13px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           SEARCH / FILTER CARD
        ========================================================= */

        .clay-search-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 24px !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.20),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-search-input {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F8FCFA
            ) !important;
            color: var(--text-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 14px !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        .clay-search-input::placeholder {
            color: var(--text-soft) !important;
        }

        .clay-search-input:focus {
            border-color: rgba(22, 139, 112, 0.55) !important;
            background: linear-gradient(
                145deg,
                #F0F8F4,
                #FBFEFC
            ) !important;
            box-shadow:
                0 0 0 3px rgba(22, 139, 112, 0.10),
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86) !important;
        }

        .clay-search-button {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.24) !important;
            border-radius: 13px !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.18),
                -4px -4px 9px rgba(255, 255, 255, 0.80),
                inset 1px 1px 0 rgba(255, 255, 255, 0.22);
        }

        .clay-search-button:hover {
            transform: translateY(-1px);
        }

        .clay-clear-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            border-radius: 13px !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.16),
                -4px -4px 9px rgba(255, 255, 255, 0.90);
        }

        .clay-clear-button:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           TABLE CARD
        ========================================================= */

        .clay-table-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 26px !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.22),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-table {
            color: var(--text-dark);
        }

        .clay-table thead {
            background: linear-gradient(
                145deg,
                #EDF6F1,
                #E4F0EA
            ) !important;
        }

        .clay-table thead th {
            color: var(--text-muted) !important;
            border-bottom-color: rgba(210, 225, 218, 0.68) !important;
        }

        .clay-table tbody tr {
            border-color: rgba(210, 225, 218, 0.58) !important;
            transition:
                background 0.18s ease,
                transform 0.18s ease;
        }

        .clay-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.48) !important;
        }

        /* =========================================================
           RESIDENT AVATAR
        ========================================================= */

        .clay-avatar {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.16),
                -4px -4px 9px rgba(255, 255, 255, 0.82),
                inset 1px 1px 0 rgba(255, 255, 255, 0.20);
        }

        .clay-resident-name {
            color: var(--text-dark) !important;
        }

        .clay-secondary-text {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           VISIT TYPE BADGE
        ========================================================= */

        .clay-visit-badge {
            background: linear-gradient(
                145deg,
                #E5F7EF,
                #D6EFE5
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.86) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.12),
                -3px -3px 7px rgba(255, 255, 255, 0.84);
        }

        .clay-unspecified-badge {
            background: linear-gradient(
                145deg,
                #F1F5F3,
                #E5ECE9
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.82) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.10),
                -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           MOBILE / DETAIL CARDS
        ========================================================= */

        .clay-mobile-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 22px !important;
            box-shadow:
                8px 8px 18px rgba(107, 134, 124, 0.20),
                -8px -8px 18px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-detail-grid {
            border-top-color: rgba(210, 225, 218, 0.62) !important;
        }

        .clay-detail-label {
            color: var(--text-soft) !important;
        }

        .clay-detail-value {
            color: var(--text-dark) !important;
        }

        /* =========================================================
           ACTION BUTTONS
        ========================================================= */

        .clay-action-view,
        .clay-action-edit,
        .clay-action-delete {
            min-height: 38px;
            border-radius: 11px !important;
            font-family: Arial, Helvetica, sans-serif !important;
            font-size: 0.8125rem !important;
            font-weight: 700 !important;
            line-height: 1 !important;
            white-space: nowrap;
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-action-view {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.14),
                -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-action-view:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .clay-action-edit {
            background: linear-gradient(
                145deg,
                #E5F7EF,
                #D6EFE5
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.86) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.14),
                -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-action-edit:hover {
            transform: translateY(-1px);
        }

        .clay-action-delete {
            background: linear-gradient(
                145deg,
                #FEF4F3,
                #F7E6E3
            ) !important;
            color: var(--danger) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            box-shadow:
                3px 3px 7px rgba(150, 94, 84, 0.12),
                -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-action-delete:hover {
            background: linear-gradient(
                145deg,
                #FCEBE8,
                #F4DCD8
            ) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .clay-empty-state {
            color: var(--text-muted);
        }

        .clay-empty-icon {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #E1ECE7
            ) !important;
            color: var(--text-soft) !important;
            border: 1px solid rgba(255, 255, 255, 0.84) !important;
            box-shadow:
                inset 4px 4px 9px rgba(107, 134, 124, 0.10),
                inset -4px -4px 9px rgba(255, 255, 255, 0.86);
        }

        .clay-empty-title {
            color: var(--text-dark) !important;
        }

        .clay-empty-text {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        .clay-pagination {
            border-top-color: rgba(210, 225, 218, 0.62) !important;
            background: rgba(245, 250, 247, 0.38);
        }

        /* =========================================================
           FOCUS / ACCESSIBILITY
        ========================================================= */

        .clay-health-visits a:focus-visible,
        .clay-health-visits button:focus-visible,
        .clay-health-visits input:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 639px) {
            .clay-page-heading {
                padding-left: 13px;
            }

            .clay-page-heading::before {
                width: 3px;
            }

            .clay-search-card,
            .clay-mobile-card,
            .clay-table-card {
                border-radius: 19px !important;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-health-visits *,
            .clay-health-visits *::before,
            .clay-health-visits *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<div class="clay-health-visits min-h-screen">

    {{-- Fixed Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Application Area --}}
    <div class="min-h-screen w-full lg:pl-72">

        {{-- Top Header --}}
        <header class="clay-top-header sticky top-0 z-30">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Left Side --}}
                <div class="flex items-center gap-4">

                    {{-- Mobile Menu Button --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-menu inline-flex h-10 w-10 items-center justify-center rounded-xl transition lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div>
                        <p class="clay-role-label text-xs font-semibold uppercase tracking-wider">
                            System Administrator
                        </p>

                        <h1 class="clay-header-title mt-1 text-xl font-bold tracking-tight sm:text-2xl">
                            Health Visit Records
                        </h1>
                    </div>

                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    @include('partials.notification-bell')

                    {{-- Profile --}}
                    <div class="clay-profile flex items-center gap-3">

                        <div class="hidden text-right sm:block">
                            <p class="clay-profile-name text-sm font-semibold">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="clay-profile-role text-xs">
                                System Administrator
                            </p>
                        </div>

                        <div class="clay-profile-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </div>

        </header>

        {{-- Page Content --}}
        <main class="w-full">

            <div class="mx-auto w-full max-w-[1600px] px-4 py-6 sm:px-6 sm:py-8 lg:px-8 xl:px-10">

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="clay-success-alert mb-6 flex items-start gap-3 px-4 py-4 text-sm">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        <p class="font-medium">
                            {{ session('success') }}
                        </p>

                    </div>
                @endif

                {{-- Page Introduction --}}
                <div class="clay-page-heading mb-7 flex flex-col gap-5 xl:flex-row xl:items-end xl:justify-between">

                    <div class="min-w-0">

                        <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                            Health Visit Records
                        </h2>

                        <p class="clay-page-description mt-2 max-w-2xl text-sm leading-6">
                            Record, review, and manage consultations and health center visits of Barangay Esperanza residents.
                        </p>

                    </div>

                    <a
                        href="{{ route('health-visits.create') }}"
                        class="clay-primary-button inline-flex w-full shrink-0 items-center justify-center gap-2 px-5 py-3 text-sm font-semibold transition sm:w-fit"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />
                        </svg>

                        Record Health Visit
                    </a>

                </div>

                {{-- Search --}}
                <div class="clay-search-card mb-6 p-4 sm:p-5">

                    <form
                        method="GET"
                        action="{{ route('health-visits.index') }}"
                        class="flex flex-col gap-3 lg:flex-row"
                    >

                        <div class="relative min-w-0 flex-1">

                            <svg
                                class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                                />
                            </svg>

                            <input
                                type="search"
                                name="search"
                                value="{{ $search }}"
                                placeholder="Search by resident name..."
                                class="clay-search-input w-full py-3 pl-10 pr-4 text-sm outline-none transition"
                            >

                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <button
                                type="submit"
                                class="clay-search-button rounded-xl px-6 py-3 text-sm font-semibold transition"
                            >
                                Search
                            </button>

                            @if ($search !== '')
                                <a
                                    href="{{ route('health-visits.index') }}"
                                    class="clay-clear-button inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-semibold transition"
                                >
                                    Clear
                                </a>
                            @endif

                        </div>

                    </form>

                </div>

                {{-- Desktop Table --}}
                <div class="clay-table-card hidden overflow-hidden lg:block">

                    <div class="w-full overflow-x-auto">

                        <table class="clay-table w-full min-w-[900px] divide-y">

                            <thead>
                                <tr>

                                    <th class="w-[34%] whitespace-nowrap px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Resident
                                    </th>

                                    <th class="w-[20%] whitespace-nowrap px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Visit Date
                                    </th>

                                    <th class="w-[21%] whitespace-nowrap px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Visit Type
                                    </th>

                                    <th class="w-[25%] whitespace-nowrap px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                                        <span class="sr-only">Actions</span>
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="divide-y">

                                @forelse ($healthVisits as $healthVisit)

                                    <tr>

                                        {{-- Resident --}}
                                        <td class="px-6 py-5">

                                            <div class="flex min-w-[220px] items-center gap-3">

                                                <div class="clay-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold">
                                                    {{ strtoupper(substr($healthVisit->resident->first_name, 0, 1) . substr($healthVisit->resident->last_name, 0, 1)) }}
                                                </div>

                                                <div class="min-w-0">

                                                    <p class="clay-resident-name truncate font-semibold">
                                                        {{ $healthVisit->resident->full_name }}
                                                    </p>

                                                    <p class="clay-secondary-text mt-0.5 text-xs">
                                                        Resident #{{ $healthVisit->resident->id }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>

                                        {{-- Date --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <p class="clay-resident-name text-sm font-semibold">
                                                {{ $healthVisit->visit_date->format('M d, Y') }}
                                            </p>

                                            <p class="clay-secondary-text mt-1 text-xs">
                                                {{ $healthVisit->visit_date->format('h:i A') }}
                                            </p>

                                        </td>

                                        {{-- Visit Type --}}
                                        <td class="px-6 py-5">

                                            @if ($healthVisit->visit_type)

                                                <span class="clay-visit-badge inline-flex max-w-full rounded-full px-3 py-1 text-xs font-semibold">
                                                    <span class="truncate">
                                                        {{ $healthVisit->visit_type }}
                                                    </span>
                                                </span>

                                            @else

                                                <span class="clay-unspecified-badge inline-flex rounded-full px-3 py-1 text-xs font-semibold">
                                                    Not specified
                                                </span>

                                            @endif

                                        </td>

                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-5">

                                            <div class="relative flex items-center justify-end">
                                                <button type="button" class="clay-action-menu-trigger flex h-10 w-10 items-center justify-center rounded-full text-[#6D817A] transition hover:text-[#164238]" aria-label="More actions for health visit #{{ $healthVisit->id }}" aria-expanded="false" data-menu-trigger>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                        <circle cx="10" cy="5" r="1.5"/>
                                                        <circle cx="10" cy="10" r="1.5"/>
                                                        <circle cx="10" cy="15" r="1.5"/>
                                                    </svg>
                                                </button>

                                                <div class="clay-action-menu absolute right-0 top-full z-20 mt-2 hidden min-w-[180px] rounded-2xl border border-white/80 bg-[#F5FAF7] p-2 shadow-[0_12px_35px_rgba(107,134,124,0.18)]" data-menu-panel>
                                                    <a href="{{ route('health-visits.show', $healthVisit) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                        View
                                                    </a>
                                                    <a href="{{ route('health-visits.edit', $healthVisit) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/></svg>
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('health-visits.destroy', $healthVisit) }}" data-confirm-title="Delete this health visit?" data-confirm-item="Health visit #{{ $healthVisit->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm font-semibold text-[#B42323] transition hover:bg-[#FDF1F1]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"/></svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4" class="clay-empty-state px-6 py-16 text-center">

                                            <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full">

                                                <svg
                                                    class="h-7 w-7"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.8"
                                                        d="M8 3v4m8-4v4M4 9h16M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm3 8h6m-6 4h4"
                                                    />
                                                </svg>

                                            </div>

                                            <h3 class="clay-empty-title mt-4 text-base font-bold">
                                                No health visits found
                                            </h3>

                                            <p class="clay-empty-text mx-auto mt-1 max-w-md text-sm">

                                                @if ($search !== '')
                                                    No health visit matches your search.
                                                @else
                                                    There are currently no health visit records.
                                                @endif

                                            </p>

                                            @if ($search === '')

                                                <a
                                                    href="{{ route('health-visits.create') }}"
                                                    class="clay-primary-button mt-5 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition"
                                                >
                                                    <svg
                                                        class="h-4 w-4"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 4v16m8-8H4"
                                                        />
                                                    </svg>

                                                    Record First Visit
                                                </a>

                                            @endif

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- Desktop Pagination --}}
                    @if ($healthVisits->hasPages())

                        <div class="clay-pagination px-6 py-4">
                            {{ $healthVisits->links() }}
                        </div>

                    @endif

                </div>

                {{-- Mobile Cards --}}
                <div class="space-y-4 lg:hidden">

                    @forelse ($healthVisits as $healthVisit)

                        <div class="clay-mobile-card overflow-hidden p-5">

                            {{-- Resident --}}
                            <div class="flex items-start gap-3">

                                <div class="clay-avatar flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-bold">
                                    {{ strtoupper(substr($healthVisit->resident->first_name, 0, 1) . substr($healthVisit->resident->last_name, 0, 1)) }}
                                </div>

                                <div class="min-w-0 flex-1">

                                    <p class="clay-resident-name truncate font-semibold">
                                        {{ $healthVisit->resident->full_name }}
                                    </p>

                                    <p class="clay-secondary-text mt-0.5 text-xs">
                                        Resident #{{ $healthVisit->resident->id }}
                                    </p>

                                </div>

                            </div>

                            {{-- Visit Type --}}
                            <div class="mt-4">

                                @if ($healthVisit->visit_type)

                                    <span class="clay-visit-badge inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                        {{ $healthVisit->visit_type }}
                                    </span>

                                @else

                                    <span class="clay-unspecified-badge inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                        Visit type not specified
                                    </span>

                                @endif

                            </div>

                            {{-- Details --}}
                            <div class="clay-detail-grid mt-5 grid grid-cols-1 gap-4 border-t pt-4">

                                <div class="min-w-0">

                                    <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                        Visit Date
                                    </p>

                                    <p class="clay-detail-value mt-1 text-sm font-medium">
                                        {{ $healthVisit->visit_date->format('M d, Y') }}
                                    </p>

                                    <p class="clay-secondary-text text-xs">
                                        {{ $healthVisit->visit_date->format('h:i A') }}
                                    </p>

                                </div>

                            </div>

                            {{-- Mobile Actions --}}
                            <div class="mt-5">
                                @component('partials.record-actions', ['label' => 'More actions for health visit #'.$healthVisit->id])

                                <a
                                    href="{{ route('health-visits.show', $healthVisit) }}"
                                >
                                    @include('partials.record-action-icon', ['icon' => 'view'])
                                    View
                                </a>

                                <a
                                    href="{{ route('health-visits.edit', $healthVisit) }}"
                                >
                                    @include('partials.record-action-icon', ['icon' => 'edit'])
                                    Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('health-visits.destroy', $healthVisit) }}"
                                    data-confirm-title="Delete this health visit?"
                                    data-confirm-item="Health visit #{{ $healthVisit->id }}"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="record-action-danger"
                                    >
                                        @include('partials.record-action-icon', ['icon' => 'delete'])
                                        Delete
                                    </button>
                                </form>

                                @endcomponent
                            </div>

                        </div>

                    @empty

                        <div class="clay-mobile-card px-6 py-16 text-center">

                            <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full">

                                <svg
                                    class="h-7 w-7"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M8 3v4m8-4v4M4 9h16M6 5h12a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2Zm3 8h6m-6 4h4"
                                    />
                                </svg>

                            </div>

                            <h3 class="clay-empty-title mt-4 text-base font-bold">
                                No health visits found
                            </h3>

                            <p class="clay-empty-text mt-1 text-sm">

                                @if ($search !== '')
                                    No health visit matches your search.
                                @else
                                    There are currently no health visit records.
                                @endif

                            </p>

                            @if ($search === '')

                                <a
                                    href="{{ route('health-visits.create') }}"
                                    class="clay-primary-button mt-5 inline-flex items-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition"
                                >
                                    Record First Visit
                                </a>

                            @endif

                        </div>

                    @endforelse

                    {{-- Mobile Pagination --}}
                    @if ($healthVisits->hasPages())

                        <div class="clay-table-card px-5 py-4">
                            {{ $healthVisits->links() }}
                        </div>

                    @endif

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>