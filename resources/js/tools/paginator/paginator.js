(function ($) {

    $.fn.laravelPaginator = function (options, extraParams) {

        // ======================================================
        // Method Mode (Call from outside)
        // ======================================================
        if (typeof options === "string") {

            let instance = $(this).data("lp-instance");

            if (!instance) {
                console.warn("laravelPaginator not initialized.");
                return this;
            }

            switch (options) {
                case "reload":
                    instance.reload(extraParams || {});
                    break;

                case "setParams":
                    instance.setParams(extraParams || {});
                    break;

                case "mergeParams":
                    instance.mergeParams(extraParams || {});
                    break;

                case "refresh":
                    instance.refresh();
                    break;

                default:
                    console.warn("Unknown method:", options);
            }

            return this;
        }

        // ======================================================
        // Initialization Mode
        // ======================================================

        let container = $(this);

        // Wrap if not wrapped yet
        if (!container.parent().hasClass("lp-wrapper")) {
            container.wrap(`
                <div class="lp-wrapper" style="
                    position: relative;
                    min-height: 120px;
                "></div>
            `);
        }

        let wrapper = container.parent();

        let settings = $.extend({
            url: null,
            page: 1,
            perPage: 10,
            method: 'GET',
            params: {},
            targetPagination: $('#pagination'),
            pagination: true,

            minHeight: 120,

            // Search input (optional)
            searchInput: null,
            searchParam: "search",
            searchDelay: 400,

            // Callbacks
            renderData: function (data, container) { },
            onEmpty: function (container, keyword = null) {
                let message = "Sorry, there is no content to display at the moment.";
                if (keyword && keyword.trim() !== "") {
                    message = `No results found for <strong>${keyword}</strong>`;
                }
                const emptyBox = $(`<div class="lp-empty-state" style=" position: absolute; inset: 0; display: flex; justify-content: center; align-items: center; text-align: center; pointer-events: none; z-index: 20; "> <div class="text-muted"> ${message} </div> </div>`);
                wrapper.find(".lp-empty-state").remove();
                wrapper.append(emptyBox);
            },
            onBeforeLoad: function (params) { },
            onAfterLoad: function (res) { },
            onError: function (err) { },

        }, options);

        wrapper.css("min-height", settings.minHeight + "px");

        // Loader
        const loader = $(`
            <div class="lp-loader" style="
                position: absolute;
                inset: 0;
                display: none;
                justify-content: center;
                align-items: center;
                z-index: 999;
            ">
                <div class="w-100 h-100 d-flex align-items-center justify-content-center">
                    <div class="shadow-sm p-2 rounded bg-white d-flex align-items-center gap-2">
                        <div class="spinner-border spinner-border-sm text-primary"></div>
                        <span>Loading...</span>
                    </div>
                </div>
            </div>
        `);

        wrapper.append(loader);

        function showLoader() { loader.fadeIn(120); }
        function hideLoader() { loader.fadeOut(120); }

        let typingTimer = null;


        // ======================================================
        // Load Data
        // ======================================================
        function loadData(page = 1) {

            showLoader();

            settings.onBeforeLoad(settings.params);
            container.trigger("lp:beforeLoad", [settings.params]);

            $.ajax({
                url: settings.url,
                method: settings.method,
                data: $.extend(settings.params, {
                    page: page,
                    per_page: settings.perPage
                }),

                success: function (res) {

                    wrapper.find(".lp-empty-state").remove();

                    if (!res.data || res.data.length === 0) {

                        container.empty();
                        settings.targetPagination.empty();

                        let keyword = settings.params[settings.searchParam] ?? "";
                        settings.onEmpty(container, keyword);

                        hideLoader();
                        return;
                    }

                    // Render user content
                    settings.renderData(res.data, container);

                    // Render pagination
                    renderPagination(res);

                    settings.onAfterLoad(res);
                    container.trigger("lp:afterLoad", [res]);
                },

                error: function (err) {
                    console.error("Paginator Error:", err);
                    settings.onError(err);
                    container.trigger("lp:error", [err]);
                },

                complete: function () {
                    hideLoader();
                }
            });
        }

        // ======================================================
        // Pagination Renderer
        // ======================================================
        function renderPagination(meta) {
            if (!settings.pagination) {
                settings.targetPagination?.empty();
                return;
            }

            let html = `
                <ul class="pagination mb-4 justify-content-end">

                    <li class="page-item ${meta.current_page == 1 ? 'disabled' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${meta.current_page - 1}">
                            Prev
                        </a>
                    </li>
            `;

            for (let i = 1; i <= meta.last_page; i++) {
                html += `
                    <li class="page-item ${i == meta.current_page ? 'active' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${i}">
                            ${i}
                        </a>
                    </li>
                `;
            }

            html += `
                    <li class="page-item ${meta.current_page == meta.last_page ? 'disabled' : ''}">
                        <a class="page-link" href="javascript:void(0);" data-page="${meta.current_page + 1}">
                            Next
                        </a>
                    </li>

                </ul>
            `;

            settings.targetPagination.html(html);

            // Pagination click event
            settings.targetPagination.find('.page-link').on('click', function () {
                let page = $(this).data('page');
                if (!page || page < 1 || page > meta.last_page) return;
                loadData(page);
            });
        }

        // ======================================================
        // Search with Debounce
        // ======================================================
        if (settings.searchInput) {

            $(settings.searchInput).on('keyup', function () {

                clearTimeout(typingTimer);

                let keyword = $(this).val();

                typingTimer = setTimeout(() => {

                    settings.params[settings.searchParam] = keyword;
                    loadData(1);

                }, settings.searchDelay);

            });
        }

        // ======================================================
        // Public Methods
        // ======================================================
        let instance = {

            reload: function (newParams = {}) {
                settings.params = { ...settings.params, ...newParams };
                loadData(1);
            },

            setParams: function (newParams = {}) {
                settings.params = { ...newParams };
                loadData(1);
            },

            mergeParams: function (newParams = {}) {
                settings.params = { ...settings.params, ...newParams };
            },

            refresh: function () {
                loadData(1);
            }
        };

        $(this).data("lp-instance", instance);

        // Initial Load
        loadData(settings.page);

        return this;
    };

})(jQuery);
