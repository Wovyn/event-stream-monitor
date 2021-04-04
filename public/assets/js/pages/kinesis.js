var Kinesis = function() {
    var appModal;
    var FormWizard = function() {
        let wizard, wizardForm;

        var initWizard = function(form) {
            wizard = $('#smartwizard', form);

            wizard.smartWizard({
                selected: 0,
                justified: true,
                enableURLhash: false,
                autoAdjustHeight: false,
                toolbarSettings: {
                    toolbarExtraButtons: [
                        $('<button type="button" class="btn btn-finish btn-success hidden">Create Data Stream</button>')
                            .on('click', function() {
                                $(this).addClass('disabled');

                                Swal.fire({
                                    title: 'Creating Data Stream',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();

                                        $.ajax({
                                            url: '/kinesis/add',
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
                                                    $dtTables['kinesis-table'].ajax.reload();
                                                } else {
                                                    console.log(response);
                                                }
                                            }
                                        });
                                    }
                                });
                            })
                    ]
                }
            });

            // html class fix
            $('.toolbar', wizard).addClass('modal-footer');

            // on leaveSte
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
                if(nextStepIndex == 3) {
                    generateSummary(form);

                    $('.sw-btn-next', form).addClass('hidden');
                    $('.btn-finish', form).removeClass('hidden');
                } else {
                    $('.sw-btn-next', form).removeClass('hidden');
                    $('.btn-finish', form).addClass('hidden');
                }

                animateBar(nextStepIndex);
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
                formValues = form.serializeArray(),
                summary = '';

            summaryEl.empty();

            _.forEach(formValues, function(data) {

                switch(data.name) {
                    case 'region':
                        data.value = $('#region option:selected', form).html() + ' | ' + data.value;

                        break;
                }

                summary += '<div class="form-group">' +
                    '<label class="control-label text-capitalize text-bold">' + data.name + ':</label>' +
                    '<p class="form-control-static display-value">' + data.value + '</p>' +
                    '</div>';
            });

            $('.summary', form).append(summary);
        }

        return {
            init: function(form) {
                initWizard(form);

                $('#shards', form).on('change keyup', function() {
                    let shards = $(this).val(),
                        writeMiB = shards * 1,
                        writeData = shards * 1000,
                        readMiB = shards * 2;

                    $('.write-calculated-mib', form).html(writeMiB);
                    $('.write-calculated-data', form).html(writeData);
                    $('.read-calculated-mib', form).html(readMiB);
                });
            }
        };
    }();

    var handleAddStream = function() {
        $('.add-stream-btn').on('click', function(e) {
            e.preventDefault();

            if(!App.checkUserAuthKeys()) {
                return false;
            }

            let $btn = $(this);

            appModal = App.modal({
                title: 'Create Data Stream',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    FormWizard.init(form);
                },
                width: '960',
                footer: false,
                others: { backdrop: 'static', keyboard: false }
            });
        });
    }

    var handleViewStream = function() {
        console.log('init handleViewStream');
        $(document).on('click', '.view-btn', function(e) {
            e.preventDefault();

            let $btn = $(this),
                $row = $btn.parents('tr').get(0),
                data = $dtTables['kinesis-table'].row($row).data();

            App.modal({
                title: data.name + ' - Stream Summary',
                ajax: {
                    url: $btn.attr('href')
                },
                btn: {
                    confirm: {
                        class: 'hidden'
                    },
                    cancel: {
                        text: 'Close'
                    }
                }
            })
        });
    }

    var handleDeleteStream = function() {
        console.log('init handleDeleteStream');
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            let $btn = $(this);

            Swal.fire({
                icon: 'warning',
                text: 'Are you sure you want to delete this Data Stream?',
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
                        $dtTables['kinesis-table'].ajax.reload();
                    } else {
                        console.log(result.value);
                    }
                }
            });
        });
    }

    return {
        init: function() {
            console.log('Kinesis.init');

            App.checkUserAuthKeys();

            App.dt.extend();
            App.dt.init({
                id: 'kinesis-table',
                autoUpdate: 60000,
                settings: {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/kinesis/get_dt_listing',
                        type: 'post'
                    },
                    columns: [
                        { name: 'region', data: 'region_name' },
                        { name: 'name', data: 'name' },
                        { name: 'shards', data: 'shards' },
                        { name: 'created_at', data: 'created_at' },
                        { name: 'updated_at', data: 'updated_at' },
                        { name: 'options', data: 'id', searchable: false, sortable: false }
                    ],
                    columnDefs: [
                        {
                            targets: 0,
                            render: function(data, type, full, meta) {
                                return '<span data-html="true" title="' + full.region + '" class="tip">' + data + '</span>';
                            }
                        },
                        {
                            targets:[3,4],
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
                            targets: 5,
                            width: '12.5%',
                            render: function(data, type, full, meta) {
                                let options =
                                    '<div class="btn-group btn-group-sm">' +
                                        // '<a href="/kinesis/edit/' +  data + '" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>' +
                                        '<a href="/kinesis/view/' +  data + '" class="btn btn-primary view-btn"><i class="fa fa-eye"></i></a>' +
                                        '<a href="/kinesis/delete/' +  data + '" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i></a>' +
                                    '</div>';

                                return options;
                            }
                        }
                    ],
                    fnCreatedRow: function (nRow, aData, iDataIndex) {
                        console.log('fnCreatedRow');
                        $('.tip', nRow).tooltip();
                    }
                }
            });

            App.validationSetDefault();
            handleAddStream();
            handleDeleteStream();
            handleViewStream();
        }
    }
}();

jQuery(document).ready(function() {
    Kinesis.init();
});