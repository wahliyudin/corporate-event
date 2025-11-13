"use strict";

import { toastError, toastSuccess, toastWarning } from "./toast.js";

export default function toastMessage(type, message) {
    switch (type) {
        case 'success': toastSuccess(message); break;
        case 'warning': toastWarning(message); break;
        case 'error': toastError(message); break;
        default: console.warn('Unknown toast type:', type); break;
    }
}
