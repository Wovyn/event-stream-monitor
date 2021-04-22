var Dashboard = function() {

    var handleStreamChart = function() {
        let $container = $('#d3-hierarchy');

        $container.append('<p class="text-center"><i class="fa fa-spin clip-spinner"></i> Loading data</p>');
        $.get('/dashboard/chartdata', function(data) {
            $container.empty();

            if(_.isEmpty(data)) {
                $('#d3-hierarchy').append('<p class="text-center">There are currently no Event Stream Sinks defined!</p>');
            } else {
                CollapseTree.chart({
                    container: $('#d3-hierarchy'),
                    transition_duration: 100,
                    node_spacingY: 4,
                    node_spacingX: 30,
                    font: {
                        family: 'Open Sans',
                        size: 13
                    },
                    margin: {top: 50, right: 120, bottom: 50, left: 120},
                    data: {
                        name: 'Event Streams',
                        children: data
                    }
                });
            }
        });
    }

    return {
        init: function() {
            console.log('Dashboard.init');

            App.globalPageChecks();

            handleStreamChart();
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});