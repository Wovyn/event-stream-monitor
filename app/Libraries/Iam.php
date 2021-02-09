<?php
namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

use \Aws\Exception\AwsException;
use \Aws\Iam\Exception\IamException;

class Iam {

    protected $aws, $iam, $version = '2010-05-08';

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

        $this->iam = $this->aws->createIam($config);
    }

    public function ListRoles() {
        $result['error'] = false;
        try {
            $result['listRoles'] = $this->iam->listRoles();
        } catch (AwsException $e) {
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
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'GetUser: ' . $e->getMessage());
        }

        return $result;
    }

}

?>