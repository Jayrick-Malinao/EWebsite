{{-- SMS disabled notice --}}
@unless ($smsEnabled)
    <section class="clay-alert bg-[#FCF7ED] p-5" role="status">
        <div class="flex items-start gap-3">
            <div class="clay-icon h-10 w-10 rounded-xl bg-[#F8E9CB] text-[#9A5A12]">
                <svg
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v3.75m0 3h.008v.008H12v-.008ZM10.29 3.86 1.82 18.14A1.5 1.5 0 003.11 20.4h16.98a1.5 1.5 0 001.29-2.26L12.91 3.86a1.5 1.5 0 00-2.62 0Z"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <h3 class="text-sm font-bold text-[#80500F]">
                    SMS sending is currently disabled
                </h3>

                <p class="mt-1 text-sm leading-6 text-[#80500F]">
                    No real SMS messages can be sent while
                    <code class="rounded bg-white/70 px-1.5 py-0.5">PHILSMS_SMS_ENABLED=false</code>.
                    Pending SMS records are preserved. Enable sending only after
                    verifying your PhilSMS API token, approved sender ID, and
                    available account credits.
                </p>
            </div>
        </div>
    </section>
@endunless