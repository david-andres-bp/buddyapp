<?php

namespace App\Models;

use CodeIgniter\Model;

class MessagesThreadModel extends Model
{
    protected $table            = 'messages_threads';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['subject'];
}
