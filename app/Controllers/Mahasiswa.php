<?php

namespace App\Controllers;

use App\Models\PendaftarModel;
use App\Models\UlasanModel;
use App\Models\EventModel;

class Mahasiswa extends BaseController
{
    protected $pendaftarModel;
    protected $ulasanModel;
    protected $eventModel;

    public function __construct()
    {
        $this->pendaftarModel = new PendaftarModel();
        $this->ulasanModel    = new UlasanModel();
        $this->eventModel     = new EventModel();
    }

    public function dashboard()
    {
        // Cek login
        if (!session()->get('logged_in') || session()->get('role') !== 'mahasiswa') {
            return redirect()->to('login');
        }

        $id_user = session()->get('user_id');
        $db = \Config\Database::connect();

        // ======================
        // STATISTIK MAHASISWA
        // ======================

        // Total pendaftaran recruitment
        $totalPendaftaran = $db->table('pendaftar_recruitment')
            ->where('id_user', $id_user)
            ->countAllResults();

        // Pendaftaran yang sudah diterima
        $totalDiterima = $db->table('pendaftar_recruitment')
            ->where('id_user', $id_user)
            ->where('status_pendaftaran', 'diterima')
            ->countAllResults();

        // Total ulasan yang pernah dibuat
        $totalUlasan = $db->table('ulasan_event')
            ->where('id_user', $id_user)
            ->countAllResults();

        // Rata-rata rating yang diberikan
        $avgRatingRow = $db->table('ulasan_event')
            ->selectAvg('rating', 'rata')
            ->where('id_user', $id_user)
            ->get()->getRow();
        $avgRating = round($avgRatingRow->rata ?? 0, 1);

        // ======================
        // DATA UNTUK SECTION
        // ======================

        // 5 Pendaftaran terbaru
        $pendaftaranTerbaru = $db->table('pendaftar_recruitment')
            ->select('pendaftar_recruitment.*, open_recruitment.judul, 
                      open_recruitment.posisi, open_recruitment.periode, 
                      ormawa.nama_ormawa, ormawa.logo')
            ->join('open_recruitment', 'open_recruitment.id_recruitment = pendaftar_recruitment.id_recruitment')
            ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa')
            ->where('pendaftar_recruitment.id_user', $id_user)
            ->orderBy('pendaftar_recruitment.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // 5 Ulasan terbaru
        $ulasanTerbaru = $db->table('ulasan_event')
            ->select('ulasan_event.*, events.nama_event, events.poster, 
                      ormawa.nama_ormawa')
            ->join('events', 'events.id_event = ulasan_event.id_event')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('ulasan_event.id_user', $id_user)
            ->orderBy('ulasan_event.created_at', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // 5 Event terbaru yang bisa diulas
        $eventBisaDiulas = $db->table('events')
            ->select('events.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('events.status', 'Published')
            ->where('events.tanggal <=', date('Y-m-d')) // yang sudah lewat
            ->orderBy('events.tanggal', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // Cek mana yang sudah diulas
        $sudahDiulas = [];
        if (!empty($eventBisaDiulas)) {
            $ids = array_column($eventBisaDiulas, 'id_event');
            $diulas = $db->table('ulasan_event')
                ->select('id_event')
                ->where('id_user', $id_user)
                ->whereIn('id_event', $ids)
                ->get()->getResultArray();
            $sudahDiulas = array_column($diulas, 'id_event');
        }

        // 3 Recruitment aktif
        $recruitmentAktif = $db->table('open_recruitment')
            ->select('open_recruitment.*, ormawa.nama_ormawa, ormawa.logo')
            ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa')
            ->where('open_recruitment.status', 'open')
            ->orderBy('open_recruitment.created_at', 'DESC')
            ->limit(3)
            ->get()->getResultArray();

        return view('mahasiswa/dashboard', [
            'title'               => 'Dashboard Mahasiswa',
            'total_pendaftaran'   => $totalPendaftaran,
            'total_diterima'      => $totalDiterima,
            'total_ulasan'        => $totalUlasan,
            'avg_rating'          => $avgRating,
            'pendaftaran_terbaru' => $pendaftaranTerbaru,
            'ulasan_terbaru'      => $ulasanTerbaru,
            'event_bisa_diulas'   => $eventBisaDiulas,
            'sudah_diulas'        => $sudahDiulas,
            'recruitment_aktif'   => $recruitmentAktif,
            'current_page'        => 'mahasiswa-dashboard',
        ]);
    }
}