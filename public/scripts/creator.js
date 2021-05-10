var navbar = document.querySelector("header");
var heightValue = window.getComputedStyle(navbar).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions()
{
    var navbar = document.querySelector("header")
    var navHeight = navbar.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top=navHeight+"px";
}

var condition = window.matchMedia("(max-width:800px)");
modifyDimensions();
condition.addEventListener("change",modifyDimensions);

const range = document.querySelector(".slider");
const bubble = document.querySelector(".bubble");

range.addEventListener("input", () => {
    setBubble(range, bubble);
});
setBubble(range, bubble);

function setBubble(range, bubble) {
    const val = range.value;
    const min = range.min ? range.min : 0;
    const max = range.max ? range.max : 100;
    const newVal = Number(((val - min) * 26) / (max - min));
    bubble.innerHTML = val;

    // Sorta magic numbers based on size of the native UI thumb
    bubble.style.marginLeft = `calc(${newVal}% + (${9 - newVal * 0.15}px))`;
}