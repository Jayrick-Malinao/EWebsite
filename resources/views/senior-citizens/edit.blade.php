<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Senior Citizen | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Update senior citizen record for Barangay Esperanza Health Center."
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
            --danger-bright: #DC2626;

            --border-soft: rgba(210, 225, 218, 0.65);
            --border-white: rgba(255, 255, 255, 0.90);

            --shadow-dark: rgba(107, 134, 124, 0.18);
            --shadow-medium: rgba(107, 134, 124, 0.12);
            --shadow-light: rgba(255, 255, 255, 0.92);

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 24px;
            --radius-2xl: 28px;
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
        }

        .clay-households,
        .clay-households *,
        .clay-households input,
        .clay-households button,
        .clay-households select,
        .clay-households textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-households {
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

        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow:
                0 5px 18px rgba(107, 134, 124, 0.08),
                0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-mobile-button {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark);
            border: 1px solid var(--border-white);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition: transform 0.18s ease, box-shadow 0.18s ease, color 0.18s ease;
        }

        .clay-mobile-button:hover {
            transform: translateY(-1px);
            color: var(--primary);
        }

        .clay-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.88);
        }

        .clay-category {
            color: var(--primary);
            letter-spacing: 0.08em;
        }

        .clay-title {
            color: var(--text);
        }

        .clay-description {
            color: var(--text-muted);
        }

        .clay-heading-wrap {
            position: relative;
        }

        .clay-heading-accent {
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

        .clay-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow:
                8px 8px 18px var(--shadow-dark),
                -8px -8px 18px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            border-radius: 24px;
        }

        .clay-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        .clay-icon {
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

        .clay-icon-green {
            background: linear-gradient(145deg, #E7F5EE, #D9ECE4);
            color: var(--primary-dark);
        }

        .clay-input {
            width: 100%;
            min-height: 46px;
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA) !important;
            color: var(--text) !important;
            border: 1px solid rgba(255, 255, 255, 0.92) !important;
            border-radius: var(--radius-md) !important;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82) !important;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        .clay-input:focus {
            outline: none;
            border-color: rgba(22, 139, 112, 0.55) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86),
                0 0 0 3px rgba(22, 139, 112, 0.12) !important;
        }

        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow:
                5px 5px 12px rgba(15, 76, 58, 0.22),
                -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        }

        .clay-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
        }

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.94);
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .clay-secondary:hover {
            transform: translateY(-1px);
            background: linear-gradient(145deg, #FFFFFF, #EEF6F2);
        }

        .clay-danger {
            background: linear-gradient(145deg, #FCF1DF, #FCEFED);
            border: 1px solid rgba(180, 35, 35, 0.14);
            color: var(--danger);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, 0.11),
                -5px -5px 12px rgba(255, 255, 255, 0.88);
        }

        .clay-households a:focus-visible,
        .clay-households button:focus-visible,
        .clay-households input:focus-visible,
        .clay-households select:focus-visible,
        .clay-households textarea:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        @media (max-width: 1023px) {
            .clay-heading-accent {
                display: none;
            }

            main {
                padding-left: 0;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition-duration: 0.01ms !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body class="clay-households antialiased">

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

        {{-- Top Header --}}
        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                        aria-controls="sidebar-overlay"
                        aria-expanded="false"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-category text-xs font-bold uppercase tracking-wider">
                            Barangay Esperanza Health Center
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Senior Citizen Program
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

                        <div class="clay-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- Page Content --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- Page Heading --}}
            <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">
                        Senior Citizen Record
                    </p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Edit {{ $seniorCitizen->resident->full_name }}
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Update senior citizen registration, pension, and health details.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('senior-citizens.show', $seniorCitizen) }}"
                        class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back to Record
                    </a>
                </div>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="clay-danger mb-6 rounded-2xl p-4 sm:p-5" role="alert" aria-live="assertive">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-white text-[#B42323]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.6 2.6 17a2 2 0 0 0 1.73 3h15.34a2 2 0 0 0 1.73-3L13.7 3.6a2 2 0 0 0-3.4 0Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-[#B42323]">
                                Please correct the following errors
                            </h3>

                            <ul class="mt-2 list-inside list-disc text-xs leading-5 text-[#B42323]">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Resident Summary Card --}}
            <section class="clay-card mb-6 p-5 sm:p-6">
                <div class="flex items-center gap-4">
                    <div class="clay-icon clay-icon-green h-12 w-12 rounded-xl text-lg font-bold">
                        {{ strtoupper(substr($seniorCitizen->resident->first_name, 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-[#164238]">
                            {{ $seniorCitizen->resident->full_name }}
                        </h3>

                        <p class="text-xs font-semibold text-[#6D817A]">
                            Born {{ $seniorCitizen->resident->birth_date?->format('F d, Y') ?? '—' }}
                            · {{ $seniorCitizen->resident->birth_date?->age ?? '—' }} yrs old
                        </p>
                    </div>
                </div>
            </section>

            {{-- Form --}}
            <form method="POST" action="{{ route('senior-citizens.update', $seniorCitizen) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Registration Details --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EEF4FB] text-[#397CB5]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Registration Details</h3>
                            <p class="text-xs text-[#6D817A]">Update senior citizen registry information.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">

                        <div>
                            <label for="registration_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Registration Date
                            </label>

                            <input
                                type="date"
                                id="registration_date"
                                name="registration_date"
                                value="{{ old('registration_date', $seniorCitizen->registration_date?->format('Y-m-d')) }}"
                                class="clay-input"
                            >

                            @error('registration_date')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- FIX: Required senior_status field --}}
                        <div>
                            <label for="senior_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Senior Status <span class="text-red-600">*</span>
                            </label>

                            <select
                                id="senior_status"
                                name="senior_status"
                                required
                                class="clay-input cursor-pointer"
                            >
                                <option value="">Select senior status</option>

                                @foreach (['Active', 'Inactive', 'Deceased', 'Transferred'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        @selected(old('senior_status', $seniorCitizen->senior_status) === $status)
                                    >
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            @error('senior_status')
                                <p class="mt-2 text-xs font-semibold text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="osca_id" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                OSCA ID
                            </label>

                            <input
                                type="text"
                                id="osca_id"
                                name="osca_id"
                                value="{{ old('osca_id', $seniorCitizen->osca_id) }}"
                                class="clay-input"
                                placeholder="Enter OSCA ID"
                            >
                        </div>

                        <div>
                            <label for="beneficiary_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Beneficiary Status
                            </label>

                            <select id="beneficiary_status" name="beneficiary_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                <option value="Beneficiary" @selected(old('beneficiary_status', $seniorCitizen->beneficiary_status) === 'Beneficiary')>
                                    Beneficiary
                                </option>
                                <option value="Non-Beneficiary" @selected(old('beneficiary_status', $seniorCitizen->beneficiary_status) === 'Non-Beneficiary')>
                                    Non-Beneficiary
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="living_arrangement" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Living Arrangement
                            </label>

                            <select id="living_arrangement" name="living_arrangement" class="clay-input cursor-pointer">
                                <option value="">Select arrangement</option>
                                <option value="Living Alone" @selected(old('living_arrangement', $seniorCitizen->living_arrangement) === 'Living Alone')>
                                    Living Alone
                                </option>
                                <option value="With Spouse" @selected(old('living_arrangement', $seniorCitizen->living_arrangement) === 'With Spouse')>
                                    With Spouse
                                </option>
                                <option value="With Family" @selected(old('living_arrangement', $seniorCitizen->living_arrangement) === 'With Family')>
                                    With Family
                                </option>
                                <option value="With Caregiver" @selected(old('living_arrangement', $seniorCitizen->living_arrangement) === 'With Caregiver')>
                                    With Caregiver
                                </option>
                            </select>
                        </div>

                    </div>
                </section>

                {{-- Pension Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EAF7EE] text-[#168B70]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Pension Information</h3>
                            <p class="text-xs text-[#6D817A]">Update status and source of pension.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="pension_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Pension Status
                            </label>

                            <select id="pension_status" name="pension_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                <option value="Receiving" @selected(old('pension_status', $seniorCitizen->pension_status) === 'Receiving')>
                                    Receiving
                                </option>
                                <option value="Not Receiving" @selected(old('pension_status', $seniorCitizen->pension_status) === 'Not Receiving')>
                                    Not Receiving
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="pension_type" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Pension Type
                            </label>

                            <input
                                type="text"
                                id="pension_type"
                                name="pension_type"
                                value="{{ old('pension_type', $seniorCitizen->pension_type) }}"
                                placeholder="e.g. SSS, GSIS, Social Pension"
                                class="clay-input"
                            >
                        </div>
                    </div>
                </section>

                {{-- Health and Assistance --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10.2A4.8 4.8 0 0 1 9.8 6c1.1 0 2.2.4 3.2 1.3C14 6.4 15.1 6 16.2 6A4.8 4.8 0 0 1 21 10.8C21 16.65 12 21 12 21Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Health and Assistance</h3>
                            <p class="text-xs text-[#6D817A]">Medical condition records and assistance needs.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="disability_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Disability Status
                            </label>

                            <select id="disability_status" name="disability_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                <option value="None" @selected(old('disability_status', $seniorCitizen->disability_status) === 'None')>
                                    None
                                </option>
                                <option value="With Disability" @selected(old('disability_status', $seniorCitizen->disability_status) === 'With Disability')>
                                    With Disability
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="medical_conditions" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Medical Conditions
                            </label>

                            <textarea
                                id="medical_conditions"
                                name="medical_conditions"
                                rows="3"
                                class="clay-input"
                                placeholder="Enter medical conditions..."
                            >{{ old('medical_conditions', $seniorCitizen->medical_conditions) }}</textarea>
                        </div>

                        <div>
                            <label for="medications" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Medications
                            </label>

                            <textarea
                                id="medications"
                                name="medications"
                                rows="3"
                                class="clay-input"
                                placeholder="Enter maintenance medications..."
                            >{{ old('medications', $seniorCitizen->medications) }}</textarea>
                        </div>

                        <div>
                            <label for="remarks" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Remarks
                            </label>

                            <textarea
                                id="remarks"
                                name="remarks"
                                rows="3"
                                class="clay-input"
                                placeholder="Additional remarks or notes..."
                            >{{ old('remarks', $seniorCitizen->remarks) }}</textarea>
                        </div>
                    </div>
                </section>

                {{-- Form Actions --}}
                <div class="clay-card flex flex-col items-stretch justify-between gap-4 p-5 sm:flex-row sm:items-center">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon clay-icon-green h-9 w-9 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.6 2.6 17a2 2 0 0 0 1.73 3h15.34a2 2 0 0 0 1.73-3L13.7 3.6a2 2 0 0 0-3.4 0Z" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-[#164238]">Review changes</p>
                            <p class="text-[11px] text-[#6D817A]">
                                Make sure updated details are accurate before saving.
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center">
                        <a
                            href="{{ route('senior-citizens.show', $seniorCitizen) }}"
                            class="clay-secondary inline-flex min-h-[44px] items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                            Update Senior Citizen
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    {{-- Mobile Sidebar Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (menuButton && overlay && sidebar) {
                const openSidebar = () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                    menuButton.setAttribute('aria-expanded', 'true');
                };

                const closeSidebar = () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                    menuButton.setAttribute('aria-expanded', 'false');
                };

                menuButton.addEventListener('click', () => {
                    const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
                    isOpen ? closeSidebar() : openSidebar();
                });

                overlay.addEventListener('click', closeSidebar);

                window.addEventListener('resize', () => {
                    if (window.innerWidth >= 1024) {
                        closeSidebar();
                    }
                });
            }
        });
    </script>
</body>

</html>