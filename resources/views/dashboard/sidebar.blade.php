@php
    $role = auth()->user()->role ?? null;
@endphp

@if ($role === 'System Administrator')

    @include('dashboard.admin.sidebar')

@elseif ($role === 'Health Worker')

    @include('dashboard.healthworker.sidebar')

@elseif ($role === 'Official')

    @include('dashboard.official.sidebar')

@endif

@if (in_array($role, ['System Administrator', 'Health Worker', 'Official'], true))

    @include('partials.database-assistant')

@endif
