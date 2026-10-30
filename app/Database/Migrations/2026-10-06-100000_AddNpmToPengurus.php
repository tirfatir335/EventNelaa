<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNimToPengurus extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pengurus', [
            'npm' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'nama',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pengurus', 'npm');
    }
}