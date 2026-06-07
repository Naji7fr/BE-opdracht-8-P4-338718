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

    var deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!window.confirm('Weet u zeker dat u dit voertuig wilt verwijderen?')) {
                event.preventDefault();
            }
        });
    });
});
