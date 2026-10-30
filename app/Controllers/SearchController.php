<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\OrmawaModel;
use App\Models\BeritaModel;
use App\Models\RecruitmentModel;

class SearchController extends BaseController
{
    public function index()
    {
        $q = trim($this->request->getGet('q') ?? '');
        $q = htmlspecialchars($q, ENT_QUOTES, 'UTF-8');

        $events = [];
        $ormawa = [];
        $berita = [];
        $recruitments = [];
        $total = 0;

        if (!empty($q)) {
            // Events
            $events = (new EventModel())
                ->select('events.*, ormawa.nama_ormawa, ormawa.logo as ormawa_logo')
                ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
                ->where('events.status', 'Published')
                ->groupStart()
                    ->like('events.nama_event', $q)
                    ->orLike('events.gedung', $q)
                    ->orLike('events.deskripsi', $q)
                ->groupEnd()
                ->orderBy('events.tanggal', 'DESC')
                ->limit(20)
                ->findAll();

            // Ormawa
            $ormawa = (new OrmawaModel())
                ->where('status', 'Aktif')
                ->groupStart()
                    ->like('nama_ormawa', $q)
                    ->orLike('pembina', $q)
                    ->orLike('deskripsi', $q)
                ->groupEnd()
                ->orderBy('nama_ormawa', 'ASC')
                ->limit(20)
                ->findAll();

            // Berita
            $berita = (new BeritaModel())
                ->select('berita.*, ormawa.nama_ormawa, ormawa.logo')
                ->join('ormawa', 'ormawa.id_ormawa = berita.id_ormawa', 'left')
                ->where('berita.status', 'published')
                ->groupStart()
                    ->like('berita.judul', $q)
                    ->orLike('berita.konten', $q)
                ->groupEnd()
                ->orderBy('berita.created_at', 'DESC')
                ->limit(20)
                ->findAll();

            // Recruitment
            $recruitments = (new RecruitmentModel())
                ->select('open_recruitment.*, ormawa.nama_ormawa, ormawa.logo')
                ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa', 'left')
                ->where('open_recruitment.status', 'open')
                ->groupStart()
                    ->like('open_recruitment.judul', $q)
                    ->orLike('open_recruitment.posisi', $q)
                    ->orLike('open_recruitment.deskripsi', $q)
                ->groupEnd()
                ->orderBy('open_recruitment.created_at', 'DESC')
                ->limit(20)
                ->findAll();

            $total = count($events) + count($ormawa) + count($berita) + count($recruitments);
        }

        return view('search', [
            'title'         => $q ? 'Pencarian: ' . $q : 'Pencarian',
            'q'             => $q,
            'events'        => $events,
            'ormawa'        => $ormawa,
            'berita'        => $berita,
            'recruitments'  => $recruitments,
            'total'         => $total,
        ]);
    }
}