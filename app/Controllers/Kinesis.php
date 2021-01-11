<?php namespace App\Controllers;

class Kinesis extends BaseController
{
    protected $authKeysModel;

    public function __construct() {
        $this->authKeysModel = new \App\Models\AuthKeysModel();
    }

    public function index()
    {
        $this->data['meta']['header'] = 'AWS Kinesis';
        $this->data['meta']['subheader'] = 'data streams';

        array_push($this->data['css'],
            '/bower_components/select2/dist/css/select2.min.css',
            '/bower_components/datatables/media/css/dataTables.bootstrap.min.css',
            '/bower_components/jQuery-Smart-Wizard/css/smart_wizard.css'
        );

        array_push($this->data['scripts'],
            '/bower_components/bootbox.js/bootbox.js',
            '/bower_components/jquery-mockjax/dist/jquery.mockjax.min.js',
            '/bower_components/select2/dist/js/select2.min.js',
            '/bower_components/datatables/media/js/jquery.dataTables.min.js',
            '/bower_components/datatables/media/js/dataTables.bootstrap.js',
            '/bower_components/jquery-validation/dist/jquery.validate.min.js',
            '/bower_components/jQuery-Smart-Wizard/js/jquery.smartWizard.js',
            '/assets/js/pages/kinesis.js'
        );

        return view('kinesis/index', $this->data);
    }

    public function add() {
        if($this->request->getPost()) {

            // return;
        }

        return view('kinesis/wizard');
    }

    public function verify() {
        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->asObject()->first();

        $aws = new \App\Libraries\AmazonSDK([
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);
    }
}
