import '../../../scss/box/list.scss'
import {hideLoader, showLoader} from "../../components/Loader";
import Modal from "../../components/Modal";

$('.detail-box-to-show').on('click', function (e) {
    e.preventDefault();
    let modal = new Modal();
    showLoader();
    $.ajax({
        method: 'GET',
        url: $(this).attr('href'),
        success: function (response) {
            modal.html('bottom-center-modal', response.html);
            hideLoader();
            modal.toggle('bottom-center-modal');
        },
        error: function (response) {
            hideLoader();
        }
    })
});
$('.quantity-box').on('change', function (e) {
    if (parseInt($(this).val()) > 0) {
        $(this).css('border', 'inherit');
    }
})
$('.detail-box-to-add').on('click', function (e) {
    e.preventDefault();
    let qtyContainer = $(this).find('.quantity-box');
    let valueSelect = parseInt(qtyContainer.val());
    let url = $(this).attr('href');
    if (valueSelect <= 0) {
        $(qtyContainer).css('border', '2 px solid red');
    } else {
        showLoader();
        let existWarnings = $('.out_of_stock');
        existWarnings.remove();
        $('#main-container').css('padding-top', '60px');
        $.ajax({
            method: 'POST',
            url: url,
            data: JSON.stringify({'quantity': valueSelect}),
            success: function (response) {
                hideLoader();
                if (response.code === 400) {
                    switch (response.type) {
                        case 'bad_request':
                            $('#quantity-box').css('border', '2px solid red')
                            break;
                        case 'out_of_stock':
                            $('#main-container').css('padding-top', 0);
                            $('#main-container').prepend(response.message);
                            break;
                    }
                } else {
                    let eltsCount = document.getElementById('counter-items');
                    $(eltsCount).html(response.qtyadd)
                }
            }
        })
    }
});