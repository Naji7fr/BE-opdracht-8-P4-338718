document.addEventListener('DOMContentLoaded', function () {
    var timedMessages = document.querySelectorAll('.melding-timed');

    timedMessages.forEach(function (element) {
        var redirectUrl = element.getAttribute('data-redirect');
        var timeout = parseInt(element.getAttribute('data-timeout') || '3000', 10);

        if (redirectUrl) {
            window.setTimeout(function () {
                window.location.href = redirectUrl;
            }, timeout);
        }
    });

    var modal = document.getElementById('delete-modal');
    var confirmButton = document.getElementById('delete-modal-confirm');
    var pendingForm = null;

    if (!modal || !confirmButton) {
        return;
    }

    function openModal(form) {
        pendingForm = form;
        modal.hidden = false;
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        confirmButton.focus();
    }

    function closeModal() {
        pendingForm = null;
        modal.hidden = true;
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
    }

    document.querySelectorAll('.delete-form').forEach(function (form) {
        var trigger = form.querySelector('.icon-delete');

        if (!trigger) {
            return;
        }

        trigger.addEventListener('click', function (event) {
            event.preventDefault();
            openModal(form);
        });
    });

    confirmButton.addEventListener('click', function () {
        if (!pendingForm) {
            return;
        }

        var formToSubmit = pendingForm;
        closeModal();
        formToSubmit.submit();
    });

    modal.querySelectorAll('[data-modal-close]').forEach(function (element) {
        element.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.hidden) {
            closeModal();
        }
    });
});
