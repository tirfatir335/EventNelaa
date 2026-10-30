<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DosenModel;

class Dosen extends BaseController
{
    protected $dosen;

    public function __construct()
    {
        $this->dosen = new DosenModel();
    }

    public function index()
    {
        return view('admin/dosen/index', [
            'title' => 'Data Pembina',
            'dosen' => $this->dosen->findAll()
        ]);
    }

    public function tambah()
    {
        return view('admin/dosen/tambah', [
            'title' => 'Tambah Pembina'
        ]);
    }

    public function simpan()
    {
        $this->dosen->insert([
            'nip' => $this->request->getPost('nip'),
            'nama_dosen' => $this->request->getPost('nama_dosen')
        ]);

        return redirect()->to(base_url('admin/dosen'));
    }

    public function edit($id)
    {
        return view('admin/dosen/edit', [
            'title' => 'Edit Pembina',
            'row'   => $this->dosen->find($id)
        ]);
    }

    public function update($id)
    {
        $this->dosen->update($id, [
            'nip' => $this->request->getPost('nip'),
            'nama_dosen' => $this->request->getPost('nama_dosen')
        ]);

        return redirect()->to(base_url('admin/dosen'));
    }

    public function hapus($id)
    {
        $this->dosen->delete($id);
        return redirect()->back();
    }
}
