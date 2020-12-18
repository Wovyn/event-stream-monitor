<?php namespace App\Controllers;

class Kinesis extends BaseController
{
    public function index()
    {
        $this->data['meta']['header'] = 'AWS Kinesis';
        $this->data['meta']['subheader'] = 'data streams';

        return view('kinesis/index', $this->data);
    }

}
