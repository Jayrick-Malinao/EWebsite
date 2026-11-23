@php
    $dashboardRoute = match (auth()->user()->role) {
        'System Administrator' => 'admin.dashboard',
        'Official' => 'official.dashboard',
        'Health Worker' => 'healthworker.dashboard',
        default => 'dashboard',
    };

    $backupsUrl = \Illuminate\Support\Facades\Route::has('backups.index')
        ? route('backups.index')
        : '#';
@endphp

<style>
    /* =========================================================
       GOVERNMENT-STYLE CLAYMORPHISM
       Frontend styling only.
       Backend logic, routes, auth, navigation and forms remain
       unchanged.
    ========================================================== */

    .claymorphism-sidebar {
        --gov-primary: #168B70;
        --gov-primary-dark: #0F6F5A;
        --gov-primary-light: #2A9B80;

        --gov-bg: #EEF5F1;
        --gov-surface: #F5FAF7;
        --gov-surface-soft: #EDF5F0;

        --gov-text: #164238;
        --gov-muted: #6D817A;
        --gov-placeholder: #9AA9A4;

        --gov-orange: #E87928;
        --gov-danger: #DC2626;
        --gov-warning: #B7791F;

        --gov-highlight: rgba(255, 255, 255, 0.94);
        --gov-shadow: rgba(107, 134, 124, 0.24);

        font-family: Arial, Helvetica, sans-serif !important;

        background: var(--gov-bg) !important;
        color: var(--gov-text);

        border-right: 0 !important;

        box-shadow:
            10px 0 24px rgba(107, 134, 124, 0.12),
            -6px -6px 18px rgba(255, 255, 255, 0.55);

        overflow: hidden;
    }

    /* ---------------------------------------------------------
       SUBTLE BACKGROUND DEPTH
    --------------------------------------------------------- */

    .claymorphism-sidebar::before {
        content: '';
        position: absolute;
        inset: 0;
        pointer-events: none;

        background:
            radial-gradient(
                circle at 15% 4%,
                rgba(255, 255, 255, 0.62),
                transparent 24%
            ),
            radial-gradient(
                circle at 95% 92%,
                rgba(22, 139, 112, 0.045),
                transparent 28%
            );
    }

    .claymorphism-sidebar > div:first-child,
    .claymorphism-sidebar > [data-assistant-slot] {
        position: relative;
        z-index: 1;

        border-color: rgba(255, 255, 255, 0.70) !important;
    }

    /* =========================================================
       BRAND AREA
    ========================================================== */

    .claymorphism-sidebar > div:first-child a > div:first-child {
        background: var(--gov-surface) !important;

        color: var(--gov-primary) !important;

        border: 1px solid rgba(255, 255, 255, 0.70);

        border-radius: 18px !important;

        box-shadow:
            7px 7px 14px var(--gov-shadow),
            -7px -7px 14px var(--gov-highlight),
            inset 1px 1px 2px rgba(255, 255, 255, 0.70);

        transition:
            transform 0.18s ease,
            box-shadow 0.18s ease;
    }

    .claymorphism-sidebar > div:first-child a:hover > div:first-child {
        transform: translateY(-1px);

        box-shadow:
            5px 5px 11px rgba(107, 134, 124, 0.22),
            -6px -6px 12px rgba(255, 255, 255, 0.94),
            inset 1px 1px 2px rgba(255, 255, 255, 0.72);
    }

    .claymorphism-sidebar > div:first-child a:hover svg {
        color: var(--gov-primary-dark) !important;
    }

    .claymorphism-sidebar > div:first-child .text-emerald-700 {
        color: var(--gov-primary-dark) !important;
    }

    /* =========================================================
       PROFILE CARD
    ========================================================== */

    .claymorphism-sidebar > div:nth-child(2) > div {
        background: var(--gov-surface) !important;

        border: 1px solid rgba(255, 255, 255, 0.70);

        border-radius: 21px !important;

        box-shadow:
            7px 7px 14px var(--gov-shadow),
            -7px -7px 14px var(--gov-highlight);

        position: relative;
    }

    .claymorphism-sidebar > div:nth-child(2) > div > div:first-child {
        background: var(--gov-surface-soft) !important;

        color: var(--gov-primary-dark) !important;

        border: 1px solid rgba(255, 255, 255, 0.70);

        box-shadow:
            4px 4px 8px rgba(107, 134, 124, 0.20),
            -4px -4px 8px rgba(255, 255, 255, 0.92);
    }

    /* =========================================================
       NAVIGATION SCROLLBAR
    ========================================================== */

    .claymorphism-sidebar nav {
        position: relative;
        z-index: 1;

        scrollbar-width: thin;
        scrollbar-color:
            rgba(22, 139, 112, 0.28)
            transparent;
    }

    .claymorphism-sidebar nav::-webkit-scrollbar {
        width: 7px;
    }

    .claymorphism-sidebar nav::-webkit-scrollbar-track {
        background: transparent;
    }

    .claymorphism-sidebar nav::-webkit-scrollbar-thumb {
        border-radius: 999px;

        background: rgba(22, 139, 112, 0.25);

        box-shadow:
            2px 2px 4px rgba(107, 134, 124, 0.18),
            -2px -2px 4px rgba(255, 255, 255, 0.82);
    }

    /* =========================================================
       NAVIGATION SECTION GROUPS
    ========================================================== */

    .claymorphism-sidebar nav > div {
        padding: 9px;

        border-radius: 21px;

        background: rgba(237, 245, 240, 0.78);

        border: 1px solid rgba(255, 255, 255, 0.62);

        box-shadow:
            5px 5px 11px rgba(107, 134, 124, 0.14),
            -5px -5px 11px rgba(255, 255, 255, 0.68);
    }

    .claymorphism-sidebar nav > div + div {
        margin-top: 14px;
    }

    .claymorphism-sidebar nav > div > p {
        color: var(--gov-muted) !important;

        letter-spacing: 0.13em !important;

        padding-left: 4px !important;

        font-family: Arial, Helvetica, sans-serif !important;
    }

    /* =========================================================
       NAVIGATION BUTTONS
    ========================================================== */

    .claymorphism-sidebar nav a {
        position: relative;

        color: #49645D !important;

        background: transparent !important;

        border: 1px solid transparent;

        border-radius: 14px !important;

        font-family: Arial, Helvetica, sans-serif !important;

        transition:
            transform 0.16s ease,
            box-shadow 0.16s ease,
            background-color 0.16s ease,
            color 0.16s ease;
    }

    .claymorphism-sidebar nav a:hover {
        background: var(--gov-surface) !important;

        color: var(--gov-primary-dark) !important;

        border-color: rgba(255, 255, 255, 0.70);

        transform: translateY(-1px);

        box-shadow:
            5px 5px 9px rgba(107, 134, 124, 0.20),
            -5px -5px 9px rgba(255, 255, 255, 0.92);
    }

    /* =========================================================
       ACTIVE NAVIGATION ITEM
    ========================================================== */

    .claymorphism-sidebar nav a.bg-emerald-50 {
        background: var(--gov-surface-soft) !important;

        color: var(--gov-primary-dark) !important;

        border-color: rgba(255, 255, 255, 0.72);

        box-shadow:
            5px 5px 10px rgba(107, 134, 124, 0.22),
            -5px -5px 10px rgba(255, 255, 255, 0.92),
            inset 1px 1px 2px rgba(255, 255, 255, 0.72);
    }

    .claymorphism-sidebar nav a.bg-emerald-50::before {
        content: '';

        position: absolute;

        left: -2px;
        top: 8px;
        bottom: 8px;

        width: 4px;

        border-radius: 999px;

        background: var(--gov-primary);

        box-shadow:
            0 2px 5px rgba(22, 139, 112, 0.20);
    }

    /* =========================================================
       ICONS
    ========================================================== */

    .claymorphism-sidebar svg {
        opacity: 1 !important;

        stroke: currentColor !important;
    }

    .claymorphism-sidebar nav a svg,
    .claymorphism-sidebar > [data-assistant-slot] form button svg {
        color: #4C665F !important;

        stroke: currentColor !important;

        fill: none !important;

        opacity: 1 !important;

        filter: none !important;

        flex-shrink: 0;

        transition:
            color 0.16s ease,
            transform 0.16s ease;
    }

    .claymorphism-sidebar nav a:hover svg {
        color: var(--gov-primary) !important;

        transform: scale(1.04);
    }

    .claymorphism-sidebar nav a.bg-emerald-50 svg {
        color: var(--gov-primary) !important;

        stroke: currentColor !important;
    }

    .claymorphism-sidebar nav a.bg-emerald-50 span {
        font-weight: 700;
    }

    /* =========================================================
       TYPOGRAPHY
    ========================================================== */

    .claymorphism-sidebar .text-slate-900 {
        color: var(--gov-text) !important;
    }

    .claymorphism-sidebar .text-slate-600 {
        color: #4F6961 !important;
    }

    .claymorphism-sidebar .text-slate-500,
    .claymorphism-sidebar .text-slate-400 {
        color: var(--gov-muted) !important;
    }

    .claymorphism-sidebar .text-emerald-700 {
        color: var(--gov-primary-dark) !important;
    }

    /* =========================================================
       SIGN OUT
    ========================================================== */

    .claymorphism-sidebar > [data-assistant-slot] form button {
        color: #536A63 !important;

        background: transparent !important;

        border: 1px solid transparent;

        border-radius: 14px !important;

        font-family: Arial, Helvetica, sans-serif !important;

        transition:
            transform 0.16s ease,
            box-shadow 0.16s ease,
            color 0.16s ease,
            background-color 0.16s ease;
    }

    .claymorphism-sidebar > [data-assistant-slot] form button:hover {
        color: var(--gov-danger) !important;

        background: #F9F1EF !important;

        border-color: rgba(255, 255, 255, 0.78);

        transform: translateY(-1px);

        box-shadow:
            5px 5px 9px rgba(107, 134, 124, 0.16),
            -5px -5px 9px rgba(255, 255, 255, 0.92);
    }

    /* =========================================================
       FOCUS ACCESSIBILITY
    ========================================================== */

    .claymorphism-sidebar a:focus-visible,
    .claymorphism-sidebar button:focus-visible {
        outline: 2px solid var(--gov-primary);

        outline-offset: 2px;

        box-shadow:
            0 0 0 4px rgba(22, 139, 112, 0.12),
            4px 4px 8px rgba(107, 134, 124, 0.18),
            -4px -4px 8px rgba(255, 255, 255, 0.90);
    }

    /* =========================================================
       REDUCED MOTION
    ========================================================== */

    @media (prefers-reduced-motion: reduce) {
        .claymorphism-sidebar nav a,
        .claymorphism-sidebar nav a svg,
        .claymorphism-sidebar > div:first-child a > div:first-child,
        .claymorphism-sidebar > [data-assistant-slot] form button {
            transition: none !important;
        }
    }
</style>

<aside
    id="adminSidebar"
    data-sidebar
    class="claymorphism-sidebar fixed inset-y-0 left-0 z-50 flex w-72 max-w-[calc(100vw-3rem)] -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 ease-in-out lg:translate-x-0"
>
    <!-- BRAND -->
    <div class="flex-shrink-0 border-b border-slate-100 px-5 py-5">
        <a href="{{ route($dashboardRoute) }}" class="group flex items-center gap-3">
            <div
                class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl"
            >
                <img
                    src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                    alt=""
                    class="h-11 w-11 rounded-xl object-contain"
                >
            </div>

            <div class="min-w-0">
                <p class="text-sm font-bold uppercase tracking-wide text-slate-900">
                    Barangay Esperanza
                </p>

                <p class="mt-0.5 text-xs font-medium text-emerald-700">
                    Health Center
                </p>
            </div>
        </a>
    </div>

    <!-- PROFILE -->
    <div class="flex-shrink-0 px-5 py-4">
        <div class="flex items-center gap-3 p-3">
            <div
                class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-full"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a7.5 7.5 0 0115 0"
                    />
                </svg>
            </div>

            <div class="min-w-0">
                <p class="truncate text-sm font-semibold text-slate-900">
                    {{ auth()->user()->name }}
                </p>

                <p class="mt-0.5 truncate text-xs text-slate-500">
                    {{ auth()->user()->role }}
                </p>
            </div>
        </div>
    </div>

    <!-- NAVIGATION -->
    <nav id="sidebar-nav" class="flex-1 overflow-y-auto px-4 pb-5">
        <!-- MAIN -->
        <div>
            <p class="mb-2 px-2 text-[10px] font-bold uppercase tracking-widest">
                Main
            </p>

            <a
                href="{{ route($dashboardRoute) }}"
                class="{{ request()->routeIs($dashboardRoute) ? 'bg-emerald-50' : '' }} flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 10.5L12 3l9 7.5v9a1.5 1.5 0 01-1.5 1.5h-15A1.5 1.5 0 013 19.5v-9z"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 21v-6h6v6"
                    />
                </svg>

                <span>Dashboard</span>
            </a>

            <a
                href="{{ route('users.index') }}"
                class="{{ request()->routeIs('users.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"
                    />
                    <circle
                        cx="9"
                        cy="7"
                        r="4"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                    />
                </svg>

                <span>Users</span>
            </a>
        </div>

        <!-- RECORDS -->
        <div>
            <p class="mb-2 px-2 text-[10px] font-bold uppercase tracking-widest">
                Records
            </p>

            <a
                href="{{ route('households.index') }}"
                class="{{ request()->routeIs('households.*') ? 'bg-emerald-50' : '' }} flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-5 7 5v13M9 21v-6h6v6M8 10h.01M12 10h.01M16 10h.01" />
                </svg>
                <span>Households</span>
            </a>

            <a
                href="{{ route('residents.index') }}"
                class="{{ request()->routeIs('residents.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3.5" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 21a7 7 0 0114 0" />
                </svg>
                <span>Residents</span>
            </a>

            <a
                href="{{ route('health-records.index') }}"
                class="{{ request()->routeIs('health-records.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h9l3 3v15H6V3z" />
                    <path stroke-linecap="round" d="M9 11h6M9 15h6M9 7h3" />
                </svg>
                <span>Health Records</span>
            </a>

            <a
                href="{{ route('health-visits.index') }}"
                class="{{ request()->routeIs('health-visits.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6M10 3v2h4V3M7 5h10a2 2 0 012 2v13H5V7a2 2 0 012-2z" />
                    <path stroke-linecap="round" d="M9 11h6M9 15h4" />
                </svg>
                <span>Health Visits</span>
            </a>
        </div>

        <!-- PROGRAMS -->
        <div>
            <p class="mb-2 px-2 text-[10px] font-bold uppercase tracking-widest">
                Programs
            </p>

            <a
                href="{{ route('immunizations.index') }}"
                class="{{ request()->routeIs('immunizations.*') ? 'bg-emerald-50' : '' }} flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 3v18M16 3v18M5 7h6M13 17h6M5 17h6M13 7h6" />
                </svg>
                <span>Immunization</span>
            </a>

            <a
                href="{{ route('maternal-care.index') }}"
                class="{{ request()->routeIs('maternal-care.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a5 5 0 0110 0M18 8a3 3 0 11-6 0" />
                </svg>
                <span>Maternal Care</span>
            </a>

            <a
                href="{{ route('child-health.index') }}"
                class="{{ request()->routeIs('child-health.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <circle cx="12" cy="8" r="3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21a5 5 0 0110 0M9 14h6" />
                </svg>
                <span>Child Health</span>
            </a>

            <a
                href="{{ route('senior-citizens.index') }}"
                class="{{ request()->routeIs('senior-citizens.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <circle cx="12" cy="7" r="3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 21a7 7 0 0114 0M8 14h8" />
                </svg>
                <span>Senior Citizens</span>
            </a>
        </div>

        <!-- OPERATIONS -->
        <div>
            <p class="mb-2 px-2 text-[10px] font-bold uppercase tracking-widest">
                Operations
            </p>

            <a
                href="{{ route('schedule.index') }}"
                class="{{ request()->routeIs('schedule.*') ? 'bg-emerald-50' : '' }} flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <rect x="3" y="4" width="18" height="17" rx="2" />
                    <path stroke-linecap="round" d="M16 2v4M8 2v4M3 9h18M8 13h.01M12 13h.01M16 13h.01M8 17h.01M12 17h.01" />
                </svg>
                <span>Schedule</span>
            </a>

            <a
                href="{{ route('medical-inventories.index') }}"
                class="{{ request()->routeIs('medical-inventories.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 5h12v16H6zM9 3h6v4H9z" />
                    <path stroke-linecap="round" d="M9 11h6M9 15h4" />
                </svg>
                <span>Medical Inventory</span>
            </a>

            <a
                href="{{ route('announcements.index') }}"
                class="{{ request()->routeIs('announcements.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 11h4l9-5v12l-9-5H4v-2z" />
                    <path stroke-linecap="round" d="M8 13l1.5 6H7l-1.5-6" />
                </svg>
                <span>Announcements</span>
            </a>

            <a
                href="{{ route('notifications.index') }}"
                class="{{ request()->routeIs('notifications.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 8a6 6 0 00-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9M10 21h4" />
                </svg>
                <span>Notifications</span>
            </a>
        </div>

        <!-- MANAGEMENT -->
        <div>
            <p class="mb-2 px-2 text-[10px] font-bold uppercase tracking-widest">
                Management
            </p>

            <a
                href="{{ route('reports.index') }}"
                class="{{ request()->routeIs('reports.*') ? 'bg-emerald-50' : '' }} flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5M4 19h17" />
                    <path stroke-linecap="round" d="M8 16v-5M12 16V8M16 16v-7M20 16v-4" />
                </svg>
                <span>Reports</span>
            </a>

            <a
                href="{{ route('analytics.index') }}"
                class="{{ request()->routeIs('analytics.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19h16M7 16V9M12 16V5M17 16v-8" />
                </svg>
                <span>Analytics</span>
            </a>

            <a
                href="{{ route('audit-logs.index') }}"
                class="{{ request()->routeIs('audit-logs.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 4h12v16H6z" />
                    <path stroke-linecap="round" d="M9 8h6M9 12h6M9 16h4" />
                </svg>
                <span>Audit Logs</span>
            </a>

            <a
                href="{{ $backupsUrl }}"
                class="{{ request()->is('backups*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12M7 8l5-5 5 5M5 14v5a2 2 0 002 2h10a2 2 0 002-2v-5" />
                </svg>
                <span>Backups</span>
            </a>

            <a
                href="{{ route('settings.index') }}"
                class="{{ request()->routeIs('settings.*') ? 'bg-emerald-50' : '' }} mt-1 flex items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8">
                    <circle cx="12" cy="12" r="3" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.7 1.7 0 00.34 1.88l.06.06-1.7 1.7-.06-.06a1.7 1.7 0 00-1.88-.34 1.7 1.7 0 00-1.02 1.55V20h-2.4v-.09a1.7 1.7 0 00-1.02-1.55 1.7 1.7 0 00-1.88.34l-.06.06-1.7-1.7.06-.06A1.7 1.7 0 008.6 15a1.7 1.7 0 00-1.55-1.02H7v-2.4h.05A1.7 1.7 0 008.6 10a1.7 1.7 0 00-.34-1.88L8.2 8.06l1.7-1.7.06.06a1.7 1.7 0 001.88.34A1.7 1.7 0 0012.86 5.2V5h2.4v.2a1.7 1.7 0 001.02 1.56 1.7 1.7 0 001.88-.34l.06-.06 1.7 1.7-.06.06A1.7 1.7 0 0019.52 10c.14.61.7 1.02 1.32 1.02H21v2.4h-.16A1.7 1.7 0 0019.4 15z" />
                </svg>
                <span>System Settings</span>
            </a>
        </div>
    </nav>

    <!-- SIGN OUT -->
    <div class="flex shrink-0 items-center gap-2 border-t border-slate-100 px-4 py-4" data-assistant-slot>
        <form method="POST" action="{{ route('logout') }}" class="min-w-0 flex-1">
            @csrf

            <button
                type="submit"
                class="flex w-full items-center gap-3 px-3 py-2.5 text-sm font-medium"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4"
                    />
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 17l5-5-5-5M15 12H3"
                    />
                </svg>

                <span>Sign Out</span>
            </button>
        </form>
    </div>

    <script>
        (function () {
            const nav = document.getElementById('sidebar-nav');
            if (!nav) return;

            const key = 'adminSidebarScrollTop';

            // Restore the saved position from the previous page.
            const saved = sessionStorage.getItem(key);

            if (saved !== null) {
                nav.scrollTop = parseInt(saved, 10);
            } else {
                // First visit: center the active link inside the nav only.
                const active = nav.querySelector('.bg-emerald-50');
                if (active) {
                    nav.scrollTop = active.offsetTop - nav.clientHeight / 2 + active.offsetHeight / 2;
                }
            }

            // Save the position right before the page changes.
            window.addEventListener('pagehide', () => {
                sessionStorage.setItem(key, nav.scrollTop);
            });
        })();
    </script>
</aside>