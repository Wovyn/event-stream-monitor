var Kinesis = function() {

    var FormWizard = function() {
        let wizard, wizardForm;

        var initWizard = function(form) {
            wizard = $('#smartwizard', form);

            wizard.smartWizard({
                selected: 0,
                justified: true,
                enableURLhash: false,
                toolbarSettings: {
                    toolbarExtraButtons: [
                        $('<button class="btn btn-finish btn-success disabled">Finish</button>')
                            .on('click', function(){
                                alert('Finish button click');
                            })
                    ]
                }
            });

            // html class fix
            $('.toolbar', wizard).addClass('modal-footer');

            // on leaveSte
            wizard.on('leaveStep', function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
               console.log('left step ' + currentStepIndex);
            });

            wizard.on('showStep', function(e, anchorObject, stepIndex, stepDirection) {
               // alert('You are on step ' + stepIndex + ' now');
            });
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

            App.modal({
                ajax: {
                    url: $btn.attr('href')
                },
                onShown: function(form) {
                    console.log('initialize wizard');

                    FormWizard.init(form);
                },
                width: '960',
                footer: false
            });
        });
    }

    return {
        init: function() {
            console.log('Kinesis.init');

            App.dt.init({
                id: 'kinesis-table',
                settings: {
                    processing: true,
                    columns: [
                        { name: 'region', data: 'region' },
                        { name: 'name', data: 'name' },
                        { name: 'status', data: 'status' },
                        { name: 'options', data: 'id', searchable: false, sortable: false }
                    ],
                    columnDefs: [
                        {
                            targets: 3,
                            width: '10%',
                            render: function(data, type, full, meta) {
                                let options =
                                    '<div class="btn-group btn-group-sm">' +
                                        '<a href="/kinesis/edit/' +  data + '" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>' +
                                        '<a href="/kinesis/delete/' +  data + '" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i></a>' +
                                    '</div>';

                                return options;
                            }
                        }
                    ]
                }
            });

            handleAddStream();
        }
    }
}();

jQuery(document).ready(function() {
    Kinesis.init();
});