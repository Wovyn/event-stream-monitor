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
            $result['message'] = $e->getMessage();

            log_message('debug', 'CreateStream: ' . json_encode($e->getMessage()));
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
            $result['message'] = $e->getMessage();

            log_message('debug', 'SinkTest: ' . json_encode($e->getMessage()));
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

            log_message('debug', 'SinkValid: ' . json_encode($e->getMessage()));
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
            $result['message'] = $e->getMessage();

            log_message('debug', 'DeleteSink: ' . json_encode($e->getMessage()));
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
            $result['message'] = $e->getMessage();

            log_message('debug', 'FetchSink: ' . json_encode($e->getMessage()));
        }

        return $result;
    }

    public function FetchSinkSubscriptions($sid) {
        $result['error'] = false;
        try {
            $result['SinkSubscriptions'] = $this->client->events->v1
                ->subscriptions($sid)
                ->fetch();
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getMessage();

            log_message('debug', 'FetchSinkSubscriptions: ' . json_encode($e->getMessage()));
        }

        return $result;
    }

    public function ReadSubscriptions() {
        $result['error'] = false;
        try {
            $result['Subscriptions'] = $this->client->events->v1
                ->subscriptions
                ->read([], 20);
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getMessage();

            log_message('debug', 'ReadSubscriptions: ' . json_encode($e->getMessage()));
        }

        return $result;
    }

    public function ReadEventTypes() {
        $result['error'] = false;
        try {
            $result['EventTypes'] = $this->client->events->v1
                ->eventTypes
                ->read();
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getMessage();

            log_message('debug', 'ReadEventTypes: ' . json_encode($e->getMessage()));
        }

        return $result;
    }

    public function JSTreeFormat($eventTypes) {
        $jstree = [];
        $parents = [];

        foreach ($eventTypes as $eventType) {
            // check if schemaId parent is already created
            if(!in_array($eventType->schemaId, $parents)) {
                // add schemaId to parents
                array_push($parents, $eventType->schemaId);
                // add parent node
                array_push($jstree, [
                    'id' => $eventType->schemaId,
                    'parent' => '#',
                    'text' => $eventType->schemaId,
                    'type' => 'parent'
                ]);
            }

            // add child node
            array_push($jstree, [
                'id' => $eventType->type,
                'parent' => $eventType->schemaId,
                'text' => $eventType->description
            ]);
        }

        return [
            'parents' => $parents,
            'jstree' => $jstree
        ];
    }

}

?>