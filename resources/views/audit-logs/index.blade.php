<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Audit Logs | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="System audit logs for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           AUDIT LOGS
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

        [x-cloak] { display: none !important; }

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
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .clay-card-hover:hover { transform: translateY(-2px); }

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

        /* ---------- Table & Panels ---------- */
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

        /* ---------- Form Fields ---------- */
        .clay-input {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(210, 225, 218, 0.85);
            box-shadow: inset 2px 2px 5px rgba(107, 134, 124, 0.10), inset -2px -2px 5px rgba(255, 255, 255, 0.85);
            color: var(--text);
        }
        .clay-input::placeholder { color: var(--text-soft); }
        .clay-input:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(42, 155, 128, 0.18), inset 2px 2px 5px rgba(107, 134, 124, 0.10);
        }

        /* ---------- Badges ---------- */
        .clay-badge {
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.82);
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.10), -2px -2px 5px rgba(255, 255, 255, 0.88);
        }
        .clay-badge-green { background: linear-gradient(145deg, #E8F6EF, #DDEEE6); color: var(--primary-dark); }
        .clay-badge-danger { background: linear-gradient(145deg, #FCEFED, #F9E0DC); color: var(--danger); }
        .clay-badge-orange { background: linear-gradient(145deg, #FCF7ED, #F9EBD9); color: var(--accent); }
        .clay-badge-neutral { background: linear-gradient(145deg, #EDF5F0, #F8FCFA); color: var(--text-secondary); }

        /* ---------- Buttons & Links ---------- */
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

        .clay-link {
            color: var(--primary-dark);
            transition: color 0.18s ease;
        }
        .clay-link:hover { color: var(--primary-deep); }

        /* ---------- Notice ---------- */
        .clay-notice {
            background: linear-gradient(145deg, #FCF7ED, #F9EBD9);
            border: 1px solid rgba(232, 121, 40, 0.18);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
            color: #7A4A1E;
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
    <main class="min-h-screen min-w-0 lg:pl-72">

        {{-- TOP HEADER --}}
        <header class="clay-header sticky top-0 z-30">
            <div class="flex min-h-20 items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">

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
                            System Administrator
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Audit Logs
                        </h1>
                    </div>
                </div>

                {{-- Right --}}
                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')

                    <div class="hidden items-center gap-3 sm:flex">
                        <div class="max-w-44 text-right">
                            <p class="truncate text-sm font-bold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="truncate text-xs font-medium text-[#6D817A]">
                                {{ auth()->user()->role }}
                            </p>
                        </div>

                        <div class="clay-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] space-y-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="clay-heading-wrap min-w-0 lg:ml-4">
                <span class="clay-heading-accent" aria-hidden="true"></span>

                <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">System Activity</p>

                <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                    System Audit Trail
                </h2>

                <p class="clay-description mt-2 max-w-3xl text-sm leading-6">
                    Review important system activities performed by authorized users, including authentication and record changes.
                </p>
            </div>

            {{-- SUMMARY --}}
            <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                {{-- Total Logs --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Total Logs</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">
                                {{ number_format($auditLogs->total()) }}
                            </p>
                        </div>
                        <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h6M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Current Page --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Current Page</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">
                                {{ number_format($auditLogs->count()) }}
                            </p>
                        </div>
                        <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Latest Activity --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Latest Activity</p>

                            @if ($auditLogs->first())
                                <p class="mt-2 truncate text-sm font-bold text-[#164238]">
                                    {{ $auditLogs->first()->created_at->format('M d, Y h:i A') }}
                                </p>
                            @else
                                <p class="mt-2 text-sm font-bold text-[#9AA9A4]">No activity</p>
                            @endif
                        </div>
                        <div class="clay-icon clay-icon-orange h-11 w-11 rounded-2xl">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

            </section>

            {{-- FILTERS --}}
            <section class="clay-card p-5 sm:p-6">

                <div class="mb-5">
                    <h3 class="text-base font-bold text-[#164238]">Filter Audit Logs</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Search and filter recorded system activity.</p>
                </div>

                <form
                    method="GET"
                    action="{{ route('audit-logs.index') }}"
                    class="grid gap-4 md:grid-cols-2 lg:grid-cols-12"
                >

                    {{-- Search --}}
                    <div class="md:col-span-2 lg:col-span-4">
                        <label for="search" class="mb-1.5 block text-xs font-bold text-[#385C52]">Search</label>
                        <input
                            id="search"
                            name="search"
                            type="text"
                            value="{{ request('search') }}"
                            placeholder="User, action, module, IP..."
                            class="clay-input w-full rounded-xl px-3.5 py-2.5 text-sm"
                        >
                    </div>

                    {{-- Action --}}
                    <div class="lg:col-span-2">
                        <label for="action" class="mb-1.5 block text-xs font-bold text-[#385C52]">Action</label>
                        <select
                            id="action"
                            name="action"
                            class="clay-input w-full rounded-xl px-3.5 py-2.5 text-sm"
                        >
                            <option value="">All Actions</option>
                            @foreach ($actions as $action)
                                <option value="{{ $action }}" @selected(request('action') === $action)>
                                    {{ ucwords(str_replace('_', ' ', $action)) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Module --}}
                    <div class="lg:col-span-2">
                        <label for="module" class="mb-1.5 block text-xs font-bold text-[#385C52]">Module</label>
                        <select
                            id="module"
                            name="module"
                            class="clay-input w-full rounded-xl px-3.5 py-2.5 text-sm"
                        >
                            <option value="">All Modules</option>
                            @foreach ($modules as $module)
                                <option value="{{ $module }}" @selected(request('module') === $module)>
                                    {{ $module }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date From --}}
                    <div class="lg:col-span-2">
                        <label for="date_from" class="mb-1.5 block text-xs font-bold text-[#385C52]">From</label>
                        <input
                            id="date_from"
                            name="date_from"
                            type="date"
                            value="{{ request('date_from') }}"
                            class="clay-input w-full rounded-xl px-3.5 py-2.5 text-sm"
                        >
                    </div>

                    {{-- Date To --}}
                    <div class="lg:col-span-2">
                        <label for="date_to" class="mb-1.5 block text-xs font-bold text-[#385C52]">To</label>
                        <input
                            id="date_to"
                            name="date_to"
                            type="date"
                            value="{{ request('date_to') }}"
                            class="clay-input w-full rounded-xl px-3.5 py-2.5 text-sm"
                        >
                    </div>

                    {{-- Filter Buttons --}}
                    <div class="flex items-end gap-2 md:col-span-2 lg:col-span-12">
                        <button
                            type="submit"
                            class="clay-primary inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <circle cx="11" cy="11" r="7" />
                                <path stroke-linecap="round" d="m20 20-4-4" />
                            </svg>
                            Apply Filters
                        </button>

                        <a
                            href="{{ route('audit-logs.index') }}"
                            class="clay-secondary inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            Clear
                        </a>
                    </div>

                </form>

            </section>

            {{-- ACTIVITY HISTORY --}}
            <section class="clay-table">

                {{-- Section Header --}}
                <div class="border-b border-white/70 px-5 py-4 sm:px-6">
                    <h3 class="text-base font-bold text-[#164238]">Activity History</h3>
                    <p class="mt-0.5 text-xs text-[#6D817A]">
                        Showing
                        <span class="font-bold text-[#164238]">{{ $auditLogs->firstItem() ?? 0 }}</span>
                        to
                        <span class="font-bold text-[#164238]">{{ $auditLogs->lastItem() ?? 0 }}</span>
                        of
                        <span class="font-bold text-[#164238]">{{ $auditLogs->total() }}</span>
                        records
                    </p>
                </div>

                {{-- DESKTOP TABLE --}}
                <div class="hidden overflow-x-auto md:block">
                    <table class="min-w-[1000px] w-full">

                        <thead class="clay-table-head">
                            <tr>
                                <th class="w-36 whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Date & Time</th>
                                <th class="w-52 whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">User</th>
                                <th class="w-32 whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Action</th>
                                <th class="w-36 whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Module</th>
                                <th class="min-w-[320px] px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Description</th>
                                <th class="w-32 whitespace-nowrap px-5 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">IP Address</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($auditLogs as $log)

                                @php
                                    $actionStyles = match ($log->action) {
                                        'created' => 'clay-badge-green',
                                        'updated' => 'clay-badge-neutral',
                                        'deleted' => 'clay-badge-danger',
                                        'login' => 'clay-badge-green',
                                        'logout' => 'clay-badge-neutral',
                                        'login_rejected' => 'clay-badge-orange',
                                        default => 'clay-badge-neutral',
                                    };
                                @endphp

                                <tr class="clay-table-row border-b border-[#D2E1DA]/60 last:border-b-0">

                                    {{-- Date --}}
                                    <td class="whitespace-nowrap px-5 py-4 align-top">
                                        <p class="text-sm font-bold text-[#234E43]">{{ $log->created_at->format('M d, Y') }}</p>
                                        <p class="mt-0.5 text-xs text-[#6D817A]">{{ $log->created_at->format('h:i A') }}</p>
                                    </td>

                                    {{-- User --}}
                                    <td class="px-5 py-4 align-top">
                                        @if ($log->user)
                                            <p class="truncate text-sm font-bold text-[#164238]">{{ $log->user->name }}</p>
                                            <p class="mt-0.5 truncate text-xs text-[#6D817A]">{{ $log->user->email }}</p>
                                        @else
                                            <p class="text-sm text-[#6D817A]">System</p>
                                        @endif
                                    </td>

                                    {{-- Action --}}
                                    <td class="whitespace-nowrap px-5 py-4 align-top">
                                        <span class="clay-badge {{ $actionStyles }} px-2.5 py-1 text-xs font-bold">
                                            {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                        </span>
                                    </td>

                                    {{-- Module --}}
                                    <td class="whitespace-nowrap px-5 py-4 align-top">
                                        <span class="text-sm font-semibold text-[#385C52]">{{ $log->module ?? '—' }}</span>
                                    </td>

                                    {{-- Description --}}
                                    <td class="px-5 py-4 align-top">
                                        <p class="max-w-xl text-sm leading-5 text-[#385C52]">
                                            {{ $log->description ?? 'No description provided.' }}
                                        </p>
                                    </td>

                                    {{-- IP --}}
                                    <td class="whitespace-nowrap px-5 py-4 align-top">
                                        <code class="clay-inset rounded-lg px-2 py-1 text-xs text-[#385C52]">
                                            {{ $log->ip_address ?? '—' }}
                                        </code>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="px-5 py-16 text-center">
                                        <div class="mx-auto max-w-sm">
                                            <div class="clay-icon clay-icon-green mx-auto h-14 w-14 rounded-2xl">
                                                <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h6M5 4h14a1 1 0 011 1v14a1 1 0 01-1 1H5a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                                </svg>
                                            </div>
                                            <h3 class="mt-4 text-base font-bold text-[#164238]">No audit logs found</h3>
                                            <p class="mt-1 text-xs text-[#6D817A]">Try adjusting your filters or wait for new system activity.</p>
                                        </div>
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- MOBILE LIST --}}
                <div class="divide-y divide-[#D2E1DA]/60 md:hidden">
                    @forelse ($auditLogs as $log)

                        @php
                            $actionStyles = match ($log->action) {
                                'created' => 'clay-badge-green',
                                'updated' => 'clay-badge-neutral',
                                'deleted' => 'clay-badge-danger',
                                'login' => 'clay-badge-green',
                                'logout' => 'clay-badge-neutral',
                                'login_rejected' => 'clay-badge-orange',
                                default => 'clay-badge-neutral',
                            };
                        @endphp

                        <article class="clay-table-row p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-bold leading-5 text-[#164238]">
                                        {{ $log->description ?? 'System activity' }}
                                    </p>
                                    <p class="mt-1 text-xs text-[#6D817A]">{{ $log->created_at->format('M d, Y h:i A') }}</p>
                                </div>

                                <span class="clay-badge {{ $actionStyles }} shrink-0 px-2.5 py-1 text-xs font-bold">
                                    {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                </span>
                            </div>

                            <dl class="mt-4 grid grid-cols-2 gap-x-4 gap-y-3">
                                <div>
                                    <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">User</dt>
                                    <dd class="mt-1 truncate text-sm font-semibold text-[#234E43]">{{ $log->user?->name ?? 'System' }}</dd>
                                </div>

                                <div>
                                    <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Module</dt>
                                    <dd class="mt-1 truncate text-sm font-semibold text-[#234E43]">{{ $log->module ?? '—' }}</dd>
                                </div>

                                <div class="col-span-2">
                                    <dt class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">IP Address</dt>
                                    <dd class="mt-1">
                                        <code class="clay-inset rounded-lg px-2 py-1 text-xs text-[#385C52]">{{ $log->ip_address ?? '—' }}</code>
                                    </dd>
                                </div>
                            </dl>
                        </article>

                    @empty

                        <div class="px-5 py-14 text-center">
                            <p class="text-sm font-bold text-[#164238]">No audit logs found.</p>
                            <p class="mt-1 text-xs text-[#6D817A]">Try adjusting your filters.</p>
                        </div>

                    @endforelse
                </div>

                {{-- PAGINATION --}}
                @if ($auditLogs->hasPages())
                    <div class="border-t border-white/70 px-5 py-4">
                        {{ $auditLogs->links() }}
                    </div>
                @endif

            </section>

            {{-- SECURITY NOTICE --}}
            <section class="clay-notice rounded-2xl p-4">
                <div class="flex items-start gap-3">
                    <div class="clay-icon clay-icon-orange mt-0.5 h-9 w-9 shrink-0 rounded-xl">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.3 4.6l-7.1 12.3A1.5 1.5 0 004.5 19h15a1.5 1.5 0 001.3-2.1L13.7 4.6a2 2 0 00-3.4 0z" />
                        </svg>
                    </div>

                    <div class="min-w-0">
                        <p class="text-sm font-bold text-[#7A4A1E]">Audit information is restricted</p>
                        <p class="mt-1 text-xs leading-5 text-[#8A5A2E]">
                            Audit Logs are available only to System Administrators.
                            Sensitive record values are intentionally not displayed directly on this page.
                        </p>
                    </div>
                </div>
            </section>

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