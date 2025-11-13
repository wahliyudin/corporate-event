"use strict";

export default function resetForm(formSelector = null, excepts = []) {
    $(formSelector).find(':input').each(function () {
        var inputName = $(this).attr('name');
        if (!inputName || inputName.startsWith('datatable-') || excepts.includes(inputName)) {
            return;
        }
        if (inputName && !inputName.startsWith('datatable-')) {
            if ($(this).hasClass('select2') || $(this).is('select')) {
                $(this).val('').trigger('change');
            } else if ($(this).hasClass('flatpickr-input') && this._flatpickr) {
                this._flatpickr.setDate(null, true);
            } else if ($(this).hasClass('dropify')) {
                const dropifyElement = $(this).data('dropify');
                if (dropifyElement) {
                    dropifyElement.resetPreview();
                    dropifyElement.clearElement();
                }
            } else if ($(this).attr('type') === 'checkbox') {
                $(this).prop('checked', false);
            } else {
                $(this).val('');
            }
        }
    });
}
