var Kinesis = function() {

    var FormWizard = function() {
        let wizard, wizardForm;

        var initWizard = function(form) {
            wizard = $('#smartwizard', form);

            wizard.smartWizard({
                selected: 0,
                justified: true,
                enableURLhash: false
            });

            // html class fix
            $('.toolbar', wizard).addClass('modal-footer');
            $('.toolbar .sw-btn-prev', wizard).addClass('btn-default');
            $('.toolbar .sw-btn-next', wizard).addClass('btn-blue');
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
                onShow: function(form) {
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