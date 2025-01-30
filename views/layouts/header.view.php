<header>
    <div class="header-area homepage1 header header-sticky d-none d-lg-block" id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-elements">
                        <div class="site-logo">
                            <a href="index.html"><img src="<?= getBaseUrl() ?>/assets/img/logo/logo1.png" alt="" /></a>
                        </div>

                        <div class="main-menu">
                            <ul>
                                <li><a href="<?= route('/') ?>">Home</a></li>
                                <li><a href="<?= route('/events') ?>">Events</a></li>
                                <!-- <li><a href="about">About Event</a></li> -->
                                <!-- <li><a href="contact">Contact Us</a></li> -->
                                <li><a href="<?= route('/login') ?>">Login</a></li>
                            </ul>
                        </div>

                        <div class="btn-area">
                            <div class="search-icon header__search header-search-btn">
                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/search1.svg" alt="" /></a>
                            </div>
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
                    <a href="index.html"><img src="<?= getBaseUrl() ?>/assets/img/logo/logo1.png" alt="" /></a>
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
            <img src="<?= getBaseUrl() ?>/assets/img/logo/logo2.png" alt="" />
        </div>
        <div class="menu-close">
            <i class="fa-solid fa-xmark"></i>
        </div>
    </div>
    <div class="mobile-nav mobile-nav1">

        <ul class="mobile-nav-list nav-list1">
            <li><a href="<?= route('/') ?>">Home </a></li>
            <li><a href="<?= route('/events') ?>">Events</a></li>
            <!-- <li><a href="features.html">Schedule</a></li> -->
            <li><a href="<?= route('/login') ?>">Login</a></li>
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