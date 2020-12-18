var Dashboard = function() {

    return {
        init: function() {
            console.log('Dashboard.init');

            Index.init();
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});