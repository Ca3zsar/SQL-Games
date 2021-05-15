let navbar = document.querySelector("header");
let heightValue = window.getComputedStyle(navbar).height;
document.getElementsByClassName("content-area")[0].style.top = heightValue;

function modifyDimensions()
{
    var navbar = document.querySelector("header")
    var navHeight = navbar.offsetHeight;
    document.getElementsByClassName("content-area")[0].style.top=navHeight+"px";
}

var condition = window.matchMedia("(max-width:800px)");
modifyDimensions();
condition.addEventListener("change",modifyDimensions);

const button = document.getElementsByClassName("submit-button")[0];
const infoForm = document.getElementById("complete-form");
button.addEventListener('click',async function (event){
    event.preventDefault();
    const formData = new FormData(infoForm);

    classNames = ["title","correctQuery","requirement"];

    let request = new XMLHttpRequest();
    request.open('POST', 'exercise_creator');
    request.responseType = 'json';

    request.onreadystatechange = function() {
        let errorClass;
        if (this.readyState === 4 && this.status === 200) {
            let response = request.response;
            if ("errors" in response || response.errors.length === 0) {
                window.location.replace("/");
            } else {
                for (let key of classNames) {
                    let classname = 'invalid-text ' + key;
                    errorClass = document.getElementsByClassName(classname)[0];
                    if(key in response.errors)
                    {
                        errorClass.innerHTML = response.errors[key][0];
                    }else{
                        errorClass.innerHTML = '';
                    }
                }
            }
        }

    };

    request.send(formData);
});


const range = document.querySelector(".slider");
const bubble = document.querySelector(".bubble");

range.addEventListener("input", () => {
    setBubble(range, bubble);
});
setBubble(range, bubble);

function setBubble(range, bubble) {
    let slider = document.getElementsByClassName('slider')[0];
        const val = range.value;
        bubble.innerHTML = val+" coins";
}

var newLines = 0;

var textAreaVar = document.getElementsByClassName("editor")[0];

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
    var thisObject = document.getElementsByClassName("editor")[0];
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
    var self = document.querySelector("textarea");
    var outerHeight = self.outerHeight;
    var innerHeight = window.getComputedStyle(self).scrollheight;
    var borderTop = parseFloat(window.getComputedStyle(self).borderTopWidth);
    var borderBottom = parseFloat(
        window.getComputedStyle(self).borderBottomWidth
    );
    var combinedScrollHeight = innerHeight + borderTop + borderBottom;

    if (outerHeight < combinedScrollHeight) {
        self.height(combinedScrollHeight);
    }
}

/*------------------------------------------
  Run syntax highlighter
------------------------------------------*/
function highlightBlock(block) {
    if (["select"].indexOf(block.innerHTML) >= 0) {
        var newSpan = document.createElement("span");
        newSpan.style.color = "red";
        newSpan.innerHTML = block.innerHTML;

        block.innerHTML = "";

        var code = document.getElementsByClassName("syntax-highlight html")[0];
        code.append(newSpan);
    }
}

function highlightSyntax() {
    var me = document.getElementsByClassName("editor")[0];
    var content = me.value;
    var codeHolder = document.querySelector("code");
    var escaped = escapeHtml(content);

    codeHolder.innerHTML = escaped;

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
    let line = document.getElementsByClassName("specific-line");
    let lineNumber = document.getElementsByClassName("line-number")[0].childElementCount;

    textCode.innerHTML = "";
    textAreaElement.value = "";

    for (let i = lineNumber - 1; i > 0; i--) {
        line[i].remove();
    }

    newLines = 0;
});