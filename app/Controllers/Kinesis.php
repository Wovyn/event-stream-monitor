<?php namespace App\Controllers;

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

    public function add() {
        if($_POST) {
            $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->asObject()->first();

            $aws = new \App\Libraries\Aws([
                'region' => $_POST['region'],
                'access' => $keys->aws_access,
                'secret' => $keys->aws_secret
            ]);

            $result = false;

            // aws createStream
            try {
                $result = $aws->kinesis->createStream([
                    'ShardCount' => (int) $_POST['shards'],
                    'StreamName' => str_replace(' ', '_', $_POST['name'])
                ]);
            } catch (Exception $e) {
                return $e;
            }

            // insert to database
            if($result) {
                $this->kinesisDataStreamsModel->save([
                    'user_id' => $this->data['user']->id,
                    'region' => $_POST['region'],
                    'name' => $_POST['name'],
                    'description' => $_POST['description'],
                    'shards' => $_POST['shards']
                ]);
            }

            return json_encode([
                'error' => !$result,
                'message' => ($result ? 'Successfully created Data Stream!' : 'Something went wrong.')
            ]);
        }

        return view('kinesis/wizard');
    }

    public function verify() {
        $keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->asObject()->first();

        $aws = new \App\Libraries\Aws([
            'region' => 'us-east-2',
            'access' => $keys->aws_access,
            'secret' => $keys->aws_secret
        ]);

        try {
            $result = $aws->kinesis->createStream([
                'ShardCount' => 1,
                'StreamName' => 'Sample_Data_Stream2'
            ]);

            echo '<pre>' , var_dump($result) , '</pre>';
        } catch (Exception $e) {
            echo '<pre>' , var_dump($e) , '</pre>';
        }
    }

}
