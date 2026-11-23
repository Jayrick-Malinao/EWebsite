<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reports | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Health center reports and analytics for Barangay Esperanza."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           REPORTS & ANALYTICS
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

        [x-cloak] { display: none !important; }

        /* ---------- Header ---------- */
        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 0 5px 18px rgba(107, 134, 124, 0.08), 0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

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

        .clay-bar-track {
            background: linear-gradient(145deg, #E4EFE9, #F1F7F4);
            box-shadow: inset 2px 2px 4px rgba(107, 134, 124, 0.12), inset -2px -2px 4px rgba(255, 255, 255, 0.85);
        }
        .clay-bar-fill-primary { background: linear-gradient(90deg, #2A9B80, #0F6F5A); }
        .clay-bar-fill-deep { background: linear-gradient(90deg, #1E6B55, #0F4C3A); }

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

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        .clay-link {
            color: var(--primary-dark);
            transition: color 0.18s ease;
        }
        .clay-link:hover { color: var(--primary-deep); }

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
                            System Administrator
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Reports
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

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Management</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Reports & Analytics
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Monitor health center records, community demographics, programs, inventory, and scheduled activities using consolidated system data.
                    </p>
                </div>
            </div>

            {{-- RECORD SUMMARY --}}
            <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                {{-- Residents --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Residents</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalResidents) }}</p>
                            <p class="mt-1 text-xs text-[#9AA9A4]">Registered residents</p>
                        </div>
                        <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a6 6 0 00-12 0m6-8a4 4 0 100-8 4 4 0 000 8zm7-5v6m3-3h-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Households --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Households</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalHouseholds) }}</p>
                            <p class="mt-1 text-xs text-[#9AA9A4]">Registered households</p>
                        </div>
                        <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V9l7-5 7 5v12M9 21v-5h6v5M9 10h.01M12 10h.01M15 10h.01" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Senior Citizens --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Senior Citizens</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#E87928]">{{ number_format($totalSeniorCitizens) }}</p>
                            <p class="mt-1 text-xs text-[#9AA9A4]">Registered program records</p>
                        </div>
                        <div class="clay-icon clay-icon-orange h-11 w-11 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19a6 6 0 00-12 0m6-8a4 4 0 100-8 4 4 0 000 8zm7-6h4m-2-2v4" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Medical Inventory --}}
                <div class="clay-card clay-card-hover p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Medical Inventory</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalMedicalInventory) }}</p>
                            <p class="mt-1 text-xs text-[#9AA9A4]">Medicine and supply records</p>
                        </div>
                        <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6m-7 4h8m-9 0v14h10V7M10 11h4m-4 4h4" />
                            </svg>
                        </div>
                    </div>
                </div>

            </section>

            {{-- PROGRAM RECORDS --}}
            <section class="mb-8">
                <div class="mb-3">
                    <h3 class="text-base font-bold text-[#164238]">Program Records</h3>
                    <p class="mt-0.5 text-xs text-[#6D817A]">Overview of records maintained across health programs.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                    <div class="clay-card p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Health Records</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-[#164238]">{{ number_format($totalHealthRecords) }}</p>
                        <p class="mt-1 text-xs text-[#9AA9A4]">Resident health profiles</p>
                    </div>

                    <div class="clay-card p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Immunizations</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-[#164238]">{{ number_format($totalImmunizations) }}</p>
                        <p class="mt-1 text-xs text-[#9AA9A4]">Vaccination records</p>
                    </div>

                    <div class="clay-card p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Maternal Care</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-[#164238]">{{ number_format($totalMaternalCare) }}</p>
                        <p class="mt-1 text-xs text-[#9AA9A4]">Maternal program records</p>
                    </div>

                    <div class="clay-card p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Child Health</p>
                        <p class="mt-2 text-2xl font-bold tracking-tight text-[#164238]">{{ number_format($totalChildHealth) }}</p>
                        <p class="mt-1 text-xs text-[#9AA9A4]">Child health assessments</p>
                    </div>

                </div>
            </section>

            {{-- COMMUNITY ANALYTICS --}}
            <section class="mb-8">
                <div class="mb-3">
                    <h3 class="text-base font-bold text-[#164238]">Community Analytics</h3>
                    <p class="mt-0.5 text-xs text-[#6D817A]">Quick breakdowns of the registered resident population.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">

                    {{-- Gender Distribution --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-5 py-4 sm:px-6">
                            <h3 class="text-base font-bold text-[#164238]">Resident Gender Distribution</h3>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Breakdown of registered residents by gender</p>
                        </div>

                        <div class="p-5 sm:p-6">
                            @if ($genderSummary->count() > 0)
                                @php
                                    $genderChartColors = ['#168B70', '#E87928', '#0F4C3A', '#8AA99C'];
                                    $genderChartOffset = 0;
                                @endphp

                                <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-center">
                                    <svg
                                        class="h-40 w-40 shrink-0"
                                        viewBox="0 0 42 42"
                                        role="img"
                                        aria-label="Resident gender distribution pie chart"
                                    >
                                        <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#E4EFE9" stroke-width="7"></circle>
                                        <g transform="rotate(-90 21 21)">
                                            @foreach ($genderSummary as $gender)
                                                @php
                                                    $percentage = $totalResidents > 0
                                                        ? ($gender->total / $totalResidents) * 100
                                                        : 0;
                                                    $color = $genderChartColors[$loop->index % count($genderChartColors)];
                                                @endphp
                                                <circle
                                                    cx="21"
                                                    cy="21"
                                                    r="15.915"
                                                    fill="transparent"
                                                    stroke="{{ $color }}"
                                                    stroke-width="7"
                                                    pathLength="100"
                                                    stroke-dasharray="{{ $percentage }} {{ 100 - $percentage }}"
                                                    stroke-dashoffset="{{ -$genderChartOffset }}"
                                                ></circle>
                                                @php
                                                    $genderChartOffset += $percentage;
                                                @endphp
                                            @endforeach
                                        </g>
                                        <text x="21" y="20" text-anchor="middle" class="fill-[#164238] text-[5px] font-bold">
                                            {{ number_format($totalResidents) }}
                                        </text>
                                        <text x="21" y="25" text-anchor="middle" class="fill-[#6D817A] text-[3px]">
                                            residents
                                        </text>
                                    </svg>

                                    <ul class="w-full space-y-3">
                                        @foreach ($genderSummary as $gender)
                                        @php
                                            $percentage = $totalResidents > 0
                                                ? round(($gender->total / $totalResidents) * 100, 1)
                                                : 0;
                                            $color = $genderChartColors[$loop->index % count($genderChartColors)];
                                        @endphp
                                        <li class="flex items-center justify-between gap-4">
                                            <span class="flex min-w-0 items-center gap-2 text-sm font-bold text-[#234E43]">
                                                <span class="h-3 w-3 shrink-0 rounded-full" style="background-color: {{ $color }}"></span>
                                                <span class="truncate">{{ $gender->gender ?: 'Not specified' }}</span>
                                            </span>
                                            <span class="shrink-0 text-xs font-semibold text-[#6D817A]">
                                                {{ number_format($gender->total) }} ({{ $percentage }}%)
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <div class="flex min-h-32 items-center justify-center text-center">
                                    <p class="text-sm text-[#6D817A]">No gender data available.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Resident Status --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-5 py-4 sm:px-6">
                            <h3 class="text-base font-bold text-[#164238]">Resident Status</h3>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Current status of registered residents</p>
                        </div>

                        <div class="p-5 sm:p-6">
                            @if ($residentStatusSummary->count() > 0)
                                @php
                                    $statusChartColors = ['#168B70', '#E87928', '#B42323', '#0F4C3A', '#8AA99C'];
                                    $statusChartOffset = 0;
                                @endphp

                                <div class="flex flex-col items-center gap-6 sm:flex-row sm:items-center">
                                    <svg
                                        class="h-40 w-40 shrink-0"
                                        viewBox="0 0 42 42"
                                        role="img"
                                        aria-label="Resident status pie chart"
                                    >
                                        <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#E4EFE9" stroke-width="7"></circle>
                                        <g transform="rotate(-90 21 21)">
                                            @foreach ($residentStatusSummary as $status)
                                                @php
                                                    $percentage = $totalResidents > 0
                                                        ? ($status->total / $totalResidents) * 100
                                                        : 0;
                                                    $color = $statusChartColors[$loop->index % count($statusChartColors)];
                                                @endphp
                                                <circle
                                                    cx="21"
                                                    cy="21"
                                                    r="15.915"
                                                    fill="transparent"
                                                    stroke="{{ $color }}"
                                                    stroke-width="7"
                                                    pathLength="100"
                                                    stroke-dasharray="{{ $percentage }} {{ 100 - $percentage }}"
                                                    stroke-dashoffset="{{ -$statusChartOffset }}"
                                                ></circle>
                                                @php
                                                    $statusChartOffset += $percentage;
                                                @endphp
                                            @endforeach
                                        </g>
                                        <text x="21" y="20" text-anchor="middle" class="fill-[#164238] text-[5px] font-bold">
                                            {{ number_format($totalResidents) }}
                                        </text>
                                        <text x="21" y="25" text-anchor="middle" class="fill-[#6D817A] text-[3px]">
                                            residents
                                        </text>
                                    </svg>

                                    <ul class="w-full space-y-3">
                                        @foreach ($residentStatusSummary as $status)
                                        @php
                                            $percentage = $totalResidents > 0
                                                ? round(($status->total / $totalResidents) * 100, 1)
                                                : 0;
                                            $color = $statusChartColors[$loop->index % count($statusChartColors)];
                                        @endphp
                                        <li class="flex items-center justify-between gap-4">
                                            <span class="flex min-w-0 items-center gap-2 text-sm font-bold text-[#234E43]">
                                                <span class="h-3 w-3 shrink-0 rounded-full" style="background-color: {{ $color }}"></span>
                                                <span class="truncate">{{ $status->status ?: 'Not specified' }}</span>
                                            </span>
                                            <span class="shrink-0 text-xs font-semibold text-[#6D817A]">
                                                {{ number_format($status->total) }} ({{ $percentage }}%)
                                            </span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <div class="flex min-h-32 items-center justify-center text-center">
                                    <p class="text-sm text-[#6D817A]">No resident status data available.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            {{-- OPERATIONAL OVERVIEW --}}
            <section class="mb-8">
                <div class="mb-3">
                    <h3 class="text-base font-bold text-[#164238]">Operational Overview</h3>
                    <p class="mt-0.5 text-xs text-[#6D817A]">Upcoming activities and inventory items requiring attention.</p>
                </div>

                <div class="grid gap-6 lg:grid-cols-2">

                    {{-- Upcoming Events --}}
                    <div class="clay-table">
                        <div class="flex items-center justify-between gap-4 border-b border-white/70 px-5 py-4 sm:px-6">
                            <div class="min-w-0">
                                <h3 class="text-base font-bold text-[#164238]">Upcoming Schedule</h3>
                                <p class="mt-0.5 text-xs text-[#6D817A]">Next scheduled health center activities</p>
                            </div>
                            <a href="{{ route('schedule.index') }}" class="clay-link shrink-0 text-xs font-bold">
                                View schedule
                            </a>
                        </div>

                        @if ($upcomingEvents->count() > 0)
                            <div class="divide-y divide-[#D2E1DA]/60">
                                @foreach ($upcomingEvents as $event)
                                    <div class="clay-table-row px-5 py-4 sm:px-6">
                                        <div class="flex items-start gap-3">
                                            <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-bold text-[#164238]">{{ $event->title }}</p>
                                                <p class="mt-1 text-xs text-[#6D817A]">
                                                    {{ $event->event_date?->format('F j, Y') }}
                                                    @if ($event->start_time)
                                                        · {{ date('g:i A', strtotime($event->start_time)) }}
                                                    @endif
                                                </p>
                                                @if ($event->location)
                                                    <p class="mt-1 truncate text-xs text-[#9AA9A4]">{{ $event->location }}</p>
                                                @endif
                                            </div>

                                            <span class="clay-badge clay-badge-green hidden shrink-0 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide sm:inline-flex">
                                                {{ $event->event_type }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex min-h-40 items-center justify-center px-5 text-center">
                                <p class="text-sm text-[#6D817A]">No upcoming schedule events.</p>
                            </div>
                        @endif
                    </div>

                    {{-- Inventory Alerts --}}
                    <div class="clay-table">
                        <div class="flex items-center justify-between gap-4 border-b border-white/70 px-5 py-4 sm:px-6">
                            <div class="min-w-0">
                                <h3 class="text-base font-bold text-[#164238]">Inventory Expiry Alerts</h3>
                                <p class="mt-0.5 text-xs text-[#6D817A]">Items approaching or past expiry</p>
                            </div>
                            <a href="{{ route('medical-inventories.index') }}" class="clay-link shrink-0 text-xs font-bold">
                                View inventory
                            </a>
                        </div>

                        @if ($inventoryAlerts->count() > 0)
                            <div class="divide-y divide-[#D2E1DA]/60">
                                @foreach ($inventoryAlerts as $inventory)
                                    @php
                                        $expiryDate = $inventory->expiry_date;
                                        $isExpired = $expiryDate?->isPast();
                                    @endphp

                                    <div class="clay-table-row px-5 py-4 sm:px-6">
                                        <div class="flex items-start gap-3">
                                            <div class="clay-icon clay-icon-orange h-10 w-10 rounded-xl">
                                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3m0 4h.01M5.07 19h13.86c1.54 0 2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46 0L3.34 16c-.77 1.33.19 3 1.73 3z" />
                                                </svg>
                                            </div>

                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-bold text-[#164238]">{{ $inventory->medicine_name }}</p>
                                                <p class="mt-1 text-xs text-[#6D817A]">Quantity: {{ number_format($inventory->quantity) }}</p>
                                                <p class="mt-1 text-xs text-[#9AA9A4]">Expiry: {{ $expiryDate?->format('F j, Y') }}</p>
                                            </div>

                                            @if ($isExpired)
                                                <span class="clay-badge clay-badge-danger h-fit shrink-0 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">
                                                    Expired
                                                </span>
                                            @else
                                                <span class="clay-badge clay-badge-orange h-fit shrink-0 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide">
                                                    Expiring
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex min-h-40 items-center justify-center px-5 text-center">
                                <p class="text-sm text-[#6D817A]">No inventory expiry alerts.</p>
                            </div>
                        @endif
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