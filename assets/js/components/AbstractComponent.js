import $ from "jquery";
import Loader from "./Loader";
import APIResolver from "./APIResolver";

export default class AbstractComponent {
    constructor() {
        $(document).foundation();
    };
}
