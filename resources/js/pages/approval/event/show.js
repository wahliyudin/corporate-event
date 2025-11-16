"use strict";

import handleAjaxError from "../../../tools/handle-ajax-error";

$(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    window.origin = $('meta[name="url"]').attr('content');
    $(document).on('click', '#btn-approve', function (e) {
        e.preventDefault();
        var button = this;
        var key = $(this).data('key');
        $(button).attr("data-indicator", "on");
        Swal.fire({
            title: 'Please confirm your approval',
            text: 'Are you sure you want to approve this event?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve!',
            preConfirm: () => {
                return new Promise(function (resolve) {
                    $.ajax({
                        type: "POST",
                        url: `${origin}/approvals/event/${key}/approve`,
                        dataType: 'json',
                    })
                        .done(function (response) {
                            Swal.fire(
                                'Verified!',
                                response.message,
                                'success'
                            ).then(function () {
                                window.location = `${origin}/approvals/event`;
                            });
                        })
                        .fail(function (xhr) {
                            handleAjaxError(xhr);
                            resolve();
                        })
                })
            },
            willClose: () => {
                $(button).removeAttr("data-indicator");
            }
        });
    });

    $(document).on('click', '#btn-reject', function (e) {
        e.preventDefault();
        var button = this;
        var key = $(this).data('key');
        $(button).attr("data-indicator", "on");
        Swal.fire({
            title: 'Please confirm your approval',
            text: 'Are you sure you want to reject this event?',
            input: 'textarea',
            icon: 'warning',
            inputPlaceholder: 'Reason',
            showCancelButton: true,
            confirmButtonText: 'Yes, reject!',
            cancelButtonText: "Cancel",
            reverseButtons: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            showLoaderOnConfirm: true,
            inputValidator: (value) => {
                if (!value) {
                    return 'Reason is required!'
                }
            },
            preConfirm: async (reason) => {
                return await $.ajax({
                    type: "POST",
                    url: `${origin}/approvals/event/${key}/reject`,
                    data: {
                        reason: reason
                    },
                    dataType: 'json',
                })
                    .done(function (response) {
                        Swal.fire(
                            'Rejected!',
                            response.message,
                            'success'
                        ).then(function () {
                            window.location = `${origin}/approvals/event`;
                        });
                    })
                    .fail(function (xhr) {
                        Swal.hideLoading();
                        handleAjaxError(xhr);
                        resolve();
                    })
            },
            willClose: () => {
                $(button).removeAttr("data-indicator");
            }
        });
    });
});