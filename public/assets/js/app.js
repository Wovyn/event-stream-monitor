var $dtTables = [], $hasAuthKey = false;
var App = function () {

    // datatables
    var dt = {};
    dt.init = function(options) {
        $dtTables[options.id] = $('#' + options.id).DataTable(options.settings);
    };

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
        var $settings = $.extend(true, {
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
        var $settings = $.extend(true, {
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
            $appModal.find('.modal-body').load($settings.ajax.url, $settings.ajax.data, function() {
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

    customs.navInit = function() {
        let activeLink = $('ul.main-navigation-menu a[href^="' + window.location.pathname + '"]');
        activeLink.parent().addClass('active');
    }

    var checkUserAuthKeys = function() {
        let keys;

        $.ajax({
            type: 'get',
            url: '/user/profile/auth_keys',
            dataType: 'json',
            success: function(response) {
                if(!response.keys) {
                    Swal.fire({
                        text: response.message,
                        icon: 'warning',
                        showCloseButton: true
                    }).then((result) => {
                        if(result.isConfirmed) {
                            window.location = '/user/profile';
                        }
                    });
                } else {
                    $hasAuthKey = true;
                }
            }
        });
    }

    var timezone = jstz.determine().name();

    return {
        init: function() {
            console.log('App.init');

            // from clip-one theme
            Main.init();

            customs.navInit();
            customs.inputCounterInit();
        },
        modal: modal,
        dt: dt,
        validationSetDefault: validationSetDefault,
        checkUserAuthKeys: checkUserAuthKeys,
        timezone: timezone
    }
}();

jQuery(document).ready(function() {
    App.init();
});