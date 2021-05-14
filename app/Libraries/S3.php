<?php
namespace App\Libraries;

use \Aws\S3\Exception\S3Exception;

class S3 extends Aws {

    protected $S3, $version = '2006-03-01';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->S3 = $this->aws->createS3($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->S3 = $this->aws->createS3($config);
    }

    public function CreateBucket($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->S3->createBucket($args);
        } catch (S3Exception $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'CreateBucket: ' . $e->getMessage());
        }

        return $result;
    }

}

?>