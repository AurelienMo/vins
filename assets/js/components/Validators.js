import {schemas} from "./schemaValidate";

const Joi = require('@hapi/joi');

export default class InputValidate {
    name = null;
    selector = null;
    parent = null;
    schema = null;

    constructor(inputName, selector, filter) {
        const schemas = schemas;
        this.selector = selector;
        this.parent = this.selector.parentNode;
        this.name = inputName;
        this.schema = Joi.object({[this.name]: schemas[filter]});

        this.selector.addEventListener('input', () => {
            this.selector.value = this.selector.value.replace(',', '.');
            const {error, value} = this.schema.validate({ [this.name]: this.selector.value });
            if (error === undefined){
                this.parent.classList.remove('wrong');
            } else {
                this.parent.classList.add('wrong');
            }
        });
    }
}
