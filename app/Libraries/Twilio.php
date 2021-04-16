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

    // start Sink API
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
    // End Sink API

    // Start Subscription API
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

    public function CreateSubscription($args) {
        $result['error'] = false;
        try {
            $result['Subscription'] = $this->client->events->v1
                ->subscriptions
                ->create(
                    $args['description'], // description
                    $args['sid'], // sinkSid
                    $args['types'] // types
                );
                // types format
                // [
                //     [ "type-id" => "com.twilio.messaging.message.delivered" ],
                //     [ "type-id" => "com.twilio.messaging.message.sent" ]
                // ]
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getMessage();

            log_message('debug', 'CreateSubscription: ' . json_encode($e->getMessage()));
        }

        return $result;
    }

    public function DeleteSubscription($subscription_sid) {
        $result['error'] = false;
        try {
            $result['DeletedSubscription'] = $this->client->events->v1
                ->subscriptions($subscription_sid)
                ->delete();
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getMessage();

            log_message('debug', 'DeleteSubscription: ' . json_encode($e->getMessage()));
        }

        return $result;
    }
    // End Subscription API

    // Start EventTypes API
    public function ReadEventTypes() {
        $result['error'] = false;
        try {
            // log_message('debug', 'running ReadEventTypes');
            $result['response'] = $this->client->events->v1
                ->eventTypes
                ->read(100); // temporary fix
            // log_message('debug', 'done ReadEventTypes');
        } catch (RestException $e) {
            $result['error'] = true;
            $result['message'] = $e->getMessage();

            log_message('debug', 'ReadEventTypes: ' . json_encode($e->getMessage()));
        }

        return $result;
    }
    // End EventTypes API

    // Start Custom
    public function JSTreeFormat($eventTypes, $subscriptions = []) {
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
                'text' => $eventType->description,
                'state' => [
                    'selected' => (in_array($eventType->type, $subscriptions) ? true : false)
                ]
            ]);
        }

        return [
            'parents' => $parents,
            'jstree' => $jstree
        ];
    }
    // End Custom

}

?>