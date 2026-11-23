<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Analytics | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Health center data analytics dashboard for Barangay Esperanza."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           ANALYTICS
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
        .clay-table-row { background: rgba(255, 255, 255, 0.48); transition: background 0.18s ease; }
        .clay-table-row:hover { background: rgba(255, 255, 255, 0.78); }

        .clay-bar-track {
            background: linear-gradient(145deg, #E4EFE9, #F1F7F4);
            box-shadow: inset 2px 2px 4px rgba(107, 134, 124, 0.12), inset -2px -2px 4px rgba(255, 255, 255, 0.85);
        }
        .clay-bar-fill-primary { background: linear-gradient(90deg, #2A9B80, #0F6F5A); }
        .clay-bar-fill-deep { background: linear-gradient(90deg, #1E6B55, #0F4C3A); }
        .clay-bar-fill-orange { background: linear-gradient(90deg, #F0A060, #E87928); }

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

        /* ---------- Buttons & Links ---------- */
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
                            Analytics
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

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Data Analytics</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Health Center Insights
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Analyze population demographics, health programs, medical inventory, and community schedules using the latest records in the health center system.
                    </p>
                </div>

                <div class="clay-card shrink-0 px-5 py-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Data Overview</p>
                    <p class="mt-1 text-sm font-bold text-[#164238]">{{ now()->format('F d, Y') }}</p>
                    <p class="mt-1 text-xs text-[#9AA9A4]">Based on current system records</p>
                </div>
            </div>

            {{-- POPULATION OVERVIEW --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Population Overview</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Current demographic indicators from registered residents.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    <div class="clay-card clay-card-hover p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Total Residents</p>
                                <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalResidents) }}</p>
                            </div>
                            <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-8a4 4 0 11-8 0 4 4 0 018 0zm5 3a3 3 0 100-6 3 3 0 000 6z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="clay-card clay-card-hover p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Households</p>
                                <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalHouseholds) }}</p>
                            </div>
                            <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10l9-7 9 7v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="clay-card clay-card-hover p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Male Residents</p>
                                <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($maleResidents) }}</p>
                            </div>
                            <div class="clay-icon clay-icon-green h-11 w-11 rounded-2xl">
                                <span class="text-lg font-bold text-[#0F6F5A]">M</span>
                            </div>
                        </div>
                    </div>

                    <div class="clay-card clay-card-hover p-5">
                        <div class="flex items-start justify-between gap-4">
                            <div class="min-w-0">
                                <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Female Residents</p>
                                <p class="mt-2 text-3xl font-bold tracking-tight text-[#E87928]">{{ number_format($femaleResidents) }}</p>
                            </div>
                            <div class="clay-icon clay-icon-orange h-11 w-11 rounded-2xl">
                                <span class="text-lg font-bold text-[#E87928]">F</span>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            {{-- DEMOGRAPHIC ANALYTICS --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Demographic Analytics</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Distribution of residents by age, gender, and registration status.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-3">

                    {{-- Age Distribution --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Age Group Distribution</h4>
                            <p class="mt-1 text-xs text-[#6D817A]">Resident population grouped by age.</p>
                        </div>

                        <div class="flex flex-col items-center gap-6 p-6">
                            @php
                                $ageChartColors = ['#168B70', '#E87928', '#0F4C3A', '#8AA99C', '#B42323'];
                                $ageChartOffset = 0;
                            @endphp

                            @if ($totalResidents > 0)
                                <svg class="h-40 w-40 shrink-0" viewBox="0 0 42 42" role="img" aria-label="Resident age group distribution pie chart">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#E4EFE9" stroke-width="7"></circle>
                                    <g transform="rotate(-90 21 21)">
                                        @foreach ($ageGroups as $group => $total)
                                            @php
                                                $percentage = ($total / $totalResidents) * 100;
                                                $color = $ageChartColors[$loop->index % count($ageChartColors)];
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
                                                stroke-dashoffset="{{ -$ageChartOffset }}"
                                            ></circle>
                                            @php
                                                $ageChartOffset += $percentage;
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
                            @else
                                <div class="clay-inset flex h-40 w-40 items-center justify-center rounded-full text-center text-xs text-[#6D817A]">
                                    No resident data
                                </div>
                            @endif

                            <ul class="w-full space-y-3">
                                @foreach ($ageGroups as $group => $total)
                                    @php
                                        $percentage = $totalResidents > 0
                                            ? ($total / $totalResidents) * 100
                                            : 0;
                                        $color = $ageChartColors[$loop->index % count($ageChartColors)];
                                    @endphp
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="flex min-w-0 items-center gap-2 text-sm font-bold text-[#234E43]">
                                            <span class="h-3 w-3 shrink-0 rounded-full" style="background-color: {{ $color }}"></span>
                                            <span class="truncate">{{ $group === 'Unknown' ? 'Unknown age' : $group.' years' }}</span>
                                        </span>
                                        <span class="shrink-0 text-xs text-[#6D817A]">
                                            {{ number_format($total) }} ({{ number_format($percentage, 1) }}%)
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Gender Distribution --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Gender Distribution</h4>
                            <p class="mt-1 text-xs text-[#6D817A]">Current resident population by gender.</p>
                        </div>

                        <div class="flex flex-col items-center gap-6 p-6">
                            @php
                                $genderChartColors = ['#168B70', '#E87928', '#0F4C3A'];
                                $genderChartOffset = 0;
                            @endphp

                            @if ($totalResidents > 0)
                                <svg class="h-40 w-40 shrink-0" viewBox="0 0 42 42" role="img" aria-label="Resident gender distribution pie chart">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#E4EFE9" stroke-width="7"></circle>
                                    <g transform="rotate(-90 21 21)">
                                        @foreach ($genderSummary as $gender)
                                            @php
                                                $percentage = ($gender->total / $totalResidents) * 100;
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
                            @else
                                <div class="clay-inset flex h-40 w-40 items-center justify-center rounded-full text-center text-xs text-[#6D817A]">
                                    No resident data
                                </div>
                            @endif

                            <ul class="w-full space-y-3">
                                @foreach ($genderSummary as $gender)
                                    @php
                                        $percentage = $totalResidents > 0
                                            ? ($gender->total / $totalResidents) * 100
                                            : 0;
                                        $color = $genderChartColors[$loop->index % count($genderChartColors)];
                                    @endphp
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="flex min-w-0 items-center gap-2 text-sm font-bold text-[#234E43]">
                                            <span class="h-3 w-3 shrink-0 rounded-full" style="background-color: {{ $color }}"></span>
                                            <span class="truncate">{{ $gender->gender }}</span>
                                        </span>
                                        <span class="shrink-0 text-xs text-[#6D817A]">
                                            {{ number_format($gender->total) }} ({{ number_format($percentage, 1) }}%)
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Resident Status --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Resident Status</h4>
                            <p class="mt-1 text-xs text-[#6D817A]">Current resident registration status.</p>
                        </div>

                        <div class="flex flex-col items-center gap-6 p-6">
                            @php
                                $statusChartColors = ['#168B70', '#E87928', '#B42323', '#0F4C3A', '#8AA99C'];
                                $statusChartOffset = 0;
                            @endphp

                            @if ($totalResidents > 0)
                                <svg class="h-40 w-40 shrink-0" viewBox="0 0 42 42" role="img" aria-label="Resident status pie chart">
                                    <circle cx="21" cy="21" r="15.915" fill="transparent" stroke="#E4EFE9" stroke-width="7"></circle>
                                    <g transform="rotate(-90 21 21)">
                                        @foreach ($residentStatusSummary as $status)
                                            @php
                                                $percentage = ($status->total / $totalResidents) * 100;
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
                            @else
                                <div class="clay-inset flex h-40 w-40 items-center justify-center rounded-full text-center text-xs text-[#6D817A]">
                                    No resident data
                                </div>
                            @endif

                            <ul class="w-full space-y-3">
                                @foreach ($residentStatusSummary as $status)
                                    @php
                                        $percentage = $totalResidents > 0
                                            ? ($status->total / $totalResidents) * 100
                                            : 0;
                                        $color = $statusChartColors[$loop->index % count($statusChartColors)];
                                    @endphp
                                    <li class="flex items-center justify-between gap-3">
                                        <span class="flex min-w-0 items-center gap-2 text-sm font-bold text-[#234E43]">
                                            <span class="h-3 w-3 shrink-0 rounded-full" style="background-color: {{ $color }}"></span>
                                            <span class="truncate">{{ $status->status ?: 'Unknown' }}</span>
                                        </span>
                                        <span class="shrink-0 text-xs text-[#6D817A]">
                                            {{ number_format($status->total) }} ({{ number_format($percentage, 1) }}%)
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </section>

            {{-- HEALTH PROGRAM ANALYTICS --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Health Program Analytics</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Records captured across major health-center programs.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
                    @foreach ($programCoverage as $program => $total)
                        <div class="clay-card clay-card-hover p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">{{ $program }}</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($total) }}</p>
                            <div class="mt-4 flex items-center gap-2 text-xs font-bold text-[#0F6F5A]">
                                <span class="h-2 w-2 rounded-full bg-[#2A9B80]"></span>
                                Recorded entries
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- IMMUNIZATION --}}
            <section class="mb-8">
                <div class="grid gap-6 xl:grid-cols-2">

                    {{-- Vaccine Distribution --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h3 class="text-base font-bold text-[#164238]">Immunization by Vaccine</h3>
                            <p class="mt-1 text-xs text-[#6D817A]">Number of immunization records for each vaccine.</p>
                        </div>

                        <div class="p-6">
                            @if ($immunizationByVaccine->isNotEmpty())
                                @php
                                    $maxVaccineTotal = max(
                                        $immunizationByVaccine->pluck('total')->map(fn ($value) => (int) $value)->all() ?: [1]
                                    );
                                @endphp

                                <div class="space-y-5">
                                    @foreach ($immunizationByVaccine as $item)
                                        @php
                                            $width = $maxVaccineTotal > 0 ? ($item->total / $maxVaccineTotal) * 100 : 0;
                                        @endphp

                                        <div>
                                            <div class="mb-2 flex items-center justify-between gap-4">
                                                <span class="text-sm font-bold text-[#234E43]">{{ $item->vaccine_name }}</span>
                                                <span class="text-sm font-bold text-[#164238]">{{ number_format($item->total) }}</span>
                                            </div>

                                            <div class="clay-bar-track h-3 overflow-hidden rounded-full">
                                                <div class="clay-bar-fill-primary h-full rounded-full" style="width: {{ $width }}%"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No immunization records available.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Immunization Trend --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h3 class="text-base font-bold text-[#164238]">Immunization Activity</h3>
                            <p class="mt-1 text-xs text-[#6D817A]">Immunization records grouped by month.</p>
                        </div>

                        <div class="p-6">
                            @if ($immunizationTrend->isNotEmpty())
                                @php
                                    $maxTrend = max(
                                        $immunizationTrend->pluck('total')->map(fn ($value) => (int) $value)->all() ?: [1]
                                    );
                                @endphp

                                <div class="space-y-4">
                                    @foreach ($immunizationTrend as $item)
                                        @php
                                            $width = $maxTrend > 0 ? ($item->total / $maxTrend) * 100 : 0;
                                        @endphp

                                        <div class="flex items-center gap-4">
                                            <div class="w-20 shrink-0 text-xs font-bold text-[#6D817A]">
                                                {{ \Carbon\Carbon::createFromFormat('Y-m', $item->month)->format('M Y') }}
                                            </div>

                                            <div class="clay-bar-track h-3 flex-1 overflow-hidden rounded-full">
                                                <div class="clay-bar-fill-deep h-full rounded-full" style="width: {{ $width }}%"></div>
                                            </div>

                                            <span class="w-10 text-right text-sm font-bold text-[#164238]">{{ $item->total }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No immunization trend data available.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            {{-- MATERNAL + CHILD HEALTH --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Maternal and Child Health</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Program indicators for maternal care and child health monitoring.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">

                    {{-- Maternal --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Maternal Care Status</h4>
                            <p class="mt-1 text-xs text-[#6D817A]">Records grouped according to pregnancy status.</p>
                        </div>

                        <div class="p-6">
                            @if ($maternalCareByStatus->isNotEmpty())
                                <div class="space-y-4">
                                    @foreach ($maternalCareByStatus as $item)
                                        <div class="clay-inset flex items-center justify-between rounded-xl px-4 py-3">
                                            <span class="text-sm font-bold text-[#234E43]">{{ $item->pregnancy_status }}</span>
                                            <span class="text-sm font-bold text-[#164238]">{{ number_format($item->total) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No maternal care records available.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Child --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Child Nutritional Status</h4>
                            <p class="mt-1 text-xs text-[#6D817A]">Child health records grouped by nutritional status.</p>
                        </div>

                        <div class="p-6">
                            @if ($childHealthByNutrition->isNotEmpty())
                                <div class="space-y-4">
                                    @foreach ($childHealthByNutrition as $item)
                                        <div class="clay-inset flex items-center justify-between rounded-xl px-4 py-3">
                                            <span class="text-sm font-bold text-[#234E43]">{{ $item->nutritional_status }}</span>
                                            <span class="text-sm font-bold text-[#164238]">{{ number_format($item->total) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No child health records available.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            {{-- SENIOR CITIZEN ANALYTICS --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Senior Citizen Analytics</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Overview of senior citizen living arrangements and benefits.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">

                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Living Arrangement</h4>
                        </div>

                        <div class="p-6">
                            @if ($seniorCitizenByLivingArrangement->isNotEmpty())
                                <div class="space-y-4">
                                    @foreach ($seniorCitizenByLivingArrangement as $item)
                                        <div class="clay-inset flex items-center justify-between rounded-xl px-4 py-3">
                                            <span class="text-sm font-bold text-[#234E43]">{{ $item->living_arrangement }}</span>
                                            <span class="text-sm font-bold text-[#164238]">{{ number_format($item->total) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No senior citizen data available.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="clay-card p-6">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Social Pension Beneficiaries</p>
                        <p class="mt-3 text-4xl font-bold tracking-tight text-[#E87928]">{{ number_format($seniorCitizenPensionCount) }}</p>
                        <p class="mt-2 text-sm text-[#6D817A]">Registered senior citizens receiving social pension.</p>

                        <div class="clay-inset mt-6 rounded-xl px-4 py-3 text-sm text-[#385C52]">
                            <span class="font-bold text-[#0F6F5A]">
                                {{ $totalSeniorCitizens > 0
                                    ? number_format(($seniorCitizenPensionCount / $totalSeniorCitizens) * 100, 1)
                                    : '0.0'
                                }}%
                            </span>
                            of registered senior citizens
                        </div>
                    </div>

                </div>
            </section>

            {{-- MEDICAL INVENTORY ANALYTICS --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Medical Inventory Analytics</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Current inventory levels and expiry indicators.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                    <div class="clay-card clay-card-hover p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Inventory Items</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalMedicalInventory) }}</p>
                    </div>

                    <div class="clay-card clay-card-hover p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Total Quantity</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">{{ number_format($totalInventoryQuantity) }}</p>
                    </div>

                    <div class="clay-card clay-card-hover p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#B42323]">Expired</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#B42323]">{{ number_format($expiredInventory) }}</p>
                    </div>

                    <div class="clay-card clay-card-hover p-5">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#E87928]">Expiring Within 30 Days</p>
                        <p class="mt-2 text-3xl font-bold tracking-tight text-[#E87928]">{{ number_format($expiringSoonInventory) }}</p>
                    </div>

                </div>

                <div class="clay-card mt-4 p-5">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#164238]">Low Stock Items</p>
                            <p class="mt-1 text-xs text-[#6D817A]">Inventory records with quantity of 10 or below.</p>
                        </div>

                        <span class="clay-badge clay-badge-orange w-fit px-3 py-1.5 text-sm font-bold">
                            {{ number_format($lowStockInventory) }} items
                        </span>
                    </div>
                </div>
            </section>

            {{-- SCHEDULE ANALYTICS --}}
            <section class="mb-8">
                <div class="mb-4">
                    <h3 class="text-base font-bold text-[#164238]">Schedule Analytics</h3>
                    <p class="mt-1 text-xs text-[#6D817A]">Community health-center events and upcoming activities.</p>
                </div>

                <div class="grid gap-6 xl:grid-cols-2">

                    {{-- Event Types --}}
                    <div class="clay-table">
                        <div class="border-b border-white/70 px-6 py-5">
                            <h4 class="text-base font-bold text-[#164238]">Events by Type</h4>
                            <p class="mt-1 text-xs text-[#6D817A]">Distribution of scheduled health-center activities.</p>
                        </div>

                        <div class="p-6">
                            @if ($eventsByType->isNotEmpty())
                                <div class="space-y-4">
                                    @foreach ($eventsByType as $item)
                                        <div class="clay-inset flex items-center justify-between rounded-xl px-4 py-3">
                                            <span class="text-sm font-bold text-[#234E43]">{{ $item->event_type }}</span>
                                            <span class="text-sm font-bold text-[#164238]">{{ number_format($item->total) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No schedule records available.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Upcoming Events --}}
                    <div class="clay-table">
                        <div class="flex items-start justify-between gap-4 border-b border-white/70 px-6 py-5">
                            <div>
                                <h4 class="text-base font-bold text-[#164238]">Upcoming Events</h4>
                                <p class="mt-1 text-xs text-[#6D817A]">Next scheduled activities.</p>
                            </div>

                            <span class="clay-badge clay-badge-green shrink-0 px-3 py-1 text-xs font-bold">
                                {{ number_format($totalEvents) }} total
                            </span>
                        </div>

                        <div class="p-6">
                            @if ($upcomingEvents->isNotEmpty())
                                <div class="space-y-3">
                                    @foreach ($upcomingEvents as $event)
                                        <div class="clay-inset rounded-xl p-4">
                                            <div class="flex items-start gap-3">
                                                <div class="clay-icon clay-icon-green h-10 w-10 shrink-0 rounded-xl text-xs font-bold">
                                                    {{ $event->event_date?->format('d') }}
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <p class="truncate text-sm font-bold text-[#164238]">{{ $event->title }}</p>
                                                    <p class="mt-1 text-xs text-[#6D817A]">
                                                        {{ $event->event_date?->format('F d, Y') }}
                                                        @if ($event->start_time)
                                                            · {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}
                                                        @endif
                                                    </p>
                                                    @if ($event->location)
                                                        <p class="mt-1 truncate text-xs text-[#9AA9A4]">{{ $event->location }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="clay-inset rounded-2xl p-5 text-center text-sm text-[#6D817A]">
                                    No upcoming events.
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </section>

            {{-- ANALYTICS FOOTER --}}
            <section>
                <div class="clay-card p-5 sm:p-6">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-bold text-[#164238]">Data-driven health center management</p>
                            <p class="mt-1 text-sm leading-6 text-[#385C52]">
                                Analytics are generated from the current records maintained in the Barangay Esperanza Health Center system.
                            </p>
                        </div>

                        <div class="clay-badge clay-badge-green shrink-0 px-4 py-2 text-xs font-bold">
                            Live system data
                        </div>
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