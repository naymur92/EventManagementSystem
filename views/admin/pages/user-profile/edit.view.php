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
                    <h5 class="m-0 text-primary">User Profile Edit</h5>

                    <a href="<?= route('/admin/user-profile') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <form action="<?= route("/update-profile") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to update profile?');">
                    <?= csrfField() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="_name">Name <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                <input type="text" name="name" id="_name" value="<?= old('name', $user->name) ?>" class="form-control <?= hasError('name') ? 'is-invalid' : '' ?>" placeholder="Full Name">

                                <?php foreach (errors('name') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="_email">Email <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                <input type="email" id="_email" value="<?= old('email', $user->email) ?>" class="form-control <?= hasError('email') ? 'is-invalid' : '' ?>" placeholder="someone@example.com" readonly disabled>

                                <?php foreach (errors('email') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>

                            </div>

                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="mobile">Mobile</label>
                                <input type="text" name="mobile" id="mobile" value="<?= old('mobile', $user->mobile) ?>" class="form-control <?= hasError('mobile') ? 'is-invalid' : '' ?>" placeholder="01xxxxxxxxx">

                                <?php foreach (errors('mobile') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>

                            </div>

                        </div>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <input type="submit" value="Update" class="btn btn-success">
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>