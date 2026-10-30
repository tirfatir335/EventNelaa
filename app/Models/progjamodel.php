<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgjaModel extends Model
{
    protected $table            = 'progja';
    protected $primaryKey       = 'id_progja';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_ormawa',
        'semester',
        'bulan',
        'nama_progja',
        'target_peserta',
        'deskripsi',
        'foto',
        'status',
        'catatan_validator',
        'validated_by',
        'validated_at',
    ];
    protected $useTimestamps = false;

    // List propja per ormawa
    public function getByOrmawa($id_ormawa)
    {
        return $this->where('id_ormawa', $id_ormawa)
            ->orderBy('bulan', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    // List propja + info proposal (untuk halaman validator)
    public function getForValidator($filter = null)
    {
        $builder = $this->select('progja.*, ormawa.nama_ormawa, ormawa.logo AS ormawa_logo, 
                                  proposal.id_proposal, 
                                  proposal.status_ketua, 
                                  proposal.status_pembina, 
                                  proposal.status_wadir')
            ->join('ormawa', 'ormawa.id_ormawa = progja.id_ormawa', 'left')
            ->join('proposal', 'proposal.id_progja = progja.id_progja', 'left')
            ->orderBy('progja.created_at', 'DESC');

        if ($filter === 'pending') {
            $builder->where('progja.status', 'pending');
        } elseif ($filter === 'approved') {
            $builder->where('progja.status', 'approved');
        }

        return $builder->findAll();
    }

    // Statistik per ormawa (buat dashboard Wadir)
    public function getStatistikPerOrmawa()
    {
        $db = \Config\Database::connect();

        return $db->query("
            SELECT 
                o.id_ormawa,
                o.nama_ormawa,
                o.logo,
                COUNT(p.id_progja) AS total_progja,
                SUM(CASE WHEN p.status = 'pending' THEN 1 ELSE 0 END) AS pending,
                SUM(CASE WHEN p.status = 'approved' THEN 1 ELSE 0 END) AS approved,
                SUM(CASE WHEN p.status = 'rejected' THEN 1 ELSE 0 END) AS rejected,
                SUM(CASE WHEN pr.id_proposal IS NOT NULL THEN 1 ELSE 0 END) AS total_proposal,
                SUM(CASE WHEN r.id_report IS NOT NULL THEN 1 ELSE 0 END) AS total_report
            FROM ormawa o
            LEFT JOIN progja p ON p.id_ormawa = o.id_ormawa
            LEFT JOIN proposal pr ON pr.id_progja = p.id_progja
            LEFT JOIN report r ON r.id_event = p.id_event
            WHERE o.status = 'Aktif'
            GROUP BY o.id_ormawa
            ORDER BY total_progja DESC
        ")->getResultArray();
    }
}