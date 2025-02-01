<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>
<link href="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<style>
    .is-invalid {
        border: 1px solid #dc3545;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>
<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<!-- Page level plugins -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= getBaseUrl() ?>/admin_assets/js/demo/datatables-demo.js"></script>


<script>
    var uniqueId = "";
    var userId = "<?= authUser()->user_id ?? '' ?>";

    // main function
    // async function main() {}

    function insertFormError(selector, message) {
        $(selector).addClass('is-invalid');
        $(`<span class='errors invalid-feedback' role='alert'><strong>${message}</strong></span>`).insertAfter(selector);
    }

    // call function at beginning
    $(function() {
        // get unique id from button link
        $(".cancel-ticket-btn").on('click', function() {
            uniqueId = $(this).attr('data-unique-id');
        })

        $("#ticketCancelForm").on('submit', function(e) {
            e.preventDefault();

            const formFields = {
                cancel_reason: $("#cancel_reason")
            };

            var cancelReason = formFields.cancel_reason.val() ?? '';

            // remove all errors first
            $('.input-area > input').removeClass('is-invalid');
            $(".errors").remove();

            var errorFound = false;
            // validation
            if (cancelReason == '') {
                insertFormError(formFields.cancel_reason, 'Enter cancel reason!');
                errorFound = true;
            }

            if (errorFound) {
                // swalMessage('error', 'Please fill the form carefully!');
                return;
            }

            params = {
                uniqueId: uniqueId,
                user_id: userId,
                cancel_reason: cancelReason,
            };

            Swal.fire({
                title: "Are you sure to cancel ticket?",
                showDenyButton: true,
                confirmButtonText: "Yes",
                denyButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {

                    setSpinner();
                    pressSubmitBtn("cancelTicketBtn", "Cancelling...");

                    callApi('/api/cancel-tickets', params).then((response) => {
                        if (response.status) {
                            location.reload();
                        } else {
                            // console.error(response);
                            swalMessage('error', response.message);
                        }

                        unsetSpinner();
                        releaseSubmitBtn("cancelTicketBtn", "Cancel Now");
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
                        releaseSubmitBtn("cancelTicketBtn", "Cancel Now");
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
                    <h1>My Tickets</h1>
                    <div class="space20"></div>
                    <a href="<?= route('/') ?>">Home</a>
                    <a href="#"><i class="mx-2 fa-solid fa-angle-right"></i><span>My Tickets</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== EVENT AREA STARTS =======-->
<div class="blog-details-section contact-inner-section sp8 page-content">
    <div class="container">
        <div class="card">
            <div class="card-header">
                Ticket List
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">

                                <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Booking No</th>
                                        <th class="align-middle">Event Name</th>
                                        <th class="align-middle">Time</th>
                                        <th class="align-middle">Ticket Price</th>
                                        <th class="align-middle">Payment Amount</th>
                                        <th class="align-middle">Ticket Status</th>
                                        <th class="align-middle">Registration Time</th>
                                        <th class="no-sort align-middle">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($ticketList as $key => $item): ?>
                                        <tr>
                                            <td class="text-center align-middle"><?= $key + 1 ?></td>
                                            <td class="align-middle"><?= $item['booking_no'] ?></td>
                                            <td class="align-middle">
                                                <a href="<?= route("/events/{$item['event_id']}/view-details") ?>" class="text-dark" target="_blank"><?= $item['name'] ?></a>
                                            </td>
                                            <td class="align-middle">
                                                <?= $item['start_time'] ?>
                                                <?php if ($item['end_time']): ?>
                                                    - <?= $item['end_time'] ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center align-middle"><?= $item['registration_fee'] ?></td>
                                            <td class="text-center align-middle">
                                                <?php if ($item['registration_fee'] > 0): ?>
                                                    <?php if ($item['payment_amount'] ==  $item['registration_fee']): ?>
                                                        <span class="text-success"><?= $item['payment_amount'] ?></span>
                                                    <?php else: ?>
                                                        <span class="text-danger"><?= $item['payment_amount'] ?></span>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center align-middle">
                                                <?php if ($item['status'] == 1): ?>
                                                    <span class="text-primary">Confirmed</span>
                                                <?php else: ?>
                                                    <span class="text-danger">Cancelled</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="align-middle"><?= date("Y-m-d h:i A", strtotime($item['registration_time'])) ?></td>
                                            <td class="align-middle">
                                                <div class="text-center d-flex justify-content-center align-items-center">

                                                    <?php if ($item['status'] == 1): ?>
                                                        <?php $uniquiId = encodeData([$item['booking_no'], $item['attendee_id']]); ?>

                                                        <!-- view ticket button -->
                                                        <a href="<?= route("/tickets/$uniquiId/view-ticket") ?>" data-toggle="tooltip" data-placement="top" title="View Ticket" class="table-data-modify-icon mx-1" target="_blank">
                                                            <span class="text-primary"><i class="fa-solid fa-ticket"></i></span>
                                                        </a>

                                                        <!-- cancel ticket modal button -->
                                                        <!-- allow cancellation before 6 hrs to start -->
                                                        <?php if (strtotime("-6 hours", strtotime($item['start_time'])) > time()): ?>
                                                            <a href="#" data-unique-id="<?= $uniquiId ?>" data-toggle="tooltip" data-placement="top" title="Cancel Ticket" class="table-data-modify-icon mx-1 cancel-ticket-btn" data-bs-toggle="modal" data-bs-target="#ticketCancelModal">
                                                                <span class="text-warning"><i class="fa-solid fa-rectangle-xmark"></i></span>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endif; ?>

                                                </div>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="ticketCancelModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="ticketCancelModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content formElement">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ticketCancelModalLabel">Cancel Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="ticketCancelForm">
                        <div class="modal-body">
                            <div class="form-body">
                                <input id="cancel_reason" class="form-control" type="text" placeholder="Cancel Reason" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button id="cancelTicketBtn" type="submit" class="btn btn-primary">Cancel Now</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="space24"></div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->