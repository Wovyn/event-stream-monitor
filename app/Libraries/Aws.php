<?php
namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

use \Aws\Exception\AwsException;

class Aws {

    protected $aws;

    public function __construct($args) {
        $this->aws = new \Aws\Sdk([
            'region' => 'us-east-2',
            'credentials' => new \Aws\Credentials\Credentials($args['access'], $args['secret'])
        ]);
    }

}

?>