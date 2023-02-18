function getTest() {
    var subject = document.getElementById('subject').value;
    var theme = document.getElementById('theme').value;
    var questions = document.getElementsByClassName('question-with-answer');
    var elements = [];
    for (let i = 0; i < questions.length; i++) {
        var thisQuestion = questions.item(i);
        var answers = thisQuestion.getElementsByClassName('question-answer');
        for (let j = 0; j < answers.length; j++) {
            let answer = answers.item(j);
            let map = [];
            map.push(subject);
            map.push(theme);
            map.push(thisQuestion.querySelector('.question-text').value);
            map.push(typeOf.get(thisQuestion));
            map.push(answer.querySelector('.right').value);
            map.push(answer.querySelector('.answer-text').value);
            elements.push(map);
            map = [];
        }
    }
    alert("тест успешно добавлен!");
    return elements;
}

function toPHP() {
    console.log("");
    createCookie('s', getTest());
}

function createCookie(name, value) {
    console.log("");
    document.cookie = escape(name) + "=" + escape(value) + "; path=/";/*Тебе не надо*/
}

var typeOf = new Map();

function checkTypes(thisValue, parentValue) {
    typeOf.set(parentValue, thisValue);
    let rightsInside = parentValue.querySelectorAll('.right');
    if (typeOf.get(parentValue) == 1) {
        rightsInside.forEach(el => el.setAttribute('type', 'radio'));
    } else rightsInside.forEach(el => el.setAttribute('type', 'checkbox'));
}

function setRight(thisValue) {
    console.log("");
    thisValue.setAttribute('value', 1);
}
