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
        $this->data['meta']['header'] = 'ElasticSearch';
        $this->data['meta']['subheader'] = 'setup your searches!';

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
            '/assets/js/pages/elasticsearch.js'
        );

        return view('elasticsearch/index', $this->data);
    }

    public function add() {
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