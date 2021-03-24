
var banner = document.querySelector(".banner-area");
var heightValue = window.getComputedStyle(banner).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions(condition)
{
    var banner = document.querySelector(".banner-area");
    var heightValue = window.getComputedStyle(banner).height;
    document.getElementsByClassName("content-area")[0].style.top = heightValue;
    
}

var condition = window.matchMedia("(max-width:800px");
modifyDimensions(condition);
condition.addEventListener("change",MediaQueryListEvent);