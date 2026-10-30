<?php
namespace App\Controllers;

use App\Models\EventModel;
use App\Models\VisitorModel;
use App\Models\OrmawaModel;
use App\Models\BeritaModel;

class Home extends BaseController
{
    public function index()
    {
        // ======================
        // SIMPAN DATA VISITOR
        // ======================
        $visitorModel = new VisitorModel();
        $visitorModel->insert([
            'ip_address' => $this->request->getIPAddress(),
            'user_agent' => $this->request->getUserAgent()->getAgentString(),
            'visited_at' => date('Y-m-d H:i:s')
        ]);

        $db = \Config\Database::connect();

        // ======================
        // STATISTIK GLOBAL
        // ======================
        $total_ukm         = $db->table('ormawa')->where('status', 'Aktif')->countAllResults();
        $total_event       = $db->table('events')->where('status', 'Published')->countAllResults();
        $total_recruitment = $db->table('open_recruitment')->where('status', 'open')->countAllResults();
        $total_berita      = $db->table('berita')->where('status', 'published')->countAllResults();
        $total_ulasan      = $db->table('ulasan_event')->countAllResults();

        // ======================
        // UKM TERPOPULER
        // ======================
        $ukm_populer = $db->query("
            SELECT o.id_ormawa, o.nama_ormawa, o.logo, o.kategori, o.pembina,
                   COUNT(DISTINCT e.id_event) as total_event,
                   COALESCE(AVG(e.rating_avg), 0) as rata_rating
            FROM ormawa o
            LEFT JOIN events e ON e.id_ormawa = o.id_ormawa AND e.status = 'Published'
            WHERE o.status = 'Aktif'
            GROUP BY o.id_ormawa
            ORDER BY total_event DESC, o.nama_ormawa ASC
            LIMIT 4
        ")->getResultArray();

        // ======================
        // EVENT TERBARU
        // ======================
        $eventModel = new EventModel();
        $events_terbaru = $eventModel
            ->select('events.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('events.status', 'Published')
            ->orderBy('events.tanggal', 'DESC')
            ->limit(6)
            ->findAll();
        // ======================
        // DATA JADWAL (untuk kalender & list)
        // ======================
        $allEvents = $eventModel
            ->select('events.*, ormawa.nama_ormawa')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('events.status', 'Published')
            ->orderBy('events.tanggal', 'ASC')
            ->findAll();

        $eventsByDate = [];
        foreach ($allEvents as $e) {
            $tgl = $e['tanggal'];
            if (!isset($eventsByDate[$tgl])) {
                $eventsByDate[$tgl] = [];
            }
            $eventsByDate[$tgl][] = $e;
        }
        // ======================
        // RECRUITMENT AKTIF
        // ======================
        $recruitments = $db->table('open_recruitment')
            ->select('open_recruitment.*, ormawa.nama_ormawa, ormawa.logo')
            ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa')
            ->where('open_recruitment.status', 'open')
            ->orderBy('open_recruitment.created_at', 'DESC')
            ->limit(3)
            ->get()->getResultArray();

        // ======================
        // BERITA TERBARU
        // ======================
        $berita_terbaru = $db->table('berita')
            ->select('berita.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo')
            ->join('ormawa', 'ormawa.id_ormawa = berita.id_ormawa')
            ->where('berita.status', 'published')
            ->orderBy('berita.created_at', 'DESC')
            ->limit(3)
            ->get()->getResultArray();

        // ======================
        // GRAFIK VISITOR PER BULAN
        // ======================
        $year = date('Y');
        $query = $db->query("
            SELECT MONTH(visited_at) AS bulan, COUNT(*) AS total
            FROM visitor_logs
            WHERE YEAR(visited_at) = ?
            GROUP BY MONTH(visited_at)
        ", [$year]);

        $chartData = array_fill(1, 12, 0);
        foreach ($query->getResultArray() as $row) {
            $chartData[(int)$row['bulan']] = (int)$row['total'];
        }

        // ======================
        // STATISTIK VISITOR
        // ======================
        $totalVisitor = $db->table('visitor_logs')->countAllResults();
        $today = $db->table('visitor_logs')
            ->where('DATE(visited_at)', date('Y-m-d'))
            ->countAllResults();

        // ======================
        // RETURN VIEW
        // ======================
        return view('index', [
            'title'             => 'EventNela - Pusat Informasi UKM & Ormawa Polinela',
            'total_ukm'         => $total_ukm,
            'total_event'       => $total_event,
            'total_recruitment' => $total_recruitment,
            'total_berita'      => $total_berita,
            'total_ulasan'      => $total_ulasan,
            'ukm_populer'       => $ukm_populer,
            'events'            => $events_terbaru,
            'eventsByDate'      => $eventsByDate,
            'recruitments'      => $recruitments,
            'berita_terbaru'    => $berita_terbaru,
            'chartData'         => array_values($chartData),
            'totalVisitor'      => $totalVisitor,
            'today'             => $today,
            'current_page'      => 'home'
        ]);
    }

        public function panduan()
    {
        return view('panduan', ['title' => 'Panduan EventNela']);
    }

    public function panduanPdf()
    {
        return view('panduan_pdf', ['title' => 'Panduan EventNela — Versi Cetak']);
    }

    public function tentang()
    {
        return view('tentang');
    }
}