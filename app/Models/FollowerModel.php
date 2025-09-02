<?php

namespace App\Models;

use CodeIgniter\Model;

class FollowerModel extends Model
{
    protected $table            = 'followers';
    protected $primaryKey       = ['follower_id', 'followed_id'];
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['follower_id', 'followed_id'];
}
