"use strict";

import '../../../tools/crud-manager';

$(function () {
    window.origin = $('meta[name="url"]').attr('content');
    var settings = new $.fn.crudManager.Builder()
        .setDataTableUrl(`${origin}/setting/permission/datatable`)
        .setServerSide(true)
        .setColumns([
            {
                data: null,
                render: function (data, type, row) {
                    if (row.can_setting) {
                        return `
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <a href="${origin}/setting/permission/${row.id}/edit" class="btn btn-sm btn-primary-light btn-icon d-flex align-items-center justify-content-center">
                                <i class='bx bx-cog' ></i>
                            </a>
                        </div>
                    `;
                    } else {
                        return '';
                    }
                },
                orderable: false,
                searchable: false
            },
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
                data: 'status',
                name: 'status'
            },
        ])
        .build();
    $('#datatable').crudManager(settings);
});
