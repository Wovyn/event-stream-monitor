<?php
namespace App\Libraries;

use \Aws\Sts\Exception\StsException;

class Sts extends Aws {

    protected $sts, $version = '2011-06-15';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->sts = $this->aws->createSts($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->sts = $this->aws->createSts($config);
    }

    public function GetCallerIdentity() {
        $result['error'] = false;
        try {
            $result['getCallerIdentity'] = $this->sts->getCallerIdentity();
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'GetCallerIdentity: ' . $e->getMessage());
        }

        return $result;
    }

}

?>