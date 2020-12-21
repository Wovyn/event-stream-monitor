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
                        swal({
                            html: true,
                            type: response.error !== true ? 'success' : 'error',
                            title: response.error !== true ? 'Success' : 'Error',
                            text: response.message
                        }, function() {
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

    return {
        init: function() {
            console.log('UserProfile.init');

            handleUpdateProfileForm();
        }
    }
}();

jQuery(document).ready(function() {
    UserProfile.init();
});