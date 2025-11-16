"use strict";

import { toastWarning } from "../../../tools/toast/toast.js";
import "../../../tools/select2/select2.js";
import resetForm from "../../../tools/crud-manager/reset-form.js";
import "./../../../tools/crud-manager.js";
import { action } from "./action.js";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');

    let description = null;
    if ($('#form #description').length) {
        DecoupledEditor
            .create(document.querySelector(`#form #description`), {
                placeholder: 'Your content here...',
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|',
                        'heading', 'alignment',
                        '|',
                        'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        '|',
                        'bold', 'italic', 'strikethrough',
                        '|',
                        'blockQuote', 'codeBlock',
                        '|',
                        'bulletedList', 'numberedList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: false
                },
            })
            .then(editor => {
                const toolbarContainer = document.querySelector(`#form #description_toolbar`);
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                description = editor;
            })
            .catch(error => {
                toastWarning(error);
            });
    }

    let location = null;
    if ($('#form #location').length) {
        DecoupledEditor
            .create(document.querySelector(`#form #location`), {
                placeholder: 'Your content here...',
                toolbar: {
                    items: [
                        'undo', 'redo',
                        '|',
                        'heading', 'alignment',
                        '|',
                        'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        '|',
                        'bold', 'italic', 'strikethrough',
                        '|',
                        'blockQuote', 'codeBlock',
                        '|',
                        'bulletedList', 'numberedList', 'outdent', 'indent'
                    ],
                    shouldNotGroupWhenFull: false
                },
            })
            .then(editor => {
                const toolbarContainer = document.querySelector(`#form #location_toolbar`);
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                location = editor;
            })
            .catch(error => {
                toastWarning(error);
            });
    }

    const MAX_LENGTH = 50;

    var settings = new $.fn.crudManager.Builder()
        .setDataTableUrl(`${origin}/events/datatable`)
        .setStoreDataUrl(`${origin}/events/store`)
        .setFetchDataUrl(`${origin}/events/{id}/edit`)
        .setDeleteDataUrl(`${origin}/events/{id}/destroy`)
        .setGetFormDataCallback(function (formData) {
            formData.append('description', description.getData());
            formData.append('location', location.getData());
            return formData;
        })
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

    if ($('#form [name="category"]').length) {
        $('#form [name="category"]').objSelect2({
            dropdownParent: $('#form .category-container'),
            api: {
                url: `${origin}/events/categories/data-select`,
                method: 'GET',
                firstOption: '<option selected disabled value="">- Select -</option>'
            },
        });
    }

    let startDate = null;
    if ($('#form [name="start_date"]').length) {
        startDate = flatpickr('#form [name="start_date"]', {
            altInput: true,
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
        });
    }

    let endDate = null;
    if ($('#form [name="end_date"]').length) {
        endDate = flatpickr('#form [name="end_date"]', {
            altInput: true,
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
        });
    }

    $(document).on('crud:row-edit', function (e, data) {
        location.setData(data.location);
        description.setData(data.description);
    });

    $(document).on('crud:form-reset', function () {
        $('#form [name="location"]').val('');
        $('#form [name="description"]').val('');
        location.setData('');
        description.setData('');
    });
});
