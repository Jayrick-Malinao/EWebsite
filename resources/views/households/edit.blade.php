<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Household | Barangay Esperanza Health Center</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ==========================================================
           BARANGAY ESPERANZA — GOVERNMENT CLAYMORPHISM SYSTEM
        =========================================================== */

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

            --warning: #8A6A28;

            --shadow-clay:
                9px 9px 20px rgba(107, 134, 124, .22),
                -9px -9px 20px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .84);

            --shadow-small:
                4px 4px 10px rgba(107, 134, 124, .18),
                -4px -4px 10px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .82);

            --shadow-inset:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82);
        }

        /* ==========================================================
           BASE
        =========================================================== */

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif !important;
            color: var(--text);
            background:
                radial-gradient(
                    circle at 8% 0%,
                    rgba(255, 255, 255, .80),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(42, 155, 128, .08),
                    transparent 26%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                ) !important;
        }

        button,
        input,
        select,
        textarea,
        option {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        button,
        a,
        input,
        select,
        textarea {
            -webkit-tap-highlight-color: transparent;
        }

        ::selection {
            background: rgba(22, 139, 112, .18);
            color: var(--text-dark);
        }

        /* ==========================================================
           PAGE WRAPPER
        =========================================================== */

        .clay-edit-page {
            min-height: 100vh;
            background:
                radial-gradient(
                    circle at 8% 0%,
                    rgba(255, 255, 255, .80),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 100% 0%,
                    rgba(42, 155, 128, .08),
                    transparent 26%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1,
                    #F5FAF7 52%,
                    #EDF5F0
                );
        }

        /* ==========================================================
           HEADER
        =========================================================== */

        .clay-header {
            position: sticky;
            top: 0;
            z-index: 30;
            border-bottom: 1px solid rgba(255, 255, 255, .72);
            background: rgba(245, 250, 247, .94);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            box-shadow:
                0 5px 18px rgba(107, 134, 124, .08),
                inset 0 -1px 0 rgba(255, 255, 255, .72);
        }

        .clay-header-inner {
            min-height: 82px;
        }

        .clay-eyebrow {
            color: var(--primary);
            letter-spacing: .18em;
        }

        .clay-page-title {
            color: var(--text-dark);
        }

        .clay-page-description {
            color: var(--text-muted);
        }

        /* ==========================================================
           BACK BUTTON
        =========================================================== */

        .clay-back-button {
            border: 1px solid rgba(255, 255, 255, .84) !important;
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;
            color: var(--text-dark) !important;
            box-shadow: var(--shadow-small) !important;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                color .18s ease !important;
        }

        .clay-back-button:hover {
            transform: translateY(-1px);
            color: var(--primary-dark) !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .21),
                -5px -5px 12px rgba(255, 255, 255, .94),
                inset 1px 1px 0 rgba(255, 255, 255, .88) !important;
        }

        /* ==========================================================
           MAIN CONTENT
        =========================================================== */

        .clay-main {
            position: relative;
        }

        /* ==========================================================
           CLAY CARDS
        =========================================================== */

        .clay-card {
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .80) !important;
            border-radius: 26px !important;
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;
            box-shadow: var(--shadow-clay) !important;
        }

        .clay-card-header {
            border-bottom: 1px solid rgba(210, 225, 218, .68) !important;
            background: rgba(245, 250, 247, .42);
        }

        .clay-section-title {
            color: var(--text-dark) !important;
        }

        .clay-section-description {
            color: var(--text-muted) !important;
        }

        /* ==========================================================
           PAGE SECTION ICONS
        =========================================================== */

        .clay-section-icon {
            border: 1px solid rgba(255, 255, 255, .72);
            background:
                linear-gradient(
                    145deg,
                    #E9F7F1,
                    #D8EEE6
                );
            color: var(--primary-dark);
            box-shadow: var(--shadow-small);
        }

        .clay-section-icon.head {
            background:
                linear-gradient(
                    145deg,
                    #EEF8F5,
                    #DCEFE9
                );
            color: var(--primary-dark);
        }

        .clay-section-icon.members {
            background:
                linear-gradient(
                    145deg,
                    #FFF5EC,
                    #F8E7D8
                );
            color: var(--accent);
        }

        /* ==========================================================
           FORM LABELS
        =========================================================== */

        .clay-label {
            color: var(--text-dark) !important;
        }

        .clay-required {
            color: var(--danger-light) !important;
        }

        /* ==========================================================
           INPUTS / SELECTS / TEXTAREAS
        =========================================================== */

        .clay-input,
        .clay-select,
        .clay-textarea {
            width: 100%;
            border: 1px solid rgba(210, 225, 218, .84) !important;
            border-radius: 14px !important;
            background:
                linear-gradient(
                    145deg,
                    #EDF5F0,
                    #F8FCFA
                ) !important;
            color: var(--text-dark) !important;
            box-shadow: var(--shadow-inset) !important;
            outline: none !important;
            transition:
                border-color .18s ease,
                box-shadow .18s ease,
                background .18s ease !important;
        }

        .clay-input::placeholder,
        .clay-textarea::placeholder {
            color: var(--text-soft) !important;
            opacity: 1;
        }

        .clay-input:hover,
        .clay-select:hover,
        .clay-textarea:hover {
            border-color: rgba(22, 139, 112, .28) !important;
        }

        .clay-input:focus,
        .clay-select:focus,
        .clay-textarea:focus {
            border-color: rgba(22, 139, 112, .72) !important;
            box-shadow:
                0 0 0 3px rgba(22, 139, 112, .10),
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .82) !important;
        }

        .clay-select {
            cursor: pointer;
        }

        .clay-textarea {
            min-height: 100px;
        }

        /* ==========================================================
           VALIDATION ERROR
        =========================================================== */

        .clay-error-panel {
            border: 1px solid rgba(220, 38, 38, .16) !important;
            border-radius: 22px !important;
            background:
                linear-gradient(
                    145deg,
                    #FFF7F7,
                    #FCEEEE
                ) !important;
            box-shadow:
                7px 7px 16px rgba(153, 87, 87, .12),
                -7px -7px 16px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .82) !important;
        }

        .clay-error-icon {
            border-radius: 13px;
            background:
                linear-gradient(
                    145deg,
                    #FFF0F0,
                    #F8DCDC
                );
            color: var(--danger-light);
            box-shadow:
                3px 3px 8px rgba(153, 87, 87, .12),
                -3px -3px 8px rgba(255, 255, 255, .86);
        }

        /* ==========================================================
           FAMILY MEMBERS AREA
        =========================================================== */

        .clay-add-member {
            border: 1px solid rgba(255, 255, 255, .82) !important;
            background:
                linear-gradient(
                    145deg,
                    #1A9679,
                    #0F755E
                ) !important;
            color: #FFFFFF !important;
            box-shadow:
                4px 4px 10px rgba(76, 113, 101, .22),
                -4px -4px 10px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .18) !important;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                filter .18s ease !important;
        }

        .clay-add-member:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow:
                5px 5px 12px rgba(76, 113, 101, .25),
                -5px -5px 12px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .20) !important;
        }

        .clay-add-member:active {
            transform: translateY(0);
        }

        /* ==========================================================
           EMPTY STATE
        =========================================================== */

        .family-empty {
            border: 1px dashed rgba(157, 178, 168, .72) !important;
            border-radius: 22px !important;
            background:
                linear-gradient(
                    145deg,
                    #EDF5F0,
                    #F7FBF9
                ) !important;
            box-shadow: var(--shadow-inset) !important;
        }

        .family-empty-icon {
            border: 1px solid rgba(255, 255, 255, .82);
            border-radius: 50%;
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #E7F0EC
                );
            color: var(--text-soft);
            box-shadow: var(--shadow-small);
        }

        /* ==========================================================
           MEMBER CARD
        =========================================================== */

        .member-card {
            border: 1px solid rgba(255, 255, 255, .78) !important;
            border-radius: 22px !important;
            background:
                linear-gradient(
                    145deg,
                    #F4F9F6,
                    #E7F0EB
                ) !important;
            box-shadow:
                6px 6px 15px rgba(107, 134, 124, .16),
                -6px -6px 15px rgba(255, 255, 255, .88),
                inset 1px 1px 0 rgba(255, 255, 255, .80) !important;
            transition:
                transform .18s ease,
                box-shadow .18s ease !important;
        }

        .member-card:hover {
            transform: translateY(-1px);
            box-shadow:
                8px 8px 18px rgba(107, 134, 124, .19),
                -8px -8px 18px rgba(255, 255, 255, .91),
                inset 1px 1px 0 rgba(255, 255, 255, .84) !important;
        }

        .member-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border-radius: 11px;
            background:
                linear-gradient(
                    145deg,
                    #E5F5EF,
                    #CFE9DF
                );
            color: var(--primary-dark);
            box-shadow: var(--shadow-small);
        }

        .member-subtitle {
            color: var(--text-muted);
        }

        /* ==========================================================
           REMOVE MEMBER
        =========================================================== */

        .remove-member {
            border: 1px solid transparent !important;
            background:
                linear-gradient(
                    145deg,
                    #FFF8F8,
                    #FBEAEA
                ) !important;
            color: var(--danger-light) !important;
            box-shadow:
                3px 3px 8px rgba(153, 87, 87, .10),
                -3px -3px 8px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .72) !important;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                background .18s ease !important;
        }

        .remove-member:hover {
            transform: translateY(-1px);
            background:
                linear-gradient(
                    145deg,
                    #FDEEEE,
                    #F8DDDD
                ) !important;
            box-shadow:
                4px 4px 10px rgba(153, 87, 87, .14),
                -4px -4px 10px rgba(255, 255, 255, .90) !important;
        }

        /* ==========================================================
           PRIMARY / SECONDARY ACTIONS
        =========================================================== */

        .clay-primary-button {
            border: 1px solid rgba(255, 255, 255, .82) !important;
            background:
                linear-gradient(
                    145deg,
                    #1A9679,
                    #0F755E
                ) !important;
            color: #FFFFFF !important;
            box-shadow:
                5px 5px 12px rgba(76, 113, 101, .23),
                -5px -5px 12px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .18) !important;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                filter .18s ease !important;
        }

        .clay-primary-button:hover {
            transform: translateY(-1px);
            filter: brightness(1.02);
            box-shadow:
                6px 6px 14px rgba(76, 113, 101, .27),
                -6px -6px 14px rgba(255, 255, 255, .90),
                inset 1px 1px 0 rgba(255, 255, 255, .20) !important;
        }

        .clay-primary-button:active {
            transform: translateY(0);
        }

        .clay-secondary-button {
            border: 1px solid rgba(255, 255, 255, .84) !important;
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;
            color: var(--text-dark) !important;
            box-shadow: var(--shadow-small) !important;
            transition:
                transform .18s ease,
                box-shadow .18s ease,
                color .18s ease !important;
        }

        .clay-secondary-button:hover {
            transform: translateY(-1px);
            color: var(--primary-dark) !important;
            box-shadow:
                5px 5px 12px rgba(107, 134, 124, .21),
                -5px -5px 12px rgba(255, 255, 255, .94),
                inset 1px 1px 0 rgba(255, 255, 255, .88) !important;
        }

        /* ==========================================================
           FOCUS ACCESSIBILITY
        =========================================================== */

        a:focus-visible,
        button:focus-visible,
        input:focus-visible,
        select:focus-visible,
        textarea:focus-visible {
            outline: 2px solid var(--primary) !important;
            outline-offset: 3px;
        }

        /* ==========================================================
           RESPONSIVE
        =========================================================== */

        @media (max-width: 639px) {
            .clay-card {
                border-radius: 20px !important;
            }

            .member-card {
                border-radius: 18px !important;
                padding: 1rem !important;
            }

            .clay-card-header {
                padding: 1rem !important;
            }

            .clay-header-inner {
                min-height: 72px;
            }
        }

        /* ==========================================================
           REDUCED MOTION
        =========================================================== */

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>

<body>

    {{-- ==========================================================
         SIDEBAR
    =========================================================== --}}
    @include('dashboard.sidebar')


    {{-- ==========================================================
         PAGE WRAPPER
         Matches create.blade.php layout
    =========================================================== --}}
    <div class="clay-edit-page min-h-screen lg:pl-72">

        {{-- ======================================================
             HEADER
        ======================================================= --}}
        <header class="clay-header">

            <div class="clay-header-inner mx-auto flex max-w-7xl items-center justify-between gap-6 px-4 py-4 sm:px-6 lg:px-8">

                <div class="min-w-0">

                    <p class="clay-eyebrow text-xs font-semibold uppercase">
                        Household Management
                    </p>

                    <h1 class="clay-page-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                        Edit Household
                    </h1>


                </div>


                <a
                    href="{{ route('households.show', $household) }}"
                    class="clay-back-button inline-flex shrink-0 items-center gap-2 rounded-xl px-3 py-2.5 text-sm font-semibold transition sm:px-4"
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
                        Back to Household
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
        <main class="clay-main mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 sm:py-8 lg:px-8">

            {{-- ==================================================
                 VALIDATION ERRORS
            =================================================== --}}
            @if ($errors->any())

                <div class="clay-error-panel mb-6 p-5">

                    <div class="flex gap-3">

                        <div class="clay-error-icon mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center">

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

                        <div>

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
                action="{{ route('households.update', $household) }}"
                class="space-y-6"
            >

                @csrf
                @method('PUT')

                {{-- =================================================
                     REQUIRED UPDATE IDENTIFIERS
                     These are hidden because they are not editable
                     from the household information UI.
                ================================================== --}}

                <input
                    type="hidden"
                    name="household_code"
                    value="{{ old('household_code', $household->household_code) }}"
                >

                <input
                    type="hidden"
                    name="household_head[id]"
                    value="{{ old('household_head.id', $head?->id) }}"
                >


                {{-- =================================================
                     HOUSEHOLD HEAD
                ================================================== --}}
                <section class="clay-card">

                    <div class="clay-card-header px-5 py-5 sm:px-6">

                        <div class="flex items-center gap-3">

                            <div class="clay-section-icon head flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                        d="M15 19.128a9.38 9.38 0 0 0 3.75-1.22M9 19.128a9.38 9.38 0 0 0-3.75-1.22M15 19.128v-.002a6.75 6.75 0 0 0-6 0v.002M12 12.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5Z"
                                    />
                                </svg>

                            </div>

                            <div class="min-w-0">

                                <h2 class="clay-section-title text-base font-bold">
                                    Household Head
                                </h2>

                                <p class="clay-section-description text-sm">
                                    Household and household head information.
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
                                    <span class="clay-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="household_head[first_name]"
                                    value="{{ old('household_head.first_name', $head?->first_name) }}"
                                    required
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >

                            </div>


                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Middle Name
                                </label>

                                <input
                                    type="text"
                                    name="household_head[middle_name]"
                                    value="{{ old('household_head.middle_name', $head?->middle_name) }}"
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >

                            </div>


                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Last Name
                                    <span class="clay-required">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="household_head[last_name]"
                                    value="{{ old('household_head.last_name', $head?->last_name) }}"
                                    required
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >

                            </div>


                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Suffix
                                </label>

                                <input
                                    type="text"
                                    name="household_head[suffix]"
                                    value="{{ old('household_head.suffix', $head?->suffix) }}"
                                    placeholder="Jr., Sr., III"
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >

                            </div>

                        </div>


                        {{-- Personal --}}
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                            <div class="grid grid-cols-2 gap-5 sm:col-span-2">

                                <div>
                                    <label class="clay-label block text-sm font-semibold">
                                        Birth Date
                                        <span class="clay-required">*</span>
                                    </label>

                                    <input
                                        type="date"
                                        name="household_head[birth_date]"
                                        value="{{ old('household_head.birth_date', optional($head?->birth_date)->format('Y-m-d')) }}"
                                        max="{{ now()->format('Y-m-d') }}"
                                        data-age-source
                                        data-today="{{ now()->format('Y-m-d') }}"
                                        required
                                        class="clay-input mt-2 px-4 py-2.5 text-sm"
                                    >
                                </div>

                                <div>
                                    <label class="clay-label block text-sm font-semibold">Age
                                        <input type="text" readonly data-age-display class="clay-input mt-2 px-4 py-2.5 text-sm">
                                    </label>
                                </div>

                            </div>


                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Gender
                                    <span class="clay-required">*</span>
                                </label>

                                <select
                                    name="household_head[gender]"
                                    required
                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                >

                                    <option value="">
                                        Select gender
                                    </option>

                                    <option
                                        value="Male"
                                        @selected(old('household_head.gender', $head?->gender) === 'Male')
                                    >
                                        Male
                                    </option>

                                    <option
                                        value="Female"
                                        @selected(old('household_head.gender', $head?->gender) === 'Female')
                                    >
                                        Female
                                    </option>

                                </select>

                            </div>


                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Civil Status
                                    <span class="clay-required">*</span>
                                </label>

                                <select
                                    name="household_head[civil_status]"
                                    required
                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                >

                                    <option value="">
                                        Select status
                                    </option>

                                    <option
                                        value="Single"
                                        @selected(old('household_head.civil_status', $head?->civil_status) === 'Single')
                                    >
                                        Single
                                    </option>

                                    <option
                                        value="Married"
                                        @selected(old('household_head.civil_status', $head?->civil_status) === 'Married')
                                    >
                                        Married
                                    </option>

                                    <option
                                        value="Widowed"
                                        @selected(old('household_head.civil_status', $head?->civil_status) === 'Widowed')
                                    >
                                        Widowed
                                    </option>

                                    <option
                                        value="Separated"
                                        @selected(old('household_head.civil_status', $head?->civil_status) === 'Separated')
                                    >
                                        Separated
                                    </option>

                                    <option
                                        value="Divorced"
                                        @selected(old('household_head.civil_status', $head?->civil_status) === 'Divorced')
                                    >
                                        Divorced
                                    </option>

                                </select>

                            </div>


                        </div>

                        {{-- Address --}}
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                            <div>
                                <label for="purok" class="clay-label block text-sm font-semibold">
                                    Purok <span class="clay-required">*</span>
                                </label>

                                <select
                                    id="purok"
                                    name="purok"
                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                    required
                                    aria-describedby="{{ $errors->has('purok') ? 'purok-error' : '' }}"
                                    aria-invalid="{{ $errors->has('purok') ? 'true' : 'false' }}"
                                >
                                    <option value="">Select Purok</option>
                                    @foreach ($puroks as $purok)
                                        <option value="{{ $purok }}" @selected(old('purok', $addressParts['purok']) === $purok)>
                                            {{ $purok }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('purok')
                                    <p id="purok-error" class="clay-field-error mt-1.5 text-xs font-medium">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            @foreach ($localityParts as $label => $value)
                                <div>
                                    <label for="household-locality-{{ strtolower($label) }}" class="clay-label block text-sm font-semibold">
                                        {{ $label }}
                                    </label>
                                    <input
                                        id="household-locality-{{ strtolower($label) }}"
                                        type="text"
                                        value="{{ $value }}"
                                        readonly
                                        class="clay-input mt-2 px-4 py-2.5 text-sm"
                                        aria-label="{{ $label }}: {{ $value }} (fixed locality)"
                                    >
                                </div>
                            @endforeach

                            <input type="hidden" name="address" value="">
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="clay-label block text-sm font-semibold">
                                    Household Status <span class="clay-required">*</span>
                                </label>
                                <select name="status" required class="clay-select mt-2 px-4 py-2.5 text-sm">
                                    <option value="Active" @selected(old('status', $household->status) === 'Active')>Active</option>
                                    <option value="Inactive" @selected(old('status', $household->status) === 'Inactive')>Inactive</option>
                                </select>
                            </div>

                            <div>
                                <p class="text-sm text-[#6D817A]">Household members use the household head's contact number.</p>
                            </div>
                        </div>

                        {{-- Contact --}}
                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">

                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Head Contact Number <span class="clay-required">*</span>
                                </label>

                                <input
                                    type="tel"
                                    name="household_head[contact_number]"
                                    required
                                    value="{{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay(old('household_head.contact_number', $head?->contact_number)) ?: '+63' }}"
                                    inputmode="numeric"
                                    maxlength="24"
                                    placeholder="+6391 7123 4567"
                                    title="Only Globe and DITO SIM numbers are supported."
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >

                            </div>


                            <div>

                                <label class="clay-label block text-sm font-semibold">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    name="household_head[email]"
                                    value="{{ old('household_head.email', $head?->email) }}"
                                    placeholder="name@example.com"
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >

                            </div>

                            <div>
                                <label class="clay-label block text-sm font-semibold">PhilHealth Number</label>
                                <input
                                    type="text"
                                    name="household_head[philhealth_number]"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    title="Use digits only."
                                    value="{{ old('household_head.philhealth_number', $head?->philhealth_number) }}"
                                    placeholder="PhilHealth number"
                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                >
                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                     FAMILY MEMBERS
                ================================================== --}}
                <section class="clay-card">

                    <div class="clay-card-header flex flex-col gap-4 px-5 py-5 sm:px-6 lg:flex-row lg:items-center lg:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="clay-section-icon members flex h-10 w-10 shrink-0 items-center justify-center rounded-xl">

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
                                        d="M18 18.72a9.094 9.094 0 0 0 3.75-1.22M6 18.72a9.094 9.094 0 0 1-3.75-1.22M18 18.72v-.002a6.75 6.75 0 0 0-12 0v.002M15 8.25a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm4.5 2.25a2.25 2.25 0 1 1-4.5 0m-9 0a2.25 2.25 0 1 1-4.5 0"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="clay-section-title text-base font-bold">
                                    Family Members
                                </h2>

                                <p class="clay-section-description text-sm">
                                    Manage members who belong to this household.
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

                        @php
                            $oldMembers = old('members', []);
                            $oldMembers = is_array($oldMembers) ? $oldMembers : [];
                            $displayMembers = session()->hasOldInput()
                                ? collect($oldMembers)->mapWithKeys(function ($oldMember, $index) use ($members) {
                                    $member = is_array($oldMember) && ! empty($oldMember['id'])
                                        ? $members->firstWhere('id', (int) $oldMember['id'])
                                        : null;

                                    return $member ? [$index => $member] : [];
                                })
                                : $members;
                        @endphp
                        <div
                            id="no-members"
                            class="{{ $displayMembers->count() > 0 ? 'hidden' : '' }} family-empty px-6 py-10 text-center"
                        >

                            <div class="family-empty-icon mx-auto flex h-12 w-12 items-center justify-center">

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

                            <h3 class="mt-3 text-sm font-semibold text-slate-800">
                                No family members added
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Click “Add Family Member” to add another member.
                            </p>

                        </div>


                        <div
                            id="members-container"
                            class="space-y-5"
                        >

                            @foreach ($displayMembers as $index => $member)

                                <div class="member-card rounded-2xl p-5">

                                    <div class="mb-5 flex items-center justify-between gap-4">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                                                <span class="member-number">
                                                    {{ $index + 1 }}
                                                </span>

                                            </div>

                                            <div>

                                                <h3 class="text-sm font-bold text-slate-900">
                                                    Family Member
                                                </h3>

                                                <p class="member-subtitle text-xs">
                                                    Existing household member
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
                                                    <span class="clay-required">*</span>
                                                </label>

                                                <input
                                                    type="text"
                                                    name="members[{{ $index }}][first_name]"
                                                    value="{{ old("members.$index.first_name", $member->first_name) }}"
                                                    required
                                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                >

                                            </div>


                                            <div>

                                                <label class="clay-label block text-sm font-semibold">
                                                    Middle Name
                                                </label>

                                                <input
                                                    type="text"
                                                    name="members[{{ $index }}][middle_name]"
                                                    value="{{ old("members.$index.middle_name", $member->middle_name) }}"
                                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                >

                                            </div>


                                            <div>

                                                <label class="clay-label block text-sm font-semibold">
                                                    Last Name
                                                    <span class="clay-required">*</span>
                                                </label>

                                                <input
                                                    type="text"
                                                    name="members[{{ $index }}][last_name]"
                                                    value="{{ old("members.$index.last_name", $member->last_name) }}"
                                                    required
                                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                >

                                            </div>


                                            <div>

                                                <label class="clay-label block text-sm font-semibold">
                                                    Suffix
                                                </label>

                                                <input
                                                    type="text"
                                                    name="members[{{ $index }}][suffix]"
                                                    value="{{ old("members.$index.suffix", $member->suffix) }}"
                                                    placeholder="Jr., Sr., III"
                                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                >

                                            </div>

                                        </div>


                                        {{-- Personal --}}
                                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                                            {{-- Relationship --}}
                                            <div>

                                                <label class="clay-label block text-sm font-semibold">
                                                    Relationship
                                                    <span class="clay-required">*</span>
                                                </label>

                                                <select
                                                    name="members[{{ $index }}][relationship_to_head]"
                                                    required
                                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                                >

                                                    <option value="">
                                                        Select relationship
                                                    </option>

                                                    @foreach ([
                                                        'Son',
                                                        'Daughter',
                                                        'Wife',
                                                        'Husband',
                                                        'Mother',
                                                        'Father',
                                                        'Grandmother',
                                                        'Grandfather',
                                                        'Sister',
                                                        'Brother',
                                                        'Grandchild',
                                                        'Other Relative',
                                                        'Other'
                                                    ] as $relationship)

                                                        <option
                                                            value="{{ $relationship }}"
                                                            @selected(old("members.$index.relationship_to_head", $member->relationship_to_head) === $relationship)
                                                        >
                                                            {{ $relationship }}
                                                        </option>

                                                    @endforeach

                                                </select>

                                            </div>


                                            <div class="grid grid-cols-2 gap-5 sm:col-span-2">

                                                <div>
                                                    <label class="clay-label block text-sm font-semibold">
                                                        Birth Date
                                                        <span class="clay-required">*</span>
                                                    </label>

                                                    <input
                                                        type="date"
                                                        name="members[{{ $index }}][birth_date]"
                                                        value="{{ old("members.$index.birth_date", optional($member->birth_date)->format('Y-m-d')) }}"
                                                        max="{{ now()->format('Y-m-d') }}"
                                                        data-age-source
                                                        data-today="{{ now()->format('Y-m-d') }}"
                                                        required
                                                        class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                    >
                                                </div>

                                                <div>
                                                    <label class="clay-label block text-sm font-semibold">Age
                                                        <input type="text" readonly data-age-display class="clay-input mt-2 px-4 py-2.5 text-sm">
                                                    </label>
                                                </div>

                                            </div>


                                            {{-- Gender --}}
                                            <div>

                                                <label class="clay-label block text-sm font-semibold">
                                                    Gender
                                                    <span class="clay-required">*</span>
                                                </label>

                                                <select
                                                    name="members[{{ $index }}][gender]"
                                                    required
                                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                                >

                                                    <option value="">
                                                        Select gender
                                                    </option>

                                                    <option
                                                        value="Male"
                                                        @selected(old("members.$index.gender", $member->gender) === 'Male')
                                                    >
                                                        Male
                                                    </option>

                                                    <option
                                                        value="Female"
                                                        @selected(old("members.$index.gender", $member->gender) === 'Female')
                                                    >
                                                        Female
                                                    </option>

                                                </select>

                                            </div>


                                            {{-- Civil Status --}}
                                            <div>

                                                <label class="clay-label block text-sm font-semibold">
                                                    Civil Status
                                                    <span class="clay-required">*</span>
                                                </label>

                                                <select
                                                    name="members[{{ $index }}][civil_status]"
                                                    required
                                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                                >

                                                    <option value="">
                                                        Select status
                                                    </option>

                                                    @foreach ([
                                                        'Single',
                                                        'Married',
                                                        'Widowed',
                                                        'Separated',
                                                        'Divorced'
                                                    ] as $status)

                                                        <option
                                                            value="{{ $status }}"
                                                            @selected(old("members.$index.civil_status", $member->civil_status) === $status)
                                                        >
                                                            {{ $status }}
                                                        </option>

                                                    @endforeach

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
                                                    name="members[{{ $index }}][philhealth_number]"
                                                    inputmode="numeric"
                                                    pattern="[0-9]*"
                                                    title="Use digits only."
                                                    value="{{ old("members.$index.philhealth_number", $member->philhealth_number) }}"
                                                    placeholder="PhilHealth number"
                                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                >

                                            </div>


                                            <div>

                                                <p class="text-sm text-[#6D817A]">Uses the household head's contact number.</p>

                                            </div>

                                        </div>


                                        {{-- Email and status --}}
                                        <div class="grid gap-5 sm:grid-cols-2">

                                            <div>
                                                <label class="clay-label block text-sm font-semibold">
                                                    Email (Optional)
                                                </label>

                                                <input
                                                    type="email"
                                                    name="members[{{ $index }}][email]"
                                                    value="{{ old("members.$index.email", $member->email) }}"
                                                    placeholder="name@example.com"
                                                    class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                >
                                            </div>

                                            <div>
                                                <label class="clay-label block text-sm font-semibold">
                                                    Status <span class="clay-required">*</span>
                                                    <select name="members[{{ $index }}][status]" required class="clay-select mt-2 px-4 py-2.5 text-sm">
                                                        <option value="Active" @selected(old("members.$index.status", $member->status) === 'Active')>Active</option>
                                                        <option value="Inactive" @selected(old("members.$index.status", $member->status) === 'Inactive')>Inactive</option>
                                                    </select>
                                                </label>
                                            </div>

                                        </div>

                                        {{-- Family member address --}}
                                        <p class="clay-label text-sm font-semibold">
                                            Address
                                        </p>
                                        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                                            <div>
                                                <label
                                                    for="member-{{ $index }}-purok"
                                                    class="clay-label block text-sm font-semibold"
                                                >
                                                    Purok
                                                    <span class="clay-required">*</span>
                                                </label>

                                                <select
                                                    id="member-{{ $index }}-purok"
                                                    name="members[{{ $index }}][purok]"
                                                    required
                                                    aria-invalid="{{ $errors->has("members.$index.purok") ? 'true' : 'false' }}"
                                                    @if ($errors->has("members.$index.purok")) aria-describedby="member-{{ $index }}-purok-error" @endif
                                                    class="clay-select mt-2 px-4 py-2.5 text-sm"
                                                >
                                                    <option value="">Select Purok</option>

                                                    @foreach ($puroks as $purok)
                                                        <option
                                                            value="{{ $purok }}"
                                                            @selected(old("members.$index.purok", $memberAddressParts[$member->id]['purok'] ?? null) === $purok)
                                                        >
                                                            {{ $purok }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @error("members.$index.purok")
                                                    <p
                                                        id="member-{{ $index }}-purok-error"
                                                        class="clay-field-error mt-1.5 text-xs font-medium"
                                                    >
                                                        {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>

                                            @foreach ($localityParts as $label => $value)
                                                <div>
                                                    <label
                                                        for="member-{{ $index }}-locality-{{ strtolower($label) }}"
                                                        class="clay-label block text-sm font-semibold"
                                                    >
                                                        {{ $label }}
                                                    </label>
                                                    <input
                                                        id="member-{{ $index }}-locality-{{ strtolower($label) }}"
                                                        type="text"
                                                        value="{{ $value }}"
                                                        readonly
                                                        class="clay-input mt-2 px-4 py-2.5 text-sm"
                                                        aria-label="{{ $label }}: {{ $value }} (fixed locality)"
                                                    >
                                                </div>
                                            @endforeach

                                        </div>

                                    </div>


                                    {{-- Keep existing resident ID --}}
                                    <input
                                        type="hidden"
                                        name="members[{{ $index }}][id]"
                                        value="{{ $member->id }}"
                                    >

                                </div>

                            @endforeach

                        </div>

                    </div>

                </section>


                {{-- =================================================
                     ACTIONS
                ================================================== --}}
                <div class="flex flex-col-reverse gap-3 pb-8 sm:flex-row sm:justify-end">

                    <a
                        href="{{ route('households.show', $household) }}"
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

                        Update Household

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

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg">

                        <span class="member-number">
                            1
                        </span>

                    </div>

                    <div>

                        <h3 class="text-sm font-bold text-slate-900">
                            Family Member
                        </h3>

                        <p class="member-subtitle text-xs">
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
                            <span class="clay-required">*</span>
                        </label>

                        <input
                            type="text"
                            data-field="first_name"
                            data-person-name-strict
                            required
                            class="clay-input mt-2 px-4 py-2.5 text-sm"
                        >
                    </div>

                    <div>
                        <label class="clay-label block text-sm font-semibold">
                            Middle Name
                        </label>

                        <input
                            type="text"
                            data-field="middle_name"
                            data-person-name-strict
                            class="clay-input mt-2 px-4 py-2.5 text-sm"
                        >
                    </div>

                    <div>
                        <label class="clay-label block text-sm font-semibold">
                            Last Name
                            <span class="clay-required">*</span>
                        </label>

                        <input
                            type="text"
                            data-field="last_name"
                            data-person-name-strict
                            required
                            class="clay-input mt-2 px-4 py-2.5 text-sm"
                        >
                    </div>

                    <div>
                        <label class="clay-label block text-sm font-semibold">
                            Suffix (Optional)
                        </label>

                        <select data-field="suffix" class="clay-select mt-2 px-4 py-2.5 text-sm">
                            <option value="">None</option>
                            <option value="Jr.">Jr.</option>
                            <option value="Sr.">Sr.</option>
                        </select>
                    </div>

                </div>


                {{-- Personal --}}
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Relationship
                            <span class="clay-required">*</span>
                        </label>

                        <select
                            data-field="relationship_to_head"
                            required
                            class="clay-select mt-2 px-4 py-2.5 text-sm"
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


                    <div class="grid grid-cols-2 gap-5 sm:col-span-2">

                        <div>
                            <label class="clay-label block text-sm font-semibold">
                                Birth Date
                                <span class="clay-required">*</span>
                            </label>

                            <input
                                type="date"
                                data-field="birth_date"
                                max="{{ now()->format('Y-m-d') }}"
                                data-age-source
                                data-today="{{ now()->format('Y-m-d') }}"
                                required
                                class="clay-input mt-2 px-4 py-2.5 text-sm"
                            >
                        </div>

                        <div>
                            <label class="clay-label block text-sm font-semibold">Age
                                <input type="text" readonly data-age-display class="clay-input mt-2 px-4 py-2.5 text-sm">
                            </label>
                        </div>

                    </div>


                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Gender
                            <span class="clay-required">*</span>
                        </label>

                        <select
                            data-field="gender"
                            required
                            class="clay-select mt-2 px-4 py-2.5 text-sm"
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


                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            Civil Status
                            <span class="clay-required">*</span>
                        </label>

                        <select
                            data-field="civil_status"
                            required
                            class="clay-select mt-2 px-4 py-2.5 text-sm"
                        >

                            <option value="">
                                Select status
                            </option>

                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                            <option value="Divorced">Divorced</option>

                        </select>

                    </div>

                </div>


                {{-- PhilHealth + Contact --}}
                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label class="clay-label block text-sm font-semibold">
                            PhilHealth Number (Optional)
                        </label>

                        <input
                            type="text"
                            data-field="philhealth_number"
                            inputmode="numeric"
                            pattern="[0-9]*"
                            title="Use digits only."
                            placeholder="PhilHealth number"
                            class="clay-input mt-2 px-4 py-2.5 text-sm"
                        >

                    </div>


                    <div>

                        <p class="text-sm text-[#6D817A]">Uses the household head's contact number.</p>

                    </div>

                </div>


                {{-- Email and status --}}
                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="clay-label block text-sm font-semibold">
                            Email (Optional)
                            <input type="email" data-field="email" placeholder="name@example.com" class="clay-input mt-2 px-4 py-2.5 text-sm">
                        </label>
                    </div>

                    <div>
                        <label class="clay-label block text-sm font-semibold">
                            Status <span class="clay-required">*</span>
                            <select data-field="status" required class="clay-select mt-2 px-4 py-2.5 text-sm">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </label>
                    </div>
                </div>

                <p class="clay-label text-sm font-semibold">Address</p>
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div>
                        <label class="clay-label block text-sm font-semibold">
                            Purok <span class="clay-required">*</span>
                            <select data-field="purok" required class="clay-select mt-2 px-4 py-2.5 text-sm">
                                <option value="">Select Purok</option>
                                @foreach ($puroks as $purok)
                                    <option value="{{ $purok }}">{{ $purok }}</option>
                                @endforeach
                            </select>
                        </label>
                    </div>
                    @foreach ($localityParts as $label => $value)
                        <div>
                            <label class="clay-label block text-sm font-semibold">
                                {{ $label }}
                                <input type="text" value="{{ $value }}" readonly class="clay-input mt-2 px-4 py-2.5 text-sm" aria-label="{{ $label }}: {{ $value }} (fixed locality)">
                            </label>
                        </div>
                    @endforeach
                </div>

            </div>

        </div>

    </template>


    {{-- ==========================================================
         JAVASCRIPT
    =========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const container = document.getElementById('members-container');
            const template = document.getElementById('member-template');
            const addButton = document.getElementById('add-member');
            const emptyState = document.getElementById('no-members');

            let memberIndex = {{ $members->count() }};


            function updateMemberNumbers() {

                const cards = container.querySelectorAll('.member-card');

                cards.forEach((card, index) => {

                    const number = card.querySelector('.member-number');

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


            function addMember(memberData = {}, focusFirstName = true, restoredIndex = null) {

                const fragment = template.content.cloneNode(true);

                const card = fragment.querySelector('.member-card');
                const index = restoredIndex ?? memberIndex;


                card.querySelectorAll('[data-field]').forEach((input) => {

                    const field = input.dataset.field;

                    input.name =
                        `members[${index}][${field}]`;

                    if (Object.prototype.hasOwnProperty.call(memberData, field)) {
                        input.value = memberData[field] ?? '';
                    }

                });


                container.appendChild(fragment);

                card.querySelectorAll('[data-age-source], [data-local-mobile]').forEach((input) => {
                    input.dispatchEvent(new Event('input', { bubbles: true }));
                });

                memberIndex = Math.max(memberIndex, index + 1);

                updateMemberNumbers();


                const cards =
                    container.querySelectorAll('.member-card');

                const latestCard =
                    cards[cards.length - 1];


                if (focusFirstName) {
                    latestCard
                        ?.querySelector('[data-field="first_name"]')
                        ?.focus();
                }

            }


            addButton.addEventListener(
                'click',
                () => addMember()
            );


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

            container.addEventListener(
                'remove-member-confirmed',
                function (event) {
                    const card = event.detail.button.closest('.member-card');

                    if (card) {
                        card.remove();
                    }

                    updateMemberNumbers();
                }
            );

            const oldMembers = @js(old('members', []));
            if (oldMembers && typeof oldMembers === 'object') {
                Object.entries(oldMembers).forEach(([index, member]) => {
                    memberIndex = Math.max(memberIndex, Number(index) + 1);
                    if (member && !member.id) {
                        addMember(member, false, Number(index));
                    }
                });
            }

            updateMemberNumbers();

        });
    </script>

</body>
</html>