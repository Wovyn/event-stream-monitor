var Streams = {};
var EventStream = function() {
    var $settings = { timeout: 5000 }, ES = {};

    ES.timeout = function() {
        if($settings.timeout > 0) {
            setTimeout(() => {}, $settings.timeout);
        }
    };

    ES.CreateEventSource = function() {
        let source = new EventSource($settings.url);
        return source;
    };

    ES.InitListeners = function(source) {
        // create listeners
        _.forEach($settings.events, function(event) {
            source.addEventListener(event.type, function(response) {
                event.listener(response.data);

                ES.timeout();
            });
        });
    }

    return {
        init: function(id, options) {
            console.log('EventStream.init');
            $settings = $.extend(true, $settings, options);

            Streams[id] = {};
            Streams[id]['settings'] = $settings;
            Streams[id]['source'] = ES.CreateEventSource();
            ES.InitListeners(Streams[id]['source']);
        }
    }
}();