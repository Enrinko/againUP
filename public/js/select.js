/* We need this bit of JS to handle hover effects on the select. */
var select = document.querySelectorAll('.div-select'), hoverClass = 'hover';
Array.prototype.forEach.call(select, function (el, i) {
    var parent = el.parentNode;
    el.addEventListener('hover', function () {
        if (parent.classList) {
            parent.classList.add(hoverClass);
        } else {
            parent.className += ' ' + hoverClass;
        }
    });
    el.addEventListener('blur', function () {
        if (parent.classList) {
            parent.classList.remove(hoverClass);
        } else parent.className = parent.className.replace(new RegExp('(^|\\b)' + hoverClass.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
    });
});