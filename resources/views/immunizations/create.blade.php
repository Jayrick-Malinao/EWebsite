<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Immunization | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Add an immunization record for Barangay Esperanza Health Center."
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

        .immunization-page {
            background: var(--bg);
            color: var(--text);
        }

        .immunization-page .clay-header {
            border-bottom: 1px solid rgba(255, 255, 255, .72);
            background: rgba(245, 250, 247, .95);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow:
                0 4px 12px rgba(107, 134, 124, .06),
                0 1px 0 rgba(255, 255, 255, .75);
        }

        .immunization-page .clay-category {
            color: #168B70;
        }

        .immunization-page .clay-title {
            color: #234E43;
        }

        .immunization-page .clay-mobile-button {
            color: #60766E;
            border: 1px solid rgba(255, 255, 255, .80);
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            );
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .10),
                -3px -3px 7px rgba(255, 255, 255, .82),
                inset 1px 1px 0 rgba(255, 255, 255, .72);
        }

        .immunization-page .clay-mobile-button:hover {
            color: #234E43;
            transform: translateY(-1px);
        }

        .immunization-page .clay-card {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            );
            border: 1px solid rgba(255, 255, 255, .82);
            box-shadow:
                8px 8px 18px rgba(107, 134, 124, .13),
                -8px -8px 18px rgba(255, 255, 255, .86),
                inset 1px 1px 0 rgba(255, 255, 255, .75);
        }

        .immunization-page .clay-section-header {
            border-bottom: 1px solid rgba(143, 165, 156, .18);
        }

        .immunization-page .clay-input,
        .immunization-page .clay-select,
        .immunization-page .clay-textarea {
            border: 1px solid rgba(255, 255, 255, .88) !important;
            background: #EDF5F0 !important;
            color: var(--text-dark) !important;
            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .10),
                inset -3px -3px 7px rgba(255, 255, 255, .80) !important;
        }

        .immunization-page .clay-input::placeholder,
        .immunization-page .clay-textarea::placeholder {
            color: var(--soft);
        }

        .immunization-page .clay-input:focus,
        .immunization-page .clay-select:focus,
        .immunization-page .clay-textarea:focus {
            border-color: rgba(22, 139, 112, .45) !important;
            background: #F5FAF7 !important;
            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, .08),
                inset -2px -2px 5px rgba(255, 255, 255, .85),
                0 0 0 3px rgba(22, 139, 112, .08) !important;
        }

        .immunization-page .clay-primary-button {
            border: 1px solid rgba(255, 255, 255, .22);
            background: linear-gradient(
                145deg,
                #2A9B80,
                #0F6F5A
            );
            color: white;
            box-shadow:
                5px 5px 10px rgba(15, 111, 90, .18),
                -4px -4px 9px rgba(255, 255, 255, .65),
                inset 1px 1px 0 rgba(255, 255, 255, .22);
        }

        .immunization-page .clay-primary-button:hover {
            background: linear-gradient(
                145deg,
                #32A98B,
                #0B654F
            );
            transform: translateY(-1px);
        }

        .immunization-page .clay-action {
            border: 1px solid rgba(255, 255, 255, .80) !important;
            box-shadow:
                3px 3px 7px rgba(107, 134, 124, .12),
                -3px -3px 7px rgba(255, 255, 255, .84),
                inset 1px 1px 0 rgba(255, 255, 255, .72) !important;
        }

        .immunization-page .clay-action-view {
            background: linear-gradient(
                145deg,
                #F8FCFA,
                #E9F1ED
            ) !important;
            color: #60766E !important;
        }

        .immunization-page .clay-action-view:hover {
            color: var(--text-dark) !important;
            transform: translateY(-1px);
        }

        .immunization-page .clay-heading-accent {
            background: var(--primary);
            box-shadow:
                2px 2px 5px rgba(15, 111, 90, .18),
                -2px -2px 5px rgba(255, 255, 255, .70);
        }

        .immunization-page .clay-error {
            border: 1px solid rgba(180, 35, 35, .16);
            background: linear-gradient(
                145deg,
                #FFF7F7,
                #FDECEC
            );
            box-shadow:
                5px 5px 10px rgba(107, 134, 124, .08),
                -5px -5px 10px rgba(255, 255, 255, .75),
                inset 1px 1px 0 rgba(255, 255, 255, .65);
        }
    </style>
</head>

<body class="min-h-screen">

    <div class="immunization-page min-h-screen">

        {{-- Mobile Overlay --}}
        <div
            id="sidebar-overlay"
            class="fixed inset-0 z-40 hidden bg-slate-950/50 backdrop-blur-sm lg:hidden"
        ></div>

        {{-- Sidebar --}}
        @include('dashboard.sidebar')

        {{-- Main Content --}}
        <main class="lg:pl-72">

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
                                Immunization
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

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl border border-white/80 bg-gradient-to-br from-[#E6F4EE] to-[#D7EAE1] text-sm font-bold text-[#0F6F5A] shadow-[4px_4px_9px_rgba(107,134,124,0.12),-4px_-4px_9px_rgba(255,255,255,0.88)]"
                            >
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>

                        </div>

                    </div>

                </div>

            </header>

            {{-- Page Content --}}
            <div class="px-4 py-6 sm:px-6 lg:px-8">

                {{-- Page Heading --}}
                <div class="mb-7 flex items-start gap-4">

                    <div class="clay-heading-accent mt-1 h-16 w-1.5 shrink-0 rounded-full"></div>

                    <div>

                        <h2 class="text-2xl font-bold tracking-tight text-[#234E43] sm:text-3xl">
                            Add Immunization Record
                        </h2>

                        <p class="mt-1 max-w-2xl text-sm text-[#6D817A]">
                            Record a vaccine administered to a resident of Barangay Esperanza Health Center.
                        </p>

                    </div>

                </div>

                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="clay-error mb-5 rounded-2xl p-4">

                        <div class="flex items-start gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-[#B42323]"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v4m0 4h.01M10.29 3.86l-7.82 13.5A2 2 0 0 0 4.2 20.5h15.6a2 2 0 0 0 1.73-3.14l-7.82-13.5a2 2 0 0 0-3.42 0Z"
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

                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route('immunizations.store') }}"
                    class="space-y-5"
                >

                    @csrf

                    {{-- Resident Information --}}
                    <div class="clay-card overflow-hidden rounded-2xl">

                        <div class="clay-section-header border-b border-[#DCE9E3] px-5 py-4">

                            <h3 class="font-semibold text-[#234E43]">
                                Resident Information
                            </h3>

                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                Select the resident associated with this immunization record.
                            </p>

                        </div>

                        <div class="p-5">

                            <label
                                for="resident_id"
                                class="block text-sm font-semibold text-[#234E43]"
                            >
                                Resident
                                <span class="text-red-500">*</span>
                            </label>

                            <select
                                id="resident_id"
                                name="resident_id"
                                required
                                class="clay-select mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                            >

                                <option value="">
                                    Select resident
                                </option>

                                @foreach ($residents as $resident)

                                    <option
                                        value="{{ $resident->id }}"
                                        @selected(old('resident_id') == $resident->id)
                                    >
                                        {{ $resident->full_name }}
                                        @if ($resident->birth_date)
                                            — {{ $resident->birth_date->format('M d, Y') }}
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                            @error('resident_id')
                                <p class="mt-1.5 text-xs font-medium text-red-600">
                                    {{ $message }}
                                </p>
                            @enderror

                        </div>

                    </div>

                    {{-- Vaccine Information --}}
                    <div class="clay-card overflow-hidden rounded-2xl">

                        <div class="clay-section-header border-b border-[#DCE9E3] px-5 py-4">

                            <h3 class="font-semibold text-[#234E43]">
                                Vaccine Information
                            </h3>

                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                Enter the details of the vaccine administered.
                            </p>

                        </div>

                        <div class="grid gap-5 p-5 md:grid-cols-2">

                            {{-- Vaccine Name --}}
                            <div>

                                <label
                                    for="vaccine_name"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Vaccine Name
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="text"
                                    id="vaccine_name"
                                    name="vaccine_name"
                                    value="{{ old('vaccine_name') }}"
                                    required
                                    maxlength="255"
                                    placeholder="e.g. BCG, Pentavalent, OPV"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('vaccine_name')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Vaccine Type --}}
                            <div>

                                <label
                                    for="vaccine_type"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Vaccine Type
                                </label>

                                <input
                                    type="text"
                                    id="vaccine_type"
                                    name="vaccine_type"
                                    value="{{ old('vaccine_type') }}"
                                    maxlength="255"
                                    placeholder="e.g. Routine Immunization"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('vaccine_type')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Dose Number --}}
                            <div>

                                <label
                                    for="dose_number"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Dose Number
                                </label>

                                <input
                                    type="text"
                                    id="dose_number"
                                    name="dose_number"
                                    value="{{ old('dose_number') }}"
                                    maxlength="100"
                                    placeholder="e.g. Dose 1, Dose 2, Booster"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('dose_number')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Date Administered --}}
                            <div>

                                <label
                                    for="date_administered"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Date Administered
                                    <span class="text-red-500">*</span>
                                </label>

                                <input
                                    type="date"
                                    id="date_administered"
                                    name="date_administered"
                                    value="{{ old('date_administered') }}"
                                    required
                                    max="{{ now()->format('Y-m-d') }}"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('date_administered')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Next Dose Date --}}
                            <div>

                                <label
                                    for="next_dose_date"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Next Dose Date
                                </label>

                                <input
                                    type="date"
                                    id="next_dose_date"
                                    name="next_dose_date"
                                    value="{{ old('next_dose_date') }}"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                <p class="mt-1.5 text-xs text-[#9AA9A4]">
                                    Leave blank if no succeeding dose is scheduled.
                                </p>

                                @error('next_dose_date')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Batch Number --}}
                            <div>

                                <label
                                    for="batch_number"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Batch / Lot Number
                                </label>

                                <input
                                    type="text"
                                    id="batch_number"
                                    name="batch_number"
                                    value="{{ old('batch_number') }}"
                                    maxlength="255"
                                    placeholder="e.g. BCG-2026-001"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('batch_number')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                    {{-- Administration Details --}}
                    <div class="clay-card overflow-hidden rounded-2xl">

                        <div class="clay-section-header border-b border-[#DCE9E3] px-5 py-4">

                            <h3 class="font-semibold text-[#234E43]">
                                Administration Details
                            </h3>

                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                Record who administered the vaccine and where it was given.
                            </p>

                        </div>

                        <div class="grid gap-5 p-5 md:grid-cols-2">

                            {{-- Administered By --}}
                            <div>

                                <label
                                    for="administered_by"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Administered By
                                </label>

                                <input
                                    type="text"
                                    id="administered_by"
                                    name="administered_by"
                                    value="{{ old('administered_by') }}"
                                    maxlength="255"
                                    placeholder="Name of health worker"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('administered_by')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Site of Administration --}}
                            <div>

                                <label
                                    for="site_of_administration"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Site of Administration
                                </label>

                                <input
                                    type="text"
                                    id="site_of_administration"
                                    name="site_of_administration"
                                    value="{{ old('site_of_administration') }}"
                                    maxlength="255"
                                    placeholder="e.g. Left upper arm"
                                    class="clay-input mt-2 w-full rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >

                                @error('site_of_administration')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                            {{-- Remarks --}}
                            <div class="md:col-span-2">

                                <label
                                    for="remarks"
                                    class="block text-sm font-semibold text-[#234E43]"
                                >
                                    Remarks
                                </label>

                                <textarea
                                    id="remarks"
                                    name="remarks"
                                    rows="4"
                                    maxlength="5000"
                                    placeholder="Add any additional notes about the immunization..."
                                    class="clay-textarea mt-2 w-full resize-y rounded-xl px-4 py-2.5 text-sm outline-none transition"
                                >{{ old('remarks') }}</textarea>

                                @error('remarks')
                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>

                        </div>

                    </div>

                    {{-- Form Actions --}}
                    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">

                        <a
                            href="{{ route('immunizations.index') }}"
                            class="clay-action clay-action-view inline-flex items-center justify-center rounded-xl px-5 py-2.5 text-sm font-semibold transition"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="clay-primary-button inline-flex items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-semibold transition"
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

                            Save Immunization
                        </button>

                    </div>

                </form>

                {{-- Footer Information --}}
                <div class="mt-5 flex flex-col gap-2 text-xs text-[#9AA9A4] sm:flex-row sm:items-center sm:justify-between">

                    <p>
                        Barangay Esperanza Health Center
                    </p>

                    <p>
                        Immunization Records Management
                    </p>

                </div>

            </div>

        </main>

    </div>

    {{-- Mobile Sidebar Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const sidebar = document.querySelector('aside');
            const overlay = document.getElementById('sidebar-overlay');
            const menuButton = document.getElementById('mobileMenuButton');

            if (sidebar && overlay && menuButton) {

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
                        overlay.classList.add('hidden');
                        document.body.classList.remove('overflow-hidden');
                    }

                });

            }

        });
    </script>

</body>
</html>