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

    public function sync($do_event = true) {
        $domains = $this->elasticsearchModel->where('user_id', $this->data['user']->id)->findAll();
        foreach ($domains as $domain) {
            $settings = json_decode($domain->settings, true);

            debug('Domain Name: ' . $domain->domain_name . ' DB Status: ' . $domain->status);

            switch ($domain->status) {
                case 'loading':
                case 'updating':
                    $describe = $this->elasticsearch->DescribeElasticsearchDomain([
                        'DomainName' => $domain->domain_name
                    ]);

                    debug(json_encode($describe['response']['DomainStatus']));

                    if(!$describe['response']['DomainStatus']['Processing']) {
                        if(isset($describe['response']['DomainStatus']['Endpoint']) && !$describe['response']['DomainStatus']['Deleted']) {
                            $settings['Endpoint'] = $describe['response']['DomainStatus']['Endpoint'];

                            $this->elasticsearchModel
                                ->update($domain->id, [
                                    'status' => 'active',
                                    'settings' => json_encode($settings)
                                ]);
                        }
                    }

                    break;
            }
        }

        if($do_event) {
            $data = $this->elasticsearchModel->where('user_id', $this->data['user']->id)->findAll();
            $es = new \App\Libraries\EventStream();
            $es->event([
                'data' => json_encode($data)
            ]);
        }
    }

    public function add() {
        if($_POST) {
            // compile create elasticsearch domain request
            $request = $this->elasticsearch->formatRequest('create', $_POST);

            $this->elasticsearch->setRegion($_POST['region']);
            $result['CreateElasticsearchDomain'] = $this->elasticsearch->CreateElasticsearchDomain($request);

            // check if request has error
            if(!$result['CreateElasticsearchDomain']['error']) {
                // compile settings field
                $settings = [];
                if(isset($_POST['fine_grain_access_control'])) {
                    $settings['MasterUserName'] = $_POST['master_username'];
                }

                // save domain to db
                $result['save'] = $this->elasticsearchModel->save([
                    'user_id' => $this->data['user']->id,
                    'region' => $_POST['region'],
                    'domain_name' => $_POST['domain_name'],
                    'status' => 'loading',
                    'settings' => json_encode($settings)
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

    public function edit($id) {
        $domain = $this->elasticsearchModel->where('id', $id)->first();

        $result['DescribeElasticsearchDomain'] = $this->elasticsearch->DescribeElasticsearchDomain([
            'DomainName' => $domain->domain_name
        ]);

        $data['db_config'] = $domain;
        $data['db_config_settings'] = json_decode($domain->settings, true);

        if($_POST) {
            $request = $this->elasticsearch->formatRequest('update', $_POST);
            $result['UpdateElasticsearchDomainConfig'] = $this->elasticsearch->UpdateElasticsearchDomainConfig($request);

            // check if request has error
            if(!$result['UpdateElasticsearchDomainConfig']['error']) {
                // compile settings field
                $settings = [];
                if(isset($_POST['fine_grain_access_control'])) {
                    $settings['MasterUserName'] = $_POST['master_username'];
                }

                // update domain
                $result['update'] = $this->elasticsearchModel->update($id, [
                    'status' => 'updating',
                    'settings' => json_encode($settings)
                ]);
            }

            return $this->response->setJSON(json_encode([
                'error' => $result['UpdateElasticsearchDomainConfig']['error'],
                'message' => ($result['UpdateElasticsearchDomainConfig']['error'] ? $result['UpdateElasticsearchDomainConfig']['message'] : 'Successfully updated Elasticsearch Domain!'),
                'result' => $result
            ]));
        }

        $data['aws_config'] = $result['DescribeElasticsearchDomain']['response']['DomainStatus'];
        $data['aws_account'] = $this->keys->aws_account;
        $data['regions'] = GetAwsRegions($this->keys);
        return view('elasticsearch/wizard_modal', $data);
    }

    public function delete($id) {
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

    public function view($id) {
        $domain = $this->elasticsearchModel->where('id', $id)->first();

        $result = $this->elasticsearch->DescribeElasticsearchDomain([
            'DomainName' => $domain->domain_name
        ]);

        $data['domain'] = $result['response']['DomainStatus'];

        return view('elasticsearch/view_modal', $data);
    }

    // manual test for elasticsearch
    public function DescribeElasticsearchDomain($domain) {
        $result = $this->elasticsearch->DescribeElasticsearchDomain([
            'DomainName' => $domain
        ]);

        echo '<pre>' , var_dump($result['response']['DomainStatus']) , '</pre>';
    }

    public function DescribeElasticsearchDomainConfig($domain) {
        $result = $this->elasticsearch->DescribeElasticsearchDomainConfig([
            'DomainName' => $domain
        ]);

        echo '<pre>' , var_dump($result['response']['DomainConfig']) , '</pre>';
    }

    public function ListCertificates() {
        $this->acm->setRegion('us-east-2');
        $result = $this->acm->listCertificates();

        echo '<pre>' , var_dump($result) , '</pre>';
    }
}