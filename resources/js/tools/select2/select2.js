import handleAjaxError from "../handle-ajax-error.js";
import { toastWarning } from "../toast/toast.js";

(function ($) {

    var Defaults = $.fn.select2.amd.require('select2/defaults');

    $.extend(Defaults.defaults, {
        dropdownPosition: 'auto'
    });

    var AttachBody = $.fn.select2.amd.require('select2/dropdown/attachBody');

    var _positionDropdown = AttachBody.prototype._positionDropdown;

    AttachBody.prototype._positionDropdown = function () {

        var $window = $(window);

        var isCurrentlyAbove = this.$dropdown.hasClass('select2-dropdown--above');
        var isCurrentlyBelow = this.$dropdown.hasClass('select2-dropdown--below');

        var newDirection = null;

        var offset = this.$container.offset();

        offset.bottom = offset.top + this.$container.outerHeight(false);

        var container = {
            height: this.$container.outerHeight(false)
        };

        container.top = offset.top;
        container.bottom = offset.top + container.height;

        var dropdown = {
            height: this.$dropdown.outerHeight(false)
        };

        var viewport = {
            top: $window.scrollTop(),
            bottom: $window.scrollTop() + $window.height()
        };

        var enoughRoomAbove = viewport.top < (offset.top - dropdown.height);
        var enoughRoomBelow = viewport.bottom > (offset.bottom + dropdown.height);

        var css = {
            left: offset.left,
            top: container.bottom
        };

        var $offsetParent = this.$dropdownParent;

        if ($offsetParent.css('position') === 'static') {
            $offsetParent = $offsetParent.offsetParent();
        }

        var parentOffset = $offsetParent.offset();

        css.top -= parentOffset.top
        css.left -= parentOffset.left;

        var dropdownPositionOption = this.options.get('dropdownPosition');

        if (dropdownPositionOption === 'above' || dropdownPositionOption === 'below') {

            newDirection = dropdownPositionOption;

        } else {

            if (!isCurrentlyAbove && !isCurrentlyBelow) {
                newDirection = 'below';
            }

            if (!enoughRoomBelow && enoughRoomAbove && !isCurrentlyAbove) {
                newDirection = 'above';
            } else if (!enoughRoomAbove && enoughRoomBelow && isCurrentlyAbove) {
                newDirection = 'below';
            }

        }

        if (newDirection == 'above' ||
            (isCurrentlyAbove && newDirection !== 'below')) {
            css.top = container.top - parentOffset.top - dropdown.height;
        }

        if (newDirection != null) {
            this.$dropdown
                .removeClass('select2-dropdown--below select2-dropdown--above')
                .addClass('select2-dropdown--' + newDirection);
            this.$container
                .removeClass('select2-container--below select2-container--above')
                .addClass('select2-container--' + newDirection);
        }

        this.$dropdownContainer.css(css);

    };

})(window.jQuery);

(function ($) {
    const Select2Plugin = (() => {
        const defaultOptions = {
            width: null,
            theme: null,
            tags: false,
            allowClear: false,
            placeholder: null,
            templateResult: null,
            templateSelection: null,
            createTag: null,
            dropdownParent: null,
            select2: true,
            dropdownPosition: 'below',
            multiple: false,
            api: {
                url: '',
                method: 'GET',
                data: {},
                key: 'id',
                value: 'name',
                selected: null,
                additional: null,
                trigger: false,
                firstOption: '<option selected disabled value="">- Select -</option>',
                renderOption: null,
                firstSelected: false,
                alertIfEmpty: null,
            },
        };

        const create = ($element, userOptions) => {
            const options = $.extend(true, {}, defaultOptions, userOptions);

            const filterNullOptions = (opts) => {
                return Object.keys(opts).reduce((filtered, key) => {
                    if (opts[key] !== null) {
                        filtered[key] = opts[key];
                    }
                    return filtered;
                }, {});
            };

            const loadData = (apiOptions) => {
                $element.empty().append('<option selected disabled value="">Please wait...</option>');
                $.ajax({
                    type: apiOptions.method,
                    url: apiOptions.url,
                    data: apiOptions.data,
                    dataType: 'json',
                    success: (response) => {
                        const data = response.data || [];
                        if (apiOptions.alertIfEmpty && data.length <= 0) {
                            toastWarning(apiOptions.alertIfEmpty)
                        }
                        $element.empty();

                        if (apiOptions.firstOption && !apiOptions.firstSelected && !options.placeholder) {
                            $element.append(apiOptions.firstOption);
                        }

                        data.forEach((item) => {
                            appendItem(apiOptions, item);
                        });

                        if (apiOptions.additional) {
                            appendItem(apiOptions, apiOptions.additional);
                        }

                        if (apiOptions.firstSelected && data.length == 1) {
                            const firstOption = $element.find('option:first-of-type');
                            if (firstOption.attr('disabled')) {
                                $element.find('option:eq(1)').prop('selected', true);
                            } else {
                                firstOption.prop('selected', true);
                            }
                            $element.trigger('change');
                        }

                        if (apiOptions.selected && apiOptions.trigger) {
                            $element.val(apiOptions.selected).trigger('change');
                        }
                    },
                    error: (response) => {
                        $element.empty().append('<option selected disabled value="">Failed to load...</option>');
                        handleAjaxError(response);
                    }
                });
            };

            const appendItem = (apiOptions, $item) => {
                let isSelected = false;
                if (Array.isArray(apiOptions.selected)) {
                    isSelected = apiOptions.selected.includes($item[apiOptions.key]);
                } else {
                    isSelected = $item[apiOptions.key] == apiOptions.selected;
                }
                const option = apiOptions.renderOption
                    ? apiOptions.renderOption($item, apiOptions)
                    : $('<option></option>')
                        .val($item[apiOptions.key])
                        .text($item[apiOptions.value])
                        .prop('selected', isSelected);

                $element.append(option);
            };

            const select2Options = filterNullOptions({
                width: options.width,
                theme: options.theme,
                tags: options.tags,
                allowClear: options.allowClear,
                placeholder: options.placeholder,
                templateResult: options.templateResult,
                templateSelection: options.templateSelection,
                createTag: options.createTag,
                dropdownParent: options.dropdownParent,
                dropdownPosition: options.dropdownPosition,
                multiple: options.multiple,
            });

            if (options.select2) {
                $element.select2(select2Options);
            }
            // Initialize Select2

            // Load data initially if API options exist
            if (options.api.url) {
                loadData(options.api);
            }

            // Listen for reload event
            $element.on('reload.select2', (e, newApiOptions) => {
                const apiOptions = $.extend(true, {}, options.api, newApiOptions);
                loadData(apiOptions);
            });

            $element.on('reset.select2', (e, newApiOptions) => {
                const apiOptions = $.extend(true, {}, options.api, newApiOptions);
                $element.find('option').remove().end().append(apiOptions.firstOption).val('').trigger('change');
            });

        };

        return { create };
    })();

    $.fn.objSelect2 = function (userOptions) {
        return this.each(function () {
            const $element = $(this);
            Select2Plugin.create($element, userOptions);
        });
    };
})(jQuery);

// $('#mySelect').objSelect2({
//     api: {
//         url: '/api/getOptions',
//         key: 'id',
//         value: 'name',
//         selected: 1,
//         renderOption: function (item) {
//             return $('<option></option>')
//                 .val(item.code)
//                 .text(`${item.name} (${item.code})`);
//         }
//     },
// });

// $('#mySelect').trigger('reload.select2', {
//     url: '/api/newOptions',
//     data: { filter: 'active' },
//     selected: 2,
// });
