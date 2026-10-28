<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit {{ $resident->full_name }} | Barangay Esperanza Health Center</title>

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

        .clay-edit-page {
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

        .clay-mobile-button {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE) !important;
            border: 1px solid rgba(255, 255, 255, .90) !important;
            color: var(--primary-dark) !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .16),
                -4px -4px 10px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .80);
            transition: .2s ease;
        }

        .clay-mobile-button:hover {
            transform: translateY(-1px);
        }

        .clay-eyebrow {
            color: var(--primary-dark) !important;
        }

        .clay-header-title,
        .clay-user-name {
            color: var(--text) !important;
        }

        .clay-user-role {
            color: var(--text-muted) !important;
        }

        .clay-user-avatar {
            background: linear-gradient(145deg, var(--primary-light), var(--primary-dark)) !important;
            color: #fff !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .18),
                -4px -4px 10px rgba(255, 255, 255, .85),
                inset 1px 1px 0 rgba(255, 255, 255, .28);
        }

        /* =========================
           PAGE INTRO
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

        .clay-resident-badge {
            background: linear-gradient(145deg, #F8FCFA, #E8F0EC) !important;
            border: 1px solid rgba(255, 255, 255, .88) !important;
            color: var(--text-muted) !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .14),
                -4px -4px 10px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
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

        /* =========================
           FORM LABELS
        ========================= */

        .clay-label {
            color: var(--text-dark) !important;
        }

        .clay-required {
            color: #C43A3A !important;
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
                background .2s ease;
        }

        .clay-input::placeholder {
            color: var(--text-soft) !important;
        }

        .clay-input:hover {
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
            opacity: .65;
            cursor: not-allowed;
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
            .clay-cancel-button {
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

<body class="clay-edit-page min-h-screen text-slate-900">

    <div
        id="sidebarOverlay"
        class="clay-sidebar-overlay fixed inset-0 z-40 hidden lg:hidden"
    ></div>

    @include('dashboard.sidebar')

    <main class="min-h-screen lg:pl-72">

        {{-- Header --}}
        <header class="clay-header sticky top-0 z-30 border-b backdrop-blur">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                <div class="flex items-center gap-3">

                    <button
                        id="openSidebar"
                        type="button"
                        class="clay-mobile-button inline-flex h-10 w-10 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open sidebar"
                    >
                        <svg
                            class="h-5 w-5"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div>
                        <p class="clay-eyebrow text-xs font-semibold uppercase tracking-wider">
                            Resident Management
                        </p>

                        <h1 class="clay-header-title text-lg font-bold sm:text-xl">
                            Edit Resident
                        </h1>
                    </div>

                </div>

                <div class="hidden items-center gap-3 sm:flex">
                    <div class="text-right">
                        <p class="clay-user-name text-sm font-semibold">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="clay-user-role text-xs">
                            System Administrator
                        </p>
                    </div>

                    <div class="clay-user-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </div>

            </div>
        </header>


        {{-- Content --}}
        <div class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- Introduction --}}
            <div class="clay-page-heading mb-7">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <h2 class="clay-page-title text-2xl font-bold tracking-tight">
                            Edit Resident Information
                        </h2>

                        <p class="clay-page-description mt-1 text-sm">
                            Update the information for
                            <span class="font-semibold text-[#234E43]">
                                {{ $resident->full_name }}
                            </span>.
                        </p>
                    </div>

                    <span class="clay-resident-badge inline-flex w-fit items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-semibold">
                        Resident #{{ str_pad($resident->id, 5, '0', STR_PAD_LEFT) }}
                    </span>

                </div>
            </div>


            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="clay-error-alert mb-6 rounded-2xl p-4">

                    <div class="flex gap-3">

                        <div class="clay-error-icon flex h-9 w-9 shrink-0 items-center justify-center rounded-xl">
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle cx="12" cy="12" r="9" />
                                <path stroke-linecap="round" d="M12 8v4M12 16h.01" />
                            </svg>
                        </div>

                        <div>
                            <p class="clay-error-title text-sm font-semibold">
                                Please correct the following errors:
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


            {{-- Update Form --}}
            <form
                method="POST"
                action="{{ route('residents.update', $resident) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')

                {{-- Preserve Household Information --}}
                <input
                    type="hidden"
                    name="household_id"
                    value="{{ old('household_id', $resident->household_id) }}"
                >

                <input
                    type="hidden"
                    name="is_household_head"
                    value="{{ $resident->is_household_head ? '1' : '0' }}"
                >

                <input
                    type="hidden"
                    name="relationship_to_head"
                    value="{{ old('relationship_to_head', $resident->relationship_to_head ?? '') }}"
                >


                {{-- Personal Information --}}
                <section class="clay-form-card overflow-hidden">

                    <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-icon clay-icon-green flex h-10 w-10 items-center justify-center rounded-xl">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <circle cx="12" cy="8" r="3" />
                                    <path
                                        stroke-linecap="round"
                                        d="M5 21c.8-4.3 3.1-6.5 7-6.5s6.2 2.2 7 6.5"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h3 class="clay-section-title text-base font-bold">
                                    Personal Information
                                </h3>

                                <p class="clay-section-description text-xs">
                                    Update the resident's demographic information.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 lg:grid-cols-4 sm:px-6">

                        {{-- First Name --}}
                        <div>
                            <label for="first_name" class="clay-label mb-2 block text-sm font-semibold">
                                First Name <span class="clay-required">*</span>
                            </label>

                            <input
                                id="first_name"
                                name="first_name"
                                type="text"
                                value="{{ old('first_name', $resident->first_name) }}"
                                required
                                maxlength="255"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>


                        {{-- Middle Name --}}
                        <div>
                            <label for="middle_name" class="clay-label mb-2 block text-sm font-semibold">
                                Middle Name
                            </label>

                            <input
                                id="middle_name"
                                name="middle_name"
                                type="text"
                                value="{{ old('middle_name', $resident->middle_name) }}"
                                maxlength="255"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>


                        {{-- Last Name --}}
                        <div>
                            <label for="last_name" class="clay-label mb-2 block text-sm font-semibold">
                                Last Name <span class="clay-required">*</span>
                            </label>

                            <input
                                id="last_name"
                                name="last_name"
                                type="text"
                                value="{{ old('last_name', $resident->last_name) }}"
                                required
                                maxlength="255"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>


                        {{-- Suffix --}}
                        <div>
                            <label for="suffix" class="clay-label mb-2 block text-sm font-semibold">
                                Suffix
                            </label>

                            <select
                                id="suffix"
                                name="suffix"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                                <option value="">None</option>
                                <option value="Jr." @selected(old('suffix', $resident->suffix) === 'Jr.')>Jr.</option>
                                <option value="Sr." @selected(old('suffix', $resident->suffix) === 'Sr.')>Sr.</option>
                                <option value="II" @selected(old('suffix', $resident->suffix) === 'II')>II</option>
                                <option value="III" @selected(old('suffix', $resident->suffix) === 'III')>III</option>
                                <option value="IV" @selected(old('suffix', $resident->suffix) === 'IV')>IV</option>
                                <option value="V" @selected(old('suffix', $resident->suffix) === 'V')>V</option>
                            </select>
                        </div>


                        {{-- Birth Date --}}
                        <div>
                            <label for="birth_date" class="clay-label mb-2 block text-sm font-semibold">
                                Birth Date <span class="clay-required">*</span>
                            </label>

                            <input
                                id="birth_date"
                                name="birth_date"
                                type="date"
                                value="{{ old('birth_date', $resident->birth_date?->format('Y-m-d')) }}"
                                max="{{ now()->format('Y-m-d') }}"
                                required
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>


                        {{-- Gender --}}
                        <div>
                            <label for="gender" class="clay-label mb-2 block text-sm font-semibold">
                                Gender <span class="clay-required">*</span>
                            </label>

                            <select
                                id="gender"
                                name="gender"
                                required
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                                <option value="Male" @selected(old('gender', $resident->gender) === 'Male')>
                                    Male
                                </option>

                                <option value="Female" @selected(old('gender', $resident->gender) === 'Female')>
                                    Female
                                </option>
                            </select>
                        </div>


                        {{-- Civil Status --}}
                        <div>
                            <label for="civil_status" class="clay-label mb-2 block text-sm font-semibold">
                                Civil Status
                            </label>

                            <select
                                id="civil_status"
                                name="civil_status"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                                <option value="">Select civil status</option>
                                <option value="Single" @selected(old('civil_status', $resident->civil_status) === 'Single')>Single</option>
                                <option value="Married" @selected(old('civil_status', $resident->civil_status) === 'Married')>Married</option>
                                <option value="Widowed" @selected(old('civil_status', $resident->civil_status) === 'Widowed')>Widowed</option>
                                <option value="Separated" @selected(old('civil_status', $resident->civil_status) === 'Separated')>Separated</option>
                                <option value="Divorced" @selected(old('civil_status', $resident->civil_status) === 'Divorced')>Divorced</option>
                            </select>
                        </div>


                        {{-- Status --}}
                        <div>
                            <label for="status" class="clay-label mb-2 block text-sm font-semibold">
                                Record Status <span class="clay-required">*</span>
                            </label>

                            <select
                                id="status"
                                name="status"
                                required
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                                <option value="Active" @selected(old('status', $resident->status) === 'Active')>
                                    Active
                                </option>

                                <option value="Inactive" @selected(old('status', $resident->status) === 'Inactive')>
                                    Inactive
                                </option>
                            </select>
                        </div>

                    </div>

                </section>


                {{-- Contact --}}
                <section class="clay-form-card overflow-hidden">

                    <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-icon clay-icon-blue flex h-10 w-10 items-center justify-center rounded-xl">
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
                                        d="M5 4h4l2 5-2.5 1.5a14 14 0 0 0 5 5L15 13l5 2v4c0 1.1-.9 2-2 2C10.3 21 3 13.7 3 5a2 2 0 0 1 2-2Z"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h3 class="clay-section-title text-base font-bold">
                                    Contact & Address
                                </h3>

                                <p class="clay-section-description text-xs">
                                    Update contact and household information.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">

                        <div>
                            <label for="contact_number" class="clay-label mb-2 block text-sm font-semibold">
                                Contact Number
                            </label>

                            <input
                                id="contact_number"
                                name="contact_number"
                                type="tel"
                                value="{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay(old('contact_number', $resident->contact_number)) ?: '+63' }}"
                                inputmode="numeric"
                                maxlength="24"
                                autocomplete="tel"
                                placeholder="+6391 7123 4567"
                                title="Only Globe and DITO SIM numbers are supported."
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>


                        <div>
                            <label for="email" class="clay-label mb-2 block text-sm font-semibold">
                                Email Address
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email', $resident->email) }}"
                                maxlength="255"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>


                        <div class="space-y-5 sm:col-span-2 lg:col-span-4">

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

                            <div class="grid gap-5 sm:grid-cols-3">
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

                    </div>

                </section>


                {{-- Health Identification --}}
                <section class="clay-form-card overflow-hidden">

                    <div class="clay-card-header border-b px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-icon clay-icon-violet flex h-10 w-10 items-center justify-center rounded-xl">
                                <svg
                                    class="h-5 w-5"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <rect x="4" y="3" width="16" height="18" rx="2" />
                                    <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h5" />
                                </svg>
                            </div>

                            <div>
                                <h3 class="clay-section-title text-base font-bold">
                                    Health Identification
                                </h3>

                                <p class="clay-section-description text-xs">
                                    Update health identification information.
                                </p>
                            </div>

                        </div>

                    </div>


                    <div class="px-5 py-6 sm:px-6">

                        <div class="max-w-xl">
                            <label for="philhealth_number" class="clay-label mb-2 block text-sm font-semibold">
                                PhilHealth Number
                            </label>

                            <input
                                id="philhealth_number"
                                name="philhealth_number"
                                type="text"
                                value="{{ old('philhealth_number', $resident->philhealth_number) }}"
                                maxlength="100"
                                class="clay-input px-4 py-3 text-sm outline-none"
                            >
                        </div>

                    </div>

                </section>


                {{-- Actions --}}
                <div class="flex items-center justify-end gap-3">

                    <a
                        href="{{ route('residents.show', $resident) }}"
                        class="clay-cancel-button inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="clay-save-button inline-flex items-center justify-center rounded-xl px-6 py-3 text-sm font-semibold"
                    >
                        Save Changes
                    </button>

                </div>

            </form>

        </div>

    </main>


    {{-- Mobile Sidebar Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const openButton = document.getElementById('openSidebar');

            if (!sidebar || !overlay || !openButton) {
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

            openButton.addEventListener('click', openSidebar);
            overlay.addEventListener('click', closeSidebar);
        });
    </script>

</body>
</html>