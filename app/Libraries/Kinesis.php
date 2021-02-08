<?php
namespace App\Libraries;

require_once APPPATH . '../aws/aws-autoloader.php';

use \Aws\Exception\AwsException;
use \Aws\Kinesis\Exception\KinesisException;

class Kinesis {

    protected $aws, $kinesis, $version = '2013-12-02';

    public function __construct($args) {
        $this->aws = new \Aws\Sdk([
            'region' => 'us-east-2',
            'credentials' => new \Aws\Credentials\Credentials($args['access'], $args['secret'])
        ]);
    }

    public function client($region = null) {
        $config = [ 'version' => $this->version ];

        if($region) {
            $config['region'] = $region;
        }

        $this->kinesis = $this->aws->createKinesis($config);
    }

    public function CreateStream($args) {
        $result['error'] = false;
        try {
            $result['createStream'] = $this->kinesis->createStream($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'CreateStream: ' . $e->getMessage());
        }

        return $result;
    }

    public function DeleteStream($args) {
        $result['error'] = false;
        try {
            $result['deleteStream'] = $this->kinesis->deleteStream($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'DeleteStream: ' . $e->getMessage());
        }

        return $result;
    }

    public function DescribeStreamSummary($args) {
        $result['error'] = false;
        try {
            $result['describeStreamSummary'] = $this->kinesis->describeStreamSummary($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'DescribeStreamSummary: ' . $e->getMessage());
        }

        return $result;
    }

}

?>