var compactButton = document.getElementById("compact");
var extendedButton = document.getElementById("extended");

compactButton.addEventListener("click",function(){
    var requirements = document.getElementsByClassName("exercise-wrapper");
    if(!requirements[0].classList.contains("compact"))
    {
        for(var i=0, len=requirements.length;i<len;i=i+1|0)
        {
            requirements[i].classList.toggle("compact",true);
        }
    }
},false);

extendedButton.addEventListener("click",function(){
    var requirements = document.getElementsByClassName("exercise-wrapper");
    if(requirements[0].classList.contains("compact"))
    {
        for(var i=0, len=requirements.length;i<len;i=i+1|0)
        {
            requirements[i].classList.toggle("compact");
        }
    }
},false);