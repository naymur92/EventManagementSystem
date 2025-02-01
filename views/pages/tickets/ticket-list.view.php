<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>
<link href="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<!-- Page level plugins -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= getBaseUrl() ?>/admin_assets/js/demo/datatables-demo.js"></script>
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
<div>
    <div class="container">
        <div class="space12"></div>

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

                                                    <?php $uniquiId = encodeData([$item['booking_no'], $item['attendee_id']]); ?>
                                                    <a href="<?= route("/event-registration/$uniquiId/view-ticket") ?>" data-toggle="tooltip" data-placement="top" title="View Ticket" class="table-data-modify-icon mr-2">
                                                        <span class="text-primary"><i class="fa-solid fa-ticket"></i></span>
                                                    </a>

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

        <div class="space12"></div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->