var Firehose = function() {
    var appModal;
    var FormWizard = function() {
        let wizard, wizardForm, lastStep;

        return {
            init: function(form) {
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
                            $('<button type="button" class="btn btn-finish btn-success hidden">Create Delivery Stream</button>')
                                .on('click', function() {
                                    let $btn = $(this);

                                    $btn.addClass('disabled');

                                    Swal.fire({
                                        title: 'Creating Delivery Stream',
                                        allowOutsideClick: false,
                                        didOpen: () => {
                                            Swal.showLoading();

                                            $.ajax({
                                                url: '/firehose/add',
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
                                                        $dtTables['firehose-table'].ajax.reload();
                                                    } else {
                                                        $btn.removeClass('disabled');
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

                FormWizard.initElements(form);
            },
            animateBar: function(step) {
                if (_.isUndefined(step)) {
                    step = 0;
                };

                numberOfSteps = $('.swMain > .nav > li').length;
                var valueNow = Math.floor(100 / numberOfSteps * (step + 1));
                $('.step-bar').css('width', valueNow + '%');
            },
            initElements: function(form) {
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
                        FormWizard.generateSummary(form);

                        $('.sw-btn-next', form).addClass('hidden');
                        $('.btn-finish', form).removeClass('hidden');
                    } else {
                        $('.sw-btn-next', form).removeClass('hidden');
                        $('.btn-finish', form).addClass('hidden');
                    }

                    FormWizard.animateBar(nextStepIndex);
                });

                // on showStep
                wizard.on('showStep', function(e, anchorObject, stepIndex, stepDirection) {
                    appModal.modal('layout');
                });

                // initialize animateBar
                FormWizard.animateBar();

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

                // custom inits
                $('#region', form).select2()
                    .on('select2:select', function (e) {
                        let kinesis = JSON.parse($('#kinesis').val()),
                            domains = JSON.parse($('#domains').val());

                        // console.log($(this).val());
                        // console.log(kinesis[$(this).val()]);
                        // console.log(domains[$(this).val()]);
                        // {id: null, text: null}

                        $('#kinesis_id', form).html('').select2({data: [{id: '', text: ''}]});
                        $('#kinesis_id', form).select2({
                            placeholder: 'Select a Kinesis Data Stream',
                            data: (_.isUndefined(kinesis[$(this).val()]) ? [{id: null, text: null}] : kinesis[$(this).val()])
                        });

                        $('#elasticsearch_id', form).html('').select2({data: [{id: '', text: ''}]});
                        $('#elasticsearch_id', form).select2({
                            placeholder: 'Select a Domain',
                            data: (_.isUndefined(domains[$(this).val()]) ? [{id: null, text: null}] : domains[$(this).val()])
                        });
                    });
            },
            generateSummary: function(form) {
                let summaryEl = $('.summary', form),
                    formValues = form.serializeArray(),
                    summary = '',
                    fieldTemplate = _.template('<div class="form-group">' +
                        '<label class="control-label text-capitalize text-bold"><%= name %>:</label>' +
                        '<p class="form-control-static display-value"><%= value %></p>' +
                        '</div>');

                summaryEl.empty();

                _.forEach(formValues, function(data) {

                    switch(data.name) {
                        case 'region':
                            data.value = $('#region option:selected', form).html() + ' | ' + data.value;

                            break;

                        case 'kinesis_id':
                            data.name = 'Kinesis Data Stream';
                            data.value = $('#kinesis_id option:selected', form).html();

                            break;

                        case 'elasticsearch_id':
                            data.name = 'Elasticsearch Domain';
                            data.value = $('#elasticsearch_id option:selected', form).html();

                            break;
                    }

                    summary += fieldTemplate({
                        name: _.startCase(data.name),
                        value: data.value
                    });
                });

                summaryEl.append(summary);
            }
        };
    }();

    var handleAdd = function() {
        $('.add-btn').on('click', function(e) {
            e.preventDefault();

            if(!App.checkUserAwsKeys()) {
                return false;
            }

            let $btn = $(this);

            // add loading phase
            Swal.fire({
                title: 'Loading Firehose Wizard',
                allowOutsideClick: false
            });

            Swal.showLoading();

            appModal = App.modal({
                title: 'Create Firehose Stream',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    // end loading phase
                    Swal.close();

                    FormWizard.init(form);
                },
                width: '960',
                footer: false,
                others: { backdrop: 'static', keyboard: false }
            });
        });
    }

    var handleDelete = function() {
        console.log('init handleDelete');
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            let $btn = $(this);

            Swal.fire({
                icon: 'warning',
                text: 'Are you sure you want to delete the Delivery Stream?',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
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
                        $dtTables['firehose-table'].ajax.reload();
                    } else {
                        console.log(result.value);
                    }
                }
            });
        });
    }

    var handleView = function() {
        console.log('init handleView');
        $(document).on('click', '.view-btn', function(e) {
            e.preventDefault();

            let $btn = $(this),
                $row = $btn.parents('tr').get(0),
                data = $dtTables['firehose-table'].row($row).data();

            App.modal({
                title: data.name + ' - Deliver Stream Summary',
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

    return {
        init: function() {
            console.log('Firehose.init');

            App.globalPageChecks();

            App.dt.extend();
            App.dt.init({
                id: 'firehose-table',
                autoUpdate: 60000,
                settings: {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/firehose/get_dt_listing',
                        type: 'post'
                    },
                    columns: [
                        { name: 'region', data: 'region_name' },
                        { name: 'firehose_name', data: 'firehose_name' },
                        { name: 'kinesis_name', data: 'kinesis_name' },
                        { name: 'elasticsearch_name', data: 'elasticsearch_name' },
                        { name: 'firehose_created_at', data: 'firehose_created_at' },
                        { name: 'firehose_updated_at', data: 'firehose_updated_at' },
                        { name: 'options', data: 'firehose_id', searchable: false, sortable: false }
                    ],
                    columnDefs: [
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
                                let options = _.template(
                                     '<div class="btn-group btn-group-sm">' +
                                        // '<a href="/firehose/edit/<%= id %>" class="btn btn-primary edit-btn tip" title="Edit"><i class="fa fa-pencil"></i></a>' +
                                        '<a href="/firehose/view/<%= id %>" class="btn btn-primary view-btn tip" title="View"><i class="fa fa-eye"></i></a>' +
                                        '<a href="/firehose/delete/<%= id %>" class="btn btn-danger delete-btn tip" title="Delete"><i class="fa fa-trash-o"></i></a>' +
                                    '</div>'
                                );

                                return options({
                                    id: data
                                });
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
            handleAdd();
            handleDelete();
            handleView();
        }
    }
}();

jQuery(document).ready(function() {
    Firehose.init();
});