import Modal from "./Modal";

export default class AbstractComponent {
    modal;

    constructor() {
        this.modal = new Modal();
    }
}
