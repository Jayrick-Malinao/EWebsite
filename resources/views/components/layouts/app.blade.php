<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Barangay Esperanza Health Center' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @fluxAppearance
</head>

<body class="min-h-screen bg-[#F7FAF8] text-slate-900">

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main content --}}
    <div class="min-h-screen lg:pl-72">

        {{-- Mobile header --}}
        <header class="sticky top-0 z-40 flex h-16 items-center border-b border-slate-200 bg-white px-4 lg:hidden">

            <button
                type="button"
                onclick="document.getElementById('adminSidebar').classList.toggle('-translate-x-full')"
                class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-600 hover:bg-slate-100"
                aria-label="Open menu"
            >
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
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </button>

            <div class="ml-3">
                <p class="text-sm font-semibold text-[#0F4C3A]">
                    Barangay Esperanza
                </p>

                <p class="text-xs text-slate-500">
                    Health Center
                </p>
            </div>

        </header>

        {{-- Page content --}}
        <main class="min-h-screen bg-[#F7FAF8] p-4 sm:p-6 lg:p-8">
            {{ $slot }}
        </main>

    </div>

</body>
</html>
