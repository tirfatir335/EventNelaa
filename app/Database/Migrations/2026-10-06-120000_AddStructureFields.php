<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStructureFields extends Migration
{
    public function up()
    {
        // === Kolom baru untuk pengurus ===
        if (!$this->db->fieldExists('id_departemen', 'pengurus')) {
            $this->forge->addColumn('pengurus', [
                'id_departemen' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'id_ormawa',
                ],
            ]);
        }

        if (!$this->db->fieldExists('level', 'pengurus')) {
            $this->forge->addColumn('pengurus', [
                'level' => [
                    'type'       => 'INT',
                    'constraint' => 2,
                    'null'       => true,
                    'after'      => 'jabatan',
                    'comment'    => '1=Ketum, 2=Waketum, 3=Sekum/Bendum, 4=Kadep, 5=Wakadep, 6=Staf',
                ],
            ]);
        }

        // === Kolom baru untuk departemen ===
        if (!$this->db->fieldExists('ikon', 'departemen')) {
            $this->forge->addColumn('departemen', [
                'ikon' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 50,
                    'null'       => true,
                    'after'      => 'nama_departemen',
                ],
            ]);
        }

        if (!$this->db->fieldExists('warna', 'departemen')) {
            $this->forge->addColumn('departemen', [
                'warna' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'null'       => true,
                    'after'      => 'ikon',
                ],
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('pengurus', ['id_departemen', 'level']);
        $this->forge->dropColumn('departemen', ['ikon', 'warna']);
    }
}