<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftarModel extends Model
{
    protected $table            = 'pendaftar_recruitment';
    protected $primaryKey       = 'id_pendaftar';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields = ['id_recruitment', 'id_user', 'nama_lengkap', 'nim', 'prodi', 'no_hp', 'email', 'alasan', 'status_pendaftaran', 'catatan_admin'];

    public function getByRecruitment($id_recruitment)
    {
        return $this->select('pendaftar_recruitment.*, users.username')
                    ->join('users', 'users.id = pendaftar_recruitment.id_user')
                    ->where('id_recruitment', $id_recruitment)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

  public function getByUser($id_user)
    {
    return $this->select('
                pendaftar_recruitment.*, 
                open_recruitment.judul, 
                open_recruitment.posisi, 
                open_recruitment.link_wa, 
                ormawa.nama_ormawa
            ')
            ->join('open_recruitment', 'open_recruitment.id_recruitment = pendaftar_recruitment.id_recruitment', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa', 'left')
            ->where('pendaftar_recruitment.id_user', $id_user)
            ->orderBy('pendaftar_recruitment.created_at', 'DESC')
            ->findAll();
    }

    public function sudahDaftar($id_recruitment, $id_user)
    {
        return $this->where('id_recruitment', $id_recruitment)
                    ->where('id_user', $id_user)
                    ->countAllResults() > 0;
    }
}