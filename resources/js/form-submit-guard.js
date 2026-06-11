const SUBMIT_BUTTON_SELECTOR = 'button[type="submit"]';

const getSubmitButton = (form, event) => {
    if (
        event?.submitter instanceof HTMLButtonElement &&
        event.submitter.matches(SUBMIT_BUTTON_SELECTOR)
    ) {
        return event.submitter;
    }

    const active = document.activeElement;
    if (
        active instanceof HTMLButtonElement &&
        active.form === form &&
        active.matches(SUBMIT_BUTTON_SELECTOR)
    ) {
        return active;
    }

    return form.querySelector(`${SUBMIT_BUTTON_SELECTOR}:not([disabled])`);
};

const setButtonLoading = (button, isLoading) => {
    if (isLoading) {
        if (button.dataset.loading === 'true') {
            return;
        }

        if (!button.dataset.originalHtml) {
            button.dataset.originalHtml = button.innerHTML;
        }

        button.dataset.loading = 'true';
        button.disabled = true;
        button.setAttribute('aria-busy', 'true');
        button.classList.add('global-submit-loading');

        if (button.form) {
            button.form.dataset.submitGuardPending = 'true';
            formButtonMap.set(button.form, button);
        }

        const spinner = document.createElement('span');
        spinner.className = 'global-submit-spinner spinner-border spinner-border-sm';
        spinner.setAttribute('aria-hidden', 'true');

        const label = document.createElement('span');
        label.className = 'global-submit-label';
        label.innerHTML = button.dataset.originalHtml;

        button.innerHTML = '';
        button.append(spinner, label);
        return;
    }

    if (button.dataset.loading !== 'true') {
        return;
    }

    const original = button.dataset.originalHtml;
    if (original !== undefined) {
        button.innerHTML = original;
    }

    button.disabled = false;
    button.removeAttribute('aria-busy');
    button.classList.remove('global-submit-loading');
    delete button.dataset.loading;

    if (button.form) {
        delete button.form.dataset.submitGuardPending;
        delete button.form.dataset.submitGuardRequest;
        delete button.form.dataset.submitGuardSubmitting;
        formButtonMap.delete(button.form);
    }
};

const formButtonMap = new WeakMap();

const getLoadingButtonForForm = (form) =>
    form?.querySelector(`${SUBMIT_BUTTON_SELECTOR}[data-loading="true"]`) ||
    formButtonMap.get(form) ||
    null;

const formDataFormMap = new WeakMap();

const installFormDataTracking = () => {
    if (!window.FormData || window.FormData.__submitGuardWrapped) {
        return;
    }

    const NativeFormData = window.FormData;

    function FormDataProxy(...args) {
        const fd = new NativeFormData(...args);
        const maybeForm = args[0];
        if (maybeForm instanceof HTMLFormElement) {
            formDataFormMap.set(fd, maybeForm);
            const button = getSubmitButton(maybeForm, null);
            if (button) {
                maybeForm.dataset.submitGuardRequest = 'true';
                setButtonLoading(button, true);
            }
        }
        return fd;
    }

    FormDataProxy.prototype = NativeFormData.prototype;
    FormDataProxy.__submitGuardWrapped = true;
    window.FormData = FormDataProxy;
};

const installFetchHook = () => {
    if (!window.fetch || window.fetch.__submitGuardWrapped) {
        return;
    }

    const nativeFetch = window.fetch.bind(window);

    window.fetch = (input, init = {}) => {
        const body = init?.body;
        if (body instanceof FormData && formDataFormMap.has(body)) {
            const form = formDataFormMap.get(body);
            const button = getLoadingButtonForForm(form);
            const request = nativeFetch(input, init);
            request.finally(() => {
                if (button && button.dataset.loading === 'true') {
                    setButtonLoading(button, false);
                }
            });
            return request;
        }

        return nativeFetch(input, init);
    };

    window.fetch.__submitGuardWrapped = true;
};

const installAxiosHook = () => {
    if (!window.axios || window.axios.__submitGuardWrapped) {
        return;
    }

    window.axios.interceptors.response.use(
        (response) => {
            const data = response?.config?.data;
            if (data instanceof FormData && formDataFormMap.has(data)) {
                const form = formDataFormMap.get(data);
                const button = getLoadingButtonForForm(form);
                if (button && button.dataset.loading === 'true') {
                    setButtonLoading(button, false);
                }
            }
            return response;
        },
        (error) => {
            const data = error?.config?.data;
            if (data instanceof FormData && formDataFormMap.has(data)) {
                const form = formDataFormMap.get(data);
                const button = getLoadingButtonForForm(form);
                if (button && button.dataset.loading === 'true') {
                    setButtonLoading(button, false);
                }
            }
            return Promise.reject(error);
        }
    );

    window.axios.__submitGuardWrapped = true;
};

installFormDataTracking();
installFetchHook();
installAxiosHook();

document.addEventListener(
    'click',
    (event) => {
        const target = event.target;
        const button =
            target instanceof HTMLElement ? target.closest(SUBMIT_BUTTON_SELECTOR) : null;
        if (!button || !(button instanceof HTMLButtonElement)) {
            return;
        }

        const form = button.form;
        if (!form) {
            return;
        }

        if (button.dataset.loading === 'true') {
            event.preventDefault();
            event.stopImmediatePropagation();
        }
    },
    true
);

document.addEventListener(
    'submit',
    (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        const submitButton = getSubmitButton(form, event);
        if (!submitButton) {
            return;
        }

        if (submitButton.dataset.loading === 'true') {
            event.preventDefault();
            event.stopImmediatePropagation();
            return;
        }

        form.dataset.submitGuardSubmitting = 'true';
        setButtonLoading(submitButton, true);
    },
    true
);

document.addEventListener(
    'formdata',
    (event) => {
        const form = event.target;
        if (!(form instanceof HTMLFormElement)) {
            return;
        }

        const submitButton = getLoadingButtonForForm(form);
        if (!submitButton) {
            return;
        }

        form.dataset.submitGuardRequest = 'true';
    },
    true
);
