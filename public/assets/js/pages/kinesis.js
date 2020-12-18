var Kinesis = function() {

    return {
        init: function() {
            console.log('Kinesis.init');

            TableData.init();
        }
    }
}();

jQuery(document).ready(function() {
    Kinesis.init();
});