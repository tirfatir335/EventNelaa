<?php

namespace App\Models;

use CodeIgniter\Model;

class OrmawaModel extends Model
{
    protected $table            = 'ormawa';
    protected $primaryKey       = 'id_ormawa';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_ormawa', 'pembina', 'visi', 'misi', 'struktur_organisasi', 'logo', 'deskripsi', 'instagram', 'status', 'kategori'];

    // Method untuk halaman daftar UKM (hanya yang Aktif)
    public function getActive()
    {
        return $this->where('status', 'Aktif')->orderBy('nama_ormawa', 'ASC')->findAll();
    }

    // Method untuk halaman detail (join dengan user untuk ambil kontak)
    public function getDetail($id)
    {
        return $this->select('ormawa.*, users.email, users.no_telp')
                    ->join('users', 'users.id_ormawa = ormawa.id_ormawa', 'left')
                    ->where('ormawa.id_ormawa', $id)
                    ->first();
    }

    // Ambil ormawa berdasarkan kategori (HMJ/UKM)
    public function getByKategori($kategori = null)
    {
        $this->where('status', 'Aktif');
        if ($kategori && in_array($kategori, ['HMJ', 'UKM', 'Lainnya'])) {
            $this->where('kategori', $kategori);
        }
        return $this->orderBy('nama_ormawa', 'ASC')->findAll();
    }
}