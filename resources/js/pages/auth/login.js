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

    $(document).on('click', '#formLogin #btnSubmit', function (e) {
        e.preventDefault();
        const btnSubmit = this;
        $(btnSubmit).attr('data-indicator', 'on').prop('disabled', true);
        const formData = new FormData($('#formLogin')[0]);
        $.ajax({
            type: "POST",
            url: `${origin}/login`,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $(btnSubmit).attr('data-indicator', 'off');
                toastSuccess('Login successfully');
                setTimeout(() => {
                    window.location = `${origin}/`;
                }, 500);
            },
            error: function (xhr) {
                $(btnSubmit).attr('data-indicator', 'off').prop('disabled', false);
                handleAjaxError(xhr);
            }
        });
    });
})