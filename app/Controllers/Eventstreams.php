<?php
namespace App\Controllers;

class Eventstreams extends BaseController
{

    protected $authKeysModel, $eventstreamSinksModel, $kinesisDataStreamsModel;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->eventstreamSinksModel = new \App\Models\EventstreamSinksModel();
        $this->kinesisDataStreamsModel = new \App\Models\KinesisDataStreamsModel();
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

    public function get_dt_listing() {
        $order = $_POST['columns'][$_POST['order'][0]['column']]['name'];
        $sort = $_POST['order'][0]['dir'];
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        // $search = $_POST['search']['value'];

        $rows = $this->eventstreamSinksModel
            ->orderBy($order, $sort)
            ->findAll($limit, $offset);

        $total = $this->eventstreamSinksModel->countAll();
        $tbl = array(
            "iTotalRecords"=> $total,
            "iTotalDisplayRecords"=> $total,
            "aaData"=> $rows
        );

        return $this->response->setJSON(json_encode($tbl));
    }

    public function add() {
        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        $data['kinesis'] = [
            'event_stream_role_arn' => $keys->event_stream_role_arn,
            'external_id' => $keys->external_id
        ];

        $data['kinesisDataStreams'] = $this->kinesisDataStreamsModel->where('user_id', $this->data['user']->id)->findAll();
        return view('eventstreams/add_modal', $data);
    }

}