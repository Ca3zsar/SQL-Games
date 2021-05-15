let filter = '';
let orderBy = '&orderBy=popularity';
let currentPage = new URLSearchParams(window.location.search).get('page');

async function loadExercises(url) {
    let request = new XMLHttpRequest();
    request.open('GET', url + "&fromJS=1", true);
    request.responseType = 'json';

    let exerciseList = document.getElementsByClassName("exercise-list")[0];

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            while (exerciseList.hasChildNodes()) {
                exerciseList.removeChild(exerciseList.lastChild);
            }
            for (let exercise in response) {
                if (response.hasOwnProperty(exercise)) {

                    let exerciseWrapper = document.createElement("div");
                    exerciseWrapper.className = 'exercise-wrapper' + compact;

                    let buttonText = response[exercise].price + ' eSQLids';

                    let exerciseStatus;
                    if (response[exercise].solved == -2) {
                        exerciseStatus = "blocked";
                    } else if (response[exercise].solved == -1) {
                        exerciseStatus = "to-buy";
                    } else if (response[exercise].solved == 0) {
                        exerciseStatus = "to-solve";
                        buttonText = "Solve exercise";

                    } else if (response[exercise].solved == 1) {
                        exerciseStatus = "solved";
                        buttonText = "Solved"
                    }

                    exerciseWrapper.innerHTML =
                        '<div class="exercise-requirement">\n' +
                        '            <div class="requirements">\n' +
                        '                <div class="meta-info">\n' +
                        '                    <div class="difficulty-wrapper">\n' +
                        '                        <p class="difficulty-title">Difficulty:</p>\n' +
                        '                        <img\n' +
                        '                            class="difficulty-bar"\n' +
                        '                            src="resources/images/difficulty_' + response[exercise].difficulty + '.png"\n' +
                        '                            alt="difficulty"\n' +
                        '                        />\n' +
                        '                    </div>\n' +
                        '                    <h3 class="exercise-author">by ' + response[exercise].authorName + '</h3>\n' +
                        '                </div>\n' +
                        '                <br class="meta-break" />\n' +
                        '                <div class="title-holder">\n' +
                        '                    <a href="/exercises/' + response[exercise]["id"] + '" class="exercise-title">#' + response[exercise].id + ' ' + response[exercise].title + '</a>\n' +
                        '                </div>\n' +
                        '                <div\n' +
                        '                    itemscope\n' +
                        '                    itemtype="http://schema.org/Product"\n' +
                        '                    class="exercise-content"\n' +
                        '                >\n' +
                        '                    <div itemprop="description" class="requirement-text">\n' +
                        '                        ' + response[exercise].requirement +
                        '                    </div>\n' +
                        '                    <div class="exercise-statistics">\n' +
                        '                        <p>\n' +
                        '                            Difficulty : <span class="difficulty-span ' + response[exercise].difficulty + '">'
                        + response[exercise].difficulty.charAt(0).toUpperCase() + response[exercise].difficulty.slice(1) +
                        '</span>\n' +
                        '                        </p>\n' +
                        '                        <p>Solved by : ' + response[exercise].timesSolved + '</p>\n' +
                        '                    </div>\n' +
                        '                    <div class="solve-button-div">\n' +
                        '                        <a\n' +
                        '                            itemprop="offers"\n' +
                        '                            itemscope\n' +
                        '                            itemtype="http://schema.org/Offer"\n' +
                        '                            class="exercise-button ' + exerciseStatus + '"\n' +
                        '                            href="/exercises/' + response[exercise]["id"] + '"\n' +
                        '                        >\n' +
                        '                            ' + buttonText +
                        '                        </a>\n' +
                        '                    </div>\n' +
                        '                </div>\n' +
                        '            </div>\n' +
                        '        </div>'
                    exerciseList.appendChild(exerciseWrapper);
                }
            }
        }
    };
    request.send();
}

const pageButtons = document.querySelectorAll(".page-buttons button");

function changeButtonValues() {
    let buttonIndex = currentPage - 1;
    console.log(buttonIndex);
    pageButtons.forEach(function (tempPageButton) {
        tempPageButton.innerHTML = buttonIndex;
        if (buttonIndex === 0) {
            tempPageButton.style.display = 'none';
        } else {
            tempPageButton.style.display = 'block';
        }
        buttonIndex += 1;
    });
}

document.addEventListener('DOMContentLoaded', function () {
    let parameters = window.location.search.substr(1);
    parameters = parameters.split("&");
    const keyValue = {};
    for (let i = 0; i < parameters.length; i++) {
        const temparr = parameters[i].split("=");
        keyValue[temparr[0]] = temparr[1];
    }
    if ("page" in keyValue) {
        if (parseInt(keyValue.page)) {
            loadExercises("shop?page=" + keyValue.page + filter + orderBy);
        } else {
            currentPage = 1;
            loadExercises("shop?page=1" + filter + orderBy);
        }
    } else {
        currentPage = 1;
        loadExercises("shop?page=1" + filter + orderBy);

    }
    changeButtonValues();
}, false);


pageButtons.forEach(function (pageButton) {
    pageButton.addEventListener("click", function () {
        loadExercises("shop?page=" + pageButton.innerHTML + filter + orderBy);
        currentPage = parseInt(pageButton.innerHTML);

        changeButtonValues();
        window.history.pushState({}, '', 'shop?page=' + currentPage);
    }, false);
});


const diffFilter = document.querySelector("#difficulty-filter");
diffFilter.addEventListener("change", function () {
    if (diffFilter.value === '') {
        filter = '';
    } else {
        filter = "&difficulty=" + diffFilter.value;
    }
    currentPage = 1;
    loadExercises("shop?page=1&" + filter + orderBy, 1);
    changeButtonValues();

}, false);

const orderFilter = document.querySelector("#order-by-filter");
orderFilter.addEventListener("change", function () {
    orderBy = "&orderBy=" + orderFilter.value;
    currentPage = 1;
    loadExercises("shop?page=1" + filter + orderBy);
    changeButtonValues();
}, false);
