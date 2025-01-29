<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<!-- summernote -->
<link rel="stylesheet" href="<?= getBaseUrl() ?>/admin_assets/vendor/summernote/summernote-bs4.css">

<!-- DateTimePicker CSS -->
<link rel="stylesheet" href="<?= getBaseUrl() ?>/admin_assets/vendor/tempusdominus/tempusdominus-bootstrap-4.min.css" crossorigin="anonymous" />
<style>
    .bootstrap-datetimepicker-widget.dropdown-menu {
        width: auto;
    }
</style>

<style>
    .file-remove-btn,
    .image-remove-btn {
        position: absolute;
        color: red;
        height: 20px;
        width: 20px;
        cursor: pointer;
        font-size: 20px;
        border-radius: 2px;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
        background-color: #ddd;
    }

    .image-remove-btn {
        right: 0;
        top: 0;
    }

    .file-remove-btn {
        right: -25px;
        top: 2px;
    }
</style>
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

<!-- DateTimePicker -->
<script src="<?= getBaseUrl() ?>/admin_assets/vendor/tempusdominus/tempusdominus-bootstrap-4.min.js"></script>
<script>
    $(function() {
        let start_time_val = document.getElementById('_start_time').value;
        let end_time_val = document.getElementById('_end_time').value;

        $('#_start_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            icons: {
                time: 'fa-regular fa-clock',
            },
            minDate: moment(),
            value: start_time_val
        });
        $('#_end_time').datetimepicker({
            format: 'YYYY-MM-DD HH:mm',
            icons: {
                time: 'fa-regular fa-clock'
            },
            showClear: true,
            autoClose: true,
            minDate: $("#_start_time").val() == '' ? moment() : $("#_start_time").val(),
            value: end_time_val,
        });

        // set startDate of end_date based on start_date selection
        $('#_start_time').on('change.datetimepicker', function(e) {
            var selectedDate = e.date;
            $('#_end_time').datetimepicker('minDate', selectedDate);
        });


    });
</script>


<script>
    const maxSize = 1024;
    const accepedTypes = [
        "image/png",
        "image/jpeg",
        "image/gif",
    ];

    const imageRequired = false;
    const imageSelector = $("#_attachment");
    const container = $("#image_container");
    const imageRemoveBtn = $('.remove-btn');

    $(document).ready(function() {
        var img = container.children('img');
        var old_src = img.attr('src');

        if (old_src == '') {
            container.hide();
        }
        imageRemoveBtn.hide();
        imageSelector.val("");

        // console.log(img.attr('src'));

        const acceped_types = [
            "image/png",
            "image/jpeg",
            "image/gif",
        ];
        imageSelector.on('change', function(event) {
            const file = event.target.files[0];
            imageSelector.removeClass('is-invalid');
            $(".errors").remove();

            // console.log(file);
            // check file type validation
            var file_type = file.type;
            if (!acceped_types.includes(file_type)) {
                imageSelector.addClass('is-invalid');
                $("<span class='errors invalid-feedback' role='alert'><strong>Unsupported filetype!</strong></span>")
                    .insertAfter(imageSelector);

                // remove img from dom
                imageSelector.val("");
            } else if (file.size > maxSize * 1024) {
                imageSelector.addClass('is-invalid');
                $("<span class='errors invalid-feedback' role='alert'><strong>Maximum filesize is 1 MB!</strong></span>")
                    .insertAfter(imageSelector);

                // remove img from dom
                imageSelector.val("");
            } else {
                let imgUrl = URL.createObjectURL(file);
                img.attr('src', imgUrl);

                container.show();
                imageRemoveBtn.show();
            }

        });

        // remove image
        imageRemoveBtn.on('click', function() {
            imageSelector.val("");
            img.attr('src', old_src);

            imageRemoveBtn.hide();

            if (old_src == '') {
                container.hide();
            }
        });

        // on submit form
        $("#event_edit_form").on('submit', function(e) {
            e.preventDefault();

            imageSelector.removeClass('is-invalid');
            $(".errors").remove();

            if (imageRequired && old_src == img.attr('src')) {
                imageSelector.addClass('is-invalid');
                $("<span class='errors invalid-feedback' role='alert'><strong>Select an image first!</strong></span>")
                    .insertAfter(imageSelector);
            } else if (swalConfirmationOnSubmit(event, 'Are you sure?')) {
                document.getElementById("event_edit_form").submit();
            }
        });
    });
</script>
<?php $scriptsBlock = ob_get_clean();
?>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-primary">Event Edit Form</h5>

                    <a href="<?= route('/admin/events') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                        <i class="fas fa-angle-left"></i> Back
                    </a>
                </div>

                <!--  onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to create user?');" -->
                <form action="<?= route("/admin/events/{$event->event_id}/update") ?>" method="POST" id="event_edit_form" enctype="multipart/form-data">
                    <?= csrfField() ?>

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="_name">Event Name <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label>
                                <input type="text" name="name" id="_name" value="<?= old('name', $event->name) ?>" class="form-control <?= hasError('name') ? 'is-invalid' : '' ?>" placeholder="Event Name">

                                <?php foreach (errors('name') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>


                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="_loc">Event Location</label>
                                <input type="text" name="location" id="_loc" value="<?= old('location', $event->location) ?>" class="form-control <?= hasError('location') ? 'is-invalid' : '' ?>" placeholder="Event location">

                                <?php foreach (errors('location') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>


                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="_google_map_loc">Google Map Location <small>(Medium iFrame HTML)</small></label>
                                <input type="text" name="google_map_location" id="_google_map_loc" value="<?= old('google_map_location', $event->google_map_location) ?>" class="form-control <?= hasError('google_map_location') ? 'is-invalid' : '' ?>" placeholder="<iframe src='https://www.google.com/maps/embed?\'></iframe>">

                                <?php foreach (errors('google_map_location') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>

                                <?php if ($event->google_map_location != '') {
                                    echo htmlspecialchars_decode($event->google_map_location);
                                } ?>
                            </div>


                            <div class="form-group col-12 col-lg-12 mb-3">
                                <label for="_desc">Description</label>
                                <textarea name="description" id="_desc" rows="5" class="text-editor form-control <?= hasError('description') ? 'is-invalid' : '' ?>"
                                    style="width: 100%; min-height: 200px;
                                    font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"><?= old('description', $event->description) ?></textarea>

                                <?php foreach (errors('description') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                                <label for="_start_time">Start Time</label>
                                <div class="form-group <?= hasError('start_time') ? 'is-invalid' : '' ?>">
                                    <div class="input-group date" id="_start_time" data-target-input="nearest">
                                        <input type="text" name="start_time" value="<?= old('start_time', $event->start_time) ?>" class="form-control datetimepicker-input" data-target="#_start_time" placeholder="YYYY-MM-DD HH:MM" />
                                        <div class="input-group-append" data-target="#_start_time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach (errors('start_time') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                            <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                                <label for="_end_time">End Time</label>
                                <div class="form-group <?= hasError('end_time') ? 'is-invalid' : '' ?>">
                                    <div class="input-group date" id="_end_time" data-target-input="nearest">
                                        <input type="text" name="end_time" value="<?= old('end_time', $event->end_time) ?>" class="form-control datetimepicker-input" data-target="#_end_time" placeholder="YYYY-MM-DD HH:MM" />
                                        <div class="input-group-append" data-target="#_end_time" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>

                                <?php foreach (errors('end_time') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>


                            <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                                <label for="_capacity" title="Keep empty for unlimited capacity!">Max Capacity</label>
                                <input type="number" name="max_capacity" id="_capacity" value="<?= old('max_capacity', $event->max_capacity) ?>" class="form-control <?= hasError('max_capacity') ? 'is-invalid' : '' ?>" min="0" step="1" placeholder="Keep empty for unlimited capacity">

                                <?php foreach (errors('max_capacity') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>


                            <div class="form-group col-12 col-md-6 col-lg-3 mb-3">
                                <label for="_fee" title="Keep empty for free entry!">Registration Fee</label>
                                <input type="number" name="registration_fee" id="_fee" value="<?= old('registration_fee', $event->registration_fee) ?>" class="form-control <?= hasError('registration_fee') ? 'is-invalid' : '' ?>" min="0" step="1" placeholder="0">

                                <?php foreach (errors('registration_fee') as $error) : ?>
                                    <span class="invalid-feedback" role="alert">
                                        <?= $error ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <fieldset class="fieldset">
                            <legend class="fieldset-legend">Change Banner Image</legend>

                            <div class="row">

                                <!-- file selector -->
                                <div class="form-group col-12 col-lg-12 mb-3">
                                    <label for="_attachment">Select Image</label>
                                    <input type="file" id="_attachment" class="form-control" name="banner_image" accept="image/png,image/jpeg">
                                </div>

                                <!-- preview selected files -->
                                <div class="col-12 col-lg-12 mb-3" style="padding: 0px 12px">
                                    <div id="image_container" style="position: relative; width: fit-content">
                                        <?php
                                        $banner = $event->getBanner();
                                        if ($banner): ?>
                                            <img class="img-thumbnail" src="<?= getBaseUrl() . "/uploads/{$banner['filepath']}/{$banner['filename']}" ?>"
                                                style="width: 20vw;">
                                        <?php else: ?>
                                            <img class="img-thumbnail" src="" style="width: 20vw;">
                                        <?php endif; ?>
                                        <i class="fas fa-times text-danger remove-btn image-remove-btn" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Image"></i>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                    </div>
                    <div class="card-footer d-flex justify-content-end">
                        <input type="submit" value="Update Event Event" class="btn btn-success">
                    </div>
                </form>

            </div>
        </div>

    </div>
</div>