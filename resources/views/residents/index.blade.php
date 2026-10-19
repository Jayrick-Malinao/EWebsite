<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Residents | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage resident records for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA — RESIDENT DIRECTORY
           Government-Style Claymorphism UI
        ========================================================= */

        .clay-residents {
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
            --danger-soft: #FBF0F0;

            font-family: Arial, Helvetica, sans-serif !important;
            min-height: 100vh;

            background:
                radial-gradient(
                    circle at 8% 0%,
                    rgba(255, 255, 255, .80),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(42, 155, 128, .08),
                    transparent 26%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                );
        }

        .clay-residents,
        .clay-residents * {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        /* =========================================================
           CLAY SURFACES
        ========================================================= */

        .clay-residents .clay-surface {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, .82) !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84) !important;
        }

        .clay-residents .clay-surface-soft {
            background: linear-gradient(
                145deg,
                #F4FAF7,
                #E8F1EC
            ) !important;
            border: 1px solid rgba(255, 255, 255, .78) !important;
            box-shadow:
                6px 6px 15px rgba(107, 134, 124, .16),
                -6px -6px 15px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .76) !important;
        }

        /* =========================================================
           TOP HEADER
        ========================================================= */

        .clay-residents .clay-top-header {
            background: rgba(245, 250, 247, .94) !important;
            border-bottom: 1px solid rgba(210, 225, 218, .72) !important;
            box-shadow:
                0 8px 22px rgba(75, 105, 94, .08),
                inset 0 -1px 0 rgba(255, 255, 255, .82) !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-residents .clay-role-label {
            color: var(--primary-dark) !important;
            letter-spacing: .13em;
        }

        .clay-residents .clay-profile-avatar {
            background: linear-gradient(
                145deg,
                #2A9B80,
                #0F6F5A
            ) !important;
            color: white !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .20),
                -4px -4px 9px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .24) !important;
        }

        .clay-residents .clay-menu-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, .82) !important;
            color: var(--text-muted) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .17),
                -4px -4px 9px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .78) !important;
        }

        .clay-residents .clay-menu-button:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           BREADCRUMB
        ========================================================= */

        .clay-residents .clay-breadcrumb {
            color: var(--text-soft) !important;
        }

        .clay-residents .clay-breadcrumb a {
            color: var(--primary-dark) !important;
        }

        .clay-residents .clay-breadcrumb a:hover {
            color: var(--primary) !important;
        }

        /* =========================================================
           PAGE HEADING
        ========================================================= */

        .clay-residents .clay-page-heading {
            position: relative;
            padding-left: 17px;
        }

        .clay-residents .clay-page-heading::before {
            content: "";
            position: absolute;
            left: 0;
            top: 3px;
            bottom: 3px;
            width: 4px;
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow: 2px 2px 6px rgba(22, 139, 112, .18);
        }

        .clay-residents .clay-eyebrow {
            color: var(--primary-dark) !important;
        }

        .clay-residents .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-residents .clay-page-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           BUTTONS
        ========================================================= */

        .clay-residents .clay-primary-button {
            background: linear-gradient(
                145deg,
                #2A9B80,
                #0F6F5A
            ) !important;
            border: 1px solid rgba(255, 255, 255, .20) !important;
            color: #FFFFFF !important;
            box-shadow:
                5px 5px 11px rgba(67, 105, 94, .24),
                -4px -4px 10px rgba(255, 255, 255, .62),
                inset 1px 1px 0 rgba(255, 255, 255, .22) !important;
        }

        .clay-residents .clay-primary-button:hover {
            background: linear-gradient(
                145deg,
                #319F84,
                #0D674F
            ) !important;
            transform: translateY(-1px);
            box-shadow:
                6px 7px 14px rgba(67, 105, 94, .27),
                -5px -5px 11px rgba(255, 255, 255, .68),
                inset 1px 1px 0 rgba(255, 255, 255, .24) !important;
        }

        .clay-residents .clay-neutral-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            ) !important;
            border: 1px solid rgba(255, 255, 255, .82) !important;
            color: var(--text-muted) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .17),
                -4px -4px 9px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .78) !important;
        }

        .clay-residents .clay-neutral-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .clay-residents .clay-search-button {
            background: linear-gradient(
                145deg,
                #2A9B80,
                #0F6F5A
            ) !important;
            color: #FFFFFF !important;
            box-shadow:
                4px 4px 9px rgba(67, 105, 94, .22),
                -4px -4px 9px rgba(255, 255, 255, .62),
                inset 1px 1px 0 rgba(255, 255, 255, .20) !important;
        }

        .clay-residents .clay-search-button:hover {
            transform: translateY(-1px);
        }

        /* =========================================================
           SEARCH / SUMMARY
        ========================================================= */

        .clay-residents .clay-search-card {
            border-radius: 24px !important;
        }

        .clay-residents .clay-search-input {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F8FCFA
            ) !important;
            border: 1px solid rgba(203, 221, 213, .86) !important;
            color: var(--text-dark) !important;
            border-radius: 14px !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82) !important;
        }

        .clay-residents .clay-search-input::placeholder {
            color: var(--text-soft) !important;
        }

        .clay-residents .clay-search-input:focus {
            border-color: rgba(22, 139, 112, .62) !important;
            background: #F8FCFA !important;
            box-shadow:
                0 0 0 3px rgba(22, 139, 112, .10),
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .84) !important;
        }

        .clay-residents .clay-summary-card {
            border-radius: 22px !important;
            min-width: 170px;
        }

        .clay-residents .clay-summary-label {
            color: var(--text-soft) !important;
            letter-spacing: .11em;
        }

        .clay-residents .clay-summary-number {
            color: var(--text-dark) !important;
        }

        .clay-residents .clay-summary-caption {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           TABLE CARD
        ========================================================= */

        .clay-residents .clay-table-card {
            border-radius: 26px !important;
        }

        .clay-residents .clay-table-header {
            border-bottom: 1px solid rgba(210, 225, 218, .70) !important;
        }

        .clay-residents .clay-table-icon {
            background: linear-gradient(
                145deg,
                #DDF1EA,
                #CBE6DC
            ) !important;
            color: var(--primary-dark) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .15),
                -4px -4px 9px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .72) !important;
        }

        .clay-residents .clay-table-title {
            color: var(--text-dark) !important;
        }

        .clay-residents .clay-table-description,
        .clay-residents .clay-search-result {
            color: var(--text-muted) !important;
        }

        .clay-residents .clay-result-pill {
            background: linear-gradient(
                145deg,
                #EDF7F2,
                #DFEEE8
            ) !important;
            border: 1px solid rgba(255, 255, 255, .78) !important;
            color: var(--primary-dark) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .82) !important;
        }

        /* =========================================================
           DESKTOP TABLE
        ========================================================= */

        .clay-residents .clay-table {
            color: var(--text-dark) !important;
        }

        .clay-residents .clay-table-head {
            background: linear-gradient(
                145deg,
                #E9F5F0,
                #E1EEE8
            ) !important;
        }

        .clay-residents .clay-table-head th {
            color: #527169 !important;
            border-bottom: 1px solid rgba(202, 220, 212, .72) !important;
        }

        .clay-residents .clay-table-row {
            border-color: rgba(210, 225, 218, .60) !important;
            transition:
                background .2s ease,
                transform .2s ease;
        }

        .clay-residents .clay-table-row:hover {
            background: rgba(255, 255, 255, .50) !important;
        }

        .clay-residents .clay-avatar {
            background: linear-gradient(
                145deg,
                #2A9B80,
                #0F6F5A
            ) !important;
            color: #FFFFFF !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .18),
                -4px -4px 9px rgba(255, 255, 255, .82),
                inset 1px 1px 0 rgba(255, 255, 255, .20) !important;
        }

        .clay-residents .clay-resident-name {
            color: var(--text-dark) !important;
        }

        .clay-residents .clay-resident-email {
            color: var(--text-soft) !important;
        }

        .clay-residents .clay-table-value {
            color: #58726A !important;
        }

        /* =========================================================
           STATUS BADGES
        ========================================================= */

        .clay-residents .clay-status-active {
            background: linear-gradient(
                145deg,
                #E7F7F0,
                #D8EEE6
            ) !important;
            border: 1px solid rgba(255, 255, 255, .76) !important;
            color: #0F6F5A !important;
            box-shadow:
                3px 3px 7px rgba(79, 117, 105, .12),
                -3px -3px 7px rgba(255, 255, 255, .82) !important;
        }

        .clay-residents .clay-status-active .status-dot {
            background: #168B70 !important;
            box-shadow: 0 0 0 3px rgba(22, 139, 112, .10);
        }

        .clay-residents .clay-status-inactive {
            background: linear-gradient(
                145deg,
                #F1F4F2,
                #E5EAE7
            ) !important;
            border: 1px solid rgba(255, 255, 255, .76) !important;
            color: #66766F !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .10),
                -3px -3px 7px rgba(255, 255, 255, .80) !important;
        }

        .clay-residents .clay-status-inactive .status-dot {
            background: #98A6A0 !important;
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .clay-residents .clay-action {
            border: 1px solid rgba(255, 255, 255, .80) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .72) !important;
        }

        .clay-residents .clay-action-view {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            ) !important;
            color: #60766E !important;
        }

        .clay-residents .clay-action-view:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .clay-residents .clay-action-edit {
            background: linear-gradient(
                145deg,
                #E9F7F2,
                #DCEEE7
            ) !important;
            color: var(--primary-dark) !important;
        }

        .clay-residents .clay-action-edit:hover {
            color: #0B5C49 !important;
            transform: translateY(-1px);
        }

        .clay-residents .clay-action-delete {
            background: linear-gradient(
                145deg,
                #FFF5F4,
                #F7E7E6
            ) !important;
            color: var(--danger) !important;
        }

        .clay-residents .clay-action-delete:hover {
            background: linear-gradient(
                145deg,
                #FFF0EF,
                #F4DEDC
            ) !important;
            color: #8F1D1D !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           MOBILE CARDS
        ========================================================= */

        .clay-residents .clay-mobile-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, .82) !important;
            border-radius: 20px !important;
            box-shadow:
                6px 6px 14px rgba(107, 134, 124, .16),
                -6px -6px 14px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .80) !important;
        }

        .clay-residents .clay-mobile-detail {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F7FBF9
            ) !important;
            border: 1px solid rgba(255, 255, 255, .76) !important;
            border-radius: 13px !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .82) !important;
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .clay-residents .clay-empty-icon {
            background: linear-gradient(
                145deg,
                #E7F4EF,
                #D7EAE2
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, .78) !important;
            box-shadow:
                inset 4px 4px 9px rgba(107, 134, 124, .10),
                inset -4px -4px 9px rgba(255, 255, 255, .86) !important;
        }

        .clay-residents .clay-empty-title {
            color: var(--text-dark) !important;
        }

        .clay-residents .clay-empty-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .clay-residents .clay-footer {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           FOCUS / ACCESSIBILITY
        ========================================================= */

        .clay-residents a:focus-visible,
        .clay-residents button:focus-visible,
        .clay-residents input:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 2px;
        }

        .clay-residents button,
        .clay-residents a {
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease,
                color .18s ease;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 639px) {
            .clay-residents .clay-table-card {
                border-radius: 21px !important;
            }

            .clay-residents .clay-summary-card {
                min-width: 0;
            }

            .clay-residents .clay-page-heading {
                padding-left: 13px;
            }

            .clay-residents .clay-page-heading::before {
                width: 3px;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-residents *,
            .clay-residents *::before,
            .clay-residents *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body class="min-h-screen text-slate-800">

    <div class="clay-residents min-h-screen">

        {{-- Mobile Overlay --}}
        <div
            id="sidebar-overlay"
            class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"
        ></div>

        {{-- Sidebar --}}
        @include('dashboard.sidebar')

        {{-- Main Content --}}
        <main class="lg:pl-72">

            {{-- Top Header --}}
            <header class="clay-top-header sticky top-0 z-30">

                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                    {{-- Left Side --}}
                    <div class="flex items-center gap-4">

                        {{-- Mobile Menu Button --}}
                        <button
                            type="button"
                            id="mobileMenuButton"
                            class="clay-menu-button inline-flex h-10 w-10 items-center justify-center rounded-xl lg:hidden"
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

                            <h1 class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                                Residents
                            </h1>
                        </div>

                    </div>

                    {{-- Right Side --}}
                    <div class="flex items-center gap-3">

                        @include('partials.notification-bell')

                        {{-- Profile --}}
                        <div class="flex items-center gap-3">

                            <div class="hidden text-right sm:block">
                                <p class="text-sm font-semibold text-slate-900">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-slate-500">
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
            <div class="px-4 py-6 sm:px-6 lg:px-8">

                

                {{-- Page Heading --}}
                <div class="clay-page-heading mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                            Residents
                        </h2>

                        <p class="clay-page-description mt-1 max-w-2xl text-sm">
                            Manage and maintain individual resident information
                            registered with Barangay Esperanza Health Center.
                        </p>
                    </div>

                    <a
                        href="{{ route('residents.create') }}"
                        class="clay-primary-button inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold"
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

                        Add Resident
                    </a>

                </div>

                {{-- Success Message --}}
                @if (session('success'))
                    <div
                        class="mb-5 flex items-start gap-3 rounded-2xl border border-white/80 bg-gradient-to-br from-emerald-50 to-emerald-100/70 px-4 py-3 text-sm text-emerald-800 shadow-[5px_5px_12px_rgba(107,134,124,.13),-5px_-5px_12px_rgba(255,255,255,.85)]"
                    >
                        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-100 text-emerald-700 shadow-inner">
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>
                        </div>

                        <p class="pt-1">
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                {{-- Search + Summary --}}
                <div class="mb-5 grid gap-4 lg:grid-cols-[1fr_auto]">

                    {{-- Search --}}
                    <form
                        method="GET"
                        action="{{ route('residents.index') }}"
                        class="clay-surface clay-search-card p-4"
                    >
                        <div class="flex flex-col gap-3 sm:flex-row">

                            <div class="relative flex-1">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg
                                        class="h-5 w-5 text-emerald-700/60"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.8"
                                            d="m21 21-4.3-4.3m2.3-5.2a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                                        />
                                    </svg>
                                </div>

                                <input
                                    type="search"
                                    name="search"
                                    value="{{ $search }}"
                                    placeholder="Search by resident name, contact number, email, or PhilHealth number..."
                                    class="clay-search-input w-full py-2.5 pl-10 pr-4 text-sm outline-none"
                                >

                            </div>

                            <button
                                type="submit"
                                class="clay-search-button inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold"
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
                                        d="m21 21-4.3-4.3m2.3-5.2a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z"
                                    />
                                </svg>

                                Search
                            </button>

                            @if ($search !== '')
                                <a
                                    href="{{ route('residents.index') }}"
                                    class="clay-neutral-button inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold"
                                >
                                    Clear
                                </a>
                            @endif

                        </div>
                    </form>

                    {{-- Summary --}}
                    <div class="clay-surface clay-summary-card flex items-center gap-4 px-5 py-4">

                        <div class="clay-table-icon flex h-11 w-11 shrink-0 items-center justify-center rounded-xl">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                />
                                <circle
                                    cx="9"
                                    cy="7"
                                    r="4"
                                    stroke-width="1.8"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M19 8v6M22 11h-6"
                                />
                            </svg>
                        </div>

                        <div>
                            <p class="clay-summary-label text-xs font-semibold uppercase">
                                Records
                            </p>

                            <p class="clay-summary-number mt-1 text-2xl font-bold">
                                {{ $residents->total() }}
                            </p>

                            <p class="clay-summary-caption text-xs">
                                Registered residents
                            </p>
                        </div>

                    </div>

                </div>

                {{-- Residents Table --}}
                <div class="clay-surface clay-table-card overflow-hidden">

                    {{-- Table Header --}}
                    <div class="clay-table-header flex flex-col gap-3 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="clay-table-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                    />
                                    <circle
                                        cx="9"
                                        cy="7"
                                        r="4"
                                        stroke-width="1.8"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M19 8v6M22 11h-6"
                                    />
                                </svg>
                            </div>

                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <h3 class="clay-table-title font-semibold">
                                        Resident Directory
                                    </h3>

                                    <span class="clay-result-pill rounded-full px-2.5 py-1 text-[11px] font-bold">
                                        {{ $residents->total() }} records
                                    </span>
                                </div>

                                <p class="clay-table-description mt-0.5 text-xs">
                                    Individual resident records currently registered in the system.
                                </p>
                            </div>

                        </div>

                        @if ($search !== '')
                            <p class="clay-search-result text-xs">
                                Search results for
                                <span class="font-semibold text-slate-700">
                                    "{{ $search }}"
                                </span>
                            </p>
                        @endif

                    </div>

                    @if ($residents->count())

                        {{-- Desktop Table --}}
                        <div class="hidden overflow-x-auto md:block">

                            <table class="clay-table min-w-full">

                                <thead class="clay-table-head">

                                    <tr>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                            Resident
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                            Birth Date
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                            Gender
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                            Contact
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide">
                                            Status
                                        </th>

                                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wide">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($residents as $resident)

                                        <tr class="clay-table-row border-b">

                                            {{-- Resident --}}
                                            <td class="whitespace-nowrap px-5 py-4">

                                                <div class="flex items-center gap-3">

                                                    <div class="clay-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-xl font-semibold">
                                                        {{ strtoupper(substr($resident->first_name, 0, 1)) }}{{ strtoupper(substr($resident->last_name, 0, 1)) }}
                                                    </div>

                                                    <div class="min-w-0">

                                                        <p class="clay-resident-name truncate font-semibold">
                                                            {{ $resident->full_name }}
                                                        </p>

                                                        @if ($resident->email)
                                                            <p class="clay-resident-email truncate text-xs">
                                                                {{ $resident->email }}
                                                            </p>
                                                        @endif

                                                    </div>

                                                </div>

                                            </td>

                                            {{-- Birth Date --}}
                                            <td class="clay-table-value whitespace-nowrap px-5 py-4 text-sm">
                                                {{ $resident->birth_date?->format('M d, Y') ?? '—' }}
                                            </td>

                                            {{-- Gender --}}
                                            <td class="clay-table-value whitespace-nowrap px-5 py-4 text-sm">
                                                {{ $resident->gender ?: '—' }}
                                            </td>

                                            {{-- Contact --}}
                                            <td class="clay-table-value whitespace-nowrap px-5 py-4 text-sm">
                                                {{ $resident->contact_number ?: '—' }}
                                            </td>

                                            {{-- Status --}}
                                            <td class="whitespace-nowrap px-5 py-4">

                                                @if ($resident->status === 'Active')

                                                    <span class="clay-status-active inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold">
                                                        <span class="status-dot h-1.5 w-1.5 rounded-full"></span>
                                                        Active
                                                    </span>

                                                @else

                                                    <span class="clay-status-inactive inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold">
                                                        <span class="status-dot h-1.5 w-1.5 rounded-full"></span>
                                                        Inactive
                                                    </span>

                                                @endif

                                            </td>

                                           {{-- Actions --}}
                                            <td class="whitespace-nowrap px-5 py-4">

                                                <div class="flex justify-end gap-2">

                                                    {{-- View --}}
                                                    <a
                                                        href="{{ route('residents.show', $resident) }}"
                                                        class="clay-action clay-action-view rounded-xl px-3 py-2 text-xs font-semibold"
                                                        title="View resident"
                                                    >
                                                        View
                                                    </a>

                                                    {{-- Edit --}}
                                                    <a
                                                        href="{{ route('residents.edit', $resident) }}"
                                                        class="clay-action clay-action-edit rounded-xl px-3 py-2 text-xs font-semibold"
                                                        title="Edit resident"
                                                    >
                                                        Edit
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form
                                                        method="POST"
                                                        action="{{ route('residents.destroy', $resident) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete {{ $resident->full_name }}? This action cannot be undone.');"
                                                    >
                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="clay-action clay-action-delete rounded-xl px-3 py-2 text-xs font-semibold"
                                                        >
                                                            Delete
                                                        </button>

                                                    </form>

                                                </div>

                                            </td>

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                        {{-- Mobile Cards --}}
                        <div class="space-y-3 p-4 md:hidden">

                            @foreach ($residents as $resident)

                                <div class="clay-mobile-card p-4">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="clay-avatar flex h-11 w-11 shrink-0 items-center justify-center rounded-xl font-semibold">
                                                {{ strtoupper(substr($resident->first_name, 0, 1)) }}{{ strtoupper(substr($resident->last_name, 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">

                                                <p class="clay-resident-name truncate font-semibold">
                                                    {{ $resident->full_name }}
                                                </p>

                                                <p class="clay-resident-email mt-0.5 text-xs">
                                                    {{ $resident->gender ?: 'Gender not provided' }}
                                                    ·
                                                    {{ $resident->birth_date?->format('M d, Y') ?? 'Birth date not provided' }}
                                                </p>

                                            </div>

                                        </div>

                                        @if ($resident->status === 'Active')

                                            <span class="clay-status-active shrink-0 rounded-full px-2 py-1 text-xs font-semibold">
                                                Active
                                            </span>

                                        @else

                                            <span class="clay-status-inactive shrink-0 rounded-full px-2 py-1 text-xs font-semibold">
                                                Inactive
                                            </span>

                                        @endif

                                    </div>

                                    <div class="mt-3 grid grid-cols-1 gap-2 text-xs">

                                        <div class="clay-mobile-detail px-3 py-2">
                                            <span class="font-semibold text-slate-700">
                                                Contact:
                                            </span>

                                            <span class="text-slate-500">
                                                {{ $resident->contact_number ?: 'Not provided' }}
                                            </span>
                                        </div>

                                        @if ($resident->household_address)

                                            <div class="clay-mobile-detail px-3 py-2">
                                                <span class="font-semibold text-slate-700">
                                                    Address:
                                                </span>

                                                <span class="text-slate-500">
                                                    {{ $resident->household_address }}
                                                </span>
                                            </div>

                                        @endif

                                    </div>

                                    <div class="mt-4 flex gap-2">

                                        <a
                                            href="{{ route('residents.show', $resident) }}"
                                            class="clay-action clay-action-view flex-1 rounded-xl px-3 py-2 text-center text-xs font-semibold"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('residents.edit', $resident) }}"
                                            class="clay-action clay-action-edit flex-1 rounded-xl px-3 py-2 text-center text-xs font-semibold"
                                        >
                                            Edit
                                        </a>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        {{-- Empty State --}}
                        <div class="px-6 py-16 text-center">

                            <div class="clay-empty-icon mx-auto flex h-16 w-16 items-center justify-center rounded-full">

                                <svg
                                    class="h-7 w-7"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                                    />

                                    <circle
                                        cx="9"
                                        cy="7"
                                        r="4"
                                        stroke-width="1.7"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-width="1.7"
                                        d="M19 8v6M22 11h-6"
                                    />
                                </svg>

                            </div>

                            <h3 class="clay-empty-title mt-4 text-base font-semibold">

                                @if ($search !== '')
                                    No residents found
                                @else
                                    No residents registered yet
                                @endif

                            </h3>

                            <p class="clay-empty-description mx-auto mt-1 max-w-md text-sm">

                                @if ($search !== '')
                                    Try adjusting your search or clear the current filter.
                                @else
                                    Start building the resident directory by adding the first resident record.
                                @endif

                            </p>

                            @if ($search !== '')

                                <a
                                    href="{{ route('residents.index') }}"
                                    class="clay-neutral-button mt-5 inline-flex items-center rounded-xl px-4 py-2 text-sm font-semibold"
                                >
                                    Clear Search
                                </a>

                            @else

                                <a
                                    href="{{ route('residents.create') }}"
                                    class="clay-primary-button mt-5 inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold"
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

                                    Add First Resident
                                </a>

                            @endif

                        </div>

                    @endif

                    {{-- Pagination --}}
                    @if ($residents->hasPages())

                        <div class="border-t border-slate-200 px-5 py-4">
                            {{ $residents->links() }}
                        </div>

                    @endif

                </div>

                {{-- Footer Information --}}
                <div class="clay-footer mt-5 flex flex-col gap-2 text-xs sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        Barangay Esperanza Health Center
                    </p>

                    <p>
                        Resident Records Management
                    </p>

                </div>

            </div>

        </main>

    </div>

    {{-- Mobile Sidebar Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.querySelector('aside');
            const overlay = document.getElementById('sidebar-overlay');
            const menuButton = document.getElementById('mobileMenuButton');

            if (!sidebar || !overlay || !menuButton) {
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

            menuButton.addEventListener('click', openSidebar);

            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {

                if (window.innerWidth >= 1024) {
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                }

            });

        });
    </script>

</body>
</html>