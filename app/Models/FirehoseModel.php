<?php
namespace App\Models;

class FirehoseModel extends BaseModel {
    protected $table = 'firehose';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'region',
        'name',
        'description',
        'kinesis_id',
        'elasticsearch_id',
        's3_bucket'
    ];

}