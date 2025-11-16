const btnEdit = (key) => {
    return `
        <button class="btn btn-info-light btn-wave btn-sm" title="Edit" data-key="${key}" id="btn-edit">
            <span class="indicator-label">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-edit-line"></i>
                </div>
            </span>
            <span class="indicator-progress">
                <span class="spinner-border spinner-border-sm align-middle"></span>
            </span>
        </button>
    `;
}
const btnDelete = (key) => {
    return `
        <button class="btn btn-danger-light btn-wave btn-sm" title="Delete" data-key="${key}" id="btn-delete">
            <span class="indicator-label">
                <div class="d-flex align-items-center gap-2">
                    <i class="ri-delete-bin-line"></i>
                </div>
            </span>
            <span class="indicator-progress">
                <span class="spinner-border spinner-border-sm align-middle"></span>
            </span>
        </button>
    `;
}

const action = (data, type, row) => {
    var btns = '';
    if (data.can_update) {
        btns += btnEdit(row.id);
    }
    if (data.can_delete) {
        btns += btnDelete(row.id);
    }
    return '<div class="d-flex align-items-center justify-content-center gap-1">' + btns + '</div>';
}

export { action }

