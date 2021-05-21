var Elasticsearch = function() {
    var appModal,
        FormWizard = function() {
        let wizard, wizardForm, lastStep, editor, mode;

        return {
            init: function(form, submitUrl, action) {
                mode = action;

                wizard = $('#smartwizard', form);
                lastStep = $('.nav li', wizard).length - 1;

                let button = '<button type="button" class="btn btn-finish btn-success hidden">' + (mode == 'create' ? 'Create Elasticsearch' : 'Update Elasticsearch') + '</button>',
                    wSettings = {
                        selected: 0,
                        justified: true,
                        enableURLhash: false,
                        autoAdjustHeight: false,
                        keyboardSettings: { keyNavigation: false },
                        toolbarSettings: {
                            toolbarExtraButtons: [
                                $(button)
                                    .on('click', function() {
                                        let $btn = $(this);

                                        $btn.addClass('disabled');

                                        Swal.fire({
                                            title: (mode == 'create' ? 'Creating Elasticsearch' : 'Updating Elasticsearch'),
                                            allowOutsideClick: false,
                                            didOpen: () => {
                                                Swal.showLoading();

                                                $.ajax({
                                                    url: submitUrl,
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
                                                            $dtTables['elasticsearch-table'].ajax.reload();
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
                    };

                if(mode == 'update') {
                    wSettings.anchorSettings = {
                            anchorClickable: true, // Enable/Disable anchor navigation
                            enableAllAnchors: true, // Activates all anchors clickable all times
                            markDoneStep: true, // add done css
                            enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
                        };
                }

                wizard.smartWizard(wSettings);

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

                    // get certificates and setup custom domain endpoint
                    if(nextStepIndex == 1) {
                        let currentRegion = $('#aws_certificate', form).data('region');

                        // check if region has been changed
                        if($('#region option:selected', form).val() != currentRegion) {
                            // set loading
                            $('#aws_certificate', form).parent().addClass('loading');

                            // reset options
                            $('#aws_certificate', form).html('').select2({data: [{id: '', text: ''}]});

                            // reset custom hostname
                            $('#custom_hostname', form).val('');

                            // set current region
                            $('#aws_certificate', form).data('region', $('#region option:selected', form).val());

                            // update options
                            fetch('/elasticsearch/certificates/' + $('#region option:selected', form).val())
                                .then(response => response.json())
                                .then(data => {
                                    let options = [ { id: '', text: '' } ];

                                    if(data.certificates.length) {
                                        _.forEach(data.certificates, function(certificate, key) {
                                            options.push({ id: certificate.CertificateArn, text: certificate.DomainName, selected: false });
                                        });
                                    }

                                    // update options
                                    $('#aws_certificate', form).select2({
                                        placeholder: 'Select an AWS Certificate',
                                        data: options
                                    });

                                    $('#aws_certificate', form).parent().removeClass('loading');
                                });
                        }
                    }

                    // set access policy json after step 2
                    if(nextStepIndex == 2) {
                        // generate access_policy json
                        FormWizard.updatePolicy();
                    }

                    if(nextStepIndex == 3) {
                        // process access_policy
                        // $('#access_policy', form).val(editor.getValue());
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

                // init select2 elements
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

                // enable custom domain
                App.customs.activeToggle({
                    btn: $('#custom_endpoint', form),
                    elements: [ $('#custom_endpoint_container', form) ]
                });

                // dedicated master nodes
                App.customs.activeToggle({
                    btn: $('#dedicated_master_nodes', form),
                    elements: [ $('#dedicated_container', form) ]
                });

                // ultrawarm data nodes
                App.customs.activeToggle({
                    btn: $('#ultrawarm_data_node', form),
                    elements: [ $('#ulrawarm_container', form) ]
                });

                // update number of nodes validation rule when availability zone changes
                $('.availability_zones', form).on('click', function() {
                    $('#number_of_nodes', form).rules('remove', 'multiple-of');
                    $('#number_of_nodes', form).rules('add', { 'multiple-of': $(this).val() });
                });

                $('#ebs_volume_type', form).select2()
                    .on('select2:select', function (e) {
                        $('#provisioned-iops-field', form).hide();

                        switch($(this).val()) {
                            case 'gp2':
                                $('#ebs_storage_size_per_node', form).rules('remove', 'min max');
                                $('#ebs_storage_size_per_node', form).rules('add', {
                                    min: 10,
                                    max: 1024
                                });

                                break;

                            case 'io1':
                                $('#ebs_storage_size_per_node', form).rules('remove', 'min max');
                                $('#ebs_storage_size_per_node', form).rules('add', {
                                    min: 35,
                                    max: 1024
                                });

                                $('#provisioned-iops-field', form).show();

                                break;

                            case 'standard':
                                $('#ebs_storage_size_per_node', form).rules('remove', 'min max');
                                $('#ebs_storage_size_per_node', form).rules('add', {
                                    min: 10,
                                    max: 100
                                });

                                break;

                        }
                    });

                // fine grained access control
                App.customs.activeToggle({
                    btn: $('#fine_grain_access_control', form),
                    elements: [ $('#fine_grain_options_container', form), $('#allow_open_access_container', form) ],
                    // callback: function(btn, elements) {
                    //     if(!btn.is(':checked') && $('#allow_open_access', form).is(':checked')) {
                    //         $('#allow_open_access', form).prop('checked', false);

                    //         FormWizard.updatePolicy();
                    //     }
                    // }
                });

                $('#fine_grain_access_control', form).on('click', function() {
                    if($(this).is(':checked')) {
                        $('#note_to_node_encryption', form).rules('add', 'required');
                        $('#enable_encryption_of_data_at_rest   ', form).rules('add', 'required');
                    } else {
                        $('#note_to_node_encryption', form).rules('remove', 'required');
                        $('#enable_encryption_of_data_at_rest   ', form).rules('remove', 'required');
                    }
                });

                // init access policy
                editor = ace.edit($('#access_policy_json', form)[0]);
                editor.setTheme("ace/theme/xcode");
                editor.session.setMode("ace/mode/json");

                editor.session.on('change', function(delta) {
                    $('#access_policy', form).val(editor.getValue());
                });

                // get IP address
                fetch('https://api.ipify.org/?format=json')
                    .then(response => response.json())
                    .then(data => {
                        $('#ip_address', form).val(data.ip);
                    });

                // init allow open access
                // $('#allow_open_access', form).on('click', function() {
                //     FormWizard.updatePolicy();
                // });

                if(mode == 'update') {
                    // set region to readonly
                    $("#region").select2({disabled: 'readonly'});

                    // update certificate options
                    fetch('/elasticsearch/certificates/' + $('#region option:selected', form).val())
                        .then(response => response.json())
                        .then(data => {
                            let options = [];

                            if(data.certificates.length) {
                                _.forEach(data.certificates, function(certificate, key) {
                                    options.push({ id: certificate.CertificateArn, text: certificate.DomainName, selected: false });
                                });
                            }

                            // update options
                            $('#aws_certificate', form).select2({
                                placeholder: 'Select an AWS Certificate',
                                data: options
                            });

                            $('#aws_certificate', form).parent().removeClass('loading');

                            $('#aws_certificate', form).val($('#aws_certificate', form).data('selected'));
                            $('#aws_certificate', form).trigger('change');
                        });

                    _.forEach($('.form-select2'), function(element, key) {
                        let selected = $(element).data('selected');

                        if(!_.isEmpty(selected)) {
                            $(element).val(selected);
                            $(element).trigger('change');
                        }
                    });

                    editor.setValue(JSON.stringify(JSON.parse($('#access_policy', form).val()), null, 2));
                }
            },
            updatePolicy: function(form) {
                let aws_account = $('#aws_account', form).val(),
                    region = $('#region option:selected', form).val(),
                    domain_name = $('#domain_name', form).val(),
                    ip_address = $('#ip_address', form).val(),
                    policy = {
                        "Version": "2012-10-17",
                        "Statement": [
                            {
                                "Effect": "Allow",
                                "Principal": {
                                    "AWS": "*"
                                },
                                "Action": [
                                    "es:*"
                                ],
                                "Resource": 'arn:aws:es:' + region + ':' + aws_account + ':domain/' + domain_name + '/*',
                                "Condition": {
                                    "IpAddress": {
                                        "aws:SourceIp": ip_address
                                    }
                                }
                            }
                        ]
                    };

                editor.setValue(JSON.stringify(policy, null, 2));
            },
            generateSummary: function(form) {
                // console.log(form.serializeArray());
                let formValues = form.serializeArray(),
                    fieldTemplate = _.template('<div class="form-group">' +
                        '<label class="control-label text-capitalize text-bold"><%= name %>:</label>' +
                        '<p class="form-control-static display-value"><%= value %></p>' +
                        '</div>'),
                    prefieldTemplate = _.template('<div class="form-group">' +
                        '<label class="control-label text-capitalize text-bold"><%= name %>:</label>' +
                        '<pre class="form-control-static display-value"><%= value %></pre>' +
                        '</div>');

                let detailsField = $('#details-field', form),
                    dataNodesField = $('#data-nodes-field', form),
                    dedicatedInstancesField = $('#dedicated-instances-field', form),
                    networkConfigField = $('#network-confi-field', form),
                    accessPolicyField = $('#access-policy-field', form);

                detailsField.empty().append('<legend class="border-0">Details:</legend>');
                dataNodesField.empty().append('<legend class="border-0">Data Nodes:</legend>');
                dedicatedInstancesField.empty().append('<legend class="border-0">Dedicated Instances:</legend>');
                networkConfigField.empty().append('<legend class="border-0">Network Configuration:</legend>');
                accessPolicyField.empty().append('<legend class="border-0">Access Policy:</legend>');

                _.forEach(formValues, function(data) {

                    // append detail fields
                    if(_.findIndex(['region', 'domain_name', 'aws_certificate', 'custom_hostname', 'auto_tune'], d => d == data.name) != -1) {
                        let toAppend = true;

                        if(data.name == 'region') {
                            data.value = $('#region option:selected', form).html() + ' | ' + data.value;
                        }

                        if(data.name == 'aws_certificate' && !$('#custom_endpoint', form).is(':checked')) {
                            toAppend = false;
                        }

                        if(data.name == 'custom_hostname' && !$('#custom_endpoint', form).is(':checked')) {
                            toAppend = false;
                        }

                        if(toAppend) {
                            detailsField.append(
                                fieldTemplate({
                                    name: _.startCase(data.name),
                                    value: data.value
                                })
                            );
                        }
                    }

                    // append data node fields
                    if(_.findIndex(['availability_zones', 'instance_type', 'number_of_nodes', 'ebs_volume_type', 'ebs_storage_size_per_node', 'provisioned_iops'], d => d == data.name) != -1) {
                        let toAppend = true;

                        if(data.name == 'provisioned_iops' && $('#ebs_volume_type', form).val() != 'io1') {
                            toAppend = false;
                        }

                        if(toAppend) {
                            dataNodesField.append(
                                fieldTemplate({
                                    name: _.startCase(data.name),
                                    value: data.value
                                })
                            );
                        }
                    }

                    // dedicated instances fields
                    if(_.findIndex(['dedicated_master_nodes', 'dedicated_master_node_instance_type', 'dedicated_master_node_number_of_nodes', 'ultrawarm_data_node', 'ultrawarm_instance_type', 'number_of_warm_data_nodes'], d => d == data.name) != -1) {
                        let toAppend = true;

                        if(_.findIndex(['dedicated_master_node_instance_type', 'dedicated_master_node_number_of_nodes'], d => d == data.name) != -1 && !$('#dedicated_master_nodes', form).is(':checked')) {
                            toAppend = false;
                        }

                        if(_.findIndex(['ultrawarm_instance_type', 'number_of_warm_data_nodes'], d => d == data.name) != -1 && !$('#ultrawarm_data_node', form).is(':checked')) {
                            toAppend = false;
                        }

                        if(toAppend) {
                            dedicatedInstancesField.append(
                                fieldTemplate({
                                    name: _.startCase(data.name),
                                    value: data.value
                                })
                            );
                        }
                    }

                    // network config fields
                    if(_.findIndex(['network_configuration','fine_grain_access_control', 'master_username', 'require_https', 'note_to_node_encryption', 'enable_encryption_of_data_at_rest'], d => d == data.name) != -1) {
                        let toAppend = true;

                        if(data.name == 'master_username' && !$('#fine_grain_access_control', form).is(':checked')) {
                            toAppend = false;
                        }

                        if(toAppend) {
                            networkConfigField.append(
                                fieldTemplate({
                                    name: _.startCase(data.name),
                                    value: data.value
                                })
                            );
                        }
                    }

                    // network config fields
                    if(_.findIndex(['access_policy'], d => d == data.name) != -1) {
                        let toAppend = true;

                        if(data.name == 'access_policy') {
                            accessPolicyField.append(
                                prefieldTemplate({
                                    name: _.startCase(data.name),
                                    value: data.value
                                })
                            );

                            toAppend = false;
                        }

                        if(toAppend) {
                            accessPolicyField.append(
                                fieldTemplate({
                                    name: _.startCase(data.name),
                                    value: data.value
                                })
                            );
                        }
                    }
                });
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
                title: 'Loading Elasticsearch Wizard',
                allowOutsideClick: false
            });

            Swal.showLoading();

            appModal = App.modal({
                title: 'Create Elasticsearch Domain',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    // end loading phase
                    Swal.close();

                    FormWizard.init(form, $btn.attr('href'), 'create');
                },
                width: '1060',
                footer: false,
                others: { backdrop: 'static', keyboard: false }
            });
        });
    }

    var handleEdit = function() {
        console.log('init handleEdit');
        $(document).on('click', '.edit-btn', function(e) {
            e.preventDefault();

            let $btn = $(this),
                $row = $btn.parents('tr').get(0),
                data = $dtTables['elasticsearch-table'].row($row).data();

            // add loading phase
            Swal.fire({
                title: 'Loading Elasticsearch Wizard',
                allowOutsideClick: false
            });

            Swal.showLoading();

            appModal = App.modal({
                title: 'Edit ' + data.domain_name + ' Domain Configuration',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    // end loading phase
                    Swal.close();

                    FormWizard.init(form, $btn.attr('href'), 'update');
                },
                width: '1060',
                footer: false,
                others: { backdrop: 'static', keyboard: false }
            });
        });
    };

    var handleView = function() {
        console.log('init handleView');
        $(document).on('click', '.view-btn', function(e) {
            e.preventDefault();

            let $btn = $(this),
                $row = $btn.parents('tr').get(0),
                data = $dtTables['elasticsearch-table'].row($row).data();

            App.modal({
                title: data.domain_name + ' - Summary',
                ajax: {
                    url: $btn.attr('href')
                },
                width: '1060',
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

    var handleDelete = function() {
        console.log('init handleDelete');
        $(document).on('click', '.delete-btn', function(e) {
            e.preventDefault();

            let $btn = $(this);

            Swal.fire({
                icon: 'warning',
                text: 'Are you sure you want to delete the Domain?',
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
                        $dtTables['elasticsearch-table'].ajax.reload();
                    } else {
                        console.log(result.value);
                    }
                }
            });
        });
    }

    var handleSync = function() {
        EventStream.init('stream', {
            url: '/elasticsearch/sync',
            events: [
                {
                    type: 'message',
                    listener: function(data) {
                        let newData = JSON.parse(data);

                        _.forEach(newData, function(rowData) {
                            let row = $('tr#' + rowData.id),
                                status = $dtTables['elasticsearch-table'].cell($('td:eq(2)', row)).data();

                            if(status != rowData.status) {
                                // trigger table reload
                                $dtTables['elasticsearch-table'].ajax.reload();
                            }
                        });
                    }
                }
            ],
            timeout: 60000
        });
    }

    return {
        init: function() {
            console.log('Elasticsearch.init');

            App.globalPageChecks();

            App.dt.extend();
            App.dt.init({
                id: 'elasticsearch-table',
                autoUpdate: 60000,
                settings: {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/elasticsearch/get_dt_listing',
                        type: 'post'
                    },
                    columns: [
                        { name: 'region', data: 'region_name' },
                        { name: 'domain_name', data: 'domain_name' },
                        { name: 'status', data: 'status' },
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
                            targets: 2,
                            render: function(data, type, full, meta) {
                                let label;

                                switch(data) {
                                    case 'loading':
                                        label = 'warning';
                                        break;

                                    case 'updating':
                                        label = 'info';
                                        break;

                                    default:
                                        label = 'success';
                                        break;
                                }

                                return '<span class="label label-' + label + '">' + data + '</span>';
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
                            width: '10%',
                            render: function(data, type, full, meta) {
                                let options = _.template(
                                     '<div class="btn-group btn-group-sm">' +
                                        '<a href="/elasticsearch/edit/<%= id %>" class="btn btn-primary edit-btn tip <% if(disabled) { %> disabled <% } %>" title="Edit"><i class="fa fa-pencil"></i></a>' +
                                        // '<a href="/elasticsearch/view/<%= id %>" class="btn btn-primary view-btn tip" title="View"><i class="fa fa-eye"></i></a>' +
                                        '<a href="/elasticsearch/delete/<%= id %>" class="btn btn-danger delete-btn tip" title="Delete"><i class="fa fa-trash-o"></i></a>' +
                                    '</div>'
                                );

                                return options({
                                    id: data,
                                    disabled: (full.status == 'loading' ? true : false)
                                });
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

            handleAdd();
            handleDelete();
            handleEdit();
            handleView();
        }
    }
}();

jQuery(document).ready(function() {
    Elasticsearch.init();
});