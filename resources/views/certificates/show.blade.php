<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $certificate->certificate_number }} | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="View certificate details for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           CERTIFICATE DETAILS
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
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.94);
            transition: transform 0.18s ease, background 0.18s ease;
        }
        .clay-secondary:hover { transform: translateY(-1px); background: linear-gradient(145deg, #FFFFFF, #EEF6F2); }

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
                            Certificate Details
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
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8 space-y-6">

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="clay-card rounded-2xl border-l-4 border-l-[#168B70] p-4 text-sm text-[#0F6F5A]">
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

            {{-- HEADER & ACTIONS --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Certificate Record</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ $certificate->certificate_type }}
                    </h2>

                    <p class="mt-1 font-mono text-sm font-bold text-[#168B70]">
                        {{ $certificate->certificate_number }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('certificates.edit', $certificate) }}" class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                        Edit
                    </a>

                    <a href="{{ route('certificates.print', $certificate) }}" target="_blank" rel="noopener" class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m11.32-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.592 0-1.082-.456-1.12-1.047L6.34 18m11.32 0H6.34m0 0L5.34 10.5M17.66 18l1-7.5M18.75 10.5h.008v.008h-.008V10.5Zm-13.5 0h.008v.008H5.25V10.5Z" />
                        </svg>
                        Print Certificate
                    </a>
                </div>
            </div>

            {{-- METADATA CARD --}}
            <section class="clay-card p-6">
                <div class="flex items-center justify-between border-b border-white/70 pb-4 mb-4">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Official Details</p>
                    @if ($certificate->status === 'Issued')
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#126647]/20 bg-[#E7F7EF] px-3 py-1 text-xs font-bold text-[#126647]">
                            <span class="h-2 w-2 rounded-full bg-[#168B70]"></span>
                            Issued
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-3 py-1 text-xs font-bold text-[#B42323]">
                            <span class="h-2 w-2 rounded-full bg-[#DC2626]"></span>
                            Cancelled
                        </span>
                    @endif
                </div>

                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="clay-inset rounded-xl p-3.5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Certificate Number</p>
                        <p class="mt-1 font-mono text-sm font-bold text-[#164238]">{{ $certificate->certificate_number }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3.5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Certificate Type</p>
                        <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $certificate->certificate_type }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3.5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Date Issued</p>
                        <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $certificate->date_issued?->format('F d, Y') }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3.5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Issued By</p>
                        <p class="mt-1 text-sm font-bold text-[#234E43]">{{ $certificate->issuer->name ?? 'System' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3.5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Created At</p>
                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $certificate->created_at?->format('F d, Y h:i A') }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3.5">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Last Updated</p>
                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $certificate->updated_at?->format('F d, Y h:i A') }}</p>
                    </div>
                </div>
            </section>

            {{-- RESIDENT INFO CARD --}}
            <section class="clay-card p-6">
                <div class="mb-5 flex items-center gap-3 border-b border-white/70 pb-4">
                    <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-[#164238]">Resident Information</h3>
                        <p class="text-xs text-[#6D817A]">Registered resident associated with this certificate.</p>
                    </div>
                </div>

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
                    <div class="clay-avatar flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl text-xl font-bold">
                        {{ strtoupper(substr($certificate->resident->first_name ?? 'R', 0, 1)) }}
                    </div>

                    <div>
                        <h3 class="text-xl font-bold text-[#164238]">{{ $certificate->resident->full_name }}</h3>
                        @if ($certificate->resident->household)
                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                Household: <span class="font-bold text-[#164238]">{{ $certificate->resident->household->household_code }}</span>
                            </p>
                        @endif
                    </div>
                </div>

                <div class="mt-6 grid gap-4 border-t border-white/70 pt-5 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="clay-inset rounded-xl p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Birth Date</p>
                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $certificate->resident->birth_date?->format('F d, Y') ?? 'Not provided' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Gender</p>
                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $certificate->resident->gender ?? 'Not provided' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Civil Status</p>
                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $certificate->resident->civil_status ?? 'Not provided' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Contact Number</p>
                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($certificate->resident->contact_number) ?? 'Not provided' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-3 sm:col-span-2">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Address</p>
                        <p class="mt-1 text-xs font-bold leading-5 text-[#234E43]">{{ $certificate->resident->household_address ?? $certificate->resident->household?->address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </section>

            {{-- ISSUANCE INFO CARD --}}
            <section class="clay-card p-6">
                <div class="mb-4 border-b border-white/70 pb-3">
                    <h3 class="text-base font-bold text-[#164238]">Issuance Information</h3>
                    <p class="text-xs text-[#6D817A]">Additional details and notes for this record.</p>
                </div>

                <div class="space-y-4">
                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Purpose</p>
                        <p class="mt-1 text-xs leading-6 text-[#234E43]">{{ $certificate->purpose ?: 'No purpose specified.' }}</p>
                    </div>

                    <div class="clay-inset rounded-xl p-4">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Remarks</p>
                        <p class="mt-1 whitespace-pre-line text-xs leading-6 text-[#234E43]">{{ $certificate->remarks ?: 'No additional remarks.' }}</p>
                    </div>
                </div>
            </section>

            {{-- BOTTOM ACTIONS --}}
            <div class="clay-card flex flex-col gap-3 p-5 sm:flex-row sm:items-center sm:justify-between">
                <a href="{{ route('certificates.index') }}" class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Back to Certificates
                </a>

                <div class="flex flex-col gap-2 sm:flex-row">
                    @if ($certificate->status === 'Issued')
                        <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" data-confirm-title="Cancel this certificate?" data-confirm-message="The certificate will be canceled and its status updated." data-confirm-item="{{ $certificate->certificate_number }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="clay-secondary inline-flex min-h-[44px] w-full sm:w-auto items-center justify-center gap-2 rounded-xl border-red-200 !text-[#B42323] px-5 py-2.5 text-sm font-bold" data-confirm-button="Cancel certificate">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Cancel Certificate
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('certificates.print', $certificate) }}" target="_blank" rel="noopener" class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m11.32-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.592 0-1.082-.456-1.12-1.047L6.34 18m11.32 0H6.34m0 0L5.34 10.5M17.66 18l1-7.5M18.75 10.5h.008v.008h-.008V10.5Zm-13.5 0h.008v.008H5.25V10.5Z" />
                        </svg>
                        Print Certificate
                    </a>
                </div>
            </div>

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