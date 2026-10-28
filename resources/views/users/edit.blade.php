<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Staff Account | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Edit a Health Worker or Barangay Official staff account."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           GOVERNMENT-STYLE CLAYMORPHISM
        ========================================================== */

        .clay-edit {
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

            min-height: 100vh;

            font-family: Arial, Helvetica, sans-serif !important;

            color: var(--gov-text);

            background:
                radial-gradient(
                    circle at 10% 5%,
                    rgba(255, 255, 255, 0.68),
                    transparent 25%
                ),
                radial-gradient(
                    circle at 90% 12%,
                    rgba(42, 155, 128, 0.07),
                    transparent 24%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1 0%,
                    #F5FAF7 52%,
                    #EDF5F0 100%
                );
        }

        .clay-edit,
        .clay-edit button,
        .clay-edit input,
        .clay-edit select,
        .clay-edit textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-edit h1,
        .clay-edit h2,
        .clay-edit h3,
        .clay-edit p,
        .clay-edit label {
            text-shadow: 0 1px 0 rgba(255, 255, 255, 0.78);
        }

        /* =========================================================
           HEADER
        ========================================================== */

        .clay-edit header {
            background: rgba(245, 250, 247, 0.96) !important;

            border-color: rgba(255, 255, 255, 0.82) !important;

            box-shadow:
                0 5px 15px rgba(107, 134, 124, 0.12),
                0 1px 0 rgba(255, 255, 255, 0.90);
        }

        .clay-edit header .rounded-lg.border,
        .clay-edit header .rounded-xl.border {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border-color: rgba(255, 255, 255, 0.84) !important;

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.17),
                -5px -5px 10px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        /* =========================================================
           SURFACE CARDS
        ========================================================== */

        .clay-edit section.rounded-2xl,
        .clay-edit .rounded-2xl.border.bg-white {
            position: relative;

            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border: 1px solid rgba(255, 255, 255, 0.84) !important;

            border-radius: 24px !important;

            box-shadow:
                10px 10px 22px var(--gov-shadow),
                -10px -10px 22px var(--gov-highlight),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84) !important;
        }

        .clay-edit section.rounded-2xl::before {
            content: "";

            position: absolute;

            top: -50px;
            right: -45px;

            width: 130px;
            height: 130px;

            border-radius: 50%;

            background: rgba(255, 255, 255, 0.20);

            pointer-events: none;
        }

        /* =========================================================
           SECTION HEADERS
        ========================================================== */

        .clay-edit section > div:first-child {
            background:
                linear-gradient(
                    145deg,
                    #F5FAF7,
                    #EAF2EE
                ) !important;

            border-color: rgba(210, 225, 218, 0.55) !important;
        }

        /* =========================================================
           CURRENT ACCOUNT PANEL
        ========================================================== */

        .clay-edit .bg-slate-50,
        .clay-edit .bg-slate-50\/70 {
            background:
                linear-gradient(
                    145deg,
                    #F3F9F6,
                    #E7F0EB
                ) !important;
        }

        .clay-edit .rounded-xl.border {
            border-color: rgba(255, 255, 255, 0.76) !important;

            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.15),
                -5px -5px 11px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           INPUTS / SELECTS
        ========================================================== */

        .clay-edit input,
        .clay-edit select {
            background: #F5FAF7 !important;

            border-color: rgba(180, 202, 193, 0.72) !important;

            border-radius: 14px !important;

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.90) !important;

            color: var(--gov-text) !important;
        }

        .clay-edit input::placeholder {
            color: var(--gov-placeholder) !important;
        }

        .clay-edit input:focus,
        .clay-edit select:focus {
            border-color: var(--gov-primary) !important;

            outline: none !important;

            box-shadow:
                0 0 0 3px rgba(22, 139, 112, 0.10),
                inset 3px 3px 7px rgba(107, 134, 124, 0.09),
                inset -3px -3px 7px rgba(255, 255, 255, 0.92) !important;
        }

        /* =========================================================
           ICON BUBBLES
        ========================================================== */

        .clay-edit .rounded-xl.bg-\[\#E8F4EF\],
        .clay-edit .rounded-xl.bg-orange-50,
        .clay-edit .rounded-lg.bg-white {
            border: 1px solid rgba(255, 255, 255, 0.76);

            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.15),
                -4px -4px 9px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           GREEN COLORS
        ========================================================== */

        .clay-edit .text-\[\#0F4C3A\],
        .clay-edit .text-\[\#128C5A\] {
            color: var(--gov-primary-dark) !important;
        }

        .clay-edit .bg-\[\#0F4C3A\] {
            background-color: var(--gov-primary-dark) !important;
        }

        .clay-edit .bg-\[\#0F4C3A\]:hover {
            background-color: #0C5D4C !important;
        }

        .clay-edit .text-emerald-700 {
            color: var(--gov-primary-dark) !important;
        }

        .clay-edit .bg-emerald-50 {
            background: #EAF5F0 !important;
        }

        /* =========================================================
           ORANGE ACCENT
        ========================================================== */

        .clay-edit .bg-orange-50 {
            background: #FBF1E8 !important;
        }

        .clay-edit .text-\[\#E87928\] {
            color: var(--gov-orange) !important;
        }

        /* =========================================================
           INFORMATION NOTICE
        ========================================================== */

        .clay-edit .bg-blue-50 {
            background: #EDF5F0 !important;
        }

        .clay-edit .border-blue-100 {
            border-color: rgba(200, 222, 213, 0.80) !important;
        }

        .clay-edit .text-blue-600,
        .clay-edit .text-blue-700 {
            color: #52786C !important;
        }

        /* =========================================================
           SECURITY NOTICE
        ========================================================== */

        .clay-edit .bg-\[\#EEF8F3\] {
            background:
                linear-gradient(
                    145deg,
                    #F1F9F5,
                    #E5F1EB
                ) !important;
        }

        .clay-edit .border-\[\#CFE5DC\] {
            border-color: rgba(207, 229, 220, 0.82) !important;
        }

        /* =========================================================
           VALIDATION ERROR
        ========================================================== */

        .clay-edit .bg-red-50 {
            background: #FDF1F1 !important;
        }

        .clay-edit .border-red-200 {
            border-color: rgba(239, 190, 190, 0.75) !important;
        }

        .clay-edit .text-red-800,
        .clay-edit .text-red-700,
        .clay-edit .text-red-600 {
            color: #A93636 !important;
        }

        /* =========================================================
           BUTTONS
        ========================================================== */

        .clay-edit button,
        .clay-edit a {
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background-color 0.18s ease,
                border-color 0.18s ease,
                color 0.18s ease;
        }

        .clay-edit button[type="submit"] {
            border: 1px solid rgba(255, 255, 255, 0.25);

            box-shadow:
                6px 6px 12px rgba(107, 134, 124, 0.22),
                -5px -5px 10px rgba(255, 255, 255, 0.48),
                inset 1px 1px 0 rgba(255, 255, 255, 0.18);
        }

        .clay-edit button[type="submit"]:hover {
            transform: translateY(-1px);

            box-shadow:
                8px 8px 15px rgba(107, 134, 124, 0.24),
                -6px -6px 12px rgba(255, 255, 255, 0.55),
                inset 1px 1px 0 rgba(255, 255, 255, 0.20);
        }

        .clay-edit a.rounded-xl.border {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border-color: rgba(255, 255, 255, 0.82) !important;

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.15),
                -5px -5px 10px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.75);
        }

        .clay-edit a.rounded-xl.border:hover {
            transform: translateY(-1px);
        }

        /* =========================================================
           STATUS BADGES
        ========================================================== */

        .clay-edit .bg-emerald-50 {
            box-shadow:
                inset 1px 1px 0 rgba(255, 255, 255, 0.72);
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================== */

        .clay-edit a:focus-visible,
        .clay-edit button:focus-visible,
        .clay-edit input:focus-visible,
        .clay-edit select:focus-visible {
            outline: 2px solid var(--gov-primary);

            outline-offset: 2px;
        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {
            .clay-edit button,
            .clay-edit a {
                transition: none !important;
            }
        }
    </style>
</head>

<body class="clay-edit min-h-screen bg-[#EEF5F1] text-[#164238]">

    {{-- Admin Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Content --}}
    <main class="min-h-screen lg:pl-72">

        {{-- Header --}}
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Mobile Sidebar Button --}}
                <button
                    type="button"
                    onclick="openAdminSidebar()"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-white p-2 text-slate-600 shadow-sm transition hover:bg-slate-50 lg:hidden"
                    aria-label="Open sidebar"
                >
                    <svg
                        class="h-6 w-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>

                {{-- Header Title --}}
                <div class="hidden flex-1 lg:block">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#0F6F5A]">
                        System Administrator
                    </p>

                    <h1 class="text-sm font-semibold text-[#164238]">
                        Edit Staff Account
                    </h1>
                </div>

                {{-- Header Actions --}}
                <div class="flex items-center gap-3">

                    {{-- Notification Bell --}}
                    @include('partials.notification-bell')

                    {{-- Profile --}}
                    <div class="hidden items-center gap-3 border-l border-slate-200 pl-4 sm:flex">

                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-[#0F6F5A] text-sm font-bold text-white">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>

                        <div class="hidden xl:block">
                            <p class="max-w-[180px] truncate text-sm font-semibold text-[#164238]">
                                {{ auth()->user()->name ?? 'System Administrator' }}
                            </p>

                            <p class="text-xs text-[#6D817A]">
                                System Administrator
                            </p>
                        </div>

                    </div>

                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="px-4 py-8 sm:px-6 lg:px-8">

            <div class="mx-auto max-w-5xl">

                {{-- Back Link --}}
                <div class="mb-6">
                    <a
                        href="{{ route('users.index') }}"
                        class="inline-flex items-center gap-2 text-sm font-medium text-[#6D817A] transition hover:text-[#0F6F5A]"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            />
                        </svg>

                        Back to Users
                    </a>
                </div>

                {{-- Page Heading --}}
                <div class="mb-8">

                    <div class="mb-3 inline-flex items-center gap-2 rounded-full bg-[#EAF5F0] px-3 py-1 text-xs font-semibold text-[#0F6F5A]">
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                            />
                        </svg>

                        Staff Accounts
                    </div>

                    <h2 class="text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                        Edit Staff Account
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-[#6D817A]">
                        Update the account information, role, or password
                        for this staff member.
                    </p>

                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 shadow-sm">
                        <div class="flex gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4m0 4h.01M10.29 3.86l-7.82 14a2 2 0 001.83 3h15.4a2 2 0 001.83-3l-7.82-14a2 2 0 00-3.66 0z"
                                />
                            </svg>

                            <div>
                                <p class="text-sm font-semibold text-red-800">
                                    Please correct the following errors:
                                </p>

                                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>

                        </div>
                    </div>
                @endif

                {{-- Edit Form --}}
                <form
                    action="{{ route('users.update', $user) }}"
                    method="POST"
                    class="space-y-6"
                >

                    @csrf
                    @method('PUT')

                    {{-- Account Information --}}
                    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 bg-slate-50/70 px-5 py-5 sm:px-6">
                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-[#EAF5F0] text-[#0F6F5A]">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-base font-semibold text-[#164238]">
                                        Staff Account Information
                                    </h3>

                                    <p class="mt-1 text-sm text-[#6D817A]">
                                        Update the basic information for this staff account.
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="space-y-6 p-5 sm:p-6">

                            {{-- Current Status --}}
                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="text-xs font-semibold uppercase tracking-wider text-[#6D817A]">
                                            Current Account
                                        </p>

                                        <p class="mt-1 text-base font-semibold text-[#164238]">
                                            {{ $user->name }}
                                        </p>

                                        <p class="mt-1 text-sm text-[#6D817A]">
                                            {{ $user->email }}
                                        </p>
                                    </div>

                                    @if ($user->status === 'active')
                                        <span class="inline-flex w-fit items-center rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @endif

                                </div>
                            </div>

                            {{-- Name --}}
                            <div>
                                <label
                                    class="mb-2 block text-sm font-semibold text-[#385C52]"
                                >
                                    Full Name
                                    <span class="text-red-500">*</span>
                                </label>

                                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                    <div>
                                        <label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#6D817A]">
                                            First Name
                                        </label>
                                        <input
                                            type="text"
                                            id="first_name"
                                            name="first_name"
                                            value="{{ old('first_name', $nameParts['first_name'] ?? '') }}"
                                            required
                                            maxlength="255"
                                            autocomplete="given-name"
                                            placeholder="First name"
                                            style="text-transform: capitalize;"
                                            class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-slate-400 focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20 @error('first_name') border-red-400 @enderror"
                                        >
                                        @error('first_name')
                                            <p class="mt-2 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="middle_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#6D817A]">
                                            Middle Name
                                        </label>
                                        <input
                                            type="text"
                                            id="middle_name"
                                            name="middle_name"
                                            value="{{ old('middle_name', $nameParts['middle_name'] ?? '') }}"
                                            maxlength="255"
                                            autocomplete="additional-name"
                                            placeholder="Middle name"
                                            style="text-transform: capitalize;"
                                            class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-slate-400 focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20 @error('middle_name') border-red-400 @enderror"
                                        >
                                        @error('middle_name')
                                            <p class="mt-2 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#6D817A]">
                                            Last Name
                                        </label>
                                        <input
                                            type="text"
                                            id="last_name"
                                            name="last_name"
                                            value="{{ old('last_name', $nameParts['last_name'] ?? '') }}"
                                            required
                                            maxlength="255"
                                            autocomplete="family-name"
                                            placeholder="Last name"
                                            style="text-transform: capitalize;"
                                            class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-slate-400 focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20 @error('last_name') border-red-400 @enderror"
                                        >
                                        @error('last_name')
                                            <p class="mt-2 text-sm text-red-600">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label
                                    for="email"
                                    class="mb-2 block text-sm font-semibold text-[#385C52]"
                                >
                                    Email Address
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    maxlength="255"
                                    autocomplete="email"
                                    placeholder="staff@example.com"
                                    class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-slate-400 focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20 @error('email') border-red-400 @enderror"
                                >

                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <p class="mt-2 text-xs text-[#6D817A]">
                                    This email address is used when the staff member logs in.
                                </p>
                            </div>

                            {{-- Role --}}
                            <div>
                                <label
                                    for="role"
                                    class="mb-2 block text-sm font-semibold text-[#385C52]"
                                >
                                    Staff Role
                                    <span class="text-red-500">*</span>
                                </label>

                                <select
                                    id="role"
                                    name="role"
                                    required
                                    class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20 @error('role') border-red-400 @enderror"
                                >
                                    <option value="">Select a role</option>

                                    <option
                                        value="Health Worker"
                                        @selected(old('role', $user->role) === 'Health Worker')
                                    >
                                        Health Worker
                                    </option>

                                    <option
                                        value="Official"
                                        @selected(old('role', $user->role) === 'Official')
                                    >
                                        Barangay Official
                                    </option>
                                </select>

                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <div class="mt-3 rounded-xl border border-[#D4E8DF] bg-[#EDF5F0] p-4">
                                    <div class="flex gap-3">

                                        <svg
                                            class="mt-0.5 h-5 w-5 flex-shrink-0 text-[#0F6F5A]"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                            />
                                        </svg>

                                        <p class="text-xs leading-5 text-[#557067]">
                                            Staff accounts can only use the
                                            <strong>Health Worker</strong> or
                                            <strong>Barangay Official</strong> role.
                                        </p>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>

                    {{-- Password --}}
                    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                        <div class="border-b border-slate-200 bg-slate-50/70 px-5 py-5 sm:px-6">
                            <div class="flex items-start gap-3">

                                <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-orange-50 text-[#E87928]">
                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm10-9V7a4 4 0 00-8 0v3h8z"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-base font-semibold text-[#164238]">
                                        Change Password
                                    </h3>

                                    <p class="mt-1 text-sm text-[#6D817A]">
                                        Leave both fields blank to keep the current password.
                                    </p>
                                </div>

                            </div>
                        </div>

                        <div class="space-y-6 p-5 sm:p-6">

                            {{-- New Password --}}
                            <div>
                                <label
                                    for="password"
                                    class="mb-2 block text-sm font-semibold text-[#385C52]"
                                >
                                    New Password
                                </label>

                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Enter new password"
                                    class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-slate-400 focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20 @error('password') border-red-400 @enderror"
                                >

                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <p class="mt-2 text-xs text-[#6D817A]">
                                    Minimum of 8 characters.
                                </p>
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label
                                    for="password_confirmation"
                                    class="mb-2 block text-sm font-semibold text-[#385C52]"
                                >
                                    Confirm New Password
                                </label>

                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    minlength="8"
                                    autocomplete="new-password"
                                    placeholder="Confirm new password"
                                    class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-slate-400 focus:border-[#168B70] focus:ring-2 focus:ring-[#168B70]/20"
                                >

                                <p class="mt-2 text-xs text-[#6D817A]">
                                    Leave blank if you do not want to change the password.
                                </p>
                            </div>

                        </div>
                    </section>

                    {{-- Form Actions --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('users.index') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 sm:w-auto"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#0F6F5A] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#0B5A49] focus:outline-none focus:ring-2 focus:ring-[#168B70] focus:ring-offset-2 sm:w-auto"
                        >
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            Save Changes
                        </button>

                    </div>

                </form>

                {{-- Security Notice --}}
                <div class="mt-8 rounded-2xl border border-[#CFE5DC] bg-[#EEF8F3] p-5">
                    <div class="flex gap-3">

                        <div class="flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-lg bg-white text-[#0F6F5A] shadow-sm">
                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm10-9V7a4 4 0 00-8 0v3h8z"
                                />
                            </svg>
                        </div>

                        <div>
                            <h3 class="text-sm font-semibold text-[#0F6F5A]">
                                Account Management Security
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-[#6D817A]">
                                Staff account changes are recorded in the system
                                audit logs for accountability and security.
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>

</body>

</html>
