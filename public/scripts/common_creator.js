let navbar = document.querySelector("header");
let heightValue = window.getComputedStyle(navbar).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions() {
    let navbar = document.querySelector("header")
    let navHeight = navbar.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top = navHeight + "px";
}

let condition = window.matchMedia("(max-width:800px)");
modifyDimensions();
condition.addEventListener("change", modifyDimensions);

const range = document.querySelector(".slider");
const bubble = document.querySelector(".bubble");


range.addEventListener("input", () => {
    setBubble(range, bubble);
});
setBubble(range, bubble);

function setBubble(range, bubble) {
    const val = range.value;
    bubble.innerHTML = val + " coins";
}

let textAreaVar = document.getElementsByClassName("editor")[0];

textAreaVar.oninput = function () {
    this.style.height = "";
    this.style.height = this.scrollHeight - 38 + "px";
};


function ready(functionToRun) {
    while (document.readyState !== "loading") {
    }

    document.querySelector(".editor").content = "";
    document.querySelector("code").content = "";

    functionToRun();
}

ready(highlightSyntax);

/*------------------------------------------
  Capture text updates
------------------------------------------*/
function updater(event, turn) {
    let thisObject = document.getElementsByClassName("editor")[0];
    correctTextareaHeight(thisObject);
    highlightSyntax();
}

document.querySelector(".editor").addEventListener("ready", updater);
document.querySelector(".editor").addEventListener("load", updater);
document.querySelector(".editor").addEventListener("keyup", updater);
document.querySelector(".editor").addEventListener("keydown", updater);
document.querySelector(".editor").addEventListener("change", updater);

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
  Run syntax highlighter
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

function highlightSyntax() {
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

textAreaVar.focus();

document.getElementsByClassName("reset-button")[0].addEventListener("click", () => {
    let textCode = document.getElementsByClassName("syntax-highlight")[0];
    let textAreaElement = document.getElementsByTagName("textarea")[0];

    textCode.innerHTML = "";
    textAreaElement.value = "";
});

document.getElementsByClassName("reset-button")[0].addEventListener("click", () => {
    let textCode = document.getElementsByClassName("syntax-highlight")[0];
    let textAreaElement = document.getElementsByClassName("editor")[0];

    textCode.innerHTML = "";
    textAreaElement.value = "";
});

document.querySelector(".verify-button").addEventListener("click", (event) => {
    event.preventDefault();
    let request = new XMLHttpRequest();
    request.open("POST", "http://localhost:8201/solver.php");

    request.onreadystatechange = function () {

        if (this.readyState === 4 && this.status === 200) {
            let type = request.getResponseHeader("Content-Type");

            let response = JSON.parse(request.response);

            if("errorMessage" in response)
            {
                let queryError = document.querySelector(".invalid-text.correctQuery");
                queryError.innerHTML = response.errorMessage;
                document.querySelector(".to-download").style.display = "none";
                document.querySelector(".invalid-text.correctQuery").style.display = "block";
            }else{
                let csvContent = [Object.keys(response[0]).join(',')];

                response.forEach(function (row){
                    csvContent.push(Object.values(row).join(','));
                });
                csvContent = csvContent.join('\n');

                let blob = new Blob([csvContent],{ type: 'text/csv;charset=utf-8;' });
                let fileName = "results.csv";
                document.querySelector(".to-download").style.display = "flex";

                var link = document.querySelector('#downloadButton');
                link.href = window.URL.createObjectURL(blob);

                link.download=fileName;
                document.querySelector(".invalid-text.correctQuery").style.display = "none";
            }
        }
    }

    let editorText = document.querySelector(".editor").value;
    request.send(JSON.stringify({"correctQuery": editorText}));
});

