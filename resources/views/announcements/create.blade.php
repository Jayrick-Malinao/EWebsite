<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Announcement | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Create and publish announcements for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           CREATE ANNOUNCEMENT
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
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-category text-xs font-bold uppercase tracking-wider">
                            Communication
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Announcements
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
                                System Administrator
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
                        Create Announcement
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Create a targeted health center announcement and notify the appropriate residents.
                    </p>
                </div>

                <a
                    href="{{ route('announcements.index') }}"
                    class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Announcements
                </a>
            </div>

            {{-- VALIDATION ERRORS --}}
            @if ($errors->any())
                <div class="clay-danger mb-6 rounded-2xl p-4 sm:p-5" role="alert">
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
            <form id="announcementForm" action="{{ route('announcements.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

                    {{-- LEFT COLUMN --}}
                    <div class="space-y-6 lg:col-span-2">

                        {{-- ANNOUNCEMENT DETAILS --}}
                        <section class="clay-card p-5 sm:p-6">
                            <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                                <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-5a2 2 0 00-2 2v9a2 2 0 002 2h5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">Announcement Details</h3>
                                    <p class="text-xs text-[#6D817A]">Write the announcement message to be delivered to residents.</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                {{-- Title --}}
                                <div>
                                    <label for="title" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                        Announcement Title <span class="text-[#DC2626]">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        name="title"
                                        id="title"
                                        value="{{ old('title') }}"
                                        maxlength="255"
                                        required
                                        placeholder="e.g. Free Medical Check-up for Senior Citizens"
                                        class="clay-input"
                                    >
                                    @error('title')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Message --}}
                                <div>
                                    <div class="mb-2 flex items-center justify-between">
                                        <label for="message" class="block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                            Message <span class="text-[#DC2626]">*</span>
                                        </label>
                                        <span id="messageCounter" class="text-[11px] font-bold text-[#6D817A]">
                                            0 / 5000
                                        </span>
                                    </div>

                                    <textarea
                                        name="message"
                                        id="message"
                                        rows="8"
                                        maxlength="5000"
                                        required
                                        placeholder="Write the complete announcement message here..."
                                        class="clay-input"
                                    >{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </section>

                        {{-- TARGET AUDIENCE --}}
                        <section class="clay-card p-5 sm:p-6">
                            <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                                <div class="clay-icon h-10 w-10 rounded-xl bg-[#E8F6EF] text-[#168B70]">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">Target Audience</h3>
                                    <p class="text-xs text-[#6D817A]">Choose which residents should receive this announcement.</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                {{-- Target Type --}}
                                <div>
                                    <label for="target_type" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                        Announcement Target <span class="text-[#DC2626]">*</span>
                                    </label>
                                    <select name="target_type" id="target_type" required class="clay-input cursor-pointer">
                                        <option value="">Select target audience</option>
                                        <option value="specific" {{ old('target_type') === 'specific' ? 'selected' : '' }}>Specific Resident</option>
                                        <option value="senior" {{ old('target_type') === 'senior' ? 'selected' : '' }}>Senior Citizens</option>
                                        <option value="children" {{ old('target_type') === 'children' ? 'selected' : '' }}>Children</option>
                                        <option value="pregnant" {{ old('target_type') === 'pregnant' ? 'selected' : '' }}>Pregnant Residents</option>
                                        <option value="general" {{ old('target_type') === 'general' ? 'selected' : '' }}>General / All Active Residents</option>
                                        <option value="age_bracket" {{ old('target_type') === 'age_bracket' ? 'selected' : '' }}>Custom Age Bracket</option>
                                    </select>
                                    @error('target_type')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Specific Resident --}}
                                <div id="specificResidentSection" class="hidden">
                                    <label for="resident_id" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                        Select Resident <span class="text-[#DC2626]">*</span>
                                    </label>
                                    <select name="resident_id" id="resident_id" class="clay-input cursor-pointer">
                                        <option value="">Select a resident</option>
                                        @foreach ($residents as $resident)
                                            <option value="{{ $resident->id }}" {{ (string) old('resident_id') === (string) $resident->id ? 'selected' : '' }}>
                                                {{ $resident->full_name }}
                                                @if ($resident->household)
                                                    — {{ $resident->household->household_code }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-1.5 text-[11px] text-[#6D817A]">Only active residents are listed.</p>
                                    @error('resident_id')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Age Bracket --}}
                                <div id="ageBracketSection" class="hidden">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label for="min_age" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                                Minimum Age <span class="text-[#DC2626]">*</span>
                                            </label>
                                            <input
                                                type="number"
                                                name="min_age"
                                                id="min_age"
                                                value="{{ old('min_age') }}"
                                                min="0"
                                                max="120"
                                                placeholder="e.g. 18"
                                                class="clay-input"
                                            >
                                            @error('min_age')
                                                <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="max_age" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                                Maximum Age <span class="text-[#DC2626]">*</span>
                                            </label>
                                            <input
                                                type="number"
                                                name="max_age"
                                                id="max_age"
                                                value="{{ old('max_age') }}"
                                                min="0"
                                                max="120"
                                                placeholder="e.g. 59"
                                                class="clay-input"
                                            >
                                            @error('max_age')
                                                <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Children Age Range --}}
                                <div id="childrenAgeSection" class="hidden space-y-4">
                                    <div class="clay-inset rounded-2xl p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="clay-icon h-8 w-8 rounded-lg bg-[#E8F6EF] text-[#168B70]">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-[#164238]">Children Target Range</p>
                                                <p class="mt-0.5 text-[11px] text-[#6D817A]">Default target is 0 to 5 years old. Adjust bounds if required.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label for="children_min_age" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">Minimum Age</label>
                                            <input type="number" id="children_min_age" min="0" max="120" value="{{ old('min_age', 0) }}" class="clay-input">
                                        </div>

                                        <div>
                                            <label for="children_max_age" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">Maximum Age</label>
                                            <input type="number" id="children_max_age" min="0" max="120" value="{{ old('max_age', 5) }}" class="clay-input">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

                    </div>

                    {{-- RIGHT COLUMN --}}
                    <div class="space-y-6">

                        {{-- PRIORITY LEVEL --}}
                        <section class="clay-card p-5 sm:p-6">
                            <div class="mb-4 border-b border-white/70 pb-3">
                                <h3 class="text-base font-bold text-[#164238]">Priority Level</h3>
                                <p class="text-xs text-[#6D817A]">Set the urgency classification of this announcement.</p>
                            </div>

                            <div>
                                <label for="priority" class="mb-2 block text-xs font-bold uppercase tracking-wider text-[#385C52]">
                                    Priority <span class="text-[#DC2626]">*</span>
                                </label>
                                <select name="priority" id="priority" required class="clay-input cursor-pointer">
                                    <option value="Normal" {{ old('priority', 'Normal') === 'Normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="Important" {{ old('priority') === 'Important' ? 'selected' : '' }}>Important</option>
                                    <option value="Urgent" {{ old('priority') === 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                                @error('priority')
                                    <p class="mt-1.5 text-xs text-[#DC2626]">{{ $message }}</p>
                                @enderror

                                {{-- Explanations --}}
                                <div class="mt-4 space-y-2.5">
                                    <div class="flex items-start gap-2.5">
                                        <span class="mt-1 h-2 w-2 rounded-full bg-[#9AA9A4] shrink-0"></span>
                                        <p class="text-xs text-[#6D817A]"><strong class="text-[#164238]">Normal:</strong> General health center notices.</p>
                                    </div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="mt-1 h-2 w-2 rounded-full bg-[#E87928] shrink-0"></span>
                                        <p class="text-xs text-[#6D817A]"><strong class="text-[#164238]">Important:</strong> Notices requiring resident attention.</p>
                                    </div>
                                    <div class="flex items-start gap-2.5">
                                        <span class="mt-1 h-2 w-2 rounded-full bg-[#DC2626] shrink-0"></span>
                                        <p class="text-xs text-[#6D817A]"><strong class="text-[#164238]">Urgent:</strong> Time-sensitive community health advisories.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- DELIVERY CHANNELS --}}
                        <section class="clay-card p-5 sm:p-6">
                            <div class="mb-4 border-b border-white/70 pb-3">
                                <h3 class="text-base font-bold text-[#164238]">Delivery Channels</h3>
                                <p class="text-xs text-[#6D817A]">How this announcement reaches targeted residents.</p>
                            </div>

                            <div class="space-y-3">
                                <div class="clay-inset flex items-start gap-3 rounded-xl p-3.5">
                                    <div class="clay-icon clay-icon-green h-8 w-8 rounded-lg">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-[#164238]">In-System Notification</p>
                                        <p class="mt-0.5 text-[11px] text-[#6D817A]">Associated directly with selected resident accounts.</p>
                                    </div>
                                </div>

                                <div class="clay-inset flex items-start gap-3 rounded-xl p-3.5">
                                    <div class="clay-icon h-8 w-8 rounded-lg bg-[#E8F6EF] text-[#168B70]">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-[#164238]">SMS Delivery</p>
                                        <p class="mt-0.5 text-[11px] text-[#6D817A]">Dispatched to registered household heads.</p>
                                    </div>
                                </div>
                            </div>
                        </section>

                        {{-- PUBLISH ACTIONS --}}
                        <section class="clay-card p-5 sm:p-6">
                            <div class="mb-4">
                                <h3 class="text-base font-bold text-[#164238]">Publish Announcement</h3>
                                <p class="mt-1 text-xs text-[#6D817A]">Selected recipients will be notified immediately upon publishing.</p>
                            </div>

                            <div class="space-y-3">
                                <button
                                    type="submit"
                                    id="publishButton"
                                    class="clay-primary inline-flex min-h-[46px] w-full items-center justify-center gap-2 rounded-xl text-sm font-bold"
                                >
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 12L3 21l18-9L3 3l3 9zm0 0h7.5" />
                                    </svg>
                                    Publish Announcement
                                </button>

                                <a
                                    href="{{ route('announcements.index') }}"
                                    class="clay-secondary inline-flex min-h-[44px] w-full items-center justify-center rounded-xl text-sm font-bold"
                                >
                                    Cancel
                                </a>
                            </div>
                        </section>

                    </div>

                </div>
            </form>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (menuButton && overlay && sidebar) {
                menuButton.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            const targetType = document.getElementById('target_type');
            const specificSection = document.getElementById('specificResidentSection');
            const ageBracketSection = document.getElementById('ageBracketSection');
            const childrenAgeSection = document.getElementById('childrenAgeSection');
            const minAge = document.getElementById('min_age');
            const maxAge = document.getElementById('max_age');
            const childrenMinAge = document.getElementById('children_min_age');
            const childrenMaxAge = document.getElementById('children_max_age');

            const message = document.getElementById('message');
            const messageCounter = document.getElementById('messageCounter');

            function updateMessageCounter() {
                if (message && messageCounter) {
                    messageCounter.textContent = `${message.value.length} / 5000`;
                }
            }

            if (message) {
                updateMessageCounter();
                message.addEventListener('input', updateMessageCounter);
            }

            function updateTargetFields() {
                if (!targetType) return;
                const value = targetType.value;

                specificSection?.classList.add('hidden');
                ageBracketSection?.classList.add('hidden');
                childrenAgeSection?.classList.add('hidden');

                if (value === 'specific') specificSection?.classList.remove('hidden');
                if (value === 'age_bracket') ageBracketSection?.classList.remove('hidden');
                if (value === 'children') childrenAgeSection?.classList.remove('hidden');
            }

            targetType?.addEventListener('change', updateTargetFields);

            const form = document.getElementById('announcementForm');
            form?.addEventListener('submit', function () {
                if (targetType.value === 'children') {
                    if (minAge) minAge.value = childrenMinAge.value || 0;
                    if (maxAge) maxAge.value = childrenMaxAge.value || 5;
                }
            });

            updateTargetFields();
        });
    </script>
</body>
</html>