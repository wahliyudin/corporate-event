"use strict";

import handleAjaxError from "../../../tools/handle-ajax-error";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.all').click(function () {
        $('input[name="menu"]').prop('checked', this.checked);
        $('input[name="modul[]"]').prop('checked', this.checked);
        $('input[name="permissions[]"]').prop('checked', this.checked);
    });
    $(".checkall_modul").click(function () {
        var menu = this.value;
        $("." + menu).prop('checked', this.checked);
        $(".sub_" + menu).prop('checked', this.checked);
    });

    $(".checkall_fitur").click(function () {
        var modulid = this.value;
        $(this).closest('tr').find('.fitur').prop('checked', this.checked);
        var checkboxes = $('.checkall_fitur[name="modul[]"][value="' + modulid + '"]');
        var allChecked = checkboxes.length === checkboxes.filter(':checked').length;
        $('.checkall_modul[name="menu"][value="' + modulid + '"]').prop('checked', allChecked);
    });

    $(".fitur").click(function () {
        var countActivefitur = $(this).closest('tr').find('.fitur:checked').length;
        if (countActivefitur > 0) {
            $(this).closest('tr').find('.checkall_fitur').prop('checked', true);
        } else {
            $(this).closest('tr').find('.checkall_fitur').prop('checked', false);
        }
    });

    window.handleRoleClick = function (checkbox) {
        const roleId = checkbox.value;
        const isChecked = checkbox.checked;

        $.ajax({
            url: `${origin}/setting/get-role-permissions/${roleId}`,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                const permissionIds = response.permissions;

                permissionIds.forEach(function (id) {
                    const cb = $(`input.fitur[value="${id}"]`);
                    if (cb.length) {
                        cb.prop('checked', isChecked); // Centang jika role dicentang, uncentang jika tidak
                    }
                });
            },
            error: function (xhr) {
                handleAjaxError(xhr);
            }
        });
    };
})
