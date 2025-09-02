<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddBioToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'bio');
    }
}
