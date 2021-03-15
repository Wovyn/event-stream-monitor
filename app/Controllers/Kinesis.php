<?php
namespace App\Controllers;

class Kinesis extends BaseController
{
    protected $authKeysModel,
        $kinesisDataStreamsModel,
        $ionAuth,
        $kinesis,
        $awsconfig,
        $keys;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();
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

        $this->awsconfig = new \Config\Aws();
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

    public function get_dt_listing() {
        $order = $_POST['columns'][$_POST['order'][0]['column']]['name'];
        $sort = $_POST['order'][0]['dir'];
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        // $search = $_POST['search']['value'];

        $rows = $this->kinesisDataStreamsModel
            ->orderBy($order, $sort)
            ->findAll($limit, $offset);

        foreach ($rows as $row) {
            $row->region_name = $this->awsconfig->regions[$row->region];
        }

        $total = $this->kinesisDataStreamsModel->countAll();
        $tbl = array(
            "iTotalRecords"=> $total,
            "iTotalDisplayRecords"=> $total,
            "aaData"=> $rows
        );

        return $this->response->setJSON(json_encode($tbl));
    }

    public function add() {
        if($_POST) {
            // aws createStream
            $this->kinesis->setRegion($_POST['region']);
            $result['CreateStream'] = $this->kinesis->CreateStream([
                'ShardCount' => (int) $_POST['shards'],
                'StreamName' => str_replace(' ', '_', $_POST['name'])
            ]);

            // insert to database
            if(!$result['CreateStream']['error']) {
                $result['save'] = $this->kinesisDataStreamsModel->save([
                    'user_id' => $this->data['user']->id,
                    'region' => $_POST['region'],
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'shards' => $_POST['shards']
                ]);
            }

            return $this->response->setJSON(json_encode([
                'error' => $result['CreateStream']['error'],
                'message' => ($result['CreateStream']['error'] ? $result['CreateStream']['message'] : 'Successfully created Data Stream!'),
                'result' => $result
            ]));
        }

        $data['regions'] = $this->GetAwsRegions();
        return view('kinesis/wizard_modal', $data);
    }

    public function GetAwsRegions() {
        if($this->keys) {
            $ec2 = new \App\Libraries\Ec2([
                'access' => $this->keys->aws_access,
                'secret' => $this->keys->aws_secret
            ]);

            $result = $ec2->DescribeRegions();

            $regions = [];
            if(!$result['error']) {
                foreach ($result['describeRegions']['Regions'] as $region) {
                    $regions[$region['RegionName']] = $this->awsconfig->regions[$region['RegionName']];
                }
            }
        } else {
            // set to default
            $regions = $this->awsconfig->regions;
        }

        asort($regions, SORT_STRING);
        return $regions;
    }

    public function delete($id) {
        // hook aws deleteStream API
        $stream = $this->kinesisDataStreamsModel->where('id', $id)->first();

        $this->kinesis->setRegion($stream->region);
        $result['DeleteStream'] = $this->kinesis->DeleteStream([
            'EnforceConsumerDeletion' => true,
            'StreamName' => str_replace(' ', '_', $stream->name)
        ]);

        if(!$result['DeleteStream']['error']) {
            $result['delete'] = $this->kinesisDataStreamsModel->where('id', $id)->delete();
        }

        return $this->response->setJSON(json_encode([
            'error' => $result['DeleteStream']['error'],
            'message' => ($result['DeleteStream']['error'] ? $result['DeleteStream']['message'] : 'Successfully deleted Data Stream!'),
            'result' => $result
        ]));
    }

    public function view($id) {
        $stream = $this->kinesisDataStreamsModel->where('id', $id)->first();

        $this->kinesis->setRegion($stream->region);
        $result = $this->kinesis->DescribeStreamSummary([
            'StreamName' => $stream->name
        ]);

        $data['stream'] = $result['describeStreamSummary']['StreamDescriptionSummary'];
        return view('kinesis/view_modal', $data);
    }
}
