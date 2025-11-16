"use strict";

import handleAjaxError from "../../../tools/handle-ajax-error.js";
import "./../../../tools/crud-manager.js";
import { action } from "./action.js";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var settings = new $.fn.crudManager.Builder()
        .setDataTableUrl(`${origin}/approvals/user/outstanding-datatable`)
        .setColumns([
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'company',
                name: 'company'
            },
            {
                data: null,
                render: action,
                orderable: false,
                searchable: false
            },
        ])
        .build();
    $('#datatable').crudManager(settings);

    function getUrlParam(param) {
        const url = new URL(window.location.href);
        return url.searchParams.get(param);
    }

    var keyword = getUrlParam('search');

    if (keyword) {
        $('#datatable').data('dataTableInstance').search(keyword).draw();
    }

    $(document).on('click', '#btn-approve', function (e) {
        e.preventDefault();
        var button = this;
        var key = $(this).data('key');
        $(button).attr("data-indicator", "on");
        Swal.fire({
            title: 'Please confirm your approval',
            text: 'Are you sure you want to approve this user?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve!',
            preConfirm: () => {
                return new Promise(function (resolve) {
                    $.ajax({
                        type: "POST",
                        url: `${origin}/approvals/user/${key}/approve`,
                        dataType: 'JSON',
                    })
                        .done(function (response) {
                            Swal.fire(
                                'Verified!',
                                response.message,
                                'success'
                            ).then(function () {
                                window.location = `${origin}/approvals/user`;
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
