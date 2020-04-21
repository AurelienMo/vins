import '../../../scss/wine/list.scss'
import {hideLoader, showLoader} from "../../components/Loader";
import Modal from "../../components/Modal";

$(function() {
    $('.detail-wine').on('click', function (e) {
        e.preventDefault();
        let modal = new Modal();
        showLoader();
        $.ajax({
            url: $(this).data('url'),
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                modal.html('bottom-center-modal', response.html);
                hideLoader();
                modal.toggle('bottom-center-modal');
            }
        })
    });
    $('.add-to-cart').on('click', function (e) {
        e.preventDefault();
        let modal = new Modal();
        showLoader();
        $.ajax({
            url: $(this).data('url'),
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                modal.html('add-product-to-cart', response.html);
                hideLoader();
                modal.toggle('add-product-to-cart');
            }
        })
    });
    $(document).on('submit', '.addWineCart', function (e) {
        e.preventDefault();
        showLoader();
        let modal = new Modal();
        let target = $(e.target);
        let eltsCount = document.getElementById('counter-items');

        $.ajax({
            type: 'POST',
            url: target.attr('action'),
            data: target.serialize(),
            cache: false,
            success: function (response) {
                hideLoader();
                let newValue = response.qtyadd;
                $(eltsCount).html(newValue);
                let textValid = $(modal.addItemToCart).find('.valid-add');
                if (textValid.length === 0) {
                    if (response.html === "<div class=\"valid-add text-center\">Panier mis à jour</span></div>") {
                        $(modal.addItemToCart).find('.modal-body').prepend(response.html);
                    } else {
                        $(modal.addItemToCart).find('.modal-content').html(response.html);
                    }
                }
            }
        })
    });
});
