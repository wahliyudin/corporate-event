"use strict";

import "./../../tools/crud-manager.js";
import { action } from "./action.js";

$(function () {
    window.origin = $('meta[name="url"]').attr('content');
    var settings = new $.fn.crudManager.Builder()
        .setDataTableUrl(`${origin}/companies/datatable`)
        .setStoreDataUrl(`${origin}/companies/store`)
        .setFetchDataUrl(`${origin}/companies/{id}/edit`)
        .setDeleteDataUrl(`${origin}/companies/{id}/destroy`)
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
        ])
        .build();
    $('#datatable').crudManager(settings);
});
