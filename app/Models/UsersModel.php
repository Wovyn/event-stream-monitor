<?php
namespace App\Models;

class UsersModel extends BaseModel {
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['first_name', 'last_name', 'email', 'phone', 'company', 'password'];
    protected $useTimestamps = false;
}