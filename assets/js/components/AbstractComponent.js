import Modal from "./Modal";

export default class AbstractComponent {
    modal: Modal;

    constructor() {
        this.modal = new Modal();
    }
}
