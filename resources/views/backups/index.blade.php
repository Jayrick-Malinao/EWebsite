<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Backups | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage database backups for Barangay Esperanza Health Center."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA HEALTH CENTER
           GOVERNMENT-STYLE CLAYMORPHISM DESIGN SYSTEM
           BACKUPS
        ========================================================= */

        :root {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;
            --primary-deep: #0F4C3A;
            --accent: #E87928;

            --bg: #EEF5F1;
            --surface: #F5FAF7;
            --surface-soft: #EDF5F0;
            --surface-raised: #F8FCFA;

            --text: #164238;
            --text-heading: #234E43;
            --text-secondary: #385C52;
            --text-muted: #6D817A;
            --text-soft: #9AA9A4;

            --danger: #B42323;
            --danger-bright: #DC2626;

            --border-soft: rgba(210, 225, 218, 0.65);
            --border-white: rgba(255, 255, 255, 0.90);

            --shadow-dark: rgba(107, 134, 124, 0.18);
            --shadow-medium: rgba(107, 134, 124, 0.12);
            --shadow-light: rgba(255, 255, 255, 0.92);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { margin: 0; }

        .clay-households,
        .clay-households *,
        .clay-households input,
        .clay-households button,
        .clay-households select,
        .clay-households textarea {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        .clay-households {
            min-height: 100vh;
            color: var(--text);
            background:
                radial-gradient(circle at 0% 0%, rgba(255, 255, 255, 0.92), transparent 34%),
                radial-gradient(circle at 100% 0%, rgba(22, 139, 112, 0.055), transparent 32%),
                linear-gradient(135deg, #EEF5F1 0%, #F5FAF7 52%, #EDF5F0 100%);
        }

        ::selection { color: #FFFFFF; background: var(--primary-dark); }

        /* ---------- Header ---------- */
        .clay-header {
            background: rgba(245, 250, 247, 0.94);
            border-bottom: 1px solid rgba(255, 255, 255, 0.92);
            box-shadow: 0 5px 18px rgba(107, 134, 124, 0.08), 0 -1px 0 rgba(255, 255, 255, 0.94) inset;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-mobile-button {
            background: linear-gradient(145deg, #F9FCFA, #EAF2EE);
            color: var(--primary-dark);
            border: 1px solid var(--border-white);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.14), -4px -4px 9px rgba(255, 255, 255, 0.92);
            transition: transform 0.18s ease, box-shadow 0.18s ease, color 0.18s ease;
        }
        .clay-mobile-button:hover { transform: translateY(-1px); color: var(--primary); }

        .clay-avatar {
            background: linear-gradient(145deg, #E6F4EE, #D7EAE1);
            color: var(--primary-dark);
            border: 1px solid rgba(255, 255, 255, 0.84);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88);
        }

        /* ---------- Heading ---------- */
        .clay-category { color: var(--primary); letter-spacing: 0.08em; }
        .clay-title { color: var(--text); }
        .clay-description { color: var(--text-muted); }
        .clay-heading-wrap { position: relative; }
        .clay-heading-accent {
            position: absolute;
            left: -16px;
            top: 4px;
            width: 4px;
            height: calc(100% - 8px);
            min-height: 62px;
            border-radius: 999px;
            background: linear-gradient(180deg, var(--primary-light), var(--primary-dark));
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.16), -1px -1px 3px rgba(255, 255, 255, 0.82);
        }

        /* ---------- Clay Surfaces ---------- */
        .clay-card {
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            box-shadow: 8px 8px 18px var(--shadow-dark), -8px -8px 18px var(--shadow-light), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
            border-radius: 24px;
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }
        .clay-card-hover:hover { transform: translateY(-2px); }

        .clay-inset {
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: inset 3px 3px 7px rgba(107, 134, 124, 0.10), inset -3px -3px 7px rgba(255, 255, 255, 0.82);
        }

        .clay-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, 0.12), -4px -4px 9px rgba(255, 255, 255, 0.88), inset 1px 1px 0 rgba(255, 255, 255, 0.42);
        }
        .clay-icon-green { background: linear-gradient(145deg, #E7F5EE, #D9ECE4); color: var(--primary-dark); }
        .clay-icon-orange { background: linear-gradient(145deg, #FCF7ED, #F9EBD9); color: var(--accent); }
        .clay-icon-danger { background: linear-gradient(145deg, #FCEFED, #F9E0DC); color: var(--danger); }

        /* ---------- Table ---------- */
        .clay-table {
            overflow: hidden;
            background: linear-gradient(145deg, #F8FCFA, #EAF2EE);
            border: 1px solid var(--border-white);
            border-radius: 26px;
            box-shadow: 8px 8px 18px rgba(107, 134, 124, 0.18), -8px -8px 18px rgba(255, 255, 255, 0.92), inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }
        .clay-table-head { background: linear-gradient(180deg, rgba(235, 244, 239, 0.98), rgba(226, 238, 232, 0.96)); }
        .clay-table-row { background: rgba(255, 255, 255, 0.48); transition: background 0.18s ease; }
        .clay-table-row:hover { background: rgba(255, 255, 255, 0.78); }

        /* ---------- Status ---------- */
        .clay-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.82);
            box-shadow: 2px 2px 5px rgba(107, 134, 124, 0.10), -2px -2px 5px rgba(255, 255, 255, 0.88);
            padding: 0.35rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .clay-status-ok { background: linear-gradient(145deg, #E8F6EF, #DDEEE6); color: var(--primary-dark); }
        .clay-status-warn { background: linear-gradient(145deg, #FCF7ED, #F9EBD9); color: var(--accent); }
        .clay-status-none { background: linear-gradient(145deg, #EDF5F0, #F8FCFA); color: var(--text-muted); }

        .clay-dot { width: 8px; height: 8px; border-radius: 999px; }
        .clay-dot-ok { background: var(--primary-light); box-shadow: 0 0 0 3px rgba(42, 155, 128, 0.18); }
        .clay-dot-warn { background: var(--accent); box-shadow: 0 0 0 3px rgba(232, 121, 40, 0.18); }
        .clay-dot-none { background: var(--text-soft); }

        .clay-chip {
            display: inline-flex;
            align-items: center;
            border-radius: 8px;
            padding: 0.2rem 0.55rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.04em;
            color: var(--text-secondary);
            background: linear-gradient(145deg, #EDF5F0, #F8FCFA);
            border: 1px solid rgba(255, 255, 255, 0.86);
            box-shadow: inset 2px 2px 4px rgba(107, 134, 124, 0.10), inset -2px -2px 4px rgba(255, 255, 255, 0.82);
        }

        /* ---------- Buttons ---------- */
        .clay-primary {
            background: linear-gradient(145deg, #168B70, #0F6F5A);
            color: #FFFFFF !important;
            border: 1px solid rgba(255, 255, 255, 0.20);
            box-shadow: 5px 5px 12px rgba(15, 76, 58, 0.22), -4px -4px 10px rgba(255, 255, 255, 0.55);
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-primary:hover { transform: translateY(-1px); filter: brightness(1.04); }

        .clay-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            min-height: 34px;
            border-radius: 10px;
            padding: 0.4rem 0.8rem;
            font-size: 0.75rem;
            font-weight: 700;
            transition: transform 0.18s ease, filter 0.18s ease;
        }
        .clay-action:hover { transform: translateY(-1px); filter: brightness(1.03); }

        .clay-view {
            background: linear-gradient(145deg, #E8F6EF, #DDEEE6);
            color: var(--primary-dark) !important;
            border: 1px solid rgba(22, 139, 112, 0.14);
            box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        .clay-danger-btn {
            background: linear-gradient(145deg, #FCEFED, #F9E0DC);
            color: var(--danger) !important;
            border: 1px solid rgba(180, 35, 35, 0.14);
            box-shadow: 3px 3px 7px rgba(107, 134, 124, 0.10), -3px -3px 7px rgba(255, 255, 255, 0.88);
        }

        /* ---------- Notices & Flash ---------- */
        .clay-notice {
            background: linear-gradient(145deg, #FCF7ED, #F9EBD9);
            border: 1px solid rgba(232, 121, 40, 0.18);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
            color: #7A4A1E;
        }

        .clay-flash-success {
            background: linear-gradient(145deg, #E8F6EF, #DDEEE6);
            border: 1px solid rgba(22, 139, 112, 0.18);
            color: var(--primary-dark);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
        }
        .clay-flash-error {
            background: linear-gradient(145deg, #FCEFED, #F9E0DC);
            border: 1px solid rgba(180, 35, 35, 0.16);
            color: var(--danger);
            box-shadow: 5px 5px 12px rgba(107, 134, 124, 0.11), -5px -5px 12px rgba(255, 255, 255, 0.88);
        }

        @media (max-width: 1023px) {
            .clay-heading-accent { display: none; }
            main { padding-left: 0; }
        }
    </style>
</head>

<body class="clay-households antialiased">

    {{-- Mobile Sidebar Overlay --}}
    <div
        id="sidebar-overlay"
        class="fixed inset-0 z-40 hidden bg-[#164238]/40 backdrop-blur-sm lg:hidden"
        aria-hidden="true"
    ></div>

    {{-- Sidebar --}}
    @include('dashboard.sidebar')

    @php
        $latestBackup = $backups->first();
        $totalBackups = $backups->count();

        // Days since the most recent backup (null when none exist)
        $daysSinceLatest = $latestBackup
            ? (int) \Carbon\Carbon::createFromTimestamp($latestBackup['modified_at'])->diffInDays(now())
            : null;

        // Protection status: ok within 7 days, warning after that
        if (is_null($daysSinceLatest)) {
            $protection = ['label' => 'No backups yet', 'tone' => 'none', 'message' => 'Create a backup to protect the health-center records.'];
        } elseif ($daysSinceLatest <= 7) {
            $protection = ['label' => 'Protected', 'tone' => 'ok', 'message' => 'The latest backup is ' . ($daysSinceLatest === 0 ? 'from today.' : $daysSinceLatest . ' day(s) old.')];
        } else {
            $protection = ['label' => 'Backup overdue', 'tone' => 'warn', 'message' => 'The latest backup is ' . $daysSinceLatest . ' days old. Consider creating a new one.'];
        }

        // Human-readable file size
        $formatSize = fn ($bytes) => $bytes >= 1048576
            ? number_format($bytes / 1048576, 2) . ' MB'
            : number_format($bytes / 1024, 1) . ' KB';
    @endphp

    {{-- Main Content --}}
    <main class="min-h-screen min-w-0 lg:pl-72">

        {{-- TOP HEADER --}}
        <header class="clay-header sticky top-0 z-30">
            <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">

                {{-- Left --}}
                <div class="flex min-w-0 items-center gap-4">
                    <button
                        type="button"
                        id="mobileMenuButton"
                        class="clay-mobile-button inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl lg:hidden"
                        aria-label="Open navigation menu"
                    >
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>

                    <div class="min-w-0">
                        <p class="clay-category truncate text-xs font-bold uppercase tracking-wider">
                            System Administrator
                        </p>

                        <h1 class="clay-title mt-1 truncate text-xl font-bold tracking-tight sm:text-2xl">
                            Backups
                        </h1>
                    </div>
                </div>

                {{-- Right --}}
                <div class="flex shrink-0 items-center gap-3">
                    @include('partials.notification-bell')

                    <div class="hidden items-center gap-3 sm:flex">
                        <div class="hidden text-right md:block">
                            <p class="max-w-40 truncate text-sm font-bold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-xs font-medium text-[#6D817A]">System Administrator</p>
                        </div>

                        <div class="clay-avatar flex h-10 w-10 shrink-0 items-center justify-center rounded-xl text-sm font-bold">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    </div>
                </div>

            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <div class="mx-auto max-w-[1600px] space-y-6 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">

            {{-- PAGE HEADING + CREATE --}}
            <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                <div class="clay-heading-wrap min-w-0 lg:ml-4">
                    <span class="clay-heading-accent" aria-hidden="true"></span>

                    <p class="clay-category mb-1 text-xs font-bold uppercase tracking-wider">Database Protection</p>

                    <h2 class="clay-title mt-1 text-2xl font-bold tracking-tight sm:text-3xl">
                        Database Backups
                    </h2>

                    <p class="clay-description mt-2 max-w-3xl text-sm leading-6">
                        Create and manage secure database backups for the Barangay Esperanza Health Center records system.
                    </p>
                </div>

                <form
                    id="backupCreateForm"
                    method="POST"
                    action="{{ route('backups.store') }}"
                    class="shrink-0"
                >
                    @csrf

                    <button
                        type="button"
                        id="openBackupConfirmation"
                        class="clay-primary inline-flex min-h-[44px] w-full items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold sm:w-auto"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 20h14" />
                        </svg>
                        Create Backup
                    </button>
                </form>

                <dialog
                    id="backupConfirmation"
                    class="w-[calc(100%-2rem)] max-w-lg rounded-2xl border border-white/90 bg-[#F5FAF7] p-0 text-[#164238] shadow-[14px_14px_30px_rgba(57,85,75,0.24)] backdrop:bg-[#164238]/40"
                    aria-labelledby="backupConfirmationTitle"
                >
                    <div class="p-6">
                        <div class="flex items-start gap-4">
                            <div class="clay-icon clay-icon-green flex h-11 w-11 shrink-0 items-center justify-center rounded-xl">
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4M5 20h14" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="backupConfirmationTitle" class="text-lg font-bold">Create database backup?</h2>
                                <p class="mt-2 text-sm leading-6 text-[#6D817A]">
                                    A new database backup will be generated and added to backup history. Existing backups will not be overwritten.
                                </p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                            <button
                                type="button"
                                data-close-backup-confirmation
                                class="clay-secondary rounded-xl px-4 py-2.5 text-sm font-bold"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                form="backupCreateForm"
                                class="clay-primary rounded-xl px-4 py-2.5 text-sm font-bold"
                            >
                                Confirm and Create
                            </button>
                        </div>
                    </div>
                </dialog>
            </div>

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div class="clay-flash-success rounded-2xl px-4 py-3 text-sm" role="alert">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon clay-icon-green mt-0.5 h-7 w-7 shrink-0 rounded-lg">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                            </svg>
                        </div>
                        <p class="font-bold">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="clay-flash-error rounded-2xl px-4 py-3 text-sm" role="alert">
                    <div class="flex items-start gap-3">
                        <div class="clay-icon clay-icon-danger mt-0.5 h-7 w-7 shrink-0 rounded-lg">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01" />
                                <circle cx="12" cy="12" r="9" />
                            </svg>
                        </div>
                        <p class="font-bold">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            {{-- PROTECTION STATUS PANEL --}}
            <section class="clay-card p-5 sm:p-6">
                <div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between">

                    <div class="flex items-center gap-4">
                        <div class="clay-icon clay-icon-green h-14 w-14 rounded-2xl">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3 4 7v5c0 5 3.5 8 8 9 4.5-1 8-4 8-9V7l-8-4Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs font-bold uppercase tracking-wider text-[#6D817A]">Protection Status</p>
                            <div class="mt-1.5 flex flex-wrap items-center gap-3">
                                <span class="clay-status clay-status-{{ $protection['tone'] }}">
                                    <span class="clay-dot clay-dot-{{ $protection['tone'] }}"></span>
                                    {{ $protection['label'] }}
                                </span>
                            </div>
                            <p class="mt-2 text-sm text-[#385C52]">{{ $protection['message'] }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-3 md:min-w-[360px]">
                        <div class="clay-inset rounded-2xl p-4 text-center">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Total</p>
                            <p class="mt-1 text-2xl font-bold tracking-tight text-[#164238]">{{ number_format($totalBackups) }}</p>
                        </div>

                        <div class="clay-inset rounded-2xl p-4 text-center">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Last Backup</p>
                            <p class="mt-1 text-sm font-bold text-[#164238]">
                                {{ $latestBackup ? \Carbon\Carbon::createFromTimestamp($latestBackup['modified_at'])->diffForHumans() : '—' }}
                            </p>
                        </div>

                        <div class="clay-inset rounded-2xl p-4 text-center">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-[#6D817A]">Storage</p>
                            <p class="mt-1 text-sm font-bold text-[#164238]">Private</p>
                        </div>
                    </div>

                </div>
            </section>

            {{-- BACKUP LIST --}}
            <section class="clay-table">

                <div class="flex flex-col gap-1 border-b border-white/70 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:gap-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <div class="clay-icon clay-icon-green h-10 w-10 rounded-xl">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 7a2 2 0 0 1-2-2m2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7m0 0a2 2 0 0 0 2-2M8 11h8" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-[#164238]">Available Backups</h2>
                            <p class="mt-0.5 text-xs text-[#6D817A]">Database backup files stored securely on the server.</p>
                        </div>
                    </div>

                    <span class="clay-chip shrink-0 self-start sm:self-auto">
                        {{ number_format($totalBackups) }}
                        {{ $totalBackups === 1 ? 'backup' : 'backups' }}
                    </span>
                </div>

                @if ($backups->isEmpty())

                    {{-- EMPTY STATE --}}
                    <div class="px-6 py-16 text-center">
                        <div class="clay-icon clay-icon-green mx-auto h-14 w-14 rounded-2xl">
                            <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M4 7a2 2 0 0 1-2-2m2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7m0 0a2 2 0 0 0 2-2M8 11h8" />
                            </svg>
                        </div>

                        <h3 class="mt-4 text-sm font-bold text-[#164238]">No database backups yet</h3>
                        <p class="mx-auto mt-1 max-w-md text-xs leading-6 text-[#6D817A]">
                            Create a database backup to protect the health-center records and make it available for download.
                        </p>
                    </div>

                @else

                    {{-- DESKTOP TABLE --}}
                    <div class="hidden overflow-x-auto md:block">
                        <table class="min-w-[900px] w-full text-left">

                            <thead class="clay-table-head">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-[#6D817A]">Backup File</th>
                                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-[#6D817A]">Created</th>
                                    <th class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-[#6D817A]">Size</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-[#6D817A]"><span class="sr-only">Actions</span></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($backups as $backup)
                                    @php
                                        $createdAt = \Carbon\Carbon::createFromTimestamp($backup['modified_at']);
                                    @endphp

                                    <tr class="clay-table-row border-b border-[#D2E1DA]/60 last:border-b-0">

                                        <td class="px-6 py-4">
                                            <div class="flex min-w-0 items-center gap-3">
                                                <div class="clay-icon clay-icon-green h-10 w-10 shrink-0 rounded-xl">
                                                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h8l4 4v14H6V3Z" />
                                                        <path stroke-linecap="round" d="M14 3v5h5M9 13h6M9 17h6" />
                                                    </svg>
                                                </div>

                                                <div class="min-w-0">
                                                    <p class="max-w-[420px] truncate text-sm font-bold text-[#164238]">{{ $backup['filename'] }}</p>
                                                    <div class="mt-1 flex items-center gap-2">
                                                        <span class="clay-chip">SQL</span>
                                                        @if ($loop->first && $protection['tone'] === 'ok')
                                                            <span class="text-[11px] font-bold text-[#0F6F5A]">Latest</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <p class="text-sm font-bold text-[#234E43]">{{ $createdAt->format('M d, Y') }}</p>
                                            <p class="mt-0.5 text-xs text-[#6D817A]">
                                                {{ $createdAt->format('h:i A') }} · {{ $createdAt->diffForHumans() }}
                                            </p>
                                        </td>

                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span class="clay-inset inline-flex rounded-lg px-2.5 py-1 text-xs font-bold text-[#385C52]">
                                                {{ $formatSize($backup['size']) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            @component('partials.record-actions', ['label' => 'More actions for '.$backup['filename']])

                                                <a
                                                    href="{{ route('backups.download', ['filename' => $backup['filename']]) }}"
                                                >
                                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4" />
                                                        <path stroke-linecap="round" d="M5 20h14" />
                                                    </svg>
                                                    Download
                                                </a>

                                                <form
                                                    method="POST"
                                                    action="{{ route('backups.destroy', ['filename' => $backup['filename']]) }}"
                                                    data-confirm-title="Delete this backup?"
                                                    data-confirm-message="This backup file will be permanently removed and cannot be restored."
                                                    data-confirm-item="{{ $backup['filename'] }}"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="record-action-danger">
                                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>

                                            @endcomponent
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                    {{-- MOBILE CARDS --}}
                    <div class="divide-y divide-[#D2E1DA]/60 md:hidden">
                        @foreach ($backups as $backup)
                            @php
                                $createdAt = \Carbon\Carbon::createFromTimestamp($backup['modified_at']);
                            @endphp

                            <article class="clay-table-row space-y-4 p-5">

                                <div class="flex items-start gap-3">
                                    <div class="clay-icon clay-icon-green h-10 w-10 shrink-0 rounded-xl">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 3h8l4 4v14H6V3Z" />
                                            <path stroke-linecap="round" d="M14 3v5h5M9 13h6M9 17h6" />
                                        </svg>
                                    </div>

                                    <div class="min-w-0 flex-1">
                                        <p class="break-all text-sm font-bold text-[#164238]">{{ $backup['filename'] }}</p>
                                        <div class="mt-1 flex items-center gap-2">
                                            <span class="clay-chip">SQL</span>
                                            @if ($loop->first && $protection['tone'] === 'ok')
                                                <span class="text-[11px] font-bold text-[#0F6F5A]">Latest</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div class="clay-inset rounded-xl p-3">
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Created</p>
                                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $createdAt->format('M d, Y') }}</p>
                                        <p class="mt-0.5 text-[11px] text-[#6D817A]">{{ $createdAt->format('h:i A') }}</p>
                                    </div>

                                    <div class="clay-inset rounded-xl p-3">
                                        <p class="text-[11px] font-bold uppercase tracking-wide text-[#6D817A]">Size</p>
                                        <p class="mt-1 text-xs font-bold text-[#234E43]">{{ $formatSize($backup['size']) }}</p>
                                    </div>
                                </div>

                                <div>
                                    @component('partials.record-actions', ['label' => 'More actions for '.$backup['filename']])
                                    <a
                                        href="{{ route('backups.download', ['filename' => $backup['filename']]) }}"
                                    >
                                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0 4-4m-4 4-4-4" />
                                            <path stroke-linecap="round" d="M5 20h14" />
                                        </svg>
                                        Download
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('backups.destroy', ['filename' => $backup['filename']]) }}"
                                        data-confirm-title="Delete this backup?"
                                        data-confirm-message="This backup file will be permanently removed and cannot be restored."
                                        data-confirm-item="{{ $backup['filename'] }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="record-action-danger">
                                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 7h16M10 11v6M14 11v6M6 7l1 14h10l1-14M9 7V4h6v3" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                    @endcomponent
                                </div>

                            </article>
                        @endforeach
                    </div>

                @endif

            </section>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const backupConfirmation = document.getElementById('backupConfirmation');
            const openBackupConfirmation = document.getElementById('openBackupConfirmation');

            openBackupConfirmation?.addEventListener('click', () => {
                backupConfirmation.showModal();
            });

            document.querySelectorAll('[data-close-backup-confirmation]').forEach((button) => {
                button.addEventListener('click', () => {
                    backupConfirmation.close();
                });
            });

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
        });
    </script>
</body>
</html>