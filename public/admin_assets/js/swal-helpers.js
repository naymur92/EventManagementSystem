function swalConfirmationOnSubmit(event, msg) {
    event.preventDefault();

    Swal.fire({
        title: msg,
        showDenyButton: true,
        confirmButtonText: "Yes",
        denyButtonText: "No",
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            event.target.submit();
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

async function showFlashMessages(swalErrors) {
    errorsBody = [];
    Object.keys(swalErrors).forEach(key => {
        // console.log(key, swalErrors[key]);
        errorType = "";
        if (key == 'flash_error') errorType = "error";
        else if (key == 'flash_success') errorType = 'success';
        else if (key == 'flash_warning') errorType = 'warning';
        else if (key == 'flash_info') errorType = 'info';

        errors = swalErrors[key];
        errors.forEach(message => {
            errorsBody.push({
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

    // console.log(errorsBody)
    for (const body of errorsBody) {
        await Swal.fire(body);
    }
}