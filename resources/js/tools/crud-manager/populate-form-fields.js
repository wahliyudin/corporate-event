"use strict";

export default function populateFormFields(formSelector, data) {
    $(formSelector).find(':input').each(function () {
        var inputName = $(this).attr('name');
        if (inputName && data[inputName] !== undefined) {
            if ($(this).hasClass('select2') || $(this).is('select')) {
                $(this).val(data[inputName]).trigger('change', data);
            } else if ($(this).hasClass('flatpickr-input') && this._flatpickr) {
                this._flatpickr.setDate(data[inputName], true);
            } else if ($(this).hasClass('dropify')) {
                const dropifyElement = $(this).data('dropify');
                if (dropifyElement) {
                    dropifyElement.destroy();
                    dropifyElement.settings.defaultFile = data[inputName];
                    dropifyElement.init();
                }
            } else if ($(this).data('cleave')) {
                $(this).data('cleave').setRawValue(data[inputName]);
            } else {
                $(this).val(data[inputName]).trigger('change');
            }
        }
    });
}
