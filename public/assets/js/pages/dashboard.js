var Dashboard = function() {

    var hierarchy = {};
    hierarchy.init = function(settings) {

    }

    return {
        init: function() {
            console.log('Dashboard.init');
            App.checkUserAuthKeys();

            hierarchy.init({
                containerID: 'd3-hierarchy'
            });
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});