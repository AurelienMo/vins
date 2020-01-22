import Modal from "./Modal";
import {showLoader, hideLoader} from "./Loader";

const modal = new Modal();

export default class Global {

    constructor() {
        this.initEvents();
    }

    initEvents() {
        $
        $('.static-call').on('click', function (e) {
            e.preventDefault();
            let modal = new Modal();
            showLoader();
            $.ajax({
                url: $(this).data('url'),
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    modal.html('bottom-modal', response.html);
                    hideLoader();
                    modal.toggle('bottom-modal');
                }
            });
        });
        $('.contact').on('click', function (e) {
            e.preventDefault();
            let modal = new Modal();
            showLoader();
            $.ajax({
                url: $(this).data('url'),
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    modal.html('bottom-modal', response.html);
                    hideLoader();
                    modal.toggle('bottom-modal');
                }
            })
        });
    }
}
