
var banner = document.querySelector(".banner-area");
var heightValue = window.getComputedStyle(banner).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions(condition)
{
    if(condition.matches){
        document.getElementsByClassName("dropdown-content")[0].style.width="100vw";
    }else{
        document.getElementsByClassName("dropdown-content")[0].style.width="260px";
        document.getElementsByClassName("dropdown-content")[0].style.max_width="none";
    }

    var navbar = document.querySelector("header")
    var navHeight = navbar.offsetHeight;
    document.getElementsByClassName("banner-area")[0].style.top=navHeight+"px";

    var banner = document.querySelector(".banner-area");
    var heightValue = banner.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top = (heightValue+navHeight)+"px"; 
}

var condition = window.matchMedia("(max-width:800px)");
modifyDimensions(condition);
condition.addEventListener("change",modifyDimensions);