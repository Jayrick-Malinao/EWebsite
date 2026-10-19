
<div id="database-assistant-root">
    <style>
        #database-assistant-root {
            font-family: Arial, Helvetica, sans-serif;
        }

        #database-assistant-toggle {
            position: fixed;
            right: 24px;
            bottom: 24px;
            z-index: 9998;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            min-width: 60px;
            height: 60px;
            padding: 0 18px;
            border: 0;
            border-radius: 999px;
            color: #fff;
            background: linear-gradient(145deg, #2A9B80, #0F6F5A);
            box-shadow: 5px 5px 12px #b8c9c0, -4px -4px 12px #fff;
            cursor: pointer;
            font-size: 15px;
            font-weight: 700;
        }

        #database-assistant-toggle:hover {
            filter: brightness(1.06);
            transform: translateY(-2px);
        }

        #database-assistant-panel {
            position: fixed;
            right: 24px;
            bottom: 98px;
            z-index: 9999;
            display: none;
            flex-direction: column;
            width: min(390px, calc(100vw - 32px));
            height: min(540px, calc(100dvh - 130px));
            overflow: hidden;
            border: 1px solid #d8e8df;
            border-radius: 22px;
            background: #F5FAF7;
            box-shadow: 0 18px 55px rgba(15, 76, 58, .22);
        }

        #database-assistant-panel.is-open {
            display: flex;
        }

        #database-assistant-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 17px;
            color: white;
            background: linear-gradient(135deg, #168B70, #0F6F5A);
        }

        #database-assistant-header strong {
            display: block;
            font-size: 15px;
        }

        #database-assistant-header small {
            display: block;
            margin-top: 4px;
            color: #e1f5eb;
            font-size: 11px;
        }

        #database-assistant-close {
            border: 0;
            border-radius: 10px;
            padding: 7px 10px;
            color: white;
            background: rgba(255, 255, 255, .15);
            cursor: pointer;
            font-size: 18px;
        }

        #database-assistant-messages {
            display: flex;
            flex: 1;
            flex-direction: column;
            gap: 12px;
            overflow-y: auto;
            padding: 16px;
        }

        .database-assistant-message {
            max-width: 88%;
            padding: 11px 13px;
            border-radius: 14px;
            font-size: 13px;
            line-height: 1.55;
            overflow-wrap: anywhere;
            white-space: pre-wrap;
        }

        .database-assistant-message.bot {
            align-self: flex-start;
            color: #164238;
            background: #fff;
            border: 1px solid #e0ece5;
            border-bottom-left-radius: 4px;
        }

        .database-assistant-message.user {
            align-self: flex-end;
            color: #fff;
            background: #168B70;
            border-bottom-right-radius: 4px;
        }

        #database-assistant-form {
            display: flex;
            gap: 8px;
            padding: 12px;
            border-top: 1px solid #dce9e1;
            background: #fff;
        }

        #database-assistant-input {
            flex: 1;
            min-width: 0;
            padding: 11px 12px;
            border: 1px solid #d4e3da;
            border-radius: 12px;
            outline: none;
            color: #164238;
            background: #F5FAF7;
            font: inherit;
            font-size: 13px;
        }

        #database-assistant-input:focus {
            border-color: #168B70;
            box-shadow: 0 0 0 3px rgba(22, 139, 112, .12);
        }

        #database-assistant-send {
            padding: 0 15px;
            border: 0;
            border-radius: 12px;
            color: white;
            background: #168B70;
            cursor: pointer;
            font-weight: 700;
        }

        #database-assistant-send:disabled {
            opacity: .55;
            cursor: wait;
        }

        #database-assistant-status {
            padding: 0 14px 10px;
            color: #6D817A;
            background: white;
            font-size: 10px;
        }

        @media (max-width: 480px) {
            #database-assistant-toggle {
                right: 16px;
                bottom: 16px;
            }

            #database-assistant-panel {
                right: 16px;
                bottom: 88px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            #database-assistant-toggle {
                transition: none;
            }
        }
    </style>

    <button
        type="button"
        id="database-assistant-toggle"
        aria-controls="database-assistant-panel"
        aria-expanded="false"
    >
        <span aria-hidden="true">✦</span>
        <span>Health Assistant</span>
    </button>

    <section
        id="database-assistant-panel"
        role="dialog"
        aria-label="Database Assistant"
        aria-hidden="true"
    >
        <header id="database-assistant-header">
            <div>
                <strong>Barangay Health Assistant</strong>
                <small>Database assistance · No AI</small>
            </div>
            <button
                type="button"
                id="database-assistant-close"
                aria-label="Close assistant"
            >×</button>
        </header>

        <div id="database-assistant-messages" aria-live="polite">
            <div class="database-assistant-message bot">Hello! I can help you search information available to your account in the health center database. Try asking how many residents are registered or to show upcoming schedules.</div>
        </div>

        <div id="database-assistant-status">Read-only mode · No records will be changed.</div>

        <form id="database-assistant-form">
            <input
                type="text"
                id="database-assistant-input"
                placeholder="Ask about your records..."
                autocomplete="off"
                required
            >
            <button type="submit" id="database-assistant-send">Send</button>
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

            const openPanel = () => {
                panel.classList.add('is-open');
                panel.setAttribute('aria-hidden', 'false');
                toggle.setAttribute('aria-expanded', 'true');
                input.focus();
            };

            const closePanel = () => {
                panel.classList.remove('is-open');
                panel.setAttribute('aria-hidden', 'true');
                toggle.setAttribute('aria-expanded', 'false');
                toggle.focus();
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
                bubble.className = `database-assistant-message ${type}`;
                bubble.textContent = text;
                messages.appendChild(bubble);
                messages.scrollTop = messages.scrollHeight;
                return bubble;
            };

            form.addEventListener('submit', async event => {
                event.preventDefault();

                const message = input.value.trim();

                if (!message) return;

                addMessage(message, 'user');
                input.value = '';
                send.disabled = true;

                const loading = addMessage('Searching the database...');

                try {
                    const response = await fetch(@json(route('assistant.chat')), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': @json(csrf_token())
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ message })
                    });

                    const data = await response.json().catch(() => ({}));
                    loading.remove();

                    if (!response.ok) {
                        if (response.status === 401 || response.status === 419) {
                            addMessage('Your session may have expired. Please refresh the page and log in again.');
                        } else if (response.status === 403) {
                            addMessage('You are not authorized to access this request.');
                        } else {
                            addMessage(data.message || 'The assistant could not complete your request. Check the Laravel log for details.');
                        }

                        return;
                    }

                    const reply = data.reply ?? data.message ?? 'The server returned no response.';
                    addMessage(typeof reply === 'string' ? reply : JSON.stringify(reply, null, 2));
                } catch (error) {
                    loading.remove();
                    addMessage('Unable to connect to the assistant. Check that Laravel is running and try again.');
                    console.error('Database Assistant error:', error);
                } finally {
                    send.disabled = false;
                    input.focus();
                }
            });
        })();
    </script>
</div>
