import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const actionMenuTriggers = new WeakMap();

const installActionMenus = () => {
    let openMenu = null;
    const gap = 8;

    const closeMenu = (restoreFocus = false) => {
        if (!openMenu) {
            return;
        }

        const { trigger, panel, placeholder, originalStyle } = openMenu;
        openMenu = null;
        panel.classList.add('hidden');
        panel.hidden = true;
        panel.classList.remove('is-floating');
        if (originalStyle === null) {
            panel.removeAttribute('style');
        } else {
            panel.setAttribute('style', originalStyle);
        }
        placeholder.replaceWith(panel);
        trigger.setAttribute('aria-expanded', 'false');

        if (restoreFocus) {
            trigger.focus({ preventScroll: true });
        }
    };

    const showMenu = (trigger, focusFirst = false) => {
        const panel = trigger.nextElementSibling;
        if (!(panel instanceof HTMLElement) || !panel.matches('[data-menu-panel], [role="menu"]')) {
            return;
        }

        const placeholder = document.createComment('action menu');
        const originalStyle = panel.getAttribute('style');
        panel.before(placeholder);
        document.body.appendChild(panel);
        openMenu = { trigger, panel, placeholder, originalStyle };
        actionMenuTriggers.set(panel, trigger);
        panel.classList.add('is-floating');
        panel.classList.remove('hidden');
        panel.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');

        const triggerRect = trigger.getBoundingClientRect();
        panel.style.maxWidth = `${Math.max(0, triggerRect.left - 2 * gap)}px`;
        panel.style.maxHeight = `${Math.max(0, window.innerHeight - 2 * gap)}px`;
        const panelRect = panel.getBoundingClientRect();
        panel.style.left = `${Math.max(gap, triggerRect.left - gap - panelRect.width)}px`;
        panel.style.top = `${Math.max(gap, Math.min(
            triggerRect.top + (triggerRect.height - panelRect.height) / 2,
            window.innerHeight - gap - panelRect.height,
        ))}px`;

        if (focusFirst) {
            panel.querySelector('a, button')?.focus();
        }
    };

    document.addEventListener('click', (event) => {
        if (!(event.target instanceof Element)) {
            return;
        }

        const trigger = event.target.closest('[data-menu-trigger], [data-action-menu-trigger]');
        if (trigger) {
            const wasOpen = openMenu?.trigger === trigger;
            closeMenu();
            if (!wasOpen) {
                showMenu(trigger);
            }
        } else if (openMenu && !openMenu.panel.contains(event.target)) {
            closeMenu();
        } else if (openMenu && event.target.closest('a, button')) {
            const panel = openMenu.panel;
            setTimeout(() => {
                if (openMenu?.panel === panel) {
                    closeMenu();
                }
            }, 0);
        }
    });

    document.addEventListener('keydown', (event) => {
        const trigger = event.target instanceof Element
            ? event.target.closest('[data-menu-trigger], [data-action-menu-trigger]')
            : null;

        if (trigger && event.key === 'ArrowDown') {
            event.preventDefault();
            closeMenu();
            showMenu(trigger, true);
        } else if (openMenu && event.key === 'Escape') {
            event.preventDefault();
            closeMenu(true);
        } else if (openMenu && openMenu.panel.contains(event.target)
            && ['ArrowDown', 'ArrowUp', 'Home', 'End'].includes(event.key)) {
            const items = Array.from(openMenu.panel.querySelectorAll('a, button:not([disabled])'));
            if (items.length === 0) {
                return;
            }
            event.preventDefault();
            const current = items.indexOf(document.activeElement);
            const index = event.key === 'Home' ? 0
                : event.key === 'End' ? items.length - 1
                    : (current + (event.key === 'ArrowDown' ? 1 : -1) + items.length) % items.length;
            items[index].focus();
        }
    });

    document.addEventListener('focusin', (event) => {
        if (openMenu && event.target !== openMenu.trigger && !openMenu.panel.contains(event.target)) {
            closeMenu();
        }
    });
    document.addEventListener('scroll', (event) => {
        if (openMenu && !openMenu.panel.contains(event.target)) {
            closeMenu();
        }
    }, true);
    window.addEventListener('resize', () => closeMenu());
};

installActionMenus();

const personNamePattern = /^[\p{L}]+(?:[ '\u2019-][\p{L}]+)*$/u;
const strictPersonNamePattern = /^[\p{L}]+(?:[ -][\p{L}]+)*$/u;
const phoneFieldNames = new Set([
    'caregiver_contact',
    'contact_number',
    'emergency_contact_number',
    'mobile_number',
    'phone',
    'phone_number',
    'telephone_number',
]);
const personNameFieldNames = new Set([
    'attended_by',
    'emergency_contact_name',
    'first_name',
    'last_name',
    'middle_name',
]);

const fieldName = (input) => input.name.match(/\[([^\]]+)\]$/)?.[1] || input.name;

const isPersonNameInput = (input) => input.hasAttribute('data-person-name-strict')
    || personNameFieldNames.has(fieldName(input));

const isNamePartInput = (input) => input.hasAttribute('data-person-name-strict')
    || /^(?:emergency_contact_)?(?:first|middle|last)_name$/.test(fieldName(input));

const isPhoneInput = (input) => phoneFieldNames.has(fieldName(input));
const isSearchInput = (input) => input.name === 'search';

const filterInputCharacters = (input, invalidCharacters) => {
    const position = input.selectionStart ?? input.value.length;
    const filtered = input.value.replace(invalidCharacters, '');

    if (filtered !== input.value) {
        const filteredPosition = input.value.slice(0, position).replace(invalidCharacters, '').length;
        input.value = filtered;
        input.setSelectionRange(filteredPosition, filteredPosition);
    }
};

const filterFormInput = (input) => {
    if (isNamePartInput(input)) {
        filterInputCharacters(input, input.hasAttribute('data-person-name-strict')
            ? /[^\p{L} -]/gu
            : /[^\p{L} '\u2019-]/gu);
    } else if (fieldName(input) === 'philhealth_number') {
        filterInputCharacters(input, /[^0-9]/g);
    }

    if (isPersonNameInput(input)) {
        validatePersonNameInput(input);
    }
};

const validatePersonNameInput = (input) => {
    const strict = input.hasAttribute('data-person-name-strict');
    const hasInvalidName = input.value !== ''
        && !(strict ? strictPersonNamePattern : personNamePattern).test(input.value);

    input.setCustomValidity(
        hasInvalidName
            ? (strict ? 'Use letters, spaces, and hyphens only.' : 'Use letters, spaces, hyphens, and apostrophes only.')
            : '',
    );

    if (hasInvalidName) {
        input.setAttribute('aria-invalid', 'true');
    } else {
        input.removeAttribute('aria-invalid');
    }
};

const normalizeMobileNumber = (value) => {
    const trimmedValue = value.trim();
    if (!/^[+\d\s().-]+$/.test(trimmedValue)) {
        return value;
    }

    let digits = trimmedValue.replace(/\D/g, '');

    if (digits.startsWith('0063')) {
        digits = digits.slice(2);
    }

    if (/^09\d{9}$/.test(digits)) {
        return `63${digits.slice(1)}`;
    }

    if (/^9\d{9}$/.test(digits)) {
        return `63${digits}`;
    }

    if (/^639\d{9}$/.test(digits)) {
        return digits;
    }

    return value;
};

const formatMobileNumberForDisplay = (value) => {
    const normalizedValue = normalizeMobileNumber(value);

    if (!/^639\d{9}$/.test(normalizedValue)) {
        return normalizedValue;
    }

    return `+${normalizedValue.slice(0, 4)} ${normalizedValue.slice(4, 8)} ${normalizedValue.slice(8)}`;
};

const formatLocalMobileNumber = (value) => {
    const normalized = normalizeMobileNumber(value);
    const digits = /^639\d{9}$/.test(normalized)
        ? `0${normalized.slice(2)}`
        : value.replace(/\D/g, '').slice(0, 11);

    return [digits.slice(0, 4), digits.slice(4, 8), digits.slice(8)]
        .filter(Boolean)
        .join('-');
};

const prepareLocalMobileInput = (input, preserveCaret = false) => {
    const caret = input.selectionStart ?? input.value.length;
    const digitsBeforeCaret = input.value.slice(0, caret).replace(/\D/g, '').length;
    const formatted = formatLocalMobileNumber(input.value);

    input.type = 'tel';
    input.inputMode = 'numeric';
    input.maxLength = 13;
    input.placeholder = '09XX-XXXX-XXX';
    input.title = 'Enter an 11-digit mobile number starting with 09.';
    input.value = formatted;
    input.setCustomValidity(
        formatted !== '' && !/^09\d{2}-\d{4}-\d{3}$/.test(formatted)
            ? 'Enter an 11-digit mobile number starting with 09.'
            : '',
    );

    if (preserveCaret) {
        let position = 0;
        let digits = 0;
        while (position < formatted.length && digits < digitsBeforeCaret) {
            if (/\d/.test(formatted[position])) {
                digits++;
            }
            position++;
        }
        input.setSelectionRange(position, position);
    }
};

const updateBirthDateAge = (input) => {
    const ageInput = input.parentElement?.nextElementSibling?.querySelector('[data-age-display]');
    if (!ageInput) {
        return;
    }

    const birthDate = input.value;
    const today = input.dataset.today;
    if (!birthDate || !today || birthDate > today || input.validity.badInput || input.validity.rangeOverflow) {
        ageInput.value = '';
        return;
    }

    const [birthYear, birthMonth, birthDay] = birthDate.split('-').map(Number);
    const [year, month, day] = today.split('-').map(Number);
    const beforeBirthday = month < birthMonth || (month === birthMonth && day < birthDay);
    ageInput.value = String(year - birthYear - Number(beforeBirthday));
};

const preparePhoneInput = (input) => {
    if (input.hasAttribute('data-local-mobile')) {
        prepareLocalMobileInput(input);
        return;
    }

    input.type = 'tel';
    input.inputMode = 'numeric';
    input.maxLength = 24;
    input.title = 'Only Globe and DITO SIM numbers are supported.';
    input.placeholder = '+6391 7123 4567';
    input.value = formatMobileNumberForDisplay(input.value);
};

const prepareSearchInput = (input) => {
    input.maxLength = 255;
};

const installFormInputFormatting = () => {
    document.querySelectorAll('input[name]').forEach((input) => {
        if (isPersonNameInput(input)) {
            input.style.textTransform = 'capitalize';
            validatePersonNameInput(input);
        }

        if (isSearchInput(input)) {
            prepareSearchInput(input);
        }

        if (isPhoneInput(input)) {
            preparePhoneInput(input);
        }
        if (input.hasAttribute('data-age-source')) {
            updateBirthDateAge(input);
        }
    });

    document.addEventListener('focusin', (event) => {
        if (event.target instanceof HTMLInputElement) {
            if (isPersonNameInput(event.target)) {
                event.target.style.textTransform = 'capitalize';
                validatePersonNameInput(event.target);
            }

            if (isSearchInput(event.target)) {
                prepareSearchInput(event.target);
            }

            if (isPhoneInput(event.target)) {
                preparePhoneInput(event.target);
            }
        }
    });

    document.addEventListener('input', (event) => {
        const input = event.target;
        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        if (!event.isComposing) {
            filterFormInput(input);
        }
        if (input.hasAttribute('data-local-mobile')) {
            prepareLocalMobileInput(input, true);
        }
        if (input.hasAttribute('data-age-source')) {
            updateBirthDateAge(input);
        }
    });

    document.addEventListener('compositionend', (event) => {
        if (event.target instanceof HTMLInputElement) {
            filterFormInput(event.target);
        }
    });

    document.addEventListener('paste', (event) => {
        const input = event.target;
        if (!(input instanceof HTMLInputElement) || !input.hasAttribute('data-local-mobile')) {
            return;
        }

        const pasted = event.clipboardData?.getData('text');
        if (pasted === undefined) {
            return;
        }

        event.preventDefault();
        const start = input.selectionStart ?? input.value.length;
        const end = input.selectionEnd ?? start;
        const replacement = formatLocalMobileNumber(pasted);
        input.value = input.value.slice(0, start) + replacement + input.value.slice(end);
        input.setSelectionRange(start + replacement.length, start + replacement.length);
        prepareLocalMobileInput(input, true);
    });

    document.addEventListener('focusout', (event) => {
        if (event.target instanceof HTMLInputElement && isPhoneInput(event.target)) {
            preparePhoneInput(event.target);
        }
    });

    document.addEventListener('submit', (event) => {
        if (event.target instanceof HTMLFormElement) {
            event.target.querySelectorAll('input[name]').forEach((input) => {
                if (isPhoneInput(input)) {
                    preparePhoneInput(input);
                }
            });
        }
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', installFormInputFormatting, { once: true });
} else {
    installFormInputFormatting();
}

const installDeleteConfirmations = () => {
    const dialog = document.createElement('dialog');
    dialog.className = 'delete-confirmation';
    dialog.setAttribute('aria-labelledby', 'delete-confirmation-title');
    dialog.setAttribute('aria-describedby', 'delete-confirmation-description');
    dialog.innerHTML = `
        <div class="delete-confirmation__card">
            <div class="delete-confirmation__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 9v4m0 4h.01M10.3 3.6 2.6 17a2 2 0 0 0 1.73 3h15.34a2 2 0 0 0 1.73-3L13.7 3.6a2 2 0 0 0-3.4 0Z" />
                </svg>
            </div>
            <p class="delete-confirmation__eyebrow">Please confirm</p>
            <h2 id="delete-confirmation-title" class="delete-confirmation__title"></h2>
            <p id="delete-confirmation-description" class="delete-confirmation__description"></p>
            <div class="delete-confirmation__item" hidden>
                <span class="delete-confirmation__item-label">Selected item</span>
                <span class="delete-confirmation__item-value"></span>
            </div>
            <p class="delete-confirmation__notice">
                This action cannot be undone.
            </p>
            <div class="delete-confirmation__actions">
                <button type="button" class="delete-confirmation__confirm" data-delete-confirm>
                    Delete record
                </button>
                <button type="button" class="delete-confirmation__cancel" data-delete-cancel autofocus>
                    Keep record
                </button>
            </div>
        </div>
    `;

    document.body.appendChild(dialog);

    const title = dialog.querySelector('#delete-confirmation-title');
    const description = dialog.querySelector('#delete-confirmation-description');
    const item = dialog.querySelector('.delete-confirmation__item');
    const itemLabel = dialog.querySelector('.delete-confirmation__item-label');
    const itemValue = dialog.querySelector('.delete-confirmation__item-value');
    const notice = dialog.querySelector('.delete-confirmation__notice');
    const cancelButton = dialog.querySelector('[data-delete-cancel]');
    const confirmButton = dialog.querySelector('[data-delete-confirm]');
    const confirmedForms = new WeakSet();

    let pendingForm = null;
    let pendingSubmitter = null;
    let pendingRemoveButton = null;
    let returnFocus = null;

    const openConfirmation = (form, submitter = null, trigger = null) => {
        pendingForm = form;
        pendingSubmitter = submitter;
        const source = trigger || submitter || document.activeElement;
        const menu = source instanceof Element ? source.closest('.clay-action-menu') : null;
        returnFocus = (menu && actionMenuTriggers.get(menu)) || source;

        const actionText = (
            submitter?.dataset.confirmButton
            || form.dataset.confirmButton
            || submitter?.textContent
            || ''
        ).trim();
        const isCancellation = /cancel/i.test(actionText)
            || form.dataset.confirmKind === 'cancel';

        title.textContent = trigger?.dataset.confirmTitle
            || form.dataset.confirmTitle
            || (isCancellation ? 'Cancel this record?' : 'Delete this record?');
        description.textContent = trigger?.dataset.confirmMessage
            || form.dataset.confirmMessage
            || (isCancellation
                ? 'The record status will be changed. Please confirm before continuing.'
                : 'Please make sure you selected the correct record before continuing.');

        const itemText = trigger?.dataset.confirmItem
            || trigger?.dataset.name
            || trigger?.dataset.householdCode
            || form.dataset.confirmItem
            || '';
        item.hidden = itemText === '';
        itemLabel.textContent = 'Selected item';
        itemValue.textContent = itemText;
        notice.textContent = 'This action cannot be undone.';

        confirmButton.textContent = form.dataset.confirmButton
            || (isCancellation ? 'Cancel record' : (actionText || 'Delete'));
        confirmButton.disabled = false;
        cancelButton.textContent = 'Cancel';

        if (!dialog.open) {
            dialog.showModal();
        }
    };

    const openRemoveConfirmation = (button) => {
        const card = button.closest('.member-card');
        const firstName = card?.querySelector('[data-field="first_name"], input[name$="[first_name]"]')?.value.trim();
        const middleName = card?.querySelector('[data-field="middle_name"], input[name$="[middle_name]"]')?.value.trim();
        const lastName = card?.querySelector('[data-field="last_name"], input[name$="[last_name]"]')?.value.trim();
        const memberName = [firstName, middleName, lastName].filter(Boolean).join(' ');

        pendingForm = null;
        pendingSubmitter = null;
        pendingRemoveButton = button;
        returnFocus = button;

        title.textContent = 'Remove this family member?';
        description.textContent = 'The family member will be removed from this form.';
        item.hidden = memberName === '';
        itemLabel.textContent = 'Family member';
        itemValue.textContent = memberName;
        notice.textContent = 'Save the form to apply this change.';
        confirmButton.textContent = 'Remove';
        confirmButton.disabled = false;
        cancelButton.textContent = 'Cancel';

        if (!dialog.open) {
            dialog.showModal();
        }
    };

    const formFromTrigger = (trigger) => {
        const formId = trigger.dataset.formId || trigger.dataset.deleteFormId;

        if (formId) {
            return document.getElementById(formId);
        }

        const targetSelector = trigger.dataset.confirmForm;
        if (targetSelector) {
            return document.querySelector(targetSelector);
        }

        if (trigger.dataset.deleteAction) {
            return document.getElementById('deleteScheduleForm');
        }

        if (trigger.classList.contains('trigger-delete-modal')) {
            return document.querySelector('.clay-confirm-overlay form')
                || document.getElementById('deleteChildHealthForm')
                || document.getElementById('deleteSeniorForm');
        }

        if (trigger.id === 'triggerDeleteModal') {
            return document.querySelector('#deleteMaternalModal form')
                || document.querySelector('#deleteSeniorModal form')
                || document.getElementById('deleteForm');
        }

        return null;
    };

    document.addEventListener('click', (event) => {
        if (!(event.target instanceof Element)) {
            return;
        }

        const trigger = event.target.closest(
            '.remove-member, [data-delete-household], .trigger-delete-modal, #triggerDeleteModal, ' +
            '#deleteImmunizationButton, [data-confirm-delete], [data-delete-maternal]'
        );

        if (!trigger) {
            return;
        }

        if (trigger.classList.contains('remove-member')) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
            openRemoveConfirmation(trigger);
            return;
        }

        const form = formFromTrigger(trigger);
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        const action = trigger.dataset.action || trigger.dataset.deleteAction;
        if (action) {
            form.action = action;
        }

        const itemText = trigger.dataset.confirmItem
            || trigger.dataset.name
            || [
                trigger.dataset.residentName,
                trigger.dataset.recordDetail,
            ].filter(Boolean).join(' · ')
            || [trigger.dataset.householdCode, trigger.dataset.householdHead]
                .filter(Boolean)
                .join(' · ');
        if (itemText) {
            trigger.dataset.confirmItem = itemText;
        }

        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        openConfirmation(form, null, trigger);
    }, true);

    document.addEventListener('submit', (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        if (confirmedForms.has(form)) {
            confirmedForms.delete(form);
            return;
        }

        const methodOverride = form.querySelector('input[name="_method"]')?.value;
        if (form.method.toLowerCase() !== 'delete' && methodOverride?.toLowerCase() !== 'delete') {
            return;
        }

        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();
        openConfirmation(form, event.submitter);
    }, true);

    cancelButton.addEventListener('click', () => dialog.close());
    dialog.addEventListener('click', (event) => {
        if (event.target === dialog) {
            dialog.close();
        }
    });
    dialog.addEventListener('close', () => {
        pendingForm = null;
        pendingSubmitter = null;
        pendingRemoveButton = null;
        returnFocus?.focus({ preventScroll: true });
    });

    confirmButton.addEventListener('click', () => {
        if (pendingRemoveButton) {
            const button = pendingRemoveButton;

            button.dispatchEvent(new CustomEvent('remove-member-confirmed', {
                bubbles: true,
                detail: { button },
            }));

            confirmButton.disabled = true;
            dialog.close();
            return;
        }

        if (!pendingForm || !pendingForm.reportValidity()) {
            return;
        }

        const form = pendingForm;
        const submitter = pendingSubmitter;

        confirmedForms.add(form);
        confirmButton.disabled = true;
        dialog.close();

        if (submitter instanceof HTMLElement && form.contains(submitter)) {
            form.requestSubmit(submitter);
        } else {
            form.requestSubmit();
        }
    });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', installDeleteConfirmations, { once: true });
} else {
    installDeleteConfirmations();
}