<?php
namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

use Twilio\Rest\Client;

class Twilio {

    protected $client;

    public function __construct($sid, $token) {
        $this->client = new Client($sid, $token);
    }

    public function CreateSink() {

    }

}

?>