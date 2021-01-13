<?php
namespace App\Models;

class KinesisDataStreamsModel extends BaseModel {
    protected $table = 'kinesis_data_streams';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'region', 'name', 'description', 'shards', 'create_date', 'last_update'];

}