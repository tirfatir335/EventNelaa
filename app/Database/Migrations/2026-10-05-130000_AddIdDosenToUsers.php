<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdDosenToUsers extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('id_dosen', 'users')) {
            return;
        }
        $this->forge->addColumn('users', [
            'id_dosen' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id_ormawa',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'id_dosen');
    }
}