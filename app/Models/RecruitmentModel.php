<?php

namespace App\Models;

use CodeIgniter\Model;

class RecruitmentModel extends Model
{
    protected $table            = 'open_recruitment';
    protected $primaryKey       = 'id_recruitment';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields = ['id_ormawa', 'judul', 'deskripsi', 'posisi', 'periode', 'link_pendaftaran', 'link_wa', 'status', 'pakai_tes_tertulis', 'pakai_wawancara'];

    public function getByOrmawa($id_ormawa)
    {
        return $this->where('id_ormawa', $id_ormawa)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getActive()
    {
    return $this->select('open_recruitment.*, ormawa.nama_ormawa, ormawa.logo')
                ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa')
                ->where('open_recruitment.status', 'open')
                ->orderBy('open_recruitment.created_at', 'DESC')
                ->findAll();
    }

    public function getDetail($id)
    {
    return $this->select('open_recruitment.*, ormawa.nama_ormawa, ormawa.logo, ormawa.pembina')
                ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa')
                ->where('open_recruitment.id_recruitment', $id)
                ->first();
    }

    // Ambil pendaftar yang LOLOS per tahap (untuk pengumuman publik)
public function getLolosByTahap($id_recruitment, $tahap = 'tes_tertulis')
{
    // Tahap valid: 'tes_tertulis', 'wawancara', 'diterima'
    if (!in_array($tahap, ['tes_tertulis', 'wawancara', 'diterima'])) {
        return [];
    }

    $pendaftarModel = new \App\Models\PendaftarModel();
    
    // Ambil semua pendaftar yang statusnya sudah melewati/atau di tahap ini
    return $pendaftarModel
        ->where('id_recruitment', $id_recruitment)
        ->whereIn('status_pendaftaran', $this->getStatusSetelahTahap($tahap))
        ->orderBy('nama_lengkap', 'ASC')
        ->findAll();
}

// Helper: status-status yang sudah lolos tahap tertentu
private function getStatusSetelahTahap($tahap)
{
    $map = [
        'tes_tertulis' => ['tes_tertulis', 'wawancara', 'diterima'],
        'wawancara'    => ['wawancara', 'diterima'],
        'diterima'     => ['diterima'],
    ];
    return $map[$tahap] ?? [];
}
}