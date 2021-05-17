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

function GetKinesisArnFromID($user_id, $kinesis_id) {
    $authKeysModel = new \App\Models\AuthKeysModel();
    $kinesisDataStreamsModel = new \App\Models\KinesisDataStreamsModel();

    $keys = $authKeysModel->where('user_id', $user_id)->first();
    $kinesis = $kinesisDataStreamsModel->where('id', $kinesis_id)->first();

    return str_format('arn:aws:kinesis:%region:%account:stream/%name', [
        '%region' => $kinesis->region,
        '%account' => $keys->aws_account,
        '%name' => $kinesis->name
    ]);
}

function GetDomainArnFromID($user_id, $domain_id) {
    $authKeysModel = new \App\Models\AuthKeysModel();
    $elasticsearchModel = new \App\Models\ElasticsearchModel();

    $keys = $authKeysModel->where('user_id', $user_id)->first();
    $domain = $elasticsearchModel->where('id', $domain_id)->first();

    return str_format('arn:aws:es:%region:%account:domain/%name', [
        '%region' => $domain->region,
        '%account' => $keys->aws_account,
        '%name' => $domain->domain_name
    ]);
}

?>