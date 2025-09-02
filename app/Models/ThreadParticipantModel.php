<?php

namespace App\Models;

use CodeIgniter\Model;

class ThreadParticipantModel extends Model
{
    protected $table            = 'thread_participants';
    protected $primaryKey       = 'thread_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['thread_id', 'user_id'];
}
