var tabCharacter = "  ";
var tabOffset = 2;
var newLines = 0;

var textAreaVar = document.getElementsByClassName("editor allow-tabs")[0];

textAreaVar.oninput = function () {
  this.style.height = "";
  this.style.height = this.scrollHeight - 38 + "px";
};

document.querySelector("#indent").addEventListener("click", (e) => {
  var thisObject = document.getElementById("indent");

  e.preventDefault();
  var self = thisObject;

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

  var thisObject = document.getElementById("fullscreen");
  var self = thisObject;

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
  while (document.readyState != "loading") {
    continue;
  }

  document.querySelector("textarea").content = "";
  document.querySelector("code").content = "";

  var firstLine = document.createElement("div");
  firstLine.className = "specific-line";
  firstLine.innerHTML = 1;

  var lineShow = document.getElementsByClassName("line-number")[0];
  lineShow.append(firstLine);

  functionToRun();
}

ready(hightlightSyntax);

/*------------------------------------------
  Capture text updates
------------------------------------------*/
function updater(event, turn) {
  var thisObject = document.getElementsByClassName("editor allow-tabs")[0];
  console.log(this)
  correctTextareaHeight(thisObject);
  hightlightSyntax();

  if (event.type == "keyup") {
    var content = document.querySelector("code").innerHTML;
    var lines = (content.match(/\n/g) || "").length;
    if (lines != newLines) {
      if (lines > newLines) {
        for (var i = newLines; i < lines; i++) {
          var toAddLine = document.createElement("div");
          toAddLine.className = "specific-line";
          toAddLine.innerHTML = i + 2;

          var lineShow = document.getElementsByClassName("line-number")[0];
          lineShow.append(toAddLine);
        }
      } else {
        var toDeleteChild = document.getElementsByClassName("specific-line");
        var lineShow = document.getElementsByClassName("line-number")[0];
        for (var i = newLines; i > lines; i--) {
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
  Run syntax hightlighter  
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

function hightlightSyntax() {
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

/*------------------------------------------
  Enable tabs in textarea
------------------------------------------*/
document.querySelector(".allow-tabs").addEventListener("keydown", function (e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode == 9) {
    e.preventDefault();

    var thisObject = document.getElementsByClassName("allow-tabs")[0];
    var start = thisObject.selectionStart;
    var end = thisObject.selectionEnd;

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
