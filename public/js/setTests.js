function setTests(tests) {
    let typeOfUser = localStorage.getItem('user');
    let addNewTest = document.querySelector('.AddnewTest');
    let needToTests = [];
    while (tests.indexOf(' ') != -1) {
        needToTests.push(tests.substring(0, tests.indexOf(' ')));
        tests = tests.replace(tests.substring(0, tests.indexOf(' ') + 1), '');
        if (tests.indexOf(' ') == -1) needToTests.push(tests.substring(0,));
    }
    let parentTests = document.querySelector('.listOfTests');
    parentTests.removeChild(addNewTest);
    let newTest = document.querySelector('.newTest');
    let allTests = parentTests.querySelectorAll('.newTest');
    allTests.length > 1 ? allTests.forEach(el => parentTests.removeChild(el)) : parentTests.removeChild(allTests.item(0));
    for (i = 0; i < needToTests.length; i++) {
        let newElement = document.createElement('li'); /* Создаём новый <div>. На странице его ещё нет */
        newElement.classList.add('newTest');
        let sameQuestion = newTest;
        newElement.innerHTML = sameQuestion.innerHTML;
        typeOfUser == 0 ? newElement.querySelector('.test-form').removeChild(newElement.querySelector('.needToCheck')) : "";
        needToTests[i] = [needToTests[i].substring(0, needToTests[i].indexOf('-')), needToTests[i].substring(needToTests[i].indexOf('-') + 1)];
        let item = needToTests[i];
        newElement.querySelector('.subject').innerHTML = item[0];
        newElement.querySelector('.theme').innerHTML = item[1];
        console.log(getCookie(item[1]));
        getCookie(item[1]) != undefined ? newElement.querySelector('.score').innerHTML = getCookie(item[1]) : newElement.querySelector('.test-ul').removeChild(newElement.querySelector('.score'));
        parentTests.appendChild(newElement);
    }
    typeOfUser == 0 ? "" : parentTests.appendChild(addNewTest);
}

function getCookie(name) {
    let matches = document.cookie.match(new RegExp("(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function sortBySomething(tests) {
    let sortItem = document.getElementById('subject').value;
    createCookie('sort', sortItem);
    alert('Обновите страницу!');
}

function createCookie(name, value) {
    document.cookie = escape(name) + "=" + escape(value) + "; path=/";
    ;
}

function redirectTest(button, parent) {
    console.log(parent);
    window.location.replace('/kursovaya/.idea/sites/' + button + (parent != null ? ("?theme='" + parent.querySelector('.theme').innerText + "'") : ""));
}