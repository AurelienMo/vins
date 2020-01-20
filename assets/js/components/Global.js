import Modal from "./Modal";
import {send} from './APIResolver'
const modal = new Modal();

export default class Global {

    constructor() {
        this.initEvents();
    }

    initEvents() {
        $('.static-call').on('click', function (e) {
            e.preventDefault();
            let modal = new Modal();
            console.log(modal);
            modal.toggle('bottom-modal');
            // let response = send($(this).data('url'));
            // console.log(response);
        });
    }
}
