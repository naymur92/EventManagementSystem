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
        <div class="col-12 col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-primary">Auth User Details</h5>

                    <a href="<?= route("/admin/users") ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <div class="card-body">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-12 col-xl-8">
                            <table class="show-table table border table-bordered">
                                <tr>
                                    <th style="width: 20%;">Name</th>
                                    <td><?= $user->name ?></td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td><?= $user->email ?></td>
                                </tr>

                                <tr>
                                    <th>Mobile</th>
                                    <td><?= $user->mobile ?></td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-pill <?= $user->status == 0 ? 'badge-danger' : 'badge-success' ?>">
                                            <?= $user->status == 0 ? 'Inactive' : 'Active' ?>
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Joined Date</th>
                                    <td><?= date('d M, Y - H:i A', strtotime($user->created_at)) ?></td>
                                </tr>

                            </table>
                        </div>

                        <div class="col-12 col-md-4 text-center">
                            <?php
                            $profilePicture = $user->getProfilePicture();
                            if ($profilePicture): ?>
                                <img class="img-thumbnail rounded-circle" src="<?= getBaseUrl() . "/uploads/{$profilePicture['filepath']}/{$profilePicture['filename']}" ?>"
                                    style="width: 20vw;">
                            <?php else: ?>
                                <img class="img-thumbnail rounded-circle" src="<?= getBaseUrl() ?>/uploads/users/user.png" style="width: 20vw;">
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <?php if ($user->user_id != 1 && $user->user_id != authUser()->user_id): ?>
                        <!-- set inactive -->
                        <?php if ($user->status == 1): ?>
                            <form action="<?= route("/admin/users/{$user->user_id}/change-status") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                                <?= csrfField() ?>
                                <input type="hidden" name="_method" value="PUT">

                                <input type="text" value="0" name="status" hidden>

                                <button type="submit" class="btn btn-outline-danger"><i class="fas fa-times"></i> Mark Inactive</button>
                            </form>
                        <?php endif; ?>

                        <!-- set active -->
                        <?php if ($user->status == 0): ?>
                            <form action="<?= route("/admin/users/{$user->user_id}/change-status") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                                <?= csrfField() ?>
                                <input type="hidden" name="_method" value="PUT">

                                <input type="text" value="1" name="status" hidden>

                                <button type="submit" class="btn btn-outline-success"><i class="fas fa-check"></i> Mark Active</button>
                            </form>
                        <?php endif; ?>

                        <!-- <form action="<?= route("/admin/users/{$user->user_id}/delete") ?>"
                            onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to delete?');"
                            method="POST">
                            <?= csrfField() ?>
                            <input type="hidden" name="_method" value="DELETE">

                            <button class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form> -->

                        <a href="<?= route("/admin/users/{$user->user_id}/edit") ?>" class="btn btn-outline-warning br-5 waves-effect waves-light">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</div>