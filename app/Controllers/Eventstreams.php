<?php
namespace App\Controllers;

class Eventstreams extends BaseController
{

    protected $authKeysModel, $eventstreamSinksModel, $kinesisDataStreamsModel, $twilio, $kinesis, $keys;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->eventstreamSinksModel = new \App\Models\EventstreamSinksModel();
        $this->kinesisDataStreamsModel = new \App\Models\KinesisDataStreamsModel();

        $this->keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();
        if($this->keys) {
            $this->twilio = new \App\Libraries\Twilio(
                $this->keys->twilio_sid,
                $this->keys->twilio_secret
            );

            $this->kinesis = new \App\Libraries\Kinesis([
                'access' => $this->keys->aws_access,
                'secret' => $this->keys->aws_secret
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
            '/assets/js/eventstream.js',
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
        if($_POST) {
            $data = [
                'user_id' => $this->data['user']->id,
                'description' => $_POST['description'],
                'sink_type' => $_POST['sink_type']
            ];

            switch ($data['sink_type']) {
                case 'kinesis':
                    $stream = $this->kinesisDataStreamsModel->where('id', $_POST['kinesis_data_stream'])->first();
                    $sink_config = [
                        'arn' => "arn:aws:kinesis:{$stream->region}:{$this->keys->aws_account}:stream/{$stream->name}",
                        'role_arn' => $this->keys->event_stream_role_arn,
                        'external_id' => $this->keys->external_id
                    ];

                    break;

                case 'webhook':
                    $sink_config = [
                        'destination' => $_POST['destination_url'],
                        'method' => $_POST['method'],
                        'batch_events' => $_POST['batch_events']
                    ];

                    break;
            }

            $result['CreateSink'] = $this->twilio->CreateSink([
                'description' => $data['description'],
                'sink_type' => $data['sink_type'],
                'config' => $sink_config
            ]);

            if(!$result['CreateSink']['error']) {
                $data['sid'] = $result['CreateSink']['CreatedSink']->sid;
                $data['status'] = $result['CreateSink']['CreatedSink']->status;

                $result['save'] = $this->eventstreamSinksModel->save($data);
            }

            return $this->response->setJSON(json_encode([
                'error' => $result['CreateSink']['error'],
                'message' => ($result['CreateSink']['error'] ? $result['CreateSink']['message'] : 'Successfully created Sink Instance!'),
                'result' => $result
            ]));
        }

        $data['kinesis'] = [
            'event_stream_role_arn' => $this->keys->event_stream_role_arn,
            'external_id' => $this->keys->external_id
        ];
        $data['kinesisDataStreams'] = $this->kinesisDataStreamsModel->where('user_id', $this->data['user']->id)->findAll();
        return view('eventstreams/add_modal', $data);
    }

    public function delete($id) {
        // hook DeleteSink API
        $sink = $this->eventstreamSinksModel->where('id', $id)->first();

        $result['DeleteSink'] = $result = $this->twilio->DeleteSink($sink->sid);

        if(!$result['DeleteSink']['error']) {
            $result['delete'] = $this->eventstreamSinksModel->where('id', $id)->delete();
        }

        return $this->response->setJSON(json_encode([
            'error' => $result['DeleteSink']['error'],
            'message' => ($result['DeleteSink']['error'] ? $result['DeleteSink']['message'] : 'Successfully deleted Sink Instance!'),
            'result' => $result
        ]));
    }

    public function sync() {
        $sinks = $this->eventstreamSinksModel->where('user_id', $this->data['user']->id)->findAll();
        foreach ($sinks as $sink) {
            switch ($sink->status) {
                case 'initialized':
                    $result['SinkTest'] = $this->twilio->SinkTest($sink->sid);

                    break;

                case 'validating':
                    $result['FetchSink'] = $this->twilio->FetchSink($sink->sid);
                    $arn = explode('stream/', $result['FetchSink']['Sink']->sinkConfiguration['arn']);
                    $streamName = $arn[1];

                    $result['GetAllRecords'] = $this->kinesis->GetAllRecords($streamName);
                    foreach ($result['GetAllRecords'] as $record) {
                        $recordData = json_decode($record['Data'], true);

                        if(!is_null($recordData)) {
                            if($recordData['type'] == 'com.twilio.eventstreams.test-event') {
                                $result['SinkValid'] = $this->twilio->SinkValid($sink->sid, $recordData['data']['test_id']);
                            }
                        }
                    }

                    break;
            }

            if($sink->status != 'active') {
                $result['FetchSink'] = $this->twilio->FetchSink($sink->sid);
                $this->eventstreamSinksModel
                    ->where('sid', $sink->sid)
                    ->update(null, [
                        'status' => $result['FetchSink']['Sink']->status
                    ]);
            }

        }

        $sinks = $this->eventstreamSinksModel->where('user_id', $this->data['user']->id)->findAll();
        $es = new \App\Libraries\EventStream();
        $es->event([
            'data' => json_encode($sinks)
        ]);
    }

    public function subscriptions($id) {
        $sink = $this->eventstreamSinksModel->where('id', $id)->first();

        $result['FetchSinkSubscriptions'] = $this->twilio->FetchSinkSubscriptions($sink->sid);

        echo '<pre>' , var_dump($result) , '</pre>';
    }

}