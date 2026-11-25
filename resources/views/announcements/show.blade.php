<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} | Announcements</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#EEF5F1] text-[#164238]">
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-[#164238]/40 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    @include('dashboard.sidebar')

    <main class="min-h-screen lg:pl-72">
        <header class="sticky top-0 z-30 border-b border-white/80 bg-[#F8FCFA]/95 shadow-sm backdrop-blur">
            <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-[#D2E1DA] bg-white text-[#0F6F5A] lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="min-w-0">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168B70]">Communication</p>
                        <h1 class="mt-1 truncate text-lg font-bold text-[#164238]">Announcement details</h1>
                    </div>
                </div>

                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')
                    <div class="hidden text-right sm:block">
                        <p class="max-w-40 truncate text-sm font-bold text-[#164238]">{{ auth()->user()->name }}</p>
                        <p class="text-xs font-medium text-[#6D817A]">{{ auth()->user()->role ?? 'Staff' }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-white bg-[#E6F4EE] text-sm font-bold text-[#0F6F5A]">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-[1600px] space-y-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
    <div class="space-y-6">
        <nav class="flex justify-end" aria-label="Breadcrumb">
            <a href="{{ route('announcements.index') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-white bg-[#F8FCFA] px-4 py-2.5 text-sm font-bold text-[#0F6F5A] shadow-sm transition hover:bg-[#E4F3EC] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#168B70]">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5m7-7-7 7 7 7" />
                </svg>
                Back to announcements
            </a>
        </nav>

        @foreach (['success', 'error', 'warning', 'info'] as $type)
            @if (session($type))
                <div
                    class="rounded-xl border px-4 py-3 text-sm font-medium {{ $type === 'error' || $type === 'warning' ? 'border-red-200 bg-red-50 text-red-800' : 'border-green-200 bg-green-50 text-green-800' }}"
                    role="status"
                >
                    {{ session($type) }}
                </div>
            @endif
        @endforeach

        @php
            $targetLabels = [
                'specific' => 'Specific resident',
                'senior' => 'Senior citizens',
                'children' => 'Children',
                'pregnant' => 'Pregnant residents',
                'postnatal' => 'Postnatal residents',
                'general' => 'All active residents',
                'age_bracket' => 'Age bracket',
            ];
            $targetLabel = $targetLabels[$announcement->target_type]
                ?? ucwords(str_replace('_', ' ', $announcement->target_type));
            $smsDeliveries = $announcement->smsDeliveries;
            $preparedSmsCount = $smsDeliveries->where('status', 'Prepared')->count();
            $retryingSmsCount = $smsDeliveries->where('status', 'Pending')->where('provider_status', 'retrying')->count();
            $pendingSmsCount = $smsDeliveries->where('status', 'Pending')->count() - $retryingSmsCount;
            $deliveredSmsCount = $smsDeliveries->where('status', 'Delivered')->count();
            $failedSmsCount = $smsDeliveries->where('status', 'Failed')->count();
            $providerSentSmsCount = $smsDeliveries->where('status', 'Unknown')->where('provider_status', 'sent')->count();
            $unknownSmsCount = $smsDeliveries->where('status', 'Unknown')->count() - $providerSentSmsCount;
            $canCancel = $smsDeliveries->every(fn ($delivery) => $delivery->status === 'Prepared' && $delivery->attempt_started_at === null);
            $allSmsSubmitted = $smsDeliveries->isNotEmpty() && $smsDeliveries->every(fn ($delivery) =>
                ($delivery->sent_at !== null && in_array($delivery->status, ['Pending', 'Delivered'], true))
                || ($delivery->status === 'Unknown' && $delivery->provider_status === 'sent')
            );
        @endphp

        <section class="overflow-hidden rounded-3xl border border-white bg-gradient-to-br from-[#F8FCFA] to-[#EAF2EE] p-6 shadow-[0_8px_24px_rgba(107,134,124,0.12)] sm:p-8">
            <p class="mb-4 text-xs font-bold uppercase tracking-[0.16em] text-[#168B70]">Announcement details</p>
            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-full bg-[#E4F3EC] px-3 py-1 text-xs font-bold text-[#0F6F5A]">
                    {{ $announcement->status }}
                </span>
                <span class="rounded-full bg-[#EDF5F0] px-3 py-1 text-xs font-bold text-[#385C52]">
                    {{ $announcement->priority }} priority
                </span>
            </div>

            <h2 class="mt-5 text-2xl font-bold leading-tight text-[#164238] sm:text-3xl">
                {{ $announcement->title }}
            </h2>

            <div class="mt-6 rounded-2xl border border-white/80 bg-white/60 p-5 sm:p-6">
                <p class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Message</p>
                <p class="mt-3 whitespace-pre-line break-words text-base leading-7 text-[#385C52]">{{ $announcement->message }}</p>
            </div>

            <dl class="mt-8 grid gap-4 border-t border-[#D2E1DA] pt-6 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Audience</dt>
                    <dd class="mt-1 text-sm font-semibold">{{ $targetLabel }}</dd>
                    @if (in_array($announcement->target_type, ['children', 'age_bracket'], true) && ! is_null($announcement->min_age) && ! is_null($announcement->max_age))
                        <dd class="mt-1 text-xs text-[#6D817A]">Ages {{ $announcement->min_age }}–{{ $announcement->max_age }}</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Recipients</dt>
                    <dd class="mt-1 text-sm font-semibold">{{ $announcement->recipients->count() }} residents &middot; {{ $smsDeliveries->count() }} SMS recipients</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Published</dt>
                    <dd class="mt-1 text-sm font-semibold">{{ $announcement->published_at?->format('M d, Y h:i A') ?? 'Not published' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Created by</dt>
                    <dd class="mt-1 text-sm font-semibold">{{ $announcement->creator?->name ?? 'Unknown' }}</dd>
                </div>
            </dl>
            @if ($announcement->target_type === 'specific')
                <div class="mt-6 border-t border-[#D2E1DA] pt-5">
                    <h3 class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Selected residents</h3>
                    <ul class="mt-3 flex flex-wrap gap-2">
                        @foreach ($announcement->recipients as $recipient)
                            <li class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-[#385C52]">
                                {{ $recipient->resident?->full_name ?? 'Resident unavailable' }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>

        <section class="rounded-3xl border border-white bg-[#F8FCFA] p-6 shadow-[0_8px_24px_rgba(107,134,124,0.12)] sm:p-8" aria-labelledby="sms-information">
            <div class="flex items-start gap-4">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-[#E4F3EC] text-[#0F6F5A]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 17v-5m0-4h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </span>
            <div>
                <h2 id="sms-information" class="text-lg font-bold text-[#164238]">SMS delivery information</h2>
                @if ($smsDeliveries->isEmpty())
                    <p class="mt-2 text-sm leading-6 text-[#385C52]">No SMS messages have been prepared for this announcement.</p>
                @else
                    <p class="mt-2 text-sm leading-6 text-[#385C52]">
                        UniSMS reports {{ $providerSentSmsCount }} message{{ $providerSentSmsCount === 1 ? '' : 's' }} sent;
                        {{ $deliveredSmsCount }} confirmed delivered out of {{ $smsDeliveries->count() }} total.
                        @if ($providerSentSmsCount > 0)
                            Handset delivery is not confirmed for messages reported as sent.
                        @endif
                        @if ($pendingSmsCount > 0)
                            Handset delivery may still be unconfirmed.
                        @endif
                    </p>
                    @if ($preparedSmsCount + $pendingSmsCount + $retryingSmsCount + $failedSmsCount + $unknownSmsCount > 0)
                        <p class="mt-1 text-sm leading-6 text-[#6D817A]">
                            Prepared: {{ $preparedSmsCount }} &middot; Pending: {{ $pendingSmsCount }} &middot;
                            Retrying: {{ $retryingSmsCount }} &middot; Failed: {{ $failedSmsCount }} &middot;
                            Unknown: {{ $unknownSmsCount }}.
                        </p>
                    @endif
                @endif
            </div>

            </div>

            <div class="mt-6 rounded-2xl border border-[#D2E1DA] bg-[#EDF5F0] p-5">
                <h3 class="text-base font-bold text-[#164238]">Confirm SMS sending</h3>
                <p class="mt-2 text-sm leading-6 text-[#385C52]">Double-check the announcement, audience, and recipient count above before clicking Send. Publishing has already notified system users; SMS messages are sent separately.</p>
                @if ($allSmsSubmitted)
                    <p class="mt-3 text-sm text-[#6D817A]"> Announcement(s) are  submitted to successfully!  </p>
                @elseif (! $smsEnabled)
                    <p class="mt-3 text-sm text-amber-800" role="status">SMS sending is disabled. Enable and configure the SMS service before sending.</p>
                @elseif (! $smsConfigured)
                    <p class="mt-3 text-sm text-amber-800" role="status">The SMS service is missing its secret key or sender ID.</p>
                @elseif ($smsDeliveries->isEmpty())
                    <p class="mt-3 text-sm text-[#6D817A]">There are no eligible SMS recipients for this announcement.</p>
                @elseif ($preparedSmsCount === 0)
                    <p class="mt-3 text-sm text-amber-800">No messages are ready to send. Check the SMS status above before taking further action.</p>
                @endif
                <div class="mt-5 flex flex-wrap gap-3">
                    @if ($canCancel)
                        <form method="POST" action="{{ route('announcements.cancel', $announcement) }}" onsubmit="return confirm('Cancel and remove this announcement and its prepared SMS messages? System users may already have seen its notification.');">
                            @csrf
                            <button type="submit" class="rounded-xl border border-[#C7DCD1] bg-white px-5 py-3 text-sm font-bold text-[#385C52] hover:bg-[#F8FCFA] focus:outline-none focus:ring-2 focus:ring-[#168B70] focus:ring-offset-2">Cancel</button>
                        </form>
                    @endif
                    @if ($smsEnabled && $smsConfigured && $preparedSmsCount > 0)
                        <form method="POST" action="{{ route('announcements.sms.send', $announcement) }}" onsubmit="return confirm('Send the prepared SMS messages for this announcement?');">
                            @csrf
                            <button type="submit" class="rounded-xl bg-[#168B70] px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#0F6F5A] focus:outline-none focus:ring-2 focus:ring-[#168B70] focus:ring-offset-2">Send {{ $preparedSmsCount }} SMS</button>
                        </form>
                    @else
                        <button type="button" disabled class="cursor-not-allowed rounded-xl bg-[#D2E1DA] px-5 py-3 text-sm font-bold text-[#6D817A]">{{ $allSmsSubmitted ? 'Sent' : 'Send' }}</button>
                    @endif
                </div>
            </div>

        </section>

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
