<?php
namespace App\Libraries;

require_once APPPATH . '../vendor/autoload.php';

use \Aws\Exception\AwsException;
use \Aws\Ec2\Exception;

class Ec2 {

    protected $aws, $ec2, $version = '2016-11-15';

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

        $this->ec2 = $this->aws->createEc2($config);
    }

    public function DescribeRegions($args = []) {
        $result['error'] = false;
        try {
            $result['describeRegions'] = $this->ec2->describeRegions($args);
        } catch (AwsException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            log_message('debug', 'DescribeRegions: ' . $e->getMessage());
        }

        return $result;
    }

}

?>