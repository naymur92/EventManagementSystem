<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>

<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<script>
    var event = {};
    var event_id = <?= $event_id ?>;

    // console.log(event_id)

    // dom related functions
    function generateEventDetailContent(event) {
        // ready date block
        let dateSection = `${event.start_time}`;
        if (event.end_time !== null && event.end_time.length > 0) {
            dateSection += ` - ${event.end_time}`;
        }

        // ready google map block
        let googleMapPart = '';
        if (event.google_map_location !== null && event.google_map_location.length > 0) {
            googleMapPart = `
                            <div class="space12"></div> 
                            <h4>Google Map Location</h4>
                            <div class="space12"></div> 
                            ${event.google_map_location}
                            <div class="space16"></div>
                            `;
        }

        // ready registration fee section
        let registrationFeeSection = '';
        if (event.registration_fee != 0) {
            registrationFeeSection = `<span class="badge bg-success">Registration Fee: Tk. ${event.registration_fee}</span>`;
        } else {
            registrationFeeSection = `<span class="badge bg-success">Free Registration.</span>`;
        }

        // ready ticket booking button
        let ticketBookingButton = '';
        let seatsAvailableBadge = '';
        if (event.current_capacity > 0 || event.max_capacity == 0) {
            if (event.current_capacity > 0) {
                seatsAvailableBadge = `<span class="badge bg-info text-dark">${event.current_capacity} Seats Available</span>`;
            } else {
                seatsAvailableBadge = `<span class="badge bg-info text-dark">Unlimited Registration</span>`;
            }

            ticketBookingButton = `
                                    <a href="<?= getBaseUrl() ?>/events/${event.event_id}/get-ticket" class="vl-btn1"><span class="demo">Get Your Ticket Now</span></a>
                                    <div class="space32"></div>
                                `;
        }

        // ready host details block
        let hostInfoSection = `<div class="space8"></div>
                                <div><img src="<?= getBaseUrl() ?>/assets/img/icons/mail1.svg" alt="" /><span> ${event.host_email}</span></div>`;
        if (event.host_mobile !== null && event.host_mobile.length > 0) {
            hostInfoSection += `<div class="space8"></div>
                                <div><img src="<?= getBaseUrl() ?>/assets/img/icons/phn1.svg" alt="" /><span> ${event.host_mobile}</span></div>`;
        }
        if (event.host_address !== null && event.host_address.length > 0) {
            hostInfoSection += `<div class="space8"></div>
                                <div><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /><span> ${event.host_address}</span></div>`;
        }


        // ready final output
        let output = `
                    <div class="col-lg-8">
                        <div class="blog-deatils-content heading2">
                            <div class="img1">
                                <img src="<?= getBaseUrl() ?>${event.banner_image}" alt="" />
                            </div>
                            <div class="space32"></div>
                            <ul>
                                <li>
                                    <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/calender1.svg" alt="" />${dateSection}<span> | </span></a>
                                </li>
                                <li>
                                    <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" />${event.location} </a>
                                </li>
                            </ul>
                            <div class="space18"></div>
                            <h2>${event.name}</h2>
                            <div class="space16"></div>
                            ${event.description}
                            <div class="space16"></div>
                            ${googleMapPart}
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="space30 d-lg-none d-block"></div>
                        <div class="blog-auhtor-details">

                            ${ticketBookingButton}

                            ${seatsAvailableBadge}
                            ${registrationFeeSection}

                            <div class="space8"></div>

                            <div class="blog-categories">
                                <h3>Date & Time</h3>
                                <div class="space8"></div>
                                <div><img src="<?= getBaseUrl() ?>/assets/img/icons/calender1.svg" alt="" /><span> ${dateSection}</span></div>

                                <div class="space24"></div>

                                <h3>Location</h3>
                                <div class="space8"></div>
                                <div><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" /><span> ${event.location}</span></div>
                            </div>

                            <div class="space32"></div>

                            <div class="tags-area">
                                <h3>About Host</h3>
                                <div class="space12"></div>

                                <div class="row justify-content-between align-items-center">
                                    <img class="col-4 col-lg-3" src="<?= getBaseUrl() ?>${event.host_profile_image ?? '/uploads/users/user.png'}" alt="" />
                                    <div class="col-8 col-lg-9"> ${event.host_name}</div>
                                </div>

                                ${hostInfoSection}
                            </div>

                        </div>
                    </div>
                `;

        $(".event-detail-area").html(output ?? "");
    }


    // main function
    async function main() {
        event = await getEventDetail({
            event_id: event_id
        });
    }

    // call function at beginning
    $(function() {
        main().then(() => {
            generateEventDetailContent(event);
        })
    })
</script>
<?php $scriptsBlock = ob_get_clean();
?>


<!--===== HERO AREA STARTS =======-->
<div class="inner-page-header" style="background-image: url(<?= getBaseUrl() ?>/assets/img/bg/header-bg8.png)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading1 text-center">
                    <h1>Event Detail</h1>
                    <div class="space20"></div>
                    <a href="<?= route('/') ?>">Home</a>
                    <a href="<?= route('/events') ?>"><i class="mx-2 fa-solid fa-angle-right"></i>Events</a>
                    <a href="#"><i class="mx-2 fa-solid fa-angle-right"></i><span>Event Detail</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== EVENT AREA STARTS =======-->
<div class="blog-details-section sp8">
    <div class="container">
        <div class="row event-detail-area"></div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->