<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Announcements | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           ANNOUNCEMENTS MANAGEMENT
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
            min-height: 32px;
            border-radius: 10px;
            padding: 0.35rem 0.65rem;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.82);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .clay-action:hover { transform: translateY(-1px); }

        .clay-view { background: linear-gradient(145deg, #E8F6EF, #DDEEE6); color: var(--primary-dark) !important; border-color: rgba(22, 139, 112, 0.14); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.88); }

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

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
                        Manage Announcements
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Create and publish health center announcements for residents and registered households.
                    </p>
                </div>

                <a
                    href="{{ route('announcements.create') }}"
                    class="clay-primary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    New Announcement
                </a>
            </div>

            {{-- MESSAGES --}}
            @if (session('success'))
                <div class="clay-card mb-6 rounded-2xl border-l-4 border-l-[#168B70] p-4 text-sm text-[#0F6F5A]">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-8 w-8 rounded-xl">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </div>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="clay-danger mb-6 rounded-2xl p-4 text-sm">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon h-8 w-8 rounded-xl bg-white text-[#B42323]">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008" />
                            </svg>
                        </div>
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- SUMMARY STATS --}}
            <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Total Announcements</p>
                            <p class="mt-2 text-3xl font-bold text-[#164238]">{{ $announcements->total() }}</p>
                        </div>
                        <div class="clay-icon clay-icon-green h-12 w-12 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-5a2 2 0 00-2 2v9a2 2 0 002 2h5z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Published</p>
                            <p class="mt-2 text-3xl font-bold text-[#126647]">{{ $announcements->where('status', 'Published')->count() }}</p>
                        </div>
                        <div class="clay-icon h-12 w-12 rounded-2xl bg-[#E7F7EF] text-[#126647]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Urgent</p>
                            <p class="mt-2 text-3xl font-bold text-[#B42323]">{{ $announcements->where('priority', 'Urgent')->count() }}</p>
                        </div>
                        <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCEFED] text-[#B42323]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3.75h.007v.008H12v-.008ZM10.29 3.86l-7.82 13.5A1.875 1.875 0 0 0 4.095 20.2h15.81a1.875 1.875 0 0 0 1.624-2.84l-7.82-13.5a1.875 1.875 0 0 0-3.248 0Z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">SMS Households</p>
                            <p class="mt-2 text-3xl font-bold text-[#E87928]">{{ $announcements->sum('sms_deliveries_count') }}</p>
                        </div>
                        <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75h6.75m-6.75 3h4.125m-7.875 3.75 1.8-1.8a1.125 1.125 0 0 1 .795-.33h8.73a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6.75v5.37a2.25 2.25 0 0 0 2.25 2.25v1.38Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>

            {{-- DESKTOP TABLE --}}
            <section class="clay-table hidden lg:block">
                <div class="flex items-center justify-between border-b border-white/70 px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-5a2 2 0 00-2 2v9a2 2 0 002 2h5z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Published Announcements</h3>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Health center advisories and delivery tracking.</p>
                        </div>
                    </div>

                    @if ($announcements->total() > 0)
                        <div class="text-xs font-semibold text-[#6D817A]">
                            Showing <span class="font-bold text-[#164238]">{{ $announcements->firstItem() }}</span> to <span class="font-bold text-[#164238]">{{ $announcements->lastItem() }}</span> of <span class="font-bold text-[#164238]">{{ $announcements->total() }}</span>
                        </div>
                    @endif
                </div>

                @if ($announcements->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[950px]">
                            <thead class="clay-table-head">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Announcement</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Target</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Priority</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Recipients</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Published</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#6D817A]">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($announcements as $announcement)
                                    @php
                                        $targetLabels = [
                                            'specific' => 'Specific Resident',
                                            'senior' => 'Senior Citizens',
                                            'children' => 'Children',
                                            'pregnant' => 'Pregnant Residents',
                                            'general' => 'All Active Residents',
                                            'age_bracket' => 'Age Bracket',
                                        ];
                                        $targetLabel = $targetLabels[$announcement->target_type] ?? ucwords(str_replace('_', ' ', $announcement->target_type));
                                    @endphp

                                    <tr class="clay-table-row border-b border-[#D2E1DA]/60 last:border-b-0">
                                        <td class="px-6 py-4">
                                            <a href="{{ route('announcements.show', $announcement) }}" class="font-bold text-[#164238] hover:text-[#168B70]">
                                                {{ $announcement->title }}
                                            </a>
                                            <p class="mt-1 line-clamp-2 max-w-xl text-xs leading-5 text-[#6D817A]">
                                                {{ $announcement->message }}
                                            </p>
                                            @if ($announcement->creator)
                                                <p class="mt-1.5 text-[11px] text-[#9AA9A4]">
                                                    Created by <span class="font-bold text-[#385C52]">{{ $announcement->creator->name }}</span>
                                                </p>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="clay-inset inline-flex rounded-full px-3 py-1 text-xs font-bold text-[#164238]">
                                                {{ $targetLabel }}
                                            </span>
                                            @if ($announcement->target_type === 'age_bracket' && !is_null($announcement->min_age) && !is_null($announcement->max_age))
                                                <p class="mt-1 text-[11px] text-[#6D817A]">Ages {{ $announcement->min_age }}–{{ $announcement->max_age }}</p>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($announcement->priority === 'Urgent')
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-3 py-1 text-xs font-bold text-[#B42323]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#DC2626]"></span>
                                                    Urgent
                                                </span>
                                            @elseif ($announcement->priority === 'Important')
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#E87928]/20 bg-[#FCF7ED] px-3 py-1 text-xs font-bold text-[#E87928]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#E87928]"></span>
                                                    Important
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#6D817A]/20 bg-[#EDF5F0] px-3 py-1 text-xs font-bold text-[#385C52]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#6D817A]"></span>
                                                    Normal
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-[#234E43]">
                                                {{ $announcement->recipients_count }} residents
                                            </p>
                                            <p class="text-[11px] text-[#6D817A]">
                                                {{ $announcement->sms_deliveries_count }} SMS households
                                            </p>
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($announcement->published_at)
                                                <p class="text-xs font-bold text-[#234E43]">{{ $announcement->published_at->format('M d, Y') }}</p>
                                                <p class="text-[11px] text-[#6D817A]">{{ $announcement->published_at->format('h:i A') }}</p>
                                            @else
                                                <span class="text-xs text-[#9AA9A4]">—</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('announcements.show', $announcement) }}" class="clay-action clay-view">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($announcements->hasPages())
                        <div class="border-t border-white/70 px-6 py-4">
                            {{ $announcements->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="clay-icon clay-icon-green mx-auto h-12 w-12 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-5a2 2 0 00-2 2v9a2 2 0 002 2h5z" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-base font-bold text-[#164238]">No announcements yet</h3>
                        <p class="mt-1 text-xs text-[#6D817A]">There are currently no published health center announcements.</p>

                        <a href="{{ route('announcements.create') }}" class="clay-primary mt-4 inline-flex items-center gap-2 rounded-xl px-4 py-2 text-xs font-bold">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Create First Announcement
                        </a>
                    </div>
                @endif
            </section>

            {{-- MOBILE CARDS --}}
            <section class="space-y-4 lg:hidden">
                @forelse ($announcements as $announcement)
                    @php
                        $targetLabels = [
                            'specific' => 'Specific Resident',
                            'senior' => 'Senior Citizens',
                            'children' => 'Children',
                            'pregnant' => 'Pregnant Residents',
                            'general' => 'All Active Residents',
                            'age_bracket' => 'Age Bracket',
                        ];
                        $targetLabel = $targetLabels[$announcement->target_type] ?? ucwords(str_replace('_', ' ', $announcement->target_type));
                    @endphp

                    <article class="clay-card rounded-[22px] p-5">
                        <div class="flex items-start justify-between border-b border-white/70 pb-3">
                            <div class="min-w-0 pr-2">
                                <a href="{{ route('announcements.show', $announcement) }}" class="text-base font-bold text-[#164238]">
                                    {{ $announcement->title }}
                                </a>
                                <p class="mt-1 line-clamp-2 text-xs text-[#6D817A]">{{ $announcement->message }}</p>
                            </div>

                            @if ($announcement->priority === 'Urgent')
                                <span class="shrink-0 rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-2.5 py-0.5 text-[11px] font-bold text-[#B42323]">Urgent</span>
                            @elseif ($announcement->priority === 'Important')
                                <span class="shrink-0 rounded-full border border-[#E87928]/20 bg-[#FCF7ED] px-2.5 py-0.5 text-[11px] font-bold text-[#E87928]">Important</span>
                            @else
                                <span class="shrink-0 rounded-full border border-[#6D817A]/20 bg-[#EDF5F0] px-2.5 py-0.5 text-[11px] font-bold text-[#385C52]">Normal</span>
                            @endif
                        </div>

                        <div class="mt-3 flex items-center gap-2">
                            <span class="clay-inset rounded-full px-3 py-1 text-xs font-bold text-[#164238]">{{ $targetLabel }}</span>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-3 text-xs">
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Recipients</p>
                                <p class="mt-1 font-bold text-[#234E43]">{{ $announcement->recipients_count }} residents</p>
                            </div>

                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Published</p>
                                <p class="mt-1 font-bold text-[#234E43]">{{ $announcement->published_at?->format('M d, Y') ?? '—' }}</p>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('announcements.show', $announcement) }}" class="clay-action clay-view w-full text-center">View Announcement</a>
                        </div>
                    </article>
                @empty
                    <div class="clay-card p-8 text-center text-sm font-medium text-[#6D817A]">
                        No announcements found.
                    </div>
                @endforelse

                @if ($announcements->hasPages())
                    <div class="mt-4">
                        {{ $announcements->links() }}
                    </div>
                @endif
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
                    overlay.classList.add('hidden');Fbread
                });
            }
        });
    </script>
</body>
</html>