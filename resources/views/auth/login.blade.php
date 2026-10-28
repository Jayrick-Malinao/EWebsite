<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Barangay Esperanza Health Center</title>

    <meta
        name="description"
        content="Staff login portal for the Barangay Esperanza Health Center Records Management System."
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* =====================================================
               CLAYMORPHISM DESIGN TOKENS
            ====================================================== */

            --clay-bg: #eef5f1;
            --clay-surface: #f5faf7;
            --clay-surface-soft: #edf5f0;

            --clay-primary: #168b70;
            --clay-primary-dark: #0f6f5a;
            --clay-primary-light: #2a9b80;

            --clay-ink: #164238;
            --clay-muted: #6d817a;
            --clay-placeholder: #9aa9a4;

            --clay-danger: #dc2626;
            --clay-warning: #b7791f;

            --clay-white: rgba(255, 255, 255, .96);

            --clay-shadow-dark: rgba(107, 134, 124, .24);
            --clay-shadow-dark-soft: rgba(107, 134, 124, .15);
            --clay-shadow-light: rgba(255, 255, 255, .96);

            --clay-radius-xl: 30px;
            --clay-radius-lg: 24px;
            --clay-radius-md: 18px;
            --clay-radius-sm: 13px;
        }

        * {
            box-sizing: border-box;
        }

        html {
            min-height: 100%;
            background: var(--clay-bg);
        }

        body {
            margin: 0;

            min-height: 100vh;
            min-height: 100dvh;

            /*
             * Formal public-service / government website typography.
             * Kept intentionally simple and highly readable.
             */
            font-family:
                Arial,
                Helvetica,
                sans-serif;

            color: var(--clay-ink);

            background:
                radial-gradient(
                    circle at 12% 8%,
                    rgba(255, 255, 255, .90) 0,
                    rgba(255, 255, 255, .42) 20%,
                    transparent 43%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(22, 139, 112, .065) 0,
                    transparent 36%
                ),
                linear-gradient(
                    135deg,
                    #edf5f1 0%,
                    #f3f8f5 52%,
                    #eaf2ee 100%
                );

            overflow-x: hidden;
        }

        button,
        input {
            font: inherit;
        }

        button {
            border: 0;
        }

        /* =====================================================
           PAGE BACKGROUND
        ====================================================== */

        .cl-page {
            position: relative;

            min-height: 100vh;
            min-height: 100dvh;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 34px 22px;

            isolation: isolate;
        }

        .cl-page::before {
            content: "";

            position: fixed;
            z-index: -2;

            width: 500px;
            height: 500px;

            top: -275px;
            right: -170px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle at 35% 35%,
                    rgba(255, 255, 255, .90),
                    rgba(255, 255, 255, .25) 45%,
                    transparent 70%
                );

            pointer-events: none;
        }

        .cl-page::after {
            content: "";

            position: fixed;
            z-index: -2;

            width: 420px;
            height: 420px;

            left: -190px;
            bottom: -250px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(22, 139, 112, .075),
                    rgba(22, 139, 112, .018) 48%,
                    transparent 72%
                );

            pointer-events: none;
        }

        /* =====================================================
           MAIN SHELL
        ====================================================== */

        .cl-shell {
            width: min(100%, 1050px);

            display: grid;

            grid-template-columns:
                minmax(300px, .84fr)
                minmax(400px, 1.16fr);

            border-radius: var(--clay-radius-xl);

            background: var(--clay-surface);

            box-shadow:
                18px 18px 38px var(--clay-shadow-dark),
                -18px -18px 38px var(--clay-shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, .96);

            overflow: hidden;
        }

        /* =====================================================
           LEFT BRAND PANEL
        ====================================================== */

        .cl-brand-panel {
            position: relative;

            display: flex;
            flex-direction: column;

            min-height: 650px;

            padding: 43px 40px;

            background:
                linear-gradient(
                    145deg,
                    #eaf3ef 0%,
                    #f3f8f5 52%,
                    #e7f0ec 100%
                );

            border-right: 1px solid rgba(107, 134, 124, .06);

            overflow: hidden;
        }

        .cl-brand-panel::before {
            content: "";

            position: absolute;

            width: 330px;
            height: 330px;

            right: -175px;
            top: 110px;

            border-radius: 50%;

            border: 1px solid rgba(22, 139, 112, .065);

            box-shadow:
                0 0 0 35px rgba(22, 139, 112, .018),
                0 0 0 70px rgba(22, 139, 112, .012);

            pointer-events: none;
        }

        .cl-brand-panel::after {
            content: "+";

            position: absolute;

            right: 40px;
            bottom: 28px;

            font-size: 110px;
            line-height: 1;
            font-weight: 200;

            color: rgba(22, 139, 112, .035);

            pointer-events: none;
        }

        .cl-brand-inner {
            position: relative;
            z-index: 1;

            height: 100%;

            display: flex;
            flex-direction: column;
        }

        /* =====================================================
           BRAND HEADER
        ====================================================== */

        .cl-brand-row {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cl-logo {
            width: 54px;
            height: 54px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 18px;

            color: var(--clay-primary);

            background: var(--clay-surface);

            box-shadow:
                8px 8px 17px var(--clay-shadow-dark-soft),
                -8px -8px 17px var(--clay-shadow-light),
                inset 1px 1px 0 rgba(255, 255, 255, .92);
        }

        .cl-logo svg {
            width: 27px;
            height: 27px;
        }

        .cl-logo img {
            width: 42px;
            height: 42px;
            object-fit: contain;
        }

        .cl-mobile-brand .cl-logo svg {
            display: none;
        }

        .cl-brand-name {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .cl-brand-name strong {
            font-size: 15px;
            font-weight: 700;

            letter-spacing: .055em;

            color: var(--clay-ink);
        }

        .cl-brand-name span {
            font-size: 10px;
            font-weight: 700;

            letter-spacing: .15em;
            text-transform: uppercase;

            color: var(--clay-muted);
        }

        /* =====================================================
           BRAND HERO
        ====================================================== */

        .cl-hero-wrap {
            display: flex;
            align-items: center;

            flex: 1;

            padding: 35px 0;
        }

        .cl-hero {
            width: 100%;
            max-width: 500px;
        }

        .cl-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 8px 13px;

            border-radius: 999px;

            color: var(--clay-primary-dark);

            background: rgba(22, 139, 112, .055);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .08),
                inset -3px -3px 7px rgba(255, 255, 255, .94);
        }

        .cl-pill-dot {
            width: 7px;
            height: 7px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #63b79c;

            box-shadow:
                0 0 0 4px rgba(99, 183, 156, .10);
        }

        .cl-pill span {
            font-size: 10px;
            font-weight: 700;

            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .cl-hero h1 {
            max-width: 450px;

            margin: 18px 0 13px;

            font-size: clamp(32px, 3.3vw, 43px);
            line-height: 1.08;

            letter-spacing: -.025em;

            color: var(--clay-ink);
        }

        .cl-hero h1 span {
            color: var(--clay-primary);
        }

        .cl-hero-text {
            max-width: 445px;

            margin: 0;

            font-size: 13px;
            line-height: 1.7;

            color: var(--clay-muted);
        }

        /* =====================================================
           BRAND FEATURE CARDS
        ====================================================== */

        .cl-features {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 12px;

            margin-top: 25px;
        }

        .cl-feature {
            min-height: 112px;

            padding: 16px;

            border-radius: 18px;

            background:
                linear-gradient(
                    145deg,
                    rgba(248, 252, 250, .92),
                    rgba(237, 245, 241, .90)
                );

            box-shadow:
                8px 8px 17px rgba(107, 134, 124, .14),
                -8px -8px 17px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .82);
        }

        .cl-feature-icon {
            width: 36px;
            height: 36px;

            display: flex;
            align-items: center;
            justify-content: center;

            margin-bottom: 10px;

            border-radius: 12px;

            color: var(--clay-primary);

            background: var(--clay-surface);

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, .12),
                -5px -5px 10px rgba(255, 255, 255, .92),
                inset 1px 1px 0 rgba(255, 255, 255, .80);
        }

        .cl-feature-icon svg {
            width: 17px;
            height: 17px;
        }

        .cl-feature strong {
            display: block;

            margin-bottom: 4px;

            font-size: 12px;
            font-weight: 700;

            color: var(--clay-ink);
        }

        .cl-feature span {
            display: block;

            font-size: 10px;
            line-height: 1.5;

            color: var(--clay-muted);
        }

        /* =====================================================
           SYSTEM STATUS
        ====================================================== */

        .cl-system-status {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-top: 13px;

            padding: 10px 13px;

            border-radius: 14px;

            background: rgba(245, 250, 247, .72);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .07),
                inset -3px -3px 7px rgba(255, 255, 255, .88);
        }

        .cl-system-status-left {
            display: flex;
            align-items: center;
            gap: 8px;

            min-width: 0;
        }

        .cl-status-dot {
            width: 8px;
            height: 8px;

            flex-shrink: 0;

            border-radius: 50%;

            background: #5fc09e;

            box-shadow:
                0 0 0 4px rgba(95, 192, 158, .10);
        }

        .cl-system-status-label {
            font-size: 10px;
            font-weight: 700;

            color: var(--clay-muted);
        }

        .cl-system-status-value {
            font-size: 10px;
            font-weight: 700;

            white-space: nowrap;

            color: var(--clay-primary-dark);
        }

        /* =====================================================
           BRAND FOOTER
        ====================================================== */

        .cl-brand-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            padding-top: 16px;

            font-size: 9.5px;

            color: var(--clay-muted);
        }

        .cl-brand-foot strong {
            color: var(--clay-ink);
        }

        .cl-access-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;

            white-space: nowrap;
        }

        .cl-access-label svg {
            width: 13px;
            height: 13px;

            color: var(--clay-primary);
        }

        /* =====================================================
           LOGIN AREA
        ====================================================== */

        .cl-login-area {
            position: relative;

            display: flex;
            align-items: center;
            justify-content: center;

            padding: 38px;

            background: var(--clay-bg);

            overflow: hidden;
        }

        .cl-login-area::before {
            content: "+";

            position: absolute;

            top: 32px;
            right: 35px;

            width: 65px;
            height: 65px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 20px;

            font-size: 42px;
            font-weight: 200;

            color: rgba(22, 139, 112, .08);

            background: rgba(255, 255, 255, .24);

            box-shadow:
                8px 8px 17px rgba(107, 134, 124, .07),
                -8px -8px 17px rgba(255, 255, 255, .76),
                inset 1px 1px 0 rgba(255, 255, 255, .72);

            pointer-events: none;
        }

        .cl-login-area::after {
            content: "";

            position: absolute;

            width: 240px;
            height: 240px;

            right: -120px;
            bottom: -110px;

            border-radius: 50%;

            border: 1px solid rgba(22, 139, 112, .065);

            box-shadow:
                0 0 0 30px rgba(22, 139, 112, .018),
                0 0 0 60px rgba(22, 139, 112, .012);

            pointer-events: none;
        }

        .cl-login-wrap {
            position: relative;
            z-index: 2;

            width: 100%;
            max-width: 425px;
        }

        .cl-home-link {
            display: inline-flex;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(207, 229, 216, .9);
            border-radius: 11px;
            color: var(--clay-primary-dark);
            background: rgba(255, 255, 255, .72);
            box-shadow: 4px 4px 9px rgba(107, 134, 124, .10), -4px -4px 9px rgba(255, 255, 255, .82);
            text-decoration: none;
            transition: transform 180ms ease, background-color 180ms ease, box-shadow 180ms ease;
        }

        .cl-home-link:hover {
            transform: translateY(-1px);
            background: #fff;
            box-shadow: 5px 6px 12px rgba(107, 134, 124, .14), -5px -5px 10px rgba(255, 255, 255, .9);
        }

        .cl-portal-row {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .cl-home-link:focus-visible {
            outline: 2px solid var(--clay-primary);
            outline-offset: 3px;
        }

        .cl-home-link svg {
            width: 16px;
            height: 16px;
            flex: 0 0 16px;
        }

        /* =====================================================
           MOBILE BRAND
        ====================================================== */

        .cl-mobile-brand {
            display: none;
        }

        /* =====================================================
           LOGIN CARD
        ====================================================== */

        .cl-card {
            position: relative;

            padding: 29px 30px;

            border-radius: var(--clay-radius-lg);

            background:
                linear-gradient(
                    145deg,
                    #f8fcfa 0%,
                    #f1f7f4 100%
                );

            box-shadow:
                15px 15px 31px rgba(107, 134, 124, .21),
                -15px -15px 31px rgba(255, 255, 255, .96),
                inset 1px 1px 0 rgba(255, 255, 255, .94);

            overflow: hidden;
        }

        .cl-card::before {
            content: "";

            position: absolute;

            top: 0;
            left: 28px;
            right: 28px;

            height: 3px;

            border-radius: 0 0 9px 9px;

            background:
                linear-gradient(
                    90deg,
                    transparent,
                    rgba(22, 139, 112, .48),
                    transparent
                );
        }

        .cl-card::after {
            content: "";

            position: absolute;

            width: 150px;
            height: 150px;

            right: -100px;
            top: -100px;

            border-radius: 50%;

            background:
                radial-gradient(
                    circle,
                    rgba(255, 255, 255, .72),
                    transparent 68%
                );

            pointer-events: none;
        }

        /* =====================================================
           PORTAL
        ====================================================== */

        .cl-portal {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            padding: 7px 11px;

            border-radius: 11px;

            color: var(--clay-primary-dark);

            background: rgba(22, 139, 112, .055);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .075),
                inset -3px -3px 7px rgba(255, 255, 255, .90);
        }

        .cl-portal svg {
            width: 14px;
            height: 14px;
        }

        .cl-portal span {
            font-size: 10px;
            font-weight: 700;

            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .cl-card-head {
            margin-bottom: 20px;
        }

        .cl-welcome {
            margin: 0 0 5px;

            font-size: 12px;
            font-weight: 600;

            color: var(--clay-muted);
        }

        .cl-title {
            margin: 0;

            font-size: 26px;
            line-height: 1.15;

            letter-spacing: -.025em;

            color: var(--clay-ink);
        }

        .cl-desc {
            max-width: 360px;

            margin: 8px 0 0;

            font-size: 11.5px;
            line-height: 1.6;

            color: var(--clay-muted);
        }

        /* =====================================================
           ERROR SUMMARY
        ====================================================== */

        .cl-errors {
            margin-bottom: 16px;

            padding: 11px 12px;

            border-radius: 13px;

            color: #991b1b;

            background: rgba(254, 226, 226, .66);

            border: 1px solid rgba(220, 38, 38, .09);

            box-shadow:
                inset 3px 3px 7px rgba(127, 29, 29, .045),
                inset -3px -3px 7px rgba(255, 255, 255, .82);
        }

        .cl-errors-title {
            display: flex;
            align-items: center;
            gap: 7px;

            margin-bottom: 5px;

            font-size: 10px;
            font-weight: 700;
        }

        .cl-errors-title svg {
            width: 14px;
            height: 14px;
        }

        .cl-errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .cl-errors li {
            font-size: 9.5px;
            line-height: 1.5;
        }

        /* =====================================================
           FORM
        ====================================================== */

        .cl-form {
            display: flex;
            flex-direction: column;

            gap: 14px;
        }

        .cl-field {
            display: flex;
            flex-direction: column;

            gap: 7px;
        }

        .cl-label {
            display: flex;
            align-items: center;
            justify-content: space-between;

            font-size: 11px;
            font-weight: 700;

            color: var(--clay-ink);
        }

        .cl-required {
            color: var(--clay-primary);
        }

        /* =====================================================
           INPUTS
        ====================================================== */

        .cl-input-wrap {
            position: relative;
        }

        .cl-input-icon {
            position: absolute;

            left: 14px;
            top: 50%;

            width: 16px;
            height: 16px;

            transform: translateY(-50%);

            color: #8ba19a;

            pointer-events: none;
        }

        .cl-input {
            width: 100%;
            height: 46px;

            padding: 0 14px 0 40px;

            border: 0;
            outline: none;

            border-radius: 14px;

            font-size: 11.5px;

            color: var(--clay-ink);

            background:
                linear-gradient(
                    145deg,
                    #e9f1ed,
                    #f0f6f3
                );

            box-shadow:
                inset 5px 5px 10px rgba(107, 134, 124, .13),
                inset -5px -5px 10px rgba(255, 255, 255, .92);

            transition:
                box-shadow .18s ease,
                background .18s ease;
        }

        .cl-input::placeholder {
            color: var(--clay-placeholder);
        }

        .cl-input:focus {
            background: #edf5f1;

            box-shadow:
                inset 5px 5px 10px rgba(107, 134, 124, .14),
                inset -5px -5px 10px rgba(255, 255, 255, .95),
                0 0 0 3px rgba(22, 139, 112, .075);
        }

        .cl-input[aria-invalid="true"] {
            box-shadow:
                inset 5px 5px 10px rgba(107, 134, 124, .13),
                inset -5px -5px 10px rgba(255, 255, 255, .92),
                0 0 0 2px rgba(220, 38, 38, .10);
        }

        /* =====================================================
           FIELD ERRORS
        ====================================================== */

        .cl-field-error {
            margin: 0;

            font-size: 9.5px;
            line-height: 1.4;

            color: var(--clay-danger);
        }

        /* =====================================================
           CAPS LOCK
        ====================================================== */

        .cl-caps-warning {
            display: none;
            align-items: center;
            gap: 7px;

            margin-top: 2px;

            padding: 8px 10px;

            border-radius: 10px;

            font-size: 9.5px;
            font-weight: 600;

            color: #8a5a13;

            background: rgba(245, 158, 11, .065);

            box-shadow:
                inset 3px 3px 6px rgba(146, 92, 14, .045),
                inset -3px -3px 6px rgba(255, 255, 255, .86);
        }

        .cl-caps-warning.visible {
            display: flex;
        }

        .cl-caps-warning svg {
            width: 14px;
            height: 14px;

            flex-shrink: 0;
        }

        /* =====================================================
           OPTIONS
        ====================================================== */

        .cl-options {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 12px;

            margin-top: -1px;
        }

        .cl-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;

            cursor: pointer;

            font-size: 10px;
            font-weight: 600;

            color: var(--clay-muted);
        }

        .cl-check input {
            appearance: none;

            width: 17px;
            height: 17px;

            margin: 0;

            border-radius: 6px;

            background:
                linear-gradient(
                    145deg,
                    #e7efeb,
                    #f0f6f3
                );

            box-shadow:
                inset 3px 3px 6px rgba(107, 134, 124, .13),
                inset -3px -3px 6px rgba(255, 255, 255, .90);

            cursor: pointer;

            transition: all .15s ease;
        }

        .cl-check input:checked {
            background: var(--clay-primary);

            box-shadow:
                inset 2px 2px 5px rgba(0, 0, 0, .13),
                2px 2px 7px rgba(107, 134, 124, .11);
        }

        .cl-check input:checked::after {
            content: "✓";

            display: flex;
            align-items: center;
            justify-content: center;

            height: 100%;

            color: white;

            font-size: 10px;
            font-weight: 700;
        }

        /* =====================================================
           LOGIN BUTTON
        ====================================================== */

        .cl-button {
            position: relative;

            width: 100%;
            height: 48px;

            display: flex;
            align-items: center;
            justify-content: center;

            gap: 9px;

            margin-top: 2px;

            border-radius: 14px;

            color: #ffffff;

            background:
                linear-gradient(
                    145deg,
                    #1a9678 0%,
                    #168b70 52%,
                    #11765f 100%
                );

            font-size: 11.5px;
            font-weight: 700;

            letter-spacing: .025em;

            cursor: pointer;

            box-shadow:
                8px 8px 16px rgba(107, 134, 124, .20),
                -7px -7px 15px rgba(255, 255, 255, .78),
                inset 1px 1px 0 rgba(255, 255, 255, .25),
                inset -1px -1px 0 rgba(0, 0, 0, .05);

            transition:
                transform .16s ease,
                box-shadow .16s ease,
                filter .16s ease;
        }

        .cl-button:hover {
            transform: translateY(-1px);

            filter: brightness(1.035);

            box-shadow:
                10px 10px 19px rgba(107, 134, 124, .21),
                -8px -8px 16px rgba(255, 255, 255, .82),
                inset 1px 1px 0 rgba(255, 255, 255, .25);
        }

        .cl-button:active {
            transform: translateY(1px);

            box-shadow:
                inset 5px 5px 9px rgba(0, 0, 0, .14),
                inset -4px -4px 8px rgba(255, 255, 255, .10);
        }

        .cl-button:disabled {
            cursor: not-allowed;

            opacity: .72;

            transform: none;

            box-shadow:
                5px 5px 10px rgba(107, 134, 124, .13),
                -5px -5px 10px rgba(255, 255, 255, .72);
        }

        .cl-button svg {
            width: 16px;
            height: 16px;
        }

        .cl-button-spinner {
            display: none;

            width: 15px;
            height: 15px;

            border: 2px solid rgba(255, 255, 255, .35);
            border-top-color: #ffffff;

            border-radius: 50%;

            animation: cl-spin .7s linear infinite;
        }

        .cl-button.loading .cl-button-spinner {
            display: block;
        }

        .cl-button.loading .cl-button-icon {
            display: none;
        }

        @keyframes cl-spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* =====================================================
           ACCESS NOTICE
        ====================================================== */

        .cl-security {
            display: flex;
            align-items: flex-start;

            gap: 10px;

            margin-top: 16px;

            padding: 11px 12px;

            border-radius: 13px;

            background: rgba(22, 139, 112, .04);

            box-shadow:
                inset 3px 3px 7px rgba(107, 134, 124, .06),
                inset -3px -3px 7px rgba(255, 255, 255, .90);
        }

        .cl-security-icon {
            width: 27px;
            height: 27px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;

            border-radius: 9px;

            color: var(--clay-primary);

            background: var(--clay-surface);

            box-shadow:
                4px 4px 8px rgba(107, 134, 124, .10),
                -4px -4px 8px rgba(255, 255, 255, .90);
        }

        .cl-security-icon svg {
            width: 13px;
            height: 13px;
        }

        .cl-security p {
            margin: 0;

            font-size: 9.5px;
            line-height: 1.55;

            color: var(--clay-muted);
        }

        .cl-security strong {
            color: var(--clay-ink);
            font-weight: 700;
        }

        /* =====================================================
           FOOTER
        ====================================================== */

        .cl-footer {
            margin-top: 12px;

            text-align: center;

            font-size: 9.5px;

            color: var(--clay-muted);
        }

        .cl-footer strong {
            color: var(--clay-ink);
            font-weight: 700;
        }

        /* =====================================================
           RESPONSIVE
        ====================================================== */

        @media (max-width: 920px) {

            .cl-shell {
                grid-template-columns: 1fr;

                max-width: 560px;
            }

            .cl-brand-panel {
                display: none;
            }

            .cl-login-area {
                min-height: 650px;

                padding: 36px 28px;
            }

            .cl-mobile-brand {
                display: flex;

                align-items: center;
                justify-content: center;

                margin-bottom: 21px;
            }

            .cl-mobile-brand-inner {
                display: flex;
                align-items: center;

                gap: 12px;
            }

            .cl-mobile-brand .cl-logo {
                width: 46px;
                height: 46px;

                border-radius: 15px;
            }

            .cl-mobile-brand .cl-logo img {
                width: 38px;
                height: 38px;
            }

            .cl-mobile-brand .cl-brand-name strong {
                font-size: 14px;
            }

            .cl-login-wrap {
                max-width: 430px;
            }
        }

        @media (max-width: 560px) {

            .cl-page {
                align-items: flex-start;

                padding: 20px 14px;
            }

            .cl-shell {
                border-radius: 24px;
            }

            .cl-login-area {
                min-height: auto;

                padding: 27px 17px 24px;
            }

            .cl-login-area::before {
                top: 14px;
                right: -20px;

                transform: scale(.78);
            }

            .cl-card {
                padding: 25px 20px;

                border-radius: 20px;
            }

            .cl-card::before {
                left: 22px;
                right: 22px;
            }

            .cl-title {
                font-size: 24px;
            }

            .cl-desc {
                font-size: 11px;
            }

            .cl-system-status {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }
        }

        @media (max-width: 390px) {

            .cl-page {
                padding: 13px 9px;
            }

            .cl-login-area {
                padding: 22px 12px 20px;
            }

            .cl-card {
                padding: 22px 17px;
            }

            .cl-card::before {
                left: 19px;
                right: 19px;
            }

            .cl-title {
                font-size: 22px;
            }

            .cl-security {
                align-items: flex-start;
            }
        }

        /* =====================================================
           SHORT DESKTOP SCREENS
        ====================================================== */

        @media (min-width: 921px) and (max-height: 820px) {

            .cl-page {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .cl-brand-panel {
                min-height: 590px;

                padding: 31px 34px;
            }

            .cl-hero-wrap {
                padding: 23px 0;
            }

            .cl-hero h1 {
                font-size: 34px;
            }

            .cl-hero-text {
                margin-top: 10px;

                font-size: 12px;
            }

            .cl-features {
                margin-top: 17px;
            }

            .cl-feature {
                min-height: 94px;

                padding: 13px;
            }

            .cl-system-status {
                margin-top: 10px;
            }

            .cl-login-area {
                padding: 29px;
            }

            .cl-card {
                padding: 24px 26px;
            }

            .cl-card-head {
                margin-bottom: 16px;
            }

            .cl-title {
                font-size: 23px;
            }

            .cl-form {
                gap: 11px;
            }
        }

        /* =====================================================
           REDUCED MOTION
        ====================================================== */

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
</head>

<body>

    <main class="cl-page">

        <section class="cl-shell">

            <!-- =================================================
                 BRAND PANEL
            ================================================== -->

            <aside
                class="cl-brand-panel"
                aria-label="Barangay Esperanza Health Center"
            >

                <div class="cl-brand-inner">

                    <!-- Brand -->
                    <div class="cl-brand-row">

                        <div class="cl-logo" aria-hidden="true">

                            <img
                                src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                                alt="Barangay Esperanza Health Center logo"
                            >

                        </div>

                        <div class="cl-brand-name">
                            <strong>BARANGAY ESPERANZA</strong>
                            <span>Health Center</span>
                        </div>

                    </div>

                    <!-- Hero -->
                    <div class="cl-hero-wrap">

                        <div class="cl-hero">

                            <div class="cl-pill">
                                <span class="cl-pill-dot"></span>

                                <span>
                                    Health Records System
                                </span>
                            </div>

                            <h1>
                                Better records.<br>
                                <span>Better community care.</span>
                            </h1>

                            <p class="cl-hero-text">
                                A centralized workspace for managing
                                health records, community services,
                                schedules, and personnel activities
                                in Barangay Esperanza.
                            </p>

                            <!-- Features -->
                            <div class="cl-features">

                                <div class="cl-feature">

                                    <div class="cl-feature-icon">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path d="M4 5h16v14H4z"></path>
                                            <path d="M8 9h8"></path>
                                            <path d="M8 13h5"></path>
                                        </svg>

                                    </div>

                                    <strong>
                                        Organized Records
                                    </strong>

                                    <span>
                                        Centralized information for
                                        efficient service delivery.
                                    </span>

                                </div>

                                <div class="cl-feature">

                                    <div class="cl-feature-icon">

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <rect
                                                x="5"
                                                y="10"
                                                width="14"
                                                height="10"
                                                rx="2"
                                            ></rect>

                                            <path
                                                d="M8 10V7a4 4 0 0 1 8 0v3"
                                            ></path>
                                        </svg>

                                    </div>

                                    <strong>
                                        Controlled Access
                                    </strong>

                                    <span>
                                        Permissions are assigned according
                                        to each user's role.
                                    </span>

                                </div>

                            </div>

                            <!-- System Status -->
                            <div class="cl-system-status">

                                <div class="cl-system-status-left">

                                    <span class="cl-status-dot"></span>

                                    <span class="cl-system-status-label">
                                        Service Status
                                    </span>

                                </div>

                                <span class="cl-system-status-value">
                                    Operational
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Brand Footer -->
                    <div class="cl-brand-foot">

                        <span>
                            Barangay Esperanza · Pilar, Sorsogon
                        </span>

                        <span class="cl-access-label">

                            <svg
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <rect
                                    x="5"
                                    y="10"
                                    width="14"
                                    height="10"
                                    rx="2"
                                ></rect>

                                <path
                                    d="M8 10V7a4 4 0 0 1 8 0v3"
                                ></path>
                            </svg>

                            <strong>
                                Authorized Access
                            </strong>

                        </span>

                    </div>

                </div>

            </aside>


            <!-- =================================================
                 LOGIN AREA
            ================================================== -->

            <section class="cl-login-area">

                <div class="cl-login-wrap">

                    <!-- Mobile Brand -->
                    <div class="cl-mobile-brand">

                        <div class="cl-mobile-brand-inner">

                            <div class="cl-logo" aria-hidden="true">
                                <img
                                    src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                                    alt=""
                                >

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path d="M12 3v18"></path>
                                    <path d="M3 12h18"></path>
                                    <path d="M7.5 7.5c1.8-1.8 5.2-1.8 7 0"></path>
                                    <path d="M7.5 16.5c1.8 1.8 5.2 1.8 7 0"></path>
                                </svg>

                            </div>

                            <div class="cl-brand-name">

                                <strong>
                                    BARANGAY ESPERANZA
                                </strong>

                                <span>
                                    Health Center
                                </span>

                            </div>

                        </div>

                    </div>

                    <!-- Login Card -->
                    <div class="cl-card">

                        <div class="cl-card-head">

                            <div class="cl-portal-row">
                                <div class="cl-portal">

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <rect
                                            x="5"
                                            y="10"
                                            width="14"
                                            height="10"
                                            rx="2"
                                        ></rect>

                                        <path
                                            d="M8 10V7a4 4 0 0 1 8 0v3"
                                        ></path>
                                    </svg>

                                    <span>
                                        Staff Portal
                                    </span>

                                </div>

                                <a
                                    href="{{ route('home') }}"
                                    class="cl-home-link"
                                    aria-label="Back to landing page"
                                    title="Back to landing page"
                                >
                                    <svg
                                        aria-hidden="true"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.7"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M15.5 10h-11m0 0 4.5-4.5M4.5 10l4.5 4.5"></path>
                                    </svg>
                                </a>
                            </div>

                            <p class="cl-welcome">
                                Welcome back
                            </p>

                            <h2 class="cl-title">
                                Sign in to continue
                            </h2>

                            <p class="cl-desc">
                                Enter your assigned credentials to
                                access your workspace.
                            </p>

                        </div>


                        <!-- Validation Errors -->
                        @if ($errors->any())

                            <div
                                class="cl-errors"
                                role="alert"
                            >

                                <div class="cl-errors-title">

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <circle
                                            cx="12"
                                            cy="12"
                                            r="9"
                                        ></circle>

                                        <path d="M12 8v4"></path>

                                        <path d="M12 16h.01"></path>
                                    </svg>

                                    <span>
                                        Please review the following:
                                    </span>

                                </div>

                                <ul>

                                    @foreach (array_unique($errors->all()) as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif


                        <!-- Login Form -->
                        <form
                            id="loginForm"
                            class="cl-form"
                            method="POST"
                            action="{{ route('login.authenticate') }}"
                            novalidate
                        >

                            @csrf


                            <!-- Email -->
                            <div class="cl-field">

                                <label
                                    class="cl-label"
                                    for="email"
                                >
                                    <span>
                                        Email Address
                                        <span class="cl-required">*</span>
                                    </span>
                                </label>

                                <div class="cl-input-wrap">

                                    <svg
                                        class="cl-input-icon"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <rect
                                            x="3"
                                            y="5"
                                            width="18"
                                            height="14"
                                            rx="2"
                                        ></rect>

                                        <path d="m3 7 9 6 9-6"></path>
                                    </svg>

                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        required
                                        placeholder="Enter your email address"
                                        class="cl-input"
                                        aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                        aria-describedby="{{ $errors->has('email') ? 'email-error' : '' }}"
                                    >

                                </div>

                                @error('email')

                                    <p
                                        id="email-error"
                                        class="cl-field-error"
                                    >
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- Password -->
                            <div class="cl-field">

                                <label
                                    class="cl-label"
                                    for="password"
                                >
                                    <span>
                                        Password
                                        <span class="cl-required">*</span>
                                    </span>
                                </label>

                                <div class="cl-input-wrap">

                                    <svg
                                        class="cl-input-icon"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        aria-hidden="true"
                                    >
                                        <rect
                                            x="5"
                                            y="10"
                                            width="14"
                                            height="10"
                                            rx="2"
                                        ></rect>

                                        <path
                                            d="M8 10V7a4 4 0 0 1 8 0v3"
                                        ></path>
                                    </svg>

                                    <input
                                        id="password"
                                        name="password"
                                        type="password"
                                        autocomplete="current-password"
                                        required
                                        placeholder="Enter your password"
                                        class="cl-input"
                                        aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                        aria-describedby="{{ $errors->has('password') ? 'password-error' : '' }}"
                                    >

                                </div>


                                <!-- Caps Lock -->
                                <div
                                    id="capsLockWarning"
                                    class="cl-caps-warning"
                                    role="status"
                                    aria-live="polite"
                                >

                                    <svg
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    >
                                        <path d="M12 3v13"></path>
                                        <path d="m7 8 5-5 5 5"></path>
                                        <path d="M5 21h14"></path>
                                    </svg>

                                    <span>
                                        Caps Lock is turned on.
                                    </span>

                                </div>


                                @error('password')

                                    <p
                                        id="password-error"
                                        class="cl-field-error"
                                    >
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            <!-- Remember Me -->
                            <div class="cl-options">

                                <label class="cl-check">

                                    <input
                                        type="checkbox"
                                        name="remember"
                                        value="1"
                                        {{ old('remember') ? 'checked' : '' }}
                                    >

                                    <span>
                                        Remember me
                                    </span>

                                </label>

                            </div>


                            <!-- Login Button -->
                            <button
                                type="submit"
                                id="loginButton"
                                class="cl-button"
                            >

                                <svg
                                    class="cl-button-icon"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.9"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <path d="M10 17l5-5-5-5"></path>
                                    <path d="M15 12H3"></path>
                                    <path d="M21 19V5a2 2 0 0 0-2-2h-6"></path>
                                </svg>

                                <span id="loginButtonText">
                                    Sign In
                                </span>

                                <span
                                    class="cl-button-spinner"
                                    aria-hidden="true"
                                ></span>

                            </button>

                        </form>


                        <!-- Access Notice -->
                        <div class="cl-security">

                            <div class="cl-security-icon">

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <rect
                                        x="5"
                                        y="10"
                                        width="14"
                                        height="10"
                                        rx="2"
                                    ></rect>

                                    <path
                                        d="M8 10V7a4 4 0 0 1 8 0v3"
                                    ></path>
                                </svg>

                            </div>

                            <p>
                                <strong>
                                    Authorized personnel only.
                                </strong>

                                Access permissions are based on the
                                account's assigned role.
                            </p>

                        </div>

                    </div>


                    <!-- Footer -->
                    <div class="cl-footer">

                        &copy; {{ date('Y') }}

                        <strong>
                            Barangay Esperanza Health Center
                        </strong>

                        · Pilar, Sorsogon

                    </div>

                </div>

            </section>

        </section>

    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const emailInput =
                document.getElementById('email');

            const passwordInput =
                document.getElementById('password');

            const capsLockWarning =
                document.getElementById('capsLockWarning');

            const loginForm =
                document.getElementById('loginForm');

            const loginButton =
                document.getElementById('loginButton');

            const loginButtonText =
                document.getElementById('loginButtonText');


            /* =====================================================
               CAPS LOCK DETECTION
            ====================================================== */

            function updateCapsLock(event) {

                if (!capsLockWarning) {
                    return;
                }

                if (
                    event.getModifierState &&
                    event.getModifierState('CapsLock')
                ) {

                    capsLockWarning.classList.add(
                        'visible'
                    );

                } else {

                    capsLockWarning.classList.remove(
                        'visible'
                    );
                }
            }

            if (passwordInput) {

                passwordInput.addEventListener(
                    'keydown',
                    updateCapsLock
                );

                passwordInput.addEventListener(
                    'keyup',
                    updateCapsLock
                );

                passwordInput.addEventListener(
                    'focus',
                    updateCapsLock
                );

                passwordInput.addEventListener(
                    'blur',
                    function () {

                        if (capsLockWarning) {

                            capsLockWarning.classList.remove(
                                'visible'
                            );
                        }
                    }
                );
            }


            /* =====================================================
               DESKTOP AUTOFOCUS
            ====================================================== */

            if (
                emailInput &&
                window.innerWidth >= 921 &&
                !emailInput.value
            ) {

                window.setTimeout(
                    function () {

                        emailInput.focus();

                    },
                    150
                );
            }


            /* =====================================================
               DOUBLE SUBMIT PROTECTION
            ====================================================== */

            if (loginForm && loginButton) {

                loginForm.addEventListener(
                    'submit',
                    function () {

                        if (loginButton.disabled) {
                            return;
                        }

                        loginButton.disabled = true;

                        loginButton.classList.add(
                            'loading'
                        );

                        if (loginButtonText) {

                            loginButtonText.textContent =
                                'Signing in...';
                        }
                    }
                );
            }


            /* =====================================================
               BROWSER BACK / BFCACHE RESET
            ====================================================== */

            window.addEventListener(
                'pageshow',
                function () {

                    if (!loginButton) {
                        return;
                    }

                    loginButton.disabled = false;

                    loginButton.classList.remove(
                        'loading'
                    );

                    if (loginButtonText) {

                        loginButtonText.textContent =
                            'Sign In';
                    }
                }
            );

        });
    </script>

</body>

</html>
