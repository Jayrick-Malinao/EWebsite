<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Users | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Manage Health Worker and Barangay Official staff accounts."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* =========================================================
           BARANGAY ESPERANZA
           SYSTEM ADMINISTRATOR DASHBOARD THEME
           GOVERNMENT-STYLE CLAYMORPHISM
           
           FRONTEND ONLY.
           Backend routes, variables, forms and logic preserved.
        ========================================================== */

        .clay-users {
            --primary: #168B70;
            --primary-dark: #0F6F5A;
            --primary-light: #2A9B80;

            --legacy-primary: #0F4C3A;
            --secondary: #128C5A;

            --accent: #E87928;

            --bg: #EEF5F1;
            --surface: #F5FAF7;
            --surface-soft: #EDF5F0;

            --text: #164238;
            --text-dark: #234E43;
            --text-muted: #6D817A;
            --text-soft: #9AA9A4;

            --white: rgba(255, 255, 255, 0.94);

            --shadow-dark: rgba(107, 134, 124, 0.22);
            --shadow-dark-soft: rgba(107, 134, 124, 0.14);
            --shadow-light: rgba(255, 255, 255, 0.92);

            min-height: 100vh;

            font-family:
                Arial,
                Helvetica,
                sans-serif !important;

            color: var(--text);

            background:
                radial-gradient(
                    circle at 8% 5%,
                    rgba(255, 255, 255, 0.68),
                    transparent 24%
                ),
                radial-gradient(
                    circle at 92% 8%,
                    rgba(42, 155, 128, 0.055),
                    transparent 23%
                ),
                linear-gradient(
                    135deg,
                    #EEF5F1 0%,
                    #F5FAF7 52%,
                    #EDF5F0 100%
                );
        }

        .clay-users,
        .clay-users *,
        .clay-users button,
        .clay-users input,
        .clay-users select,
        .clay-users textarea {
            font-family:
                Arial,
                Helvetica,
                sans-serif !important;
        }

        .clay-users main {
            background: transparent;
        }

        /* =========================================================
           GLOBAL TEXT
        ========================================================== */

        .clay-users .text-slate-900 {
            color: #164238 !important;
        }

        .clay-users .text-slate-800 {
            color: #234E43 !important;
        }

        .clay-users .text-slate-700 {
            color: #385C52 !important;
        }

        .clay-users .text-slate-600 {
            color: #557067 !important;
        }

        .clay-users .text-slate-500 {
            color: #6D817A !important;
        }

        .clay-users .text-slate-400 {
            color: #9AA9A4 !important;
        }

        /* =========================================================
           HEADER
        ========================================================== */

        .clay-users > main > header {
            background:
                rgba(245, 250, 247, 0.94) !important;

            border-color:
                rgba(255, 255, 255, 0.78) !important;

            box-shadow:
                0 5px 16px rgba(107, 134, 124, 0.10),
                0 1px 0 rgba(255, 255, 255, 0.92);

            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .clay-users header h1,
        .clay-users header p {
            text-shadow:
                0 1px 0 rgba(255, 255, 255, 0.78);
        }

        /* =========================================================
           MOBILE MENU
        ========================================================== */

        .clay-users #mobileMenuButton {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border-color:
                rgba(255, 255, 255, 0.86) !important;

            color:
                var(--primary-dark) !important;

            box-shadow:
                5px 5px 11px var(--shadow-dark-soft),
                -5px -5px 11px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        .clay-users #mobileMenuButton:hover {
            background:
                #EDF5F0 !important;
        }

        /* =========================================================
           PROFILE AVATAR
        ========================================================== */

        .clay-users header .bg-emerald-100 {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #E3EEE8
                ) !important;

            color:
                var(--primary-dark) !important;

            border:
                1px solid rgba(255, 255, 255, 0.86);

            box-shadow:
                5px 5px 11px var(--shadow-dark-soft),
                -5px -5px 11px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.82);
        }

        /* =========================================================
           MAIN CONTENT
        ========================================================== */

        .clay-users main > div {
            position: relative;
        }

        /* =========================================================
           PAGE HEADING
        ========================================================== */

        .clay-page-heading {
            position: relative;
        }

        .clay-page-heading::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 4px;

            width: 4px;
            height: 72px;

            border-radius: 999px;

            background:
                linear-gradient(
                    180deg,
                    #168B70,
                    #0F6F5A
                );

            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.18),
                -2px -2px 5px rgba(255, 255, 255, 0.80);
        }

        /* =========================================================
           PRIMARY BUTTON
        ========================================================== */

        .clay-users a.bg-\[\#0F4C3A\],
        .clay-users button.bg-\[\#0F4C3A\] {
            background:
                linear-gradient(
                    145deg,
                    #168B70,
                    #0F6F5A
                ) !important;

            border:
                1px solid rgba(255, 255, 255, 0.22);

            box-shadow:
                7px 7px 15px rgba(107, 134, 124, 0.22),
                -6px -6px 13px rgba(255, 255, 255, 0.76),
                inset 1px 1px 0 rgba(255, 255, 255, 0.18);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease,
                background 0.18s ease;
        }

        .clay-users a.bg-\[\#0F4C3A\]:hover,
        .clay-users button.bg-\[\#0F4C3A\]:hover {
            background:
                linear-gradient(
                    145deg,
                    #2A9B80,
                    #0F6F5A
                ) !important;

            transform:
                translateY(-2px);

            box-shadow:
                9px 9px 18px rgba(107, 134, 124, 0.24),
                -7px -7px 14px rgba(255, 255, 255, 0.82),
                inset 1px 1px 0 rgba(255, 255, 255, 0.20);
        }

        /* =========================================================
           DASHBOARD-STYLE CLAY CARDS
        ========================================================== */

        .clay-summary-card,
        .clay-filter-card,
        .clay-table-card,
        .clay-mobile-card {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            border:
                1px solid rgba(255, 255, 255, 0.84) !important;

            box-shadow:
                9px 9px 20px var(--shadow-dark),
                -9px -9px 20px var(--shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);

            position: relative;
        }

        .clay-summary-card {
            border-radius: 22px !important;

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-summary-card:hover {
            transform:
                translateY(-2px);

            box-shadow:
                11px 11px 23px rgba(107, 134, 124, 0.25),
                -11px -11px 23px rgba(255, 255, 255, 0.96),
                inset 1px 1px 0 rgba(255, 255, 255, 0.86);
        }

        .clay-filter-card {
            border-radius: 24px !important;
        }

        .clay-table-card {
            border-radius: 26px !important;

            box-shadow:
                11px 11px 24px rgba(107, 134, 124, 0.22),
                -11px -11px 24px rgba(255, 255, 255, 0.94),
                inset 1px 1px 0 rgba(255, 255, 255, 0.86);
        }

        .clay-mobile-card {
            border-radius: 22px !important;
        }

        /* =========================================================
           SUMMARY CARD ICONS
        ========================================================== */

        .clay-summary-icon {
            display: flex;

            height: 50px;
            width: 50px;

            align-items: center;
            justify-content: center;

            border-radius: 15px;

            border:
                1px solid rgba(255, 255, 255, 0.80);

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.15),
                -5px -5px 10px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-summary-icon.total {
            background:
                linear-gradient(
                    145deg,
                    #F0F6F3,
                    #E3EEE9
                );

            color:
                #0F6F5A;
        }

        .clay-summary-icon.health {
            background:
                linear-gradient(
                    145deg,
                    #EEF8F3,
                    #DCEFE7
                );

            color:
                #168B70;
        }

        .clay-summary-icon.official {
            background:
                linear-gradient(
                    145deg,
                    #FCF4EC,
                    #F4E5D7
                );

            color:
                #E87928;
        }

        /* =========================================================
           FILTER CARD
        ========================================================== */

        .clay-filter-header {
            padding-bottom: 1rem;

            border-bottom:
                1px solid rgba(210, 225, 218, 0.58);
        }

        .clay-filter-title-icon {
            display: flex;

            height: 38px;
            width: 38px;

            align-items: center;
            justify-content: center;

            border-radius: 12px;

            background:
                linear-gradient(
                    145deg,
                    #EEF7F3,
                    #E0EEE8
                );

            color:
                var(--primary-dark);

            border:
                1px solid rgba(255, 255, 255, 0.82);

            box-shadow:
                4px 4px 8px rgba(107, 134, 124, 0.13),
                -4px -4px 8px rgba(255, 255, 255, 0.84),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        /* =========================================================
           INPUTS AND SELECTS
        ========================================================== */

        .clay-users input,
        .clay-users select {
            background:
                linear-gradient(
                    145deg,
                    #EDF5F0,
                    #F8FCFA
                ) !important;

            border:
                1px solid rgba(255, 255, 255, 0.84) !important;

            color:
                var(--text) !important;

            border-radius:
                14px !important;

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.82),
                1px 1px 0 rgba(255, 255, 255, 0.72);

            transition:
                border-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-users input::placeholder {
            color:
                var(--text-soft) !important;
        }

        .clay-users input:focus,
        .clay-users select:focus {
            border-color:
                rgba(22, 139, 112, 0.48) !important;

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.84),
                0 0 0 3px rgba(22, 139, 112, 0.10) !important;
        }

        /* =========================================================
           FILTER BUTTONS
        ========================================================== */

        .clay-filter-submit {
            background:
                linear-gradient(
                    145deg,
                    #168B70,
                    #0F6F5A
                ) !important;

            border:
                1px solid rgba(255, 255, 255, 0.20);

            box-shadow:
                5px 5px 11px rgba(107, 134, 124, 0.19),
                -5px -5px 10px rgba(255, 255, 255, 0.74),
                inset 1px 1px 0 rgba(255, 255, 255, 0.18);

            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-filter-submit:hover {
            background:
                linear-gradient(
                    145deg,
                    #2A9B80,
                    #0F6F5A
                ) !important;

            transform:
                translateY(-1px);
        }

        /* =========================================================
           TABLE HEADER
        ========================================================== */

        .clay-table-heading {
            border-bottom:
                1px solid rgba(210, 225, 218, 0.62);
        }

        .clay-table-heading-icon {
            display: flex;

            height: 42px;
            width: 42px;

            align-items: center;
            justify-content: center;

            border-radius: 13px;

            background:
                linear-gradient(
                    145deg,
                    #EEF7F3,
                    #E0EEE8
                );

            color:
                var(--primary-dark);

            border:
                1px solid rgba(255, 255, 255, 0.84);

            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.14),
                -4px -4px 9px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-account-count {
            background:
                linear-gradient(
                    145deg,
                    #EEF4F1,
                    #E3ECE8
                ) !important;

            color:
                var(--text-muted) !important;

            border:
                1px solid rgba(255, 255, 255, 0.80);

            box-shadow:
                inset 2px 2px 5px rgba(107, 134, 124, 0.08),
                inset -2px -2px 5px rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           TABLE
        ========================================================== */

        .clay-users thead {
            background:
                #EDF5F0 !important;
        }

        .clay-users tbody {
            background:
                transparent !important;
        }

        .clay-users tbody tr {
            transition:
                background 0.18s ease;
        }

        .clay-users tbody tr:hover {
            background:
                rgba(255, 255, 255, 0.48) !important;
        }

        .clay-users th {
            color:
                var(--text-muted) !important;

            border-color:
                rgba(210, 225, 218, 0.66) !important;
        }

        .clay-users td {
            border-color:
                rgba(210, 225, 218, 0.58) !important;
        }

        /* =========================================================
           STAFF AVATARS
        ========================================================== */

        .clay-staff-avatar {
            display: flex;

            height: 42px;
            width: 42px;

            flex-shrink: 0;

            align-items: center;
            justify-content: center;

            border-radius: 14px;

            background:
                linear-gradient(
                    145deg,
                    #168B70,
                    #0F6F5A
                ) !important;

            color:
                white;

            border:
                1px solid rgba(255, 255, 255, 0.22);

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.18),
                -4px -4px 9px rgba(255, 255, 255, 0.78),
                inset 1px 1px 0 rgba(255, 255, 255, 0.18);
        }

        /* =========================================================
           ROLE BADGES
        ========================================================== */

        .clay-role-health {
            background:
                linear-gradient(
                    145deg,
                    #EEF8F3,
                    #DDEFE8
                ) !important;

            color:
                #0F6F5A !important;

            border:
                1px solid rgba(22, 139, 112, 0.12);

            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.10),
                -2px -2px 5px rgba(255, 255, 255, 0.76),
                inset 1px 1px 0 rgba(255, 255, 255, 0.72);
        }

        .clay-role-official {
            background:
                linear-gradient(
                    145deg,
                    #FCF4EC,
                    #F4E5D7
                ) !important;

            color:
                #A85E24 !important;

            border:
                1px solid rgba(232, 121, 40, 0.12);

            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.10),
                -2px -2px 5px rgba(255, 255, 255, 0.76),
                inset 1px 1px 0 rgba(255, 255, 255, 0.72);
        }

        /* =========================================================
           STATUS BADGES
        ========================================================== */

        .clay-status-active {
            background:
                linear-gradient(
                    145deg,
                    #EEF8F3,
                    #DDEFE8
                ) !important;

            color:
                #0F6F5A !important;

            border:
                1px solid rgba(22, 139, 112, 0.12);

            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.10),
                -2px -2px 5px rgba(255, 255, 255, 0.76),
                inset 1px 1px 0 rgba(255, 255, 255, 0.72);
        }

        .clay-status-inactive {
            background:
                linear-gradient(
                    145deg,
                    #F0F4F2,
                    #E4EBE8
                ) !important;

            color:
                #667B73 !important;

            border:
                1px solid rgba(107, 134, 124, 0.10);

            box-shadow:
                2px 2px 5px rgba(107, 134, 124, 0.08),
                -2px -2px 5px rgba(255, 255, 255, 0.74),
                inset 1px 1px 0 rgba(255, 255, 255, 0.70);
        }

        .clay-status-dot-active {
            background:
                #168B70 !important;

            box-shadow:
                0 0 0 3px rgba(22, 139, 112, 0.10);
        }

        .clay-status-dot-inactive {
            background:
                #8FA19A !important;
        }

        /* =========================================================
           ACTION BUTTONS
        ========================================================== */

        .clay-action {
            border-radius:
                11px !important;

            border:
                1px solid rgba(255, 255, 255, 0.80) !important;

            box-shadow:
                3px 3px 7px rgba(107, 134, 124, 0.12),
                -3px -3px 7px rgba(255, 255, 255, 0.76),
                inset 1px 1px 0 rgba(255, 255, 255, 0.68);

            transition:
                transform 0.16s ease,
                box-shadow 0.16s ease,
                background 0.16s ease;
        }

        .clay-action:hover {
            transform:
                translateY(-1px);
        }

        .clay-action-edit {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                ) !important;

            color:
                #385C52 !important;
        }

        .clay-action-edit:hover {
            background:
                #EDF5F0 !important;
        }

        .clay-action-danger {
            background:
                linear-gradient(
                    145deg,
                    #FBEDEC,
                    #F3DEDC
                ) !important;

            color:
                #B42323 !important;

            border-color:
                rgba(220, 38, 38, 0.13) !important;
        }

        .clay-action-danger:hover {
            background:
                #F9E5E3 !important;
        }

        .clay-action-activate {
            background:
                linear-gradient(
                    145deg,
                    #EEF8F3,
                    #DDEFE8
                ) !important;

            color:
                #0F6F5A !important;

            border-color:
                rgba(22, 139, 112, 0.14) !important;
        }

        .clay-action-activate:hover {
            background:
                #D7ECE4 !important;
        }

        /* =========================================================
           EMPTY STATE
        ========================================================== */

        .clay-empty-icon {
            background:
                linear-gradient(
                    145deg,
                    #EEF4F1,
                    #E2EBE7
                ) !important;

            color:
                #8FA19A !important;

            border:
                1px solid rgba(255, 255, 255, 0.80);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.10),
                inset -3px -3px 7px rgba(255, 255, 255, 0.80),
                2px 2px 6px rgba(107, 134, 124, 0.08);
        }

        /* =========================================================
           MOBILE CARDS
        ========================================================== */

        .clay-mobile-card {
            transition:
                transform 0.18s ease,
                box-shadow 0.18s ease;
        }

        .clay-mobile-card:hover {
            transform:
                translateY(-1px);

            box-shadow:
                10px 10px 21px rgba(107, 134, 124, 0.23),
                -10px -10px 21px rgba(255, 255, 255, 0.94),
                inset 1px 1px 0 rgba(255, 255, 255, 0.84);
        }

        /* =========================================================
           FLASH MESSAGES
        ========================================================== */

        .clay-success-alert {
            background:
                linear-gradient(
                    145deg,
                    #F0F8F4,
                    #E2F0E9
                ) !important;

            border:
                1px solid rgba(22, 139, 112, 0.16) !important;

            color:
                #0F6F5A !important;

            box-shadow:
                6px 6px 13px rgba(107, 134, 124, 0.14),
                -6px -6px 13px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-error-alert {
            background:
                linear-gradient(
                    145deg,
                    #FCF0EF,
                    #F4E3E1
                ) !important;

            border:
                1px solid rgba(220, 38, 38, 0.14) !important;

            color:
                #B42323 !important;

            box-shadow:
                6px 6px 13px rgba(107, 134, 124, 0.13),
                -6px -6px 13px rgba(255, 255, 255, 0.86),
                inset 1px 1px 0 rgba(255, 255, 255, 0.76);
        }

        /* =========================================================
           SECURITY NOTICE
        ========================================================== */

        .clay-security {
            background:
                linear-gradient(
                    145deg,
                    #FBF7ED,
                    #F2EBD9
                ) !important;

            border:
                1px solid rgba(183, 121, 31, 0.17) !important;

            border-radius:
                22px !important;

            box-shadow:
                8px 8px 17px rgba(107, 134, 124, 0.14),
                -8px -8px 17px rgba(255, 255, 255, 0.90),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-security-icon {
            background:
                linear-gradient(
                    145deg,
                    #F4EBD2,
                    #EBDD B8
                ) !important;

            color:
                #8A6A28 !important;

            border:
                1px solid rgba(255, 255, 255, 0.72);

            box-shadow:
                4px 4px 9px rgba(107, 134, 124, 0.11),
                -4px -4px 9px rgba(255, 255, 255, 0.78),
                inset 1px 1px 0 rgba(255, 255, 255, 0.70);
        }

        /* =========================================================
           PAGINATION
        ========================================================== */

        .clay-users nav[aria-label="Pagination Navigation"] {
            font-family:
                Arial,
                Helvetica,
                sans-serif !important;
        }

        .clay-users nav[aria-label="Pagination Navigation"] a,
        .clay-users nav[aria-label="Pagination Navigation"] span {
            border-color:
                rgba(255, 255, 255, 0.76) !important;
        }

        /* =========================================================
           CONFIRMATION MODAL
        ========================================================== */

        .clay-confirm-overlay {
            position: fixed;
            inset: 0;
            z-index: 100;

            display: none;

            align-items: center;
            justify-content: center;

            padding: 1rem;

            background:
                rgba(22, 66, 56, 0.24);

            backdrop-filter:
                blur(4px);

            -webkit-backdrop-filter:
                blur(4px);
        }

        .clay-confirm-overlay.is-open {
            display: flex;
        }

        .clay-confirm-box {
            width: 100%;
            max-width: 430px;

            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                );

            border:
                1px solid rgba(255, 255, 255, 0.90);

            border-radius:
                24px;

            padding:
                1.35rem;

            box-shadow:
                13px 13px 30px rgba(107, 134, 124, 0.25),
                -13px -13px 30px rgba(255, 255, 255, 0.96),
                inset 1px 1px 0 rgba(255, 255, 255, 0.90);

            transform:
                translateY(8px) scale(0.98);

            opacity:
                0;

            transition:
                transform 0.18s ease,
                opacity 0.18s ease;
        }

        .clay-confirm-overlay.is-open .clay-confirm-box {
            transform:
                translateY(0) scale(1);

            opacity:
                1;
        }

        .clay-confirm-icon {
            display: flex;

            height: 46px;
            width: 46px;

            flex-shrink: 0;

            align-items: center;
            justify-content: center;

            border-radius:
                14px;

            background:
                linear-gradient(
                    145deg,
                    #FBEDEC,
                    #F2DCDA
                );

            color:
                #B42323;

            border:
                1px solid rgba(220, 38, 38, 0.12);

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.13),
                -5px -5px 10px rgba(255, 255, 255, 0.84),
                inset 1px 1px 0 rgba(255, 255, 255, 0.80);
        }

        .clay-confirm-account {
            margin-top:
                1rem;

            border-radius:
                15px;

            background:
                linear-gradient(
                    145deg,
                    #EDF5F0,
                    #E7F0EB
                );

            border:
                1px solid rgba(255, 255, 255, 0.84);

            padding:
                0.85rem 0.95rem;

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, 0.09),
                inset -3px -3px 7px rgba(255, 255, 255, 0.80);
        }

        .clay-confirm-cancel {
            background:
                linear-gradient(
                    145deg,
                    #F8FCFA,
                    #EAF2EE
                );

            color:
                #385C52;

            border:
                1px solid rgba(255, 255, 255, 0.88);

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, 0.14),
                -5px -5px 10px rgba(255, 255, 255, 0.88),
                inset 1px 1px 0 rgba(255, 255, 255, 0.78);
        }

        .clay-confirm-cancel:hover {
            background:
                #EDF5F0;
        }

        .clay-confirm-danger {
            background:
                linear-gradient(
                    145deg,
                    #DC2626,
                    #B42323
                );

            color:
                white;

            border:
                1px solid rgba(255, 255, 255, 0.24);

            box-shadow:
                6px 6px 12px rgba(107, 134, 124, 0.20),
                -6px -6px 11px rgba(255, 255, 255, 0.74),
                inset 1px 1px 0 rgba(255, 255, 255, 0.18);
        }

        .clay-confirm-danger:hover {
            background:
                linear-gradient(
                    145deg,
                    #EF4444,
                    #B42323
                );
        }

        .clay-confirm-activate {
            background:
                linear-gradient(
                    145deg,
                    #168B70,
                    #0F6F5A
                ) !important;

            color:
                white !important;

            border:
                1px solid rgba(255, 255, 255, 0.22);

            box-shadow:
                6px 6px 12px rgba(107, 134, 124, 0.20),
                -6px -6px 11px rgba(255, 255, 255, 0.74),
                inset 1px 1px 0 rgba(255, 255, 255, 0.18);
        }

        .clay-confirm-activate:hover {
            background:
                linear-gradient(
                    145deg,
                    #2A9B80,
                    #0F6F5A
                ) !important;
        }

        /* =========================================================
           ACCESSIBILITY
        ========================================================== */

        .clay-users a:focus-visible,
        .clay-users button:focus-visible,
        .clay-users input:focus-visible,
        .clay-users select:focus-visible {
            outline:
                2px solid var(--primary);

            outline-offset:
                2px;

            box-shadow:
                0 0 0 4px rgba(22, 139, 112, 0.10),
                4px 4px 9px rgba(107, 134, 124, 0.16),
                -4px -4px 9px rgba(255, 255, 255, 0.84);
        }

        /* =========================================================
           RESPONSIVE
        ========================================================== */

        @media (max-width: 639px) {

            .clay-page-heading::before {
                display:
                    none;
            }

            .clay-summary-card {
                border-radius:
                    20px !important;
            }

            .clay-filter-card,
            .clay-mobile-card {
                border-radius:
                    20px !important;
            }

            .clay-table-card {
                border-radius:
                    22px !important;
            }

        }

        /* =========================================================
           REDUCED MOTION
        ========================================================== */

        @media (prefers-reduced-motion: reduce) {

            .clay-users *,
            .clay-users *::before,
            .clay-users *::after {
                scroll-behavior:
                    auto !important;

                transition:
                    none !important;

                animation-duration:
                    0.01ms !important;

                animation-iteration-count:
                    1 !important;
            }

        }
    </style>
</head>

<body class="clay-users min-h-screen bg-[#EEF5F1] text-[#164238]">

    {{-- Admin Sidebar --}}
    @include('dashboard.sidebar')

    {{-- Main Content --}}
    <main class="min-h-screen lg:pl-72">

        {{-- =====================================================
             TOP HEADER
        ====================================================== --}}
        <header class="sticky top-0 z-30 border-b border-slate-200 bg-white/95 backdrop-blur">

            <div class="flex h-20 items-center justify-between px-4 sm:px-6 lg:px-8">

                {{-- Left --}}
                <div class="flex items-center gap-4">

                    {{-- Mobile Menu --}}
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

                        <p class="text-xs font-semibold uppercase tracking-wider text-[#168B70]">
                            System Administrator
                        </p>

                        <h1 class="mt-1 text-xl font-bold tracking-tight text-[#164238] sm:text-2xl">
                            User Management
                        </h1>

                    </div>

                </div>


                {{-- Right --}}
                <div class="flex items-center gap-3">

                    @include('partials.notification-bell')

                    {{-- Profile --}}
                    <div class="flex items-center gap-3">

                        <div class="hidden text-right sm:block">

                            <p class="text-sm font-semibold text-[#164238]">
                                {{ auth()->user()->name }}
                            </p>

                            <p class="text-xs text-[#6D817A]">
                                System Administrator
                            </p>

                        </div>

                        <div class="clay-profile-avatar flex h-10 w-10 items-center justify-center rounded-xl text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>


                    </div>

                </div>

            </div>

        </header>


        {{-- =====================================================
             PAGE CONTENT
        ====================================================== --}}
        <div class="px-4 py-6 sm:px-6 lg:px-8">

            {{-- =================================================
                 FLASH MESSAGES
            ================================================== --}}
            @if (session('success'))

                <div class="clay-success-alert mb-6 rounded-xl px-4 py-3 text-sm font-medium">

                    {{ session('success') }}

                </div>

            @endif


            @if (session('error'))

                <div class="clay-error-alert mb-6 rounded-xl px-4 py-3 text-sm font-medium">

                    {{ session('error') }}

                </div>

            @endif


            @if ($errors->any())

                <div class="clay-error-alert mb-6 rounded-xl px-4 py-3 text-sm">

                    <p class="font-bold">
                        Please correct the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- =================================================
                 PAGE HEADING
            ================================================== --}}
            <div class="clay-page-heading mb-7 flex flex-col gap-4 pl-0 sm:flex-row sm:items-end sm:justify-between sm:pl-2">

                <div>


                    <h1 class="mt-1 text-2xl font-bold tracking-tight text-[#164238] sm:text-3xl">
                        User Management
                    </h1>

                    <p class="mt-1 max-w-2xl text-sm leading-6 text-[#6D817A]">
                        Manage Health Worker and Barangay Official staff accounts
                        for the Barangay Esperanza Health Center.
                    </p>

                </div>


                <a
                    href="{{ route('users.create') }}"
                    class="inline-flex min-h-11 items-center justify-center gap-2 rounded-xl bg-[#0F4C3A] px-5 py-2.5 text-sm font-bold text-white shadow-sm transition hover:bg-[#0c3d2f] focus:outline-none focus:ring-2 focus:ring-[#0F4C3A] focus:ring-offset-2"
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
                            d="M12 4v16m8-8H4"
                        />
                    </svg>

                    Add Staff Account

                </a>

            </div>


            {{-- =================================================
                 SUMMARY / KPI CARDS
            ================================================== --}}
            <div class="mb-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">

                {{-- Total Staff --}}
                <div class="clay-summary-card p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-semibold text-[#6D817A]">
                                Total Staff
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">
                                {{ $totalStaff }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                Managed staff accounts
                            </p>

                        </div>

                        <div class="clay-summary-icon total">

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
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Health Workers --}}
                <div class="clay-summary-card p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-semibold text-[#6D817A]">
                                Health Workers
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">
                                {{ $healthWorkers }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                Health center personnel
                            </p>

                        </div>

                        <div class="clay-summary-icon health">

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
                                    d="M19 14.15V19a2 2 0 01-2 2H7a2 2 0 01-2-2v-4.85M9 11V7a3 3 0 016 0v4M12 11v4m-2-2h4"
                                />
                            </svg>

                        </div>

                    </div>

                </div>


                {{-- Officials --}}
                <div class="clay-summary-card p-5">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-semibold text-[#6D817A]">
                                Barangay Officials
                            </p>

                            <p class="mt-2 text-3xl font-bold tracking-tight text-[#164238]">
                                {{ $officials }}
                            </p>

                            <p class="mt-1 text-xs font-medium text-[#9AA9A4]">
                                Barangay personnel
                            </p>

                        </div>

                        <div class="clay-summary-icon official">

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
                                    d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m7-10a4 4 0 100-8 4 4 0 000 8zm8-1v6m3-3h-6"
                                />
                            </svg>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =================================================
                 FILTER PANEL
            ================================================== --}}
            <div class="clay-filter-card mb-6 p-5 sm:p-6">

                <div class="clay-filter-header mb-5 flex items-center gap-3">

                    <div class="clay-filter-title-icon">

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
                                d="M3 4h18M6 10h12M10 16h4"
                            />
                        </svg>

                    </div>

                    <div>

                        <h2 class="text-base font-bold text-[#164238]">
                            Filter Staff Accounts
                        </h2>

                        <p class="mt-0.5 text-xs text-[#6D817A]">
                            Search and filter registered staff accounts.
                        </p>

                    </div>

                </div>


                <form
                    id="staff-filter-form"
                    method="GET"
                    action="{{ route('users.index') }}"
                    class="flex flex-col gap-4 sm:flex-row sm:items-end"
                >

                    {{-- Search --}}
                    <div class="min-w-0 flex-1">

                        <label
                            for="search"
                            class="mb-2 block text-sm font-semibold text-[#385C52]"
                        >
                            Search
                        </label>

                        <div class="relative">

                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-[#9AA9A4]"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                                    />
                                </svg>

                            </div>

                            <input
                                type="text"
                                id="search"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name or email..."
                                class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 outline-none transition placeholder:text-slate-400 focus:border-[#128C5A] focus:ring-2 focus:ring-[#128C5A]/20"
                            >

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="flex flex-wrap items-end gap-2">

                        <button
                            type="submit"
                            class="clay-filter-submit inline-flex min-h-10 items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-white transition"
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
                                    d="M21 21l-4.35-4.35m1.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>

                            Search

                        </button>

                        <details class="relative">
                            <summary class="clay-filter-submit flex min-h-10 cursor-pointer list-none items-center justify-center gap-2 rounded-xl px-5 py-2.5 text-sm font-bold text-white transition [&::-webkit-details-marker]:hidden">
                                Filter
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m6 9 6 6 6-6" />
                                </svg>
                            </summary>
                            <div class="absolute left-0 z-30 mt-2 w-64 space-y-4 rounded-xl border border-white/80 bg-[#F5FAF7] p-4 shadow-lg sm:left-auto sm:right-0">
                                <div>
                                    <label for="role" class="mb-2 block text-sm font-semibold text-[#385C52]">Role</label>
                                    <select id="role" name="role" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-[#128C5A] focus:ring-2 focus:ring-[#128C5A]/20">
                                        <option value="">All Roles</option>
                                        <option value="Health Worker" @selected(request('role') === 'Health Worker')>Health Worker</option>
                                        <option value="Official" @selected(request('role') === 'Official')>Official</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="status" class="mb-2 block text-sm font-semibold text-[#385C52]">Status</label>
                                    <select id="status" name="status" class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-800 outline-none transition focus:border-[#128C5A] focus:ring-2 focus:ring-[#128C5A]/20">
                                        <option value="">All Statuses</option>
                                        <option value="active" @selected(request('status') === 'active')>Active</option>
                                        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </details>

                    </div>

                </form>

            </div>


            {{-- =================================================
                 DESKTOP STAFF TABLE
            ================================================== --}}
            <div class="clay-table-card hidden overflow-hidden lg:block">

                {{-- Table Header --}}
                <div class="clay-table-heading px-6 py-5">

                    <div class="flex items-center justify-between gap-4">

                        <div class="flex items-center gap-3">

                            <div class="clay-table-heading-icon">

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
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>

                            </div>

                            <div>

                                <h2 class="text-lg font-bold text-[#164238]">
                                    Staff Accounts
                                </h2>

                                <p class="mt-1 text-sm text-[#6D817A]">
                                    Health Worker and Barangay Official accounts.
                                </p>

                            </div>

                        </div>

                        <span class="clay-account-count rounded-full px-3 py-1 text-xs font-bold">

                            {{ $users->total() }}
                            account{{ $users->total() === 1 ? '' : 's' }}

                        </span>

                    </div>

                </div>


                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-slate-200">

                        <thead>

                            <tr>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500"
                                >
                                    Staff
                                </th>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500"
                                >
                                    Role
                                </th>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500"
                                >
                                    Status
                                </th>

                                <th scope="col" class="px-6 py-3"><span class="sr-only">Actions</span></th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-200">

                            @forelse ($users as $user)

                                <tr>

                                    {{-- Staff --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        <div class="flex items-center gap-3">

                                            <div class="clay-staff-avatar">

                                                {{ strtoupper(substr($user->name, 0, 1)) }}

                                            </div>

                                            <div>

                                                <p class="text-sm font-bold text-[#164238]">
                                                    {{ $user->name }}
                                                </p>

                                                <p class="mt-0.5 text-xs text-[#6D817A]">
                                                    {{ $user->email }}
                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Role --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($user->role === 'Health Worker')

                                            <span class="clay-role-health inline-flex rounded-full px-3 py-1 text-xs font-bold">
                                                Health Worker
                                            </span>

                                        @else

                                            <span class="clay-role-official inline-flex rounded-full px-3 py-1 text-xs font-bold">
                                                Official
                                            </span>

                                        @endif

                                    </td>


                                    {{-- Status --}}
                                    <td class="whitespace-nowrap px-6 py-4">

                                        @if ($user->status === 'active')

                                            <span class="clay-status-active inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold">

                                                <span class="clay-status-dot-active h-1.5 w-1.5 rounded-full"></span>

                                                Active

                                            </span>

                                        @else

                                            <span class="clay-status-inactive inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold">

                                                <span class="clay-status-dot-inactive h-1.5 w-1.5 rounded-full"></span>

                                                Inactive

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Actions --}}
                                    <td class="px-6 py-4">

                                        <div class="relative flex items-center justify-end">
                                            <button
                                                type="button"
                                                class="clay-action-menu-trigger flex h-10 w-10 items-center justify-center rounded-full text-[#6D817A] transition hover:text-[#164238]"
                                                aria-label="More actions for {{ $user->name }}"
                                                aria-expanded="false"
                                                data-menu-trigger
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                                    <circle cx="10" cy="5" r="1.5"/>
                                                    <circle cx="10" cy="10" r="1.5"/>
                                                    <circle cx="10" cy="15" r="1.5"/>
                                                </svg>
                                            </button>

                                            <div class="clay-action-menu absolute right-0 top-full z-20 mt-2 hidden min-w-[180px] rounded-2xl border border-white/80 bg-[#F5FAF7] p-2 shadow-[0_12px_35px_rgba(107,134,124,0.18)]" data-menu-panel>
                                                <a href="{{ route('users.edit', $user) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0]" title="Edit staff account">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/></svg>
                                                    Edit
                                                </a>

                                                <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="toggle-status-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="button" class="toggle-status-button flex w-full items-center gap-2 rounded-xl px-3 py-2 text-left text-sm font-semibold text-[#164238] transition hover:bg-[#EDF5F0] {{ $user->status === 'active' ? 'text-[#B42323]' : 'text-[#168B70]' }}" data-user-name="{{ $user->name }}" data-action="{{ $user->status === 'active' ? 'deactivate' : 'activate' }}">
                                                        @if ($user->status === 'active')
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                            Deactivate
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                            Activate
                                                        @endif
                                                    </button>
                                                </form>

                                                <a href="{{ route('users.delete', $user) }}" class="flex items-center gap-2 rounded-xl px-3 py-2 text-sm font-semibold text-[#B42323] transition hover:bg-[#FDF1F1]" title="Delete staff account">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"/></svg>
                                                    Delete
                                                </a>
                                            </div>
                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="px-6 py-12 text-center"
                                    >

                                        <div class="mx-auto flex max-w-md flex-col items-center">

                                            <div class="clay-empty-icon flex h-14 w-14 items-center justify-center rounded-full">

                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="h-7 w-7"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                                    />
                                                </svg>

                                            </div>

                                            <h3 class="mt-4 text-base font-bold text-[#164238]">
                                                No staff accounts found
                                            </h3>

                                            <p class="mt-1 text-sm text-[#6D817A]">
                                                Try changing your search or filters.
                                            </p>

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- =================================================
                 MOBILE STAFF CARDS
            ================================================== --}}
            <div class="space-y-4 lg:hidden">

                @forelse ($users as $user)

                    <div class="clay-mobile-card p-5">

                        {{-- User Information --}}
                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="clay-staff-avatar h-11 w-11">

                                    {{ strtoupper(substr($user->name, 0, 1)) }}

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate text-sm font-bold text-[#164238]">
                                        {{ $user->name }}
                                    </p>

                                    <p class="mt-0.5 truncate text-xs text-[#6D817A]">
                                        {{ $user->email }}
                                    </p>

                                </div>

                            </div>


                            @if ($user->status === 'active')

                                <span class="clay-status-active shrink-0 rounded-full px-2.5 py-1 text-xs font-bold">
                                    Active
                                </span>

                            @else

                                <span class="clay-status-inactive shrink-0 rounded-full px-2.5 py-1 text-xs font-bold">
                                    Inactive
                                </span>

                            @endif

                        </div>


                        {{-- Divider --}}
                        <div class="my-4 border-t border-white/70"></div>


                        {{-- Role --}}
                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-[#9AA9A4]">
                                Role
                            </p>

                            @if ($user->role === 'Health Worker')

                                <span class="clay-role-health mt-1 inline-flex rounded-full px-3 py-1 text-xs font-bold">
                                    Health Worker
                                </span>

                            @else

                                <span class="clay-role-official mt-1 inline-flex rounded-full px-3 py-1 text-xs font-bold">
                                    Official
                                </span>

                            @endif

                        </div>


                        {{-- Actions --}}
                        <div class="mt-5">
                            @component('partials.record-actions', ['label' => 'More actions for '.$user->name])

                            <a
                                href="{{ route('users.edit', $user) }}"
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
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-7.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"
                                    />
                                </svg>

                                Edit

                            </a>


                            <form
                                method="POST"
                                action="{{ route('users.toggle-status', $user) }}"
                                class="toggle-status-form"
                            >

                                @csrf
                                @method('PATCH')

                                <button
                                    type="button"
                                    class="toggle-status-button {{ $user->status === 'active' ? 'record-action-danger' : '' }}"
                                    data-user-name="{{ $user->name }}"
                                    data-action="{{ $user->status === 'active' ? 'deactivate' : 'activate' }}"
                                >

                                    @if ($user->status === 'active')

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
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                                            />
                                        </svg>

                                        Deactivate

                                    @else

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
                                                d="M5 13l4 4L19 7"
                                            />
                                        </svg>

                                        Activate

                                    @endif

                                </button>

                            </form>


                            <a
                                href="{{ route('users.delete', $user) }}"
                                class="record-action-danger"
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
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-8 0h10"
                                    />
                                </svg>

                                Delete

                            </a>

                            @endcomponent
                        </div>

                    </div>

                @empty

                    <div class="clay-mobile-card px-5 py-12 text-center">

                        <div class="clay-empty-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-7 w-7"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-base font-bold text-[#164238]">
                            No staff accounts found
                        </h3>

                        <p class="mt-1 text-sm text-[#6D817A]">
                            Try changing your search or filters.
                        </p>

                    </div>

                @endforelse

            </div>


            {{-- =================================================
                 PAGINATION
            ================================================== --}}
            @if ($users->hasPages())

                <div class="mt-6">
                    {{ $users->links() }}
                </div>

            @endif


        </div>

    </main>


    {{-- =========================================================
         DEACTIVATE / ACTIVATE CONFIRMATION MODAL
    ========================================================== --}}
    <div
        id="statusConfirmModal"
        class="clay-confirm-overlay"
        aria-hidden="true"
    >

        <div
            class="clay-confirm-box"
            role="dialog"
            aria-modal="true"
            aria-labelledby="statusConfirmTitle"
            aria-describedby="statusConfirmMessage"
        >

            <div class="flex items-start gap-3">

                {{-- Confirmation Icon --}}
                <div class="clay-confirm-icon">

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
                            d="M12 9v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.52 20h14.96a2 2 0 001.73-3l-7.5-13a2 2 0 00-3.42 0z"
                        />
                    </svg>

                </div>


                {{-- Confirmation Text --}}
                <div class="min-w-0 flex-1">

                    <h2
                        id="statusConfirmTitle"
                        class="text-base font-bold text-[#164238]"
                    >
                        Confirm Account Status
                    </h2>

                    <p
                        id="statusConfirmMessage"
                        class="mt-1 text-sm leading-5 text-[#6D817A]"
                    >
                        Are you sure you want to change this account's status?
                    </p>

                </div>

            </div>


            {{-- Account --}}
            <div class="clay-confirm-account">

                <p class="text-xs font-semibold uppercase tracking-wide text-[#9AA9A4]">
                    Staff Account
                </p>

                <p
                    id="statusConfirmUser"
                    class="mt-1 truncate text-sm font-bold text-[#164238]"
                >
                    Staff Member
                </p>

            </div>


            {{-- Buttons --}}
            <div class="mt-5 flex items-center justify-end gap-2">

                <button
                    type="button"
                    id="statusConfirmCancel"
                    class="clay-confirm-cancel inline-flex min-h-10 items-center justify-center rounded-xl px-4 py-2 text-sm font-bold transition"
                >
                    Cancel
                </button>

                <button
                    type="button"
                    id="statusConfirmSubmit"
                    class="clay-confirm-danger inline-flex min-h-10 items-center justify-center rounded-xl px-4 py-2 text-sm font-bold transition"
                >
                    Deactivate
                </button>

            </div>

        </div>

    </div>


    {{-- =========================================================
         CONFIRMATION MODAL SCRIPT
    ========================================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const filterForm = document.getElementById('staff-filter-form');
            filterForm.querySelectorAll('select').forEach((select) => {
                select.addEventListener('change', () => filterForm.requestSubmit());
            });

            const modal =
                document.getElementById('statusConfirmModal');

            const cancelButton =
                document.getElementById('statusConfirmCancel');

            const submitButton =
                document.getElementById('statusConfirmSubmit');

            const confirmMessage =
                document.getElementById('statusConfirmMessage');

            const confirmUser =
                document.getElementById('statusConfirmUser');

            let selectedForm = null;


            function openStatusModal(button) {

                selectedForm =
                    button.closest('form');

                const userName =
                    button.dataset.userName ||
                    'this staff account';

                const action =
                    button.dataset.action ||
                    'deactivate';

                const isDeactivate =
                    action === 'deactivate';

                confirmUser.textContent =
                    userName;


                if (isDeactivate) {

                    document.getElementById(
                        'statusConfirmTitle'
                    ).textContent =
                        'Deactivate Staff Account';

                    confirmMessage.textContent =
                        'Are you sure you want to deactivate this staff account? The account will no longer be active.';

                    submitButton.textContent =
                        'Deactivate';

                    submitButton.classList.remove(
                        'clay-confirm-activate'
                    );

                    submitButton.classList.add(
                        'clay-confirm-danger'
                    );

                } else {

                    document.getElementById(
                        'statusConfirmTitle'
                    ).textContent =
                        'Activate Staff Account';

                    confirmMessage.textContent =
                        'Are you sure you want to activate this staff account? The account will become active again.';

                    submitButton.textContent =
                        'Activate';

                    submitButton.classList.remove(
                        'clay-confirm-danger'
                    );

                    submitButton.classList.add(
                        'clay-confirm-activate'
                    );

                }


                modal.classList.add(
                    'is-open'
                );

                modal.setAttribute(
                    'aria-hidden',
                    'false'
                );

                document.body.style.overflow =
                    'hidden';

                cancelButton.focus();
            }


            function closeStatusModal() {

                modal.classList.remove(
                    'is-open'
                );

                modal.setAttribute(
                    'aria-hidden',
                    'true'
                );

                document.body.style.overflow =
                    '';

                selectedForm =
                    null;

            }


            document
                .querySelectorAll('.toggle-status-button')
                .forEach(function (button) {

                    button.addEventListener(
                        'click',
                        function () {

                            openStatusModal(
                                button
                            );

                        }
                    );

                });



            cancelButton.addEventListener(
                'click',
                function () {

                    closeStatusModal();

                }
            );


            submitButton.addEventListener(
                'click',
                function () {

                    if (selectedForm) {

                        selectedForm.submit();

                    }

                }
            );


            modal.addEventListener(
                'click',
                function (event) {

                    if (
                        event.target === modal
                    ) {

                        closeStatusModal();

                    }

                }
            );


            document.addEventListener(
                'keydown',
                function (event) {

                    if (
                        event.key === 'Escape' &&
                        modal.classList.contains(
                            'is-open'
                        )
                    ) {

                        closeStatusModal();

                    }

                }
            );

        });
    </script>

</body>

</html>