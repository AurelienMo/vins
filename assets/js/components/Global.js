import Modal from "./Modal";
import {showLoader, hideLoader} from "./Loader";

const modal = new Modal();

export default class Global {

    constructor() {
        this.initEvents();
    }

    initEvents() {
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
        $(document).on('submit', 'form', function(e) {
            e.preventDefault();
            showLoader();
            let modal = new Modal();
            let target = $(e.target);
            $.ajax({
                type: "POST",
                url: target.attr('action'),
                data: target.serialize(),
                cache: false,
                success: function (response) {
                    if (response.url) {
                        console.log('toto');
                        window.location.replace(response.url);
                    }
                    hideLoader();
                    modal.html('bottom-modal', response.html);
                },
                error: function (jqXHR) {
                    hideLoader();
                    modal.html('bottom-modal', JSON.parse(jqXHR.responseText).html);
                }
            });
        })
    }
}