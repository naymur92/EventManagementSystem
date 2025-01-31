<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>
<style>
    .custom-brand-box {
        border-radius: 8px;
        border: 1px solid rgba(26, 23, 25, 0.05);
        background: #FFF;
        text-align: center;
        padding: 30px;
        transition: all 0.4s;
        margin-bottom: 30px;
    }

    /* .brands1-section-area .brand-box img {} */
</style>
<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<script>
    var eventSchedules = [];
    var events = [];
    var hostUsers = [];

    // dom related functions
    function generateSchedules(schedules) {
        let output = '';
        let isActive = true;
        for (let i = 0; i < schedules.length; i++) {
            let scheduleDate = schedules[i].date;

            let date = new Date(scheduleDate);

            // Extract values
            let day = date.getDate().toString().padStart(2, '0');
            let month = date.toLocaleString('en-US', {
                month: 'short'
            }).toUpperCase();
            let year = date.getFullYear();

            // console.log(day, month, year)

            output += `
                    <li class="nav-item" role="presentation">
                        <button class="nav-link ${isActive ? 'active' : ''} schedule-button" data-schedule-date="${scheduleDate}" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                            
                            <span class="vl-flex">
                                <span class="cal">${day}</span>
                                <span class="date">${month.toUpperCase()} <br />
                                    ${year}</span>
                            </span>
                        </button>
                    </li>
                `;

            isActive = false;
        }

        $(".schedule-area").html(output ?? "No Content!");
    }

    function generateEvents(events) {
        let output = '';
        let data_eos_duration = 800;
        for (let event of events) {
            output += `
                    <div class="tabs-widget-boxarea" data-aos="fade-up" data-aos-duration="${data_eos_duration}">
                        <div class="row align-items-center">
                            <div class="col-lg-4">
                                <div class="img1">
                                    <img src="<?= getBaseUrl() ?>${event.banner_image}" alt="" />
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="content-area">
                                    <ul>
                                        <li>
                                            <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" /> ${event.start_time} <span> | </span></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /> ${event.location} </a>
                                        </li>
                                    </ul>
                                    <div class="space20"></div>
                                    <a href="<?= getBaseUrl() ?>/events/${event.event_id}/view-details" class="head">${event.name}</a>
                                    <div class="space32"></div>
                                    <div class="btn-area1">
                                        <a href="<?= getBaseUrl() ?>/events/${event.event_id}/get-ticket" class="vl-btn1">Get Your Ticket Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space30"></div>
                `;

            data_eos_duration += 200;
        }

        $(".events-area").html(output ?? "No Content!");
    }

    function generateHosts(hosts) {
        let output = '';
        let data_eos_duration = 800;
        for (let host of hosts) {
            output += `
                    <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-duration="${data_eos_duration}">
                        <div class="custom-brand-box row justify-content-between align-items-center">
                            <img class="col-3" src="<?= getBaseUrl() ?>${host.profile_picture ?? '/uploads/users/user.png'}" alt="" />
                            <h5 class="col-9">${host.name}</h5>
                        </div>
                    </div>
                `;

            data_eos_duration += 100;
        }

        $(".hosts-area").html(output ?? "");
    }

    // main function
    async function main() {
        // get schedules
        eventSchedules = await getEventSchedules({
            limit: 4
        });

        // get events on first schedule
        if (eventSchedules.length > 0) {
            events = await getEvents({
                date: eventSchedules[0].date
            });
        }

        hostUsers = await getHostUsers({
            limit: 6
        });
    }

    // call function at beginning
    $(function() {
        main().then(() => {
            // get events of first schedule
            generateSchedules(eventSchedules);

            // generate events
            generateEvents(events);

            // generate hosts
            generateHosts(hostUsers);
        })
    })


    // get events and print when click schedule button
    $(document).on('click', '.schedule-button', function() {
        getEvents({
            date: $(this).attr('data-schedule-date')
        }).then((events) => {
            generateEvents(events)
        })
    });
</script>
<?php $scriptsBlock = ob_get_clean();
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
                    <!-- <h2 class="text-anime-style-3">Events Schedules</h2> -->
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div data-aos="fade-up" data-aos-duration="900">
                    <!-- Event Schedule Section -->
                    <ul class="nav nav-pills space-margin60 schedule-area"></ul>
                </div>

                <div class="tab-content">
                    <!-- Event List Section -->
                    <div class="tab-pane show active events-area" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0"></div>

                    <div class="d-flex justify-content-center">
                        <a href="<?= route('/events') ?>" class="vl-btn1">Show All Events</a>
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
                    <h2 class="text-anime-style-3">Our Hosts</h2>
                </div>
            </div>
        </div>
        <div class="row hosts-area"></div>
    </div>
</div>
<!--===== OTHERS AREA ENDS =======-->