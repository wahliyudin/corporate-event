"use strict";

import "./../../../tools/crud-manager.js";
import "./color.js";
import { action } from "./action.js";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');

    var settings = new $.fn.crudManager.Builder()
        .setDataTableUrl(`${origin}/events/categories/datatable`)
        .setStoreDataUrl(`${origin}/events/categories/store`)
        .setFetchDataUrl(`${origin}/events/categories/{id}/edit`)
        .setDeleteDataUrl(`${origin}/events/categories/{id}/destroy`)
        .setColumns([
            {
                data: null,
                render: action,
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'color',
                name: 'color'
            },
        ])
        .build();
    $('#datatable').crudManager(settings);
});
