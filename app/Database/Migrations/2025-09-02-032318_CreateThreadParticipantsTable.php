<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateThreadParticipantsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'thread_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('thread_id', 'threads', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('thread_participants');
    }

    public function down()
    {
        $this->forge->dropTable('thread_participants');
    }
}
