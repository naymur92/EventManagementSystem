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

        // set startDate of end_date based on start_date selection
        // $('#_from_date').on('change.datetimepicker', function(e) {
        //     var selectedDate = e.date;
        //     $('#_to_date').datetimepicker('minDate', selectedDate);
        //     // $('#_to_date').datetimepicker('clear');
        // });
    });
</script>


<script>
    $(function() {
        $(".event_report_download_btn").on('click', function(e) {
            e.preventDefault();

            let url = $(this).attr('data-download-url');
            let formData = $("#event_report_form").serialize();

            location.href = url + "?" + formData;
        })
    });
</script>
<?php $scriptsBlock = ob_get_clean();
?>

<div class="container-fluid">

    <div class="card shadow mb-5">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Event Report Query Form</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <a href="<?= route('/admin') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>

                </div>
            </div>
        </div>

        <form id="event_report_form" action="<?= route('/admin/reports/event-report') ?>" method="POST">
            <?= csrfField() ?>

            <div class="card-body">
                <div class="row">

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_name">Event Name</label>
                        <input type="text" name="name" id="_name" value="<?= $searchParams['name'] ?? "" ?>" class="form-control" placeholder="Event Name">
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_h_name">Host Name</label>
                        <input type="text" name="host_name" id="_h_name" value="<?= $searchParams['host_name'] ?? "" ?>" class="form-control" placeholder="Host Name">
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
                        <label for="">Seat Capacity</label>
                        <div class="input-group">
                            <input type="number" min="0" step="1" name="seat_cap_from" value="<?= $searchParams['seat_cap_from'] ?? "" ?>" class="form-control" placeholder="0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">to</span>
                            </div>
                            <input type="number" min="0" step="1" name="seat_cap_to" value="<?= $searchParams['seat_cap_to'] ?? "" ?>" class="form-control" placeholder="0">
                        </div>
                    </div>

                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="">Available Seat</label>
                        <div class="input-group">
                            <input type="number" min="0" step="1" name="av_seat_from" value="<?= $searchParams['av_seat_from'] ?? "" ?>" class="form-control" placeholder="0">
                            <div class="input-group-prepend">
                                <span class="input-group-text">to</span>
                            </div>
                            <input type="number" min="0" step="1" name="av_seat_to" value="<?= $searchParams['av_seat_to'] ?? "" ?>" class="form-control" placeholder="0">
                        </div>
                    </div>


                    <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                        <label for="_status">Status</label>

                        <select name="status" id="_status" class="form-control select2">
                            <option value="" <?= ($searchParams['status'] ?? "") == '' ? 'selected' : "" ?>>All</option>
                            <option value="1" <?= ($searchParams['status'] ?? "") == 1 ? 'selected' : "" ?>>Published</option>
                            <option value="0" <?= ($searchParams['status'] ?? "") == 0 ? 'selected' : "" ?>>Pending</option>
                            <option value="2" <?= ($searchParams['status'] ?? "") == 2 ? 'selected' : "" ?>>Blocked</option>
                        </select>
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="<?= route('/admin/reports/event-report') ?>" class="btn btn-danger mx-2">Reset</a>

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
                    <a type="button" data-download-url="<?= route("/admin/reports/event-report/download-event-list") ?>" class="event_report_download_btn btn waves-effect waves-light br-5 btn-info">Download Event Data
                    </a>
                    <a type="button" data-download-url="<?= route("/admin/reports/event-report/download-attendee-list") ?>" class="event_report_download_btn btn waves-effect waves-light br-5 btn-info">Download Attendee Data
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
                                    <th class="align-middle">Event Name</th>
                                    <th class="align-middle">Host Name</th>
                                    <th class="align-middle">Location</th>
                                    <th class="align-middle">Start Time</th>
                                    <th class="align-middle">End Time</th>
                                    <th class="align-middle">Registration Fee</th>
                                    <th class="align-middle">Total Seat</th>
                                    <th class="align-middle">Available Seat</th>
                                    <th class="align-middle">Total Registration</th>
                                    <th class="align-middle">Total Payment Received</th>
                                    <th class="align-middle">Event Status</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($reportResult as $key => $item): ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                                        <td class="align-middle"><?= $item['event_name'] ?></td>
                                        <td class="align-middle"><?= $item['host_name'] ?></td>
                                        <td class="align-middle"><?= $item['location'] ?></td>
                                        <td class="text-center align-middle"><?= date('Y-m-d h:i', strtotime($item['start_time'])) ?></td>
                                        <td class="text-center align-middle"><?= $item['end_time'] ? date('Y-m-d h:i', strtotime($item['end_time'])) : '' ?></td>
                                        <td class="align-middle"><?= $item['registration_fee'] ?></td>
                                        <td class="align-middle"><?= $item['total_seat'] ?></td>
                                        <td class="align-middle"><?= $item['available_seat'] ?></td>
                                        <td class="align-middle"><?= $item['total_registration'] ?></td>
                                        <td class="align-middle"><?= $item['total_payment_collection'] ?></td>
                                        <td class="align-middle"><?= $item['status'] ?></td>
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