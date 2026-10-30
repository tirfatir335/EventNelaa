<?php

namespace App\Models;

use CodeIgniter\Model;

class PengurusModel extends Model
{
    protected $table            = 'pengurus';
    protected $primaryKey       = 'id_pengurus';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_ormawa', 'id_departemen', 'nama', 'npm', 'jabatan', 'level', 'foto', 'periode'];

    public function getByOrmawa($id_ormawa)
    {
        return $this->where('id_ormawa', $id_ormawa)
            ->orderBy('level', 'ASC')
            ->orderBy('jabatan', 'ASC')
            ->findAll();
    }

    // Untuk halaman publik — group by departemen
    public function getStrukturByOrmawa($id_ormawa)
    {
        return $this->select('pengurus.*, departemen.nama_departemen, departemen.ikon, departemen.warna')
            ->join('departemen', 'departemen.id_departemen = pengurus.id_departemen', 'left')
            ->where('pengurus.id_ormawa', $id_ormawa)
            ->orderBy('pengurus.level', 'ASC')
            ->orderBy('pengurus.jabatan', 'ASC')
            ->findAll();
    }
}