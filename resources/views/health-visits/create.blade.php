<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Record Health Visit | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           HEALTH VISIT — GOVERNMENT CLAYMORPHISM UI
           Frontend styling only.
        ========================================================== */

        :root {
            --gov-primary: #168B70;
            --gov-primary-dark: #0F6F5A;
            --gov-primary-light: #2A9B80;

            --gov-bg: #EEF5F1;
            --gov-surface: #F5FAF7;
            --gov-surface-soft: #EDF5F0;

            --gov-text: #164238;
            --gov-secondary: #385C52;
            --gov-muted: #6D817A;
            --gov-placeholder: #9AA9A4;

            --gov-orange: #E87928;
            --gov-danger: #DC2626;
            --gov-warning: #B7791F;

            --gov-highlight: rgba(255, 255, 255, 0.94);
            --gov-shadow: rgba(107, 134, 124, 0.24);
        }

        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--gov-bg);
            color: var(--gov-text);
        }

        /* =========================================================
           PAGE BACKGROUND
           EXACTLY MATCHES SIDEBAR BACKGROUND
        ========================================================== */

        .clay-page {
            min-height: 100vh;
            background: #EEF5F1;
            color: #164238;
        }

        /* =========================================================
           TOP HEADER
        ========================================================== */

        .clay-header {
            background: #F5FAF7;

            border-bottom: 1px solid rgba(255, 255, 255, 0.70);

            box-shadow:
                0 3px 12px rgba(107, 134, 124, 0.10),
                0 1px 2px rgba(255, 255, 255, 0.95) inset;
        }

        /* =========================================================
           MOBILE MENU BUTTON
        ========================================================== */

        .clay-mobile-menu {
            background: var(--gov-surface);

            color: var(--gov-primary-dark);

            border: 1px solid rgba(255, 255, 255, 0.70);

            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.18),
                -3px -3px 7px rgba(255, 255, 255, 0.90);

            transition:
                transform 0.16s ease,
                box-shadow 0.16s ease;
        }

        .clay-mobile-menu:hover {
            transform: translateY(-1px);

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.20),
                -4px -4px 8px rgba(255, 255, 255, 0.94);
        }

        /* =========================================================
           PAGE ICON
        ========================================================== */

        .clay-page-icon {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E3EEE9
            );

            color: var(--gov-primary);

            border: 1px solid rgba(255, 255, 255, 0.70);

            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.20),
                -4px -4px 9px rgba(255, 255, 255, 0.95);
        }

        /* =========================================================
           FORM CARDS
        ========================================================== */

        .clay-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );

            border: 1px solid rgba(255, 255, 255, 0.70);

            box-shadow:
                7px 7px 18px rgba(107, 134, 124, 0.20),
                -5px -5px 12px rgba(255, 255, 255, 0.92);

            position: relative;
        }

        .clay-card-header {
            background: rgba(245, 250, 247, 0.70);

            border-bottom: 1px solid rgba(255, 255, 255, 0.72);
        }

        /* =========================================================
           SECTION ICONS
        ========================================================== */

        .clay-section-icon {
            background: var(--gov-surface-soft);

            border: 1px solid rgba(255, 255, 255, 0.72);

            box-shadow:
                4px 4px 8px rgba(107, 134, 124, 0.20),
                -4px -4px 8px rgba(255, 255, 255, 0.92);

            color: var(--gov-primary);
        }

        /* =========================================================
           FORM LABELS
        ========================================================== */

        .clay-label {
            color: var(--gov-secondary);

            font-size: 14px;
            font-weight: 700;
        }

        .required-mark {
            color: var(--gov-danger);
        }

        /* =========================================================
           FORM CONTROLS
        ========================================================== */

        .clay-input,
        .clay-select,
        .clay-textarea {
            width: 100%;

            color: var(--gov-text);

            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EDF5F0
            );

            border: 1px solid rgba(107, 134, 124, 0.17);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.11),
                inset -3px -3px 7px rgba(255, 255, 255, 0.90);

            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease,
                transform 0.18s ease;
        }

        .clay-input,
        .clay-select {
            min-height: 46px;

            padding: 11px 14px;

            border-radius: 14px;

            font-size: 14px;
        }

        .clay-textarea {
            min-height: 110px;

            padding: 12px 14px;

            border-radius: 14px;

            font-size: 14px;
            line-height: 1.6;

            resize: vertical;
        }

        .clay-input::placeholder,
        .clay-textarea::placeholder {
            color: var(--gov-placeholder);
        }

        .clay-input:hover,
        .clay-select:hover,
        .clay-textarea:hover {
            border-color: rgba(22, 139, 112, 0.25);
        }

        .clay-input:focus,
        .clay-select:focus,
        .clay-textarea:focus {
            outline: none;

            border-color: rgba(22, 139, 112, 0.60);

            box-shadow:
                0 0 0 3px rgba(22, 139, 112, 0.10),
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.90);
        }

        /* =========================================================
           ERROR PANEL
        ========================================================== */

        .clay-error-panel {
            background: linear-gradient(
                145deg,
                #FFF9F8,
                #FCEDEA
            );

            border: 1px solid rgba(220, 38, 38, 0.16);

            box-shadow:
                5px 5px 14px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.85);
        }

        .clay-error-icon {
            background: #FCEDEA;

            color: var(--gov-danger);

            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.14),
                -3px -3px 7px rgba(255, 255, 255, 0.90);
        }

        .clay-field-error {
            color: var(--gov-danger);
        }

        /* =========================================================
           ACTION AREA
        ========================================================== */

        .clay-actions {
            border-top: 1px solid rgba(107, 134, 124, 0.14);
        }

        /* =========================================================
           PRIMARY BUTTON
        ========================================================== */

        .clay-primary-button {
            background: linear-gradient(
                135deg,
                #168B70,
                #0F6F5A
            );

            color: #FFFFFF;

            border: 1px solid rgba(15, 111, 90, 0.35);

            box-shadow:
                5px 5px 12px rgba(107, 134, 124, 0.25),
                -3px -3px 8px rgba(255, 255, 255, 0.65);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .clay-primary-button:hover {
            transform: translateY(-1px);

            filter: brightness(1.025);

            box-shadow:
                6px 7px 14px rgba(107, 134, 124, 0.28),
                -3px -3px 8px rgba(255, 255, 255, 0.72);
        }

        .clay-primary-button:active {
            transform: translateY(0);

            box-shadow:
                inset 3px 3px 7px rgba(5, 76, 61, 0.25),
                inset -2px -2px 6px rgba(255, 255, 255, 0.20);
        }

        /* =========================================================
           SECONDARY BUTTON
        ========================================================== */

        .clay-secondary-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );

            color: var(--gov-primary-dark);

            border: 1px solid rgba(255, 255, 255, 0.72);

            box-shadow:
                5px 5px 12px rgba(107, 134, 124, 0.20),
                -4px -4px 9px rgba(255, 255, 255, 0.90);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-secondary-button:hover {
            transform: translateY(-1px);

            box-shadow:
                6px 6px 13px rgba(107, 134, 124, 0.23),
                -4px -4px 9px rgba(255, 255, 255, 0.95);
        }

        .clay-secondary-button:active {
            transform: translateY(0);
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================== */

        .clay-focus:focus-visible {
            outline: 2px solid var(--gov-primary);

            outline-offset: 2px;

            box-shadow:
                0 0 0 4px rgba(22, 139, 112, 0.12),
                4px 4px 8px rgba(107, 134, 124, 0.18),
                -4px -4px 8px rgba(255, 255, 255, 0.90);
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
            }
        }

        /* =========================================================
           MOBILE
        ========================================================== */

        @media (max-width: 640px) {
            .clay-card {
                border-radius: 18px;
            }

            .clay-input,
            .clay-select {
                min-height: 48px;
            }

            .clay-textarea {
                min-height: 120px;
            }
        }
    </style>
</head>

<body class="clay-page min-h-screen bg-[#EEF5F1] text-[#164238]">

    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    @include('dashboard.sidebar')

    {{-- =========================================================
        MAIN APPLICATION AREA
    ========================================================== --}}
    <main class="min-h-screen lg:pl-72">

        {{-- =====================================================
            TOP HEADER
        ====================================================== --}}
        <header class="clay-header sticky top-0 z-30">

            <div class="flex min-h-20 items-center justify-between gap-4 px-5 py-4 sm:px-8 lg:px-10">

                {{-- Left Header --}}
                <div class="flex min-w-0 items-center gap-3">

                    {{-- Mobile Menu --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        aria-label="Open navigation menu"
                        class="clay-mobile-menu clay-focus inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="1.8"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div class="min-w-0">

                        <p class="truncate text-xs font-bold uppercase tracking-[0.18em] text-[#168B70]">
                            Health Center Records
                        </p>

                        <h1 class="mt-1 truncate text-xl font-bold tracking-tight text-[#164238] sm:text-2xl">
                            Record Health Visit
                        </h1>

                    </div>

                </div>

                {{-- Right Header --}}
                <div class="flex shrink-0 items-center gap-3">

                    {{-- Notifications --}}
                    @include('partials.notification-bell')

                    {{-- Authenticated User --}}
                    @auth
                        <div class="hidden items-center gap-3 sm:flex">

                            <div class="min-w-0 text-right">

                                <p class="max-w-[180px] truncate text-sm font-bold text-[#164238]">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="text-xs text-[#6D817A]">
                                    {{ auth()->user()->role }}
                                </p>

                            </div>

                           <div class="clay-profile-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                        </div>
                    @endauth

                </div>

            </div>

        </header>

        {{-- =====================================================
            PAGE CONTENT
        ====================================================== --}}
        <div class="w-full">

            <div class="mx-auto w-full max-w-7xl px-5 py-8 sm:px-8 lg:px-10">

                {{-- =================================================
                    PAGE INTRODUCTION
                ================================================== --}}
                <div class="mb-7">

                    <div class="flex items-start gap-4">

                        <div
                            class="clay-page-icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl"
                            aria-hidden="true"
                        >
                            <svg
                                class="h-6 w-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M12 5v14m-7-7h14"
                                />
                            </svg>
                        </div>

                        <div class="min-w-0">

                            <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168B70]">
                                Health Center Records
                            </p>

                            <h2 class="mt-1 text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                                New Health Visit
                            </h2>

                            <p class="mt-2 max-w-3xl text-sm leading-6 text-[#6D817A]">
                                Record the resident's consultation, assessment, treatment, and other relevant health information.
                            </p>

                        </div>

                    </div>

                </div>

                {{-- =================================================
                    VALIDATION ERRORS
                ================================================== --}}
                @if ($errors->any())
                    <div class="clay-error-panel mb-6 rounded-2xl p-5 sm:p-6">

                        <div class="flex items-start gap-3">

                            <div
                                class="clay-error-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl"
                                aria-hidden="true"
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
                                        d="M12 8v4m0 4h.01M10.29 3.86l-7.4 12.8A2 2 0 004.62 19.7h14.76a2 2 0 001.73-3.04l-7.4-12.8a2 2 0 00-3.42 0Z"
                                    />
                                </svg>
                            </div>

                            <div class="min-w-0">

                                <h3 class="text-sm font-bold text-[#164238]">
                                    Please review the form
                                </h3>

                                <p class="mt-1 text-sm text-[#6D817A]">
                                    The following information needs to be corrected before the health visit can be saved.
                                </p>

                                <ul class="mt-3 list-disc space-y-1.5 pl-5 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>

                            </div>

                        </div>

                    </div>
                @endif

                {{-- =================================================
                    FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('health-visits.store') }}"
                    class="space-y-6"
                >

                    @csrf

                    {{-- =================================================
                        VISIT INFORMATION
                    ================================================== --}}
                    <section class="clay-card overflow-hidden rounded-2xl">

                        {{-- Section Header --}}
                        <div class="clay-card-header px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div
                                    class="clay-section-icon flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                                    aria-hidden="true"
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
                                            stroke-width="1.8"
                                            d="M8 7V3m8 4V3m-9 4h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2Z"
                                        />
                                    </svg>
                                </div>

                                <div class="min-w-0">

                                    <h3 class="font-bold text-[#164238]">
                                        Visit Information
                                    </h3>

                                    <p class="mt-0.5 text-xs text-[#6D817A]">
                                        Basic information about this health center visit.
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
                                    class="clay-label mb-2 block"
                                >
                                    Resident <span class="required-mark">*</span>
                                </label>

                                <select
                                    id="resident_id"
                                    name="resident_id"
                                    required
                                    class="clay-select clay-focus"
                                >
                                    <option value="">
                                        Select a resident
                                    </option>

                                    @foreach ($residents as $resident)
                                        <option
                                            value="{{ $resident->id }}"
                                            @selected(old('resident_id') == $resident->id)
                                        >
                                            {{ $resident->full_name }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('resident_id')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Visit Date --}}
                            <div>

                                <label
                                    for="visit_date"
                                    class="clay-label mb-2 block"
                                >
                                    Visit Date & Time <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="datetime-local"
                                    id="visit_date"
                                    name="visit_date"
                                    value="{{ old('visit_date', now()->format('Y-m-d\TH:i')) }}"
                                    max="{{ now()->format('Y-m-d\TH:i') }}"
                                    required
                                    class="clay-input clay-focus"
                                >

                                @error('visit_date')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Visit Type --}}
                            <div>

                                <label
                                    for="visit_type"
                                    class="clay-label mb-2 block"
                                >
                                    Visit Type
                                </label>

                                <select
                                    id="visit_type"
                                    name="visit_type"
                                    class="clay-select clay-focus"
                                >
                                    <option value="">
                                        Select visit type
                                    </option>

                                    <option
                                        value="General Consultation"
                                        @selected(old('visit_type') === 'General Consultation')
                                    >
                                        General Consultation
                                    </option>

                                    <option
                                        value="Follow-up"
                                        @selected(old('visit_type') === 'Follow-up')
                                    >
                                        Follow-up
                                    </option>

                                    <option
                                        value="Prenatal"
                                        @selected(old('visit_type') === 'Prenatal')
                                    >
                                        Prenatal
                                    </option>

                                    <option
                                        value="Postnatal"
                                        @selected(old('visit_type') === 'Postnatal')
                                    >
                                        Postnatal
                                    </option>

                                    <option
                                        value="Child Health"
                                        @selected(old('visit_type') === 'Child Health')
                                    >
                                        Child Health
                                    </option>

                                    <option
                                        value="Senior Citizen"
                                        @selected(old('visit_type') === 'Senior Citizen')
                                    >
                                        Senior Citizen
                                    </option>

                                    <option
                                        value="Immunization"
                                        @selected(old('visit_type') === 'Immunization')
                                    >
                                        Immunization
                                    </option>

                                    <option
                                        value="Other"
                                        @selected(old('visit_type') === 'Other')
                                    >
                                        Other
                                    </option>
                                </select>

                                @error('visit_type')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Attended By --}}
                            <div class="md:col-span-2">

                                <label
                                    for="attended_by"
                                    class="clay-label mb-2 block"
                                >
                                    Attended By
                                </label>

                                <input
                                    type="text"
                                    id="attended_by"
                                    name="attended_by"
                                    value="{{ old('attended_by', auth()->user()->name) }}"
                                    maxlength="255"
                                    placeholder="Name of health worker or attending personnel"
                                    class="clay-input clay-focus"
                                >

                                @error('attended_by')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>

                    {{-- =================================================
                        CLINICAL INFORMATION
                    ================================================== --}}
                    <section class="clay-card overflow-hidden rounded-2xl">

                        {{-- Section Header --}}
                        <div class="clay-card-header px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div
                                    class="clay-section-icon flex h-11 w-11 shrink-0 items-center justify-center rounded-xl"
                                    aria-hidden="true"
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
                                            stroke-width="1.8"
                                            d="M9 3h6m-7 4h8m-8 4h8m-8 4h5m-8 5h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v13a2 2 0 002 2Z"
                                        />
                                    </svg>
                                </div>

                                <div class="min-w-0">

                                    <h3 class="font-bold text-[#164238]">
                                        Clinical Information
                                    </h3>

                                    <p class="mt-0.5 text-xs text-[#6D817A]">
                                        Record the patient's reported condition and care provided.
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
                                    class="clay-label mb-2 block"
                                >
                                    Chief Complaint
                                </label>

                                <textarea
                                    id="chief_complaint"
                                    name="chief_complaint"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Describe the main reason for the visit..."
                                    class="clay-textarea clay-focus"
                                >{{ old('chief_complaint') }}</textarea>

                                @error('chief_complaint')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Assessment --}}
                            <div>

                                <label
                                    for="assessment"
                                    class="clay-label mb-2 block"
                                >
                                    Assessment
                                </label>

                                <textarea
                                    id="assessment"
                                    name="assessment"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Record the assessment, findings, or observations..."
                                    class="clay-textarea clay-focus"
                                >{{ old('assessment') }}</textarea>

                                @error('assessment')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Treatment --}}
                            <div>

                                <label
                                    for="treatment"
                                    class="clay-label mb-2 block"
                                >
                                    Treatment / Intervention
                                </label>

                                <textarea
                                    id="treatment"
                                    name="treatment"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Describe the treatment, medication, advice, or intervention provided..."
                                    class="clay-textarea clay-focus"
                                >{{ old('treatment') }}</textarea>

                                @error('treatment')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Remarks --}}
                            <div>

                                <label
                                    for="remarks"
                                    class="clay-label mb-2 block"
                                >
                                    Remarks
                                </label>

                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="3"
                                    maxlength="5000"
                                    placeholder="Add any additional notes or follow-up instructions..."
                                    class="clay-textarea clay-focus"
                                >{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <p class="clay-field-error mt-2 text-xs font-bold">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>

                    {{-- =================================================
                        FORM ACTIONS
                    ================================================== --}}
                    <div class="clay-actions flex flex-col-reverse gap-3 pt-6 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('health-visits.index') }}"
                            class="clay-secondary-button clay-focus inline-flex min-h-11 items-center justify-center rounded-xl px-6 py-3 text-sm font-bold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-primary-button clay-focus inline-flex min-h-11 items-center justify-center gap-2 rounded-xl px-7 py-3 text-sm font-bold"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Save Health Visit
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>

</body>

</html>