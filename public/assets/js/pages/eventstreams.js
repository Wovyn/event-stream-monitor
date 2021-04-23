var Eventstreams = function() {
    var appModal;
    var FormWizard = function() {
        let wizard, lastStep, $tree, eventTypes;

        var initWizard = function(form) {
            wizard = $('#smartwizard', form);
            lastStep = $('.nav li', wizard).length - 1;

            wizard.smartWizard({
                selected: 0,
                justified: true,
                enableURLhash: false,
                autoAdjustHeight: false,
                keyboardSettings: { keyNavigation: false },
                toolbarSettings: {
                    toolbarExtraButtons: [
                        $('<button type="button" class="btn btn-finish btn-success hidden">Create Sink Instance</button>')
                            .on('click', function() {
                                $(this).addClass('disabled');

                                Swal.fire({
                                    title: 'Creating Sink Instance',
                                    allowOutsideClick: false
                                });
                                Swal.showLoading();

                                // create sink
                                $.ajax({
                                    url: '/eventstreams/add',
                                    method: 'POST',
                                    data: form.serialize(),
                                    dataType: 'json',
                                    success: function(response) {
                                        // console.log(response.result.sink_id);
                                        if(!response.error) {
                                            // submit subscriptions
                                            let selected = $tree.jstree('get_selected');
                                            _.pullAll(selected, eventTypes.parents);

                                            // check selected subscription length
                                            if(selected.length) {
                                                Swal.update({
                                                    title: 'Updating Sink Subscription',
                                                    showConfirmButton: false
                                                });

                                                Swal.showLoading();

                                                $.ajax({
                                                    url: '/eventstreams/subscriptions/' + response.result.sink_id,
                                                    method: 'POST',
                                                    data: { subscriptions: selected },
                                                    dataType: 'json',
                                                    success: function (subResponse) {
                                                        if (subResponse.message !== false) {
                                                            Swal.fire({
                                                                icon: subResponse.error !== true ? 'success' : 'error',
                                                                text: response.message
                                                            });
                                                        } else {
                                                            Swal.close();
                                                        }

                                                        if (!subResponse.error) {
                                                            appModal.modal('hide');
                                                            $dtTables['sink-table'].ajax.reload();
                                                        } else {
                                                            console.log(subResponse);
                                                        }
                                                    }
                                                });
                                            } else {
                                                Swal.fire({
                                                    icon: response.error !== true ? 'success' : 'error',
                                                    text: response.message
                                                });

                                                appModal.modal('hide');
                                                $dtTables['sink-table'].ajax.reload();
                                            }
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                text: response.message
                                            });

                                            console.log(response);
                                        }
                                    }
                                });
                            })
                    ]
                }
            });

            // html class fix
            $('.toolbar', wizard).addClass('modal-footer');

            // on leaveStep
            wizard.on('leaveStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
                // validate current step
                if(!form.valid()) {
                    return false;
                }

                // set prev button hidden on first step
                if(nextStepIndex == 0) {
                    $('.sw-btn-prev', form).addClass('hidden');
                } else {
                    $('.sw-btn-prev', form).removeClass('hidden');
                }

                // show/hide create data stream btn and next button
                if(nextStepIndex == lastStep) {
                    generateSummary(form);

                    $('.sw-btn-next', form).addClass('hidden');
                    $('.btn-finish', form).removeClass('hidden');
                } else {
                    $('.sw-btn-next', form).removeClass('hidden');
                    $('.btn-finish', form).addClass('hidden');
                }

                animateBar(nextStepIndex);
            });

            // on showStep
            wizard.on('showStep', function(e, anchorObject, stepIndex, stepDirection) {
                appModal.modal('layout');
            });

            // initialize animateBar
            animateBar();

            // set prev button hidden on first step
            $('.sw-btn-prev', form).addClass('hidden');

            // init elements
            $('.form-select2', form).select2()
                .on('select2:select', function (e) {
                    if($(this).val()) {
                        $(this)
                            .closest('.form-group')
                                .removeClass('has-error')
                                .addClass('has-success')
                            .find('.symbol')
                                .removeClass('required')
                                .addClass('ok');
                    }
                });
        }

        var animateBar = function(step) {
            if (_.isUndefined(step)) {
                step = 0;
            };

            numberOfSteps = $('.swMain > .nav > li').length;
            var valueNow = Math.floor(100 / numberOfSteps * (step + 1));
            $('.step-bar').css('width', valueNow + '%');
        };

        var generateSummary = function(form) {
            // console.log(form.serializeArray());
            let summaryEl = $('.summary', form),
                sinkType = $('#sink_type', form).val(),
                formValues = form.serializeArray(),
                subscriptions = $tree.jstree('get_selected', true),
                summary = '';

            summaryEl.empty();

            // sink configuration
            summary += '<div class="col-md-6">';
            _.forEach(formValues, function(data) {
                if (sinkType == 'kinesis' && $.inArray(data.name, ['description', 'data_view_url', 'kinesis_data_stream', 'role_arn']) != -1) {
                    summary += '<div class="form-group">' +
                        '<label class="control-label text-capitalize text-bold">' + data.name + ':</label>' +
                        '<p class="form-control-static display-value">' + data.value + '</p>' +
                        '</div>';
                }

                if (sinkType == 'webhook' && $.inArray(data.name, ['description', 'data_view_url', 'destination_url', 'method', 'batch_events']) != -1) {
                    summary += '<div class="form-group">' +
                        '<label class="control-label text-capitalize text-bold">' + data.name + ':</label>' +
                        '<p class="form-control-static display-value">' + data.value + '</p>' +
                        '</div>';
                }
            });
            summary += '</div>';

            // console.log(subscriptions);

            if(subscriptions.length) {
                // format
                let events = {};
                _.forEach(subscriptions, function (subscription, key) {
                    if (subscription.parent != '#') {
                        if (_.isUndefined(events[subscription.parent])) {
                            events[subscription.parent] = [];
                        }

                        events[subscription.parent].push(subscription.id);
                    }
                });

                // subscriptions
                summary += '<div class="col-md-6" >' +
                    '<div class="form-group">' +
                    '<label class="control-label text-capitalize text-bold">Subscriptions:</label><br>';
                _.forEach(events, function(eventparent, key) {
                    summary += '<b>' + key + '</b><ul>';
                    _.forEach(eventparent, function(eventchild) {
                        summary += '<li>' + eventchild + '</li>';
                    });
                    summary += '</ul>';
                });
                summary += '</div></div>';

                // console.log(events);
            } else {
                summary += '<div class="col-md-6" >' +
                    '<div class="form-group">' +
                        '<label class="control-label text-capitalize text-bold">Subscriptions:</label><br>' +
                        '<p class="help-block">No subscribed Events.</p>' +
                    '</div></div>';
            }

            summaryEl.append(summary);
        }

        return {
            init: function(form) {
                initWizard(form);

                // initialize sink_type fields
                $('#sink_type', form).on('change', function() {
                    // console.log($(this).val());
                    if($(this).val() == 'kinesis') {
                        $('.sink-type .kinesis').show();
                        $('.sink-type .webhook').hide();
                    } else {
                        $('.sink-type .kinesis').hide();
                        $('.sink-type .webhook').show();
                    }
                });

                // initialize subscription tree
                eventTypes = $.parseJSON($('#jstree', form).html());
                $tree = $('#jstree', form).jstree({
                    core: {
                        data: eventTypes.jstree,
                        multiple: true
                    },
                    checkbox: {
                        keep_selected_style: false
                    },
                    search: {
                        show_only_matches: true
                    },
                    types: {
                        default: { icon: 'fa fa-hashtag' },
                        parent: { icon: 'clip-folder' },
                    },
                    plugins: ['checkbox', 'types', 'wholerow']
                });

                // initialize fields
                $('#external_id', form).inputHidden();
            }
        };
    }();

    var handleAddSink = function() {
        $('.add-sink-btn').on('click', function(e) {
            e.preventDefault();

            if(!App.checkUserTwilioKeys()) {
                return false;
            }

            Swal.fire({
                title: 'Loading Sink Wizard!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let $btn = $(this);

            appModal = App.modal({
                title: 'Create Sink Instance',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    FormWizard.init(form);

                    // loading phase end
                    Swal.close();
                },
                width: '960',
                footer: false,
                others: { backdrop: 'static', keyboard: false }
            });

        });
    };

    // var handleAddSink = function() {
    //     $('.add-sink-btn').on('click', function(e) {
    //         e.preventDefault();

    //         if(!App.checkUserTwilioKeys()) {
    //             return false;
    //         }

    //         let $btn = $(this);
    //             appModal = App.modal({
    //             title: 'Create Sink Instance',
    //             ajax: {
    //                 url: $btn.attr('href')
    //             },
    //             onShown: function(form) {
    //                 $('#sink_type', form).on('change', function() {
    //                     // console.log($(this).val());
    //                     if($(this).val() == 'kinesis') {
    //                         $('.sink-type .kinesis').show();
    //                         $('.sink-type .webhook').hide();
    //                     } else {
    //                         $('.sink-type .kinesis').hide();
    //                         $('.sink-type .webhook').show();
    //                     }
    //                 });

    //                 $('.form-select2', form).select2()
    //                     .on('select2:select', function (e) {
    //                         if($(this).val()) {
    //                             $(this).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
    //                         }
    //                     });
    //             },
    //             // width: '960',
    //             btn: {
    //                 confirm: {
    //                     text: 'Create Sink',
    //                     onClick: function(form) {
    //                         Swal.fire({
    //                             title: 'Creating Sink Instance',
    //                             allowOutsideClick: false,
    //                             didOpen: () => {
    //                                 Swal.showLoading();

    //                                 $.ajax({
    //                                     url: $btn.attr('href'),
    //                                     method: 'POST',
    //                                     data: form.serialize(),
    //                                     dataType: 'json',
    //                                     success: function(response) {
    //                                         Swal.fire({
    //                                             icon: response.error !== true ? 'success' : 'error',
    //                                             text: response.message
    //                                         });

    //                                         if(!response.error) {
    //                                             appModal.modal('hide');
    //                                             $dtTables['sink-table'].ajax.reload();
    //                                         } else {
    //                                             console.log(response);
    //                                         }
    //                                     }
    //                                 });
    //                             }
    //                         });

    //                         return false;
    //                     }
    //                 }
    //             },
    //             validate: true,
    //             others: { backdrop: 'static', keyboard: false }
    //         })
    //     });
    // }

    var handleEditSink = function() {
        console.log('init handleEditSink');
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();

            let $btn = $(this);

            App.modal({
                title: 'Edit Sink Instance',
                ajax: {
                    url: $btn.attr('href')
                },
                onShow: function(form) {
                    $('#external_id', form).inputHidden();
                },
                btn: {
                    confirm: {
                        text: 'Update Sink Instance',
                        onClick: function(form) {
                            $.ajax({
                                url: $btn.attr('href'),
                                method: 'POST',
                                data: form.serialize(),
                                // dataType: 'json',
                                success: function(response) {
                                    Swal.fire({
                                        icon: response.error !== true ? 'success' : 'error',
                                        text: response.message
                                    });

                                    if(!response.error) {
                                        $dtTables['sink-table'].ajax.reload();
                                    } else {
                                        console.log(response);
                                    }
                                }
                            });
                        }
                    }
                },
                width: '960',
                validate: true
            });
        });
    }

    var handleSubscriptionSink = function() {
        console.log('init handleSubscriptionSink');
        $(document).on('click', '.subscriptions-btn', function(e) {
            e.preventDefault();

            // loading phase start
            Swal.fire({
                title: 'Loading Sink Subscriptions!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            let $btn = $(this), $tree, appModal;

            $.get($btn.attr('href'), function(data) {
                appModal = App.modal({
                    title: 'Sink Subscriptions',
                    body: '<div id="jstree"></div>',
                    onShow: function(form) {
                        let $subscriptions = $('#subscriptions', form);

                        $tree = $('#jstree', form).jstree({
                            core: {
                                data: data.jstree,
                                multiple: true
                            },
                            checkbox: {
                                keep_selected_style: false
                            },
                            search: {
                                show_only_matches: true
                            },
                            types: {
                                default: { icon: 'fa fa-hashtag' },
                                parent: { icon: 'clip-folder' },
                            },
                            plugins: ['checkbox', 'types', 'wholerow']
                        });

                        // loading phase end
                        Swal.close();
                    },
                    btn: {
                        confirm: {
                            text: 'Update Subscription',
                            onClick: function(form) {
                                let selected = $tree.jstree('get_selected');
                                _.pullAll(selected, data.parents);

                                Swal.fire({
                                    title: 'Updating Sink Event Subscription',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();
                                        $.ajax({
                                            url: $btn.attr('href'),
                                            method: 'POST',
                                            data: { subscriptions: selected },
                                            dataType: 'json',
                                            success: function(response) {
                                                if(response.message !== false) {
                                                    Swal.fire({
                                                        icon: response.error !== true ? 'success' : 'error',
                                                        text: response.message
                                                    });
                                                } else {
                                                    Swal.close();
                                                }

                                                if(!response.error) {
                                                    appModal.modal('hide');
                                                } else {
                                                    console.log(response);
                                                }
                                            }
                                        });
                                    }
                                });

                                return false;
                            }
                        }
                    }
                });
            });
        });
    }

    var handleSync = function() {
        EventStream.init('stream', {
            url: '/eventstreams/sync',
            events: [
                {
                    type: 'message',
                    listener: function(data) {
                        let newData = JSON.parse(data);

                        // console.log(newData);

                        _.forEach(newData, function(rowData) {
                            let row = $('tr#' + rowData.id),
                                status = $dtTables['sink-table'].cell($('td:eq(1)', row)).data();

                            if(status != rowData.status) {
                                // trigger table reload
                                $dtTables['sink-table'].ajax.reload();
                            }
                        });
                    }
                }
            ],
            // timeout: 60000
        });

        // setInterval(function() {
        //     $.get('/eventstreams/sync', function() {
        //         $dtTables['sink-table'].ajax.reload();
        //     });
        // }, 60000)
    }

    var handleDeleteSink = function() {
        console.log('init handleDeleteSink');
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            let $btn = $(this);

            Swal.fire({
                icon: 'warning',
                text: 'Are you sure you want to delete this Sink Instance?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return fetch($btn.attr('href')).
                        then(response => {
                            return response.json();
                        });
                }
            }).then((result) => {
                if(result.isConfirmed) {
                    Swal.fire({
                        icon: result.value.error !== true ? 'success' : 'error',
                        text: result.value.message
                    });

                    if(!result.value.error) {
                        $dtTables['sink-table'].ajax.reload();
                    } else {
                        console.log(result.value);
                    }
                }
            });
        });
    }

    return {
        init: function() {
            console.log('Eventstreams.init');

            App.globalPageChecks();

            App.dt.extend();
            App.dt.init({
                id: 'sink-table',
                autoUpdate: 60000,
                settings: {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/eventstreams/get_dt_listing',
                        type: 'post'
                    },
                    columns: [
                        { name: 'description', data: 'description' },
                        { name: 'status', data: 'status' },
                        { name: 'sink_type', data: 'sink_type' },
                        { name: 'sid', data: 'sid' },
                        { name: 'created_at', data: 'created_at' },
                        { name: 'updated_at', data: 'updated_at' },
                        { name: 'options', data: 'id', searchable: false, sortable: false }
                    ],
                    columnDefs: [
                        {
                            targets: 1,
                            render: function(data, type, full, meta) {
                                let labelClass;

                                // initialized (blue), validating (yellow), active (green) or failed (red)}
                                switch (data) {
                                    case 'initialized':
                                        labelClass = 'label-info';

                                        break;

                                    case 'validating':
                                        labelClass = 'label-warning';

                                        break;

                                    case 'active':
                                        labelClass = 'label-success';

                                        break;

                                    case 'failed':
                                        labelClass = 'label-danger';

                                        break;
                                }

                                return '<span class="label ' + labelClass + '">' + data + '</span>';
                            }
                        },
                        {
                            targets: 2,
                            render: function(data, type, full, meta) {
                                let config = $.parseJSON(full.config),
                                    tooltip;

                                if(full.sink_type == "webhook") {
                                    tooltip =
                                        '<div class=\'text-left text-wrap\'>' +
                                            '<b>Destination:</b><br>' + config.sink_configuration.destination + '<br>' +
                                            '<b>Batch Events:</b><br>' + (config.sink_configuration.batch_events ? 'true' : 'false') + '<br>' +
                                            '<b>Method:</b><br>' + config.sink_configuration.method + '<br>' +
                                        '</div>'
                                } else {
                                    tooltip =
                                        '<div class=\'text-left text-wrap\'>' +
                                            '<b>Stream ARN:</b><br>' + config.sink_configuration.arn + '<br>' +
                                            '<b>Role ARN:</b><br>' + config.sink_configuration.role_arn + '<br>' +
                                        '</div>';
                                }

                                return '<span class="label label-' + (full.sink_type == 'webhook' ? 'info' : 'warning') + ' tip" data-html="true" title="' + tooltip + '"> ' + data + '</span>'
                            }
                        },
                        {
                            targets:[4,5],
                            render: function(data, type, full, meta) {
                                let utcTime = moment.tz(data, 'UTC'),
                                    localTime = moment.tz(data, 'UTC').tz(App.timezone),
                                    tooltip =
                                        '<div class=\'text-left\'>' +
                                            '<b>UTC:</b> ' + utcTime.format("MMM DD, YYYY h:mm:ss a") + '<br>' +
                                            '<b>Local:</b> ' + localTime.format("MMM DD, YYYY h:mm:ss a") + '<br>' +
                                        '</div>';

                                if(data) {
                                    return '<span data-html="true" title="' + tooltip + '" class="tip">' + localTime.fromNow() + '</span>';
                                } else {
                                    return '';
                                }
                            }
                        },
                        {
                            targets: 6,
                            width: '15%',
                            render: function(data, type, full, meta) {
                                let config = $.parseJSON(full.config),
                                    options = '<div class="btn-group btn-group-sm">' +
                                    '<a href="/eventstreams/edit/' +  data + '" class="btn btn-primary edit-btn tip" title="Edit"><i class="fa fa-pencil"></i></a>' +
                                    '<a href="' +
                                        (!_.isEmpty(config.data_view_url) ? config.data_view_url : '#') +
                                        '" target="_blank" class="btn btn-primary tip ' +
                                        (!_.isEmpty(config.data_view_url) ? '' : 'disabled') + '" title="Data View URL">' +
                                        (!_.isEmpty(config.data_view_url) ? '<i class="fa fa-eye"></i>' : '<i class="fa fa-eye-slash"></i>') +
                                    '</a>' +
                                    '<a href="/eventstreams/subscriptions/' +  data + '" class="btn btn-primary subscriptions-btn ' + (full.status != 'active' ? 'disabled' : '') + ' tip" title="Edit Subscriptions"><i class="fa fa-sliders"></i></a>' +
                                    '<a href="/eventstreams/delete/' +  data + '" class="btn btn-danger delete-btn tip" title="Delete"><i class="fa fa-trash-o"></i></a>' +
                                '</div>';

                                return options;
                            }
                        }
                    ],
                    fnCreatedRow: function (nRow, aData, iDataIndex) {
                        // add id to row
                        $(nRow).attr('id', aData.id);

                        // init tooltips in row
                        $('.tip', nRow).tooltip();
                    },
                    fnInitComplete: function(settings, json) {
                        // handleSync();
                    }
                }
            });

            App.validationSetDefault();
            handleAddSink();
            handleEditSink();
            handleSubscriptionSink();
            handleDeleteSink();
        }
    }
}();

jQuery(document).ready(function() {
    Eventstreams.init();
});