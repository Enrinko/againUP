function moreActions(tests) {
    var needToTests = [];
    while (tests.indexOf(' ') != -1) {
        needToTests.push(tests.substring(0, tests.indexOf(' ')));
        tests = tests.replace(tests.substring(0, tests.indexOf(' ') + 1), '');
        if (tests.indexOf(' ') == -1) needToTests.push(tests.substring(0,));
    }
    var keys = ['id', 'theme', 'question', 'type', 'rightOrNot', 'answer', 'subject_id', 'updateTimeDay', 'updateTimeTime', 'updateTime'];
    var items = [];
    let count = 0;
    let map = new Map();
    for (let i = 0; i < needToTests.length; i++) {
        map.set(keys[i % 9], needToTests[i]);
        if (i % 9 == 8) {
            map.set(keys[9], map.get(keys[7]) + " " + map.get(keys[8]));
            map.delete(keys[7]);
            map.delete(keys[8]);
            items.push(map);
            map = new Map();
            count++;
        }
    }
    items.length == 0 ? "" : settests(items);
}

function settests(questions) {
    $(document).ready(function () {
    var test = document.querySelector('.test');
    var question = document.querySelector('.question-with-answer');
    var answer = document.querySelector('.question-answer');
    question.removeChild(answer);
    test.removeChild(question);
    test.querySelector('#theme').setAttribute('value', questions[0].get('theme'));
    var subjectList = test.querySelectorAll('#subject option');
    for (i = 0; i < subjectList.length; i++) {
        let item = subjectList.item(i).value;
        if (item == questions[0].get('subject_id') - 1) {
            subjectList.item(i).setAttribute('selected', 'selected');
            break;
        }
    }
    for (i = 0; i < questions.length; i++) {
        var newQuestion = question.cloneNode(true);
        newQuestion.querySelector('.multi').value == questions[i]['type'] ? newQuestion.querySelector('.multi').setAttribute('checked', 'checked') : newQuestion.querySelector('.only').setAttribute('checked', 'checked');
        newQuestion.querySelector('.question-text').setAttribute('value', questions[i].get('question'));
        let prevQuestions = document.querySelectorAll('.question-with-answer');
        let flag = true;
        for (let j = 0; j < prevQuestions.length; j++) if (prevQuestions.item(j).querySelector('.question-text').value == questions[i].get('question')) {
            let anotherAnswer = answer.cloneNode(true);
            anotherAnswer.querySelector('.right').setAttribute('value', questions[i].get('rightOrNot'));
            anotherAnswer.querySelector('.answer-text').setAttribute('value', questions[i].get('answer'));
            prevQuestions.item(j).appendChild(anotherAnswer);
            flag = false;
        }
        if (flag) {
            let anotherAnswer = answer.cloneNode(true);
            anotherAnswer.querySelector('.right').setAttribute('value', questions[i].get('rightOrNot'));
            anotherAnswer.querySelector('.answer-text').setAttribute('value', questions[i].get('answer'));
            newQuestion.appendChild(anotherAnswer);
            test.appendChild(newQuestion);
        }
    }
})
}
