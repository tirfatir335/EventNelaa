<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'report';
    protected $primaryKey       = 'id_report';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'id_event',
        'id_ormawa',
        'laporan_file',
        'keuangan_link',
        'bukti_link',
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

    public function getByEvent($id_event)
    {
        return $this->where('id_event', $id_event)->first();
    }

    public function getByOrmawa($id_ormawa)
    {
        return $this->select('report.*, events.nama_event, events.tanggal, events.poster, events.gedung')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->where('report.id_ormawa', $id_ormawa)
            ->orderBy('report.created_at', 'DESC')
            ->findAll();
    }

    public function getForPembina($id_ormawa)
    {
        return $this->select('report.*, events.nama_event, events.tanggal, ormawa.nama_ormawa')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = report.id_ormawa', 'left')
            ->where('report.id_ormawa', $id_ormawa)
            ->orderBy('report.created_at', 'DESC')
            ->findAll();
    }

    public function getForWadir()
    {
        return $this->select('report.*, events.nama_event, events.tanggal, ormawa.nama_ormawa')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = report.id_ormawa', 'left')
            ->where('report.status_ketua', 'approved')
            ->where('report.status_pembina', 'approved')
            ->orderBy('report.created_at', 'DESC')
            ->findAll();
    }

    public function getGlobalStatus($report)
    {
        $s = [
            $report['status_ketua']   ?? 'pending',
            $report['status_pembina'] ?? 'pending',
            $report['status_wadir']   ?? 'pending',
        ];

        if (in_array('rejected', $s)) {
            return 'rejected';
        }
        if ($s[0] === 'approved' && $s[1] === 'approved' && $s[2] === 'approved') {
            return 'approved';
        }
        return 'pending';
    }

    /**
     * Event yang butuh isi report:
     * Published + tanggal <= hari ini + belum ada report
     */
    public function getEventBelumReport($id_ormawa)
    {
        $db = \Config\Database::connect();
        $hariIni = date('Y-m-d');

        $sql = "
            SELECT e.*
            FROM events e
            LEFT JOIN report r ON r.id_event = e.id_event
            WHERE e.id_ormawa = ?
              AND e.status = 'Published'
              AND e.tanggal <= ?
              AND r.id_report IS NULL
            ORDER BY e.tanggal DESC
        ";

        return $db->query($sql, [$id_ormawa, $hariIni])->getResultArray();
    }
}