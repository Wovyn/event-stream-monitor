<?php
namespace App\Controllers;

class Firehose extends BaseController
{

    public function __construct() {
        parent::__construct();

    }

    public function index() {
        $this->data['meta']['header'] = 'Kinesis Data Firehose';
        $this->data['meta']['subheader'] = 'connect your data streams';

        array_push($this->data['css'],

        );

        array_push($this->data['scripts'],

        );

        return view('firehose/index', $this->data);
    }

}