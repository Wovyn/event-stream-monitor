<?php
namespace App\Libraries;

use \Aws\Iam\Exception\IamException;

class Iam extends Aws {

    protected $iam, $version = '2010-05-08';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->iam = $this->aws->createIam($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->iam = $this->aws->createIam($config);
    }

    public function ListRoles() {
        $result['error'] = false;
        try {
            $result['listRoles'] = $this->iam->listRoles();
        } catch (IamException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'ListRoles: ' . $e->getMessage());
        }

        return $result;
    }

    public function GetUser() {
        $result['error'] = false;
        try {
            $result['getUser'] = $this->iam->getUser();
        } catch (IamException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'GetUser: ' . $e->getMessage());
        }

        return $result;
    }

}

?>