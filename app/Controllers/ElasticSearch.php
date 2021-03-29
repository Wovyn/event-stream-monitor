<?php
namespace App\Controllers;

class ElasticSearch extends BaseController
{

    public function __construct() {
        parent::__construct();

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

}