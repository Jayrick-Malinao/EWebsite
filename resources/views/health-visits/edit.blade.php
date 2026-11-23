<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Health Visit | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM
        ========================================================= */

        .clay-health-visit-edit {
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

        .clay-health-visit-edit *,
        .clay-health-visit-edit *::before,
        .clay-health-visit-edit *::after {
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
           PAGE INTRODUCTION
        ========================================================= */

        .clay-page-heading {
            position: relative;
            padding-left: 17px;
        }

        .clay-page-heading::before {
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
            box-shadow: 2px 2px 5px rgba(15, 111, 90, 0.18);
        }

        .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-page-description {
            color: var(--text-muted) !important;
        }

        .clay-edit-icon {
            background: linear-gradient(
                145deg,
                #FFF4E8,
                #F8E8D7
            ) !important;
            color: var(--accent) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.12),
                -5px -5px 10px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.80);
        }

        /* =========================================================
           HEADER / NAVIGATION BUTTON
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
                box-shadow 0.18s ease,
                color 0.18s ease;
        }

        .clay-header-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        /* =========================================================
           CURRENT RECORD
        ========================================================= */

        .clay-current-record {
            background: linear-gradient(
                145deg,
                #F2FBF6,
                #E1F2E9
            ) !important;
            border: 1px solid rgba(255, 255, 255, 0.92) !important;
            border-radius: 20px !important;
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, 0.14),
                -7px -7px 15px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-record-label {
            color: var(--primary-dark) !important;
        }

        .clay-record-name {
            color: var(--text-dark) !important;
        }

        .clay-record-number {
            color: var(--text-muted) !important;
        }

        .clay-view-record {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 12px !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.90);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-view-record:hover {
            transform: translateY(-1px);
        }

        /* =========================================================
           VALIDATION ERROR
        ========================================================= */

        .clay-error-alert {
            background: linear-gradient(
                145deg,
                #FFF7F6,
                #FCEBE8
            ) !important;
            color: var(--danger) !important;
            border: 1px solid rgba(255, 255, 255, 0.90) !important;
            border-radius: 18px !important;
            box-shadow:
                6px 6px 13px rgba(150, 94, 84, 0.12),
                -6px -6px 13px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           FORM SECTIONS
        ========================================================= */

        .clay-form-section {
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

        .clay-section-icon-green {
            background: linear-gradient(
                145deg,
                #E7F8F0,
                #D8EEE5
            ) !important;
            color: var(--primary-dark) !important;
        }

        .clay-section-icon-blue {
            background: linear-gradient(
                145deg,
                #EEF7F6,
                #DCEDEB
            ) !important;
            color: #277A70 !important;
        }

        .clay-section-title {
            color: var(--text-dark) !important;
        }

        .clay-section-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           FORM LABELS
        ========================================================= */

        .clay-label {
            color: var(--text-dark) !important;
        }

        .clay-required {
            color: var(--danger) !important;
        }

        /* =========================================================
           INSET FORM CONTROLS
        ========================================================= */

        .clay-input,
        .clay-select,
        .clay-textarea {
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
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease;
        }

        .clay-input::placeholder,
        .clay-textarea::placeholder {
            color: var(--text-soft) !important;
        }

        .clay-input:focus,
        .clay-select:focus,
        .clay-textarea:focus {
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

        .clay-input:hover,
        .clay-select:hover,
        .clay-textarea:hover {
            border-color: rgba(168, 190, 182, 0.75) !important;
        }

        .clay-error-message {
            color: var(--danger) !important;
        }

        /* =========================================================
           FORM ACTIONS
        ========================================================= */

        .clay-form-actions {
            border-top-color: rgba(210, 225, 218, 0.68) !important;
        }

        .clay-cancel-button {
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

        .clay-cancel-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .clay-update-button {
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

        .clay-update-button:hover {
            transform: translateY(-2px);
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, 0.25),
                -5px -5px 11px rgba(255, 255, 255, 0.84),
                inset 1px 1px 0 rgba(255, 255, 255, 0.24);
        }

        /* =========================================================
           FOCUS / ACCESSIBILITY
        ========================================================= */

        .clay-health-visit-edit a:focus-visible,
        .clay-health-visit-edit button:focus-visible,
        .clay-health-visit-edit input:focus-visible,
        .clay-health-visit-edit select:focus-visible,
        .clay-health-visit-edit textarea:focus-visible {
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

            .clay-form-section,
            .clay-current-record {
                border-radius: 19px !important;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-health-visit-edit *,
            .clay-health-visit-edit *::before,
            .clay-health-visit-edit *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body>

<div class="clay-health-visit-edit min-h-screen">

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
                            Edit Health Visit
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

                {{-- Page Introduction --}}
                <div class="clay-page-heading mb-7">

                    <div class="flex items-center gap-4">

                        <div class="clay-edit-icon flex h-12 w-12 shrink-0 items-center justify-center rounded-xl">

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
                                    d="m16.5 3.5 4 4M5 19l3.5-.7L19.8 7a1.4 1.4 0 0 0 0-2l-.8-.8a1.4 1.4 0 0 0-2 0L5.7 14.3 5 19Z"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                                Edit Health Visit
                            </h2>

                            <p class="clay-page-description mt-1 text-sm leading-6">
                                Update the resident's consultation, assessment, treatment, and other health information.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Current Record --}}
                <div class="clay-current-record mb-6 p-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="min-w-0">

                            <p class="clay-record-label text-xs font-semibold uppercase tracking-wide">
                                Editing Record
                            </p>

                            <p class="clay-record-name mt-1 truncate text-base font-bold">
                                {{ $healthVisit->resident->full_name }}
                            </p>

                            <p class="clay-record-number mt-1 text-xs">
                                Visit Record #{{ $healthVisit->id }}
                            </p>

                        </div>

                        <a
                            href="{{ route('health-visits.index') }}"
                            class="clay-view-record inline-flex shrink-0 items-center justify-center px-4 py-2.5 text-sm font-semibold transition"
                        >
                            View Record
                        </a>

                    </div>

                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="clay-error-alert mb-6 p-5">

                        <div class="flex items-start gap-3">

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
                                    d="M12 8v4m0 4h.01M10.29 3.86l-7.4 12.8A2 2 0 004.62 19.7h14.76a2 2 0 001.73-3.04l-7.4-12.8a2 2 0 0 0-3.42 0Z"
                                />
                            </svg>

                            <div class="min-w-0">

                                <h3 class="text-sm font-bold">
                                    Please correct the following errors:
                                </h3>

                                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">

                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif

                {{-- Edit Form --}}
                <form
                    method="POST"
                    action="{{ route('health-visits.update', $healthVisit) }}"
                    class="space-y-6"
                >

                    @csrf
                    @method('PUT')

                    {{-- =====================================================
                        VISIT INFORMATION
                    ====================================================== --}}
                    <section class="clay-form-section overflow-hidden">

                        {{-- Section Header --}}
                        <div class="clay-section-header px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-section-icon clay-section-icon-green flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                            d="M8 7V3m8 4V3m-9 4h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 00-2 2Z"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="clay-section-title font-bold">
                                        Visit Information
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Update the basic information about this health visit.
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Section Body --}}
                        <div class="grid gap-6 p-5 sm:p-6 md:grid-cols-2">

                            {{-- Resident --}}
                            <div class="md:col-span-2">

                                <label
                                    for="resident_id"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Resident <span class="clay-required">*</span>
                                </label>

                                <select
                                    id="resident_id"
                                    name="resident_id"
                                    required
                                    class="clay-select w-full px-4 py-3 text-sm outline-none transition"
                                >

                                    <option value="">
                                        Select a resident
                                    </option>

                                    @foreach ($residents as $resident)

                                        <option
                                            value="{{ $resident->id }}"
                                            @selected(old('resident_id', $healthVisit->resident_id) == $resident->id)
                                        >
                                            {{ $resident->full_name }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('resident_id')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Visit Date --}}
                            <div>

                                <label
                                    for="visit_date"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Visit Date & Time <span class="clay-required">*</span>
                                </label>

                                <input
                                    type="datetime-local"
                                    id="visit_date"
                                    name="visit_date"
                                    value="{{ old('visit_date', $healthVisit->visit_date->format('Y-m-d\TH:i')) }}"
                                    max="{{ now()->format('Y-m-d\TH:i') }}"
                                    required
                                    class="clay-input w-full px-4 py-3 text-sm outline-none transition"
                                >

                                @error('visit_date')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Visit Type --}}
                            <div>

                                <label
                                    for="visit_type"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Visit Type
                                </label>

                                <select
                                    id="visit_type"
                                    name="visit_type"
                                    class="clay-select w-full px-4 py-3 text-sm outline-none transition"
                                >

                                    <option value="">
                                        Select visit type
                                    </option>

                                    <option value="General Consultation" @selected(old('visit_type', $healthVisit->visit_type) === 'General Consultation')>
                                        General Consultation
                                    </option>

                                    <option value="Follow-up" @selected(old('visit_type', $healthVisit->visit_type) === 'Follow-up')>
                                        Follow-up
                                    </option>

                                    <option value="Prenatal" @selected(old('visit_type', $healthVisit->visit_type) === 'Prenatal')>
                                        Prenatal
                                    </option>

                                    <option value="Postnatal" @selected(old('visit_type', $healthVisit->visit_type) === 'Postnatal')>
                                        Postnatal
                                    </option>

                                    <option value="Child Health" @selected(old('visit_type', $healthVisit->visit_type) === 'Child Health')>
                                        Child Health
                                    </option>

                                    <option value="Senior Citizen" @selected(old('visit_type', $healthVisit->visit_type) === 'Senior Citizen')>
                                        Senior Citizen
                                    </option>

                                    <option value="Immunization" @selected(old('visit_type', $healthVisit->visit_type) === 'Immunization')>
                                        Immunization
                                    </option>

                                    <option value="Other" @selected(old('visit_type', $healthVisit->visit_type) === 'Other')>
                                        Other
                                    </option>

                                </select>

                                @error('visit_type')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Attended By --}}
                            <div class="md:col-span-2">

                                <label
                                    for="attended_by"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Attended By
                                </label>

                                <input
                                    type="text"
                                    id="attended_by"
                                    name="attended_by"
                                    value="{{ old('attended_by', $healthVisit->attended_by) }}"
                                    maxlength="255"
                                    placeholder="Name of health worker or attending personnel"
                                    class="clay-input w-full px-4 py-3 text-sm outline-none transition"
                                >

                                @error('attended_by')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>

                    {{-- =====================================================
                        CLINICAL INFORMATION
                    ====================================================== --}}
                    <section class="clay-form-section overflow-hidden">

                        {{-- Section Header --}}
                        <div class="clay-section-header px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-section-icon clay-section-icon-blue flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                            d="M9 3h6m-7 4h8m-8 4h8m-8 4h5m-8 5h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 0 2Z"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="clay-section-title font-bold">
                                        Clinical Information
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Update the patient's condition and care provided.
                                    </p>

                                </div>

                            </div>

                        </div>

                        {{-- Section Body --}}
                        <div class="space-y-6 p-5 sm:p-6">

                            {{-- Chief Complaint --}}
                            <div>

                                <label
                                    for="chief_complaint"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Chief Complaint
                                </label>

                                <textarea
                                    id="chief_complaint"
                                    name="chief_complaint"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Describe the main reason for the visit..."
                                    class="clay-textarea w-full resize-y px-4 py-3 text-sm leading-6 outline-none transition"
                                >{{ old('chief_complaint', $healthVisit->chief_complaint) }}</textarea>

                                @error('chief_complaint')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Assessment --}}
                            <div>

                                <label
                                    for="assessment"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Assessment
                                </label>

                                <textarea
                                    id="assessment"
                                    name="assessment"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Record the assessment, findings, or observations..."
                                    class="clay-textarea w-full resize-y px-4 py-3 text-sm leading-6 outline-none transition"
                                >{{ old('assessment', $healthVisit->assessment) }}</textarea>

                                @error('assessment')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Treatment --}}
                            <div>

                                <label
                                    for="treatment"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Treatment / Intervention
                                </label>

                                <textarea
                                    id="treatment"
                                    name="treatment"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Describe the treatment, medication, advice, or intervention provided..."
                                    class="clay-textarea w-full resize-y px-4 py-3 text-sm leading-6 outline-none transition"
                                >{{ old('treatment', $healthVisit->treatment) }}</textarea>

                                @error('treatment')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Remarks --}}
                            <div>

                                <label
                                    for="remarks"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Remarks
                                </label>

                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="3"
                                    maxlength="5000"
                                    placeholder="Add any additional notes or follow-up instructions..."
                                    class="clay-textarea w-full resize-y px-4 py-3 text-sm leading-6 outline-none transition"
                                >{{ old('remarks', $healthVisit->remarks) }}</textarea>

                                @error('remarks')
                                    <p class="clay-error-message mt-2 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>

                    {{-- =====================================================
                        FORM ACTIONS
                    ====================================================== --}}
                    <div class="clay-form-actions flex flex-col-reverse gap-3 border-t pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('health-visits.index') }}"
                            class="clay-cancel-button inline-flex items-center justify-center px-6 py-3 text-sm font-semibold transition"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-update-button inline-flex items-center justify-center gap-2 px-7 py-3 text-sm font-semibold transition"
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
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Update Health Visit
                        </button>

                    </div>

                </form>

            </div>

        </main>

    </div>

</div>

</body>
</html>