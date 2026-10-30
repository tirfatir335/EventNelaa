<?php

namespace App\Controllers;

class BackupController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        return view('validator/backup', [
            'title' => 'Backup Data',
        ]);
    }

    // ============================================================
    // BACKUP B: Rekap Data (4 CSV dalam 1 ZIP)
    // ============================================================
    public function rekapData()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        set_time_limit(300);
        ini_set('memory_limit', '512M');

        $db = \Config\Database::connect();

        // Pastikan folder ada
        $folder = WRITEPATH . 'backup';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $filename = 'Rekap_EventNela_' . date('Y-m-d_His') . '.zip';
        $tmpFile  = $folder . DIRECTORY_SEPARATOR . $filename;

        $zip = new \ZipArchive();
        if ($zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file backup.');
        }

        // 1. Events
        $events = $db->table('events')
            ->select('events.id_event, events.nama_event, ormawa.nama_ormawa, events.tanggal, events.waktu, events.gedung, events.status, events.peserta_tipe, events.peserta_jumlah, events.durasi_hari, events.konsumsi_tipe, events.konsumsi_per_orang, events.biaya_lain, events.total_biaya, events.created_at')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->orderBy('events.tanggal', 'DESC')
            ->get()->getResultArray();
        $zip->addFromString('1_daftar_event.csv', $this->arrayToCsv($events));

        // 2. Report / LPJ
        $reports = $db->table('report')
            ->select('report.id_report, events.nama_event, ormawa.nama_ormawa, events.tanggal, report.status_ketua, report.status_pembina, report.status_wadir, report.keuangan_link, report.bukti_link, report.laporan_file, report.created_at')
            ->join('events', 'events.id_event = report.id_event', 'left')
            ->join('ormawa', 'ormawa.id_ormawa = report.id_ormawa', 'left')
            ->orderBy('report.created_at', 'DESC')
            ->get()->getResultArray();
        $zip->addFromString('2_daftar_lpj.csv', $this->arrayToCsv($reports));

        // 3. Ormawa
        $ormawa = $db->table('ormawa')
            ->select('id_ormawa, nama_ormawa, kategori, pembina, status, instagram, deskripsi')
            ->orderBy('nama_ormawa', 'ASC')
            ->get()->getResultArray();
        $zip->addFromString('3_daftar_ormawa.csv', $this->arrayToCsv($ormawa));

        // 4. Pengurus
        $pengurus = $db->table('pengurus')
            ->select('pengurus.id_pengurus, ormawa.nama_ormawa, pengurus.nama, pengurus.npm, pengurus.jabatan, pengurus.periode')
            ->join('ormawa', 'ormawa.id_ormawa = pengurus.id_ormawa', 'left')
            ->orderBy('ormawa.nama_ormawa', 'ASC')
            ->get()->getResultArray();
        $zip->addFromString('4_daftar_pengurus.csv', $this->arrayToCsv($pengurus));

        // 5. Info file
        $info = "BACKUP EVENTNELA\n";
        $info .= "================\n";
        $info .= "Tanggal Backup: " . date('d F Y, H:i:s') . " WIB\n";
        $info .= "Di-backup oleh: " . session()->get('username') . "\n\n";
        $info .= "Isi file:\n";
        $info .= "- 1_daftar_event.csv    : " . count($events) . " baris\n";
        $info .= "- 2_daftar_lpj.csv      : " . count($reports) . " baris\n";
        $info .= "- 3_daftar_ormawa.csv   : " . count($ormawa) . " baris\n";
        $info .= "- 4_daftar_pengurus.csv : " . count($pengurus) . " baris\n";
        $zip->addFromString('README.txt', $info);

        $zip->close();

        return $this->response->download($tmpFile, null);
    }

    // ============================================================
    // BACKUP C: ZIP semua file di public/uploads/
    // ============================================================
    public function backupUploads()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'validator') {
            return redirect()->to('login');
        }

        set_time_limit(600);
        ini_set('memory_limit', '512M');

        $folder = WRITEPATH . 'backup';
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $filename = 'Backup_Uploads_' . date('Y-m-d_His') . '.zip';
        $tmpFile  = $folder . DIRECTORY_SEPARATOR . $filename;

        $zip = new \ZipArchive();
        if ($zip->open($tmpFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            return redirect()->back()->with('error', 'Gagal membuat file backup.');
        }

        $uploadPath = FCPATH . 'uploads';

        if (!is_dir($uploadPath)) {
            $zip->addFromString('README.txt', 'Folder uploads tidak ditemukan.');
            $zip->close();
            return $this->response->download($tmpFile, null);
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($uploadPath, \FilesystemIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        $count = 0;
        foreach ($files as $file) {
            if ($file->isFile()) {
                $filePath     = $file->getRealPath();
                $relativePath = 'uploads/' . substr($filePath, strlen($uploadPath) + 1);
                $zip->addFile($filePath, $relativePath);
                $count++;
            }
        }

        $zip->addFromString('README.txt',
            "BACKUP UPLOADS EVENTNELA\n" .
            "========================\n" .
            "Tanggal Backup: " . date('d F Y, H:i:s') . " WIB\n" .
            "Di-backup oleh: " . session()->get('username') . "\n" .
            "Total file: " . $count . " file\n"
        );

        $zip->close();

        return $this->response->download($tmpFile, null);
    }

    // ============================================================
    // Helper: array → CSV string
    // ============================================================
    private function arrayToCsv($array)
    {
        if (empty($array)) {
            return '';
        }

        $output = fopen('php://temp', 'w');

        // BOM biar Excel bisa baca UTF-8 dengan bener
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header
        fputcsv($output, array_keys($array[0]));

        // Rows
        foreach ($array as $row) {
            fputcsv($output, $row);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return $csv;
    }
}