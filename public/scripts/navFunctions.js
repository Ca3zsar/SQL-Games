function displayOptions()
{
    var navbar = document.getElementsByClassName('right-nav')[0];
    navbar.classList.toggle('show');
}

function displayDrop(event)
{
    event.preventDefault();
    var dropbtn = document.getElementsByClassName("dropbtn")[0];
    var drop = document.getElementsByClassName("dropdown-content")[0];

    if(dropbtn.classList.contains("active"))
    {
        drop.style.display="none";
        dropbtn.classList.remove("active");
    }else{
        drop.style.display="block";
        dropbtn.classList.add("active");
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var button = document.getElementsByClassName("dropbtn")[0];
    button.addEventListener("click",function(event){
        displayDrop(event);
    },false);
    
 }, false);

