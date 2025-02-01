<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<link href="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<!-- Page level plugins -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= getBaseUrl() ?>/admin_assets/js/demo/datatables-demo.js"></script>


<script>
    var uniqueId = "";
    var userId = "";

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
            userId = $(this).attr('data-user-id');
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

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Event Info</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <a href="<?= route('/admin/events') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row align-items-center justify-content-between">
                <div class="col-12">
                    <table class="show-table table border table-bordered">
                        <tr style="width: 20%;">
                            <th>Event Name</th>
                            <td><?= $event->name ?></td>
                        </tr>

                        <tr>
                            <th>Location</th>
                            <td><?= $event->location ?></td>
                        </tr>

                        <tr>
                            <th>Start Time</th>
                            <td>
                                <?= $event->start_time != '' ? date('d M, Y - H:i A', strtotime($event->start_time)) : "Any Time" ?>
                                <?php if ($event->start_time != '' && $event->start_time < date('Y-m-d H:i:s')): ?>
                                    <span class="badge badge-pill badge-danger">Expired</span>
                                <?php endif; ?>
                            </td>
                        </tr>

                        <tr>
                            <th>End Time</th>
                            <td>
                                <?= $event->end_time != '' ? date('d M, Y - H:i A', strtotime($event->end_time)) : "" ?>
                            </td>
                        </tr>


                        <tr>
                            <th>Max Capacity</th>
                            <td><?= $event->max_capacity > 0 ? $event->max_capacity : "Unlimited" ?></td>
                        </tr>


                        <tr>
                            <th>Current Capacity</th>
                            <td><?= $event->max_capacity > 0 ? $event->current_capacity : "Unlimited" ?></td>
                        </tr>


                        <tr>
                            <th>Registration Fee</th>
                            <td><?= $event->registration_fee > 0 ? $event->registration_fee : "Free" ?></td>
                        </tr>

                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Event Attendee List</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <a href="<?= route("/admin/events/{$event->event_id}/download-attendee-list") ?>" class="btn waves-effect waves-light br-5 btn-success">Download List
                    </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table data-display-length='100' class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">

                            <!-- <colgroup>
                                <col style="width: 5%;">
                                <col style="width: 25%;">
                                <col style="width: 20%;">
                                <col style="width: 15%;">
                                <col style="width: 10%;">
                                <col style="width: 10%;">
                                <col style="width: 5%;">
                                <col style="width: 10%;">
                            </colgroup> -->

                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Booking No</th>
                                    <th class="align-middle">Attendee Name</th>
                                    <th class="align-middle">Attendee Email</th>
                                    <th class="align-middle">Attendee Mobile</th>

                                    <th class="align-middle">Payment Trnx No</th>
                                    <th class="align-middle">Payment Amount</th>
                                    <th class="align-middle">Payment Account No</th>

                                    <th class="align-middle">Registration Time</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Cancel Reason</th>
                                    <th class="no-sort align-middle">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($attendees as $key => $item): ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                                        <td class="align-middle"><?= $item['booking_no'] ?></td>
                                        <td class="align-middle"><?= $item['name'] ?></td>
                                        <td class="align-middle"><?= $item['email'] ?></td>
                                        <td class="align-middle"><?= $item['mobile'] ?></td>

                                        <td class="align-middle"><?= $item['payment_trnx_no'] ?></td>
                                        <td class="align-middle"><?= $item['payment_amount'] ?></td>
                                        <td class="align-middle"><?= $item['payment_account_no'] ?></td>

                                        <td class="text-center align-middle"><?= date('Y-m-d h:i A', strtotime($item['registration_time'])) ?></td>

                                        <td class="text-center align-middle">
                                            <span class="badge badge-pill <?= $item['status'] == 0 ? 'badge-danger' : 'badge-success' ?>">
                                                <?= $item['status'] == 0 ? 'Cancelled' : 'Confirmed' ?>
                                            </span>
                                        </td>
                                        <td class="align-middle"><?= $item['cancel_reason'] ?></td>

                                        <td class="align-middle">
                                            <div class="text-center d-flex justify-content-center align-items-center">
                                                <?php if ($item['status'] == 1): ?>
                                                    <?php $uniquiId = encodeData([$item['booking_no'], $item['attendee_id']]); ?>

                                                    <a href="<?= route("/admin/tickets/$uniquiId/view-ticket") ?>" data-toggle="tooltip" data-placement="top" title="View Ticket" class="table-data-modify-icon mr-2" target="_blank">
                                                        <span class="badge badge-primary"><i class="fa-solid fa-ticket"></i></span>
                                                    </a>

                                                    <!-- cancel ticket modal button -->
                                                    <a href="#" data-user-id="<?= $item['user_id'] ?>" data-unique-id="<?= $uniquiId ?>" title="Cancel Ticket" class="table-data-modify-icon mx-1 cancel-ticket-btn" data-toggle="modal" data-target="#ticketCancelModal">
                                                        <span class="badge badge-warning"><i class="fa-solid fa-rectangle-xmark"></i></span>
                                                    </a>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

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

</div>