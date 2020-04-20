import '../../../scss/box/list.scss'
import {hideLoader, showLoader} from "../../components/Loader";
import Modal from "../../components/Modal";

$('#detail-box').on('click', function (e) {
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

$('#add-box-to-card').on('click', function (e) {
    let valueSelect = $('#quantity-box').val();
});