<?php

namespace App\Controllers;

use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    // ==================== PUBLIK ====================
    // Halaman semua berita (publik)
    public function index()
    {
        $data = [
            'title' => 'Berita UKM & Ormawa',
            'berita' => $this->beritaModel->getPublished(),
            'current_page' => 'berita'
        ];
        return view('berita/list', $data);
    }

    // Detail berita (publik)
    public function detail($id)
    {
        $berita = $this->beritaModel->getDetail($id);
        
        if (!$berita || $berita['status'] !== 'published') {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Berita tidak ditemukan.');
        }

        // Ambil berita lain dari ormawa yang sama (sidebar)
        $beritaLain = $this->beritaModel->getPublished($berita['id_ormawa'], 5);

        return view('berita/detail', [
            'title' => $berita['judul'],
            'berita' => $berita,
            'berita_lain' => $beritaLain,
            'current_page' => 'berita'
        ]);
    }

    // ==================== ORMAWA: KELOLA ====================
    public function kelola()
    {
        if (!can_access('berita', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Kelola Berita',
            'berita' => $this->beritaModel->getByOrmawa(session()->get('id_ormawa'))
        ];
        return view('ormawa/berita/index', $data);
    }

    public function tambah()
    {
        if (!can_access('berita', 'create')) {
            return redirect()->to('ormawa/berita')->with('error', 'Akses ditolak.');
        }
        return view('ormawa/berita/tambah', ['title' => 'Tulis Berita']);
    }

    public function simpan()
    {
        if (!can_access('berita', 'create')) {
            return redirect()->to('ormawa/berita')->with('error', 'Akses ditolak.');
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/berita', $namaFoto);
        }

        $this->beritaModel->insert([
            'id_ormawa' => session()->get('id_ormawa'),
            'id_user'   => session()->get('user_id'),
            'judul'     => $this->request->getPost('judul'),
            'konten'    => $this->request->getPost('konten'),
            'foto'      => $namaFoto,
            'status'    => $this->request->getPost('status') ?? 'draft'
        ]);

        return redirect()->to('ormawa/berita')->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!can_access('berita', 'edit')) {
            return redirect()->to('ormawa/berita')->with('error', 'Akses ditolak.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita || $berita['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/berita')->with('error', 'Data tidak ditemukan.');
        }

        return view('ormawa/berita/edit', [
            'title' => 'Edit Berita',
            'berita' => $berita
        ]);
    }

    public function update($id)
    {
        if (!can_access('berita', 'edit')) {
            return redirect()->to('ormawa/berita')->with('error', 'Akses ditolak.');
        }

        $berita = $this->beritaModel->find($id);
        if (!$berita || $berita['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/berita')->with('error', 'Akses ditolak.');
        }

        $data = [
            'judul'  => $this->request->getPost('judul'),
            'konten' => $this->request->getPost('konten'),
            'status' => $this->request->getPost('status')
        ];

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($berita['foto']) && file_exists('uploads/berita/' . $berita['foto'])) {
                unlink('uploads/berita/' . $berita['foto']);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move('uploads/berita', $namaFoto);
            $data['foto'] = $namaFoto;
        }

        $this->beritaModel->update($id, $data);

        return redirect()->to('ormawa/berita')->with('success', 'Berita berhasil diperbarui.');
    }

    public function hapus($id)
    {
        if (!can_access('berita', 'delete')) {
            return redirect()->to('ormawa/berita')->with('error', 'Akses ditolak.');
        }

        $berita = $this->beritaModel->find($id);
        if ($berita && $berita['id_ormawa'] == session()->get('id_ormawa')) {
            if (!empty($berita['foto']) && file_exists('uploads/berita/' . $berita['foto'])) {
                unlink('uploads/berita/' . $berita['foto']);
            }
            $this->beritaModel->delete($id);
        }

        return redirect()->to('ormawa/berita')->with('success', 'Berita berhasil dihapus.');
    }
}