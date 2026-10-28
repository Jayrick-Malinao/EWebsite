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

        #database-assistant-toggle {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 9998;
            display: grid;
            width: 54px;
            height: 54px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .42);
            border-radius: 50%;
            color: #fff;
            background: linear-gradient(145deg, var(--assistant-light), var(--assistant-dark));
            box-shadow: 0 8px 22px rgba(15, 111, 90, .3), inset 1px 1px 2px rgba(255, 255, 255, .28);
            cursor: pointer;
            transition: transform 150ms ease, box-shadow 150ms ease;
        }

        #database-assistant-toggle:hover {
            transform: translateY(-2px);
            box-shadow: 0 11px 25px rgba(15, 111, 90, .34), inset 1px 1px 2px rgba(255, 255, 255, .28);
        }

        #database-assistant-toggle:focus-visible,
        #database-assistant-close:focus-visible,
        #database-assistant-send:focus-visible,
        .database-assistant-suggestion:focus-visible {
            outline: 3px solid var(--assistant-accent);
            outline-offset: 3px;
        }

        #database-assistant-panel {
            position: fixed;
            right: 24px;
            bottom: 92px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            width: min(410px, calc(100vw - 32px));
            height: min(600px, calc(100dvh - 116px));
            overflow: hidden;
            border: 1px solid #d3e2d9;
            border-radius: 24px;
            background: var(--assistant-surface);
            box-shadow: 10px 12px 32px rgba(22, 66, 56, .16), -5px -5px 18px rgba(255, 255, 255, .72);
            opacity: 0;
            pointer-events: none;
            transform: translateY(10px) scale(.985);
            transform-origin: bottom right;
            visibility: hidden;
            transition: opacity 180ms ease, transform 180ms ease, visibility 0s linear 180ms;
        }

        #database-assistant-panel.is-open {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0) scale(1);
            visibility: visible;
            transition-delay: 0s;
        }

        #database-assistant-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 78px;
            padding: 16px 18px;
            color: #fff;
            background: linear-gradient(135deg, var(--assistant-primary), var(--assistant-dark));
        }

        .database-assistant-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }

        .database-assistant-avatar {
            display: grid;
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .38);
            border-radius: 15px;
            background: rgba(255, 255, 255, .15);
            box-shadow: inset 1px 1px 2px rgba(255, 255, 255, .24);
        }

        .database-assistant-heading strong {
            display: block;
            font-size: 15px;
            font-weight: 750;
            letter-spacing: .01em;
        }

        .database-assistant-heading small {
            display: block;
            margin-top: 4px;
            color: #e8f6ef;
            font-size: 11px;
            line-height: 1.35;
        }

        #database-assistant-close {
            display: grid;
            width: 36px;
            height: 36px;
            flex: 0 0 auto;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .3);
            border-radius: 12px;
            color: #fff;
            background: rgba(255, 255, 255, .12);
            cursor: pointer;
            font-size: 22px;
            line-height: 1;
            transition: background-color 140ms ease;
        }

        #database-assistant-close:hover {
            background: rgba(255, 255, 255, .22);
        }

        #database-assistant-messages {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 13px;
            overflow-x: hidden;
            overflow-y: auto;
            overscroll-behavior: contain;
            padding: 20px 17px;
            scroll-behavior: smooth;
        }

        .database-assistant-empty {
            margin: auto 0;
            padding: 8px 2px;
        }

        .database-assistant-empty h2 {
            margin: 0 0 7px;
            color: var(--assistant-text);
            font-size: 17px;
            line-height: 1.35;
        }

        .database-assistant-empty p {
            margin: 0;
            color: var(--assistant-secondary);
            font-size: 13px;
            line-height: 1.55;
        }

        .database-assistant-suggestions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 16px;
        }

        .database-assistant-suggestion {
            max-width: 100%;
            padding: 8px 11px;
            border: 1px solid #c8ddd2;
            border-radius: 14px;
            color: var(--assistant-dark);
            background: #fff;
            box-shadow: 2px 3px 7px rgba(22, 66, 56, .07);
            cursor: pointer;
            font: inherit;
            font-size: 12px;
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
            max-width: 91%;
            padding: 11px 14px;
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
            font-size: 13px;
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
            padding: 8px 16px 9px;
            border-top: 1px solid #e2ece6;
            color: var(--assistant-muted-contrast);
            background: var(--assistant-surface);
            font-size: 11px;
            line-height: 1.4;
        }

        #database-assistant-form {
            display: flex;
            align-items: flex-end;
            gap: 9px;
            padding: 12px;
            border-top: 1px solid #dce9e1;
            background: #fff;
        }

        #database-assistant-input {
            display: block;
            min-width: 0;
            min-height: 44px;
            max-height: 120px;
            flex: 1;
            resize: none;
            overflow-y: auto;
            padding: 11px 13px;
            border: 1px solid #c8d9cf;
            border-radius: 15px;
            outline: none;
            color: var(--assistant-text);
            background: var(--assistant-surface);
            font: inherit;
            font-size: 13px;
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
            min-width: 46px;
            height: 44px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0 14px;
            border: 1px solid var(--assistant-dark);
            border-radius: 14px;
            color: #fff;
            background: var(--assistant-dark);
            box-shadow: 2px 3px 7px rgba(15, 111, 90, .16);
            cursor: pointer;
            font: inherit;
            font-size: 13px;
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
            #database-assistant-toggle {
                right: 16px;
                bottom: 16px;
            }

            #database-assistant-panel {
                right: 12px;
                bottom: 82px;
                width: calc(100vw - 24px);
                height: min(620px, calc(100dvh - 98px));
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
        id="database-assistant-toggle"
        aria-label="Open Barangay Health Assistant"
        aria-controls="database-assistant-panel"
        aria-expanded="false"
        title="Open Barangay Health Assistant"
    >
        <svg aria-hidden="true" width="25" height="25" viewBox="0 0 24 24" fill="none">
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
                    <svg width="23" height="23" viewBox="0 0 24 24" fill="none">
                        <path d="M12 3.5 14.15 9.85 20.5 12l-6.35 2.15L12 20.5l-2.15-6.35L3.5 12l6.35-2.15L12 3.5Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/>
                    </svg>
                </span>
                <div>
                    <strong>Barangay Health Assistant</strong>
                    <small>Current records · General health education</small>
                </div>
            </div>
            <button
                type="button"
                id="database-assistant-close"
                aria-label="Close assistant"
                title="Close assistant"
            >×</button>
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

            const toggle = root.querySelector('#database-assistant-toggle');
            const panel = root.querySelector('#database-assistant-panel');
            const close = root.querySelector('#database-assistant-close');
            const messages = root.querySelector('#database-assistant-messages');
            const form = root.querySelector('#database-assistant-form');
            const input = root.querySelector('#database-assistant-input');
            const send = root.querySelector('#database-assistant-send');
            let requestInProgress = false;

            const scrollMessagesToBottom = () => {
                messages.scrollTop = messages.scrollHeight;
            };

            const focusInput = () => {
                input.focus({ preventScroll: true });
            };

            const openPanel = () => {
                panel.classList.add('is-open');
                panel.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'true');
                focusInput();
            };

            const closePanel = () => {
                panel.classList.remove('is-open');
                panel.setAttribute('aria-hidden', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus({ preventScroll: true });
            };

            toggle.addEventListener('click', () => {
                panel.classList.contains('is-open') ? closePanel() : openPanel();
            });

            close.addEventListener('click', closePanel);

            document.addEventListener('keydown', event => {
                if (event.key === 'Escape' && panel.classList.contains('is-open')) {
                    closePanel();
                }
            });

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

            root.querySelectorAll('.database-assistant-suggestion').forEach(button => {
                button.addEventListener('click', () => {
                    if (requestInProgress) {
                        return;
                    }

                    input.value = button.dataset.question || '';
                    resizeInput();
                    form.requestSubmit();
                });
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
