"use strict";

export default function errorPlacement(error, element) {
    if (!element.attr('name')) {
        return;
    }
    error.addClass("invalid-feedback");
    if (element.is("select")) {
        error.insertAfter(element.next("span"));
    } else if (element.parent().hasClass("input-group")) {
        error.insertAfter(element.parent());
    } else if (element.is("textarea")) {
        if (element.next().hasClass('ck-editor')) {
            error.insertAfter(element.next('div'));
        } else {
            error.insertAfter(element);
        }
    } else if (element.hasClass("dropify")) {
        error.insertAfter(element.closest('.dropify-wrapper'));
    } else if (element.hasClass('flatpickr-input')) {
        error.appendTo(element.parent());
    } else {
        if (element.parent().hasClass('form-group')) {
            element.closest('.form-group').append(error);
        } else {
            error.insertAfter(element);
        }
    }
}
