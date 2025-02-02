<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>
<style>
    .is-invalid {
        border: 1px solid #dc3545;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<script>
    var eventId = "<?= $event->event_id ?>";
    var userId = "<?= authUser()->user_id ?? '' ?>";
    var registrationFee = "<?= $event->registration_fee ?>";
    var maxCapacity = "<?= $event->max_capacity ?>";
    var currentCapacity = "<?= $event->current_capacity ?>";

    var errorFound = false;

    // main function
    // async function main() {}

    // call function at beginning
    $(function() {
        $("#event_registration_form").on('submit', function(e) {
            e.preventDefault();

            const formFields = {
                name: $("#name_field"),
                email: $("#email_field"),
                mobile: $("#mobile_field"),
                payment_trnx_no: $("#trnx_no_field"),
                payment_amount: $("#payment_amount_field"),
                payment_account_no: $("#payment_account_field"),
            };

            var nameFieldValue = formFields.name.val() ?? '';
            var emailFieldValue = formFields.email.val() ?? '';
            var mobileFieldValue = formFields.mobile.val() ?? '';
            var trnxNoFieldValue = formFields.payment_trnx_no.val() ?? '';
            var paymentAmountFieldValue = formFields.payment_amount.val() ?? '';
            var paymentAccountFieldValue = formFields.payment_account_no.val() ?? '';

            // remove all errors first
            removeFormError('.input-area > input')

            // validation
            if (nameFieldValue == '') {
                insertFormError(formFields.name, 'Enter your name!');
                errorFound = true;
            }
            if (emailFieldValue == '') {
                insertFormError(formFields.email, 'Enter your email!');
                errorFound = true;
            }
            if (mobileFieldValue == '') {
                insertFormError(formFields.mobile, 'Enter mobile number!');
                errorFound = true;
            }
            if (!validateMobileNumber(mobileFieldValue)) {
                insertFormError(formFields.mobile, "Invalid mobile number");
                errorFound = true;
            }

            if (registrationFee > 0) {
                if (trnxNoFieldValue == '') {
                    insertFormError(formFields.payment_trnx_no, 'Enter transaction number!');
                    errorFound = true;
                }
                if (paymentAmountFieldValue == '') {
                    insertFormError(formFields.payment_amount, 'Enter payment amount!');
                    errorFound = true;
                }
                if (paymentAmountFieldValue > 0 && paymentAmountFieldValue != registrationFee) {
                    insertFormError(formFields.payment_amount, 'Invalid payment amount!');
                    errorFound = true;
                }
                if (paymentAccountFieldValue == '') {
                    insertFormError(formFields.payment_account_no, 'Enter account number!');
                    errorFound = true;
                }
            }

            if (errorFound) {
                swalMessage('error', 'Please fill the form carefully!');
                return;
            }

            params = {
                event_id: eventId,
                user_id: userId,
                name: nameFieldValue,
                email: emailFieldValue,
                mobile: mobileFieldValue,
                payment_trnx_no: trnxNoFieldValue,
                payment_amount: paymentAmountFieldValue,
                payment_account_no: paymentAccountFieldValue,
            };

            Swal.fire({
                title: "Are you sure?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {

                    setSpinner();
                    pressSubmitBtn("event_reg_submit_btn");

                    callApi('/api/event-registration', params).then((response) => {
                        if (response.status) {
                            let msg = "Registration successfull! Your booking number is: " + response.data.booking_no + ". You want to print your ticket now?";
                            Swal.fire({
                                title: `${msg}`,
                                showDenyButton: true,
                                confirmButtonText: "Yes",
                                denyButtonText: "No",
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = response.data.redirect_url;
                                } else {
                                    location.href = BASE_URL;
                                }
                            });
                        } else {
                            // console.error(response);
                            swalMessage('error', response.message);
                        }

                        unsetSpinner();
                        releaseSubmitBtn("event_reg_submit_btn", "Book Event");
                    }).catch((error) => {
                        // console.error(error);
                        errObj = error.responseJSON;

                        errors = errObj.errors ?? {};

                        Object.keys(errors).forEach(key => {
                            errors[key].forEach(message => {
                                insertFormError(formFields[key], message);
                            })
                        });

                        swalMessage('error', errObj.message);

                        unsetSpinner();
                        releaseSubmitBtn("event_reg_submit_btn", "Book Event");
                    })
                }
            });
        })

        // mobile number validation
        $("#mobile_field").on("input", function() {
            // remove all errors first
            removeFormError('.input-area > input')

            let value = $(this).val().trim();

            if (!validateMobileNumber(value)) {
                insertFormError($("#mobile_field"), "Invalid mobile number");
            }
        });
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
                    <h1>Get Ticket</h1>
                    <div class="space20"></div>
                    <a href="<?= route('/') ?>">Home</a>
                    <a href="<?= route('/events') ?>"><i class="mx-2 fa-solid fa-angle-right"></i>Events</a>
                    <a href="#"><i class="mx-2 fa-solid fa-angle-right"></i><span>Get Ticket</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== EVENT AREA STARTS =======-->
<div class="blog-details-section contact-inner-section sp8 page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="contact4-boxarea formElement">
                    <h3 class="text-anime-style-3">Please give your information</h3>
                    <div class="space8"></div>

                    <form action="" id="event_registration_form">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="input-area">
                                    <?php if (authUser() && authUser()->name != ""): ?>
                                        <input id="name_field" type="text" value="<?= authUser()->name ?>" disabled readonly placeholder="Name" />
                                    <?php else: ?>
                                        <input id="name_field" type="text" placeholder="Name" />
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="input-area">
                                    <?php if (authUser() && authUser()->mobile != ""): ?>
                                        <input id="mobile_field" type="text" value="<?= authUser()->mobile ?>" disabled readonly placeholder="Mobile" />
                                    <?php else: ?>
                                        <input id="mobile_field" type="text" placeholder="Mobile" />
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-6">
                                <div class="input-area">
                                    <?php if (authUser() && authUser()->email != ""): ?>
                                        <input id="email_field" type="email" value="<?= authUser()->email ?>" disabled readonly placeholder="Email" />
                                    <?php else: ?>
                                        <input id="email_field" type="email" placeholder="Email" />
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- payment info -->
                            <?php if ($event->registration_fee != 0): ?>
                                <div class="space24"></div>
                                <div class="col-12">
                                    <div class="alert alert-danger m-0" role="alert">
                                        Please transfer registration fee to bKash or bank account below: <br>
                                        <strong>bKash</strong>: 017xxxxxxxx <br>
                                        <strong>Bank</strong>: 897xxxxxxxxxxx, City Bank, Kawran Bazar Branch <br>
                                    </div>
                                    <span class="badge bg-success">Registration Fee: Tk. <?= $event->registration_fee ?></span>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="input-area">
                                        <input id="trnx_no_field" type="text" placeholder="Payment Trnx No" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="input-area">
                                        <input id="payment_amount_field" type="text" placeholder="Payment Amount" />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-6">
                                    <div class="input-area">
                                        <input id="payment_account_field" type="text" placeholder="Accout No" />
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-lg-12">
                                <div class="space24"></div>
                                <div class="input-area text-end">
                                    <button type="submit" class="vl-btn1" id="event_reg_submit_btn">Book Now</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="blog-auhtor-details">
                    <div class="blog-categories">
                        <h3><?= $event->name; ?></h3>

                        <div class="space8"></div>
                        <?php if ($event->current_capacity > 0 && $event->max_capacity != 0): ?>
                            <span class="badge bg-info text-dark"><?= $event->current_capacity ?> Seats Available</span>
                        <?php else: ?>
                            <span class="badge bg-info text-dark">Unlimited Registration</span>
                        <?php endif; ?>

                        <?php if ($event->registration_fee != 0): ?>
                            <span class="badge bg-success">Registration Fee: Tk. <?= $event->registration_fee ?></span>
                        <?php else: ?>
                            <span class="badge bg-success">Free Registration</span>
                        <?php endif; ?>

                        <div class="space24"></div>

                        <h3>Date & Time</h3>
                        <div class="space8"></div>
                        <div><img src="<?= getBaseUrl() ?>/assets/img/icons/calender1.svg" alt="" /><span>
                                <?= date('Y-m-d h:i A', strtotime($event->start_time)) ?>
                                <?php if ($event->end_time != '') {
                                    echo ' - ' . date('Y-m-d h:i A', strtotime($event->end_time));
                                } ?>
                            </span></div>

                        <div class="space24"></div>

                        <h3>Location</h3>
                        <div class="space8"></div>
                        <div><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /><span> <?= $event->location ?></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space12"></div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->