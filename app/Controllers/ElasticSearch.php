<?php
namespace App\Controllers;

class ElasticSearch extends BaseController
{

    protected $authKeysModel,
        $elasticsearch,
        $keys;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();

        $this->keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();
        if($this->keys) {
            $this->elasticsearch = new \App\Libraries\Elasticsearch([
                'access' => $this->keys->aws_access,
                'secret' => $this->keys->aws_secret
            ]);
        }
    }

    public function index() {
        $this->data['meta']['header'] = 'AWS Elasticsearch';
        $this->data['meta']['subheader'] = 'create and manage';

        array_push($this->data['css'],
            '/bower_components/select2/dist/css/select2.min.css',
            '/bower_components/datatables/media/css/dataTables.bootstrap.min.css',
            '/bower_components/jQuery-Smart-Wizard/css/smart_wizard.css'
        );

        array_push($this->data['scripts'],
            '/bower_components/select2/dist/js/select2.min.js',
            '/bower_components/datatables/media/js/jquery.dataTables.min.js',
            '/bower_components/datatables/media/js/dataTables.bootstrap.js',
            '/bower_components/jquery-validation/dist/jquery.validate.min.js',
            '/bower_components/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
            '/bower_components/ace/ace.js',
            '/assets/js/pages/elasticsearch.js'
        );

        return view('elasticsearch/index', $this->data);
    }

    public function add() {
        if($_POST) {
            // compile create elasticsearch domain request
            $request = [
                'ElasticsearchVersion' => '7.10',
                'AccessPolicies' => $_POST['access_policy'],
                'DomainName' => $_POST['domain_name'],
                'AutoTuneOptions' => [
                    'DesiredState' => $_POST['auto_tune'],
                    // 'MaintenanceSchedules'
                ],
                'ElasticsearchClusterConfig' => [
                    'ZoneAwarenessEnabled' => true,
                    'ZoneAwarenessConfig' => [
                        'AvailabilityZoneCount' => (int) $_POST['availability_zones']
                    ],
                    'InstanceType' => $_POST['instance_type'],
                    'InstanceCount' => (int) $_POST['number_of_nodes']
                ],
                'EBSOptions' => [
                    'EBSEnabled' => true,
                    // 'Iops' => <integer>,
                    'VolumeSize' => (int) $_POST['ebs_storage_size_per_node'],
                    'VolumeType' => $_POST['ebs_volume_type'],
                ],
                'NodeToNodeEncryptionOptions' => [
                    'Enabled' => isset($_POST['note_to_node_encryption']),
                ],

                // custom domain
                'DomainEndpointOptions' => [
                    'EnforceHTTPS' => isset($_POST['require_https']),
                    'CustomEndpointEnabled' => false,
                    // 'CustomEndpoint' => '<string>',
                    // 'CustomEndpointCertificateArn' => '<string>',
                    // 'TLSSecurityPolicy' => 'Policy-Min-TLS-1-0-2019-07|Policy-Min-TLS-1-2-2019-07',
                ],

                // Fine–grained access control
                'AdvancedSecurityOptions' => [
                    'Enabled' => false
                    // 'SAMLOptions'
                ],
                // Amazon Cognito authentication
                'CognitoOptions' => [
                    'Enabled' => false
                ]
            ];

            if(isset($_POST['dedicated_master_nodes'])) {
                $request['ElasticsearchClusterConfig']['DedicatedMasterEnabled'] = isset($_POST['dedicated_master_nodes']);
                $request['ElasticsearchClusterConfig']['DedicatedMasterType'] = $_POST['dedicated_master_node_instance_type'];
                $request['ElasticsearchClusterConfig']['DedicatedMasterCount'] = (int) $_POST['dedicated_master_node_number_of_nodes'];

                if(isset($_POST['ultrawarm_data_node'])) {
                    $request['ElasticsearchClusterConfig']['WarmEnabled'] = isset($_POST['ultrawarm_data_node']);
                    $request['ElasticsearchClusterConfig']['WarmType'] = $_POST['ultrawarm_instance_type'];
                    $request['ElasticsearchClusterConfig']['WarmCount'] = (int) $_POST['number_of_warm_data_nodes'];
                }
            }

            $this->elasticsearch->setRegion($_POST['region']);
            $result['CreateElasticsearchDomain'] = $this->elasticsearch->CreateElasticsearchDomain($request);

            echo 'Request: <br>';
            echo '<pre>', var_dump($request) , '</pre>';

            echo 'Result: <br>';
            echo '<pre>', var_dump($result['CreateElasticsearchDomain']) , '</pre>';
        }

        $data['aws_account'] = $this->keys->aws_account;
        $data['regions'] = GetAwsRegions($this->keys);
        return view('elasticsearch/wizard_modal', $data);
    }

    // manual test for elasticsearch
    public function CreateElasticsearchDomain() {
        $result = $this->elasticsearch->CreateElasticsearchDomain([
            'DomainName' => 'esm-test-02',
            'EBSOptions' => [
                'EBSEnabled' => true,
                'VolumeSize' => 10,
                'VolumeType' => 'gp2'
            ]
        ]);

        echo '<pre>' , var_dump($result) , '</pre>';
    }

    public function DeleteElasticsearchDomain($domain) {
        $result = $this->elasticsearch->DeleteElasticsearchDomain([
            'DomainName' => $domain
        ]);

        echo '<pre>' , var_dump($result) , '</pre>';
    }

    public function DescribeElasticsearchDomain($domain) {
        $result = $this->elasticsearch->DescribeElasticsearchDomain([
            'DomainName' => $domain
        ]);

        echo '<pre>' , var_dump($result) , '</pre>';
    }

}