import $ from 'jquery';
import 'foundation-sites/dist/js/foundation';
import '../scss/app.scss'
import Header from "./components/Header";
import {blank} from "./components/Validators";

$(document).foundation();

let header = new Header();
blank();

document.querySelector('body').addEventListener('submit', function (e) {
    e.preventDefault()
});

[].forEach.call(document.querySelectorAll('input'), function(el) {
    el.addEventListener('focus', function() {
        console.log('dfddd');
    })
});
