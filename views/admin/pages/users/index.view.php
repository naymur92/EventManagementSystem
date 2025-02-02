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
            <h5 class="m-0 text-primary">Auth Users List</h5>

            <div class="ms-auto">
                <div class="btn-list">
                    <a class="btn btn-primary waves-effect waves-light br-5" href="<?= route("/admin/users/create") ?>">
                        <i class="fas fa-plus-circle me-1"></i> Add New User</a>

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap align-middle" id="dataTable" width="100%" cellspacing="0">

                            <colgroup>
                                <col style="width: 10%;">
                                <col style="width: 20%;">
                                <col style="width: 25%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                                <col style="width: 15%;">
                            </colgroup>

                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>User Type</th>
                                    <th>Status</th>
                                    <th class="no-sort">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($users as $key => $user): ?>
                                    <tr>
                                        <td class="text-center"><?= $key + 1 ?></td>
                                        <td><?= $user['name'] ?></td>
                                        <td><?= $user['email'] ?></td>

                                        <td><?= $user['mobile'] ?></td>
                                        <td class="text-center">
                                            <?php if ($user['type'] == 1): ?>
                                                <span class="badge badge-pill badge-primary">Super User</span>
                                            <?php elseif ($user['type'] == 2): ?>
                                                <span class="badge badge-pill badge-info">Host User</span>
                                            <?php elseif ($user['type'] == 3): ?>
                                                <span class="badge badge-pill badge-secondary">General User</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-pill <?= $user['status'] == 0 ? 'badge-danger' : 'badge-success' ?>">
                                                <?= $user['status'] == 0 ? 'Inactive' : 'Active' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-center d-flex justify-content-center align-items-center">

                                                <a href="<?= route("/admin/users/{$user['user_id']}/show") ?>" data-toggle="tooltip" data-placement="top" title="View Details" class="table-data-modify-icon mx-1 my-1">
                                                    <span class="badge badge-primary"><i class="fa-solid fa-eye"></i></span>
                                                </a>

                                                <?php if ($user['user_id'] != 1 && $user['user_id'] != authUser()->user_id): ?>
                                                    <!-- set inactive -->
                                                    <?php if ($user['status'] == 1): ?>
                                                        <form action="<?= route("/admin/users/{$user['user_id']}/change-status") ?>" method="POST"
                                                            onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                                                            <?= csrfField() ?>
                                                            <input type="hidden" name="_method" value="PUT">

                                                            <input type="text" value="0" name="status" hidden>

                                                            <input type="submit" class="hidden-submit-btn" hidden>

                                                            <a type="button" data-toggle="tooltip" data-placement="top"
                                                                title="Mark Inactive" class="table-data-modify-icon mx-1 my-1"
                                                                onclick="$(this).closest('form').find('.hidden-submit-btn').click()">
                                                                <span class="badge badge-danger"><i class="fa-solid fa-xmark"></i></span>
                                                            </a>

                                                        </form>
                                                    <?php endif; ?>

                                                    <!-- set active -->
                                                    <?php if ($user['status'] == 0): ?>
                                                        <form action="<?= route("/admin/users/{$user['user_id']}/change-status") ?>" method="POST"
                                                            onsubmit="swalConfirmationOnSubmit(event, 'Are you sure??');">
                                                            <?= csrfField() ?>
                                                            <input type="hidden" name="_method" value="PUT">

                                                            <input type="text" value="1" name="status" hidden>

                                                            <input type="submit" class="hidden-submit-btn" hidden>

                                                            <a type="button" data-toggle="tooltip" data-placement="top"
                                                                title="Mark Active" class="table-data-modify-icon mx-1 my-1" onclick="$(this).closest('form').find('.hidden-submit-btn').click()">
                                                                <span class="badge badge-success"><i class="fa-solid fa-check"></i></span>
                                                            </a>
                                                        </form>
                                                    <?php endif; ?>

                                                    <a href="<?= route("/admin/users/{$user['user_id']}/edit") ?>" data-toggle="tooltip" data-placement="top" title="Edit User" class="table-data-modify-icon mx-1 my-1">
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