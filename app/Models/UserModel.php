<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';
    // Pastikan semua kolom ini ada di database
    protected $allowedFields = ['username', 'email', 'password', 'role'];
}