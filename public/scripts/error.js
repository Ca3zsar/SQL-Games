const navbar = document.querySelector("header");
const heightValue = window.getComputedStyle(navbar).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions()
{
    const navbar = document.querySelector("header");
    const navHeight = navbar.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top=navHeight+"px";
}

const condition = window.matchMedia("(max-width:800px)");
modifyDimensions();
condition.addEventListener("change",modifyDimensions);