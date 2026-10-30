<?php

namespace App\Models;

use CodeIgniter\Model;

class GaleriOrmawaModel extends Model
{
    protected $table            = 'galeri_ormawa';
    protected $primaryKey       = 'id_galeri';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_ormawa', 'judul_foto', 'deskripsi', 'foto'];

    public function getByOrmawa($id_ormawa)
    {
        return $this->where('id_ormawa', $id_ormawa)->orderBy('created_at', 'DESC')->findAll();
    }
}