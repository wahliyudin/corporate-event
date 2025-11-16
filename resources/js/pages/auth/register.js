"use strict";

import handleAjaxError from "../../tools/handle-ajax-error";
import "./../../tools/select2/select2";
import { toastSuccess } from "../../tools/toast/toast";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('#formRegister [name="company"]').length) {
        $('#formRegister [name="company"]').objSelect2({
            dropdownParent: $('#formRegister .company-container'),
            api: {
                url: `${origin}/companies/data-select`,
                method: 'GET',
                firstOption: '<option selected disabled value="">- Select -</option>'
            },
        });
    }

    $(document).on('click', '#formRegister #btnSubmit', function (e) {
        e.preventDefault();
        const btnSubmit = this;
        $(btnSubmit).attr('data-indicator', 'on').prop('disabled', true);
        const formData = new FormData($('#formRegister')[0]);
        $.ajax({
            type: "POST",
            url: `${origin}/register`,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $(btnSubmit).attr('data-indicator', 'off');
                toastSuccess('Register successfully');
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