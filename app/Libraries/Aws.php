<?php
namespace App\Libraries;

require_once APPPATH . '../aws/aws-autoloader.php';

use \Aws\Exception\AwsException;
use \Aws\Kinesis\Exception\KinesisException;

class Aws {

    // protected $aws;
    protected $aws, $kinesis;

    public function __construct($args) {
        $this->aws = new \Aws\Sdk([
            'region' => $args['region'],
            'credentials' => new \Aws\Credentials\Credentials($args['access'], $args['secret'])
        ]);

        $this->kinesis = $this->aws->createKinesis([
            'version' => '2013-12-02',
            'region' => $args['region']
        ]);


        // testing purposes
        // return $this->aws;
    }

    public function kinesisCreateStream($args) {
        $result['error'] = false;
        try {
            $result['createStream'] = $this->kinesis->createStream($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->toArray()['message'];
        }

        return $result;
    }

    public function kinesisDeleteStream($args) {
        $result['error'] = false;
        try {
            $result['deleteStream'] = $this->kinesis->deleteStream($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->toArray()['message'];
        }

        return $result;
    }
}

?>