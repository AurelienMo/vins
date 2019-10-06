const Joi = require('@hapi/joi');

export const schemas = {
    'not-blank': Joi.string().min(1),
};
