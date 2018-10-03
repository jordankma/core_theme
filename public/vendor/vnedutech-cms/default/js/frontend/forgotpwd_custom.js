$(".omb_loginForm").bootstrapValidator({
    fields: {
        inputEmail: {
            validators: {
                notEmpty: {
                    message: 'Yêu cầu nhập email'
                },
                emailAddress: {
                    message: 'Email không chính xác'
                }
            }
        }
    }
});
$(function() {
    setTimeout(function () {
        $("#notific").remove();
    }, 5000);
});