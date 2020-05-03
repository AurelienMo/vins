import '../../../scss/wine/list.scss'
import {hideLoader, showLoader} from "../../components/Loader";
import Modal from "../../components/Modal";
import $ from "jquery";

$(function() {
    $('.detail-wine').on('click', function (e) {
        e.preventDefault();
        showLoader();
        $.ajax({
            url: $(this).data('url'),
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                $('.detail-modal-multi').find('.modal-body').html(response.html);
                hideLoader();
                $('.detail-modal-multi').modal('toggle');
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
        console.log('toto');
        e.preventDefault();
        showLoader();
        let modal = new Modal();
        let target = $(e.target);
        let counter = $('.count-items');
        $.ajax({
            type: 'POST',
            url: target.attr('action'),
            data: target.serialize(),
            cache: false,
            success: function (response) {
                hideLoader();
                let newValue = response.qtyadd;
                $(counter).each(function (i, val) {
                    $(val).html(newValue);
                })
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
$(document).ready(function() {
    $('.mdb-select').materialSelect();
});