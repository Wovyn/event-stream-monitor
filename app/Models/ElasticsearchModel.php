<?php
namespace App\Models;

class ElasticsearchModel extends BaseModel {
    protected $table = 'elasticsearch';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'region',
        'domain_name',
        'status', // [loading, active]
        'settings'
    ];

}