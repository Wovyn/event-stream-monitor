<?php
namespace App\Models;

class EventstreamSinksModel extends BaseModel {
    protected $table = 'eventstream_sinks';
    protected $primaryKey = 'id';

    protected $allowedFields = ['user_id', 'description', 'status', 'sink_type', 'sid'];

}