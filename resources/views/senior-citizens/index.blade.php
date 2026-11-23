<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Senior Citizens | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage senior citizen records for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           SENIOR CITIZEN MANAGEMENT
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

        /* ---------- Search Panel ---------- */
        .clay-search-panel {
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: var(--radius-xl);
            box-shadow: 8px 8px 18px rgba(107, 134, 124, 0.16), -8px -8px 18px rgba(255, 255, 255, 0.92), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-input {
            min-height: 46px;
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA) !important;
            color: var(--text) !important;
            border: 1px solid rgba(255, 255, 255, 0.92) !important;
            border-radius: var(--radius-md) !important;
            box-shadow: inset 3px 3px 7px rgba(107, 134, 124, 0.10), inset -3px -3px 7px rgba(255, 255, 255, 0.82) !important;
            transition: border-color 0.18s ease, box-shadow 0.18s ease;
        }

        /* ---------- Table & Actions ---------- */
        .clay-table {
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 26px;
            box-shadow: 8px 8px 18px rgba(107, 134, 124, 0.18), -8px -8px 18px rgba(255, 255, 255, 0.92), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }
        .clay-table-head { background: linear-gradient(180deg, rgba(235, 244, 239, 0.98), rgba(226, 238, 232, 0.96)); }
        .clay-table-row { background: rgba(255, 255, 255, 0.48); transition: background 0.18s ease; }
        .clay-table-row:hover { background: rgba(255, 255, 255, 0.78); }

        .clay-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            border-radius: 11px;
            padding: 0.42rem 0.78rem;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.82);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .clay-action:hover { transform: translateY(-1px); }

        .clay-view { background: linear-gradient(145deg, #F9FCFA, #EAF2EE); color: var(--primary-dark) !important; box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.12), -3px -3px 7px rgba(255, 255, 255, 0.90); }
        .clay-edit { background: linear-gradient(145deg, #EDF8F2, #DDEFE6); color: #216B53 !important; border-color: rgba(18, 140, 90, 0.13); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.11), -3px -3px 7px rgba(255, 255, 255, 0.88); }
        .clay-delete { background: linear-gradient(145deg, #FCEFED, #F5E2E0); color: var(--danger) !important; border-color: rgba(180, 35, 35, 0.14); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.84); }

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
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.94);
        }

        .clay-count {
            background: linear-gradient(145deg, #E8F6EF, #DDEEE6);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.74);
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.08), -2px -2px 5px rgba(255, 255, 255, 0.76);
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
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-category text-xs font-bold uppercase tracking-wider">
                            {{ auth()->user()->role ?? 'System Administrator' }}
                        </p>
                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Senior Citizen Program
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

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>
                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Senior Citizen Records</p>
                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Senior Citizens
                    </h2>
                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Manage and maintain senior citizen information registered with Barangay Esperanza Health Center.
                    </p>
                </div>

                <a
                    href="{{ route('senior-citizens.create') }}"
                    class="clay-primary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    Add Senior Citizen
                </a>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="clay-card mb-6 rounded-2xl border-l-4 border-l-[#168B70] p-4 text-sm text-[#0F6F5A]">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-8 w-8 rounded-xl">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </div>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- SEARCH PANEL --}}
            <section class="clay-search-panel mb-6 p-4 sm:p-5">
                <div class="relative z-10 mb-4 flex items-start gap-3">
                    <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-[#164238]">Find Senior Citizens</p>
                        <p class="mt-0.5 text-xs text-[#6D817A]">Search by senior citizen name, contact number, or ID.</p>
                    </div>
                </div>

                <form action="{{ route('senior-citizens.index') }}" method="GET" class="relative z-10 flex flex-col gap-3 lg:flex-row">
                    <div class="relative min-w-0 flex-1">
                        <svg class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-[#6D817A]" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" />
                        </svg>
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search', '') }}"
                            placeholder="Search by senior citizen name, contact number, or ID..."
                            class="clay-input w-full py-3 pl-11 pr-4 text-sm outline-none"
                        >
                    </div>

                    <button type="submit" class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold">
                        Search
                    </button>

                    @if (request('search', '') !== '')
                        <a href="{{ route('senior-citizens.index') }}" class="clay-secondary inline-flex min-h-[44px] items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold">
                            Clear
                        </a>
                    @endif
                </form>
            </section>

            {{-- DESKTOP TABLE --}}
            <section class="clay-table hidden lg:block">
                <div class="flex items-center justify-between border-b border-white/70 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Senior Citizen Directory</h3>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Registered senior citizens aged 60 years and above.</p>
                        </div>
                    </div>
                    <div class="clay-count inline-flex rounded-full px-3 py-1.5 text-xs font-bold">
                        {{ $seniorCitizens->total() }} Records
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px]">
                        <thead class="clay-table-head">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Senior Citizen</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Senior ID</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Age</th>
                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Purok</th>
                                <th scope="col" class="px-6 py-4"><span class="sr-only">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($seniorCitizens as $seniorCitizen)
                                @php $resident = $seniorCitizen->resident; @endphp
                                <tr class="clay-table-row border-b border-[#D2E1DA]/60 last:border-b-0">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl text-sm font-bold">
                                                {{ strtoupper(substr($resident?->first_name ?? 'S', 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-[#164238]">{{ $resident?->full_name ?? 'Resident unavailable' }}</p>
                                                <p class="text-xs text-[#9AA9A4]">{{ $resident?->email ?: 'No email' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="clay-inset inline-flex rounded-lg px-2.5 py-1 text-xs font-bold text-[#234E43]">
                                            {{ $seniorCitizen->senior_citizen_id ?: '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-bold text-[#234E43]">{{ $resident?->birth_date ? $resident->birth_date->age . ' yrs old' : '—' }}</p>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-[#6D817A]">
                                        {{ $resident->household ? \Illuminate\Support\Str::before($resident->household->address, ',') : '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative flex items-center justify-end">
                                            <button type="button" class="clay-action-menu-trigger flex h-10 w-10 items-center justify-center rounded-full text-[#6D817A] transition hover:text-[#164238]" aria-label="More actions for {{ $resident?->full_name ?? 'Senior Citizen' }}" aria-expanded="false" data-menu-trigger>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <circle cx="10" cy="5" r="1.5"/>
                                                    <circle cx="10" cy="10" r="1.5"/>
                                                    <circle cx="10" cy="15" r="1.5"/>
                                                </svg>
                                            </button>
                                            <div class="clay-action-menu absolute right-0 top-full z-20 mt-2 hidden min-w-[180px] rounded-2xl border border-white/80 bg-[#F5FAF7] p-2 shadow-[0_12px_35px_rgba(107,134,124,0.18)]" data-menu-panel>
                                                <a href="{{ route('senior-citizens.show', $seniorCitizen) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]" title="View senior citizen record">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    View
                                                </a>
                                                <a href="{{ route('senior-citizens.edit', $seniorCitizen) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]" title="Edit senior citizen record">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/></svg>
                                                    Edit
                                                </a>
                                                <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm font-semibold text-[#B42323] transition hover:bg-[#FDF1F1] trigger-delete-modal" data-action="{{ route('senior-citizens.destroy', $seniorCitizen) }}" data-name="{{ $resident?->full_name ?? 'Senior Citizen' }}" data-confirm-title="Delete this senior citizen record?" title="Delete senior citizen record">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"/></svg>
                                                    Delete
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-sm font-medium text-[#6D817A]">
                                        No senior citizens found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($seniorCitizens->hasPages())
                    <div class="border-t border-white/70 px-6 py-4">
                        {{ $seniorCitizens->links() }}
                    </div>
                @endif
            </section>

            {{-- MOBILE CARDS --}}
            <section class="space-y-4 lg:hidden">
                @forelse ($seniorCitizens as $seniorCitizen)
                    @php $resident = $seniorCitizen->resident; @endphp
                    <article class="clay-card rounded-[22px] p-5">
                        <div class="flex items-center gap-3 border-b border-white/70 pb-4">
                            <div class="clay-icon clay-icon-green h-11 w-11 rounded-xl text-base font-bold">
                                {{ strtoupper(substr($resident?->first_name ?? 'S', 0, 1)) }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="truncate text-base font-bold text-[#164238]">
                                    {{ $resident?->full_name ?? 'Resident unavailable' }}
                                </h3>
                                <p class="text-xs text-[#6D817A]">
                                    {{ $resident?->birth_date ? $resident->birth_date->age . ' yrs old' : 'Age N/A' }} · ID: {{ $seniorCitizen->senior_citizen_id ?: '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3">
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">OSCA ID</p>
                                <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $seniorCitizen->osca_id ?: '—' }}</p>
                            </div>
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Pension Status</p>
                                <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $seniorCitizen->pension_status ?: '—' }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            @component('partials.record-actions', ['label' => 'More actions for '.($resident?->full_name ?? 'Senior Citizen')])
                            <a href="{{ route('senior-citizens.show', $seniorCitizen) }}">@include('partials.record-action-icon', ['icon' => 'view']) View</a>
                            <a href="{{ route('senior-citizens.edit', $seniorCitizen) }}">@include('partials.record-action-icon', ['icon' => 'edit']) Edit</a>
                            <button 
                                type="button" 
                                class="record-action-danger trigger-delete-modal"
                                data-action="{{ route('senior-citizens.destroy', $seniorCitizen) }}"
                                data-name="{{ $resident?->full_name ?? 'Senior Citizen' }}"
                                data-confirm-title="Delete this senior citizen record?"
                            >
                                @include('partials.record-action-icon', ['icon' => 'delete'])
                                Delete
                            </button>
                            @endcomponent
                        </div>
                    </article>
                @empty
                    <div class="clay-card p-8 text-center text-sm font-medium text-[#6D817A]">
                        No senior citizens found.
                    </div>
                @endforelse
            </section>

        </div>
    </main>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div
        id="deleteSeniorModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
    >
        <div class="clay-confirm-box" role="document">
            <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCEFED] text-[#B42323]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14a2 2 0 0 0 1.73 3h16.32a2 2 0 0 0 1.73-3l-8.18-14a2 2 0 0 0-3.42 0Z" />
                </svg>
            </div>

            <div class="mt-4">
                <h2 class="text-lg font-bold text-[#164238]">Delete Senior Citizen Record?</h2>
                <p class="mt-2 text-sm leading-6 text-[#6D817A]">
                    This action will permanently delete the senior citizen record. The linked resident profile will not be removed.
                </p>
            </div>

            <div class="clay-inset mt-4 rounded-xl p-4">
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Senior Citizen Name</p>
                <p id="deleteSeniorName" class="mt-1 break-words text-sm font-bold text-[#164238]">—</p>
            </div>

            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <button type="button" id="deleteSeniorCancel" class="clay-secondary inline-flex min-h-[42px] items-center justify-center rounded-xl px-4 py-2.5 text-sm font-bold">
                    Cancel
                </button>

                <form id="deleteSeniorForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="clay-primary inline-flex min-h-[42px] w-full sm:w-auto items-center justify-center gap-2 rounded-xl !bg-gradient-to-r !from-[#DC2626] !to-[#B42323] px-4 py-2.5 text-sm font-bold">
                        Delete Record
                    </button>
                </form>
            </div>
        </div>
    </div>

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

            /* Delete Modal */
            const modal = document.getElementById('deleteSeniorModal');
            const cancelBtn = document.getElementById('deleteSeniorCancel');
            const deleteForm = document.getElementById('deleteSeniorForm');
            const deleteSeniorName = document.getElementById('deleteSeniorName');
            const triggers = document.querySelectorAll('.trigger-delete-modal');

            triggers.forEach(btn => {
                btn.addEventListener('click', () => {
                    deleteForm.setAttribute('action', btn.getAttribute('data-action'));
                    deleteSeniorName.textContent = btn.getAttribute('data-name');
                    modal.classList.add('is-open');
                });
            });

            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => modal.classList.remove('is-open'));
            }
        });
    </script>
</body>
</html>