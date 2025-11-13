const toastError = (msg) => {
    let toastError = document.getElementById('error-toast');
    document.querySelector('#error-toast > .toast-body').innerHTML = msg;
    var toast = new bootstrap.Toast(toastError)
    toast.show()
}

const toastSuccess = (msg) => {
    let toastSuccess = document.getElementById('success-toast');
    document.querySelector('#success-toast > .toast-body').innerHTML = msg;
    var toast = new bootstrap.Toast(toastSuccess)
    toast.show()
}

const toastWarning = (msg) => {
    let toastWarning = document.getElementById('warning-toast');
    document.querySelector('#warning-toast > .toast-body').innerHTML = msg;
    var toast = new bootstrap.Toast(toastWarning)
    toast.show()
}


export { toastError, toastSuccess, toastWarning };
