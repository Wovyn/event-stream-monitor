<?php
namespace App\Libraries;

use Aws\ElasticsearchService\Exception\ElasticsearchServiceException;

class Elasticsearch extends Aws {

    protected $elasticsearch, $version = '2015-01-01';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->elasticsearch = $this->aws->createElasticsearchService($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->elasticsearch = $this->aws->createElasticsearchService($config);
    }

    public function CreateElasticsearchDomain($args = []) {
        $result['error'] = false;
        $result['args'] = $args;

        try {
            $result['response'] = $this->elasticsearch->createElasticsearchDomain($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'CreateElasticsearchDomain: ' . $e->getMessage());
        }

        return $result;
    }

    public function DeleteElasticsearchDomain($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->deleteElasticsearchDomain($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'DeleteElasticsearchDomain: ' . $e->getMessage());
        }

        return $result;
    }

    public function DescribeElasticsearchDomain($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->describeElasticsearchDomain($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'DescribeElasticsearchDomain: ' . $e->getMessage());
        }

        return $result;
    }

    public function DescribeElasticsearchDomainConfig($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->describeElasticsearchDomainConfig($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'DescribeElasticsearchDomainConfig: ' . $e->getMessage());
        }

        return $result;
    }

    public function version() {
        return $this->version;
    }

}

?>