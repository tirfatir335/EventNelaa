<?php

namespace App\Services;

use App\Models\EventModel;
use App\Models\OrmawaModel;
use App\Models\UlasanModel;

class AIService
{
    protected $apiKey;
    protected $endpoint;
    protected $model;

    public function __construct()
    {
        $this->apiKey   = env('AI_API_KEY');
        $this->endpoint = rtrim(env('AI_BASE_URL'), '/') . '/chat/completions';
        $this->model    = env('AI_MODEL');
    }


    // ═══════════════════════════════════════════════════════════
    // 1. CHATBOT — TANYA AI (untuk halaman /chatbot)
    // ═══════════════════════════════════════════════════════════
    public function tanya($pertanyaan, $history = [])
    {
        if (empty($this->apiKey)) {
            return 'API Key belum diset di file .env.';
        }

        $konteks      = $this->buildContext($pertanyaan);
        $systemPrompt = $this->buildSystemPrompt($konteks);

        return $this->callGroq($systemPrompt, $pertanyaan, $history);
    }


    // ═══════════════════════════════════════════════════════════
    // 2. CONTEXT BUILDER (untuk chatbot)
    // ═══════════════════════════════════════════════════════════
    private function buildContext($pertanyaan)
    {
        $pertanyaanLower = strtolower($pertanyaan);
        $konteks = [];
        $db = \Config\Database::connect();

        // --- DAFTAR UKM ---
        $ormawaModel  = new OrmawaModel();
        $daftarOrmawa = $ormawaModel->select('nama_ormawa, kategori, pembina')->findAll();
        $konteks[]    = "=== DAFTAR UKM/ORMAWA ===";
        if (empty($daftarOrmawa)) {
            $konteks[] = "- Belum ada UKM/Ormawa terdaftar";
        } else {
            foreach ($daftarOrmawa as $o) {
                $konteks[] = "- {$o['nama_ormawa']} ({$o['kategori']}) - Pembina: {$o['pembina']}";
            }
        }

        // --- EVENT PUBLISHED ---
        $eventModel  = new EventModel();
        $daftarEvent = $eventModel
            ->select('events.nama_event, events.rating_avg, events.jumlah_ulasan, ormawa.nama_ormawa, events.tanggal, events.gedung')
            ->join('ormawa', 'ormawa.id_ormawa = events.id_ormawa', 'left')
            ->where('events.status', 'Published')
            ->orderBy('events.rating_avg', 'DESC')
            ->limit(20)->findAll();

        $konteks[] = "\n=== DAFTAR EVENT PUBLISHED (20 teratas) ===";
        if (empty($daftarEvent)) {
            $konteks[] = "- Belum ada event dipublikasikan";
        } else {
            foreach ($daftarEvent as $e) {
                $rating    = $e['rating_avg'] ? number_format($e['rating_avg'], 1) : 'belum ada';
                $jumlah    = $e['jumlah_ulasan'] ?? 0;
                $konteks[] = "- \"{$e['nama_event']}\" oleh {$e['nama_ormawa']} | Rating: {$rating}/5 ({$jumlah} ulasan) | {$e['tanggal']} | {$e['gedung']}";
            }
        }

        // --- DAFTAR GEDUNG ---
        $daftarGedung = $db->table('gedung')
            ->select('nama_gedung')
            ->orderBy('nama_gedung', 'ASC')
            ->get()->getResultArray();

        $konteks[] = "\n=== DAFTAR GEDUNG DI POLINELA ===";
        if (empty($daftarGedung)) {
            $konteks[] = "- Belum ada data gedung";
        } else {
            foreach ($daftarGedung as $g) {
                $konteks[] = "- {$g['nama_gedung']}";
            }
        }

        // --- DAFTAR DOSEN ---
        $daftarDosen = $db->table('dosen')
            ->select('nama_dosen, nip')
            ->orderBy('nama_dosen', 'ASC')
            ->limit(30)
            ->get()->getResultArray();

        $konteks[] = "\n=== DAFTAR DOSEN PEMBINA ===";
        if (empty($daftarDosen)) {
            $konteks[] = "- Belum ada data dosen";
        } else {
            foreach ($daftarDosen as $d) {
                $konteks[] = "- {$d['nama_dosen']} (NIP: {$d['nip']})";
            }
        }

        // --- ULASAN (kalau ditanya) ---
        if (strpos($pertanyaanLower, 'ulasan') !== false
            || strpos($pertanyaanLower, 'komentar') !== false
            || strpos($pertanyaanLower, 'kekurangan') !== false
            || strpos($pertanyaanLower, 'kelebihan') !== false
            || strpos($pertanyaanLower, 'review') !== false) {

            $ulasanModel = new UlasanModel();
            $ulasan = $ulasanModel
                ->select('ulasan_event.rating, ulasan_event.komentar, events.nama_event')
                ->join('events', 'events.id_event = ulasan_event.id_event')
                ->orderBy('ulasan_event.created_at', 'DESC')
                ->limit(15)->findAll();

            $konteks[] = "\n=== ULASAN TERBARU ===";
            if (empty($ulasan)) {
                $konteks[] = "- Belum ada ulasan dari user";
            } else {
                foreach ($ulasan as $u) {
                    $komentar  = !empty($u['komentar']) ? $u['komentar'] : '(tanpa komentar)';
                    $konteks[] = "- Event \"{$u['nama_event']}\" (⭐{$u['rating']}/5): {$komentar}";
                }
            }
        }

        // --- RECRUITMENT (kalau ditanya) ---
        if (strpos($pertanyaanLower, 'recruitment') !== false
            || strpos($pertanyaanLower, 'rekrutmen') !== false
            || strpos($pertanyaanLower, 'rekrut') !== false
            || strpos($pertanyaanLower, 'open rec') !== false) {

            $recruitment = $db->table('open_recruitment')
                ->select('open_recruitment.judul, open_recruitment.posisi, open_recruitment.periode, ormawa.nama_ormawa')
                ->join('ormawa', 'ormawa.id_ormawa = open_recruitment.id_ormawa')
                ->where('open_recruitment.status', 'open')
                ->get()->getResultArray();

            $konteks[] = "\n=== OPEN RECRUITMENT AKTIF ===";
            if (empty($recruitment)) {
                $konteks[] = "- Belum ada recruitment yang dibuka";
            } else {
                foreach ($recruitment as $r) {
                    $konteks[] = "- \"{$r['judul']}\" oleh {$r['nama_ormawa']} | Posisi: {$r['posisi']} | Periode: {$r['periode']}";
                }
            }
        }

        // --- STATISTIK UKM (kalau ditanya) ---
        if (strpos($pertanyaanLower, 'aktif') !== false
            || strpos($pertanyaanLower, 'populer') !== false
            || strpos($pertanyaanLower, 'terbaik') !== false
            || strpos($pertanyaanLower, 'terbanyak') !== false) {

            $stats = $db->query("
                SELECT o.nama_ormawa,
                       COUNT(DISTINCT e.id_event) as total_event,
                       COALESCE(AVG(e.rating_avg), 0) as rata_rating,
                       COALESCE(SUM(e.jumlah_ulasan), 0) as total_ulasan
                FROM ormawa o
                LEFT JOIN events e ON e.id_ormawa = o.id_ormawa AND e.status = 'Published'
                GROUP BY o.id_ormawa
                ORDER BY total_event DESC
            ")->getResultArray();

            $konteks[] = "\n=== STATISTIK UKM ===";
            foreach ($stats as $s) {
                $konteks[] = "- {$s['nama_ormawa']}: {$s['total_event']} event, rata-rata rating " . number_format($s['rata_rating'], 1) . "/5 ({$s['total_ulasan']} ulasan)";
            }
        }

        return implode("\n", $konteks);
    }


    // ═══════════════════════════════════════════════════════════
    // 3. SYSTEM PROMPT (untuk chatbot)
    // ═══════════════════════════════════════════════════════════
    private function buildSystemPrompt($konteks)
    {
        return "Kamu adalah EventNela AI, asisten virtual cerdas untuk sistem informasi UKM/Ormawa Politeknik Negeri Lampung (Polinela).

═══ KEPRIBADIAN ═══
- Ramah, santai, helpful — kayak teman kampus yang pintar.
- Pakai bahasa Indonesia sehari-hari (tidak kaku/formal).
- Boleh pakai emoji (maksimal 3 per jawaban).
- Panggil diri 'aku', panggil user 'kamu'.
- Sesuaikan energi dengan user.

═══ ATURAN UTAMA ═══

**1. BEDAKAN JENIS PESAN USER**

a. Pertanyaan DATA → Jawab dari KONTEKS data.
b. Komentar Santai → Balas SINGKAT (1-2 kalimat).
c. Pertanyaan Lanjutan → Baca history percakapan.

**2. JANGAN ULANG JAWABAN YANG SAMA**

**3. UNTUK TOPIK EVENTNELA:**
   → Jawab dari KONTEKS data.

**4. DI LUAR KONTEKS:**
   → Alihkan sopan ke topik EventNela.

**5. JANGAN MENGARANG DATA**

**6. BACA HISTORY PERCAKAPAN — WAJIB!**

   → Kalau user jawab SINGKAT: 'iya', 'oke', 'boleh' → itu SETUJU dengan tawaran AI sebelumnya.

   → JANGAN pernah ulang salam pembuka di tengah percakapan.

═══ KONTEKS DATA EVENTNELA (REAL-TIME DARI DATABASE) ═══
{$konteks}

═══ INSTRUKSI ═══
Jawab sesuai jenis pesan user. Fokus ke INTERAKSI NATURAL.";
    }


    // ═══════════════════════════════════════════════════════════
    // 4. REKOMENDASI EVENT — SUPPORT MODE REVISI
    // ═══════════════════════════════════════════════════════════
    public function rekomendasiEvent($input, $previous = null, $feedback = null)
    {
        if (empty($this->apiKey)) {
            return ['status' => 'error', 'message' => 'API Key belum diset di .env.'];
        }

        $konteks      = $this->buildEventContext();
        $systemPrompt = $this->buildEventSystemPrompt($konteks);

        if ($previous && $feedback) {
            $userMessage = "MODE REVISI EVENT\n\n" .
                "Data event sebelumnya:\n" .
                json_encode($previous, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n" .
                "Feedback dari user: \"{$feedback}\"\n\n" .
                "TUGAS: Revisi event di atas sesuai feedback user.";
        } else {
            $userMessage = "Buatkan event dengan konsep: \"{$input}\"";
        }

        $jawaban = $this->callGroq($systemPrompt, $userMessage);

        return $this->parseEventJSON($jawaban);
    }


    // ═══════════════════════════════════════════════════════════
    // 5. GENERATE EVENT LENGKAP DARI WIZARD (7 PERTANYAAN)
    // ═══════════════════════════════════════════════════════════
    public function generateEventLengkap($dataUser)
    {
        if (empty($this->apiKey)) {
            return ['status' => 'error', 'message' => 'API Key belum diset di .env.'];
        }

        // Ambil daftar gedung dari DB
        $db = \Config\Database::connect();
        $gedungList = $db->table('gedung')
            ->select('nama_gedung')
            ->orderBy('nama_gedung', 'ASC')
            ->get()->getResultArray();

        $gedungText = implode(', ', array_column($gedungList, 'nama_gedung'));

        $systemPrompt = "Kamu adalah Event Planner AI untuk EventNela — platform UKM/Ormawa Politeknik Negeri Lampung.

═══ TUGAS ═══
Berdasarkan data event yang diberikan user, kamu WAJIB membuat detail event LENGKAP dalam format JSON.

═══ DATA EVENT DARI USER ═══
- Konsep event: {$dataUser['konsep']}
- Peserta: {$dataUser['peserta_tipe']}
- Jumlah peserta: {$dataUser['peserta_jumlah']} orang
- Durasi: {$dataUser['durasi_hari']} hari
- Konsumsi: {$dataUser['konsumsi_tipe']}
- Budget konsumsi per orang: Rp {$dataUser['konsumsi_per_orang']}
- Biaya lain: Rp {$dataUser['biaya_lain']}

═══ DAFTAR GEDUNG YANG TERSEDIA ═══
{$gedungText}

Tanggal hari ini: " . date('Y-m-d') . "

═══ ATURAN ═══
1. Nama event: menarik, catchy, singkat
2. Deskripsi: 3-5 baris
3. Tanggal rekomendasi: minimal 7 hari dari hari ini, format YYYY-MM-DD
4. Waktu rekomendasi: format HH:MM
5. Gedung rekomendasi: WAJIB pilih dari daftar gedung di atas
6. Rundown: array 4-6 item, format \"HH:MM - Nama Kegiatan\"

═══ OUTPUT JSON (HANYA JSON, TANPA TEKS LAIN) ═══
{
  \"status\": \"success\",
  \"nama_event\": \"...\",
  \"deskripsi\": \"...\",
  \"tanggal\": \"YYYY-MM-DD\",
  \"waktu\": \"HH:MM\",
  \"gedung\": \"dari daftar\",
  \"rundown\": [\"08:00 - Pembukaan\", \"...\"]
}";

        $jawaban = $this->callGroq($systemPrompt, 'Generate event sekarang.');
        $parsed = $this->parseEventJSON($jawaban);

        if (($parsed['status'] ?? '') !== 'success') {
            return $parsed;
        }

        // Gabung dengan data dari user
        $parsed['peserta_tipe']       = $dataUser['peserta_tipe'];
        $parsed['peserta_jumlah']     = (int) $dataUser['peserta_jumlah'];
        $parsed['durasi_hari']        = (int) $dataUser['durasi_hari'];
        $parsed['konsumsi_tipe']      = $dataUser['konsumsi_tipe'];
        $parsed['konsumsi_per_orang'] = (float) $dataUser['konsumsi_per_orang'];
        $parsed['biaya_lain']         = (float) $dataUser['biaya_lain'];
        $parsed['total_biaya']        =
            ($dataUser['peserta_jumlah'] * $dataUser['konsumsi_per_orang'] * $dataUser['durasi_hari'])
            + $dataUser['biaya_lain'];

        return $parsed;
    }


    // ═══════════════════════════════════════════════════════════
    // 6. CONTEXT BUILDER (untuk event generator)
    // ═══════════════════════════════════════════════════════════
    private function buildEventContext()
    {
        $db      = \Config\Database::connect();
        $konteks = [];

        // GEDUNG
        $gedung = $db->table('gedung')
            ->select('nama_gedung')
            ->orderBy('nama_gedung', 'ASC')
            ->get()->getResultArray();

        $konteks[] = "=== GEDUNG YANG TERSEDIA DI POLINELA ===";
        if (empty($gedung)) {
            $konteks[] = "- (Belum ada data gedung)";
        } else {
            foreach ($gedung as $g) {
                $konteks[] = "- {$g['nama_gedung']}";
            }
        }

        // EVENT EXISTING
        $existing = $db->table('events')
            ->select('nama_event, tanggal, gedung')
            ->whereIn('status', ['Published', 'Pending Admin', 'Pending Validator'])
            ->orderBy('tanggal', 'DESC')
            ->limit(20)
            ->get()->getResultArray();

        $konteks[] = "\n=== EVENT YANG SUDAH PERNAH ADA (JANGAN DUPLIKAT NAMA) ===";
        if (empty($existing)) {
            $konteks[] = "- (Belum ada event sama sekali)";
        } else {
            foreach ($existing as $e) {
                $konteks[] = "- \"{$e['nama_event']}\" ({$e['tanggal']}, {$e['gedung']})";
            }
        }

        // DAFTAR ORMAWA
        $ormawa = $db->table('ormawa')
            ->select('nama_ormawa, kategori')
            ->where('status', 'Aktif')
            ->get()->getResultArray();

        $konteks[] = "\n=== DAFTAR UKM/ORMAWA ===";
        foreach ($ormawa as $o) {
            $konteks[] = "- {$o['nama_ormawa']} ({$o['kategori']})";
        }

        return implode("\n", $konteks);
    }


    // ═══════════════════════════════════════════════════════════
    // 7. SYSTEM PROMPT (untuk event generator)
    // ═══════════════════════════════════════════════════════════
    private function buildEventSystemPrompt($konteks)
    {
        return "Kamu adalah Event Planner AI untuk EventNela — platform UKM/Ormawa Politeknik Negeri Lampung (Polinela).

═══ TUGAS UTAMA ═══
User akan memberikan konsep/tema singkat event. Kamu WAJIB memberikan rekomendasi event LENGKAP dalam format JSON.

Ada 2 MODE:
1. MODE AWAL → User kasih konsep, kamu generate dari nol.
2. MODE REVISI → User kasih feedback untuk perbaiki event sebelumnya.

═══ ATURAN KERAS ═══

**1. STAY IN CONTEXT EVENTNELA**
   - Cuma boleh rekomendasi event KAMPUS (UKM/Ormawa Polinela)

**2. GEDUNG WAJIB DARI DATABASE**

**3. JANGAN DUPLIKAT NAMA EVENT**

**4. OUTPUT WAJIB JSON VALID (TANPA MARKDOWN)**
   {
     \"status\": \"success\",
     \"nama_event\": \"...\",
     \"tema\": \"...\",
     \"deskripsi\": \"...\",
     \"gedung\": \"...\",
     \"target_peserta\": 100,
     \"waktu\": \"08:00\",
     \"durasi_jam\": 4,
     \"rundown\": [\"08:00 - Pembukaan\"],
     \"alasan\": \"...\"
   }

═══ KONTEKS DATA EVENTNELA ═══
{$konteks}

═══ INSTRUKSI FINAL ═══
Return HANYA JSON valid.";
    }


    // ═══════════════════════════════════════════════════════════
    // 8. PARSE JSON DARI AI
    // ═══════════════════════════════════════════════════════════
    private function parseEventJSON($jawaban)
    {
        $clean = preg_replace('/```json\s*|\s*```/', '', $jawaban);
        $clean = trim($clean);

        if (preg_match('/\{.*\}/s', $clean, $matches)) {
            $clean = $matches[0];
        }

        $parsed = json_decode($clean, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return [
                'status'  => 'error',
                'message' => 'AI gagal membuat format yang valid. Coba lagi.',
                'raw'     => $jawaban
            ];
        }

        if (!isset($parsed['status'])) {
            $parsed['status'] = 'success';
        }

        return $parsed;
    }


    // ═══════════════════════════════════════════════════════════
    // 9. CALL AI API (IB-Center)
    // ═══════════════════════════════════════════════════════════
    private function callGroq($systemPrompt, $pertanyaan, $history = [])
    {
        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        if (!empty($history)) {
            $pastHistory = array_slice($history, 0, -1);

            foreach ($pastHistory as $h) {
                $messages[] = [
                    'role'    => $h['role'] === 'assistant' ? 'assistant' : 'user',
                    'content' => $h['message']
                ];
            }
        }

        $messages[] = ['role' => 'user', 'content' => $pertanyaan];

        $payload = [
            'model'       => $this->model,
            'messages'    => $messages,
            'temperature' => 0.7,
            'max_tokens'  => 1500,
        ];

        $ch = curl_init($this->endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $this->apiKey,
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        // Log untuk debug
        log_message('debug', 'AI Request: ' . json_encode($payload));
        log_message('debug', 'AI Response HTTP ' . $httpCode . ': ' . $response);

        if ($httpCode !== 200) {
            return "Maaf, AI sedang tidak tersedia. Error: HTTP {$httpCode} " . ($curlErr ?: '');
        }

        $result = json_decode($response, true);

        if (!$result) {
            return "Maaf, respons AI tidak valid.";
        }

        return $result['choices'][0]['message']['content'] ?? "Maaf, AI tidak memberikan respons.";
    }
}