var Profile = function() {

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

        $('#twilio_secret').inputHidden();
        $('#aws_secret').inputHidden();
        $('#external_id').inputHidden();

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

    var checkHashtag = function() {
        if(!_.isEmpty(window.location.hash)) {
            $('.nav-tabs a[href="' + window.location.hash + '"]').tab('show');
        }
    }

    return {
        init: function() {
            console.log('Profile.init');

            App.validationSetDefault();

            checkHashtag();

            handleUpdateProfileForm();
            handleUpdateKeysForm();
        }
    }
}();

jQuery(document).ready(function() {
    Profile.init();
});