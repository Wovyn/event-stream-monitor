var Eventstreams = function() {

    return {
        init: function() {
            console.log('Eventstreams.init');

            App.checkUserAuthKeys();

            App.dt.extend();
            App.dt.init({
                id: 'eventstreams-table',
                autoUpdate: 60000,
                settings: {
                    processing: true,
                    serverSide: true,
                    // ajax: {
                    //     url: '/kinesis/get_dt_listing',
                    //     type: 'post'
                    // },
                    // columns: [
                    //     { name: 'region', data: 'region' },
                    //     { name: 'name', data: 'name' },
                    //     { name: 'shards', data: 'shards' },
                    //     { name: 'created_at', data: 'created_at' },
                    //     { name: 'updated_at', data: 'updated_at' },
                    //     { name: 'options', data: 'id', searchable: false, sortable: false }
                    // ],
                    // columnDefs: [
                    //     {
                    //         targets: 0,
                    //         render: function(data, type, full, meta) {
                    //             return full.region_name + ' | ' + data;
                    //         }
                    //     },
                    //     {
                    //         targets:[3,4],
                    //         render: function(data, type, full, meta) {
                    //             let utcTime = moment.tz(data, 'UTC'),
                    //                 localTime = moment.tz(data, 'UTC').tz(App.timezone),
                    //                 tooltip =
                    //                     '<div class=\'text-left\'>' +
                    //                         '<b>UTC:</b> ' + utcTime.format("MMM DD, YYYY h:mm:ss a") + '<br/>' +
                    //                         '<b>Local:</b> ' + localTime.format("MMM DD, YYYY h:mm:ss a") + '<br/>' +
                    //                     '</div>';

                    //             if(data) {
                    //                 return '<span data-html="true" title="' + tooltip + '" class="tip">' + localTime.fromNow() + '</span>';
                    //             } else {
                    //                 return '';
                    //             }
                    //         }
                    //     },
                    //     {
                    //         targets: 5,
                    //         width: '12.5%',
                    //         render: function(data, type, full, meta) {
                    //             let options =
                    //                 '<div class="btn-group btn-group-sm">' +
                    //                     // '<a href="/kinesis/edit/' +  data + '" class="btn btn-primary edit-btn"><i class="fa fa-pencil"></i></a>' +
                    //                     '<a href="/kinesis/view/' +  data + '" class="btn btn-primary view-btn"><i class="fa fa-eye"></i></a>' +
                    //                     '<a href="/kinesis/delete/' +  data + '" class="btn btn-danger delete-btn"><i class="fa fa-trash-o"></i></a>' +
                    //                 '</div>';

                    //             return options;
                    //         }
                    //     }
                    // ],
                    fnCreatedRow: function (nRow, aData, iDataIndex) {
                        console.log('fnCreatedRow');
                        $('.tip', nRow).tooltip();
                    }
                }
            });

            App.validationSetDefault();
        }
    }
}();

jQuery(document).ready(function() {
    Eventstreams.init();
});