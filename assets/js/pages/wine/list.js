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
});