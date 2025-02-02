// single image selector
function fileSelection(imageSelector, container, imageRemoveBtn, formSelector, maxSize, accepedTypes, requiredImage = true) {
    let imageTag = container.children('img');
    let old_img_src = imageTag.attr('src');
    imageSelector.val("");

    imageSelector.on('change', function (event) {
        const file = event.target.files[0];
        imageSelector.removeClass('is-invalid');
        $(".errors").remove();

        // check file type validation
        var file_type = file.type;
        if (!accepedTypes.includes(file_type)) {
            imageSelector.addClass('is-invalid');
            $("<span class='errors invalid-feedback' role='alert'><strong>Unsupported filetype!</strong></span>")
                .insertAfter(imageSelector);

            // remove img from dom
            imageSelector.val("");
        } else if (file.size > maxSize * maxSize) {
            imageSelector.addClass('is-invalid');
            $(`<span class='errors invalid-feedback' role='alert'><strong>Maximum filesize is ${maxSize} KB!</strong></span>`)
                .insertAfter(imageSelector);

            // remove img from dom
            imageSelector.val("");
        } else {
            let imgUrl = URL.createObjectURL(file);
            imageTag.attr('src', imgUrl);

            // show remove btn
            imageRemoveBtn.css('display', 'inline');
        }
    });

    // on click image remove button
    imageRemoveBtn.on('click', function () {
        imageSelector.val("");
        imageTag.attr('src', old_img_src);
        $(this).css('display', 'none');
    });

    // on submit form
    formSelector.on('submit', function (e) {
        e.preventDefault();
        imageSelector.removeClass('is-invalid');
        $(".errors").remove();

        if (requiredImage && old_img_src == imageTag.attr('src')) {
            imageSelector.addClass('is-invalid');
            $("<span class='errors invalid-feedback' role='alert'><strong>Select an image first!</strong></span>")
                .insertAfter(imageSelector);

            return false;
        }
        // if (old_img_src == imageTag.attr('src')) {

        // } else {
        //   // console.log(formSelector.attr('id'))
        //   let form_id = formSelector.attr('id');
        //   document.getElementById(form_id).submit();
        // }
        let form_id = formSelector.attr('id');
        document.getElementById(form_id).submit();
    });
}

// multiple file/image selector
function multipleFileSelection(fileSelector, imageContainer, fileContainer, formSelector, maxSize, maxFiles, accepedTypes, requiredFile = true) {
    // start
    var selectedFiles = [];
    var filesURL = [];

    // print files into dom
    function printFilesToDom() {
        var imageItems = '';
        var pdfItems = '';

        filesURL.forEach((url, index) => {
            // console.log(url)
            if (selectedFiles[index].type == 'application/pdf') {
                // list pdfs
                pdfItems +=
                    `<li class="position-relative mr-2" style="width:fit-content;"><a href="${url}" target="_blank">${selectedFiles[index].name}</a><i key="${index}" class="fas fa-sm fa-times text-danger remove-btn file-remove-btn ml-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove File"></i></li>`
            } else {
                // print images
                imageItems +=
                    `<div class="position-relative mr-2"><img src="${url}" style="width: 150px" class="img-thumbnail selected-image" /><i key="${index}" class="fas fa-times text-danger remove-btn image-remove-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Image"></i></div>`;
            }
        })

        imageContainer.html(imageItems)
        fileContainer.html(pdfItems)
    }

    // on click remove button
    $(document).on('click', '.remove-btn', function () {
        const itemIndex = parseInt($(this).attr('key'));
        let tempFiles = selectedFiles.filter((_, index) => index !== itemIndex);
        selectedFiles = tempFiles;

        // remove selected urls
        let tempUrls = filesURL.filter((_, index) => index !== itemIndex);
        filesURL = tempUrls;

        // regenerate items
        printFilesToDom()
    });

    // check validations and add to collection
    function addFileToSelectedFiles(files) {
        fileSelector.removeClass('is-invalid');
        $(".errors").remove();

        for (var i = 0; i < files.length; ++i) {
            let error_found = false;

            // check file type validation
            var file_type = files[i].type;
            if (!accepedTypes.includes(file_type)) {
                $("<span class='errors invalid-feedback' role='alert'><strong>Unsupported filetype!</strong></span>")
                    .insertAfter(fileSelector);
                error_found = true;

            }

            // file size validation
            if (files[i].size > maxSize * maxSize) {
                $(`<span class='errors invalid-feedback' role='alert'><strong>Maximum filesize is ${maxSize} KB!</strong></span>`)
                    .insertAfter(fileSelector);

                error_found = true;
            }

            // file count validation
            if (selectedFiles.length == maxFiles) {
                $(`<span class='errors invalid-feedback' role='alert'><strong>Maximum files is ${maxFiles}</strong></span>`)
                    .insertAfter(fileSelector);

                error_found = true;
            }


            if (error_found) {
                fileSelector.addClass('is-invalid');
                break;
            }

            selectedFiles.push(files[i])
            let fileUrl = URL.createObjectURL(files[i]);
            filesURL.push(fileUrl)
            // imageTag.attr('src', fileUrl);


        }
        printFilesToDom();
    }

    // on change file selector
    fileSelector.on('change', function (event) {
        // console.log(fileSelector)
        // console.log(typeof event.target.files)
        const files = document.getElementById(fileSelector.attr('id')).files;
        addFileToSelectedFiles(files)
    });

    // on submit form
    formSelector.on('submit', function (e) {
        e.preventDefault();
        fileSelector.removeClass('is-invalid');
        $(".errors").remove();

        if (requiredFile && selectedFiles.length == 0) {
            fileSelector.addClass('is-invalid');
            $("<span class='errors invalid-feedback' role='alert'><strong>Select file first!</strong></span>")
                .insertAfter(fileSelector);

            return false;
        }

        // replace file selector data with selectedFiles
        var newFileList = new DataTransfer();
        selectedFiles.forEach(function (file) {
            newFileList.items.add(file);
        });
        document.getElementById(fileSelector.attr('id')).files = newFileList.files

        let form_id = formSelector.attr('id');
        document.getElementById(form_id).submit();
    });
    // end
}

function printDoc(id, title, orientation = 'portrait') {
    var div = $(`#${id}`);

    var w = window.open();

    w.document.write('<html><head><title>' + title + '</title>');
    w.document.write('<style>@media print{@page {size: ' + orientation + '}}</style>');

    w.document.write('</head><body>');
    w.document.write(div.html());
    w.document.write('</body></html>');

    w.document.close();
    w.print();
    w.close();
}

async function printElement(id, title, orientation = 'portrait') {
    var elementToPrint = document.getElementById(id);
    if (!elementToPrint) {
        console.error('Element with id "' + id + '" not found.');
        return;
    }

    // Create a spinning loader with Font Awesome icon
    var loader = document.createElement('div');
    loader.style.position = 'fixed';
    loader.style.top = '50%';
    loader.style.left = '50%';
    loader.style.transform = 'translate(-50%, -50%)';
    loader.innerHTML = '<i class="fas fa-spinner fa-spin" style="font-size: 4em; color: #3498db;"></i>';
    document.body.appendChild(loader);

    // Wait for 2 seconds before initiating printing
    setTimeout(function () {
        printWithLoader(elementToPrint, title, orientation, cssFiles, fontUrls, loader);
    }, 1000);

    // Listen for "afterprint" event to remove loader immediately after canceling print
    window.addEventListener('afterprint', function () {
        document.body.removeChild(loader);
    });

    // Function to print content with loader
    function printWithLoader(elementToPrint, title, orientation, cssFiles, fontUrls, loader) {
        // Create a new hidden iframe
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none';
        document.body.appendChild(iframe);

        // Create the HTML content to be printed
        var htmlContent = '<html><head><meta charset="utf-8"><title>' + title + '</title>';
        htmlContent += '<style>@media print{@page {size: ' + orientation + '}}</style>';
        // fontUrls.forEach(function (url) {
        //     htmlContent += '<link rel="stylesheet" type="text/css" href="' + url + '">';
        // });
        cssFiles.forEach(function (file) {
            htmlContent += '<link rel="stylesheet" type="text/css" href="' + file + '">';
        });
        htmlContent += '</head><body>';
        htmlContent += elementToPrint.innerHTML; // Append the innerHTML of the target element
        htmlContent += '</body></html>';

        // Write HTML content to the iframe
        iframe.contentDocument.open();
        iframe.contentDocument.write(htmlContent);
        iframe.contentDocument.close();

        // Wait for the iframe content to load
        iframe.onload = function () {
            // Print the iframe content
            iframe.contentWindow.print();

            // Remove the iframe and loader after printing
            setTimeout(function () {
                document.body.removeChild(iframe);
                document.body.removeChild(loader);
            }, 100); // Adjust delay as needed
        };
    }
}


// form interactions
function setSpinner() {
    $(".formElement form").css("pointer-events", "none");
    $(".formElement").css("cursor", "wait");
}
function unsetSpinner() {
    $(".formElement form").css("pointer-events", "auto");
    $(".formElement").css("cursor", "default");
}
function pressSubmitBtn(btnId = null, btnText = null) {
    let submitButton = document.getElementById(btnId ?? "submitBtn");

    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + (btnText ?? 'Processing...');
}
function releaseSubmitBtn(btnId = null, btnText = null) {
    let submitButton = document.getElementById(btnId ?? "submitBtn");

    submitButton.disabled = false;
    submitButton.innerText = btnText ?? "Save";
}
function setCursorWait(selector = '.page-content') {
    $(`${selector} div`).css("pointer-events", "none");
    $(selector).css("cursor", "wait");
}
function unsetCursorWait(selector = '.page-content') {
    $(`${selector} div`).css("pointer-events", "auto");
    $(selector).css("cursor", "default");
}


function insertFormError(selector, message) {
    $(selector).addClass('is-invalid');
    $(`<span class='errors invalid-feedback' role='alert'><strong>${message}</strong></span>`).insertAfter(selector);
}

function removeFormError(selector) {
    $(selector).removeClass('is-invalid');
    $(".errors").remove();
}

function validateMobileNumber(value) {
    value = value.trim();

    let mobilePattern = /^01\d{9}$/;
    return mobilePattern.test(value) || value.length == 0;
}
