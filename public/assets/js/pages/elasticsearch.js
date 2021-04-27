var Elasticsearch = function() {
    var appModal,
        FormWizard = function() {
        let wizard, wizardForm, lastStep, editor;

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
                        $('<button type="button" class="btn btn-finish btn-success hidden">Create Elasticsearch</button>')
                            .on('click', function() {
                                $(this).addClass('disabled');

                                Swal.fire({
                                    title: 'Creating Elasticsearch',
                                    allowOutsideClick: false,
                                    didOpen: () => {
                                        Swal.showLoading();

                                        $.ajax({
                                            url: '/elasticsearch/add',
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

                // set access policy json after step 2
                if(nextStepIndex == 2) {
                    fetch('https://api.ipify.org/?format=json')
                        .then(response => response.json())
                        .then(data => {
                            // generate default access_policy json
                            let aws_account = $('#aws_account').val(),
                                region = $('#region option:selected', form).html(),
                                domain_name = $('#domain_name', form).val(),
                                default_policy = {
                                    "Version":"2012-10-17",
                                    "Statement":[
                                        {
                                            "Effect":"Allow",
                                            "Principal":{
                                                "AWS":"*"
                                            },
                                            "Action":"es:*",
                                            "Resource":"arn:aws:es:us-east-1:" + aws_account + ":domain/" + domain_name + "/*",
                                            "Condition":{
                                                "IpAddress":{
                                                    "aws:SourceIp":data.ip
                                                }
                                            }
                                        }
                                    ]
                                };

                            editor.setValue(JSON.stringify(default_policy, null, 4));
                        });
                }

                if(nextStepIndex == 3) {
                    // process access_policy
                    // $('#access_policy', form).val(editor.getValue());
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

            // init access policy
            editor = ace.edit($('#access_policy_json', form)[0]);
            editor.setTheme("ace/theme/xcode");
            editor.session.setMode("ace/mode/json");

            editor.session.on('change', function(delta) {
                $('#access_policy', form).val(editor.getValue());
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
            let formValues = form.serializeArray(),
                summary = '',
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
                if(_.findIndex(['region', 'domain_name', 'auto_tune'], d => d == data.name) != -1) {
                    if(data.name == 'region') {
                        data.value = $('#region option:selected', form).html() + ' | ' + data.value;
                    }

                    detailsField.append(
                        fieldTemplate({
                            name: _.startCase(data.name),
                            value: data.value
                        })
                    );
                }

                // append data node fields
                if(_.findIndex(['availability_zones', 'instance_type', 'number_of_nodes', 'ebs_volume_type', 'ebs_storage_size_per_node'], d => d == data.name) != -1) {
                    dataNodesField.append(
                        fieldTemplate({
                            name: _.startCase(data.name),
                            value: data.value
                        })
                    );
                }

                // dedicated instances fields
                if(_.findIndex(['dedicated_master_nodes', 'dedicated_master_node_instance_type', 'dedicated_master_node_number_of_nodes', 'ultrawarm_data_node', 'number_of_warm_data_nodes'], d => d == data.name) != -1) {
                    dedicatedInstancesField.append(
                        fieldTemplate({
                            name: _.startCase(data.name),
                            value: data.value
                        })
                    );
                }

                // network config fields
                if(_.findIndex(['network_configuration', 'require_https', 'note_to_node_encryption'], d => d == data.name) != -1) {
                    networkConfigField.append(
                        fieldTemplate({
                            name: _.startCase(data.name),
                            value: data.value
                        })
                    );
                }

                // network config fields
                if(_.findIndex(['access_policy'], d => d == data.name) != -1) {
                    accessPolicyField.append(
                        prefieldTemplate({
                            name: _.startCase(data.name),
                            value: data.value
                        })
                    );
                }
            });

            // _.forEach(formValues, function(data) {
            //     switch(data.name) {
            //         case 'region':
            //             data.value = $('#region option:selected', form).html() + ' | ' + data.value;

            //             summary += fieldTemplate({
            //                 name: _.startCase(data.name),
            //                 value: data.value
            //             });

            //             break;

            //         case 'access_policy':
            //             summary += prefieldTemplate({
            //                 name: _.startCase(data.name),
            //                 value: data.value
            //             });

            //             break;

            //         default:
            //             summary += fieldTemplate({
            //                 name: _.startCase(data.name),
            //                 value: data.value
            //             });

            //             break;
            //     }
            // });

            $('.summary', form).append(summary);
        }

        return {
            init: function(form) {
                initWizard(form);

                // $('#shards', form).on('change', function() {
                //     let shards = $(this).val(),
                //         writeMiB = shards * 1,
                //         writeData = shards * 1000,
                //         readMiB = shards * 2;

                //     $('.write-calculated-mib', form).html(writeMiB);
                //     $('.write-calculated-data', form).html(writeData);
                //     $('.read-calculated-mib', form).html(readMiB);
                // });
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

            appModal = App.modal({
                title: 'Create Data Stream',
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    FormWizard.init(form);
                },
                width: '1060',
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
                                return '<span class="label label-' + (data == 'processing' ? 'warning' : 'success') + '">' + data + '</span>';
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
                                        '<a href="/elasticsearch/delete/' +  data + '" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i></a>' +
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

            handleAdd();
            handleDelete();
        }
    }
}();

jQuery(document).ready(function() {
    Elasticsearch.init();
});