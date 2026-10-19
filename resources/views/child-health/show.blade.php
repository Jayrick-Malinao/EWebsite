<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Child Health Record | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
        ========================================================= */

        :root {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;

            --bg: #EEF5F1;
            --surface: #F5FAF7;
            --surface-soft: #EDF5F0;

            --text: #164238;
            --text-heading: #234E43;
            --text-muted: #6D817A;

            --danger: #B42323;

            --border-white: rgba(255, 255, 255, 0.90);
            --shadow-dark: rgba(107, 134, 124, 0.18);
            --shadow-light: rgba(255, 255, 255, 0.92);

            --radius-md: 14px;
            --radius-xl: 24px;
        }

        *, *::before, *::after { box-sizing: border-box; }
        body { margin: 0; background: var(--bg); color: var(--text); font-family: Arial, Helvetica, sans-serif !important; }

        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(14px);
        }

        .clay-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow: 8px 8px 18px var(--shadow-dark), -8px -8px 18px var(--shadow-light);
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
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88);
        }
        .clay-icon-green { background: linear-gradient(145deg, #E7F5EE, #D9ECE4); color: var(--primary-dark); }

        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22);
            transition: transform 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); }

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14);
        }

        .clay-delete-btn {
            background: linear-gradient(145deg, #FCEFED, #F5E2E0);
            color: var(--danger) !important;
            border: 1px solid rgba(180, 35, 35, 0.14);
        }

        @media (max-width: 1023px) { main { padding-left: 0; } }
    </style>
</head>

<body class="antialiased">

    <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-[#164238]/40 backdrop-blur-sm lg:hidden"></div>

    @include('dashboard.sidebar')

    <main class="min-h-screen lg:pl-72">

        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <button id="mobileMenuButton" class="clay-secondary h-10 w-10 rounded-xl lg:hidden flex items-center justify-center">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-[#168B70]">Barangay Esperanza Health Center</p>
                        <h1 class="text-xl font-bold text-[#164238]">Child Health Record</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    @include('partials.notification-bell')
                    <div class="hidden sm:block text-right">
                        <p class="text-sm font-bold text-[#164238]">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#6D817A]">{{ auth()->user()->role ?? 'Health Worker' }}</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8">

            <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-[#164238]">
                        {{ $childHealth->resident?->full_name ?? 'Child Health Record' }}
                    </h2>
                    <p class="text-sm text-[#6D817A]">Detailed growth, assessment, and preventive health information.</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('child-health.index') }}" class="clay-secondary min-h-[44px] px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                        Back
                    </a>
                    <a href="{{ route('child-health.edit', $childHealth) }}" class="clay-primary min-h-[44px] px-4 py-2.5 rounded-xl text-xs font-bold inline-flex items-center gap-2">
                        Edit Record
                    </a>
                </div>
            </div>

            <div class="space-y-6">

                {{-- Resident Overview --}}
                <section class="clay-card p-6">
                    <div class="flex items-center gap-4 border-b border-white/70 pb-4 mb-5">
                        <div class="clay-icon clay-icon-green h-12 w-12 rounded-2xl text-lg font-bold">
                            {{ strtoupper(substr($childHealth->resident?->first_name ?? 'C', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Resident Profile</p>
                            <h3 class="text-xl font-bold text-[#164238]">{{ $childHealth->resident?->full_name ?? 'Unknown Resident' }}</h3>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-3">
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Resident ID</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">#{{ $childHealth->resident_id }}</p>
                        </div>
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Assessment Date</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $childHealth->assessment_date?->format('F d, Y') ?? '—' }}</p>
                        </div>
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Nutritional Status</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $childHealth->nutritional_status ?: 'Not recorded' }}</p>
                        </div>
                    </div>
                </section>

                {{-- Assessment & Growth --}}
                <section class="clay-card p-6">
                    <h3 class="text-base font-bold text-[#164238] mb-4 border-b border-white/70 pb-3">Growth & Measurements</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Weight</p>
                            <p class="mt-1 text-base font-bold text-[#234E43]">{{ $childHealth->weight_kg !== null ? number_format((float)$childHealth->weight_kg, 2) . ' kg' : 'Not recorded' }}</p>
                        </div>
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Height</p>
                            <p class="mt-1 text-base font-bold text-[#234E43]">{{ $childHealth->height_cm !== null ? number_format((float)$childHealth->height_cm, 2) . ' cm' : 'Not recorded' }}</p>
                        </div>
                    </div>
                </section>

                {{-- Preventive Care --}}
                <section class="clay-card p-6">
                    <h3 class="text-base font-bold text-[#164238] mb-4 border-b border-white/70 pb-3">Preventive Care</h3>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Vitamin A Supplementation</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $childHealth->vitamin_a_status ?: 'Not recorded' }}</p>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Date: {{ $childHealth->vitamin_a_date?->format('F d, Y') ?? '—' }}</p>
                        </div>
                        <div class="clay-inset p-4 rounded-xl">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Deworming Treatment</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $childHealth->deworming_status ?: 'Not recorded' }}</p>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Date: {{ $childHealth->deworming_date?->format('F d, Y') ?? '—' }}</p>
                        </div>
                    </div>
                </section>

                {{-- Notes & Observations --}}
                <section class="clay-card p-6 space-y-4">
                    <h3 class="text-base font-bold text-[#164238] border-b border-white/70 pb-3">Observations & Health Assessment</h3>
                    
                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Developmental Milestones</p>
                        <div class="clay-inset mt-1.5 p-4 rounded-xl text-sm leading-6 text-[#164238]">
                            {!! nl2br(e($childHealth->developmental_milestones ?: 'No details recorded.')) !!}
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Health Assessment</p>
                        <div class="clay-inset mt-1.5 p-4 rounded-xl text-sm leading-6 text-[#164238]">
                            {!! nl2br(e($childHealth->health_assessment ?: 'No health assessment recorded.')) !!}
                        </div>
                    </div>

                    <div>
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Remarks</p>
                        <div class="clay-inset mt-1.5 p-4 rounded-xl text-sm leading-6 text-[#164238]">
                            {!! nl2br(e($childHealth->remarks ?: 'No additional remarks.')) !!}
                        </div>
                    </div>
                </section>

                {{-- Delete Form Action --}}
                <section class="clay-card p-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div>
                        <h4 class="text-sm font-bold text-[#164238]">Delete Record</h4>
                        <p class="text-xs text-[#6D817A]">Permanently remove this child health monitoring record.</p>
                    </div>

                    <form method="POST" action="{{ route('child-health.destroy', $childHealth) }}" onsubmit="return confirm('Are you sure you want to delete this record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="clay-delete-btn min-h-[44px] px-5 py-2.5 rounded-xl text-xs font-bold">
                            Delete Record
                        </button>
                    </form>
                </section>

            </div>

        </div>
    </main>

</body>
</html>