<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $title ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .fakeimg {
            height: 200px;
            background: #aaa;
        }
    </style>
</head>

<body>

    <div class="p-5 bg-primary text-white text-center">
        <h1>PHP MVC Architecture Project</h1>
        <!-- <p>Resize this responsive page to see the effect!</p> -->
    </div>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= urlIs('/') ? 'active' : '' ?>" href="<?= route('/') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= urlIs('/users') || urlIs('/users/create') ? 'active' : '' ?>" href="<?= route('/users') ?>">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Test Page</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li> -->

                <?php if (!authUser()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= route('/login') ?>">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <!-- <div class="col-sm-4">

                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Active</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#">Disabled</a>
                    </li>
                </ul>
                <hr class="d-sm-none">
            </div> -->

            <!-- content -->
            <?= $viewContent ?>
        </div>
    </div>

    <div class="mt-5 p-4 bg-dark text-white text-center">
        <p>Footer</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>

    <script src="<?= getBaseUrl() ?>/assets/js/global_helpers.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/swal-helpers.js"></script>

    <script>
        // show popup messages
        showPopupMessages(<?= json_encode(getPopupData()); ?>).then(() => {
            // show flash messages
            showFlashMessages(<?= json_encode(getFlashData()); ?>);
        });
    </script>
</body>

</html>