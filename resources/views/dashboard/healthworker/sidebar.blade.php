@php
    $dashboardRoute = 'healthworker.dashboard';
@endphp

<aside
    id="healthworkerSidebar"
    data-sidebar
    class="claymorphism-sidebar fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 ease-in-out lg:translate-x-0"
>
    {{-- =========================================================
         BRAND
    ========================================================== --}}
    <div class="flex h-20 shrink-0 items-center border-b border-slate-100 px-6">
        <a
            href="{{ route($dashboardRoute) }}"
            class="flex min-w-0 items-center gap-3"
        >
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-700 shadow-sm">
                <img
                    src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                    alt=""
                    class="h-10 w-10 rounded-xl object-contain"
                >
            </div>

            <div class="min-w-0">
                <p class="truncate text-xs font-bold tracking-wide text-emerald-700">
                    BARANGAY ESPERANZA
                </p>

                <p class="truncate text-sm font-semibold text-slate-900">
                    Health Center
                </p>
            </div>
        </a>
    </div>

    {{-- =========================================================
         USER PROFILE
    ========================================================== --}}
    <div class="border-b border-slate-100 px-5 py-4">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3">

            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900">
                    {{ auth()->user()->name }}
                </p>

                <p class="truncate text-xs text-slate-500">
                    {{ auth()->user()->role }}
                </p>
            </div>

        </div>
    </div>

    {{-- =========================================================
         NAVIGATION
    ========================================================== --}}
    <nav id="sidebar-nav" class="flex-1 overflow-y-auto px-4 py-5">

        {{-- MAIN --}}
        <div>

            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Main
            </p>

            <div class="space-y-1">

                {{-- Dashboard --}}
                <a
                    href="{{ route('healthworker.dashboard') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-semibold transition
                        {{ request()->routeIs('healthworker.dashboard')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>

                    <span>Dashboard</span>
                </a>

            </div>
        </div>

        {{-- RECORDS --}}
        <div class="mt-7">

            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Records
            </p>

            <div class="space-y-1">

                {{-- Households --}}
                <a
                    href="{{ route('households.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('households.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 20h18" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20V9l7-5 7 5v11" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20v-6h6v6" />
                    </svg>

                    <span>Households</span>
                </a>

                {{-- Residents --}}
                <a
                    href="{{ route('residents.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('residents.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="9" cy="8" r="3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                        <path stroke-linecap="round" d="M16 5.5a3 3 0 0 1 0 5.8" />
                        <path stroke-linecap="round" d="M18 14c1.8.8 3 2.5 3 4.5" />
                    </svg>

                    <span>Residents</span>
                </a>

                {{-- Health Records --}}
                <a
                    href="{{ route('health-records.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('health-records.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="4" y="3" width="16" height="18" rx="2" />
                        <path stroke-linecap="round" d="M8 8h8M8 12h8M8 16h5" />
                    </svg>

                    <span>Health Records</span>
                </a>

                {{-- Home Visits --}}
                <a
                    href="{{ route('health-visits.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('health-visits.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5 12 4l9 7.5" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.5 10v9h13v-9" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-5h6v5" />
                    </svg>

                    <span>Home Visits</span>
                </a>

            </div>
        </div>

        {{-- PROGRAMS --}}
        <div class="mt-7">

            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Programs
            </p>

            <div class="space-y-1">

                {{-- Immunization --}}
                <a
                    href="{{ route('immunizations.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('immunizations.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18M5 8h14M5 16h14" />
                        <circle cx="12" cy="12" r="9" />
                    </svg>

                    <span>Immunization</span>
                </a>

                {{-- Maternal Care --}}
                <a
                    href="{{ route('maternal-care.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('maternal-care.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" d="M12 7v5l3 2" />
                    </svg>

                    <span>Maternal Care</span>
                </a>

                {{-- Child Health --}}
                <a
                    href="{{ route('child-health.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('child-health.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="8" r="3" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 21c.8-4.3 3.1-6.5 7-6.5s6.2 2.2 7 6.5" />
                        <path stroke-linecap="round" d="M19 5v4M17 7h4" />
                    </svg>

                    <span>Child Health</span>
                </a>

                {{-- Senior Citizens --}}
                <a
                    href="{{ route('senior-citizens.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('senior-citizens.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="9" r="4" />
                        <path stroke-linecap="round" d="M5 21c1-4 3.3-6 7-6s6 2 7 6" />
                    </svg>

                    <span>Senior Citizens</span>
                </a>

            </div>
        </div>

        {{-- OPERATIONS --}}
        <div class="mt-7">

            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Operations
            </p>

            <div class="space-y-1">

                {{-- Schedule --}}
                <a
                    href="{{ route('schedule.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('schedule.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="3" y="4" width="18" height="17" rx="2" />
                        <path stroke-linecap="round" d="M16 2v4M8 2v4M3 9h18" />
                        <path stroke-linecap="round" d="M8 13h2M14 13h2M8 17h2" />
                    </svg>

                    <span>Schedule</span>
                </a>

                {{-- Medical Inventory --}}
                <a
                    href="{{ route('medical-inventories.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('medical-inventories.*')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6v4H9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h10v14H7z" />
                        <path stroke-linecap="round" d="M10 11h4M10 15h4M10 18h2" />
                    </svg>

                    <span>Medical Inventory</span>
                </a>

                {{-- Notifications --}}
                <a
                    href="{{ route('notifications.index') }}"
                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                        {{ request()->routeIs('notifications.index')
                            ? 'bg-emerald-50 text-emerald-700'
                            : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
                >
                    <svg
                        class="h-5 w-5 shrink-0"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z" />
                        <path stroke-linecap="round" d="M10 21h4" />
                    </svg>

                    <span>Notifications</span>
                </a>

            </div>
        </div>

    </nav>

    {{-- =========================================================
         SIGN OUT
    ========================================================== --}}
    <div class="shrink-0 border-t border-slate-100 p-4">

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-red-50 hover:text-red-600"
            >
                <svg
                    class="h-5 w-5 shrink-0"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path stroke-linecap="round" d="M10 17l5-5-5-5" />
                    <path stroke-linecap="round" d="M15 12H3" />
                    <path stroke-linecap="round" d="M21 19V5a2 2 0 0 0-2-2h-6" />
                </svg>

                <span>Sign out</span>
            </button>
        </form>

    </div>

    <script>
        (function () {
            const nav = document.getElementById('sidebar-nav');
            if (!nav) return;

            const key = 'healthworkerSidebarScrollTop';

            const saved = sessionStorage.getItem(key);

            if (saved !== null) {
                nav.scrollTop = parseInt(saved, 10);
            } else {
                const active = nav.querySelector('.bg-emerald-50');
                if (active) {
                    nav.scrollTop = active.offsetTop - nav.clientHeight / 2 + active.offsetHeight / 2;
                }
            }

            window.addEventListener('pagehide', () => {
                sessionStorage.setItem(key, nav.scrollTop);
            });
        })();
    </script>

</aside>