async function loadExercises() {
    let request = new XMLHttpRequest();
    request.open('GET', 'getExercises', true);
    request.responseType = 'json';

    let exerciseList = document.getElementsByClassName("exercise-list")[0];

    request.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            console.log(response);
            for (let exercise in response) {
                var exerciseWrapper = document.createElement("div");
                exerciseWrapper.className = 'exercise-wrapper';

                let buttonText = response[exercise].price + ' eSQLids';

                let exerciseStatus;
                if(response[exercise].solved == -2)
                {
                    exerciseStatus = "blocked";
                }else if(response[exercise].solved == -1)
                {
                    exerciseStatus = "to-buy";
                }else if(response[exercise].solved == 0)
                {
                    exerciseStatus = "to-solve";
                    buttonText = "Solve exercise";

                }else if(response[exercise].solved == 1)
                {
                    exerciseStatus = "solved";
                    buttonText = "Solved"
                }

                exerciseWrapper.innerHTML=
                    '<div class="exercise-requirement">\n' +
                    '            <div class="requirements">\n' +
                    '                <div class="meta-info">\n' +
                    '                    <div class="difficulty-wrapper">\n' +
                    '                        <p class="difficulty-title">Difficulty:</p>\n' +
                    '                        <img\n' +
                    '                            class="difficulty-bar"\n' +
                    '                            src="resources/images/difficulty_'+ response[exercise].difficulty +'.png"\n' +
                    '                            alt="difficulty"\n' +
                    '                        />\n' +
                    '                    </div>\n' +
                    '                    <h3 class="exercise-author">by ' + response[exercise].authorName +'</h3>\n' +
                    '                </div>\n' +
                    '                <br class="meta-break" />\n' +
                    '                <div class="title-holder">\n' +
                    '                    <a href="/exercise" class="exercise-title">#' + response[exercise].id + ' '+response[exercise].title +'</a>\n' +
                    '                </div>\n' +
                    '                <div\n' +
                    '                    itemscope\n' +
                    '                    itemtype="http://schema.org/Product"\n' +
                    '                    class="exercise-content"\n' +
                    '                >\n' +
                    '                    <div itemprop="description" class="requirement-text">\n' +
                    '                        ' +response[exercise].requirement +
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
                    '                            class="exercise-button ' + exerciseStatus +'"\n' +
                    '                            href="/exercise"\n' +
                    '                        >\n' +
                    '                            '+ buttonText +
                    '                        </a>\n' +
                    '                    </div>\n' +
                    '                </div>\n' +
                    '            </div>\n' +
                    '        </div>'




                exerciseList.appendChild(exerciseWrapper);

                console.log(response[exercise]);
            }
        }

    };
    request.send();
}

document.addEventListener('DOMContentLoaded', loadExercises, false);