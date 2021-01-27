<?php
namespace App\Libraries;

class EventStream {

    private $defaultPayload;

    protected $lastID;

    public function __construct() {
        $this->defaultPayload = [
            'id' => 'ES' . uniqid(),
            'event' => 'message',
            'data' => null,
            'retry' => 5000
        ];
    }

    private function formatPayload($data) {
        $payload = [];

        $this->lastID = $data['id'];

        foreach ($data as $key => $value) {
            $payload[] = sprintf('%s: %s', $key, $value);
        }

        $payload = implode("\n", $payload);
        $payload .= "\n\n";

        return $payload;
    }

    public function event($data = null) {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        $data = !is_null($data) ? $data : [];
        $payload = $this->formatPayload(array_merge($this->defaultPayload, $data));

        ob_start();

        echo $payload;

        if(ob_get_level() > 0) {
            ob_flush();
        }

        flush();
    }

}

?>