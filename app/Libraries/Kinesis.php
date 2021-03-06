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
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function DeleteStream($args) {
        $result['error'] = false;
        try {
            $result['deleteStream'] = $this->kinesis->deleteStream($args);
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function DescribeStreamSummary($args) {
        $result['error'] = false;
        try {
            $result['describeStreamSummary'] = $this->kinesis->describeStreamSummary($args);
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function PutRecord($args) {
        $result['error'] = false;
        try {
            $result['putRecord'] = $this->kinesis->putRecord($args);
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function GetRecords($args) {
        $result['error'] = false;
        try {
            $result['getRecords'] = $this->kinesis->getRecords($args);
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function ListShards($args) {
        $result['error'] = false;
        try {
            $result['listShards'] = $this->kinesis->listShards($args);
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function GetShardIterator($args) {
        $result['error'] = false;
        try {
            $result['getShardIterator'] = $this->kinesis->getShardIterator($args);
        } catch (KinesisException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function GetAllRecords($streamName) {
        log_message('debug', 'GetAllRecords for ' . $streamName);

        $result['GetAllRecords'] = [];
        $result['ListShards'] = $this->ListShards([
            'StreamName' => $streamName
        ]);

        log_message('debug', 'ListShards: ' . json_encode($result['ListShards']['listShards']['Shards']));

        foreach ($result['ListShards']['listShards']['Shards'] as $shard) {
            $result['GetShardIterator'] = $this->GetShardIterator([
                'ShardId' => $shard['ShardId'],
                'ShardIteratorType' => 'TRIM_HORIZON', // REQUIRED
                'StreamName' => $streamName // REQUIRED
            ]);

            $result['GetRecords'] = $this->GetRecords([
                'ShardIterator' => $result['GetShardIterator']['getShardIterator']['ShardIterator']
            ]);

            foreach ($result['GetRecords']['getRecords']['Records'] as $record) {
                $result['GetAllRecords'][] = $record;
            }
        }

        return $result['GetAllRecords'];
    }
}

?>