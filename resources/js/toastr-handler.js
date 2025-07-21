// public/js/toastr-handler.js

document.addEventListener('DOMContentLoaded', function () {
    // Toastr default options
    console.log("eeeeeeeeeeeeeeeeegu")
    toastr.options = {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
    };

    // Ambil pesan dari window.Laravel
    if (window.Laravel && window.Laravel.sessionMessages) {
        const messages = window.Laravel.sessionMessages;

        // Validation Errors
        if (Array.isArray(messages.errors)) {
            messages.errors.forEach(function (msg) {
                toastr.error(msg);
            });
        }

        // Success message
        if (messages.success) {
            toastr.success(messages.success);
        }

        // Error message
        if (messages.error) {
            toastr.error(messages.error);
        }
    }
});
