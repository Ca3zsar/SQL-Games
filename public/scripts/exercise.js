const navbar = document.querySelector("header");
const heightValue = window.getComputedStyle(navbar).height;
let exerciseId = window.location.pathname.replace("\/exercises\/", "");

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

function getCorrectSize() {
    let outerHeight = window.outerHeight;
    let pageHeight = window.innerHeight;

    if (pageHeight < outerHeight) {
        document.body.style.height = "93.35vh";
    } else {
        document.body.style.height = "auto";
    }
}
window.onresize = getCorrectSize;
document.addEventListener('DOMContentLoaded',getCorrectSize,false);

async function buyExercise()
{
    let request = new XMLHttpRequest();
    request.open('POST',window.location.pathname,true);
    request.responseType = 'json';

    let dataToSend = new FormData();
    dataToSend.append("buy","yes");
    dataToSend.append("exerciseId",exerciseId);

    request.onreadystatechange = function () {
        let errorText;
        let wrapper;
        let coinsTexts;
        let buyButton;
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            if ("errorCode" in response && response.errorCode!='') {
                errorText = document.querySelector(".buy-text");
                errorText.innerHTML = "You don't have enough eSQLids to buy this!";

                buyButton = document.querySelector('.buy');
                if (buyButton.classList.contains('can-buy')) {
                    buyButton.classList.toggle('can-buy');
                    buyButton.classList.toggle('cant-buy')
                }
            } else {
                wrapper = document.querySelector(".editor-wrapper");
                wrapper.innerHTML = response["exerciseEditor"];

                var script = document.createElement("script");
                script.setAttribute("type", "text/javascript");
                script.setAttribute("src", "/scripts/highlighter.js");
                document.getElementsByTagName("head")[0].appendChild(script);

                let exerciseStatus = document.querySelector(".exercise-status");
                exerciseStatus.classList.replace("blocked", "tried");
            }

            coinsTexts = document.querySelectorAll(".coins-value");
            coinsTexts.forEach(coinText => coinText.innerHTML = response["coins"]);

            boughtBy = document.querySelector(".bought-by");
            boughtBy.innerHTML = "bought by : " + response["boughtBy"] + " persons";

            solvedBy = document.querySelector(".solved-by");
            solvedBy.innerHTML = "solved by : " + response["solvedBy"] + " persons";

        }
    };

    request.send(dataToSend);
}

let buyButton = document.querySelector(".buy");
if(buyButton)
{
    document.querySelector(".buy").addEventListener("click", async function(e) {
        e.preventDefault();
        await buyExercise();
    });
}



  