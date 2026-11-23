<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>Add Staff Account | Barangay Esperanza Health Center</title>

<meta
    name="description"
    content="Create a Health Worker or Barangay Official staff account."
>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    html,
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    .clay-page {
        background: #EEF5F1;
    }

    .clay-surface {
        background: #F5FAF7;
        box-shadow:
            8px 8px 18px rgba(107, 134, 124, 0.24),
            -8px -8px 18px rgba(255, 255, 255, 0.94);
    }

    .clay-soft {
        background: #EDF5F0;
        box-shadow:
            5px 5px 12px rgba(107, 134, 124, 0.18),
            -5px -5px 12px rgba(255, 255, 255, 0.94);
    }

    .clay-inset {
        background: #F5FAF7;
        box-shadow:
            inset 3px 3px 7px rgba(107, 134, 124, 0.16),
            inset -3px -3px 7px rgba(255, 255, 255, 0.94);
    }

    .clay-button {
        background: #168B70;
        box-shadow:
            5px 5px 10px rgba(107, 134, 124, 0.22),
            -4px -4px 9px rgba(255, 255, 255, 0.94);
    }

    .clay-button:hover {
        background: #0F6F5A;
    }

    .clay-button:active {
        box-shadow:
            inset 3px 3px 6px rgba(7, 79, 62, 0.20),
            inset -3px -3px 6px rgba(255, 255, 255, 0.20);
    }

    .clay-outline-button {
        background: #F5FAF7;
        box-shadow:
            4px 4px 9px rgba(107, 134, 124, 0.18),
            -4px -4px 9px rgba(255, 255, 255, 0.94);
    }

    .clay-outline-button:hover {
        background: #EDF5F0;
    }

    .clay-input {
        background: #F5FAF7;
        border: 1px solid rgba(107, 134, 124, 0.18);
        box-shadow:
            inset 3px 3px 7px rgba(107, 134, 124, 0.13),
            inset -3px -3px 7px rgba(255, 255, 255, 0.94);
    }

    .clay-input:focus {
        border-color: #168B70;
        box-shadow:
            inset 3px 3px 7px rgba(107, 134, 124, 0.12),
            inset -3px -3px 7px rgba(255, 255, 255, 0.94),
            0 0 0 3px rgba(22, 139, 112, 0.12);
    }

    .clay-card {
        border: 1px solid rgba(107, 134, 124, 0.12);
        border-radius: 24px;
        background: #F5FAF7;
        box-shadow:
            9px 9px 20px rgba(107, 134, 124, 0.20),
            -9px -9px 20px rgba(255, 255, 255, 0.94);
    }

    .clay-small-card {
        border: 1px solid rgba(107, 134, 124, 0.10);
        border-radius: 18px;
        background: #EDF5F0;
        box-shadow:
            5px 5px 12px rgba(107, 134, 124, 0.16),
            -5px -5px 12px rgba(255, 255, 255, 0.94);
    }

    .clay-icon {
        background: #EDF5F0;
        box-shadow:
            4px 4px 9px rgba(107, 134, 124, 0.18),
            -4px -4px 9px rgba(255, 255, 255, 0.94);
    }

    .clay-badge {
        background: #EDF5F0;
        box-shadow:
            3px 3px 7px rgba(107, 134, 124, 0.14),
            -3px -3px 7px rgba(255, 255, 255, 0.94);
    }

    .clay-alert-blue {
        background: #EEF6F4;
        border: 1px solid rgba(22, 139, 112, 0.16);
        box-shadow:
            4px 4px 10px rgba(107, 134, 124, 0.14),
            -4px -4px 10px rgba(255, 255, 255, 0.94);
    }

    .clay-error {
        background: #FEF2F2;
        border: 1px solid rgba(220, 38, 38, 0.16);
        box-shadow:
            4px 4px 10px rgba(107, 134, 124, 0.12),
            -4px -4px 10px rgba(255, 255, 255, 0.94);
    }

    .clay-select {
        appearance: auto;
    }
</style>

</head>

<body class="min-h-screen clay-page text-[#164238]">

<div class="min-h-screen">

{{-- =========================================================
     ADMIN SIDEBAR
========================================================== --}}
@include('dashboard.sidebar')


{{-- =========================================================
     MAIN CONTENT
========================================================== --}}
<main class="min-h-screen w-full min-w-0 lg:pl-72">

    {{-- Top Header --}}
    <header
        class="sticky top-0 z-30 border-b border-[#D8E6DF] bg-[#F5FAF7]/95 backdrop-blur"
        style="box-shadow: 0 4px 12px rgba(107, 134, 124, 0.10);"
    >

        <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

            {{-- Left Side --}}
            <div class="flex items-center gap-4">

                {{-- Mobile Menu Button --}}
                <button
                    type="button"
                    id="mobileMenuButton"
                    class="clay-outline-button inline-flex h-10 w-10 items-center justify-center rounded-xl border border-[#D8E6DF] text-[#6D817A] transition hover:text-[#164238] lg:hidden"
                    aria-label="Open navigation menu"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>

                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-[#168B70]">
                        System Administrator
                    </p>

                    <h1 class="mt-1 text-xl font-bold tracking-tight text-[#164238] sm:text-2xl">
                        Add Staff Account
                    </h1>
                </div>

            </div>

            {{-- Right Side --}}
            <div class="flex items-center gap-3">

                @include('partials.notification-bell')

                {{-- Profile --}}
                <div class="flex items-center gap-3">

                    <div class="hidden text-right sm:block">
                        <p class="text-sm font-semibold text-[#164238]">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-xs text-[#6D817A]">
                            System Administrator
                        </p>
                    </div>

                    <div
                        class="clay-icon flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold text-[#0F6F5A]"
                    >
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                </div>

            </div>

        </div>

    </header>


    {{-- =====================================================
         PAGE CONTENT
    ====================================================== --}}
    <div class="min-w-0 px-4 py-8 sm:px-6 lg:px-8">

        <div class="mx-auto w-full max-w-5xl">

            {{-- =================================================
                 PAGE INTRODUCTION
            ================================================== --}}
            <div class="mb-7">

                <div
                    class="clay-badge mb-4 inline-flex items-center gap-2 rounded-full px-3.5 py-1.5 text-xs font-semibold text-[#0F6F5A]"
                >

                    <span class="h-2 w-2 rounded-full bg-[#168B70]"></span>

                    Staff Accounts

                </div>


                <h2 class="text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                    Add Staff Account
                </h2>


                <p class="mt-2 max-w-2xl text-sm leading-6 text-[#6D817A]">
                    Create a new account for a Health Worker or Barangay Official
                    of the Barangay Esperanza Health Center.
                </p>

            </div>


            {{-- =================================================
                 VALIDATION ERRORS
            ================================================== --}}
            @if ($errors->any())

                <div class="clay-error mb-6 rounded-2xl px-5 py-4">

                    <div class="flex gap-3">

                        <div class="mt-0.5 shrink-0 text-[#DC2626]">

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
                                    d="M12 8v4m0 4h.01M10.29 3.86l-8.1 14A2 2 0 003.92 21h16.16a2 2 0 001.73-3.14l-8.1-14a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p class="text-sm font-semibold text-[#991B1B]">
                                Please correct the following errors:
                            </p>

                            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-[#B91C1C]">

                                @foreach ($errors->all() as $error)

                                    <li>
                                        {{ $error }}
                                    </li>

                                @endforeach

                            </ul>

                        </div>

                    </div>

                </div>

            @endif


            {{-- =================================================
                 FORM CARD
            ================================================== --}}
            <div class="clay-card overflow-hidden">

                {{-- CARD HEADER --}}
                <div class="border-b border-[#D8E6DF] bg-[#EDF5F0]/70 px-5 py-6 sm:px-7">

                    <div class="flex items-start gap-4">

                        <div
                            class="clay-icon flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl text-[#0F6F5A]"
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
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m8-8a4 4 0 100-8 4 4 0 000 8zm7-4v6m3-3h-6"
                                />
                            </svg>

                        </div>


                        <div class="min-w-0">

                            <h3 class="text-base font-semibold text-[#164238]">
                                Staff Account Information
                            </h3>

                            <p class="mt-1 text-sm text-[#6D817A]">
                                Enter the staff member's account details below.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('users.store') }}"
                    class="p-5 sm:p-7"
                >

                    @csrf


                    {{-- FORM GRID --}}
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- =================================================
                             FULL NAME
                        ================================================== --}}
                        <div class="md:col-span-2">

                            <label
                                class="mb-2 block text-sm font-semibold text-[#164238]"
                            >
                                Full Name
                                <span class="text-[#DC2626]">*</span>
                            </label>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <label for="first_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#6D817A]">
                                        First Name
                                    </label>
                                    <input
                                        id="first_name"
                                        type="text"
                                        name="first_name"
                                        data-person-name-strict
                                        value="{{ old('first_name') }}"
                                        placeholder="First name"
                                        required
                                        autofocus
                                        autocomplete="given-name"
                                        style="text-transform: capitalize;"
                                        class="clay-input w-full rounded-xl px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-[#9AA9A4] @error('first_name') border-[#DC2626] @enderror"
                                    >
                                    @error('first_name')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="middle_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#6D817A]">
                                        Middle Name
                                    </label>
                                    <input
                                        id="middle_name"
                                        type="text"
                                        name="middle_name"
                                        data-person-name-strict
                                        value="{{ old('middle_name') }}"
                                        placeholder="Middle name"
                                        autocomplete="additional-name"
                                        style="text-transform: capitalize;"
                                        class="clay-input w-full rounded-xl px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-[#9AA9A4] @error('middle_name') border-[#DC2626] @enderror"
                                    >
                                    @error('middle_name')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#6D817A]">
                                        Last Name
                                    </label>
                                    <input
                                        id="last_name"
                                        type="text"
                                        name="last_name"
                                        data-person-name-strict
                                        value="{{ old('last_name') }}"
                                        placeholder="Last name"
                                        required
                                        autocomplete="family-name"
                                        style="text-transform: capitalize;"
                                        class="clay-input w-full rounded-xl px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-[#9AA9A4] @error('last_name') border-[#DC2626] @enderror"
                                    >
                                    @error('last_name')
                                        <p class="mt-1.5 text-xs text-[#DC2626]">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                        </div>


                        {{-- =================================================
                             EMAIL
                        ================================================== --}}
                        <div>

                            <label
                                for="email"
                                class="mb-2 block text-sm font-semibold text-[#164238]"
                            >
                                Email Address
                                <span class="text-[#DC2626]">*</span>
                            </label>


                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="staff@example.com"
                                required
                                autocomplete="email"
                                class="clay-input w-full rounded-xl px-4 py-3 text-sm text-[#164238] outline-none transition placeholder:text-[#9AA9A4] @error('email') border-[#DC2626] @enderror"
                            >


                            @error('email')

                                <p class="mt-1.5 text-xs text-[#DC2626]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- =================================================
                             ROLE
                        ================================================== --}}
                        <div>

                            <label
                                for="role"
                                class="mb-2 block text-sm font-semibold text-[#164238]"
                            >
                                Staff Role
                                <span class="text-[#DC2626]">*</span>
                            </label>


                            <select
                                id="role"
                                name="role"
                                required
                                class="clay-input clay-select w-full rounded-xl px-4 py-3 text-sm text-[#164238] outline-none transition focus:border-[#168B70] @error('role') border-[#DC2626] @enderror"
                            >

                                <option value="">
                                    Select staff role
                                </option>


                                <option
                                    value="Health Worker"
                                    @selected(old('role') === 'Health Worker')
                                >
                                    Health Worker
                                </option>


                                <option
                                    value="Official"
                                    @selected(old('role') === 'Official')
                                >
                                    Barangay Official
                                </option>

                            </select>


                            @error('role')

                                <p class="mt-1.5 text-xs text-[#DC2626]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- =================================================
                             PASSWORD
                        ================================================== --}}
                        <div>

                            <label
                                for="password"
                                class="mb-2 block text-sm font-semibold text-[#164238]"
                            >
                                Password
                                <span class="text-[#DC2626]">*</span>
                            </label>


                            <div class="relative">
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    placeholder="Enter password"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    class="clay-input w-full rounded-xl px-4 py-3 pr-11 text-sm text-[#164238] outline-none transition placeholder:text-[#9AA9A4] @error('password') border-[#DC2626] @enderror"
                                >
                                <button
                                    type="button"
                                    class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-[#6D817A] transition hover:text-[#164238]"
                                    data-toggle-password="password"
                                    aria-label="Show password"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>


                            <p class="mt-1.5 text-xs text-[#6D817A]">
                                Minimum of 8 characters.
                            </p>


                            @error('password')

                                <p class="mt-1.5 text-xs text-[#DC2626]">
                                    {{ $message }}
                                </p>

                            @enderror

                        </div>


                        {{-- =================================================
                             CONFIRM PASSWORD
                        ================================================== --}}
                        <div>

                            <label
                                for="password_confirmation"
                                class="mb-2 block text-sm font-semibold text-[#164238]"
                            >
                                Confirm Password
                                <span class="text-[#DC2626]">*</span>
                            </label>


                            <div class="relative">
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Re-enter password"
                                    required
                                    minlength="8"
                                    autocomplete="new-password"
                                    class="clay-input w-full rounded-xl px-4 py-3 pr-11 text-sm text-[#164238] outline-none transition placeholder:text-[#9AA9A4]"
                                >
                                <button
                                    type="button"
                                    class="absolute inset-y-0 right-0 flex w-11 items-center justify-center text-[#6D817A] transition hover:text-[#164238]"
                                    data-toggle-password="password_confirmation"
                                    aria-label="Show confirmation password"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12 18 18.75 12 18.75 2.25 12 2.25 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         ROLE INFORMATION
                    ================================================== --}}
                    <div class="clay-alert-blue mt-7 rounded-2xl p-5">

                        <div class="flex gap-3">

                            <div class="mt-0.5 shrink-0 text-[#168B70]">

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
                                        d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"
                                    />
                                </svg>

                            </div>


                            <div class="min-w-0">

                                <p class="text-sm font-semibold text-[#164238]">
                                    Staff role access
                                </p>

                                <p class="mt-1 text-sm leading-6 text-[#315E52]">
                                    Health Workers and Barangay Officials receive
                                    access according to their assigned role.
                                    System Administrator accounts cannot be
                                    created from this page.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         ACTION BUTTONS
                    ================================================== --}}
                    <div class="mt-7 flex flex-col-reverse gap-4 border-t border-[#D8E6DF] pt-7 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('users.index') }}"
                            class="clay-outline-button inline-flex items-center justify-center gap-2 rounded-xl border border-[#D8E6DF] px-5 py-2.5 text-sm font-semibold text-[#164238] transition focus:outline-none focus:ring-2 focus:ring-[#168B70]/20"
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
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"
                                />
                            </svg>

                            Cancel

                        </a>


                        <button
                            type="submit"
                            class="clay-button inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold text-white transition focus:outline-none focus:ring-2 focus:ring-[#168B70]/25 focus:ring-offset-2"
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
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>

                            Create Staff Account

                        </button>

                    </div>

                </form>

            </div>


        </div>

    </div>

</main>


</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
            button.addEventListener('click', function () {
                const input = document.getElementById(button.dataset.togglePassword);
                if (!input) {
                    return;
                }

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                button.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');
            });
        });
    });
</script>

</body>

</html>
