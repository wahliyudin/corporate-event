"use strict";

export default function generateValidationRules(formSelector) {
    const rules = {};
    $(formSelector).find(':input').each(function () {
        const inputName = $(this).attr('name');
        if (!inputName) return;
        if ($(this).prop('required')) rules[inputName] = { required: true };
    });
    return rules;
}
