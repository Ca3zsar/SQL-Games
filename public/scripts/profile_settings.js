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
const formElement = document.getElementById('complete-form');

button.addEventListener('click', async function (event) {
    event.preventDefault();
    const formData = new FormData(formElement);
    console.log(formData.entries());

    let request = new XMLHttpRequest();
    request.open('PUT', 'localhost:8123/profile_settings', true);
    request.responseType = 'json';

    request.send(formData);
});