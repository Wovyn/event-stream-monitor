<?php
namespace App\Libraries;

use Aws\Acm\Exception\AcmException;

class Acm extends Aws {

    protected $acm, $version = '2015-12-08';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->acm = $this->aws->createAcm($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->acm = $this->aws->createAcm($config);
    }

    public function ListCertificates($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->acm->listCertificates($args);
        } catch (AcmException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

}

?>