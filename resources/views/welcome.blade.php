<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f6f5a">
    <meta name="description" content="Barangay Esperanza Health Center Records Management System — organized resident records, health services, inventory, reports, schedules, and community coordination.">

    <title>Barangay Esperanza Health Center | Digital Health Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js" defer></script>

    <style>
        :root {
            --brand: #168B70;
            --brand-dark: #0F6F5A;
            --brand-deep: #0F4C3A;
            --bg: #EEF5F1;
            --surface: #F8FCFA;
            --text: #164238;
            --muted: #6D817A;
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: 92px;
        }

        body {
            margin: 0;
            overflow-x: hidden;
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4 {
            font-family: 'Manrope', sans-serif;
            letter-spacing: -.025em;
        }

        .font-heading { font-family: 'Manrope', sans-serif; }

        a, button { -webkit-tap-highlight-color: transparent; }

        section[id] { scroll-margin-top: 92px; }

        .page-container {
            width: min(1160px, calc(100% - 44px));
            margin-inline: auto;
        }

        /* Header and buttons */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(248,252,250,.91);
            border-bottom: 1px solid rgba(22,89,69,.07);
            backdrop-filter: blur(16px);
        }

        .brand-logo {
            width: 43px;
            height: 43px;
            flex-shrink: 0;
            object-fit: cover;
            border-radius: 13px;
        }

        .nav-link {
            position: relative;
            color: #526D63;
            font-size: 14px;
            font-weight: 600;
            transition: color .2s ease;
        }

        .nav-link::after {
            position: absolute;
            right: 0;
            bottom: -8px;
            left: 0;
            height: 2px;
            content: '';
            background: var(--brand);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .2s ease;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--brand-dark);
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
        }

        .primary-button,
        .secondary-button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 20px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 700;
            transition:
                background .22s ease,
                color .22s ease,
                transform .22s ease,
                box-shadow .22s ease;
        }

        .primary-button {
            border: 1px solid transparent;
            background: var(--brand);
            color: white;
            box-shadow: 0 7px 17px rgba(22,139,112,.17);
        }

        .primary-button:hover {
            background: var(--brand-dark);
            transform: translateY(-2px);
            box-shadow: 0 11px 22px rgba(22,139,112,.22);
        }

        .secondary-button {
            border: 1px solid #C9DDD2;
            background: rgba(255,255,255,.8);
            color: var(--brand-dark);
        }

        .secondary-button:hover {
            border-color: var(--brand);
            background: white;
            transform: translateY(-2px);
        }

        /* Hero */
        .hero-section {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            padding: 40px 0 80px;
            background:
                radial-gradient(circle at 82% 28%, rgba(42,155,128,.12), transparent 30%),
                radial-gradient(circle at 5% 90%, rgba(22,139,112,.07), transparent 28%),
                linear-gradient(145deg, #F8FCFA, #EEF5F1);
        }

        .hero-section::before {
            position: absolute;
            z-index: -1;
            top: 55px;
            right: -150px;
            width: 400px;
            height: 400px;
            border: 1px solid rgba(22,139,112,.09);
            border-radius: 50%;
            content: '';
        }

        .hero-layout {
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            align-items: center;
            gap: 48px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 12px;
            border: 1px solid #D3E8DD;
            border-radius: 999px;
            background: rgba(255,255,255,.72);
            color: var(--brand-dark);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .07em;
        }

        .eyebrow-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #2A9B80;
            box-shadow: 0 0 0 4px rgba(42,155,128,.12);
        }

        .hero-title {
            max-width: 640px;
            margin: 22px 0 17px;
            color: var(--brand-deep);
            font-size: clamp(40px, 4.2vw, 54px);
            font-weight: 800;
            line-height: 1.12;
        }

        .hero-title span { color: var(--brand); }

        .hero-description {
            max-width: 520px;
            color: var(--muted);
            font-size: 16px;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 11px;
            margin-top: 27px;
        }

        .hero-note {
            display: flex;
            align-items: center;
            gap: 9px;
            margin-top: 23px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 600;
        }

        .hero-note svg {
            color: var(--brand);
            flex-shrink: 0;
        }

        .hero-visual {
            position: relative;
            min-width: 0;
        }

        .hero-animation-card {
            position: relative;
            display: flex;
            min-height: 420px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,.9);
            border-radius: 30px;
            background: radial-gradient(circle at 50% 45%, #FFF 0%, #F0F8F3 65%, #E2F1E8 100%);
            box-shadow:
                0 22px 55px rgba(15,76,58,.11),
                inset 0 2px 5px rgba(255,255,255,.8);
        }

        .hero-animation-card::before {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 85px;
            height: 85px;
            border: 1px solid rgba(22,139,112,.14);
            border-radius: 50%;
            content: '';
        }

        .hero-lottie {
            position: relative;
            z-index: 2;
            display: block;
            width: min(100%, 500px);
            height: 395px;
            margin: auto;
        }

        .hero-fallback {
            position: absolute;
            inset: 0;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 28px;
            background: radial-gradient(circle at 50% 45%, #FFFFFF 0%, #F0F8F3 68%, #E2F1E8 100%);
        }

        .hero-fallback-content {
            max-width: 280px;
            color: var(--brand);
            text-align: center;
        }

        .hero-fallback-content svg {
            width: 76px;
            height: 76px;
            margin: 0 auto 16px;
        }

        .hero-fallback-content strong {
            display: block;
            color: var(--brand-deep);
            font-size: 18px;
            font-weight: 800;
        }

        .hero-fallback-content p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        /* Floating system labels: each one fades in/out on its own timer
           and is placed at a random spot (set inline by JavaScript). */
        .floating-label {
            position: absolute;
            z-index: 3;
            display: flex;
            min-width: 190px;
            align-items: center;
            gap: 9px;
            padding: 11px 14px;
            border: 1px solid rgba(255,255,255,.95);
            border-radius: 15px;
            background: rgba(255,255,255,.95);
            box-shadow: 0 10px 24px rgba(15,76,58,.11);
            opacity: 0;
            transform: translateY(10px) scale(.92);
            pointer-events: none;
            transition:
                opacity .6s ease,
                transform .6s cubic-bezier(.22,.68,0,1.1);
            will-change: opacity, transform;
        }

        .floating-label.is-on {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .floating-label-icon {
            display: grid;
            width: 33px;
            height: 33px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 11px;
            background: #E5F4ED;
            color: var(--brand);
        }

        .floating-label strong {
            display: block;
            color: var(--text);
            font-size: 13px;
            font-weight: 800;
            line-height: 1.35;
        }

        .floating-label small {
            display: block;
            margin-top: 2px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.35;
        }

        /* Capability strip */
        .capability-strip {
            padding: 24px 0;
            border-block: 1px solid rgba(22,89,69,.06);
            background: #F8FCFA;
        }

        .capability-grid {
            display: grid;
            grid-template-columns: repeat(5,1fr);
            gap: 16px;
        }

        .capability-item {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: #527067;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .capability-icon {
            display: grid;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 10px;
            background: #E5F4ED;
            color: var(--brand);
        }

        /* Shared section typography */
        .section-space { padding: 88px 0; }

        .section-heading {
            max-width: 660px;
            margin: 0 auto 40px;
            text-align: center;
        }

        .section-kicker {
            display: inline-block;
            margin-bottom: 11px;
            color: var(--brand);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .section-title {
            margin: 0;
            color: var(--brand-deep);
            font-size: clamp(30px, 3.3vw, 40px);
            font-weight: 800;
            line-height: 1.2;
        }

        .section-description {
            margin: 14px auto 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        /* About */
        .about-section,
        .highlights-section,
        .community-section {
            background: #F8FCFA;
            padding-top: 35px;
        }

        .about-grid,
        .community-grid {
            display: grid;
            grid-template-columns: .95fr 1.05fr;
            align-items: center;
            gap: 55px;
        }

        .about-visual {
            position: relative;
            display: flex;
            min-height: 345px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #E2EEE7;
            border-radius: 27px;
            background: radial-gradient(circle at 50% 50%, #FFF, #EDF7F1 70%);
            box-shadow: 0 14px 33px rgba(15,76,58,.065);
        }

        .about-visual-inner {
            position: relative;
            width: 100%;
            padding: 32px;
            text-align: center;
        }

        /* Actual Barangay Esperanza logo */
        .about-emblem {
            display: flex;
            width: 155px;
            height: 155px;
            margin: 0 auto 24px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 3px solid #D5E9DC;
            border-radius: 50%;
            background: #FFFFFF;
            box-shadow:
                0 12px 28px rgba(15,76,58,.12),
                inset 0 2px 5px rgba(15,76,58,.04);
            animation: emblem-rotate 6s linear infinite;
        }

        @keyframes emblem-rotate {
            0% { transform: rotateY(0deg); }
            83.33% { transform: rotateY(180deg); }
            100% { transform: rotateY(180deg); }
        }

        .about-emblem img {
            display: block;
            width: 100%;
            height: 100%;
            padding: 2px;
            object-fit: contain;
            border-radius: 50%;
            animation: logo-counter-rotate 6s linear infinite;
        }

        @keyframes logo-counter-rotate {
            0% { transform: rotateY(0deg); }
            83.33% { transform: rotateY(-180deg); }
            100% { transform: rotateY(-180deg); }
        }

        .about-visual h3 {
            margin: 0;
            color: var(--brand-deep);
            font-size: 21px;
            font-weight: 800;
        }

        .about-visual p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 12px;
        }

        .about-copy h2,
        .community-copy h2 {
            margin: 0;
            color: var(--brand-deep);
            font-size: clamp(30px, 3.2vw, 39px);
            font-weight: 800;
            line-height: 1.22;
        }

        .about-copy > p,
        .community-copy > p {
            margin-top: 16px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.85;
        }

        .about-points {
            display: grid;
            gap: 14px;
            margin-top: 24px;
        }

        .about-point {
            display: flex;
            align-items: flex-start;
            gap: 11px;
        }

        .check-icon {
            display: grid;
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            place-items: center;
            border-radius: 50%;
            background: #E1F2E8;
            color: var(--brand);
        }

        .about-point strong {
            display: block;
            color: var(--text);
            font-size: 13px;
            font-weight: 800;
        }

        .about-point span {
            display: block;
            margin-top: 3px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.65;
        }

        /* Services */
        .services-section,
        .roles-section {
            background: var(--bg);
            padding-top: 35px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(4,1fr);
            gap: 17px;
        }

        .service-card {
            min-width: 0;
            padding: 24px 20px 25px;
            border: 1px solid #D5E8DC;
            border-radius: 21px;
            background: #F8FCFA;
            box-shadow: 0 7px 19px rgba(15,76,58,.04);
            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;
        }

        .service-card:hover {
            border-color: #B8DCC9;
            transform: translateY(-6px);
            box-shadow: 0 16px 30px rgba(15,76,58,.1);
        }

        .service-icon,
        .role-icon {
            display: grid;
            width: 48px;
            height: 48px;
            margin-bottom: 19px;
            place-items: center;
            border-radius: 15px;
            background: #E6F4EC;
            color: var(--brand);
            transition: transform .25s ease;
        }

        .service-card:hover .service-icon {
            transform: scale(1.06) rotate(-3deg);
        }

        .service-icon svg,
        .role-icon svg {
            width: 23px;
            height: 23px;
        }

        .service-card h3 {
            margin: 0;
            color: var(--brand-deep);
            font-size: 17px;
            font-weight: 800;
            line-height: 1.4;
        }

        .service-card p {
            margin: 9px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.75;
        }

        /* Mission callout */
        .mission-section {
            position: relative;
            overflow: hidden;
            padding: 67px 0;
            background: linear-gradient(115deg,#0F4C3A,#0F6F5A 60%,#168B70);
            color: white;
            padding-top: 35px;
        }

        .mission-section::before,
        .mission-section::after {
            position: absolute;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 50%;
            content: '';
            pointer-events: none;
        }

        .mission-section::before {
            top: -190px;
            right: -100px;
            width: 430px;
            height: 430px;
        }

        .mission-section::after {
            bottom: -260px;
            left: 15%;
            width: 400px;
            height: 400px;
        }

        .mission-content {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: 1fr auto;
            align-items: center;
            gap: 35px;
        }

        .mission-content h2 {
            max-width: 700px;
            margin: 0;
            color: white;
            font-size: clamp(30px,3.3vw,40px);
            font-weight: 800;
            line-height: 1.22;
        }

        .mission-content p {
            max-width: 650px;
            margin: 13px 0 0;
            color: rgba(255,255,255,.76);
            font-size: 14px;
            line-height: 1.8;
        }

        .mission-button {
            display: inline-flex;
            min-height: 45px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 0 20px;
            border-radius: 999px;
            background: #FFF;
            color: var(--brand-dark);
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
            transition: transform .2s ease, background .2s ease;
        }

        .mission-button:hover {
            background: #EAF6EF;
            transform: translateY(-2px);
        }

        /* Highlights and roles */
        .highlights-grid,
        .roles-grid {
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 19px;
            padding-top: 35px;
        }

        .highlight-card,
        .role-card {
            padding: 26px;
            border: 1px solid #E0EDE5;
            border-radius: 21px;
            background: linear-gradient(145deg,#FFF,#F5FAF7);
            box-shadow: 0 8px 20px rgba(15,76,58,.04);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .highlight-card:hover,
        .role-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 16px 30px rgba(15,76,58,.09);
        }

        .highlight-number {
            display: inline-grid;
            width: 34px;
            height: 34px;
            margin-bottom: 19px;
            place-items: center;
            border-radius: 11px;
            background: #E5F4ED;
            color: var(--brand);
            font-size: 12px;
            font-weight: 800;
        }

        .highlight-card h3,
        .role-card h3 {
            margin: 0;
            color: var(--brand-deep);
            font-size: 17px;
            font-weight: 800;
            line-height: 1.4;
        }

        .highlight-card p,
        .role-card p {
            margin: 9px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
        }

        .role-icon {
            width: 46px;
            height: 46px;
            margin-bottom: 17px;
        }

        /* Community Lottie */
        .community-grid { grid-template-columns: 1fr 1fr; }

        .community-animation-card {
            display: flex;
            min-height: 330px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border: 1px solid #E1EEE6;
            border-radius: 26px;
            background: radial-gradient(circle at 50% 50%,#FFF,#EAF5EE);
            box-shadow: 0 14px 32px rgba(15,76,58,.065);
        }

        .community-lottie {
            display: block;
            width: min(100%,420px);
            height: 320px;
        }

        .community-fallback {
            display: none;
            max-width: 240px;
            padding: 30px;
            color: var(--brand);
            text-align: center;
        }

        .community-fallback svg {
            width: 62px;
            height: 62px;
            margin: 0 auto 13px;
        }

        .community-fallback p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.7;
        }

        /* CTA and footer */
        .cta-section {
            padding: 72px 0;
            background: var(--bg);
        }

        .cta-card {
            position: relative;
            overflow: hidden;
            padding: 54px 28px;
            border: 1px solid #D5E9DC;
            border-radius: 27px;
            background:
                radial-gradient(circle at 90% 15%,rgba(42,155,128,.12),transparent 29%),
                linear-gradient(135deg,#F8FCFA,#E8F4EC);
            box-shadow: 0 13px 35px rgba(15,76,58,.06);
            text-align: center;
        }

        .cta-card h2 {
            max-width: 690px;
            margin: 0 auto;
            color: var(--brand-deep);
            font-size: clamp(30px,3.3vw,40px);
            font-weight: 800;
            line-height: 1.22;
        }

        .cta-card p {
            max-width: 560px;
            margin: 14px auto 23px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.8;
        }

        .site-footer {
            padding: 48px 0 22px;
            background: #0D3F32;
            color: rgba(255,255,255,.72);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 45px;
            padding-bottom: 34px;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 11px;
            margin-bottom: 14px;
        }

        .footer-brand img {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
        }

        .footer-brand strong {
            color: white;
            font-size: 13px;
            font-weight: 800;
        }

        .footer-description {
            max-width: 350px;
            color: rgba(255,255,255,.62);
            font-size: 12px;
            line-height: 1.8;
        }

        .footer-column h3 {
            margin: 0 0 14px;
            color: white;
            font-size: 13px;
            font-weight: 800;
        }

        .footer-links {
            display: grid;
            gap: 10px;
        }

        .footer-links a {
            width: fit-content;
            color: rgba(255,255,255,.65);
            font-size: 12px;
            transition: color .2s ease, transform .2s ease;
        }

        .footer-links a:hover {
            color: white;
            transform: translateX(3px);
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding-top: 19px;
            border-top: 1px solid rgba(255,255,255,.12);
            color: rgba(255,255,255,.5);
            font-size: 11px;
        }

        /* Reveal animations work when scrolling down and back up */
        [data-reveal] {
            opacity: 0;
            transform: translateY(27px);
            transition:
                opacity .65s cubic-bezier(.2,.65,.3,1),
                transform .65s cubic-bezier(.2,.65,.3,1);
            will-change: opacity, transform;
        }

        [data-reveal="left"] { transform: translateX(-32px); }
        [data-reveal="right"] { transform: translateX(32px); }
        [data-reveal="scale"] { transform: scale(.95); }

        [data-reveal].is-visible {
            opacity: 1;
            transform: translate(0,0) scale(1);
        }

        [data-delay="1"] { transition-delay: .08s; }
        [data-delay="2"] { transition-delay: .16s; }
        [data-delay="3"] { transition-delay: .24s; }
        [data-delay="4"] { transition-delay: .32s; }

        .hero-reveal {
            animation: hero-entrance .8s cubic-bezier(.2,.65,.3,1) both;
        }

        .hero-reveal.delay { animation-delay: .13s; }

        @keyframes hero-entrance {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes gentle-float {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        /* Mobile menu */
        .mobile-menu {
            display: none;
            padding: 10px 0 17px;
            border-top: 1px solid #E3EEE7;
        }

        .mobile-menu.open {
            display: block;
            animation: menu-appear .2s ease both;
        }

        .mobile-menu a:not(.primary-button) {
            display: block;
            padding: 10px 4px;
            color: #385C52;
            font-size: 14px;
            font-weight: 600;
        }

        .mobile-menu a:not(.primary-button):hover { color: var(--brand); }

        @keyframes menu-appear {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 1024px) {
            .hero-layout { gap: 28px; }
            .hero-animation-card { min-height: 370px; }
            .hero-lottie { height: 350px; }
            .services-grid { grid-template-columns: repeat(2,1fr); }

            .capability-grid {
                grid-template-columns: repeat(3,1fr);
                row-gap: 15px;
            }

            .about-grid,
            .community-grid { gap: 34px; }

            .floating-label {
                min-width: 175px;
            }
        }

        @media (max-width: 767px) {
            html { scroll-padding-top: 78px; }
            section[id] { scroll-margin-top: 78px; }

            .page-container { width: min(100% - 34px,560px); }

            .desktop-nav,
            .desktop-login { display: none !important; }

            .hero-section { padding: 53px 0 58px; }

            .hero-layout {
                grid-template-columns: 1fr;
                gap: 31px;
            }

            .hero-title { font-size: clamp(36px,8.5vw,46px); }
            .hero-description { font-size: 14px; }

            .hero-animation-card {
                min-height: 315px;
                border-radius: 23px;
            }

            .hero-lottie { height: 300px; }

            .floating-label {
                min-width: 0;
                max-width: 158px;
                gap: 7px;
                padding: 8px 9px;
                border-radius: 12px;
            }

            .floating-label-icon {
                width: 27px;
                height: 27px;
                border-radius: 9px;
            }

            .floating-label-icon svg {
                width: 15px;
                height: 15px;
            }

            .floating-label strong {
                font-size: 11px;
            }

            .floating-label small {
                font-size: 10px;
            }

            .capability-grid {
                grid-template-columns: repeat(2,1fr);
                gap: 14px 9px;
            }

            .capability-item {
                justify-content: flex-start;
                font-size: 11px;
                text-align: left;
            }

            .section-space { padding: 68px 0; }
            .section-heading { margin-bottom: 31px; }
            .section-title { font-size: clamp(28px,6.5vw,35px); }
            .section-description { font-size: 13px; }

            .about-grid,
            .community-grid {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .about-visual { min-height: 285px; }

            .about-emblem {
                width: 130px;
                height: 130px;
            }

            .about-copy h2,
            .community-copy h2 { font-size: 31px; }

            .about-copy > p,
            .community-copy > p { font-size: 13px; }

            .services-grid {
                grid-template-columns: repeat(2,1fr);
                gap: 11px;
            }

            .service-card {
                padding: 19px 15px;
                border-radius: 17px;
            }

            .service-icon {
                width: 42px;
                height: 42px;
                margin-bottom: 15px;
                border-radius: 12px;
            }

            .service-card h3 { font-size: 14px; }
            .service-card p { font-size: 12px; }

            .mission-section { padding: 53px 0; }

            .mission-content {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .mission-content h2 { font-size: 31px; }
            .mission-content p { font-size: 12px; }
            .mission-button { width: fit-content; }

            .highlights-grid,
            .roles-grid { grid-template-columns: 1fr; }

            .highlight-card,
            .role-card { padding: 22px; }

            .highlight-card h3,
            .role-card h3 { font-size: 16px; }

            .community-animation-card {
                min-height: 285px;
                border-radius: 22px;
            }

            .community-lottie { height: 275px; }

            .cta-section { padding: 58px 0; }

            .cta-card {
                padding: 42px 20px;
                border-radius: 23px;
            }

            .cta-card h2 { font-size: 31px; }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 30px 22px;
            }

            .footer-brand-column { grid-column: 1 / -1; }

            .footer-bottom {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }

        @media (max-width: 420px) {
            .services-grid { grid-template-columns: 1fr; }

            .hero-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .hero-actions a { width: 100%; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-brand-column { grid-column: auto; }

            .floating-label {
                max-width: 145px;
                padding: 7px 8px;
            }

            .floating-label strong { font-size: 10px; }
            .floating-label small { font-size: 9px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }

            [data-reveal] {
                opacity: 1 !important;
                transform: none !important;
            }

            .floating-label {
                transition: none !important;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="site-header">
        <div class="page-container">
            <div class="flex min-h-[74px] items-center justify-between gap-4">
                <a href="#home" class="flex min-w-0 items-center gap-3">
                    <img
                        src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                        alt="Barangay Esperanza Health Center Logo"
                        class="brand-logo"
                        onerror="this.style.display='none'"
                    >

                    <div class="min-w-0">
                        <span class="block truncate font-heading text-sm font-extrabold text-[#164238]">Barangay Esperanza</span>
                        <span class="block text-[11px] font-semibold tracking-wide text-[#6D817A]">HEALTH CENTER</span>
                    </div>
                </a>

                <nav class="desktop-nav hidden items-center gap-7 md:flex" aria-label="Main navigation">
                    <a href="#home" class="nav-link active">Home</a>
                    <a href="#about" class="nav-link">About</a>
                    <a href="#services" class="nav-link">Services</a>
                    <a href="#highlights" class="nav-link">Features</a>
                    <a href="#roles" class="nav-link">Access</a>
                    <a href="#contact" class="nav-link">Contact</a>
                </nav>

                <div class="desktop-login hidden md:block">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="primary-button">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="primary-button">Sign In</a>
                        @endauth
                    @endif
                </div>

                <button
                    type="button"
                    id="mobileMenuButton"
                    class="grid h-10 w-10 flex-shrink-0 place-items-center rounded-xl border border-[#D8E8DE] bg-white text-[#0F6F5A] md:hidden"
                    aria-label="Open navigation menu"
                    aria-expanded="false"
                    aria-controls="mobileMenu"
                >
                    <svg id="menuOpenIcon" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>

                    <svg id="menuCloseIcon" class="hidden" width="21" height="21" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                        <path d="m18 6-12 12M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav id="mobileMenu" class="mobile-menu md:hidden" aria-label="Mobile navigation">
                <a href="#home">Home</a>
                <a href="#about">About</a>
                <a href="#services">Services</a>
                <a href="#highlights">Features</a>
                <a href="#roles">Access</a>
                <a href="#contact">Contact</a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ route('dashboard') }}" class="mt-2 font-bold text-[#168B70]">Go to Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="primary-button mt-2">Sign In</a>
                    @endauth
                @endif
            </nav>
        </div>
    </header>

    <main>

        <!-- HERO -->
        <section id="home" class="hero-section">
            <div class="page-container">
                <div class="hero-layout">
                    <div>
                        <div class="eyebrow hero-reveal">
                            <span class="eyebrow-dot"></span>
                            DIGITAL HEALTH MANAGEMENT
                        </div>

                        <h1 class="hero-title hero-reveal delay">
                            Community Healthcare, <span>Organized Around People.</span>
                        </h1>

                        <p class="hero-description font-semibold text-[#168B70] hero-reveal delay">
                            Community health, organized digitally
                        </p>

                        <p class="hero-description hero-reveal delay">
                            Supporting Barangay Esperanza Health Center through organized resident information, health records, medical inventory, community schedules, and coordinated health services.
                        </p>

                        <div class="hero-actions hero-reveal delay">
                            <a href="#about" class="secondary-button">Explore the System</a>
                        </div>

                        <div class="hero-note hero-reveal delay">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                                <path d="m9 12 2 2 4-4"/>
                            </svg>

                            An organized digital workspace for authorized health center staff.
                        </div>
                    </div>

                    <div class="hero-visual hero-reveal delay">
                        <div class="hero-animation-card">
                            <div class="hero-fallback" id="heroLottieFallback" aria-hidden="true">
                                <div class="hero-fallback-content">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                                        <path d="M12 8v8M8 12h8"/>
                                    </svg>

                                    <strong>Barangay Health Center</strong>
                                    <p>Organized healthcare information for the Esperanza community.</p>
                                </div>
                            </div>

                            <lottie-player
                                id="heroLottie"
                                class="hero-lottie"
                                src="{{ asset('images/Call Center Support Lottie Animation.json') }}"
                                background="transparent"
                                speed="0.5"
                                loop
                                autoplay>
                            </lottie-player>
                        </div>

                        <!-- Floating labels: positions and text are set by JavaScript -->
                        <div class="floating-label" data-label-index="0" aria-hidden="true">
                            <div class="floating-label-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="10" cy="7" r="4"/>
                                    <path d="M20 8v6M23 11h-6"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Resident Records</strong>
                                <small>Resident information</small>
                            </div>
                        </div>

                        <div class="floating-label" data-label-index="1" aria-hidden="true">
                            <div class="floating-label-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 21h18M5 21V7l8-4v18M19 21V11l-6-4"/>
                                    <path d="M9 9v.01M9 13v.01M9 17v.01M15 13v.01M15 17v.01"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Household Management</strong>
                                <small>Household information</small>
                            </div>
                        </div>

                        <div class="floating-label" data-label-index="2" aria-hidden="true">
                            <div class="floating-label-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M8 3h8l4 4v14H4V3zM8 3v5h8V3M8 13h8M8 17h6"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Health Records</strong>
                                <small>Health information</small>
                            </div>
                        </div>

                        <div class="floating-label" data-label-index="3" aria-hidden="true">
                            <div class="floating-label-icon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M12 7v10M7 12h10"/>
                                </svg>
                            </div>
                            <div>
                                <strong>Child Health</strong>
                                <small>Child health records</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SYSTEM CAPABILITIES -->
        <section class="capability-strip" aria-label="System capabilities">
            <div class="page-container">
                <div class="capability-grid">
                    <div class="capability-item"><span class="capability-icon">♧</span>Residents &amp; Households</div>
                    <div class="capability-item"><span class="capability-icon">▤</span>Health Records</div>
                    <div class="capability-item"><span class="capability-icon">✚</span>Child Health &amp; Immunization</div>
                    <div class="capability-item"><span class="capability-icon">▥</span>Medical Inventory</div>
                    <div class="capability-item"><span class="capability-icon">⌁</span>Analytics &amp; Reports</div>
                </div>
            </div>
        </section>

        <!-- ABOUT -->
        <section id="about" class="about-section section-space">
            <div class="page-container">
                <div class="about-grid">
                    <div class="about-visual" data-reveal="left">
                        <div class="about-visual-inner">
                            <div class="about-emblem">
                                <img
                                    src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                                    alt="Official Barangay Esperanza Health Center Logo"
                                    loading="lazy"
                                >
                            </div>

                            <h3>Barangay Esperanza</h3>
                            <p>Health Center Records Management System</p>
                        </div>
                    </div>

                    <div class="about-copy" data-reveal="right">
                        <span class="section-kicker">ABOUT THE SYSTEM</span>

                        <h2>Making Community Health Information More Organized</h2>

                        <p>
                            The Barangay Esperanza Health Center Records Management System is designed to support the organization of health center information and everyday administrative activities. It brings important records and system functions into one digital workspace for authorized personnel.
                        </p>

                        <div class="about-points">
                            <div class="about-point">
                                <div class="check-icon">✓</div>
                                <div>
                                    <strong>Organized Health Center Records</strong>
                                    <span>Manage resident, household, and health-related information in a structured system.</span>
                                </div>
                            </div>

                            <div class="about-point">
                                <div class="check-icon">✓</div>
                                <div>
                                    <strong>Administrative Coordination</strong>
                                    <span>Keep schedules, announcements, and relevant community information organized.</span>
                                </div>
                            </div>

                            <div class="about-point">
                                <div class="check-icon">✓</div>
                                <div>
                                    <strong>Reports and Data Insights</strong>
                                    <span>Provide organized information through reports and system analytics.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVICES -->
        <section id="services" class="services-section section-space">
            <div class="page-container">
                <div class="section-heading" data-reveal>
                    <span class="section-kicker">SYSTEM SERVICES</span>
                    <h2 class="section-title">The Tools to Support Community Healthcare</h2>
                    <p class="section-description">
                        Relevant records and administrative functions are organized into dedicated modules to support the health center's workflow.
                    </p>
                </div>

                <div class="services-grid">
                    <article class="service-card" data-reveal data-delay="1">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="10" cy="7" r="4"/>
                                <path d="M20 8v6m3-3h-6"/>
                            </svg>
                        </div>
                        <h3>Residents &amp; Households</h3>
                        <p>Maintain resident profiles and household information in an organized digital record system.</p>
                    </article>

                    <article class="service-card" data-reveal data-delay="2">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M8 3h8l4 4v14H4V3zM8 3v5h8V3M8 13h8M8 17h6"/>
                            </svg>
                        </div>
                        <h3>Health Records</h3>
                        <p>Keep relevant resident health information organized and accessible to authorized personnel.</p>
                    </article>

                    <article class="service-card" data-reveal data-delay="3">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v10M7 12h10"/>
                            </svg>
                        </div>
                        <h3>Child Health &amp; Immunization</h3>
                        <p>Organize child health information and immunization records within their designated system modules.</p>
                    </article>

                    <article class="service-card" data-reveal data-delay="4">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M4 7h16M4 12h16M4 17h16M8 3v18"/>
                            </svg>
                        </div>
                        <h3>Medical Inventory</h3>
                        <p>Organize medical supply information and monitor inventory records and relevant expiry notifications.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- DARK MISSION CALLOUT -->
        <section class="mission-section">
            <div class="page-container">
                <div class="mission-content" data-reveal>
                    <div>
                        <span class="mb-3 inline-block text-[11px] font-extrabold tracking-[.15em] text-[#B5E5D0]">
                            ORGANIZED INFORMATION. BETTER COORDINATION.
                        </span>

                        <h2>Supporting a More Connected Barangay Health Center.</h2>

                        <p>
                            Bring records, inventory information, schedules, announcements, and reporting tools together in one organized digital environment.
                        </p>
                    </div>

                    <a href="#highlights" class="mission-button">Discover Features</a>
                </div>
            </div>
        </section>

        <!-- FEATURES -->
        <section id="highlights" class="highlights-section section-space">
            <div class="page-container">
                <div class="section-heading" data-reveal>
                    <span class="section-kicker">SYSTEM HIGHLIGHTS</span>
                    <h2 class="section-title">More Than Just Digital Record Keeping</h2>
                    <p class="section-description">
                        Additional tools help authorized staff organize information, coordinate activities, and review health center data.
                    </p>
                </div>

                <div class="highlights-grid">
                    <article class="highlight-card" data-reveal data-delay="1">
                        <span class="highlight-number">01</span>
                        <h3>Analytics &amp; Reports</h3>
                        <p>Present relevant system information through dashboards, organized summaries, and report-generation features.</p>
                    </article>

                    <article class="highlight-card" data-reveal data-delay="2">
                        <span class="highlight-number">02</span>
                        <h3>Schedules &amp; Events</h3>
                        <p>Organize community schedules and health center events in a centralized calendar and event management area.</p>
                    </article>

                    <article class="highlight-card" data-reveal data-delay="3">
                        <span class="highlight-number">03</span>
                        <h3>Announcements &amp; Notifications</h3>
                        <p>Support information sharing and system notifications for relevant activities and updates.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- USER ROLES -->
        <section id="roles" class="roles-section section-space">
            <div class="page-container">
                <div class="section-heading" data-reveal>
                    <span class="section-kicker">AUTHORIZED SYSTEM ACCESS</span>
                    <h2 class="section-title">Designed Around Staff Responsibilities</h2>
                    <p class="section-description">
                        System access is organized according to assigned user roles and their permitted responsibilities.
                    </p>
                </div>

                <div class="roles-grid">
                    <article class="role-card" data-reveal data-delay="1">
                        <div class="role-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <circle cx="12" cy="12" r="10"/>
                                <path d="m12 6 1.7 3.8 4.1.4-3.1 2.8.9 4.1-3.6-2.1-3.6 2.1.9-4.1-3.1-2.8 4.1-.4z"/>
                            </svg>
                        </div>
                        <h3>System Administrator</h3>
                        <p>Oversees system administration, user access, and authorized management functions.</p>
                    </article>

                    <article class="role-card" data-reveal data-delay="2">
                        <div class="role-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="10" cy="7" r="4"/>
                                <path d="m16 11 2 2 4-4"/>
                            </svg>
                        </div>
                        <h3>Official</h3>
                        <p>Accesses assigned administrative information and relevant community coordination features.</p>
                    </article>

                    <article class="role-card" data-reveal data-delay="3">
                        <div class="role-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                                <path d="M12 8v8M8 12h8"/>
                            </svg>
                        </div>
                        <h3>Health Worker</h3>
                        <p>Works with assigned resident, health record, and health center management functions.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- COMMUNITY ANIMATION -->
        <section class="community-section section-space">
            <div class="page-container">
                <div class="community-grid">
                    <div class="community-copy" data-reveal="left">
                        <span class="section-kicker">COMMUNITY-FOCUSED MANAGEMENT</span>

                        <h2>Helping Health Center Staff Stay Organized and Connected.</h2>

                        <p>
                            From resident information to schedules and announcements, the system provides dedicated tools that support the administrative work of Barangay Esperanza Health Center.
                        </p>

                        <p>
                            Its goal is to make everyday information easier to organize, manage, and review through a centralized digital workspace.
                        </p>

                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="primary-button mt-5">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="primary-button mt-5">Sign In</a>
                            @endauth
                        @endif
                    </div>

                    <div class="community-animation-card" data-reveal="right">
                        <lottie-player
                            id="communityLottie"
                            class="community-lottie"
                            src="{{ asset('images/prueba - doctores-freepik.json') }}"
                            background="transparent"
                            speed="1"
                            loop
                            autoplay>
                        </lottie-player>

                        <div id="communityLottieFallback" class="community-fallback">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                <path d="M12 22s8-4 8-11V5l-8-3-8 3v6c0 7 8 11 8 11z"/>
                                <path d="M12 8v8M8 12h8"/>
                            </svg>
                            <p>Barangay Esperanza Health Center</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FINAL CTA -->
        <section id="contact" class="cta-section">
            <div class="page-container">
                <div class="cta-card" data-reveal>
                    <span class="section-kicker">BARANGAY ESPERANZA HEALTH CENTER</span>

                    <h2>A More Organized Digital Workspace for Community Healthcare.</h2>

                    <p>
                        Authorized health center personnel can access the system to manage assigned records, information, and administrative activities.
                    </p>

                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="primary-button">Go to Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="primary-button">Sign In</a>
                        @endauth
                    @endif
                </div>
            </div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer class="site-footer">
        <div class="page-container">
            <div class="footer-grid">
                <div class="footer-brand-column">
                    <div class="footer-brand">
                        <img
                            src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                            alt="Barangay Esperanza Health Center Logo"
                            onerror="this.style.display='none'"
                        >
                        <strong>Barangay Esperanza Health Center</strong>
                    </div>

                    <p class="footer-description">
                        A digital records management system designed to support organized health center information, administrative coordination, and community healthcare activities in Barangay Esperanza, Pilar, Sorsogon.
                    </p>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <div class="footer-links">
                        <a href="#home">Home</a>
                        <a href="#about">About the System</a>
                        <a href="#services">System Services</a>
                        <a href="#highlights">Features</a>
                        <a href="#roles">User Access</a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Staff Access</h3>
                    <div class="footer-links">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ route('dashboard') }}">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}">Sign In</a>
                            @endauth
                        @endif

                        <a href="#contact">Contact Information</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Barangay Esperanza Health Center. All rights reserved.</span>
                <span>Digital Health Management System</span>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Mobile navigation
            const menuButton = document.getElementById('mobileMenuButton');
            const mobileMenu = document.getElementById('mobileMenu');
            const menuOpenIcon = document.getElementById('menuOpenIcon');
            const menuCloseIcon = document.getElementById('menuCloseIcon');

            function closeMobileMenu() {
                if (!menuButton || !mobileMenu) return;

                mobileMenu.classList.remove('open');
                menuButton.setAttribute('aria-expanded', 'false');
                menuButton.setAttribute('aria-label', 'Open navigation menu');

                menuOpenIcon?.classList.remove('hidden');
                menuCloseIcon?.classList.add('hidden');
            }

            menuButton?.addEventListener('click', function () {
                const isOpen = mobileMenu.classList.toggle('open');

                menuButton.setAttribute('aria-expanded', String(isOpen));
                menuButton.setAttribute(
                    'aria-label',
                    isOpen ? 'Close navigation menu' : 'Open navigation menu'
                );

                menuOpenIcon?.classList.toggle('hidden', isOpen);
                menuCloseIcon?.classList.toggle('hidden', !isOpen);
            });

            mobileMenu?.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape') closeMobileMenu();
            });

            document.addEventListener('click', event => {
                if (
                    mobileMenu?.classList.contains('open') &&
                    !mobileMenu.contains(event.target) &&
                    !menuButton?.contains(event.target)
                ) {
                    closeMobileMenu();
                }
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 768) closeMobileMenu();
            });

            // Smooth anchor navigation with sticky-header offset
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', function (event) {
                    const targetId = this.getAttribute('href');

                    if (!targetId || targetId === '#') return;

                    const target = document.querySelector(targetId);

                    if (!target) return;

                    event.preventDefault();

                    const headerHeight =
                        document.querySelector('.site-header')?.offsetHeight || 0;

                    const targetTop =
                        target.getBoundingClientRect().top +
                        window.scrollY -
                        headerHeight -
                        10;

                    window.scrollTo({
                        top: targetTop,
                        behavior: window.matchMedia(
                            '(prefers-reduced-motion: reduce)'
                        ).matches ? 'auto' : 'smooth'
                    });

                    closeMobileMenu();
                });
            });

            // Reveal on entering and leaving the viewport
            const revealElements = document.querySelectorAll('[data-reveal]');

            const reduceMotion =
                window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (reduceMotion || !('IntersectionObserver' in window)) {
                revealElements.forEach(element => {
                    element.classList.add('is-visible');
                });
            } else {
                const revealObserver = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        entry.target.classList.toggle(
                            'is-visible',
                            entry.isIntersecting
                        );
                    });
                }, {
                    threshold: 0.12,
                    rootMargin: '0px 0px -7% 0px'
                });

                revealElements.forEach(element => {
                    revealObserver.observe(element);
                });
            }

            // Highlight the navigation link for the section currently in view
            const navLinks = document.querySelectorAll('.desktop-nav .nav-link');
            const navSections = document.querySelectorAll('main section[id]');

            if ('IntersectionObserver' in window) {
                const sectionObserver = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;

                        const id = entry.target.getAttribute('id');

                        navLinks.forEach(link => {
                            link.classList.toggle(
                                'active',
                                link.getAttribute('href') === '#' + id
                            );
                        });
                    });
                }, {
                    rootMargin: '-25% 0px -60% 0px',
                    threshold: 0
                });

                navSections.forEach(section => {
                    sectionObserver.observe(section);
                });
            }

            // ===== Floating system labels =====
            // Each label runs its own timer, so they never appear or disappear in sync.
            // Positions are picked from a varied pool (edges, middle and top/bottom),
            // not only the corners.

            const floatingLabels = Array.from(
                document.querySelectorAll('.hero-visual .floating-label')
            );

            const systemModules = [
                { title: 'Resident Records', description: 'Resident information' },
                { title: 'Household Management', description: 'Household information' },
                { title: 'Health Records', description: 'Health information' },
                { title: 'Child Health', description: 'Child health records' },
                { title: 'Immunization Records', description: 'Vaccination information' },
                { title: 'Medical Inventory', description: 'Medicine and supplies' },
                { title: 'Analytics & Reports', description: 'Data insights and reports' },
                { title: 'Schedules & Events', description: 'Community activities' },
                { title: 'Announcements', description: 'Updates and notifications' }
            ];

            // side: left / right / center, band: rough vertical position (0 = top, 100 = bottom)
            // Spots on the same side with a close band are not used together.
            const floatingSpots = [
                { top: '4%',    left: '-26px', side: 'left',   band: 8 },
                { top: '36%',   left: '-30px', side: 'left',   band: 40 },
                { bottom: '8%', left: '-26px', side: 'left',   band: 88 },
                { top: '2%',    right: '-26px', side: 'right', band: 8 },
                { top: '38%',   right: '-30px', side: 'right', band: 40 },
                { bottom: '10%', right: '-26px', side: 'right', band: 88 },
                { top: '-14px', left: '32%',  side: 'center', band: 0 },
                { bottom: '-14px', right: '30%', side: 'center', band: 100 }
            ];

            const POSITION_KEYS = ['top', 'right', 'bottom', 'left'];

            const reduceMotionPref =
                window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            // On narrow screens, keep labels inside the card instead of overflowing
            function edgeValue(value) {
                if (window.innerWidth >= 768) return value;
                if (!value.endsWith('px')) return value;
                return parseFloat(value) < 0 ? '6px' : value;
            }

            function randomBetween(min, max) {
                return min + Math.random() * (max - min);
            }

            const labelState = floatingLabels.map(() => ({
                spotIndex: null,
                moduleIndex: null,
                timers: []
            }));

            function getFreeSpot(labelIndex) {
                const takenSpots = labelState
                    .filter((_, i) => i !== labelIndex && labelState[i].spotIndex !== null)
                    .map(s => s.spotIndex);

                const candidates = floatingSpots
                    .map((_, idx) => idx)
                    .filter(idx => {
                        if (takenSpots.includes(idx)) return false;
                        const spot = floatingSpots[idx];

                        return takenSpots.every(t => {
                            const other = floatingSpots[t];
                            if (other.side !== spot.side) return true;
                            return Math.abs(other.band - spot.band) >= 25;
                        });
                    });

                const pool = candidates.length
                    ? candidates
                    : floatingSpots.map((_, i) => i).filter(i => !takenSpots.includes(i));

                return pool[Math.floor(Math.random() * pool.length)];
            }

            function getFreeModule(labelIndex) {
                const takenModules = labelState
                    .filter((_, i) => i !== labelIndex && labelState[i].moduleIndex !== null)
                    .map(s => s.moduleIndex);

                const pool = systemModules
                    .map((_, i) => i)
                    .filter(i => !takenModules.includes(i));

                return pool[Math.floor(Math.random() * pool.length)];
            }

            function applySpot(label, spot) {
                POSITION_KEYS.forEach(key => {
                    label.style[key] = 'auto';
                });

                POSITION_KEYS.forEach(key => {
                    if (spot[key] !== undefined) {
                        label.style[key] = edgeValue(spot[key]);
                    }
                });
            }

            function showLabel(i, animated = true) {
                const label = floatingLabels[i];
                const state = labelState[i];

                state.spotIndex = getFreeSpot(i);
                state.moduleIndex = getFreeModule(i);

                const module = systemModules[state.moduleIndex];
                const title = label.querySelector('strong');
                const description = label.querySelector('small');

                if (title) title.textContent = module.title;
                if (description) description.textContent = module.description;

                applySpot(label, floatingSpots[state.spotIndex]);

                // Force a reflow so the fade-in starts from the hidden state
                void label.offsetWidth;

                label.classList.add('is-on');

                if (animated) {
                    const stayFor = randomBetween(3200, 5600);
                    state.timers.push(window.setTimeout(() => hideLabel(i), stayFor));
                }
            }

            function hideLabel(i) {
                const label = floatingLabels[i];
                const state = labelState[i];

                label.classList.remove('is-on');

                state.timers.push(window.setTimeout(() => {
                    // Free the spot and module only after the fade-out finishes
                    state.spotIndex = null;
                    state.moduleIndex = null;

                    const waitFor = randomBetween(1800, 3800);
                    state.timers.push(window.setTimeout(() => showLabel(i), waitFor));
                }, 900));
            }

            if (reduceMotionPref) {
                // No movement for reduced-motion users: show the labels once, statically
                floatingLabels.forEach((_, i) => showLabel(i, false));
            } else if (floatingLabels.length) {
                floatingLabels.forEach((_, i) => {
                    // Start each label at a different random moment
                    const startDelay = randomBetween(400, 3200);
                    labelState[i].timers.push(window.setTimeout(() => showLabel(i), startDelay));
                });
            }

            // Hero Lottie fallback remains visible if the JSON/player fails
            const heroLottie = document.getElementById('heroLottie');
            const heroFallback = document.getElementById('heroLottieFallback');

            heroLottie?.addEventListener('ready', () => {
                if (heroFallback) heroFallback.style.display = 'none';
            });

            heroLottie?.addEventListener('error', () => {
                if (heroLottie) heroLottie.style.display = 'none';
                if (heroFallback) heroFallback.style.display = 'flex';
            });

            if (heroLottie && !customElements.get('lottie-player')) {
                heroLottie.style.display = 'none';

                if (heroFallback) {
                    heroFallback.style.display = 'flex';
                }
            }

            // Secondary Lottie fallback
            const communityLottie =
                document.getElementById('communityLottie');

            const communityFallback =
                document.getElementById('communityLottieFallback');

            communityLottie?.addEventListener('ready', () => {
                if (communityFallback) {
                    communityFallback.style.display = 'none';
                }
            });

            communityLottie?.addEventListener('error', () => {
                if (communityLottie) {
                    communityLottie.style.display = 'none';
                }

                if (communityFallback) {
                    communityFallback.style.display = 'block';
                }
            });
        });
    </script>
</body>
</html>