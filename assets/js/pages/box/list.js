import '../../../scss/box/list.scss'
import {hideLoader, showLoader} from "../../components/Loader";
import Modal from "../../components/Modal";
import $ from "jquery";

$('.detail-box-to-show').on('click', function (e) {
    e.preventDefault();
    let modal = new Modal();
    showLoader();
    $.ajax({
        method: 'GET',
        url: $(this).attr('href'),
        success: function (response) {
            $('.detail-modal-multi').find('.modal-body').html(response.html);
            hideLoader();
            $('.detail-modal-multi').modal('toggle');

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
    let qtyContainer = $('.box_'+$(this).data('box-id')).find('select');
    let valueSelect = qtyContainer.val();
    let url = $(this).attr('href');
    if (valueSelect > 0 || valueSelect != null) {
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