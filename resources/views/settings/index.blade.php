<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>System Settings | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage system settings for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           SYSTEM SETTINGS
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
        .clay-icon-orange { background: linear-gradient(145deg, #FCF7ED, #F9EBD9); color: var(--accent); }
        .clay-icon-danger { background: linear-gradient(145deg, #FCEFED, #F9E0DC); color: var(--danger); }

        /* ---------- Form Fields ---------- */
        .clay-input {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(210, 225, 218, 0.85);
            box-shadow: inset 2px 2px 5px rgba(107, 134, 124, 0.10), inset -2px -2px 5px rgba(255, 255, 255, 0.85);
            color: var(--text);
            transition: box-shadow 0.18s ease, border-color 0.18s ease;
        }
        .clay-input::placeholder { color: var(--text-soft); }
        .clay-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(42, 155, 128, 0.18), inset 2px 2px 5px rgba(107, 134, 124, 0.10);
        }
        .clay-input-error {
            border-color: rgba(180, 35, 35, 0.45);
        }

        .clay-label {
            display: block;
            margin-bottom: 0.45rem;
            font-size: 0.8rem;
            font-weight: 700;
            color: var(--text-secondary);
        }

        /* ---------- Table & Section Headers ---------- */
        .clay-table {
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 26px;
            box-shadow: 8px 8px 18px rgba(107, 134, 124, 0.18), -8px -8px 18px rgba(255, 255, 255, 0.92), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        /* ---------- Toggle ---------- */
        .clay-toggle-track {
            background: linear-gradient(145deg, #E4EFE9, #F1F7F4);
            box-shadow: inset 2px 2px 4px rgba(107, 134, 124, 0.14), inset -2px -2px 4px rgba(255, 255, 255, 0.85);
        }

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--text-secondary);
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition: transform 0.18s ease, color 0.18s ease;
        }
        .clay-secondary:hover { transform: translateY(-1px); color: var(--primary-dark); }

        /* ---------- Notices & Flash ---------- */
        .clay-notice {
            background: linear-gradient(145deg, #FCF7ED, #F9EBD9);
            border: 1px solid rgba(232, 121, 40, 0.18);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
            color: #7A4A1E;
        }

        .clay-flash-success {
            background: linear-gradient(145deg, #E8F6EF, #DDEEE6);
            border: 1px solid rgba(22, 139, 112, 0.18);
            color: var(--primary-dark);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
        }
        .clay-flash-error {
            background: linear-gradient(145deg, #FCEFED, #F9E0DC);
            border: 1px solid rgba(180, 35, 35, 0.16);
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

    @php
        $user = auth()->user();
        $generalErrors = $errors->getBag('default');
    @endphp

    {{-- Main Content --}}
    <main class="min-h-screen min-w-0 lg:pl-72">

        {{-- TOP HEADER --}}
        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

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
                        <p class="clay-category truncate text-xs font-bold uppercase tracking-wider">
                            System Administrator
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            System Settings
                        </h1>
                    </div>
                </div>

                {{-- Right --}}
                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')

                    <div class="hidden items-center gap-3 sm:flex">
                        <div class="hidden text-right md:block">
                            <p class="max-w-40 truncate text-sm font-bold text-[#164238]">
                                {{ $user->name ?? 'User' }}
                            </p>
                            <p class="text-xs font-medium text-[#6D817A]">
                                {{ $user->role ?? 'System Administrator' }}
                            </p>
                        </div>

                        <div class="clay-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="clay-heading-wrap mb-7 min-w-0 lg:ml-4">
                <span class="clay-heading-accent" aria-hidden="true"></span>

                <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Administration</p>

                <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                    System Settings
                </h2>

                <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                    Manage the health center information, system preferences, event notification settings, and your administrator account.
                </p>
            </div>

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div class="clay-flash-success mb-6 rounded-2xl px-4 py-3 text-sm" role="alert">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon clay-icon-green mt-0.5 h-7 w-7 shrink-0 rounded-lg">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Changes saved</p>
                            <p class="mt-0.5">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if ($generalErrors->any())
                <div class="clay-flash-error mb-6 rounded-2xl px-4 py-3 text-sm" role="alert">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon clay-icon-danger mt-0.5 h-7 w-7 shrink-0 rounded-lg">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                                <circle cx="12" cy="12" r="9" />
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold">Please correct the following errors:</p>
                            <ul class="mt-2 list-inside list-disc space-y-1">
                                @foreach ($generalErrors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid items-start gap-6 xl:grid-cols-3">

                {{-- ===================================================
                     LEFT: SYSTEM SETTINGS FORM
                ==================================================== --}}
                <form
                    method="POST"
                    action="{{ route('settings.update') }}"
                    class="min-w-0 space-y-6 xl:col-span-2"
                >
                    @csrf
                    @method('PUT')

                    {{-- HEALTH CENTER INFORMATION --}}
                    <section class="clay-table">
                        <div class="border-b border-white/70 px-5 py-5 sm:px-6">
                            <div class="flex items-start gap-4">
                                <div class="clay-icon clay-icon-green h-11 w-11 rounded-xl">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V8.5L12 4l7 4.5V21M9 21v-6h6v6M8 10h.01M12 10h.01M16 10h.01" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">Health Center Information</h3>
                                    <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                                        Basic information displayed and referenced throughout the Barangay Esperanza Health Center system.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">

                            <div class="sm:col-span-2">
                                <label for="health_center_name" class="clay-label">
                                    Health Center Name <span class="text-[#B42323]">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="health_center_name"
                                    name="health_center_name"
                                    value="{{ old('health_center_name', $settings['health_center_name'] ?? '') }}"
                                    maxlength="255"
                                    required
                                    placeholder="Barangay Esperanza Health Center"
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('health_center_name') clay-input-error @enderror"
                                >
                                @error('health_center_name')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="barangay" class="clay-label">
                                    Barangay <span class="text-[#B42323]">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="barangay"
                                    name="barangay"
                                    value="{{ old('barangay', $settings['barangay'] ?? '') }}"
                                    maxlength="100"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('barangay') clay-input-error @enderror"
                                >
                                @error('barangay')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="municipality" class="clay-label">
                                    Municipality <span class="text-[#B42323]">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="municipality"
                                    name="municipality"
                                    value="{{ old('municipality', $settings['municipality'] ?? '') }}"
                                    maxlength="100"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('municipality') clay-input-error @enderror"
                                >
                                @error('municipality')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="province" class="clay-label">
                                    Province <span class="text-[#B42323]">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="province"
                                    name="province"
                                    value="{{ old('province', $settings['province'] ?? '') }}"
                                    maxlength="100"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('province') clay-input-error @enderror"
                                >
                                @error('province')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_number" class="clay-label">Contact Number</label>
                                <input
                                    type="text"
                                    id="contact_number"
                                    name="contact_number"
                                    value="{{ old('contact_number', $settings['contact_number'] ?? '') }}"
                                    maxlength="50"
                                    placeholder="e.g. 09XXXXXXXXX"
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('contact_number') clay-input-error @enderror"
                                >
                                @error('contact_number')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="health_center_address" class="clay-label">
                                    Health Center Address <span class="text-[#B42323]">*</span>
                                </label>
                                <textarea
                                    id="health_center_address"
                                    name="health_center_address"
                                    rows="3"
                                    maxlength="500"
                                    required
                                    class="clay-input w-full resize-y rounded-xl px-4 py-3 text-sm @error('health_center_address') clay-input-error @enderror"
                                >{{ old('health_center_address', $settings['health_center_address'] ?? '') }}</textarea>
                                @error('health_center_address')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="email" class="clay-label">Email Address</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $settings['email'] ?? '') }}"
                                    maxlength="255"
                                    placeholder="healthcenter@example.com"
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('email') clay-input-error @enderror"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </section>

                    {{-- SYSTEM PREFERENCES --}}
                    <section class="clay-table">
                        <div class="border-b border-white/70 px-5 py-5 sm:px-6">
                            <div class="flex items-start gap-4">
                                <div class="clay-icon clay-icon-green h-11 w-11 rounded-xl">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.5 6h9M4.5 6h1.5M13.5 12h6M4.5 12h6M8.5 18h10M4.5 18h1.5M8 4v4M11 10v4M7 16v4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">System Preferences</h3>
                                    <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                                        Configure regional formatting and general system behavior.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="grid gap-5 px-5 py-6 sm:grid-cols-2 sm:px-6">

                            <div>
                                <label for="timezone" class="clay-label">
                                    Timezone <span class="text-[#B42323]">*</span>
                                </label>
                                <select
                                    id="timezone"
                                    name="timezone"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('timezone') clay-input-error @enderror"
                                >
                                    @php
                                        $selectedTimezone = old('timezone', $settings['timezone'] ?? 'Asia/Manila');
                                    @endphp

                                    @foreach ([
                                        'Asia/Manila' => 'Asia/Manila (Philippines)',
                                        'Asia/Singapore' => 'Asia/Singapore',
                                        'Asia/Tokyo' => 'Asia/Tokyo',
                                        'Asia/Seoul' => 'Asia/Seoul',
                                        'Asia/Hong_Kong' => 'Asia/Hong Kong',
                                        'UTC' => 'UTC',
                                    ] as $timezoneValue => $timezoneLabel)
                                        <option value="{{ $timezoneValue }}" @selected($selectedTimezone === $timezoneValue)>
                                            {{ $timezoneLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('timezone')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="locale" class="clay-label">
                                    Locale <span class="text-[#B42323]">*</span>
                                </label>
                                <select
                                    id="locale"
                                    name="locale"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('locale') clay-input-error @enderror"
                                >
                                    @php
                                        $selectedLocale = old('locale', $settings['locale'] ?? 'en');
                                    @endphp

                                    <option value="en" @selected($selectedLocale === 'en')>English</option>
                                    <option value="fil" @selected($selectedLocale === 'fil')>Filipino</option>
                                </select>
                                @error('locale')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_format" class="clay-label">
                                    Date Format <span class="text-[#B42323]">*</span>
                                </label>
                                <select
                                    id="date_format"
                                    name="date_format"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('date_format') clay-input-error @enderror"
                                >
                                    @php
                                        $selectedDateFormat = old('date_format', $settings['date_format'] ?? 'F d, Y');
                                    @endphp

                                    @foreach ([
                                        'F d, Y' => 'October 06, 2026',
                                        'M d, Y' => 'Oct 06, 2026',
                                        'Y-m-d' => '2026-10-06',
                                        'm/d/Y' => '10/06/2026',
                                        'd/m/Y' => '06/10/2026',
                                    ] as $formatValue => $formatLabel)
                                        <option value="{{ $formatValue }}" @selected($selectedDateFormat === $formatValue)>
                                            {{ $formatLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('date_format')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="records_per_page" class="clay-label">
                                    Records Per Page <span class="text-[#B42323]">*</span>
                                </label>
                                <select
                                    id="records_per_page"
                                    name="records_per_page"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('records_per_page') clay-input-error @enderror"
                                >
                                    @php
                                        $selectedRecordsPerPage = (string) old('records_per_page', $settings['records_per_page'] ?? 20);
                                    @endphp

                                    @foreach ([10, 20, 30, 50, 100] as $records)
                                        <option value="{{ $records }}" @selected($selectedRecordsPerPage === (string) $records)>
                                            {{ $records }} records
                                        </option>
                                    @endforeach
                                </select>
                                @error('records_per_page')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </section>

                    {{-- NOTIFICATION SETTINGS --}}
                    <section class="clay-table">
                        <div class="border-b border-white/70 px-5 py-5 sm:px-6">
                            <div class="flex items-start gap-4">
                                <div class="clay-icon clay-icon-orange h-11 w-11 rounded-xl">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M14.857 17.082a23.848 23.848 0 0 1-5.714 0M18.75 10.5c0 3.75 1.5 3.75 1.5 5.25H3.75c0-1.5 1.5-1.5 1.5-5.25a6.75 6.75 0 1 1 13.5 0ZM9.75 20.25h4.5" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">Notification Settings</h3>
                                    <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                                        Control automated reminders for health center schedule events.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 px-5 py-6 sm:px-6">

                            {{-- Toggle --}}
                            <div class="clay-inset flex flex-col gap-4 rounded-2xl p-4 sm:flex-row sm:items-center sm:justify-between">
                                <div class="pr-4">
                                    <p class="text-sm font-bold text-[#164238]">Enable Event Reminders</p>
                                    <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                                        Send automated notifications for upcoming health center events.
                                    </p>
                                </div>

                                <label class="relative inline-flex shrink-0 cursor-pointer items-center">
                                    <input
                                        type="checkbox"
                                        id="event_reminders_enabled"
                                        name="event_reminders_enabled"
                                        value="1"
                                        class="peer sr-only"
                                        @checked(old('event_reminders_enabled', $settings['event_reminders_enabled'] ?? true))
                                    >
                                    <div class="clay-toggle-track h-6 w-11 rounded-full transition peer-checked:bg-[#168B70] peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-[#2A9B80]/20 after:absolute after:left-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-white after:bg-white after:shadow-sm after:transition-all after:content-[''] peer-checked:after:translate-x-full"></div>
                                    <span class="sr-only">Enable Event Reminders</span>
                                </label>
                            </div>

                            {{-- Reminder days --}}
                            <div class="max-w-md">
                                <label for="event_reminder_days" class="clay-label">
                                    Reminder Days Before Event <span class="text-[#B42323]">*</span>
                                </label>

                                <div class="flex items-center gap-3">
                                    <input
                                        type="number"
                                        id="event_reminder_days"
                                        name="event_reminder_days"
                                        value="{{ old('event_reminder_days', $settings['event_reminder_days'] ?? 7) }}"
                                        min="1"
                                        max="30"
                                        required
                                        class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('event_reminder_days') clay-input-error @enderror"
                                    >
                                    <span class="shrink-0 text-sm font-bold text-[#6D817A]">days</span>
                                </div>

                                <p class="mt-2 text-xs leading-5 text-[#6D817A]">
                                    Choose between 1 and 30 days before an event.
                                </p>

                                @error('event_reminder_days')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </section>

                    {{-- SECURITY NOTICE --}}
                    <section class="clay-notice rounded-2xl p-4 sm:p-5">
                        <div class="flex items-start gap-3">
                            <div class="clay-icon clay-icon-orange h-9 w-9 shrink-0 rounded-xl">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v3.75m0 3h.008v.008H12V15.75ZM10.29 3.86 2.82 16.5a2 2 0 0 0 1.72 3h14.92a2 2 0 0 0 1.72-3L13.71 3.86a2 2 0 0 0-3.42 0Z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-[#7A4A1E]">Administrator-only settings</p>
                                <p class="mt-1 text-xs leading-5 text-[#8A5A2E]">
                                    These settings are restricted to System Administrators. Database credentials, application keys, and other sensitive environment configuration remain managed through the server environment and are not exposed here.
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- FORM ACTIONS --}}
                    <div class="flex flex-col-reverse gap-3 pt-2 sm:flex-row sm:items-center sm:justify-end">
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="clay-secondary inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-bold"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-primary inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-bold"
                        >
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                            Save Settings
                        </button>
                    </div>

                </form>

                {{-- ===================================================
                     RIGHT: MY ACCOUNT
                ==================================================== --}}
                <aside class="min-w-0 space-y-6 xl:sticky xl:top-28">

                    {{-- Profile --}}
                    <section class="clay-table">
                        <div class="border-b border-white/70 px-5 py-5">
                            <div class="flex items-center gap-4">
                                <div class="clay-avatar flex h-12 w-12 shrink-0 items-center justify-center rounded-xl text-base font-bold">
                                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <h3 class="truncate text-base font-bold text-[#164238]">My Account</h3>
                                    <p class="truncate text-xs text-[#6D817A]">{{ $user->email ?? '' }}</p>
                                </div>
                            </div>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('account.profile.update') }}"
                            class="space-y-5 px-5 py-6"
                        >
                            @csrf
                            @method('PUT')

                            <div class="flex items-center gap-2">
                                <div class="clay-icon clay-icon-green h-7 w-7 rounded-lg">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a8.25 8.25 0 0 1 15 0" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-[#164238]">Profile Information</p>
                            </div>

                            <div>
                                <label for="account_name" class="clay-label">Full Name <span class="text-[#B42323]">*</span></label>
                                <input
                                    type="text"
                                    id="account_name"
                                    name="name"
                                    value="{{ old('name', $user->name) }}"
                                    maxlength="255"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('name', 'updateProfile') clay-input-error @enderror"
                                >
                                @error('name', 'updateProfile')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_email" class="clay-label">Email Address <span class="text-[#B42323]">*</span></label>
                                <input
                                    type="email"
                                    id="account_email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    maxlength="255"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('email', 'updateProfile') clay-input-error @enderror"
                                >
                                @error('email', 'updateProfile')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <button
                                type="submit"
                                class="clay-primary inline-flex w-full items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                            >
                                Update Profile
                            </button>
                        </form>
                    </section>

                    {{-- Password --}}
                    <section class="clay-table">
                        <div class="border-b border-white/70 px-5 py-5">
                            <div class="flex items-center gap-2">
                                <div class="clay-icon clay-icon-orange h-7 w-7 rounded-lg">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16.5 10.5V7.5a4.5 4.5 0 1 0-9 0v3m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v7.5a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 4.5 19.5V12a1.5 1.5 0 0 1 1.5-1.5Z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-bold text-[#164238]">Change Password</p>
                            </div>
                            <p class="mt-2 text-xs leading-5 text-[#6D817A]">
                                Use at least 8 characters. You will stay signed in on this device after changing it.
                            </p>
                        </div>

                        <form
                            method="POST"
                            action="{{ route('account.password.update') }}"
                            class="space-y-5 px-5 py-6"
                        >
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="clay-label">Current Password <span class="text-[#B42323]">*</span></label>
                                <input
                                    type="password"
                                    id="current_password"
                                    name="current_password"
                                    autocomplete="current-password"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('current_password', 'updatePassword') clay-input-error @enderror"
                                >
                                @error('current_password', 'updatePassword')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password" class="clay-label">New Password <span class="text-[#B42323]">*</span></label>
                                <input
                                    type="password"
                                    id="new_password"
                                    name="password"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm @error('password', 'updatePassword') clay-input-error @enderror"
                                >
                                @error('password', 'updatePassword')
                                    <p class="mt-1.5 text-xs font-semibold text-[#B42323]">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="clay-label">Confirm New Password <span class="text-[#B42323]">*</span></label>
                                <input
                                    type="password"
                                    id="new_password_confirmation"
                                    name="password_confirmation"
                                    autocomplete="new-password"
                                    minlength="8"
                                    required
                                    class="clay-input w-full rounded-xl px-4 py-3 text-sm"
                                >
                            </div>

                            <button
                                type="submit"
                                class="clay-secondary inline-flex w-full items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                            >
                                Change Password
                            </button>
                        </form>
                    </section>

                </aside>

            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
        });
    </script>
</body>
</html>