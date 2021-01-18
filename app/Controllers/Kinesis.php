<?php
namespace App\Controllers;

class Kinesis extends BaseController
{
    protected $authKeysModel, $kinesisDataStreamsModel, $ionAuth, $aws;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->kinesisDataStreamsModel = new \App\Models\KinesisDataStreamsModel();

        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        $this->aws = new \App\Libraries\Aws([
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);
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

        $total = $this->kinesisDataStreamsModel->countAll();
        $tbl = array(
            "iTotalRecords"=> $total,
            "iTotalDisplayRecords"=> $total,
            "aaData"=> $rows
        );

        return json_encode($tbl);
    }

    public function add() {
        if($_POST) {
            // aws createStream
            $this->aws->kinesisClient($_POST['region']);
            $result['kinesisCreateStream'] = $this->aws->kinesisCreateStream([
                'ShardCount' => (int) $_POST['shards'],
                'StreamName' => str_replace(' ', '_', $_POST['name'])
            ]);

            // insert to database
            if(!$result['kinesisCreateStream']['error']) {
                $result['save'] = $this->kinesisDataStreamsModel->save([
                    'user_id' => $this->data['user']->id,
                    'region' => $_POST['region'],
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'shards' => $_POST['shards']
                ]);
            }

            return json_encode([
                'error' => $result['kinesisCreateStream']['error'],
                'message' => ($result['kinesisCreateStream']['error'] ? $result['kinesisCreateStream']['message'] : 'Successfully created Data Stream!'),
                'result' => $result
            ]);
        }

        return view('kinesis/wizard');
    }

    public function delete($id) {
        // hook aws deleteStream API
        $stream = $this->kinesisDataStreamsModel->where('id', $id)->first();

        $this->aws->kinesisClient($stream->region);
        $result['kinesisDeleteStream'] = $this->aws->kinesisDeleteStream([
            'EnforceConsumerDeletion' => true,
            'StreamName' => str_replace(' ', '_', $stream->name)
        ]);

        if(!$result['kinesisDeleteStream']['error']) {
            $result['delete'] = $this->kinesisDataStreamsModel->where('id', $id)->delete();
        }

        return json_encode([
                'error' => $result['kinesisDeleteStream']['error'],
                'message' => ($result['kinesisDeleteStream']['error'] ? $result['kinesisDeleteStream']['message'] : 'Successfully deleted Data Stream!'),
                'result' => $result
            ]);
    }

    public function verify() {
        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        $aws = new \App\Libraries\Aws([
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);

        $aws->kinesisClient('us-east-2');

        var_dump($aws->describeRegions());
    }
}
