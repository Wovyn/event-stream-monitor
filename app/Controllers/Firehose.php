<?php
namespace App\Controllers;

class Firehose extends BaseController
{
    protected $authKeysModel,
        $firehoseModel,
        $kinesisDataStreamsModel,
        $elasticsearchModel,
        $s3,
        $firehose,
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

            $this->firehose = new \App\Libraries\Firehose([
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
            ->select('*,
                firehose.id AS firehose_id,
                firehose.name AS firehose_name,
                firehose.created_at AS firehose_created_at,
                firehose.updated_at AS firehose_updated_at,
                kinesis_data_streams.name AS kinesis_name,
                elasticsearch.domain_name AS elasticsearch_name')
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
        if($_POST) {
            // create bucket request
            $bucket_name = str_format('%name-bucket', [ '%name' => $_POST['name'] ]);

            $this->s3->setRegion($_POST['region']);
            $result['CreateBucket'] = $this->s3->CreateBucket([
                'Bucket' => str_format('%name-bucket', [ '%name' => $_POST['name'] ])
            ]);

            // check if CreateBucket has an error
            if($result['CreateBucket']['error']) {
                return $this->response->setJSON(json_encode([
                    'error' => $result['CreateBucket']['error'],
                    'message' => $result['CreateBucket']['message'],
                    'result' => $result['CreateBucket']
                ]));
            }

            $bucket_arn = str_format('arn:aws:s3:::%bucket', [ '%bucket' => $bucket_name ]);

            // create delivery stream request
            $this->firehose->setRegion($_POST['region']);
            $result['CreateDeliveryStream'] = $this->firehose->CreateDeliveryStream([
                'DeliveryStreamName' => $_POST['name'],
                'DeliveryStreamType' => 'KinesisStreamAsSource',
                'KinesisStreamSourceConfiguration' => [
                    'KinesisStreamARN' => GetKinesisArnFromID($this->data['user']->id, $_POST['kinesis_id']), // REQUIRED
                    'RoleARN' => $this->keys->s3_firehose_role_arn, // REQUIRED
                ],
                'ElasticsearchDestinationConfiguration' => [
                    'DomainARN' => GetDomainArnFromID($this->data['user']->id, $_POST['elasticsearch_id']),
                    'RoleARN' => $this->keys->s3_firehose_role_arn, // REQUIRED
                    'IndexName' => $_POST['index'],
                    'IndexRotationPeriod' => $_POST['index_rotation'],
                    'RetryOptions' => [
                        'DurationInSeconds' => (int) $_POST['retry_duration'],
                    ],
                    'S3BackupMode' => 'FailedDocumentsOnly',
                    'S3Configuration' => [ // REQUIRED
                        'BucketARN' => $bucket_arn, // REQUIRED
                        'RoleARN' => $this->keys->s3_firehose_role_arn, // REQUIRED
                    ]
                ],
            ]);

            if($result['CreateDeliveryStream']['error']) {
                return $this->response->setJSON(json_encode([
                    'error' => $result['CreateDeliveryStream']['error'],
                    'message' => $result['CreateDeliveryStream']['message'],
                    'result' => $result['CreateDeliveryStream']
                ]));
            }

            // hook to DB
            $result['save'] = $this->firehoseModel->save([
                'user_id' => $this->data['user']->id,
                'region' => $_POST['region'],
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'kinesis_id' => $_POST['kinesis_id'],
                'elasticsearch_id' => $_POST['elasticsearch_id'],
                's3_bucket' => $bucket_name
            ]);

            return $this->response->setJSON(json_encode([
                'error' => ($result['save'] ? false : true),
                'message' => 'Successfully created Delivery Stream!',
                'result' => $result
            ]));
        }

        $kinesis = $this->kinesisDataStreamsModel
            ->where('user_id', $this->data['user']->id)
            ->findAll();

        $data['kinesis'] = $this->format_data('kinesis', $kinesis);

        $domains = $this->elasticsearchModel
            ->where([
                'user_id' => $this->data['user']->id,
                'status' => 'active'
            ])
            ->findAll();

        $data['domains'] = $this->format_data('elasticsearch', $domains);

        $data['regions'] = GetAwsRegions($this->keys);
        return view('firehose/wizard_modal', $data);
    }

    public function delete($id) {
        $delivery = $this->firehoseModel->where('id', $id)->first();

        $this->s3->setRegion($delivery->region);
        $result['DeleteBucket'] = $this->s3->DeleteBucket([
            'Bucket' => $delivery->s3_bucket
        ]);

        if($result['DeleteBucket']['error']) {
            return $this->response->setJSON(json_encode([
                'error' => $result['DeleteBucket']['error'],
                'message' => $result['DeleteBucket']['message'],
                'result' => $result['DeleteBucket']
            ]));
        }

        $this->firehose->setRegion($delivery->region);
        $result['DeleteDeliveryStream'] = $this->firehose->DeleteDeliveryStream([
            'DeliveryStreamName' => $delivery->name
        ]);

        if(!$result['DeleteDeliveryStream']['error']) {
            $result['delete'] = $this->firehoseModel->where('id', $id)->delete();
        }

        return $this->response->setJSON(json_encode([
            'error' => $result['DeleteDeliveryStream']['error'],
            'message' => ($result['DeleteDeliveryStream']['error'] ? $result['DeleteDeliveryStream']['message'] : 'Successfully deleted Delivery Stream!'),
            'result' => $result
        ]));
    }

    private function format_data($type, $data) {
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

    public function view($id) {
        $delivery = $this->firehoseModel
            ->select('*,
                firehose.id AS firehose_id,
                firehose.name AS firehose_name,
                firehose.created_at AS firehose_created_at,
                firehose.updated_at AS firehose_updated_at,
                kinesis_data_streams.name AS kinesis_name,
                elasticsearch.domain_name AS elasticsearch_name')
            ->join('kinesis_data_streams', 'kinesis_data_streams.id = firehose.kinesis_id')
            ->join('elasticsearch', 'elasticsearch.id = firehose.elasticsearch_id')
            ->where('firehose.id', $id)->first();

        $this->firehose->setRegion($delivery->region);
        $result = $this->firehose->DescribeDeliveryStream([
            'DeliveryStreamName' => $delivery->firehose_name
        ]);

        // echo '<pre>' , var_dump($result['response']) , '</pre>';

        if($result['error']) {
            return '<div class="alert alert-warning"><i class="fa fa-exclamation-triangle"></i> ' . $result['message'] . '</div>';
        }

        $data['aws'] = $result['response'];
        $data['db'] = $delivery;

        return view('firehose/view_modal', $data);
    }

}