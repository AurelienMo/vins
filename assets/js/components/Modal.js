import $ from "jquery";
import AbstractComponent from "./AbstractComponent";

export default class Modal extends AbstractComponent {
    basicModal;

    constructor() {
        super();
        this.onLoad();
    }

    onLoad() {
        this.basicModal = document.getElementById('basic-modal');
    }

    toggle = (id) => {
        switch (id) {
            case 'basic-modal':
                $(this.basicModal).foundation('toggle');
                break;
        }
    }

    html = (id, html) => {
        switch (id) {
            case 'basic-modal':
                $(this.basicModal).find('.content-modal').html(html);
                break
        }
    }
}
