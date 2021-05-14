var Login = function () {
    var runLoginButtons = function () {
        $('.forgot').bind('click', function () {
            $('.box-login').hide();
            $('.box-forgot').show();
        });
        $('.register').bind('click', function () {
            $('.box-login').hide();
            $('.box-register').show();
        });
        $('.go-back').click(function () {
            resetBoxes();
        });

        var el = $('.box-login');
        if (getParameterByName('box').length) {
            switch(getParameterByName('box')) {
                case "register" :
                    el = $('.box-register');
                    break;
                case "forgot" :
                    el = $('.box-forgot');
                    break;
                default :
                    el = $('.box-login');
                    break;
            }
        }
        el.show();
    };
    var resetBoxes = function() {
        $('.box-login').show();
        $('.box-forgot').hide();
        $('.box-register').hide();
    };
    var runSetDefaultValidation = function () {
        $.validator.setDefaults({
            errorElement: "span", // contain the error msg in a small tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "card_expiry_mm" || element.attr("name") == "card_expiry_yyyy") {
                    error.appendTo($(element).closest('.form-group').children('div'));
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
            ignore: ':hidden',
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error').find('.symbol').removeClass('ok').addClass('required');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            },
            success: function (label, element) {
                label.addClass('help-block valid');
                // mark the current input as valid and display OK icon
                $(element).closest('.form-group').removeClass('has-error');
            },
            highlight: function (element) {
                $(element).closest('.help-block').removeClass('valid');
                // display OK icon
                $(element).closest('.form-group').addClass('has-error');
                // add the Bootstrap error class to the control group
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element).closest('.form-group').removeClass('has-error');
                // set error class to the control group
            }
        });
    };
    var runLoginValidator = function () {
        var form = $('.form-login');
        var errorHandler = $('.errorHandler', form);
        form.validate({
            rules: {
                identity: {
                    minlength: 2,
                    required: true
                },
                password: {
                    // minlength: 6,
                    required: true
                }
            },
            submitHandler: function (form) {
                errorHandler.hide();
                form.submit();
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler.show();
            }
        });
    };
    var runForgotValidator = function () {
        var form2 = $('.form-forgot');
        var errorHandler2 = $('.errorHandler', form2);
        form2.validate({
            rules: {
                email: {
                    required: true
                }
            },
            submitHandler: function (form) {
                errorHandler2.hide();

                $.ajax({
                    url: form2.attr('action'),
                    method: 'POST',
                    data: form2.serialize(),
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        swal({
                            html: true,
                            type: response.error !== true ? 'success' : 'error',
                            title: response.error !== true ? 'Success' : 'Error',
                            text: response.message
                        }, function() {
                            if(response.error !== true) {
                                resetBoxes();
                            }
                        });
                    }
                });
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler2.show();
            }
        });
    };
    var runRegisterValidator = function () {
        var form3 = $('.form-register');
        var errorHandler3 = $('.errorHandler', form3);
        form3.validate({
            rules: {
                first_name: {
                    minlength: 2,
                    required: true
                },
                last_name: {
                    minlength: 2,
                    required: true
                },
                phone: {
                    minlength: 2,
                    required: true
                },
                email: {
                    required: true
                },
                password: {
                    minlength: 6,
                    required: true
                },
                password_confirm: {
                    required: true,
                    minlength: 5,
                    equalTo: "#register_password"
                },
                agree: {
                    minlength: 1,
                    required: true
                }
            },
            submitHandler: function (form) {
                errorHandler3.hide();

                $.ajax({
                    url: form3.attr('action'),
                    method: 'POST',
                    data: form3.serialize(),
                    dataType: 'json',
                    success: function(response, status, xhr, $form) {
                        swal({
                            html: true,
                            type: response.error !== true ? 'success' : 'error',
                            title: response.error !== true ? 'Success' : 'Error',
                            text: response.message
                        }, function() {
                            if(response.error !== true) {
                                resetBoxes();
                            }
                        });
                    }
                });
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler3.show();
            }
        });
    };

    var runResetPasswordValidator = function() {
        var form4 = $('.form-resetpassword');
        var errorHandler4 = $('.errorHandler', form4);
        form4.validate({
            rules: {
                new: {
                    minlength: 6,
                    required: true
                },
                new_confirm: {
                    required: true,
                    minlength: 6,
                    equalTo: "#new"
                }
            },
            submitHandler: function (form) {
                errorHandler4.hide();
                form4.submit();
            },
            invalidHandler: function (event, validator) { //display error alert on form submit
                errorHandler4.show();
            }
        });
    }

    //function to return the querystring parameter with a given name.
    var getParameterByName = function(name) {
        name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"), results = regex.exec(location.search);
        return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };

    var runMigrationCheck = function() {
        let loginBtn = $('#login'),
            btnContent = loginBtn.html();

        loginBtn.html('<i class="fa fa-spin clip-spinner"></i>');
        loginBtn.addClass('disabled');

        $.ajax({
            url: '/migrate/check',
            method: 'get',
            dataType: 'json',
            success: function(response) {
                if(response.length) {
                    let summary = '<table class="table">' +
                        '<thead><tr>' +
                            '<th>Version</th>' +
                            '<th>Name</th>' +
                            '<th>Result</th>' +
                            '<th>Message</th>' +
                        '</tr></thead><tbody>';

                    _.forEach(response, function(row, key) {
                        summary += '<tr>' +
                                '<td>' + row.version + '</td>' +
                                '<td>' + row.name + '</td>' +
                                '<td>' + (row.result.success ? '<label class="label label-success">success</label>' : '<label class="label label-warning">failed</label>') + '</td>' +
                                '<td>' + (row.result.success ? '' : row.result.error_message ) + '</td>' +
                            '</tr>';
                    });

                    summary += '</tbody></table>';

                    App.modal({
                        title: 'Migration Update Notice',
                        body: summary,
                        width: 640,
                        btn: {
                            confirm: {
                                class: 'hidden'
                            },
                            cancel: {
                                text: 'Close'
                            }
                        },
                        others: { backdrop: 'static', keyboard: false }
                    });
                }

                loginBtn.html(btnContent);
                loginBtn.removeClass('disabled');
            }
        });
    };

    return {
        //main function to initiate template pages
        init: function () {
            runLoginButtons();
            runSetDefaultValidation();
            runLoginValidator();
            runForgotValidator();
            runRegisterValidator();
            runResetPasswordValidator();

            runMigrationCheck();
        }
    };
}();