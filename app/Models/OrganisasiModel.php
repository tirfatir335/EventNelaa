<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganisasiModel extends Model
{
    protected $table = 'ormawa';
    protected $primaryKey = 'id_ormawa';

    protected $allowedFields = [
    'nama_ormawa', 
    'pembina', 
    'visi', 
    'misi', 
    'deskripsi', 
    'instagram', 
    'logo', 
    'status', 
    'kategori'
];

    public function getAllOrganisasi()
    {
        return $this->select('ormawa.*, users.username, users.email, users.no_telp,
        (SELECT COUNT(*) FROM events WHERE events.id_ormawa = ormawa.id_ormawa) AS jumlah_event')
        ->join('users', 'users.id_ormawa = ormawa.id_ormawa', 'left')
        ->findAll();
    }

    public function getById($id)
    {
        return $this->select('ormawa.*, users.username, users.email, users.no_telp')
            ->join('users', 'users.id_ormawa = ormawa.id_ormawa', 'left')
            ->where('ormawa.id_ormawa', $id)
            ->first();
    }
}
