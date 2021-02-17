<?php
namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

use Twilio\Rest\Client;
use Twilio\Exceptions\RestException;

class Twilio {

    protected $client;

    public function __construct($sid, $token) {
        $this->client = new Client($sid, $token);
    }

    public function CreateSink($args) {
        $result['error'] = false;
        try {
            $result['CreatedSink'] = $this->client->events->v1->sinks
                ->create(
                    $args['description'],
                    $args['config'],
                    $args['sink_type']
                );
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getDetails();

            log_message('debug', 'CreateStream: ' . json_encode($e->getDetails()));
        }

        return $result;
    }

    public function SinkTest($sid) {
        $result['error'] = false;
        try {
            $result['SinkTest'] = $this->client->events->v1
                ->sinks($sid)
                ->sinkTest
                ->create();
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getDetails();

            log_message('debug', 'SinkTest: ' . json_encode($e->getDetails()));
        }

        return $result;
    }

    public function SinkValid($sid, $testID) {
        $result['error'] = false;
        try {
            $result['SinkValid'] = $this->client->events->v1
                ->sinks($sid)
                ->sinkValidate
                ->create($testID);
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e;

            log_message('debug', 'SinkValid: ' . json_encode($e->getDetails()));
        }

        return $result;
    }

    public function DeleteSink($sid) {
        $result['error'] = false;
        try {
            $result['DeletedSink'] = $this->client->events->v1
                ->sinks($sid)
                ->delete();
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getDetails();

            log_message('debug', 'DeleteSink: ' . json_encode($e->getDetails()));
        }

        return $result;
    }

    public function FetchSink($sid) {
        $result['error'] = false;
        try {
            $result['Sink'] = $this->client->events->v1
                ->sinks($sid)
                ->fetch();
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getDetails();

            log_message('debug', 'FetchSink: ' . json_encode($e->getDetails()));
        }

        return $result;
    }

}

?>