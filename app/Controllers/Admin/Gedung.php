<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GedungModel;

class Gedung extends BaseController
{
    protected $gedung;

    public function __construct()
    {
        $this->gedung = new GedungModel();
    }

    public function index()
{
    return view('admin/gedung/index', [
        'title'  => 'Data Gedung',
        'gedung' => $this->gedung->findAll()
    ]);
}

    public function tambah()
    {
        return view('admin/gedung/tambah', [
            'title' => 'Tambah Gedung'
        ]);
    }

    public function simpan()
    {
        $this->gedung->insert([
            'nama_gedung' => $this->request->getPost('nama_gedung')
        ]);

        return redirect()->to(base_url('admin/gedung'));
    }

    public function edit($id)
{
    return view('admin/gedung/edit', [
        'title' => 'Edit Gedung',
        'gedung' => $this->gedung->find($id)
    ]);
}

    public function update($id)
    {
        $this->gedung->update($id, [
            'nama_gedung' => $this->request->getPost('nama_gedung')
        ]);

        return redirect()->to(base_url('admin/gedung'));
    }

    public function hapus($id)
    {
        $this->gedung->delete($id);
        return redirect()->back();
    }
}
