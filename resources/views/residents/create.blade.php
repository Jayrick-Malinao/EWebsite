<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Resident | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
        }

        * {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        html {
            background: var(--bg);
        }

        body {
            background:
                radial-gradient(circle at 7% 3%, rgba(255, 255, 255, .90), transparent 28%),
                radial-gradient(circle at 94% 7%, rgba(42, 155, 128, .08), transparent 24%),
                linear-gradient(135deg, #EEF5F1, #F5FAF7 52%, #EDF5F0) !important;
            color: var(--text) !important;
        }

        button,
        a,
        input,
        select,
        textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-add-page {
            min-height: 100vh;
        }

        /* =========================
           HEADER
        ========================= */

        .clay-header {
            background: rgba(245, 250, 247, .94) !important;
            border-color: rgba(210, 225, 218, .75) !important;
            box-shadow:
                0 5px 18px rgba(107, 134, 124, .10),
                inset 0 -1px 0 rgba(255, 255, 255, .78);
        }

        .clay-mobile-button,
        .clay-back-button {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            border: 1px solid rgba(255, 255, 255, .90) !important;
            color: var(--text-dark) !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .16),
                -4px -4px 10px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .80);
            transition: .2s ease;
        }

        .clay-mobile-button:hover,
        .clay-back-button:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        .clay-eyebrow {
            color: var(--primary-dark) !important;
        }

        .clay-header-title {
            color: var(--text) !important;
        }

        .clay-header-description {
            color: var(--text-muted) !important;
        }

        /* =========================
           PAGE CONTENT
        ========================= */

        .clay-page-heading {
            position: relative;
            padding-left: 18px;
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
            box-shadow: 2px 2px 5px rgba(107, 134, 124, .16);
        }

        .clay-page-title {
            color: var(--text) !important;
        }

        .clay-page-description {
            color: var(--text-muted) !important;
        }

        /* =========================
           VALIDATION ERROR
        ========================= */

        .clay-error-alert {
            background: linear-gradient(145deg, #FFF7F7, #F8EAEA) !important;
            border: 1px solid rgba(230, 184, 184, .72) !important;
            box-shadow:
                7px 7px 16px rgba(120, 82, 82, .12),
                -7px -7px 16px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
        }

        .clay-error-icon {
            background: linear-gradient(145deg, #FDECEC, #F5DADA) !important;
            color: #B42323 !important;
            box-shadow:
                3px 3px 8px rgba(120, 82, 82, .12),
                -3px -3px 8px rgba(255, 255, 255, .82),
                inset 1px 1px 0 rgba(255, 255, 255, .70);
        }

        .clay-error-title {
            color: #8F2424 !important;
        }

        .clay-error-list {
            color: #A43A3A !important;
        }

        /* =========================
           FORM CARDS
        ========================= */

        .clay-form-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            border: 1px solid rgba(255, 255, 255, .88) !important;
            border-radius: 26px !important;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84) !important;
        }

        .clay-card-header {
            border-color: rgba(210, 225, 218, .70) !important;
        }

        .clay-section-title {
            color: var(--text) !important;
        }

        .clay-section-description {
            color: var(--text-muted) !important;
        }

        /* =========================
           SECTION ICONS
        ========================= */

        .clay-icon {
            border: 1px solid rgba(255, 255, 255, .82);
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .14),
                -4px -4px 10px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .65);
        }

        .clay-icon-green {
            background: linear-gradient(145deg, #E8F7F0, #D7ECE3) !important;
            color: var(--primary-dark) !important;
        }

        .clay-icon-blue {
            background: linear-gradient(145deg, #EDF6F7, #DDECEB) !important;
            color: #286C73 !important;
        }

        .clay-icon-violet {
            background: linear-gradient(145deg, #F1EEF8, #E5E0F1) !important;
            color: #625080 !important;
        }

        .clay-icon-orange {
            background: linear-gradient(145deg, #FBF0E6, #F4DFCC) !important;
            color: #A65B20 !important;
        }

        /* =========================
           FORM LABELS
        ========================= */

        .clay-label {
            color: var(--text-dark) !important;
        }

        .clay-required {
            color: #C43A3A !important;
        }

        .clay-help {
            color: var(--text-soft) !important;
        }

        /* =========================
           INSET INPUTS
        ========================= */

        .clay-input {
            width: 100%;
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA) !important;
            border: 1px solid rgba(206, 222, 214, .90) !important;
            border-radius: 14px !important;
            color: var(--text-dark) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82) !important;
            transition:
                border-color .2s ease,
                box-shadow .2s ease,
                background .2s ease,
                color .2s ease;
        }

        .clay-input::placeholder {
            color: var(--text-soft) !important;
        }

        .clay-input:hover:not(:disabled) {
            border-color: rgba(168, 195, 184, .95) !important;
        }

        .clay-input:focus {
            border-color: var(--primary) !important;
            outline: none !important;
            background: linear-gradient(145deg, #EAF4EF, #F9FCFA) !important;
            box-shadow:
                0 0 0 3px rgba(22, 139, 112, .10),
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .84) !important;
        }

        .clay-input:disabled {
            opacity: .70;
            cursor: not-allowed;
            background: linear-gradient(145deg, #E7EEEA, #F1F5F2) !important;
            color: #9AA9A4 !important;
        }

        .clay-input.clay-input-error {
            border-color: rgba(180, 35, 35, .55) !important;
        }

        .clay-input.clay-input-error:focus {
            border-color: #B42323 !important;
            box-shadow:
                0 0 0 3px rgba(180, 35, 35, .10),
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .84) !important;
        }

        /* =========================
           FIELD ERROR TEXT
        ========================= */

        .clay-field-error {
            color: #B42323 !important;
        }

        /* =========================
           ACTIONS
        ========================= */

        .clay-cancel-button {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            border: 1px solid rgba(255, 255, 255, .88) !important;
            color: var(--text-dark) !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .18),
                -5px -5px 12px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
            transition: .2s ease;
        }

        .clay-cancel-button:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-1px);
        }

        .clay-save-button {
            background: linear-gradient(145deg, var(--primary-light), var(--primary-dark)) !important;
            border: 1px solid rgba(255, 255, 255, .24) !important;
            color: #fff !important;
            box-shadow:
                6px 6px 14px rgba(107, 134, 124, .22),
                -6px -6px 14px rgba(255, 255, 255, .80),
                inset 1px 1px 0 rgba(255, 255, 255, .20);
            transition: .2s ease;
        }

        .clay-save-button:hover {
            background: linear-gradient(145deg, #329F84, #0D654F) !important;
            transform: translateY(-2px);
            box-shadow:
                8px 8px 17px rgba(107, 134, 124, .25),
                -7px -7px 15px rgba(255, 255, 255, .82),
                inset 1px 1px 0 rgba(255, 255, 255, .20);
        }

        .clay-save-button:active,
        .clay-cancel-button:active {
            transform: translateY(0);
        }

        /* =========================
           SIDEBAR OVERLAY
        ========================= */

        .clay-sidebar-overlay {
            background: rgba(22, 66, 56, .24) !important;
            backdrop-filter: blur(2px);
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 639px) {
            .clay-form-card {
                border-radius: 21px !important;
            }

            .clay-page-heading {
                padding-left: 14px;
            }

            .clay-page-heading::before {
                width: 3px;
            }

            .clay-save-button,
            .clay-cancel-button,
            .clay-back-button {
                width: 100%;
            }
        }

        /* =========================
           ACCESSIBILITY
        ========================= */

        :focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition: none !important;
                animation: none !important;
            }
        }
    </style>
</head>

<body class="clay-add-page min-h-screen text-slate-900">

    {{-- Mobile Sidebar Overlay --}}
    <div
        id="sidebarOverlay"
        class="clay-sidebar-overlay fixed inset-0 z-40 hidden lg:hidden"
    ></div>

    {{-- Shared Sidebar --}}
    @include('dashboard.sidebar')

    <main class="min-h-screen lg:pl-72">

        {{-- Header --}}
        <header class="clay-header sticky top-0 z-30 border-b backdrop-blur">
            <div class="flex min-h-20 items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-3">

                    <button
                        id="openSidebar"
                        type="button"
                        class="clay-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open sidebar"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-eyebrow text-xs font-semibold uppercase tracking-[0.18em]">
                            Resident Management
                        </p>

                        <h1 class="clay-header-title mt-1 text-lg font-bold tracking-tight sm:text-xl">
                            Add Resident
                        </h1>
                    </div>

                </div>

                <a
                    href="{{ route('residents.index') }}"
                    class="clay-back-button inline-flex h-10 shrink-0 items-center justify-center rounded-xl px-4 text-sm font-semibold"
                >
                    Back
                </a>

            </div>
        </header>


        {{-- Main Content --}}
        <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            <div class="mx-auto max-w-5xl">

                {{-- Page Introduction --}}
                <div class="clay-page-heading mb-7">

                    <h2 class="clay-page-title text-2xl font-bold tracking-tight">
                        Register New Resident
                    </h2>

                    <p class="clay-page-description mt-1 text-sm">
                        Enter the household, personal, contact, and identification information below.
                    </p>

                </div>


                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="clay-error-alert mb-6 rounded-2xl p-4">

                        <div class="flex gap-3">

                            <div class="clay-error-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-xl">
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <circle cx="12" cy="12" r="9" />
                                    <path
                                        stroke-linecap="round"
                                        d="M12 8v4M12 16h.01"
                                    />
                                </svg>
                            </div>

                            <div>
                                <p class="clay-error-title text-sm font-semibold">
                                    Please check the following:
                                </p>

                                <ul class="clay-error-list mt-2 space-y-1 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>

                    </div>
                @endif


                <form
                    action="{{ route('residents.store') }}"
                    method="POST"
                    class="space-y-6"
                >

                    @csrf


                    {{-- ========================================================= --}}
                    {{-- HOUSEHOLD INFORMATION --}}
                    {{-- ========================================================= --}}
                    <section class="clay-form-card overflow-hidden">

                        <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-icon clay-icon-green flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-5h6v5"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="clay-section-title text-sm font-bold">
                                        Household Information
                                    </h2>

                                    <p class="clay-section-description text-xs">
                                        Select the household and specify this resident's household role.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">

                            {{-- Household --}}
                            <div class="sm:col-span-2">

                                <label
                                    for="household_id"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Household
                                    <span class="clay-required">*</span>
                                </label>

                                <select
                                    id="household_id"
                                    name="household_id"
                                    required
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option value="">
                                        Select household
                                    </option>

                                    @forelse ($households as $household)
                                        <option
                                            value="{{ $household->id }}"
                                            @selected((string) old('household_id') === (string) $household->id)
                                        >
                                            {{ $household->household_code }}
                                            —
                                            {{ $household->household_head_name ?: 'No household head assigned' }}
                                        </option>
                                    @empty
                                        <option value="" disabled>
                                            No households available
                                        </option>
                                    @endforelse
                                </select>

                                @if ($households->isEmpty())
                                    <p class="mt-1.5 text-xs font-medium text-amber-600">
                                        Please create a household before adding a resident.
                                    </p>
                                @endif

                                @error('household_id')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Household Role --}}
                            <div>

                                <label
                                    for="is_household_head"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Household Role
                                    <span class="clay-required">*</span>
                                </label>

                                <select
                                    id="is_household_head"
                                    name="is_household_head"
                                    required
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option
                                        value="0"
                                        @selected(old('is_household_head', '0') == '0')
                                    >
                                        Family Member
                                    </option>

                                    <option
                                        value="1"
                                        @selected(old('is_household_head') == '1')
                                    >
                                        Household Head
                                    </option>
                                </select>

                                @error('is_household_head')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Relationship --}}
                            <div>

                                <label
                                    for="relationship_to_head"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Relationship to Household Head
                                </label>

                                <select
                                    id="relationship_to_head"
                                    name="relationship_to_head"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option value="">
                                        Select relationship
                                    </option>

                                    @foreach ([
                                        'Spouse',
                                        'Son',
                                        'Daughter',
                                        'Father',
                                        'Mother',
                                        'Brother',
                                        'Sister',
                                        'Grandfather',
                                        'Grandmother',
                                        'Grandchild',
                                        'Other Relative',
                                        'Non-Relative'
                                    ] as $relationship)

                                        <option
                                            value="{{ $relationship }}"
                                            @selected(old('relationship_to_head') === $relationship)
                                        >
                                            {{ $relationship }}
                                        </option>

                                    @endforeach

                                </select>

                                <p
                                    id="relationship-help"
                                    class="clay-help mt-1.5 text-[11px]"
                                >
                                    Select the resident's relationship to the household head.
                                </p>

                                @error('relationship_to_head')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- ========================================================= --}}
                    {{-- PERSONAL INFORMATION --}}
                    {{-- ========================================================= --}}
                    <section class="clay-form-card overflow-hidden">

                        <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-icon clay-icon-green flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 19a6 6 0 0 0-12 0m6-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm7 8v-2a4 4 0 0 0-3-3.87m0-8a4 4 0 0 1 0 7.75"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="clay-section-title text-sm font-bold">
                                        Personal Information
                                    </h2>

                                    <p class="clay-section-description text-xs">
                                        Enter the resident's basic personal information.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 lg:grid-cols-4 sm:px-6">

                            {{-- First Name --}}
                            <div>

                                <label
                                    for="first_name"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    First Name
                                    <span class="clay-required">*</span>
                                </label>

                                <input
                                    id="first_name"
                                    type="text"
                                    name="first_name"
                                    value="{{ old('first_name') }}"
                                    required
                                    maxlength="100"
                                    autocomplete="given-name"
                                    placeholder="Enter first name"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('first_name')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Middle Name --}}
                            <div>

                                <label
                                    for="middle_name"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Middle Name
                                </label>

                                <input
                                    id="middle_name"
                                    type="text"
                                    name="middle_name"
                                    value="{{ old('middle_name') }}"
                                    maxlength="100"
                                    autocomplete="additional-name"
                                    placeholder="Enter middle name"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('middle_name')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Last Name --}}
                            <div>

                                <label
                                    for="last_name"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Last Name
                                    <span class="clay-required">*</span>
                                </label>

                                <input
                                    id="last_name"
                                    type="text"
                                    name="last_name"
                                    value="{{ old('last_name') }}"
                                    required
                                    maxlength="100"
                                    autocomplete="family-name"
                                    placeholder="Enter last name"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('last_name')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Suffix --}}
                            <div>

                                <label
                                    for="suffix"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Suffix
                                </label>

                                <select
                                    id="suffix"
                                    name="suffix"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option value="">
                                        None
                                    </option>

                                    @foreach (['Jr.', 'Sr.', 'II', 'III', 'IV', 'V'] as $suffix)
                                        <option
                                            value="{{ $suffix }}"
                                            @selected(old('suffix') === $suffix)
                                        >
                                            {{ $suffix }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('suffix')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Birth Date --}}
                            <div>

                                <label
                                    for="birth_date"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Birth Date
                                    <span class="clay-required">*</span>
                                </label>

                                <input
                                    id="birth_date"
                                    type="date"
                                    name="birth_date"
                                    value="{{ old('birth_date') }}"
                                    max="{{ now()->format('Y-m-d') }}"
                                    required
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('birth_date')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Gender --}}
                            <div>

                                <label
                                    for="gender"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Gender
                                    <span class="clay-required">*</span>
                                </label>

                                <select
                                    id="gender"
                                    name="gender"
                                    required
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option value="">
                                        Select gender
                                    </option>

                                    <option
                                        value="Male"
                                        @selected(old('gender') === 'Male')
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        @selected(old('gender') === 'Female')
                                    >
                                        Female
                                    </option>

                                </select>

                                @error('gender')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Civil Status --}}
                            <div>

                                <label
                                    for="civil_status"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Civil Status
                                </label>

                                <select
                                    id="civil_status"
                                    name="civil_status"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option value="">
                                        Select civil status
                                    </option>

                                    @foreach ([
                                        'Single',
                                        'Married',
                                        'Widowed',
                                        'Separated',
                                        'Divorced'
                                    ] as $civilStatus)

                                        <option
                                            value="{{ $civilStatus }}"
                                            @selected(old('civil_status') === $civilStatus)
                                        >
                                            {{ $civilStatus }}
                                        </option>

                                    @endforeach
                                </select>

                                @error('civil_status')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- ========================================================= --}}
                    {{-- CONTACT & IDENTIFICATION --}}
                    {{-- ========================================================= --}}
                    <section class="clay-form-card overflow-hidden">

                        <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-icon clay-icon-blue flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.967-.852-1.09l-4.423-1.106a1.125 1.125 0 0 0-1.173.417l-.97 1.293c-.27.36-.73.5-1.16.345a12.035 12.035 0 0 1-7.184-7.184c-.155-.43-.015-.89.345-1.16l1.293-.97c.364-.273.53-.74.417-1.173L6.787 2.98A1.125 1.125 0 0 0 5.697 2.25H4.325A2.25 2.25 0 0 0 2.075 4.5v2.25Z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="clay-section-title text-sm font-bold">
                                        Contact & Identification
                                    </h2>

                                    <p class="clay-section-description text-xs">
                                        Contact details and government health identification.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">

                            {{-- Contact Number --}}
                            <div>

                                <label
                                    for="contact_number"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Contact Number
                                </label>

                                <input
                                    id="contact_number"
                                    type="tel"
                                    name="contact_number"
                                    value="{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay(old('contact_number')) ?: '+63' }}"
                                    inputmode="numeric"
                                    maxlength="24"
                                    autocomplete="tel"
                                    placeholder="+6391 7123 4567"
                                    title="Only Globe and DITO SIM numbers are supported."
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('contact_number')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Email --}}
                            <div>

                                <label
                                    for="email"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Email Address
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    maxlength="255"
                                    autocomplete="email"
                                    placeholder="resident@example.com"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('email')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- PhilHealth --}}
                            <div>

                                <label
                                    for="philhealth_number"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    PhilHealth Number
                                </label>

                                <input
                                    id="philhealth_number"
                                    type="text"
                                    name="philhealth_number"
                                    value="{{ old('philhealth_number') }}"
                                    maxlength="50"
                                    placeholder="Enter PhilHealth number"
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >

                                @error('philhealth_number')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Status --}}
                            <div>

                                <label
                                    for="status"
                                    class="clay-label mb-2 block text-sm font-semibold"
                                >
                                    Status
                                    <span class="clay-required">*</span>
                                </label>

                                <select
                                    id="status"
                                    name="status"
                                    required
                                    class="clay-input px-4 py-3 text-sm outline-none"
                                >
                                    <option
                                        value="Active"
                                        @selected(old('status', 'Active') === 'Active')
                                    >
                                        Active
                                    </option>

                                    <option
                                        value="Inactive"
                                        @selected(old('status') === 'Inactive')
                                    >
                                        Inactive
                                    </option>
                                </select>

                                @error('status')
                                    <p class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </section>


                    {{-- ========================================================= --}}
                    {{-- ADDRESS --}}
                    {{-- ========================================================= --}}
                    <section class="clay-form-card overflow-hidden">

                        <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-icon clay-icon-violet flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h2 class="clay-section-title text-sm font-bold">
                                        Address
                                    </h2>

                                    <p class="clay-section-description text-xs">
                                        Current residential address of the resident.
                                    </p>
                                </div>

                            </div>

                        </div>


                        <div class="px-5 py-6 sm:px-6">

                            <div class="max-w-xl">

                                <div>
                                    <label
                                        for="purok"
                                        class="clay-label mb-2 block text-sm font-semibold"
                                    >
                                        Purok
                                    </label>

                                    <select
                                        id="purok"
                                        name="purok"
                                        class="clay-input w-full px-4 py-3 text-sm outline-none"
                                        required
                                        aria-describedby="{{ $errors->has('purok') ? 'purok-error' : '' }}"
                                        aria-invalid="{{ $errors->has('purok') ? 'true' : 'false' }}"
                                    >
                                        <option value="">
                                            Select Purok
                                        </option>

                                        @foreach ($puroks as $purok)
                                            <option
                                                value="{{ $purok }}"
                                                @selected(old('purok', $addressParts['purok']) === $purok)
                                            >
                                                {{ $purok }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('purok')
                                        <p id="purok-error" class="clay-field-error mt-1.5 text-xs font-medium">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <input type="hidden" name="household_address" value="">
                            </div>

                            <div class="mt-5 grid gap-5 sm:grid-cols-3">
                                @foreach ($localityParts as $label => $value)
                                    <div>
                                        <label
                                            for="resident-locality-{{ strtolower($label) }}"
                                            class="clay-label mb-2 block text-sm font-semibold"
                                        >
                                            {{ $label }}
                                        </label>

                                        <input
                                            id="resident-locality-{{ strtolower($label) }}"
                                            type="text"
                                            value="{{ $value }}"
                                            readonly
                                            class="clay-input w-full px-4 py-3 text-sm outline-none"
                                            aria-label="{{ $label }}: {{ $value }} (fixed locality)"
                                        >
                                    </div>
                                @endforeach
                            </div>

                        </div>

                    </section>


                    {{-- ========================================================= --}}
                    {{-- FORM ACTIONS --}}
                    {{-- ========================================================= --}}
                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('residents.index') }}"
                            class="clay-cancel-button inline-flex h-11 items-center justify-center rounded-xl px-5 text-sm font-semibold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-save-button inline-flex h-11 items-center justify-center rounded-xl px-6 text-sm font-semibold"
                        >
                            Save Resident
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </main>


    {{-- ========================================================= --}}
    {{-- HOUSEHOLD ROLE / RELATIONSHIP BEHAVIOR --}}
    {{-- ========================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openButton = document.getElementById('openSidebar');

            if (sidebar && overlay && openButton) {
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
            }

            const householdRole = document.getElementById('is_household_head');
            const relationship = document.getElementById('relationship_to_head');
            const relationshipHelp = document.getElementById('relationship-help');

            if (!householdRole || !relationship) {
                return;
            }

            function updateRelationshipField() {
                const isHouseholdHead = householdRole.value === '1';

                relationship.disabled = isHouseholdHead;

                if (isHouseholdHead) {
                    relationship.value = '';

                    relationship.classList.add(
                        'cursor-not-allowed',
                        'bg-slate-100',
                        'text-slate-400'
                    );

                    if (relationshipHelp) {
                        relationshipHelp.textContent =
                            'Relationship is not required for the household head.';
                    }
                } else {
                    relationship.classList.remove(
                        'cursor-not-allowed',
                        'bg-slate-100',
                        'text-slate-400'
                    );

                    if (relationshipHelp) {
                        relationshipHelp.textContent =
                            "Select the resident's relationship to the household head.";
                    }
                }
            }

            householdRole.addEventListener(
                'change',
                updateRelationshipField
            );

            updateRelationshipField();
        });
    </script>

</body>
</html>