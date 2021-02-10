<?php
namespace App\Libraries;

use \Aws\Kinesis\Exception\KinesisException;

class Kinesis extends Aws {

    protected $kinesis, $version = '2013-12-02';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->kinesis = $this->aws->createKinesis($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

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