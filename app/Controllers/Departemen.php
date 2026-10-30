<?php

namespace App\Controllers;

use App\Models\DepartemenModel;

class Departemen extends BaseController
{
    protected $departemenModel;

    public function __construct()
    {
        $this->departemenModel = new DepartemenModel();
    }

    public function index()
    {
        if (!can_access('departemen', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Departemen / Divisi',
            'departemen' => $this->departemenModel->getByOrmawa(session()->get('id_ormawa'))
        ];
        return view('ormawa/departemen/index', $data);
    }

    public function tambah()
    {
        if (!can_access('departemen', 'create')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Akses ditolak.');
        }
        return view('ormawa/departemen/tambah', ['title' => 'Tambah Departemen']);
    }

    public function simpan()
    {
        if (!can_access('departemen', 'create')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Akses ditolak.');
        }

        $this->departemenModel->insert([
    'id_ormawa'       => session()->get('id_ormawa'),
    'nama_departemen' => $this->request->getPost('nama_departemen'),
    'ikon'            => $this->request->getPost('ikon') ?: null,
    'warna'           => $this->request->getPost('warna') ?: null,
    'deskripsi'       => $this->request->getPost('deskripsi'),
]);

        return redirect()->to('ormawa/departemen')->with('success', 'Departemen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!can_access('departemen', 'edit')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Akses ditolak.');
        }

        $departemen = $this->departemenModel->find($id);
        if (!$departemen || $departemen['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Data tidak ditemukan.');
        }
        return view('ormawa/departemen/edit', ['title' => 'Edit Departemen', 'departemen' => $departemen]);
    }

    public function update($id)
    {
        if (!can_access('departemen', 'edit')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Akses ditolak.');
        }

        $departemen = $this->departemenModel->find($id);
        if (!$departemen || $departemen['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Akses ditolak.');
        }

        $this->departemenModel->update($id, [
    'nama_departemen' => $this->request->getPost('nama_departemen'),
    'ikon'            => $this->request->getPost('ikon') ?: null,
    'warna'           => $this->request->getPost('warna') ?: null,
    'deskripsi'       => $this->request->getPost('deskripsi'),
]);

        return redirect()->to('ormawa/departemen')->with('success', 'Departemen berhasil diperbarui.');
    }

    public function hapus($id)
    {
        if (!can_access('departemen', 'delete')) {
            return redirect()->to('ormawa/departemen')->with('error', 'Akses ditolak.');
        }

        $departemen = $this->departemenModel->find($id);
        if ($departemen && $departemen['id_ormawa'] == session()->get('id_ormawa')) {
            $this->departemenModel->delete($id);
        }
        return redirect()->to('ormawa/departemen')->with('success', 'Data berhasil dihapus.');
    }
}