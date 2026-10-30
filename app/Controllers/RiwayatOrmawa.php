<?php
namespace App\Controllers;

use App\Models\EventModel;

class RiwayatOrmawa extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();
        $ormawa_id = session()->get('id_ormawa');

        // Mengambil data kegiatan berdasarkan status
        $data = [
            'title' => 'Riwayat Kegiatan',
            'total_pengajuan' => $eventModel->where('id_ormawa', $ormawa_id)->findAll(), // Semua kegiatan
            'disetujui' => $eventModel->where('id_ormawa', $ormawa_id)->where('status', 'Approved')->findAll(), // Disetujui
            'ditolak' => $eventModel->where('id_ormawa', $ormawa_id)->where('status', 'Rejected')->findAll() // Ditolak
        ];

        return view('ormawa/riwayat', $data); // Pastikan view ini di-link ke file riwayat.php
    }
}
