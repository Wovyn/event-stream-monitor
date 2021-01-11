<?php
namespace App\Libraries;

require_once APPPATH . '../aws/aws-autoloader.php';

class AmazonSDK {

    protected $aws;

    public function __construct($args) {
        $config['credentials'] = new \Aws\Credentials\Credentials($args['access'], $args['key']);
        $this->aws = new \Aws\Sdk($config);
    }

}


?>