import $ from 'jquery';
import 'bootstrap';
import '../scss/app.scss'
import Modal from "./components/Modal";


$('.test-link').on('click', function (e) {
    let modal = new Modal();
    console.log(modal);
    e.preventDefault();
    modal.html('bottom-modal', '<h1>Mon super titre modal</h1>');
    modal.toggle('bottom-modal');
});
