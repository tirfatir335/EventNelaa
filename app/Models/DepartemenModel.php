<?php

namespace App\Models;

use CodeIgniter\Model;

class DepartemenModel extends Model
{
    protected $table            = 'departemen';
    protected $primaryKey       = 'id_departemen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_ormawa', 'nama_departemen', 'ikon', 'warna', 'jenis', 'koordinator', 'deskripsi'];

    public function getByOrmawa($id_ormawa)
    {
        return $this->where('id_ormawa', $id_ormawa)
            ->orderBy('nama_departemen', 'ASC')
            ->findAll();
    }
}