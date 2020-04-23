import '../scss/theme.scss'
import '../scss/app.scss'
var $ = require('jquery');
global.$ = global.jQuery = $;

global.bsCustomFileInput = require('mdbootstrap/js/modules/bs-custom-file-input');
import Global from "./components/Global";
new Global();

$('.menu').on('click', function (e) {
    document.getElementById('mySidenav').style.width = '100%';
});
$('.closebtn').on('click', function (e) {
    document.getElementById('mySidenav').style.width = "0";
})