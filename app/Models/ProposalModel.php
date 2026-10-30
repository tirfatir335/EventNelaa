<?php

namespace App\Models;

use CodeIgniter\Model;

class ProposalModel extends Model
{
    protected $table            = 'proposal';
    protected $primaryKey       = 'id_proposal';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'id_progja',
        'id_ormawa',
        'file_proposal',
        'deskripsi_kegiatan',
        'rundown',
        'anggaran',
        'catatan',
        'status_ketua',
        'status_pembina',
        'status_wadir',
        'catatan_ketua',
        'catatan_pembina',
        'catatan_wadir',
        'verified_ketua_at',
        'verified_pembina_at',
        'verified_wadir_at',
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getByProgja($id_progja)
    {
        return $this->where('id_progja', $id_progja)->first();
    }

    public function getByOrmawa($id_ormawa)
    {
        return $this->select('proposal.*, progja.nama_progja, progja.bulan, progja.semester')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->where('proposal.id_ormawa', $id_ormawa)
            ->orderBy('proposal.created_at', 'DESC')
            ->findAll();
    }

    public function getForPembina($id_ormawa)
    {
        return $this->select('proposal.*, progja.nama_progja, progja.bulan, ormawa.nama_ormawa')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = proposal.id_ormawa', 'left')
            ->where('proposal.id_ormawa', $id_ormawa)
            ->orderBy('proposal.created_at', 'DESC')
            ->findAll();
    }

    public function getForWadir()
    {
        return $this->select('proposal.*, progja.nama_progja, progja.bulan, ormawa.nama_ormawa')
            ->join('progja', 'progja.id_progja = proposal.id_progja', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = proposal.id_ormawa', 'left')
            ->orderBy('proposal.created_at', 'DESC')
            ->findAll();
    }

    public function getGlobalStatus($proposal)
    {
        $s = [
            $proposal['status_ketua']   ?? 'pending',
            $proposal['status_pembina'] ?? 'pending',
            $proposal['status_wadir']   ?? 'pending',
        ];

        if (in_array('rejected', $s)) return 'rejected';
        if ($s[0] === 'approved' && $s[1] === 'approved' && $s[2] === 'approved') return 'approved';
        return 'pending';
    }
}