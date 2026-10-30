<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id_berita';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['id_ormawa', 'id_user', 'judul', 'konten', 'foto', 'status'];

    // Berita berdasarkan ormawa (untuk dashboard)
    public function getByOrmawa($id_ormawa)
    {
        return $this->where('id_ormawa', $id_ormawa)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Berita yang sudah published (untuk publik)
    public function getPublished($id_ormawa = null, $limit = null)
    {
        $builder = $this->select('berita.*, ormawa.nama_ormawa, ormawa.logo, users.username')
                        ->join('ormawa', 'ormawa.id_ormawa = berita.id_ormawa')
                        ->join('users', 'users.id = berita.id_user')
                        ->where('berita.status', 'published');
        
        if ($id_ormawa) {
            $builder->where('berita.id_ormawa', $id_ormawa);
        }
        
        $builder->orderBy('berita.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    // Detail berita
    public function getDetail($id)
    {
        return $this->select('berita.*, ormawa.nama_ormawa, ormawa.logo, ormawa.instagram, users.username, users.foto as user_foto')
                    ->join('ormawa', 'ormawa.id_ormawa = berita.id_ormawa')
                    ->join('users', 'users.id = berita.id_user')
                    ->where('id_berita', $id)
                    ->first();
    }
}