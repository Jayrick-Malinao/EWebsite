<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Household {{ $household->household_code }}
        | Barangay Esperanza Health Center
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ==========================================================
           BARANGAY ESPERANZA — GOVERNMENT CLAYMORPHISM
        =========================================================== */

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
            --danger-light: #DC2626;

            --warning: #8A6A28;
            --warning-bg: #FBF7ED;
            --warning-bg-dark: #F2EBD9;

            --shadow-raised:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84);

            --shadow-small:
                4px 4px 10px rgba(107, 134, 124, .18),
                -4px -4px 10px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .80);

            --shadow-inset:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82);
        }

        html {
            background: var(--bg);
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif !important;
            color: var(--text) !important;
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
                ) !important;
            -webkit-font-smoothing: antialiased;
            text-rendering: optimizeLegibility;
        }

        button,
        input,
        select,
        textarea,
        option {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        button,
        a,
        input,
        select,
        textarea {
            -webkit-tap-highlight-color: transparent;
        }

        a,
        button {
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background-color .18s ease,
                border-color .18s ease,
                color .18s ease;
        }

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 2px;
        }

        /* ==========================================================
           PAGE SHELL
        =========================================================== */

        .clay-household-page {
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

        /* ==========================================================
           STICKY HEADER
        =========================================================== */

        .clay-header {
            background: rgba(245, 250, 247, .94) !important;
            border-bottom: 1px solid rgba(210, 225, 218, .78) !important;
            box-shadow:
                0 5px 18px rgba(107, 134, 124, .10),
                inset 0 -1px 0 rgba(255, 255, 255, .80);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-header-inner {
            min-height: 80px;
        }

        .clay-eyebrow {
            color: var(--primary) !important;
            letter-spacing: .18em;
        }

        .clay-header-title {
            color: var(--text-dark) !important;
        }

        .clay-header-description {
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           RAISED NAVIGATION / ACTION BUTTON
        =========================================================== */

        .clay-back-button {
            border: 1px solid rgba(255, 255, 255, .88) !important;
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;
            color: var(--text-dark) !important;
            box-shadow: var(--shadow-small) !important;
        }

        .clay-back-button:hover {
            transform: translateY(-1px);
            color: var(--primary-dark) !important;
            border-color: rgba(42, 155, 128, .22) !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .21),
                -5px -5px 12px rgba(255, 255, 255, .94),
                inset 1px 1px 0 rgba(255, 255, 255, .86) !important;
        }

        /* ==========================================================
           MAIN CONTENT / PAGE HEADING
        =========================================================== */

        .clay-main {
            position: relative;
        }

        .clay-page-heading {
            position: relative;
            padding-left: 17px;
        }

        .clay-page-heading::before {
            content: "";
            position: absolute;
            top: 2px;
            bottom: 2px;
            left: 0;
            width: 4px;
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow: 2px 2px 6px rgba(15, 111, 90, .18);
        }

        .clay-breadcrumb {
            color: var(--text-muted) !important;
        }

        .clay-breadcrumb a:hover {
            color: var(--primary-dark) !important;
        }

        .clay-household-title {
            color: var(--text-dark) !important;
        }

        .clay-household-code {
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           PRIMARY ACTION
        =========================================================== */

        .clay-primary-button {
            border: 1px solid rgba(255, 255, 255, .42) !important;
            background:
                linear-gradient(
                    145deg,
                    var(--primary-light),
                    var(--primary-dark)
                ) !important;
            color: #FFFFFF !important;
            box-shadow:
                4px 4px 10px rgba(15, 111, 90, .20),
                -3px -3px 8px rgba(255, 255, 255, .62),
                inset 1px 1px 0 rgba(255, 255, 255, .22) !important;
        }

        .clay-primary-button:hover {
            transform: translateY(-2px);
            background:
                linear-gradient(
                    145deg,
                    #2F9F83,
                    #0F6F5A
                ) !important;
            box-shadow:
                6px 6px 13px rgba(15, 111, 90, .23),
                -4px -4px 10px rgba(255, 255, 255, .68),
                inset 1px 1px 0 rgba(255, 255, 255, .24) !important;
        }

        /* ==========================================================
           RAISED CARDS
        =========================================================== */

        .clay-card {
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .86) !important;
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;
            box-shadow: var(--shadow-raised) !important;
        }

        .clay-card-header {
            border-bottom: 1px solid rgba(210, 225, 218, .62) !important;
            background: rgba(245, 250, 247, .48);
        }

        .clay-section-title {
            color: var(--text-dark) !important;
        }

        .clay-section-description {
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           ICON TILES
        =========================================================== */

        .clay-icon {
            border: 1px solid rgba(255, 255, 255, .72);
            box-shadow: var(--shadow-small);
        }

        .clay-icon-green {
            background:
                linear-gradient(
                    145deg,
                    #DDF3EA,
                    #CBE8DD
                ) !important;
            color: var(--primary-dark) !important;
        }

        .clay-icon-amber {
            background:
                linear-gradient(
                    145deg,
                    #FBF7ED,
                    #F2EBD9
                ) !important;
            color: var(--warning) !important;
        }

        .clay-icon-sky {
            background:
                linear-gradient(
                    145deg,
                    #EDF7F4,
                    #DCEFE9
                ) !important;
            color: var(--primary-dark) !important;
        }

        /* ==========================================================
           INFORMATION VALUES
        =========================================================== */

        .clay-field-label {
            color: var(--text-soft) !important;
            letter-spacing: .08em;
        }

        .clay-field-value {
            color: var(--text-dark) !important;
        }

        .clay-field-muted {
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           STATUS BADGES
        =========================================================== */

        .clay-status-active {
            border: 1px solid rgba(22, 139, 112, .16);
            background:
                linear-gradient(
                    145deg,
                    #E8F7F1,
                    #DCEFE8
                ) !important;
            color: var(--primary-dark) !important;
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, .12),
                -2px -2px 5px rgba(255, 255, 255, .80),
                inset 1px 1px 0 rgba(255, 255, 255, .75);
        }

        .clay-status-inactive {
            border: 1px solid rgba(107, 134, 124, .13);
            background:
                linear-gradient(
                    145deg,
                    #F1F5F3,
                    #E7ECE9
                ) !important;
            color: var(--text-muted) !important;
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, .10),
                -2px -2px 5px rgba(255, 255, 255, .76),
                inset 1px 1px 0 rgba(255, 255, 255, .72);
        }

        /* ==========================================================
           HOUSEHOLD HEAD NOTICE CARD
        =========================================================== */

        .clay-head-card {
            border-color: rgba(190, 160, 90, .22) !important;
            background:
                linear-gradient(
                    145deg,
                    #FCFAF3,
                    #F3EEDC
                ) !important;
            box-shadow:
                9px 9px 20px rgba(145, 128, 83, .14),
                -9px -9px 20px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .82) !important;
        }

        .clay-head-header {
            border-bottom-color: rgba(190, 160, 90, .17) !important;
            background: rgba(251, 247, 237, .58) !important;
        }

        /* ==========================================================
           FAMILY MEMBER ROWS
        =========================================================== */

        .clay-member-row {
            border-bottom: 1px solid rgba(210, 225, 218, .58);
            background: transparent;
        }

        .clay-member-row:last-child {
            border-bottom: 0;
        }

        .clay-member-row:hover {
            background: rgba(255, 255, 255, .46) !important;
        }

        .clay-avatar {
            border: 1px solid rgba(255, 255, 255, .86);
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #DDEAE4
                ) !important;
            color: var(--primary-dark) !important;
            box-shadow: var(--shadow-small);
        }

        .clay-member-name {
            color: var(--text-dark) !important;
        }

        .clay-member-meta {
            color: var(--text-muted) !important;
        }

        .clay-relationship {
            border: 1px solid rgba(22, 139, 112, .14) !important;
            background:
                linear-gradient(
                    145deg,
                    #E8F7F1,
                    #DCEFE8
                ) !important;
            color: var(--primary-dark) !important;
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, .10),
                -2px -2px 5px rgba(255, 255, 255, .76),
                inset 1px 1px 0 rgba(255, 255, 255, .72);
        }

        .clay-relationship-empty {
            border: 1px solid rgba(107, 134, 124, .12) !important;
            background:
                linear-gradient(
                    145deg,
                    #F1F5F3,
                    #E7ECE9
                ) !important;
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           EMPTY STATE
        =========================================================== */

        .clay-empty-icon {
            border: 1px solid rgba(255, 255, 255, .90);
            background:
                linear-gradient(
                    145deg,
                    #EDF5F0,
                    #DCE9E3
                ) !important;
            color: var(--text-soft) !important;
            box-shadow: var(--shadow-small);
        }

        .clay-empty-title {
            color: var(--text-dark) !important;
        }

        .clay-empty-description {
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           RESPONSIVE
        =========================================================== */

        @media (max-width: 639px) {
            .clay-page-heading {
                padding-left: 12px;
            }

            .clay-page-heading::before {
                width: 3px;
            }

            .clay-card {
                border-radius: 20px !important;
            }

            .clay-header-inner {
                min-height: 72px;
            }

            .clay-primary-button {
                width: 100%;
            }
        }

        /* ==========================================================
           REDUCED MOTION
        =========================================================== */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }

            .clay-primary-button:hover,
            .clay-back-button:hover {
                transform: none !important;
            }
        }
    </style>
</head>

<body>

    {{-- ==========================================================
         PAGE WRAPPER
    =========================================================== --}}
    <div class="clay-household-page min-h-screen">

        @include('dashboard.sidebar')

        <div class="min-h-screen w-full lg:pl-72">

            {{-- ======================================================
                 HEADER
            ======================================================= --}}
            <header class="clay-header sticky top-0 z-30">

                <div class="clay-header-inner flex items-center justify-between gap-6 px-4 sm:px-6 lg:px-8">

                    <div class="min-w-0">

                        <h1 class="clay-header-title truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Household Details
                        </h1>

                    </div>

                    <a
                        href="{{ route('households.index') }}"
                        class="clay-back-button inline-flex shrink-0 items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold"
                    >

                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m15 18-6-6 6-6"
                            />
                        </svg>

                        <span class="hidden sm:inline">
                            Back to Households
                        </span>

                        <span class="sm:hidden">
                            Back
                        </span>

                    </a>

                </div>

            </header>


            {{-- ======================================================
                 MAIN CONTENT
            ======================================================= --}}
            <main class="clay-main w-full">

                <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

                    {{-- ==================================================
                         PAGE HEADING
                    =================================================== --}}
                    <div class="clay-page-heading mb-7">

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">

                            <div class="min-w-0">

                                <h2 class="clay-household-title text-2xl font-bold tracking-tight sm:text-3xl">
                                    {{ $household->household_head_name }}
                                </h2>

                                <p class="clay-household-code mt-1 text-sm">
                                    Household Code: {{ $household->household_code }}
                                </p>

                            </div>


                            <a
                                href="{{ route('households.edit', $household) }}"
                                class="clay-primary-button inline-flex h-11 shrink-0 items-center justify-center gap-2 rounded-xl px-5 text-sm font-semibold"
                            >

                                <svg
                                    class="h-4 w-4 shrink-0"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.862 3.487a2.1 2.1 0 0 1 2.97 2.97L8.5 17.79 4 19l1.21-4.5L16.862 3.487Z"
                                    />
                                </svg>

                                Edit Household

                            </a>

                        </div>

                    </div>


                    {{-- ==================================================
                         HOUSEHOLD INFORMATION
                    =================================================== --}}
                    <section class="clay-card mb-7 rounded-[26px]">

                        <div class="clay-card-header px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-icon clay-icon-green flex h-11 w-11 shrink-0 items-center justify-center rounded-xl">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="m3 10 9-7 9 7M5 9v11h14V9M9 20v-6h6v6"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="clay-section-title text-base font-bold">
                                        Household Information
                                    </h3>

                                    <p class="clay-section-description text-xs">
                                        General information about this household.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-3">

                            {{-- Household Code --}}
                            <div>

                                <p class="clay-field-label text-xs font-semibold uppercase">
                                    Household Code
                                </p>

                                <p class="clay-field-value mt-1 text-sm font-bold">
                                    {{ $household->household_code }}
                                </p>

                            </div>


                            {{-- Status --}}
                            <div>

                                <p class="clay-field-label text-xs font-semibold uppercase">
                                    Status
                                </p>

                                <div class="mt-2">

                                    <span class="clay-status-{{ $household->status === 'Active' ? 'active' : 'inactive' }} inline-flex items-center gap-1.5 rounded-full px-3 py-1.5 text-xs font-bold">

                                        @if ($household->status === 'Active')
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        @else
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        @endif

                                        {{ $household->status }}

                                    </span>

                                </div>

                            </div>


                            {{-- Family Members --}}
                            <div>

                                <p class="clay-field-label text-xs font-semibold uppercase">
                                    Family Members
                                </p>

                                <p class="clay-field-value mt-1 text-sm font-bold">
                                    {{ $household->residents->count() }}
                                    {{ Str::plural('resident', $household->residents->count()) }}
                                </p>

                            </div>


                            {{-- Address --}}
                            <div class="sm:col-span-2 lg:col-span-3">

                                <p class="clay-field-label text-xs font-semibold uppercase">
                                    Address
                                </p>

                                <p class="clay-field-value mt-1 text-sm leading-6">
                                    {{ $household->address }}
                                </p>

                            </div>


                            {{-- Contact --}}
                            <div>

                                <p class="clay-field-label text-xs font-semibold uppercase">
                                    Contact Number
                                </p>

                                <p class="clay-field-muted mt-1 text-sm">
                                    {{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($household->contact_number) ?: 'Not provided' }}
                                </p>

                            </div>

                        </div>

                    </section>


                    {{-- ==================================================
                         HOUSEHOLD HEAD
                    =================================================== --}}
                    @php
                        $householdHead = $household->residents
                            ->firstWhere('is_household_head', true);
                    @endphp

                    <section class="clay-card mb-7 overflow-hidden rounded-[26px]">

                    @if ($householdHead)

                        <details class="group">

                            <summary class="clay-card-header clay-head-header flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-5 sm:px-6">

                                <div class="flex items-center gap-3">

                                    <div class="clay-icon clay-icon-amber flex h-11 w-11 shrink-0 items-center justify-center rounded-xl">

                                        <svg
                                            class="h-5 w-5"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M15 19a6 6 0 0 0-12 0m6-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z"
                                            />
                                        </svg>

                                    </div>

                                    <div class="min-w-0">

                                        <h3 class="clay-section-title text-base font-bold">
                                            Household Head
                                        </h3>

                                        <p class="clay-section-description text-xs">
                                            Primary household member.
                                        </p>

                                    </div>

                                </div>

                                <svg
                                    class="h-5 w-5 shrink-0 transition-transform group-open:rotate-180"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                                </svg>

                            </summary>


                            <div class="grid gap-6 p-5 sm:grid-cols-2 sm:p-6 lg:grid-cols-4">

                                {{-- Full Name --}}
                                <div>

                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                        Full Name
                                    </p>

                                    <p class="clay-field-value mt-1 text-sm font-bold">
                                        {{ $householdHead->full_name }}
                                    </p>

                                </div>


                                {{-- Birth Date --}}
                                <div>

                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                        Birth Date
                                    </p>

                                    <p class="clay-field-muted mt-1 text-sm">
                                        {{ $householdHead->birth_date?->format('F d, Y') ?? 'Not provided' }}
                                    </p>
                                    <p class="clay-field-muted mt-1 text-sm">
                                        Age: {{ $householdHead->birth_date ? $householdHead->birth_date->age . ' years' : 'N/A' }}
                                    </p>

                                </div>


                                {{-- Gender --}}
                                <div>

                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                        Gender
                                    </p>

                                    <p class="clay-field-muted mt-1 text-sm">
                                        {{ $householdHead->gender }}
                                    </p>

                                </div>


                                {{-- Civil Status --}}
                                <div>

                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                        Civil Status
                                    </p>

                                    <p class="clay-field-muted mt-1 text-sm">
                                        {{ $householdHead->civil_status }}
                                    </p>

                                </div>


                                {{-- Contact Number --}}
                                <div>

                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                        Contact Number
                                    </p>

                                    <p class="clay-field-muted mt-1 text-sm">
                                        {{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($householdHead->contact_number) ?: 'Not provided' }}
                                    </p>

                                </div>


                                {{-- Email --}}
                                <div>

                                    <p class="min-w-0 clay-field-label text-xs font-semibold uppercase">
                                        Email
                                    </p>

                                    <p class="clay-field-muted mt-1 break-all text-sm">
                                        {{ $householdHead->email ?: 'Not provided' }}
                                    </p>

                                </div>


                                {{-- PhilHealth Number --}}
                                <div class="sm:col-span-2">

                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                        PhilHealth Number
                                    </p>

                                    <p class="clay-field-muted mt-1 text-sm">
                                        {{ $householdHead->philhealth_number ?: 'Not provided' }}
                                    </p>

                                </div>

                            </div>

                        </details>

                    @endif


                    {{-- ==================================================
                         FAMILY MEMBERS
                    =================================================== --}}
                    <details class="group">

                        <summary class="clay-card-header flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-5 sm:px-6">

                            <div class="flex items-center gap-3">

                                <div class="clay-icon clay-icon-sky flex h-11 w-11 shrink-0 items-center justify-center rounded-xl">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8 10v-2a4 4 0 0 0-3-3.87m-1-11a4 4 0 0 1 0 7.75"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <h3 class="clay-section-title text-base font-bold">
                                        Family Members
                                    </h3>

                                    <p class="clay-section-description text-xs">
                                        Residents registered under this household.
                                    </p>

                                </div>

                            </div>

                            <svg
                                class="h-5 w-5 shrink-0 transition-transform group-open:rotate-180"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" />
                            </svg>

                        </summary>

                        @php
                            $familyMembers = $household->residents
                                ->where('is_household_head', false);
                        @endphp


                        @if ($familyMembers->count())

                            <div>

                                @foreach ($familyMembers as $member)

                                    <div class="clay-member-row p-5 sm:p-6">

                                        <div class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between">

                                            {{-- Member Identity --}}
                                            <div class="flex min-w-0 items-start gap-4">

                                                {{-- Initial --}}
                                                <div class="clay-avatar flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-bold">

                                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}

                                                </div>


                                                {{-- Name + Relationship --}}
                                                <div class="min-w-0">

                                                    <h4 class="clay-member-name truncate text-sm font-bold">
                                                        {{ $member->full_name }}
                                                    </h4>


                                                    {{-- Relationship to Household Head --}}
                                                    <div class="mt-2">

                                                        @if ($member->relationship_to_head)

                                                            <span class="clay-relationship inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold uppercase tracking-wide">

                                                                <svg
                                                                    class="h-3.5 w-3.5"
                                                                    fill="none"
                                                                    stroke="currentColor"
                                                                    stroke-width="1.8"
                                                                    viewBox="0 0 24 24"
                                                                >
                                                                    <path
                                                                        stroke-linecap="round"
                                                                        stroke-linejoin="round"
                                                                        d="M17 20h5v-2a4 4 0 0 0-4-4h-1m-4-4a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm6 4a4 4 0 0 0-3-3.87M9 14H5a4 4 0 0 0-4 4v2h8"
                                                                    />
                                                                </svg>

                                                                {{ $member->relationship_to_head }}

                                                            </span>

                                                        @else

                                                            <span class="clay-relationship-empty inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold">
                                                                Relationship not provided
                                                            </span>

                                                        @endif

                                                    </div>


                                                    <p class="clay-member-meta mt-2 text-xs">
                                                        Resident #{{ $member->id }}
                                                    </p>

                                                </div>

                                            </div>


                                            {{-- Member Details --}}
                                            <div class="grid gap-4 sm:grid-cols-3 lg:min-w-[520px]">

                                                {{-- Birth Date --}}
                                                <div>

                                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                                        Birth Date
                                                    </p>

                                                    <p class="clay-field-muted mt-1 text-sm">
                                                        {{ $member->birth_date?->format('M d, Y') ?? '—' }}
                                                    </p>
                                                    <p class="clay-field-muted mt-1 text-sm">
                                                        Age: {{ $member->birth_date ? $member->birth_date->age . ' years' : 'N/A' }}
                                                    </p>

                                                </div>


                                                {{-- Gender --}}
                                                <div>

                                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                                        Gender
                                                    </p>

                                                    <p class="clay-field-muted mt-1 text-sm">
                                                        {{ $member->gender ?: '—' }}
                                                    </p>

                                                </div>


                                                {{-- Civil Status --}}
                                                <div>

                                                    <p class="clay-field-label text-xs font-semibold uppercase">
                                                        Civil Status
                                                    </p>

                                                    <p class="clay-field-muted mt-1 text-sm">
                                                        {{ $member->civil_status ?: '—' }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                @endforeach

                            </div>

                        @else

                            <div class="px-6 py-12 text-center">

                                <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full">

                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2m8-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8 10v-2a4 4 0 0 0-3-3.87m-1-11a4 4 0 0 0 0 7.75"
                                        />
                                    </svg>

                                </div>

                                <p class="clay-empty-title mt-4 text-sm font-bold">
                                    No additional family members
                                </p>

                                <p class="clay-empty-description mt-1 text-xs">
                                    Only the household head is currently registered.
                                </p>

                            </div>

                        @endif

                    </details>

                    </section>

                </div>

            </main>

        </div>

    </div>

</body>

</html>