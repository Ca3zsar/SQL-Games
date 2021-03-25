var tabCharacter = "  ";
var tabOffset = 2;

document.querySelector("#indent").addEventListener('click',e =>
{
	var thisObject = document.getElementById("indent");

	e.preventDefault();
	var self = thisObject;
	
	self.classList.toggle('active');
	
	if(self.classList.contains('active'))
	{
		tabCharacter = "\t";
		tabOffset = 1;
	}
	else
	{
		tabCharacter = "  ";
		tabOffset = 2;
	}
});

document.querySelector("#fullscreen").addEventListener('click',e =>{
	e.preventDefault();

	var thisObject = document.getElementById("fullscreen");
	var self = thisObject;
	
	self.classList.toggle('active');
	document.getElementsByClassName("editor-holder")[0].classList.toggle('fullscreen');
});

/*------------------------------------------
	Render existing code
------------------------------------------*/
function ready(functionToRun){
	while(document.readyState != 'loading'){
		continue;
	}
	console.log("CIVA");
	functionToRun();
}

ready(hightlightSyntax);

/*------------------------------------------
	Capture text updates
------------------------------------------*/
function updater()
{
	var thisObject = document.getElementsByClassName("editor allow-tabs")[0];
	correctTextareaHeight(thisObject);
	hightlightSyntax();
}

document.querySelector("textarea").addEventListener("ready",updater);
document.querySelector("textarea").addEventListener("load",updater);
document.querySelector("textarea").addEventListener("keyup",updater);
document.querySelector("textarea").addEventListener("keydown",updater);
document.querySelector("textarea").addEventListener("change",updater);

/*------------------------------------------
	Resize textarea based on content  
------------------------------------------*/
function correctTextareaHeight(element)
{
  var self = document.querySelector("textarea");
  var outerHeight = self.outerHeight;
  var innerHeight = window.getComputedStyle(self).scrollheight;
  var borderTop = parseFloat( window.getComputedStyle(self).borderTopWidth);
  var borderBottom = parseFloat( window.getComputedStyle(self).borderBottomWidth);
  var combinedScrollHeight = innerHeight + borderTop + borderBottom;
  
  if(outerHeight < combinedScrollHeight )
  {
    self.height(combinedScrollHeight);
  }
}

/*------------------------------------------
	Run syntax hightlighter  
------------------------------------------*/
function highlightBlock(block){
	if([" select "].indexOf(block.innerHTML) >= 0)
	{
		console.log("ALTCEVA");
		var newSpan = document.createElement("span");
		newSpan.style.color = "red";
		newSpan.innerHTML = block.innerHTML;

		var code = document.getElementsByClassName("syntax-highlight html")[0];
		code.append(newSpan);
	}
}

function hightlightSyntax(){
	var me  = document.getElementsByClassName('editor')[0];
	var content = me.value;
	var codeHolder = document.querySelector("code");
	var escaped = escapeHtml(content);
	
	codeHolder.innerHTML=escaped;
	
	document.querySelectorAll('.syntax-highlight').forEach(
		block=>{
			highlightBlock(block);
		}
	);

	// $('.syntax-highlight').each(function(i, block) {
	// 	hljs.highlightBlock(block);
	// });
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
document.querySelector(".allow-tabs").addEventListener('keydown',function(e){	
	var keyCode = e.keyCode || e.which;
	if (keyCode == 9) {
		e.preventDefault();
		
		var thisObject = document.getElementsByClassName("allow-tabs")[0];
		var start = thisObject.selectionStart;
		var end = thisObject.selectionEnd;

		// set textarea value to: text before caret + tab + text after caret
		thisObject.value=thisObject.value.substring(0, start)
								+ tabCharacter
								+ thisObject.value.substring(end);

		// put caret at right position again
		thisObject.selectionStart =
		thisObject.selectionEnd = start + tabOffset;
	}
});
