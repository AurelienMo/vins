import '../scss/theme.scss'
import '../scss/app.scss'
var $ = require('jquery');
global.$ = global.jQuery = $;
import popper from 'popper.js';
global.popper = global.Popper = popper;
import 'mdbootstrap/js/bootstrap.min.js';

//import 'mdbootstrap-pro/css/mdb.min.css';

//global.bsCustomFileInput = require('mdbootstrap/js/modules/vendor/bs-custom-file-input');
// import 'mdbootstrap/js/mdb.min.js';
import Global from "./components/Global";
new Global();
