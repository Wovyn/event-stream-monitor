<?php
namespace App\Libraries;

use Aws\ElasticsearchService\Exception\ElasticsearchServiceException;

class Elasticsearch extends Aws {

    protected $elasticsearch, $version = '2015-01-01';

    public function __construct($args) {
        parent::__construct($args);

        $config = [
            'version' => $this->version
        ];

        $this->elasticsearch = $this->aws->createElasticsearchService($config);
    }

    public function setRegion($region) {
        $config = [
            'version' => $this->version,
            'region' => $region
        ];

        $this->elasticsearch = $this->aws->createElasticsearchService($config);
    }

    public function CreateElasticsearchDomain($args = []) {
        $result['error'] = false;
        $result['args'] = $args;

        try {
            $result['response'] = $this->elasticsearch->createElasticsearchDomain($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function DeleteElasticsearchDomain($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->deleteElasticsearchDomain($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function DescribeElasticsearchDomain($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->describeElasticsearchDomain($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function DescribeElasticsearchDomainConfig($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->describeElasticsearchDomainConfig($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function UpdateElasticsearchDomainConfig($args = []) {
        $result['error'] = false;
        try {
            $result['response'] = $this->elasticsearch->updateElasticsearchDomainConfig($args);
        } catch (ElasticsearchServiceException $e) {
            $result['error'] = true;
            $result['message'] = $e->getAwsErrorMessage();

            debug($e->getMessage());
        }

        return $result;
    }

    public function formatRequest($mode, $request)  {
        $result = [
            'ElasticsearchVersion' => '7.10',
            'DomainName' => $request['domain_name'],
            'AccessPolicies' => $request['access_policy'],
            'AutoTuneOptions' => [
                'DesiredState' => $request['auto_tune'],
                // 'MaintenanceSchedules'
            ],
            'ElasticsearchClusterConfig' => [
                'InstanceType' => $request['instance_type'],
                'InstanceCount' => (int) $request['number_of_nodes']
            ],
            'EBSOptions' => [
                'EBSEnabled' => true,
                'VolumeSize' => (int) $request['ebs_storage_size_per_node'],
                'VolumeType' => $request['ebs_volume_type'],
            ],
            'EncryptionAtRestOptions' => [
                'Enabled' => isset($request['enable_encryption_of_data_at_rest']),
            ],
            'NodeToNodeEncryptionOptions' => [
                'Enabled' => isset($request['note_to_node_encryption']),
            ],
            // custom domain
            'DomainEndpointOptions' => [
                'EnforceHTTPS' => isset($request['require_https']),
                'CustomEndpointEnabled' => false
                // 'TLSSecurityPolicy' => 'Policy-Min-TLS-1-0-2019-07|Policy-Min-TLS-1-2-2019-07',
            ],

            // Fine–grained access control
            'AdvancedSecurityOptions' => [
                // 'SAMLOptions' => [
                //     'Enabled' => false,
                // ]
            ],
            // Amazon Cognito authentication
            'CognitoOptions' => [
                'Enabled' => false
            ]
        ];

        $result['ElasticsearchClusterConfig']['ZoneAwarenessEnabled'] = $request['availability_zones'] > 1 ? true : false;
        if($request['availability_zones'] > 1) {
            $result['ElasticsearchClusterConfig']['ZoneAwarenessConfig'] = [
                'AvailabilityZoneCount' => (int) $request['availability_zones']
            ];
        }

        if($request['ebs_volume_type'] == 'io1') {
            $result['EBSOptions']['Iops'] = (int) $request['provisioned_iops'];
        }

        $result['DomainEndpointOptions']['CustomEndpointEnabled'] = isset($request['custom_endpoint']);
        if(isset($request['custom_endpoint'])) {
            $result['DomainEndpointOptions']['CustomEndpoint'] = $request['custom_hostname'];
            $result['DomainEndpointOptions']['CustomEndpointCertificateArn'] = $request['aws_certificate'];
        }

        if($mode == 'create') {
            $result['AdvancedSecurityOptions']['Enabled'] = isset($request['fine_grain_access_control']);
            $result['AdvancedSecurityOptions']['InternalUserDatabaseEnabled'] = isset($request['fine_grain_access_control']);
            if(isset($request['fine_grain_access_control'])) {
                $result['AdvancedSecurityOptions']['MasterUserOptions'] = [
                    'MasterUserName' => $request['master_username'],
                    'MasterUserPassword' => $request['master_password']
                ];
            }
        }

        $result['ElasticsearchClusterConfig']['DedicatedMasterEnabled'] = isset($request['dedicated_master_nodes']);
        if(isset($request['dedicated_master_nodes'])) {
            $result['ElasticsearchClusterConfig']['DedicatedMasterType'] = $request['dedicated_master_node_instance_type'];
            $result['ElasticsearchClusterConfig']['DedicatedMasterCount'] = (int) $request['dedicated_master_node_number_of_nodes'];
        }

        $result['ElasticsearchClusterConfig']['WarmEnabled'] = isset($request['ultrawarm_data_node']);
        if(isset($request['ultrawarm_data_node'])) {
            $result['ElasticsearchClusterConfig']['WarmType'] = $request['ultrawarm_instance_type'];
            $result['ElasticsearchClusterConfig']['WarmCount'] = (int) $request['number_of_warm_data_nodes'];
        }

        return $result;
    }

    public function version() {
        return $this->version;
    }

}

?>