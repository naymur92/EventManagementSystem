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
<?php $scriptsBlock = ob_get_clean();
?>

<div class="container-fluid">

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Events List</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <?php if (authUser()->type == 2): ?>
                        <a class="btn btn-primary waves-effect waves-light br-5" href="<?= route("/admin/events/create") ?>">
                            <i class="fas fa-plus-circle me-1"></i> Add New Event</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="dataTable" width="100%" cellspacing="0">

                            <colgroup>
                                <col style="width: 5%;">
                                <col style="width: 25%;">
                                <col style="width: 20%;">
                                <col style="width: 15%;">
                                <col style="width: 10%;">
                                <col style="width: 10%;">
                                <col style="width: 5%;">
                                <col style="width: 10%;">
                            </colgroup>

                            <thead class="bg-primary text-white text-center">
                                <tr>
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Event Name</th>
                                    <th class="align-middle">Location</th>
                                    <th class="align-middle">Host</th>
                                    <th class="align-middle">Current Capacity</th>
                                    <th class="align-middle">Start Time</th>
                                    <th class="align-middle">Status</th>
                                    <th class="no-sort align-middle">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($events as $key => $event): ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $key + 1 ?></td>
                                        <td class="align-middle"><?= $event['name'] ?></td>
                                        <td class="align-middle"><?= $event['location'] ?></td>
                                        <td class="align-middle"><?= $hostUsers[$event['user_id']] ?></td>
                                        <td class="text-center align-middle"><?= $event['max_capacity'] > 0 ? $event['current_capacity'] : "Unlimited" ?></td>
                                        <td class="text-center align-middle"><?= $event['start_time'] ?></td>
                                        <td class="text-center align-middle">
                                            <?php if ($event['status'] ==  0): ?>
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            <?php elseif ($event['status'] == 1): ?>
                                                <span class="badge badge-pill badge-success">Published</span>
                                            <?php else: ?>
                                                <span class="badge badge-pill badge-danger">Blocked</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle">
                                            <div class="text-center d-flex justify-content-center align-items-center">

                                                <a href="<?= route("/admin/events/{$event['event_id']}/show") ?>" data-toggle="tooltip" data-placement="top" title="View Details" class="table-data-modify-icon mx-1 my-1">
                                                    <span class="badge badge-primary"><i class="fa-solid fa-eye"></i></span>
                                                </a>

                                                <!-- set inactive -->
                                                <?php if ($event['status'] == 1 && authUser()->type == 1): ?>
                                                    <!-- only super user can unpublish the event -->
                                                    <form action="<?= route("/admin/events/{$event['event_id']}/change-status") ?>" method="POST"
                                                        onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                                                        <?= csrfField() ?>
                                                        <input type="hidden" name="_method" value="PUT">

                                                        <input type="text" value="0" name="status" hidden>

                                                        <input type="submit" class="hidden-submit-btn" hidden>

                                                        <a type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Unpublish" class="table-data-modify-icon mx-1 my-1"
                                                            onclick="$(this).closest('form').find('.hidden-submit-btn').click()">
                                                            <span class="badge badge-danger"><i class="fa-solid fa-xmark"></i></span>
                                                        </a>

                                                    </form>
                                                <?php endif; ?>

                                                <!-- set active -->
                                                <?php if ($event['status'] == 0 || ($event['status'] == 2 && authUser()->type == 1)): ?>
                                                    <form action="<?= route("/admin/events/{$event['event_id']}/change-status") ?>" method="POST"
                                                        onsubmit="swalConfirmationOnSubmit(event, 'Are you sure??');">
                                                        <?= csrfField() ?>
                                                        <input type="hidden" name="_method" value="PUT">

                                                        <input type="text" value="1" name="status" hidden>

                                                        <input type="submit" class="hidden-submit-btn" hidden>

                                                        <a type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Publish" class="table-data-modify-icon mx-1 my-1" onclick="$(this).closest('form').find('.hidden-submit-btn').click()">
                                                            <span class="badge badge-success"><i class="fa-solid fa-check"></i></span>
                                                        </a>
                                                    </form>
                                                <?php endif; ?>

                                                <!-- block event -->
                                                <?php if ($event['status'] != 2 && authUser()->type == 1): ?>
                                                    <form action="<?= route("/admin/events/{$event['event_id']}/change-status") ?>" method="POST"
                                                        onsubmit="swalConfirmationOnSubmit(event, 'Are you sure??');">
                                                        <?= csrfField() ?>
                                                        <input type="hidden" name="_method" value="PUT">

                                                        <input type="text" value="2" name="status" hidden>

                                                        <input type="submit" class="hidden-submit-btn" hidden>

                                                        <a type="button" data-toggle="tooltip" data-placement="top"
                                                            title="Block" class="table-data-modify-icon mx-1 my-1" onclick="$(this).closest('form').find('.hidden-submit-btn').click()">
                                                            <span class="badge badge-danger"><i class="fa-solid fa-ban"></i></span>
                                                        </a>
                                                    </form>
                                                <?php endif; ?>

                                                <a href="<?= route("/admin/events/{$event['event_id']}/attendee-list") ?>" data-toggle="tooltip" data-placement="top" title="Attendee List" class="table-data-modify-icon mx-1 my-1">
                                                    <span class="badge badge-info"><i class="fa-solid fa-list"></i></span>
                                                </a>

                                                <?php if (authUser()->type == 2): ?>

                                                    <a href="<?= route("/admin/events/{$event['event_id']}/edit") ?>" data-toggle="tooltip" data-placement="top" title="Edit Event" class="table-data-modify-icon mx-1 my-1">
                                                        <span class="badge badge-warning"><i class="fa-solid fa-pen-to-square"></i></span>
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

</div>