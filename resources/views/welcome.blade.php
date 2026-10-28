
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0f6f5a">
    <meta name="description" content="Barangay Esperanza Health Center Records Management System: organized health records, medical inventory, schedules, analytics, reports, and notifications.">

    <title>Barangay Esperanza Health Center | Digital Health Management</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --green: #168b70;
            --green-dark: #0f6f5a;
            --green-deep: #0b4035;
            --green-light: #2fb393;
            --mint: #e8f5ee;
            --mint-soft: #f4faf6;
            --background: #f6faf7;
            --white: #ffffff;
            --text: #143c33;
            --muted: #62796f;
            --border: #e1ece5;
            --orange: #e87928;
            --orange-soft: #fff1e6;
            --radius-lg: 28px;
            --radius-md: 20px;
            --header-height: 84px;
            --scroll-offset: 100px;
            --clay-shadow:
                0 18px 36px rgba(15, 76, 58, .10),
                inset 0 -6px 0 rgba(15, 76, 58, .05),
                inset 0 4px 0 rgba(255, 255, 255, .9);
            --ease: cubic-bezier(.2, .7, .2, 1);
        }

        * { box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            scroll-padding-top: var(--scroll-offset);
            scroll-restoration: manual;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: "DM Sans", Arial, sans-serif;
            line-height: 1.65;
            overflow-x: hidden;
        }

        body.menu-open { overflow: hidden; }

        a { color: inherit; text-decoration: none; }
        button { font: inherit; }
        img, svg { max-width: 100%; }

        button:focus-visible,
        a:focus-visible {
            outline: 3px solid rgba(47, 179, 147, .6);
            outline-offset: 4px;
            border-radius: 8px;
        }

        /* Correct anchor positioning beneath the sticky header. */
        main section[id],
        main .hero[id] {
            scroll-margin-top: var(--scroll-offset);
        }

        .container {
            width: min(1180px, calc(100% - 48px));
            margin-inline: auto;
        }

        .section { padding: 112px 0; position: relative; }

        .section-head {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: end;
            gap: 40px;
            margin-bottom: 58px;
        }

        .section-head.centered {
            grid-template-columns: 1fr;
            max-width: 680px;
            margin-inline: auto;
            text-align: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
            padding: 7px 14px 7px 8px;
            border-radius: 100px;
            background: var(--white);
            box-shadow: 0 4px 12px rgba(15, 76, 58, .07);
            color: var(--green-dark);
            font-size: .72rem;
            font-weight: 800;
            letter-spacing: .12em;
            text-transform: uppercase;
        }

        .eyebrow-dot {
            display: grid;
            width: 22px;
            height: 22px;
            place-items: center;
            border-radius: 50%;
            background: var(--green);
            color: white;
        }

        .eyebrow-dot svg { width: 12px; height: 12px; }

        h1, h2, h3, h4 {
            font-family: "Manrope", Arial, sans-serif;
            letter-spacing: -.035em;
        }

        .section-head h2,
        .centered h2 {
            margin: 0;
            font-size: clamp(2rem, 3.8vw, 3.1rem);
            font-weight: 800;
            line-height: 1.12;
        }

        .section-head p {
            margin: 0;
            color: var(--muted);
            font-size: 1.02rem;
            line-height: 1.85;
        }

        .accent { color: var(--green); }

        /* Buttons */

        .btn {
            display: inline-flex;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 13px 24px;
            border: 0;
            border-radius: 18px;
            font-size: .93rem;
            font-weight: 700;
            cursor: pointer;
            transition: transform .25s var(--ease), box-shadow .25s var(--ease), background .25s;
            position: relative;
        }

        .btn svg {
            width: 18px;
            height: 18px;
            transition: transform .25s var(--ease);
        }

        .btn:hover { transform: translateY(-3px); }
        .btn:hover svg { transform: translateX(3px); }

        .btn-primary {
            background: linear-gradient(180deg, #1ea283, var(--green-dark));
            color: white;
            box-shadow:
                0 14px 26px rgba(22, 139, 112, .28),
                inset 0 -4px 0 rgba(0, 0, 0, .12),
                inset 0 2px 0 rgba(255, 255, 255, .25);
        }

        .btn-primary:hover {
            box-shadow: 0 20px 32px rgba(22, 139, 112, .34), inset 0 -4px 0 rgba(0, 0, 0, .12);
        }

        .btn-ghost {
            background: var(--white);
            color: var(--text);
            box-shadow: var(--clay-shadow);
        }

        .btn-light {
            background: var(--white);
            color: var(--green-dark);
            box-shadow: 0 14px 28px rgba(0, 0, 0, .14), inset 0 -4px 0 rgba(15, 76, 58, .08);
        }

        /* Header */

        .site-header {
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: background .3s, box-shadow .3s;
            background: rgba(246, 250, 247, .7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }

        .site-header.scrolled {
            background: rgba(255, 255, 255, .92);
            box-shadow: 0 10px 30px rgba(15, 76, 58, .08);
        }

        .navbar {
            display: flex;
            min-height: var(--header-height);
            align-items: center;
            justify-content: space-between;
            gap: 24px;
        }

        .brand {
            display: inline-flex;
            min-width: 0;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            display: grid;
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            place-items: center;
            overflow: hidden;
            border-radius: 16px;
            background: white;
            box-shadow: 0 6px 16px rgba(15, 76, 58, .10), inset 0 -3px 0 rgba(15, 76, 58, .05);
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-copy {
            display: flex;
            flex-direction: column;
            line-height: 1.3;
        }

        .brand-copy strong {
            font-family: "Manrope", Arial, sans-serif;
            font-size: .95rem;
            font-weight: 800;
        }

        .brand-copy span {
            margin-top: 2px;
            color: var(--muted);
            font-size: .72rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px;
            border-radius: 100px;
            background: rgba(255, 255, 255, .75);
            box-shadow: 0 6px 18px rgba(15, 76, 58, .06);
        }

        .nav-links a:not(.nav-cta) {
            padding: 9px 16px;
            border-radius: 100px;
            color: #49665d;
            font-size: .87rem;
            font-weight: 600;
            transition: background .2s, color .2s;
        }

        .nav-links a:not(.nav-cta):hover,
        .nav-links a:not(.nav-cta).active {
            background: var(--mint);
            color: var(--green-dark);
        }

        .nav-cta { display: none; }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .nav-actions .btn {
            min-height: 46px;
            padding: 11px 20px;
            font-size: .88rem;
        }

        .menu-toggle {
            display: none;
            width: 46px;
            height: 46px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 15px;
            background: white;
            color: var(--text);
            box-shadow: var(--clay-shadow);
            cursor: pointer;
        }

        .menu-toggle svg { width: 22px; height: 22px; }

        /* Hero */

        .hero {
            position: relative;
            padding: 70px 0 110px;
            overflow: hidden;
        }

        .hero-blob {
            position: absolute;
            z-index: 0;
            border-radius: 50%;
            filter: blur(70px);
            opacity: .55;
            animation: drift 14s ease-in-out infinite alternate;
            pointer-events: none;
        }

        .blob-a {
            top: -120px;
            left: -120px;
            width: 460px;
            height: 460px;
            background: #bfe8d4;
        }

        .blob-b {
            right: -160px;
            bottom: -180px;
            width: 520px;
            height: 520px;
            background: #cdeedd;
            animation-delay: -6s;
        }

        .blob-c {
            top: 30%;
            right: 28%;
            width: 180px;
            height: 180px;
            background: #ffe2c8;
            opacity: .45;
            animation-duration: 18s;
        }

        .hero-grid {
            position: relative;
            z-index: 1;
            display: grid;
            align-items: center;
            grid-template-columns: 1.02fr .98fr;
            gap: 64px;
        }

        .hero-copy > * {
            opacity: 0;
            transform: translateY(18px);
            animation: rise .8s var(--ease) forwards;
        }

        .hero-copy > :nth-child(1) { animation-delay: .05s; }
        .hero-copy > :nth-child(2) { animation-delay: .15s; }
        .hero-copy > :nth-child(3) { animation-delay: .25s; }
        .hero-copy > :nth-child(4) { animation-delay: .35s; }
        .hero-copy > :nth-child(5) { animation-delay: .45s; }

        .live-pill {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 16px 8px 9px;
            border-radius: 100px;
            background: var(--white);
            box-shadow: var(--clay-shadow);
            font-size: .78rem;
            font-weight: 700;
            color: var(--green-dark);
        }

        .live-pill .pulse {
            position: relative;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--green-light);
        }

        .live-pill .pulse::after {
            position: absolute;
            inset: -5px;
            border-radius: 50%;
            border: 2px solid var(--green-light);
            content: "";
            animation: ping 2s ease-out infinite;
        }

        .hero h1 {
            margin: 26px 0 22px;
            font-size: clamp(2.8rem, 5.4vw, 4.7rem);
            font-weight: 800;
            line-height: 1.04;
        }

        .hero h1 .swash {
            position: relative;
            white-space: nowrap;
            color: var(--green);
        }

        .hero h1 .swash::after {
            position: absolute;
            right: 0;
            bottom: .08em;
            left: 0;
            z-index: -1;
            height: .26em;
            border-radius: 8px;
            background: #ffd9bd;
            content: "";
            transform: rotate(-1deg);
        }

        .hero-desc {
            max-width: 540px;
            margin: 0;
            color: #5a7268;
            font-size: 1.08rem;
            line-height: 1.85;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 34px;
        }

        .hero-points {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 34px;
        }

        .hero-points span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 14px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .8);
            box-shadow: 0 4px 12px rgba(15, 76, 58, .05);
            color: #4f6b61;
            font-size: .8rem;
            font-weight: 600;
        }

        .hero-points svg {
            width: 16px;
            height: 16px;
            color: var(--green);
        }

        /* Hero visual: orbit */

        .orbit-stage {
            position: relative;
            aspect-ratio: 1 / 1;
            max-width: 560px;
            margin-left: auto;
            width: 100%;
            animation: rise 1s .2s var(--ease) both;
        }

        .orbit-ring {
            position: absolute;
            inset: 0;
            border: 1.5px dashed rgba(22, 139, 112, .25);
            border-radius: 50%;
            animation: spin 60s linear infinite;
        }

        .orbit-ring.inner {
            inset: 16%;
            border-style: solid;
            border-color: rgba(22, 139, 112, .12);
            animation-direction: reverse;
            animation-duration: 42s;
        }

        .orbit-core {
            position: absolute;
            top: 50%;
            left: 50%;
            display: grid;
            width: 176px;
            height: 176px;
            transform: translate(-50%, -50%);
            place-items: center;
            border-radius: 52px;
            background: linear-gradient(150deg, #2cb08f, #0f6f5a);
            box-shadow:
                0 30px 50px rgba(15, 111, 90, .30),
                inset 0 -8px 0 rgba(0, 0, 0, .12),
                inset 0 6px 0 rgba(255, 255, 255, .25);
            color: white;
            animation: bob 6s ease-in-out infinite;
        }

        .orbit-core svg { width: 80px; height: 80px; }

        .orbit-chip {
            position: absolute;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 16px 11px 11px;
            border-radius: 18px;
            background: var(--white);
            box-shadow: var(--clay-shadow);
            font-size: .82rem;
            font-weight: 700;
            white-space: nowrap;
            animation: bob 5s ease-in-out infinite;
        }

        .orbit-chip .chip-icon {
            display: grid;
            width: 34px;
            height: 34px;
            place-items: center;
            border-radius: 12px;
        }

        .orbit-chip .chip-icon svg { width: 18px; height: 18px; }

        .chip-green .chip-icon { background: #e6f5ec; color: var(--green); }
        .chip-orange .chip-icon { background: var(--orange-soft); color: var(--orange); }
        .chip-blue .chip-icon { background: #e9f1ff; color: #4d78c7; }
        .chip-purple .chip-icon { background: #f3edff; color: #8160bd; }

        .chip-1 { top: 2%; left: 10%; animation-delay: 0s; }
        .chip-2 { top: 26%; right: -2%; animation-delay: -1.5s; }
        .chip-3 { bottom: 20%; right: 4%; animation-delay: -3s; }
        .chip-4 { bottom: 4%; left: 2%; animation-delay: -2s; }

        .orbit-note {
            position: absolute;
            right: 0;
            bottom: -6px;
            left: 0;
            margin: 0;
            color: #8aa096;
            font-size: .7rem;
            text-align: center;
        }

        /* Marquee */

        .marquee {
            position: relative;
            z-index: 2;
            overflow: hidden;
            padding: 22px 0;
            background: var(--green-deep);
            color: #cfeee0;
            transform: rotate(-1.2deg) scale(1.02);
            margin: 10px 0 0;
        }

        .marquee-track {
            display: flex;
            width: max-content;
            gap: 46px;
            animation: marquee 32s linear infinite;
            font-family: "Manrope", Arial, sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            white-space: nowrap;
        }

        .marquee-track span::before {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 46px;
            border-radius: 50%;
            background: var(--orange);
            content: "";
            vertical-align: middle;
        }

        /* Modules */

        .modules-section { background: var(--background); }

        .bento {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .tile {
            position: relative;
            min-width: 0;
            padding: 32px;
            overflow: hidden;
            border-radius: var(--radius-lg);
            background: var(--white);
            box-shadow: var(--clay-shadow);
            transition: transform .35s var(--ease), box-shadow .35s var(--ease);
        }

        .tile:hover {
            transform: translateY(-6px);
            box-shadow: 0 28px 50px rgba(15, 76, 58, .14), inset 0 -6px 0 rgba(15, 76, 58, .05);
        }

        .tile-icon {
            display: grid;
            width: 58px;
            height: 58px;
            place-items: center;
            margin-bottom: 26px;
            border-radius: 20px;
            background: #e6f5ec;
            color: var(--green);
            box-shadow: inset 0 -4px 0 rgba(15, 76, 58, .07);
            transition: transform .4s var(--ease);
        }

        .tile:hover .tile-icon { transform: rotate(-6deg) scale(1.08); }
        .tile-icon svg { width: 27px; height: 27px; }

        .tile-orange .tile-icon { background: var(--orange-soft); color: var(--orange); }
        .tile-blue .tile-icon { background: #e9f1ff; color: #4d78c7; }
        .tile-purple .tile-icon { background: #f3edff; color: #8160bd; }
        .tile-teal .tile-icon { background: #e4f6f4; color: #258d84; }
        .tile-rose .tile-icon { background: #fdeef1; color: #c65c76; }

        .tile h3 {
            margin: 0 0 10px;
            font-size: 1.14rem;
            font-weight: 800;
        }

        .tile p {
            margin: 0;
            color: var(--muted);
            font-size: .93rem;
            line-height: 1.75;
        }

        .tile-wide {
            grid-column: span 2;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            align-items: center;
            background: linear-gradient(140deg, #ffffff 0%, #f2faf5 100%);
        }

        .tile-wide .tile-icon { margin-bottom: 18px; }

        .bars {
            display: flex;
            height: 150px;
            align-items: flex-end;
            gap: 10px;
            padding: 18px 16px 0;
            border-radius: 20px;
            background: var(--white);
            box-shadow: inset 0 -4px 0 rgba(15, 76, 58, .04);
        }

        .bars span {
            flex: 1;
            border-radius: 9px 9px 4px 4px;
            background: linear-gradient(180deg, #4cc2a4, var(--green));
            transform-origin: bottom;
            animation: grow 1.2s var(--ease) both;
        }

        .bars span:nth-child(odd) { background: linear-gradient(180deg, #ffb27a, var(--orange)); }
        .bars span:nth-child(1) { height: 40%; animation-delay: .1s; }
        .bars span:nth-child(2) { height: 62%; animation-delay: .2s; }
        .bars span:nth-child(3) { height: 48%; animation-delay: .3s; }
        .bars span:nth-child(4) { height: 80%; animation-delay: .4s; }
        .bars span:nth-child(5) { height: 66%; animation-delay: .5s; }
        .bars span:nth-child(6) { height: 92%; animation-delay: .6s; }

        .bars-caption {
            margin-top: 10px;
            color: #93a59b;
            font-size: .72rem;
            text-align: center;
        }

        .tile-tag {
            display: inline-block;
            margin-bottom: 12px;
            padding: 5px 11px;
            border-radius: 100px;
            background: var(--mint);
            color: var(--green-dark);
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        /* Workflow */

        .workflow-section {
            background: linear-gradient(180deg, #eef7f1 0%, #e6f3ec 100%);
            overflow: hidden;
        }

        .timeline {
            position: relative;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 26px;
        }

        .timeline::before {
            position: absolute;
            top: 33px;
            right: 12%;
            left: 12%;
            height: 4px;
            border-radius: 4px;
            background: rgba(22, 139, 112, .15);
            content: "";
        }

        .timeline-progress {
            position: absolute;
            top: 33px;
            left: 12%;
            height: 4px;
            width: 0;
            border-radius: 4px;
            background: linear-gradient(90deg, var(--green-light), var(--green));
            transition: width 1.8s var(--ease);
        }

        .timeline.is-visible .timeline-progress { width: 76%; }

        .step { position: relative; text-align: center; }

        .step-num {
            display: grid;
            width: 68px;
            height: 68px;
            place-items: center;
            margin: 0 auto 24px;
            border-radius: 22px;
            background: var(--white);
            color: var(--green);
            font-family: "Manrope", Arial, sans-serif;
            font-size: 1.2rem;
            font-weight: 800;
            box-shadow: var(--clay-shadow);
            transition: transform .35s var(--ease), background .35s, color .35s;
        }

        .step:hover .step-num {
            transform: translateY(-4px) scale(1.04);
            background: var(--green);
            color: white;
        }

        .step-card {
            padding: 24px 20px;
            border-radius: var(--radius-md);
            background: rgba(255, 255, 255, .7);
            box-shadow: 0 6px 18px rgba(15, 76, 58, .04);
        }

        .step h3 {
            margin: 0 0 8px;
            font-size: 1.05rem;
            font-weight: 800;
        }

        .step p {
            margin: 0;
            color: var(--muted);
            font-size: .88rem;
            line-height: 1.75;
        }

        /* Access */

        .access-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .access-card {
            padding: 34px 30px;
            border-radius: var(--radius-lg);
            background: var(--white);
            border: 1px solid var(--border);
            transition: border-color .3s, transform .35s var(--ease);
        }

        .access-card:hover {
            border-color: #b9dcca;
            transform: translateY(-5px);
        }

        .access-card .avatar {
            display: grid;
            width: 64px;
            height: 64px;
            place-items: center;
            margin-bottom: 24px;
            border-radius: 50%;
            font-family: "Manrope", Arial, sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            color: white;
            box-shadow: inset 0 -5px 0 rgba(0, 0, 0, .10);
        }

        .avatar-green { background: var(--green); }
        .avatar-orange { background: var(--orange); }
        .avatar-blue { background: #4d78c7; }

        .access-card h3 {
            margin: 0 0 10px;
            font-size: 1.15rem;
            font-weight: 800;
        }

        .access-card p {
            margin: 0;
            color: var(--muted);
            font-size: .92rem;
            line-height: 1.75;
        }

        /* About */

        .about-grid {
            display: grid;
            align-items: center;
            grid-template-columns: .9fr 1.1fr;
            gap: 80px;
        }

        .about-card {
            position: relative;
            padding: 46px 40px;
            border-radius: 36px;
            background: linear-gradient(160deg, #ffffff, #eef8f2);
            box-shadow: var(--clay-shadow);
        }

        .about-card .quote-mark {
            color: var(--orange);
            font-family: "Manrope", Arial, sans-serif;
            font-size: 4.5rem;
            font-weight: 800;
            line-height: .6;
        }

        .about-card blockquote {
            margin: 14px 0 0;
            font-family: "Manrope", Arial, sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.5;
            letter-spacing: -.02em;
        }

        .about-card .attrib {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 26px;
            color: var(--muted);
            font-size: .85rem;
        }

        .about-card .attrib strong { color: var(--text); }

        .about-copy h2 {
            margin: 0 0 20px;
            font-size: clamp(2rem, 3.4vw, 2.8rem);
            font-weight: 800;
            line-height: 1.15;
        }

        .about-copy > p {
            margin: 0 0 30px;
            color: var(--muted);
            font-size: 1.02rem;
            line-height: 1.85;
        }

        .check-list {
            display: grid;
            gap: 16px;
            margin: 0 0 36px;
            padding: 0;
            list-style: none;
        }

        .check-list li {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .check-list .tick {
            display: grid;
            flex-shrink: 0;
            width: 30px;
            height: 30px;
            place-items: center;
            border-radius: 11px;
            background: var(--mint);
            color: var(--green);
            box-shadow: inset 0 -3px 0 rgba(15, 76, 58, .07);
        }

        .check-list .tick svg { width: 16px; height: 16px; }

        .check-list strong {
            display: block;
            font-size: .96rem;
            font-weight: 800;
        }

        .check-list span {
            color: var(--muted);
            font-size: .88rem;
        }

        /* CTA */

        .cta-section { padding: 0 0 112px; }

        .cta-panel {
            position: relative;
            display: grid;
            grid-template-columns: 1.3fr auto;
            align-items: center;
            gap: 40px;
            padding: 64px 66px;
            overflow: hidden;
            border-radius: 40px;
            background:
                radial-gradient(circle at 92% 8%, rgba(255, 255, 255, .18), transparent 28%),
                radial-gradient(circle at 4% 100%, rgba(232, 121, 40, .28), transparent 30%),
                linear-gradient(125deg, #0b4035 0%, #0f6f5a 55%, #168b70 100%);
            box-shadow: 0 30px 60px rgba(11, 64, 53, .25);
            color: white;
        }

        .cta-panel h2 {
            margin: 18px 0 14px;
            font-size: clamp(2rem, 3.6vw, 2.9rem);
            font-weight: 800;
            line-height: 1.14;
        }

        .cta-panel p {
            max-width: 560px;
            margin: 0;
            color: rgba(255, 255, 255, .8);
            font-size: 1rem;
            line-height: 1.8;
        }

        .cta-panel .eyebrow {
            background: rgba(255, 255, 255, .12);
            color: #d5f3e5;
            box-shadow: none;
        }

        .cta-panel .eyebrow-dot { background: var(--orange); }

        .cta-action {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            min-width: 230px;
        }

        .cta-action small {
            color: rgba(255, 255, 255, .65);
            font-size: .75rem;
            text-align: center;
        }

        .cta-panel .blob {
            position: absolute;
            border-radius: 50%;
            border: 1px solid rgba(255, 255, 255, .12);
            pointer-events: none;
        }

        .cta-panel .blob-1 { top: -160px; right: 8%; width: 340px; height: 340px; }
        .cta-panel .blob-2 { bottom: -220px; right: -90px; width: 420px; height: 420px; }

        /* Footer */

        .site-footer {
            padding: 70px 0 28px;
            background: var(--white);
            border-top: 1px solid var(--border);
        }

        .footer-main {
            display: grid;
            grid-template-columns: 1.6fr 1fr 1fr;
            gap: 60px;
            padding-bottom: 46px;
        }

        .footer-brand p {
            max-width: 360px;
            margin: 20px 0 0;
            color: var(--muted);
            font-size: .9rem;
            line-height: 1.8;
        }

        .footer-heading {
            margin: 4px 0 18px;
            font-size: .9rem;
            font-weight: 800;
        }

        .footer-links { display: grid; gap: 12px; }

        .footer-links a {
            width: fit-content;
            color: var(--muted);
            font-size: .88rem;
            transition: color .2s, transform .2s var(--ease);
        }

        .footer-links a:hover {
            color: var(--green);
            transform: translateX(4px);
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
            color: #8a9d93;
            font-size: .8rem;
        }

        .footer-bottom p { margin: 0; }

        .footer-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-status span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--green-light);
            box-shadow: 0 0 0 4px rgba(47, 179, 147, .15);
        }

        /* Back to top */

        .back-to-top {
            position: fixed;
            z-index: 900;
            right: 24px;
            bottom: 24px;
            display: grid;
            width: 50px;
            height: 50px;
            place-items: center;
            border-radius: 18px;
            background: linear-gradient(180deg, #1ea283, var(--green-dark));
            color: white;
            box-shadow: 0 14px 26px rgba(15, 76, 58, .25), inset 0 -4px 0 rgba(0, 0, 0, .12);
            opacity: 0;
            visibility: hidden;
            transform: translateY(14px) scale(.9);
            transition: all .3s var(--ease);
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
            transform: none;
        }

        .back-to-top svg { width: 20px; height: 20px; }

        /* Reveal */

        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity .8s var(--ease), transform .8s var(--ease);
        }

        .reveal.is-visible {
            opacity: 1;
            transform: none;
        }

        .d1 { transition-delay: .08s; }
        .d2 { transition-delay: .16s; }
        .d3 { transition-delay: .24s; }

        /* Keyframes */

        @keyframes rise {
            to { opacity: 1; transform: none; }
        }

        @keyframes drift {
            from { translate: 0 0; }
            to { translate: 40px 30px; }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @keyframes bob {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -10px; }
        }

        @keyframes marquee {
            to { transform: translateX(-50%); }
        }

        @keyframes ping {
            0% { transform: scale(.6); opacity: 1; }
            100% { transform: scale(1.8); opacity: 0; }
        }

        @keyframes grow {
            from { transform: scaleY(.05); }
            to { transform: scaleY(1); }
        }

        /* Responsive */

        @media (min-width: 1000px) {
            .nav-links a.nav-cta { display: none; }
        }

        @media (max-width: 1050px) {
            .nav-links a:not(.nav-cta) { padding: 9px 11px; }
            .bento { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .tile-wide { grid-column: span 2; }
            .cta-panel { padding: 52px 44px; }
        }

        @media (max-width: 920px) {
            :root {
                --header-height: 76px;
                --scroll-offset: 92px;
            }

            .section { padding: 84px 0; }

            .menu-toggle { display: inline-flex; }

            .nav-links {
                position: fixed;
                top: calc(var(--header-height) + 8px);
                right: 16px;
                left: 16px;
                z-index: 1100;
                flex-direction: column;
                align-items: stretch;
                gap: 4px;
                max-height: calc(100dvh - var(--header-height) - 24px);
                overflow-x: hidden;
                overflow-y: auto;
                overscroll-behavior: contain;
                padding: 14px;
                border: 1px solid rgba(225, 236, 229, .9);
                border-radius: 26px;
                background: rgba(255, 255, 255, .98);
                box-shadow: 0 24px 50px rgba(15, 76, 58, .16);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transform: translateY(-10px) scale(.98);
                transform-origin: top center;
                transition: opacity .25s var(--ease), transform .25s var(--ease), visibility .25s;
            }

            .nav-links.open {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
                transform: none;
            }

            .nav-links a:not(.nav-cta) {
                display: block;
                padding: 14px 16px;
                border-radius: 14px;
            }

            .nav-links a.nav-cta {
                display: inline-flex;
                margin-top: 8px;
            }

            .nav-actions > .btn { display: none; }

            .hero { padding: 40px 0 90px; }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 60px;
            }

            .orbit-stage {
                max-width: 480px;
                margin-inline: auto;
            }

            .section-head {
                grid-template-columns: 1fr;
                gap: 18px;
                margin-bottom: 42px;
            }

            .about-grid {
                grid-template-columns: 1fr;
                gap: 50px;
            }

            .access-grid { grid-template-columns: 1fr; }

            .timeline {
                grid-template-columns: 1fr 1fr;
                row-gap: 40px;
            }

            .timeline::before,
            .timeline-progress { display: none; }

            .cta-panel {
                grid-template-columns: 1fr;
                padding: 46px 36px;
            }

            .cta-action {
                flex-direction: row;
                flex-wrap: wrap;
                min-width: 0;
                align-items: center;
            }

            .cta-action .btn { flex: 1 1 220px; }
            .cta-action small { width: 100%; }

            .footer-main {
                grid-template-columns: 1fr 1fr;
                gap: 40px 24px;
            }

            .footer-brand { grid-column: 1 / -1; }
        }

        @media (max-width: 640px) {
            :root {
                --header-height: 72px;
                --scroll-offset: 84px;
            }

            .container { width: min(100% - 32px, 1180px); }
            .section { padding: 68px 0; }

            .brand-copy strong { font-size: .8rem; max-width: 190px; }
            .brand-copy span { font-size: .64rem; }
            .brand-logo { width: 42px; height: 42px; border-radius: 14px; }

            .hero h1 { font-size: clamp(2.5rem, 11vw, 3.4rem); }
            .hero-desc { font-size: 1rem; }
            .hero-actions .btn { width: 100%; }

            .orbit-stage { aspect-ratio: auto; height: 380px; }
            .orbit-core { width: 130px; height: 130px; border-radius: 40px; }
            .orbit-core svg { width: 58px; height: 58px; }
            .orbit-chip { font-size: .7rem; padding: 8px 10px 8px 8px; gap: 7px; }
            .orbit-chip .chip-icon { width: 28px; height: 28px; border-radius: 10px; }
            .chip-1 { top: 0; left: 0; }
            .chip-2 { top: 22%; right: 0; }
            .chip-3 { bottom: 18%; right: 0; }
            .chip-4 { bottom: 0; left: 0; }

            .bento { grid-template-columns: 1fr; }
            .tile-wide { grid-column: auto; grid-template-columns: 1fr; }
            .tile { padding: 26px; }

            .timeline { grid-template-columns: 1fr; }

            .cta-panel { padding: 36px 26px; border-radius: 30px; }
            .about-card { padding: 34px 26px; }

            .footer-main { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; align-items: flex-start; }

            .back-to-top { right: 16px; bottom: 16px; width: 46px; height: 46px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }

            .reveal,
            .hero-copy > *,
            .orbit-stage {
                opacity: 1;
                transform: none;
            }

            .timeline.is-visible .timeline-progress { width: 76%; }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header class="site-header" id="siteHeader">
        <div class="container navbar">
            <a href="{{ route('home') }}" class="brand" aria-label="Barangay Esperanza Health Center home">
                <span class="brand-logo">
                    <img
                        src="{{ asset('images/esperanza-health-center-logo.jpg') }}"
                        alt="Barangay Esperanza Health Center logo"
                    >
                </span>
                <span class="brand-copy">
                    <strong>Barangay Esperanza</strong>
                    <span>Health Center Management System</span>
                </span>
            </a>

            <nav class="nav-links" id="navLinks" aria-label="Main navigation">
                <a href="#home">Home</a>
                <a href="#modules">Modules</a>
                <a href="#workflow">How It Works</a>
                <a href="#access">Access</a>
                <a href="#about">About</a>
                <a href="{{ route('login') }}" class="btn btn-primary nav-cta">Authorized Login</a>
            </nav>

            <div class="nav-actions">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    Sign In
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>

                <button type="button" class="menu-toggle" id="menuButton" aria-label="Open navigation menu" aria-controls="navLinks" aria-expanded="false">
                    <svg class="icon-open" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
                    <svg class="icon-close" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true" style="display:none"><path d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section class="hero" id="home">
            <div class="hero-blob blob-a"></div>
            <div class="hero-blob blob-b"></div>
            <div class="hero-blob blob-c"></div>

            <div class="container hero-grid">
                <div class="hero-copy">
                    <span class="live-pill">
                        <span class="pulse"></span>
                        Community health, organized digitally
                    </span>

                    <h1>
                        Better records for a <span class="swash">healthier</span> barangay.
                    </h1>

                    <p class="hero-desc">
                        One centralized system where authorized personnel of Barangay Esperanza
                        keep health information in order, track medical supplies, plan schedules,
                        and turn records into clear, useful reports.
                    </p>

                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            Access the System
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                        <a href="#modules" class="btn btn-ghost">Explore Modules</a>
                    </div>

                    <div class="hero-points">
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                            Role-based access
                        </span>
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                            Organized records
                        </span>
                        <span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                            Data-informed decisions
                        </span>
                    </div>
                </div>

                <!-- Illustrative visual: not live system data -->
                <div class="orbit-stage" aria-label="Illustration of connected health center modules">
                    <div class="orbit-ring"></div>
                    <div class="orbit-ring inner"></div>

                    <div class="orbit-core">
                        <svg viewBox="0 0 64 64" fill="none" stroke="white" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M32 57S8 45 8 24V11l24-7 24 7v13c0 21-24 33-24 33Z"/>
                            <path d="M32 17v25M19.5 29.5h25"/>
                        </svg>
                    </div>

                    <div class="orbit-chip chip-green chip-1">
                        <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="9" cy="8" r="4"/><path d="M3 21v-2a6 6 0 0 1 12 0v2"/></svg></span>
                        Resident records
                    </div>

                    <div class="orbit-chip chip-orange chip-2">
                        <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 3h12l3 6-9 12L3 9l3-6Z"/><path d="M3 9h18"/></svg></span>
                        Medical inventory
                    </div>

                    <div class="orbit-chip chip-blue chip-3">
                        <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18"/></svg></span>
                        Schedules
                    </div>

                    <div class="orbit-chip chip-purple chip-4">
                        <span class="chip-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M3 3v18h18"/><path d="m7 14 4-4 4 3 5-7"/></svg></span>
                        Analytics
                    </div>

                    <p class="orbit-note">Illustrative overview of system modules, not live records.</p>
                </div>
            </div>
        </section>

        <!-- Marquee -->
        <div class="marquee" aria-hidden="true">
            <div class="marquee-track">
                <span>Resident &amp; Household Records</span>
                <span>Medical Inventory</span>
                <span>Schedules &amp; Events</span>
                <span>Data Analytics</span>
                <span>Automated Reporting</span>
                <span>Notifications</span>
                <span>Resident &amp; Household Records</span>
                <span>Medical Inventory</span>
                <span>Schedules &amp; Events</span>
                <span>Data Analytics</span>
                <span>Automated Reporting</span>
                <span>Notifications</span>
            </div>
        </div>

        <!-- Modules -->
        <section class="section modules-section" id="modules">
            <div class="container">
                <div class="section-head reveal">
                    <div>
                        <span class="eyebrow"><span class="eyebrow-dot"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>System modules</span>
                        <h2>Everything in one place, <span class="accent">built around care.</span></h2>
                    </div>
                    <p>
                        Purpose-built tools help authorized health center personnel manage essential
                        records and everyday administrative work without juggling separate logbooks.
                    </p>
                </div>

                <div class="bento">
                    <article class="tile reveal">
                        <div class="tile-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><circle cx="9" cy="8" r="4"/><path d="M3 21v-2a6 6 0 0 1 12 0v2M17 8h4M19 6v4"/></svg></div>
                        <h3>Resident &amp; Household Records</h3>
                        <p>Organize resident profiles, household details, and contact information for faster retrieval.</p>
                    </article>

                    <article class="tile tile-orange reveal d1">
                        <div class="tile-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path d="M6 3h12l3 6-9 12L3 9l3-6Z"/><path d="M3 9h18M9 3l3 18M15 3l-3 18"/></svg></div>
                        <h3>Medical Inventory</h3>
                        <p>Monitor supplies, review stock details, and spot items approaching their expiration.</p>
                    </article>

                    <article class="tile tile-wide reveal">
                        <div>
                            <span class="tile-tag">Featured</span>
                            <div class="tile-icon tile-purple"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path d="M3 3v18h18"/><path d="M7 14v-3M12 14V6M17 14V9"/><path d="M6 18h12"/></svg></div>
                            <h3>Data Analytics</h3>
                            <p>Turn system data into visual summaries that help personnel understand records and monitor trends over time.</p>
                        </div>
                        <div>
                            <div class="bars" aria-hidden="true">
                                <span></span><span></span><span></span><span></span><span></span><span></span>
                            </div>
                            <div class="bars-caption">Illustrative trend view</div>
                        </div>
                    </article>

                    <article class="tile tile-blue reveal">
                        <div class="tile-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M16 3v4M8 3v4M3 10h18M8 14h3"/></svg></div>
                        <h3>Schedules &amp; Events</h3>
                        <p>Manage health center schedules and community events in one centralized calendar.</p>
                    </article>

                    <article class="tile tile-teal reveal d1">
                        <div class="tile-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/><path d="M14 2v6h6M8 13h8M8 17h8"/></svg></div>
                        <h3>Automated Reporting</h3>
                        <p>Compile organized information into reports, reducing the need to gather data by hand.</p>
                    </article>

                    <article class="tile tile-rose reveal d2">
                        <div class="tile-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/><path d="M10 21h4"/></svg></div>
                        <h3>Notifications</h3>
                        <p>Keep staff informed about schedules, announcements, and other supported notification events.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- Workflow -->
        <section class="section workflow-section" id="workflow">
            <div class="container">
                <div class="section-head centered reveal">
                    <span class="eyebrow"><span class="eyebrow-dot"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>A clearer workflow</span>
                    <h2>From records to <span class="accent">informed action.</span></h2>
                </div>

                <div class="timeline" id="timeline">
                    <div class="timeline-progress"></div>

                    <article class="step reveal">
                        <div class="step-num">01</div>
                        <div class="step-card">
                            <h3>Record</h3>
                            <p>Maintain resident, household, and other supported health center information in one system.</p>
                        </div>
                    </article>

                    <article class="step reveal d1">
                        <div class="step-num">02</div>
                        <div class="step-card">
                            <h3>Organize</h3>
                            <p>Manage schedules, inventory details, and announcements through the available modules.</p>
                        </div>
                    </article>

                    <article class="step reveal d2">
                        <div class="step-num">03</div>
                        <div class="step-card">
                            <h3>Review</h3>
                            <p>Use dashboards, analytics, and reports to review information and identify trends.</p>
                        </div>
                    </article>

                    <article class="step reveal d3">
                        <div class="step-num">04</div>
                        <div class="step-card">
                            <h3>Coordinate</h3>
                            <p>Use schedules and notifications to help staff stay informed about system activities.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>

        <!-- Access -->
        <section class="section" id="access">
            <div class="container">
                <div class="section-head reveal">
                    <div>
                        <span class="eyebrow"><span class="eyebrow-dot"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>Controlled access</span>
                        <h2>The right tools for <span class="accent">the right people.</span></h2>
                    </div>
                    <p>
                        Access is intended for authorized personnel. Each account sees the tools
                        and information assigned to its role, keeping sensitive records protected.
                    </p>
                </div>

                <div class="access-grid">
                    <article class="access-card reveal">
                        <div class="avatar avatar-green">HW</div>
                        <h3>Health workers</h3>
                        <p>Maintain resident health records, manage requests, and coordinate schedules and notifications.</p>
                    </article>

                    <article class="access-card reveal d1">
                        <div class="avatar avatar-orange">OF</div>
                        <h3>Officials</h3>
                        <p>Review dashboards, analytics, and reports to support informed administration and planning.</p>
                    </article>

                    <article class="access-card reveal d2">
                        <div class="avatar avatar-blue">AD</div>
                        <h3>Administrators</h3>
                        <p>Manage staff accounts and roles, and oversee system settings for the health center.</p>
                    </article>
                </div>
            </div>
        </section>

        <!-- About -->
        <section class="section" id="about" style="padding-top: 0;">
            <div class="container about-grid">
                <div class="about-card reveal">
                    <div class="quote-mark" aria-hidden="true">&ldquo;</div>
                    <blockquote>
                        Technology that supports community health administration, so staff can spend
                        less time searching for records and more time serving residents.
                    </blockquote>
                    <div class="attrib">
                        <span class="brand-logo" style="width:40px;height:40px;border-radius:13px;">
                            <img src="{{ asset('images/esperanza-health-center-logo.jpg') }}" alt="" style="width:100%;height:100%;object-fit:contain;">
                        </span>
                        <span><strong>Barangay Esperanza Health Center</strong><br>Pilar, Sorsogon</span>
                    </div>
                </div>

                <div class="about-copy reveal d1">
                    <span class="eyebrow"><span class="eyebrow-dot"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>About the platform</span>
                    <h2>Designed for the health center, <span class="accent">step by step.</span></h2>
                    <p>
                        The Barangay Esperanza Health Center Records Management System is built to
                        improve how authorized personnel organize information, coordinate tasks,
                        and access the reports they need.
                    </p>

                    <ul class="check-list">
                        <li>
                            <span class="tick"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>
                            <div>
                                <strong>Purpose-built for the health center</strong>
                                <span>Records, inventory, schedules, analytics, reporting, and notifications.</span>
                            </div>
                        </li>
                        <li>
                            <span class="tick"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>
                            <div>
                                <strong>Access based on assigned roles</strong>
                                <span>Permissions match each person's responsibilities.</span>
                            </div>
                        </li>
                        <li>
                            <span class="tick"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.6" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>
                            <div>
                                <strong>Built for informed administration</strong>
                                <span>Organized data and reporting support review and planning.</span>
                            </div>
                        </li>
                    </ul>

                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Continue to Secure Login
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                    </a>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-panel reveal">
                    <span class="blob blob-1"></span>
                    <span class="blob blob-2"></span>

                    <div>
                        <span class="eyebrow"><span class="eyebrow-dot"><svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg></span>Barangay Esperanza, Pilar, Sorsogon</span>
                        <h2>One organized system.<br>A clearer way to manage records.</h2>
                        <p>Sign in with your authorized account to open the health center management platform.</p>
                    </div>

                    <div class="cta-action">
                        <a href="{{ route('login') }}" class="btn btn-light">
                            Sign In to the System
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                        </a>
                        <small>For authorized system users only</small>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="container">
            <div class="footer-main">
                <div class="footer-brand">
                    <a href="{{ route('home') }}" class="brand">
                        <span class="brand-logo">
                            <img src="{{ asset('images/esperanza-health-center-logo.jpg') }}" alt="Barangay Esperanza Health Center logo">
                        </span>
                        <span class="brand-copy">
                            <strong>Barangay Esperanza</strong>
                            <span>Health Center Management System</span>
                        </span>
                    </a>
                    <p>
                        A digital records management platform supporting organized health center
                        administration in Barangay Esperanza, Pilar, Sorsogon.
                    </p>
                </div>

                <div>
                    <h3 class="footer-heading">Explore</h3>
                    <div class="footer-links">
                        <a href="#home">Home</a>
                        <a href="#modules">System Modules</a>
                        <a href="#workflow">How It Works</a>
                        <a href="#about">About the System</a>
                    </div>
                </div>

                <div>
                    <h3 class="footer-heading">System Access</h3>
                    <div class="footer-links">
                        <a href="{{ route('login') }}">Authorized Login</a>
                        <a href="#access">Role-Based Access</a>
                        <a href="#modules">Analytics &amp; Reports</a>
                        <a href="#modules">Schedules &amp; Inventory</a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; <span id="currentYear"></span> Barangay Esperanza Health Center. All rights reserved.</p>
                <span class="footer-status"><span></span>Digital health records management</span>
            </div>
        </div>
    </footer>

    <a href="#home" class="back-to-top" id="backToTop" aria-label="Back to top">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m18 15-6-6-6 6"/></svg>
    </a>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const header = document.getElementById('siteHeader');
            const menuButton = document.getElementById('menuButton');
            const navLinks = document.getElementById('navLinks');
            const backToTop = document.getElementById('backToTop');
            const yearEl = document.getElementById('currentYear');
            const iconOpen = menuButton?.querySelector('.icon-open');
            const iconClose = menuButton?.querySelector('.icon-close');
            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (!header || !menuButton || !navLinks || !backToTop) return;

            if (yearEl) {
                yearEl.textContent = new Date().getFullYear();
            }

            /*
             * Keep the CSS offset synchronized with the real header height.
             * This prevents headings from hiding beneath the sticky navigation.
             */
            function updateHeaderMeasurements() {
                const height = Math.ceil(header.getBoundingClientRect().height);
                document.documentElement.style.setProperty('--header-height', height + 'px');
                document.documentElement.style.setProperty('--scroll-offset', (height + 16) + 'px');
            }

            updateHeaderMeasurements();

            if ('ResizeObserver' in window) {
                const headerObserver = new ResizeObserver(updateHeaderMeasurements);
                headerObserver.observe(header);
            } else {
                window.addEventListener('resize', updateHeaderMeasurements);
            }

            function setMenu(open, returnFocus = false) {
                navLinks.classList.toggle('open', open);
                document.body.classList.toggle('menu-open', open);

                menuButton.setAttribute('aria-expanded', String(open));
                menuButton.setAttribute(
                    'aria-label',
                    open ? 'Close navigation menu' : 'Open navigation menu'
                );

                if (iconOpen) iconOpen.style.display = open ? 'none' : 'block';
                if (iconClose) iconClose.style.display = open ? 'block' : 'none';

                if (!open && returnFocus) {
                    menuButton.focus();
                }
            }

            menuButton.addEventListener('click', function () {
                const isOpen = menuButton.getAttribute('aria-expanded') === 'true';
                setMenu(!isOpen);
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && navLinks.classList.contains('open')) {
                    setMenu(false, true);
                }
            });

            document.addEventListener('click', function (event) {
                if (
                    navLinks.classList.contains('open') &&
                    !navLinks.contains(event.target) &&
                    !menuButton.contains(event.target)
                ) {
                    setMenu(false);
                }
            });

            /*
             * Resolve only same-page hash links. Laravel routes such as /login
             * remain ordinary navigation links and are not intercepted.
             */
            function getSamePageTarget(link) {
                const href = link.getAttribute('href');

                if (!href || href === '#' || !href.includes('#')) {
                    return null;
                }

                let url;

                try {
                    url = new URL(href, window.location.href);
                } catch {
                    return null;
                }

                if (
                    url.origin !== window.location.origin ||
                    url.pathname !== window.location.pathname ||
                    url.search !== window.location.search ||
                    !url.hash
                ) {
                    return null;
                }

                let targetId;

                try {
                    targetId = decodeURIComponent(url.hash.slice(1));
                } catch {
                    return null;
                }

                const target = document.getElementById(targetId);

                return target ? { target, hash: url.hash } : null;
            }

            /*
             * Scroll using the live header height rather than a fixed offset.
             * This is more reliable across desktop, tablet, and mobile layouts.
             */
            function scrollToTarget(target, behavior) {
                updateHeaderMeasurements();

                const headerHeight = header.getBoundingClientRect().height;
                const targetTop = target.getBoundingClientRect().top + window.scrollY;
                const offset = headerHeight + 16;
                const maxScroll = Math.max(
                    0,
                    document.documentElement.scrollHeight - window.innerHeight
                );
                const destination = Math.min(
                    Math.max(0, targetTop - offset),
                    maxScroll
                );

                window.scrollTo({
                    top: destination,
                    behavior: reduceMotion ? 'auto' : behavior
                });
            }

            function navigateToTarget(target, hash, options = {}) {
                const {
                    updateHistory = true,
                    behavior = 'smooth'
                } = options;

                setMenu(false);

                if (updateHistory && window.location.hash !== hash) {
                    window.history.pushState(
                        { sectionNavigation: true },
                        '',
                        hash
                    );
                }

                scrollToTarget(target, behavior);
            }

            /*
             * Apply the same behavior to navigation, footer links, hero buttons,
             * and the Back to Top button. External routes are left untouched.
             */
            document.addEventListener('click', function (event) {
                if (
                    event.defaultPrevented ||
                    event.button !== 0 ||
                    event.metaKey ||
                    event.ctrlKey ||
                    event.shiftKey ||
                    event.altKey
                ) {
                    return;
                }

                const link = event.target.closest('a[href]');

                if (!link || link.hasAttribute('download')) return;
                if (link.target && link.target !== '_self') return;

                const result = getSamePageTarget(link);

                if (!result) {
                    if (navLinks.contains(link)) {
                        setMenu(false);
                    }
                    return;
                }

                event.preventDefault();

                navigateToTarget(result.target, result.hash);
            });

            /*
             * Restore the correct section when users use browser Back/Forward.
             */
            function handleHistoryNavigation() {
                const rawHash = window.location.hash;

                if (!rawHash) {
                    window.scrollTo({
                        top: 0,
                        behavior: reduceMotion ? 'auto' : 'smooth'
                    });
                    setMenu(false);
                    return;
                }

                let targetId;

                try {
                    targetId = decodeURIComponent(rawHash.slice(1));
                } catch {
                    return;
                }

                const target = document.getElementById(targetId);

                if (target) {
                    setMenu(false);
                    scrollToTarget(target, 'smooth');
                }
            }

            window.addEventListener('popstate', handleHistoryNavigation);
            window.addEventListener('hashchange', handleHistoryNavigation);

            /*
             * Direct visits to URLs such as /#modules should land at the
             * correct location after the page has rendered.
             */
            if (window.location.hash) {
                window.requestAnimationFrame(function () {
                    window.requestAnimationFrame(handleHistoryNavigation);
                });
            }

            /* Header appearance and Back to Top visibility. */
            let ticking = false;

            function onScroll() {
                const y = window.scrollY;

                header.classList.toggle('scrolled', y > 12);
                backToTop.classList.toggle('visible', y > 480);

                ticking = false;
            }

            window.addEventListener('scroll', function () {
                if (!ticking) {
                    window.requestAnimationFrame(onScroll);
                    ticking = true;
                }
            }, { passive: true });

            onScroll();

            /* Reveal sections only when they enter the viewport. */
            const revealEls = document.querySelectorAll('.reveal');
            const timeline = document.getElementById('timeline');

            function revealElement(element) {
                element.classList.add('is-visible');

                if (timeline && (element === timeline || timeline.contains(element))) {
                    timeline.classList.add('is-visible');
                }
            }

            if ('IntersectionObserver' in window && !reduceMotion) {
                const revealObserver = new IntersectionObserver(function (entries, observer) {
                    entries.forEach(function (entry) {
                        if (entry.isIntersecting) {
                            revealElement(entry.target);
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.05,
                    rootMargin: '0px 0px -24px 0px'
                });

                revealEls.forEach(function (element) {
                    revealObserver.observe(element);
                });

                if (timeline) {
                    revealObserver.observe(timeline);
                }
            } else {
                revealEls.forEach(revealElement);

                if (timeline) {
                    revealElement(timeline);
                }
            }

            /* Close the mobile menu when returning to desktop layout. */
            window.addEventListener('resize', function () {
                updateHeaderMeasurements();

                if (window.innerWidth > 920) {
                    setMenu(false);
                }
            });

            /* Keep the mobile menu usable if device orientation changes. */
            window.addEventListener('orientationchange', function () {
                updateHeaderMeasurements();
                setMenu(false);
            });
        });
    </script>
</body>
</html>
