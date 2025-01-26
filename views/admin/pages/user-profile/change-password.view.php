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
                    <h5 class="m-0 text-primary">User Password Change</h5>
                    <div class="ms-auto">
                        <div class="btn-list">
                            <a href="<?= route('/admin') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                                <i class="fas fa-angle-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <form action="<?= route("/admin/change-password") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure?');">
                    <?= csrfField() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_pass" class="col-form-label font-14">Enter new password <span class="text-danger"><i
                                            class="fas fa-xs fa-asterisk"></i></span></label>

                                <input type="password" name="password" class="form-control <?= hasError('password') ? 'is-invalid' : '' ?>" id="_pass">

                                <?php foreach (errors('password') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-lg-6 mb-3">
                                <label for="_pass_conf" class="col-form-label font-14">Enter password again <span class="text-danger"><i
                                            class="fas fa-xs fa-asterisk"></i></span></label>

                                <input type="password" name="password_confirmation" class="form-control <?= hasError('password_confirmation') ? 'is-invalid' : '' ?>" id="_pass_conf">

                                <?php foreach (errors('password_confirmation') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <input class="btn btn-primary" type="submit" value="Update">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>