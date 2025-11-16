"use strict";

import "./../../../tools/crud-manager.js";
import { action } from "./action.js";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');

    const MAX_LENGTH = 50;

    var settings = new $.fn.crudManager.Builder()
        .setDataTableUrl(`${origin}/approvals/event/outstanding-datatable`)
        .setStoreDataUrl(`${origin}/approvals/event/store`)
        .setFetchDataUrl(`${origin}/approvals/event/{id}/edit`)
        .setDeleteDataUrl(`${origin}/approvals/event/{id}/destroy`)
        .setColumns([
            {
                data: null,
                render: action,
                orderable: false,
                searchable: false
            },
            {
                data: 'number',
                name: 'number'
            },
            {
                data: 'requestor',
                name: 'requestor'
            },
            {
                data: 'title',
                name: 'title'
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'company',
                name: 'company'
            },
            {
                data: 'start_date',
                name: 'start_date'
            },
            {
                data: 'end_date',
                name: 'end_date'
            },
            {
                data: 'location',
                name: 'location',
                className: 'text-wrap',
                render: function (data, type, row, meta) {
                    if (type === 'display') {
                        const shortText = data.length > MAX_LENGTH ? data.substring(0, MAX_LENGTH) + '...' : data;
                        const isLong = data.length > MAX_LENGTH;
                        return `
                        <span class="desc-short">${shortText}</span>
                        ${isLong ? `<span class="desc-full d-none">${data}</span>
                        <a href="#" class="toggle-more text-primary ms-1">More</a>` : ''}
                      `;
                    }
                    return data;
                }
            },
            {
                data: 'created_at',
                name: 'created_at'
            },
        ])
        .build();
    $('#datatable').crudManager(settings);

    let expandedRow = null;

    $('#datatable').on('click', '.toggle-more', function (e) {
        e.preventDefault();

        const $link = $(this);
        const $cell = $link.closest('td');
        const $short = $cell.find('.desc-short');
        const $full = $cell.find('.desc-full');

        if (expandedRow && expandedRow[0] !== $cell[0]) {
            const $prevLink = expandedRow.find('.toggle-more');
            const $prevShort = expandedRow.find('.desc-short');
            const $prevFull = expandedRow.find('.desc-full');
            $prevFull.addClass('d-none');
            $prevShort.removeClass('d-none');
            $prevLink.text('More');
        }

        const isExpanded = !$full.hasClass('d-none');
        if (isExpanded) {
            $full.addClass('d-none');
            $short.removeClass('d-none');
            $link.text('More');
            expandedRow = null;
        } else {
            $short.addClass('d-none');
            $full.removeClass('d-none');
            $link.text('Less');
            expandedRow = $cell;
        }
    });

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
