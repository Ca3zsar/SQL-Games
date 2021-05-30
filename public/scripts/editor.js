let exerciseId = window.location.pathname.replace("\/exercise_creator\/", "");

const button = document.getElementsByClassName("submit-button")[0];
const infoForm = document.getElementById("complete-form");
button.addEventListener('click', async function (event) {
    event.preventDefault();
    let formData = new FormData(infoForm);
    formData.append("exerciseId",exerciseId);

    let classNames = ["title", "correctQuery", "requirement"];

    let request = new XMLHttpRequest();
    request.open('POST', '/exercise_creator/'+exerciseId);
    request.responseType = 'json';

    request.onreadystatechange = function () {
        let errorClass;
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            if ("errors" in response && response.errors.length === 0) {

                window.location.replace("/");
            } else {
                for (let key of classNames) {
                    let classname = 'invalid-text ' + key;
                    errorClass = document.getElementsByClassName(classname)[0];
                    if (key in response.errors) {
                        errorClass.innerHTML = response.errors[key][0];
                    } else {
                        errorClass.innerHTML = '';
                    }
                }
            }
        }

    };
    request.send(formData);
});
