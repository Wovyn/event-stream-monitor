<?php
namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model {
    // public $order, $sort, $offset, $limit, $search, $where;

    protected $returnType = 'object';

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = 'last_update';
    protected $deletedField  = '';
}
?>