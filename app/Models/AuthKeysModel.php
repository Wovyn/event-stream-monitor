<?php
namespace App\Models;

class AuthKeysModel extends BaseModel {
    protected $table = 'auth_keys';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'twilio_sid',
        'twilio_secret',
        'aws_access',
        'aws_secret',
        'event_stream_role_arn',
        's3_firehose_role_arn',
        'external_id',
        'aws_account'
    ];

}