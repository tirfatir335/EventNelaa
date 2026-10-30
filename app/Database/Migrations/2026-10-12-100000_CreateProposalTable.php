<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProposalTable extends Migration
{
    public function up()
    {
        // ============================================
        // 1. TAMBAH KOLOM DI TABEL PROGJA
        // ============================================
        if (!$this->db->fieldExists('bulan', 'progja')) {
            $this->forge->addColumn('progja', [
                'bulan' => [
                    'type'       => 'TINYINT',
                    'constraint' => 2,
                    'null'       => true,
                    'after'      => 'semester',
                    'comment'    => '1-12 (Jan-Des)',
                ],
                'status' => [
                    'type'       => 'ENUM',
                    'constraint' => ['draft', 'pending', 'approved', 'rejected'],
                    'default'    => 'draft',
                    'after'      => 'foto',
                ],
                'catatan_validator' => [
                    'type'  => 'TEXT',
                    'null'  => true,
                    'after' => 'status',
                ],
                'validated_by' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                    'null'       => true,
                    'after'      => 'catatan_validator',
                ],
                'validated_at' => [
                    'type'  => 'DATETIME',
                    'null'  => true,
                    'after' => 'validated_by',
                ],
            ]);
        }

        // ============================================
        // 2. TABEL PROPOSAL
        // ============================================
        if (!$this->db->tableExists('proposal')) {
            $this->forge->addField([
                'id_proposal' => [
                    'type'           => 'INT',
                    'constraint'     => 11,
                    'unsigned'       => true,
                    'auto_increment' => true,
                ],
                'id_progja' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],
                'id_ormawa' => [
                    'type'       => 'INT',
                    'constraint' => 11,
                    'unsigned'   => true,
                ],

                // === KONTEN PROPOSAL ===
                'file_proposal' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 255,
                    'null'       => true,
                    'comment'    => 'File proposal (PDF/DOC)',
                ],
                'deskripsi_kegiatan' => [
                    'type'  => 'TEXT',
                    'null'  => true,
                ],
                'rundown' => [
                    'type'  => 'TEXT',
                    'null'  => true,
                    'comment' => 'JSON array rundown',
                ],
                'anggaran' => [
                    'type'       => 'DECIMAL',
                    'constraint' => '12,2',
                    'null'       => true,
                ],
                'catatan' => [
                    'type'  => 'TEXT',
                    'null'  => true,
                ],

                // === VERIFIKASI 3 PIHAK ===
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

            $this->forge->addKey('id_proposal', true);
            $this->forge->addKey('id_progja');
            $this->forge->addKey('id_ormawa');
            $this->forge->createTable('proposal');
        }
    }

    public function down()
    {
        $this->forge->dropTable('proposal', true);

        if ($this->db->fieldExists('bulan', 'progja')) {
            $this->forge->dropColumn('progja', [
                'bulan', 'status', 'catatan_validator', 'validated_by', 'validated_at'
            ]);
        }
    }
}