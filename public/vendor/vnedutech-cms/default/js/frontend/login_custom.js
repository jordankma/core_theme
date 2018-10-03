$(document).ready(function () {
    $(".omb_loginForm").bootstrapValidator({
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Bắt buộc phải nhập email.'
                    },
                    emailAddress: {
                        message: 'Email không chính xác.'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Bắt buộc phải nhập mật khẩu.'
                    }
                }
            }
        }
    });
});