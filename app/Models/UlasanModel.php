<?php

namespace App\Models;

use CodeIgniter\Model;

class UlasanModel extends Model
{
    protected $table            = 'ulasan_event';
    protected $primaryKey       = 'id_ulasan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_event', 'id_user', 'rating', 'komentar'];

    // Ambil semua ulasan untuk satu event (join dengan user)
    public function getByEvent($id_event)
    {
        return $this->select('ulasan_event.*, users.username, users.foto')
                    ->join('users', 'users.id = ulasan_event.id_user')
                    ->where('id_event', $id_event)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    // Hitung rata-rata rating untuk satu event
    public function getRatingAvg($id_event)
    {
        $result = $this->selectAvg('rating', 'rata')
                       ->where('id_event', $id_event)
                       ->first();
        return round($result['rata'] ?? 0, 2);
    }

    // Hitung jumlah ulasan untuk satu event
    public function getCount($id_event)
    {
        return $this->where('id_event', $id_event)->countAllResults();
    }

    // Cek apakah user sudah pernah memberi ulasan untuk event ini
    public function sudahUlas($id_event, $id_user)
    {
        return $this->where('id_event', $id_event)
                    ->where('id_user', $id_user)
                    ->countAllResults() > 0;
    }

    // Ambil ulasan user untuk event tertentu
    public function getByUserAndEvent($id_event, $id_user)
    {
        return $this->where('id_event', $id_event)
                    ->where('id_user', $id_user)
                    ->first();
    }
}