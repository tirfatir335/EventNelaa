<?php

namespace App\Controllers;

use App\Models\ReportModel;
use App\Models\EventModel;

class ReportOrmawa extends BaseController
{
    protected $reportModel;
    protected $eventModel;

    public function __construct()
    {
        $this->reportModel = new ReportModel();
        $this->eventModel  = new EventModel();
    }

    // Daftar report ormawa
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $reports     = $this->reportModel->getByOrmawa($id_ormawa);
        $belumReport = $this->reportModel->getEventBelumReport($id_ormawa);

        return view('ormawa/report/index', [
            'title'        => 'Report / LPJ',
            'reports'      => $reports,
            'belum_report' => $belumReport,
        ]);
    }

    // Form isi report
        public function isi($id_event)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $event = $this->eventModel->where('id_event', $id_event)->where('id_ormawa', $id_ormawa)->first();

        if (!$event) {
            return redirect()->to('ormawa/report')->with('error', 'Event tidak ditemukan.');
        }

        $existing = $this->reportModel->getByEvent($id_event);
        $is_revision = false;

        if ($existing) {
            $statuses = [$existing['status_ketua'], $existing['status_pembina'], $existing['status_wadir']];
            if (in_array('rejected', $statuses)) {
                $is_revision = true;
            } else {
                return redirect()->to('ormawa/report/detail/' . $existing['id_report']);
            }
        }

        return view('ormawa/report/isi', [
            'title'       => $is_revision ? 'Revisi Report' : 'Isi Report',
            'event'       => $event,
            'report'      => $existing,
            'is_revision' => $is_revision,
        ]);
    }

        // Simpan report baru atau update revisi
    public function simpan()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $id_event  = (int) $this->request->getPost('id_event');

        $event = $this->eventModel->where('id_event', $id_event)->where('id_ormawa', $id_ormawa)->first();
        if (!$event) {
            return redirect()->to('ormawa/report')->with('error', 'Event tidak ditemukan.');
        }

        $existing = $this->reportModel->getByEvent($id_event);
        $is_revision = false;

        if ($existing) {
            $statuses = [$existing['status_ketua'], $existing['status_pembina'], $existing['status_wadir']];
            if (!in_array('rejected', $statuses)) {
                return redirect()->to('ormawa/report')->with('error', 'Report sedang diproses atau sudah disetujui.');
            }
            $is_revision = true;
        }

        // Upload Laporan
        $file = $this->request->getFile('laporan_file');
        $namaFile = $is_revision ? $existing['laporan_file'] : null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($file->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()->withInput()->with('error', 'File laporan maksimal 5MB.');
            }
            if ($is_revision && !empty($existing['laporan_file']) && file_exists('uploads/report/' . $existing['laporan_file'])) {
                unlink('uploads/report/' . $existing['laporan_file']);
            }
            $namaFile = $file->getRandomName();
            $file->move('uploads/report', $namaFile);
        } elseif (!$is_revision) {
            return redirect()->back()->withInput()->with('error', 'File laporan wajib diupload.');
        }

        $keuanganLink = trim($this->request->getPost('keuangan_link') ?? '');
        $buktiLink    = trim($this->request->getPost('bukti_link') ?? '');

        if (empty($keuanganLink) || empty($buktiLink)) {
            return redirect()->back()->withInput()->with('error', 'Link keuangan dan bukti wajib diisi.');
        }

        // === LOGIKA SMART REVISI ===
        // Kalau Pembina sudah approve, biarkan approve.
        // Kalau Pembina yang nolak, balikin ke pending.
        $oldPembinaStatus = $existing ? $existing['status_pembina'] : 'pending';
        $newStatusPembina = ($oldPembinaStatus === 'approved') ? 'approved' : 'pending';

        $data = [
            'id_event'       => $id_event,
            'id_ormawa'      => $id_ormawa,
            'laporan_file'   => $namaFile,
            'keuangan_link'  => $keuanganLink,
            'bukti_link'     => $buktiLink,

            'status_ketua'        => 'approved',
            'verified_ketua_at'   => date('Y-m-d H:i:s'),
            'catatan_ketua'       => 'Auto-approved oleh pengaju.',

            // Pembina: pakai Smart Revisi
            'status_pembina'      => $newStatusPembina,
            'catatan_pembina'     => ($newStatusPembina === 'pending') ? null : $existing['catatan_pembina'],
            'verified_pembina_at' => ($newStatusPembina === 'pending') ? null : $existing['verified_pembina_at'],

            // Wadir: selalu reset ke pending
            'status_wadir'        => 'pending',
            'catatan_wadir'       => null,
            'verified_wadir_at'   => null,
        ];

        if ($is_revision) {
            $this->reportModel->update($existing['id_report'], $data);
            $msg = 'Report berhasil direvisi dan dikirim ulang.';
        } else {
            $this->reportModel->insert($data);
            $msg = 'Report berhasil dikirim. Menunggu verifikasi.';
        }

        return redirect()->to('ormawa/report')->with('success', $msg);
    }
        // Lembar pengesahan
    public function pengesahan($id_report)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');

        $report = $this->reportModel
            ->select('report.*, events.nama_event, events.tanggal, events.gedung, events.waktu, ormawa.nama_ormawa, ormawa.pembina')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = report.id_ormawa', 'left')
            ->where('report.id_report', $id_report)
            ->where('report.id_ormawa', $id_ormawa)
            ->first();

        if (!$report) {
            return redirect()->to('ormawa/report')->with('error', 'Report tidak ditemukan.');
        }

        $status = $this->reportModel->getGlobalStatus($report);
        if ($status !== 'approved') {
            return redirect()->to('ormawa/report/detail/' . $id_report)
                ->with('error', 'Lembar pengesahan hanya bisa dicetak setelah semua pihak menyetujui.');
        }

        $db = \Config\Database::connect();

        // Ambil ketua umum dari tabel pengurus
        $ketua = $db->table('pengurus')
            ->where('id_ormawa', $report['id_ormawa'])
            ->like('LOWER(jabatan)', 'ketua')
            ->orderBy('id_pengurus', 'ASC')
            ->get()->getRowArray();

        // 🔥 Ambil data pembina + NIP dari users + dosen
        $pembinaData = $db->table('users')
            ->select('users.username, users.email, dosen.nip, dosen.nama_dosen')
            ->join('dosen', 'dosen.id_dosen = users.id_dosen', 'left')
            ->where('users.id_ormawa', $report['id_ormawa'])
            ->where('users.role', 'pembina')
            ->get()->getRowArray();

        return view('ormawa/report/pengesahan', [
            'title'        => 'Lembar Pengesahan',
            'report'       => $report,
            'ketua'        => $ketua,
            'pembina_data' => $pembinaData,
        ]);
    }

        // Hapus report
    public function hapus($id_report)
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login');
        }

        $id_ormawa = session()->get('id_ormawa');
        $report = $this->reportModel->where('id_report', $id_report)->where('id_ormawa', $id_ormawa)->first();

        if (!$report) {
            return redirect()->to('ormawa/report')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        // Hapus file fisik dari folder uploads
        if (!empty($report['laporan_file']) && file_exists('uploads/report/' . $report['laporan_file'])) {
            unlink('uploads/report/' . $report['laporan_file']);
        }

        $this->reportModel->delete($id_report);
        return redirect()->to('ormawa/report')->with('success', 'Report berhasil dihapus secara permanen.');
    }
    
}