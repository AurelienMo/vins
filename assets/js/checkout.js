import '../scss/checkout.scss'
import {showLoader, hideLoader} from "./components/Loader";

// Tooltips Initialization
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

// Steppers
$(document).ready(function () {
    function notDisplayStripBtn () {
        let defaultBtn = document.getElementsByClassName("stripe-button-el");
        if (defaultBtn.length > 0) {
            defaultBtn[0].style.display = 'none';
        }
    }
    var navListItems = $('div.setup-panel-2 div a'),
        allWells = $('.setup-content-2'),
        allNextBtn = $('.nextBtn-2'),
        allPrevBtn = $('.prevBtn-2');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-amber').addClass('btn-blue-grey');
            $item.addClass('btn-amber');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content-2"),
            curStepBtn = curStep.attr("id"),
            prevStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        prevStepSteps.removeAttr('disabled').trigger('click');
        $(window).scrollTop(0);
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content-2"),
            curStepBtn = curStep.attr("id"),
            nextStepSteps = $('div.setup-panel-2 div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for(var i=0; i< curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                // isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepSteps.removeAttr('disabled').trigger('click');
            $(window).scrollTop(0);
    });

    $('div.setup-panel-2 div a.btn-amber').trigger('click');
    $('.entry-quantity').on('focusout', function (e) {
        let initValue = $(this).data('init-value');
        let itemId = $(this).data('item-id');
        let errorElt = $('.error_item_'+itemId);
        let url = $('table').data('url');
        if (parseInt($(this).val()) !== parseInt(initValue)) {
            showLoader();
            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'json',
                data: JSON.stringify({
                    'id': $(this).data('item-id'),
                    'actual': parseInt(initValue),
                    'new': parseInt($(this).val()),
                    'type': $(this).data('type')
                }),
                success: function (response) {
                    if (response.code == 200) {
                        window.location.replace(response.url);
                    }
                    if (response.code == 400) {
                        if (response.code_type == 'no_stock') {
                            let textError = "Stock insuffisant. " + response.available_stock + " bouteille(s) disponible(s)"
                            $(errorElt).html(textError);
                            $(errorElt).removeClass('d-none');
                        }
                        hideLoader()
                    }
                }
            })
        } else {
            if(!errorElt.hasClass('d-none')) {
                errorElt.addClass('d-none');
            }
        }
    });
    $('.remove-element').on('click', function (e) {
        e.preventDefault();
        showLoader();
        $.ajax({
            url: $(this).data('url'),
            method: 'DELETE',
            success: function (response) {
                window.location.replace(response.url);
            },
            error: function () {
                hideLoader();
            }
        })
    })
    $('.mdb-select').materialSelect();
    $(document).on('submit', '.valid-delivery', function (e) {
        e.preventDefault();
        let target = $(e.target);
        let validDelivery = $('.define-delivery');
        let updateDelivery = $('.update-delivery');
        showLoader();
        $.ajax({
            url: target.attr('action'),
            type: 'POST',
            data: target.serialize(),
            cache: false,
            success: function (response) {
                let containerPayment = $('#container-button').find('#container-payment');
                if (containerPayment.length === 0) {
                    $('#container-button').append(response.html);
                    notDisplayStripBtn();
                }
                if (updateDelivery.hasClass('d-none')) {
                    updateDelivery.removeClass('d-none');
                }
                if (!validDelivery.hasClass('d-none')) {
                    validDelivery.addClass('d-none');
                }
                hideLoader();
            },
            error: function (item, a, b) {
            }
        })
    });
    notDisplayStripBtn();
});