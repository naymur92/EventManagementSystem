function swalConfirmationOnSubmit(event, msg) {
    event.preventDefault();
    let target = event.target;

    Swal.fire({
        title: msg,
        showDenyButton: true,
        confirmButtonText: "Yes",
        denyButtonText: "No",
    }).then((result) => {
        if (result.isConfirmed) {
            if (target.matches(".logout-btn")) {
                let form = target.closest("form");
                if (form) {
                    form.submit();
                }
            } else if (target.tagName === "FORM") {
                target.submit();
            }
        }
    });
}

function swalToast(icon, message) {
    Swal.fire({
        text: `${message}`,
        icon: `${icon}`,
        toast: true,
        showConfirmButton: false,
        position: 'top-end',
        timer: 1500,
        timerProgressBar: true,
    });
}

function swalMessage(icon, message) {
    Swal.fire({
        text: `${message}`,
        icon: `${icon}`,
    });
}

async function showFlashMessages(swalFlashes) {
    flashBody = [];
    Object.keys(swalFlashes).forEach(key => {
        // console.log(key, swalFlashes[key]);
        errorType = "";
        if (key == 'flash_error') errorType = "error";
        else if (key == 'flash_success') errorType = 'success';
        else if (key == 'flash_warning') errorType = 'warning';
        else if (key == 'flash_info') errorType = 'info';

        swalFlashes[key].forEach(message => {
            flashBody.push({
                text: `${message}`,
                icon: `${errorType}`,
                toast: true,
                showConfirmButton: false,
                position: 'top-end',
                timer: 1500,
                timerProgressBar: true,
            });
        })
    });

    // console.log(flashBody)
    for (const body of flashBody) {
        await Swal.fire(body);
    }
}

async function showPopupMessages(swalPopups) {
    popupBody = [];
    Object.keys(swalPopups).forEach(key => {
        errorType = "";
        if (key == 'popup_error') errorType = "error";
        else if (key == 'popup_success') errorType = 'success';
        else if (key == 'popup_warning') errorType = 'warning';
        else if (key == 'popup_info') errorType = 'info';

        swalPopups[key].forEach(message => {
            popupBody.push({
                text: `${message}`,
                icon: `${errorType}`,
            });
        })
    });

    // console.log(popupBody)
    for (const body of popupBody) {
        await Swal.fire(body);
    }
}