<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<script>
    // mobile number validation
    $("#_mobile").on("input", function() {
        // remove all errors first
        removeFormError('.form-group > input')

        let value = $(this).val().trim();

        if (!validateMobileNumber(value)) {
            insertFormError($("#_mobile"), "Invalid mobile number");
        }
    });
</script>
<?php $scriptsBlock = ob_get_clean();
?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-primary">Auth User Create</h5>

                    <a href="<?= route('/admin/users') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <form action="<?= route('/admin/users') ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to create user?');">
                    <?= csrfField() ?>

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_name">Name <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                <input type="text" name="name" id="_name" value="<?= old('name') ?>" class="form-control <?= hasError('name') ? 'is-invalid' : '' ?>" placeholder="Full Name">

                                <?php foreach (errors('name') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_email">Email <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                <input type="email" name="email" id="_email" value="<?= old('email') ?>" class="form-control <?= hasError('email') ? 'is-invalid' : '' ?>" placeholder="someone@example.com">

                                <?php foreach (errors('email') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>

                            </div>

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_mobile">Mobile</label>
                                <input type="text" name="mobile" id="_mobile" value="<?= old('mobile') ?>" class="form-control <?= hasError('mobile') ? 'is-invalid' : '' ?>" placeholder="01xxxxxxxxx">

                                <?php foreach (errors('mobile') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>

                            </div>

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_password">Password <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                <input type="password" name="password" id="_password" class="form-control <?= hasError('password') ? 'is-invalid' : '' ?>">

                                <?php foreach (errors('password') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_type">User Type <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>

                                <select name="type" id="_type" class="form-control select2 <?= hasError('type') ? 'is-invalid' : '' ?>">
                                    <option value="1" <?= old('type') == 1 ? 'selected' : "" ?>>Super User</option>
                                    <option value="2" <?= old('type') == 2 ? 'selected' : "" ?>>Host User</option>
                                    <option value="3" <?= old('type') == 3 ? 'selected' : "" ?>>General User</option>
                                </select>

                                <?php foreach (errors('type') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_status">Status <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>

                                <select name="status" id="_status" class="form-control select2 <?= hasError('status') ? 'is-invalid' : '' ?>">
                                    <option value="0" <?= old('status') == 0 ? 'selected' : "" ?>>Inactive</option>
                                    <option value="1" <?= old('status') == 1 ? 'selected' : "" ?>>Active</option>
                                </select>

                                <?php foreach (errors('status') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <input type="submit" value="Submit" class="btn btn-success">
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>