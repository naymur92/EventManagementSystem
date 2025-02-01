<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<link href="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="<?= getBaseUrl() ?>/admin_assets/vendor/tempusdominus/tempusdominus-bootstrap-4.min.css" crossorigin="anonymous" />
<style>
    .bootstrap-datetimepicker-widget.dropdown-menu {
        width: auto;
    }
</style>

<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<!-- Page level plugins -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= getBaseUrl() ?>/admin_assets/js/demo/datatables-demo.js"></script>


<!-- DateTimePicker -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/tempusdominus/tempusdominus-bootstrap-4.min.js"></script>
<script>
    $(function() {
        let from_date_val = document.getElementById('_from_date').value;
        let to_date_val = document.getElementById('_to_date').value;

        $('#_from_date').datetimepicker({
            format: 'YYYY-MM-DD',
            minDate: moment(),
            value: from_date_val
        });
        $('#_to_date').datetimepicker({
            format: 'YYYY-MM-DD',
            showClear: true,
            autoClose: true,
            minDate: $("#_from_date").val() == '' ? moment() : $("#_from_date").val(),
            value: to_date_val,
        });
    });
</script>


<script>
    $(function() {
        $(".report_download_btn").on('click', function(e) {
            e.preventDefault();

            let url = $(this).attr('data-download-url');
            let formData = $("#attendee_report_form").serialize();

            location.href = url + "?" + formData;
        })
    });
</script>
<?php $scriptsBlock = ob_get_clean();
?>

<div class="container-fluid">

    <div class="card shadow mb-5">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Attendee Report Query Form</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <a href="<?= route('/admin') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>

                </div>
            </div>
        </div>

        <form id="attendee_report_form" action="<?= route('/admin/reports/attendee-report') ?>" method="POST">
            <?= csrfField() ?>

            <div class="card-body">
                <div class="row">

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_name">Event Name</label>
                        <input type="text" name="name" id="_name" value="<?= $searchParams['name'] ?? "" ?>" class="form-control" placeholder="Event Name">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_from_date">From Date</label>
                        <div class="form-group">
                            <div class="input-group date" id="_from_date" data-target-input="nearest">
                                <input type="text" name="from_date" value="<?= $searchParams['from_date'] ?? "" ?>" class="form-control datetimepicker-input" data-target="#_from_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#_from_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_to_date">To Date</label>
                        <div class="form-group">
                            <div class="input-group date" id="_to_date" data-target-input="nearest">
                                <input type="text" name="to_date" value="<?= $searchParams['to_date'] ?? "" ?>" class="form-control datetimepicker-input" data-target="#_to_date" placeholder="YYYY-MM-DD" />
                                <div class="input-group-append" data-target="#_to_date" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="">Registratin Fee</label>
                        <div class="input-group">
                            <input type="number" min="0" step="1" name="reg_fee_from" value="<?= $searchParams['reg_fee_from'] ?? "" ?>" class="form-control" placeholder="0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">to</span>
                            </div>
                            <input type="number" min="0" step="1" name="reg_fee_to" value="<?= $searchParams['reg_fee_to'] ?? "" ?>" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_a_name">Attendee Name</label>
                        <input type="text" name="attendee_name" id="_a_name" value="<?= $searchParams['attendee_name'] ?? "" ?>" class="form-control" placeholder="Attendee Name">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_a_email">Attendee Email</label>
                        <input type="email" name="attendee_email" id="_a_email" value="<?= $searchParams['attendee_email'] ?? "" ?>" class="form-control" placeholder="Attendee Email">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_a_mobile">Attendee Mobile</label>
                        <input type="text" name="attendee_mobile" id="_a_mobile" value="<?= $searchParams['attendee_mobile'] ?? "" ?>" class="form-control" placeholder="Attendee Mobile">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_status">Event Status</label>

                        <select name="status" id="_status" class="form-control select2">
                            <option value="" <?= ($searchParams['status'] ?? "") == '' ? 'selected' : "" ?>>All</option>
                            <option value="1" <?= ($searchParams['status'] ?? "") == 1 ? 'selected' : "" ?>>Active</option>
                            <option value="0" <?= ($searchParams['status'] ?? "") == 0 ? 'selected' : "" ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_t_status">Ticket Status</label>

                        <select name="t_status" id="_t_status" class="form-control select2">
                            <option value="" <?= ($searchParams['t_status'] ?? "") == '' ? 'selected' : "" ?>>All</option>
                            <option value="1" <?= ($searchParams['t_status'] ?? "") == 1 ? 'selected' : "" ?>>Confirmed</option>
                            <option value="0" <?= ($searchParams['t_status'] ?? "") == 0 ? 'selected' : "" ?>>Cancelled</option>
                        </select>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="<?= route('/admin/reports/attendee-report') ?>" class="btn btn-danger mx-2">Reset</a>

                    <input type="submit" value="Generate Report" class="btn btn-primary">
                </div>
            </div>
        </form>

    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Report Result</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <a type="button" data-download-url="<?= route("/admin/reports/attendee-report/download") ?>" class="report_download_btn btn waves-effect waves-light br-5 btn-info">Download Report Data
                    </a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table data-display-length='100' class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">

                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Host Name</th>
                                    <th class="align-middle">Event Name</th>
                                    <th class="align-middle">Start Time</th>
                                    <th class="align-middle">End Time</th>
                                    <th class="align-middle">Booking No</th>
                                    <th class="align-middle">Attendee Name</th>
                                    <th class="align-middle">Attendee Email</th>
                                    <th class="align-middle">Attendee Mobile</th>
                                    <th class="align-middle">Registration Fee</th>
                                    <th class="align-middle">Payment Amount</th>
                                    <th class="align-middle">Payment Trnx No</th>
                                    <th class="align-middle">Payment Account No</th>
                                    <th class="align-middle">Registration Time</th>
                                    <th class="align-middle">Status</th>
                                    <th class="align-middle">Cancel Reason</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($reportResult as $key => $item): ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                                        <td class="align-middle"><?= $item['host_name'] ?></td>
                                        <td class="align-middle"><?= $item['event_name'] ?></td>
                                        <td class="text-center align-middle"><?= date('Y-m-d h:i', strtotime($item['start_time'])) ?></td>
                                        <td class="text-center align-middle"><?= $item['end_time'] ? date('Y-m-d h:i', strtotime($item['end_time'])) : '' ?></td>
                                        <td class="align-middle"><?= $item['booking_no'] ?></td>
                                        <td class="align-middle"><?= $item['attendee_name'] ?></td>
                                        <td class="align-middle"><?= $item['attendee_email'] ?></td>
                                        <td class="align-middle"><?= $item['attendee_mobile'] ?></td>
                                        <td class="align-middle"><?= $item['registration_fee'] ?></td>
                                        <td class="align-middle"><?= $item['payment_amount'] ?></td>
                                        <td class="align-middle"><?= $item['payment_trnx_no'] ?></td>
                                        <td class="align-middle"><?= $item['payment_account_no'] ?></td>
                                        <td class="text-center align-middle"><?= date('Y-m-d h:i A', strtotime($item['registration_time'])) ?></td>
                                        <td class="text-center align-middle"><?= $item['status'] ?></td>
                                        <td class="align-middle"><?= $item['cancel_reason'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>