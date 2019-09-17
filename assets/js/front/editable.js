const axios = require('axios');

document.querySelectorAll('.editable-input').forEach(value => {
    value.addEventListener('dblclick', function () {
        value.setAttribute('contenteditable', true);
    });
    value.addEventListener('blur', function () {
        value.removeAttribute('contenteditable');

        axios.post(
            value.getAttribute('url'),
            {
                value: value.innerText,
                field: value.getAttribute('type')
            },
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then(function (response) {
            console.log(response.data);
            location.reload(true);
        });
    }, true);
})