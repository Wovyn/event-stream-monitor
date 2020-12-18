<?php namespace App\Controllers;

class Dashboard extends BaseController
{
	public function index()
	{
        $this->data['meta']['header'] = 'Dashboard';
        $this->data['meta']['subheader'] = 'overview & stats';

        array_push($this->data['css'],
            "/bower_components/fullcalendar/dist/fullcalendar.min.css"
        );

        array_push($this->data['scripts'],
            '/bower_components/Flot/jquery.flot.js',
            '/bower_components/Flot/jquery.flot.pie.js',
            '/bower_components/Flot/jquery.flot.resize.js',
            '/assets/plugin/jquery.sparkline.min.js',
            '/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
            '/bower_components/jqueryui-touch-punch/jquery.ui.touch-punch.min.js',
            '/bower_components/moment/min/moment.min.js',
            '/bower_components/fullcalendar/dist/fullcalendar.min.js',
            '/assets/js/min/index.min.js',
            '/assets/js/pages/dashboard.js',
            '/assets/js/app.js'
        );

		return view('dashboard/index', $this->data);
	}

}
