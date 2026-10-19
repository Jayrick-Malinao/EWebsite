@php
    $dashboardRoute = 'official.dashboard';
@endphp

<aside
    id="officialSidebar"
    data-sidebar
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 ease-in-out lg:translate-x-0"
>
    {{-- Brand --}}
    <div class="flex h-20 shrink-0 items-center border-b border-slate-200 px-6">
        <a href="{{ route($dashboardRoute) }}" class="flex items-center gap-3">
            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-700 text-white shadow-sm">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s8-4.5 8-10.5V5.5L12 3 4 5.5v5C4 16.5 12 21 12 21Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v6M9 11h6"/>
                </svg>
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-bold text-slate-900">
                    Barangay Esperanza
                </p>
                <p class="truncate text-xs text-slate-500">
                    Health Center
                </p>
            </div>
        </a>
    </div>

    {{-- User Profile --}}
    <div class="border-b border-slate-200 px-4 py-4">
        <div class="flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3">
            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-bold text-emerald-700">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900">
                    {{ auth()->user()->name ?? 'User' }}
                </p>
                <p class="truncate text-xs text-slate-500">
                    Barangay Official
                </p>
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav id="sidebar-nav" class="flex-1 overflow-y-auto px-4 py-5">

        {{-- MAIN --}}
        <div class="mb-6">
            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Main
            </p>

            <a
                href="{{ route('official.dashboard') }}"
                class="{{ request()->routeIs('official.dashboard') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m3 10 9-7 9 7"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 9.5V21h14V9.5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-7h6v7"/>
                </svg>
                Dashboard
            </a>
        </div>

        {{-- MONITORING --}}
        <div class="mb-6">
            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Monitoring
            </p>

            <a
                href="{{ route('residents.index') }}"
                class="{{ request()->routeIs('residents.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                Residents
            </a>

            <a
                href="{{ route('households.index') }}"
                class="{{ request()->routeIs('households.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 21V8l7-4 7 4v13"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21v-5h6v5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01"/>
                </svg>
                Households
            </a>
        </div>

        {{-- COMMUNITY --}}
        <div class="mb-6">
            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Community
            </p>

            <a
                href="{{ route('schedule.index') }}"
                class="{{ request()->routeIs('schedule.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="18" height="18" x="3" y="4" rx="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 2v4M8 2v4M3 10h18"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 14h2M14 14h2M8 18h2"/>
                </svg>
                Schedule
            </a>

            <a
                href="{{ route('announcements.index') }}"
                class="{{ request()->routeIs('announcements.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 11.5a2.5 2.5 0 0 1 2.5-2.5H9l6-4v13l-6-4H5.5A2.5 2.5 0 0 1 3 11.5Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9a4 4 0 0 1 0 5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.5 6.5a7.5 7.5 0 0 1 0 10"/>
                </svg>
                Announcements
            </a>

            <a
                href="{{ route('notifications.index') }}"
                class="{{ request()->routeIs('notifications.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 21h4"/>
                </svg>
                Notifications
            </a>
        </div>

        {{-- REPORTS --}}
        <div class="mb-6">
            <p class="mb-2 px-3 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                Reports
            </p>

            <a
                href="{{ route('reports.index') }}"
                class="{{ request()->routeIs('reports.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5h15l-2 4 2 4H4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 19v2"/>
                </svg>
                Reports
            </a>

            <a
                href="{{ route('analytics.index') }}"
                class="{{ request()->routeIs('analytics.*') ? 'bg-emerald-50 text-emerald-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }} group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 16v-4M12 16V8M17 16v-7"/>
                </svg>
                Analytics
            </a>
        </div>

    </nav>

    {{-- Sign Out --}}
    <div class="shrink-0 border-t border-slate-200 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-red-50 hover:text-red-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16 17 5-5-5-5"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12H9"/>
                </svg>
                Sign Out
            </button>
        </form>
    </div>

    <script>
        (function () {
            const nav = document.getElementById('sidebar-nav');
            if (!nav) return;

            const key = 'officialSidebarScrollTop';

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