var Eventstreams = function() {

    var handleAddSink = function() {
        $('.add-sink-btn').on('click', function(e) {
            e.preventDefault();

            if(!App.checkUserTwilioKeys()) {
                return false;
            }

            let $btn = $(this),
                appModal = App.modal({
                title: 'Create Sink Instance',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
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

                    $('.form-select2', form).select2()
                        .on('select2:select', function (e) {
                            if($(this).val()) {
                                $(this).closest('.form-group').removeClass('has-error').addClass('has-success').find('.symbol').removeClass('required').addClass('ok');
                            }
                        });
                },
                // width: '960',
                btn: {
                    confirm: {
                        text: 'Create Sink',
                        onClick: function(form) {
                            Swal.fire({
                                title: 'Creating Sink Instance',
                                allowOutsideClick: false,
                                didOpen: () => {
                                    Swal.showLoading();

                                    $.ajax({
                                        url: $btn.attr('href'),
                                        method: 'POST',
                                        data: form.serialize(),
                                        dataType: 'json',
                                        success: function(response) {
                                            Swal.fire({
                                                icon: response.error !== true ? 'success' : 'error',
                                                text: response.message
                                            });

                                            if(!response.error) {
                                                appModal.modal('hide');
                                                $dtTables['sink-table'].ajax.reload();
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
                },
                validate: true,
                others: { backdrop: 'static', keyboard: false }
            })
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

            App.checkUserTwilioKeys();
            App.checkUserDefaults();

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
                            targets:[4,5],
                            render: function(data, type, full, meta) {
                                let utcTime = moment.tz(data, 'UTC'),
                                    localTime = moment.tz(data, 'UTC').tz(App.timezone),
                                    tooltip =
                                        '<div class=\'text-left\'>' +
                                            '<b>UTC:</b> ' + utcTime.format("MMM DD, YYYY h:mm:ss a") + '<br/>' +
                                            '<b>Local:</b> ' + localTime.format("MMM DD, YYYY h:mm:ss a") + '<br/>' +
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
                            width: '10%',
                            render: function(data, type, full, meta) {
                                let options =
                                    '<div class="btn-group btn-group-sm">' +
                                        '<a href="/eventstreams/subscriptions/' +  data + '" class="btn btn-primary subscriptions-btn ' + (full.status != 'active' ? 'disabled' : '') + '"><i class="fa fa-sliders"></i></a>' +
                                        '<a href="/eventstreams/delete/' +  data + '" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i></a>' +
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
                        handleSync();
                    }
                }
            });

            App.validationSetDefault();
            handleAddSink();
            handleSubscriptionSink();
            handleDeleteSink();
        }
    }
}();

jQuery(document).ready(function() {
    Eventstreams.init();
});