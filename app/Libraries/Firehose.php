<?php
namespace App\Libraries;

use \Aws\Firehose\Exception\FirehoseException;

class Firehose extends Aws {

    protected $firehose, $version = '2015-08-04';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->firehose = $this->aws->createFirehose($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->firehose = $this->aws->createFirehose($config);
    }

    public function CreateDeliveryStream($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->firehose->createDeliveryStream($args);
        } catch (FirehoseException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'CreateDeliveryStream: ' . $e->getMessage());
        }

        return $result;
    }

}

?>