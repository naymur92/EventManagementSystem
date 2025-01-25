$(document).ready(function () {
    // let datepickerVal = document.getElementById('datepicker').value ?? '';
    let datepickerVal = $('.datepicker').val() ?? '';
    // datepicker interactions
    $(".date-selector-icon").on('click', function () {
        var dateInput = $(this).prev();
        // var hasFocus = dateInput.is(':focus');
        dateInput.focus();
        // if (!hasFocus) {
        // } else {
        //     dateInput.focusout();
        // }

        // console.log(dateInput.val())
    })

    // datepicker initializations
    $("#monthpicker").datepicker({
        format: "yyyy-mm",
        viewMode: "months",
        minViewMode: "months",
        orientation: "auto",
        autoClose: true,
        language: "bn",
        // value: month_val
    });
    $("#yearpicker").datepicker({
        format: "yyyy",
        viewMode: "years",
        minViewMode: "years",
        orientation: "auto",
        autoClose: true,
        language: "bn",
    });
    $("#datepicker").datepicker({
        format: "yyyy-mm-dd",
        orientation: "auto",
        autoClose: true,
        todayHighlight: true,
        value: datepickerVal,
        language: "bn",
    });
    $(".datepicker-selector").datepicker({
        format: "yyyy-mm-dd",
        orientation: "auto",
        autoClose: true,
        todayHighlight: true,
        language: "bn",
    })

})