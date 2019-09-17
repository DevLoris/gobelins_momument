const axios = require('axios');

document.querySelectorAll('.rate[url][rate]').forEach(value => {
    value.addEventListener("click", function () {
        console.log("click");
        let url = value.getAttribute('url');
        let rating = value.getAttribute('rate');

        axios.post(
            url,
            {rating},
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then(function (response) {
            console.log(response.data);
            location.reload(true);
        });
    });
});