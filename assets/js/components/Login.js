import Modal from "./Modal";
import {show, hide} from './Loader';
import {send} from './APIResolver';

export const initLoginEvent = () => {
    const selectorConnect = document.querySelector('#connect');
    selectorConnect.addEventListener('click', function (e) {
        e.preventDefault();
        const modal = new Modal();
        let uri = selectorConnect.attributes.href.value;
        show();
        send(uri, 'GET')
            .then(
                data => modal.html('basic-modal', data.html)
            );
        hide();
        modal.toggle('basic-modal');
    });
};
