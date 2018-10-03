"use strict";
// bootstrap wizard//
$("#packageForm").bootstrapValidator({
    fields: {
        package: {
            validators: {
                notEmpty: {
                    message: 'The package is required'
                }
            },
            required: true,
            minlength: 3
        },
        module: {
            validators: {
                notEmpty: {
                    message: 'The module is required'
                }
            },
            required: true,
            minlength: 3
        }
    }
});
$("#packageFormFile").bootstrapValidator({
    fields: {
        package: {
            validators: {
                notEmpty: {
                    message: 'The package is required'
                }
            },
            required: true,
            minlength: 3
        },
        module: {
            validators: {
                notEmpty: {
                    message: 'The module is required'
                }
            },
            required: true,
            minlength: 3
        }
        // file_upload: {
        //     validators: {
        //         file: {
        //             extension: 'tar.gz',
        //             type: 'application/gzip, application/x-gzip, application/x-gunzip, application/gzipped, application/gzip-compressed, application/x-compressed, application/x-compress, gzip/document, application/octet-stream',
        //             maxSize: 100 * 1024 * 1024,   // 100 MB
        //             message: 'The selected file is not valid, it should be (tar.gz) and 100 MB at maximum.'
        //         },
        //         notEmpty: {
        //             message: 'The file is required'
        //         }
        //     }
        // }
    }
});