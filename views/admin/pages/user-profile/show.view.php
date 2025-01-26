<?php
$layoutFile = 'admin.layouts.main';

// extra styles section
ob_start(); ?>
<style>
    .image-remove-btn {
        position: absolute;
        cursor: pointer;
        /* right: 130px; */
        padding: 5px;
        border-radius: 50%;
        background-color: #ddd;
        display: none;
    }
</style>
<?php $stylesBlock = ob_get_clean();

// extra scripts section
ob_start(); ?>
<script>
    $(document).ready(function() {
        var img = $("#img_container").children('img');
        var old_src = img.attr('src');
        $("#_pp").val("");

        // console.log(img.attr('src'));

        const acceped_types = [
            "image/png",
            "image/jpeg",
            "image/gif",
        ];
        $("#_pp").on('change', function(event) {
            const file = event.target.files[0];
            $("#_pp").removeClass('is-invalid');
            $(".errors").remove();

            // console.log(file);
            // check file type validation
            var file_type = file.type;
            if (!acceped_types.includes(file_type)) {
                $("#_pp").addClass('is-invalid');
                $("<span class='errors invalid-feedback' role='alert'><strong>Unsupported filetype!</strong></span>")
                    .insertAfter("#_pp");

                // remove img from dom
                $("#_pp").val("");
            } else if (file.size > 1024 * 1024) {
                $("#_pp").addClass('is-invalid');
                $("<span class='errors invalid-feedback' role='alert'><strong>Maximum filesize is 1 MB!</strong></span>")
                    .insertAfter("#_pp");

                // remove img from dom
                $("#_pp").val("");
            } else {
                let imgUrl = URL.createObjectURL(file);
                img.attr('src', imgUrl);

                // show remove btn
                $(".image-remove-btn").css('display', 'inline');
            }

        });

        // remove image
        $(".image-remove-btn").on('click', function() {
            $("#_pp").val("");
            img.attr('src', old_src);
            $(this).css('display', 'none');
            // $(".image-remove-btn").css('display', 'none');
        });

        // on submit form
        $("#profile_picture_change_form").on('submit', function(e) {
            e.preventDefault();

            $("#_pp").removeClass('is-invalid');
            $(".errors").remove();

            if (old_src == img.attr('src')) {
                $("#_pp").addClass('is-invalid');
                $("<span class='errors invalid-feedback' role='alert'><strong>Select an image first!</strong></span>")
                    .insertAfter("#_pp");
            } else if (swalConfirmationOnSubmit(event, 'Are you sure?')) {
                document.getElementById("profile_picture_change_form").submit();
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
                    <h5 class="m-0 text-primary">My Profile</h5>
                    <div class="ms-auto">
                        <div class="btn-list">
                            <a href="<?= route('/admin') ?>" class="btn waves-effect waves-light br-5 btn-secondary">
                                <i class="fas fa-angle-left"></i> Back
                            </a>
                        </div>
                    </div>
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

                        <div class="col-12 col-xl-4 text-center">
                            <!-- @if (Auth::user()->profilePicture)
                            <img class="img-thumbnail rounded-circle"
                                src="{{ asset('/') }}{{ Auth::user()->profilePicture->filepath . '/' . Auth::user()->profilePicture->filename }}" style="width: 20vw;">
                            @else
                            <img class="img-thumbnail rounded-circle" src="{{ asset('/') }}assets/uploads/users/user.png" style="width: 20vw;">
                            @endif -->
                            <img class="img-thumbnail rounded-circle" src="<?= getBaseUrl() ?>/uploads/users/user.png" style="width: 20vw;">

                            <br>
                            <button class="btn btn-outline-success mt-2" data-toggle="modal" data-target="#profilePictureChangeModal">Change Profile Picture</button>

                            <!-- profile picture change modal -->
                            <div class="modal fade" id="profilePictureChangeModal" tabindex="-1" aria-labelledby="profilePictureChangeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="profilePictureChangeModalLabel">Profile Picture Change
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="profile_picture_change_form" action="<?= route('/admin/change-profile-picture') ?>" method="POST"
                                            enctype="multipart/form-data">
                                            <?= csrfField() ?>
                                            <input type="hidden" name="_method" value="PUT">

                                            <div class="modal-body text-center">
                                                <div id="img_container" style="position: relative;">

                                                    <!-- @if (Auth::user()->profilePicture)
                                                    <img class="img-thumbnail rounded-circle"
                                                        src="{{ asset('/') }}{{ Auth::user()->profilePicture->filepath . '/' . Auth::user()->profilePicture->filename }}"
                                                        style="width: 15vw;">
                                                    @else
                                                    <img class="img-thumbnail rounded-circle" src="{{ asset('/') }}assets/uploads/users/user.png" style="width: 15vw;">
                                                    @endif -->
                                                    <img class="img-thumbnail rounded-circle" src="<?= getBaseUrl() ?>/uploads/users/user.png" style="width: 20vw;">

                                                    <i class="image-remove-btn fas fa-trash text-danger"></i>
                                                </div>

                                                <div class="form-group mt-3">
                                                    <label for="_pp">Select Profile Picture</label>
                                                    <input type="file" id="_pp" class="form-control" name="profile_picture" accept="image/png,image/jpeg,image/gif">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="<?= route('') ?>" class="btn btn-outline-warning br-5 waves-effect waves-light">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>