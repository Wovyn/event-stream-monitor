var Dashboard = function() {

    return {
        init: function() {
            console.log('Dashboard.init');

            Main.init();
            Index.init();
        }
    }
}();

jQuery(document).ready(function() {
    Dashboard.init();
});