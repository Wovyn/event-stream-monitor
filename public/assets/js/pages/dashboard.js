var Dashboard = function() {

    return {
        init: function() {
            console.log('Dashboard.init');
            App.checkUserAuthKeys();
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});