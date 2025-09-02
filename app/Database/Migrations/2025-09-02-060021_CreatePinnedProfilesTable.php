<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePinnedProfilesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'pinned_user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('pinned_user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('pinned_profiles');
    }

    public function down()
    {
        $this->forge->dropTable('pinned_profiles');
    }
}
