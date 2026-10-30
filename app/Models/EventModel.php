<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table      = 'events';
    protected $primaryKey = 'id_event';

    protected $allowedFields = [
        // Kolom lama
        'id_ormawa',
        'nama_event',
        'poster',
        'deskripsi',
        'tanggal',
        'waktu',
        'gedung',
        'status',
        'catatan_penolakan',
        'validated_by',
        'approved_by',
        'rating_avg',
        'jumlah_ulasan',
        'id_dosen',
        'id_gedung',

        // Kolom baru (RAB)
        'peserta_tipe',
        'peserta_jumlah',
        'durasi_hari',
        'konsumsi_tipe',
        'konsumsi_per_orang',
        'biaya_lain',
        'total_biaya',
        'rundown',
    ];

    protected $useTimestamps = true;
}