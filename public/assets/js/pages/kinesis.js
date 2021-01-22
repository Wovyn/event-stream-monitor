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
                        $('<button type="button" class="btn btn-finish btn-success disabled">Create Data Stream</button>')
                            .on('click', function(){
                                $.ajax({
                                    url: '/kinesis/add',
                                    method: 'POST',
                                    data: form.serialize(),
                                    dataType: 'json',
                                    success: function(response) {
                                        Swal.fire({
                                            icon: response.error !== true ? 'success' : 'error',
                                            title: response.message
                                        });

                                        if(!response.error) {
                                            appModal.modal('hide');
                                            $dtTables['kinesis-table'].ajax.reload();
                                        } else {
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

            // on leaveSte
            wizard.on('leaveStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
                // validate current step
                if(!form.valid()) {
                    return false;
                }

                // show/hide create data stream btn
                if(nextStepIndex == 3) {
                    generateSummary(form);

                    $('.btn-finish', form).removeClass('disabled');
                } else {
                    $('.btn-finish', form).addClass('disabled');
                }

                animateBar(nextStepIndex);
            });

            wizard.on('showStep', function(e, anchorObject, stepIndex, stepDirection) {

            });

            // initialize animateBar
            animateBar();
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
                    '<label class="control-label text-capitalize">' + data.name + ':</label>' +
                    '<p class="form-control-static display-value">' + data.value + '</p>' +
                    '</div>';
            });

            $('.summary', form).append(summary);
        }

        return {
            init: function(form) {
                initWizard(form);
            }
        };
    }();

    var handleAddStream = function() {
        $('.add-stream-btn').on('click', function(e) {
            e.preventDefault();

            let $btn = $(this);

            appModal = App.modal({
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    FormWizard.init(form);

                    $('#shards', form).on('change', function() {
                        let shards = $(this).val(),
                            writeMiB = shards * 1,
                            writeData = shards * 1000,
                            readMiB = shards * 2;

                        $('.write-calculated-mib', form).html(writeMiB);
                        $('.write-calculated-data', form).html(writeData);
                        $('.read-calculated-mib', form).html(readMiB);
                    })
                },
                width: '960',
                footer: false,
                others: { backdrop: 'static', keyboard: false }
            });
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
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                // console.log(result);
                if(result.isConfirmed) {
                    $.ajax({
                        url: $btn.attr('href'),
                        method: 'POST',
                        dataType: 'json',
                        success: function(response) {
                            if(response) {
                                Swal.fire({
                                    icon: response.error !== true ? 'success' : 'error',
                                    title: response.message
                                });

                                if(!response.error) {
                                    $dtTables['kinesis-table'].ajax.reload();
                                } else {
                                    console.log(response);
                                }
                            }
                        }
                    });
                }
            });
        });
    }

    return {
        init: function() {
            console.log('Kinesis.init');

            App.checkUserAuthKeys();

            App.dt.init({
                id: 'kinesis-table',
                settings: {
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '/kinesis/get_dt_listing',
                        type: 'post'
                    },
                    columns: [
                        { name: 'region', data: 'region' },
                        { name: 'name', data: 'name' },
                        { name: 'shards', data: 'shards' },
                        { name: 'created_at', data: 'created_at' },
                        { name: 'updated_at', data: 'updated_at' },
                        { name: 'options', data: 'id', searchable: false, sortable: false }
                    ],
                    columnDefs: [
                        {
                            targets: 5,
                            width: '10%',
                            render: function(data, type, full, meta) {
                                let options =
                                    '<div class="btn-group btn-group-sm">' +
                                        '<a href="/kinesis/view/' +  data + '" class="btn btn-primary view-btn"><i class="fa fa-eye"></i></a>' +
                                        '<a href="/kinesis/delete/' +  data + '" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i></a>' +
                                    '</div>';

                                return options;
                            }
                        }
                    ]
                }
            });

            App.validationSetDefault();
            handleAddStream();
            handleDeleteStream();
        }
    }
}();

jQuery(document).ready(function() {
    Kinesis.init();
});