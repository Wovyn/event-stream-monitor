<?php
namespace App\Controllers;

class Eventstreams extends BaseController
{

    protected $authKeysModel, $iam;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();

        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        if($keys) {
            $this->iam = new \App\Libraries\Iam([
                'access' => $keys->aws_access,
                'secret' => $keys->aws_secret
            ]);
        }
    }

    public function index() {
        $this->data['meta']['header'] = 'Event Streams';
        $this->data['meta']['subheader'] = 'connecting streams';

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
            '/assets/js/pages/eventstreams.js'
        );

        return view('eventstreams/index', $this->data);
    }

    public function add() {

    }

    public function listRoles() {
        $this->iam->client();
        echo '<pre>' , var_dump($this->iam->ListRoles()) , '</pre>';
    }

    public function getUser() {
        $this->iam->client();
        echo '<pre>' , var_dump($this->iam->GetUser()) , '</pre>';
    }

}