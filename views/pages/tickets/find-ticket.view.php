<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>

<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<script>
    function insertFormError(selector, message) {
        $(selector).addClass('is-invalid');
        $(`<span class='errors invalid-feedback' role='alert'><strong>${message}</strong></span>`).insertAfter(selector);
    }

    // call function at beginning
    $(function() {
        $("#ticket_find_form").on('submit', function(e) {
            e.preventDefault();

            $(".ticket-view-btn-area").hide();

            const formFields = {
                booking_no: $("#booking_number_field"),
                mobile: $("#mobile_field"),
                email: $("#email_field")
            };

            // remove all errors first
            $('.input-area > input').removeClass('is-invalid');
            $(".errors").remove();

            var errorFound = false;

            bookingNumber = formFields.booking_no.val();
            mobile = formFields.mobile.val();
            email = formFields.email.val();

            // validation
            if (bookingNumber == '') {
                insertFormError(formFields.booking_no, 'Enter Booking No!');
                errorFound = true;
            } else {
                if (mobile == '' && email == '') {
                    insertFormError(formFields.mobile, 'Enter mobile no!');
                    insertFormError(formFields.email, 'Enter email!');

                    errorFound = true;
                }
            }

            if (errorFound) {
                swalMessage('error', 'Please fill the form carefully!');
                return;
            }

            params = {
                booking_no: bookingNumber,
                email: email,
                mobile: mobile,
            };

            Swal.fire({
                title: "Are you sure?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {

                    setSpinner();
                    pressSubmitBtn("ticket_find_submit_btn", "Finding...");

                    callApi('/api/find-tickets', params).then((response) => {
                        if (response.status) {
                            // console.log(response.data);
                            // location.href = response.data.redirect_url;
                            $(".ticket-view-btn-area").show();
                            $(".ticket-view-btn-area a").attr('href', response.data.redirect_url);
                            swalMessage('success', response.message);
                        } else {
                            // console.error(response);
                            swalMessage('error', response.message);
                        }

                        unsetSpinner();
                        releaseSubmitBtn("ticket_find_submit_btn", "Find Now");
                    }).catch((error) => {
                        // console.error(error);
                        errObj = error.responseJSON ?? {};

                        errors = errObj.errors ?? {};

                        Object.keys(errors).forEach(key => {
                            errors[key].forEach(message => {
                                insertFormError(formFields[key], message);
                            })
                        });

                        swalMessage('error', errObj.message);

                        unsetSpinner();
                        releaseSubmitBtn("ticket_find_submit_btn", "Find Now");
                    })
                }
            });
        })
    })
</script>
<?php $scriptsBlock = ob_get_clean();
?>


<!--===== HERO AREA STARTS =======-->
<div class="inner-page-header" style="background-image: url(<?= getBaseUrl() ?>/assets/img/bg/header-bg8.png)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading1 text-center">
                    <h1>Find Ticket</h1>
                    <div class="space20"></div>
                    <a href="<?= route('/') ?>">Home</a>
                    <a href="#"><i class="mx-2 fa-solid fa-angle-right"></i><span>Find Ticket</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== EVENT AREA STARTS =======-->
<div class="blog-details-section contact-inner-section sp8 page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="contact4-boxarea formElement">
                    <h3 class="text-anime-style-3 text-center">Find Ticket</h3>
                    <div class="space8"></div>

                    <form action="" id="ticket_find_form">
                        <div class="row">
                            <div class="col-lg-12 col-md-6">
                                <div class="input-area">

                                    <input id="booking_number_field" type="text" placeholder="Booking Number" />
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-6">
                                <div class="input-area">
                                    <input id="mobile_field" type="text" placeholder="Mobile" />
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="input-area">
                                    <input id="email_field" type="email" placeholder="Email" />
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="space24"></div>
                                <div class="input-area text-end">
                                    <button type="submit" class="vl-btn1" id="ticket_find_submit_btn">Find Now</button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="text-center ticket-view-btn-area" style="display: none;">
                        <div class="space8"></div>
                        <a href="" class="btn btn-success">View Ticket</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="space12"></div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->