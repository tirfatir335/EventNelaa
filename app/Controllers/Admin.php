<?php

namespace App\Controllers;

use App\Models\GedungModel;
use App\Models\EventModel;

class Admin extends BaseController
{
    protected $gedungModel;
    protected $eventModel;

    public function __construct()
    {
        $this->gedungModel = new GedungModel();
        $this->eventModel  = new EventModel();
    }

    // ==========================================================
    // DASHBOARD
    // ==========================================================
    public function dashboard()
    {
        $db = \Config\Database::connect();

        $total_gedung = $db->table('gedung')->countAllResults();

        // Booking pending (butuh validasi gedung)
        $total_pending_gedung = $db->table('events')
            ->where('status', 'Pending Admin')
            ->countAllResults();

        // Booking yang sudah lolos validasi gedung
        $total_tervalidasi = $db->table('events')
            ->whereIn('status', ['Pending Validator', 'Published'])
            ->countAllResults();

        $today = date('Y-m-d');
    $booking_hari_ini = $db->table('events')
    ->where('tanggal', $today)
    ->where('status', 'Published')
    ->countAllResults();

    $booking_bulan_ini = $db->table('events')
    ->where('MONTH(tanggal)', date('n'))
    ->where('YEAR(tanggal)', date('Y'))
    ->where('status', 'Published')
    ->countAllResults();

        // Booking terbaru
    $booking_terbaru = $db->table('events')
    ->select('events.*, ormawa.nama_ormawa')
    ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
    ->where('events.status', 'Published')
    ->orderBy('events.tanggal', 'DESC')
    ->limit(5)
    ->get()->getResultArray();

        // Events untuk kalender — HANYA yang sudah PUBLISHED
    $events = $db->table('events')
    ->select('events.*, ormawa.nama_ormawa')
    ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
    ->where('events.status', 'Published')
    ->orderBy('events.tanggal', 'ASC')
    ->get()->getResultArray();

        $eventsByDate = [];
        foreach ($events as $e) {
            $tgl = $e['tanggal'];
            if (!isset($eventsByDate[$tgl])) $eventsByDate[$tgl] = [];
            $eventsByDate[$tgl][] = $e;
        }

        return view('admin/dashboard', [
            'title'                 => 'Dashboard Pengelola Gedung',
            'total_gedung'          => $total_gedung,
            'total_pending_gedung'  => $total_pending_gedung,
            'total_tervalidasi'     => $total_tervalidasi,
            'booking_hari_ini'      => $booking_hari_ini,
            'booking_bulan_ini'     => $booking_bulan_ini,
            'booking_terbaru'       => $booking_terbaru,
            'eventsByDate'          => $eventsByDate,
        ]);
    }

    // ==========================================================
    // VALIDASI GEDUNG (BARU)
    // ==========================================================
    public function validasiGedung()
    {
        $db = \Config\Database::connect();

        // Ambil semua event yang butuh validasi gedung
        $pending = $db->table('events')
            ->select('events.*, ormawa.nama_ormawa')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('events.status', 'Pending Admin')
            ->orderBy('events.created_at', 'ASC')
            ->get()->getResultArray();

        // Ambil yang sudah divalidasi (history)
        $selesai = $db->table('events')
            ->select('events.*, ormawa.nama_ormawa')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->whereIn('events.status', ['Pending Validator', 'Published', 'Rejected Admin', 'Rejected Validator'])
            ->orderBy('events.updated_at', 'DESC')
            ->limit(20)
            ->get()->getResultArray();

        return view('admin/validasi_gedung', [
            'title'    => 'Validasi Gedung',
            'pending'  => $pending,
            'selesai'  => $selesai,
        ]);
    }

    public function detailValidasi($id)
    {
        $db = \Config\Database::connect();

        $event = $db->table('events')
            ->select('events.*, ormawa.nama_ormawa')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('events.id_event', $id)
            ->get()->getRowArray();

        if (!$event) {
            return redirect()->to('admin/validasi')
                ->with('error', 'Event tidak ditemukan');
        }

        // Cek bentrok: event lain di gedung + tanggal + waktu sama
        $bentrok = $db->table('events')
            ->where('gedung', $event['gedung'])
            ->where('tanggal', $event['tanggal'])
            ->where('id_event !=', $id)
            ->whereIn('status', ['Published', 'Pending Admin', 'Pending Validator'])
            ->get()->getResultArray();

        return view('admin/validasi_detail', [
            'title'   => 'Detail Validasi Gedung',
            'event'   => $event,
            'bentrok' => $bentrok,
        ]);
    }

    public function prosesValidasi($id)
    {
        $valid   = $this->request->getPost('valid');
        $catatan = $this->request->getPost('catatan');

        if ($valid == '1') {
            // Setuju → lempar ke Validator
            $this->eventModel->update($id, [
                'status'      => 'Pending Validator',
                'validated_by'=> session()->get('user_id'),
                'updated_at'  => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('admin/validasi')
                ->with('success', 'Gedung tersedia, event diteruskan ke Validator');
        } else {
            // Tolak → status Rejected Admin
            $this->eventModel->update($id, [
                'status'             => 'Rejected Admin',
                'catatan_penolakan'  => $catatan,
                'validated_by'       => session()->get('user_id'),
                'updated_at'         => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('admin/validasi')
                ->with('success', 'Event ditolak');
        }
    }

    public function approveGedung($id)
    {
        $this->eventModel->update($id, [
            'status'       => 'Pending Validator',
            'validated_by' => session()->get('user_id'),
            'updated_at'   => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Event diteruskan ke Validator');
    }

    public function rejectGedung($id)
    {
        $catatan = $this->request->getPost('catatan') ?? 'Gedung tidak tersedia';

        $this->eventModel->update($id, [
            'status'            => 'Rejected Admin',
            'catatan_penolakan' => $catatan,
            'validated_by'      => session()->get('user_id'),
            'updated_at'        => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()->with('success', 'Event ditolak');
    }
}