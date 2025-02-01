<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<?php $scriptsBlock = ob_get_clean();
?>


<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-primary">Ticket Copy</h5>

                    <div class="ms-auto">
                        <div class="btn-list">
                            <button onclick="printElement('event_ticket_copy', 'Event Ticket - <?= $ticketData['booking_no']; ?>')" class="btn btn-primary">Print Ticket</button>

                            <a href="<?= route("/admin/events") ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                                <i class="fas fa-angle-left"></i> Back
                            </a>

                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12">

                            <div id="event_ticket_copy" style="width: 100%; margin: 0 auto;">
                                <div style="width: 600px; margin: 20px auto; border: 2px solid #000; padding: 20px; font-family: Arial, sans-serif; text-align: center;">
                                    <h2 style="margin-bottom: 10px;">Event Ticket</h2>
                                    <hr style="border: 1px solid #000;">
                                    <h3 style="color: #d9534f;"> <?= $ticketData['name']; ?> </h3>

                                    <table style="width: 100%; border: none; text-align: left;">
                                        <tr>
                                            <th style="width: 30%;">Location</th>
                                            <td style="padding: 3px;">: <?= $ticketData['location']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Start Time</th>
                                            <td style="padding: 3px;">: <?= $ticketData['start_time']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Booking No</th>
                                            <td style="padding: 3px;">: <?= $ticketData['booking_no']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Attendee</th>
                                            <td style="padding: 3px;">: <?= $ticketData['attendee_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td style="padding: 3px;">: <?= $ticketData['attendee_email']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Mobile</th>
                                            <td style="padding: 3px;">: <?= $ticketData['attendee_mobile']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Registration Fee</th>
                                            <td style="padding: 3px;">: <?= $ticketData['registration_fee'] > 0 ? $ticketData['registration_fee'] : '<strong style="color: green;">FREE</strong>'; ?></td>
                                        </tr>
                                        <?php if ($ticketData['registration_fee'] > 0): ?>
                                            <tr>
                                                <th>Transaction No</th>
                                                <td style="padding: 3px;">: <?= $ticketData['payment_trnx_no']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Amount Paid</th>
                                                <td style="padding: 3px;">: BDT <?= $ticketData['payment_amount']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Payment Status</th>
                                                <td style="padding: 3px;">: <?= $ticketData['payment_amount'] == $ticketData['registration_fee'] ? '<strong style="color: green;">Paid</strong>' : '<strong style="color: red;">Pending</strong>' ?></td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th>Registration Time</th>
                                            <td style="padding: 3px;">: <?= date('Y-m-d h:i A', strtotime($ticketData['registration_time'])); ?></td>
                                        </tr>
                                    </table>

                                    <hr style="border: 1px dashed #000; margin-top: 20px;">
                                    <p><strong>Host:</strong> <?= $ticketData['host_name']; ?></p>
                                    <p><strong>Email:</strong> <?= $ticketData['host_email']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>