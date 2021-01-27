var EventStream = function() {
    var $settings = {}, ES = {};

    ES.timeout = function() {
        if($settings.timeout > 0) {
            setTimeout(() => {}, $settings.timeout);
        }
    };

    ES.CreateEventSource = function() {
        let source = new EventSource($settings.url);

        // create listeners
        _.forEach($settings.events, function(event) {
            source.addEventListener(event.type, function(response) {
                event.listener(response.data);

                ES.timeout();
            });
        });

        return source;
    };

    return {
        init: function(options) {
            console.log('EventStream.init');
            $settings = $.extend(true, $settings, options);

            return ES.CreateEventSource();
        },
        close: function() {

        }
    }
}();