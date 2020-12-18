<?php namespace App\Controllers;

class Kinesis extends BaseController
{
    public function index()
    {
        return view('dashboard/index', $this->data);
    }

}
