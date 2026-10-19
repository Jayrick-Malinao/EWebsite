<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Certificates | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage health center and barangay certificates for Barangay Esperanza."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           CERTIFICATE MANAGEMENT
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
        .clay-edit { background: linear-gradient(145deg, #FCF7ED, #F8EED9); color: var(--accent) !important; border-color: rgba(232, 121, 40, 0.14); box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.88); }
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
                            Certificates
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

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Barangay Health Center Services</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Certificate Management
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Issue, manage, and monitor certificates for registered residents of Barangay Esperanza.
                    </p>
                </div>

                <a
                    href="{{ route('certificates.create') }}"
                    class="clay-primary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14" />
                    </svg>
                    Issue Certificate
                </a>
            </div>

            {{-- SUCCESS MESSAGE --}}
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

            {{-- STATS GRID --}}
            <section class="mb-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Total Certificates</p>
                            <p class="mt-2 text-3xl font-bold text-[#164238]">{{ $certificates->total() }}</p>
                        </div>
                        <div class="clay-icon clay-icon-green h-12 w-12 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Issued</p>
                            <p class="mt-2 text-3xl font-bold text-[#126647]">{{ $certificates->getCollection()->where('status', 'Issued')->count() }}</p>
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
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Cancelled</p>
                            <p class="mt-2 text-3xl font-bold text-[#B42323]">{{ $certificates->getCollection()->where('status', 'Cancelled')->count() }}</p>
                        </div>
                        <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCEFED] text-[#B42323]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="clay-card p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">This Page</p>
                            <p class="mt-2 text-3xl font-bold text-[#164238]">{{ $certificates->count() }}</p>
                        </div>
                        <div class="clay-icon h-12 w-12 rounded-2xl bg-[#FCF7ED] text-[#E87928]">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-[#164238]">Certificate Records</h3>
                            <p class="mt-0.5 text-xs text-[#6D817A]">View and manage certificates issued through the health center.</p>
                        </div>
                    </div>

                    <div class="text-xs font-semibold text-[#6D817A]">
                        Showing <span class="font-bold text-[#164238]">{{ $certificates->firstItem() ?? 0 }}</span> - <span class="font-bold text-[#164238]">{{ $certificates->lastItem() ?? 0 }}</span> of <span class="font-bold text-[#164238]">{{ $certificates->total() }}</span>
                    </div>
                </div>

                @if ($certificates->count())
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[900px]">
                            <thead class="clay-table-head">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Certificate No.</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Resident</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Date Issued</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Issued By</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#6D817A]">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($certificates as $certificate)
                                    <tr class="clay-table-row border-b border-[#D2E1DA]/60 last:border-b-0">
                                        <td class="px-6 py-4 font-mono text-xs font-bold text-[#164238]">
                                            {{ $certificate->certificate_number }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="clay-avatar flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-xs font-bold">
                                                    {{ strtoupper(substr($certificate->resident->first_name ?? 'R', 0, 1)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-bold text-[#164238]">
                                                        {{ $certificate->resident->full_name }}
                                                    </p>
                                                    @if ($certificate->resident->household)
                                                        <p class="text-[11px] text-[#6D817A]">
                                                            {{ $certificate->resident->household->household_code }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <p class="text-sm font-bold text-[#234E43]">
                                                {{ $certificate->certificate_type }}
                                            </p>
                                            @if ($certificate->purpose)
                                                <p class="max-w-xs truncate text-[11px] text-[#6D817A]">
                                                    {{ $certificate->purpose }}
                                                </p>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-xs font-bold text-[#234E43]">
                                            {{ $certificate->date_issued?->format('M d, Y') }}
                                        </td>

                                        <td class="px-6 py-4 text-xs text-[#6D817A]">
                                            {{ $certificate->issuer->name ?? 'System' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($certificate->status === 'Issued')
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#126647]/20 bg-[#E7F7EF] px-3 py-1 text-xs font-bold text-[#126647]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#168B70]"></span>
                                                    Issued
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-3 py-1 text-xs font-bold text-[#B42323]">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-[#DC2626]"></span>
                                                    Cancelled
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('certificates.show', $certificate) }}" class="clay-action clay-view">
                                                    View
                                                </a>
                                                <a href="{{ route('certificates.edit', $certificate) }}" class="clay-action clay-edit">
                                                    Edit
                                                </a>

                                                @if ($certificate->status === 'Issued')
                                                    <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this certificate?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="clay-action clay-delete">
                                                            Cancel
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="border-t border-white/70 px-6 py-4">
                        {{ $certificates->links() }}
                    </div>
                @else
                    <div class="px-6 py-16 text-center">
                        <div class="clay-icon clay-icon-green mx-auto h-12 w-12 rounded-2xl">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-base font-bold text-[#164238]">No certificates found</h3>
                        <p class="mt-1 text-xs text-[#6D817A]">No certificates have been issued yet.</p>

                        <a href="{{ route('certificates.create') }}" class="clay-primary mt-4 inline-flex items-center gap-2 rounded-xl px-4 py-2 text-xs font-bold">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Issue First Certificate
                        </a>
                    </div>
                @endif
            </section>

            {{-- MOBILE CARDS --}}
            <section class="space-y-4 lg:hidden">
                @forelse ($certificates as $certificate)
                    <article class="clay-card rounded-[22px] p-5">
                        <div class="flex items-start justify-between border-b border-white/70 pb-3">
                            <div>
                                <p class="font-mono text-xs font-bold text-[#168B70]">{{ $certificate->certificate_number }}</p>
                                <h3 class="mt-1 text-base font-bold text-[#164238]">{{ $certificate->resident->full_name }}</h3>
                                <p class="text-xs text-[#6D817A]">{{ $certificate->certificate_type }}</p>
                            </div>

                            @if ($certificate->status === 'Issued')
                                <span class="inline-flex rounded-full border border-[#126647]/20 bg-[#E7F7EF] px-2.5 py-0.5 text-[11px] font-bold text-[#126647]">
                                    Issued
                                </span>
                            @else
                                <span class="inline-flex rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-2.5 py-0.5 text-[11px] font-bold text-[#B42323]">
                                    Cancelled
                                </span>
                            @endif
                        </div>

                        <div class="mt-3 grid grid-cols-2 gap-3 text-xs">
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Date Issued</p>
                                <p class="mt-1 font-bold text-[#234E43]">{{ $certificate->date_issued?->format('M d, Y') }}</p>
                            </div>

                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Issuer</p>
                                <p class="mt-1 truncate font-bold text-[#234E43]">{{ $certificate->issuer->name ?? 'System' }}</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center gap-2">
                            <a href="{{ route('certificates.show', $certificate) }}" class="clay-action clay-view flex-1 text-center">View</a>
                            <a href="{{ route('certificates.edit', $certificate) }}" class="clay-action clay-edit flex-1 text-center">Edit</a>

                            @if ($certificate->status === 'Issued')
                                <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" class="flex-1" onsubmit="return confirm('Cancel this certificate?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="clay-action clay-delete w-full">Cancel</button>
                                </form>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="clay-card p-8 text-center text-sm font-medium text-[#6D817A]">
                        No certificates found.
                    </div>
                @endforelse

                <div class="mt-4">
                    {{ $certificates->links() }}
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