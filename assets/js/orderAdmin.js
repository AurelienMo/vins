$(function () {
    let deliveryPoint = $('.delivery-point');
    let deliveryNiche = $('.delivery-niche');
    if ($('.delivery-type select option:selected').text() === "A l'adresse") {
        deliveryNiche.removeClass('d-none');
    } else if ($('.delivery-type select option:selected'). text() === 'Point relais') {
        deliveryPoint.removeClass('d-none');
    } else {

    }
    $('.delivery-type select').on('change', function (e) {
        switch ($(this).find('option:selected').text()) {
            case 'Point relais':
                if (!deliveryNiche.hasClass('d-none')) {
                    deliveryNiche.addClass('d-none');
                }
                deliveryPoint.removeClass('d-none');
                break;
            case "A l'adresse":
                if (!deliveryPoint.hasClass('d-none')) {
                    deliveryPoint.addClass('d-none');
                }
                deliveryNiche.removeClass('d-none');
                break;
            default:
                deliveryPoint.addClass('d-none');
                deliveryNiche.addClass('d-none');
                break;
        }
    });
});
