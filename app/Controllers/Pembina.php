<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ReportModel;

class Pembina extends BaseController
{
    protected $userModel;
    protected $reportModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->reportModel = new ReportModel();
    }

        public function dashboard()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $allReports = $this->reportModel->getForPembina($id_ormawa);

        $totalPending  = 0;
        $totalApproved = 0;
        $totalRejected = 0;

        foreach ($allReports as $r) {
            if ($r['status_pembina'] === 'pending')  $totalPending++;
            if ($r['status_pembina'] === 'approved') $totalApproved++;
            if ($r['status_pembina'] === 'rejected') $totalRejected++;
        }

        return view('pembina/dashboard', [
            'title'           => 'Dashboard Pembina',
            'total_pending'   => $totalPending,
            'total_approved'  => $totalApproved,
            'total_rejected'  => $totalRejected,
            'belum_verifikasi' => $totalPending,  // ← TAMBAH
        ]);
    }

    // ==================== PROFIL ====================
    public function profil()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id = session()->get('user_id');
        $pembina = $this->userModel->find($id);

        if (!$pembina) {
            return redirect()->to('login')->with('error', 'Data user tidak ditemukan.');
        }

        return view('pembina/profil', [
            'title'    => 'Profil Pembina',
            'pembina'  => $pembina,
        ]);
    }

    public function updateProfil()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->back()->with('error', 'Silakan login terlebih dahulu.');
        }

        $id = session()->get('user_id');
        $pembina = $this->userModel->find($id);

        if (!$pembina) {
            return redirect()->back()->with('error', 'Data user tidak ditemukan.');
        }

        $rules = [
            'email'   => 'required|valid_email',
            'no_telp' => 'permit_empty',
            'foto'    => [
                'rules'  => 'if_exist|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'Format foto harus JPG atau PNG',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'email'   => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp'),
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($pembina['foto']) &&
                $pembina['foto'] !== 'default.png' &&
                file_exists(FCPATH . 'uploads/profil/' . $pembina['foto'])) {
                unlink(FCPATH . 'uploads/profil/' . $pembina['foto']);
            }
            $newName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/profil', $newName);
            $data['foto'] = $newName;
            session()->set('foto', $newName);
        }

        $this->userModel->update($id, $data);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ==================== REPORT / VERIFIKASI LPJ ====================
    public function report()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $reports   = $this->reportModel->getForPembina($id_ormawa);

        return view('pembina/report', [
            'title'   => 'Verifikasi LPJ',
            'reports' => $reports,
        ]);
    }

    public function detailReport($id_report)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $report = $this->reportModel
            ->select('report.*, events.nama_event, events.tanggal, events.gedung, events.waktu, ormawa.nama_ormawa')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = report.id_ormawa', 'left')
            ->where('report.id_report', $id_report)
            ->where('report.id_ormawa', $id_ormawa)
            ->first();

        if (!$report) {
            return redirect()->to('pembina/report')->with('error', 'Report tidak ditemukan.');
        }

        return view('pembina/report_detail', [
            'title'  => 'Detail LPJ',
            'report' => $report,
        ]);
    }

    public function verifikasiReport($id_report)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $report = $this->reportModel
            ->where('id_report', $id_report)
            ->where('id_ormawa', $id_ormawa)
            ->first();

        if (!$report) {
            return redirect()->to('pembina/report')->with('error', 'Report tidak ditemukan.');
        }

        $aksi    = $this->request->getPost('aksi');   // 'approve' atau 'reject'
        $catatan = trim($this->request->getPost('catatan') ?? '');

        if (!in_array($aksi, ['approve', 'reject'])) {
            return redirect()->back()->with('error', 'Aksi tidak valid.');
        }

        if ($aksi === 'reject' && empty($catatan)) {
            return redirect()->back()->with('error', 'Catatan wajib diisi jika menolak.');
        }

        $this->reportModel->update($id_report, [
            'status_pembina'     => $aksi === 'approve' ? 'approved' : 'rejected',
            'catatan_pembina'    => $catatan ?: null,
            'verified_pembina_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $aksi === 'approve'
            ? 'Report berhasil disetujui. Diteruskan ke Wadir.'
            : 'Report ditolak.';

        return redirect()->to('pembina/report')->with('success', $msg);
    }

        // ==================== PROPOSAL ====================
    public function proposal()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $proposalModel = new \App\Models\ProposalModel();
        $proposals = $proposalModel->getForPembina($id_ormawa);

        return view('pembina/proposal', [
            'title'     => 'Verifikasi Proposal',
            'proposals' => $proposals,
        ]);
    }

    public function detailProposal($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $proposalModel = new \App\Models\ProposalModel();
        $proposal = $proposalModel
            ->select('proposal.*, progja.nama_progja, progja.bulan, progja.semester,
                      ormawa.nama_ormawa')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = proposal.id_ormawa', 'left')
            ->where('proposal.id_proposal', $id)
            ->where('proposal.id_ormawa', $id_ormawa)
            ->first();

        if (!$proposal) {
            return redirect()->to('pembina/proposal')->with('error', 'Proposal tidak ditemukan.');
        }

        return view('pembina/proposal_detail', [
            'title'    => 'Detail Proposal',
            'proposal' => $proposal,
        ]);
    }

    public function verifikasiProposal($id)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'pembina') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $proposalModel = new \App\Models\ProposalModel();
        $proposal = $proposalModel
            ->where('id_proposal', $id)
            ->where('id_ormawa', $id_ormawa)
            ->first();

        if (!$proposal) {
            return redirect()->to('pembina/proposal')->with('error', 'Proposal tidak ditemukan.');
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
            'status_pembina'      => $aksi === 'approve' ? 'approved' : 'rejected',
            'catatan_pembina'     => $catatan ?: null,
            'verified_pembina_at' => date('Y-m-d H:i:s'),
        ]);

        $msg = $aksi === 'approve'
            ? 'Proposal disetujui. Diteruskan ke Wadir.'
            : 'Proposal ditolak.';

        return redirect()->to('pembina/proposal')->with('success', $msg);
    }
}