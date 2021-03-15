<?php
namespace App\Libraries;

use \Aws\Ec2\Exception\Ec2Exception;

class Ec2 extends Aws {

    protected $ec2, $version = '2016-11-15';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->ec2 = $this->aws->createEc2($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

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