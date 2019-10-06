import AbstractComponent from "./AbstractComponent";

export default class Header extends AbstractComponent {
    headerEl = null;
    constructor() {
        super();
        this.onLoad();
    }

    onLoad() {
        this.initMainSelector();
        this.initAllEvents();
    }

    initMainSelector() {
        this.headerEl = document.getElementById('header');
    }

    initAllEvents() {
    }
}
