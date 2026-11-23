<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Health Visit Details | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM
        ========================================================= */

        .clay-health-visit-show {
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

        .clay-health-visit-show *,
        .clay-health-visit-show *::before,
        .clay-health-visit-show *::after {
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
                inset 0 1px 0 rgba(255, 255, 255, 0.90);
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
           HEADER BUTTON
        ========================================================= */

        .clay-header-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 13px !important;
            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.16),
                -5px -5px 10px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.80);
            transition:
                transform 0.18s ease,
                color 0.18s ease;
        }

        .clay-header-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           PAGE HEADER
        ========================================================= */

        .clay-page-header {
            position: relative;
            padding-left: 17px;
        }

        .clay-page-header::before {
            content: "";
            position: absolute;
            left: 0;
            top: 2px;
            bottom: 2px;
            width: 4px;
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow: 2px 2px 5px rgba(15, 111, 90, 0.18);
        }

        .clay-record-id {
            color: var(--text-muted) !important;
        }

        .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-page-date {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           PRIMARY ACTION
        ========================================================= */

        .clay-edit-button {
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

        .clay-edit-button:hover {
            transform: translateY(-2px);
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, 0.25),
                -5px -5px 11px rgba(255, 255, 255, 0.84),
                inset 1px 1px 0 rgba(255, 255, 255, 0.24);
        }

        /* =========================================================
           INFORMATION CARDS
        ========================================================= */

        .clay-info-section {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 24px !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.19),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-section-header {
            border-bottom-color: rgba(210, 225, 218, 0.64) !important;
        }

        .clay-section-icon {
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.80);
        }

        .clay-icon-green {
            background: linear-gradient(
                145deg,
                #E7F8F0,
                #D8EEE5
            ) !important;
            color: var(--primary-dark) !important;
        }

        .clay-icon-blue {
            background: linear-gradient(
                145deg,
                #EEF7F6,
                #DCEDEB
            ) !important;
            color: #277A70 !important;
        }

        .clay-icon-violet {
            background: linear-gradient(
                145deg,
                #F2F2FA,
                #E5E6F2
            ) !important;
            color: #64658C !important;
        }

        .clay-section-title {
            color: var(--text-dark) !important;
        }

        .clay-section-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           DETAIL VALUES
        ========================================================= */

        .clay-detail-label {
            color: var(--text-soft) !important;
        }

        .clay-detail-value {
            color: var(--text-dark) !important;
        }

        .clay-detail-secondary {
            color: var(--text-muted) !important;
        }

        .clay-detail-divider > * + * {
            border-color: rgba(210, 225, 218, 0.60) !important;
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

        .clay-empty-value {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           CLINICAL CONTENT
        ========================================================= */

        .clay-clinical-row + .clay-clinical-row {
            border-top: 1px solid rgba(210, 225, 218, 0.60);
        }

        .clay-clinical-text {
            color: var(--text-dark) !important;
        }

        .clay-clinical-empty {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           RECORD METADATA
        ========================================================= */

        .clay-metadata-section {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 20px !important;
            box-shadow:
                7px 7px 16px rgba(107, 134, 124, 0.16),
                -7px -7px 16px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-metadata-label {
            color: var(--text-muted) !important;
        }

        .clay-metadata-value {
            color: var(--text-dark) !important;
        }

        /* =========================================================
           BOTTOM ACTIONS
        ========================================================= */

        .clay-back-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 13px !important;
            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.15),
                -5px -5px 10px rgba(255, 255, 255, 0.90);
            transition:
                transform 0.18s ease,
                color 0.18s ease;
        }

        .clay-back-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           FOCUS / ACCESSIBILITY
        ========================================================= */

        .clay-health-visit-show a:focus-visible,
        .clay-health-visit-show button:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 639px) {
            .clay-page-header {
                padding-left: 13px;
            }

            .clay-page-header::before {
                width: 3px;
            }

            .clay-info-section {
                border-radius: 19px !important;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-health-visit-show *,
            .clay-health-visit-show *::before,
            .clay-health-visit-show *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<div class="clay-health-visit-show min-h-screen">

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Application Area --}}
    <div class="min-h-screen w-full lg:pl-72">

        {{-- Top Header --}}
        <header class="clay-top-header sticky top-0 z-30">

            <div class="flex min-h-20 items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">

                {{-- Left Side --}}
                <div class="flex min-w-0 items-center gap-4">

                    {{-- Mobile Menu Button --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-menu inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl transition lg:hidden"
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

                        <p class="clay-role-label text-xs font-semibold uppercase tracking-wider">
                            System Administrator
                        </p>

                        <h1 class="clay-header-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Health Visit Details
                        </h1>

                    </div>

                </div>

                {{-- Right Side --}}
                <div class="flex shrink-0 items-center gap-3">

                    @include('partials.notification-bell')

                    {{-- Profile --}}
                    <div class="flex items-center gap-3">

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

            <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

                {{-- =====================================================
                    PAGE HEADER
                ====================================================== --}}
                <div class="clay-page-header mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                    <div class="min-w-0">

                       

                        <h2 class="clay-page-title mt-1 break-words text-2xl font-bold tracking-tight sm:text-3xl">
                            {{ $healthVisit->resident->full_name }}
                        </h2>

                         <p class="clay-record-id text-sm font-medium">
                            Visit Record #{{ $healthVisit->id }}
                        </p>

                        

                    </div>

                    <div class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row">

                        <a
                            href="{{ route('health-visits.index') }}"
                            class="clay-back-button inline-flex w-full items-center justify-center px-5 py-3 text-sm font-semibold transition sm:w-auto"
                        >
                            Back to Health Visits
                        </a>

                        <a
                            href="{{ route('health-visits.edit', $healthVisit) }}"
                            class="clay-edit-button inline-flex w-full items-center justify-center gap-2 px-5 py-3 text-sm font-semibold transition sm:w-auto"
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
                                    stroke-width="1.8"
                                    d="m16.5 3.5 4 4M5 19l3.5-.7L19.8 7a1.4 1.4 0 0 0 0-2l-.8-.8a1.4 1.4 0 0 0-2 0L5.7 14.3 5 19Z"
                                />
                            </svg>

                            Edit Visit
                        </a>

                    </div>

                </div>

                {{-- =====================================================
                    RESIDENT INFORMATION
                ====================================================== --}}
                <section class="clay-info-section mb-6 overflow-hidden">

                    {{-- Section Header --}}
                    <div class="clay-section-header px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-section-icon clay-icon-green flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                        d="M15 20a6 6 0 0 0-12 0m6-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7-3v6m3-3h-6"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h3 class="clay-section-title font-bold">
                                    Resident Information
                                </h3>

                                <p class="clay-section-description mt-0.5 text-xs">
                                    Resident associated with this health visit.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Resident Details --}}
                    <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-4">

                        <div class="min-w-0">

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Full Name
                            </p>

                            <p class="clay-detail-value mt-1 break-words font-semibold">
                                {{ $healthVisit->resident->full_name }}
                            </p>

                        </div>

                        <div>

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Resident ID
                            </p>

                            <p class="clay-detail-value mt-1 font-semibold">
                                #{{ $healthVisit->resident->id }}
                            </p>

                        </div>

                        <div>

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Birth Date
                            </p>

                            <p class="clay-detail-value mt-1 font-semibold">
                                {{ $healthVisit->resident->birth_date?->format('F d, Y') ?? 'Not recorded' }}
                            </p>

                        </div>

                        <div>

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Gender
                            </p>

                            <p class="clay-detail-value mt-1 font-semibold">
                                {{ $healthVisit->resident->gender }}
                            </p>

                        </div>

                    </div>

                </section>

                {{-- =====================================================
                    VISIT INFORMATION
                ====================================================== --}}
                <section class="clay-info-section mb-6 overflow-hidden">

                    {{-- Section Header --}}
                    <div class="clay-section-header px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-section-icon clay-icon-blue flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                        d="M8 7V3m8 4V3m-9 4h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2Z"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h3 class="clay-section-title font-bold">
                                    Visit Information
                                </h3>

                                <p class="clay-section-description mt-0.5 text-xs">
                                    Basic details about the consultation.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Visit Details --}}
                    <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-4">

                        {{-- Visit Date --}}
                        <div>

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Visit Date
                            </p>

                            <p class="clay-detail-value mt-1 font-semibold">
                                {{ $healthVisit->visit_date->format('F d, Y') }}
                            </p>

                            <p class="clay-detail-secondary mt-1 text-xs">
                                {{ $healthVisit->visit_date->format('h:i A') }}
                            </p>

                        </div>

                        {{-- Visit Type --}}
                        <div>

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Visit Type
                            </p>

                            @if ($healthVisit->visit_type)

                                <span class="clay-visit-badge mt-2 inline-flex max-w-full rounded-full px-3 py-1 text-xs font-semibold">
                                    {{ $healthVisit->visit_type }}
                                </span>

                            @else

                                <p class="clay-empty-value mt-1 text-sm">
                                    Not specified
                                </p>

                            @endif

                        </div>

                        {{-- Attended By --}}
                        <div class="min-w-0">

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Attended By
                            </p>

                            <p class="clay-detail-value mt-1 break-words font-semibold">
                                {{ $healthVisit->attended_by ?: 'Not specified' }}
                            </p>

                        </div>

                        {{-- Recorded --}}
                        <div>

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Recorded
                            </p>

                            <p class="clay-detail-value mt-1 font-semibold">
                                {{ $healthVisit->created_at->format('M d, Y') }}
                            </p>

                            <p class="clay-detail-secondary mt-1 text-xs">
                                {{ $healthVisit->created_at->format('h:i A') }}
                            </p>

                        </div>

                    </div>

                </section>

                {{-- =====================================================
                    CLINICAL INFORMATION
                ====================================================== --}}
                <section class="clay-info-section mb-6 overflow-hidden">

                    {{-- Section Header --}}
                    <div class="clay-section-header px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-section-icon clay-icon-violet flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                        d="M9 3h6m-7 4h8m-8 4h8m-8 4h5m-8 5h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 002 2Z"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h3 class="clay-section-title font-bold">
                                    Clinical Information
                                </h3>

                                <p class="clay-section-description mt-0.5 text-xs">
                                    Clinical notes and care provided during the visit.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- Clinical Details --}}
                    <div class="clay-detail-divider">

                        {{-- Chief Complaint --}}
                        <div class="clay-clinical-row p-5 sm:p-6">

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Chief Complaint
                            </p>

                            @if ($healthVisit->chief_complaint)

                                <p class="clay-clinical-text mt-2 whitespace-pre-line break-words text-sm leading-7">
                                    {{ $healthVisit->chief_complaint }}
                                </p>

                            @else

                                <p class="clay-clinical-empty mt-2 text-sm italic">
                                    No chief complaint recorded.
                                </p>

                            @endif

                        </div>

                        {{-- Assessment --}}
                        <div class="clay-clinical-row p-5 sm:p-6">

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Assessment
                            </p>

                            @if ($healthVisit->assessment)

                                <p class="clay-clinical-text mt-2 whitespace-pre-line break-words text-sm leading-7">
                                    {{ $healthVisit->assessment }}
                                </p>

                            @else

                                <p class="clay-clinical-empty mt-2 text-sm italic">
                                    No assessment recorded.
                                </p>

                            @endif

                        </div>

                        {{-- Treatment --}}
                        <div class="clay-clinical-row p-5 sm:p-6">

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Treatment / Intervention
                            </p>

                            @if ($healthVisit->treatment)

                                <p class="clay-clinical-text mt-2 whitespace-pre-line break-words text-sm leading-7">
                                    {{ $healthVisit->treatment }}
                                </p>

                            @else

                                <p class="clay-clinical-empty mt-2 text-sm italic">
                                    No treatment or intervention recorded.
                                </p>

                            @endif

                        </div>

                        {{-- Remarks --}}
                        <div class="clay-clinical-row p-5 sm:p-6">

                            <p class="clay-detail-label text-xs font-semibold uppercase tracking-wide">
                                Remarks
                            </p>

                            @if ($healthVisit->remarks)

                                <p class="clay-clinical-text mt-2 whitespace-pre-line break-words text-sm leading-7">
                                    {{ $healthVisit->remarks }}
                                </p>

                            @else

                                <p class="clay-clinical-empty mt-2 text-sm italic">
                                    No additional remarks.
                                </p>

                            @endif

                        </div>

                    </div>

                </section>

                {{-- =====================================================
                    RECORD METADATA
                ====================================================== --}}
                <section class="clay-metadata-section overflow-hidden">

                    <div class="p-5 sm:p-6">

                        <div class="flex flex-col gap-3 text-xs sm:flex-row sm:items-center sm:justify-between">

                            <p class="clay-metadata-label">
                                Record ID:
                                <span class="clay-metadata-value font-semibold">
                                    #{{ $healthVisit->id }}
                                </span>
                            </p>

                            <p class="clay-metadata-label">
                                Last updated:
                                <span class="clay-metadata-value font-semibold">
                                    {{ $healthVisit->updated_at->format('F d, Y h:i A') }}
                                </span>
                            </p>

                        </div>

                    </div>

                </section>

            </div>

        </main>

    </div>

</div>

</body>
</html>