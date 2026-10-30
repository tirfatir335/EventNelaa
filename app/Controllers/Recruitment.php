<?php

namespace App\Controllers;

use App\Models\RecruitmentModel;
use App\Models\PendaftarModel;

class Recruitment extends BaseController
{
    protected $recruitmentModel;
    protected $pendaftarModel;

    public function __construct()
    {
        $this->recruitmentModel = new RecruitmentModel();
        $this->pendaftarModel   = new PendaftarModel();
    }

    // ==================== PUBLIK ====================
    public function index()
    {
        $data = [
            'title' => 'Open Recruitment UKM/Ormawa',
            'recruitments' => $this->recruitmentModel->getActive(),
            'current_page' => 'recruitment'
        ];
        return view('recruitment/list', $data);
    }

    public function detail($id)
{
    $recruitment = $this->recruitmentModel->getDetail($id);
    if (!$recruitment) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Open Recruitment tidak ditemukan.');
    }

    $sudah_daftar = false;
    $pendaftaran_user = null;
    if (session()->get('logged_in')) {
        $sudah_daftar = $this->pendaftarModel->sudahDaftar($id, session()->get('user_id'));
        $pendaftaran_user = $this->pendaftarModel
            ->where('id_recruitment', $id)
            ->where('id_user', session()->get('user_id'))
            ->first();
    }

    // Ambil daftar yang LOLOS per tahap (untuk pengumuman publik)
    $lolosTesTertulis = $this->recruitmentModel->getLolosByTahap($id, 'tes_tertulis');
    $lolosWawancara   = $this->recruitmentModel->getLolosByTahap($id, 'wawancara');
    $diterima         = $this->recruitmentModel->getLolosByTahap($id, 'diterima');

    return view('recruitment/detail', [
        'title'            => $recruitment['judul'],
        'recruitment'      => $recruitment,
        'sudah_daftar'     => $sudah_daftar,
        'pendaftaran_user' => $pendaftaran_user,
        'lolos_tes'        => $lolosTesTertulis,
        'lolos_wawancara'  => $lolosWawancara,
        'diterima'         => $diterima,
        'current_page'     => 'recruitment'
    ]);
    }

    public function formDaftar($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $recruitment = $this->recruitmentModel->getDetail($id);
        if (!$recruitment) {
            return redirect()->to('recruitment')->with('error', 'Data tidak ditemukan.');
        }

        if ($this->pendaftarModel->sudahDaftar($id, session()->get('user_id'))) {
            return redirect()->to('recruitment/detail/'.$id)->with('error', 'Anda sudah mendaftar.');
        }

        return view('recruitment/form_daftar', [
            'title' => 'Form Pendaftaran - ' . $recruitment['judul'],
            'recruitment' => $recruitment
        ]);
    }

    public function simpanPendaftaran()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $id_recruitment = $this->request->getPost('id_recruitment');
        $id_user = session()->get('user_id');

        if ($this->pendaftarModel->sudahDaftar($id_recruitment, $id_user)) {
            return redirect()->back()->with('error', 'Anda sudah mendaftar.');
        }

        $this->pendaftarModel->insert([
            'id_recruitment' => $id_recruitment,
            'id_user' => $id_user,
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'nim' => $this->request->getPost('nim'),
            'prodi' => $this->request->getPost('prodi'),
            'no_hp' => $this->request->getPost('no_hp'),
            'email' => $this->request->getPost('email'),
            'alasan' => $this->request->getPost('alasan'),
            'status_pendaftaran' => 'pending'
        ]);

        return redirect()->to('recruitment/riwayat')->with('success', 'Pendaftaran berhasil dikirim!');
    }

    public function riwayat()
    {
    if (!session()->get('logged_in')) {
        return redirect()->to('login');
    }

    $pendaftarModel = new PendaftarModel();
    $pendaftaran = $pendaftarModel->getByUser(session()->get('user_id'));

    $data = [
        'title' => 'Pendaftaran Saya',
        'pendaftaran' => $pendaftaran,
        'current_page' => 'riwayat'
    ];
    return view('recruitment/riwayat', $data);
    }

    // ==================== ORMAWA: KELOLA ====================
    public function kelola()
    {
        if (!can_access('recruitment', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Kelola Open Recruitment',
            'recruitments' => $this->recruitmentModel->getByOrmawa(session()->get('id_ormawa'))
        ];
        return view('ormawa/recruitment/index', $data);
    }

    public function tambah()
    {
        if (!can_access('recruitment', 'create')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }
        return view('ormawa/recruitment/tambah', ['title' => 'Tambah Open Recruitment']);
    }

    public function simpan()
    {
        if (!can_access('recruitment', 'create')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }

         $this->recruitmentModel->insert([
            'id_ormawa' => session()->get('id_ormawa'),
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'posisi' => $this->request->getPost('posisi'),
            'periode' => $this->request->getPost('periode'),
            'link_pendaftaran' => $this->request->getPost('link_pendaftaran'),
            'link_wa' => $this->request->getPost('link_wa'),
            'status' => $this->request->getPost('status'),
            'pakai_tes_tertulis' => $this->request->getPost('pakai_tes_tertulis') ? 1 : 0,
            'pakai_wawancara' => $this->request->getPost('pakai_wawancara') ? 1 : 0,
        ]);

        return redirect()->to('ormawa/recruitment')->with('success', 'Open Recruitment berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!can_access('recruitment', 'edit')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }

        $recruitment = $this->recruitmentModel->find($id);
        if (!$recruitment || $recruitment['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Data tidak ditemukan.');
        }

        return view('ormawa/recruitment/edit', [
            'title' => 'Edit Open Recruitment',
            'recruitment' => $recruitment
        ]);
    }

    public function update($id)
    {
        if (!can_access('recruitment', 'edit')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }

        $recruitment = $this->recruitmentModel->find($id);
        if (!$recruitment || $recruitment['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }

         $this->recruitmentModel->update($id, [
            'judul' => $this->request->getPost('judul'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'posisi' => $this->request->getPost('posisi'),
            'periode' => $this->request->getPost('periode'),
            'link_pendaftaran' => $this->request->getPost('link_pendaftaran'),
            'link_wa' => $this->request->getPost('link_wa'),
            'status' => $this->request->getPost('status'),
            'pakai_tes_tertulis' => $this->request->getPost('pakai_tes_tertulis') ? 1 : 0,
            'pakai_wawancara' => $this->request->getPost('pakai_wawancara') ? 1 : 0,
        ]);
        return redirect()->to('ormawa/recruitment')->with('success', 'Data berhasil diperbarui.');
    }

    public function hapus($id)
    {
        if (!can_access('recruitment', 'delete')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }

        $recruitment = $this->recruitmentModel->find($id);
        if ($recruitment && $recruitment['id_ormawa'] == session()->get('id_ormawa')) {
            $this->recruitmentModel->delete($id);
        }
        return redirect()->to('ormawa/recruitment')->with('success', 'Data berhasil dihapus.');
    }

    public function pendaftar($id_recruitment)
    {
        if (!can_access('recruitment', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $recruitment = $this->recruitmentModel->find($id_recruitment);
        if (!$recruitment || $recruitment['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/recruitment')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Daftar Pendaftar - ' . $recruitment['judul'],
            'recruitment' => $recruitment,
            'pendaftar' => $this->pendaftarModel->getByRecruitment($id_recruitment)
        ];
        return view('ormawa/recruitment/pendaftar', $data);
    }

    public function updateStatusPendaftar($id_pendaftar)
{
    if (!can_access('recruitment', 'edit')) {
        return redirect()->back()->with('error', 'Akses ditolak.');
    }

    $pendaftar = $this->pendaftarModel->find($id_pendaftar);
    if (!$pendaftar) {
        return redirect()->back()->with('error', 'Data tidak ditemukan.');
    }

    $recruitment = $this->recruitmentModel->find($pendaftar['id_recruitment']);
    if (!$recruitment || $recruitment['id_ormawa'] != session()->get('id_ormawa')) {
        return redirect()->back()->with('error', 'Akses ditolak.');
    }

    $this->pendaftarModel->update($id_pendaftar, [
        'status_pendaftaran' => $this->request->getPost('status_pendaftaran'),
        'catatan_admin'      => $this->request->getPost('catatan_admin') 
    ]);

    return redirect()->back()->with('success', 'Status & catatan pendaftar berhasil diperbarui.');
}

    // ==================== UPDATE STATUS MASSAL (BULK) ====================
    public function updateBulkStatus()
    {
        if (!can_access('recruitment', 'edit')) {
            return redirect()->back()->with('error', 'Akses ditolak.');
        }

        $ids    = $this->request->getPost('ids'); // Array ID pendaftar
        $status = $this->request->getPost('status_bulk');
        $catatan = trim($this->request->getPost('catatan_bulk') ?? '');

        if (empty($ids) || empty($status)) {
            return redirect()->back()->with('error', 'Pilih pendaftar dan status terlebih dahulu.');
        }

        // Update semua ID yang dipilih
        $this->pendaftarModel->whereIn('id_pendaftar', $ids)->set([
            'status_pendaftaran' => $status,
            'catatan_admin'      => $catatan ?: null,
        ])->update();

        $jumlah = count($ids);
        return redirect()->back()->with('success', "Berhasil mengubah status {$jumlah} pendaftar sekaligus.");
    }
}