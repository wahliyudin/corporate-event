$(function () {
    "use strict";
    window.origin = $('meta[name="url"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadLatestActivity() {
        const item = function (event) {
            let badge = `<span class="badge bg-light text-default mb-1">12:00PM - 1:00PM</span>`;
            if (event.status == 'completed') {
                badge = `<span class="badge bg-success mb-1">Completed</span>`;
            } else if (event.status == 'verified' && event.has_due_date) {
                badge = `<span class="badge bg-danger-transparent mb-1">Due Date</span>`;
            }
            return `
                <li>
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <p class="mb-1 fw-semibold">
                            ${event.date.date}
                        </p>
                        ${badge}
                    </div>
                    <p class="mb-0 text-muted fs-12">
                        ${event.title}
                    </p>
                </li>
            `;
        }
        const loader = `
            <div class="d-flex justify-content-center" id="latest-activity-loading">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        `;
        const empty = `
            <div class="alert alert-info">
                <p class="mb-0">No activities found.</p>
            </div>
        `;
        $('#latest-activities').html(loader);
        $.ajax({
            url: `${origin}/events/latest-activity`,
            type: 'GET',
            success: function (res) {
                if (res.data.length > 0) {
                    $('#latest-activities').html(res.data.map(item).join(''));
                } else {
                    $('#latest-activities').html(empty);
                }
            },
            error: function (err) {
                $('#latest-activities').html(`
                    <div class="alert alert-danger">
                        <h6 class="alert-heading">Failed to load activities!</h6>
                        <p class="mb-0">${err.responseJSON.message}</p>
                    </div>
                `);
            }
        });
    }

    loadLatestActivity();

    $(document).on('reload-all-api', function () {
        loadLatestActivity();
    });
});