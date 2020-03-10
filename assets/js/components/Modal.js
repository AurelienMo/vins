import $ from "jquery";

export const BOTTOM_MODAL = 'bottom-modal';

export default class Modal {
    bottomModal;
    centerBottomModal;
    addItemToCart;

    constructor() {
        this.onLoad();
    }

    onLoad() {
        this.bottomModal = document.getElementById('bottom-modal');
        this.centerBottomModal = document.getElementById('bottom-center-modal');
        this.addItemToCart = document.getElementById('add-product-to-cart');
    }

    toggle = (id) => {
        switch (id) {
            case 'bottom-modal':
                $(this.bottomModal).modal('show');
                break;
            case 'bottom-center-modal':
                $(this.centerBottomModal).modal('show');
                break;
            case 'add-product-to-cart':
                $(this.addItemToCart).modal('show');
                break;
        }
    };

    html = (id, html) => {
        switch (id) {
            case 'bottom-modal':
                $(this.bottomModal).find('.modal-body').html(html);
                break;
            case 'bottom-center-modal':
                $(this.centerBottomModal).find('.modal-body').html(html);
                break;
            case 'add-product-to-cart':
                $(this.addItemToCart).find('.modal-dialog').html(html);
                break;
        }
    }
}
