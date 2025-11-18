import "../../../tools/paginator/paginator.js";

$(function () {
    "use strict";
    window.origin = $('meta[name="url"]').attr('content');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function loadEventCategories() {
        const itemCategory = function (category) {
            return `
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" value="${category.name}" id="${category.id}">
                    <label class="form-check-label" for="${category.id}">
                        <span class="badge" style="background-color: ${category.color}">${category.name}</span>
                    </label>
                    <span class="badge bg-light text-default fw-500 float-end" id="category-count-${category.id}">0</span>
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
                const maxShow = 6;
                if (res.data.length > 0) {
                    let eventCategories = '';
                    const slicedData = res.data.slice(0, maxShow);
                    if (res.data.length > maxShow) {
                        const overflowData = res.data.slice(maxShow);
                        eventCategories += slicedData.map(itemCategory).join('');
                        let containerCollapse = `
                            <div class="collapse" id="category-more">
                        `
                        containerCollapse += overflowData.map(itemCategory).join('');
                        containerCollapse += `
                        </div>
                            <a class="ecommerce-more-link" data-bs-toggle="collapse" href="#category-more" role="button"
                                aria-expanded="false" aria-controls="category-more">MORE</a>
                        `;
                        eventCategories += containerCollapse;
                    } else {
                        eventCategories = slicedData.map(itemCategory).join('');
                    }
                    $('#event-categories').html(eventCategories);
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

    $('#list-events').laravelPaginator({
        url: `${origin}/events/upcoming/data`,
        perPage: 5,
        searchInput: "#searchBox",
        renderData: function (data, container) {
            let html = '';
            data.forEach(item => {
                const MAX_LENGTH = 200;
                const description = item.description;
                const shortText = description.length > MAX_LENGTH ? description.substring(0, MAX_LENGTH) + '...' : description;
                const isLong = description.length > MAX_LENGTH;
                let descFull = '';
                if (isLong) {
                    descFull = `<span class="desc-full d-none">${description}</span>
                    <a href="#" class="toggle-more text-primary ms-1">More</a>`;
                }
                html += `
                <div class="card custom-card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="fw-semibold fs-14">${limitString(item.title, 50)}</div>

                                <div class="small mt-1 d-flex flex-wrap align-items-center gap-2">
                                    <span class="badge rounded-pill bg-light text-dark border">
                                        <i class="fe fe-calendar me-1"></i> ${item.date}
                                    </span>

                                    <span class="badge rounded-pill bg-light text-dark border">
                                        <i class="fe fe-map-pin me-1"></i> ${limitString(item.location, 40)}
                                    </span>

                                    <span class="badge rounded-pill bg-primary text-white">
                                        <i class="fe fe-user me-1"></i> PIC: ${item.pic}
                                    </span>
                                </div>

                                <div class="small mt-2">
                                    <span class="desc-short">${shortText}</span>
                                    ${descFull}
                                </div>
                            </div>

                            <div class="text-end">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-light text-primary"></span>
                                    <span class="badge" style="background-color: ${item.category_color};">
                                        ${item.category}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="btn-list float-end">
                            <a href="" class="text-primary fw-semibold d-inline-flex">
                                Complete Now <i class="fe fe-arrow-right transform-arrow ms-2 lh-base"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
            });

            container.html(html);
        },
        onAfterLoad: function (res) {
            const categories = res.total_per_categories;
            $('#event-categories [type="checkbox"]').each(function (index, element) {
                if (categories[$(element).val()]) {
                    $(element).next().next().text(categories[$(element).val()]);
                } else {
                    $(element).next().next().text(0);
                }
            });
            $('#total-events').text(res.total);
        }
    });

    $(document).on('change', '#event-categories [type="checkbox"]', function () {
        let categories = $('#event-categories [type="checkbox"]:checked').map((i, el) => el.value).get();

        $('#list-events').laravelPaginator("reload", {
            categories: categories
        });
    });

    function limitString(str, limit) {
        if (str.length > limit) {
            return str.substring(0, limit) + '...';
        } else {
            return str;
        }
    }
    let expandedRow = null;

    $(document).on('click', '.toggle-more', function (e) {
        e.preventDefault();

        const $link = $(this);
        const $wrapper = $link.closest('div');
        const $short = $wrapper.find('.desc-short');
        const $full = $wrapper.find('.desc-full');

        if (expandedRow && expandedRow[0] !== $wrapper[0]) {
            const $prevLink = expandedRow.find('.toggle-more');
            const $prevShort = expandedRow.find('.desc-short');
            const $prevFull = expandedRow.find('.desc-full');

            $prevFull.addClass('d-none');
            $prevShort.removeClass('d-none');
            $prevLink.text('More');
        }

        const isExpanded = !$full.hasClass('d-none');

        if (isExpanded) {
            $full.addClass('d-none');
            $short.removeClass('d-none');
            $link.text('More');
            expandedRow = null;
        } else {
            $short.addClass('d-none');
            $full.removeClass('d-none');
            $link.text('Less');
            expandedRow = $wrapper;
        }
    });
});