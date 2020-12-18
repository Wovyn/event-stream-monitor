<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
        $this->data['meta']['header'] = 'Dashboard';
        $this->data['meta']['subheader'] = 'overview & stats';

		return view('dashboard/index', $this->data);
	}

}
