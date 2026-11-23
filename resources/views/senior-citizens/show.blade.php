<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $seniorCitizen->resident->full_name }} | Senior Citizen Record</title>

    <meta
        name="description"
        content="View senior citizen record details for Barangay Esperanza Health Center."
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

        /* ---------- Accessibility ---------- */
        .clay-households a:focus-visible,
        .clay-households button:focus-visible {
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

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Senior Citizen Record</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ $seniorCitizen->resident->full_name }}
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Detailed profile, registration info, pension records, and health assistance details.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    <a
                        href="{{ route('senior-citizens.index') }}"
                        class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back to List
                    </a>

                </div>
            </div>

            {{-- SUCCESS MESSAGE --}}
            @if(session('success'))
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

            {{-- PROFILE SUMMARY HEADER --}}
            <section class="clay-card mb-6 p-6 sm:p-8">
                <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                    <div class="flex items-center gap-5">
                        <div class="clay-icon clay-icon-green h-16 w-16 rounded-2xl text-2xl font-bold sm:h-20 sm:w-20">
                            {{ strtoupper(substr($seniorCitizen->resident->first_name, 0, 1)) }}
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#168B70]">
                                Senior Citizen Profile
                            </p>
                            <h2 class="mt-1 text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                                {{ $seniorCitizen->resident->full_name }}
                            </h2>
                            <p class="mt-1 text-xs font-semibold text-[#6D817A]">
                                Senior Citizen ID: <span class="text-[#164238]">{{ $seniorCitizen->senior_citizen_id ?? 'Not assigned' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="clay-inset flex flex-wrap items-center gap-4 rounded-2xl p-4 sm:gap-6">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">OSCA ID</p>
                            <p class="mt-0.5 text-sm font-bold text-[#164238]">{{ $seniorCitizen->osca_id ?? '—' }}</p>
                        </div>

                        <div class="h-8 w-px bg-[#D2E1DA]/80"></div>

                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Pension</p>
                            <p class="mt-0.5 text-sm font-bold text-[#164238]">{{ $seniorCitizen->pension_status ?? '—' }}</p>
                        </div>

                        <div class="h-8 w-px bg-[#D2E1DA]/80"></div>

                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Age</p>
                            <p class="mt-0.5 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->birth_date?->age ?? '—' }} yrs</p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- RESIDENT INFORMATION --}}
            <section class="clay-card mb-6 p-5 sm:p-6">
                <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                    <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#164238]">Resident Information</h3>
                        <p class="text-xs text-[#6D817A]">Basic demographic details linked from the resident record.</p>
                    </div>
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Full Name</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->full_name }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Birth Date</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->birth_date?->format('F d, Y') ?? '—' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Age</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->birth_date?->age ?? '—' }} years old</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Gender</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->gender ?? '—' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Civil Status</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->civil_status ?? '—' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Contact Number</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($seniorCitizen->resident->contact_number) ?? '—' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4 sm:col-span-2 lg:col-span-3">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Household Address</p>
                        <p class="mt-1 text-sm font-bold text-[#164238]">{{ $seniorCitizen->resident->household_address ?? '—' }}</p>
                    </div>
                </div>
            </section>

            {{-- REGISTRATION & PENSION GRID --}}
            <div class="mb-6 grid gap-6 lg:grid-cols-2">

                {{-- Registration Details --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EEF4FB] text-[#397CB5]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Registration Details</h3>
                            <p class="text-xs text-[#6D817A]">Senior citizen registry and arrangement status.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Senior Citizen ID</span>
                            <span class="text-sm font-bold text-[#168B70]">{{ $seniorCitizen->senior_citizen_id ?? '—' }}</span>
                        </div>

                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Registration Date</span>
                            <span class="text-sm font-bold text-[#164238]">{{ $seniorCitizen->registration_date?->format('F d, Y') ?? '—' }}</span>
                        </div>

                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">OSCA ID</span>
                            <span class="text-sm font-bold text-[#164238]">{{ $seniorCitizen->osca_id ?? '—' }}</span>
                        </div>

                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Beneficiary Status</span>
                            @if($seniorCitizen->beneficiary_status)
                                <span class="inline-flex rounded-full bg-[#E7F7EF] px-2.5 py-0.5 text-xs font-bold text-[#126647]">
                                    {{ $seniorCitizen->beneficiary_status }}
                                </span>
                            @else
                                <span class="text-sm font-bold text-[#164238]">—</span>
                            @endif
                        </div>

                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Living Arrangement</span>
                            <span class="text-sm font-bold text-[#164238]">{{ $seniorCitizen->living_arrangement ?? '—' }}</span>
                        </div>
                    </div>
                </section>

                {{-- Pension Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#EAF7EE] text-[#168B70]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Pension Information</h3>
                            <p class="text-xs text-[#6D817A]">Assistance pension status and classification.</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Pension Status</span>
                            @if($seniorCitizen->pension_status)
                                <span class="inline-flex rounded-full bg-[#EEF4FB] px-2.5 py-0.5 text-xs font-bold text-[#397CB5]">
                                    {{ $seniorCitizen->pension_status }}
                                </span>
                            @else
                                <span class="text-sm font-bold text-[#164238]">—</span>
                            @endif
                        </div>

                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Pension Type</span>
                            <span class="text-sm font-bold text-[#164238]">{{ $seniorCitizen->pension_type ?? '—' }}</span>
                        </div>

                        <div class="clay-inset flex items-center justify-between rounded-xl p-3.5">
                            <span class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Disability Status</span>
                            <span class="text-sm font-bold text-[#164238]">{{ $seniorCitizen->disability_status ?? '—' }}</span>
                        </div>
                    </div>
                </section>

            </div>

            {{-- HEALTH & ASSISTANCE --}}
            <section class="clay-card mb-6 p-5 sm:p-6">
                <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                    <div class="clay-icon h-10 w-10 rounded-xl bg-[#FCF7ED] text-[#E87928]">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.35-7-10.2A4.8 4.8 0 0 1 9.8 6c1.1 0 2.2.4 3.2 1.3C14 6.4 15.1 6 16.2 6A4.8 4.8 0 0 1 21 10.8C21 16.65 12 21 12 21Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#164238]">Health and Assistance</h3>
                        <p class="text-xs text-[#6D817A]">Recorded medical conditions, medications, assistance requirements, and notes.</p>
                    </div>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Medical Conditions</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 font-bold text-[#164238]">
                            {{ $seniorCitizen->medical_conditions ?: 'No medical conditions recorded.' }}
                        </p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Medications</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 font-bold text-[#164238]">
                            {{ $seniorCitizen->medications ?: 'No medications recorded.' }}
                        </p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Assistance Needed</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 font-bold text-[#164238]">
                            {{ $seniorCitizen->assistance_needed ?: 'No assistance requirements recorded.' }}
                        </p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Remarks</p>
                        <p class="mt-2 whitespace-pre-line text-sm leading-6 font-bold text-[#164238]">
                            {{ $seniorCitizen->remarks ?: 'No additional remarks.' }}
                        </p>
                    </div>
                </div>
            </section>

            {{-- RECORD METADATA & ACTIONS --}}
            <div class="clay-card p-5">
                <div class="flex items-center gap-4 text-xs font-semibold text-[#6D817A]">
                    <p>Created: <span class="font-bold text-[#164238]">{{ $seniorCitizen->created_at?->format('M d, Y h:i A') ?? '—' }}</span></p>
                    <span class="h-4 w-px bg-[#D2E1DA]"></span>
                    <p>Updated: <span class="font-bold text-[#164238]">{{ $seniorCitizen->updated_at?->format('M d, Y h:i A') ?? '—' }}</span></p>
                </div>

            </div>

        </div>
    </main>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* Mobile Sidebar */
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