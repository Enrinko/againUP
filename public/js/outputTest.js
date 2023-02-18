function moreActions(tests) {
    let needToTests = [];
    while (tests.indexOf(' ') != -1) {
        needToTests.push(tests.substring(0, tests.indexOf(' ')));
        tests = tests.replace(tests.substring(0, tests.indexOf(' ') + 1), '');
        if (tests.indexOf(' ') == -1) needToTests.push(tests.substring(0,));
    }
    let keys = ['id', 'theme', 'question', 'type', 'rightOrNot', 'answer', 'subject_id', 'updateTimeDay', 'updateTimeTime', 'updateTime'];
    let items = [];
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

function settests(questions){
    $(document).ready(function () {
        let test = document.querySelector('.outputTest');
        let question = document.querySelector('.outputQuestion');
        let answer = document.querySelector('.questionAnswers');
        question.removeChild(answer);
        test.removeChild(question);
        test.querySelector('.themeText').innerHTML = questions[0].get('theme');
        test.querySelector('.subjectText').innerHTML = questions[0].get('subject_id');
        for (i = 0; i < questions.length; i++) {
            var newQuestion = question.cloneNode(true);
            let type = questions[i].get('type') == 1 ? 'radio' : 'checkbox';
            newQuestion.querySelector('.questionText').innerHTML = questions[i].get('question');
            newQuestion.querySelector('.hidden').setAttribute('value', questions[i].get('question'));
            let prevQuestions = document.querySelectorAll('.outputQuestion');
            let flag = true;
            for (let j = 0; j < prevQuestions.length; j++) if (prevQuestions.item(j).querySelector('.questionText').innerHTML == questions[i].get('question')) {
                let anotherAnswer = answer.cloneNode(true);
                let checkboxOrRadio = anotherAnswer.querySelector('.checkedOrNot');
                checkboxOrRadio.setAttribute('value', questions[i].get('answer'));
                type == 1 ? checkboxOrRadio.setAttribute('type', 'radio') : checkboxOrRadio.setAttribute('type', 'checkbox');
                anotherAnswer.querySelector('.answerText').innerHTML = questions[i].get('answer');
                prevQuestions.item(j).appendChild(anotherAnswer);
                flag = false;
            }
            if (flag) {
                let anotherAnswer = answer.cloneNode(true);
                let checkboxOrRadio = anotherAnswer.querySelector('.checkedOrNot');
                checkboxOrRadio.setAttribute('type', type);
                checkboxOrRadio.setAttribute('value', questions[i].get('answer'));
                anotherAnswer.querySelector('.answerText').innerHTML = questions[i].get('answer');
                newQuestion.appendChild(anotherAnswer);
                test.appendChild(newQuestion);
            }
        }
    })
}