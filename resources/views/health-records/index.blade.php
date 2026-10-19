<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Health Records | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage health records for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA — HEALTH RECORDS
           Government-Style Claymorphism
        ========================================================== */

        :root {
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

            --clay-shadow:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84);

            --clay-small-shadow:
                4px 4px 10px rgba(107, 134, 124, .16),
                -4px -4px 10px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .75);

            --clay-inset:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82);
        }

        html {
            min-height: 100%;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(
                    circle at 8% 5%,
                    rgba(255, 255, 255, .78),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 94% 8%,
                    rgba(42, 155, 128, .08),
                    transparent 25%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                );
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif !important;
        }

        button,
        input,
        select,
        textarea,
        a {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-health-records {
            min-height: 100vh;
        }

        /* =========================================================
           MOBILE OVERLAY
        ========================================================== */

        .clay-health-records #sidebar-overlay {
            background: rgba(22, 66, 56, .28) !important;
            backdrop-filter: blur(4px);
        }

        /* =========================================================
           TOP HEADER
        ========================================================== */

        .clay-health-records .clay-top-header {
            min-height: 80px;
            border-bottom: 1px solid rgba(210, 225, 218, .75) !important;
            background: rgba(245, 250, 247, .94) !important;
            box-shadow:
                0 5px 18px rgba(107, 134, 124, .08),
                inset 0 -1px 0 rgba(255, 255, 255, .85);
            backdrop-filter: blur(14px);
        }

        .clay-health-records .clay-mobile-menu {
            height: 42px;
            width: 42px;
            border-radius: 13px;
            color: var(--primary-dark);
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid rgba(255, 255, 255, .9);
            box-shadow: var(--clay-small-shadow);
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                color .2s ease;
        }

        .clay-health-records .clay-mobile-menu:hover {
            color: var(--primary);
            transform: translateY(-1px);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .20),
                -5px -5px 12px rgba(255, 255, 255, .94);
        }

        .clay-health-records .clay-role-label {
            color: var(--primary-dark) !important;
            letter-spacing: .18em;
        }

        .clay-health-records .clay-header-title {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-profile {
            border-color: rgba(210, 225, 218, .75) !important;
        }

        .clay-health-records .clay-profile-avatar {
            background:
                linear-gradient(
                    145deg,
                    var(--primary-light),
                    var(--primary-dark)
                ) !important;
            color: #FFFFFF !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .18),
                -4px -4px 10px rgba(255, 255, 255, .85),
                inset 1px 1px 0 rgba(255, 255, 255, .28);
        }

        /* =========================================================
           PAGE WRAPPER
        ========================================================== */

        .clay-health-records .clay-page {
            max-width: 1440px;
            margin: 0 auto;
        }

        /* =========================================================
           BREADCRUMB
        ========================================================== */

        .clay-health-records .clay-breadcrumb {
            color: var(--text-soft) !important;
        }

        .clay-health-records .clay-breadcrumb a {
            color: var(--text-muted) !important;
            transition: color .2s ease;
        }

        .clay-health-records .clay-breadcrumb a:hover {
            color: var(--primary) !important;
        }

        .clay-health-records .clay-breadcrumb-current {
            color: var(--text-dark) !important;
        }

        /* =========================================================
           PAGE HEADING
        ========================================================== */

        .clay-health-records .clay-page-heading {
            position: relative;
            padding-left: 18px;
        }

        .clay-health-records .clay-page-heading::before {
            content: "";
            position: absolute;
            left: 0;
            top: 2px;
            bottom: 2px;
            width: 4px;
            border-radius: 999px;
            background:
                linear-gradient(
                    180deg,
                    var(--primary-light),
                    var(--primary-dark)
                );
            box-shadow: 1px 2px 5px rgba(22, 139, 112, .20);
        }

        .clay-health-records .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-page-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           PRIMARY ACTION
        ========================================================== */

        .clay-health-records .clay-primary-button {
            min-height: 44px;
            border-radius: 13px !important;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(
                    145deg,
                    var(--primary-light),
                    var(--primary-dark)
                ) !important;
            color: #FFFFFF !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .20),
                -5px -5px 12px rgba(255, 255, 255, .82),
                inset 1px 1px 0 rgba(255, 255, 255, .24) !important;
            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .clay-health-records .clay-primary-button:hover {
            transform: translateY(-1px);
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, .23),
                -7px -7px 15px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .28) !important;
        }

        /* =========================================================
           SUCCESS ALERT
        ========================================================== */

        .clay-health-records .clay-success-alert {
            border: 1px solid rgba(22, 139, 112, .16) !important;
            border-radius: 18px;
            background:
                linear-gradient(145deg, #F7FCF9, #E5F2EC) !important;
            box-shadow:
                6px 6px 15px rgba(107, 134, 124, .13),
                -6px -6px 15px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .85);
            color: var(--primary-dark) !important;
        }

        .clay-health-records .clay-success-alert svg {
            color: var(--primary) !important;
        }

        /* =========================================================
           SEARCH CARD
        ========================================================== */

        .clay-health-records .clay-search-card {
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            box-shadow: var(--clay-shadow);
        }

        .clay-health-records .clay-search-input {
            border: 1px solid rgba(210, 225, 218, .85) !important;
            border-radius: 14px !important;
            background:
                linear-gradient(145deg, #EDF5F0, #F8FCFA) !important;
            color: var(--text-dark) !important;
            box-shadow: var(--clay-inset);
            outline: none !important;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease;
        }

        .clay-health-records .clay-search-input::placeholder {
            color: var(--text-soft) !important;
            opacity: 1;
        }

        .clay-health-records .clay-search-input:focus {
            border-color: rgba(22, 139, 112, .62) !important;
            background:
                linear-gradient(145deg, #F1F8F4, #FBFEFC) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .90),
                0 0 0 3px rgba(22, 139, 112, .10) !important;
        }

        .clay-health-records .clay-search-icon {
            color: var(--text-soft) !important;
        }

        .clay-health-records .clay-search-button {
            min-height: 44px;
            border-radius: 13px !important;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #315F53, #234E43) !important;
            color: #FFFFFF !important;
            box-shadow: var(--clay-small-shadow);
            transition:
                transform .2s ease,
                box-shadow .2s ease;
        }

        .clay-health-records .clay-search-button:hover {
            transform: translateY(-1px);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .20),
                -5px -5px 12px rgba(255, 255, 255, .90);
        }

        .clay-health-records .clay-clear-button {
            min-height: 44px;
            border-radius: 13px !important;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #F8FCFA, #E7EFEB) !important;
            color: var(--text-muted) !important;
            box-shadow: var(--clay-small-shadow);
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                color .2s ease;
        }

        .clay-health-records .clay-clear-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           SUMMARY CARD
        ========================================================== */

        .clay-health-records .clay-summary-card {
            border-radius: 22px;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            box-shadow: var(--clay-shadow);
        }

        .clay-health-records .clay-summary-label {
            color: var(--text-soft) !important;
        }

        .clay-health-records .clay-summary-number {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-summary-caption {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           DIRECTORY CARD
        ========================================================== */

        .clay-health-records .clay-directory {
            overflow: hidden;
            border-radius: 26px;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            box-shadow: var(--clay-shadow);
        }

        .clay-health-records .clay-directory-header {
            border-bottom: 1px solid rgba(210, 225, 218, .65) !important;
            background: rgba(245, 250, 247, .42);
        }

        .clay-health-records .clay-directory-title {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-directory-description,
        .clay-health-records .clay-search-results {
            color: var(--text-muted) !important;
        }

        .clay-health-records .clay-search-results strong {
            color: var(--text-dark) !important;
        }

        /* =========================================================
           DESKTOP TABLE
        ========================================================== */

        .clay-health-records .clay-table {
            border-collapse: separate;
            border-spacing: 0;
        }

        .clay-health-records .clay-table thead {
            background:
                linear-gradient(
                    145deg,
                    #EDF6F1,
                    #E3EFE9
                ) !important;
        }

        .clay-health-records .clay-table th {
            color: var(--text-muted) !important;
            border-bottom: 1px solid rgba(210, 225, 218, .72) !important;
        }

        .clay-health-records .clay-table tbody tr {
            border-bottom: 1px solid rgba(210, 225, 218, .58);
            transition:
                background .2s ease,
                transform .2s ease;
        }

        .clay-health-records .clay-table tbody tr:last-child {
            border-bottom: none;
        }

        .clay-health-records .clay-table tbody tr:hover {
            background: rgba(255, 255, 255, .50) !important;
        }

        .clay-health-records .clay-resident-avatar {
            height: 42px;
            width: 42px;
            border-radius: 13px;
            background:
                linear-gradient(
                    145deg,
                    var(--primary-light),
                    var(--primary-dark)
                ) !important;
            color: #FFFFFF !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .18),
                -4px -4px 9px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .25);
        }

        .clay-health-records .clay-resident-name {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-resident-id {
            color: var(--text-soft) !important;
        }

        .clay-health-records .clay-table-text {
            color: var(--text-muted) !important;
        }

        .clay-health-records .clay-empty-text {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           BLOOD TYPE BADGE
        ========================================================== */

        .clay-health-records .clay-blood-badge {
            border: 1px solid rgba(22, 139, 112, .10);
            background:
                linear-gradient(145deg, #EAF8F1, #DCEFE6) !important;
            color: var(--primary-dark) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .11),
                -3px -3px 7px rgba(255, 255, 255, .78);
        }

        .clay-health-records .clay-muted-badge {
            border: 1px solid rgba(210, 225, 218, .72);
            background:
                linear-gradient(145deg, #F0F5F2, #E4ECE8) !important;
            color: var(--text-muted) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .10),
                -3px -3px 7px rgba(255, 255, 255, .78);
        }

        /* =========================================================
           ACTION BUTTONS
        ========================================================== */

        .clay-health-records .clay-action {
            min-height: 38px;
            border-radius: 11px !important;
            border: 1px solid rgba(255, 255, 255, .88) !important;
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                color .2s ease,
                background .2s ease;
        }

        .clay-health-records .clay-action-neutral {
            background:
                linear-gradient(145deg, #F8FCFA, #E7EFEB) !important;
            color: var(--text-muted) !important;
            box-shadow: var(--clay-small-shadow);
        }

        .clay-health-records .clay-action-neutral:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .clay-health-records .clay-action-green {
            background:
                linear-gradient(145deg, #EFF9F4, #DCEFE6) !important;
            color: var(--primary-dark) !important;
            box-shadow: var(--clay-small-shadow);
        }

        .clay-health-records .clay-action-green:hover {
            transform: translateY(-1px);
        }

        .clay-health-records .clay-action-danger {
            background:
                linear-gradient(145deg, #FFF7F7, #F7E7E7) !important;
            color: var(--danger) !important;
            box-shadow: var(--clay-small-shadow);
        }

        .clay-health-records .clay-action-danger:hover {
            transform: translateY(-1px);
            color: #8F2424 !important;
        }

        /* =========================================================
           MOBILE RECORD CARDS
        ========================================================== */

        .clay-health-records .clay-mobile-record {
            margin: 14px;
            padding: 17px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, .90);
            background:
                linear-gradient(145deg, #F8FCFA, #EAF2EE);
            box-shadow: var(--clay-small-shadow);
        }

        .clay-health-records .clay-mobile-record + .clay-mobile-record {
            margin-top: 16px;
        }

        .clay-health-records .clay-mobile-detail {
            color: var(--text-muted) !important;
        }

        .clay-health-records .clay-mobile-detail strong {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-mobile-actions {
            border-top: 1px solid rgba(210, 225, 218, .62);
        }

        /* =========================================================
           EMPTY STATE
        ========================================================== */

        .clay-health-records .clay-empty-state {
            padding: 64px 24px;
        }

        .clay-health-records .clay-empty-icon {
            height: 62px;
            width: 62px;
            border-radius: 20px;
            background:
                linear-gradient(145deg, #EDF7F2, #DDEDE5) !important;
            color: var(--primary) !important;
            box-shadow: var(--clay-inset);
        }

        .clay-health-records .clay-empty-title {
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-empty-description {
            color: var(--text-muted) !important;
        }

        .clay-health-records .clay-empty-secondary {
            min-height: 42px;
            border-radius: 13px !important;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #F8FCFA, #E7EFEB) !important;
            color: var(--text-muted) !important;
            box-shadow: var(--clay-small-shadow);
            transition: transform .2s ease;
        }

        .clay-health-records .clay-empty-secondary:hover {
            transform: translateY(-1px);
            color: var(--text-dark) !important;
        }

        .clay-health-records .clay-empty-primary {
            min-height: 44px;
            border-radius: 13px !important;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(
                    145deg,
                    var(--primary-light),
                    var(--primary-dark)
                ) !important;
            color: #FFFFFF !important;
            box-shadow: var(--clay-small-shadow);
            transition: transform .2s ease;
        }

        .clay-health-records .clay-empty-primary:hover {
            transform: translateY(-1px);
        }

        /* =========================================================
           PAGINATION
        ========================================================== */

        .clay-health-records .clay-pagination {
            border-top: 1px solid rgba(210, 225, 218, .68) !important;
            background: rgba(245, 250, 247, .32);
        }

        /* =========================================================
           FOOTER
        ========================================================== */

        .clay-health-records .clay-footer {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================== */

        .clay-health-records a:focus-visible,
        .clay-health-records button:focus-visible,
        .clay-health-records input:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 639px) {
            .clay-health-records .clay-page-heading {
                padding-left: 14px;
            }

            .clay-health-records .clay-page-title {
                font-size: 1.55rem !important;
            }

            .clay-health-records .clay-directory {
                border-radius: 21px;
            }

            .clay-health-records .clay-search-card {
                border-radius: 21px;
            }

            .clay-health-records .clay-summary-card {
                border-radius: 20px;
            }

            .clay-health-records .clay-primary-button {
                width: 100%;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {
            .clay-health-records *,
            .clay-health-records *::before,
            .clay-health-records *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<div class="clay-health-records min-h-screen">

    {{-- =========================================================
         MOBILE OVERLAY
    ========================================================== --}}
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden lg:hidden"
    ></div>

    {{-- =========================================================
         SIDEBAR
    ========================================================== --}}
    @include('dashboard.sidebar')

    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <main class="lg:pl-72">

        {{-- Top Header --}}
        <header class="clay-top-header sticky top-0 z-30">

            <div class="flex min-h-20 items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">

                {{-- Left Side --}}
                <div class="flex min-w-0 items-center gap-4">

                    {{-- Mobile Menu Button --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-menu inline-flex shrink-0 items-center justify-center lg:hidden"
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

                    <div class="min-w-0">
                        <p class="clay-role-label text-xs font-semibold uppercase">
                            System Administrator
                        </p>

                        <h1 class="clay-header-title mt-1 text-xl font-bold tracking-tight sm:text-2xl">
                            Health Records
                        </h1>
                    </div>

                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    @include('partials.notification-bell')

                    {{-- Profile --}}
                    <div class="clay-profile flex items-center gap-3">

                        <div class="hidden text-right sm:block">
                            <p class="truncate text-sm font-semibold text-[#234E43]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="truncate text-xs text-[#6D817A]">
                                System Administrator
                            </p>
                        </div>

                        <div class="clay-profile-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </div>

        </header>

        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}
        <div class="px-4 py-6 sm:px-6 lg:px-8">

            <div class="clay-page">

                

                {{-- =================================================
                     PAGE HEADING
                ================================================== --}}
                <div class="clay-page-heading mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                            Health Records
                        </h2>

                        <p class="clay-page-description mt-1 max-w-2xl text-sm">
                            Manage and maintain medical information registered
                            with Barangay Esperanza Health Center.
                        </p>
                    </div>

                    {{-- Add Health Record --}}
                    <a
                        href="{{ route('health-records.create') }}"
                        class="clay-primary-button inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold"
                    >
                        Add Health Record
                    </a>

                </div>

                {{-- =================================================
                     SUCCESS MESSAGE
                ================================================== --}}
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

                        <p>
                            {{ session('success') }}
                        </p>

                    </div>

                @endif

                {{-- =================================================
                     SEARCH + SUMMARY
                ================================================== --}}
                <div class="mb-6 grid gap-5 lg:grid-cols-[1fr_auto]">

                    {{-- Search --}}
                    <form
                        method="GET"
                        action="{{ route('health-records.index') }}"
                        class="clay-search-card p-4"
                    >

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <div class="relative flex-1">

                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                                    <svg
                                        class="clay-search-icon h-5 w-5"
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
                                    placeholder="Search by resident name or PhilHealth number..."
                                    class="clay-search-input w-full py-2.5 pl-10 pr-4 text-sm"
                                >

                            </div>

                            <button
                                type="submit"
                                class="clay-search-button inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold"
                            >
                                Search
                            </button>

                            @if ($search !== '')

                                <a
                                    href="{{ route('health-records.index') }}"
                                    class="clay-clear-button inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold"
                                >
                                    Clear
                                </a>

                            @endif

                        </div>

                    </form>

                    {{-- Summary --}}
                    <div class="clay-summary-card px-6 py-5">

                        <p class="clay-summary-label text-xs font-semibold uppercase tracking-[0.12em]">
                            Records
                        </p>

                        <p class="clay-summary-number mt-1 text-3xl font-bold">
                            {{ $healthRecords->total() }}
                        </p>

                        <p class="clay-summary-caption text-xs">
                            Registered health records
                        </p>

                    </div>

                </div>

                {{-- =================================================
                     HEALTH RECORDS TABLE
                ================================================== --}}
                <div class="clay-directory">

                    {{-- Table Header --}}
                    <div class="clay-directory-header flex flex-col gap-2 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">

                        <div>
                            <h3 class="clay-directory-title font-semibold">
                                Health Record Directory
                            </h3>

                            <p class="clay-directory-description mt-0.5 text-xs">
                                Medical information currently registered in the system.
                            </p>
                        </div>

                        @if ($search !== '')

                            <p class="clay-search-results text-xs">
                                Search results for

                                <span class="font-semibold">
                                    "{{ $search }}"
                                </span>
                            </p>

                        @endif

                    </div>

                    @if ($healthRecords->count())

                        {{-- =================================================
                             DESKTOP TABLE
                        ================================================== --}}
                        <div class="hidden overflow-x-auto md:block">

                            <table class="clay-table min-w-full">

                                <thead>

                                    <tr>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em]">
                                            Resident
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em]">
                                            Blood Type
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em]">
                                            Allergies
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em]">
                                            Chronic Conditions
                                        </th>

                                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-[0.08em]">
                                            Emergency Contact
                                        </th>

                                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-[0.08em]">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($healthRecords as $healthRecord)

                                        <tr>

                                            {{-- Resident --}}
                                            <td class="whitespace-nowrap px-5 py-4">

                                                <div class="flex items-center gap-3">

                                                    <div class="clay-resident-avatar flex shrink-0 items-center justify-center font-semibold">

                                                        {{ strtoupper(substr($healthRecord->resident->first_name, 0, 1)) }}{{ strtoupper(substr($healthRecord->resident->last_name, 0, 1)) }}

                                                    </div>

                                                    <div class="min-w-0">

                                                        <p class="clay-resident-name truncate font-semibold">
                                                            {{ $healthRecord->resident->full_name }}
                                                        </p>

                                                        <p class="clay-resident-id truncate text-xs">
                                                            Resident ID #{{ $healthRecord->resident_id }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </td>

                                            {{-- Blood Type --}}
                                            <td class="whitespace-nowrap px-5 py-4">

                                                @if ($healthRecord->blood_type)

                                                    <span class="clay-blood-badge inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold">
                                                        {{ $healthRecord->blood_type }}
                                                    </span>

                                                @else

                                                    <span class="clay-empty-text text-sm">
                                                        —
                                                    </span>

                                                @endif

                                            </td>

                                            {{-- Allergies --}}
                                            <td class="max-w-xs px-5 py-4">

                                                @if ($healthRecord->allergies)

                                                    <p
                                                        class="clay-table-text line-clamp-2 text-sm"
                                                        title="{{ $healthRecord->allergies }}"
                                                    >
                                                        {{ $healthRecord->allergies }}
                                                    </p>

                                                @else

                                                    <span class="clay-empty-text text-sm">
                                                        None recorded
                                                    </span>

                                                @endif

                                            </td>

                                            {{-- Chronic Conditions --}}
                                            <td class="max-w-xs px-5 py-4">

                                                @if ($healthRecord->chronic_conditions)

                                                    <p
                                                        class="clay-table-text line-clamp-2 text-sm"
                                                        title="{{ $healthRecord->chronic_conditions }}"
                                                    >
                                                        {{ $healthRecord->chronic_conditions }}
                                                    </p>

                                                @else

                                                    <span class="clay-empty-text text-sm">
                                                        None recorded
                                                    </span>

                                                @endif

                                            </td>

                                            {{-- Emergency Contact --}}
                                            <td class="max-w-xs px-5 py-4">

                                                @if ($healthRecord->emergency_contact_name)

                                                    <p class="truncate text-sm font-medium text-[#234E43]">
                                                        {{ $healthRecord->emergency_contact_name }}
                                                    </p>

                                                    @if ($healthRecord->emergency_contact_number)

                                                        <p class="mt-0.5 text-xs text-[#9AA9A4]">
                                                            {{ $healthRecord->emergency_contact_number }}
                                                        </p>

                                                    @endif

                                                @else

                                                    <span class="clay-empty-text text-sm">
                                                        Not provided
                                                    </span>

                                                @endif

                                            </td>

                                            {{-- Actions --}}
                                            <td class="whitespace-nowrap px-5 py-4">

                                                <div class="flex justify-end gap-2">

                                                    {{-- View --}}
                                                    <a
                                                        href="{{ route('health-records.show', $healthRecord) }}"
                                                        class="clay-action clay-action-neutral inline-flex items-center justify-center px-3 py-2 text-sm font-semibold"
                                                        title="View health record"
                                                    >
                                                        View
                                                    </a>

                                                    {{-- Edit --}}
                                                    <a
                                                        href="{{ route('health-records.edit', $healthRecord) }}"
                                                        class="clay-action clay-action-green inline-flex items-center justify-center px-3 py-2 text-sm font-semibold"
                                                        title="Edit health record"
                                                    >
                                                        Edit
                                                    </a>

                                                    {{-- Delete --}}
                                                    <form
                                                        method="POST"
                                                        action="{{ route('health-records.destroy', $healthRecord) }}"
                                                        class="inline"
                                                        onsubmit="return confirm('Are you sure you want to delete the health record of {{ $healthRecord->resident->full_name }}? This action cannot be undone.');"
                                                    >

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="clay-action clay-action-danger inline-flex items-center justify-center px-3 py-2 text-sm font-semibold"
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

                        {{-- =================================================
                             MOBILE CARDS
                        ================================================== --}}
                        <div class="md:hidden">

                            @foreach ($healthRecords as $healthRecord)

                                <div class="clay-mobile-record">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="flex min-w-0 items-center gap-3">

                                            <div class="clay-resident-avatar flex h-11 w-11 shrink-0 items-center justify-center font-semibold">

                                                {{ strtoupper(substr($healthRecord->resident->first_name, 0, 1)) }}{{ strtoupper(substr($healthRecord->resident->last_name, 0, 1)) }}

                                            </div>

                                            <div class="min-w-0">

                                                <p class="clay-resident-name truncate font-semibold">
                                                    {{ $healthRecord->resident->full_name }}
                                                </p>

                                                <p class="clay-resident-id mt-0.5 text-xs">
                                                    Resident ID #{{ $healthRecord->resident_id }}
                                                </p>

                                            </div>

                                        </div>

                                        @if ($healthRecord->blood_type)

                                            <span class="clay-blood-badge shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold">
                                                {{ $healthRecord->blood_type }}
                                            </span>

                                        @else

                                            <span class="clay-muted-badge shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold">
                                                Blood type —
                                            </span>

                                        @endif

                                    </div>

                                    <div class="mt-4 grid grid-cols-1 gap-2 text-xs">

                                        <div class="clay-mobile-detail">
                                            <span class="font-semibold">
                                                Allergies:
                                            </span>

                                            {{ $healthRecord->allergies ?: 'None recorded' }}
                                        </div>

                                        <div class="clay-mobile-detail">
                                            <span class="font-semibold">
                                                Chronic Conditions:
                                            </span>

                                            {{ $healthRecord->chronic_conditions ?: 'None recorded' }}
                                        </div>

                                        @if ($healthRecord->emergency_contact_name)

                                            <div class="clay-mobile-detail">

                                                <span class="font-semibold">
                                                    Emergency Contact:
                                                </span>

                                                {{ $healthRecord->emergency_contact_name }}

                                                @if ($healthRecord->emergency_contact_number)
                                                    · {{ $healthRecord->emergency_contact_number }}
                                                @endif

                                            </div>

                                        @endif

                                    </div>

                                    <div class="clay-mobile-actions mt-4 flex gap-2 pt-4">

                                        <a
                                            href="{{ route('health-records.show', $healthRecord) }}"
                                            class="clay-action clay-action-neutral flex-1 px-3 py-2 text-center text-xs font-semibold"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('health-records.edit', $healthRecord) }}"
                                            class="clay-action clay-action-green flex-1 px-3 py-2 text-center text-xs font-semibold"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('health-records.destroy', $healthRecord) }}"
                                            class="flex-1"
                                            onsubmit="return confirm('Are you sure you want to delete the health record of {{ $healthRecord->resident->full_name }}? This action cannot be undone.');"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="clay-action clay-action-danger w-full px-3 py-2 text-center text-xs font-semibold"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        {{-- =================================================
                             EMPTY STATE
                        ================================================== --}}
                        <div class="clay-empty-state text-center">

                            <div class="clay-empty-icon mx-auto flex items-center justify-center">

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
                                        d="M9 12h6m-6 4h4M7 3h7l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.7"
                                        d="M14 3v5h5"
                                    />
                                </svg>

                            </div>

                            <h3 class="clay-empty-title mt-5 text-base font-semibold">

                                @if ($search !== '')

                                    No health records found

                                @else

                                    No health records registered yet

                                @endif

                            </h3>

                            <p class="clay-empty-description mx-auto mt-1 max-w-md text-sm">

                                @if ($search !== '')

                                    Try adjusting your search or clear the current filter.

                                @else

                                    Start maintaining resident medical information
                                    by adding the first health record.

                                @endif

                            </p>

                            @if ($search !== '')

                                <a
                                    href="{{ route('health-records.index') }}"
                                    class="clay-empty-secondary mt-5 inline-flex items-center justify-center px-4 py-2 text-sm font-semibold"
                                >
                                    Clear Search
                                </a>

                            @else

                                <a
                                    href="{{ route('health-records.create') }}"
                                    class="clay-empty-primary mt-5 inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold"
                                >
                                    Add First Health Record
                                </a>

                            @endif

                        </div>

                    @endif

                    {{-- =================================================
                         PAGINATION
                    ================================================== --}}
                    @if ($healthRecords->hasPages())

                        <div class="clay-pagination px-5 py-4">

                            {{ $healthRecords->links() }}

                        </div>

                    @endif

                </div>

                {{-- =================================================
                     FOOTER INFORMATION
                ================================================== --}}
                <div class="clay-footer mt-6 flex flex-col gap-2 text-xs sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        Barangay Esperanza Health Center
                    </p>

                    <p>
                        Health Records Management
                    </p>

                </div>

            </div>

        </div>

    </main>

</div>

{{-- =============================================================
     MOBILE SIDEBAR SCRIPT
============================================================== --}}
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