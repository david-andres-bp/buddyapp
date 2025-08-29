<?php

namespace App\Models;

use CodeIgniter\Model;

class UserMetaModel extends Model
{
    protected $table            = 'user_meta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['user_id', 'meta_key', 'meta_value'];
}
