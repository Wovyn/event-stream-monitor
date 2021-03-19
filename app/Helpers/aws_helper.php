<?php

function GetAwsRegions($keys) {
    $awsconfig = new \Config\Aws();

    $regions = [];
    if($keys) {
        $ec2 = new \App\Libraries\Ec2([
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);

        $result = $ec2->DescribeRegions();

        if(!$result['error']) {
            foreach ($result['describeRegions']['Regions'] as $region) {
                $regions[$region['RegionName']] = $awsconfig->regions[$region['RegionName']];
            }
        }
    }

    if(empty($regions)) {
        // set to default
        $regions = $awsconfig->regions;
    }

    asort($regions, SORT_STRING);
    return $regions;
}

?>