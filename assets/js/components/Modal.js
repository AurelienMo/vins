import $ from "jquery";

export const BOTTOM_MODAL = 'bottom-modal';

export default class Modal {
    bottomModal;
    centerBottomModal;

    constructor() {
        this.onLoad();
    }

    onLoad() {
        this.bottomModal = document.getElementById('bottom-modal');
        this.centerBottomModal = document.getElementById('bottom-center-modal');
    }

    toggle = (id) => {
        switch (id) {
            case 'bottom-modal':
                $(this.bottomModal).modal('show');
                break;
            case 'bottom-center-modal':
                $(this.centerBottomModal).modal('show');
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
        }
    }
}
