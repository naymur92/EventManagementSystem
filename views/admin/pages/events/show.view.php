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
                    <h5 class="m-0 text-primary">Event Details</h5>

                    <a href="<?= route("/admin/events") ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    <!-- profile info -->
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12">
                            <table class="show-table table border table-bordered">
                                <tr>
                                    <th style="width: 20%;">Banner</th>
                                    <td>
                                        <?php
                                        $banner = $event->getBanner();
                                        if ($banner): ?>
                                            <img class="img-thumbnail" src="<?= getBaseUrl() . "/uploads/{$banner['filepath']}/{$banner['filename']}" ?>"
                                                style="width: 20vw;">
                                        <?php else: ?>
                                            No Image
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Event Name</th>
                                    <td><?= $event->name ?></td>
                                </tr>

                                <tr>
                                    <th>Location</th>
                                    <td><?= $event->location ?></td>
                                </tr>


                                <tr>
                                    <th>Google Map Location</th>
                                    <td><?= htmlspecialchars_decode($event->google_map_location) ?></td>
                                </tr>

                                <tr>
                                    <th>Description</th>
                                    <td><?= htmlspecialchars_decode($event->description) ?></td>
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


                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-pill <?= ($event->start_time != '' && $event->start_time < date('Y-m-d H:i:s')) ||  $event->status == 0 ? 'badge-danger' : 'badge-success' ?>">
                                            <?= $event->start_time != '' && $event->start_time < date('Y-m-d H:i:s') ? 'Ended' : ($event->status == 0 ? 'Inactive' : 'Published') ?>
                                        </span>
                                    </td>
                                </tr>


                            </table>
                        </div>
                    </div>


                    <!-- host details -->
                    <div class="row align-items-center justify-content-between mt-5">
                        <div class="col-12">
                            <h5 class="text-primary">Host Details</h5>

                            <table class="show-table table border table-bordered">
                                <tr>
                                    <th style="width: 20%;">Host Name</th>
                                    <td><?= $hostDetails['info']['name'] ?? '' ?></td>
                                </tr>

                                <tr>
                                    <th>Host Email</th>
                                    <td><?= $hostDetails['info']['email'] ?? '' ?></td>
                                </tr>

                                <tr>
                                    <th>Host Mobile</th>
                                    <td><?= $hostDetails['info']['mobile'] ?? '' ?></td>
                                </tr>

                                <tr>
                                    <th>Profile Image</th>
                                    <td>
                                        <?php
                                        if (isset($hostDetails['profile_photo']['filename'])): ?>
                                            <img class="img-thumbnail" src="<?= getBaseUrl() . "/uploads/{$hostDetails['profile_photo']['filepath']}/{$hostDetails['profile_photo']['filename']}" ?>"
                                                style="width: 20vw;">
                                        <?php else: ?>
                                            <img class="img-thumbnail" src="<?= getBaseUrl() ?>/uploads/users/user.png" style="width: 20vw;">
                                        <?php endif; ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Host Address</th>
                                    <td><?= $hostDetails['extra_info']['location'] ?? '' ?></td>
                                </tr>

                                <tr>
                                    <th>About Host</th>
                                    <td><?= htmlspecialchars_decode($hostDetails['extra_info']['description'] ?? '') ?></td>
                                </tr>
                            </table>
                        </div>

                    </div>


                </div>
                <div class="card-footer d-flex justify-content-between">
                    <!-- set inactive -->
                    <?php if ($event->status == 1): ?>
                        <form action="<?= route("/admin/events/{$event->event_id}/change-status") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                            <?= csrfField() ?>
                            <input type="hidden" name="_method" value="PUT">

                            <input type="text" value="0" name="status" hidden>

                            <button type="submit" class="btn btn-outline-danger"><i class="fas fa-times"></i> Unpublish Event</button>
                        </form>
                    <?php endif; ?>

                    <!-- set active -->
                    <?php if ($event->status == 0): ?>
                        <form action="<?= route("/admin/events/{$event->event_id}/change-status") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                            <?= csrfField() ?>
                            <input type="hidden" name="_method" value="PUT">

                            <input type="text" value="1" name="status" hidden>

                            <button type="submit" class="btn btn-outline-success"><i class="fas fa-check"></i> Publish Event</button>
                        </form>
                    <?php endif; ?>

                    <!-- <form action="<?= route("/admin/events/{$event->event_id}/delete") ?>"
                        onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to delete?');"
                        method="POST">
                        <?= csrfField() ?>
                        <input type="hidden" name="_method" value="DELETE">

                        <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                    </form> -->

                    <?php if ($event->user_id == authUser()->user_id): ?>
                        <a href="<?= route("/admin/events/{$event->event_id}/edit") ?>" class="btn btn-outline-warning br-5 waves-effect waves-light">
                            <i class="fa-solid fa-pen-to-square"></i> Edit Event
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>