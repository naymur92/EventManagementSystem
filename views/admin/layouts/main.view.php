<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Event Management Software">
    <meta name="author" content="Naymur Rahman">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?= csrf(); ?>">

    <title><?= $title ?? '' ?> - <?= getEnvData('APP_NAME') ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= getBaseUrl() ?>/admin_assets/vendor/Font-Awesome-6.x/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="<?= getBaseUrl() ?>/admin_assets/css/fonts.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= getBaseUrl() ?>/admin_assets/css/sb-admin-2.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="<?= getBaseUrl() ?>/admin_assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet">

    <link href="<?= getBaseUrl() ?>/admin_assets/css/customized-bootstrap-datepicker.css" rel="stylesheet">

    <!-- Styles -->
    <?= $stylesBlock ?? '' ?>

    <link href="<?= getBaseUrl() ?>/admin_assets/css/custom.css" rel="stylesheet">

    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
            text-align: right;
        }
    </style>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- style files for printing -->
    <script>
        var fontUrls = [];

        var cssFiles = [
            "<?= getBaseUrl() ?>/admin_assets/vendor/Font-Awesome-6.x/css/all.min.css",
            "<?= getBaseUrl() ?>/admin_assets/css/print-style.css",
        ];
    </script>

    <!-- Custom scripts for all pages-->
    <script src="<?= getBaseUrl() ?>/admin_assets/js/sb-admin-2.js"></script>

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php require(basePath('/views/admin/layouts/sidebar.view.php')) ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php require(basePath('/views/admin/layouts/topbar.view.php')) ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?= $viewContent ?? '' ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php require(basePath('/views/admin/layouts/footer.view.php')) ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- moment js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment-with-locales.min.js"></script>

    <script src="<?= getBaseUrl() ?>/admin_assets/js/customized-bootstrap-datepicker.js" defer></script>
    <script src="<?= getBaseUrl() ?>/admin_assets/js/global_helpers.js"></script>
    <script src="<?= getBaseUrl() ?>/admin_assets/js/swal-helpers.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        showFlashMessages(<?= json_encode(getFlashData()); ?>);
    </script>


    <!-- scripts block -->
    <?= $scriptsBlock ?? '' ?>
</body>

</html>