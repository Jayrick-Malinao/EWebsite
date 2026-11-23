<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Immunizations | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
            --muted: #6D817A;
            --soft: #9AA9A4;

            --danger: #B42323;
            --danger-light: #FDECEC;
        }

        .immunization-page {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .immunization-page .clay-header {
            background: rgba(245, 250, 247, 0.96);
            border-color: rgba(15, 111, 90, 0.12);
            box-shadow:
                0 5px 14px rgba(22, 67, 56, 0.07),
                0 1px 3px rgba(22, 67, 56, 0.05);
        }

        .immunization-page .clay-menu-button {
            border: 1px solid rgba(22, 139, 112, 0.14);
            background: var(--surface);
            color: var(--primary-dark);
            box-shadow:
                4px 4px 10px rgba(30, 76, 65, 0.10),
                -3px -3px 8px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-menu-button:hover {
            background: var(--surface-soft);
            color: var(--primary);
        }

        .immunization-page .clay-role {
            color: var(--primary);
        }

        .immunization-page .clay-title {
            color: var(--text-dark);
        }

        .immunization-page .clay-profile-name {
            color: var(--text-dark);
        }

        .immunization-page .clay-profile-role {
            color: var(--muted);
        }

        .immunization-page .clay-avatar {
            background: linear-gradient(145deg, #DDF1E9, #CBE7DD);
            color: var(--primary-dark);
            box-shadow:
                4px 4px 9px rgba(30, 76, 65, 0.12),
                -3px -3px 8px rgba(255, 255, 255, 0.9);
        }

        .immunization-page .clay-breadcrumb {
            color: var(--muted);
        }

        .immunization-page .clay-breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .immunization-page .clay-breadcrumb-current {
            color: var(--text-dark);
        }

        .immunization-page .clay-page-label {
            color: var(--primary);
        }

        .immunization-page .clay-page-title {
            color: var(--text-dark);
        }

        .immunization-page .clay-description {
            color: var(--muted);
        }

        .immunization-page .clay-primary-button {
            background: linear-gradient(145deg, var(--primary-light), var(--primary-dark));
            color: white;
            border: 1px solid rgba(15, 111, 90, 0.20);
            box-shadow:
                5px 5px 12px rgba(22, 76, 64, 0.18),
                -4px -4px 10px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-primary-button:hover {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark));
            transform: translateY(-1px);
            box-shadow:
                6px 7px 14px rgba(22, 76, 64, 0.20),
                -4px -4px 10px rgba(255, 255, 255, 0.9);
        }

        .immunization-page .clay-primary-button:focus {
            outline: none;
            box-shadow:
                0 0 0 3px rgba(22, 139, 112, 0.18),
                5px 5px 12px rgba(22, 76, 64, 0.18);
        }

        .immunization-page .clay-card {
            background: var(--surface);
            border: 1px solid rgba(22, 139, 112, 0.10);
            box-shadow:
                7px 7px 16px rgba(38, 77, 67, 0.10),
                -6px -6px 14px rgba(255, 255, 255, 0.90);
        }

        .immunization-page .clay-input {
            border: 1px solid rgba(22, 139, 112, 0.13);
            background: var(--surface-soft);
            color: var(--text-dark);
            box-shadow:
                inset 3px 3px 7px rgba(38, 77, 67, 0.07),
                inset -3px -3px 7px rgba(255, 255, 255, 0.78);
        }

        .immunization-page .clay-input::placeholder {
            color: var(--soft);
        }

        .immunization-page .clay-input:focus {
            border-color: rgba(22, 139, 112, 0.55);
            background: var(--surface);
            outline: none;
            box-shadow:
                inset 2px 2px 5px rgba(38, 77, 67, 0.06),
                inset -2px -2px 5px rgba(255, 255, 255, 0.85),
                0 0 0 3px rgba(22, 139, 112, 0.10);
        }

        .immunization-page .clay-search-button {
            background: var(--text-dark);
            color: white;
            box-shadow:
                4px 4px 9px rgba(38, 77, 67, 0.16),
                -3px -3px 8px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-search-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .immunization-page .clay-clear-button {
            border: 1px solid rgba(22, 139, 112, 0.12);
            color: var(--muted);
            background: var(--surface);
            box-shadow:
                3px 3px 8px rgba(38, 77, 67, 0.08),
                -3px -3px 7px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-clear-button:hover {
            background: var(--surface-soft);
            color: var(--text-dark);
        }

        .immunization-page .clay-success {
            border: 1px solid rgba(22, 139, 112, 0.16);
            background: #E5F4EE;
            color: var(--primary-dark);
            box-shadow:
                5px 5px 12px rgba(38, 77, 67, 0.08),
                -4px -4px 10px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-error {
            border: 1px solid rgba(180, 35, 35, 0.14);
            background: var(--danger-light);
            color: var(--danger);
            box-shadow:
                5px 5px 12px rgba(100, 45, 45, 0.07),
                -4px -4px 10px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-summary-icon {
            background: linear-gradient(145deg, #E1F2EB, #D2EAE1);
            color: var(--primary-dark);
            box-shadow:
                4px 4px 9px rgba(38, 77, 67, 0.10),
                -3px -3px 8px rgba(255, 255, 255, 0.9);
        }

        .immunization-page .clay-table {
            background: var(--surface);
            border-color: rgba(22, 139, 112, 0.10);
            box-shadow:
                8px 8px 18px rgba(38, 77, 67, 0.10),
                -6px -6px 14px rgba(255, 255, 255, 0.90);
        }

        .immunization-page .clay-table-head {
            background: var(--surface-soft);
            color: var(--muted);
            border-color: rgba(22, 139, 112, 0.10);
        }

        .immunization-page .clay-table-row {
            border-color: rgba(22, 139, 112, 0.07);
        }

        .immunization-page .clay-table-row:hover {
            background: #F0F7F3;
        }

        .immunization-page .clay-avatar-small {
            background: linear-gradient(145deg, #E1F2EB, #CFE9DF);
            color: var(--primary-dark);
            box-shadow:
                3px 3px 7px rgba(38, 77, 67, 0.10),
                -2px -2px 6px rgba(255, 255, 255, 0.85);
        }

        .immunization-page .clay-name {
            color: var(--text-dark);
        }

        .immunization-page .clay-secondary {
            color: var(--muted);
        }

        .immunization-page .clay-dose {
            background: #E2F2EC;
            color: var(--primary-dark);
            box-shadow:
                inset 2px 2px 4px rgba(38, 77, 67, 0.06),
                inset -2px -2px 4px rgba(255, 255, 255, 0.75);
        }

        /* =========================================================
           ACTIONS
        ========================================================= */

        .immunization-page .clay-action {
            min-width: 62px;
            min-height: 36px;
            border: 1px solid rgba(255, 255, 255, .80) !important;
            border-radius: 9px;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .72) !important;
        }

        .immunization-page .clay-action-view {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            ) !important;
            color: #60766E !important;
        }

        .immunization-page .clay-action-view:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .immunization-page .clay-action-edit {
            background: linear-gradient(
                145deg,
                #E9F7F2,
                #DCEEE7
            ) !important;
            color: var(--primary-dark) !important;
        }

        .immunization-page .clay-action-edit:hover {
            color: #0B5C49 !important;
            transform: translateY(-1px);
        }

        .immunization-page .clay-action-delete {
            background: linear-gradient(
                145deg,
                #FFF5F4,
                #F7E7E6
            ) !important;
            color: var(--danger) !important;
        }

        .immunization-page .clay-action-delete:hover {
            background: linear-gradient(
                145deg,
                #FFF0EF,
                #F4DEDC
            ) !important;
            color: #8F1D1D !important;
            transform: translateY(-1px);
        }

        .immunization-page .clay-overdue {
            color: var(--danger);
        }

        .immunization-page .clay-due {
            background: var(--danger-light);
            color: var(--danger);
            box-shadow:
                inset 2px 2px 4px rgba(100, 45, 45, 0.05),
                inset -2px -2px 4px rgba(255, 255, 255, 0.70);
        }

        .immunization-page .clay-empty-icon {
            background: linear-gradient(145deg, #E6F0EC, #DCE9E4);
            color: var(--soft);
            box-shadow:
                4px 4px 9px rgba(38, 77, 67, 0.09),
                -3px -3px 8px rgba(255, 255, 255, 0.90);
        }

        .immunization-page .clay-empty-title {
            color: var(--text-dark);
        }

        .immunization-page .clay-empty-text {
            color: var(--muted);
        }

        .immunization-page .clay-mobile-card {
            background: var(--surface);
            border: 1px solid rgba(22, 139, 112, 0.10);
            box-shadow:
                7px 7px 16px rgba(38, 77, 67, 0.10),
                -6px -6px 14px rgba(255, 255, 255, 0.90);
        }

        .immunization-page .clay-divider {
            border-color: rgba(22, 139, 112, 0.09);
        }

        .immunization-page .clay-footer {
            border-color: rgba(22, 139, 112, 0.10);
            color: var(--muted);
        }

        .immunization-page .clay-pagination {
            border-color: rgba(22, 139, 112, 0.10);
        }

        @media (max-width: 640px) {
            .immunization-page .clay-primary-button {
                width: 100%;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#EEF5F1] text-[#164238]">

    <div class="immunization-page">

        {{-- Mobile Sidebar Overlay --}}
        <div
            id="sidebar-overlay"
            class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden">
        </div>

        {{-- Sidebar --}}
        @include('dashboard.sidebar')

        {{-- Main Content --}}
        <main class="lg:pl-72">

            {{-- Top Header --}}
            <header class="clay-header sticky top-0 z-30 border-b bg-white/95 backdrop-blur">

                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                    {{-- Left Side --}}
                    <div class="flex items-center gap-4">

                        {{-- Mobile Menu Button --}}
                        <button
                            type="button"
                            id="mobileMenuButton"
                            class="clay-menu-button inline-flex h-10 w-10 items-center justify-center rounded-xl transition lg:hidden"
                            aria-label="Open navigation menu"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>

                        <div>
                            <p class="clay-role text-xs font-semibold uppercase tracking-wider">
                                System Administrator
                            </p>

                            <h1 class="clay-title mt-1 text-xl font-bold tracking-tight sm:text-2xl">
                                Immunization
                            </h1>
                        </div>

                    </div>

                    {{-- Right Side --}}
                    <div class="flex items-center gap-3">

                        @include('partials.notification-bell')

                        {{-- Profile --}}
                        <div class="flex items-center gap-3">

                            <div class="clay-profile-name hidden text-right sm:block">
                                <p class="text-sm font-semibold">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="clay-profile-role text-xs">
                                    System Administrator
                                </p>
                            </div>

                            <div class="clay-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                        </div>

                    </div>

                </div>

            </header>

            {{-- Page Content --}}
            <div class="px-4 py-6 sm:px-6 lg:px-8">

                {{-- Page Heading --}}
                <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div class="flex items-start gap-4">

                        {{-- Left Accent Line --}}
                        <div class="mt-1 h-16 w-1.5 shrink-0 rounded-full bg-[#168B70] shadow-[2px_2px_5px_rgba(15,111,90,0.18)]"></div>

                        <div>

                            <h1 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                                Immunization Records
                            </h1>

                            <p class="clay-description mt-1 max-w-2xl text-sm">
                                Record and monitor vaccines administered to Barangay Esperanza residents.
                            </p>

                        </div>

                    </div>

                    <a
                        href="{{ route('immunizations.create') }}"
                        class="clay-primary-button inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 5v14M5 12h14" />

                        </svg>

                        Add Immunization

                    </a>

                </div>

                {{-- Flash Message --}}
                @if (session('success'))

                    <div class="clay-success mb-6 flex items-start gap-3 rounded-xl px-4 py-3 text-sm">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5 12 4 4L19 6" />

                        </svg>

                        <span>{{ session('success') }}</span>

                    </div>

                @endif

                {{-- Validation / Error Message --}}
                @if ($errors->any())

                    <div class="clay-error mb-6 rounded-xl px-4 py-3 text-sm">

                        <div class="flex items-start gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.007M10.29 3.86l-8.04 14a2 2 0 0 0 1.73 3l-8.04-14a2 2 0 0 0-3.46 0Z" />

                            </svg>

                            <div>
                                <p class="font-semibold">
                                    Please check the following:
                                </p>

                                <ul class="mt-1 list-disc space-y-1 pl-5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>

                    </div>

                @endif

                {{-- Search + Summary --}}
                <div class="mb-6 grid gap-4 lg:grid-cols-[1fr_auto]">

                    {{-- Search --}}
                    <form
                        method="GET"
                        action="{{ route('immunizations.index') }}"
                        class="clay-card rounded-2xl p-4">

                        <label
                            for="search"
                            class="mb-2 block text-sm font-semibold text-[#234E43]">
                            Search immunization records
                        </label>

                        <div class="flex flex-col gap-3 sm:flex-row">

                            <div class="relative flex-1">

                                <svg
                                    class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-[#9AA9A4]"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z" />

                                </svg>

                                <input
                                    id="search"
                                    name="search"
                                    type="search"
                                    value="{{ $search }}"
                                    placeholder="Search resident, vaccine, type, or dose..."
                                    class="clay-input w-full rounded-xl py-2.5 pl-10 pr-4 text-sm outline-none transition">

                            </div>

                            <button
                                type="submit"
                                class="clay-search-button inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold transition">

                                Search

                            </button>

                            @if ($search !== '')

                                <a
                                    href="{{ route('immunizations.index') }}"
                                    class="clay-clear-button inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold transition">

                                    Clear

                                </a>

                            @endif

                        </div>

                    </form>

                    {{-- Summary --}}
                    <div class="clay-card rounded-2xl p-5 lg:min-w-52">

                        <div class="flex items-center justify-between gap-4">

                            <div>

                                <p class="text-xs font-semibold uppercase tracking-wider text-[#6D817A]">
                                    Records
                                </p>

                                <p class="mt-1 text-2xl font-bold text-[#234E43]">
                                    {{ $immunizations->total() }}
                                </p>

                                <p class="mt-1 text-xs text-[#6D817A]">
                                    Immunization records
                                </p>

                            </div>

                            <div class="clay-summary-icon flex h-11 w-11 items-center justify-center rounded-xl">

                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 3 5 17m4-12 4 4m-6 6 4 4M8 21h8" />

                                </svg>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Desktop Table --}}
                <div class="clay-table hidden overflow-hidden rounded-2xl border lg:block">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-[#E1EAE6]">

                            <thead class="clay-table-head">

                                <tr>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Resident
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Purok
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">
                                        Status
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">
                                        <span class="sr-only">Actions</span>
                                    </th>

                                </tr>

                            </thead>

                            <tbody class="divide-y divide-[#E8F0EC]">

                                @forelse ($immunizations as $immunization)

                                    <tr class="clay-table-row transition">

                                        {{-- Resident --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <div class="flex items-center gap-3">

                                                <div class="clay-avatar-small flex h-10 w-10 shrink-0 items-center justify-center rounded-full text-sm font-bold">

                                                    {{ strtoupper(substr($immunization->resident->first_name ?? 'R', 0, 1)) }}

                                                </div>

                                                <div>

                                                    <p class="clay-name font-semibold">
                                                        {{ $immunization->resident->full_name ?? 'Unknown Resident' }}
                                                    </p>

                                                    <p class="clay-secondary text-xs">
                                                        Resident ID #{{ $immunization->resident_id }}
                                                    </p>

                                                </div>

                                            </div>

                                        </td>

                                        {{-- Purok --}}
                                        <td class="px-6 py-4">
                                            <p class="clay-name font-medium">
                                                {{ $immunization->resident?->purok ?: '—' }}
                                            </p>
                                        </td>

                                        {{-- Status --}}
                                        <td class="whitespace-nowrap px-6 py-4">
                                            @if (($immunization->resident?->status ?? 'Active') === 'Active')
                                                <span class="clay-status-active inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#168B70]"></span>
                                                    Active
                                                </span>
                                            @else
                                                <span class="clay-status-inactive inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#8FA19A]"></span>
                                                    {{ $immunization->resident?->status ?? 'Inactive' }}
                                                </span>
                                            @endif
                                        </td>

                                        {{-- Actions --}}
                                        <td class="whitespace-nowrap px-6 py-4">

                                            <div class="relative flex items-center justify-end">
                                                <button type="button" class="clay-action-menu-trigger flex h-10 w-10 items-center justify-center rounded-full text-[#6D817A] transition hover:text-[#164238]" aria-label="More actions for {{ $immunization->resident->full_name ?? 'immunization' }}" aria-expanded="false" data-menu-trigger>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                        <circle cx="10" cy="5" r="1.5"/>
                                                        <circle cx="10" cy="10" r="1.5"/>
                                                        <circle cx="10" cy="15" r="1.5"/>
                                                    </svg>
                                                </button>

                                                <div class="clay-action-menu absolute right-0 top-full z-20 mt-2 hidden min-w-[180px] rounded-2xl border border-white/80 bg-[#F5FAF7] p-2 shadow-[0_12px_35px_rgba(107,134,124,0.18)]" data-menu-panel>
                                                    <a href="{{ route('immunizations.show', $immunization) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                        View
                                                    </a>
                                                    <a href="{{ route('immunizations.edit', $immunization) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/></svg>
                                                        Edit
                                                    </a>
                                                    <form method="POST" action="{{ route('immunizations.destroy', $immunization) }}" data-confirm-title="Delete this immunization record?" data-confirm-item="{{ $immunization->vaccine_name }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm font-semibold text-[#B42323] transition hover:bg-[#FDF1F1]">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"/></svg>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="px-6 py-16 text-center">

                                            <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-2xl">

                                                <svg
                                                    class="h-7 w-7"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    viewBox="0 0 24 24">

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M19 3 5 17m4-12 4 4m-6 6 4 4M8 21h8" />

                                                </svg>

                                            </div>

                                            <h3 class="clay-empty-title mt-4 text-sm font-semibold">
                                                No immunization records found
                                            </h3>

                                            <p class="clay-empty-text mx-auto mt-1 max-w-md text-sm">
                                                @if ($search !== '')
                                                    No records match your search. Try a different search term.
                                                @else
                                                    Start by recording the first immunization given to a resident.
                                                @endif
                                            </p>

                                            @if ($search === '')

                                                <a
                                                    href="{{ route('immunizations.create') }}"
                                                    class="clay-primary-button mt-5 inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition">

                                                    <svg
                                                        class="h-5 w-5"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                        viewBox="0 0 24 24">

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 5v14M5 12h14" />

                                                    </svg>

                                                    Add Immunization

                                                </a>

                                            @endif

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- Pagination --}}
                    @if ($immunizations->hasPages())

                        <div class="clay-pagination border-t px-6 py-4">
                            {{ $immunizations->links() }}
                        </div>

                    @endif

                </div>

                {{-- Mobile Cards --}}
                <div class="space-y-3 lg:hidden">

                    @forelse ($immunizations as $immunization)

                        <div class="clay-mobile-card rounded-2xl p-4">

                            <div class="flex items-start justify-between gap-3">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="clay-avatar-small flex h-11 w-11 shrink-0 items-center justify-center rounded-full text-sm font-bold">

                                        {{ strtoupper(substr($immunization->resident->first_name ?? 'R', 0, 1)) }}

                                    </div>

                                    <div class="min-w-0">

                                        <p class="clay-name truncate font-semibold">
                                            {{ $immunization->resident->full_name ?? 'Unknown Resident' }}
                                        </p>

                                        <p class="clay-secondary truncate text-xs">
                                            {{ $immunization->vaccine_name }}
                                        </p>

                                    </div>

                                </div>

                                @if ($immunization->dose_number)

                                    <span class="clay-dose shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold">
                                        {{ $immunization->dose_number }}
                                    </span>

                                @endif

                            </div>

                            <div class="clay-divider mt-4 grid grid-cols-2 gap-3 border-t pt-4">

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-[#9AA9A4]">
                                        Administered
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-[#234E43]">
                                        {{ $immunization->date_administered?->format('M d, Y') ?? '—' }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-[11px] font-semibold uppercase tracking-wider text-[#9AA9A4]">
                                        Next Dose
                                    </p>

                                    @if ($immunization->next_dose_date)

                                        @php
                                            $nextDose = $immunization->next_dose_date;
                                            $isOverdue = $nextDose->isPast();
                                        @endphp

                                        <p class="mt-1 text-sm font-medium {{ $isOverdue ? 'clay-overdue' : 'text-[#234E43]' }}">
                                            {{ $nextDose->format('M d, Y') }}
                                        </p>

                                    @else

                                        <p class="mt-1 text-sm text-[#9AA9A4]">
                                            —
                                        </p>

                                    @endif

                                </div>

                            </div>

                            <div class="clay-divider mt-4 border-t pt-3">
                                @component('partials.record-actions', ['label' => 'More actions for '.($immunization->resident->full_name ?? 'immunization')])

                                <a
                                    href="{{ route('immunizations.show', $immunization) }}"
                                >

                                    @include('partials.record-action-icon', ['icon' => 'view'])
                                    View

                                </a>

                                <a
                                    href="{{ route('immunizations.edit', $immunization) }}"
                                >

                                    @include('partials.record-action-icon', ['icon' => 'edit'])
                                    Edit

                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('immunizations.destroy', $immunization) }}"
                                    data-confirm-title="Delete this immunization record?"
                                    data-confirm-item="{{ $immunization->vaccine_name }}">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="record-action-danger">

                                        @include('partials.record-action-icon', ['icon' => 'delete'])
                                        Delete

                                    </button>

                                </form>

                                @endcomponent
                            </div>

                        </div>

                    @empty

                        <div class="clay-mobile-card rounded-2xl px-5 py-12 text-center">

                            <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-2xl">

                                <svg
                                    class="h-7 w-7"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 3 5 17m4-12 4 4m-6 6 4 4M8 21h8" />

                                </svg>

                            </div>

                            <h3 class="clay-empty-title mt-4 text-sm font-semibold">
                                No immunization records found
                            </h3>

                            <p class="clay-empty-text mx-auto mt-1 max-w-md text-sm">
                                @if ($search !== '')
                                    No records match your search.
                                @else
                                    Start by recording the first immunization given to a resident.
                                @endif
                            </p>

                            @if ($search === '')

                                <a
                                    href="{{ route('immunizations.create') }}"
                                    class="clay-primary-button mt-5 inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24">

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 5v14M5 12h14" />

                                    </svg>

                                    Add Immunization

                                </a>

                            @endif

                        </div>

                    @endforelse

                    @if ($immunizations->hasPages())

                        <div class="clay-mobile-card rounded-2xl px-4 py-4">
                            {{ $immunizations->links() }}
                        </div>

                    @endif

                </div>

            </div>

            {{-- Footer --}}
            <footer class="clay-footer border-t px-4 py-5 sm:px-6 lg:px-8">

                <div class="flex flex-col gap-2 text-xs sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        © {{ date('Y') }} Barangay Esperanza Health Center
                    </p>

                    <p>
                        Immunization Records Management
                    </p>

                </div>

            </footer>

        </main>

    </div>

    {{-- Mobile Sidebar Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('[data-sidebar]');
            const overlay = document.getElementById('sidebar-overlay');
            const menuButton = document.getElementById('mobileMenuButton');

            if (!sidebar || !overlay || !menuButton) {
                return;
            }

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            };

            menuButton.addEventListener('click', openSidebar);
            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });

        });
    </script>

</body>

</html>