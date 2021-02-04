<?php
namespace App\Libraries;

require_once APPPATH . '../aws/aws-autoloader.php';

use \Aws\Exception\AwsException;
use \Aws\Kinesis\Exception\KinesisException;

class Aws {

    protected $aws, $kinesis;

    public function __construct($args) {
        $this->aws = new \Aws\Sdk([
            'region' => 'us-east-2',
            'credentials' => new \Aws\Credentials\Credentials($args['access'], $args['secret'])
        ]);
    }

    public function kinesisClient($region = null) {
        $config = [ 'version' => '2013-12-02' ];
        if($region) {
            $config['region'] = $region;
        }

        $this->kinesis = $this->aws->createKinesis($config);
    }

    public function kinesisCreateStream($args) {
        $result['error'] = false;
        try {
            $result['createStream'] = $this->kinesis->createStream($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'kinesisCreateStream: ' . $e->getMessage());
        }

        return $result;
    }

    public function kinesisDeleteStream($args) {
        $result['error'] = false;
        try {
            $result['deleteStream'] = $this->kinesis->deleteStream($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'kinesisDeleteStream: ' . $e->getMessage());
        }

        return $result;
    }

}

?>