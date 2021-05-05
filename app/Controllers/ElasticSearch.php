<?php
namespace App\Controllers;

class ElasticSearch extends BaseController
{

    protected $authKeysModel,
        $elasticsearchModel,
        $elasticsearch,
        $acm,
        $awsconfig,
        $keys;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->elasticsearchModel = new \App\Models\ElasticsearchModel();

        $this->keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();
        if($this->keys) {
            $this->elasticsearch = new \App\Libraries\Elasticsearch([
                'access' => $this->keys->aws_access,
                'secret' => $this->keys->aws_secret
            ]);

            $this->acm = new \App\Libraries\Acm([
                'access' => $this->keys->aws_access,
                'secret' => $this->keys->aws_secret
            ]);
        }

        $this->awsconfig = new \Config\Aws();
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
            '/assets/js/eventstream.js',
            '/assets/js/pages/elasticsearch.js'
        );

        return view('elasticsearch/index', $this->data);
    }

    public function get_dt_listing() {
        $order = $_POST['columns'][$_POST['order'][0]['column']]['name'];
        $sort = $_POST['order'][0]['dir'];
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        // $search = $_POST['search']['value'];

        $rows = $this->elasticsearchModel
            ->where('user_id', $this->data['user']->id)
            ->orderBy($order, $sort)
            ->findAll($limit, $offset);

        foreach ($rows as $row) {
            $row->region_name = $this->awsconfig->regions[$row->region];
        }

        $total = $this->elasticsearchModel->countAll();
        $tbl = array(
            "iTotalRecords"=> $total,
            "iTotalDisplayRecords"=> $total,
            "aaData"=> $rows
        );

        return $this->response->setJSON(json_encode($tbl));
    }

    public function sync() {
        $domains = $this->elasticsearchModel->where('user_id', $this->data['user']->id)->findAll();
        foreach ($domains as $domain) {
            switch ($domain->status) {
                case 'loading':
                    $describe = $this->elasticsearch->DescribeElasticsearchDomain([
                        'DomainName' => $domain->domain_name
                    ]);

                    if(isset($describe['response']['DomainStatus']['Endpoint']) && !$describe['response']['DomainStatus']['Deleted']) {
                        $this->elasticsearchModel
                            ->update($domain->id, [
                                'status' => 'active',
                                'settings' => json_encode([
                                    'Endpoint' => $describe['response']['DomainStatus']['Endpoint'],
                                ])
                            ]);
                    }

                    break;
            }
        }

        $data = $this->elasticsearchModel->where('user_id', $this->data['user']->id)->findAll();
        $es = new \App\Libraries\EventStream();
        $es->event([
            'data' => json_encode($data)
        ]);
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
                    'VolumeSize' => (int) $_POST['ebs_storage_size_per_node'],
                    'VolumeType' => $_POST['ebs_volume_type'],
                ],
                'NodeToNodeEncryptionOptions' => [
                    'Enabled' => isset($_POST['note_to_node_encryption']),
                ],

                // custom domain
                'DomainEndpointOptions' => [
                    'EnforceHTTPS' => isset($_POST['require_https']),
                    'CustomEndpointEnabled' => false
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

            if($_POST['ebs_volume_type'] == 'io1') {
                $request['EBSOptions']['Iops'] = (int) $_POST['provisioned_iops'];
            }

            $request['DomainEndpointOptions']['CustomEndpointEnabled'] = isset($_POST['custom_endpoint']);
            if(isset($_POST['custom_endpoint'])) {
                $request['DomainEndpointOptions']['CustomEndpoint'] = $_POST['custom_hostname'];
                $request['DomainEndpointOptions']['CustomEndpointCertificateArn'] = $_POST['aws_certificate'];
            }

            $request['ElasticsearchClusterConfig']['DedicatedMasterEnabled'] = isset($_POST['dedicated_master_nodes']);
            if(isset($_POST['dedicated_master_nodes'])) {
                $request['ElasticsearchClusterConfig']['DedicatedMasterType'] = $_POST['dedicated_master_node_instance_type'];
                $request['ElasticsearchClusterConfig']['DedicatedMasterCount'] = (int) $_POST['dedicated_master_node_number_of_nodes'];
            }

            $request['ElasticsearchClusterConfig']['WarmEnabled'] = isset($_POST['ultrawarm_data_node']);
            if(isset($_POST['ultrawarm_data_node'])) {
                $request['ElasticsearchClusterConfig']['WarmType'] = $_POST['ultrawarm_instance_type'];
                $request['ElasticsearchClusterConfig']['WarmCount'] = (int) $_POST['number_of_warm_data_nodes'];
            }

            $this->elasticsearch->setRegion($_POST['region']);
            $result['CreateElasticsearchDomain'] = $this->elasticsearch->CreateElasticsearchDomain($request);

            if(!$result['CreateElasticsearchDomain']['error']) {
                $result['save'] = $this->elasticsearchModel->save([
                    'user_id' => $this->data['user']->id,
                    'region' => $_POST['region'],
                    'domain_name' => $_POST['domain_name'],
                    'status' => 'loading'
                ]);
            }

            return $this->response->setJSON(json_encode([
                'error' => $result['CreateElasticsearchDomain']['error'],
                'message' => ($result['CreateElasticsearchDomain']['error'] ? $result['CreateElasticsearchDomain']['message'] : 'Successfully created Elasticsearch Domain!'),
                'result' => $result
            ]));
        }

        $data['aws_account'] = $this->keys->aws_account;
        $data['regions'] = GetAwsRegions($this->keys);
        return view('elasticsearch/wizard_modal', $data);
    }

    function delete($id) {
        $domain = $this->elasticsearchModel->where('id', $id)->first();

        $this->elasticsearch->setRegion($domain->region);
        $result['DeleteElasticsearchDomain'] = $this->elasticsearch->DeleteElasticsearchDomain([
            'DomainName' => $domain->domain_name
        ]);

        if(!$result['DeleteElasticsearchDomain']['error']) {
            $result['delete'] = $this->elasticsearchModel->where('id', $id)->delete();
        }

        return $this->response->setJSON(json_encode([
            'error' => $result['DeleteElasticsearchDomain']['error'],
            'message' => ($result['DeleteElasticsearchDomain']['error'] ? $result['DeleteElasticsearchDomain']['message'] : 'Successfully deleted Data Stream!'),
            'result' => $result
        ]));
    }

    public function certificates($region) {
        $this->acm->setRegion($region);
        $result = $this->acm->listCertificates();

        return $this->response->setJSON(json_encode([
            'error' => $result['error'],
            'message' => ($result['error'] ? $result['message'] : 'Successfully fetched Certificates.'),
            'certificates' => ($result['error'] ? [] : $result['response']['CertificateSummaryList'])
        ]));
    }

    // manual test for elasticsearch
    public function DescribeElasticsearchDomain($domain) {
        $result = $this->elasticsearch->DescribeElasticsearchDomain([
            'DomainName' => $domain
        ]);

        echo '<pre>' , var_dump($result) , '</pre>';
    }

    public function ListCertificates() {
        $this->acm->setRegion('us-east-2');
        $result = $this->acm->listCertificates();

        echo '<pre>' , var_dump($result) , '</pre>';
    }

}