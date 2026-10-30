<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\UserModel;
use App\Models\OrganisasiModel;
use App\Models\DosenModel;

class ValidatorController extends BaseController
{
    protected $eventModel;
    protected $userModel;
    protected $organisasiModel;
    protected $dosenModel;

    public function __construct()
    {
        $this->eventModel      = new EventModel();
        $this->userModel       = new UserModel();
        $this->organisasiModel = new OrganisasiModel();
        $this->dosenModel      = new DosenModel();
    }

    // ==========================================================
    // DASHBOARD
    // ==========================================================
        public function dashboard()
    {
        $db = \Config\Database::connect();

        // Ambil semua event
        $events = $this->eventModel
            ->select('events.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->orderBy('events.created_at', 'DESC')
            ->findAll();

        // Filter per status
        $data_pending = array_values(array_filter($events, fn($e) => $e['status'] === 'Pending Validator'));
        $data_published = array_values(array_filter($events, fn($e) => $e['status'] === 'Published'));
        $data_rejected = array_values(array_filter($events, fn($e) => $e['status'] === 'Rejected Validator'));

        $total_pending = count($data_pending);
        $total_publish = count($data_published);
        $total_reject  = count($data_rejected);
        $total_all     = count($events);

        // Chart
        $year = date('Y');
        $chartPublish = $db->query("
            SELECT MONTH(updated_at) as bulan, COUNT(*) as total
            FROM events
            WHERE status = 'Published' AND YEAR(updated_at) = ?
            GROUP BY MONTH(updated_at)
            ORDER BY bulan ASC
        ", [$year])->getResultArray();

        $chartData = array_fill(1, 12, 0);
        foreach ($chartPublish as $row) {
            $chartData[(int)$row['bulan']] = (int)$row['total'];
        }

        // Statistik ormawa
        $total_ormawa = $db->table('ormawa')->countAllResults();
        $total_ormawa_aktif = $db->table('ormawa')->where('status', 'Aktif')->countAllResults();

        // LPJ yang menunggu verifikasi wadir
        $reportModel = new \App\Models\ReportModel();
        $reportPendingList = array_values(array_filter(
        $reportModel->getForWadir(),
            fn($r) => ($r['status_wadir'] ?? 'pending') === 'pending'
            ));
        $belumVerifikasi   = count($reportPendingList);

        // ===== PROGRESS PER ORMAWA =====
        $ormawaList = $db->table('ormawa')
            ->where('status', 'Aktif')
            ->orderBy('nama_ormawa', 'ASC')
            ->get()->getResultArray();

        $progressOrmawa = [];
        foreach ($ormawaList as $o) {
            $id = $o['id_ormawa'];

            $progjaTotal    = $db->table('progja')->where('id_ormawa', $id)->countAllResults();
            $progjaApproved = $db->table('progja')->where('id_ormawa', $id)->where('status', 'approved')->countAllResults();
            $progjaPending  = $db->table('progja')->where('id_ormawa', $id)->where('status', 'pending')->countAllResults();

            $proposalTotal    = $db->table('proposal')->where('id_ormawa', $id)->countAllResults();
            $proposalApproved = $db->table('proposal')
                ->where('id_ormawa', $id)
                ->where('status_ketua', 'approved')
                ->where('status_pembina', 'approved')
                ->where('status_wadir', 'approved')
                ->countAllResults();
            $proposalPending = $db->table('proposal')
                ->where('id_ormawa', $id)
                ->where('status_wadir', 'pending')
                ->countAllResults();

            $reportTotal    = $db->table('report')->where('id_ormawa', $id)->countAllResults();
            $reportApproved = $db->table('report')
                ->where('id_ormawa', $id)
                ->where('status_ketua', 'approved')
                ->where('status_pembina', 'approved')
                ->where('status_wadir', 'approved')
                ->countAllResults();
            $reportPending = $db->table('report')
                ->where('id_ormawa', $id)
                ->where('status_wadir', 'pending')
                ->countAllResults();

            $progressProposal = $progjaApproved > 0 ? round(($proposalApproved / $progjaApproved) * 100) : 0;
            $progressReport   = $proposalApproved > 0 ? round(($reportApproved / $proposalApproved) * 100) : 0;

            $progressOrmawa[] = [
                'ormawa'            => $o,
                'progja_total'      => $progjaTotal,
                'progja_approved'   => $progjaApproved,
                'progja_pending'    => $progjaPending,
                'proposal_total'    => $proposalTotal,
                'proposal_approved' => $proposalApproved,
                'proposal_pending'  => $proposalPending,
                'report_total'      => $reportTotal,
                'report_approved'   => $reportApproved,
                'report_pending'    => $reportPending,
                'progress_proposal' => $progressProposal,
                'progress_report'   => $progressReport,
            ];
        }

        return view('validator/dashboard', [
            'title'              => 'Dashboard Validator',
            'total_pending'      => $total_pending,
            'total_publish'      => $total_publish,
            'total_reject'       => $total_reject,
            'total_all'          => $total_all,
            'total_ormawa'       => $total_ormawa,
            'total_ormawa_aktif' => $total_ormawa_aktif,
            'data_pending'       => $data_pending,
            'data_selesai'       => array_merge($data_published, $data_rejected),
            'recent_events'      => array_slice($events, 0, 10),
            'chartData'          => array_values($chartData),
            'chartYear'          => $year,
            'belum_verifikasi'   => $belumVerifikasi,
            'progressOrmawa'     => $progressOrmawa,
            'reportPendingList'  => $reportPendingList,
        ]);
    }
        // ==========================================================
    // VALIDASI EVENT
    // ==========================================================
    public function approve($id)
    {
        $this->eventModel->update($id, ['status' => 'Published']);
        return redirect()->to('validator/dashboard')
            ->with('success', 'Event berhasil dipublikasikan.');
    }

    public function reject($id)
    {
        $this->eventModel->update($id, ['status' => 'Rejected Validator']);
        return redirect()->to('validator/dashboard')
            ->with('success', 'Event ditolak.');
    }

    public function hapus($id)
    {
        $this->eventModel->delete($id);
        return redirect()->to('validator/dashboard')
            ->with('success', 'Event berhasil dihapus.');
    }

        // ==========================================================
    // KELOLA ORMAWA (HANYA ADMIN ORMAWA / role=organisasi)
    // ==========================================================
    public function ormawa()
    {
        $db = \Config\Database::connect();

        $organisasi = $db->table('ormawa')
            ->select('ormawa.*, users.username, users.email, users.no_telp, users.id AS id_user')
            ->join('users', 'users.id_ormawa = ormawa.id_ormawa', 'left')
            ->where('users.role', 'organisasi')
            ->orderBy('ormawa.nama_ormawa', 'ASC')
            ->get()->getResultArray();

        return view('validator/ormawa/index', [
            'organisasi' => $organisasi,
        ]);
    }

    
public function tambahOrmawa()
{
    return view('validator/ormawa/tambah', [
        'title' => 'Tambah Ormawa',
    ]);
}

public function simpanOrmawa()
{
    $namaOrmawa = trim((string) $this->request->getPost('nama_ormawa'));
    $kategori   = trim((string) $this->request->getPost('kategori'));
    $username   = trim((string) $this->request->getPost('username'));
    $email      = trim((string) $this->request->getPost('email'));
    $noTelp     = trim((string) $this->request->getPost('no_telp'));
    $password   = (string) $this->request->getPost('password');

    if (
        $namaOrmawa === '' ||
        $kategori === '' ||
        $username === '' ||
        $email === '' ||
        $noTelp === '' ||
        $password === ''
    ) {
        return redirect()->back()->withInput()
            ->with('error', 'Semua field wajib diisi.');
    }

    if (!in_array($kategori, ['HMJ', 'UKM', 'Lainnya'], true)) {
        return redirect()->back()->withInput()
            ->with('error', 'Kategori Ormawa tidak valid.');
    }

    if (strlen($password) < 6) {
        return redirect()->back()->withInput()
            ->with('error', 'Password minimal 6 karakter.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return redirect()->back()->withInput()
            ->with('error', 'Format email tidak valid.');
    }

    if (!preg_match('/^(\+62|08)[0-9]{8,13}$/', $noTelp)) {
        return redirect()->back()->withInput()
            ->with('error', 'Nomor telepon harus diawali +62 atau 08.');
    }

    if ($this->userModel->where('username', $username)->first()) {
        return redirect()->back()->withInput()
            ->with('error', 'Username sudah digunakan.');
    }

    if ($this->userModel->where('email', $email)->first()) {
        return redirect()->back()->withInput()
            ->with('error', 'Email sudah digunakan.');
    }

    if ($this->userModel->where('no_telp', $noTelp)->first()) {
        return redirect()->back()->withInput()
            ->with('error', 'Nomor telepon sudah digunakan.');
    }

    $db = \Config\Database::connect();
    $db->transBegin();

    try {
        // Simpan Ormawa tanpa memilih pembina terlebih dahulu.
        $idOrmawa = $this->organisasiModel->insert([
            'nama_ormawa' => $namaOrmawa,
            'kategori'    => $kategori,
            'pembina'     => null,
            'status'      => 'Aktif',
        ], true);

        if (!$idOrmawa) {
            throw new \RuntimeException('Data Ormawa gagal disimpan.');
        }

        // Buat akun login admin Ormawa.
        $idUser = $this->userModel->insert([
            'id_ormawa' => $idOrmawa,
            'username'  => $username,
            'email'     => $email,
            'no_telp'   => $noTelp,
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'role'      => 'organisasi',
        ], true);

        if (!$idUser || $db->transStatus() === false) {
            throw new \RuntimeException('Akun Ormawa gagal dibuat.');
        }

        $db->transCommit();

        return redirect()->to(site_url('validator/ormawa'))
            ->with('success', 'Ormawa dan akun login berhasil ditambahkan.');

    } catch (\Throwable $e) {
        $db->transRollback();

        log_message('error', 'Gagal menambahkan Ormawa: ' . $e->getMessage());

        return redirect()->back()->withInput()
            ->with('error', 'Data gagal disimpan. Periksa struktur tabel database.');
    }
}

    public function editOrmawa($id)
    {
        $db = \Config\Database::connect();

        $organisasi = $db->table('ormawa')
            ->select('ormawa.*, users.username, users.email, users.no_telp')
            ->join('users', 'users.id_ormawa = ormawa.id_ormawa', 'left')
            ->where('ormawa.id_ormawa', $id)
            ->where('users.role', 'organisasi')
            ->get()->getRowArray();

        if (!$organisasi) {
            return redirect()->to('validator/ormawa')
                ->with('error', 'Data tidak ditemukan');
        }

        return view('validator/ormawa/edit', [
            'row'           => $organisasi,
            'dosen'         => $this->dosenModel->findAll(),
            'kategori_list' => ['HMJ', 'UKM', 'Lainnya']
        ]);
    }

    public function updateOrmawa($id)
    {
        $ormawaModel = $this->organisasiModel;
        $userModel   = new UserModel();

        $no_telp = $this->request->getPost('no_telp');

        if (!preg_match('/^(\+62|08)[0-9]{8,13}$/', $no_telp)) {
            return redirect()->back()->withInput()
                ->with('error', 'No Telp harus diawali +62 atau 08');
        }

        // Cek duplikat user (selain admin ormawa ini)
        $cekUser = $userModel
            ->groupStart()
                ->where('email', $this->request->getPost('email'))
                ->orWhere('no_telp', $no_telp)
            ->groupEnd()
            ->where('role', 'organisasi')
            ->where('id_ormawa !=', $id)
            ->first();

        if ($cekUser) {
            return redirect()->back()->withInput()
                ->with('error', 'Email / No Telp sudah digunakan');
        }

        // Update ormawa
        $dataOrmawa = [
            'nama_ormawa' => $this->request->getPost('nama_ormawa'),
            'pembina'     => $this->request->getPost('pembina'),
            'kategori'    => $this->request->getPost('kategori'),
            'status'      => $this->request->getPost('status')
        ];
        $dataOrmawa = array_filter($dataOrmawa, fn($v) => $v !== null && $v !== '');

        if (!empty($dataOrmawa)) {
            $ormawaModel->update($id, $dataOrmawa);
        }

        // Update user admin ormawa
        $dataUser = [
            'email'   => $this->request->getPost('email'),
            'no_telp' => $no_telp
        ];

        if ($this->request->getPost('password')) {
            $dataUser['password'] = password_hash(
                $this->request->getPost('password'),
                PASSWORD_DEFAULT
            );
        }
        $dataUser = array_filter($dataUser, fn($v) => $v !== null && $v !== '');

        if (!empty($dataUser)) {
            $userModel->where('id_ormawa', $id)
                      ->where('role', 'organisasi')
                      ->set($dataUser)
                      ->update();
        }

        return redirect()->to('validator/ormawa')
            ->with('success', 'Data berhasil diperbarui');
    }
    public function hapusOrmawa($id)
    {
        // Hapus user ormawa dulu
        $this->userModel->where('id_ormawa', $id)->delete();

        // Baru hapus ormawa
        $this->organisasiModel->delete($id);

        return redirect()->to(base_url('validator/ormawa'))
            ->with('success', 'Data Ormawa berhasil dihapus!');
    }

    // ==========================================================
    // KELOLA PEMBINA 
    // ==========================================================
    public function dosen()
    {
        $db = \Config\Database::connect();

        $pembina = $db->table('users')
            ->select('users.*, dosen.nip, dosen.nama_dosen, ormawa.nama_ormawa')
            ->join('dosen', 'dosen.id_dosen = users.id_dosen', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = users.id_ormawa', 'left')
            ->where('users.role', 'pembina')
            ->orderBy('dosen.nama_dosen', 'ASC')
            ->get()->getResultArray();

        return view('validator/dosen/index', [
            'title'    => 'Data Pembina',
            'pembina'  => $pembina,
        ]);
    }

    public function tambahDosen()
    {
        $ormawaModel = new \App\Models\OrganisasiModel();

        return view('validator/dosen/tambah', [
            'title'  => 'Tambah Pembina',
            'ormawa' => $ormawaModel->orderBy('nama_ormawa', 'ASC')->findAll(),
        ]);
    }

    public function simpanDosen()
    {
        $db          = \Config\Database::connect();
        $userModel   = new UserModel();
        $ormawaModel = new \App\Models\OrganisasiModel();

        $nip       = trim($this->request->getPost('nip'));
        $namaDosen = trim($this->request->getPost('nama_dosen'));
        $email     = trim($this->request->getPost('email'));
        $username  = trim($this->request->getPost('username'));
        $password  = $this->request->getPost('password');
        $noTelp    = trim($this->request->getPost('no_telp'));
        $idOrmawa  = (int) $this->request->getPost('id_ormawa');

        // Validasi
        if (empty($nip) || empty($namaDosen) || empty($email) || empty($username) || empty($password) || !$idOrmawa) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
        }

        if ($this->dosenModel->where('nip', $nip)->first()) {
            return redirect()->back()->withInput()->with('error', 'NIP sudah terdaftar.');
        }

        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username sudah dipakai.');
        }

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah dipakai.');
        }

        // Cek ormawa sudah punya pembina atau belum
        $sudahAdaPembina = $userModel->where('id_ormawa', $idOrmawa)
            ->where('role', 'pembina')
            ->first();
        if ($sudahAdaPembina) {
            return redirect()->back()->withInput()->with('error', 'Ormawa ini sudah punya pembina.');
        }

        // Insert ke tabel dosen
        $idDosen = $this->dosenModel->insert([
            'nip'        => $nip,
            'nama_dosen' => $namaDosen,
        ], true);

        // Insert ke tabel users
        $userModel->insert([
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'no_telp'    => $noTelp,
            'role'       => 'pembina',
            'id_ormawa'  => $idOrmawa,
            'id_dosen'   => $idDosen,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        // Update nama pembina di tabel ormawa (biar konsisten)
        $ormawaModel->update($idOrmawa, [
            'pembina' => $namaDosen,
        ]);

        return redirect()->to(base_url('validator/dosen'))
            ->with('success', 'Akun pembina berhasil dibuat. Berikan username & password ke pembina yang bersangkutan.');
    }

    public function editDosen($id)
    {
        $db          = \Config\Database::connect();
        $ormawaModel = new \App\Models\OrganisasiModel();

        // $id di sini = id_dosen (bukan id_user)
        $dosen = $this->dosenModel->find($id);
        if (!$dosen) {
            return redirect()->to('validator/dosen')->with('error', 'Data tidak ditemukan.');
        }

        $user = $db->table('users')
            ->where('id_dosen', $id)
            ->where('role', 'pembina')
            ->get()->getRowArray();

        return view('validator/dosen/edit', [
            'title'  => 'Edit Pembina',
            'dosen'  => $dosen,
            'user'   => $user,
            'ormawa' => $ormawaModel->orderBy('nama_ormawa', 'ASC')->findAll(),
        ]);
    }

    public function updateDosen($id)
    {
        $db        = \Config\Database::connect();
        $userModel = new UserModel();

        $dosen = $this->dosenModel->find($id);
        if (!$dosen) {
            return redirect()->to('validator/dosen')->with('error', 'Data tidak ditemukan.');
        }

        $nip       = trim($this->request->getPost('nip'));
        $namaDosen = trim($this->request->getPost('nama_dosen'));
        $email     = trim($this->request->getPost('email'));
        $noTelp    = trim($this->request->getPost('no_telp'));
        $idOrmawa  = (int) $this->request->getPost('id_ormawa');
        $password  = $this->request->getPost('password');

        if (empty($nip) || empty($namaDosen) || empty($email) || !$idOrmawa) {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        // Cek NIP duplikat (selain dirinya)
        $cek = $this->dosenModel->where('nip', $nip)->where('id_dosen !=', $id)->first();
        if ($cek) {
            return redirect()->back()->withInput()->with('error', 'NIP sudah dipakai dosen lain.');
        }

        // Update dosen
        $this->dosenModel->update($id, [
            'nip'        => $nip,
            'nama_dosen' => $namaDosen,
        ]);

        // Update user pembina
        $user = $db->table('users')->where('id_dosen', $id)->where('role', 'pembina')->get()->getRowArray();
        if ($user) {
            $dataUser = [
                'email'     => $email,
                'no_telp'   => $noTelp,
                'id_ormawa' => $idOrmawa,
            ];
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
                }
                $dataUser['password'] = password_hash($password, PASSWORD_DEFAULT);
            }
            $userModel->update($user['id'], $dataUser);

            // Update nama pembina di ormawa
            $ormawaModel = new \App\Models\OrganisasiModel();
            $ormawaModel->update($idOrmawa, ['pembina' => $namaDosen]);
        }

        return redirect()->to(base_url('validator/dosen'))
            ->with('success', 'Data pembina berhasil diperbarui.');
    }

    public function hapusDosen($id)
    {
        $db = \Config\Database::connect();

        $dosen = $this->dosenModel->find($id);
        if (!$dosen) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hapus user pembina-nya dulu
        $db->table('users')->where('id_dosen', $id)->where('role', 'pembina')->delete();

        // Baru hapus dosen
        $this->dosenModel->delete($id);

        return redirect()->back()->with('success', 'Akun pembina berhasil dihapus.');
    }

        // ==========================================================
    // VERIFIKASI REPORT / LPJ (WADIR)
    // ==========================================================
    public function report()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $reportModel = new \App\Models\ReportModel();
        $reports = $reportModel->getForWadir();

        return view('validator/report', [
            'title'   => 'Verifikasi LPJ',
            'reports' => $reports,
        ]);
    }

    public function detailReport($id_report)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $reportModel = new \App\Models\ReportModel();
        $report = $reportModel
            ->select('report.*, events.nama_event, events.tanggal, events.gedung, events.waktu, ormawa.nama_ormawa, ormawa.pembina')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = report.id_ormawa', 'left')
            ->where('report.id_report', $id_report)
            ->first();

        if (!$report) {
            return redirect()->to('validator/report')->with('error', 'Report tidak ditemukan.');
        }

        return view('validator/report_detail', [
            'title'  => 'Detail LPJ',
            'report' => $report,
        ]);
    }

    public function verifikasiReport($id_report)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $reportModel = new \App\Models\ReportModel();
        $report = $reportModel->find($id_report);

        if (!$report) {
            return redirect()->to('validator/report')->with('error', 'Report tidak ditemukan.');
        }

        $aksi    = $this->request->getPost('aksi');
        $catatan = trim($this->request->getPost('catatan') ?? '');

        if (!in_array($aksi, ['approve', 'reject'])) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        if ($aksi === 'reject' && empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan wajib diisi jika menolak.');
        }

        $reportModel->update($id_report, [
            'status_wadir'      => $aksi === 'approve' ? 'approved' : 'rejected',
            'catatan_wadir'     => $catatan ?: null,
            'verified_wadir_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $aksi === 'approve'
            ? 'LPJ disetujui! Lembar pengesahan sudah bisa dicetak oleh ormawa.'
            : 'LPJ ditolak.';

        return redirect()->to('validator/report')->with('success', $msg);
    }

        
    // PROGRAM KERJA — DAFTAR & VALIDASI
    
        public function progja()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $db = \Config\Database::connect();

        // Ambil semua ormawa aktif
        $ormawaList = $db->table('ormawa')
            ->where('status', 'Aktif')
            ->orderBy('nama_ormawa', 'ASC')
            ->get()->getResultArray();

        // Ambil semua progja + proposal
        $progjaList = $db->table('progja')
            ->select('progja.*, ormawa.nama_ormawa, ormawa.logo AS ormawa_logo,
                      proposal.id_proposal, 
                      proposal.status_ketua, 
                      proposal.status_pembina, 
                      proposal.status_wadir')
            ->join('ormawa', 'ormawa.id_ormawa = progja.id_ormawa', 'left')
            ->join('proposal', 'proposal.id_progja = progja.id_progja', 'left')
            ->orderBy('progja.bulan', 'ASC')
            ->orderBy('progja.created_at', 'DESC')
            ->get()->getResultArray();

        // Group by ormawa
        $grouped = [];
        foreach ($ormawaList as $o) {
            $grouped[$o['id_ormawa']] = [
                'ormawa' => $o,
                'progja' => [],
            ];
        }
        foreach ($progjaList as $p) {
            if (isset($grouped[$p['id_ormawa']])) {
                $grouped[$p['id_ormawa']]['progja'][] = $p;
            }
        }

        return view('validator/progja/index', [
            'title'   => 'Program Kerja Ormawa',
            'grouped' => $grouped,
        ]);
    }

    public function detailProgja($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $db = \Config\Database::connect();

        $progja = $db->table('progja')
            ->select('progja.*, ormawa.nama_ormawa, ormawa.logo AS ormawa_logo')
            ->join('ormawa', 'ormawa.id_ormawa = progja.id_ormawa', 'left')
            ->where('progja.id_progja', $id)
            ->get()->getRowArray();

        if (!$progja) {
            return redirect()->to('validator/progja')->with('error', 'Progja tidak ditemukan.');
        }

        return view('validator/progja/detail', [
            'title'  => 'Detail Progja - ' . $progja['nama_progja'],
            'progja' => $progja,
        ]);
    }

    public function prosesProgja($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $progjaModel = new \App\Models\ProgjaModel();
        $progja = $progjaModel->find($id);

        if (!$progja) {
            return redirect()->to('validator/progja')->with('error', 'Progja tidak ditemukan.');
        }

        $aksi    = $this->request->getPost('aksi'); // approve / reject
        $catatan = trim($this->request->getPost('catatan') ?? '');

        if (!in_array($aksi, ['approve', 'reject'])) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        if ($aksi === 'reject' && empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan wajib diisi jika menolak.');
        }

        $progjaModel->update($id, [
            'status'            => $aksi === 'approve' ? 'approved' : 'rejected',
            'catatan_validator' => $catatan ?: null,
            'validated_by'      => session()->get('user_id'),
            'validated_at'      => date('Y-m-d H:i:s'),
        ]);

        $msg = $aksi === 'approve'
            ? 'Progja disetujui. Ormawa bisa upload proposal.'
            : 'Progja ditolak.';

        return redirect()->to('validator/progja')->with('success', $msg);
    }

    // ==========================================================
    // PROPOSAL — DAFTAR & VERIFIKASI
    // ==========================================================
    public function proposal()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $proposalModel = new \App\Models\ProposalModel();
        $proposals = $proposalModel->getForWadir();

        return view('validator/proposal', [
            'title'     => 'Verifikasi Proposal',
            'proposals' => $proposals,
        ]);
    }

    public function detailProposal($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $proposalModel = new \App\Models\ProposalModel();
        $proposal = $proposalModel
            ->select('proposal.*, progja.nama_progja, progja.bulan, progja.semester, 
                      ormawa.nama_ormawa, ormawa.pembina')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = proposal.id_ormawa', 'left')
            ->where('proposal.id_proposal', $id)
            ->first();

        if (!$proposal) {
            return redirect()->to('validator/proposal')->with('error', 'Proposal tidak ditemukan.');
        }

        return view('validator/proposal_detail', [
            'title'    => 'Detail Proposal',
            'proposal' => $proposal,
        ]);
    }

    public function verifikasiProposal($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        $proposalModel = new \App\Models\ProposalModel();
        $proposal = $proposalModel->find($id);

        if (!$proposal) {
            return redirect()->to('validator/proposal')->with('error', 'Proposal tidak ditemukan.');
        }

        $aksi    = $this->request->getPost('aksi');
        $catatan = trim($this->request->getPost('catatan') ?? '');

        if (!in_array($aksi, ['approve', 'reject'])) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        if ($aksi === 'reject' && empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan wajib diisi jika menolak.');
        }

        $proposalModel->update($id, [
            'status_wadir'      => $aksi === 'approve' ? 'approved' : 'rejected',
            'catatan_wadir'     => $catatan ?: null,
            'verified_wadir_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $aksi === 'approve'
            ? 'Proposal disetujui! Lembar pengesahan sudah bisa dicetak oleh ormawa.'
            : 'Proposal ditolak.';

        return redirect()->to('validator/proposal')->with('success', $msg);
    }
}