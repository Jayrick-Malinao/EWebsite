<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $resident->full_name }} | Resident Details</title>

    <meta
        name="description"
        content="View resident details for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;
            --primary-deep: #0F4C3A;
            --accent: #E87928;

            --bg: #EEF5F1;
            --surface: #F5FAF7;
            --surface-soft: #EDF5F0;
            --surface-raised: #F8FCFA;

            --text: #164238;
            --text-heading: #234E43;
            --text-secondary: #385C52;
            --text-muted: #6D817A;
            --text-soft: #9AA9A4;

            --danger: #B42323;
            --border-soft: rgba(210, 225, 218, 0.65);
            --border-white: rgba(255, 255, 255, 0.90);

            --shadow-dark: rgba(107, 134, 124, 0.18);
            --shadow-light: rgba(255, 255, 255, 0.92);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
        }

        .resident-page,
        .resident-page *,
        .resident-page input,
        .resident-page button,
        .resident-page select,
        .resident-page textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .resident-page {
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.92), transparent 34%),
                radial-gradient(circle at 100% 0%, rgba(22, 139, 112, 0.055), transparent 32%),
                linear-gradient(135deg, #EEF5F1 0%, #F5FAF7 52%, #EDF5F0 100%);
        }

        ::selection {
            color: #FFFFFF;
            background: var(--primary-dark);
        }

        /* Header */

        .resident-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow:
                0 5px 18px rgba(107, 134, 124, 0.08),
                0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .resident-mobile-button {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark);
            border: 1px solid var(--border-white);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition: transform 0.18s ease, color 0.18s ease;
        }

        .resident-mobile-button:hover {
            transform: translateY(-1px);
            color: var(--primary);
        }

        .resident-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.88);
        }

        .resident-category {
            color: var(--primary);
            letter-spacing: 0.08em;
        }

        .resident-title {
            color: var(--text);
        }

        .resident-description {
            color: var(--text-muted);
        }

        .resident-heading-wrap {
            position: relative;
        }

        .resident-heading-accent {
            position: absolute;
            left: -16px;
            top: 4px;
            width: 4px;
            height: calc(100% - 8px);
            min-height: 62px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--primary-light), var(--primary-dark));
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.16),
                -1px -1px 3px rgba(255, 255, 255, 0.82);
        }

        /* Clay surfaces */

        .resident-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow:
                8px 8px 18px var(--shadow-dark),
                -8px -8px 18px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            border-radius: 24px;
        }

        .resident-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        .resident-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.42);
        }

        .resident-icon-green {
            background: linear-gradient(145deg, #E7F5EE, #D9ECE4);
            color: var(--primary-dark);
        }

        /* Buttons */

        .resident-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow:
                5px 5px 12px rgba(15, 76, 58, 0.22),
                -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, filter 0.18s ease;
        }

        .resident-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
        }

        .resident-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.94);
            transition: transform 0.18s ease, background 0.18s ease;
        }

        .resident-secondary:hover {
            transform: translateY(-1px);
            background: linear-gradient(145deg, #FFFFFF, #EEF6F2);
        }

        .resident-button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-radius: 12px;
            padding: 10px 17px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        /* Details */

        .resident-detail-label {
            display: block;
            margin-bottom: 7px;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.055em;
            text-transform: uppercase;
        }

        .resident-detail-value {
            color: var(--text);
            font-size: 14px;
            font-weight: 700;
            line-height: 1.65;
            overflow-wrap: anywhere;
            white-space: normal;
        }

        .resident-section-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(210, 225, 218, 0.65);
            padding-bottom: 16px;
        }

        .resident-section-heading h3 {
            margin: 0;
            color: var(--text);
            font-size: 16px;
            font-weight: 800;
        }

        .resident-section-heading p {
            margin: 5px 0 0;
            color: var(--text-muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .resident-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 999px;
            padding: 6px 11px;
            font-size: 11px;
            font-weight: 800;
        }

        .resident-status-active {
            background: #E7F7EF;
            color: #126647;
        }

        .resident-status-inactive {
            background: #FCEFED;
            color: #B42323;
        }

        .resident-status-default {
            background: #EDF5F0;
            color: #385C52;
        }

        .resident-record-footer {
            color: var(--text-muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .resident-page a:focus-visible,
        .resident-page button:focus-visible {
            outline: 3px solid var(--accent) !important;
            outline-offset: 3px;
        }

        @media (max-width: 1023px) {
            .resident-heading-accent {
                display: none;
            }
        }

        @media (max-width: 639px) {
            .resident-button {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
            }
        }
    </style>
</head>

<body class="resident-page antialiased">

    {{-- Mobile Sidebar Overlay --}}
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-[#164238]/40 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Content --}}
    <main class="min-h-screen lg:pl-72">

        {{-- TOP HEADER --}}
        <header class="resident-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="resident-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                        aria-controls="sidebar-overlay"
                        aria-expanded="false"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="resident-category text-xs font-bold uppercase tracking-wider">
                            Barangay Esperanza Health Center
                        </p>

                        <h1 class="resident-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Resident Management
                        </h1>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="max-w-40 truncate text-sm font-bold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs font-medium text-[#6D817A]">
                                {{ auth()->user()->role ?? 'System Administrator' }}
                            </p>
                        </div>

                        <div class="resident-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="resident-heading-wrap min-w-0 lg:ml-4">
                    <span class="resident-heading-accent" aria-hidden="true"></span>

                    <p class="resident-category mb-1 text-xs font-bold uppercase tracking-wider">
                        Resident Record
                    </p>

                    <h2 class="resident-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ $resident->full_name }}
                    </h2>

                    <p class="resident-description mt-2 max-w-2xl text-sm leading-6">
                        View the resident's personal profile, household association, and registered contact information.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
                    <a
                        href="{{ route('residents.index') }}"
                        class="resident-button resident-secondary"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back to Residents
                    </a>

                    <a
                        href="{{ route('residents.edit', $resident) }}"
                        class="resident-button resident-primary"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.65-1.65a1.875 1.875 0 1 1 2.652 2.652l-8.78 8.78a4.5 4.5 0 0 1-1.897 1.13l-3.258.93.93-3.258a4.5 4.5 0 0 1 1.13-1.897l7.523-7.523Z" />
                        </svg>
                        Edit Resident
                    </a>
                </div>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
                <div class="resident-card mb-6 rounded-2xl border-l-4 border-l-[#168B70] p-4 text-sm text-[#0F6F5A]" role="status">
                    <div class="flex items-center gap-3">
                        <div class="resident-icon resident-icon-green h-9 w-9 rounded-xl">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </div>

                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- VALIDATION / ERROR MESSAGES --}}
            @if(session('error'))
                <div class="resident-card mb-6 rounded-2xl border-l-4 border-l-[#B42323] p-4 text-sm text-[#B42323]" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            {{-- PROFILE SUMMARY --}}
            <section class="resident-card mb-6 p-6 sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

                    <div class="flex min-w-0 items-center gap-5">
                        <div class="resident-icon resident-icon-green h-16 w-16 rounded-2xl text-2xl font-bold sm:h-20 sm:w-20">
                            {{ strtoupper(substr($resident->first_name ?? 'R', 0, 1)) }}
                        </div>

                        <div class="min-w-0">
                            <p class="resident-category text-xs font-bold uppercase tracking-wider">
                                Resident Profile
                            </p>

                            <h2 class="mt-1 break-words text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                                {{ $resident->full_name }}
                            </h2>

                            <p class="mt-2 text-xs font-semibold text-[#6D817A]">
                                Resident Record ID:
                                <span class="text-[#164238]">{{ $resident->id }}</span>
                            </p>

                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                @if(strtolower((string) $resident->status) === 'active')
                                    <span class="resident-status resident-status-active">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        Active
                                    </span>
                                @elseif(strtolower((string) $resident->status) === 'inactive')
                                    <span class="resident-status resident-status-inactive">
                                        <span class="h-1.5 w-1.5 rounded-full bg-current"></span>
                                        Inactive
                                    </span>
                                @else
                                    <span class="resident-status resident-status-default">
                                        {{ $resident->status ?? 'Status not specified' }}
                                    </span>
                                @endif

                                @if($resident->is_household_head)
                                    <span class="resident-status resident-status-active">
                                        Household Head
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="resident-inset grid grid-cols-2 gap-4 rounded-2xl p-4 sm:gap-6">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                Age
                            </p>
                            <p class="mt-1 text-lg font-bold text-[#164238]">
                                {{ $resident->birth_date ? $resident->birth_date->age . ' years' : '—' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                Gender
                            </p>
                            <p class="mt-1 text-lg font-bold text-[#164238]">
                                {{ $resident->gender ?? '—' }}
                            </p>
                        </div>
                    </div>

                </div>
            </section>

            {{-- DETAILS GRID --}}
            <div class="grid gap-6 xl:grid-cols-2">

                {{-- PERSONAL INFORMATION --}}
                <section class="resident-card p-5 sm:p-6">
                    <div class="resident-section-heading">
                        <div class="resident-icon resident-icon-green h-11 w-11 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>

                        <div>
                            <h3>Personal Information</h3>
                            <p>Basic demographic and identification details.</p>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">First Name</span>
                            <p class="resident-detail-value">{{ $resident->first_name ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Middle Name</span>
                            <p class="resident-detail-value">{{ $resident->middle_name ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Last Name</span>
                            <p class="resident-detail-value">{{ $resident->last_name ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Suffix</span>
                            <p class="resident-detail-value">{{ $resident->suffix ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Date of Birth</span>
                            <p class="resident-detail-value">
                                {{ $resident->birth_date?->format('F d, Y') ?? '—' }}
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Age</span>
                            <p class="resident-detail-value">
                                {{ $resident->birth_date ? $resident->birth_date->age . ' years old' : '—' }}
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Gender</span>
                            <p class="resident-detail-value">{{ $resident->gender ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Civil Status</span>
                            <p class="resident-detail-value">{{ $resident->civil_status ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4 sm:col-span-2">
                            <span class="resident-detail-label">PhilHealth Number</span>
                            <p class="resident-detail-value">{{ $resident->philhealth_number ?? '—' }}</p>
                        </div>
                    </div>
                </section>

                {{-- CONTACT INFORMATION --}}
                <section class="resident-card p-5 sm:p-6">
                    <div class="resident-section-heading">
                        <div class="resident-icon resident-icon-green h-11 w-11 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 6 9 7 9-7" />
                            </svg>
                        </div>

                        <div>
                            <h3>Contact Information</h3>
                            <p>Registered communication details and address.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Contact Number</span>
                            <p class="resident-detail-value">{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($resident->contact_number) ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Email Address</span>
                            <p class="resident-detail-value">{{ $resident->email ?? '—' }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Resident Address</span>
                            <p class="resident-detail-value">{{ $resident->household_address ?? '—' }}</p>
                        </div>
                    </div>
                </section>

                {{-- HOUSEHOLD INFORMATION --}}
                <section class="resident-card p-5 sm:p-6">
                    <div class="resident-section-heading">
                        <div class="resident-icon resident-icon-green h-11 w-11 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7M5 9v11h14V9M9 20v-7h6v7" />
                            </svg>
                        </div>

                        <div>
                            <h3>Household Information</h3>
                            <p>Household registration and relationship details.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Household Code</span>
                            <p class="resident-detail-value">
                                {{ $resident->household?->household_code ?? 'Not assigned' }}
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Household Head</span>
                            <p class="resident-detail-value">
                                @if($resident->is_household_head)
                                    {{ $resident->full_name }}
                                    <span class="font-normal text-[#6D817A]">(This resident)</span>
                                @else
                                    {{ $resident->household?->household_head_name ?? '—' }}
                                @endif
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Relationship to Household Head</span>
                            <p class="resident-detail-value">
                                {{ $resident->relationship_to_head ?? '—' }}
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Household Address</span>
                            <p class="resident-detail-value">
                                {{ $resident->household?->address ?? $resident->household_address ?? '—' }}
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Household Contact Number</span>
                            <p class="resident-detail-value">
                                {{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($resident->household?->contact_number) ?? '—' }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- RECORD INFORMATION --}}
                <section class="resident-card p-5 sm:p-6">
                    <div class="resident-section-heading">
                        <div class="resident-icon resident-icon-green h-11 w-11 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 8h8M8 12h8M8 16h5" />
                            </svg>
                        </div>

                        <div>
                            <h3>Record Information</h3>
                            <p>System record identifier and timestamps.</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Resident Record ID</span>
                            <p class="resident-detail-value">{{ $resident->id }}</p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Record Created</span>
                            <p class="resident-detail-value">
                                {{ $resident->created_at?->format('F d, Y h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div class="resident-inset rounded-xl p-4">
                            <span class="resident-detail-label">Last Updated</span>
                            <p class="resident-detail-value">
                                {{ $resident->updated_at?->format('F d, Y h:i A') ?? '—' }}
                            </p>
                        </div>
                    </div>
                </section>

            </div>

        </div>
    </main>

    {{-- MOBILE SIDEBAR SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (!menuButton || !overlay || !sidebar) {
                return;
            }

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                menuButton.setAttribute('aria-expanded', 'true');
                overlay.setAttribute('aria-hidden', 'false');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                menuButton.setAttribute('aria-expanded', 'false');
                overlay.setAttribute('aria-hidden', 'true');
            };

            menuButton.addEventListener('click', () => {
                const isOpen = menuButton.getAttribute('aria-expanded') === 'true';

                if (isOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>

</body>
</html>
