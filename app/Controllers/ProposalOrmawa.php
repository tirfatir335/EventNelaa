<?php

namespace App\Controllers;

use App\Models\ProposalModel;
use App\Models\ProgjaModel;

class ProposalOrmawa extends BaseController
{
    protected $proposalModel;
    protected $progjaModel;

    public function __construct()
    {
        $this->proposalModel = new ProposalModel();
        $this->progjaModel   = new ProgjaModel();
    }

    // Daftar proposal ormawa
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $proposals = $this->proposalModel->getByOrmawa($id_ormawa);

        // Ambil propja yang approved tapi belum ada proposal
        $progjaBelumProposal = [];
        $allProgja = $this->progjaModel->where('id_ormawa', $id_ormawa)
            ->where('status', 'approved')
            ->orderBy('bulan', 'ASC')
            ->findAll();

        foreach ($allProgja as $p) {
            if (!$this->proposalModel->getByProgja($p['id_progja'])) {
                $progjaBelumProposal[] = $p;
            }
        }

        return view('ormawa/proposal/index', [
            'title'         => 'Proposal Kegiatan',
            'proposals'     => $proposals,
            'belum_proposal'=> $progjaBelumProposal,
        ]);
    }

        // Form upload proposal (bisa untuk baru atau revisi)
    public function isi($id_progja)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $progja = $this->progjaModel
            ->where('id_progja', $id_progja)
            ->where('id_ormawa', $id_ormawa)
            ->first();

        if (!$progja) {
            return redirect()->to('ormawa/proposal')->with('error', 'Progja tidak ditemukan.');
        }

        if ($progja['status'] !== 'approved') {
            return redirect()->to('ormawa/proposal')
                ->with('error', 'Progja belum disetujui Wadir.');
        }

        // Cek apakah sudah ada proposal
        $existing = $this->proposalModel->getByProgja($id_progja);
        $is_revision = false;

        if ($existing) {
            $statuses = [$existing['status_ketua'], $existing['status_pembina'], $existing['status_wadir']];
            // Jika ditolak, izinkan revisi
            if (in_array('rejected', $statuses)) {
                $is_revision = true;
            } else {
                // Jika masih pending atau sudah approved, lempar ke detail
                return redirect()->to('ormawa/proposal/detail/' . $existing['id_proposal']);
            }
        }

        return view('ormawa/proposal/isi', [
            'title'       => $is_revision ? 'Revisi Proposal' : 'Upload Proposal',
            'progja'      => $progja,
            'proposal'    => $existing,
            'is_revision' => $is_revision,
        ]);
    }

        // Simpan proposal baru atau update revisi
        // Simpan proposal baru atau update revisi
    public function simpan()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $id_progja = (int) $this->request->getPost('id_progja');

        $progja = $this->progjaModel
            ->where('id_progja', $id_progja)
            ->where('id_ormawa', $id_ormawa)
            ->first();

        if (!$progja) {
            return redirect()->to('ormawa/proposal')->with('error', 'Progja tidak ditemukan.');
        }

        $existing = $this->proposalModel->getByProgja($id_progja);
        $is_revision = false;

        if ($existing) {
            $statuses = [$existing['status_ketua'], $existing['status_pembina'], $existing['status_wadir']];
            if (!in_array('rejected', $statuses)) {
                return redirect()->to('ormawa/proposal')->with('error', 'Proposal sedang diproses atau sudah disetujui.');
            }
            $is_revision = true;
        }

        // === UPLOAD FILE PROPOSAL ===
        $file = $this->request->getFile('file_proposal');
        $namaFile = $is_revision ? $existing['file_proposal'] : null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'File proposal maksimal 5MB.');
            }
            // Hapus file lama jika revisi
            if ($is_revision && !empty($existing['file_proposal']) && file_exists('uploads/proposal/' . $existing['file_proposal'])) {
                unlink('uploads/proposal/' . $existing['file_proposal']);
            }
            $namaFile = $file->getRandomName();
            $file->move('uploads/proposal', $namaFile);
        } elseif (!$is_revision) {
            return redirect()->back()->withInput()->with('error', 'File proposal wajib diupload.');
        }

        // Rundown
        $rundownRaw = $this->request->getPost('rundown') ?? '';
        $rundownArr = array_values(array_filter(array_map('trim', explode("\n", $rundownRaw))));

        // === LOGIKA SMART REVISI ===
        // Kalau Pembina sudah approve, biarkan approve.
        // Kalau Pembina yang nolak, balikin ke pending.
        $oldPembinaStatus = $existing ? $existing['status_pembina'] : 'pending';
        $newStatusPembina = ($oldPembinaStatus === 'approved') ? 'approved' : 'pending';

        $data = [
            'id_progja'          => $id_progja,
            'id_ormawa'          => $id_ormawa,
            'file_proposal'      => $namaFile,
            'deskripsi_kegiatan' => $this->request->getPost('deskripsi_kegiatan'),
            'rundown'            => json_encode($rundownArr),
            'anggaran'           => (float) $this->request->getPost('anggaran'),
            'catatan'            => $this->request->getPost('catatan'),

            // Ketua auto-approve
            'status_ketua'        => 'approved',
            'verified_ketua_at'   => date('Y-m-d H:i:s'),
            'catatan_ketua'       => 'Auto-approved oleh pengaju.',

            // Pembina: pakai Smart Revisi
            'status_pembina'      => $newStatusPembina,
            'catatan_pembina'     => ($newStatusPembina === 'pending') ? null : $existing['catatan_pembina'],
            'verified_pembina_at' => ($newStatusPembina === 'pending') ? null : $existing['verified_pembina_at'],

            // Wadir: selalu reset ke pending
            'status_wadir'        => 'pending',
            'catatan_wadir'       => null,
            'verified_wadir_at'   => null,
        ];

        if ($is_revision) {
            $this->proposalModel->update($existing['id_proposal'], $data);
            $msg = 'Proposal berhasil direvisi dan dikirim ulang.';
        } else {
            $this->proposalModel->insert($data);
            $msg = 'Proposal berhasil dikirim. Menunggu verifikasi.';
        }

        return redirect()->to('ormawa/proposal')->with('success', $msg);
    }

    // Detail proposal
    public function detail($id_proposal)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $proposal = $this->proposalModel
            ->select('proposal.*, progja.nama_progja, progja.bulan, progja.semester')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->where('proposal.id_proposal', $id_proposal)
            ->where('proposal.id_ormawa', $id_ormawa)
            ->first();

        if (!$proposal) {
            return redirect()->to('ormawa/proposal')->with('error', 'Proposal tidak ditemukan.');
        }

        return view('ormawa/proposal/detail', [
            'title'    => 'Detail Proposal - ' . $proposal['nama_progja'],
            'proposal' => $proposal,
        ]);
    }

    // Lembar pengesahan proposal
    public function pengesahan($id_proposal)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $proposal = $this->proposalModel
            ->select('proposal.*, progja.nama_progja, progja.bulan, progja.semester, 
                      ormawa.nama_ormawa, ormawa.pembina')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = proposal.id_ormawa', 'left')
            ->where('proposal.id_proposal', $id_proposal)
            ->where('proposal.id_ormawa', $id_ormawa)
            ->first();

        if (!$proposal) {
            return redirect()->to('ormawa/proposal')->with('error', 'Proposal tidak ditemukan.');
        }

        $status = $this->proposalModel->getGlobalStatus($proposal);
        if ($status !== 'approved') {
            return redirect()->to('ormawa/proposal/detail/' . $id_proposal)
                ->with('error', 'Lembar pengesahan hanya bisa dicetak setelah semua pihak menyetujui.');
        }

        // Ambil ketua umum
        $db = \Config\Database::connect();
        $ketua = $db->table('pengurus')
            ->where('id_ormawa', $proposal['id_ormawa'])
            ->like('LOWER(jabatan)', 'ketua')
            ->orderBy('id_pengurus', 'ASC')
            ->get()->getRowArray();

        // Ambil pembina + NIP
        $pembinaData = $db->table('users')
            ->select('users.username, users.email, dosen.nip, dosen.nama_dosen')
            ->join('dosen', 'dosen.id_dosen = users.id_dosen', 'left')
            ->where('users.id_ormawa', $proposal['id_ormawa'])
            ->where('users.role', 'pembina')
            ->get()->getRowArray();

        return view('ormawa/proposal/pengesahan', [
            'title'        => 'Lembar Pengesahan Proposal',
            'proposal'     => $proposal,
            'ketua'        => $ketua,
            'pembina_data' => $pembinaData,
        ]);
    }

        // Hapus proposal
    public function hapus($id_proposal)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $proposal = $this->proposalModel->where('id_proposal', $id_proposal)->where('id_ormawa', $id_ormawa)->first();

        if (!$proposal) {
            return redirect()->to('ormawa/proposal')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Hapus file fisik dari folder uploads
        if (!empty($proposal['file_proposal']) && file_exists('uploads/proposal/' . $proposal['file_proposal'])) {
            unlink('uploads/proposal/' . $proposal['file_proposal']);
        }

        $this->proposalModel->delete($id_proposal);
        return redirect()->to('ormawa/proposal')->with('success', 'Proposal berhasil dihapus secara permanen.');
    }
}