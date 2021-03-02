<?php
namespace App\Models;

class SinkSubscriptionsModel extends BaseModel {
    protected $table = 'sink_subscriptions';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sink_id',
        'subscription_sid',
        'subscriptions'
    ];

}