<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Maternal Care Record | Barangay Esperanza Health Center</title>

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

        .clay-count {
            background: linear-gradient(145deg, #E8F6EF, #DDEEE6);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.74);
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.08), -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

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

        .clay-delete-btn {
            background: linear-gradient(145deg, #FCEFED, #F5E2E0);
            color: var(--danger) !important;
            border: 1px solid rgba(180, 35, 35, 0.14);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.10), -4px -4px 9px rgba(255, 255, 255, 0.84);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-delete-btn:hover { transform: translateY(-1px); filter: brightness(0.98); }

        .clay-danger {
            background: linear-gradient(145deg, #FCF1DF, #FCEFED);
            border: 1px solid rgba(180, 35, 35, 0.14);
            color: var(--danger);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
        }

        /* ---------- Modal ---------- */
        .clay-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 1rem;
            background: rgba(22, 66, 56, 0.34);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }
        .clay-confirm-overlay.is-open { display: flex; }

        .clay-confirm-box {
            width: min(100%, 420px);
            border-radius: 24px;
            padding: 1.5rem;
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 14px 14px 30px rgba(57, 85, 75, 0.24), -12px -12px 28px rgba(255, 255, 255, 0.94);
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
                                {{ auth()->user()->role ?? 'User' }}
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
                        Edit Maternal Care Record
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Update the maternal and pregnancy information for this resident.
                    </p>
                </div>

                <a
                    href="{{ route('maternal-care.show', $maternalCare) }}"
                    class="clay-secondary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Record
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
            <form method="POST" action="{{ route('maternal-care.update', $maternalCare) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Pregnancy Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h8M12 8v8" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Pregnancy Information</h3>
                            <p class="text-xs text-[#6D817A]">Basic pregnancy and resident information.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        {{-- Resident --}}
                        <div class="sm:col-span-2">
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Resident
                            </label>
                            <div class="clay-input">
                                {{ $maternalCare->resident?->full_name }} — Resident #{{ $maternalCare->resident_id }}
                            </div>
                            <input type="hidden" name="resident_id" value="{{ $maternalCare->resident_id }}">

                            @error('resident_id')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pregnancy Number --}}
                        <div>
                            <label class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Pregnancy Number
                            </label>

                            <div class="clay-inset flex min-h-[46px] items-center gap-3 rounded-xl p-3">
                                <div class="clay-icon clay-icon-green h-8 w-8 rounded-lg text-xs font-bold">
                                    #{{ $maternalCare->pregnancy_number }}
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-[#164238]">Pregnancy #{{ $maternalCare->pregnancy_number }}</p>
                                    <p class="text-[11px] text-[#6D817A]">Automatically assigned and cannot be changed.</p>
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
                                @foreach (['Pregnant', 'Delivered', 'Miscarriage', 'Stillbirth', 'Completed'] as $status)
                                    <option value="{{ $status }}" @selected(old('pregnancy_status', $maternalCare->pregnancy_status) === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            @error('pregnancy_status')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
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
                                value="{{ old('last_menstrual_period', optional($maternalCare->last_menstrual_period)->format('Y-m-d')) }}"
                                class="clay-input"
                            >

                            @error('last_menstrual_period')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
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
                                value="{{ old('expected_delivery_date', optional($maternalCare->expected_delivery_date)->format('Y-m-d')) }}"
                                class="clay-input"
                            >

                            @error('expected_delivery_date')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Prenatal Care --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EEF4FB] text-[#397CB5]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 14c0 4-3 6-7 6s-7-2-7-6c0-3.5 2.5-5.5 7-5.5S19 10.5 19 14Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8V4m-2 0h4" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Prenatal Care</h3>
                            <p class="text-xs text-[#6D817A]">Track prenatal visits and follow-up care.</p>
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
                                value="{{ old('last_prenatal_visit', optional($maternalCare->last_prenatal_visit)->format('Y-m-d')) }}"
                                class="clay-input"
                            >

                            @error('last_prenatal_visit')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="prenatal_visit_count" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Number of Prenatal Visits
                            </label>

                            <input
                                type="number"
                                id="prenatal_visit_count"
                                name="prenatal_visit_count"
                                min="0"
                                value="{{ old('prenatal_visit_count', $maternalCare->prenatal_visit_count) }}"
                                placeholder="e.g. 4"
                                class="clay-input"
                            >

                            @error('prenatal_visit_count')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Delivery Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 7v5l3 2" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Delivery Information</h3>
                            <p class="text-xs text-[#6D817A]">Record delivery and birth outcome details.</p>
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
                                value="{{ old('actual_delivery_date', optional($maternalCare->actual_delivery_date)->format('Y-m-d')) }}"
                                class="clay-input"
                            >

                            @error('actual_delivery_date')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="delivery_type" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Delivery Type
                            </label>

                            <select id="delivery_type" name="delivery_type" class="clay-input cursor-pointer">
                                <option value="">Select delivery type</option>
                                @foreach (['Normal', 'Cesarean Section', 'Assisted'] as $type)
                                    <option value="{{ $type }}" @selected(old('delivery_type', $maternalCare->delivery_type) === $type)>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>

                            @error('delivery_type')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="place_of_delivery" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Place of Delivery
                            </label>

                            <input
                                type="text"
                                id="place_of_delivery"
                                name="place_of_delivery"
                                value="{{ old('place_of_delivery', $maternalCare->place_of_delivery) }}"
                                placeholder="e.g. Hospital, Health Center, Home"
                                class="clay-input"
                            >

                            @error('place_of_delivery')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="birth_outcome" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Birth Outcome
                            </label>

                            <select id="birth_outcome" name="birth_outcome" class="clay-input cursor-pointer">
                                <option value="">Select outcome</option>
                                @foreach (['Live Birth', 'Stillbirth', 'Miscarriage'] as $outcome)
                                    <option value="{{ $outcome }}" @selected(old('birth_outcome', $maternalCare->birth_outcome) === $outcome)>
                                        {{ $outcome }}
                                    </option>
                                @endforeach
                            </select>

                            @error('birth_outcome')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </section>

                {{-- Health & Risk Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCEFED] text-[#DC2626]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-7.18 12A2 2 0 0 0 4.82 19h14.36a2 2 0 0 0 1.71-3.14l-7.18-12a2 2 0 0 0-3.42 0Z" />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Health &amp; Risk Information</h3>
                            <p class="text-xs text-[#6D817A]">Record pregnancy risks, medical conditions, and medications.</p>
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
                                rows="4"
                                placeholder="Describe any known pregnancy risk factors..."
                                class="clay-input"
                            >{{ old('pregnancy_risk_factors', $maternalCare->pregnancy_risk_factors) }}</textarea>

                            @error('pregnancy_risk_factors')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="medical_conditions" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Medical Conditions
                            </label>

                            <textarea
                                id="medical_conditions"
                                name="medical_conditions"
                                rows="4"
                                placeholder="List relevant medical conditions..."
                                class="clay-input"
                            >{{ old('medical_conditions', $maternalCare->medical_conditions) }}</textarea>

                            @error('medical_conditions')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="medications" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Medications
                            </label>

                            <textarea
                                id="medications"
                                name="medications"
                                rows="4"
                                placeholder="List current medications..."
                                class="clay-input"
                            >{{ old('medications', $maternalCare->medications) }}</textarea>

                            @error('medications')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="remarks" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Remarks
                            </label>

                            <textarea
                                id="remarks"
                                name="remarks"
                                rows="4"
                                placeholder="Additional notes or remarks..."
                                class="clay-input"
                            >{{ old('remarks', $maternalCare->remarks) }}</textarea>

                            @error('remarks')
                                <p class="mt-2 text-xs text-[#DC2626]">{{ $message }}</p>
                            @enderror
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
                            href="{{ route('maternal-care.show', $maternalCare) }}"
                            class="clay-secondary inline-flex min-h-[44px] items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 12.5 9.5 17 19 7.5" />
                            </svg>
                            Update Record
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </main>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* Sidebar Toggle */
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
                    if (window.innerWidth >= 1024) closeSidebar();
                });
            }

        });
    </script>
</body>
</html>