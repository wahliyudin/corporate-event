import errorPlacement from "../../tools/crud-manager/error-placement.js";
import generateValidationRules from "../../tools/crud-manager/generate-validation-rules.js";
import handleAjaxError from "../../tools/handle-ajax-error.js";
import toastMessage from "../../tools/toast/toast-message.js";
import "../../tools/select2/select2.js";

(function () {
    "use strict";
    window.origin = $('meta[name="url"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var curYear = moment().format('YYYY');
    var curMonth = moment().format('MM');
    var sptCalendarEvents = {
        id: 1,
        events: [{
            id: '1',
            start: curYear + '-' + curMonth + '-02',
            end: curYear + '-' + curMonth + '-03',
            title: 'Spruko Meetup',
            backgroundColor: '#845adf',
            borderColor: '#845adf',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '2',
            start: curYear + '-' + curMonth + '-17',
            end: curYear + '-' + curMonth + '-17',
            title: 'Design Review',
            backgroundColor: '#23b7e5',
            borderColor: '#23b7e5',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '3',
            start: curYear + '-' + curMonth + '-13',
            end: curYear + '-' + curMonth + '-13',
            title: 'Lifestyle Conference',
            backgroundColor: '#845adf',
            borderColor: '#845adf',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '4',
            start: curYear + '-' + curMonth + '-21',
            end: curYear + '-' + curMonth + '-21',
            title: 'Team Weekly Brownbag',
            backgroundColor: '#f5b849',
            borderColor: '#f5b849',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '5',
            start: curYear + '-' + curMonth + '-04T10:00:00',
            end: curYear + '-' + curMonth + '-06T15:00:00',
            title: 'Music Festival',
            backgroundColor: '#26bf94',
            borderColor: '#26bf94',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '6',
            start: curYear + '-' + curMonth + '-23T13:00:00',
            end: curYear + '-' + curMonth + '-25T18:30:00',
            title: 'Attend Lea\'s Wedding',
            backgroundColor: '#26bf94',
            borderColor: '#26bf94',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }]
    };
    var sptBirthdayEvents = {
        id: 2,
        backgroundColor: '#49b6f5',
        borderColor: '#49b6f5',
        textColor: '#fff',
        events: [{
            id: '7',
            start: curYear + '-' + curMonth + '-04',
            end: curYear + '-' + curMonth + '-04',
            title: 'Harcates Birthday',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '8',
            start: curYear + '-' + curMonth + '-28',
            end: curYear + '-' + curMonth + '-28',
            title: 'Bunnysin\'s Birthday',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '9',
            start: curYear + '-' + curMonth + '-31',
            end: curYear + '-' + curMonth + '-31',
            title: 'Lee shin\'s Birthday',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        }, {
            id: '10',
            start: curYear + '-' + 11 + '-11',
            end: curYear + '-' + 11 + '-11',
            title: 'Shinchan\'s Birthday',
            description: 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary'
        },]
    };
    var sptHolidayEvents = {
        id: 3,
        backgroundColor: '#e6533c',
        borderColor: '#e6533c',
        textColor: '#fff',
        events: [{
            id: '10',
            start: curYear + '-' + curMonth + '-05',
            end: curYear + '-' + curMonth + '-08',
            title: 'Festival Day'
        }, {
            id: '11',
            start: curYear + '-' + curMonth + '-18',
            end: curYear + '-' + curMonth + '-19',
            title: 'Memorial Day'
        }, {
            id: '12',
            start: curYear + '-' + curMonth + '-25',
            end: curYear + '-' + curMonth + '-26',
            title: 'Diwali'
        }]
    };
    var sptOtherEvents = {
        id: 4,
        backgroundColor: '#23b7e5',
        borderColor: '#23b7e5',
        textColor: '#fff',
        events: [{
            id: '13',
            start: curYear + '-' + curMonth + '-07',
            end: curYear + '-' + curMonth + '-09',
            title: 'My Rest Day'
        }, {
            id: '13',
            start: curYear + '-' + curMonth + '-29',
            end: curYear + '-' + curMonth + '-31',
            title: 'My Rest Day'
        }]
    };

    var containerEl = document.getElementById('external-events');
    new FullCalendar.Draggable(containerEl, {
        itemSelector: '.fc-event',
        eventData: function (eventEl) {
            return {
                title: eventEl.innerText.trim(),
                title: eventEl.innerText,
                className: eventEl.className + ' overflow-hidden '
            }
        }
    });
    var calendarEl = document.getElementById('calendar-events');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        events: function (fetchInfo, successCallback, failureCallback) {
            $.ajax({
                url: '/events/data-calendar',
                type: 'GET',
                success: function (res) {
                    successCallback(res);
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

        select: onSelect,
        eventClick: function (arg) {
            console.log(arg.event);
        },

        editable: true,
        dayMaxEvents: true, // allow "more" link when too many events
        // eventSources: [sptCalendarEvents, sptBirthdayEvents, sptHolidayEvents, sptOtherEvents],
    });
    calendar.render();

    function onSelect(arg) {
        $('#modalFormEvent').modal('show');

        // var title = prompt('Event Title:');
        // if (title) {
        //     calendar.addEvent({
        //         title: title,
        //         start: arg.start,
        //         end: arg.end,
        //         allDay: arg.allDay
        //     })
        // }
        // calendar.unselect()
    }

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
        $.ajax({
            url: `${origin}/events/store`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                toastMessage('success', response.message);
                $('#modalFormEvent').modal('hide');
            },
            error: function (xhr, status, error) {
                handleAjaxError(xhr);
            }
        }).always(function () {
            $(button).removeAttr('data-indicator').prop('disabled', false);
        });
    });

    if ($('#eventForm [name="company"]').length) {
        $('#eventForm [name="company"]').objSelect2({
            dropdownParent: $('#eventForm .company-container'),
        });
    }

    if ($('#eventForm [name="category"]').length) {
        $('#eventForm [name="category"]').objSelect2({
            dropdownParent: $('#eventForm .category-container'),
        });
    }

    if ($('#eventForm [name="status"]').length) {
        $('#eventForm [name="status"]').objSelect2({
            dropdownParent: $('#eventForm .status-container'),
        });
    }

    if ($('#eventForm [name="start_date"]').length) {
        flatpickr('#eventForm [name="start_date"]', {
            altInput: true,
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
            time_24hr: true,
        });
    }

    if ($('#eventForm [name="end_date"]').length) {
        flatpickr('#eventForm [name="end_date"]', {
            altInput: true,
            altFormat: "d F Y H:i",
            dateFormat: "Y-m-d H:i",
            enableTime: true,
            time_24hr: true,
        });
    }

    // for activity scroll
    var myElement1 = document.getElementById('full-calendar-activity');
    new SimpleBar(myElement1, { autoHide: true });
})();
