import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const personNamePattern = /^[\p{L}]+(?:[ '\u2019-][\p{L}]+)*$/u;
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

const isPersonNameInput = (input) => personNameFieldNames.has(fieldName(input));

const isPhoneInput = (input) => phoneFieldNames.has(fieldName(input));
const isSearchInput = (input) => input.name === 'search';

const validatePersonNameInput = (input) => {
    const hasInvalidName = input.value !== '' && !personNamePattern.test(input.value);

    input.setCustomValidity(
        hasInvalidName
            ? 'Use letters, spaces, hyphens, and apostrophes only.'
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

const preparePhoneInput = (input) => {
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

        if (isPersonNameInput(input)) {
            validatePersonNameInput(input);
        }
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
        returnFocus = trigger || submitter || document.activeElement;

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
            || (isCancellation ? 'Cancel this certificate?' : 'Delete this record?');
        description.textContent = trigger?.dataset.confirmMessage
            || form.dataset.confirmMessage
            || (isCancellation
                ? 'The certificate status will be changed. Please confirm before continuing.'
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
            || (isCancellation ? 'Cancel certificate' : (actionText || 'Delete'));
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