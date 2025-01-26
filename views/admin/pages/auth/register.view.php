<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Event Management Software">
    <meta name="author" content="Naymur Rahman">

    <title>Register - <?= getEnvData('APP_NAME') ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= getBaseUrl() ?>/admin_assets/vendor/Font-Awesome-6.x/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= getBaseUrl() ?>/admin_assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= getBaseUrl() ?>/admin_assets/css/custom.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">

            <div class="col-12 col-lg-8">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">New registration</h1>
                            </div>
                            <form class="user" method="POST" action="<?= route('/register') ?>" autocomplete="off">
                                <?= csrfField() ?>

                                <div class="form-group">
                                    <!-- <label for="_name">Name <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label> -->
                                    <input id="_name" type="text" class="form-control form-control-user <?= hasError('name') ? 'is-invalid' : '' ?>" name="name" value="<?= old('name') ?>" required placeholder="Full Name">

                                    <?php foreach (errors('name') as $error) : ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?= $error ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <div class="form-group">
                                    <!-- <label for="_email">Email <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label> -->
                                    <input id="_email" type="email" class="form-control form-control-user <?= hasError('email') ? 'is-invalid' : '' ?>" name="email" value="<?= old('email') ?>" required placeholder="someone@example.com">

                                    <?php foreach (errors('email') as $error) : ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?= $error ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <div class="form-group">
                                    <!-- <label for="_mobile">Mobile</label> -->
                                    <input id="_mobile" type="text" class="form-control form-control-user <?= hasError('mobile') ? 'is-invalid' : '' ?>" name="mobile" value="<?= old('mobile') ?>" placeholder="01xxxxxxxxx">

                                    <?php foreach (errors('mobile') as $error) : ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?= $error ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>

                                <div class="form-group">
                                    <!-- <label for="_password">Password <span class="text-danger"><i class="fas fa-xs fa-asterisk"></i></span></label> -->
                                    <input id="_password" type="password" class="form-control form-control-user <?= hasError('password') ? 'is-invalid' : '' ?>" name="password" required placeholder="Password here">

                                    <?php foreach (errors('password') as $error) : ?>
                                        <span class="invalid-feedback" role="alert">
                                            <?= $error ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>


                                <input type="submit" class="btn btn-primary btn-user btn-block" value="Register">

                            </form>
                            <hr>
                            <div class="text-center">
                                <!-- <a class="small" href="forgot-password.html">Forgot Password?</a> -->
                            </div>
                            <div class="text-center">
                                <a class="small" href="<?= route('/login') ?>">Already have an account? Login!</a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= getBaseUrl() ?>/admin_assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= getBaseUrl() ?>/admin_assets/js/sb-admin-2.min.js"></script>

</body>

</html>