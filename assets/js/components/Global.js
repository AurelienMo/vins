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
        $('.contact, .registration').on('click', function (e) {
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
        $(document).on('submit', '.ajaxForm', function(e) {
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
                    console.log(response);
                    if (response.url) {
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
        $('body').on('change', '#contact_subject', function (e) {
            let orderField = $('#ordernumberinput');
            if ($(this).val() === 'Suivi de commande') {
                if (orderField.hasClass('d-none')) {
                    console.log('has follow');
                    orderField.removeClass('d-none')
                }
                console.log('not has follow')
            } else {
                if (!orderField.hasClass('d-none')) {
                    console.log('not has');
                    orderField.addClass('d-none');
                }
                console.log('has');
            }
        })
    }
}
