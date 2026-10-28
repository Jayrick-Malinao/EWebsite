<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Immunization Details | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="View immunization details for a resident of Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
            --muted: #6D817A;
            --soft: #9AA9A4;

            --danger: #B42323;
            --danger-light: #FDECEC;
        }

        .immunization-show-page {
            min-height: 100vh;
            background: var(--bg);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        /* =========================================================
           HEADER
        ========================================================= */

        .immunization-show-page .clay-header {
            background: rgba(245, 250, 247, 0.96);
            border-color: rgba(15, 111, 90, 0.12);
            box-shadow:
                0 5px 14px rgba(22, 67, 56, 0.07),
                0 1px 3px rgba(22, 67, 56, 0.05);
        }

        .immunization-show-page .clay-menu-button {
            border: 1px solid rgba(22, 139, 112, 0.14);
            background: var(--surface);
            color: var(--primary-dark);
            box-shadow:
                4px 4px 10px rgba(30, 76, 65, 0.10),
                -3px -3px 8px rgba(255, 255, 255, 0.85);
        }

        .immunization-show-page .clay-menu-button:hover {
            background: var(--surface-soft);
            color: var(--primary);
        }

        .immunization-show-page .clay-role {
            color: var(--primary);
        }

        .immunization-show-page .clay-title {
            color: var(--text-dark);
        }

        .immunization-show-page .clay-profile-name {
            color: var(--text-dark);
        }

        .immunization-show-page .clay-profile-role {
            color: var(--muted);
        }

        .immunization-show-page .clay-avatar {
            background: linear-gradient(145deg, #DDF1E9, #CBE7DD);
            color: var(--primary-dark);
            box-shadow:
                4px 4px 9px rgba(30, 76, 65, 0.12),
                -3px -3px 8px rgba(255, 255, 255, 0.9);
        }

        /* =========================================================
           BREADCRUMB
        ========================================================= */

        .immunization-show-page .clay-breadcrumb {
            color: var(--muted);
        }

        .immunization-show-page .clay-breadcrumb a:hover {
            color: var(--primary-dark);
        }

        .immunization-show-page .clay-breadcrumb-current {
            color: var(--text-dark);
        }

        /* =========================================================
           PAGE HEADING
        ========================================================= */

        .immunization-show-page .clay-page-title {
            color: var(--text-dark);
        }

        .immunization-show-page .clay-page-label {
            color: var(--primary);
        }

        .immunization-show-page .clay-description {
            color: var(--muted);
        }

        .immunization-show-page .clay-heading-line {
            background: var(--primary);
            box-shadow:
                2px 2px 5px rgba(15, 111, 90, 0.18);
        }

        /* =========================================================
           PRIMARY BUTTON
        ========================================================= */

        .immunization-show-page .clay-primary-button {
            background: linear-gradient(
                145deg,
                var(--primary-light),
                var(--primary-dark)
            );
            color: white;
            border: 1px solid rgba(15, 111, 90, 0.20);
            box-shadow:
                5px 5px 12px rgba(22, 76, 64, 0.18),
                -4px -4px 10px rgba(255, 255, 255, 0.85);
        }

        .immunization-show-page .clay-primary-button:hover {
            background: linear-gradient(
                145deg,
                var(--primary),
                var(--primary-dark)
            );
            transform: translateY(-1px);
            box-shadow:
                6px 7px 14px rgba(22, 76, 64, 0.20),
                -4px -4px 10px rgba(255, 255, 255, 0.90);
        }

        .immunization-show-page .clay-primary-button:focus {
            outline: none;
            box-shadow:
                0 0 0 3px rgba(22, 139, 112, 0.18),
                5px 5px 12px rgba(22, 76, 64, 0.18);
        }

        /* =========================================================
           SECONDARY BUTTON
        ========================================================= */

        .immunization-show-page .clay-secondary-button {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            );
            color: #60766E;
            border: 1px solid rgba(255, 255, 255, .80);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .72);
        }

        .immunization-show-page .clay-secondary-button:hover {
            color: var(--text-dark);
            transform: translateY(-1px);
        }

        /* =========================================================
           CARDS
        ========================================================= */

        .immunization-show-page .clay-card {
            background: var(--surface);
            border: 1px solid rgba(22, 139, 112, 0.10);
            box-shadow:
                7px 7px 16px rgba(38, 77, 67, 0.10),
                -6px -6px 14px rgba(255, 255, 255, 0.90);
        }

        .immunization-show-page .clay-card-header {
            border-color: rgba(22, 139, 112, 0.09);
        }

        .immunization-show-page .clay-card-title {
            color: var(--text-dark);
        }

        .immunization-show-page .clay-card-description {
            color: var(--muted);
        }

        /* =========================================================
           RESIDENT
        ========================================================= */

        .immunization-show-page .clay-resident-avatar {
            background: linear-gradient(
                145deg,
                #E1F2EB,
                #CFE9DF
            );
            color: var(--primary-dark);
            box-shadow:
                4px 4px 9px rgba(38, 77, 67, 0.10),
                -3px -3px 8px rgba(255, 255, 255, 0.90);
        }

        .immunization-show-page .clay-resident-name {
            color: var(--text-dark);
        }

        .immunization-show-page .clay-resident-meta {
            color: var(--muted);
        }

        /* =========================================================
           VIEW RESIDENT
        ========================================================= */

        .immunization-show-page .clay-view-resident {
            background: linear-gradient(
                145deg,
                #E9F7F2,
                #DCEEE7
            );
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, .80);
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .72);
        }

        .immunization-show-page .clay-view-resident:hover {
            color: #0B5C49;
            transform: translateY(-1px);
        }

        /* =========================================================
           DATA VALUES
        ========================================================= */

        .immunization-show-page .clay-label {
            color: var(--soft);
        }

        .immunization-show-page .clay-value {
            color: var(--text-dark);
        }

        .immunization-show-page .clay-next-dose {
            color: var(--primary-dark);
        }

        .immunization-show-page .clay-no-data {
            color: var(--soft);
        }

        /* =========================================================
           DOSE BADGE
        ========================================================= */

        .immunization-show-page .clay-dose {
            background: #E2F2EC;
            color: var(--primary-dark);
            box-shadow:
                inset 2px 2px 4px rgba(38, 77, 67, 0.06),
                inset -2px -2px 4px rgba(255, 255, 255, 0.75);
        }

        /* =========================================================
           REMARKS
        ========================================================= */

        .immunization-show-page .clay-remarks {
            color: var(--muted);
        }

        .immunization-show-page .clay-empty-remarks {
            color: var(--soft);
        }

        /* =========================================================
           FOOTER
        ========================================================= */

        .immunization-show-page .clay-footer {
            border-color: rgba(22, 139, 112, 0.10);
            color: var(--muted);
        }

        @media (max-width: 640px) {
            .immunization-show-page .clay-primary-button,
            .immunization-show-page .clay-secondary-button {
                width: 100%;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-[#EEF5F1] text-[#164238]">

    <div class="immunization-show-page min-h-screen">

        {{-- Mobile Overlay --}}
        <div
            id="sidebar-overlay"
            class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden">
        </div>

        {{-- Sidebar --}}
        @include('dashboard.sidebar')

        {{-- Main Content --}}
        <main class="lg:pl-72">

            {{-- Top Header --}}
            <header class="clay-header sticky top-0 z-30 border-b backdrop-blur">

                <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                    {{-- Left Side --}}
                    <div class="flex items-center gap-4">

                        {{-- Mobile Menu --}}
                        <button
                            type="button"
                            id="mobileMenuButton"
                            class="clay-menu-button inline-flex h-10 w-10 items-center justify-center rounded-xl transition lg:hidden"
                            aria-label="Open navigation"
                        >
                            <svg
                                class="h-5 w-5"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                            </svg>
                        </button>

                        <div>

                            <p class="clay-role text-xs font-semibold uppercase tracking-wider">
                                System Administrator
                            </p>

                            <h1 class="clay-title mt-1 text-xl font-bold tracking-tight sm:text-2xl">
                                Immunization
                            </h1>

                        </div>

                    </div>

                    {{-- Right Side --}}
                    <div class="flex items-center gap-3">

                        @include('partials.notification-bell')

                        {{-- Profile --}}
                        <div class="flex items-center gap-3">

                            <div class="clay-profile-name hidden text-right sm:block">

                                <p class="text-sm font-semibold">
                                    {{ auth()->user()->name }}
                                </p>

                                <p class="clay-profile-role text-xs">
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

            {{-- Page Content --}}
            <div class="px-4 py-6 sm:px-6 lg:px-8">

                
                {{-- Page Heading --}}
                <div class="mb-7 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                    <div class="flex items-start gap-4">

                        {{-- Left Accent Line --}}
                        <div class="clay-heading-line mt-1 h-16 w-1.5 shrink-0 rounded-full"></div>

                        <div>


                            <h2 class="clay-page-title text-2xl font-bold tracking-tight sm:text-3xl">
                                {{ $immunization->vaccine_name }}
                            </h2>

                            <p class="clay-description mt-1 max-w-2xl text-sm">
                                Detailed immunization information for
                                <span class="font-semibold text-[#234E43]">
                                    {{ $immunization->resident->full_name }}
                                </span>.
                            </p>

                        </div>

                    </div>

                    {{-- Actions --}}
                    <div class="flex flex-col gap-2 sm:flex-row">

                        <a
                            href="{{ route('immunizations.index') }}"
                            class="clay-secondary-button inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition"
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
                                    stroke-width="1.8"
                                    d="M19 12H5m6 6-6-6 6-6"
                                />
                            </svg>

                            Back
                        </a>

                        <a
                            href="{{ route('immunizations.edit', $immunization) }}"
                            class="clay-primary-button inline-flex items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition"
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
                                    stroke-width="1.8"
                                    d="M12 20h9"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4L16.5 3.5z"
                                />
                            </svg>

                            Edit Record
                        </a>

                    </div>

                </div>

                {{-- Resident Card --}}
                <div class="clay-card mb-5 overflow-hidden rounded-2xl">

                    <div class="clay-card-header border-b px-5 py-4">

                        <h3 class="clay-card-title font-semibold">
                            Resident Information
                        </h3>

                        <p class="clay-card-description mt-0.5 text-xs">
                            Resident associated with this immunization record.
                        </p>

                    </div>

                    <div class="flex flex-col gap-4 p-5 sm:flex-row sm:items-center">

                        {{-- Initials --}}
                        <div class="clay-resident-avatar flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-lg font-bold">

                            {{ strtoupper(substr($immunization->resident->first_name, 0, 1)) }}{{ strtoupper(substr($immunization->resident->last_name, 0, 1)) }}

                        </div>

                        {{-- Resident Details --}}
                        <div class="min-w-0 flex-1">

                            <h4 class="clay-resident-name text-lg font-bold">
                                {{ $immunization->resident->full_name }}
                            </h4>

                            <div class="clay-resident-meta mt-1 flex flex-wrap gap-x-4 gap-y-1 text-sm">

                                @if ($immunization->resident->gender)

                                    <span>
                                        {{ $immunization->resident->gender }}
                                    </span>

                                @endif

                                @if ($immunization->resident->birth_date)

                                    <span>
                                        Born {{ $immunization->resident->birth_date->format('M d, Y') }}
                                    </span>

                                @endif

                                @if ($immunization->resident->contact_number)

                                    <span>
                                        {{ \App\Support\PhilippineMobileNumberFormatter::formatForDisplay($immunization->resident->contact_number) }}
                                    </span>

                                @endif

                            </div>

                        </div>

                        {{-- View Resident --}}
                        <a
                            href="{{ route('residents.show', $immunization->resident) }}"
                            class="clay-view-resident inline-flex shrink-0 items-center justify-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition"
                        >
                            View Resident

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="1.8"
                                    d="M9 5l7 7-7 7"
                                />
                            </svg>

                        </a>

                    </div>

                </div>

                {{-- Vaccine Overview --}}
                <div class="clay-card mb-5 overflow-hidden rounded-2xl">

                    <div class="clay-card-header border-b px-5 py-4">

                        <h3 class="clay-card-title font-semibold">
                            Vaccine Information
                        </h3>

                        <p class="clay-card-description mt-0.5 text-xs">
                            Details of the vaccine administered to the resident.
                        </p>

                    </div>

                    <div class="grid gap-5 p-5 sm:grid-cols-2 lg:grid-cols-4">

                        {{-- Vaccine --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Vaccine
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->vaccine_name }}
                            </p>

                        </div>

                        {{-- Vaccine Type --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Vaccine Type
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->vaccine_type ?: '—' }}
                            </p>

                        </div>

                        {{-- Dose --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Dose
                            </p>

                            @if ($immunization->dose_number)

                                <span class="clay-dose mt-1 inline-flex rounded-full px-2.5 py-1 text-xs font-semibold">
                                    {{ $immunization->dose_number }}
                                </span>

                            @else

                                <p class="clay-no-data mt-1 text-sm font-semibold">
                                    —
                                </p>

                            @endif

                        </div>

                        {{-- Date Administered --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Date Administered
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->date_administered?->format('M d, Y') ?? '—' }}
                            </p>

                        </div>

                        {{-- Next Dose --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Next Dose
                            </p>

                            @if ($immunization->next_dose_date)

                                <p class="clay-next-dose mt-1 text-sm font-semibold">
                                    {{ $immunization->next_dose_date->format('M d, Y') }}
                                </p>

                            @else

                                <p class="clay-no-data mt-1 text-sm font-semibold">
                                    No scheduled dose
                                </p>

                            @endif

                        </div>

                        {{-- Batch Number --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Batch / Lot Number
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->batch_number ?: '—' }}
                            </p>

                        </div>

                        {{-- Administered By --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Administered By
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->administered_by ?: '—' }}
                            </p>

                        </div>

                        {{-- Site --}}
                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Administration Site
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->site_of_administration ?: '—' }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Remarks --}}
                <div class="clay-card mb-5 overflow-hidden rounded-2xl">

                    <div class="clay-card-header border-b px-5 py-4">

                        <h3 class="clay-card-title font-semibold">
                            Remarks
                        </h3>

                    </div>

                    <div class="p-5">

                        @if ($immunization->remarks)

                            <p class="clay-remarks whitespace-pre-line text-sm leading-6">
                                {{ $immunization->remarks }}
                            </p>

                        @else

                            <p class="clay-empty-remarks text-sm italic">
                                No additional remarks were recorded for this immunization.
                            </p>

                        @endif

                    </div>

                </div>

                {{-- Record Metadata --}}
                <div class="clay-card overflow-hidden rounded-2xl">

                    <div class="clay-card-header border-b px-5 py-4">

                        <h3 class="clay-card-title font-semibold">
                            Record Information
                        </h3>

                    </div>

                    <div class="grid gap-5 p-5 sm:grid-cols-2">

                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Record Created
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->created_at?->format('M d, Y h:i A') ?? '—' }}
                            </p>

                        </div>

                        <div>

                            <p class="clay-label text-xs font-medium uppercase tracking-wide">
                                Last Updated
                            </p>

                            <p class="clay-value mt-1 text-sm font-semibold">
                                {{ $immunization->updated_at?->format('M d, Y h:i A') ?? '—' }}
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Footer Information --}}
                <footer class="clay-footer mt-5 flex flex-col gap-2 border-t py-5 text-xs sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        Barangay Esperanza Health Center
                    </p>

                    <p>
                        Immunization Records Management
                    </p>

                </footer>

            </div>

        </main>

    </div>

    {{-- Mobile Sidebar Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.querySelector('[data-sidebar]');
            const overlay = document.getElementById('sidebar-overlay');
            const menuButton = document.getElementById('mobileMenuButton');

            if (!sidebar || !overlay || !menuButton) {
                return;
            }

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }

            menuButton.addEventListener('click', openSidebar);

            overlay.addEventListener('click', closeSidebar);

            window.addEventListener('resize', function () {

                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }

            });

        });
    </script>

</body>

</html>