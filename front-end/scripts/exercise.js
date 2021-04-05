var navbar = document.querySelector("header");
var heightValue = window.getComputedStyle(navbar).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions(condition)
{
    var navbar = document.querySelector("header")
    var navHeight = navbar.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top=navHeight+"px";
}

var condition = window.matchMedia("(max-width:800px)");
modifyDimensions(condition);
condition.addEventListener("change",modifyDimensions);

document.getElementsByClassName("exercise-status")[0].classList.toggle("blocked");

document.querySelector(".submit-button").addEventListener("click", (e) => {
    e.preventDefault();
    var status = document.getElementsByClassName("exercise-status")[0];
    if(status.classList.contains("blocked")){
        status.classList.toggle("blocked");
        status.classList.toggle("tried");
    } 
    else{
        if(status.classList.contains("tried"))
        {
            status.classList.toggle("tried");
            status.classList.toggle("solved");
        }
    }
});
  