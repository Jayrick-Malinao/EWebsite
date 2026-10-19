<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Barangay Esperanza Health Center' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100">

    <div class="p-8">
        <h1 class="text-3xl font-bold text-green-700">
            Layout Test Successful
        </h1>

        <p class="mt-2 text-gray-600">
            The Laravel App layout component is working.
        </p>

        <div class="mt-6 rounded-lg bg-white p-6 shadow">
            {{ $slot }}
        </div>
    </div>

</body>
</html>