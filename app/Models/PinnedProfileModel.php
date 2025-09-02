<?php

namespace App\Models;

use CodeIgniter\Model;

class PinnedProfileModel extends Model
{
    protected $table            = 'pinned_profiles';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'pinned_user_id'];
}
