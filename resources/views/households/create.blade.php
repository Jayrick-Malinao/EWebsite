<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Household | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Register a household and its family members for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ==========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM UI
        ========================================================== */

        :root {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;
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

            --warning-text: #8A6A28;
            --warning-bg: #FBF7ED;
            --warning-bg-dark: #F2EBD9;

            --shadow-dark: rgba(107, 134, 124, .22);
            --shadow-light: rgba(255, 255, 255, .92);
        }

        /* ==========================================================
           BASE
        ========================================================== */

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif !important;
            color: var(--text);
            background:
                radial-gradient(
                    circle at 8% 4%,
                    rgba(255, 255, 255, .72),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 96% 8%,
                    rgba(42, 155, 128, .07),
                    transparent 26%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                );
        }

        button,
        input,
        select,
        textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        a,
        button,
        input,
        select,
        textarea {
            -webkit-tap-highlight-color: transparent;
        }

        :focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 2px;
        }

        /* ==========================================================
           PAGE BACKGROUND
        ========================================================== */

        .clay-page {
            min-height: 100vh;
            background:
                radial-gradient(
                    circle at 8% 4%,
                    rgba(255, 255, 255, .72),
                    transparent 28%
                ),
                radial-gradient(
                    circle at 96% 8%,
                    rgba(42, 155, 128, .07),
                    transparent 26%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                );
            color: var(--text);
        }

        /* ==========================================================
           HEADER
        ========================================================== */

        .clay-header {
            background: rgba(245, 250, 247, .94);
            border-bottom: 1px solid rgba(255, 255, 255, .78);
            box-shadow:
                0 4px 16px rgba(107, 134, 124, .10),
                0 1px 2px rgba(255, 255, 255, .95) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .header-inner {
            min-height: 82px;
        }

        .header-label {
            color: var(--primary-dark);
            letter-spacing: .18em;
        }

        .header-title {
            color: var(--text);
        }

        .header-description {
            color: var(--text-muted);
        }

        /* ==========================================================
           PAGE INTRO
        ========================================================== */

        .page-intro {
            position: relative;
            padding-left: 16px;
        }

        .page-intro::before {
            content: "";
            position: absolute;
            left: 0;
            top: 3px;
            bottom: 3px;
            width: 4px;
            border-radius: 999px;
            background: linear-gradient(
                180deg,
                var(--primary-light),
                var(--primary-dark)
            );
            box-shadow: 0 2px 7px rgba(22, 139, 112, .18);
        }

        .page-icon {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );
            color: var(--primary-dark);
            border: 1px solid rgba(107, 134, 124, .14);
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .18),
                -4px -4px 10px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84);
        }

        .page-title {
            color: var(--text);
        }

        .page-description {
            color: var(--text-muted);
        }

        /* ==========================================================
           CLAY CARDS
        ========================================================== */

        .clay-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            );
            border: 1px solid rgba(255, 255, 255, .76);
            box-shadow:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84);
        }

        .clay-card-header {
            border-bottom: 1px solid rgba(210, 225, 218, .65);
        }

        .section-icon {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #E8F2ED
            );
            border: 1px solid rgba(255, 255, 255, .78);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .17),
                -4px -4px 9px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
        }

        .section-icon.green {
            color: var(--primary-dark);
        }

        .section-icon.blue {
            color: #2F6F8F;
        }

        .section-icon.orange {
            color: var(--accent);
        }

        .section-title {
            color: var(--text);
        }

        .section-description {
            color: var(--text-muted);
        }

        /* ==========================================================
           FORM LABELS
        ========================================================== */

        .clay-label {
            color: var(--text-dark);
        }

        .required-mark {
            color: var(--danger-light);
        }

        /* ==========================================================
           INPUTS / SELECTS / TEXTAREAS
        ========================================================== */

        .clay-input,
        .clay-select,
        .clay-textarea {
            width: 100% !important;
            border: 1px solid rgba(107, 134, 124, .16) !important;
            background: linear-gradient(
                145deg,
                #EDF5F0,
                #F8FCFA
            ) !important;
            color: var(--text) !important;
            border-radius: 14px !important;
            outline: none !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82) !important;
            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                transform .18s ease !important;
        }

        .clay-input,
        .clay-select {
            min-height: 46px;
            padding: 11px 14px !important;
        }

        .clay-textarea {
            min-height: 96px;
            padding: 12px 14px !important;
            resize: vertical;
        }

        .clay-input::placeholder,
        .clay-textarea::placeholder {
            color: var(--text-soft) !important;
            opacity: 1 !important;
        }

        .clay-input:hover,
        .clay-select:hover,
        .clay-textarea:hover {
            border-color: rgba(22, 139, 112, .28) !important;
        }

        .clay-input:focus,
        .clay-select:focus,
        .clay-textarea:focus {
            border-color: rgba(22, 139, 112, .55) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82),
                0 0 0 3px rgba(22, 139, 112, .10) !important;
        }

        .clay-input:disabled,
        .clay-select:disabled,
        .clay-textarea:disabled {
            cursor: not-allowed;
            opacity: .65;
        }

        /* ==========================================================
           VALIDATION ERROR PANEL
        ========================================================== */

        .clay-error-panel {
            background: linear-gradient(
                145deg,
                #FFF8F7,
                #FCECEA
            );
            border: 1px solid rgba(180, 35, 35, .16);
            box-shadow:
                7px 7px 16px rgba(107, 134, 124, .14),
                -7px -7px 16px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .75);
        }

        .error-icon {
            background: linear-gradient(
                145deg,
                #FFFDFD,
                #FDEDEC
            );
            color: var(--danger-light);
            border: 1px solid rgba(180, 35, 35, .10);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .90);
        }

        /* ==========================================================
           FAMILY MEMBER AREA
        ========================================================== */

        .family-empty {
            background: linear-gradient(
                145deg,
                #F5FAF7,
                #EAF2EE
            );
            border: 1px dashed rgba(107, 134, 124, .25);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .80);
        }

        .family-empty-icon {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #E8F2ED
            );
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, .78);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .15),
                -4px -4px 9px rgba(255, 255, 255, .90);
        }

        .member-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E8F1EC
            );
            border: 1px solid rgba(255, 255, 255, .76);
            box-shadow:
                7px 7px 16px rgba(107, 134, 124, .18),
                -7px -7px 16px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .76);
            transition:
                transform .18s ease,
                box-shadow .18s ease !important;
        }

        .member-card:hover {
            transform: translateY(-1px);
            box-shadow:
                9px 9px 19px rgba(107, 134, 124, .20),
                -8px -8px 18px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .80);
        }

        .member-number {
            background: linear-gradient(
                145deg,
                #F9FCFA,
                #E7F1EC
            );
            border: 1px solid rgba(255, 255, 255, .82);
            color: var(--primary-dark);
            box-shadow:
                4px 4px 8px rgba(107, 134, 124, .15),
                -3px -3px 7px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
        }

        /* ==========================================================
           BUTTONS
        ========================================================== */

        .clay-primary-button,
        .clay-secondary-button,
        .clay-add-member,
        .clay-back-button {
            font-family: Arial, Helvetica, sans-serif !important;
            cursor: pointer;
            text-decoration: none;
        }

        .clay-primary-button {
            background: linear-gradient(
                135deg,
                #168B70,
                #0F6F5A
            ) !important;
            color: #FFFFFF !important;
            border: 1px solid rgba(15, 111, 90, .35);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .25),
                -3px -3px 8px rgba(255, 255, 255, .65);
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                filter .18s ease;
        }

        .clay-primary-button:hover {
            filter: brightness(1.03);
            transform: translateY(-1px);
            box-shadow:
                6px 6px 14px rgba(107, 134, 124, .27),
                -3px -3px 8px rgba(255, 255, 255, .70);
        }

        .clay-primary-button:active {
            transform: translateY(1px);
            box-shadow:
                inset 3px 3px 7px rgba(0, 0, 0, .12),
                2px 2px 6px rgba(107, 134, 124, .18);
        }

        .clay-primary-button:focus-visible {
            outline: none !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .25),
                -3px -3px 8px rgba(255, 255, 255, .65),
                0 0 0 3px rgba(22, 139, 112, .18);
        }

        .clay-secondary-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, .78);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .20),
                -5px -5px 10px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease;
        }

        .clay-secondary-button:hover {
            background: linear-gradient(
                145deg,
                #FBFEFC,
                #EDF5F0
            ) !important;
            transform: translateY(-1px);
        }

        .clay-secondary-button:active {
            transform: translateY(1px);
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                2px 2px 6px rgba(107, 134, 124, .15);
        }

        .clay-secondary-button:focus-visible {
            outline: none !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .20),
                -5px -5px 10px rgba(255, 255, 255, .90),
                0 0 0 3px rgba(22, 139, 112, .15);
        }

        /* ==========================================================
           ADD MEMBER BUTTON
        ========================================================== */

        .clay-add-member {
            background: linear-gradient(
                135deg,
                #168B70,
                #0F6F5A
            ) !important;
            color: #FFFFFF !important;
            border: 1px solid rgba(15, 111, 90, .30);
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .22),
                -3px -3px 7px rgba(255, 255, 255, .65);
            transition:
                transform .18s ease,
                box-shadow .18s ease;
        }

        .clay-add-member:hover {
            transform: translateY(-1px);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .24),
                -3px -3px 7px rgba(255, 255, 255, .70);
        }

        .clay-add-member:active {
            transform: translateY(1px);
        }

        .clay-add-member:focus-visible {
            outline: none !important;
            box-shadow:
                4px 4px 10px rgba(107, 134, 124, .22),
                -3px -3px 7px rgba(255, 255, 255, .65),
                0 0 0 3px rgba(22, 139, 112, .18);
        }

        /* ==========================================================
           REMOVE MEMBER
        ========================================================== */

        .remove-member {
            color: var(--danger-light) !important;
            transition:
                background .18s ease,
                box-shadow .18s ease,
                transform .18s ease;
        }

        .remove-member:hover {
            background: rgba(180, 35, 35, .07);
            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, .07),
                inset -2px -2px 5px rgba(255, 255, 255, .70);
        }

        .remove-member:active {
            transform: translateY(1px);
        }

        .remove-member:focus-visible {
            outline: none !important;
            box-shadow:
                0 0 0 3px rgba(220, 38, 38, .12);
        }

        /* ==========================================================
           HEADER BACK BUTTON
        ========================================================== */

        .clay-back-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, .78);
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .18),
                -5px -5px 10px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .78);
            transition:
                transform .18s ease,
                box-shadow .18s ease;
        }

        .clay-back-button:hover {
            transform: translateY(-1px);
            box-shadow:
                6px 6px 14px rgba(107, 134, 124, .20),
                -5px -5px 11px rgba(255, 255, 255, .92);
        }

        .clay-back-button:active {
            transform: translateY(1px);
        }

        .clay-back-button:focus-visible {
            outline: none !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .18),
                -5px -5px 10px rgba(255, 255, 255, .90),
                0 0 0 3px rgba(22, 139, 112, .15);
        }

        /* ==========================================================
           ACTION AREA
        ========================================================== */

        .action-area {
            padding-bottom: 2rem;
        }

        /* ==========================================================
           MOBILE MENU BUTTON
        ========================================================== */

        .clay-menu-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #EAF2EE
            ) !important;
            color: var(--primary-dark) !important;
            border: 1px solid rgba(255, 255, 255, .78);
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .16),
                -4px -4px 8px rgba(255, 255, 255, .90);
            transition:
                transform .18s ease,
                box-shadow .18s ease;
        }

        .clay-menu-button:hover {
            transform: translateY(-1px);
        }

        .clay-menu-button:focus-visible {
            outline: none !important;
            box-shadow:
                4px 4px 9px rgba(107, 134, 124, .16),
                -4px -4px 8px rgba(255, 255, 255, .90),
                0 0 0 3px rgba(22, 139, 112, .15);
        }

        /* ==========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 1023px) {
            .page-intro::before {
                display: none;
            }

            .page-intro {
                padding-left: 0;
            }
        }

        @media (max-width: 639px) {
            .header-inner {
                min-height: 72px;
            }

            .clay-card {
                border-radius: 22px;
                box-shadow:
                    6px 6px 15px rgba(107, 134, 124, .20),
                    -6px -6px 14px rgba(255, 255, 255, .92),
                    inset 1px 1px 0 rgba(255, 255, 255, .80);
            }

            .member-card {
                border-radius: 18px;
            }

            .clay-input,
            .clay-select,
            .clay-textarea {
                border-radius: 13px !important;
            }

            .page-icon {
                width: 44px;
                height: 44px;
                border-radius: 16px;
            }
        }

        /* ==========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                transition-duration: .01ms !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
            }
        }
    </style>
</head>

<body class="clay-page min-h-screen">

    {{-- ==========================================================
         SIDEBAR
    =========================================================== --}}
    @include('dashboard.sidebar')


    {{-- ==========================================================
         PAGE WRAPPER
         lg:pl-72 prevents content from going underneath sidebar
    =========================================================== --}}
    <div class="min-h-screen lg:pl-72">

        {{-- ======================================================
             HEADER
        ======================================================= --}}
        <header class="clay-header sticky top-0 z-30">

            <div class="header-inner mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                <div class="flex min-w-0 items-center gap-3">

                    {{-- Mobile menu --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-menu-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="header-label truncate text-[10px] font-bold uppercase sm:text-xs">
                            Household Management
                        </p>

                        <h1 class="header-title mt-1 truncate text-lg font-bold tracking-tight sm:text-xl">
                            Add New Household
                        </h1>

                    </div>

                </div>

                {{-- Back button --}}
                <a
                    href="{{ route('households.index') }}"
                    class="clay-back-button inline-flex shrink-0 items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold sm:px-4"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                        />
                    </svg>

                    <span class="hidden sm:inline">
                        Back to Households
                    </span>

                    <span class="sm:hidden">
                        Back
                    </span>
                </a>

            </div>

        </header>


        {{-- ======================================================
             MAIN CONTENT
        ======================================================= --}}
        <main class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- ==================================================
                 PAGE INTRO
            =================================================== --}}
            <div class="page-intro mb-6 flex items-start gap-4">

                <div class="page-icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 7h1m4 0h1M9 11h1m4 0h1M9 15h1m4 0h1"
                        />
                    </svg>

                </div>

                <div class="min-w-0">
                    <h2 class="page-title text-xl font-bold tracking-tight sm:text-2xl">
                        Household Registration
                    </h2>

                    <p class="page-description mt-1 text-sm leading-6 sm:text-base">
                        Create a household record and register the household head and family members.
                    </p>
                </div>

            </div>


            {{-- ==================================================
                 VALIDATION ERRORS
            =================================================== --}}
            @if ($errors->any())

                <div class="clay-error-panel mb-6 rounded-2xl p-5">

                    <div class="flex gap-3">

                        <div class="error-icon mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-xl">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3.75h.007M10.29 3.86 2.82 17.11A2 2 0 0 0 4.56 20h14.88a2 2 0 0 0 1.74-2.89L13.71 3.86a2 2 0 0 0-3.42 0Z"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <h3 class="text-sm font-bold text-red-800">
                                Please correct the following errors.
                            </h3>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- ==================================================
                 FORM
            =================================================== --}}
            <form
                method="POST"
                action="{{ route('households.store') }}"
                class="space-y-6"
            >

                @csrf


                {{-- =================================================
                     HOUSEHOLD INFORMATION
                ================================================== --}}
                <section class="clay-card overflow-hidden rounded-[22px]">

                    <div class="clay-card-header px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="section-icon green flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M3 21h18M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16M9 7h1m4 0h1M9 11h1m4 0h1M9 15h1m4 0h1"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h2 class="section-title text-base font-bold">
                                    Household Information
                                </h2>

                                <p class="section-description text-sm">
                                    Basic information about the household.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="grid gap-5 px-5 py-6 sm:px-6 md:grid-cols-2">

                        {{-- Household Head Name --}}
                        <div>

                            <label class="clay-label block text-sm font-semibold">
                                Household Head Name
                                <span class="required-mark">*</span>
                            </label>

                            <input
                                type="text"
                                name="household_head_name"
                                value="{{ old('household_head_name') }}"
                                required
                                placeholder="Enter household head name"
                                class="clay-input mt-2"
                            >

                        </div>


                        {{-- Contact --}}
                        <div>

                            <label class="clay-label block text-sm font-semibold">
                                Contact Number
                            </label>

                            <input
                                type="text"
                                name="contact_number"
                                value="{{ old('contact_number') }}"
                                placeholder="09XXXXXXXXX"
                                class="clay-input mt-2"
                            >

                        </div>


                        {{-- Address --}}
                        <div class="md:col-span-2">

                            <label class="clay-label block text-sm font-semibold">
                                Address
                                <span class="required-mark">*</span>
                            </label>

                            <textarea
                                name="address"
                                rows="3"
                                required
                                placeholder="Enter complete household address"
                                class="clay-textarea mt-2"
                            >{{ old('address') }}</textarea>

                        </div>


                        {{-- Status --}}
                        <div>

                            <label class="clay-label block text-sm font-semibold">
                                Status
                                <span class="required-mark">*</span>
                            </label>

                            <select
                                name="status"
                                required
                                class="clay-select mt-2"
                            >

                                <option
                                    value="Active"
                                    @selected(old('status', 'Active') === 'Active')
                                >
                                    Active
                                </option>

                                <option
                                    value="Inactive"
                                    @selected(old('status') === 'Inactive')
                                >
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                     HOUSEHOLD HEAD
                ================================================== --}}
                <section class="clay-card overflow-hidden rounded-[22px]">

                    <div class="clay-card-header px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="section-icon blue flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 3.75-1.22M9 19.128a9.38 9.38 0 0 1-3.75-1.22M15 19.128v-.002a6.75 6.75 0 0 0-6 0v.002M12 12.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="section-title text-base font-bold">
                                    Household Head
                                </h2>

                                <p class="section-description text-sm">
                                    Personal information of the household head.
                                </p>

                            </div>

                        </div>

                    </div>

                    <div class="space-y-5 px-5 py-6 sm:px-6">

                        {{-- Name --}}
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    First Name
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="household_head[first_name]"
                                    value="{{ old('household_head.first_name') }}"
                                    required
                                    class="clay-input mt-2"
                                >

                            </div>

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Middle Name
                                </label>

                                <input
                                    type="text"
                                    name="household_head[middle_name]"
                                    value="{{ old('household_head.middle_name') }}"
                                    class="clay-input mt-2"
                                >

                            </div>

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Last Name
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="household_head[last_name]"
                                    value="{{ old('household_head.last_name') }}"
                                    required
                                    class="clay-input mt-2"
                                >

                            </div>

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Suffix
                                </label>

                                <input
                                    type="text"
                                    name="household_head[suffix]"
                                    value="{{ old('household_head.suffix') }}"
                                    placeholder="Jr., Sr., III"
                                    class="clay-input mt-2"
                                >

                            </div>

                        </div>


                        {{-- Personal --}}
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                            {{-- Birth Date --}}
                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Birth Date
                                    <span class="required-mark">*</span>
                                </label>

                                <input
                                    type="date"
                                    name="household_head[birth_date]"
                                    value="{{ old('household_head.birth_date') }}"
                                    required
                                    class="clay-input mt-2"
                                >

                            </div>


                            {{-- Gender --}}
                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Gender
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    name="household_head[gender]"
                                    required
                                    class="clay-select mt-2"
                                >

                                    <option value="">
                                        Select gender
                                    </option>

                                    <option
                                        value="Male"
                                        @selected(old('household_head.gender') === 'Male')
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        @selected(old('household_head.gender') === 'Female')
                                    >
                                        Female
                                    </option>

                                </select>

                            </div>


                            {{-- Civil Status --}}
                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Civil Status
                                    <span class="required-mark">*</span>
                                </label>

                                <select
                                    name="household_head[civil_status]"
                                    required
                                    class="clay-select mt-2"
                                >

                                    <option value="">
                                        Select status
                                    </option>

                                    <option
                                        value="Single"
                                        @selected(old('household_head.civil_status') === 'Single')
                                    >
                                        Single
                                    </option>

                                    <option
                                        value="Married"
                                        @selected(old('household_head.civil_status') === 'Married')
                                    >
                                        Married
                                    </option>

                                    <option
                                        value="Widowed"
                                        @selected(old('household_head.civil_status') === 'Widowed')
                                    >
                                        Widowed
                                    </option>

                                    <option
                                        value="Separated"
                                        @selected(old('household_head.civil_status') === 'Separated')
                                    >
                                        Separated
                                    </option>

                                    <option
                                        value="Divorced"
                                        @selected(old('household_head.civil_status') === 'Divorced')
                                    >
                                        Divorced
                                    </option>

                                </select>

                            </div>


                            {{-- PhilHealth --}}
                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    PhilHealth Number
                                </label>

                                <input
                                    type="text"
                                    name="household_head[philhealth_number]"
                                    value="{{ old('household_head.philhealth_number') }}"
                                    placeholder="PhilHealth number"
                                    class="clay-input mt-2"
                                >

                            </div>

                        </div>


                        {{-- Contact --}}
                        <div class="grid gap-5 sm:grid-cols-2">

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Contact Number
                                </label>

                                <input
                                    type="text"
                                    name="household_head[contact_number]"
                                    value="{{ old('household_head.contact_number') }}"
                                    placeholder="09XXXXXXXXX"
                                    class="clay-input mt-2"
                                >

                            </div>

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="household_head[email]"
                                    value="{{ old('household_head.email') }}"
                                    placeholder="name@example.com"
                                    class="clay-input mt-2"
                                >

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                     FAMILY MEMBERS
                ================================================== --}}
                <section class="clay-card overflow-hidden rounded-[22px]">

                    <div class="clay-card-header flex flex-col gap-4 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="section-icon orange flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M18 18.72a9.094 9.094 0 0 1-3.75-1.22M6 18.72a9.094 9.094 0 0 1-3.75-1.22M18 18.72v-.002a6.75 6.75 0 0 0-12 0v.002M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm4.5 2.25a2.25 2.25 0 1 1-4.5 0m-9 0a2.25 2.25 0 1 1-4.5 0"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="section-title text-base font-bold">
                                    Family Members
                                </h2>

                                <p class="section-description text-sm">
                                    Add members who belong to this household.
                                </p>

                            </div>

                        </div>

                        <button
                            type="button"
                            id="add-member"
                            class="clay-add-member inline-flex w-full items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold sm:w-auto"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 4.5v15m7.5-7.5h-15"
                                />
                            </svg>

                            Add Family Member

                        </button>

                    </div>


                    <div class="space-y-5 px-5 py-6 sm:px-6">

                        {{-- Empty State --}}
                        <div
                            id="no-members"
                            class="family-empty rounded-2xl px-6 py-10 text-center"
                        >

                            <div class="family-empty-icon mx-auto flex h-12 w-12 items-center justify-center rounded-full">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 3.75-1.22M9 19.128a9.38 9.38 0 0 0-3.75-1.22M15 19.128v-.002a6.75 6.75 0 0 0-6 0v.002M12 12.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                                    />
                                </svg>

                            </div>

                            <h3 class="mt-3 text-sm font-semibold text-[#164238]">
                                No family members added
                            </h3>

                            <p class="mt-1 text-sm text-[#6D817A]">
                                Click “Add Family Member” to add another member.
                            </p>

                        </div>


                        <div
                            id="members-container"
                            class="space-y-5"
                        ></div>

                    </div>

                </section>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}
                <div class="action-area flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('households.index') }}"
                        class="clay-secondary-button inline-flex items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="clay-primary-button inline-flex items-center justify-center gap-2 rounded-xl px-5 py-3 text-sm font-semibold"
                    >

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m5 12 4 4L19 6"
                            />
                        </svg>

                        Save Household

                    </button>

                </div>

            </form>

        </main>

    </div>


    {{-- ==========================================================
         FAMILY MEMBER TEMPLATE
    =========================================================== --}}
    <template id="member-template">

        <div class="member-card rounded-2xl p-5">

            <div class="mb-5 flex items-center justify-between gap-4">

                <div class="flex items-center gap-3">

                    <div class="member-number flex h-9 w-9 shrink-0 items-center justify-center rounded-lg text-sm font-bold">

                        <span class="member-number">
                            1
                        </span>

                    </div>

                    <div>

                        <h3 class="text-sm font-bold text-[#164238]">
                            Family Member
                        </h3>

                        <p class="text-xs text-[#6D817A]">
                            Additional household member
                        </p>

                    </div>

                </div>

                <button
                    type="button"
                    class="remove-member inline-flex shrink-0 items-center gap-2 rounded-lg px-3 py-2 text-xs font-semibold"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 7.5h12m-10.5 0v11.25a1.5 1.5 0 0 0 1.5 1.5h6a1.5 1.5 0 0 0 1.5-1.5V7.5M9.75 7.5V5.25A.75.75 0 0 1 10.5 4.5h3a.75.75 0 0 1 .75.75V7.5"
                        />
                    </svg>

                    Remove

                </button>

            </div>


            <div class="space-y-5">

                {{-- Name --}}
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            First Name
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="text"
                            data-field="first_name"
                            required
                            class="clay-input mt-2"
                        >

                    </div>

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Middle Name
                        </label>

                        <input
                            type="text"
                            data-field="middle_name"
                            class="clay-input mt-2"
                        >

                    </div>

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Last Name
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="text"
                            data-field="last_name"
                            required
                            class="clay-input mt-2"
                        >

                    </div>

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Suffix
                        </label>

                        <input
                            type="text"
                            data-field="suffix"
                            placeholder="Jr., Sr., III"
                            class="clay-input mt-2"
                        >

                    </div>

                </div>


                {{-- Personal --}}
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    {{-- Relationship --}}
                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Relationship to Household Head
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            data-field="relationship_to_head"
                            required
                            class="clay-select mt-2"
                        >

                            <option value="">
                                Select relationship
                            </option>

                            <option value="Son">Son</option>
                            <option value="Daughter">Daughter</option>
                            <option value="Wife">Wife</option>
                            <option value="Husband">Husband</option>
                            <option value="Mother">Mother</option>
                            <option value="Father">Father</option>
                            <option value="Grandmother">Grandmother</option>
                            <option value="Grandfather">Grandfather</option>
                            <option value="Sister">Sister</option>
                            <option value="Brother">Brother</option>
                            <option value="Grandchild">Grandchild</option>
                            <option value="Other Relative">Other Relative</option>
                            <option value="Other">Other</option>

                        </select>

                    </div>


                    {{-- Birth Date --}}
                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Birth Date
                            <span class="required-mark">*</span>
                        </label>

                        <input
                            type="date"
                            data-field="birth_date"
                            required
                            class="clay-input mt-2"
                        >

                    </div>


                    {{-- Gender --}}
                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Gender
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            data-field="gender"
                            required
                            class="clay-select mt-2"
                        >

                            <option value="">
                                Select gender
                            </option>

                            <option value="Male">
                                Male
                            </option>

                            <option value="Female">
                                Female
                            </option>

                        </select>

                    </div>


                    {{-- Civil Status --}}
                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Civil Status
                            <span class="required-mark">*</span>
                        </label>

                        <select
                            data-field="civil_status"
                            required
                            class="clay-select mt-2"
                        >

                            <option value="">
                                Select status
                            </option>

                            <option value="Single">
                                Single
                            </option>

                            <option value="Married">
                                Married
                            </option>

                            <option value="Widowed">
                                Widowed
                            </option>

                            <option value="Separated">
                                Separated
                            </option>

                            <option value="Divorced">
                                Divorced
                            </option>

                        </select>

                    </div>

                </div>


                {{-- PhilHealth + Contact --}}
                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            PhilHealth Number
                        </label>

                        <input
                            type="text"
                            data-field="philhealth_number"
                            placeholder="PhilHealth number"
                            class="clay-input mt-2"
                        >

                    </div>

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Contact Number
                        </label>

                        <input
                            type="text"
                            data-field="contact_number"
                            placeholder="09XXXXXXXXX"
                            class="clay-input mt-2"
                        >

                    </div>

                </div>


                {{-- Email --}}
                <div>

                    <label class="clay-label block text-sm font-semibold">
                        Email
                    </label>

                    <input
                        type="email"
                        data-field="email"
                        placeholder="name@example.com"
                        class="clay-input mt-2"
                    >

                </div>

            </div>

        </div>

    </template>


    {{-- ==========================================================
         JAVASCRIPT
    =========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const container =
                document.getElementById('members-container');

            const template =
                document.getElementById('member-template');

            const addButton =
                document.getElementById('add-member');

            const emptyState =
                document.getElementById('no-members');

            let memberIndex = 0;


            /* ======================================================
               MOBILE SIDEBAR
            ====================================================== */

            const mobileMenuButton =
                document.getElementById('mobileMenuButton');

            const sidebar =
                document.querySelector('[data-sidebar]');


            if (mobileMenuButton && sidebar) {

                mobileMenuButton.addEventListener('click', function () {

                    sidebar.classList.toggle('-translate-x-full');

                });

            }


            /* ======================================================
               FAMILY MEMBER NUMBERING
            ====================================================== */

            function updateMemberNumbers() {

                const cards =
                    container.querySelectorAll('.member-card');

                cards.forEach((card, index) => {

                    const number =
                        card.querySelector('.member-number span');

                    if (number) {
                        number.textContent = index + 1;
                    }

                });


                if (emptyState) {

                    emptyState.classList.toggle(
                        'hidden',
                        cards.length > 0
                    );

                }

            }


            /* ======================================================
               ADD FAMILY MEMBER
            ====================================================== */

            function addMember() {

                const fragment =
                    template.content.cloneNode(true);

                const card =
                    fragment.querySelector('.member-card');


                card.querySelectorAll('[data-field]')
                    .forEach((input) => {

                        const field =
                            input.dataset.field;

                        input.name =
                            `members[${memberIndex}][${field}]`;

                    });


                container.appendChild(fragment);

                memberIndex++;

                updateMemberNumbers();


                const cards =
                    container.querySelectorAll('.member-card');

                const latestCard =
                    cards[cards.length - 1];


                latestCard
                    ?.querySelector('[data-field="first_name"]')
                    ?.focus();

            }


            /* ======================================================
               ADD BUTTON
            ====================================================== */

            if (addButton) {

                addButton.addEventListener(
                    'click',
                    addMember
                );

            }


            /* ======================================================
               REMOVE FAMILY MEMBER
            ====================================================== */

            if (container) {

                container.addEventListener(
                    'click',
                    function (event) {

                        const removeButton =
                            event.target.closest('.remove-member');

                        if (!removeButton) {
                            return;
                        }


                        const card =
                            removeButton.closest('.member-card');


                        if (card) {
                            card.remove();
                        }


                        updateMemberNumbers();

                    }
                );

            }


            /* ======================================================
               INITIAL STATE
            ====================================================== */

            updateMemberNumbers();

        });
    </script>

</body>

</html>