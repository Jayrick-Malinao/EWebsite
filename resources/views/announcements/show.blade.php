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
            $statusCheckCandidates = $smsDeliveries->whereIn('status', ['Pending', 'Unknown'])->filter(fn ($delivery) => $delivery->provider_status !== 'sent');
            $checkableSmsCount = $statusCheckCandidates->filter(fn ($delivery) => $smsService->isValidReference($delivery->provider_reference))->count();
            $missingReferenceCount = $smsSyncOverview['missing'];
            $invalidReferenceCount = $smsSyncOverview['invalid'];
            $lastStatusUpdate = $smsDeliveries->whereNotNull('status_checked_at')->sortByDesc('status_checked_at')->first()?->status_checked_at;
            $lastStatusCheck = $smsDeliveries->whereNotNull('status_check_attempted_at')->sortByDesc('status_check_attempted_at')->first();
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
                    @if ($announcement->target_type === 'age_bracket' && ! is_null($announcement->min_age) && ! is_null($announcement->max_age))
                        <dd class="mt-1 text-xs text-[#6D817A]">Ages {{ $announcement->min_age }}–{{ $announcement->max_age }}</dd>
                    @endif
                </div>
                <div>
                    <dt class="text-xs font-bold uppercase tracking-wide text-[#6D817A]">Recipients</dt>
                    <dd class="mt-1 text-sm font-semibold">{{ $announcement->recipients->count() }} residents</dd>
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
                        </p>
                        @if ($preparedSmsCount + $pendingSmsCount + $retryingSmsCount + $failedSmsCount + $unknownSmsCount > 0)
                            <p class="mt-1 text-sm leading-6 text-[#6D817A]">Other messages may still be prepared, pending, retrying, failed, or have an unknown outcome. See SMS controls and details below.</p>
                        @endif
                    @endif
                </div>
            </div>

            <details class="mt-6 border-t border-[#D2E1DA] pt-5">
                <summary class="cursor-pointer text-sm font-bold text-[#0F6F5A]">SMS controls and details</summary>
                <p class="mt-4 text-sm leading-6 text-[#385C52]">
                    Prepared: {{ $preparedSmsCount }} &middot; Pending: {{ $pendingSmsCount }} &middot;
                    Retrying: {{ $retryingSmsCount }} &middot; Sent (unconfirmed): {{ $providerSentSmsCount }} &middot;
                    Delivered: {{ $deliveredSmsCount }} &middot; Failed: {{ $failedSmsCount }} &middot; Unknown: {{ $unknownSmsCount }}
                </p>

            <p class="mt-5 rounded-2xl border border-[#D2E1DA] bg-[#EDF5F0] p-4 text-sm leading-6 text-[#385C52]">
                Prepared: not submitted. Pending: queued at UniSMS. Retrying: UniSMS is retrying.
                Sent (unconfirmed): UniSMS reports sent, but does not document handset delivery confirmation.
                A recipient may receive the message even if this status remains unconfirmed.
                Delivered: confirmed handset delivery. Failed: rejected or reported failed.
                Unknown: the submission or delivery outcome could not be determined.
                Checking status does not send SMS messages.
                A manual check bypasses per-message intervals but still respects the provider-error cooldown.
            </p>
            @if ($lastStatusCheck)
                <p class="mt-2 text-sm text-[#6D817A]">
                    Last status check: {{ $lastStatusCheck->status_check_attempted_at->format('M d, Y h:i A') }}.
                    Result: {{ match ($lastStatusCheck->status_check_result) {
                        'success' => 'provider response received',
                        'connection_error' => 'connection unavailable; previous status retained',
                        'http_error' => 'provider request failed; previous status retained',
                        'invalid_response' => 'invalid provider response; previous status retained',
                        'skipped' => 'delivery changed; provider status not applied',
                        default => 'check in progress',
                    } }}.
                    @if ($lastStatusCheck->status_lookup_http_status !== null)
                        HTTP {{ $lastStatusCheck->status_lookup_http_status }}.
                    @endif
                </p>
            @endif
            @if ($lastStatusUpdate)
                <p class="mt-2 text-sm text-[#6D817A]">Latest provider update: {{ $lastStatusUpdate->format('M d, Y h:i A') }}</p>
            @endif
            <p class="mt-2 text-sm text-[#6D817A]">
                Automatic checks: {{ $smsSyncOverview['due'] }} due; {{ $smsSyncOverview['not_due'] }} not yet due.
                @if ($smsSyncOverview['next_due'])
                    Next eligibility for not-yet-due records: {{ $smsSyncOverview['next_due']->format('M d, Y h:i A T') }}. Scheduling and provider cooldowns may delay it.
                @endif
            </p>
            @if ($missingReferenceCount > 0)
                <p class="mt-2 text-sm text-amber-800">{{ $missingReferenceCount }} message{{ $missingReferenceCount === 1 ? '' : 's' }} cannot be checked because the provider reference is missing.</p>
            @endif
            @if ($invalidReferenceCount > 0)
                <p class="mt-2 text-sm text-amber-800">{{ $invalidReferenceCount }} message{{ $invalidReferenceCount === 1 ? '' : 's' }} cannot be checked because the provider reference is invalid.</p>
            @endif

            @if (! $smsEnabled)
                <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900" role="status">
                    SMS sending is disabled. Prepared SMS records are preserved. Enable
                    <code class="rounded bg-white px-1.5 py-0.5">UNISMS_SMS_ENABLED</code>
                    only when you are ready to send real messages.
                </p>
            @elseif (! $smsConfigured)
                <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900" role="status">
                    UniSMS is enabled, but its secret key or sender ID is not configured.
                </p>
            @elseif ($preparedSmsCount > 0)
                <form
                    class="mt-5"
                    method="POST"
                    action="{{ route('announcements.sms.send', $announcement) }}"
                    onsubmit="return confirm('Send the prepared SMS messages for this announcement?');"
                >
                    @csrf
                    <button
                        type="submit"
                        class="rounded-xl bg-[#168B70] px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#0F6F5A] focus:outline-none focus:ring-2 focus:ring-[#168B70] focus:ring-offset-2"
                    >
                        Send {{ $preparedSmsCount }} prepared SMS message{{ $preparedSmsCount === 1 ? '' : 's' }}
                    </button>
                </form>
            @else
                <p class="mt-5 text-sm text-[#6D817A]">There are no prepared SMS messages to send.</p>
            @endif

            @if ($smsStatusConfigured && $checkableSmsCount > 0)
                <form class="mt-4" method="POST" action="{{ route('announcements.sms.refresh', $announcement) }}"
                    x-data="{ checking: false }"
                    x-on:submit="if (checking) { $event.preventDefault() } else { checking = true }">
                    @csrf
                    <button type="submit" class="rounded-xl border border-[#168B70] px-5 py-3 text-sm font-bold text-[#0F6F5A] disabled:cursor-wait disabled:opacity-60"
                        x-bind:disabled="checking" x-bind:aria-busy="checking">
                        <span x-text="checking ? 'Checking UniSMS status...' : 'Check UniSMS status'">Check UniSMS status</span>
                    </button>
                </form>
            @endif

            @if ($failedSmsCount > 0)
                <div class="mt-6 border-t border-[#D2E1DA] pt-5">
                    <h3 class="text-sm font-bold text-[#164238]">Failed delivery details</h3>
                    <ul class="mt-3 space-y-3">
                        @foreach ($smsDeliveries->where('status', 'Failed') as $delivery)
                            <li class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">
                                <p class="font-bold">Delivery #{{ $delivery->id }}</p>
                                <p class="mt-1 whitespace-pre-line break-words">{{ $delivery->failure_reason ?? 'No failure details were recorded.' }}</p>
                                @if ($delivery->canPrepareRetry())
                                    <form method="POST" action="{{ route('announcements.sms.prepare-retry', [$announcement, $delivery->id]) }}" class="mt-3"
                                        onsubmit="return confirm('Prepare this rejected SMS for retry? No message will be sent until you confirm sending prepared messages.');">
                                        @csrf
                                        <button type="submit" class="rounded-lg border border-red-700 px-3 py-2 font-bold hover:bg-red-100">
                                            Prepare rejected SMS for retry
                                        </button>
                                    </form>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($unknownSmsCount + $providerSentSmsCount > 0)
                <div class="mt-6 border-t border-[#D2E1DA] pt-5">
                    <h3 class="text-sm font-bold text-[#164238]">Unconfirmed delivery outcomes</h3>
                    <ul class="mt-3 space-y-3">
                        @foreach ($smsDeliveries->where('status', 'Unknown') as $delivery)
                            <li class="rounded-2xl border p-4 text-sm {{ $delivery->provider_status === 'sent' ? 'border-blue-200 bg-blue-50 text-blue-900' : 'border-amber-200 bg-amber-50 text-amber-900' }}">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <p class="font-bold">Delivery #{{ $delivery->id }}</p>
                                    <span class="rounded-full bg-white/80 px-3 py-1 text-xs font-bold">
                                        {{ $delivery->provider_status === 'sent' ? 'Sent by provider' : 'Outcome unknown' }}
                                    </span>
                                </div>
                                @if ($delivery->provider_reference)
                                    <p class="mt-3 break-all">Provider reference: {{ $delivery->provider_reference }}</p>
                                @endif

                                <p class="mt-1">{{ $delivery->failure_reason ?? ($delivery->provider_status === 'sent' ? 'UniSMS reports sent; handset delivery is not confirmed.' : 'The final delivery outcome is not confirmed.') }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($smsDeliveries->isNotEmpty())
                <div class="mt-6 border-t border-[#D2E1DA] pt-5">
                    <h3 class="text-sm font-bold text-[#164238]">Latest provider responses</h3>
                    <ul class="mt-3 space-y-3 text-sm text-[#6D817A]">
                        @foreach ($smsDeliveries as $delivery)
                            <li class="rounded-xl border border-[#D2E1DA] bg-white p-4">
                                <p class="font-bold text-[#164238]">Delivery #{{ $delivery->id }}</p>
                                <p class="mt-1">Provider status: {{ in_array($delivery->provider_status, ['pending', 'retrying', 'sent', 'failed'], true) ? $delivery->provider_status : 'unavailable' }}</p>
                                <p class="mt-1 break-all">Provider reference: {{ $delivery->provider_reference ?? 'Not available' }}</p>
                                <p class="mt-1">Provider acceptance recorded: {{ $delivery->provider_http_status === 201 && $delivery->sent_at ? $delivery->sent_at->format('M d, Y h:i A') : 'Not confirmed' }}</p>
                                <p class="mt-1">Last successful status check: {{ $lastSuccessfulSmsChecks->get($delivery->id)?->format('M d, Y h:i A') ?? 'Not recorded' }}</p>
                                @if ($latestSmsReasons->get($delivery->id)?->provider_reason)
                                    <p class="mt-1 whitespace-pre-line break-words">Last reported provider detail ({{ \Carbon\Carbon::parse($latestSmsReasons->get($delivery->id)->checked_at)->format('M d, Y h:i A') }}): {{ $latestSmsReasons->get($delivery->id)->provider_reason }}</p>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            </details>
        </section>

        <section class="rounded-2xl border border-white bg-[#F8FCFA] p-6 shadow-[0_8px_24px_rgba(107,134,124,0.12)]">
            <div class="mb-5">
                <h2 class="text-lg font-bold text-[#164238]">Announcement directory</h2>
                <p class="mt-1 text-sm text-[#6D817A]">Open another announcement or remove one from the directory.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[640px]">
                    <thead class="bg-[#EDF5F0]">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Announcement</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Target</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Recipient</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-[#6D817A]">Publish</th>
                            <th class="px-4 py-3 text-right text-xs font-bold uppercase tracking-wide text-[#6D817A]"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($directoryAnnouncements as $directoryAnnouncement)
                            @php
                                $directoryTargetLabels = [
                                    'specific' => 'Specific resident',
                                    'senior' => 'Senior citizens',
                                    'children' => 'Children (0–5)',
                                    'pregnant' => 'Pregnant residents',
                                    'postnatal' => 'Postnatal residents',
                                    'general' => 'All active residents',
                                    'age_bracket' => 'Age bracket',
                                ];
                            @endphp
                            <tr class="border-b border-[#D2E1DA]/70 last:border-0">
                                <td class="px-4 py-3">
                                    <a href="{{ route('announcements.show', $directoryAnnouncement) }}" class="font-semibold text-[#164238] hover:text-[#168B70]">
                                        {{ $directoryAnnouncement->title }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-[#385C52]">
                                    {{ $directoryTargetLabels[$directoryAnnouncement->target_type] ?? ucwords(str_replace('_', ' ', $directoryAnnouncement->target_type)) }}
                                </td>
                                <td class="px-4 py-3 text-sm text-[#385C52]">{{ $directoryAnnouncement->recipients_count }} residents</td>
                                <td class="px-4 py-3 text-sm text-[#385C52]">{{ $directoryAnnouncement->published_at?->format('M d, Y') ?? '—' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end gap-2">
                                        <a
                                            href="{{ route('announcements.show', $directoryAnnouncement) }}"
                                            class="rounded-lg border border-[#D2E1DA] bg-white px-3 py-2 text-xs font-bold text-[#0F6F5A] hover:bg-[#EDF5F0]"
                                        >
                                            View
                                        </a>
                                        <form
                                            method="POST"
                                            action="{{ route('announcements.destroy', $directoryAnnouncement) }}"
                                            onsubmit="return confirm('Delete this announcement and its delivery records?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                type="submit"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-bold text-red-700 hover:bg-red-100"
                                            >
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($directoryAnnouncements->hasPages())
                <div class="mt-4">{{ $directoryAnnouncements->links() }}</div>
            @endif
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
