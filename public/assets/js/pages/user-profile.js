var UserProfile = function() {

    var handleUpdateProfileForm = function() {
        let $form = $('#update-profile-form');

        $form.validate({
            rules: {
                confirm_password: {
                    equalTo: '#password'
                }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        Swal.fire({
                            icon: response.error !== true ? 'success' : 'error',
                            title: response.error !== true ? 'Success' : 'Error',
                            text: response.message
                        }).then((result) => {
                            if(response.error !== true) {
                                // reset password and confirm_password field
                                $('#password, #confirm_password', $form).val('');
                            }
                        });
                    }
                });
            }
        });
    }

    var handleUpdateKeysForm = function() {
        let $form = $('#update-keys-form');

        $form.validate({
            submitHandler: function (form) {
                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: $form.serialize(),
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        Swal.fire({
                            icon: response.error !== true ? 'success' : 'error',
                            title: response.error !== true ? 'Success' : 'Error',
                            text: response.message
                        });
                    }
                });
            }
        });
    }

    return {
        init: function() {
            console.log('UserProfile.init');

            App.validationSetDefault();

            handleUpdateProfileForm();
            handleUpdateKeysForm();
        }
    }
}();

jQuery(document).ready(function() {
    UserProfile.init();
});