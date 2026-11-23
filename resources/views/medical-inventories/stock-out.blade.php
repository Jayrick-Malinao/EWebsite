<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Out | Barangay Esperanza Health Center</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-50 text-slate-800">
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-slate-900/40 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>
    @include('dashboard.sidebar')

    <main class="min-h-screen lg:pl-72">
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">
            <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm hover:bg-slate-50 lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Medical Inventory</p>
                        <h1 class="truncate text-xl font-bold tracking-tight text-slate-900 sm:text-2xl">Stock Out</h1>
                    </div>
                </div>
                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')
                    <div class="hidden text-right sm:block">
                        <p class="max-w-40 truncate text-sm font-semibold text-slate-900">{{ $releasedBy->name }}</p>
                        <p class="text-xs text-slate-500">{{ $releasedBy->role }}</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-100 text-sm font-bold text-emerald-800">
                        {{ strtoupper(substr($releasedBy->name, 0, 1)) }}
                    </div>
                </div>
            </div>
        </header>

        <div class="mx-auto max-w-4xl px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Medical Inventory</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl">Release medicine stock</h2>
                    <p class="mt-2 text-sm text-slate-600">Record a release to a resident. Only in-date stock with available units can be released.</p>
                </div>
                <a
                    href="{{ route('medical-inventories.index') }}"
                    class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                >
                    Back to inventory
                </a>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-800" role="alert">
                    <p class="font-semibold">Please correct the following:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                id="stock-out-form"
                action="{{ route('medical-inventories.stock-out.store') }}"
                method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                onsubmit="return window.confirm('Confirm this medicine stock release?')"
            >
                @csrf
                <div class="grid gap-5 p-5 sm:grid-cols-2 sm:p-7">
                    <div class="sm:col-span-2">
                        <label for="medicine-search" class="block text-sm font-semibold text-slate-800">
                            Medicine <span class="text-red-600">*</span>
                        </label>
                        <input
                            id="medicine-search"
                            name="medicine_search"
                            type="search"
                            list="medical-inventory-options"
                            value="{{ old('medicine_search') }}"
                            placeholder="Search medicine name or expiry date"
                            autocomplete="off"
                            required
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                            aria-describedby="available-amount"
                        >
                        <datalist id="medical-inventory-options">
                            @foreach ($medicalInventories as $inventory)
                                <option
                                    value="{{ $inventory->medicine_name }} — Expires {{ $inventory->expiry_date->format('M d, Y') }} — Available {{ $inventory->quantity }}"
                                    data-id="{{ $inventory->id }}"
                                    data-quantity="{{ $inventory->quantity }}"
                                ></option>
                            @endforeach
                        </datalist>
                        <input
                            type="hidden"
                            id="medical_inventory_id"
                            name="medical_inventory_id"
                            value="{{ old('medical_inventory_id') }}"
                        >
                        <p id="available-amount" class="mt-2 text-sm font-medium text-slate-600" aria-live="polite">
                            Available amount: <span id="available-quantity">Select a medicine</span>
                        </p>
                        @error('medical_inventory_id')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="resident-search" class="block text-sm font-semibold text-slate-800">
                            Resident <span class="text-red-600">*</span>
                        </label>
                        <input
                            id="resident-search"
                            name="resident_search"
                            type="search"
                            list="resident-options"
                            value="{{ old('resident_search') }}"
                            placeholder="Search resident by name"
                            autocomplete="off"
                            required
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >
                        <datalist id="resident-options">
                            @foreach ($residents as $resident)
                                <option
                                    value="{{ $resident->full_name }} — Resident #{{ $resident->id }}"
                                    data-id="{{ $resident->id }}"
                                ></option>
                            @endforeach
                        </datalist>
                        <input
                            type="hidden"
                            id="resident_id"
                            name="resident_id"
                            value="{{ old('resident_id') }}"
                        >
                        @error('resident_id')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="released-by" class="block text-sm font-semibold text-slate-800">Released by</label>
                        <input
                            id="released-by"
                            type="text"
                            value="{{ $releasedBy->name }}"
                            readonly
                            class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700"
                        >
                        <p class="mt-1 text-xs text-slate-500">Recorded from your signed-in account.</p>
                    </div>

                    <div>
                        <label for="released-at" class="block text-sm font-semibold text-slate-800">Release date and time</label>
                        <input
                            id="released-at"
                            type="text"
                            value="{{ $releasedAt->format('M d, Y h:i A T') }}"
                            readonly
                            class="mt-2 block w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 text-sm text-slate-700"
                        >
                        <p class="mt-1 text-xs text-slate-500">Set by the server in {{ config('app.timezone') }}.</p>
                    </div>

                    <div>
                        <label for="method" class="block text-sm font-semibold text-slate-800">
                            Method <span class="text-red-600">*</span>
                        </label>
                        <input
                            id="method"
                            name="method"
                            type="text"
                            value="{{ old('method') }}"
                            maxlength="100"
                            required
                            placeholder="How the medicine is handed over"
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >
                        @error('method')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="block text-sm font-semibold text-slate-800">
                            Quantity <span class="text-red-600">*</span>
                        </label>
                        <input
                            id="quantity"
                            name="quantity"
                            type="number"
                            value="{{ old('quantity') }}"
                            min="1"
                            step="1"
                            inputmode="numeric"
                            required
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >
                        @error('quantity')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="purpose" class="block text-sm font-semibold text-slate-800">
                            Purpose <span class="text-red-600">*</span>
                        </label>
                        <textarea
                            id="purpose"
                            name="purpose"
                            rows="3"
                            maxlength="1000"
                            required
                            placeholder="Reason for releasing this medicine"
                            class="mt-2 block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm shadow-sm outline-none focus:border-emerald-600 focus:ring-2 focus:ring-emerald-100"
                        >{{ old('purpose') }}</textarea>
                        @error('purpose')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="flex items-start gap-3 text-sm text-slate-700">
                            <input
                                type="checkbox"
                                name="confirmation"
                                value="1"
                                @checked(old('confirmation'))
                                required
                                class="mt-0.5 h-4 w-4 rounded border-slate-300 text-emerald-700 focus:ring-emerald-600"
                            >
                            <span>I confirm that the selected medicine, resident, and release quantity are correct.</span>
                        </label>
                        @error('confirmation')
                            <p class="mt-1 text-sm text-red-700">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:justify-end sm:px-7">
                    <a
                        href="{{ route('medical-inventories.index') }}"
                        class="inline-flex min-h-11 items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Cancel
                    </a>
                    <button
                        type="submit"
                        class="inline-flex min-h-11 items-center justify-center rounded-xl bg-emerald-700 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-emerald-800"
                    >
                        Confirm Stock Out
                    </button>
                </div>
            </form>

            @if ($medicalInventories->isEmpty())
                <p class="mt-4 rounded-xl border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
                    No unexpired medicine with available stock can be released.
                </p>
            @endif
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menuButton = document.getElementById('mobileMenuButton');
            const overlay = document.getElementById('sidebar-overlay');
            const sidebar = document.querySelector('[data-sidebar]');

            if (menuButton && overlay && sidebar) {
                menuButton.addEventListener('click', () => {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('hidden');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }

            const medicineSearch = document.getElementById('medicine-search');
            const medicineOptions = document.getElementById('medical-inventory-options');
            const inventoryId = document.getElementById('medical_inventory_id');
            const availableQuantity = document.getElementById('available-quantity');
            const quantityInput = document.getElementById('quantity');
            const residentSearch = document.getElementById('resident-search');
            const residentOptions = document.getElementById('resident-options');
            const residentId = document.getElementById('resident_id');

            const matchingOption = (options, value) => (
                Array.from(options.options).find((option) => option.value === value)
            );

            const updateMedicine = () => {
                const option = matchingOption(medicineOptions, medicineSearch.value);

                inventoryId.value = option ? option.dataset.id : '';
                availableQuantity.textContent = option ? `${option.dataset.quantity} units` : 'Select a medicine';
                quantityInput.max = option ? option.dataset.quantity : '';
            };

            medicineSearch.addEventListener('input', updateMedicine);
            medicineSearch.addEventListener('change', updateMedicine);
            residentSearch.addEventListener('input', () => {
                const option = matchingOption(residentOptions, residentSearch.value);

                residentId.value = option ? option.dataset.id : '';
            });
            residentSearch.addEventListener('change', () => {
                const option = matchingOption(residentOptions, residentSearch.value);

                residentId.value = option ? option.dataset.id : '';
            });
            updateMedicine();
        });
    </script>
</body>

</html>
