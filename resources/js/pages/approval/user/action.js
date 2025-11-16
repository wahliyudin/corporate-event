const btnApprove = (key) => {
    return `
        <button class="btn btn-info-light btn-wave btn-sm" title="Approve" data-key="${key}" id="btn-approve">
            <span class="indicator-label">
                <div class="d-flex align-items-center fs-6 fw-bold gap-2">
                    <i class="ri-check-line"></i>
                </div>
            </span>
            <span class="indicator-progress">
                <span class="spinner-border spinner-border-sm align-middle"></span>
            </span>
        </button>
    `;
}
const btnReject = (key) => {
    return `
        <button class="btn btn-danger-light btn-wave btn-sm" title="Reject" data-key="${key}" id="btn-reject">
            <span class="indicator-label">
                <div class="d-flex align-items-center fs-6 fw-bold gap-2">
                    <i class="ri-close-line"></i>
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
    if (data.can_approve) {
        btns += btnApprove(row.id);
    }
    if (data.can_reject) {
        btns += btnReject(row.id);
    }
    return '<div class="d-flex align-items-center justify-content-center gap-1 flex-wrap">' + btns + '</div>';
}

export { action }

