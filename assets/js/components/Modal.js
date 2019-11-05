import $ from "jquery";
import AbstractComponent from "./AbstractComponent";

export const BOTTOM_MODAL = 'bottom-modal';

export default class Modal extends AbstractComponent {
    bottomModal;

    constructor() {
        super();
        this.onLoad();
    }

    onLoad() {
        this.bottomModal = document.getElementById('bottom-modal');
    }

    toggle = (id) => {
        switch (id) {
            case 'bottom-modal':
                $(this.bottomModal).modal('show');
                break;
        }
    };

    html = (id, html) => {
        switch (id) {
            case 'bottom-modal':
                $(this.bottomModal).find('.modal-content').html(html);
                break
        }
    }
}
