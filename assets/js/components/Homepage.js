import AbstractComponent from "./AbstractComponent";

export default class Homepage extends AbstractComponent {
    constructor() {
        super();
        this.initSearchTextEvent();
    }

    initSearchTextEvent() {
        document.querySelector('form').addEventListener('submit', function (e) {
            //TODO Process submitting form ajax
        })
    }
}
