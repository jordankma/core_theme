"use strict";
// bootstrap wizard//
$("#roleForm").bootstrapValidator({
    fields: {
        name: {
            validators: {
                notEmpty: {
                    message: 'The name is required'
                }
            },
            required: true,
            minlength: 3
        }
    }
});