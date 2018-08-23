"use strict";
// bootstrap wizard//
$("#starForm").bootstrapValidator({
    excluded: [':disabled'],
    fields: {
        star_number: {
            validators: {
                notEmpty: {
                    message: 'The star number is required and cannot be empty'
                }
            }
        },
        gold_rate: {
            validators: {
                notEmpty: {
                    message: 'The gold rate is required and cannot be empty'
                }
            }
        },
        heart_rate: {
            validators: {
                notEmpty: {
                    message: 'The heart rate is required and cannot be empty'
                }
            }
        },
        move_rate: {
            validators: {
                notEmpty: {
                    message: 'The move rate is required and cannot be empty'
                }
            }
        },
        gem_rate: {
            validators: {
                notEmpty: {
                    message: 'The gem rate is required and cannot be empty'
                }
            }
        }
    }
});