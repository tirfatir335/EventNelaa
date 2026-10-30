<?php

namespace App\Controllers;

use App\Models\EventModel;
use App\Models\GedungModel;

class KegiatanOrmawa extends BaseController
{
    protected $eventModel;
    protected $gedungModel;

    public function __construct()
    {
        $this->eventModel  = new EventModel();
        $this->gedungModel = new GedungModel();
    }

    // ===== INDEX =====
    public function index()
    {
        if (!can_access('event', 'view')) {
            return redirect()->to('ormawa/dashboard')->with('error', 'Akses ditolak.');
        }

        $id_ormawa = session()->get('id_ormawa');

        $events = $this->eventModel
            ->where('id_ormawa', $id_ormawa)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        $statistikPerTahun  = [];
        $statistikPerBulan  = [];
        $statistikPerMinggu = [];

        foreach ($events as $e) {
            $ts = strtotime($e['tanggal']);
            if (!$ts) continue;

            $tahun  = (int) date('Y', $ts);
            $bulan  = (int) date('n', $ts);
            $minggu = (int) date('W', $ts);

            if (!isset($statistikPerTahun[$tahun])) {
                $statistikPerTahun[$tahun] = [
                    'tahun'     => $tahun,
                    'total'     => 0,
                    'published' => 0,
                    'pending'   => 0,
                    'rejected'  => 0,
                ];
            }
            $statistikPerTahun[$tahun]['total']++;

            $status = $e['status'];
            if ($status === 'Published') {
                $statistikPerTahun[$tahun]['published']++;
            } elseif (in_array($status, ['Pending Admin', 'Pending Validator'])) {
                $statistikPerTahun[$tahun]['pending']++;
            } elseif (in_array($status, ['Rejected Admin', 'Rejected Validator'])) {
                $statistikPerTahun[$tahun]['rejected']++;
            }

            if (!isset($statistikPerBulan[$tahun][$bulan])) {
                $statistikPerBulan[$tahun][$bulan] = 0;
            }
            $statistikPerBulan[$tahun][$bulan]++;

            if (!isset($statistikPerMinggu[$tahun][$minggu])) {
                $statistikPerMinggu[$tahun][$minggu] = 0;
            }
            $statistikPerMinggu[$tahun][$minggu]++;
        }

        ksort($statistikPerTahun);
        $statistikPerTahun = array_values($statistikPerTahun);

        if (empty($statistikPerTahun)) {
            $statistikPerTahun = [[
                'tahun'     => (int) date('Y'),
                'total'     => 0,
                'published' => 0,
                'pending'   => 0,
                'rejected'  => 0,
            ]];
        }

        $totalEvent     = count($events);
        $totalPublished = count(array_filter($events, fn($e) => $e['status'] === 'Published'));
        $totalPending   = count(array_filter($events, fn($e) => in_array($e['status'], ['Pending Admin', 'Pending Validator'])));
        $totalRejected  = count(array_filter($events, fn($e) => in_array($e['status'], ['Rejected Admin', 'Rejected Validator'])));

        return view('ormawa/kegiatan/index', [
            'title'              => 'Daftar Kegiatan',
            'events'             => $events,
            'gedung'             => $this->gedungModel->findAll(),
            'statistikPerTahun'  => $statistikPerTahun,
            'statistikPerBulan'  => $statistikPerBulan,
            'statistikPerMinggu' => $statistikPerMinggu,
            'total_event'        => $totalEvent,
            'total_published'    => $totalPublished,
            'total_pending'      => $totalPending,
            'total_rejected'     => $totalRejected,
        ]);
    }

    // ===== AI EVENT GENERATOR (mode lama - tetap ada) =====
    public function generateAI()
    {
        if (!can_access('event', 'create')) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Akses ditolak.'
            ]);
        }

        $konsep   = trim($this->request->getPost('konsep') ?? '');
        $feedback = trim($this->request->getPost('feedback') ?? '');
        $previous = $this->request->getPost('previous');

        $previousData = null;
        if (!empty($previous)) {
            $previousData = json_decode($previous, true);
        }

        if (empty($konsep) && !$previousData) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Konsep event harus diisi.'
            ]);
        }

        if ($previousData && empty($feedback)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Feedback revisi harus diisi.'
            ]);
        }

        $ai = new \App\Services\AIService();
        $hasil = $ai->rekomendasiEvent($konsep, $previousData, $feedback);

        return $this->response->setJSON($hasil);
    }

    // ===== TAMBAH (form manual + auto-fill dari AI) =====
    public function tambah()
    {
        if (!can_access('event', 'create')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        return view('ormawa/kegiatan/tambah', [
            'gedung'    => $this->gedungModel->findAll(),
            'dipakai'   => [],
            'ai_result' => session()->get('ai_result'),
        ]);
    }

    // ============================================================
    // HALAMAN GENERATE AI (CHATBOT)
    // ============================================================
    public function generateAIPage()
    {
        if (!can_access('event', 'create')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        return view('ormawa/kegiatan/generate_ai', [
            'title'  => 'Generate Event dengan AI',
            'gedung' => $this->gedungModel->findAll(),
        ]);
    }

    // ============================================================
    // PROSES AI — (mode lama, wizard 7 pertanyaan)
    // ============================================================
    public function prosesAI()
    {
        if (!can_access('event', 'create')) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Akses ditolak.'
            ]);
        }

        $dataUser = [
            'konsep'             => trim($this->request->getPost('konsep') ?? ''),
            'peserta_tipe'       => trim($this->request->getPost('peserta_tipe') ?? ''),
            'peserta_jumlah'     => (int) $this->request->getPost('peserta_jumlah'),
            'durasi_hari'        => (int) $this->request->getPost('durasi_hari'),
            'konsumsi_tipe'      => trim($this->request->getPost('konsumsi_tipe') ?? ''),
            'konsumsi_per_orang' => (float) $this->request->getPost('konsumsi_per_orang'),
            'biaya_lain'         => (float) $this->request->getPost('biaya_lain'),
        ];

        if (empty($dataUser['konsep'])) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data belum lengkap.'
            ]);
        }

        $ai = new \App\Services\AIService();
        $hasil = $ai->generateEventLengkap($dataUser);

        return $this->response->setJSON($hasil);
    }

              // ============================================================
    // CHAT AI — chatbot bebas, output form_data (IB-Center)
    // ============================================================
    public function chatAi()
    {
        set_time_limit(180);
        ini_set('memory_limit', '256M');

        $body    = $this->request->getJSON(true);
        $history = $body['history'] ?? [];

        if (empty($history)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'History kosong.'
            ]);
        }

        // Trim history: max 12 pesan terakhir
        if (count($history) > 12) {
            $history = array_slice($history, -12);
        }

        // Config AI
        $apiKey  = env('AI_API_KEY');
        $baseUrl = rtrim(env('AI_BASE_URL', 'https://omni.ib-center.com/v1'), '/');
        $model   = env('AI_MODEL', 'bansos.v1.prodi.mi');

        if (!$apiKey) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'AI_API_KEY belum di-set di .env'
            ]);
        }

        // Konteks gedung
        $gedungList = $this->gedungModel->findAll();
        $gedungText = implode(', ', array_column($gedungList, 'nama_gedung'));

        // Konteks tanggal
        $hariIni       = date('Y-m-d');
        $hariIniIndo   = date('d F Y');
        $default14     = date('Y-m-d', strtotime('+14 days'));
        $default14Indo = date('d F Y', strtotime('+14 days'));

        $systemPrompt = <<<PROMPT
Kamu EventNela AI, konsultan perencanaan event kampus untuk organisasi mahasiswa Politeknik Negeri Lampung.

═══ TUGAS ═══
Ngobrol santai dengan user untuk mengumpulkan data event, SATU pertanyaan per balasan.

═══ DATA YANG WAJIB DIKUMPULKAN ═══
1.  nama_event         (string)
2.  tanggal            (YYYY-MM-DD, masa depan)
3.  waktu              (HH:MM 24 jam)
4.  gedung             (WAJIB dari daftar: {$gedungText})
5.  deskripsi          (2-4 kalimat)
6.  peserta_tipe       (Mahasiswa Internal / Mahasiswa + Dosen / Umum / Eksternal)
7.  peserta_jumlah     (angka)
8.  durasi_hari        (angka)
9.  konsumsi_tipe      (Tanpa Konsumsi / Snack Saja / Snack + Makan Siang)
10. konsumsi_per_orang (angka rupiah)
11. biaya_lain         (angka rupiah, isi 0 kalau tidak ada)
12. rundown            (array: ["08:00 - Pembukaan", ...])

═══ ATURAN KERAS ═══
1. HARI INI: {$hariIniIndo} ({$hariIni}).
   Default tanggal kalau user bingung: {$default14Indo} ({$default14}).

2. **JANGAN TANYA ULANG** hal yang sudah dijawab di history percakapan.
   BACA history dengan teliti!

3. Tanya SATU hal yang BELUM ada di history. Kalau user udah jawab nama event, 
   jangan tanya nama event lagi.

4. MODE REVISI: kalau status sudah "ready" dan user minta revisi, UPDATE form_data 
   dan balas status "ready" lagi dengan form_data LENGKAP.

5. Kalau user bilang "oke"/"lanjut" saat status "ready", balas form_data yang sama.

═══ FORMAT OUTPUT — WAJIB JSON VALID ═══

Kalau data MASIH KURANG:
{"status":"asking","reply":"pertanyaan SINGKAT ke user"}

Kalau data SUDAH LENGKAP:
{"status":"ready","reply":"konfirmasi","form_data":{"nama_event":"...","tanggal":"YYYY-MM-DD","waktu":"HH:MM","gedung":"...","deskripsi":"...","peserta_tipe":"...","peserta_jumlah":0,"durasi_hari":0,"konsumsi_tipe":"...","konsumsi_per_orang":0,"biaya_lain":0,"rundown":["08:00 - Pembukaan"]}}

═══ CONTOH BENAR ═══
{"status":"asking","reply":"Tanggal berapa eventnya?"}

═══ CONTOH SALAH (JANGAN!) ═══
Oke, seminar ya! Tanggal berapa?
{"status":"asking",...} di luar JSON

PENTING:
- Balasanmu WAJIB JSON valid. TIDAK BOLEH ada teks di luar JSON.
- JANGAN bungkus dengan markdown apapun.
- Bahasa Indonesia santai, boleh emoji secukupnya (max 3).
- GEDUNG wajib dari daftar: {$gedungText}
PROMPT;

        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $history
        );

        $payload = [
            'model'       => $model,
            'messages'    => $messages,
            'temperature' => 0.2,
            'max_tokens'  => 800,
        ];

        $ch = curl_init($baseUrl . '/chat/completions');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT        => 90,
        ]);

        $startTime = microtime(true);
        $res       = curl_exec($ch);
        $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err       = curl_error($ch);
        $elapsed   = round(microtime(true) - $startTime, 2);
        curl_close($ch);

        log_message('debug', "ChatAI selesai {$elapsed}s — HTTP {$httpCode} — err: {$err}");

        if ($err) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'AI timeout / koneksi gagal. Coba kirim ulang pesanmu.'
            ]);
        }

        if ($httpCode !== 200) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'AI error HTTP ' . $httpCode . '. Coba lagi.'
            ]);
        }

        $json    = json_decode($res, true);
        $content = $json['choices'][0]['message']['content'] ?? '';

        if (empty($content)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'AI tidak memberikan respons. Coba lagi.'
            ]);
        }

        // ══════════════════════════════════════════════════
        // PARSING — Handle teks, code fence, JSON bocor, dll
        // ══════════════════════════════════════════════════

        // 1. Hapus code fence markdown
        $clean = preg_replace('/```(?:json)?\s*|\s*```/', '', $content);
        $clean = trim($clean);

        // 2. Cari JSON paling luar
        if (preg_match('/\{[\s\S]*\}/', $clean, $matches)) {
            $clean = $matches[0];
        }

        $parsed = json_decode($clean, true);

        // 3. FALLBACK 1: decode dari content asli kalau $clean gagal
        if (!is_array($parsed) || empty($parsed['status'])) {
            if (preg_match('/\{[\s\S]*"status"[\s\S]*\}/', $content, $m)) {
                $retry = json_decode($m[0], true);
                if (is_array($retry) && !empty($retry['status'])) {
                    $parsed = $retry;
                }
            }
        }

        // 4. FALLBACK 2: kalau reply-nya sendiri berisi JSON (nested)
        if (is_array($parsed) && isset($parsed['reply']) && is_string($parsed['reply'])) {
            $replyTrim = trim($parsed['reply']);
            if (str_starts_with($replyTrim, '{')) {
                $inner = json_decode($replyTrim, true);
                if (is_array($inner) && !empty($inner['reply'])) {
                    $parsed['reply'] = $inner['reply'];
                    if (!empty($inner['status'])) {
                        $parsed['status'] = $inner['status'];
                    }
                    if (!empty($inner['form_data'])) {
                        $parsed['form_data'] = $inner['form_data'];
                    }
                }
            }
        }

        // 5. FALLBACK 3: kalau masih bukan JSON valid → treat sebagai asking
        if (!is_array($parsed) || empty($parsed['status'])) {
            $parsed = [
                'status' => 'asking',
                'reply'  => trim(strip_tags($content))
            ];
        }

        // 6. Pastikan reply gak kosong
        if (empty($parsed['reply'])) {
            $parsed['reply'] = 'Oke, lanjut. Ada info lain?';
        }

        // 7. Simpan ke session kalau ready
        if (($parsed['status'] ?? '') === 'ready' && !empty($parsed['form_data'])) {
            session()->set('ai_result', $parsed['form_data']);
            session()->set('ai_result_ts', time());
        }

        return $this->response->setJSON($parsed);
    }

    // ===== SIMPAN =====
    public function simpan()
    {
        if (!can_access('event', 'create')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        $tanggal = $this->request->getPost('tanggal');
        $waktu   = $this->request->getPost('waktu');
        $gedung  = $this->request->getPost('gedung');

        if ($gedung === 'lainnya') {
            $gedung = $this->request->getPost('gedung_lainnya');
        }
        $gedung = $this->normalisasiGedung($gedung);

        $cek = $this->eventModel
            ->where('tanggal', $tanggal)
            ->where('waktu', $waktu)
            ->where('UPPER(TRIM(gedung))', $gedung)
            ->whereIn('status', ['Pending Admin', 'Pending Validator', 'Published'])
            ->first();

        if ($cek) {
            $statusText = 'sedang diajukan';
            if ($cek['status'] === 'Published') {
                $statusText = 'sudah terjadwal';
            } elseif ($cek['status'] === 'Pending Validator') {
                $statusText = 'sedang menunggu validasi';
            }

            return redirect()->back()->withInput()
                ->with('error',
                    'Gedung ' . $gedung . ' pada tanggal ' .
                    date('d M Y', strtotime($tanggal)) .
                    ' jam ' . $waktu . ' ' . $statusText .
                    ' oleh ormawa lain. Silakan pilih waktu/gedung lain.'
                );
        }

        $file = $this->request->getFile('poster');

        if (!$file || !$file->isValid()) {
            return redirect()->back()->withInput()
                ->with('error', 'Poster wajib diupload');
        }

        $poster = $file->getRandomName();
        $file->move('uploads/poster', $poster);

        $pesertaJumlah    = (int) $this->request->getPost('peserta_jumlah');
        $konsumsiPerOrang = (float) $this->request->getPost('konsumsi_per_orang');
        $durasiHari       = (int) $this->request->getPost('durasi_hari');
        $biayaLain        = (float) $this->request->getPost('biaya_lain');
        $totalBiaya       = ($pesertaJumlah * $konsumsiPerOrang * $durasiHari) + $biayaLain;

        $rundownRaw = $this->request->getPost('rundown') ?? '';
        $rundownArr = array_values(array_filter(array_map('trim', explode("\n", $rundownRaw))));

        $this->eventModel->insert([
            'id_ormawa'          => session()->get('id_ormawa'),
            'nama_event'         => $this->request->getPost('nama_event'),
            'tanggal'            => $tanggal,
            'waktu'              => $waktu,
            'gedung'             => $gedung,
            'deskripsi'          => $this->request->getPost('deskripsi'),
            'poster'             => $poster,
            'status'             => 'Pending Admin',
            'peserta_tipe'       => $this->request->getPost('peserta_tipe'),
            'peserta_jumlah'     => $pesertaJumlah,
            'durasi_hari'        => $durasiHari,
            'konsumsi_tipe'      => $this->request->getPost('konsumsi_tipe'),
            'konsumsi_per_orang' => $konsumsiPerOrang,
            'biaya_lain'         => $biayaLain,
            'total_biaya'        => $totalBiaya,
            'rundown'            => json_encode($rundownArr),
        ]);

        // Bersihkan data AI setelah berhasil simpan
        session()->remove('ai_result');
        session()->remove('ai_result_ts');

        return redirect()->to('/ormawa/kegiatan')
            ->with('success', 'Kegiatan berhasil diajukan. Menunggu validasi.');
    }

    // ===== EDIT =====
    public function edit($id)
    {
        if (!can_access('event', 'edit')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        $event = $this->eventModel
            ->where('id_event', $id)
            ->where('id_ormawa', session()->get('id_ormawa'))
            ->first();

        if (!$event) {
            return redirect()->to('/ormawa/kegiatan')->with('error', 'Data kegiatan tidak ditemukan');
        }

        return view('ormawa/kegiatan/edit', [
            'title'  => 'Edit Kegiatan',
            'event'  => $event,
            'gedung' => $this->gedungModel->findAll()
        ]);
    }

    // ===== UPDATE =====
    public function update($id)
    {
        if (!can_access('event', 'edit')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        $event = $this->eventModel->find($id);
        if (!$event || $event['id_ormawa'] != session()->get('id_ormawa')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        $tanggal = $this->request->getPost('tanggal');
        $waktu   = $this->request->getPost('waktu');
        $gedung  = $this->request->getPost('gedung');

        if ($gedung === 'lainnya') {
            $gedung = $this->request->getPost('gedung_lainnya');
        }
        $gedung = $this->normalisasiGedung($gedung);

        $cek = $this->eventModel
            ->where('tanggal', $tanggal)
            ->where('waktu', $waktu)
            ->where('UPPER(TRIM(gedung))', $gedung)
            ->where('id_event !=', $id)
            ->whereIn('status', ['Pending Admin', 'Pending Validator', 'Published'])
            ->first();

        if ($cek) {
            return redirect()->back()->withInput()
                ->with('error', 'Gedung sudah dipakai pada tanggal & jam tersebut');
        }

        $poster = $event['poster'];
        $file = $this->request->getFile('poster');

        if ($file && $file->isValid()) {
            if (!empty($event['poster']) && file_exists('uploads/poster/' . $event['poster'])) {
                unlink('uploads/poster/' . $event['poster']);
            }
            $poster = $file->getRandomName();
            $file->move('uploads/poster', $poster);
        }

        $pesertaJumlah    = (int) $this->request->getPost('peserta_jumlah');
        $konsumsiPerOrang = (float) $this->request->getPost('konsumsi_per_orang');
        $durasiHari       = (int) $this->request->getPost('durasi_hari');
        $biayaLain        = (float) $this->request->getPost('biaya_lain');
        $totalBiaya       = ($pesertaJumlah * $konsumsiPerOrang * $durasiHari) + $biayaLain;

        $rundownRaw = $this->request->getPost('rundown') ?? '';
        $rundownArr = array_values(array_filter(array_map('trim', explode("\n", $rundownRaw))));

        $this->eventModel->update($id, [
            'nama_event'         => $this->request->getPost('nama_event'),
            'tanggal'            => $tanggal,
            'waktu'              => $waktu,
            'gedung'             => $gedung,
            'deskripsi'          => $this->request->getPost('deskripsi'),
            'poster'             => $poster,
            'peserta_tipe'       => $this->request->getPost('peserta_tipe'),
            'peserta_jumlah'     => $pesertaJumlah,
            'durasi_hari'        => $durasiHari,
            'konsumsi_tipe'      => $this->request->getPost('konsumsi_tipe'),
            'konsumsi_per_orang' => $konsumsiPerOrang,
            'biaya_lain'         => $biayaLain,
            'total_biaya'        => $totalBiaya,
            'rundown'            => json_encode($rundownArr),
        ]);

        return redirect()->back()->with('success', 'Event berhasil diperbarui');
    }

    // ===== DELETE =====
    public function delete($id)
    {
        if (!can_access('event', 'delete')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        $event = $this->eventModel->find($id);
        if ($event && $event['id_ormawa'] == session()->get('id_ormawa')) {
            $this->eventModel->delete($id);
        }

        return redirect()->to('/ormawa/kegiatan');
    }

    // ===== AJUKAN ULANG =====
    public function ajukan($id)
    {
        if (!can_access('event', 'edit')) {
            return redirect()->to('ormawa/kegiatan')->with('error', 'Akses ditolak.');
        }

        $event = $this->eventModel->find($id);
        if ($event && $event['id_ormawa'] == session()->get('id_ormawa')) {
            $this->eventModel->update($id, [
                'status' => 'Pending Admin'
            ]);
        }

        return redirect()->to('/ormawa/kegiatan')
            ->with('success', 'Kegiatan diajukan kembali');
    }

    // ===== CEK GEDUNG (AJAX) =====
    public function cekGedung()
    {
        $tanggal = $this->request->getGet('tanggal');
        $waktu   = $this->request->getGet('waktu');

        $builder = $this->eventModel
            ->select('UPPER(TRIM(gedung)) as gedung')
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['Pending Admin', 'Pending Validator', 'Published']);

        if (!empty($waktu)) {
            $builder->where('waktu', $waktu);
        }

        $data = $builder->findAll();

        return $this->response->setJSON(
            array_column($data, 'gedung')
        );
    }

    // ===== NORMALISASI GEDUNG =====
    private function normalisasiGedung($gedung)
    {
        $gedung = trim($gedung);
        $gedung = preg_replace('/\s+/', ' ', $gedung);
        return strtoupper($gedung);
    }
}