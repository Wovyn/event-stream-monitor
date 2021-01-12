<?php
namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

class Aws {

    // protected $aws;
    public $aws, $kinesis, $ec2;

    public function __construct($args) {
        $this->aws = new \Aws\Sdk([
            'region' => $args['region'],
            'credentials' => new \Aws\Credentials\Credentials($args['access'], $args['secret'])
        ]);

        $this->kinesis = $this->aws->createKinesis([
            'version' => '2013-12-02',
            'region' => $args['region']
        ]);

        return $this->aws;
    }

    public function kinesis() {
        return $this->kinesis;
    }

}

?>