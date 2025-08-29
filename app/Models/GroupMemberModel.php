<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupMemberModel extends Model
{
    protected $table            = 'group_members';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['group_id', 'user_id', 'role'];
}
