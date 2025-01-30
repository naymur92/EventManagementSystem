const BASE_URL = $('meta[name="base-url"]').attr('content');

// global function for fetch api data
async function callApi(endPoint, params) {
    return await $.ajax({
        "url": BASE_URL + endPoint,
        "method": "POST",
        "headers": {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        "data": params
    });
}


// function to get event schedules
async function getEventSchedules(params) {
    let eventSchedules = [];
    await callApi('/api/get-event-schedules', params).then((response) => {
        if (response.status) {
            eventSchedules = response.data;
        } else {
            // console.error(response);
        }
    }).catch((error) => {
        // console.error(error);
    })
    return eventSchedules;
}


// function to get events
async function getEvents(params) {
    let events = [];
    await callApi('/api/get-events', params).then((response) => {
        if (response.status) {
            events = response.data;
        } else {
            // console.error(response);
        }
    }).catch((error) => {
        // console.error(error);
    })
    return events;
}