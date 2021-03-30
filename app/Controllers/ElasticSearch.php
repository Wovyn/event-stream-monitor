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

        );

        array_push($this->data['scripts'],

        );

        return view('elasticsearch/index', $this->data);
    }

    // manual test for elasticsearch
    public function CreateElasticsearchDomain() {
        $result = $this->elasticsearch->CreateElasticsearchDomain([
            'DomainName' => 'esm-test-02',
            // 'EBSOptions' => [
            //     'EBSEnabled' => true,
            //     'VolumeSize' => 10,
            //     'VolumeType' => 'gp2'
            // ]
        ]);

        echo '<pre>' , var_dump($result) , '</pre>';
    }

    public function test() {
        echo $this->elasticsearch->version();
    }

}