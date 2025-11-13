"use strict";

import toastMessage from "./toast/toast-message.js";

export default function handleAjaxError(xhr, defaultMessage) {
    if (xhr.status == 500) {
        toastMessage('error', 'Server Error 500');
        return;
    }
    var response = JSON.parse(xhr.responseText);
    var message = response.message || defaultMessage;
    if (xhr.status === 422) {
        var errors = response.errors;
        if (errors && errors.length > 1) {
            $.each(errors, function (key, value) {
                message += '\n' + value;
            });
        }
        toastMessage('warning', message);
    } else if (xhr.status == 419) {
        Swal.fire({
            icon: 'warning',
            title: 'Peringatan!',
            text: "Session anda telah habis. Silahkan login kembali.",
        }).then(function () {
            window.location = `${origin}/login`;
        });
    } else if ([400, 401, 403, 404].includes(xhr.status)) {
        toastMessage('warning', message);
    } else {
        toastMessage('error', message);
    }
    return message;
}
