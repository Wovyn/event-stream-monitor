var Dashboard = function() {

    return {
        init: function() {
            console.log('Dashboard.init');

            Index.init();
            App.checkUserAuthKeys();
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});