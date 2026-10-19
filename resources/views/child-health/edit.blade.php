<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Child Health Record | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Edit child health monitoring record for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           CHILD HEALTH MANAGEMENT
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
                            Child Health Program
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
                        Edit Child Health Record
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Update the growth measurements, nutritional status, preventive care, and health observations for this child.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('child-health.show', $childHealth) }}"
                        class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back to View Record
                    </a>
                </div>
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
            <form method="POST" action="{{ route('child-health.update', $childHealth) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Child Selection --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Child Selection</h3>
                            <p class="text-xs text-[#6D817A]">Resident associated with this child health record.</p>
                        </div>
                    </div>

                    <div>
                        <label for="resident_id" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                            Child / Resident <span class="text-[#DC2626]">*</span>
                        </label>

                        <select id="resident_id" name="resident_id" required class="clay-input cursor-pointer">
                            <option value="">Select Child</option>
                            @foreach ($residents as $resident)
                                <option value="{{ $resident->id }}" @selected(old('resident_id', $childHealth->resident_id) == $resident->id)>
                                    {{ $resident->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </section>

                {{-- Assessment & Growth --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EEF4FB] text-[#397CB5]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v18h18M6.75 12l4.5-4.5 4.5 4.5 4.5-4.5" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Assessment &amp; Growth</h3>
                            <p class="text-xs text-[#6D817A]">Update assessment date and physical growth measurements.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-3">
                        <div>
                            <label for="assessment_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Assessment Date <span class="text-[#DC2626]">*</span>
                            </label>
                            <input
                                type="date"
                                id="assessment_date"
                                name="assessment_date"
                                value="{{ old('assessment_date', optional($childHealth->assessment_date)->format('Y-m-d')) }}"
                                required
                                class="clay-input"
                            >
                        </div>

                        <div>
                            <label for="weight_kg" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Weight (kg)
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                id="weight_kg"
                                name="weight_kg"
                                value="{{ old('weight_kg', $childHealth->weight_kg) }}"
                                placeholder="e.g. 12.50"
                                class="clay-input"
                            >
                        </div>

                        <div>
                            <label for="height_cm" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Height (cm)
                            </label>
                            <input
                                type="number"
                                step="0.01"
                                id="height_cm"
                                name="height_cm"
                                value="{{ old('height_cm', $childHealth->height_cm) }}"
                                placeholder="e.g. 85.00"
                                class="clay-input"
                            >
                        </div>
                    </div>
                </section>

                {{-- Nutrition & Breastfeeding --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Nutrition &amp; Breastfeeding</h3>
                            <p class="text-xs text-[#6D817A]">Update nutritional condition and breastfeeding details.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nutritional_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Nutritional Status
                            </label>
                            <select id="nutritional_status" name="nutritional_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                @foreach (['Normal', 'Underweight', 'Wasted', 'Severely Wasted', 'Overweight', 'Obese'] as $status)
                                    <option value="{{ $status }}" @selected(old('nutritional_status', $childHealth->nutritional_status) === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="breastfeeding_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Breastfeeding Status
                            </label>
                            <select id="breastfeeding_status" name="breastfeeding_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                @foreach (['Exclusive Breastfeeding', 'Mixed Feeding', 'Formula Feeding', 'Not Breastfeeding', 'Not Applicable'] as $status)
                                    <option value="{{ $status }}" @selected(old('breastfeeding_status', $childHealth->breastfeeding_status) === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </section>

                {{-- Preventive Care --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EAF7EE] text-[#168B70]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Preventive Care</h3>
                            <p class="text-xs text-[#6D817A]">Update Vitamin A and deworming administration records.</p>
                        </div>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="vitamin_a_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Vitamin A Status
                            </label>
                            <select id="vitamin_a_status" name="vitamin_a_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                @foreach (['Given', 'Not Given', 'Not Due'] as $status)
                                    <option value="{{ $status }}" @selected(old('vitamin_a_status', $childHealth->vitamin_a_status) === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="vitamin_a_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Vitamin A Date
                            </label>
                            <input
                                type="date"
                                id="vitamin_a_date"
                                name="vitamin_a_date"
                                value="{{ old('vitamin_a_date', optional($childHealth->vitamin_a_date)->format('Y-m-d')) }}"
                                class="clay-input"
                            >
                        </div>

                        <div>
                            <label for="deworming_status" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Deworming Status
                            </label>
                            <select id="deworming_status" name="deworming_status" class="clay-input cursor-pointer">
                                <option value="">Select status</option>
                                @foreach (['Given', 'Not Given', 'Not Due'] as $status)
                                    <option value="{{ $status }}" @selected(old('deworming_status', $childHealth->deworming_status) === $status)>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="deworming_date" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Deworming Date
                            </label>
                            <input
                                type="date"
                                id="deworming_date"
                                name="deworming_date"
                                value="{{ old('deworming_date', optional($childHealth->deworming_date)->format('Y-m-d')) }}"
                                class="clay-input"
                            >
                        </div>
                    </div>
                </section>

                {{-- Observations & Assessments --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EDF2F7] text-[#4A5568]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Observations &amp; Assessment</h3>
                            <p class="text-xs text-[#6D817A]">Document developmental milestones, assessment findings, and remarks.</p>
                        </div>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <label for="developmental_milestones" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Developmental Milestones
                            </label>
                            <textarea
                                id="developmental_milestones"
                                name="developmental_milestones"
                                rows="3"
                                placeholder="Describe developmental milestones or observations..."
                                class="clay-input"
                            >{{ old('developmental_milestones', $childHealth->developmental_milestones) }}</textarea>
                        </div>

                        <div>
                            <label for="health_assessment" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Health Assessment
                            </label>
                            <textarea
                                id="health_assessment"
                                name="health_assessment"
                                rows="3"
                                placeholder="Enter health assessment details..."
                                class="clay-input"
                            >{{ old('health_assessment', $childHealth->health_assessment) }}</textarea>
                        </div>

                        <div>
                            <label for="remarks" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                Remarks
                            </label>
                            <textarea
                                id="remarks"
                                name="remarks"
                                rows="3"
                                placeholder="Enter additional notes or remarks..."
                                class="clay-input"
                            >{{ old('remarks', $childHealth->remarks) }}</textarea>
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
                            <p class="text-[11px] text-[#6D817A]">Verify updated child health details before submitting changes.</p>
                        </div>
                    </div>

                    <div class="flex flex-col-reverse gap-2 sm:flex-row sm:items-center">
                        <a
                            href="{{ route('child-health.show', $childHealth) }}"
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
                            Update Child Health Record
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </main>

    {{-- SCRIPTS --}}
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
                    if (window.innerWidth >= 1024) closeSidebar();
                });
            }
        });
    </script>
</body>
</html>