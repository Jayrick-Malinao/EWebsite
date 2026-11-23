<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Stock In | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Stock in a medicine, vaccine, or medical supply at Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">

    {{-- =========================================================
        SIDEBAR
    ========================================================== --}}
    @include('dashboard.sidebar')


    {{-- =========================================================
        MAIN APPLICATION AREA
    ========================================================== --}}
    <div class="min-h-screen lg:pl-72">

        {{-- Top Header --}}
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Left Side --}}
                <div class="flex items-center gap-4">

                    {{-- Mobile Menu Button --}}
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 lg:hidden"
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
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-600">
                            System Administrator
                        </p>

                        <h1 class="mt-1 text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                            Inventory Item
                        </h1>
                    </div>

                </div>

                {{-- Right Side --}}
                <div class="flex items-center gap-3">

                    @include('partials.notification-bell')
                           
                    {{-- Profile --}}
                    <div class="flex items-center gap-3">

                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-semibold text-slate-900">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-slate-500">
                                System Administrator
                            </p>
                        </div>

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-sm font-bold text-emerald-700">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                    </div>

                </div>

            </div>

        </header>


        {{-- =====================================================
            PAGE CONTENT
        ====================================================== --}}
        <main class="px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            <div class="mx-auto max-w-4xl">


                {{-- =================================================
                    PAGE TITLE
                ================================================== --}}
                <div class="mb-6">

                    <div class="flex items-center gap-3">

                        <div
                            class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50"
                        >
                            <svg
                                class="h-6 w-6 text-emerald-700"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7.8 7.8 6.4 6.4m11.2 11.2-1.4-1.4m0-8.4 1.4-1.4M6.4 17.6l1.4-1.4M12 8v8m-4-4h8"
                                />
                            </svg>
                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">
                                Medical Inventory
                            </p>

                            <h1 class="text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">
                                Stock In
                            </h1>

                            <p class="mt-0.5 text-sm text-slate-500">
                                Record incoming medicine, vaccine, or medical supply stock.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    VALIDATION SUMMARY
                ================================================== --}}
                @if ($errors->any())

                    <div
                        class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4"
                        role="alert"
                    >

                        <div class="flex gap-3">

                            <svg
                                class="mt-0.5 h-5 w-5 shrink-0 text-red-600"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v3.75m0 3h.007v.008H12v-.008ZM10.29 3.86 2.82 17.25a1.5 1.5 0 0 0 1.31 2.25h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.5 1.5 0 0 0-2.62 0Z"
                                />
                            </svg>


                            <div>

                                <p class="text-sm font-semibold text-red-800">
                                    Please correct the following:
                                </p>

                                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

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
                <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


                    {{-- Card Header --}}
                    <div class="border-b border-slate-200 px-6 py-6 sm:px-8">

                        <div class="flex items-start gap-4">

                            <div
                                class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-emerald-50"
                            >

                                <svg
                                    class="h-6 w-6 text-emerald-700"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7.8 7.8 6.4 6.4m11.2 11.2-1.4-1.4m0-8.4 1.4-1.4M6.4 17.6l1.4-1.4M12 8v8m-4-4h8"
                                    />
                                </svg>

                            </div>


                            <div>

                                <h2 class="text-lg font-semibold text-slate-900">
                                    Inventory Information
                                </h2>

                                <p class="mt-1 text-sm leading-6 text-slate-500">
                                    Enter the basic information for the medicine, vaccine,
                                    or medical supply you want to track.
                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                        FORM
                    ================================================== --}}
                    <form
                        method="POST"
                        action="{{ route('medical-inventories.store') }}"
                    >

                        @csrf


                        <div class="space-y-6 px-6 py-6 sm:px-8 sm:py-8">


                            {{-- Medicine Name --}}
                            <div>

                                <label
                                    for="medicine_name"
                                    class="block text-sm font-semibold text-slate-700"
                                >
                                    Medicine Name
                                    <span class="text-red-500">*</span>
                                </label>

                                <p class="mt-1 text-xs text-slate-500">
                                    Enter the name of the medicine, vaccine, or medical supply.
                                </p>


                                <input
                                    id="medicine_name"
                                    name="medicine_name"
                                    type="text"
                                    value="{{ old('medicine_name') }}"
                                    placeholder="e.g. Paracetamol 500mg"
                                    maxlength="255"
                                    required
                                    autofocus
                                    class="mt-3 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 @error('medicine_name') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                                >


                                @error('medicine_name')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Expiry Date --}}
                            <div>

                                <label
                                    for="expiry_date"
                                    class="block text-sm font-semibold text-slate-700"
                                >
                                    Expiry Date
                                    <span class="text-red-500">*</span>
                                </label>

                                <p class="mt-1 text-xs text-slate-500">
                                    This date will be used to calculate the automatic expiry alerts.
                                </p>


                                <input
                                    id="expiry_date"
                                    name="expiry_date"
                                    type="date"
                                    value="{{ old('expiry_date') }}"
                                    min="{{ now()->format('Y-m-d') }}"
                                    required
                                    class="mt-3 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 @error('expiry_date') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                                >


                                @error('expiry_date')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Quantity --}}
                            <div>

                                <label
                                    for="quantity"
                                    class="block text-sm font-semibold text-slate-700"
                                >
                                    Quantity
                                    <span class="text-red-500">*</span>
                                </label>

                                <p class="mt-1 text-xs text-slate-500">
                                    Enter the current number of units available.
                                </p>


                                <input
                                    id="quantity"
                                    name="quantity"
                                    type="number"
                                    value="{{ old('quantity') }}"
                                    min="0"
                                    step="1"
                                    inputmode="numeric"
                                    placeholder="e.g. 100"
                                    required
                                    class="mt-3 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100 @error('quantity') border-red-400 focus:border-red-500 focus:ring-red-100 @enderror"
                                >


                                @error('quantity')

                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>


                        {{-- =================================================
                            FORM FOOTER
                        ================================================== --}}
                        <div
                            class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-end sm:px-8"
                        >

                            {{-- Cancel --}}
                            <a
                                href="{{ route('medical-inventories.index') }}"
                                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2"
                            >
                                Cancel
                            </a>


                            {{-- Save --}}
                            <button
                                type="submit"
                                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2"
                            >

                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M12 4v16m8-8H4"
                                    />
                                </svg>

                                Confirm Stock In

                            </button>

                        </div>

                    </form>

                </div>


                {{-- =================================================
                    EXPIRY ALERT INFORMATION
                ================================================== --}}
                <div
                    class="mt-6 rounded-2xl border border-emerald-100 bg-emerald-50/60 p-5"
                >

                    <div class="flex gap-3">

                        <svg
                            class="mt-0.5 h-5 w-5 shrink-0 text-emerald-700"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="1.8"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 9v3.75m0 3h.007v.008H12v-.008ZM10.29 3.86 2.82 17.25a1.5 1.5 0 0 0 1.31 2.25h15.74a1.5 1.5 0 0 0 1.31-2.25L13.71 3.86a1.5 1.5 0 0 0-2.62 0Z"
                            />
                        </svg>


                        <div>

                            <h3 class="text-sm font-semibold text-emerald-900">
                                Automatic Expiry Monitoring
                            </h3>

                            <p class="mt-1 text-sm leading-6 text-emerald-800">
                                The system will use this item's expiry date to determine
                                when expiry notifications should be generated.
                            </p>


                            <div class="mt-3 flex flex-wrap gap-2">

                                <span
                                    class="rounded-full bg-white px-3 py-1 text-xs font-medium text-emerald-800 ring-1 ring-inset ring-emerald-200"
                                >
                                    1 month before
                                </span>

                                <span
                                    class="rounded-full bg-white px-3 py-1 text-xs font-medium text-emerald-800 ring-1 ring-inset ring-emerald-200"
                                >
                                    15 days before
                                </span>

                                <span
                                    class="rounded-full bg-white px-3 py-1 text-xs font-medium text-emerald-800 ring-1 ring-inset ring-emerald-200"
                                >
                                    7 days before
                                </span>

                                <span
                                    class="rounded-full bg-white px-3 py-1 text-xs font-medium text-emerald-800 ring-1 ring-inset ring-emerald-200"
                                >
                                    On expiry date
                                </span>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>

</html>