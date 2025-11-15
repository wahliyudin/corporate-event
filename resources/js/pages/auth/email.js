"use strict";

import handleAjaxError from "../../tools/handle-ajax-error";
import { toastSuccess } from "../../tools/toast/toast";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('click', '#formForgotPassword #btnSubmit', function (e) {
        e.preventDefault();
        const btnSubmit = this;
        $(btnSubmit).attr('data-indicator', 'on').prop('disabled', true);
        const formData = new FormData($('#formForgotPassword')[0]);
        $.ajax({
            type: "POST",
            url: `${origin}/password/email`,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $(btnSubmit).attr('data-indicator', 'off').prop('disabled', false);
                toastSuccess('Link has been sent to your email');
            },
            error: function (xhr) {
                $(btnSubmit).attr('data-indicator', 'off').prop('disabled', false);
                handleAjaxError(xhr);
            }
        });
    });
})