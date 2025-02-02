<header>
    <div class="header-area homepage1 header header-sticky d-none d-lg-block" id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-elements">
                        <div class="site-logo">
                            <a href="<?= route('/'); ?>"><img src="<?= getBaseUrl() ?>/assets/img/logo/logo1.png" alt="" /></a>
                        </div>

                        <div class="main-menu">
                            <ul class="d-flex align-items-center">
                                <li><a href="<?= route('/') ?>">Home</a></li>
                                <li><a href="<?= route('/events') ?>">Events</a></li>
                                <li><a href="<?= route('/tickets/find-ticket') ?>">Find Ticket</a></li>
                                <?php if (authUser()): ?>
                                    <?php if (authUser()->type != 3): ?>
                                        <li><a href="<?= route('/admin') ?>">Admin Page</a></li>
                                    <?php endif; ?>
                                    <li>
                                        <div style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 5px; padding: 2px;">
                                            <?php
                                            $profilePicture = authUser()->getProfilePicture();
                                            if ($profilePicture): ?>
                                                <img class="img-profile rounded-circle" src="<?= getBaseUrl() . "/uploads/{$profilePicture['filepath']}/{$profilePicture['filename']}" ?>">
                                            <?php else: ?>
                                                <img class="img-profile rounded-circle" src="<?= getBaseUrl() ?>/uploads/users/user.png">
                                            <?php endif; ?>
                                            <a href="#"><?= authUser()->name; ?> <i class="fa-solid fa-angle-down"></i></a>

                                            <ul class="dropdown-padding">
                                                <li><a href="<?= route('/user-profile') ?>">Profile Info</a></li>
                                                <?php if (authUser()->type == 3): ?>
                                                    <li><a href="<?= route('/my-tickets') ?>">My Tickets</a></li>
                                                <?php endif; ?>

                                                <form action="<?= route('/logout') ?>" method="POST">
                                                    <?= csrfField() ?>

                                                    <a class="vl-btn1 logout-btn" type="button" onclick="swalConfirmationOnSubmit(event, 'Are you sure to logout?');">
                                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                                        Logout
                                                    </a>
                                                </form>
                                            </ul>
                                        </div>
                                    </li>
                                <?php else: ?>
                                    <li><a href="<?= route('/login') ?>">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="btn-area">
                            <!-- <div class="search-icon header__search header-search-btn">
                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/search1.svg" alt="" /></a>
                            </div> -->
                        </div>

                        <div class="header-search-form-wrapper">
                            <div class="tx-search-close tx-close"><i class="fa-solid fa-xmark"></i></div>
                            <div class="header-search-container">
                                <form role="search" class="search-form">
                                    <input type="search" class="search-field" placeholder="Search …" value="" name="s" />
                                    <button type="submit" class="search-submit"><img src="<?= getBaseUrl() ?>/assets/img/icons/search1.svg" alt="" /></button>
                                </form>
                            </div>
                        </div>

                        <div class="body-overlay"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>


<!--===== MOBILE HEADER STARTS =======-->
<div class="mobile-header mobile-haeder1 d-block d-lg-none">
    <div class="container-fluid">
        <div class="col-12">
            <div class="mobile-header-elements">
                <div class="mobile-logo">
                    <a href="<?= route('/') ?>"><img src="<?= getBaseUrl() ?>/assets/img/logo/logo1.png" alt="" /></a>
                </div>
                <div class="mobile-nav-icon dots-menu">
                    <i class="fa-solid fa-bars-staggered"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-sidebar mobile-sidebar1">
    <div class="logosicon-area">
        <div class="logos">
            <img src="<?= getBaseUrl() ?>/assets/img/logo/logo1.png" alt="" />
        </div>
        <div class="menu-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="mobile-nav mobile-nav1">

        <ul class="mobile-nav-list nav-list1">
            <li><a href="<?= route('/') ?>">Home </a></li>
            <li><a href="<?= route('/events') ?>">Events</a></li>
            <li><a href="<?= route('/tickets/find-ticket') ?>">Find Tickets</a></li>
            <?php if (authUser()): ?>
                <?php if (authUser()->type != 3): ?>
                    <li><a href="<?= route('/admin') ?>">Admin Page</a></li>
                <?php endif; ?>
                <li>
                    <div style="display: flex; align-items: center;">
                        <?php
                        $profilePicture = authUser()->getProfilePicture();
                        if ($profilePicture): ?>
                            <img class="img-profile rounded-circle" src="<?= getBaseUrl() . "/uploads/{$profilePicture['filepath']}/{$profilePicture['filename']}" ?>">
                        <?php else: ?>
                            <img class="img-profile rounded-circle" src="<?= getBaseUrl() ?>/uploads/users/user.png">
                        <?php endif; ?>

                        <a style="margin-left: 5px;" href="#"><?= authUser()->name; ?></a>

                        <ul class="sub-menu">
                            <li><a href="<?= route('/user-profile') ?>">Profile Info</a></li>
                            <?php if (authUser()->type == 3): ?>
                                <li><a href="<?= route('/my-tickets') ?>">My Tickets</a></li>
                            <?php endif; ?>
                            <form action="<?= route('/logout') ?>" method="POST">
                                <?= csrfField() ?>

                                <a class="vl-btn1 logout-btn text-white" type="button" onclick="swalConfirmationOnSubmit(event, 'Are you sure to logout?');">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                                    Logout
                                </a>
                            </form>
                        </ul>
                    </div>
                </li>
            <?php else: ?>
                <li><a href="<?= route('/login') ?>">Login</a></li>
            <?php endif; ?>
        </ul>

        <div class="allmobilesection">
            <!-- <a href="contact" class="vl-btn1">Contact Now</a> -->
            <div class="single-footer">
                <h3>Contact Info</h3>
                <div class="footer1-contact-info">
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <span><i class="fa-solid fa-phone-volume"></i></span>
                        </div>
                        <div class="contact-info-text">
                            <a href="tel:+8801737036324">+8801737036324</a>
                        </div>
                    </div>
                    <div class="contact-info-single">
                        <div class="contact-info-icon">
                            <span><i class="fa-solid fa-envelope"></i></span>
                        </div>
                        <div class="contact-info-text">
                            <a href="mailto:info@example.com">info@example.com</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>