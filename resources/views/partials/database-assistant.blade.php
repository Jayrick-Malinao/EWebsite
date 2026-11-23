<div id="database-assistant-root">
    <style>
        #database-assistant-root {
            --assistant-primary: #168B70;
            --assistant-dark: #0F6F5A;
            --assistant-light: #2A9B80;
            --assistant-background: #EEF5F1;
            --assistant-surface: #F5FAF7;
            --assistant-text: #164238;
            --assistant-secondary: #385C52;
            --assistant-muted: #6D817A;
            --assistant-muted-contrast: #526A61;
            --assistant-accent: #E87928;
            --assistant-danger: #B42323;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        #database-assistant-root *,
        #database-assistant-root *::before,
        #database-assistant-root *::after {
            box-sizing: border-box;
        }

        #database-assistant-help {
            display: grid;
            width: 36px;
            height: 36px;
            flex: 0 0 auto;
            place-items: center;
            border: 1px solid #b9d8cb;
            border-radius: 50%;
            color: #0f6f5a;
            background: #f5faf7;
            font: 700 18px/1 Arial, sans-serif;
            cursor: pointer;
        }

        #database-assistant-help:hover {
            background: #e1f2e9;
        }

        #database-assistant-help:focus-visible,
        #database-assistant-close:focus-visible {
            outline: 3px solid #e87928;
            outline-offset: 3px;
        }

        #database-assistant-toggle {
            position: fixed;
            right: 8px;
            bottom: 0;
            z-index: 9998;
            display: grid;
            place-items: center;
            padding: 8px;
            border: 0;
            border-radius: 50%;
            color: #fff;
            background: transparent;
            cursor: pointer;
            touch-action: none;
            user-select: none;
            -webkit-user-select: none;
            -webkit-touch-callout: none;
            transition: left .35s ease, top .35s ease, width .3s ease, height .3s ease, transform 150ms ease;
        }

        #database-assistant-toggle[hidden] {
            display: none;
        }

        #database-assistant-toggle:hover {
            transform: translateY(-2px);
        }

        /* Shown while the button is being held, before dragging starts. */
        #database-assistant-toggle.is-holding {
            transform: scale(.94);
            transition: transform 350ms ease;
        }

        #database-assistant-toggle.is-dragging {
            cursor: grabbing;
            transition: none;
            transform: none;
        }

        #database-assistant-toggle .assistant-lottie {
            display: block;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        #database-assistant-toggle .assistant-lottie-fallback {
            display: none;
            width: 100%;
            height: 100%;
            padding: 24px;
            border-radius: 50%;
            color: #fff;
            background: linear-gradient(145deg, var(--assistant-light), var(--assistant-dark));
            box-shadow: 0 8px 22px rgba(15, 111, 90, .3), inset 1px 1px 2px rgba(255, 255, 255, .28);
        }

        #database-assistant-toggle:focus-visible,
        #database-assistant-send:focus-visible,
        .database-assistant-suggestion:focus-visible {
            outline: 3px solid var(--assistant-accent);
            outline-offset: 3px;
        }

        /* Panel is always centered in the viewport when open. */
        #database-assistant-panel {
            position: fixed;
            left: 50%;
            top: 50%;
            right: auto;
            bottom: auto;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            width: min(480px, calc(100vw - 32px));
            height: min(720px, calc(100dvh - 40px));
            overflow: hidden;
            border: 1px solid #d3e2d9;
            border-radius: 24px;
            background: var(--assistant-surface);
            box-shadow: 10px 12px 32px rgba(22, 66, 56, .16), -5px -5px 18px rgba(255, 255, 255, .72);
            opacity: 0;
            pointer-events: none;
            transform: translate(-50%, -48%) scale(.985);
            transform-origin: center;
            visibility: hidden;
            transition: opacity 180ms ease, transform 180ms ease, visibility 0s linear 180ms;
        }

        #database-assistant-panel.is-open {
            opacity: 1;
            pointer-events: auto;
            transform: translate(-50%, -50%) scale(1);
            visibility: visible;
            transition-delay: 0s;
        }

        #database-assistant-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 84px;
            padding: 18px 20px;
            color: #fff;
            background: linear-gradient(135deg, var(--assistant-primary), var(--assistant-dark));
        }

        #database-assistant-close {
            display: grid;
            width: 40px;
            height: 40px;
            flex: 0 0 auto;
            place-items: center;
            border: 0;
            border-radius: 50%;
            color: #fff;
            background: rgba(15, 76, 58, .35);
            cursor: pointer;
        }

        #database-assistant-close:hover {
            background: rgba(15, 76, 58, .55);
        }

        .database-assistant-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .database-assistant-avatar {
            display: grid;
            width: 44px;
            height: 44px;
            flex: 0 0 auto;
            place-items: center;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .38);
            border-radius: 50%;
            background: #fff;
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, .24);
        }

        .database-assistant-avatar img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .database-assistant-heading strong {
            display: block;
            font-size: 16px;
            font-weight: 750;
            letter-spacing: .01em;
        }

        .database-assistant-heading small {
            display: block;
            margin-top: 4px;
            color: #e8f6ef;
            font-size: 12px;
            line-height: 1.35;
        }

        /* Scrolling still works, but the scrollbar is hidden. */
        #database-assistant-messages {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 14px;
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior: contain;
            padding: 22px 20px;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        #database-assistant-messages::-webkit-scrollbar {
            display: none;
        }

        .database-assistant-empty {
            margin: 0;
            padding: 4px 2px 0;
        }

        .database-assistant-empty h2 {
            margin: 0 0 8px;
            color: var(--assistant-text);
            font-size: 18px;
            line-height: 1.35;
        }

        .database-assistant-empty p {
            margin: 0;
            color: var(--assistant-secondary);
            font-size: 14px;
            line-height: 1.55;
        }

        .database-assistant-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 18px;
        }

        .database-assistant-suggestion {
            max-width: 100%;
            padding: 9px 12px;
            border: 1px solid #c8ddd2;
            border-radius: 14px;
            color: var(--assistant-dark);
            background: #fff;
            box-shadow: 2px 3px 7px rgba(22, 66, 56, .07);
            cursor: pointer;
            font: inherit;
            font-size: 13px;
            line-height: 1.35;
            text-align: left;
            transition: border-color 140ms ease, background-color 140ms ease, transform 140ms ease;
        }

        .database-assistant-suggestion:hover {
            transform: translateY(-1px);
            border-color: var(--assistant-primary);
            background: #edf7f1;
        }

        .database-assistant-message {
            max-width: 90%;
            padding: 12px 15px;
            border: 1px solid transparent;
            border-radius: 17px;
            overflow-wrap: anywhere;
            animation: database-assistant-message-in 160ms ease-out both;
        }

        .database-assistant-message-label {
            display: block;
            margin-bottom: 4px;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: .045em;
            opacity: .84;
            text-transform: uppercase;
        }

        .database-assistant-message-copy {
            white-space: pre-wrap;
            font-size: 14px;
            line-height: 1.55;
        }

        .database-assistant-message.bot {
            align-self: flex-start;
            border-color: #dbe9e1;
            border-bottom-left-radius: 5px;
            color: var(--assistant-text);
            background: #fff;
            box-shadow: 3px 4px 10px rgba(22, 66, 56, .065);
        }

        .database-assistant-message.user {
            align-self: flex-end;
            border-bottom-right-radius: 5px;
            color: #fff;
            background: var(--assistant-dark);
            box-shadow: 3px 4px 10px rgba(15, 111, 90, .16);
        }

        .database-assistant-message.error {
            border-color: #efc7c4;
            color: var(--assistant-danger);
            background: #fff8f7;
        }

        .database-assistant-message.typing {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            align-items: center;
            column-gap: 9px;
            color: var(--assistant-secondary);
            background: #fff;
        }

        .database-assistant-message.typing .database-assistant-message-label {
            grid-column: 1 / -1;
            margin-bottom: 4px;
            white-space: nowrap;
        }

        .database-assistant-message.typing .database-assistant-message-copy {
            min-width: 0;
        }

        .database-assistant-typing-dots {
            display: inline-flex;
            flex: 0 0 auto;
            gap: 4px;
        }

        .database-assistant-typing-dots span {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--assistant-primary);
            animation: database-assistant-typing 1.1s ease-in-out infinite;
        }

        .database-assistant-typing-dots span:nth-child(2) {
            animation-delay: 140ms;
        }

        .database-assistant-typing-dots span:nth-child(3) {
            animation-delay: 280ms;
        }

        #database-assistant-status {
            padding: 9px 18px 10px;
            border-top: 1px solid #e2ece6;
            color: var(--assistant-muted-contrast);
            background: var(--assistant-surface);
            font-size: 12px;
            line-height: 1.4;
        }

        #database-assistant-form {
            display: flex;
            align-items: flex-end;
            gap: 10px;
            padding: 14px;
            border-top: 1px solid #dce9e1;
            background: #fff;
        }

        #database-assistant-input {
            display: block;
            min-width: 0;
            min-height: 46px;
            max-height: 120px;
            flex: 1;
            resize: none;
            overflow-y: auto;
            padding: 12px 14px;
            border: 1px solid #c8d9cf;
            border-radius: 15px;
            outline: none;
            color: var(--assistant-text);
            background: var(--assistant-surface);
            font: inherit;
            font-size: 14px;
            line-height: 1.45;
            transition: border-color 140ms ease, box-shadow 140ms ease;
        }

        #database-assistant-input::placeholder {
            color: var(--assistant-muted-contrast);
            opacity: 1;
        }

        #database-assistant-input:focus-visible {
            border-color: var(--assistant-primary);
            box-shadow: 0 0 0 3px rgba(22, 139, 112, .18);
        }

        #database-assistant-send {
            display: inline-flex;
            min-width: 48px;
            height: 46px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 15px;
            border: 1px solid var(--assistant-dark);
            border-radius: 14px;
            color: #fff;
            background: var(--assistant-dark);
            box-shadow: 2px 3px 7px rgba(15, 111, 90, .16);
            cursor: pointer;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            transition: background-color 140ms ease, transform 140ms ease;
        }

        #database-assistant-send:hover:not(:disabled) {
            transform: translateY(-1px);
            background: #0b5c4b;
        }

        #database-assistant-send:disabled {
            cursor: wait;
            opacity: .65;
        }

        .database-assistant-input-hint {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        @keyframes database-assistant-message-in {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes database-assistant-typing {
            0%, 60%, 100% { opacity: .35; transform: translateY(0); }
            30% { opacity: 1; transform: translateY(-3px); }
        }

        @media (max-width: 480px) {
            #database-assistant-panel {
                width: calc(100vw - 24px);
                height: min(640px, calc(100dvh - 32px));
                border-radius: 21px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #database-assistant-root *,
            #database-assistant-root *::before,
            #database-assistant-root *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
        }
    </style>

    <button
        type="button"
        id="database-assistant-help"
        aria-label="Show Barangay Health Assistant"
        aria-controls="database-assistant-toggle"
        aria-expanded="false"
        title="Show Barangay Health Assistant"
    >?</button>

    <button
        type="button"
        id="database-assistant-toggle"
        aria-label="Open Barangay Health Assistant"
        aria-controls="database-assistant-panel"
        aria-expanded="false"
        title="Click to open or close. Press and hold to move."
        hidden
    >
        <lottie-player
            id="assistantLottie"
            class="assistant-lottie"
            src="{{ asset('images/Live chatbot.json') }}"
            background="transparent"
            speed="1"
            loop
            autoplay
            aria-hidden="true">
        </lottie-player>

        <svg
            id="assistantLottieFallback"
            class="assistant-lottie-fallback"
            aria-hidden="true"
            viewBox="0 0 24 24"
            fill="none"
        >
            <path d="M12 3.5 14.15 9.85 20.5 12l-6.35 2.15L12 20.5l-2.15-6.35L3.5 12l6.35-2.15L12 3.5Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
            <path d="m19 3 .65 1.85L21.5 5.5l-1.85.65L19 8l-.65-1.85L16.5 5.5l1.85-.65L19 3Z" fill="currentColor"/>
        </svg>
    </button>

    <section
        id="database-assistant-panel"
        role="dialog"
        aria-label="Barangay Health Assistant"
        aria-hidden="true"
    >
        <header id="database-assistant-header">
            <div class="database-assistant-heading">
                <span class="database-assistant-avatar" aria-hidden="true">
                    <img src="{{ asset('images/esperanza-health-center-logo.jpg') }}" alt="" onerror="this.style.display='none'">
                </span>
                <div>
                    <strong>Barangay Health Assistant</strong>
                    <small>Current records · General health education</small>
                </div>
            </div>
            <button type="button" id="database-assistant-close" aria-label="Close Barangay Health Assistant">
                <svg aria-hidden="true" width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M6 6l12 12M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </button>
        </header>

        <div id="database-assistant-messages" role="log" aria-live="polite" aria-relevant="additions">
            <div class="database-assistant-empty">
                <h2>How can I help?</h2>
                <p>Ask about information available to your account. System answers come from current records.</p>
                <div class="database-assistant-suggestions" aria-label="Suggested questions">
                    <button type="button" class="database-assistant-suggestion" data-question="How many residents are registered?">Resident count</button>
                    <button type="button" class="database-assistant-suggestion" data-question="How many households are registered?">Household count</button>
                    <button type="button" class="database-assistant-suggestion" data-question="May upcoming schedules ba this week?">Schedules this week</button>
                    <button type="button" class="database-assistant-suggestion" data-question="Which medical items are expiring soon?">Expiring inventory</button>
                    <button type="button" class="database-assistant-suggestion" data-question="Show published announcements">Published announcements</button>
                </div>
            </div>
        </div>

        <div id="database-assistant-status" role="status">
            Read-only answers · Access follows your account permissions.
        </div>

        <form id="database-assistant-form">
            <label class="database-assistant-input-hint" for="database-assistant-input">
                Ask a question
            </label>
            <textarea
                id="database-assistant-input"
                rows="1"
                placeholder="Ask about records or health education…"
                autocomplete="off"
                aria-describedby="database-assistant-input-help"
                required
            ></textarea>
            <span id="database-assistant-input-help" class="database-assistant-input-hint">
                Press Enter to send. Press Shift and Enter for a new line.
            </span>
            <button type="submit" id="database-assistant-send" aria-label="Send message">
                <span>Send</span>
                <svg aria-hidden="true" width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M4 12h15m-6-6 6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>
    </section>

    <script>
        (() => {
            const root = document.getElementById('database-assistant-root');

            if (!root || root.dataset.initialized === 'true') {
                return;
            }

            root.dataset.initialized = 'true';

            const help = root.querySelector('#database-assistant-help');
            const helpSlot = document.querySelector('[data-assistant-slot]');
            if (helpSlot) {
                helpSlot.appendChild(help);
            }

            document.body.appendChild(root);

            const toggle = root.querySelector('#database-assistant-toggle');
            const panel = root.querySelector('#database-assistant-panel');
            const close = root.querySelector('#database-assistant-close');
            const messages = root.querySelector('#database-assistant-messages');
            const form = root.querySelector('#database-assistant-form');
            const input = root.querySelector('#database-assistant-input');
            const send = root.querySelector('#database-assistant-send');
            const assistantLottie = root.querySelector('#assistantLottie');
            const assistantFallback = root.querySelector('#assistantLottieFallback');
            let requestInProgress = false;

            // Keep the starting content so the conversation can be reset when the chat closes.
            const welcomeHTML = messages.innerHTML;

            // ===== Lottie animation =====
            const LOTTIE_SRC = 'https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js';

            const ensureLottiePlayer = () => {
                if (customElements.get('lottie-player')) {
                    return Promise.resolve();
                }

                if (!document.querySelector(`script[src="${LOTTIE_SRC}"]`)) {
                    const script = document.createElement('script');
                    script.src = LOTTIE_SRC;
                    script.async = true;
                    document.head.appendChild(script);
                }

                const timeout = new Promise((_, reject) => {
                    window.setTimeout(() => reject(new Error('Lottie timed out')), 8000);
                });

                return Promise.race([customElements.whenDefined('lottie-player'), timeout]);
            };

            if (assistantLottie) {
                const showAnimation = () => {
                    assistantLottie.style.display = 'block';
                    if (assistantFallback) assistantFallback.style.display = 'none';
                };

                const showFallback = () => {
                    assistantLottie.style.display = 'none';
                    if (assistantFallback) assistantFallback.style.display = 'block';
                };

                assistantLottie.addEventListener('error', showFallback);

                ensureLottiePlayer().then(showAnimation).catch(showFallback);
            }

            // ===== Movable toggle =====
            const EDGE = 8;               // distance from the side and top edges
            const BOTTOM_EDGE = 0;
            const FLOAT_SIZE = 135;       // size while being moved
            const DOCK_SIZE = 180;        // size once docked on desktop
            const MOBILE_DOCK_SIZE = 144; // size once docked on phones
            const HOLD_DELAY = 350;       // milliseconds the button must be held before it can move
            const MOVE_TOLERANCE = 6;     // pixels the pointer can move before a press is no longer a hold or click

            const isMobile = () => window.matchMedia('(max-width: 480px)').matches;
            const fitSize = size => Math.max(0, Math.min(size, window.innerWidth - 2 * EDGE, window.innerHeight - 2 * EDGE));
            const dockSize = () => fitSize(isMobile() ? MOBILE_DOCK_SIZE : DOCK_SIZE);
            const clampTop = (top, size) => Math.max(EDGE, Math.min(top, window.innerHeight - size - BOTTOM_EDGE));

            let position = { side: 'right', top: window.innerHeight - BOTTOM_EDGE - dockSize() };
            let hasDragged = false;
            let suppressClick = false;
            let pointer = null;

            // Snap the toggle to its side at the docked size.
            const applyDockedPosition = () => {
                const size = dockSize();
                position.top = clampTop(position.top, size);

                toggle.style.width = `${size}px`;
                toggle.style.height = `${size}px`;
                toggle.style.top = `${position.top}px`;
                toggle.style.bottom = 'auto';
                toggle.style.right = 'auto';
                toggle.style.left = position.side === 'left'
                    ? `${EDGE}px`
                    : `${Math.max(8, window.innerWidth - size - EDGE)}px`;
            };

            // Decide the side from where the button was released, then snap to it.
            const finishDrag = () => {
                const rect = toggle.getBoundingClientRect();
                const side = rect.left + rect.width / 2 < window.innerWidth / 2 ? 'left' : 'right';

                position = { side, top: rect.top };
                hasDragged = true;
                toggle.classList.remove('is-dragging');
                applyDockedPosition();
            };

            const cancelHold = () => {
                if (!pointer) return;
                window.clearTimeout(pointer.timer);
                toggle.classList.remove('is-holding');
            };

            toggle.addEventListener('pointerdown', event => {
                if (event.button !== 0) return;

                suppressClick = false;
                const rect = toggle.getBoundingClientRect();
                pointer = {
                    id: event.pointerId,
                    x: event.clientX,
                    y: event.clientY,
                    left: rect.left,
                    top: rect.top,
                    dragging: false,
                    timer: null
                };

                // Visual feedback that holding has started.
                toggle.classList.add('is-holding');

                // Only after the button has been held long enough does it become movable.
                pointer.timer = window.setTimeout(() => {
                    if (!pointer) return;

                    pointer.dragging = true;
                    toggle.setPointerCapture(pointer.id);
                    toggle.classList.remove('is-holding');
                    toggle.classList.add('is-dragging');
                }, HOLD_DELAY);
            });

            toggle.addEventListener('pointermove', event => {
                if (!pointer || event.pointerId !== pointer.id) return;

                const dx = event.clientX - pointer.x;
                const dy = event.clientY - pointer.y;

                // Moving before the hold completes cancels the hold, so a quick swipe does not move the button.
                if (!pointer.dragging) {
                    if (Math.hypot(dx, dy) > MOVE_TOLERANCE) {
                        cancelHold();
                    }
                    return;
                }

                const size = fitSize(FLOAT_SIZE);
                const left = Math.max(EDGE, Math.min(pointer.left + dx, window.innerWidth - size - EDGE));
                const top = clampTop(pointer.top + dy, size);

                toggle.style.width = `${size}px`;
                toggle.style.height = `${size}px`;
                toggle.style.left = `${left}px`;
                toggle.style.top = `${top}px`;
                toggle.style.right = 'auto';
                toggle.style.bottom = 'auto';
            });

            const endPointer = event => {
                if (!pointer || event.pointerId !== pointer.id) return;

                const wasDragging = pointer.dragging;
                cancelHold();
                pointer = null;

                if (wasDragging) {
                    suppressClick = true;
                    finishDrag();
                }
            };

            toggle.addEventListener('pointerup', endPointer);
            toggle.addEventListener('pointercancel', endPointer);

            // Stop the long-press menu on phones from appearing over the button.
            toggle.addEventListener('contextmenu', event => event.preventDefault());

            window.addEventListener('resize', () => {
                if (toggle.classList.contains('is-dragging')) return;

                if (!hasDragged) {
                    position.top = window.innerHeight - BOTTOM_EDGE - dockSize();
                }
                applyDockedPosition();
            });

            // ===== Panel: opens centered on click, closes on the next click =====
            const scrollMessagesToBottom = () => {
                messages.scrollTop = messages.scrollHeight;
            };

            const focusInput = () => {
                input.focus({ preventScroll: true });
            };

            // Clears the conversation so the next open starts from the welcome screen.
            const resetConversation = () => {
                messages.innerHTML = welcomeHTML;
                messages.scrollTop = 0;
                input.value = '';
                input.style.height = 'auto';
            };

            const openPanel = () => {
                panel.classList.add('is-open');
                panel.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'true');
                focusInput();
            };

            const closePanel = (restoreFocus = true) => {
                panel.classList.remove('is-open');
                panel.setAttribute('aria-hidden', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                resetConversation();
                if (restoreFocus) {
                    toggle.focus({ preventScroll: true });
                }
            };

            const visibilityKey = 'database-assistant-visible';

            const setAssistantVisible = visible => {
                if (!visible && panel.classList.contains('is-open')) {
                    closePanel(false);
                }

                toggle.hidden = !visible;
                if (visible) {
                    applyDockedPosition();
                }
                const label = `${visible ? 'Hide' : 'Show'} Barangay Health Assistant`;
                help.setAttribute('aria-expanded', String(visible));
                help.setAttribute('aria-label', label);
                help.title = label;
            };

            try {
                setAssistantVisible(localStorage.getItem(visibilityKey) === 'true');
            } catch (error) {
                console.error('Unable to restore assistant visibility:', error);
                help.title = 'Assistant visibility could not be restored in this browser.';
            }

            help.addEventListener('click', () => {
                const visible = toggle.hidden;
                setAssistantVisible(visible);
                try {
                    localStorage.setItem(visibilityKey, String(visible));
                } catch (error) {
                    console.error('Unable to save assistant visibility:', error);
                    help.title = 'Assistant visibility could not be saved in this browser.';
                }
            });

            window.addEventListener('storage', event => {
                if (event.key === visibilityKey) {
                    setAssistantVisible(event.newValue === 'true');
                }
            });

            close.addEventListener('click', () => closePanel());

            toggle.addEventListener('click', () => {
                if (suppressClick) {
                    suppressClick = false;
                    return;
                }

                panel.classList.contains('is-open') ? closePanel() : openPanel();
            });

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && panel.classList.contains('is-open')) {
                    closePanel();
                }
            });

            // Start at the bottom-right on each page.
            applyDockedPosition();

            // ===== Messages =====
            const addMessage = (text, type = 'bot') => {
                const bubble = document.createElement('div');
                const label = document.createElement('span');
                const copy = document.createElement('div');

                bubble.className = `database-assistant-message ${type}`;
                label.className = 'database-assistant-message-label';
                label.textContent = type === 'user' ? 'You' : 'Assistant';
                copy.className = 'database-assistant-message-copy';
                copy.textContent = text;
                bubble.append(label, copy);
                messages.appendChild(bubble);
                scrollMessagesToBottom();

                return bubble;
            };

            const addTypingIndicator = () => {
                const bubble = document.createElement('div');
                bubble.className = 'database-assistant-message bot typing';
                bubble.setAttribute('aria-label', 'Assistant is responding');

                const label = document.createElement('span');
                label.className = 'database-assistant-message-label';
                label.textContent = 'Assistant';

                const copy = document.createElement('div');
                copy.className = 'database-assistant-message-copy';
                copy.textContent = 'Checking the available information';

                const dots = document.createElement('span');
                dots.className = 'database-assistant-typing-dots';
                dots.setAttribute('aria-hidden', 'true');
                for (let index = 0; index < 3; index += 1) {
                    dots.appendChild(document.createElement('span'));
                }

                bubble.append(label, copy, dots);
                messages.appendChild(bubble);
                scrollMessagesToBottom();
                return bubble;
            };

            const resizeInput = () => {
                input.style.height = 'auto';
                input.style.height = `${Math.min(input.scrollHeight, 120)}px`;
            };

            input.addEventListener('input', resizeInput);
            input.addEventListener('keydown', event => {
                if (event.key === 'Enter' && !event.shiftKey && !event.isComposing) {
                    event.preventDefault();
                    form.requestSubmit();
                }
            });

            // Suggestion buttons are re-created on reset, so use event delegation.
            messages.addEventListener('click', event => {
                const button = event.target.closest('.database-assistant-suggestion');

                if (!button || requestInProgress) {
                    return;
                }

                input.value = button.dataset.question || '';
                resizeInput();
                form.requestSubmit();
            });

            form.addEventListener('submit', async event => {
                event.preventDefault();

                if (requestInProgress) {
                    return;
                }

                const message = input.value.trim();
                if (!message) {
                    return;
                }

                requestInProgress = true;
                send.disabled = true;
                input.disabled = true;
                messages.setAttribute('aria-busy', 'true');

                // Remove the welcome content on the first message.
                const welcome = messages.querySelector('.database-assistant-empty');
                if (welcome) welcome.remove();

                addMessage(message, 'user');
                input.value = '';
                resizeInput();
                const loading = addTypingIndicator();
                const controller = new AbortController();
                const timeout = window.setTimeout(() => controller.abort(), 95000);

                try {
                    const response = await fetch(@json(route('assistant.chat')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token())
                        },
                        credentials: 'same-origin',
                        signal: controller.signal,
                        body: JSON.stringify({ message })
                    });

                    const data = await response.json().catch(() => null);
                    loading.remove();

                    if (!response.ok) {
                        if (response.status === 401 || response.status === 419) {
                            addMessage('Your session may have expired. Refresh the page and sign in again.', 'error');
                        } else if (response.status === 403) {
                            addMessage('Your account is not authorized to access that information.', 'error');
                        } else if (response.status === 422) {
                            addMessage('Please enter a shorter question and try again.', 'error');
                        } else if (response.status >= 500) {
                            addMessage('The server could not complete that request. Please try again shortly.', 'error');
                        } else {
                            addMessage('The assistant could not process that request. Please try again.', 'error');
                        }
                        return;
                    }

                    if (!data || typeof data !== 'object') {
                        addMessage('The server returned an unreadable response. Please try again.', 'error');
                        return;
                    }

                    const reply = data.reply ?? data.message;
                    if (typeof reply !== 'string' || reply.trim() === '') {
                        addMessage('The assistant returned no answer. Please try again.', 'error');
                        return;
                    }

                    addMessage(reply);
                } catch (error) {
                    loading.remove();
                    if (error.name === 'AbortError') {
                        addMessage('This request took too long. Please try again, or ask a shorter database question.', 'error');
                    } else {
                        addMessage('Unable to connect to the assistant. Check your connection and try again.', 'error');
                        console.error('Database Assistant error:', error);
                    }
                } finally {
                    window.clearTimeout(timeout);
                    requestInProgress = false;
                    send.disabled = false;
                    input.disabled = false;
                    messages.setAttribute('aria-busy', 'false');

                    if (panel.classList.contains('is-open')) {
                        focusInput();
                    }
                }
            });
        })();
    </script>
</div>