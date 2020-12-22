<?php
namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model {
    public $order, $sort, $offset, $limit, $search, $where;

}
?>