<?php
$layoutFile = 'layouts.main';

################## extra styles section ##################
ob_start(); ?>
<style>
    .schedule-button,
    .book-ticket-btn {
        font-size: 15px;
        font-weight: 600;
        line-height: 15px;
        padding: 12px 15px;
    }

    .schedule-button::after,
    .book-ticket-btn::after {
        height: 25px;
        width: 25px;
    }

    .search-container {
        position: relative;
        display: inline-block;
    }

    .search-icon {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        color: #999;
        pointer-events: none;
    }
</style>
<?php $stylesBlock = ob_get_clean();

################## extra scripts section ##################
ob_start(); ?>
<script>
    var eventSchedules = [];
    var events = [];
    var filteredEvents = [];
    const eventsPerPage = 10;
    var currentPage = 1;
    var totalPages;

    // dom related functions
    function generateSchedules(schedules) {
        let output = '';
        for (let schedule of schedules) {
            output += `<a style="cursor: pointer;" data-schedule-date="${schedule.date}" class="schedule-button vl-btn1 m-1">${schedule.date}</a>`;
        }

        $(".schedule-area").append(output ?? "");
    }

    function generateEvents(eventList) {
        let output = '';
        for (let event of eventList) {
            output += `
                    <div class="row">
                        <div class="col-lg-10 m-auto">
                            <div class="event2-boxarea box1">

                                <div class="row align-items-center">

                                    <div class="col-lg-5">
                                        <div class="img1">
                                            <img src="<?= getBaseUrl() ?>${event.banner_image}" alt="" />
                                        </div>
                                    </div>

                                    <div class="col-lg-1"></div>

                                    <div class="col-lg-6">
                                        <div class="content-area">
                                            <ul>
                                                <li>
                                                    <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/clock1.svg" alt="" />${event.start_time} <span> | </span></a>
                                                </li>
                                                <li>
                                                    <a href="#"><img src="<?= getBaseUrl() ?>/assets/img/icons/location1.svg" alt="" />${event.location} </a>
                                                </li>
                                            </ul>
                                            <div class="space14"></div>
                                            <a href="<?= getBaseUrl() ?>/events/${event.event_id}/view-details" class="head">${event.name}</a>
                                            
                                            <div class="space16"></div>
                                            <div class="btn-area1">
                                                <a href="<?= getBaseUrl() ?>/events/${event.event_id}/get-ticket" class="vl-btn1 book-ticket-btn"><span class="demo">Get Your Ticket Now</span></a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="space40"></div>
                `;
        }

        $(".events-area").html(output ?? "No Content!");
    }

    // pagination area
    function calculateTotalPages() {
        currentPage = 1;
        totalPages = Math.ceil(filteredEvents.length / eventsPerPage);
    }

    function getPaginatedEvents() {
        const startIndex = (currentPage - 1) * eventsPerPage;
        const endIndex = startIndex + eventsPerPage;
        return filteredEvents.slice(startIndex, endIndex);
    }

    function renderPagination() {
        let output = '';

        if (totalPages <= 1) {
            $(".pagination").html('');
            return;
        }

        // Previous button
        output += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}">
                            <i class="fa-solid fa-angle-left"></i>
                        </a>
                    </li>`;

        // Page numbers
        if (totalPages <= 5) {
            for (let i = 1; i <= totalPages; i++) {
                output += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
            }
        } else {
            output += `<li class="page-item ${currentPage === 1 ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="1">1</a>
                        </li>`;

            if (currentPage > 3) {
                output += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            let startPage = Math.max(2, currentPage - 1);
            let endPage = Math.min(totalPages - 1, currentPage + 1);

            for (let i = startPage; i <= endPage; i++) {
                output += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a class="page-link" href="#" data-page="${i}">${i}</a>
                            </li>`;
            }

            if (currentPage < totalPages - 2) {
                output += `<li class="page-item disabled"><a class="page-link">...</a></li>`;
            }

            output += `<li class="page-item ${currentPage === totalPages ? 'active' : ''}">
                            <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                        </li>`;
        }

        // Next button
        output += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}">
                            <i class="fa-solid fa-angle-right"></i>
                        </a>
                    </li>`;

        // Append pagination
        $(".pagination").html(output);

        // Attach event listeners
        $(".pagination .page-link").on("click", function(e) {
            e.preventDefault();
            const newPage = parseInt($(this).data("page"));
            if (!isNaN(newPage) && newPage > 0 && newPage <= totalPages) {
                currentPage = newPage;
                renderPagination();
                generateEvents(getPaginatedEvents());
            }
        });
    }

    function setEvents(items) {
        events = items;
        filteredEvents = events;
    }

    function renderDataWithAllFunctionality() {
        calculateTotalPages();
        renderPagination();
        generateEvents(getPaginatedEvents());
    }

    // Search function
    function searchEvents(query) {
        query = query.toLowerCase().trim();

        filteredEvents = events.filter(event =>
            event.name.toLowerCase().includes(query) ||
            event.start_time.toLowerCase().includes(query) ||
            event.location.toLowerCase().includes(query)
        );

        renderDataWithAllFunctionality();
    }

    // main function
    async function main() {
        // get schedules
        eventSchedules = await getEventSchedules({});

        // get events on first schedule
        events = await getEvents({});
    }

    // call function at beginning
    $(function() {
        main().then(() => {
            // get events of first schedule
            generateSchedules(eventSchedules);

            filteredEvents = events;

            // generate events
            renderDataWithAllFunctionality();
        })
    })

    // Attach search event listener
    $("#search-events").on("input", function() {
        const query = $(this).val();
        searchEvents(query);
    });


    // get events and print when click schedule button
    $(document).on('click', '.schedule-button', function(event) {
        getEvents({
            date: $(this).attr('data-schedule-date')
        }).then((events) => {
            setEvents(events);

            renderDataWithAllFunctionality();
        })
    });
</script>
<?php $scriptsBlock = ob_get_clean();
?>


<!--===== HERO AREA STARTS =======-->
<div class="inner-page-header" style="background-image: url(<?= getBaseUrl() ?>/assets/img/bg/header-bg8.png)">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="heading1 text-center">
                    <h1>Events</h1>
                    <div class="space20"></div>
                    <a href="<?= route('/') ?>">Home</a>
                    <a href="#"><i class="mx-2 fa-solid fa-angle-right"></i><span>Event List</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== HERO AREA ENDS =======-->

<!--===== EVENT AREA STARTS =======-->
<div class="event-team-area blog-details-section sp1">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="text-center space-margin60">
                    <h2>All Events</h2>
                </div>
            </div>
        </div>
        <div class="row">

            <!-- sidebar -->
            <div class="col-lg-4">
                <div class="space30 d-lg-none d-block"></div>
                <div class="blog-auhtor-details">
                    <div class="search-area">
                        <h3>Search</h3>
                        <div class="space16"></div>
                        <div class="form-control search-container">
                            <input type="text" id="search-events" placeholder="Search..." />
                            <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        </div>
                    </div>
                    <div class="space16"></div>
                    <div class="blog-categories schedule-area">
                        <h3>Event Schedules</h3>
                        <div class="space8"></div>
                        <a style="cursor: pointer;" data-schedule-date="" class="schedule-button vl-btn1 m-1">All</a>
                    </div>
                </div>
            </div>

            <!-- events -->
            <div class="col-lg-8">
                <div class="event-widget-area events-area"></div>

                <div class="space60"></div>
                <div class="pagination-area">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination"></ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!--===== EVENT AREA ENDS =======-->