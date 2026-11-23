<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Maternal Care Record | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Create a maternal care record for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           MATERNAL CARE MANAGEMENT
        ========================================================= */

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
            --warning: #8A6A28;

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

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; }

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

        ::selection { color: #FFFFFF; background: var(--primary-dark); }

        /* ---------- Header ---------- */
        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 0 5px 18px rgba(107, 134, 124, 0.08), 0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-mobile-button {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark);
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition: transform 0.18s ease, box-shadow 0.18s ease, color 0.18s ease;
        }
        .clay-mobile-button:hover { transform: translateY(-1px); color: var(--primary); }

        .clay-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88);
        }

        /* ---------- Heading ---------- */
        .clay-category { color: var(--primary); letter-spacing: 0.08em; }
        .clay-title { color: var(--text); }
        .clay-description { color: var(--text-muted); }
        .clay-heading-wrap { position: relative; }
        .clay-heading-accent {
            position: absolute;
            left: -16px;
            top: 4px;
            width: 4px;
            height: calc(100% - 8px);
            min-height: 62px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--primary-light), var(--primary-dark));
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.16), -1px -1px 3px rgba(255, 255, 255, 0.82);
        }

        /* ---------- Clay Surfaces ---------- */
        .clay-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow: 8px 8px 18px var(--shadow-dark), -8px -8px 18px var(--shadow-light), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            border-radius: 24px;
        }

        .clay-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: inset 3px 3px 7px rgba(107, 134, 124, 0.10), inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        .clay-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88), inset 1px 1px 0 rgba(255, 255, 255, 0.42);
        }
        .clay-icon-green { background: linear-gradient(145deg, #E7F5EE, #D9ECE4); color: var(--primary-dark); }

        /* ---------- Form Inputs ---------- */
        .clay-input {
            width: 100%;
            min-height: 46px;
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA) !important;
            color: var(--text) !important;
            border: 1px solid rgba(255, 255, 255, 0.92) !important;
            border-radius: var(--radius-md) !important;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            box-shadow: inset 3px 3px 7px rgba(107, 134, 124, 0.10), inset -3px -3px 7px rgba(255, 255, 255, 0.82) !important;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }
        .clay-input:focus {
            outline: none;
            border-color: rgba(22, 139, 112, 0.55) !important;
            box-shadow: inset 3px 3px 7px rgba(107, 134, 124, 0.08), inset -3px -3px 7px rgba(255, 255, 255, 0.86), 0 0 0 3px rgba(22, 139, 112, 0.12) !important;
        }

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, box-shadow 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.94);
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }
        .clay-secondary:hover { transform: translateY(-1px); background: linear-gradient(145deg, #FFFFFF, #EEF6F2); }

        .clay-danger {
            background: linear-gradient(145deg, #FCF1DF, #FCEFED);
            border: 1px solid rgba(180, 35, 35, 0.14);
            color: var(--danger);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
        }

        /* ---------- Accessibility ---------- */
        .clay-households a:focus-visible,
        .clay-households button:focus-visible,
        .clay-households input:focus-visible,
        .clay-households select:focus-visible,
        .clay-households textarea:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        @media (max-width: 1023px) {
            .clay-heading-accent { display: none; }
            main { padding-left: 0; }
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

        {{-- TOP HEADER --}}
        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Left --}}
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
                            Maternal Care
                        </h1>
                    </div>
                </div>

                {{-- Right --}}
                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="max-w-40 truncate text-sm font-bold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs font-medium text-[#6D817A]">
                                {{ auth()->user()->role ?? 'Health Worker' }}
                            </p>
                        </div>

                        <div class="clay-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
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
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>


                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Add Maternal Care Record
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Create a new maternal care record for a female resident and document pregnancy, prenatal care, delivery, and health information.
                    </p>
                </div>

                <a
                    href="{{ route('maternal-care.index') }}"
                    class="clay-secondary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Maternal Care
                </a>
            </div>

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="clay-danger mb-6 rounded-2xl p-4 sm:p-5" role="alert" aria-live="assertive">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-white text-[#B42323]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.6 2.6 17a2 2 0 0 0 1.73 3h15.34a2 2 0 0 0 1.73-3L13.7 3.6a2 2 0 0 0-3.4 0Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-bold text-[#B42323]">Please correct the following errors</h3>
                            <ul class="mt-2 list-inside list-disc text-xs leading-5 text-[#B42323]">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- FORM --}}
            <form method="POST" action="{{ route('maternal-care.store') }}" class="space-y-6">
                @csrf

                {{-- Resident Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Resident Information</h3>
                            <p class="text-xs text-[#6D817A]">Select the resident associated with this maternal care record.</p>
                        </div>
                    </div>

                    <div>
                        @php
                            $selectedResident = $residents->firstWhere('id', old('resident_id'));
                            $residentSearchValue = old(
                                'resident_search',
                                $selectedResident
                                    ? "{$selectedResident->full_name} — Resident #{$selectedResident->id}"
                                    : ''
                            );
                        @endphp

                        <label for="resident_search" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                            Search or select resident <span class="text-[#DC2626]">*</span>
                        </label>

                        <input
                            id="resident_search"
                            type="text"
                            list="resident_options"
                            value="{{ $residentSearchValue }}"
                            required
                            autocomplete="off"
                            placeholder="Type a resident name"
                            class="clay-input"
                            data-resident-search
                        >
                        <input type="hidden" id="resident_id" name="resident_id" value="{{ old('resident_id') }}">
                        <datalist id="resident_options">
                            @foreach ($residents as $resident)
                                <option value="{{ $resident->full_name }} — Resident #{{ $resident->id }}" data-resident-id="{{ $resident->id }}"></option>
                            @endforeach
                        </datalist>

                        <p class="mt-2 text-xs text-[#6D817A]">
                            Maternal care records are intended for female residents. Verify the selected resident before saving.
                        </p>
                    </div>
                </section>

                {{-- Pregnancy Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCEFED] text-[#E87928]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-9.5-9.1C.8 7.9 3.1 4.5 6.7 4.5c2.1 0 4.1 1.2 5.3 3 1.2-1.8 3.2-3 5.3-3 3.6 0 5.9 3.4 4.2 7.4C19 16.65 12 21 12 21Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Pregnancy Information</h3>
                            <p class="text-xs text-[#6D817A]">Record pregnancy status and important pregnancy dates.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        {{-- Automatic Pregnancy Number --}}
                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Pregnancy Number
                            </label>
                            <div class="clay-inset flex min-h-[46px] items-center gap-3 rounded-xl p-3">
                                <div class="clay-icon clay-icon-green h-8 w-8 rounded-lg">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-3-3v6m8.25-3A8.25 8.25 0 1 1 3.75 12a8.25 8.25 0 0 1 16.5 0Z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-[#164238]">Automatically assigned</p>
                                    <p class="text-[11px] text-[#6D817A]">The system will assign the next pregnancy number after saving.</p>
                                </div>
                            </div>
                        </div>

                        {{-- Pregnancy Status --}}
                        <div>
                            <label for="pregnancy_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Pregnancy Status <span class="text-[#DC2626]">*</span>
                            </label>
                            <select id="pregnancy_status" name="pregnancy_status" required class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                <option value="Pregnant" @selected(old('pregnancy_status') === 'Pregnant')>Pregnant</option>
                                <option value="Delivered" @selected(old('pregnancy_status') === 'Delivered')>Delivered</option>
                                <option value="Miscarriage" @selected(old('pregnancy_status') === 'Miscarriage')>Miscarriage</option>
                                <option value="Stillbirth" @selected(old('pregnancy_status') === 'Stillbirth')>Stillbirth</option>
                                <option value="Completed" @selected(old('pregnancy_status') === 'Completed')>Completed</option>
                            </select>
                        </div>

                        {{-- LMP --}}
                        <div>
                            <label for="last_menstrual_period" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Last Menstrual Period
                            </label>
                            <input
                                type="date"
                                id="last_menstrual_period"
                                name="last_menstrual_period"
                                value="{{ old('last_menstrual_period') }}"
                                max="{{ now()->format('Y-m-d') }}"
                                class="clay-input"
                            >
                            <p class="mt-2 text-xs text-[#6D817A]">Enter the first day of the last menstrual period, if known.</p>
                        </div>

                        {{-- EDD --}}
                        <div>
                            <label for="expected_delivery_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Expected Delivery Date
                            </label>
                            <input
                                type="date"
                                id="expected_delivery_date"
                                name="expected_delivery_date"
                                value="{{ old('expected_delivery_date') }}"
                                class="clay-input"
                            >
                            <p class="mt-2 text-xs text-[#6D817A]">Enter the estimated date of delivery, if available.</p>
                        </div>
                    </div>
                </section>

                {{-- Prenatal Care --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EEF4FB] text-[#397CB5]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25h-15m12 4.5h-9m9-9h-9m12 12.75h-15" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Prenatal Care</h3>
                            <p class="text-xs text-[#6D817A]">Document prenatal visit dates and visit frequency.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="last_prenatal_visit" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Last Prenatal Visit
                            </label>
                            <input
                                type="date"
                                id="last_prenatal_visit"
                                name="last_prenatal_visit"
                                value="{{ old('last_prenatal_visit') }}"
                                max="{{ now()->format('Y-m-d') }}"
                                class="clay-input"
                            >
                        </div>

                        <div>
                            <label for="prenatal_visit_count" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Prenatal Visit Count
                            </label>
                            <input
                                type="number"
                                id="prenatal_visit_count"
                                name="prenatal_visit_count"
                                value="{{ old('prenatal_visit_count', 0) }}"
                                min="0"
                                class="clay-input"
                            >
                            <p class="mt-2 text-xs text-[#6D817A]">Enter the total number of recorded prenatal visits.</p>
                        </div>
                    </div>
                </section>

                {{-- Delivery Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Delivery Information</h3>
                            <p class="text-xs text-[#6D817A]">Complete these details when delivery information becomes available.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="actual_delivery_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Actual Delivery Date
                            </label>
                            <input
                                type="date"
                                id="actual_delivery_date"
                                name="actual_delivery_date"
                                value="{{ old('actual_delivery_date') }}"
                                class="clay-input"
                            >
                        </div>

                        <div>
                            <label for="delivery_type" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Delivery Type
                            </label>
                            <select id="delivery_type" name="delivery_type" class="clay-input cursor-pointer">
                                <option value="">Select delivery type</option>
                                <option value="Normal" @selected(old('delivery_type') === 'Normal')>Normal</option>
                                <option value="Cesarean Section" @selected(old('delivery_type') === 'Cesarean Section')>Cesarean Section</option>
                                <option value="Assisted" @selected(old('delivery_type') === 'Assisted')>Assisted</option>
                            </select>
                        </div>

                        <div>
                            <label for="place_of_delivery" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Place of Delivery
                            </label>
                            <input
                                type="text"
                                id="place_of_delivery"
                                name="place_of_delivery"
                                value="{{ old('place_of_delivery') }}"
                                placeholder="e.g. Hospital, Birthing Center"
                                class="clay-input"
                            >
                        </div>

                        <div>
                            <label for="birth_outcome" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Birth Outcome
                            </label>
                            <select id="birth_outcome" name="birth_outcome" class="clay-input cursor-pointer">
                                <option value="">Select outcome</option>
                                <option value="Live Birth" @selected(old('birth_outcome') === 'Live Birth')>Live Birth</option>
                                <option value="Stillbirth" @selected(old('birth_outcome') === 'Stillbirth')>Stillbirth</option>
                                <option value="Miscarriage" @selected(old('birth_outcome') === 'Miscarriage')>Miscarriage</option>
                            </select>
                        </div>
                    </div>
                </section>

                {{-- Health & Risk Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCEFED] text-[#DC2626]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 3.6 2.6 17a2 2 0 0 0 1.73 3h15.34a2 2 0 0 0 1.73-3L13.7 3.6a2 2 0 0 0-3.4 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Health &amp; Risk Information</h3>
                            <p class="text-xs text-[#6D817A]">Document relevant medical conditions, risk factors, medications, and additional notes.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="pregnancy_risk_factors" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Pregnancy Risk Factors
                            </label>
                            <textarea
                                id="pregnancy_risk_factors"
                                name="pregnancy_risk_factors"
                                rows="3"
                                placeholder="Enter identified pregnancy risk factors..."
                                class="clay-input"
                            >{{ old('pregnancy_risk_factors') }}</textarea>
                        </div>

                        <div>
                            <label for="medical_conditions" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Medical Conditions
                            </label>
                            <textarea
                                id="medical_conditions"
                                name="medical_conditions"
                                rows="3"
                                placeholder="Enter relevant medical conditions..."
                                class="clay-input"
                            >{{ old('medical_conditions') }}</textarea>
                        </div>

                        <div>
                            <label for="medications" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Medications
                            </label>
                            <textarea
                                id="medications"
                                name="medications"
                                rows="3"
                                placeholder="Enter current medications..."
                                class="clay-input"
                            >{{ old('medications') }}</textarea>
                        </div>

                        <div>
                            <label for="remarks" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Remarks
                            </label>
                            <textarea
                                id="remarks"
                                name="remarks"
                                rows="3"
                                placeholder="Enter additional remarks..."
                                class="clay-input"
                            >{{ old('remarks') }}</textarea>
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
                            <p class="text-xs font-bold text-[#164238]">Review before saving</p>
                            <p class="text-[11px] text-[#6D817A]">Confirm the resident and pregnancy details. Required fields are marked with an asterisk.</p>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center">
                        <a
                            href="{{ route('maternal-care.index') }}"
                            class="clay-secondary inline-flex min-h-[44px] items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Save Maternal Care Record
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </main>

    {{-- MOBILE SIDEBAR SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const residentSearch = document.querySelector('[data-resident-search]');
            const residentId = document.getElementById('resident_id');
            const residentOptions = document.getElementById('resident_options');

            if (residentSearch && residentId && residentOptions) {
                const options = Array.from(residentOptions.options);
                const syncResidentId = () => {
                    const match = options.find((option) => option.value === residentSearch.value.trim());
                    residentId.value = match ? match.dataset.residentId : '';
                    residentSearch.setCustomValidity(
                        residentSearch.value.trim() && !match
                            ? 'Select a resident from the suggestions.'
                            : ''
                    );
                };

                residentSearch.addEventListener('input', syncResidentId);
                residentSearch.addEventListener('change', syncResidentId);
                syncResidentId();
            }

            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (!menuButton || !overlay || !sidebar) return;

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

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
                    closeSidebar();
                    menuButton.focus();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) closeSidebar();
            });
        });
    </script>
</body>
</html>