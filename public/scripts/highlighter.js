let tabCharacter = "  ";
let tabOffset = 2;
let newLines = 0;

const textAreaVar = document.getElementsByClassName("editor allow-tabs")[0];

textAreaVar.oninput = function () {
    this.style.height = "";
    this.style.height = this.scrollHeight - 38 + "px";
};

document.querySelector("#indent").addEventListener("click", (e) => {
    const thisObject = document.getElementById("indent");

    e.preventDefault();
    const self = thisObject;

    self.classList.toggle("active");

    if (self.classList.contains("active")) {
        tabCharacter = "\t";
        tabOffset = 1;
    } else {
        tabCharacter = "  ";
        tabOffset = 2;
    }
});

document.querySelector("#fullscreen").addEventListener("click", (e) => {
    e.preventDefault();

    const self = document.getElementById("fullscreen");

    self.classList.toggle("active");
    document
        .getElementsByClassName("editor-holder")[0]
        .classList.toggle("fullscreen");
    document.getElementsByClassName("buttons")[0].classList.toggle("fullscreen");
});

/*------------------------------------------
  Render existing code
------------------------------------------*/
function ready(functionToRun) {
    while (document.readyState !== "loading" && document.readyState !== 'complete') {

    }

    document.querySelector("textarea").content = "";
    document.querySelector("code").content = "";

    let firstLine = document.createElement("div");
    firstLine.className = "specific-line";
    firstLine.innerHTML = 1;

    let lineShow = document.getElementsByClassName("line-number")[0];
    lineShow.append(firstLine);

    functionToRun();
}

ready(hightlightSyntax);

/*------------------------------------------
  Capture text updates
------------------------------------------*/
function updater(event) {
    let lineShow;
    let thisObject = document.getElementsByClassName("editor allow-tabs")[0];
    correctTextareaHeight(thisObject);
    hightlightSyntax();

    if (event.type === "keyup") {
        let content = document.querySelector("code").innerHTML;
        let lines = (content.match(/\n/g) || "").length;
        if (lines !== newLines) {
            if (lines > newLines) {
                for (let i = newLines; i < lines; i++) {
                    let toAddLine = document.createElement("div");
                    toAddLine.className = "specific-line";
                    toAddLine.innerHTML = i + 2;

                    lineShow = document.getElementsByClassName("line-number")[0];
                    lineShow.append(toAddLine);
                }
            } else {
                let toDeleteChild = document.getElementsByClassName("specific-line");
                lineShow = document.getElementsByClassName("line-number")[0];
                for (let i = newLines; i > lines; i--) {
                    toDeleteChild[i].remove();
                }
            }
            newLines = lines;
        }
    }
}

document.querySelector("textarea").addEventListener("ready", updater);
document.querySelector("textarea").addEventListener("load", updater);
document.querySelector("textarea").addEventListener("keyup", updater);
document.querySelector("textarea").addEventListener("keydown", updater);
document.querySelector("textarea").addEventListener("change", updater);

/*------------------------------------------
  Resize textarea based on content
------------------------------------------*/
function correctTextareaHeight(element) {
    let self = document.querySelector("textarea");
    let outerHeight = self.outerHeight;
    let innerHeight = window.getComputedStyle(self).scrollheight;
    let borderTop = parseFloat(window.getComputedStyle(self).borderTopWidth);
    let borderBottom = parseFloat(
        window.getComputedStyle(self).borderBottomWidth
    );
    let combinedScrollHeight = innerHeight + borderTop + borderBottom;

    if (outerHeight < combinedScrollHeight) {
        self.height(combinedScrollHeight);
    }
}

/*------------------------------------------
  Run syntax hightlighter
------------------------------------------*/
function highlightBlock(block) {
    if (["select"].indexOf(block.innerHTML) >= 0) {
        let newSpan = document.createElement("span");
        newSpan.style.color = "red";
        newSpan.innerHTML = block.innerHTML;

        block.innerHTML = "";

        let code = document.getElementsByClassName("syntax-highlight html")[0];
        code.append(newSpan);
    }
}

function hightlightSyntax() {
    let me = document.getElementsByClassName("editor")[0];
    let content = me.value;
    let codeHolder = document.querySelector("code");
    codeHolder.innerHTML = escapeHtml(content);

    document.querySelectorAll(".syntax-highlight").forEach((block) => {
        highlightBlock(block);
    });
}

/*------------------------------------------
  String html characters
------------------------------------------*/
function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

/*------------------------------------------
  Enable tabs in textarea
------------------------------------------*/
document.querySelector(".allow-tabs").addEventListener("keydown", function (e) {
    let keyCode = e.keyCode || e.which;
    if (keyCode === 9) {
        e.preventDefault();

        let thisObject = document.getElementsByClassName("allow-tabs")[0];
        let start = thisObject.selectionStart;
        let end = thisObject.selectionEnd;

        // set textarea value to: text before caret + tab + text after caret
        thisObject.value =
            thisObject.value.substring(0, start) +
            tabCharacter +
            thisObject.value.substring(end);

        // put caret at right position again
        thisObject.selectionStart = start;
        thisObject.selectionEnd = start + tabOffset;
    }
});

textAreaVar.focus();

document.getElementsByClassName("reset-button")[0].addEventListener("click", () => {
    let textCode = document.getElementsByClassName("syntax-highlight")[0];
    let textAreaElement = document.getElementsByTagName("textarea")[0];
    let line = document.getElementsByClassName("specific-line");
    let lineNumber = document.getElementsByClassName("line-number")[0].childElementCount;

    textCode.innerHTML = "";
    textAreaElement.value = "";

    for (let i = lineNumber - 1; i > 0; i--) {
        line[i].remove();
    }

    newLines = 0;
});

document.querySelector(".edit-button").addEventListener("click",()=>{
    window.location.href = '/exercise_creator/'+exerciseId;
});

document.querySelector(".submit-button").addEventListener("click", async function (event) {
    event.preventDefault();

    let request = new XMLHttpRequest();
    request.open('POST', window.location.pathname, true);
    request.responseType = 'json';

    let dataToSend = new FormData();
    dataToSend.append("exerciseId", exerciseId);
    dataToSend.append("query", document.querySelector(".editor").value);
    dataToSend.append("solve", "1");

    request.onreadystatechange = function () {
        let errorText = document.querySelector(".exercise-message");
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            console.log(response);

            if ("errorMessage" in response) {
                errorText.innerHTML = response.errorMessage;
                errorText.style.color = "#FF0000";
            } else {
                errorText.innerHTML = response.status;
                errorText.style.color = "#FF0000";
                if (response.status == "correct") {
                    errorText.style.color = "#1AA84B";
                    if ("coins" in response) {
                        let coinsTexts = document.querySelectorAll(".coins-value");
                        coinsTexts.forEach(coinText => coinText.innerHTML = response["coins"]);
                    }

                    let tried = document.querySelector(".tried");
                    if (tried) {
                        tried.classList.replace("tried", "solved");

                        if ("starImage" in response) {
                            let dummy = document.createElement('DIV');
                            dummy.innerHTML = response["starImage"];
                            tried.appendChild(dummy.firstChild);
                        }
                    }

                }
            }
            let boughtBy = document.querySelector(".bought-by");
            boughtBy.innerHTML = "bought by : " + response["boughtBy"] + " users";

            let solvedBy = document.querySelector(".solved-by");
            solvedBy.innerHTML = "solved by : " + response["solvedBy"] + " users";

            let votedBy = document.querySelector(".voted-by");
            votedBy.innerHTML = response["stars"] + " &#9733;";
        }

    }

    request.send(dataToSend);
});
