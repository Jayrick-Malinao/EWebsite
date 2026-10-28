<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Pregnancy #{{ $maternalCare->pregnancy_number }}
        | Maternal Care
        | Barangay Esperanza Health Center
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           MATERNAL CARE MANAGEMENT
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

            --radius-md: 14px;
            --radius-xl: 24px;
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

        /* ---------- Status Badges ---------- */
        .clay-status-pregnant { background: linear-gradient(145deg, #E7F7EF, #DCEFE6); color: #126647; border: 1px solid rgba(18, 140, 90, 0.08); }
        .clay-status-delivered { background: linear-gradient(145deg, #EAF2EE, #DDE8E2); color: #385C52; border: 1px solid rgba(56, 92, 82, 0.08); }
        .clay-status-miscarriage { background: linear-gradient(145deg, #FCF1DF, #F6E5C9); color: #8B5B16; border: 1px solid rgba(139, 91, 22, 0.10); }
        .clay-status-stillbirth { background: linear-gradient(145deg, #FCEDEC, #F5DCDA); color: #A52626; border: 1px solid rgba(165, 38, 38, 0.10); }
        .clay-status-default { background: linear-gradient(145deg, #EEF3F0, #E3EAE6); color: #52665E; border: 1px solid rgba(101, 126, 117, 0.08); }

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

        .clay-delete-btn {
            background: linear-gradient(145deg, #FCEFED, #F5E2E0);
            color: var(--danger) !important;
            border: 1px solid rgba(180, 35, 35, 0.14);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.10), -4px -4px 9px rgba(255, 255, 255, 0.84);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-delete-btn:hover { transform: translateY(-1px); filter: brightness(0.98); }

        .clay-success {
            background: linear-gradient(145deg, #F1FAF5, #E2F2E9);
            border: 1px solid rgba(22, 139, 112, 0.13);
            color: #0F6F5A;
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
                            Maternal Care
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
                                {{ auth()->user()->role ?? 'User' }}
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
                        Pregnancy #{{ $maternalCare->pregnancy_number }}
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Detailed pregnancy and maternal care information.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2">
                    {{-- Back --}}
                    <a
                        href="{{ route('maternal-care.index') }}"
                        class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        Back
                    </a>

                    {{-- Edit --}}
                    <a
                        href="{{ route('maternal-care.edit', $maternalCare) }}"
                        class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.5 16.153 6.75 17.25l1.097-3.75L16.862 4.487Z" />
                        </svg>
                        Edit Record
                    </a>

                    {{-- Delete --}}
                    <button
                        type="button"
                        id="triggerDeleteModal"
                        data-confirm-title="Delete this maternal care record?"
                        data-confirm-item="{{ $maternalCare->resident?->full_name ?? 'Resident record' }}"
                        class="clay-delete-btn inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12M9 7V4h6v3m-8 0 .7 13h8.6L17 7M10 11v5m4-5v5" />
                        </svg>
                        Delete Record
                    </button>
                </div>
            </div>

            <div class="space-y-6">

                {{-- Resident Card --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                        <div class="clay-icon clay-icon-green h-11 w-11 rounded-xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Resident</p>
                            <h3 class="text-lg font-bold text-[#164238]">
                                {{ $maternalCare->resident?->full_name ?? 'Unknown Resident' }}
                            </h3>
                        </div>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Pregnancy Number</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">#{{ $maternalCare->pregnancy_number }}</p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Status</p>
                            @php
                                $statusClasses = match($maternalCare->pregnancy_status) {
                                    'Pregnant' => 'clay-status-pregnant',
                                    'Delivered' => 'clay-status-delivered',
                                    'Miscarriage' => 'clay-status-miscarriage',
                                    'Stillbirth' => 'clay-status-stillbirth',
                                    'Completed' => 'clay-status-default',
                                    default => 'clay-status-default',
                                };
                            @endphp
                            <span class="{{ $statusClasses }} mt-1 inline-flex items-center gap-1.5 rounded-full px-2.5 py-0.5 text-xs font-bold">
                                <span class="h-1.5 w-1.5 rounded-full bg-current" aria-hidden="true"></span>
                                {{ $maternalCare->pregnancy_status }}
                            </span>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Prenatal Visits</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $maternalCare->prenatal_visit_count ?? 0 }}</p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Last Prenatal Visit</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->last_prenatal_visit?->format('M d, Y') ?? '—' }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Pregnancy Details --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 border-b border-white/70 pb-4">
                        <h3 class="text-base font-bold text-[#164238]">Pregnancy Information</h3>
                        <p class="text-xs text-[#6D817A]">Important pregnancy dates and delivery information.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Last Menstrual Period</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->last_menstrual_period?->format('F d, Y') ?? 'Not recorded' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Expected Delivery Date</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->expected_delivery_date?->format('F d, Y') ?? 'Not recorded' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Actual Delivery Date</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->actual_delivery_date?->format('F d, Y') ?? 'Not recorded' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Delivery Type</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->delivery_type ?: 'Not recorded' }}
                            </p>
                        </div>

                        <div class="clay-inset sm:col-span-2 rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Place of Delivery</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->place_of_delivery ?: 'Not recorded' }}
                            </p>
                        </div>

                        <div class="clay-inset sm:col-span-2 rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Birth Outcome</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->birth_outcome ?: 'Not recorded' }}
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Health & Risk Information --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-5 border-b border-white/70 pb-4">
                        <h3 class="text-base font-bold text-[#164238]">Health &amp; Risk Information</h3>
                        <p class="text-xs text-[#6D817A]">Medical information associated with this pregnancy.</p>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Pregnancy Risk Factors</p>
                            <div class="clay-inset mt-2 rounded-xl p-4 text-sm leading-6 text-[#164238]">
                                {!! nl2br(e($maternalCare->pregnancy_risk_factors ?: 'No risk factors recorded.')) !!}
                            </div>
                        </div>

                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Medical Conditions</p>
                            <div class="clay-inset mt-2 rounded-xl p-4 text-sm leading-6 text-[#164238]">
                                {!! nl2br(e($maternalCare->medical_conditions ?: 'No medical conditions recorded.')) !!}
                            </div>
                        </div>

                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Medications</p>
                            <div class="clay-inset mt-2 rounded-xl p-4 text-sm leading-6 text-[#164238]">
                                {!! nl2br(e($maternalCare->medications ?: 'No medications recorded.')) !!}
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Remarks --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-4 border-b border-white/70 pb-3">
                        <h3 class="text-base font-bold text-[#164238]">Remarks</h3>
                    </div>
                    <p class="whitespace-pre-line text-sm leading-6 text-[#164238]">
                        {{ $maternalCare->remarks ?: 'No remarks recorded.' }}
                    </p>
                </section>

                {{-- Record Metadata --}}
                <section class="clay-card p-5 sm:p-6">
                    <div class="mb-4 border-b border-white/70 pb-3">
                        <h3 class="text-base font-bold text-[#164238]">Record Information</h3>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Created</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->created_at?->format('F d, Y h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Last Updated</p>
                            <p class="mt-1 text-sm font-bold text-[#234E43]">
                                {{ $maternalCare->updated_at?->format('F d, Y h:i A') ?? '—' }}
                            </p>
                        </div>
                    </div>
                </section>

            </div>

            {{-- Delete Form --}}
            <form id="deleteForm" method="POST" action="{{ route('maternal-care.destroy', $maternalCare) }}" class="hidden">
                @csrf
                @method('DELETE')
            </form>

        </div>
    </main>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div
        id="deleteMaternalModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteMaternalModalTitle"
    >
        <div class="clay-confirm-box" role="document">
            <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCEFED] text-[#B42323]">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14a2 2 0 0 0 1.73 3h16.32a2 2 0 0 0 1.73-3l-8.18-14a2 2 0 0 0-3.42 0Z" />
                </svg>
            </div>

            <div class="mt-4">
                <h2 id="deleteMaternalModalTitle" class="text-lg font-bold text-[#164238]">
                    Delete Maternal Record?
                </h2>
                <p class="mt-2 text-sm leading-6 text-[#6D817A]">
                    This action will permanently remove the selected maternal care record. Please confirm that you want to continue.
                </p>
            </div>

            <div class="clay-inset mt-4 rounded-xl p-4">
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">Maternal Record</p>
                <p class="mt-1 break-words text-sm font-bold text-[#164238]">
                    {{ $maternalCare->resident?->full_name ?? 'Resident Record' }}
                </p>
                <p class="mt-1 text-xs font-medium text-[#6D817A]">
                    Pregnancy #{{ $maternalCare->pregnancy_number }} · {{ $maternalCare->pregnancy_status }}
                </p>
            </div>

            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    id="deleteMaternalCancel"
                    class="clay-secondary inline-flex min-h-[42px] items-center justify-center rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="deleteMaternalConfirm"
                    class="clay-primary inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl !bg-gradient-to-r !from-[#DC2626] !to-[#B42323] px-4 py-2.5 text-sm font-bold"
                >
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7h12m-9 0v10m6-10v10M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7m-8 0 .75 12.25A2 2 0 0 0 9.75 21h4.5a2 2 0 0 0 1.99-1.75L17 7" />
                    </svg>
                    Delete Record
                </button>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            /* Sidebar Toggle */
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

            /* Delete Modal */
            const triggerBtn = document.getElementById('triggerDeleteModal');
            const modal = document.getElementById('deleteMaternalModal');
            const cancelBtn = document.getElementById('deleteMaternalCancel');
            const confirmBtn = document.getElementById('deleteMaternalConfirm');
            const deleteForm = document.getElementById('deleteForm');

            if (triggerBtn && modal && cancelBtn && confirmBtn && deleteForm) {
                triggerBtn.addEventListener('click', () => {
                    modal.classList.add('is-open');
                    modal.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                });

                const closeModal = () => {
                    modal.classList.remove('is-open');
                    modal.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                };

                cancelBtn.addEventListener('click', closeModal);
                confirmBtn.addEventListener('click', () => deleteForm.submit());

                modal.addEventListener('click', (e) => {
                    if (e.target === modal) closeModal();
                });
            }
        });
    </script>
</body>
</html>