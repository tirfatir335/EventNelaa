<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateReportTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_report' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_event' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_ormawa' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            // === 3 KONTEN LPJ ===
            'laporan_file' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'comment'    => 'Nama file laporan (upload)',
            ],
            'keuangan_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'comment'    => 'Link Google Drive SPJ/keuangan',
            ],
            'bukti_link' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
                'null'       => true,
                'comment'    => 'Link Google Drive foto dokumentasi',
            ],

            // === VERIFIKASI 3 ORANG ===
            'status_ketua'   => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'status_pembina' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'status_wadir'   => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],

            'catatan_ketua'   => ['type' => 'TEXT', 'null' => true],
            'catatan_pembina' => ['type' => 'TEXT', 'null' => true],
            'catatan_wadir'   => ['type' => 'TEXT', 'null' => true],

            'verified_ketua_at'   => ['type' => 'DATETIME', 'null' => true],
            'verified_pembina_at' => ['type' => 'DATETIME', 'null' => true],
            'verified_wadir_at'   => ['type' => 'DATETIME', 'null' => true],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id_report', true);
        $this->forge->addKey('id_event');
        $this->forge->addKey('id_ormawa');
        $this->forge->createTable('report');
    }

    public function down()
    {
        $this->forge->dropTable('report');
    }
}