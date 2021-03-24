// var node = document.getElementById('mainpage-sql-area')
// node.addEventListener('input', modifyColor);

var reservedKeywords = ['select', 'from', 'where', 'group by', 'join', 'on'];

var globalLength = 0;

//seteaza cursorul la finalul comenzii(fara asta pune cursorul la inceputul cuvantului cu fiecare litera).
function setCursor() {
    let el = document.getElementById('mainpage-sql-area');

    let range = document.createRange();
    range.selectNodeContents(el);
    range.collapse(false);
    let sel = window.getSelection();

    sel.removeAllRanges();
    sel.addRange(range);
}


//cand gaseste cuvinte rezervate le pune in <span> si le schimba culoarea
function modifyColor() {
    let textInput = document.getElementById("mainpage-sql-area");

    let value = textInput.textContent;

    let words = value.split(' ');

    let finalValue = '';

    for (let i = 0; i < words.length; i++) {
        if (reservedKeywords.includes(words[i])) {
            words[i] = "<span id='reservedKeyword'>" + words[i] + "</span>"
        }
        finalValue = finalValue + (words[i] + ' ');
    }

    globalLength = value.length;

    value = textInput.innerHTML = finalValue;
}


