<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Search -->
    <!-- <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                aria-label="Search" aria-describedby="basic-addon2">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form> -->

    <!-- Topbar Navbar -->
    <div class="float-left mr-auto ml-3 pl-1 topbar-title">
        <h1 class="page-title text-truncate text-primary font-weight-medium mb-1"><?= $title ?></h1>
    </div>

    <ul class="navbar-nav float-end ml-auto">
        <div class="first-topbar-divider topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <?php if (authUser()): ?>
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= authUser()->name ?></span>
                    <!-- @if (Auth::user()->profilePicture)
                    <img class="img-profile rounded-circle" src="{{ asset('/') }}{{ Auth::user()->profilePicture->filepath . '/' . Auth::user()->profilePicture->filename }}">
                    @else
                    <img class="img-profile rounded-circle" src="{{ asset('/') }}assets/uploads/users/user.png">
                    @endif -->

                    <img class="img-profile rounded-circle" src="<?= getBaseUrl() ?>/uploads/users/user.png">
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="<?= route('/admin/user-profile') ?>">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Profile
                    </a>
                    <a class="dropdown-item" href="<?= route('/admin/change-password') ?>">
                        <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                        Change Password
                    </a>

                    <div class="dropdown-divider"></div>
                    <form action="<?= route('/logout') ?>" method="POST" onsubmit="swalConfirmationOnSubmit(event, 'Are you sure to logout?');">
                        <?= csrfField() ?>

                        <button class="dropdown-item dropdown-logout-button btn btn-sm btn-link btn-outline-danger" type="submit">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </li>
        <?php endif; ?>


    </ul>

</nav>