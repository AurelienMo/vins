import $ from "jquery";
import Loader from "./Loader";

export default class AbstractComponent {
    loader;
    constructor() {
        $(document).foundation();
        this.loader = new Loader();
    };
}
