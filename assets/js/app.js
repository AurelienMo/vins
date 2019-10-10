import $ from 'jquery';
import 'foundation-sites/dist/js/foundation';
import '../scss/app.scss'
import Header from "./components/Header";

$(document).foundation();

let header = new Header();

document.querySelector('body').addEventListener('submit', function (e) {
    e.preventDefault()
});

[].forEach.call(document.querySelectorAll('input'), function(el) {
    el.addEventListener('focus', function() {
    })
});
