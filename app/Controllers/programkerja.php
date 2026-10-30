<?php

namespace App\Controllers;

use App\Models\ProgjaModel;

class ProgramKerja extends BaseController
{
    protected $progjaModel;

    public function __construct()
    {
        $this->progjaModel = new ProgjaModel();
    }

    // ===== INDEX =====
    public function index()
    {
        if (!can_access('progja', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $progjaModel = new \App\Models\ProgjaModel();
        $proposalModel = new \App\Models\ProposalModel();

        $id_ormawa = session()->get('id_ormawa');
        $list = $progjaModel->where('id_ormawa', $id_ormawa)
            ->orderBy('bulan', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Ambil info proposal per propja
        foreach ($list as &$p) {
            $p['proposal'] = $proposalModel->getByProgja($p['id_progja']);
        }
        unset($p);

        return view('ormawa/progja/index', [
            'title'  => 'Program Kerja',
            'progja' => $list,
        ]);
    }

    // ===== TAMBAH =====
    public function tambah()
    {
        if (!can_access('progja', 'create')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        return view('ormawa/progja/tambah', ['title' => 'Tambah Progja']);
    }

    // ===== SIMPAN =====
    public function simpan()
    {
        if (!can_access('progja', 'create')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/progja', $namaFoto);
        }

        $this->progjaModel->insert([
            'id_ormawa'      => session()->get('id_ormawa'),
            'semester'       => $this->request->getPost('semester'),
            'bulan'          => (int) $this->request->getPost('bulan'),
            'nama_progja'    => $this->request->getPost('nama_progja'),
            'target_peserta' => $this->request->getPost('target_peserta'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'foto'           => $namaFoto,
            'status'         => 'draft',
        ]);

        return redirect()->to('ormawa/program-kerja')->with('success', 'Program Kerja berhasil ditambahkan.');
    }

    // ===== EDIT =====
    public function edit($id)
    {
        if (!can_access('progja', 'edit')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        $progja = $this->progjaModel->find($id);
        if (!$progja || $progja['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Data tidak ditemukan.');
        }

        return view('ormawa/progja/edit', ['title' => 'Edit Progja', 'progja' => $progja]);
    }

    // ===== UPDATE =====
    public function update($id)
    {
        if (!can_access('progja', 'edit')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        $progja = $this->progjaModel->find($id);
        if (!$progja || $progja['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        $data = [
            'semester'       => $this->request->getPost('semester'),
            'bulan'          => (int) $this->request->getPost('bulan'),
            'nama_progja'    => $this->request->getPost('nama_progja'),
            'target_peserta' => $this->request->getPost('target_peserta'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
        ];

        // Kalau di-reject dan diedit, status kembali ke draft
        if ($progja['status'] === 'rejected') {
            $data['status'] = 'draft';
            $data['catatan_validator'] = null;
        }

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($progja['foto']) && file_exists('uploads/progja/' . $progja['foto'])) {
                unlink('uploads/progja/' . $progja['foto']);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/progja', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->progjaModel->update($id, $data);

        return redirect()->to('ormawa/program-kerja')->with('success', 'Program Kerja berhasil diperbarui.');
    }

    // ===== AJUKAN KE WADIR =====
    public function ajukan($id)
    {
        if (!can_access('progja', 'edit')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        $progja = $this->progjaModel->find($id);
        if (!$progja || $progja['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        if (!in_array($progja['status'], ['draft', 'rejected'])) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Progja ini sudah diajukan.');
        }

        $this->progjaModel->update($id, [
            'status' => 'pending',
            'catatan_validator' => null,
        ]);

        return redirect()->to('ormawa/program-kerja')
            ->with('success', 'Progja berhasil diajukan ke Wadir. Menunggu validasi.');
    }

    // ===== HAPUS =====
    public function hapus($id)
    {
        if (!can_access('progja', 'delete')) {
            return redirect()->to('ormawa/program-kerja')->with('error', 'Akses ditolak.');
        }

        $progja = $this->progjaModel->find($id);
        if ($progja && $progja['id_ormawa'] == session()->get('id_ormawa')) {
            if (!empty($progja['foto']) && file_exists('uploads/progja/' . $progja['foto'])) {
                unlink('uploads/progja/' . $progja['foto']);
            }
            $this->progjaModel->delete($id);
        }

        return redirect()->to('ormawa/program-kerja')->with('success', 'Data berhasil dihapus.');
    }
}