<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <meta name="csrf-token" content="<?= csrf(); ?>">
    <meta name="base-url" content="<?= getBaseUrl(); ?>">


    <title><?= $title; ?></title>

    <!--=====FAB ICON=======-->
    <link rel="shortcut icon" href="<?= getBaseUrl() ?>/assets/img/logo/fav-logo1.png" />

    <!--===== CSS LINK =======-->
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/aos.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/fontawesome.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/magnific-popup.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/mobile.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/owlcarousel.min.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/sidebar.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/slick-slider.css" />
    <!-- <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/nice-select.css" /> -->
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/vendor/odometer.css" />
    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/main.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="<?= getBaseUrl() ?>/assets/css/custom.css" />


    <!-- Styles -->
    <?= $stylesBlock ?? '' ?>

    <!--=====  JS SCRIPT LINK =======-->
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/jquery-3.7.1.min.js"></script>


    <script src="<?= getBaseUrl() ?>/assets/js/ajax.js"></script>
</head>

<body class="homepage1-body">
    <!--===== PRELOADER STARTS =======-->
    <!-- <div class="preloader">
        <div class="loading-container">
            <div class="loading"></div>
            <div id="loading-icon"><img src="assets/img/logo/preloader.png" alt="" /></div>
        </div>
    </div> -->
    <!--===== PRELOADER ENDS =======-->

    <!--===== PAGE PROGRESS START=======-->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
    </div>
    <!--===== PAGE PROGRESS END=======-->

    <?php require(basePath('/views/layouts/header.view.php')) ?>


    <?= $viewContent ?? '' ?>


    <!--===== FOOTER AREA STARTS =======-->
    <?php require(basePath('/views/layouts/footer.view.php')) ?>
    <!--===== FOOTER AREA ENDS =======-->


    <script src="<?= getBaseUrl() ?>/assets/js/vendor/bootstrap.min.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/fontawesome.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/aos.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/jquery.appear.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/jquery.odometer.min.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/sidebar.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/magnific-popup.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/gsap.min.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/ScrollTrigger.min.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/Splitetext.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/mobilemenu.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/owlcarousel.min.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/nice-select.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/waypoints.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/slick-slider.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/vendor/circle-progress.js"></script>
    <script src="<?= getBaseUrl() ?>/assets/js/main.js"></script>

    <!--===== JS SCRIPT LINK =======-->
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

    <!-- scripts block -->
    <?= $scriptsBlock ?? '' ?>
</body>


</html>