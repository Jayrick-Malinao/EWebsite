<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title }} | Announcements</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#EEF5F1] text-[#164238]">
    <header class="border-b border-white/80 bg-[#F8FCFA] shadow-sm">
        <div class="mx-auto flex max-w-5xl items-center justify-between gap-4 px-4 py-4 sm:px-6">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#168B70]">
                    Barangay Esperanza Health Center
                </p>
                <h1 class="mt-1 text-lg font-bold text-[#164238]">Announcement details</h1>
            </div>

            <a
                href="{{ route('announcements.index') }}"
                class="rounded-xl border border-[#D2E1DA] bg-white px-4 py-2 text-sm font-bold text-[#164238] hover:bg-[#EDF5F0]"
            >
                Back to announcements
            </a>
        </div>
    </header>

    <main class="mx-auto max-w-5xl space-y-6 px-4 py-8 sm:px-6">
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
                'general' => 'All active residents',
                'age_bracket' => 'Age bracket',
            ];
            $targetLabel = $targetLabels[$announcement->target_type]
                ?? ucwords(str_replace('_', ' ', $announcement->target_type));
            $smsDeliveries = $announcement->smsDeliveries;
            $pendingSmsCount = $smsDeliveries->where('status', 'Pending')->count();
            $sentSmsCount = $smsDeliveries->where('status', 'Sent')->count();
            $failedSmsCount = $smsDeliveries->where('status', 'Failed')->count();
        @endphp

        <section class="rounded-2xl border border-white bg-[#F8FCFA] p-6 shadow-[0_8px_24px_rgba(107,134,124,0.12)] sm:p-8">
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

            <p class="mt-5 whitespace-pre-line break-words text-base leading-7 text-[#385C52]">{{ $announcement->message }}</p>

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

        <section class="rounded-2xl border border-white bg-[#F8FCFA] p-6 shadow-[0_8px_24px_rgba(107,134,124,0.12)]">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-bold text-[#164238]">SMS delivery</h2>
                    <p class="mt-1 text-sm text-[#6D817A]">
                        {{ $smsDeliveries->count() }} household message{{ $smsDeliveries->count() === 1 ? '' : 's' }} prepared.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2 text-xs font-bold">
                    <span class="rounded-full bg-amber-50 px-3 py-1.5 text-amber-800">Pending: {{ $pendingSmsCount }}</span>
                    <span class="rounded-full bg-green-50 px-3 py-1.5 text-green-800">Accepted: {{ $sentSmsCount }}</span>
                    <span class="rounded-full bg-red-50 px-3 py-1.5 text-red-800">Failed: {{ $failedSmsCount }}</span>
                </div>
            </div>

            @if (! $smsEnabled)
                <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900" role="status">
                    SMS sending is disabled. Pending SMS records are preserved. Enable
                    <code class="rounded bg-white px-1.5 py-0.5">UNISMS_SMS_ENABLED</code>
                    only when you are ready to send real messages.
                </p>
            @elseif (! $smsConfigured)
                <p class="mt-5 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm leading-6 text-amber-900" role="status">
                    UniSMS is enabled, but its secret key or sender ID is not configured.
                </p>
            @elseif ($pendingSmsCount > 0)
                <form
                    class="mt-5"
                    method="POST"
                    action="{{ route('announcements.sms.send', $announcement) }}"
                    onsubmit="return confirm('Send the pending SMS messages for this announcement?');"
                >
                    @csrf
                    <button
                        type="submit"
                        class="rounded-xl bg-[#168B70] px-5 py-3 text-sm font-bold text-white shadow-sm hover:bg-[#0F6F5A] focus:outline-none focus:ring-2 focus:ring-[#168B70] focus:ring-offset-2"
                    >
                        Send {{ $pendingSmsCount }} pending SMS message{{ $pendingSmsCount === 1 ? '' : 's' }}
                    </button>
                </form>
            @else
                <p class="mt-5 text-sm text-[#6D817A]">There are no pending SMS messages to send.</p>
            @endif

            @if ($failedSmsCount > 0)
                <div class="mt-6 border-t border-[#D2E1DA] pt-5">
                    <h3 class="text-sm font-bold text-[#164238]">Failed delivery details</h3>
                    <ul class="mt-3 space-y-3">
                        @foreach ($smsDeliveries->where('status', 'Failed') as $delivery)
                            <li class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-900">
                                <p class="font-bold">Delivery #{{ $delivery->id }}</p>
                                <p class="mt-1 whitespace-pre-line break-words">{{ $delivery->failure_reason ?? 'No failure details were recorded.' }}</p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </section>
    </main>
</body>

</html>
