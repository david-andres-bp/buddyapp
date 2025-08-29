<?php

namespace App\Models;

use CodeIgniter\Model;

class MessagesRecipientModel extends Model
{
    protected $table            = 'messages_recipients';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $allowedFields    = ['thread_id', 'user_id', 'is_read'];
}
