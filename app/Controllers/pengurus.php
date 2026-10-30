<?php

namespace App\Controllers;

use App\Models\PengurusModel;

class Pengurus extends BaseController
{
    protected $pengurusModel;

    public function __construct()
    {
        $this->pengurusModel = new PengurusModel();
    }

    // ===== INDEX =====
    public function index()
    {
        if (!can_access('pengurus', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Pengurus',
            'pengurus' => $this->pengurusModel->getByOrmawa(session()->get('id_ormawa'))
        ];
        return view('ormawa/pengurus/index', $data);
    }

    // ===== TAMBAH =====
    public function tambah()
{
    if (!can_access('pengurus', 'create')) {
        return redirect()->to('ormawa/pengurus')->with('error', 'Akses ditolak.');
    }

    $departemenModel = new \App\Models\DepartemenModel();
    return view('ormawa/pengurus/tambah', [
        'title'      => 'Tambah Pengurus',
        'departemen' => $departemenModel->getByOrmawa(session()->get('id_ormawa')),
    ]);
}

    // ===== SIMPAN =====
    public function simpan()
    {
        if (!can_access('pengurus', 'create')) {
            return redirect()->to('ormawa/pengurus')->with('error', 'Akses ditolak.');
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/pengurus', $namaFoto);
        }

        $this->pengurusModel->insert([
    'id_ormawa'      => session()->get('id_ormawa'),
    'id_departemen'  => $this->request->getPost('id_departemen') ?: null,
    'nama'           => $this->request->getPost('nama'),
    'npm'            => $this->request->getPost('npm'),
    'jabatan'        => $this->request->getPost('jabatan'),
    'level'          => (int) $this->request->getPost('level') ?: null,
    'periode'        => $this->request->getPost('periode'),
    'foto'           => $namaFoto,
]);


        return redirect()->to('ormawa/pengurus')->with('success', 'Pengurus berhasil ditambahkan.');
    }

    // ===== EDIT =====
    public function edit($id)
{
    if (!can_access('pengurus', 'edit')) {
        return redirect()->to('ormawa/pengurus')->with('error', 'Akses ditolak.');
    }

    $pengurus = $this->pengurusModel->find($id);
    if (!$pengurus || $pengurus['id_ormawa'] != session()->get('id_ormawa')) {
        return redirect()->to('ormawa/pengurus')->with('error', 'Data tidak ditemukan.');
    }

    $departemenModel = new \App\Models\DepartemenModel();
    return view('ormawa/pengurus/edit', [
        'title'      => 'Edit Pengurus',
        'pengurus'   => $pengurus,
        'departemen' => $departemenModel->getByOrmawa(session()->get('id_ormawa')),
    ]);
}

    // ===== UPDATE =====
    public function update($id)
    {
        if (!can_access('pengurus', 'edit')) {
            return redirect()->to('ormawa/pengurus')->with('error', 'Akses ditolak.');
        }

        $pengurus = $this->pengurusModel->find($id);
        if (!$pengurus || $pengurus['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/pengurus')->with('error', 'Akses ditolak.');
        }

       $data = [
    'id_departemen' => $this->request->getPost('id_departemen') ?: null,
    'nama'          => $this->request->getPost('nama'),
    'npm'           => $this->request->getPost('npm'),
    'jabatan'       => $this->request->getPost('jabatan'),
    'level'         => (int) $this->request->getPost('level') ?: null,
    'periode'       => $this->request->getPost('periode'),
];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($pengurus['foto']) && file_exists('uploads/pengurus/' . $pengurus['foto'])) {
                unlink('uploads/pengurus/' . $pengurus['foto']);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/pengurus', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->pengurusModel->update($id, $data);
        return redirect()->to('ormawa/pengurus')->with('success', 'Pengurus berhasil diperbarui.');
    }

    // ===== HAPUS =====
    public function hapus($id)
    {
        if (!can_access('pengurus', 'delete')) {
            return redirect()->to('ormawa/pengurus')->with('error', 'Akses ditolak.');
        }

        $pengurus = $this->pengurusModel->find($id);
        if ($pengurus && $pengurus['id_ormawa'] == session()->get('id_ormawa')) {
            if (!empty($pengurus['foto']) && file_exists('uploads/pengurus/' . $pengurus['foto'])) {
                unlink('uploads/pengurus/' . $pengurus['foto']);
            }
            $this->pengurusModel->delete($id);
        }
        return redirect()->to('ormawa/pengurus')->with('success', 'Data berhasil dihapus.');
    }

    
}