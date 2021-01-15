<?php
namespace App\Controllers;

class Kinesis extends BaseController
{
    protected $authKeysModel, $kinesisDataStreamsModel;

    public function __construct() {
        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->kinesisDataStreamsModel = new \App\Models\KinesisDataStreamsModel();
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
            $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

            $aws = new \App\Libraries\Aws([
                'region' => $_POST['region'],
                'access' => $keys->aws_access,
                'secret' => $keys->aws_secret
            ]);

            // aws createStream
            $result['kinesisCreateStream'] = $aws->kinesisCreateStream([
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
        $keys = $this->authKeysModel->where('user_id', $stream->user_id)->first();

        $aws = new \App\Libraries\Aws([
            'region' => $stream->region,
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);

        $result = false;
        try {
            $result['deleteStream'] = $aws->kinesis->deleteStream([
                'EnforceConsumerDeletion' => true,
                'StreamName' => str_replace(' ', '_', $stream->name)
            ]);

            $result['delete'] = $this->kinesisDataStreamsModel->where('id', $id)->delete();
        } catch (Exception $e) {
            return $e;
        }

        return json_encode([
            'result' => $result
        ]);
    }

    public function verify() {
        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();

        $aws = new \App\Libraries\Aws([
            'region' => 'us-east-2',
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);

        $result = $aws->kinesisCreateStream([
            'ShardCount' => 1,
            'StreamName' => 'Sample_Data_Stream'
        ]);

        var_dump($result);
    }
}
