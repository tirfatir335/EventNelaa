<?php
namespace App\Controllers;

use App\Models\EventModel;
use App\Models\UlasanModel;

class EventController extends BaseController
{


// ===== HALAMAN DAFTAR EVENT =====
public function index()
{
    $eventModel = new EventModel();
    $db = \Config\Database::connect();

    // Filter kategori
    $filter = $this->request->getGet('filter') ?? 'semua';
    $search = $this->request->getGet('search') ?? '';

    // Query dasar
    $builder = $eventModel
        ->select('events.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo, ormawa.kategori as ormawa_kategori')
        ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
        ->where('events.status', 'Published');

    // Filter tanggal
    if ($filter === 'akan_datang') {
        $builder->where('events.tanggal >=', date('Y-m-d'));
    } elseif ($filter === 'selesai') {
        $builder->where('events.tanggal <', date('Y-m-d'));
    }

    // Search
    if (!empty($search)) {
        $builder->groupStart()
                ->like('events.nama_event', $search)
                ->orLike('ormawa.nama_ormawa', $search)
                ->orLike('events.gedung', $search)
                ->groupEnd();
    }

    $events = $builder->orderBy('events.tanggal', 'DESC')->findAll();

    // Statistik
    $totalEvent      = count($events);
    $eventAkanDatang = $db->table('events')->where('status', 'Published')->where('tanggal >=', date('Y-m-d'))->countAllResults();
    $eventSelesai    = $db->table('events')->where('status', 'Published')->where('tanggal <', date('Y-m-d'))->countAllResults();

    return view('events/list', [
        'title'            => 'Event Kegiatan - EventNela',
        'events'           => $events,
        'filter_aktif'     => $filter,
        'search'           => $search,
        'total_event'      => $totalEvent,
        'event_akan_datang' => $eventAkanDatang,
        'event_selesai'    => $eventSelesai,
        'current_page'     => 'event'
    ]);
}
    // ===== DETAIL EVENT + ULASAN =====
    public function detail($id)
{
    $eventModel = new EventModel();
    $ulasanModel = new UlasanModel();

    $event = $eventModel
        ->select('events.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo, ormawa.kategori')
        ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
        ->where('events.id_event', $id)
        ->first();

    if (!$event) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Event tidak ditemukan.");
    }

    $ulasan = $ulasanModel->getByEvent($id);
    $rating_avg = $ulasanModel->getRatingAvg($id);
    $jumlah_ulasan = $ulasanModel->getCount($id);

    $sudah_ulas = false;
    if (session()->get('logged_in')) {
        $sudah_ulas = $ulasanModel->sudahUlas($id, session()->get('user_id'));
    }

    return view('events/detail_event', [
        'event'         => $event,
        'ulasan'        => $ulasan,
        'rating_avg'    => $rating_avg,
        'jumlah_ulasan' => $jumlah_ulasan,
        'sudah_ulas'    => $sudah_ulas,
        'current_page'  => 'event'
    ]);
}

    // ===== SIMPAN ULASAN =====
    public function simpanUlasan()
{
    if (!session()->get('logged_in')) {
        return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
    }

    $id_event = $this->request->getPost('id_event');
    $rating = $this->request->getPost('rating');
    $komentar = $this->request->getPost('komentar');
    $id_user = session()->get('user_id');

    // Validasi
    if (empty($id_event) || empty($rating)) {
        return redirect()->back()->with('error', 'Data tidak lengkap.');
    }

    if ($rating < 1 || $rating > 5) {
        return redirect()->back()->with('error', 'Rating harus 1-5.');
    }

    $ulasanModel = new UlasanModel();

    // Cek apakah user sudah pernah ulas
    if ($ulasanModel->sudahUlas($id_event, $id_user)) {
        return redirect()->back()->with('error', 'Anda sudah memberi ulasan untuk event ini.');
    }

    // Simpan ulasan
    $ulasanModel->insert([
        'id_event' => $id_event,
        'id_user'  => $id_user,
        'rating'   => $rating,
        'komentar' => $komentar ?? ''
    ]);

    // Update rating rata-rata di tabel events
    $eventModel = new EventModel();
    $avg = $ulasanModel->getRatingAvg($id_event);
    $count = $ulasanModel->getCount($id_event);
    
    $eventModel->update($id_event, [
        'rating_avg'    => $avg,
        'jumlah_ulasan' => $count
    ]);

    return redirect()->back()->with('success', 'Terima kasih! Ulasan berhasil disimpan.');
}
    // ===== HAPUS ULASAN (Admin / Ormawa) =====
    public function hapusUlasan($id_ulasan)
    {
        if (!session()->get('logged_in')) {
            return redirect()->back()->with('error', 'Silakan login.');
        }

        $ulasanModel = new UlasanModel();
        $ulasan = $ulasanModel->find($id_ulasan);

        if (!$ulasan) {
            return redirect()->back()->with('error', 'Ulasan tidak ditemukan.');
        }

        // Cek role: admin bisa hapus semua, ormawa hanya hapus ulasan di event mereka
        $role = session()->get('role');

        if (in_array($role, ['admin', 'super_admin'])) {
            // Admin bebas hapus semua
        } elseif ($role === 'organisasi') {
            $eventModel = new EventModel();
            $event = $eventModel->where('id_event', $ulasan['id_event'])
                                ->where('id_ormawa', session()->get('id_ormawa'))
                                ->first();
            if (!$event) {
                return redirect()->back()->with('error', 'Anda tidak berhak menghapus ulasan ini.');
            }
        } else {
            return redirect()->back()->with('error', 'Anda tidak berhak menghapus ulasan ini.');
        }

        $ulasanModel->delete($id_ulasan);

        // Update rating rata-rata
        $eventModel = new EventModel();
        $avg = $ulasanModel->getRatingAvg($ulasan['id_event']);
        $count = $ulasanModel->getCount($ulasan['id_event']);
        $eventModel->update($ulasan['id_event'], [
            'rating_avg'    => $avg,
            'jumlah_ulasan' => $count
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }

    // ===== APPROVE EVENT (Admin) =====
    public function approve($id)
    {
        (new EventModel())->update($id, [
            'status' => 'Pending Validator'
        ]);

        return redirect()->back()->with('success', 'Event dikirim ke Validator');
    }

    // ===== REJECT EVENT (Admin) =====
    public function reject($id)
    {
        (new EventModel())->update($id, [
            'status' => 'Rejected Admin'
        ]);

        return redirect()->back()->with('success', 'Event ditolak');
    }
}