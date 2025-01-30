// global function for fetch api data
async function callApi(url, params) {
    try {
        return await $.ajax({
            "url": url,
            "method": "POST",
            "headers": {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            "data": params
        });
    } catch (error) {
        console.error('Error:', error);
    }
}
