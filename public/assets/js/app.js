var $dtTables = [];
var App = function () {

    // datatables
    var dt = {};
    dt.init = function(options) {
        let $settings = $.extend(true, {
            autoUpdate: false
        }, options);

        $dtTables[$settings.id] = $('#' + $settings.id).DataTable($settings.settings);

        if($settings.autoUpdate) {
            setInterval(() => {
                if(dt.autoUpdateRule()) {
                    $dtTables[$settings.id].ajax.reload(null, false);
                }
            }, $settings.autoUpdate);
        }
    };

    dt.autoUpdateRule = function() {
        let $body = $('body');

        if($body.hasClass('modal-open')) {
            return false;
        }

        if($body.hasClass('swal2-shown')) {
            return false;
        }

        return true;
    }

    dt.extend = function() {
        if( typeof $.fn.dataTable !== 'undefined' ) {
            jQuery.fn.dataTable.Api.register( 'processing()', function ( show ) {
                return this.iterator( 'table', function ( ctx ) {
                    ctx.oApi._fnProcessingDisplay( ctx, show );
                } );
            } );

            $.extend(true, $.fn.dataTable.defaults, {
                dom:
                    "<'row'<'col-md-8'f><'col-md-4'p>>" +
                    "<'row'<'col-md-12'tr>>" +
                    "<'row'<'col-md-4'i><'col-md-8 dataTables_pager'lp>>",
                lengthMenu: [10, 25, 50],
                pageLength: 10,
                language: {
                    lengthMenu: "Display _MENU_",
                    search: "_INPUT_",
                    searchPlaceholder: "Search"
                }
            });
        }
    };

    dt.custom = {};

    // extend datatables select extension
    dt.custom.selectAll = function(tableID) {
        console.log('Initialize dt.custom.selectAll');

        let $table = $('#' + tableID);

        let $dtWrapper = $table.parents('.dataTables_wrapper'),
            $toolbar = $('.dt-toolbar', $dtWrapper),
            $bulkBtn = $('#dt-bulk', $toolbar);

        $('th.select-all', $table).on('click', function(e) {
            let $selectAllBtn = $(this);

            if($selectAllBtn.hasClass('selected')) {
                $selectAllBtn.removeClass('selected');
                $dtTables[tableID].rows({filter: 'applied'}).deselect();
            } else {
                $selectAllBtn.addClass('selected');
                $dtTables[tableID].rows({filter: 'applied'}).select();
            }
        });

        return {
            deselectAll: function() {
                let $selectAllBtn = $('th.select-all', $table);

                if($selectAllBtn.hasClass('selected')) {
                    $selectAllBtn.removeClass('selected');
                    $dtTables[tableID].rows({filter: 'applied'}).deselect();

                    if($bulkBtn.length) {
                        $bulkBtn.addClass('disabled');
                    }
                }
            },
            selectAll: function() {
                let $selectAllBtn = $('th.select-all', $table);

                if(!$selectAllBtn.hasClass('selected')) {
                    $selectAllBtn.addClass('selected');
                    $dtTables[tableID].rows({filter: 'applied'}).select();

                    if($bulkBtn.length) {
                        $bulkBtn.removeClass('disabled');
                    }
                }
            }
        }
    };

    dt.custom.bulkCallbacks = [];
    dt.custom.bulk = function(tableID, options) {
        console.log('Initialize dt.custom.bulk');

        let $table = $('#' + tableID),
            $dtWrapper = $table.parents('.dataTables_wrapper'),
            $toolbar = $('<div class="dt-toolbar"></div>').appendTo('.dataTables_filter', $dtWrapper);

        // set callbacks
        dt.custom.bulkCallbacks[tableID] = options.actions;

        // generate dropdown button
        let dropdownContent = '', dropdown, btn;
        _.forEach(options.actions, function(action, key) {
            dropdownContent += `<li><a href="#" class="dropdown-item" onClick="App.dt.custom.bulkCallbacks['${tableID}'][${key}].callback($(this));">${action.label}</a></li>`;
        });

        dropdown =
            '<div class="dt-bulk-dropdown btn-group">' +
                '<button class="btn btn-primary btn-sm dropdown-toggle disabled" type="button" id="dt-bulk" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                    options.label +
                '</button>' +
                '<ul class="dt-bulk-menu dropdown-menu" aria-labelledby="dt-bulk-dropdown">' + dropdownContent + '</ul>' +
            '</div>';

        btn = $('.dropdown-toggle', $(dropdown).appendTo($toolbar));

        // initialize
        $dtTables[tableID].on('select deselect', function(e, dt, type, indexes) {
            // console.log($dtTables[tableID].rows('.selected').data().length);
            if($dtTables[tableID].rows('.selected').data().length > 0) {
                btn.removeClass('disabled');
            } else {
                btn.addClass('disabled');
            }
        });
    }

    dt.custom.button = function(tableID, options) {
        let $settings = $.extend(true, {
            label: 'Button',
            generate: function() {},
            initialize: function() {}
        }, options);

        let $table = $('#' + tableID),
            $dtWrapper = $table.parents('.dataTables_wrapper'),
            $toolbar = $('.dt-toolbar'),
            element = $settings.generate(),
            $btn;

        $btn = $(element).appendTo($toolbar);
        $btn.closest('div').addClass($settings.label);
        $settings.initialize($btn);
    }

    // modal
    var modal = function(options) {
        let $settings = $.extend(true, {
            title: 'Confirmation Modal',
            body: 'Are you sure you want to continue?',
            footer: true,
            width: 500,
            ajax: false,
            onShow: function() {},
            onShown: function() {},
            onHide: function() {},
            btn: {
                confirm: {
                    text: 'Confirm',
                    class: 'btn btn-blue',
                    onClick: function() {}
                },
                cancel: {
                    text: 'Cancel',
                    class: 'btn btn-default',
                    onClick: function() {}
                }
            },
            validate: false,
            others: {}
        }, options);


        var $appModal = $('<div class="modal fade" id="app-modal" tabindex="-1" role="dialog" data-width="' + $settings.width + '" aria-hidden="true"></div>');
        $appModal.html(
            '<form id="app-modal-form" action="#">' +
                '<div class="modal-header">' +
                    '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +
                    '<h4 class="modal-title">' + $settings.title + '</h4>' +
                '</div>' +
                '<div class="modal-body">' + (!$settings.ajax ? $settings.body : '') + '</div>' +
                '<div class="modal-footer">' +
                    '<button type="button" class="' + $settings.btn.cancel.class + '" id="cancel">' + $settings.btn.cancel.text + '</button>' +
                    '<button type="button" class="' + $settings.btn.confirm.class + '" id="confirm">' + $settings.btn.confirm.text + '</button>' +
                '</div>' +
            '</form>');

        $($appModal).appendTo($('body'));

        var $appModalForm = $appModal.find('form'),
            $callbacks = $.Callbacks(),
            defaultCall = function(run=true) {
                // add a check to override modal hide
                if(run) {
                    $appModal.modal('hide');
                }
            };

        if(!$settings.footer) {
            $appModal.find('.modal-footer').remove();
        }

        // set default callback
        $callbacks.add(defaultCall);

        // set confirm
        if($settings.btn.confirm) {
            $appModal.find('button#confirm').on('click', function() {
            // set form and validation
            if($settings.validate) {
                if($appModalForm.valid()) {
                    $callbacks.fire($settings.btn.confirm.onClick($appModalForm, $(this)));
                }
            } else {
                $callbacks.fire($settings.btn.confirm.onClick($appModalForm, $(this)));
            }
            });
        } else {
            $appModal.find('button#confirm').addClass('hidden');
        }

        // set cancel
        $appModal.find('button#cancel').on('click', function() {
            $callbacks.fire($settings.btn.cancel.onClick($appModalForm));
        });

        // on.show
        $appModal.on('show.bs.modal', function() {
            $settings.onShow($appModalForm);
        });

        $appModal.on('shown.bs.modal', function() {
            $settings.onShown($appModalForm);
        });

        // on.hide
        $appModal.on('hide.bs.modal ', function() {
            $settings.onHide($appModalForm);
        });

        // on.hidden
        $appModal.on('hidden.bs.modal', function() {
            $(this).remove();
        });

        $($appModal).appendTo($('body'));

        // load ajax content to body
        if($settings.ajax) {
            $appModal.find('.modal-body').load($settings.ajax.url, $settings.ajax.data, function(response, status, xhr) {
                // console.log(response);
                // console.log(status);
                // console.log(xhr);

                $appModal.modal($settings.others);
            });
        } else {
            $appModal.modal($settings.others);
        }

        return $appModal;
    }

    // jquery validation default
    var validationSetDefault = function() {
        jQuery.validator.setDefaults({
            errorElement: "span", // contain the error msg in a span tag
            errorClass: 'help-block',
            errorPlacement: function (error, element) { // render error placement for each input type
                if (element.attr("type") == "radio" || element.attr("type") == "checkbox") { // for chosen elements, need to insert the error after the chosen container
                    error.insertAfter($(element).closest('.form-group').children('div').children().last());
                } else if (element.attr("name") == "dd" || element.attr("name") == "mm" || element.attr("name") == "yyyy") {
                    error.insertAfter($(element).closest('.form-group').children('div'));
                } else if (element.hasClass('form-select2')) {
                    error.insertAfter($(element).next());
                } else if (element.parent().hasClass('input-group')) {
                    error.insertAfter($(element).parent());
                } else {
                    error.insertAfter(element);
                    // for other inputs, just perform default behavior
                }
            },
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
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
            }
        });

        $.validator.addMethod('nospace', function (value, element) {
            return /^[a-zA-Z0-9_.-]+$/.test(value);
        }, 'Please remove spaces or use underscore instead.');

        $.validator.addMethod('domain-name', function (value, element) {
            return /^[a-z0-9-]+$/.test(value);
        }, 'Valid characters are a-z (lowercase only), 0-9, and - (hyphen).');

        $.validator.addMethod('multiple-of', function (value, element, int) {
            return parseInt(value, 10) % int == 0;
        }, $.validator.format('Value must be a multiple of {0}.'));

        $.validator.addMethod('valid-url', function(value, element) {
            var url = $.validator.methods.url.bind(this);
            return url(value, element) || url('http://' + value, element);
        }, 'Please enter a valid URL');

        $.validator.addMethod('passwordExt', function(value, element, param) {
            if (this.optional(element)) {
                return true;
            } else if (!/[A-Z]/.test(value)) {
                return false;
            } else if (!/[a-z]/.test(value)) {
                return false;
            } else if (!/[0-9]/.test(value)) {
                return false;
            } else if (!/[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/.test(value)) {
                return false;
            }

            return true;
        }, 'Please enter a valid password. Requires 1 uppercase letter, 1 lowercase letter, 1 number character, and 1 special character.');
    }

    var customs = {};

    // input counter
    customs.inputCounterInit = function() {
        $.fn.inputCounter = function ($settings) {
            $settings.input = $(this);
            $settings.counter = $('<span class="counter">' + $settings.max + '</span>').insertAfter($settings.input);

            $settings.input.on('keyup', function() {
                let value, count;

                value = $settings.input.val().substr(0, $settings.max);
                $settings.input.val(value);

                count = $settings.max - $settings.input.val().length;
                $settings.counter.html(count);
            });
        }
    }

    customs.inputHiddenInit = function() {
        $.fn.inputHidden = function ($settings = {}) {
            $settings.input = $(this);

            // $settings.input.wrap('<div class="input-group input-append input-hidden-container input-hidden"></div>');
            // $settings.input.parent().append('<span id="toggle" class="input-group-addon add-on"><i class="clip-eye"></i></span>');

            $settings.toggle = $settings.input.next();
            $settings.toggle.on('click', function() {
                if($settings.input.parent().hasClass('input-hidden')) {
                    $settings.input.parent().removeClass('input-hidden');
                } else {
                    $settings.input.parent().addClass('input-hidden');
                }
            });
        }
    }

    customs.navInit = function() {
        let activeLink = $('ul.main-navigation-menu a[href^="' + window.location.pathname + '"]');
        activeLink.parent().addClass('active');
    }

    // phpliteadmin access
    customs.liteInit = function() {
        let liteBtn = $('#lite-btn');

        liteBtn.on('click', function(event) {
            if(event.altKey) {
                window.open('/phpliteadmin');
            }
        });
    }

    // hiddenNavs
    customs.hiddenNavs = function() {
        let main = $('.main-container');

        main.on('click', function(event) {
            if(event.altKey) {
                if($('.main-navigation-menu li.secret').is(':visible')) {
                   $('.main-navigation-menu li.secret').hide();
                } else {
                    $('.main-navigation-menu li.secret').show();
                }
            }
        });
    }

    customs.activeToggle = function(options) {
        let $settings = $.extend(true, {
            btn: null,
            elements: null,
            condition: function(btn) {
                return btn.is(':checked');
            }
        }, options);

        $settings.btn.on('click', function() {
            // check condition display if condition is true; hide if false
            if($settings.condition($(this))) {
                $.each($settings.elements, function(key, element) {
                    element.show();
                });
            } else {
                $.each($settings.elements, function(key, element) {
                    element.hide();
                });
            }
        });
    }

    var checkUserAwsKeys = function() {
        if(_.isNull(window.localStorage.getItem('HasAwsKeys'))) {
            console.log('checkUserAwsKeys');
            $.ajax({
                type: 'get',
                async: false,
                url: '/user/profile/auth_keys',
                dataType: 'json',
                success: function(response) {
                    if(_.isEmpty(response.keys.aws_access) || _.isEmpty(response.keys.aws_secret)) {
                        Swal.fire({
                            text: 'To use any AWS related services, you must configure your AWS API Keys and parameters in your profile.',
                            icon: 'warning',
                            allowOutsideClick: false,
                            showCloseButton: false,
                            confirmButtonText: 'Configure',
                            showCancelButton: true,
                            cancelButtonText: 'Close'
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location = '/user/profile';
                            }
                        });
                    } else {
                        window.localStorage.setItem('HasAwsKeys', true);
                    }
                }
            });

            return false;
        } else {
            return true;
        }
    }

    var checkUserTwilioKeys = function() {
        if(_.isNull(window.localStorage.getItem('HasTwilioKeys'))) {
            console.log('checkUserTwilioKeys');
            $.ajax({
                type: 'get',
                async: false,
                url: '/user/profile/auth_keys',
                dataType: 'json',
                success: function(response) {
                    if(_.isEmpty(response.keys.twilio_sid) || _.isEmpty(response.keys.twilio_secret)) {
                        Swal.fire({
                            text: 'Before using the portal, you must enter your Twilio API Keys.',
                            icon: 'warning',
                            confirmButtonText: 'Configure',
                            allowOutsideClick: false,
                            showCloseButton: false
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location = '/user/profile';
                            }
                        });
                    } else {
                        window.localStorage.setItem('HasTwilioKeys', true);
                    }
                }
            });

            return false;
        } else {
            return true;
        }
    }

    var checkUserDefaults = function() {
        if(_.isNull(window.localStorage.getItem('HasUpdatedDefaults'))) {
            console.log('checkUserDefaults');
            $.ajax({
                type: 'get',
                async: false,
                url: '/user/profile/user_defaults',
                dataType: 'json',
                success: function(response) {
                    if(!response.email_updated || !response.password_updated) {
                        let message = '';

                        message += (!response.email_updated) ? '<p>Email needs to be updated.</p>' : '';
                        message += (!response.password_updated) ? '<p>Password needs to be updated.</p>' : '';

                        Swal.fire({
                            html: message,
                            icon: 'warning',
                            allowOutsideClick: false,
                            showCloseButton: false
                        }).then((result) => {
                            if(result.isConfirmed) {
                                window.location = '/user/profile#edit_account';
                            }
                        });
                    } else {
                        window.localStorage.setItem('HasUpdatedDefaults', true);
                    }
                }
            });

            return false;
        } else {
            return true;
        }
    }

    var globalPageChecks = function() {
        let validDefaults;

        // check if user has already updated defaults
        if(_.isNull(window.localStorage.getItem('HasUpdatedDefaults'))) {
            validDefaults = checkuser.defaults();

            validDefaults.then(result => {
                if(result) {
                    if($.inArray(window.location.pathname, ['/dashboard', '/eventstreams']) > -1) {
                        checkuser.twilio();
                    }

                    if($.inArray(window.location.pathname, ['/kinesis', '/elasticsearch']) > -1) {
                        checkuser.aws();
                    }
                }
            });
        }

        if($.inArray(window.location.pathname, ['/dashboard', '/eventstreams']) > -1) {
            // check if user has updated defaults and has twilio keys
            if(!_.isNull(window.localStorage.getItem('HasUpdatedDefaults')) && _.isNull(window.localStorage.getItem('HasTwilioKeys'))) {
                checkuser.twilio();
            }
        }

        if($.inArray(window.location.pathname, ['/kinesis', '/elasticsearch']) > -1) {
            // check if user has updated defaults and has aws keys
            if(!_.isNull(window.localStorage.getItem('HasUpdatedDefaults')) && _.isNull(window.localStorage.getItem('HasAwsKeys'))) {
                checkuser.aws();
            }
        }
    }

    var checkuser = {};

    checkuser.defaults = function() {
        return fetch('/user/profile/user_defaults')
            .then(response => response.json())
            .then(data => {
                if(!data.email_updated || !data.password_updated) {
                    let message = '';

                    message += (!data.email_updated) ? '<p>Email needs to be updated.</p>' : '';
                    message += (!data.password_updated) ? '<p>Password needs to be updated.</p>' : '';

                    Swal.fire({
                        html: message,
                        icon: 'warning',
                        allowOutsideClick: false,
                        showCloseButton: false
                    }).then((result) => {
                        if(result.isConfirmed) {
                            window.location = '/user/profile#edit_account';
                        }
                    });

                    return false;
                }

                window.localStorage.setItem('HasUpdatedDefaults', true);
                return true;
            });
    }

    checkuser.twilio = function() {
        return fetch('/user/profile/auth_keys')
            .then(response => response.json())
            .then(data => {
                if(_.isEmpty(data.keys.twilio_sid) || _.isEmpty(data.keys.twilio_secret)) {
                    Swal.fire({
                        text: 'Before using the portal, you must enter your Twilio API Keys.',
                        icon: 'warning',
                        confirmButtonText: 'Configure',
                        allowOutsideClick: false,
                        showCloseButton: false
                    }).then((result) => {
                        if(result.isConfirmed) {
                            window.location = '/user/profile';
                        }
                    });

                    return false;
                }

                window.localStorage.setItem('HasTwilioKeys', true);
                return true;
            });
    }

    checkuser.aws = function() {
        return fetch('/user/profile/auth_keys')
            .then(response => response.json())
            .then(data => {
                if(_.isEmpty(data.keys.aws_access) || _.isEmpty(data.keys.aws_secret)) {
                    Swal.fire({
                        text: 'To use any AWS related services, you must configure your AWS API Keys and parameters in your profile.',
                        icon: 'warning',
                        allowOutsideClick: false,
                        showCloseButton: false,
                        confirmButtonText: 'Configure',
                        showCancelButton: true,
                        cancelButtonText: 'Close'
                    }).then((result) => {
                        if(result.isConfirmed) {
                            window.location = '/user/profile';
                        }
                    });
                } else {
                    window.localStorage.setItem('HasAwsKeys', true);
                }
            });
    }

    return {
        init: function() {
            console.log('App.init');

            // from clip-one theme
            Main.init();

            customs.navInit();
            customs.liteInit();
            customs.hiddenNavs();
            customs.inputCounterInit();
            customs.inputHiddenInit();
        },
        modal: modal,
        dt: dt,
        validationSetDefault: validationSetDefault,
        globalPageChecks: globalPageChecks,
        checkUserTwilioKeys: checkUserTwilioKeys,
        checkUserAwsKeys: checkUserAwsKeys,
        checkUserDefaults: checkUserDefaults,
        timezone: jstz.determine().name(),
        // sendTest: function() {
        //     $.ajax({
        //         url: 'https://030946c3ad5dec074c7e5eb94dbc7090.m.pipedream.net',
        //         type: 'post',
        //         data: {
        //             test_id: 'esm-test-' + moment().unix()
        //         },
        //         dataType: 'json',
        //         success: function(response) {
        //             console.log(response);
        //         }
        //     });
        // },
        checkuser: checkuser,
        customs: customs
    }
}();

jQuery(document).ready(function() {
    App.init();
});