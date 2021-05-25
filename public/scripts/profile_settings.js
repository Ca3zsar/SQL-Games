

var navbar = document.querySelector("header");
var heightValue = window.getComputedStyle(navbar).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions(condition) {
    var navbar = document.querySelector("header")
    var navHeight = navbar.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top = navHeight + "px";
}

var condition = window.matchMedia("(max-width:800px)");
modifyDimensions(condition);
condition.addEventListener("change", modifyDimensions);

const button = document.getElementById('submit-changes');
const formElement = document.querySelector('.complete-form');

button.addEventListener('click', async function (event) {
    event.preventDefault();
    let classNames = ["currentPassword", "newPassword", "confirmPassword"];
    let formData = new FormData(formElement);

    let request = new XMLHttpRequest();
    request.open('POST', '/profile_settings', true);
    request.responseType = 'json';

    request.onreadystatechange = function () {
        let errorClass;
        if (this.readyState === 4 && this.status === 200) {
            window.location.replace("/");
            for (let key of classNames) {
                let classname = 'invalid-text ' + key;
                errorClass = document.getElementsByClassName(classname)[0];
                errorClass.innerHTML = '';

            }
        }
        if (this.readyState === 4 && (this.status === 400 || this.status === 401)) {
            let response = request.response;
            for (let key of classNames) {
                let classname = 'invalid-text ' + key;
                errorClass = document.getElementsByClassName(classname)[0];
                if (key in response.errors) {
                    errorClass.innerHTML = response.errors[key][0];
                } else {
                    errorClass.innerHTML = '';
                }
            }
        }

    };

    request.send(formData);
});