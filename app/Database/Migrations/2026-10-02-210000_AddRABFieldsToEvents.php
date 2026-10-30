<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRABFieldsToEvents extends Migration
{
    public function up()
    {
        if ($this->db->fieldExists('peserta_tipe', 'events')) {
            return;
        }
        $fields = [
            'peserta_tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'deskripsi',
            ],
            'peserta_jumlah' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'peserta_tipe',
            ],
            'durasi_hari' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'peserta_jumlah',
            ],
            'konsumsi_tipe' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'after'      => 'durasi_hari',
            ],
            'konsumsi_per_orang' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'null'       => true,
                'after'      => 'konsumsi_tipe',
            ],
            'biaya_lain' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'null'       => true,
                'after'      => 'konsumsi_per_orang',
            ],
            'total_biaya' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,2',
                'null'       => true,
                'after'      => 'biaya_lain',
            ],
            'rundown' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'total_biaya',
            ],
        ];

        $this->forge->addColumn('events', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('events', [
            'peserta_tipe',
            'peserta_jumlah',
            'durasi_hari',
            'konsumsi_tipe',
            'konsumsi_per_orang',
            'biaya_lain',
            'total_biaya',
            'rundown',
        ]);
    }
}