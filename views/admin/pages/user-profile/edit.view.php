<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<!-- summernote -->
<link rel="stylesheet" href="<?= getBaseUrl() ?>/admin_assets/vendor/summernote/summernote-bs4.css">
<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<!-- summernote -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/summernote/summernote-bs4.min.js"></script>
<script>
    $(function() {
        // Summernote
        $('.text-editor').summernote()
    })
</script>

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
                    <h5 class="m-0 text-primary">User Profile Edit</h5>

                    <a href="<?= route('/user-profile') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <form action="<?= route("/update-profile") ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to update profile?');">
                    <?= csrfField() ?>
                    <input type="hidden" name="_method" value="PUT">

                    <div class="card-body">

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Profile Info</legend>

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
                                    <label for="_mobile">Mobile</label>
                                    <input type="text" name="mobile" id="_mobile" value="<?= old('mobile', $user->mobile) ?>" class="form-control <?= hasError('mobile') ? 'is-invalid' : '' ?>" placeholder="01xxxxxxxxx">

                                    <?php foreach (errors('mobile') as $error) : ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?= $error ?>
                                        </span>
                                    <?php endforeach; ?>

                                </div>

                            </div>
                        </fieldset>

                        <?php if ($user->type == 2): ?>
                            <fieldset class="fieldset">
                                <legend class="fieldset-legend">Extra Information for Host</legend>

                                <div class="row">

                                    <div class="form-group col-12 col-lg-12 mb-3">
                                        <label for="_desc">Description</label>
                                        <textarea name="description" id="_desc" rows="5" class="text-editor form-control <?= hasError('description') ? 'is-invalid' : '' ?>"
                                            style="width: 100%; min-height: 200px;
                                    font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= old('description', $hostDetails->description ?? '') ?></textarea>

                                        <?php foreach (errors('description') as $error) : ?>
                                            <span class="invalid-feedback" role="alert">
                                                <?= $error ?>
                                            </span>
                                        <?php endforeach; ?>
                                    </div>

                                    <div class="form-group col-12 col-lg-12 mb-3">
                                        <label for="_loc">Address <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                        <input type="text" id="_loc" name="location" value="<?= old('location', $hostDetails->location ?? '') ?>" class="form-control <?= hasError('location') ? 'is-invalid' : '' ?>" placeholder="Address">

                                        <?php foreach (errors('location') as $error) : ?>
                                            <span class="invalid-feedback" role="alert">
                                                <?= $error ?>
                                            </span>
                                        <?php endforeach; ?>

                                    </div>

                                </div>
                            </fieldset>
                        <?php endif; ?>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <input type="submit" value="Update" class="btn btn-success">
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>