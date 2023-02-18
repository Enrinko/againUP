function add(typeOfDiv, typeOfParent, thisValue) {
    let newElement = document.createElement('div'); /* Создаём новый <div>. На странице его ещё нет */
    newElement.classList.add(typeOfDiv);
    let sameQuestion = document.querySelector('.' + typeOfDiv);
    newElement.innerHTML = sameQuestion.innerHTMLlet;
    parent = thisValue.value == 0 ? thisValue.closest('.question-with-answer') : document.querySelector('.' + typeOfParent);
    if ('question-with-answer'.localeCompare(typeOfDiv) == 0) {
        let onlyOneAnswer = document.querySelector('.question-answer');
        let allAnswers = newElement.querySelectorAll('.question-answer');
        for (let i = 0; i < allAnswers.length; i++) allAnswers.item(i).innerHTML = i == 0 ? onlyOneAnswer.innerHTML : "";
    } else {
        newElement.querySelector('.right').setAttribute('value', 0);
        newElement.querySelector('.right').setAttribute('type', parent.querySelector('.right').getAttribute('type'));
    }
    newElement.querySelectorAll('.input').forEach(el => el.setAttribute('value', ""));
    parent.appendChild(newElement); /* Добавляем сообщение в HTML */
}

function deleteSomething(thisValue) {
    let elementToDelete = thisValue.value == 0 ? thisValue.closest('.question-answer') : thisValue.closest('.question-with-answer');
    elementToDelete.parentNode.removeChild(elementToDelete);
}
