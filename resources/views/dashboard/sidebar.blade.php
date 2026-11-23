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

@if (request()->routeIs('admin.dashboard', 'healthworker.dashboard', 'official.dashboard'))
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 lg:hidden"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('[data-sidebar]');
            const overlay = document.getElementById('sidebarOverlay');
            const button = document.getElementById('sidebarOpen');
            const desktop = window.matchMedia('(min-width: 1024px)');

            if (!sidebar || !overlay || !button) return;

            const closeSidebar = (restoreFocus = false) => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
                button.setAttribute('aria-expanded', 'false');
                sidebar.inert = !desktop.matches;
                if (restoreFocus && !desktop.matches) button.focus();
            };

            button.addEventListener('click', () => {
                sidebar.inert = false;
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
                button.setAttribute('aria-expanded', 'true');
                sidebar.querySelector('a, button')?.focus();
            });
            overlay.addEventListener('click', () => closeSidebar(true));
            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && button.getAttribute('aria-expanded') === 'true') {
                    closeSidebar(true);
                }
            });
            desktop.addEventListener('change', () => closeSidebar());
            closeSidebar();
        });
    </script>
@endif

@if (in_array($role, ['System Administrator', 'Health Worker', 'Official'], true))

    @include('partials.database-assistant')

@endif
