<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Maternal Care | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage pregnancy, prenatal care, and maternal health records of residents in Barangay Esperanza."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           MATERNAL CARE MANAGEMENT
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
            --warning: #8A6A28;

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

        /* =========================================================
           BASE
        ========================================================= */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 100px;
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
                    circle at 0% 0%,
                    rgba(255, 255, 255, 0.92),
                    transparent 34%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(22, 139, 112, 0.055),
                    transparent 32%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1 0%,
                    #F5FAF7 52%,
                    #EDF5F0 100%
                );
        }

        ::selection {
            color: #FFFFFF;
            background: var(--primary-dark);
        }

        /* =========================================================
           HEADER
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
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark);
            border: 1px solid var(--border-white);
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

        .clay-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.12),
                -4px -4px 9px rgba(255, 255, 255, 0.88);
        }

        /* =========================================================
           TYPOGRAPHY
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
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow:
                8px 8px 18px var(--shadow-dark),
                -8px -8px 18px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-card:hover {
            box-shadow:
                10px 10px 22px rgba(107, 134, 124, 0.19),
                -10px -10px 22px rgba(255, 255, 255, 0.94),
                inset 1px 1px 0 rgba(255, 255, 255, 0.88);
        }

        .clay-raised {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow:
                5px 5px 12px var(--shadow-medium),
                -5px -5px 12px var(--shadow-light);
        }

        .clay-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           ICONS
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
            background: linear-gradient(145deg, #E7F5EE, #D9ECE4);
            color: var(--primary-dark);
        }

        /* =========================================================
           BUTTONS
        ========================================================= */

        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
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

        .clay-secondary {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            border: 1px solid var(--border-white);
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
            background: linear-gradient(145deg, #FFFFFF, #EEF6F2);
        }

        .clay-secondary:active {
            transform: translateY(0);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-primary:disabled,
        .clay-secondary:disabled {
            cursor: not-allowed;
            opacity: 0.55;
            transform: none;
            box-shadow: none;
        }

        /* =========================================================
           SEARCH PANEL
        ========================================================= */

        .clay-search-panel {
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: var(--radius-xl);
            box-shadow:
                8px 8px 18px rgba(107, 134, 124, 0.16),
                -8px -8px 18px rgba(255, 255, 255, 0.92),
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
            min-height: 46px;
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA) !important;
            color: var(--text) !important;
            border: 1px solid rgba(255, 255, 255, 0.92) !important;
            border-radius: var(--radius-md) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82) !important;
            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-input::placeholder {
            color: var(--text-soft) !important;
            opacity: 1;
        }

        .clay-input:focus {
            border-color: rgba(22, 139, 112, 0.55) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86),
                0 0 0 3px rgba(22, 139, 112, 0.12) !important;
        }

        /* =========================================================
           RECORD COUNTS
        ========================================================= */

        .clay-count {
            background: linear-gradient(145deg, #E8F6EF, #DDEEE6);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.74);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.08),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           TABLE
        ========================================================= */

        .clay-table {
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 26px;
            box-shadow:
                8px 8px 18px rgba(107, 134, 124, 0.18),
                -8px -8px 18px rgba(255, 255, 255, 0.92),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        .clay-table-head {
            background: linear-gradient(
                180deg,
                rgba(235, 244, 239, 0.98),
                rgba(226, 238, 232, 0.96)
            );
        }

        .clay-table-row {
            background: rgba(255, 255, 255, 0.48);
            transition: background 0.18s ease;
        }

        .clay-table-row:hover {
            background: rgba(255, 255, 255, 0.78);
        }

        .clay-divider {
            border-color: var(--border-soft);
        }

        /* =========================================================
           TABLE ACTION BUTTONS
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
            line-height: 1.25;
            white-space: nowrap;
            cursor: pointer;
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

        .clay-action:active {
            transform: translateY(0);
            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, 0.12),
                inset -2px -2px 5px rgba(255, 255, 255, 0.82);
        }

        .clay-view {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.12),
                -3px -3px 7px rgba(255, 255, 255, 0.90);
        }

        .clay-view:hover {
            color: var(--primary) !important;
        }

        .clay-edit {
            background: linear-gradient(145deg, #EDF8F2, #DDEFE6);
            color: #216B53 !important;
            border-color: rgba(18, 140, 90, 0.13);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.11),
                -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-edit:hover {
            background: linear-gradient(145deg, #E8F6EE, #D8EDE2);
        }

        .clay-delete {
            background: linear-gradient(145deg, #FCEFED, #F5E2E0);
            color: var(--danger) !important;
            border-color: rgba(180, 35, 35, 0.14);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.10),
                -3px -3px 7px rgba(255, 255, 255, 0.84);
        }

        .clay-delete:hover {
            background: linear-gradient(145deg, #FBE9E7, #F2DDDA);
        }

        /* =========================================================
           STATUS BADGES
        ========================================================= */

        .clay-status-pregnant {
            background: linear-gradient(145deg, #E7F7EF, #DCEFE6);
            color: #126647;
            border: 1px solid rgba(18, 140, 90, 0.08);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.07),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        .clay-status-delivered {
            background: linear-gradient(145deg, #EAF2EE, #DDE8E2);
            color: #385C52;
            border: 1px solid rgba(56, 92, 82, 0.08);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.07),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        .clay-status-miscarriage {
            background: linear-gradient(145deg, #FCF1DF, #F6E5C9);
            color: #8B5B16;
            border: 1px solid rgba(139, 91, 22, 0.10);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.07),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        .clay-status-stillbirth {
            background: linear-gradient(145deg, #FCEDEC, #F5DCDA);
            color: #A52626;
            border: 1px solid rgba(165, 38, 38, 0.10);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.07),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        .clay-status-default {
            background: linear-gradient(145deg, #EEF3F0, #E3EAE6);
            color: #52665E;
            border: 1px solid rgba(101, 126, 117, 0.08);
            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.06),
                -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           FEEDBACK MESSAGES
        ========================================================= */

        .clay-success {
            background: linear-gradient(145deg, #F1FAF5, #E2F2E9);
            border: 1px solid rgba(22, 139, 112, 0.13);
            color: #0F6F5A;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, 0.11),
                -5px -5px 12px rgba(255, 255, 255, 0.88);
        }

        .clay-info {
            background: linear-gradient(145deg, #FBF7ED, #F2EBD9);
            border: 1px solid rgba(138, 106, 40, 0.12);
            box-shadow:
                6px 6px 14px rgba(107, 134, 124, 0.11),
                -6px -6px 14px rgba(255, 255, 255, 0.86);
        }

        /* =========================================================
           EMPTY STATES
        ========================================================= */

        .clay-empty-icon {
            background: linear-gradient(145deg, #E8F1EC, #DDE8E2);
            color: #789087;
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86);
        }

        /* =========================================================
           DELETE CONFIRMATION MODAL
        ========================================================= */

        .clay-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;
            display: none;
            align-items: center;
            justify-content: center;
            overflow-y: auto;
            padding: 1rem;
            background: rgba(22, 66, 56, 0.34);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
        }

        .clay-confirm-overlay.is-open {
            display: flex;
        }

        .clay-confirm-box {
            width: min(100%, 420px);
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
            border-radius: 24px;
            padding: 1.5rem;
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
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
            background: linear-gradient(145deg, #FCEFED, #F2DFDC);
            color: var(--danger);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.08),
                inset -3px -3px 7px rgba(255, 255, 255, 0.86);
        }

        .clay-confirm-account {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, 0.07),
                inset -2px -2px 5px rgba(255, 255, 255, 0.82);
        }

        .clay-confirm-cancel {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
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
            background: linear-gradient(145deg, #DC2626, #B42323);
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

        .clay-confirm-danger:active,
        .clay-confirm-cancel:active {
            transform: translateY(0);
        }

        /* =========================================================
           PAGINATION
        ========================================================= */

        nav[aria-label="Pagination Navigation"] a,
        nav[aria-label="Pagination Navigation"] span,
        .pagination a,
        .pagination span {
            border-radius: 10px;
        }

        nav[aria-label="Pagination Navigation"] a {
            color: var(--primary-dark);
            transition: background 0.18s ease, color 0.18s ease;
        }

        nav[aria-label="Pagination Navigation"] a:hover {
            background: #E1F0E8;
            color: var(--primary-deep);
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================= */

        .clay-households a:focus-visible,
        .clay-households button:focus-visible,
        .clay-households input:focus-visible,
        .clay-households select:focus-visible,
        .clay-households textarea:focus-visible,
        .clay-confirm-overlay button:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
            box-shadow:
                0 0 0 3px rgba(255, 255, 255, 0.94),
                0 0 0 6px rgba(22, 139, 112, 0.18);
        }

        /* =========================================================
           SIDEBAR AND RESPONSIVE LAYOUT
        ========================================================= */

        #sidebar-overlay {
            transition: opacity 180ms ease;
        }

        @media (max-width: 1023px) {
            .clay-heading-accent {
                display: none;
            }

            main {
                padding-left: 0;
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

            .clay-action {
                min-height: 38px;
                padding-right: 0.45rem;
                padding-left: 0.45rem;
                font-size: 0.7rem;
            }

            .clay-card:hover {
                transform: none;
            }
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================= */

        @media (prefers-reduced-motion: reduce) {
            .clay-households *,
            .clay-households *::before,
            .clay-households *::after,
            .clay-confirm-overlay,
            .clay-confirm-box {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
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
                        aria-controls="sidebar-overlay"
                        aria-expanded="false"
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
                            Maternal Care
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
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>

                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING --}}
            <div class="mb-7 flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">

                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">
                        Maternal Health Services
                    </p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Maternal Care Management
                    </h2>

                    <p class="clay-description mt-2 max-w-2xl text-sm leading-6">
                        Manage pregnancy records, prenatal visits, delivery information,
                        and maternal health follow-ups in one organized workspace.
                    </p>
                </div>

                <a
                    href="{{ route('maternal-care.create') }}"
                    class="clay-primary inline-flex min-h-[44px] w-full shrink-0 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
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

                    Add Maternal Record
                </a>

            </div>

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div
                    class="clay-success mb-6 rounded-2xl px-4 py-3.5"
                    role="status"
                    aria-live="polite"
                >
                    <div class="flex items-start gap-3">
                        <div class="clay-icon clay-icon-green mt-0.5 h-8 w-8 rounded-xl">
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

            {{-- SEARCH PANEL --}}
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
                            Find Maternal Records
                        </p>

                        <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                            Search using a resident's name or available record details.
                        </p>
                    </div>
                </div>

                <form
                    action="{{ route('maternal-care.index') }}"
                    method="GET"
                    class="relative z-10 flex flex-col gap-3 lg:flex-row"
                >
                    <div class="relative min-w-0 flex-1">
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
                            id="maternal-search"
                            type="search"
                            name="search"
                            value="{{ $search }}"
                            placeholder="Search resident, status, delivery type..."
                            aria-label="Search maternal care records"
                            class="clay-input w-full py-3 pl-11 pr-4 text-sm outline-none"
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
                            href="{{ route('maternal-care.index') }}"
                            class="clay-secondary inline-flex min-h-[44px] items-center justify-center rounded-xl px-5 py-2.5 text-sm font-bold"
                        >
                            Clear
                        </a>
                    @endif
                </form>

            </section>

            {{-- DESKTOP TABLE --}}
            <section
                class="clay-table hidden lg:block"
                aria-label="Maternal care records"
            >

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
                                    d="M12 21s-7-4.35-7-10a4 4 0 0 1 7-2.65A4 4 0 0 1 19 11c0 5.65-7 10-7 10Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-3-3v6"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-base font-bold text-[#164238]">
                                Maternal Care Records
                            </h3>

                            <p class="mt-1 text-xs text-[#6D817A]">
                                Pregnancy information, delivery status, and prenatal visit history.
                            </p>
                        </div>
                    </div>

                    <div class="clay-count inline-flex w-fit rounded-full px-3 py-1.5 text-xs font-bold">
                        {{ $maternalCares->total() }} Records
                    </div>

                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[1000px]">

                        <thead class="clay-table-head">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Resident
                                </th>

                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Pregnancy
                                </th>

                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Status
                                </th>

                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Expected Delivery
                                </th>

                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Prenatal Visits
                                </th>

                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#6D817A]">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($maternalCares as $maternalCare)
                                <tr class="clay-table-row border-b clay-divider last:border-b-0">

                                    {{-- Resident --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl text-sm font-bold">
                                                {{ strtoupper(substr($maternalCare->resident->first_name ?? 'R', 0, 1)) }}
                                            </div>

                                            <div class="min-w-0">
                                                <p class="text-sm font-bold text-[#164238]">
                                                    {{ $maternalCare->resident->full_name }}
                                                </p>

                                                <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                                    Resident #{{ $maternalCare->resident->id }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- Pregnancy --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($maternalCare->pregnancy_number)
                                            <p class="text-sm font-bold text-[#234E43]">
                                                Pregnancy #{{ $maternalCare->pregnancy_number }}
                                            </p>
                                        @else
                                            <p class="text-sm font-medium text-[#9AA9A4]">
                                                Not specified
                                            </p>
                                        @endif
                                    </td>

                                    {{-- Status --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @php
                                            $statusClasses = match ($maternalCare->pregnancy_status) {
                                                'Pregnant' => 'clay-status-pregnant',
                                                'Delivered' => 'clay-status-delivered',
                                                'Miscarriage' => 'clay-status-miscarriage',
                                                'Stillbirth' => 'clay-status-stillbirth',
                                                'Completed' => 'clay-status-default',
                                                default => 'clay-status-default',
                                            };
                                        @endphp

                                        <span class="{{ $statusClasses }} inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold">
                                            <span class="h-1.5 w-1.5 rounded-full bg-current" aria-hidden="true"></span>
                                            {{ $maternalCare->pregnancy_status }}
                                        </span>
                                    </td>

                                    {{-- Expected Delivery --}}
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @if ($maternalCare->expected_delivery_date)
                                            <p class="text-sm font-medium text-[#6D817A]">
                                                {{ $maternalCare->expected_delivery_date->format('M d, Y') }}
                                            </p>
                                        @else
                                            <p class="text-sm font-medium text-[#9AA9A4]">
                                                Not specified
                                            </p>
                                        @endif
                                    </td>

                                    {{-- Prenatal Visits --}}
                                    <td class="px-6 py-4">
                                        <span class="clay-count inline-flex min-w-[36px] items-center justify-center rounded-full px-3 py-1.5 text-xs font-bold">
                                            {{ $maternalCare->prenatal_visit_count ?? 0 }}
                                        </span>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-end gap-2">

                                            <a
                                                href="{{ route('maternal-care.show', $maternalCare) }}"
                                                class="clay-action clay-view"
                                                aria-label="View maternal record for {{ $maternalCare->resident->full_name }}"
                                            >
                                                View
                                            </a>

                                            <a
                                                href="{{ route('maternal-care.edit', $maternalCare) }}"
                                                class="clay-action clay-edit"
                                                aria-label="Edit maternal record for {{ $maternalCare->resident->full_name }}"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                id="delete-maternal-form-{{ $maternalCare->id }}"
                                                action="{{ route('maternal-care.destroy', $maternalCare) }}"
                                                method="POST"
                                            >
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="button"
                                                    class="clay-action clay-delete"
                                                    data-delete-maternal
                                                    data-form-id="delete-maternal-form-{{ $maternalCare->id }}"
                                                    data-resident-name="{{ $maternalCare->resident->full_name }}"
                                                    data-record-detail="{{ $maternalCare->pregnancy_number ? 'Pregnancy #' . $maternalCare->pregnancy_number . ' · ' : '' }}{{ $maternalCare->pregnancy_status }}"
                                                    data-confirm-title="Delete this maternal care record?"
                                                    aria-label="Delete maternal record for {{ $maternalCare->resident->full_name }}"
                                                >
                                                    Delete
                                                </button>
                                            </form>

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
                                                        d="M12 21s-7-4.35-7-10a4 4 0 0 1 7-2.65A4 4 0 0 1 19 11c0 5.65-7 10-7 10Z"
                                                    />
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12h6m-3-3v6"
                                                    />
                                                </svg>
                                            </div>

                                            <h3 class="mt-4 text-sm font-bold text-[#164238]">
                                                No maternal care records found
                                            </h3>

                                            <p class="mt-1 text-sm leading-6 text-[#6D817A]">
                                                @if ($search !== '')
                                                    No records match your search. Try another keyword or clear the search.
                                                @else
                                                    Start by adding a maternal care record for a female resident.
                                                @endif
                                            </p>

                                            @if ($search === '')
                                                <a
                                                    href="{{ route('maternal-care.create') }}"
                                                    class="clay-primary mt-5 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
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
                                                    Add Maternal Record
                                                </a>
                                            @else
                                                <a
                                                    href="{{ route('maternal-care.index') }}"
                                                    class="clay-secondary mt-5 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                                                >
                                                    Clear Search
                                                </a>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                @if ($maternalCares->hasPages())
                    <div class="border-t border-white/70 px-6 py-4">
                        {{ $maternalCares->links() }}
                    </div>
                @endif

            </section>

            {{-- MOBILE CARDS --}}
            <section
                class="space-y-4 lg:hidden"
                aria-label="Maternal care records"
            >
                @forelse ($maternalCares as $maternalCare)
                    <article class="clay-card rounded-[22px] p-5">

                        {{-- Card Header --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">
                                <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl text-sm font-bold">
                                    {{ strtoupper(substr($maternalCare->resident->first_name ?? 'R', 0, 1)) }}
                                </div>

                                <div class="min-w-0">
                                    <p class="break-words text-sm font-bold text-[#164238]">
                                        {{ $maternalCare->resident->full_name }}
                                    </p>

                                    <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                        Resident #{{ $maternalCare->resident->id }}
                                    </p>
                                </div>
                            </div>

                            @php
                                $statusClasses = match ($maternalCare->pregnancy_status) {
                                    'Pregnant' => 'clay-status-pregnant',
                                    'Delivered' => 'clay-status-delivered',
                                    'Miscarriage' => 'clay-status-miscarriage',
                                    'Stillbirth' => 'clay-status-stillbirth',
                                    'Completed' => 'clay-status-default',
                                    default => 'clay-status-default',
                                };
                            @endphp

                            <span class="{{ $statusClasses }} inline-flex shrink-0 items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-bold">
                                <span class="h-1.5 w-1.5 rounded-full bg-current" aria-hidden="true"></span>
                                {{ $maternalCare->pregnancy_status }}
                            </span>

                        </div>

                        {{-- Card Details --}}
                        <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                            <div class="clay-inset min-w-0 rounded-xl p-3.5">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Pregnancy
                                </p>

                                <p class="mt-1 break-words text-sm font-bold text-[#234E43]">
                                    @if ($maternalCare->pregnancy_number)
                                        #{{ $maternalCare->pregnancy_number }}
                                    @else
                                        Not specified
                                    @endif
                                </p>
                            </div>

                            <div class="clay-inset min-w-0 rounded-xl p-3.5">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Prenatal Visits
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#234E43]">
                                    {{ $maternalCare->prenatal_visit_count ?? 0 }}
                                </p>
                            </div>

                            <div class="clay-inset min-w-0 rounded-xl p-3.5">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Expected Delivery
                                </p>

                                <p class="mt-1 break-words text-sm font-bold text-[#234E43]">
                                    @if ($maternalCare->expected_delivery_date)
                                        {{ $maternalCare->expected_delivery_date->format('M d, Y') }}
                                    @else
                                        Not specified
                                    @endif
                                </p>
                            </div>

                            <div class="clay-inset min-w-0 rounded-xl p-3.5">
                                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                                    Delivery Type
                                </p>

                                <p class="mt-1 break-words text-sm font-bold text-[#234E43]">
                                    {{ $maternalCare->delivery_type ?: 'Not specified' }}
                                </p>
                            </div>

                        </div>

                        {{-- Card Actions --}}
                        <div class="mt-5 grid grid-cols-3 gap-2 border-t border-white/70 pt-4">

                            <a
                                href="{{ route('maternal-care.show', $maternalCare) }}"
                                class="clay-action clay-view w-full"
                                aria-label="View maternal record for {{ $maternalCare->resident->full_name }}"
                            >
                                View
                            </a>

                            <a
                                href="{{ route('maternal-care.edit', $maternalCare) }}"
                                class="clay-action clay-edit w-full"
                                aria-label="Edit maternal record for {{ $maternalCare->resident->full_name }}"
                            >
                                Edit
                            </a>

                            <form
                                id="delete-maternal-mobile-form-{{ $maternalCare->id }}"
                                action="{{ route('maternal-care.destroy', $maternalCare) }}"
                                method="POST"
                                class="w-full"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="button"
                                    class="clay-action clay-delete w-full"
                                    data-delete-maternal
                                    data-form-id="delete-maternal-mobile-form-{{ $maternalCare->id }}"
                                    data-resident-name="{{ $maternalCare->resident->full_name }}"
                                    data-record-detail="{{ $maternalCare->pregnancy_number ? 'Pregnancy #' . $maternalCare->pregnancy_number . ' · ' : '' }}{{ $maternalCare->pregnancy_status }}"
                                    data-confirm-title="Delete this maternal care record?"
                                    aria-label="Delete maternal record for {{ $maternalCare->resident->full_name }}"
                                >
                                    Delete
                                </button>
                            </form>

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
                                    d="M12 21s-7-4.35-7-10a4 4 0 0 1 7-2.65A4 4 0 0 1 19 11c0 5.65-7 10-7 10Z"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12h6m-3-3v6"
                                />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-sm font-bold text-[#164238]">
                            No maternal care records found
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-[#6D817A]">
                            @if ($search !== '')
                                No records match your search. Try another keyword or clear the search.
                            @else
                                Add your first maternal care record to get started.
                            @endif
                        </p>

                        @if ($search === '')
                            <a
                                href="{{ route('maternal-care.create') }}"
                                class="clay-primary mt-5 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
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
                                Add Maternal Record
                            </a>
                        @else
                            <a
                                href="{{ route('maternal-care.index') }}"
                                class="clay-secondary mt-5 inline-flex min-h-[42px] items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-xs font-bold"
                            >
                                Clear Search
                            </a>
                        @endif

                    </div>
                @endforelse

                @if ($maternalCares->hasPages())
                    <div>
                        {{ $maternalCares->links() }}
                    </div>
                @endif

            </section>

            {{-- INFORMATION NOTICE --}}
            <aside class="clay-info mt-6 rounded-2xl p-4 sm:p-5">
                <div class="flex items-start gap-3">

                    <div class="clay-icon mt-0.5 h-9 w-9 rounded-xl bg-[#F6E8C8] text-[#8A6A28]">
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
                            Maternal Care Records
                        </h3>

                        <p class="mt-1 text-xs leading-5 text-[#806B47]">
                            Maternal care information should be kept accurate and updated
                            to support proper prenatal follow-ups and health-center
                            record management.
                        </p>
                    </div>

                </div>
            </aside>

        </div>
    </main>

    {{-- DELETE CONFIRMATION MODAL --}}
    <div
        id="deleteMaternalModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteMaternalModalTitle"
    >
        <div class="clay-confirm-box" role="document">

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
                    id="deleteMaternalModalTitle"
                    class="text-lg font-bold text-[#164238]"
                >
                    Delete Maternal Record?
                </h2>

                <p class="mt-2 text-sm leading-6 text-[#6D817A]">
                    This action will permanently remove the selected maternal care
                    record. Please confirm that you want to continue.
                </p>
            </div>

            {{-- Affected Record --}}
            <div class="clay-confirm-account mt-4 rounded-xl p-4">
                <p class="text-[11px] font-bold uppercase tracking-wider text-[#6D817A]">
                    Maternal Record
                </p>

                <p
                    id="deleteMaternalResident"
                    class="mt-1 break-words text-sm font-bold text-[#164238]"
                >
                    —
                </p>

                <p
                    id="deleteMaternalDetail"
                    class="mt-1 text-xs font-medium text-[#6D817A]"
                >
                    —
                </p>
            </div>

            {{-- Buttons --}}
            <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">
                <button
                    type="button"
                    id="deleteMaternalCancel"
                    class="clay-confirm-cancel inline-flex min-h-[42px] items-center justify-center rounded-xl px-4 py-2.5 text-sm font-bold"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="deleteMaternalConfirm"
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

                    Delete Record
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE SIDEBAR SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (!menuButton || !overlay || !sidebar) {
                return;
            }

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                menuButton.setAttribute('aria-expanded', 'true');
                menuButton.setAttribute('aria-label', 'Close navigation menu');
                overlay.setAttribute('aria-hidden', 'false');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('aria-label', 'Open navigation menu');
                overlay.setAttribute('aria-hidden', 'true');
            };

            menuButton.addEventListener('click', () => {
                const isOpen = menuButton.getAttribute('aria-expanded') === 'true';

                if (isOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !overlay.classList.contains('hidden')) {
                    closeSidebar();
                    menuButton.focus();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>

    {{-- DELETE CONFIRMATION SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('deleteMaternalModal');
            const cancelButton = document.getElementById('deleteMaternalCancel');
            const confirmButton = document.getElementById('deleteMaternalConfirm');

            const residentName = document.getElementById('deleteMaternalResident');
            const recordDetail = document.getElementById('deleteMaternalDetail');

            if (!modal || !cancelButton || !confirmButton || !residentName || !recordDetail) {
                return;
            }

            let activeFormId = null;
            let previouslyFocusedElement = null;

            const deleteButtons = document.querySelectorAll('[data-delete-maternal]');

            function openDeleteModal(button) {
                activeFormId = button.dataset.formId || null;
                previouslyFocusedElement = button;

                residentName.textContent =
                    button.dataset.residentName || 'Maternal record';

                recordDetail.textContent =
                    button.dataset.recordDetail || '';

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

                if (previouslyFocusedElement) {
                    previouslyFocusedElement.focus();
                    previouslyFocusedElement = null;
                }
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
                } else {
                    closeDeleteModal();
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

                if (
                    event.key === 'Tab' &&
                    modal.classList.contains('is-open')
                ) {
                    const focusableElements = modal.querySelectorAll(
                        'button:not(:disabled), a[href], input:not(:disabled), select:not(:disabled), textarea:not(:disabled), [tabindex]:not([tabindex="-1"])'
                    );

                    if (!focusableElements.length) {
                        return;
                    }

                    const firstElement = focusableElements[0];
                    const lastElement = focusableElements[focusableElements.length - 1];

                    if (event.shiftKey && document.activeElement === firstElement) {
                        event.preventDefault();
                        lastElement.focus();
                    } else if (!event.shiftKey && document.activeElement === lastElement) {
                        event.preventDefault();
                        firstElement.focus();
                    }
                }
            });
        });
    </script>

</body>
</html>
