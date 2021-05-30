const compactButton = document.getElementById("compact");
const extendedButton = document.getElementById("extended");
let compact = '';

compactButton.addEventListener("click", function () {
    let requirements = document.querySelectorAll(".exercise-wrapper");
    if (requirements.length > 0) {
        if (!requirements[0].classList.contains("compact")) {
            compact = ' compact';
            for (let i = 0, len = requirements.length; i < len; i = i + 1 | 0) {
                requirements[i].classList.toggle("compact", true);
            }
        }
    }
}, false);

extendedButton.addEventListener("click", function () {
    let requirements = document.querySelectorAll(".exercise-wrapper");
    if (requirements.length > 0) {
        if (requirements[0].classList.contains("compact")) {
            compact = '';
            for (let i = 0, len = requirements.length; i < len; i = i + 1 | 0) {
                requirements[i].classList.toggle("compact");
            }
        }
    }
}, false);