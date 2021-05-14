<?php
namespace App\Controllers;

class Firehose extends BaseController
{
    protected $authKeysModel,
        $firehoseModel,
        $kinesisDataStreamsModel,
        $elasticsearchModel,
        $s3,
        $awsconfig,
        $keys;

    public function __construct() {
        parent::__construct();

        $this->authKeysModel = new \App\Models\AuthKeysModel();
        $this->firehoseModel = new \App\Models\FirehoseModel();
        $this->elasticsearchModel = new \App\Models\ElasticsearchModel();
        $this->kinesisDataStreamsModel = new \App\Models\KinesisDataStreamsModel();

        $this->keys = $this->authKeysModel->where('user_id', $this->data['user']->id)->first();
        if($this->keys) {
            $this->s3 = new \App\Libraries\S3([
                'access' => $this->keys->aws_access,
                'secret' => $this->keys->aws_secret
            ]);
        }

        $this->awsconfig = new \Config\Aws();
    }

    public function index() {
        $this->data['meta']['header'] = 'Kinesis Data Firehose';
        $this->data['meta']['subheader'] = 'connect your data streams';

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
            '/assets/js/pages/firehose.js'
        );

        return view('firehose/index', $this->data);
    }

    public function get_dt_listing() {
        $order = $_POST['columns'][$_POST['order'][0]['column']]['name'];
        $sort = $_POST['order'][0]['dir'];
        $offset = $_POST['start'];
        $limit = $_POST['length'];
        // $search = $_POST['search']['value'];

        $rows = $this->firehoseModel
            ->select('*, kinesis_data_streams.name AS kinesis_name, elasticsearch.domain_name AS elasticsearch_name')
            ->where('firehose.user_id', $this->data['user']->id)
            ->join('kinesis_data_streams', 'kinesis_data_streams.id = firehose.kinesis_id')
            ->join('elasticsearch', 'elasticsearch.id = firehose.elasticsearch_id')
            ->orderBy($order, $sort)
            ->findAll($limit, $offset);

        foreach ($rows as $row) {
            $row->region_name = $this->awsconfig->regions[$row->region];
        }

        $total = $this->firehoseModel->countAll();
        $tbl = array(
            "iTotalRecords"=> $total,
            "iTotalDisplayRecords"=> $total,
            "aaData"=> $rows
        );

        return $this->response->setJSON(json_encode($tbl));
    }

    public function add() {
        $kinesis = $this->kinesisDataStreamsModel->where('user_id', $this->data['user']->id)->findAll();
        $data['kinesis'] = $this->format_data('kinesis', $kinesis);

        $domains = $this->elasticsearchModel->where([
            'user_id' => $this->data['user']->id,
            'status' => 'active'
        ])->findAll();
        $data['domains'] = $this->format_data('elasticsearch', $domains);

        $data['regions'] = GetAwsRegions($this->keys);
        return view('firehose/wizard_modal', $data);
    }

    public function format_data($type, $data) {
        $result = [];
        foreach ($data as $item) {
            // check if region exist
            if(!isset($result[$item->region])) {
                $result[$item->region] = [];
            }

            array_push($result[$item->region], [
                'id' => $item->id,
                'text' => ( $type == 'kinesis' ? $item->name : $item->domain_name )
            ]);
        }

        return $result;
    }

    public function CreateBucket() {
        $this->s3->setRegion('us-east-2');
        $result = $this->s3->CreateBucket([
            // 'ACL' => 'private',
            'Bucket' => 'esm-bucket-test-01'
        ]);

        echo '<pre>' , var_dump($result) , '</pre>';
    }
}