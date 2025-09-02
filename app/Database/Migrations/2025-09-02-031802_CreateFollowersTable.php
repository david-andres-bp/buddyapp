<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFollowersTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'follower_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'followed_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('follower_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('followed_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('followers');
    }

    public function down()
    {
        $this->forge->dropTable('followers');
    }
}
