
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $announcement->title }} | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="View announcement details, recipients, and SMS delivery information."
    >

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
            --text-heading: #234E43;
            --text-muted: #6D817A;
            --danger: #B42323;
            --border-soft: rgba(210, 225, 218, 0.65);
            --border-white: rgba(255, 255, 255, 0.90);
            --shadow-dark: rgba(107, 134, 124, 0.18);
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
                radial-gradient(circle at 0% 0%, rgba(255,255,255,.92), transparent 34%),
                radial-gradient(circle at 100% 0%, rgba(22,139,112,.055), transparent 32%),
                linear-gradient(135deg, #EEF5F1 0%, #F5FAF7 52%, #EDF5F0 100%);
        }

        ::selection { color: #FFFFFF; background: var(--primary-dark); }

        .clay-header {
            background: rgba(245,250,247,.94);
            border-bottom: 1px solid rgba(255,255,255,.92);
            box-shadow: 0 5px 18px rgba(107,134,124,.08);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-mobile-button,
        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107,134,124,.14),
                        -4px -4px 9px rgba(255,255,255,.92);
            transition: transform .18s ease, filter .18s ease;
        }

        .clay-mobile-button:hover,
        .clay-secondary:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
        }

        .clay-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255,255,255,.84);
            box-shadow: 4px 4px 9px rgba(107,134,124,.12),
                        -4px -4px 9px rgba(255,255,255,.88);
        }

        .clay-category { color: var(--primary); letter-spacing: .08em; }
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
        }

        .clay-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow: 8px 8px 18px var(--shadow-dark),
                        -8px -8px 18px var(--shadow-light),
                        inset 1px 1px 0 rgba(255,255,255,.84);
            border-radius: 24px;
        }

        .clay-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255,255,255,.86);
            box-shadow: inset 3px 3px 7px rgba(107,134,124,.10),
                        inset -3px -3px 7px rgba(255,255,255,.82);
        }

        .clay-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,.86);
            box-shadow: 4px 4px 9px rgba(107,134,124,.12),
                        -4px -4px 9px rgba(255,255,255,.88);
        }

        .clay-icon-green {
            background: linear-gradient(145deg, #E7F5EE, #D9ECE4);
            color: var(--primary-dark);
        }

        .clay-table {
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 26px;
            box-shadow: 8px 8px 18px rgba(107,134,124,.18),
                        -8px -8px 18px rgba(255,255,255,.92);
        }

        .clay-table-head {
            background: linear-gradient(180deg, rgba(235,244,239,.98), rgba(226,238,232,.96));
        }

        .clay-table-row {
            background: rgba(255,255,255,.48);
            transition: background .18s ease;
        }

        .clay-table-row:hover { background: rgba(255,255,255,.78); }

        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255,255,255,.20);
            box-shadow: 5px 5px 12px rgba(15,76,58,.22),
                        -4px -4px 10px rgba(255,255,255,.55);
            transition: transform .18s ease, filter .18s ease;
        }

        .clay-primary:hover:not(:disabled) {
            transform: translateY(-1px);
            filter: brightness(1.04);
        }

        .clay-primary:disabled {
            cursor: not-allowed;
            opacity: .55;
            box-shadow: none;
        }

        .clay-alert {
            border: 1px solid rgba(255,255,255,.88);
            border-radius: 18px;
            box-shadow: 5px 5px 12px rgba(107,134,124,.10),
                        -4px -4px 10px rgba(255,255,255,.85);
        }

        @media (max-width: 1023px) {
            .clay-heading-accent { display: none; }
            main { padding-left: 0; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body class="clay-households antialiased">

    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-[#164238]/40 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    @include('dashboard.sidebar')

    <main class="min-h-screen lg:pl-72">

        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                        aria-controls="sidebar-overlay"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-category text-xs font-bold uppercase tracking-wider">
                            System Administrator
                        </p>
                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Announcement Details
                        </h1>
                    </div>
                </div>

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

        <div class="mx-auto max-w-[1600px] space-y-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- Session feedback --}}
            @foreach ([
                'success' => ['bg' => 'bg-[#E7F7EF]', 'text' => 'text-[#126647]', 'title' => 'Success'],
                'error' => ['bg' => 'bg-[#FCEFED]', 'text' => 'text-[#B42323]', 'title' => 'Error'],
                'warning' => ['bg' => 'bg-[#FCF7ED]', 'text' => 'text-[#9A5A12]', 'title' => 'Warning'],
                'info' => ['bg' => 'bg-[#EAF3FA]', 'text' => 'text-[#245A83]', 'title' => 'Information'],
            ] as $sessionKey => $alert)
                @if (session()->has($sessionKey))
                    <div class="clay-alert {{ $alert['bg'] }} p-4 {{ $alert['text'] }}" role="alert">
                        <p class="text-sm font-bold">{{ $alert['title'] }}</p>
                        <p class="mt-1 text-sm">{{ session($sessionKey) }}</p>
                    </div>
                @endif
            @endforeach

            @php
                $targetLabels = [
                    'specific' => 'Specific Resident',
                    'senior' => 'Senior Citizens',
                    'children' => 'Children',
                    'pregnant' => 'Pregnant Residents',
                    'general' => 'General',
                    'age_bracket' => 'Age Bracket',
                ];

                $smsDeliveries = $announcement->smsDeliveries;
                $pendingCount = $smsDeliveries->where('status', 'Pending')->count();
                $sentCount = $smsDeliveries->where('status', 'Sent')->count();
                $failedCount = $smsDeliveries->where('status', 'Failed')->count();
                $smsEnabled = (bool) config('services.semaphore.enabled', false);
            @endphp

            {{-- Page heading and actions --}}
            <div class="flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>

                    <span class="clay-inset mb-2 inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold text-[#126647]">
                        <span class="h-2 w-2 rounded-full bg-[#168B70]"></span>
                        {{ $announcement->status }}
                    </span>

                    <h2 class="clay-title mt-1 break-words text-2xl font-bold tracking-tight sm:text-3xl">
                        {{ $announcement->title }}
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Review the announcement message, target audience, recipients, and SMS processing records.
                    </p>
                </div>

                <div class="flex flex-col gap-3 sm:flex-row">
                    <a
                        href="{{ route('announcements.index') }}"
                        class="clay-secondary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                    >
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
                        </svg>
                        Back to Announcements
                    </a>
                </div>
            </div>

            {{-- SMS disabled notice --}}
            @unless ($smsEnabled)
                <section class="clay-alert bg-[#FCF7ED] p-5" role="status">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon h-10 w-10 rounded-xl bg-[#F8E9CB] text-[#9A5A12]">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.29 3.86 1.82 18.14A1.5 1.5 0 003.11 20.4h16.98a1.5 1.5 0 001.29-2.26L12.91 3.86a1.5 1.5 0 00-2.62 0Z"/>
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <h3 class="text-sm font-bold text-[#80500F]">SMS sending is currently disabled</h3>
                            <p class="mt-1 text-sm leading-6 text-[#80500F]">
                                No real SMS messages can be sent while
                                <code class="rounded bg-white/70 px-1.5 py-0.5">SEMAPHORE_SMS_ENABLED=false</code>.
                                Pending records are preserved. Enable sending only after confirming your Semaphore account, credits, and sender name are ready.
                            </p>
                        </div>
                    </div>
                </section>
            @endunless

            {{-- Statistics --}}
            <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-5">

                <div class="clay-card p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Priority</p>
                    <div class="mt-3">
                        @if ($announcement->priority === 'Urgent')
                            <span class="inline-flex rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-3 py-1 text-xs font-bold text-[#B42323]">Urgent</span>
                        @elseif ($announcement->priority === 'Important')
                            <span class="inline-flex rounded-full border border-[#E87928]/20 bg-[#FCF7ED] px-3 py-1 text-xs font-bold text-[#9A5A12]">Important</span>
                        @else
                            <span class="inline-flex rounded-full border border-[#6D817A]/20 bg-[#EDF5F0] px-3 py-1 text-xs font-bold text-[#385C52]">Normal</span>
                        @endif
                    </div>
                </div>

                <div class="clay-card p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Residents</p>
                    <p class="mt-2 text-2xl font-bold text-[#164238]">{{ $announcement->recipients->count() }}</p>
                    <p class="mt-1 text-[11px] text-[#6D817A]">Qualifying recipients</p>
                </div>

                <div class="clay-card p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">SMS Pending</p>
                    <p class="mt-2 text-2xl font-bold text-[#9A5A12]">{{ $pendingCount }}</p>
                    <p class="mt-1 text-[11px] text-[#6D817A]">Awaiting processing</p>
                </div>

                <div class="clay-card p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">SMS Accepted</p>
                    <p class="mt-2 text-2xl font-bold text-[#126647]">{{ $sentCount }}</p>
                    <p class="mt-1 text-[11px] text-[#6D817A]">Accepted by the API</p>
                </div>

                <div class="clay-card p-5">
                    <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">SMS Failed</p>
                    <p class="mt-2 text-2xl font-bold text-[#B42323]">{{ $failedCount }}</p>
                    <p class="mt-1 text-[11px] text-[#6D817A]">Needs review</p>
                </div>

            </section>

            {{-- Main layout --}}
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

                <div class="space-y-6 xl:col-span-2">

                    {{-- Announcement message --}}
                    <section class="clay-card p-6">
                        <div class="mb-4 flex items-center gap-3 border-b border-white/70 pb-3">
                            <div class="clay-icon clay-icon-green h-9 w-9 rounded-xl">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-5a2 2 0 00-2 2v9a2 2 0 002 2h5z"/>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-[#164238]">Announcement Message</h3>
                                <p class="text-xs text-[#6D817A]">The announcement content.</p>
                            </div>
                        </div>

                        <div class="clay-inset rounded-2xl p-5">
                            <p class="whitespace-pre-line break-words text-sm leading-7 text-[#234E43]">{{ $announcement->message }}</p>
                        </div>
                    </section>

                    {{-- SMS delivery management --}}
                    <section class="clay-card p-6" id="sms-deliveries">
                        <div class="flex flex-col gap-4 border-b border-white/70 pb-4 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8m-8 4h5m-9 5 1.5-3H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v9a2 2 0 01-2 2h-5l-4 3H4z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">SMS Delivery Log</h3>
                                    <p class="text-xs text-[#6D817A]">SMS records for household heads.</p>
                                </div>
                            </div>

                            <form
                                method="POST"
                                action="{{ route('announcements.sms.send', $announcement) }}"
                                onsubmit="return confirm('Process all pending SMS records for this announcement? Verify the recipients and message before continuing.');"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="clay-primary inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                                    @disabled(!$smsEnabled || $pendingCount === 0)
                                    title="{{ !$smsEnabled ? 'SMS sending is disabled in the application configuration.' : ($pendingCount === 0 ? 'There are no pending SMS records.' : 'Process pending SMS records.') }}"
                                >
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 12l16-8-5 16-3-6-8-2Zm8 2 5-5"/>
                                    </svg>
                                    Send Pending SMS
                                </button>
                            </form>
                        </div>

                        <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-3">
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Pending</p>
                                <p class="mt-1 text-xl font-bold text-[#9A5A12]">{{ $pendingCount }}</p>
                            </div>
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Accepted</p>
                                <p class="mt-1 text-xl font-bold text-[#126647]">{{ $sentCount }}</p>
                            </div>
                            <div class="clay-inset rounded-xl p-3">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Failed</p>
                                <p class="mt-1 text-xl font-bold text-[#B42323]">{{ $failedCount }}</p>
                            </div>
                        </div>

                        <p class="mt-4 text-xs leading-5 text-[#6D817A]">
                            An accepted SMS means the provider accepted the request; it does not independently confirm delivery to the recipient's phone.
                        </p>

                        @if ($smsDeliveries->count())
                            <div class="mt-5 space-y-3">
                                @foreach ($smsDeliveries as $delivery)
                                    <article class="clay-inset rounded-2xl p-4">
                                        <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
                                            <div class="min-w-0">
                                                <p class="break-words text-sm font-bold text-[#164238]">
                                                    {{ $delivery->householdHead?->full_name ?? 'Household Head' }}
                                                </p>

                                                <p class="mt-1 text-xs font-semibold text-[#6D817A]">
                                                    {{ $delivery->contact_number ?: 'No contact number recorded' }}
                                                </p>

                                                @if ($delivery->household)
                                                    <p class="mt-1 text-[11px] text-[#9AA9A4]">
                                                        Household: {{ $delivery->household->household_code }}
                                                    </p>
                                                @endif
                                            </div>

                                            <div class="shrink-0 sm:text-right">
                                                @if ($delivery->status === 'Sent')
                                                    <span class="inline-flex rounded-full border border-[#126647]/20 bg-[#E7F7EF] px-3 py-1 text-xs font-bold text-[#126647]">
                                                        Accepted
                                                    </span>
                                                @elseif ($delivery->status === 'Failed')
                                                    <span class="inline-flex rounded-full border border-[#B42323]/20 bg-[#FCEFED] px-3 py-1 text-xs font-bold text-[#B42323]">
                                                        Failed
                                                    </span>
                                                @else
                                                    <span class="inline-flex rounded-full border border-[#E87928]/20 bg-[#FCF7ED] px-3 py-1 text-xs font-bold text-[#9A5A12]">
                                                        Pending
                                                    </span>
                                                @endif

                                                @if ($delivery->sent_at)
                                                    <p class="mt-2 text-[11px] text-[#6D817A]">
                                                        {{ $delivery->sent_at->format('M d, Y h:i A') }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>

                                        @if ($delivery->failure_reason)
                                            <div class="mt-3 rounded-xl border border-[#B42323]/10 bg-[#FCEFED]/70 p-3">
                                                <p class="text-[10px] font-bold uppercase tracking-wider text-[#B42323]">
                                                    Processing details
                                                </p>
                                                <p class="mt-1 break-words text-xs leading-5 text-[#8F2929]">
                                                    {{ $delivery->failure_reason }}
                                                </p>
                                            </div>
                                        @endif
                                    </article>
                                @endforeach
                            </div>
                        @else
                            <div class="clay-inset mt-5 rounded-2xl p-8 text-center">
                                <div class="clay-icon mx-auto h-12 w-12 rounded-2xl text-[#6D817A]">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8m-8 4h5m-9 5 1.5-3H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-5l-4 3H4z"/>
                                    </svg>
                                </div>
                                <p class="mt-3 text-sm font-bold text-[#234E43]">No SMS delivery records</p>
                                <p class="mt-1 text-xs text-[#6D817A]">
                                    No household SMS records have been created for this announcement.
                                </p>
                            </div>
                        @endif
                    </section>

                    {{-- Resident recipients --}}
                    <section class="clay-table">
                        <div class="flex flex-col gap-3 border-b border-white/70 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                            <div class="flex items-center gap-3">
                                <div class="clay-icon h-10 w-10 rounded-xl bg-[#E8F6EF] text-[#168B70]">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base font-bold text-[#164238]">Resident Recipients</h3>
                                    <p class="text-xs text-[#6D817A]">Individual residents included in the announcement.</p>
                                </div>
                            </div>

                            <span class="clay-inset rounded-full px-3 py-1 text-xs font-bold text-[#164238]">
                                {{ $announcement->recipients->count() }} recipients
                            </span>
                        </div>

                        @if ($announcement->recipients->count())
                            <div class="overflow-x-auto">
                                <table class="w-full min-w-[600px]">
                                    <thead class="clay-table-head">
                                        <tr>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Resident</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Household</th>
                                            <th scope="col" class="px-6 py-3.5 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">Read Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($announcement->recipients as $recipient)
                                            @php
                                                $resident = $recipient->resident;
                                                $household = $resident?->household;
                                            @endphp

                                            <tr class="clay-table-row border-b border-[#D2E1DA]/60 last:border-b-0">
                                                <td class="px-6 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <div class="clay-avatar flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-xs font-bold">
                                                            {{ strtoupper(substr($resident?->first_name ?? 'R', 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-sm font-bold text-[#164238]">
                                                                {{ $resident?->full_name ?? 'Unknown Resident' }}
                                                            </p>
                                                            @if ($resident?->is_household_head)
                                                                <span class="text-[11px] font-bold text-[#168B70]">Household Head</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="px-6 py-4">
                                                    @if ($household)
                                                        <p class="text-xs font-bold text-[#234E43]">{{ $household->household_code }}</p>
                                                        <p class="text-[11px] text-[#6D817A]">{{ $household->household_head_name ?? 'Household' }}</p>
                                                    @else
                                                        <span class="text-xs text-[#9AA9A4]">No household</span>
                                                    @endif
                                                </td>

                                                <td class="px-6 py-4">
                                                    @if ($recipient->read_at)
                                                        <span class="inline-flex rounded-full border border-[#126647]/20 bg-[#E7F7EF] px-2.5 py-1 text-xs font-bold text-[#126647]">
                                                            Read
                                                        </span>
                                                        <p class="mt-1 text-[11px] text-[#6D817A]">
                                                            {{ $recipient->read_at->format('M d, Y h:i A') }}
                                                        </p>
                                                    @else
                                                        <span class="inline-flex rounded-full border border-[#6D817A]/20 bg-[#EDF5F0] px-2.5 py-1 text-xs font-bold text-[#385C52]">
                                                            Unread
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="p-8 text-center text-xs font-bold text-[#6D817A]">
                                No recipients associated with this announcement.
                            </div>
                        @endif
                    </section>

                </div>

                {{-- Right sidebar --}}
                <aside class="space-y-6">

                    <section class="clay-card space-y-4 p-6">
                        <div class="border-b border-white/70 pb-3">
                            <h3 class="text-base font-bold text-[#164238]">Announcement Info</h3>
                            <p class="text-xs text-[#6D817A]">Publication metadata.</p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Target Audience</p>
                            <p class="mt-1 text-xs font-bold text-[#234E43]">
                                {{ $targetLabels[$announcement->target_type] ?? $announcement->target_type }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Status</p>
                            <p class="mt-1 text-xs font-bold text-[#126647]">{{ $announcement->status }}</p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Created By</p>
                            <p class="mt-1 break-words text-xs font-bold text-[#234E43]">
                                {{ $announcement->creator?->name ?? 'System Administrator' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Created At</p>
                            <p class="mt-1 text-xs font-bold text-[#234E43]">
                                {{ $announcement->created_at?->format('M d, Y h:i A') ?? '—' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-xl p-3.5">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Published At</p>
                            <p class="mt-1 text-xs font-bold text-[#234E43]">
                                {{ $announcement->published_at?->format('M d, Y h:i A') ?? 'Not published' }}
                            </p>
                        </div>
                    </section>

                    <section class="clay-card p-6">
                        <div class="mb-3 border-b border-white/70 pb-3">
                            <h3 class="text-base font-bold text-[#164238]">Target Criteria</h3>
                            <p class="text-xs text-[#6D817A]">Rules used for recipient selection.</p>
                        </div>

                        <div class="clay-inset rounded-xl p-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Type</p>
                            <p class="mt-1 text-sm font-bold text-[#164238]">
                                {{ $targetLabels[$announcement->target_type] ?? $announcement->target_type }}
                            </p>

                            @if ($announcement->target_type === 'age_bracket')
                                <p class="mt-2 text-xs font-bold text-[#168B70]">
                                    Ages {{ $announcement->min_age }} to {{ $announcement->max_age }} years old
                                </p>
                            @elseif ($announcement->target_type === 'children')
                                <p class="mt-2 text-xs font-bold text-[#168B70]">
                                    Ages {{ $announcement->min_age ?? 0 }} to {{ $announcement->max_age ?? 5 }} years old
                                </p>
                            @endif
                        </div>
                    </section>

                </aside>

            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (menuButton && overlay && sidebar) {
                const openSidebar = () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                    menuButton.setAttribute('aria-expanded', 'true');
                    overlay.setAttribute('aria-hidden', 'false');
                };

                const closeSidebar = () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                    menuButton.setAttribute('aria-expanded', 'false');
                    overlay.setAttribute('aria-hidden', 'true');
                };

                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.addEventListener('click', () => {
                    if (overlay.classList.contains('hidden')) {
                        openSidebar();
                    } else {
                        closeSidebar();
                    }
                });

                overlay.addEventListener('click', closeSidebar);

                document.addEventListener('keydown', event => {
                    if (event.key === 'Escape') {
                        closeSidebar();
                    }
                });
            }
        });
    </script>
</body>
</html>
