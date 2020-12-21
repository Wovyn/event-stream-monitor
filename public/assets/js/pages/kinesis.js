var Kinesis = function() {

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
        }
    }
}();

jQuery(document).ready(function() {
    Kinesis.init();
});