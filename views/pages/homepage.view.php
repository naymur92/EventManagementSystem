<?php
$layoutFile = 'layouts.main';
?>

<!--===== HERO AREA STARTS =======-->
<div class="inner-page-header" style="background-image: url(assets/img/bg/header-bg12.png)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading1 text-center">
                    <!-- <h1>Contact Us</h1>
                        <div class="space20"></div>
                        <a href="index.html">Home <i class="fa-solid fa-angle-right"></i> <span>Contact Us</span></a> -->
                    <h1>Welcome, Find your event here!</h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== EVENT AREA STARTS =======-->
<div class="event1-section-area sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="event-header heading2 space-margin60 text-center">
                    <h5 data-aos="fade-left" data-aos-duration="800">Event Schedule</h5>
                    <div class="space16"></div>
                    <h2 class="text-anime-style-3">Our Events Schedule Plan</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div data-aos="fade-up" data-aos-duration="900">
                    <ul class="nav nav-pills space-margin60" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                <span class="day">Day 01</span>
                                <span class="vl-flex">
                                    <span class="cal">01</span>
                                    <span class="date">JAN <br />
                                        2025</span>
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                <span class="day">Day 02</span>
                                <span class="vl-flex">
                                    <span class="cal">08</span>
                                    <span class="date">JAN <br />
                                        2025</span>
                                </span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">
                                <span class="day">Day 03</span>
                                <span class="vl-flex">
                                    <span class="cal">15</span>
                                    <span class="date">JAN <br />
                                        2025</span>
                                </span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact1-tab" data-bs-toggle="pill" data-bs-target="#pills-contact1" type="button" role="tab" aria-controls="pills-contact1" aria-selected="false">
                                <span class="day">Day 04</span>
                                <span class="vl-flex">
                                    <span class="cal">20</span>
                                    <span class="date">JAN <br />
                                        2025</span>
                                </span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-contact2-tab" data-bs-toggle="pill" data-bs-target="#pills-contact2" type="button" role="tab" aria-controls="pills-contact2" aria-selected="false">
                                <span class="day">Day 05</span>
                                <span class="vl-flex">
                                    <span class="cal">25</span>
                                    <span class="date">JAN <br />
                                        2025</span>
                                </span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                        <div class="tabs-widget-boxarea" data-aos="fade-up" data-aos-duration="800">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img1.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Your Pathway to Business Transformation</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea" data-aos="fade-up" data-aos-duration="1000">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img2.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 A Full-Day Journey the Future of Business</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea" data-aos="fade-up" data-aos-duration="1200">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img3.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Charting the Course for Business Success</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-3">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img1.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Your Pathway to Business Transformation</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab" tabindex="0">
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img1.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Your Pathway to Business Transformation</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img2.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 A Full-Day Journey the Future of Business</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img3.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Charting the Course for Business Success</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact1" role="tabpanel" aria-labelledby="pills-contact1-tab" tabindex="0">
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img1.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Your Pathway to Business Transformation</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img2.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 A Full-Day Journey the Future of Business</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img3.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Charting the Course for Business Success</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact2" role="tabpanel" aria-labelledby="pills-contact2-tab" tabindex="0">
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img1.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Your Pathway to Business Transformation</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img2.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 A Full-Day Journey the Future of Business</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="space30"></div>
                        <div class="tabs-widget-boxarea">
                            <div class="row align-items-center">
                                <div class="col-lg-4">
                                    <div class="img1">
                                        <img src="<?= getBaseUrl() ?>/assets/img/all-images/event/event-img3.png" alt="" />
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="content-area">
                                        <ul>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> 10:00 AM -12:00 PM <span> | </span></a>
                                            </li>
                                            <li>
                                                <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> 26/C Asana, New York </a>
                                            </li>
                                        </ul>
                                        <div class="space20"></div>
                                        <a href="event-single" class="head">Innovate 2025 Charting the Course for Business Success</a>
                                        <div class="space16"></div>
                                        <p>The Innovate 2025 conference is meticulously designed to provide you with a rich, immersive experience that drives actionable insights & fosters collaboration from keynote presentations.</p>
                                        <div class="space32"></div>
                                        <div class="btn-area1">
                                            <a href="pricing-plan" class="vl-btn1">purchase ticket now</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->


<!--===== OTHERS AREA STARTS =======-->
<div class="brands1-section-area sp2">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 m-auto">
                <div class="brand-header heading2 space-margin60 text-center">
                    <h5 data-aos="fade-left" data-aos-duration="800">general sponsors</h5>
                    <div class="space16"></div>
                    <h2 class="text-anime-style-3">Our Official Sponsors</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="800">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img1.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="900">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img2.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="1000">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img3.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="1100">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img4.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="900">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img5.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="1000">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img6.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="1100">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img7.png" alt="" />
                </div>
            </div>

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-duration="1200">
                <div class="brand-box">
                    <img src="<?= getBaseUrl() ?>/assets/img/elements/brand-img8.png" alt="" />
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== OTHERS AREA ENDS =======-->