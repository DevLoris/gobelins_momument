const axios = require('axios');

document.querySelectorAll('.tabs ul li').forEach(value => {
    value.addEventListener("click", function () {
        let tab = value.getAttribute('tab');

        value.parentNode.parentNode.querySelectorAll('.tab').forEach(value1 => {
            value1.classList.toggle("active" , value1.getAttribute('tab') === tab)

        })
    });
});