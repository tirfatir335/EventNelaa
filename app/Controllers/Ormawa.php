<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\OrganisasiModel;

class Ormawa extends BaseController
{
    protected $eventModel;
    protected $ormawaModel;

    public function __construct()
    {
        $this->eventModel  = new EventModel();
        $this->ormawaModel = new OrganisasiModel();
    }

    // ==========================================================
    // DASHBOARD
    // ==========================================================
    public function dashboard()
    {
        $id_ormawa = session()->get('id_ormawa');

        if (!$id_ormawa) {
            return redirect()->to('login');
        }

        // DATA ORMAWA
        $ormawa = $this->ormawaModel->find($id_ormawa);

        // STATISTIK EVENT
        $total_pengajuan = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->countAllResults();

        $total_disetujui = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->where('status', 'Published')
            ->countAllResults();

        $total_ditolak = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->groupStart()
                ->where('status', 'Rejected Admin')
                ->orWhere('status', 'Rejected Validator')
            ->groupEnd()
            ->countAllResults();

        $total_pending = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->groupStart()
                ->where('status', 'Pending Admin')
                ->orWhere('status', 'Pending Validator')
            ->groupEnd()
            ->countAllResults();

        // NOTIF REPORT BELUM DIISI
        $reportModel = new \App\Models\ReportModel();
        $belumReport = $reportModel->getEventBelumReport($id_ormawa);

        // CHART EVENT PER BULAN
        $db   = \Config\Database::connect();
        $year = date('Y');

        $chartEvent = $db->query("
            SELECT MONTH(tanggal) as bulan, COUNT(*) as total
            FROM events
            WHERE id_ormawa = ? AND YEAR(tanggal) = ? AND status = 'Published'
            GROUP BY MONTH(tanggal)
            ORDER BY bulan ASC
        ", [$id_ormawa, $year])->getResultArray();

        $chartData = array_fill(1, 12, 0);
        foreach ($chartEvent as $row) {
            $chartData[(int) $row['bulan']] = (int) $row['total'];
        }

        // RECENT EVENTS (untuk activity feed)
        $recentEvents = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->findAll();

        // DATA DISETUJUI (tabel bawah)
        $data_disetujui = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->where('status', 'Published')
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->findAll();

        // DATA DITOLAK
        $data_ditolak = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->groupStart()
                ->where('status', 'Rejected Admin')
                ->orWhere('status', 'Rejected Validator')
            ->groupEnd()
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->findAll();

        // STATISTIK TAMBAHAN + PROGRESS
        // Progja: progress = (approved / total) × 100
        $totalProgja    = $db->table('progja')->where('id_ormawa', $id_ormawa)->countAllResults();
        $progjaApproved = $db->table('progja')->where('id_ormawa', $id_ormawa)->where('status', 'approved')->countAllResults();
        $progressProgja = $totalProgja > 0 ? round(($progjaApproved / $totalProgja) * 100) : 0;

        // Pengurus: progress = (jumlah / 6) × 100 (6 = ideal struktur inti)
        $totalPengurus    = $db->table('pengurus')->where('id_ormawa', $id_ormawa)->countAllResults();
        $progressPengurus = min(round(($totalPengurus / 6) * 100), 100);

        // Galeri: progress = (jumlah / 20) × 100 (target minimal 20 foto)
        $totalGaleri    = $db->table('galeri_ormawa')->where('id_ormawa', $id_ormawa)->countAllResults();
        $progressGaleri = min(round(($totalGaleri / 20) * 100), 100);

        // Recruitment: progress = (aktif / total) × 100
        $totalRecruitment    = $db->table('open_recruitment')->where('id_ormawa', $id_ormawa)->countAllResults();
        $recruitmentAktif    = $db->table('open_recruitment')->where('id_ormawa', $id_ormawa)->where('status', 'open')->countAllResults();
        $progressRecruitment = $totalRecruitment > 0 ? round(($recruitmentAktif / $totalRecruitment) * 100) : 0;

        // RETURN VIEW
        return view('ormawa/dashboard', [
            'title'                => 'Dashboard',
            'subtitle'             => 'Selamat datang kembali',
            'ormawa'               => $ormawa,
            'total_pengajuan'      => $total_pengajuan,
            'total_disetujui'      => $total_disetujui,
            'total_ditolak'        => $total_ditolak,
            'total_pending'        => $total_pending,
            'belum_report'         => $belumReport,
            'chartData'            => array_values($chartData),
            'chartYear'            => $year,
            'recent_events'        => $recentEvents,
            'data_disetujui'       => $data_disetujui,
            'data_ditolak'         => $data_ditolak,
            'total_progja'         => $totalProgja,
            'progress_progja'      => $progressProgja,
            'total_pengurus'       => $totalPengurus,
            'progress_pengurus'    => $progressPengurus,
            'total_galeri'         => $totalGaleri,
            'progress_galeri'      => $progressGaleri,
            'total_recruitment'    => $totalRecruitment,
            'progress_recruitment' => $progressRecruitment,
        ]);
    }

    // ==================== KELOLA ULASAN EVENT ORMAWA ====================
    public function ulasan()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $db = \Config\Database::connect();

        $filter  = $this->request->getGet('filter') ?? 'semua';
        $search  = $this->request->getGet('search') ?? '';

        $events = $db->query("
            SELECT 
                e.id_event,
                e.nama_event,
                e.tanggal,
                e.poster,
                e.rating_avg,
                e.jumlah_ulasan,
                COUNT(u.id_ulasan) as total_ulasan_real,
                COALESCE(AVG(u.rating), 0) as avg_rating_real
            FROM events e
            LEFT JOIN ulasan_event u ON u.id_event = e.id_event
            WHERE e.id_ormawa = ? AND e.status = 'Published'
            GROUP BY e.id_event
            ORDER BY e.tanggal DESC
        ", [$id_ormawa])->getResultArray();

        $ulasanGrouped = [];
        $totalSemuaUlasan = 0;

        foreach ($events as $ev) {
            $builder = $db->table('ulasan_event')
                ->select('ulasan_event.*, users.username, users.foto as user_foto')
                ->join('users', 'users.id = ulasan_event.id_user', 'left')
                ->where('ulasan_event.id_event', $ev['id_event']);

            if ($filter === 'bintang5') {
                $builder->where('ulasan_event.rating', 5);
            } elseif ($filter === 'bintang_rendah') {
                $builder->where('ulasan_event.rating <=', 2);
            } elseif ($filter === 'ada_komentar') {
                $builder->where('ulasan_event.komentar !=', '');
                $builder->where('ulasan_event.komentar IS NOT NULL');
            }

            if (!empty($search)) {
                $builder->groupStart()
                            ->like('ulasan_event.komentar', $search)
                            ->orLike('users.username', $search)
                        ->groupEnd();
            }

            $list = $builder->orderBy('ulasan_event.created_at', 'DESC')->get()->getResultArray();

            if (!empty($list)) {
                $ulasanGrouped[] = [
                    'event'   => $ev,
                    'ulasan'  => $list,
                ];
                $totalSemuaUlasan += count($list);
            }
        }

        $statTotal = $db->query("
            SELECT COUNT(u.id_ulasan) as total,
                   COALESCE(AVG(u.rating), 0) as avg_rating,
                   SUM(CASE WHEN u.rating = 5 THEN 1 ELSE 0 END) as total_bintang5,
                   SUM(CASE WHEN u.rating <= 2 THEN 1 ELSE 0 END) as total_rendah
            FROM ulasan_event u
            JOIN events e ON e.id_event = u.id_event
            WHERE e.id_ormawa = ?
        ", [$id_ormawa])->getRowArray();

        return view('ormawa/ulasan', [
            'title'               => 'Ulasan Event',
            'ulasanGrouped'       => $ulasanGrouped,
            'total_event_ulasan'  => count($ulasanGrouped),
            'total_ulasan'        => $statTotal['total'] ?? 0,
            'rating_avg'          => round($statTotal['avg_rating'] ?? 0, 2),
            'total_bintang5'      => $statTotal['total_bintang5'] ?? 0,
            'total_rating_rendah' => $statTotal['total_rendah'] ?? 0,
            'filter_aktif'        => $filter,
            'search'              => $search,
        ]);
    }

    // ==================== HAPUS ULASAN (ORMAWA) ====================
    public function hapusUlasan($id_ulasan)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $ulasanModel = new \App\Models\UlasanModel();
        $eventModel  = new \App\Models\EventModel();

        $ulasan = $ulasanModel->find($id_ulasan);
        if (!$ulasan) {
            return redirect()->back()->with('error', 'Ulasan tidak ditemukan.');
        }

        $event = $eventModel->where('id_event', $ulasan['id_event'])
                            ->where('id_ormawa', $id_ormawa)
                            ->first();
        if (!$event) {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus ulasan ini.');
        }

        $id_event = $ulasan['id_event'];

        $ulasanModel->delete($id_ulasan);

        $avg   = $ulasanModel->getRatingAvg($id_event);
        $count = $ulasanModel->getCount($id_event);
        $eventModel->update($id_event, [
            'rating_avg'    => $avg,
            'jumlah_ulasan' => $count
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}