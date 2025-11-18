import errorPlacement from "../../../tools/crud-manager/error-placement.js";
import generateValidationRules from "../../../tools/crud-manager/generate-validation-rules.js";
import handleAjaxError from "../../../tools/handle-ajax-error.js";
import toastMessage from "../../../tools/toast/toast-message.js";
import "../../../tools/select2/select2.js";
import { toastError, toastSuccess, toastWarning } from "../../../tools/toast/toast.js";
import resetForm from "../../../tools/crud-manager/reset-form.js";
import "./latest-activity.js";

(function () {
    "use strict";
    window.origin = $('meta[name="url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    if ($('#eventForm [name="company"]').length) {
        $('#eventForm [name="company"]').objSelect2({
            dropdownParent: $('#eventForm .company-container'),
            api: {
                url: `${origin}/companies/data-select`,
                method: 'GET',
                firstOption: '<option selected disabled value="">- Select -</option>'
            },
        });
    }

    if ($('#eventForm [name="category"]').length) {
        $('#eventForm [name="category"]').objSelect2({
            dropdownParent: $('#eventForm .category-container'),
            api: {
                url: `${origin}/events/categories/data-select`,
                method: 'GET',
                firstOption: '<option selected disabled value="">- Select -</option>'
            },
        });
    }

    let startDate = null;
    if ($('#eventForm [name="start_date"]').length) {
        startDate = flatpickr('#eventForm [name="start_date"]', {
            appendTo: document.querySelector(".modal"),
            altInput: true,
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
        });
    }

    let endDate = null;
    if ($('#eventForm [name="end_date"]').length) {
        endDate = flatpickr('#eventForm [name="end_date"]', {
            appendTo: document.querySelector(".modal"),
            altInput: true,
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
        });
    }

    let description = null;
    if ($('#eventForm #description').length) {
        DecoupledEditor
            .create(document.querySelector(`#eventForm #description`), {
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
                const toolbarContainer = document.querySelector(`#eventForm #description_toolbar`);
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                description = editor;
            })
            .catch(error => {
                toastWarning(error);
            });
    }

    let location = null;
    if ($('#eventForm #location').length) {
        DecoupledEditor
            .create(document.querySelector(`#eventForm #location`), {
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
                const toolbarContainer = document.querySelector(`#eventForm #location_toolbar`);
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);
                location = editor;
            })
            .catch(error => {
                toastWarning(error);
            });
    }


    function loadEventCategories() {
        const itemCategory = function (category) {
            return `
                <div data-id="${category.id}" class="fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event" style="background-color: ${category.color}; border-color: ${category.color};">
                    <div class="fc-event-main">${category.name}</div>
                </div>
            `;
        }
        const loader = `
            <div class="d-flex justify-content-center" id="event-categories-loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        const empty = `
            <div class="alert alert-info">
                <p class="mb-0">No categories found.</p>
            </div>
        `;
        $('#event-categories').html(loader);
        $.ajax({
            url: `${origin}/events/categories/data-select`,
            type: 'GET',
            success: function (res) {
                if (res.data.length > 0) {
                    $('#event-categories').html(res.data.map(itemCategory).join(''));
                } else {
                    $('#event-categories').html(empty);
                }
            },
            error: function (err) {
                $('#event-categories').html(`
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">Failed to load categories!</h6>
                        <p class="mb-0">${err.responseJSON.message}</p>
                    </div>
                `);
            }
        });
    }

    loadEventCategories();

    let receiveEvent = null;
    var containerEl = document.getElementById('event-categories');
    new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function (eventEl) {
            const bgColor = window.getComputedStyle(eventEl).backgroundColor;

            return {
                title: eventEl.innerText.trim(),
                category_id: eventEl.dataset.id,
                className: eventEl.className + ' overflow-hidden ',
                backgroundColor: bgColor,
                borderColor: bgColor,
                textColor: '#fff'
            };
        }
    });
    var calendarEl = document.getElementById('calendar-events');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'Asia/Jakarta',
        events: function (fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: '/calendar/data-calendar',
                type: 'GET',
                success: function (res) {
                    successCallback(res.map(function (event) {
                        const start = moment.tz(event.start, "Asia/Jakarta");
                        const end = moment.tz(event.end, "Asia/Jakarta");
                        if (!start.isSame(end, 'day')) {
                            event.end = end.add(1, 'day').format('YYYY-MM-DD HH:mm:ss');
                        }
                        return event;
                    }));
                },
                error: function () {
                    alert('Gagal mengambil data event.');
                    failureCallback();
                }
            });
        },
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
        },
        defaultView: 'month',
        navLinks: true, // can click day/week names to navigate views
        businessHours: true, // display business hours
        editable: true,
        selectable: true,
        selectMirror: true,
        droppable: true, // this allows things to be dropped onto the calendar
        editable: true,
        dayMaxEvents: true,
        select: onSelect,
        dateClick: function (info) {
            console.log(info);
        },
        eventClick: function (info) {
            const eventData = {
                id: info.event.id,
                title: info.event.title,
                start_date: info.event.start,
                end_date: info.event.end || info.event.start,
                extendedProps: info.event.extendedProps
            };

            setDetailEvent({
                id: eventData.id,
                title: eventData.title,
                date: eventData.extendedProps.date_str,
                company: eventData.extendedProps?.company || '',
                category: eventData.extendedProps?.event_category || '',
                location: eventData.extendedProps?.location || '',
                pic: eventData.extendedProps?.pic || '',
                status: eventData.extendedProps?.status || '',
                description: eventData.extendedProps?.description || ''
            });
            $('#modalDetailEvent').modal('show');
            info.jsEvent.preventDefault();
        },
        eventDrop: function (info) {
            const oldStart = moment(info.oldEvent.startStr);
            const oldEnd = info.oldEvent.end ? moment(info.oldEvent.endStr) : null;
            let newStart = moment(info.event.startStr);
            let newEnd = info.event.end ? moment(info.event.endStr) : null;
            newStart = moment(
                newStart.format("YYYY-MM-DD") + " " + oldStart.format("HH:mm"),
                "YYYY-MM-DD HH:mm"
            );
            if (newEnd && oldEnd) {
                newEnd = moment(
                    newEnd.format("YYYY-MM-DD") + " " + oldEnd.format("HH:mm"),
                    "YYYY-MM-DD HH:mm"
                );
            }
            if (!newStart.isSame(newEnd, 'day')) {
                newStart = newStart.add(1, 'day');
            }
            newStart = newStart.toDate();
            newEnd = newEnd ? newEnd.toDate() : null;
            info.event.setStart(newStart);
            if (newEnd) info.event.setEnd(newEnd);
            Swal.fire({
                title: "Confirmation",
                html: (() => {
                    const start = moment.tz(info.event.start, "Asia/Jakarta").subtract(1, "day");
                    const endRaw = info.event.end;
                    let end = endRaw ? moment.tz(endRaw, "Asia/Jakarta").subtract(1, "day") : null;

                    if (!end || start.isSame(end, "day")) {
                        return `
                            Move event to:<br>
                            <strong>${start.add(1, "day").format("DD MMM YYYY, HH:mm")}</strong>
                            - <strong>${end ? end.format("HH:mm") : ""} WIB</strong>?
                        `;
                    } else {
                        return `
                            Move event to:<br>
                            <strong>${start.format("DD MMM YYYY, HH:mm")}</strong>
                            - <strong>${end.format("DD MMM YYYY, HH:mm")} WIB</strong>?
                        `;
                    }
                })(),

                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, move it!",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),
                preConfirm: async () => {
                    try {
                        const start = moment.tz(info.event.start, "Asia/Jakarta");
                        const end = moment.tz(info.event.end, "Asia/Jakarta");
                        if (!start.isSame(end, 'day')) {
                            start.subtract(1, "day");
                            end.subtract(1, "day");
                        }
                        const response = await $.ajax({
                            url: `${origin}/calendar/${info.event.id}/move`,
                            method: "POST",
                            data: {
                                start: start.format('YYYY-MM-DD HH:mm:ss'),
                                end: end.format('YYYY-MM-DD HH:mm:ss')
                            }
                        });
                        if (!response || response.status !== "success") {
                            throw new Error("Server returned error");
                        }
                        return true;
                    } catch (error) {
                        Swal.showValidationMessage(
                            `Failed to move event.<br>Error: ${error.responseJSON?.message || error.statusText || "Unknown error"}`
                        );
                        return false;
                    }
                }

            }).then((result) => {
                if (result.isDismissed) {
                    info.revert();
                    return;
                }
                if (result.isConfirmed) {
                    toastSuccess('Event successfully moved!');
                    reloadAllApi();
                }
            });
        },
        eventReceive: function (info) {
            receiveEvent = info.event;
            startDate.setDate(info.event.start);
            endDate.setDate(info.event.end ?? info.event.start);
            $('#eventForm [name="category"]').val(info.event.extendedProps.category_id).trigger('change');
            $('#modalFormEvent').modal('show');
        },
    });
    calendar.render();

    function reloadAllApi() {
        $(document).trigger('reload-all-api');
    }

    $(document).on('reload-all-api', function () {
        calendar.refetchEvents();
    });

    function setDetailEvent(event) {
        $('#detailEventId').val(event.id);
        $('#detailEventTitle').text(event.title);
        $('#detailEventDate').text(event.date);
        $('#detailEventCompany').text(event.company);
        $('#detailEventCategory').text(event.category);
        $('#detailEventLocation').html(event.location);
        $('#detailEventPIC').text(event.pic);
        $('#detailEventStatus').text(event.status);
        $('#detailEventDescription').html(event.description);
    }

    function onSelect(info) {
        startDate.setDate(info.startStr);
        endDate.setDate(moment(info.endStr).subtract(1, "day").format("YYYY-MM-DD HH:mm"));
        $('#modalFormEvent').modal('show');
    }

    $(document).on('click', '#modalDetailEvent #btnEdit', function (e) {
        e.preventDefault();
        const eventId = $('#detailEventId').val();
        $.ajax({
            url: `${origin}/calendar/${eventId}/edit`,
            method: 'GET',
            success: function (response) {
                $('#modalDetailEvent').modal('hide');
                $('#modalFormEvent').modal('show');
                $('#eventForm input[name="id"]').val(response.id);
                $('#eventForm input[name="title"]').val(response.title);
                startDate.setDate(response.start_date);
                endDate.setDate(response.end_date);
                $('#eventForm select[name="company"]').val(response.company).trigger('change');
                $('#eventForm select[name="category"]').val(response.category).trigger('change');
                location.setData(response.location);
                description.setData(response.description);
                $('#eventForm input[name="pic"]').val(response.pic);
                $('#eventForm select[name="status"]').val(response.status).trigger('change');
            },
            error: function (xhr, status, error) {
                toastError(`Failed to load event data <br>${xhr.responseJSON?.message || error.statusText || "Unknown error"}`);
            }
        });
    });

    $(document).on('click', '#modalDetailEvent #btnDelete', function (e) {
        e.preventDefault();
        const eventId = $('#detailEventId').val();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `${origin}/calendar/${eventId}/destroy`,
                    method: 'DELETE',
                    success: function (response) {
                        $('#modalDetailEvent').modal('hide');
                        reloadAllApi();
                        toastSuccess('Event successfully deleted!');
                    },
                    error: function (xhr, status, error) {
                        toastError(`Failed to delete event <br>${xhr.responseJSON?.message || error.statusText || "Unknown error"}`);
                    }
                });
            }
        });
    });

    $(document).on('click', '#btnCreateEvent', function (e) {
        e.preventDefault();
        resetForm('#eventForm');
        location.setData('');
        description.setData('');
        $('#modalFormEvent').modal('show');
    });


    $('#modalFormEvent').on('hidden.bs.modal', function () {
        receiveEvent?.remove();
        receiveEvent = null;
        resetForm('#eventForm');
        location.setData('');
        description.setData('');
    });


    var formValidator = $('#eventForm').validate({
        ignore: ':hidden:not(.chosen) :hidden:not(.ckeditor)',
        errorElement: "div",
        errorPlacement: errorPlacement,
        rules: generateValidationRules('#eventForm'),
    });

    $(document).on('click', '#modalFormEvent #btnSave', function (e) {
        e.preventDefault();
        const button = this;
        $(button).attr('data-indicator', 'on').prop('disabled', true);
        const saveButton = this;
        $(saveButton).attr('disabled', 'disabled').attr("data-indicator", "on");

        if (!formValidator.form()) {
            $(saveButton).removeAttr("data-indicator").removeAttr('disabled');
            toastMessage('warning', 'Please fill in the required fields');
            return;
        }

        const formData = new FormData($('#eventForm')[0]);
        formData.append('description', description?.getData());
        formData.append('location', location?.getData());
        $.ajax({
            url: `${origin}/calendar/store`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastMessage('success', response.message);
                description?.setData('');
                location?.setData('');
                reloadAllApi();
                resetForm('#eventForm');
                receiveEvent?.remove();
                receiveEvent = null;
                $('#modalFormEvent').modal('hide');
            },
            error: function (xhr, status, error) {
                handleAjaxError(xhr);
            }
        }).always(function () {
            calendar.unselect()
            $(button).removeAttr('data-indicator').prop('disabled', false);
        });
    });

    // for activity scroll
    var myElement1 = document.getElementById('full-calendar-activity');
    new SimpleBar(myElement1, { autoHide: true });
})();
