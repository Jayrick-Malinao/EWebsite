<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Health Record | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="View a resident health record at Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM
        ========================================================= */

        .clay-health-record {
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
            color: var(--text);
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

        .clay-health-record *,
        .clay-health-record *::before,
        .clay-health-record *::after {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        /* =========================================================
           HEADER
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
            border: 1px solid rgba(255, 255, 255, 0.82) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.16),
                -4px -4px 9px rgba(255, 255, 255, 0.92);
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

        .clay-notification {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.86) !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.16),
                -4px -4px 9px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-notification:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        .clay-notification-dot {
            background: var(--primary) !important;
            box-shadow: 0 0 0 2px #F5FAF7 !important;
        }

        .clay-profile {
            border-color: rgba(210, 225, 218, 0.72) !important;
        }

        .clay-profile-avatar {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.18),
                -4px -4px 9px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.22);
        }

        .clay-profile-name {
            color: var(--text-dark) !important;
        }

        .clay-profile-role {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           PAGE
        ========================================================= */

        .clay-page {
            color: var(--text);
        }

        .clay-breadcrumb {
            color: var(--text-soft) !important;
        }

        .clay-breadcrumb a {
            color: var(--text-muted) !important;
        }

        .clay-breadcrumb a:hover {
            color: var(--primary-dark) !important;
        }

        .clay-breadcrumb-current {
            color: var(--text-dark) !important;
        }

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

        .clay-eyebrow {
            color: var(--primary-dark) !important;
        }

        .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-page-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           CLAY BUTTONS
        ========================================================= */

        .clay-edit-button {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.25) !important;
            border-radius: 13px !important;
            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.22),
                -4px -4px 10px rgba(255, 255, 255, 0.78),
                inset 1px 1px 0 rgba(255, 255, 255, 0.22);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-edit-button:hover {
            background: linear-gradient(
                145deg,
                #35A98C,
                #0F765F
            ) !important;
            transform: translateY(-2px);
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, 0.25),
                -5px -5px 11px rgba(255, 255, 255, 0.82),
                inset 1px 1px 0 rgba(255, 255, 255, 0.24);
        }

        .clay-back-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--text-muted) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            border-radius: 13px !important;
            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.18),
                -5px -5px 11px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                color 0.18s ease;
        }

        .clay-back-button:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
            box-shadow:
                6px 6px 13px rgba(107, 134, 124, 0.20),
                -5px -5px 11px rgba(255, 255, 255, 0.94);
        }

        /* =========================================================
           PROFILE / RESIDENT SUMMARY
        ========================================================= */

        .clay-profile-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 22px !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.22),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-profile-avatar-large {
            background: linear-gradient(
                145deg,
                #DDF3EA,
                #C9E9DD
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.86) !important;
            box-shadow:
                inset 4px 4px 8px rgba(107, 134, 124, 0.10),
                inset -4px -4px 8px rgba(255, 255, 255, 0.88),
                3px 3px 8px rgba(107, 134, 124, 0.12);
        }

        .clay-profile-card h3 {
            color: var(--text-dark) !important;
        }

        .clay-profile-id {
            color: var(--text-muted) !important;
        }

        .clay-active-badge {
            background: linear-gradient(
                145deg,
                #E5F7EF,
                #D6EFE5
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.88) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.12),
                -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           INFORMATION CARDS
        ========================================================= */

        .clay-info-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 22px !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.20),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            overflow: hidden;
        }

        .clay-section-header {
            background: linear-gradient(
                145deg,
                rgba(248, 252, 250, 0.92),
                rgba(237, 245, 240, 0.82)
            ) !important;
            border-bottom: 1px solid rgba(210, 225, 218, 0.65) !important;
        }

        .clay-section-icon {
            background: linear-gradient(
                145deg,
                #DDF3EA,
                #C9E9DD
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.86) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.13),
                -3px -3px 7px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-section-title {
            color: var(--text-dark) !important;
        }

        .clay-section-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           BASIC INFORMATION
        ========================================================= */

        .clay-basic-grid {
            background: transparent !important;
        }

        .clay-basic-item {
            background: linear-gradient(
                145deg,
                #F3F9F6,
                #E9F2ED
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.84) !important;
            border-radius: 15px !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.84);
        }

        .clay-field-label {
            color: var(--text-soft) !important;
        }

        .clay-field-value {
            color: var(--text-dark) !important;
        }

        .clay-field-value-muted {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           MEDICAL INFORMATION
        ========================================================= */

        .clay-medical-item {
            background: linear-gradient(
                145deg,
                #F3F9F6,
                #E9F2ED
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.84) !important;
            border-radius: 17px !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.82),
                inset 1px 1px 0 rgba(255, 255, 255, 0.76);
        }

        .clay-medical-label {
            color: var(--text-soft) !important;
        }

        .clay-medical-value {
            color: var(--text-dark) !important;
        }

        .clay-empty-value {
            color: var(--text-muted) !important;
            font-style: italic;
        }

        /* =========================================================
           EMERGENCY CONTACT
        ========================================================= */

        .clay-emergency-item {
            background: linear-gradient(
                145deg,
                #F3F9F6,
                #E9F2ED
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.84) !important;
            border-radius: 15px !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.84);
        }

        /* =========================================================
           NOTES
        ========================================================= */

        .clay-notes {
            background: linear-gradient(
                145deg,
                #F3F9F6,
                #E9F2ED
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.84) !important;
            border-radius: 16px !important;
            box-shadow:
                inset 3px 3px 8px rgba(107, 134, 124, 0.09),
                inset -3px -3px 8px rgba(255, 255, 255, 0.86);
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .clay-footer {
            color: var(--text-soft) !important;
            border-top: 1px solid rgba(210, 225, 218, 0.55);
        }

        /* =========================================================
           FOCUS / ACCESSIBILITY
        ========================================================= */

        .clay-health-record a:focus-visible,
        .clay-health-record button:focus-visible {
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

            .clay-profile-card,
            .clay-info-card {
                border-radius: 18px !important;
            }

            .clay-medical-item {
                border-radius: 15px !important;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-health-record *,
            .clay-health-record *::before,
            .clay-health-record *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<div class="clay-health-record min-h-screen">

    {{-- Mobile Overlay --}}
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"
    ></div>

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    <main class="lg:pl-72">

        {{-- Header --}}
        <header class="clay-top-header sticky top-0 z-30">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                <button
                    type="button"
                    id="mobileMenuButton"
                    class="clay-mobile-menu flex h-10 w-10 items-center justify-center rounded-xl transition lg:hidden"
                    aria-label="Open navigation"
                >
                    <svg
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>

                <div class="hidden sm:block">
                    <p class="clay-role-label text-xs font-semibold uppercase tracking-wider">
                        {{ auth()->user()->role }}
                    </p>

                    <h1 class="clay-header-title mt-0.5 text-lg font-bold">
                        Health Records
                    </h1>
                </div>

                <div class="ml-auto flex items-center gap-2 sm:gap-3">

                    <button
                        type="button"
                        class="clay-notification relative flex h-10 w-10 items-center justify-center rounded-xl transition"
                        aria-label="Notifications"
                    >
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
                                d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z"
                            />
                            <path
                                stroke-linecap="round"
                                d="M10 21h4"
                            />
                        </svg>

                        <span class="clay-notification-dot absolute right-2 top-2 h-2 w-2 rounded-full ring-2"></span>
                    </button>

                    <div class="clay-profile hidden items-center gap-3 border-l pl-3 sm:flex">

                        <div class="clay-profile-avatar flex h-9 w-9 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="max-w-40">

                            <p class="clay-profile-name truncate text-sm font-semibold">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="clay-profile-role truncate text-xs">
                                {{ auth()->user()->role }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </header>

        {{-- Page --}}
        <div class="clay-page px-4 py-6 sm:px-6 lg:px-8">

            {{-- Heading --}}
            <div class="clay-page-heading mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div>


                    <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                        Health Record
                    </h2>

                    <p class="clay-page-description mt-1 max-w-2xl text-sm">
                        View the complete medical information registered for this resident.
                    </p>

                </div>

                <div class="flex flex-col gap-2 sm:flex-row">

                    <a
                        href="{{ route('health-records.edit', $healthRecord) }}"
                        class="clay-edit-button inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold transition"
                    >
                        Edit Record
                    </a>

                    <a
                        href="{{ route('health-records.index') }}"
                        class="clay-back-button inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold transition"
                    >
                        Back to Records
                    </a>

                </div>

            </div>

            {{-- Resident Summary --}}
            <div class="clay-profile-card mb-5">

                <div class="p-5 sm:p-6">

                    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                        <div class="clay-profile-avatar-large flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl text-lg font-bold">
                            {{ strtoupper(substr($healthRecord->resident->first_name, 0, 1)) }}{{ strtoupper(substr($healthRecord->resident->last_name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">

                            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                                <div>
                                    <h3 class="text-xl font-bold">
                                        {{ $healthRecord->resident->full_name }}
                                    </h3>

                                    <p class="clay-profile-id mt-1 text-sm">
                                        Resident ID #{{ $healthRecord->resident_id }}
                                    </p>
                                </div>

                                <span class="clay-active-badge inline-flex w-fit items-center rounded-full px-3 py-1 text-xs font-semibold">
                                    Health Record Active
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            {{-- Basic Information --}}
            <div class="clay-info-card mb-5">

                <div class="clay-section-header px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="clay-section-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M13 3v5h5"
                                />
                            </svg>

                        </div>

                        <div>
                            <h3 class="clay-section-title font-semibold">
                                Basic Health Information
                            </h3>

                            <p class="clay-section-description mt-0.5 text-xs">
                                Basic medical information recorded for the resident.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="clay-basic-grid grid gap-4 p-5 sm:grid-cols-2 lg:grid-cols-4">

                    <div class="clay-basic-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            Blood Type
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->blood_type ?: 'Not recorded' }}
                        </p>
                    </div>

                    <div class="clay-basic-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            Resident Status
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->resident->status ?: 'Not recorded' }}
                        </p>
                    </div>

                    <div class="clay-basic-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            Contact Number
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->resident->contact_number ?: 'Not recorded' }}
                        </p>
                    </div>

                    <div class="clay-basic-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            PhilHealth Number
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->resident->philhealth_number ?: 'Not recorded' }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Medical History --}}
            <div class="clay-info-card mb-5">

                <div class="clay-section-header px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="clay-section-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                    d="M9 3h6m-7 4h8M7 7h10a2 2 0 012 2v10a2 2 0 01-2 2H7a2 2 0 01-2-2V9a2 2 0 012-2Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 13h6M9 17h4"
                                />
                            </svg>

                        </div>

                        <div>
                            <h3 class="clay-section-title font-semibold">
                                Medical History
                            </h3>

                            <p class="clay-section-description mt-0.5 text-xs">
                                Recorded medical conditions and health history.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="grid gap-4 p-5 lg:grid-cols-2">

                    <div class="clay-medical-item p-4">

                        <p class="clay-medical-label text-xs font-semibold uppercase tracking-wide">
                            Allergies
                        </p>

                        <p class="clay-medical-value mt-2 whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->allergies ?: 'None recorded.' }}
                        </p>

                    </div>

                    <div class="clay-medical-item p-4">

                        <p class="clay-medical-label text-xs font-semibold uppercase tracking-wide">
                            Chronic Conditions
                        </p>

                        <p class="clay-medical-value mt-2 whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->chronic_conditions ?: 'None recorded.' }}
                        </p>

                    </div>

                    <div class="clay-medical-item p-4">

                        <p class="clay-medical-label text-xs font-semibold uppercase tracking-wide">
                            Medical History
                        </p>

                        <p class="clay-medical-value mt-2 whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->medical_history ?: 'None recorded.' }}
                        </p>

                    </div>

                    <div class="clay-medical-item p-4">

                        <p class="clay-medical-label text-xs font-semibold uppercase tracking-wide">
                            Current Medications
                        </p>

                        <p class="clay-medical-value mt-2 whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->current_medications ?: 'None recorded.' }}
                        </p>

                    </div>

                    <div class="clay-medical-item p-4">

                        <p class="clay-medical-label text-xs font-semibold uppercase tracking-wide">
                            Disabilities
                        </p>

                        <p class="clay-medical-value mt-2 whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->disabilities ?: 'None recorded.' }}
                        </p>

                    </div>

                    <div class="clay-medical-item p-4">

                        <p class="clay-medical-label text-xs font-semibold uppercase tracking-wide">
                            Family Medical History
                        </p>

                        <p class="clay-medical-value mt-2 whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->family_medical_history ?: 'None recorded.' }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Emergency Contact --}}
            <div class="clay-info-card mb-5">

                <div class="clay-section-header px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="clay-section-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                    d="M3 5a2 2 0 012-2h3l2 5-2.5 1.5a16 16 0 007 7L16 14l5 2v3a2 2 0 01-2 2C10.82 21 3 13.18 3 5Z"
                                />
                            </svg>

                        </div>

                        <div>
                            <h3 class="clay-section-title font-semibold">
                                Emergency Contact
                            </h3>

                            <p class="clay-section-description mt-0.5 text-xs">
                                Person to contact during a health emergency.
                            </p>
                        </div>

                    </div>

                </div>

                <div class="grid gap-4 p-5 sm:grid-cols-3">

                    <div class="clay-emergency-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            Name
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->emergency_contact_name ?: 'Not provided' }}
                        </p>
                    </div>

                    <div class="clay-emergency-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            Contact Number
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->emergency_contact_number ?: 'Not provided' }}
                        </p>
                    </div>

                    <div class="clay-emergency-item p-4">
                        <p class="clay-field-label text-xs font-semibold uppercase tracking-wide">
                            Relationship
                        </p>

                        <p class="clay-field-value mt-1 text-sm font-semibold">
                            {{ $healthRecord->emergency_contact_relationship ?: 'Not provided' }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- Notes --}}
            <div class="clay-info-card mb-5">

                <div class="clay-section-header px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="clay-section-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                    d="M9 5h6M9 9h6M9 13h6M9 17h4"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M15 3v5h4"
                                />
                            </svg>

                        </div>

                        <div>
                            <h3 class="clay-section-title font-semibold">
                                Additional Notes
                            </h3>
                        </div>

                    </div>

                </div>

                <div class="p-5">

                    <div class="clay-notes p-4">

                        <p class="clay-medical-value whitespace-pre-line text-sm leading-6">
                            {{ $healthRecord->notes ?: 'No additional notes recorded.' }}
                        </p>

                    </div>

                </div>

            </div>

            {{-- Footer --}}
            <div class="clay-footer mt-5 flex flex-col gap-2 border-t pt-5 text-xs sm:flex-row sm:items-center sm:justify-between">

                <p>
                    Barangay Esperanza Health Center
                </p>

                <p>
                    Health Records Management
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