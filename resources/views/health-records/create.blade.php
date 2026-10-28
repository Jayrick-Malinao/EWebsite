<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Health Record | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Create a health record for a resident of Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA — HEALTH RECORD CREATE
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
            --danger-light: #FDF1F1;

            --warning: #8A6A28;
            --warning-light: #FBF7ED;

            --clay-shadow:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84);

            --clay-small-shadow:
                4px 4px 10px rgba(107, 134, 124, .16),
                -4px -4px 10px rgba(255, 255, 255, .9),
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

        .clay-health-record {
            min-height: 100vh;
        }

        /* =========================================================
           MOBILE SIDEBAR OVERLAY
        ========================================================== */

        .clay-health-record #sidebar-overlay {
            background: rgba(22, 66, 56, .28) !important;
            backdrop-filter: blur(4px);
        }

        /* =========================================================
           TOP HEADER
        ========================================================== */

        .clay-health-record .clay-top-header {
            min-height: 80px;
            border-bottom: 1px solid rgba(210, 225, 218, .75) !important;
            background: rgba(245, 250, 247, .94) !important;
            box-shadow:
                0 5px 18px rgba(107, 134, 124, .08),
                inset 0 -1px 0 rgba(255, 255, 255, .85);
            backdrop-filter: blur(14px);
        }

        .clay-health-record .clay-mobile-menu {
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

        .clay-health-record .clay-mobile-menu:hover {
            color: var(--primary);
            transform: translateY(-1px);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .2),
                -5px -5px 12px rgba(255, 255, 255, .94);
        }

        .clay-health-record .clay-role-label {
            color: var(--primary-dark) !important;
            letter-spacing: .18em;
        }

        .clay-health-record .clay-header-title {
            color: var(--text-dark) !important;
        }

        .clay-health-record .clay-profile {
            border-color: rgba(210, 225, 218, .75) !important;
        }

        .clay-health-record .clay-profile-avatar {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            ) !important;
            color: white !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .18),
                -4px -4px 10px rgba(255, 255, 255, .85),
                inset 1px 1px 0 rgba(255, 255, 255, .28);
        }

        /* =========================================================
           PAGE WRAPPER
        ========================================================== */

        .clay-health-record .clay-page {
            max-width: 1120px;
            margin: 0 auto;
        }

        /* =========================================================
           BREADCRUMB
        ========================================================== */

        .clay-health-record .clay-breadcrumb {
            color: var(--text-soft) !important;
        }

        .clay-health-record .clay-breadcrumb a {
            color: var(--text-muted) !important;
            transition: color .2s ease;
        }

        .clay-health-record .clay-breadcrumb a:hover {
            color: var(--primary) !important;
        }

        .clay-health-record .clay-breadcrumb-current {
            color: var(--text-dark) !important;
        }

        /* =========================================================
           PAGE HEADING
        ========================================================== */

        .clay-health-record .clay-page-heading {
            position: relative;
            padding-left: 18px;
        }

        .clay-health-record .clay-page-heading::before {
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
            box-shadow: 1px 2px 5px rgba(22, 139, 112, .2);
        }

        .clay-health-record .clay-eyebrow {
            color: var(--primary-dark) !important;
        }

        .clay-health-record .clay-page-title {
            color: var(--text-dark) !important;
        }

        .clay-health-record .clay-page-description {
            color: var(--text-muted) !important;
        }

        /* =========================================================
           VALIDATION ALERT
        ========================================================== */

        .clay-health-record .clay-error-alert {
            border: 1px solid rgba(180, 35, 35, .14) !important;
            border-radius: 18px;
            background:
                linear-gradient(145deg, #FFF9F9, #F8EDEC) !important;
            box-shadow:
                6px 6px 15px rgba(107, 134, 124, .13),
                -6px -6px 15px rgba(255, 255, 255, .9),
                inset 1px 1px 0 rgba(255, 255, 255, .85);
        }

        .clay-health-record .clay-error-alert svg {
            color: var(--danger) !important;
        }

        .clay-health-record .clay-error-title {
            color: #8F2424 !important;
        }

        .clay-health-record .clay-error-list {
            color: #A33B3B !important;
        }

        /* =========================================================
           FORM SECTIONS
        ========================================================== */

        .clay-health-record .clay-section {
            overflow: hidden;
            border-radius: 26px;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            background:
                linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            box-shadow: var(--clay-shadow);
        }

        .clay-health-record .clay-section-header {
            border-bottom: 1px solid rgba(210, 225, 218, .68) !important;
            background: rgba(245, 250, 247, .42);
            padding: 20px 22px;
        }

        .clay-health-record .clay-section-header-inner {
            display: flex;
            align-items: flex-start;
            gap: 13px;
        }

        .clay-health-record .clay-section-icon {
            display: flex;
            height: 40px;
            width: 40px;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            border-radius: 13px;
            color: white;
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .18),
                -4px -4px 9px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .25);
        }

        .clay-health-record .clay-section-title {
            color: var(--text-dark) !important;
        }

        .clay-health-record .clay-section-description {
            color: var(--text-muted) !important;
        }

        .clay-health-record .clay-section-body {
            padding: 22px;
        }

        /* =========================================================
           FORM LABELS
        ========================================================== */

        .clay-health-record .clay-label {
            color: var(--text-dark) !important;
        }

        .clay-health-record .clay-required {
            color: var(--danger) !important;
        }

        /* =========================================================
           CLAY INPUTS
        ========================================================== */

        .clay-health-record .clay-input {
            width: 100%;
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
                background .2s ease,
                transform .2s ease;
        }

        .clay-health-record .clay-input::placeholder {
            color: var(--text-soft) !important;
            opacity: 1;
        }

        .clay-health-record .clay-input:hover {
            border-color: rgba(22, 139, 112, .28) !important;
        }

        .clay-health-record .clay-input:focus {
            border-color: rgba(22, 139, 112, .62) !important;
            background:
                linear-gradient(145deg, #F1F8F4, #FBFEFC) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .9),
                0 0 0 3px rgba(22, 139, 112, .10) !important;
        }

        .clay-health-record .clay-input:disabled {
            cursor: not-allowed !important;
            opacity: .62;
            background:
                linear-gradient(145deg, #E7EFEB, #F0F5F2) !important;
            color: var(--text-soft) !important;
        }

        .clay-health-record select.clay-input {
            cursor: pointer;
        }

        .clay-health-record select.clay-input:disabled {
            cursor: not-allowed;
        }

        .clay-health-record textarea.clay-input {
            min-height: 92px;
        }

        .clay-health-record .clay-field-error {
            color: #B42323 !important;
        }

        .clay-health-record .clay-helper {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           WARNING / EMPTY RESIDENT STATE
        ========================================================== */

        .clay-health-record .clay-warning {
            border: 1px solid rgba(138, 106, 40, .14) !important;
            border-radius: 16px;
            background:
                linear-gradient(145deg, #FFFDF7, #F2EBD9) !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .13),
                -5px -5px 12px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .75);
            color: var(--warning) !important;
        }

        .clay-health-record .clay-warning-title {
            color: var(--warning) !important;
        }

        .clay-health-record .clay-warning-text {
            color: #9B8150 !important;
        }

        /* =========================================================
           FORM ACTIONS
        ========================================================== */

        .clay-health-record .clay-action {
            min-height: 44px;
            border-radius: 13px !important;
            border: 1px solid rgba(255, 255, 255, .9) !important;
            transition:
                transform .2s ease,
                box-shadow .2s ease,
                background .2s ease,
                color .2s ease;
        }

        .clay-health-record .clay-cancel-button {
            background:
                linear-gradient(145deg, #F8FCFA, #E7EFEB) !important;
            color: var(--text-muted) !important;
            box-shadow: var(--clay-small-shadow) !important;
        }

        .clay-health-record .clay-cancel-button:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .20),
                -5px -5px 12px rgba(255, 255, 255, .94);
        }

        .clay-health-record .clay-save-button {
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
        }

        .clay-health-record .clay-save-button:hover:not(:disabled) {
            transform: translateY(-1px);
            box-shadow:
                7px 7px 15px rgba(107, 134, 124, .23),
                -7px -7px 15px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .28) !important;
        }

        .clay-health-record .clay-save-button:disabled {
            cursor: not-allowed !important;
            opacity: .52;
            transform: none !important;
            box-shadow:
                3px 3px 8px rgba(107, 134, 124, .12),
                -3px -3px 8px rgba(255, 255, 255, .7) !important;
        }

        /* =========================================================
           FOOTER
        ========================================================== */

        .clay-health-record .clay-footer {
            color: var(--text-soft) !important;
        }

        /* =========================================================
           FOCUS ACCESSIBILITY
        ========================================================== */

        .clay-health-record a:focus-visible,
        .clay-health-record button:focus-visible,
        .clay-health-record input:focus-visible,
        .clay-health-record select:focus-visible,
        .clay-health-record textarea:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 639px) {
            .clay-health-record .clay-section {
                border-radius: 21px;
            }

            .clay-health-record .clay-section-header {
                padding: 17px;
            }

            .clay-health-record .clay-section-body {
                padding: 17px;
            }

            .clay-health-record .clay-page-heading {
                padding-left: 14px;
            }

            .clay-health-record .clay-page-title {
                font-size: 1.55rem !important;
            }

            .clay-health-record .clay-action {
                width: 100%;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */

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

        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}
        <header class="clay-top-header sticky top-0 z-30">

            <div class="flex min-h-20 items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">

                {{-- Mobile Menu --}}
                <button
                    type="button"
                    id="mobileMenuButton"
                    class="clay-mobile-menu flex items-center justify-center lg:hidden"
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

                {{-- Page Title --}}
                <div class="hidden min-w-0 sm:block">
                    <p class="clay-role-label text-xs font-semibold uppercase">
                        {{ auth()->user()->role }}
                    </p>

                    <h1 class="clay-header-title mt-1 text-lg font-bold tracking-tight">
                        Health Records
                    </h1>
                </div>

                {{-- Right Actions --}}
                <div class="ml-auto flex items-center gap-2 sm:gap-3">

                    @include('partials.notification-bell')

                    {{-- Profile --}}
                    <div class="clay-profile hidden items-center gap-3 border-l pl-3 sm:flex">

                        <div class="clay-profile-avatar flex h-9 w-9 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="max-w-40">
                            <p class="truncate text-sm font-semibold text-[#234E43]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="truncate text-xs text-[#6D817A]">
                                {{ auth()->user()->role }}
                            </p>
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

                {{-- Page Heading --}}
                <div class="clay-page-heading mb-7">

                    <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                        Add Health Record
                    </h2>

                    <p class="clay-page-description mt-1 max-w-2xl text-sm">
                        Create a medical health record for a registered resident.
                    </p>

                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="clay-error-alert mb-6 px-4 py-4">

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
                                    d="M12 9v3m0 4h.01M10.29 3.86l-7.82 13.5A1.5 1.5 0 003.77 19.6h16.46a1.5 1.5 0 001.3-2.24l-7.82-13.5a1.5 1.5 0 0 0-2.59 0z"
                                />
                            </svg>

                            <div>
                                <p class="clay-error-title text-sm font-semibold">
                                    Please correct the following errors:
                                </p>

                                <ul class="clay-error-list mt-1 list-disc pl-5 text-sm">
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
                    action="{{ route('health-records.store') }}"
                    class="space-y-6"
                >

                    @csrf

                    {{-- =================================================
                         RESIDENT INFORMATION
                    ================================================== --}}
                    <div class="clay-section">

                        <div class="clay-section-header">

                            <div class="clay-section-header-inner">

                                <div class="clay-section-icon">
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
                                            d="M16 19v-1a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v1M10 10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-5v6m3-3h-6"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="clay-section-title font-semibold">
                                        Resident Information
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Select the resident who will be assigned this health record.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="clay-section-body">

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
                                class="clay-input px-4 py-2.5 text-sm"
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
                                        — Resident #{{ $resident->id }}
                                    </option>

                                @endforeach

                            </select>

                            @error('resident_id')
                                <p class="clay-field-error mt-1.5 text-xs">
                                    {{ $message }}
                                </p>
                            @enderror

                            @if ($residents->isEmpty())

                                <div class="clay-warning mt-4 px-4 py-3 text-sm">

                                    <p class="clay-warning-title font-semibold">
                                        No residents are available.
                                    </p>

                                    <p class="clay-warning-text mt-0.5 text-xs">
                                        All registered residents may already have a health record.
                                    </p>

                                </div>

                            @else

                                <p class="clay-helper mt-2 text-xs">
                                    Only residents without an existing health record are listed.
                                </p>

                            @endif

                        </div>

                    </div>

                    {{-- =================================================
                         BASIC HEALTH INFORMATION
                    ================================================== --}}
                    <div class="clay-section">

                        <div class="clay-section-header">

                            <div class="clay-section-header-inner">

                                <div class="clay-section-icon">
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
                                            d="M12 21s8-4.35 8-10V5l-8-3-8 3v6c0 5.65 8 10 8 10Z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            d="M9 12h6M12 9v6"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="clay-section-title font-semibold">
                                        Basic Health Information
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Record the resident's current basic medical information.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="grid gap-5 p-5 md:grid-cols-2">

                            {{-- Blood Type --}}
                            <div>

                                <label
                                    for="blood_type"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Blood Type
                                </label>

                                <select
                                    id="blood_type"
                                    name="blood_type"
                                    class="clay-input px-4 py-2.5 text-sm"
                                >

                                    <option value="">
                                        Select blood type
                                    </option>

                                    @foreach (['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'] as $bloodType)

                                        <option
                                            value="{{ $bloodType }}"
                                            @selected(old('blood_type') === $bloodType)
                                        >
                                            {{ $bloodType }}
                                        </option>

                                    @endforeach

                                </select>

                                @error('blood_type')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Allergies --}}
                            <div>

                                <label
                                    for="allergies"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Allergies
                                </label>

                                <textarea
                                    id="allergies"
                                    name="allergies"
                                    rows="3"
                                    placeholder="e.g. Penicillin, peanuts, seafood, or None"
                                    class="clay-input resize-y px-4 py-2.5 text-sm"
                                >{{ old('allergies') }}</textarea>

                                @error('allergies')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                    {{-- =================================================
                         MEDICAL HISTORY
                    ================================================== --}}
                    <div class="clay-section">

                        <div class="clay-section-header">

                            <div class="clay-section-header-inner">

                                <div class="clay-section-icon">
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
                                            d="M8 4h8a2 2 0 0 1 2 2v14H6V6a2 2 0 0 1 2-2Zm2-2h4a1 1 0 0 1 1 1v1h-6V3a1 1 0 0 1 1-1Zm0 8h4m-4 4h4m-4 4h4"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="clay-section-title font-semibold">
                                        Medical History
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Document known conditions, previous medical history, and medications.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="space-y-5 p-5">

                            {{-- Chronic Conditions --}}
                            <div>

                                <label
                                    for="chronic_conditions"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Chronic Conditions
                                </label>

                                <textarea
                                    id="chronic_conditions"
                                    name="chronic_conditions"
                                    rows="3"
                                    placeholder="List diagnosed or ongoing chronic conditions..."
                                    class="clay-input resize-y px-4 py-2.5 text-sm"
                                >{{ old('chronic_conditions') }}</textarea>

                                @error('chronic_conditions')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Medical History --}}
                            <div>

                                <label
                                    for="medical_history"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Medical History
                                </label>

                                <textarea
                                    id="medical_history"
                                    name="medical_history"
                                    rows="4"
                                    placeholder="Record significant previous illnesses, surgeries, hospitalizations, or other relevant medical history..."
                                    class="clay-input resize-y px-4 py-2.5 text-sm"
                                >{{ old('medical_history') }}</textarea>

                                @error('medical_history')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Current Medications --}}
                            <div>

                                <label
                                    for="current_medications"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Current Medications
                                </label>

                                <textarea
                                    id="current_medications"
                                    name="current_medications"
                                    rows="3"
                                    placeholder="List current medications, dosage, and frequency when known..."
                                    class="clay-input resize-y px-4 py-2.5 text-sm"
                                >{{ old('current_medications') }}</textarea>

                                @error('current_medications')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Disabilities --}}
                            <div>

                                <label
                                    for="disabilities"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Disabilities
                                </label>

                                <textarea
                                    id="disabilities"
                                    name="disabilities"
                                    rows="3"
                                    placeholder="Record any known disability or special health-related condition..."
                                    class="clay-input resize-y px-4 py-2.5 text-sm"
                                >{{ old('disabilities') }}</textarea>

                                @error('disabilities')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Family Medical History --}}
                            <div>

                                <label
                                    for="family_medical_history"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Family Medical History
                                </label>

                                <textarea
                                    id="family_medical_history"
                                    name="family_medical_history"
                                    rows="3"
                                    placeholder="Record relevant hereditary or family medical conditions..."
                                    class="clay-input resize-y px-4 py-2.5 text-sm"
                                >{{ old('family_medical_history') }}</textarea>

                                @error('family_medical_history')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                    {{-- =================================================
                         EMERGENCY CONTACT
                    ================================================== --}}
                    <div class="clay-section">

                        <div class="clay-section-header">

                            <div class="clay-section-header-inner">

                                <div class="clay-section-icon">
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
                                            d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="clay-section-title font-semibold">
                                        Emergency Contact
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Provide a person who can be contacted during a health emergency.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="grid gap-5 p-5 md:grid-cols-3">

                            {{-- Name --}}
                            <div>

                                <label
                                    for="emergency_contact_name"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Contact Name
                                </label>

                                <input
                                    type="text"
                                    id="emergency_contact_name"
                                    name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name') }}"
                                    placeholder="Full name"
                                    class="clay-input px-4 py-2.5 text-sm"
                                >

                                @error('emergency_contact_name')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Number --}}
                            <div>

                                <label
                                    for="emergency_contact_number"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Contact Number
                                </label>

                                <input
                                    type="tel"
                                    id="emergency_contact_number"
                                    name="emergency_contact_number"
                                    value="{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay(old('emergency_contact_number')) ?: '+63' }}"
                                    inputmode="numeric"
                                    maxlength="24"
                                    placeholder="+6391 7123 4567"
                                    title="Only Globe and DITO SIM numbers are supported."
                                    class="clay-input px-4 py-2.5 text-sm"
                                >

                                @error('emergency_contact_number')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Relationship --}}
                            <div>

                                <label
                                    for="emergency_contact_relationship"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Relationship
                                </label>

                                <input
                                    type="text"
                                    id="emergency_contact_relationship"
                                    name="emergency_contact_relationship"
                                    value="{{ old('emergency_contact_relationship') }}"
                                    placeholder="e.g. Spouse, Parent, Sibling"
                                    class="clay-input px-4 py-2.5 text-sm"
                                >

                                @error('emergency_contact_relationship')
                                    <p class="clay-field-error mt-1.5 text-xs">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                    {{-- =================================================
                         NOTES
                    ================================================== --}}
                    <div class="clay-section">

                        <div class="clay-section-header">

                            <div class="clay-section-header-inner">

                                <div class="clay-section-icon">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.8"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8 6h8M8 10h8M8 14h5M5 3h14a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="clay-section-title font-semibold">
                                        Additional Notes
                                    </h3>

                                    <p class="clay-section-description mt-0.5 text-xs">
                                        Add any other relevant health information.
                                    </p>
                                </div>

                            </div>

                        </div>

                        <div class="clay-section-body">

                            <label
                                for="notes"
                                class="clay-label mb-2 block text-sm font-semibold"
                            >
                                Notes
                            </label>

                            <textarea
                                id="notes"
                                name="notes"
                                rows="4"
                                placeholder="Enter additional notes or observations..."
                                class="clay-input resize-y px-4 py-2.5 text-sm"
                            >{{ old('notes') }}</textarea>

                            @error('notes')
                                <p class="clay-field-error mt-1.5 text-xs">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- =================================================
                         FORM ACTIONS
                    ================================================== --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('health-records.index') }}"
                            class="clay-action clay-cancel-button inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            @disabled($residents->isEmpty())
                            class="clay-action clay-save-button inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold"
                        >
                            Save Health Record
                        </button>

                    </div>

                </form>

                {{-- Footer --}}
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