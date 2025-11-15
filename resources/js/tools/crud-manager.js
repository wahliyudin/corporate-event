import errorPlacement from "./crud-manager/error-placement.js";
import generateValidationRules from "./crud-manager/generate-validation-rules.js";
import handleAjaxError from "./handle-ajax-error.js";
import populateFormFields from "./crud-manager/populate-form-fields.js";
import resetForm from "./crud-manager/reset-form.js";
import toastMessage from "./toast/toast-message.js";

(function ($) {
    $.fn.crudManager = function (options) {
        // Constants for better maintainability
        const REQUIRED_COLUMNS = "Columns configuration is required.";
        const CSRF_TOKEN_HEADER = 'X-CSRF-TOKEN';
        const POST_METHOD = 'POST';
        const GET_METHOD = 'GET';
        const DEFAULT_SUCCESS_MESSAGE = 'Data saved successfully!';
        const DEFAULT_ERROR_MESSAGE = 'An error occurred. Please try again.';
        const DEFAULT_WARNING_MESSAGE = 'Please correct the validations.';

        // Ensure columns are provided
        if (!options.columns || options.columns.length === 0) {
            console.error(REQUIRED_COLUMNS);
            return;
        }

        // Merge the user options with the default settings
        const settings = $.extend({
            dataTableUrl: '',
            storeDataUrl: '',
            fetchDataUrl: '',
            deleteDataUrl: '',
            detailDataUrl: null,
            serverSide: false,
            responsive: false,
            scrollX: false,
            stateSave: false,
            resetFormOnClose: true,
            ajaxDataCallback: null,
            dom: null,
            dataSrc: null,
            buttons: null,
            order: null,
            csrfToken: $('meta[name="csrf-token"]').attr('content'),
            successMessage: DEFAULT_SUCCESS_MESSAGE,
            errorMessage: DEFAULT_ERROR_MESSAGE,
            warningMessage: DEFAULT_WARNING_MESSAGE,
            formSelector: '#form',
            modalSelector: '#formModal',
            dataTableSelector: '#datatable',
            saveButtonSelector: '#btn-save',
            editButtonSelector: '#btn-edit',
            deleteButtonSelector: '#btn-delete',
            columns: options.columns,
            footerCallback: null,
            initComplete: null,
            data: null,
            onXhr: null,
            extensions: [], // This will hold the list of extension functions
            // Overridable functions can be set here
        }, options);

        // Execute extensions if provided by the user
        if (Array.isArray(settings.extensions) && settings.extensions.length > 0) {
            settings.extensions.forEach(function (extension) {
                if (typeof extension === 'function') {
                    extension.call(this, settings);
                }
            });
        }

        // Main function to handle the plugin logic
        this.each(function () {
            var $dataTable = $(settings.dataTableSelector);

            var config = {
                language: {
                    searchPlaceholder: 'Search...',
                    sSearch: '',
                },
                serverSide: settings.serverSide,
                processing: true,
                responsive: settings.responsive,
                scrollX: settings.scrollX,
                ajax: {
                    url: settings.dataTableUrl,
                    method: POST_METHOD,
                    headers: {
                        [CSRF_TOKEN_HEADER]: settings.csrfToken
                    }
                },
                order: settings.order ?? [[0, 'asc']],
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
                pageLength: 10,
                columns: settings.columns,
            };

            if (settings.additionalDatatable) {
                config = $.extend(config, settings.additionalDatatable);
            }

            if (settings.ajaxDataCallback) {
                config.ajax.data = settings.ajaxDataCallback;
            }

            if (settings.columnDefs.length > 0) {
                config.columnDefs = settings.columnDefs;
            }

            if (settings.dataSrc) {
                config.ajax.dataSrc = settings.dataSrc;
            }

            if (settings.data) {
                config.ajax.data = settings.data;
            }

            if (settings.dom) {
                config.dom = settings.dom;
            }

            if (settings.buttons) {
                config.buttons = settings.buttons;
            }

            if (settings.stateSave) {
                config.stateSave = settings.stateSave;
            }

            if (settings.footerCallback) {
                config.footerCallback = settings.footerCallback;
            }

            if (settings.initComplete) {
                config.initComplete = settings.initComplete;
            }

            var dataTableInstance = $dataTable.DataTable(config);

            $dataTable.data('dataTableInstance', dataTableInstance);
            $dataTable.data('settings', settings);

            if (typeof settings.onXhr === 'function') {
                $dataTable.on('xhr.dt', function () {
                    const json = dataTableInstance.ajax.json();
                    settings.onXhr(json?.data ?? [], dataTableInstance);
                });
            }

            var formValidator = null;
            if (settings.storeDataUrl) {
                formValidator = $(settings.formSelector).validate({
                    ignore: ':hidden:not(.chosen) :hidden:not(.ckeditor)',
                    errorElement: "div",
                    errorPlacement: errorPlacement,
                    rules: generateValidationRules(settings.formSelector),
                });
            }

            $(settings.modalSelector).on('hidden.bs.modal', function () {
                if (settings.resetFormOnClose) {
                    resetForm(settings.formSelector);
                }
            });

            // Save button click handler for the form modal
            $(settings.modalSelector).on('click', settings.saveButtonSelector, function (e) {
                e.preventDefault();
                const saveButton = this;
                $(saveButton).attr('disabled', 'disabled').attr("data-indicator", "on");

                // If form is not valid, reset the button
                if (!formValidator.form()) {
                    $(saveButton).removeAttr("data-indicator").removeAttr('disabled');
                    toastMessage('warning', settings.warningMessage);
                    return;
                }

                const formData = new FormData($(settings.formSelector)[0]);
                $.ajax({
                    type: POST_METHOD,
                    url: settings.storeDataUrl,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        [CSRF_TOKEN_HEADER]: settings.csrfToken
                    },
                    success: function (response) {
                        $(saveButton).removeAttr("data-indicator").removeAttr('disabled');
                        toastMessage('success', response.message);
                        $(settings.modalSelector).modal('hide');
                        resetForm(settings.formSelector);
                        $(document).trigger('crud:form-saved', response?.data ?? {});
                        if (settings.detailDataUrl && response?.data?.key) {
                            window.location = settings.detailDataUrl.replace('{id}', response?.data?.key);
                        } else {
                            dataTableInstance.ajax.reload();
                        }
                    },
                    error: function (xhr) {
                        $(saveButton).removeAttr("data-indicator").removeAttr('disabled');
                        handleAjaxError(xhr, settings.errorMessage);
                    }
                });
            });

            // Edit button click handler to load the form data for editing
            $(settings.dataTableSelector).on('click', settings.editButtonSelector, function (e) {
                e.preventDefault();
                const editButton = this;
                const recordId = $(editButton).data('key');
                $(editButton).attr("data-indicator", "on");

                $.ajax({
                    url: settings.fetchDataUrl.replace('{id}', recordId),
                    type: GET_METHOD,
                    headers: {
                        [CSRF_TOKEN_HEADER]: settings.csrfToken
                    },
                    success: function (response) {
                        $(editButton).removeAttr("data-indicator");
                        $(settings.modalSelector).modal('show');
                        populateFormFields(settings.formSelector, response.data);
                    },
                    error: function (xhr) {
                        $(editButton).removeAttr("data-indicator");
                        handleAjaxError(xhr, settings.errorMessage);
                    }
                });
            });

            // Delete button click handler to delete a record
            $(settings.dataTableSelector).on('click', settings.deleteButtonSelector, function (e) {
                e.preventDefault();
                const deleteButton = this;
                const recordId = $(deleteButton).data('key');
                $(deleteButton).attr('data-indicator', 'on');

                Swal.fire({
                    title: 'Confirm Deletion',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'DELETE',
                            url: settings.deleteDataUrl.replace('{id}', recordId),
                            dataType: 'json',
                            headers: {
                                [CSRF_TOKEN_HEADER]: settings.csrfToken
                            },
                        })
                            .done(function (response) {
                                $(deleteButton).attr('data-indicator', 'off');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                }).then(function () {
                                    dataTableInstance.ajax.reload();
                                });
                            })
                            .fail(function (xhr) {
                                $(deleteButton).attr('data-indicator', 'off');
                                handleAjaxError(xhr, settings.errorMessage);
                            });
                    }
                }).then(function () {
                    $(deleteButton).attr('data-indicator', 'off');
                });
            });

        });

        return this;
    };

    // Commodity Manager Builder Pattern
    $.fn.crudManager.Builder = function () {
        this.settings = {
            additionalDatatable: null,
            columnDefs: [],
            columns: [],
            extensions: [],
            dataTableUrl: '',
            storeDataUrl: '',
            fetchDataUrl: '', // '/master/commodity/{id}/edit'
            deleteDataUrl: '', // '/master/commodity/{id}/destroy'
            detailDataUrl: null, // '/master/commodity/{id}/show'
            responsive: false,
            scrollX: true,
            ajaxDataCallback: null,
            dom: null,
            dataSrc: null,
            buttons: null,
            order: null,
            data: null,
            onXhr: null,
            csrfToken: $('meta[name="csrf-token"]').attr('content'),
            successMessage: 'Data saved successfully!',
            errorMessage: 'An error occurred. Please try again.',
            warningMessage: 'Please correct the validations.',
            formSelector: '#form',
            modalSelector: '#formModal',
            dataTableSelector: '#datatable',
            saveButtonSelector: '#btn-save',
            editButtonSelector: '#btn-edit',
            deleteButtonSelector: '#btn-delete'
        };

        this.setDataTableSelector = function (dataTableSelector) {
            this.settings.dataTableSelector = dataTableSelector;
            return this;
        };

        this.setAdditionalDatatable = function (additional) {
            this.settings.additionalDatatable = additional;
            return this;
        };

        this.setColumnDefs = function (columnDefs) {
            this.settings.columnDefs = columnDefs;
            return this;
        };

        this.setDataSrc = function (dataSrc) {
            this.settings.dataSrc = dataSrc;
            return this;
        };

        this.setData = function (data) {
            this.settings.data = data;
            return this;
        };

        this.setOnXhr = function (onXhr) {
            this.settings.onXhr = onXhr;
            return this;
        };

        this.setColumns = function (columns) {
            this.settings.columns = columns;
            return this;
        };

        this.setFooterCallback = function (footerCallback) {
            this.settings.footerCallback = footerCallback;
            return this;
        };

        this.setInitComplete = function (initComplete) {
            this.settings.initComplete = initComplete;
            return this;
        };

        this.setStateSave = function () {
            this.settings.stateSave = true;
            return this;
        };

        this.setAjaxDataCallback = function (ajaxDataCallback) {
            this.settings.ajaxDataCallback = ajaxDataCallback;
            return this;
        };

        this.setDom = function (dom) {
            this.settings.dom = dom;
            return this;
        };

        this.setOrder = function (order) {
            this.settings.order = order;
            return this;
        };

        this.setResetFormOnClose = function (resetFormOnClose) {
            this.settings.resetFormOnClose = resetFormOnClose;
            return this;
        };

        this.setButtons = function (buttons) {
            this.settings.buttons = buttons;
            return this;
        };

        this.setServerSide = function (serverSide = true) {
            this.settings.serverSide = serverSide;
            return this;
        };

        this.setResponsive = function (responsive = true) {
            this.settings.responsive = responsive;
            this.settings.scrollX = !responsive;
            return this;
        };

        this.setScrollX = function (scrollX = true) {
            this.settings.scrollX = scrollX;
            this.settings.responsive = !scrollX;
            return this;
        };

        this.addExtension = function (extension) {
            this.settings.extensions.push(extension);
            return this;
        };

        this.setDataTableUrl = function (url) {
            this.settings.dataTableUrl = url;
            return this;
        };

        this.setStoreDataUrl = function (url) {
            this.settings.storeDataUrl = url;
            return this;
        };

        this.setFetchDataUrl = function (url) {
            this.settings.fetchDataUrl = url;
            return this;
        };

        this.setDeleteDataUrl = function (url) {
            this.settings.deleteDataUrl = url;
            return this;
        };

        this.setDetailDataUrl = function (url) {
            this.settings.detailDataUrl = url;
            return this;
        };

        this.setCsrfToken = function (token) {
            this.settings.csrfToken = token;
            return this;
        };

        this.setEditButtonSelector = function (selector) {
            this.settings.editButtonSelector = selector;
            return this;
        };

        this.setMessages = function (successMessage, errorMessage, warningMessage) {
            if (successMessage) this.settings.successMessage = successMessage;
            if (errorMessage) this.settings.errorMessage = errorMessage;
            if (warningMessage) this.settings.warningMessage = warningMessage;
            return this;
        };

        this.build = function () {
            return this.settings;
        };
    };
})(jQuery);

// $('#commodityTable').crudManager({
//     columns: [
//         { title: 'ID', data: 'id' },
//         { title: 'Name', data: 'name' },
//         { title: 'Category', data: 'category' },
//         { title: 'Action', data: 'action' }
//     ]
// });

// var settings = new $.fn.crudManager.Builder()
//     .setColumns([
//         { title: 'ID', data: 'id' },
//         { title: 'Name', data: 'name' },
//         { title: 'Category', data: 'category' },
//         { title: 'Action', data: 'action' }
//     ])
//     .setStoreDataUrl('/new-store-url')
//     .addExtension(function (settings) {
//         // Add a custom extension
//         settings.successMessage = 'Your custom success message';
//     })
//     .build();

// $('#commodityTable').crudManager(settings);

// $('#myCommodityTable').crudManager({
//     columns: [
//         { title: 'ID', data: 'id' },
//         { title: 'Name', data: 'name' },
//         { title: 'Category', data: 'category' },
//         { title: 'Action', data: 'action' },
//     ],
//     extensions: [
//         function (settings) {
//             // Override the populateFormFields function
//             populateFormFields = function (data) {
//                 $(settings.formSelector).find(':input').each(function () {
//                     var inputName = $(this).attr('name');
//                     if (inputName && data[inputName] !== undefined) {
//                         // Custom behavior for populating form fields
//                         console.log('Custom logic to populate field: ', inputName);
//                         $(this).val(data[inputName]);
//                     }
//                 });
//             };
//         }
//     ]
// });
