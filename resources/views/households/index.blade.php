<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Households | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage household records for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           MASTER GOVERNMENT-STYLE CLAYMORPHISM
           HOUSEHOLD MANAGEMENT
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

            --text: #164238;
            --text-dark: #234E43;
            --text-muted: #6D817A;
            --text-soft: #9AA9A4;

            --danger: #B42323;
            --danger-light: #DC2626;

            --warning: #8A6A28;

            --border-soft: rgba(210, 225, 218, 0.60);
            --border-white: rgba(255, 255, 255, 0.90);

            --shadow-dark: rgba(107, 134, 124, 0.22);
            --shadow-dark-soft: rgba(107, 134, 124, 0.14);
            --shadow-light: rgba(255, 255, 255, 0.92);
        }

        /* =========================================================
           BASE
        ========================================================= */

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
        }

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
                radial-gradient(
                    circle at top left,
                    rgba(255, 255, 255, 0.92),
                    transparent 31%
                ),
                radial-gradient(
                    circle at top right,
                    rgba(22, 139, 112, 0.055),
                    transparent 34%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1 0%,
                    #F5FAF7 52%,
                    #EDF5F0 100%
                );
        }

        /* =========================================================
           STICKY TOP HEADER
        ========================================================= */

        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow:
                0 5px 18px rgba(107, 134, 124, 0.08),
                0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-mobile-button {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EAF2EE
            );
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                color 0.18s ease;
        }

        .clay-mobile-button:hover {
            transform: translateY(-1px);
            color: var(--primary);
        }

        .clay-mobile-button:active {
            transform: translateY(0);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.12),
                inset -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        /* =========================================================
           PAGE TYPOGRAPHY
        ========================================================= */

        .clay-category {
            color: var(--primary);
            letter-spacing: 0.08em;
        }

        .clay-title {
            color: var(--text);
        }

        .clay-description {
            color: var(--text-muted);
        }

        .clay-heading-wrap {
            position: relative;
        }

        .clay-heading-accent {
            position: absolute;
            left: -16px;
            top: 4px;
            width: 4px;
            height: calc(100% - 8px);
            min-height: 62px;
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.16),
                -1px -1px 3px rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           CLAY SURFACES
        ========================================================= */

        .clay-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );
            border: 1px solid var(--border-white);
            box-shadow:
                9px 9px 20px var(--shadow-dark),
                -9px -9px 20px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-raised {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EAF2EE
            );
            border: 1px solid rgba(255, 255, 255, 0.90);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, 0.15),
                -5px -5px 12px rgba(255, 255, 255, 0.92);
        }

        .clay-inset {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F8FCFA
            );
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           ICON TILES
        ========================================================= */

        .clay-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.42);
        }

        .clay-icon-green {
            background: linear-gradient(
                145deg,
                #E7F5EE,
                #D9ECE4
            );
            color: var(--primary-dark);
        }

        .clay-icon-orange {
            background: linear-gradient(
                145deg,
                #FFF4E9,
                #F8E8D7
            );
            color: #C96822;
        }

        .clay-icon-blue {
            background: linear-gradient(
                145deg,
                #ECF4FA,
                #DDEAF3
            );
            color: #4F7CAC;
        }

        /* =========================================================
           PRIMARY BUTTON
        ========================================================= */

        .clay-primary {
            background: linear-gradient(
                145deg,
                #168B70,
                #0F6F5A
            );
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow:
                5px 5px 12px rgba(15, 76, 58, 0.22),
                -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                filter 0.18s ease;
        }

        .clay-primary:hover {
            transform: translateY(-1px);
            filter: brightness(1.04);
            box-shadow:
                7px 7px 15px rgba(15, 76, 58, 0.24),
                -5px -5px 11px rgba(255, 255, 255, 0.60);
        }

        .clay-primary:active {
            transform: translateY(0);
            box-shadow:
                inset 3px 3px 7px rgba(5, 60, 45, 0.22),
                inset -3px -3px 7px rgba(255, 255, 255, 0.24);
        }

        /* =========================================================
           SECONDARY BUTTON
        ========================================================= */

        .clay-secondary {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EAF2EE
            );
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, 0.90);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.94);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease;
        }

        .clay-secondary:hover {
            transform: translateY(-1px);
            background: linear-gradient(
                145deg,
                #FFFFFF,
                #EEF6F2
            );
        }

        .clay-secondary:active {
            transform: translateY(0);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        /* =========================================================
           SEARCH PANEL
        ========================================================= */

        .clay-search-panel {
            position: relative;
            overflow: hidden;
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );
            border: 1px solid rgba(255, 255, 255, 0.90);
            border-radius: 24px;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.18),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-search-panel::after {
            content: "";
            position: absolute;
            right: -55px;
            top: -70px;
            width: 150px;
            height: 150px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.22);
            pointer-events: none;
        }

        .clay-input {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F8FCFA
            ) !important;
            color: var(--text) !important;
            border: 1px solid rgba(255, 255, 255, 0.92) !important;
            border-radius: 14px !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82) !important;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-input::placeholder {
            color: var(--text-soft) !important;
        }

        .clay-input:focus {
            border-color: rgba(22, 139, 112, 0.40) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86),
                0 0 0 3px rgba(22, 139, 112, 0.10) !important;
        }

        /* =========================================================
           RECORD COUNT
        ========================================================= */

        .clay-count {
            background: linear-gradient(
                145deg,
                #E8F6EF,
                #DDEEE6
            );
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.74);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.08),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           DATA TABLE
        ========================================================= */

        .clay-table {
            overflow: hidden;
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );
            border: 1px solid rgba(255, 255, 255, 0.90);
            border-radius: 26px;
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, 0.22),
                -9px -9px 20px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-table-head {
            background:
                linear-gradient(
                    180deg,
                    rgba(235, 244, 239, 0.98),
                    rgba(226, 238, 232, 0.96)
                );
        }

        .clay-table-row {
            background: rgba(255, 255, 255, 0.48);
            transition:
                background 0.18s ease,
                transform 0.18s ease;
        }

        .clay-table-row:hover {
            background: rgba(255, 255, 255, 0.70);
        }

        .clay-divider {
            border-color: rgba(210, 225, 218, 0.60);
        }

        /* =========================================================
           ACTION BUTTONS
        ========================================================= */

        .clay-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            border-radius: 11px;
            padding: 0.42rem 0.78rem;
            font-size: 0.75rem;
            font-weight: 700;
            white-space: nowrap;
            border: 1px solid rgba(255, 255, 255, 0.82);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease,
                color 0.18s ease;
        }

        .clay-action:hover {
            transform: translateY(-1px);
        }

        .clay-view {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EAF2EE
            );
            color: var(--primary-dark) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.12),
                -3px -3px 7px rgba(255, 255, 255, 0.90);
        }

        .clay-view:hover {
            color: var(--primary) !important;
        }

        .clay-edit {
            background: linear-gradient(
                145deg,
                #EDF8F2,
                #DDEFE6
            );
            color: #216B53 !important;
            border-color: rgba(18, 140, 90, 0.13);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.11),
                -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-edit:hover {
            background: linear-gradient(
                145deg,
                #E8F6EE,
                #D8EDE2
            );
        }

        .clay-delete {
            background: linear-gradient(
                145deg,
                #FCEFED,
                #F5E2E0
            );
            color: var(--danger) !important;
            border-color: rgba(180, 35, 35, 0.14);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.10),
                -3px -3px 7px rgba(255, 255, 255, 0.84);
        }

        .clay-delete:hover {
            background: linear-gradient(
                145deg,
                #FBE9E7,
                #F2DDDA
            );
        }

        /* =========================================================
           STATUS BADGES
        ========================================================= */

        .clay-status-active {
            background: linear-gradient(
                145deg,
                #E7F7EF,
                #DCEFE6
            );
            color: #0F6F5A;
            border: 1px solid rgba(18, 140, 90, 0.08);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.07),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        .clay-status-inactive {
            background: linear-gradient(
                145deg,
                #EEF3F0,
                #E3EAE6
            );
            color: var(--text-muted);
            border: 1px solid rgba(101, 126, 117, 0.08);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.06),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           SUCCESS MESSAGE
        ========================================================= */

        .clay-success {
            background: linear-gradient(
                145deg,
                #F1FAF5,
                #E2F2E9
            );
            border: 1px solid rgba(22, 139, 112, 0.13);
            color: #0F6F5A;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, 0.11),
                -5px -5px 12px rgba(255, 255, 255, 0.88);
        }

        /* =========================================================
           EMPTY STATE
        ========================================================= */

        .clay-empty-icon {
            background: linear-gradient(
                145deg,
                #E8F1EC,
                #DDE8E2
            );
            color: #789087;
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86);
        }

        /* =========================================================
           INFORMATION / SECURITY NOTICE
        ========================================================= */

        .clay-info {
            background: linear-gradient(
                145deg,
                #FBF7ED,
                #F2EBD9
            );
            border: 1px solid rgba(138, 106, 40, 0.12);
            box-shadow:
                6px 6px 14px rgba(107, 134, 124, 0.11),
                -6px -6px 14px rgba(255, 255, 255, 0.86);
        }

        /* =========================================================
           CONFIRMATION MODAL
        ========================================================= */

        .clay-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            background: rgba(22, 66, 56, 0.24);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .clay-confirm-overlay.is-open {
            display: flex;
        }

        .clay-confirm-box {
            width: min(100%, 420px);
            border-radius: 24px;
            padding: 1.5rem;
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EAF2EE
            );
            border: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow:
                14px 14px 30px rgba(57, 85, 75, 0.24),
                -12px -12px 28px rgba(255, 255, 255, 0.94);
            animation: clayModalIn 0.18s ease-out;
        }

        @keyframes clayModalIn {
            from {
                opacity: 0;
                transform: translateY(8px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .clay-confirm-icon {
            display: flex;
            height: 52px;
            width: 52px;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: linear-gradient(
                145deg,
                #FCEFED,
                #F2DFDC
            );
            color: var(--danger);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86);
        }

        .clay-confirm-account {
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F8FCFA
            );
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, 0.07),
                inset -2px -2px 5px rgba(255, 255, 255, 0.82);
        }

        .clay-confirm-cancel {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #EAF2EE
            );
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.90);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.90);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-confirm-cancel:hover {
            transform: translateY(-1px);
        }

        .clay-confirm-danger {
            background: linear-gradient(
                145deg,
                #DC2626,
                #B42323
            );
            color: #FFFFFF;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow:
                5px 5px 12px rgba(127, 29, 29, 0.20),
                -4px -4px 10px rgba(255, 255, 255, 0.46);
            transition:
                transform 0.18s ease,
                filter 0.18s ease;
        }

        .clay-confirm-danger:hover {
            filter: brightness(1.04);
            transform: translateY(-1px);
        }

        /* =========================================================
           FOCUS ACCESSIBILITY
        ========================================================= */

        .clay-households a:focus-visible,
        .clay-households button:focus-visible,
        .clay-households input:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 2px;
            box-shadow:
                0 0 0 3px rgba(255, 255, 255, 0.94),
                0 0 0 6px rgba(22, 139, 112, 0.18);
        }

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1023px) {
            .clay-heading-accent {
                display: none;
            }
        }

        @media (max-width: 639px) {
            .clay-search-panel {
                border-radius: 20px;
            }

            .clay-table {
                border-radius: 20px;
            }

            .clay-confirm-box {
                border-radius: 20px;
                padding: 1.25rem;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-households *,
            .clay-households *::before,
            .clay-households *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body class="clay-households antialiased">

    {{-- =========================================================
         ADMIN SIDEBAR
    ========================================================== --}}
    @include('dashboard.sidebar')

    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}
    <main class="min-h-screen lg:pl-72">

        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}
        <header class="clay-header sticky top-0 z-30">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Left --}}
                <div class="flex min-w-0 items-center gap-4">

                    {{-- Mobile Menu --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div class="min-w-0">

                        <p class="clay-category text-xs font-bold uppercase tracking-wider">
                            System Administrator
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Household Management
                        </h1>

                    </div>

                </div>

                {{-- Right --}}
                <div class="flex shrink-0 items-center gap-3">

                    @include('partials.notification-bell')

                    <div class="flex items-center gap-3">

                        <div class="hidden text-right sm:block">

                            <p class="text-sm font-bold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs font-medium text-[#6D817A]">
                                System Administrator
                            </p>

                        </div>

                       <div class="clay-profile-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>


                    </div>

                </div>

            </div>

        </header>

        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- =================================================
                 PAGE HEADING
            ================================================== --}}
            <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div class="clay-heading-wrap min-w-0 lg:ml-4">

                    <span
                        class="clay-heading-accent"
                        aria-hidden="true"
                    ></span>


                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Manage Households
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Register, search, view, and manage household information
                        within Barangay Esperanza Health Center.
                    </p>

                </div>

                <a
                    href="{{ route('households.create') }}"
                    class="clay-primary inline-flex min-h-[44px] shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 5v14M5 12h14"
                        />
                    </svg>

                    Add Household
                </a>

            </div>

            {{-- =================================================
                 SUCCESS MESSAGE
            ================================================== --}}
            @if (session('success'))

                <div class="clay-success mb-6 rounded-2xl px-4 py-3.5">

                    <div class="flex items-start gap-3">

                        <div
                            class="clay-icon clay-icon-green mt-0.5 h-8 w-8 rounded-xl"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m5 12 4 4L19 6"
                                />
                            </svg>
                        </div>

                        <p class="pt-1 text-sm font-semibold">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif

            @if (session('error'))
                <div role="alert" class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3.5 text-sm font-semibold text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- =================================================
                 SEARCH PANEL
            ================================================== --}}
            <section class="clay-search-panel mb-6 rounded-[24px] p-4 sm:p-5">

                <div class="relative z-10 mb-4 flex items-start gap-3">

                    <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">

                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>

                    </div>

                    <div>

                        <p class="text-sm font-bold text-[#164238]">
                            Search Household Records
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                            Search by household code, household head, address, or contact number.
                        </p>

                    </div>

                </div>

                <form
                    action="{{ route('households.index') }}"
                    method="GET"
                    class="relative z-10 flex flex-col gap-3 lg:flex-row"
                >

                    <div class="relative flex-1">

                        <svg
                            class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-[#6D817A]"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>

                        <input
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search household code, household head, address, or contact number..."
                            aria-label="Search household records"
                            class="clay-input w-full rounded-xl py-3 pl-11 pr-4 text-sm outline-none"
                        >

                    </div>

                    <button
                        type="submit"
                        class="clay-primary inline-flex min-h-[44px] items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                            />
                        </svg>

                        Search
                    </button>

                    @if ($search !== '')

                        <a
                            href="{{ route('households.index') }}"
                            class="clay-secondary inline-flex min-h-[44px] items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            Clear
                        </a>

                    @endif

                </form>

            </section>

            {{-- =================================================
                 DESKTOP TABLE
            ================================================== --}}
            <section class="clay-table hidden lg:block">

                <div class="flex flex-col gap-3 border-b border-white/70 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

                    <div class="flex items-center gap-3">

                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 10.5 12 3l9 7.5M5.25 9.75V21h13.5V9.75M9 21v-6h6v6"
                                />
                            </svg>

                        </div>

                        <div>

                            <h3 class="text-base font-bold text-[#164238]">
                                Household Records
                            </h3>

                            <p class="mt-1 text-xs text-[#6D817A]">
                                Registered households within Barangay Esperanza.
                            </p>

                        </div>

                    </div>

                    <div class="clay-count inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-bold">
                        {{ $households->total() }} Records
                    </div>

                </div>

                <div class="relative overflow-x-auto">

                    <table class="w-full min-w-[950px] table-fixed">

                        <colgroup>
                            <col class="w-[20%]">
                            <col class="w-[28%]">
                            <col class="w-[17%]">
                            <col class="w-[14%]">
                            <col class="w-[12%]">
                            <col class="w-[9%]">
                        </colgroup>

                        <thead class="clay-table-head sticky top-0 z-20">

                            <tr class="bg-[#F5FAF7] shadow-sm border-b border-white/90">

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Household ID
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Household Head
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Purok
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Status
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Members
                                </th>
                                <th scope="col" class="px-6 py-4"><span class="sr-only">Actions</span></th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($households as $household)

                                <tr class="clay-table-row border-b clay-divider last:border-b-0">

                                    <td class="px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="clay-icon clay-icon-green h-10 w-10 shrink-0 rounded-xl">

                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.8"
                                                    viewBox="0 0 24 24"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3 10.5 12 3l9 7.5M5.25 9.75V21h13.5V9.75M9 21v-6h6v6"
                                                    />
                                                </svg>

                                            </div>

                                            <div>

                                                <p class="whitespace-nowrap text-sm font-bold text-[#164238]">
                                                    {{ $household->household_code }}
                                                </p>

                                                <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                                    ID #{{ $household->id }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="px-6 py-4">

                                        <p class="break-words text-sm font-bold text-[#234E43]">
                                            {{ $household->household_head_name }}
                                        </p>

                                    </td>

                                    <td class="px-6 py-4">

                                        <p class="text-sm font-medium text-[#6D817A]">
                                            {{ $household->address ? Str::before($household->address, ',') : '—' }}
                                        </p>

                                    </td>

                                    <td class="px-6 py-4">

                                        @if ($household->status === 'Active')

                                            <span class="clay-status-active inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold">

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#168B70]"></span>

                                                Active

                                            </span>

                                        @else

                                            <span class="clay-status-inactive inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold">

                                                <span class="h-1.5 w-1.5 rounded-full bg-[#8FA19A]"></span>

                                                Inactive

                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-6 py-4 text-center text-sm font-medium text-[#6D817A]">
                                        {{ $household->residents_count }}
                                    </td>

                                    <td class="px-4 py-4">

                                        <div class="relative flex items-center justify-end">
                                            <button type="button" class="clay-action-menu-trigger flex h-10 w-10 items-center justify-center rounded-full text-[#6D817A] transition hover:text-[#164238]" aria-label="More actions for {{ $household->household_code }}" aria-expanded="false" data-menu-trigger>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <circle cx="10" cy="5" r="1.5"/>
                                                    <circle cx="10" cy="10" r="1.5"/>
                                                    <circle cx="10" cy="15" r="1.5"/>
                                                </svg>
                                            </button>

                                            <div class="clay-action-menu absolute right-0 top-full z-20 mt-2 hidden min-w-[180px] rounded-2xl border border-white/80 bg-[#F5FAF7] p-2 shadow-[0_12px_35px_rgba(107,134,124,0.18)]" data-menu-panel>
                                                <a href="{{ route('households.show', $household) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                                    View
                                                </a>
                                                <a href="{{ route('households.edit', $household) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/></svg>
                                                    Edit
                                                </a>
                                                <form id="delete-household-form-{{ $household->id }}" action="{{ route('households.destroy', $household) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm font-semibold text-[#B42323] transition hover:bg-[#FDF1F1]" data-delete-household data-form-id="delete-household-form-{{ $household->id }}" data-household-code="{{ $household->household_code }}" data-household-head="{{ $household->household_head_name }}" data-confirm-title="Delete this household?">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"/></svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="6" class="px-6 py-16 text-center">

                                        <div class="mx-auto max-w-sm">

                                            <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full">

                                                <svg
                                                    class="h-7 w-7"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="1.7"
                                                    viewBox="0 0 24 24"
                                                    aria-hidden="true"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M3 10.5 12 3l9 7.5M5.25 9.75V21h13.5V9.75M9 21v-6h6v6"
                                                    />
                                                </svg>

                                            </div>

                                            <h3 class="mt-4 text-sm font-bold text-[#164238]">
                                                No households found
                                            </h3>

                                            <p class="mt-1 text-sm leading-6 text-[#6D817A]">

                                                @if ($search !== '')
                                                    No household records match your search.
                                                @else
                                                    Start by registering the first household.
                                                @endif

                                            </p>

                                            @if ($search === '')

                                                <a
                                                    href="{{ route('households.create') }}"
                                                    class="clay-primary mt-5 inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                                                >
                                                    <svg
                                                        class="h-4 w-4"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.8"
                                                        viewBox="0 0 24 24"
                                                        aria-hidden="true"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M12 5v14M5 12h14"
                                                        />
                                                    </svg>

                                                    Add Household
                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                @if ($households->hasPages())

                    <div class="border-t border-white/70 px-6 py-4">
                        {{ $households->links() }}
                    </div>

                @endif

            </section>

            {{-- =================================================
                 MOBILE CARDS
            ================================================== --}}
            <section class="space-y-4 lg:hidden">

                @forelse ($households as $household)

                    <article class="clay-card rounded-[22px] p-5">

                        {{-- Card Header --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        viewBox="0 0 24 24"
                                        aria-hidden="true"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M3 10.5 12 3l9 7.5M5.25 9.75V21h13.5V9.75M9 21v-6h6v6"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-bold text-[#164238]">
                                        {{ $household->household_code }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                        ID #{{ $household->id }}
                                    </p>

                                </div>

                            </div>

                            @if ($household->status === 'Active')

                                <span class="clay-status-active inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold">

                                    <span class="h-1.5 w-1.5 rounded-full bg-[#168B70]"></span>

                                    Active

                                </span>

                            @else

                                <span class="clay-status-inactive inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold">

                                    <span class="h-1.5 w-1.5 rounded-full bg-[#8FA19A]"></span>

                                    Inactive

                                </span>

                            @endif

                        </div>

                        {{-- Card Details --}}
                        <div class="mt-5 space-y-4">

                            <div class="clay-inset rounded-xl p-3.5">

                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Household Head
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#234E43]">
                                    {{ $household->household_head_name }}
                                </p>

                            </div>

                            <div>

                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Address
                                </p>

                                <p class="mt-1 text-sm font-medium leading-6 text-[#6D817A]">
                                    {{ $household->address }}
                                </p>

                            </div>

                            <div>

                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Members
                                </p>

                                <p class="mt-1 text-sm font-medium text-[#6D817A]">
                                    {{ $household->residents_count }}
                                </p>

                            </div>

                            <div>

                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Contact Number
                                </p>

                                <p class="mt-1 text-sm font-medium text-[#6D817A]">
                                    {{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($household->contact_number) ?: '—' }}
                                </p>

                            </div>

                        </div>

                        {{-- Card Actions --}}
                        <div class="mt-5 border-t border-white/70 pt-4">
                            @component('partials.record-actions', ['label' => 'More actions for '.$household->household_code])

                            <a
                                href="{{ route('households.show', $household) }}"
                            >
                                @include('partials.record-action-icon', ['icon' => 'view'])
                                View
                            </a>

                            <a
                                href="{{ route('households.edit', $household) }}"
                            >
                                @include('partials.record-action-icon', ['icon' => 'edit'])
                                Edit
                            </a>

                            <form
                                id="delete-household-mobile-form-{{ $household->id }}"
                                action="{{ route('households.destroy', $household) }}"
                                method="POST"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="record-action-danger"
                                    data-delete-household
                                    data-form-id="delete-household-mobile-form-{{ $household->id }}"
                                    data-household-code="{{ $household->household_code }}"
                                    data-household-head="{{ $household->household_head_name }}"
                                    data-confirm-title="Delete this household?"
                                >
                                    @include('partials.record-action-icon', ['icon' => 'delete'])
                                    Delete
                                </button>

                            </form>

                            @endcomponent
                        </div>

                    </article>

                @empty

                    <div class="clay-card rounded-[22px] px-6 py-16 text-center">

                        <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full">

                            <svg
                                class="h-7 w-7"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.7"
                                viewBox="0 0 24 24"
                                aria-hidden="true"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3 10.5 12 3l9 7.5M5.25 9.75V21h13.5V9.75M9 21v-6h6v6"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-sm font-bold text-[#164238]">
                            No households found
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-[#6D817A]">

                            @if ($search !== '')
                                No household records match your search.
                            @else
                                Start by registering the first household.
                            @endif

                        </p>

                        @if ($search === '')

                            <a
                                href="{{ route('households.create') }}"
                                class="clay-primary mt-5 inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    viewBox="0 0 24 24"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 5v14M5 12h14"
                                    />
                                </svg>

                                Add Household
                            </a>

                        @endif

                    </div>

                @endforelse

                @if ($households->hasPages())

                    <div>
                        {{ $households->links() }}
                    </div>

                @endif

            </section>

            {{-- =================================================
                 INFORMATION NOTICE
            ================================================== --}}
            <div class="clay-info mt-6 rounded-2xl p-4 sm:p-5">

                <div class="flex items-start gap-3">

                    <div
                        class="clay-icon mt-0.5 h-9 w-9 rounded-xl bg-[#F6E8C8] text-[#8A6A28]"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14a2 2 0 0 0 1.73 3h16.32a2 2 0 0 0 1.73-3l-8.18-14a2 2 0 0 0-3.42 0Z"
                            />
                        </svg>
                    </div>

                    <div>

                        <h3 class="text-sm font-bold text-[#8A6A28]">
                            Household Records
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#806B47]">
                            Household information should be kept accurate and updated
                            to support proper resident registration and health-center
                            record management.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </main>

    {{-- =========================================================
         DELETE CONFIRMATION MODAL
    ========================================================== --}}
    <div
        id="deleteHouseholdModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteHouseholdModalTitle"
    >

        <div
            class="clay-confirm-box"
            role="document"
        >

            {{-- Icon --}}
            <div class="clay-confirm-icon">

                <svg
                    class="h-6 w-6"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86l-8.18 14a2 2 0 0 0 1.73 3h16.32a2 2 0 0 0 1.73-3l-8.18-14a2 2 0 0 0-3.42 0Z"
                    />
                </svg>

            </div>

            {{-- Text --}}
            <div class="mt-4">

                <h2
                    id="deleteHouseholdModalTitle"
                    class="text-lg font-bold text-[#164238]"
                >
                    Delete Household?
                </h2>

                <p class="mt-2 text-sm leading-6 text-[#6D817A]">
                    This will permanently remove the household, its residents and their related records,
                    and the household's SMS delivery records. Please confirm that you want to continue.
                </p>

            </div>

            {{-- Affected Household --}}
            <div class="clay-confirm-account mt-4 rounded-xl p-4">

                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                    Household
                </p>

                <p
                    id="deleteHouseholdCode"
                    class="mt-1 text-sm font-bold text-[#164238]"
                >
                    —
                </p>

                <p
                    id="deleteHouseholdHead"
                    class="mt-1 text-xs font-medium text-[#6D817A]"
                >
                    —
                </p>

            </div>

            {{-- Buttons --}}
            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                <button
                    type="button"
                    id="deleteHouseholdCancel"
                    class="clay-confirm-cancel inline-flex min-h-[42px] items-center justify-center rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="deleteHouseholdConfirm"
                    class="clay-confirm-danger inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    <svg
                        class="h-4 w-4"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 7h12m-9 0v10m6-10v10M9 7V5.75A1.75 1.75 0 0 1 10.75 4h2.5A1.75 1.75 0 0 1 15 5.75V7m-8 0 .75 12.25A2 2 0 0 0 9.75 21h4.5a2 2 0 0 0 1.99-1.75L17 7"
                        />
                    </svg>

                    Delete Household
                </button>

            </div>

        </div>

    </div>

    {{-- =========================================================
         FRONTEND INTERACTIONS
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const modal = document.getElementById('deleteHouseholdModal');
            const cancelButton = document.getElementById('deleteHouseholdCancel');
            const confirmButton = document.getElementById('deleteHouseholdConfirm');

            const householdCode = document.getElementById('deleteHouseholdCode');
            const householdHead = document.getElementById('deleteHouseholdHead');

            let activeFormId = null;

            const deleteButtons = document.querySelectorAll(
                '[data-delete-household]'
            );

            function openDeleteModal(button) {

                activeFormId = button.dataset.formId || null;

                householdCode.textContent =
                    button.dataset.householdCode || 'Household record';

                householdHead.textContent =
                    button.dataset.householdHead || '';

                modal.classList.add('is-open');
                modal.setAttribute('aria-hidden', 'false');

                document.body.style.overflow = 'hidden';

                window.setTimeout(function () {
                    cancelButton.focus();
                }, 50);
            }

            function closeDeleteModal() {

                modal.classList.remove('is-open');
                modal.setAttribute('aria-hidden', 'true');

                document.body.style.overflow = '';

                activeFormId = null;
            }

            deleteButtons.forEach(function (button) {

                button.addEventListener('click', function () {
                    openDeleteModal(button);
                });

            });

            cancelButton.addEventListener('click', function () {
                closeDeleteModal();
            });

            confirmButton.addEventListener('click', function () {

                if (!activeFormId) {
                    closeDeleteModal();
                    return;
                }

                const form = document.getElementById(activeFormId);

                if (form) {
                    form.submit();
                }

            });

            modal.addEventListener('click', function (event) {

                if (event.target === modal) {
                    closeDeleteModal();
                }

            });

            document.addEventListener('keydown', function (event) {

                if (
                    event.key === 'Escape' &&
                    modal.classList.contains('is-open')
                ) {
                    closeDeleteModal();
                }

            });


        });
    </script>

</body>
</html>