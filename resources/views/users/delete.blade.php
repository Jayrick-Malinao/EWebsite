<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">


<meta
    name="viewport"
    content="width=device-width, initial-scale=1.0"
>

<title>Delete Staff Account | Barangay Esperanza Health Center</title>

<meta
    name="description"
    content="Confirm permanent deletion of a Barangay Esperanza Health Center staff account."
>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    html,
    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    body {
        background: #EEF5F1;
        color: #164238;
    }

    .clay-surface {
        background: #F5FAF7;
        box-shadow:
            9px 9px 20px rgba(107, 134, 124, 0.20),
            -9px -9px 20px rgba(255, 255, 255, 0.94);
    }

    .clay-soft {
        background: #EDF5F0;
        box-shadow:
            6px 6px 14px rgba(107, 134, 124, 0.18),
            -6px -6px 14px rgba(255, 255, 255, 0.94);
    }

    .clay-inset {
        background: #F5FAF7;
        box-shadow:
            inset 3px 3px 7px rgba(107, 134, 124, 0.14),
            inset -3px -3px 7px rgba(255, 255, 255, 0.94);
    }

    .clay-icon {
        background: #EDF5F0;
        box-shadow:
            4px 4px 9px rgba(107, 134, 124, 0.16),
            -4px -4px 9px rgba(255, 255, 255, 0.94);
    }

    .clay-button {
        background: #168B70;
        box-shadow:
            5px 5px 11px rgba(107, 134, 124, 0.22),
            -4px -4px 10px rgba(255, 255, 255, 0.94);
    }

    .clay-button:hover {
        background: #0F6F5A;
    }

    .clay-button:active {
        box-shadow:
            inset 3px 3px 7px rgba(7, 79, 62, 0.20),
            inset -3px -3px 7px rgba(255, 255, 255, 0.20);
    }

    .clay-danger {
        background: #DC2626;
        box-shadow:
            5px 5px 11px rgba(107, 134, 124, 0.20),
            -4px -4px 10px rgba(255, 255, 255, 0.94);
    }

    .clay-danger:hover {
        background: #B91C1C;
    }

    .clay-danger:active {
        box-shadow:
            inset 3px 3px 7px rgba(127, 29, 29, 0.20),
            inset -3px -3px 7px rgba(255, 255, 255, 0.20);
    }

    .clay-outline {
        background: #F5FAF7;
        border: 1px solid rgba(107, 134, 124, 0.14);
        box-shadow:
            4px 4px 10px rgba(107, 134, 124, 0.16),
            -4px -4px 10px rgba(255, 255, 255, 0.94);
    }

    .clay-outline:hover {
        background: #EDF5F0;
    }

    .clay-danger-soft {
        background: #FEF3F3;
        border: 1px solid rgba(220, 38, 38, 0.15);
        box-shadow:
            6px 6px 14px rgba(107, 134, 124, 0.14),
            -6px -6px 14px rgba(255, 255, 255, 0.94);
    }

    .clay-warning {
        background: #FAF6EE;
        border: 1px solid rgba(183, 121, 31, 0.16);
        box-shadow:
            5px 5px 12px rgba(107, 134, 124, 0.14),
            -5px -5px 12px rgba(255, 255, 255, 0.94);
    }

    .clay-header {
        background: rgba(245, 250, 247, 0.96);
        box-shadow:
            0 5px 14px rgba(107, 134, 124, 0.10);
    }

    .clay-avatar {
        background: #168B70;
        box-shadow:
            5px 5px 11px rgba(107, 134, 124, 0.20),
            -4px -4px 10px rgba(255, 255, 255, 0.94);
    }

    .clay-meta {
        background: #EDF5F0;
        box-shadow:
            inset 2px 2px 5px rgba(107, 134, 124, 0.10),
            inset -2px -2px 5px rgba(255, 255, 255, 0.94);
    }
</style>

</head>

<body class="min-h-screen">

{{-- =========================================================
    ADMIN SIDEBAR
========================================================== --}}
@include('dashboard.sidebar')


{{-- =========================================================
    MAIN CONTENT
========================================================== --}}
<main class="min-h-screen lg:pl-72">

    {{-- =====================================================
        HEADER
    ====================================================== --}}
    <header class="clay-header sticky top-0 z-30 border-b border-[#D8E6DF]">

        <div class="flex h-16 items-center justify-between px-4 sm:px-6 lg:h-20 lg:px-8">

            {{-- Mobile Menu --}}
            <button
                type="button"
                data-sidebar-toggle
                class="clay-outline inline-flex h-10 w-10 items-center justify-center rounded-xl text-[#6D817A] transition hover:text-[#164238] lg:hidden"
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


            {{-- Desktop Heading --}}
            <div class="hidden lg:block">

                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-[#168B70]">
                    System Administrator
                </p>

                <h1 class="mt-1 text-xl font-bold text-[#164238]">
                    Delete Staff Account
                </h1>

            </div>


            {{-- Mobile Brand --}}
            <div class="text-center lg:hidden">

                <p class="text-sm font-bold text-[#0F6F5A]">
                    Barangay Esperanza
                </p>

                <p class="text-[10px] font-medium uppercase tracking-wide text-[#6D817A]">
                    Health Center
                </p>

            </div>


            {{-- Header Right --}}
            <div class="ml-auto flex items-center gap-3 lg:ml-0 lg:gap-4">

                {{-- Notification Bell --}}
                @include('partials.notification-bell')


                {{-- Profile --}}
                <div class="hidden items-center gap-3 border-l border-[#D8E6DF] pl-4 sm:flex">

                    <div class="clay-avatar flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold text-white">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>

                    <div class="min-w-0">

                        <p class="max-w-40 truncate text-sm font-semibold text-[#164238]">
                            {{ auth()->user()->name ?? 'System Administrator' }}
                        </p>

                        <p class="text-xs text-[#6D817A]">
                            {{ auth()->user()->role ?? 'System Administrator' }}
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </header>


    {{-- =====================================================
        PAGE CONTENT
    ====================================================== --}}
    <div class="px-4 py-7 sm:px-6 lg:px-8 lg:py-9">

        <div class="mx-auto max-w-5xl">


            {{-- =================================================
                BACK TO USERS
            ================================================== --}}
            <div class="mb-6">

                <a
                    href="{{ route('users.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-[#6D817A] transition hover:text-[#0F6F5A]"
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
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"
                        />
                    </svg>

                    Back to Users
                </a>

            </div>


            {{-- =================================================
                PAGE HEADING
            ================================================== --}}
            <div class="mb-7">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div>

                        {{-- Page Label --}}
                        <div
                            class="clay-danger-soft mb-3 inline-flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-bold uppercase tracking-wide text-[#B91C1C]"
                        >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-3.5 w-3.5"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M10.29 3.86l-8.82 14a2 2 0 001.71 3.04h17.64a2 2 0 001.71-3.04l-8.82-14a2 2 0 00-3.42 0z"
                                />
                            </svg>

                            Account Deletion

                        </div>


                        {{-- Heading --}}
                        <h2 class="text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                            Delete Staff Account
                        </h2>


                        {{-- Description --}}
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-[#6D817A]">
                            Review the account carefully before proceeding.
                            This action permanently removes the staff account
                            from the system.
                        </p>

                    </div>

                </div>

            </div>


            {{-- =================================================
                MAIN GRID
            ================================================== --}}
            <div class="grid gap-7 lg:grid-cols-3">


                {{-- =================================================
                    ACCOUNT INFORMATION
                ================================================== --}}
                <section class="clay-surface overflow-hidden rounded-[24px] lg:col-span-2">

                    {{-- Card Header --}}
                    <div class="border-b border-[#D8E6DF] bg-[#EDF5F0]/70 px-5 py-6 sm:px-7">

                        <div class="flex items-center justify-between gap-4">

                            <div>

                                <h3 class="text-base font-bold text-[#164238]">
                                    Account Information
                                </h3>

                                <p class="mt-1 text-sm text-[#6D817A]">
                                    Verify the staff account you want to delete.
                                </p>

                            </div>


                            {{-- Permanent Action Badge --}}
                            <span class="clay-danger-soft hidden rounded-full px-3 py-1 text-xs font-bold text-[#B91C1C] sm:inline-flex">
                                Permanent Action
                            </span>

                        </div>

                    </div>


                    {{-- Account Profile --}}
                    <div class="px-5 py-7 sm:px-7">

                        <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                            {{-- Avatar --}}
                            <div class="clay-avatar flex h-20 w-20 shrink-0 items-center justify-center rounded-[22px] text-2xl font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>


                            {{-- Details --}}
                            <div class="min-w-0 flex-1">

                                <h4 class="text-xl font-bold text-[#164238]">
                                    {{ $user->name }}
                                </h4>

                                <p class="mt-1 break-all text-sm text-[#6D817A]">
                                    {{ $user->email }}
                                </p>


                                {{-- Role + Status --}}
                                <div class="mt-3 flex flex-wrap items-center gap-2">

                                    {{-- Role --}}
                                    <span class="clay-soft inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold text-[#0F6F5A]">
                                        {{ $user->role }}
                                    </span>


                                    {{-- Status --}}
                                    @if ($user->status === 'active')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#E8F5EF] px-3 py-1 text-xs font-semibold text-[#168B70]">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#168B70]"></span>

                                            Active

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-[#EDF5F0] px-3 py-1 text-xs font-semibold text-[#6D817A]">

                                            <span class="h-1.5 w-1.5 rounded-full bg-[#9AA9A4]"></span>

                                            Inactive

                                        </span>

                                    @endif

                                </div>

                            </div>

                        </div>


                        {{-- Metadata --}}
                        <div class="mt-7 grid gap-4 border-t border-[#D8E6DF] pt-6 sm:grid-cols-3">


                            {{-- Account ID --}}
                            <div class="clay-meta rounded-2xl p-4">

                                <p class="text-[11px] font-bold uppercase tracking-wide text-[#9AA9A4]">
                                    Account ID
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#164238]">
                                    #{{ $user->id }}
                                </p>

                            </div>


                            {{-- Created --}}
                            <div class="clay-meta rounded-2xl p-4">

                                <p class="text-[11px] font-bold uppercase tracking-wide text-[#9AA9A4]">
                                    Created
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#164238]">
                                    {{ $user->created_at?->format('M d, Y') ?? '—' }}
                                </p>

                            </div>


                            {{-- Last Updated --}}
                            <div class="clay-meta rounded-2xl p-4">

                                <p class="text-[11px] font-bold uppercase tracking-wide text-[#9AA9A4]">
                                    Last Updated
                                </p>

                                <p class="mt-1 text-sm font-bold text-[#164238]">
                                    {{ $user->updated_at?->format('M d, Y') ?? '—' }}
                                </p>

                            </div>

                        </div>

                    </div>

                </section>


                {{-- =================================================
                    WARNING CARD
                ================================================== --}}
                <aside class="clay-danger-soft rounded-[24px] p-6">

                    <div class="clay-icon flex h-11 w-11 items-center justify-center rounded-xl text-[#DC2626]">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v2m0 4h.01M10.29 3.86l-8.82 14a2 2 0 001.71 3.04h17.64a2 2 0 001.71-3.04l-8.82-14a2 2 0 00-3.42 0z"
                            />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-base font-bold text-[#7F1D1D]">
                        Permanent Deletion
                    </h3>


                    <p class="mt-2 text-sm leading-6 text-[#B91C1C]">
                        Deleting this account will permanently remove it
                        from the system.
                    </p>


                    <ul class="mt-5 space-y-3 text-sm text-[#991B1B]">

                        <li class="flex items-start gap-2">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-4 w-4 shrink-0 text-[#DC2626]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            The account will no longer be able to sign in.

                        </li>


                        <li class="flex items-start gap-2">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-4 w-4 shrink-0 text-[#DC2626]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            The account record will be permanently removed.

                        </li>


                        <li class="flex items-start gap-2">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-4 w-4 shrink-0 text-[#DC2626]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"
                                />
                            </svg>

                            This action cannot be undone.

                        </li>

                    </ul>

                </aside>

            </div>


            {{-- =================================================
                CONFIRMATION SECTION
            ================================================== --}}
            <section class="clay-surface mt-7 overflow-hidden rounded-[24px] border border-[#E8CACA]">


                {{-- Confirmation Header --}}
                <div class="border-b border-[#E8D5D5] bg-[#FEF3F3] px-5 py-6 sm:px-7">

                    <div class="flex items-start gap-3">

                        {{-- Warning Icon --}}
                        <div class="clay-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-[#DC2626]">

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
                                    d="M12 9v2m0 4h.01M10.29 3.86l-8.82 14a2 2 0 001.71 3.04h17.64a2 2 0 001.71-3.04l-8.82-14a2 2 0 00-3.42 0z"
                                />
                            </svg>

                        </div>


                        <div>

                            <h3 class="text-base font-bold text-[#7F1D1D]">
                                Confirm Permanent Deletion
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-[#B91C1C]">
                                You are about to permanently delete this
                                staff account. This action cannot be undone.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Confirmation Body --}}
                <div class="px-5 py-7 sm:px-7">


                    {{-- Account Being Deleted --}}
                    <div class="clay-inset rounded-2xl p-4">

                        <div class="flex items-center gap-3">

                            {{-- Avatar --}}
                            <div class="clay-avatar flex h-11 w-11 shrink-0 items-center justify-center rounded-xl text-sm font-bold text-white">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>


                            {{-- Account Details --}}
                            <div class="min-w-0">

                                <p class="truncate text-sm font-bold text-[#164238]">
                                    {{ $user->name }}
                                </p>

                                <p class="truncate text-xs text-[#6D817A]">
                                    {{ $user->email }}
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- Warning Message --}}
                    <div class="clay-warning mt-5 rounded-2xl p-5">

                        <div class="flex items-start gap-3">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="mt-0.5 h-5 w-5 shrink-0 text-[#B7791F]"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v2m0 4h.01M10.29 3.86l-8.82 14a2 2 0 001.71 3.04h17.64a2 2 0 001.71-3.04l-8.82-14a2 2 0 00-3.42 0z"
                                />
                            </svg>


                            <div>

                                <p class="text-sm font-bold text-[#76541C]">
                                    Please verify before continuing.
                                </p>

                                <p class="mt-1 text-sm leading-6 text-[#76541C]">
                                    Make sure you are deleting the correct
                                    account. Once
                                    <span class="font-bold">
                                        {{ $user->name }}
                                    </span>
                                    is deleted, the account cannot be restored.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    ACTIONS
                ================================================== --}}
                <div class="border-t border-[#E8D5D5] bg-[#EDF5F0] px-5 py-6 sm:px-7">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-end">


                        {{-- Cancel --}}
                        <a
                            href="{{ route('users.index') }}"
                            class="clay-outline inline-flex min-h-[52px] w-full items-center justify-center rounded-xl px-7 py-3 text-sm font-bold text-[#164238] transition focus:outline-none focus:ring-2 focus:ring-[#168B70]/20 focus:ring-offset-2 sm:w-auto"
                        >
                            Cancel
                        </a>


                        {{-- Permanently Delete --}}
                        <form
                            method="POST"
                            action="{{ route('users.destroy', $user) }}"
                            class="w-full sm:w-auto"
                            data-confirm-title="Delete this account?"
                            data-confirm-item="{{ $user->name }}"
                            data-confirm-message="This staff account and its access to the system will be permanently removed."
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="clay-danger inline-flex min-h-[52px] w-full items-center justify-center gap-2 rounded-xl border border-[#DC2626] px-7 py-3 text-sm font-bold text-white transition focus:outline-none focus:ring-2 focus:ring-[#DC2626]/30 focus:ring-offset-2 sm:w-auto"
                            >
                                {{-- Trash Icon --}}
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-4 w-4 shrink-0"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M6 7h12M9 7V5a1 1 0 011-1h4a1 1 0 011 1v2m2 0v12a1 1 0 01-1 1H8a1 1 0 01-1-1V7m3 4v6m4-6v6"
                                    />
                                </svg>

                                Delete Account
                            </button>
                        </form>


                    </div>

                </div>

            </section>


            {{-- =================================================
                SECURITY NOTICE
            ================================================== --}}
            <div class="clay-surface mt-7 rounded-[22px] p-5">

                <div class="flex items-start gap-3">

                    <div class="clay-icon flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-[#0F6F5A]">

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
                                d="M12 15v2m0-6V9m8 3a8 8 0 11-16 0 8 8 0 0116 0z"
                            />
                        </svg>

                    </div>


                    <div>

                        <h3 class="text-sm font-bold text-[#164238]">
                            Security Notice
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-[#6D817A]">
                            Only Health Worker and Official accounts can
                            be deleted from this page. System Administrator
                            accounts are protected from deletion.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>


{{-- =========================================================
    MOBILE SIDEBAR TOGGLE
========================================================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const toggleButton = document.querySelector('[data-sidebar-toggle]');

        if (!toggleButton) {
            return;
        }

        toggleButton.addEventListener('click', function () {

            const sidebar = document.querySelector('aside');

            if (!sidebar) {
                return;
            }

            sidebar.classList.toggle('-translate-x-full');

        });

    });
</script>


</body>

</html>
