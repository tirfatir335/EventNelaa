<?php

namespace App\Controllers;

use App\Models\GaleriOrmawaModel;

class GaleriOrmawa extends BaseController
{
    protected $galeriModel;

    public function __construct()
    {
        $this->galeriModel = new GaleriOrmawaModel();
    }

    public function index()
    {
        if (!can_access('galeri', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Galeri Dokumentasi',
            'foto' => $this->galeriModel->getByOrmawa(session()->get('id_ormawa'))
        ];
        return view('ormawa/galeri_ormawa/index', $data);
    }

    public function tambah()
    {
        if (!can_access('galeri', 'create')) {
            return redirect()->to('ormawa/galeri-ormawa')->with('error', 'Akses ditolak.');
        }
        return view('ormawa/galeri_ormawa/tambah', ['title' => 'Tambah Foto']);
    }

    public function simpan()
    {
        if (!can_access('galeri', 'create')) {
            return redirect()->to('ormawa/galeri-ormawa')->with('error', 'Akses ditolak.');
        }

        $files = $this->request->getFiles();
        $uploaded = 0;

        if (!empty($files['foto'])) {
            foreach ($files['foto'] as $file) {
                if ($file->isValid() && !$file->hasMoved() && $file->getSize() < 2048000) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/galeri_ormawa', $newName);

                    $this->galeriModel->insert([
                        'id_ormawa'  => session()->get('id_ormawa'),
                        'foto'       => $newName,
                        'judul_foto' => $this->request->getPost('judul') ?? '',
                        'deskripsi'  => $this->request->getPost('deskripsi') ?? ''
                    ]);
                    $uploaded++;
                }
            }
        }

        return redirect()->to('ormawa/galeri-ormawa')->with('success', $uploaded . ' foto berhasil diupload.');
    }

    public function hapus($id_galeri)
    {
        if (!can_access('galeri', 'delete')) {
            return redirect()->to('ormawa/galeri-ormawa')->with('error', 'Akses ditolak.');
        }

        $foto = $this->galeriModel->find($id_galeri);
        if (!$foto || $foto['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->back()->with('error', 'Foto tidak ditemukan.');
        }

        if (!empty($foto['foto']) && file_exists('uploads/galeri_ormawa/' . $foto['foto'])) {
            unlink('uploads/galeri_ormawa/' . $foto['foto']);
        }

        $this->galeriModel->delete($id_galeri);
        return redirect()->back()->with('success', 'Foto berhasil dihapus.');
    }
}