<?php

namespace App\Controllers;

use App\Models\OrmawaModel;
use App\Models\EventModel;
use App\Models\ProgjaModel;
use App\Models\PengurusModel;
use App\Models\DepartemenModel;
use App\Models\GaleriOrmawaModel;

class OrmawaPublic extends BaseController
{
    protected $ormawaModel;
    protected $eventModel;
    protected $progjaModel;
    protected $pengurusModel;
    protected $departemenModel;
    protected $galeriOrmawaModel; 

    public function __construct()
    {
        $this->ormawaModel        = new OrmawaModel();
        $this->eventModel         = new EventModel();
        $this->progjaModel        = new ProgjaModel();
        $this->pengurusModel      = new PengurusModel();
        $this->departemenModel    = new DepartemenModel();
        $this->galeriOrmawaModel  = new GaleriOrmawaModel(); 
    }

    // ==================== DAFTAR SEMUA UKM ====================
    public function index()
    {
        $kategori = $this->request->getGet('kategori');

        $data = [
            'title'          => 'Daftar UKM / Ormawa Polinela',
            'ormawa_list'    => $this->ormawaModel->getByKategori($kategori),
            'kategori_aktif' => $kategori,
            'current_page'   => 'ukm'
        ];

        return view('ormawa_publik/list', $data);
    }

    // ==================== DETAIL SATU UKM ====================
                  public function detail($id)
    {
        $ormawa = $this->ormawaModel->getDetail($id);

        if (!$ormawa) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('UKM tidak ditemukan');
        }

        $galeri_ormawa = $this->galeriOrmawaModel->getByOrmawa($id);

        $events = $this->eventModel
            ->where('id_ormawa', $id)
            ->where('status', 'Published')
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        $progja = $this->progjaModel
            ->where('id_ormawa', $id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Semua pengurus, 1 list flat
        $db = \Config\Database::connect();
        $semuaPengurus = $db->table('pengurus')
            ->select('pengurus.*, departemen.nama_departemen')
            ->join('departemen', 'departemen.id_departemen = pengurus.id_departemen', 'left')
            ->where('pengurus.id_ormawa', $id)
            ->orderBy('pengurus.level', 'ASC')
            ->orderBy('pengurus.id_pengurus', 'ASC')
            ->get()->getResultArray();

        // Departemen (cuma list, tanpa anggota)
        $departemenList = $this->departemenModel
            ->where('id_ormawa', $id)
            ->orderBy('nama_departemen', 'ASC')
            ->findAll();

        return view('ormawa_publik/detail', [
            'title'           => $ormawa['nama_ormawa'],
            'ormawa'          => $ormawa,
            'events'          => $events,
            'progja'          => $progja,
            'semua_pengurus'  => $semuaPengurus,
            'departemen_list' => $departemenList,
            'galeri_ormawa'   => $galeri_ormawa,
            'current_page'    => 'ukm',
        ]);
    }
}