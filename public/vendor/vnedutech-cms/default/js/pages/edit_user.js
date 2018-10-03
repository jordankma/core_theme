// bootstrap wizard//
$("#gender, #gender1").select2({
    theme:"bootstrap",
    placeholder:"",
    width: '100%'
});
$("#commentForm").bootstrapValidator({
    fields: {
        contact_name: {
            validators: {
                notEmpty: {
                    message: 'The contact name is required'
                }
            },
            required: true,
            minlength: 3
        },
        username: {
            validators: {
                notEmpty: {
                    message: 'The username is required'
                }
            },
            required: true,
            minlength: 3
        },
        password: {
            validators: {
                different: {
                    field: 'contact_name,username',
                    message: 'Password should not match first or last name'
                }
            }
        },
        password_confirm: {
            validators: {
                identical: {
                    field: 'password'
                },
                different: {
                    field: 'contact_name,username',
                    message: 'Confirm Password should match with password'
                }
            }
        },
        email: {
            validators: {
                notEmpty: {
                    message: 'The email address is required'
                },
                emailAddress: {
                    message: 'The input is not a valid email address'
                }
            }
        },
        activate: {
            validators: {
                notEmpty: {
                    message: 'Please check the checkbox to activate'
                }
            }
        },
        group: {
            validators:{
                notEmpty:{
                    message: 'You must select a group'
                }
            }
        }
    }
});

$('#rootwizard').bootstrapWizard({
    'tabClass': 'nav nav-pills',
    'onNext': function(tab, navigation, index) {
        var $validator = $('#commentForm').data('bootstrapValidator').validate();
        return $validator.isValid();
    },
    onTabClick: function(tab, navigation, index) {
        return false;
    },
    onTabShow: function(tab, navigation, index) {
        var $total = navigation.find('li').length;
        var $current = index + 1;

        // If it's the last tab then hide the last button and show the finish instead
        if ($current >= $total) {
            $('#rootwizard').find('.pager .next').hide();
            $('#rootwizard').find('.pager .finish').show();
            $('#rootwizard').find('.pager .finish').removeClass('disabled');
        } else {
            $('#rootwizard').find('.pager .next').show();
            $('#rootwizard').find('.pager .finish').hide();
        }
    }});


$('#rootwizard .finish').click(function () {
    var $validator = $('#commentForm').data('bootstrapValidator').validate();
    if ($validator.isValid()) {
        document.getElementById("commentForm").submit();
    }

});
$('#activate').on('ifChanged', function(event){
    $('#commentForm').bootstrapValidator('revalidateField', $('#activate'));
});