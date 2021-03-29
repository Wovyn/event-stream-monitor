<?php
namespace App\Controllers;

class Firehose extends BaseController
{

    public function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->data['meta']['header'] = 'Firehose';
        $this->data['meta']['subheader'] = 'hose down your searches!';

        array_push($this->data['css'],

        );

        array_push($this->data['scripts'],

        );

        return view('firehose/index', $this->data);
    }

}