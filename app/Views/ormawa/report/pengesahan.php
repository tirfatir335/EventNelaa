<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Pengesahan - <?= esc($report['nama_event']) ?></title>
    <style>
        @page {
            size: A4 portrait;
            margin: 15mm 20mm;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            color: #000;
            background: #f0f0f0;
            padding: 20px;
        }

        .paper {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            padding: 18mm 22mm;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }

        /* KOP */
        .kop {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 6px;
            border-bottom: 3px double #000;
            margin-bottom: 4px;
        }

        .kop-logo {
            width: 82px;
            height: 82px;
            object-fit: contain;
            flex-shrink: 0;
            margin-left: 6px;
            margin-right: 4px;
        }

        .kop-text {
            flex: 1;
            text-align: center;
            line-height: 1.3;
        }

        .kop-text .k1 { font-size: 10pt; }
        .kop-text .k2 { font-size: 14pt; font-weight: bold; letter-spacing: 1px; }
        .kop-text .k3 { font-size: 9.5pt; }
        .kop-text .k4 { font-size: 8.5pt; }

        /* JUDUL */
        h1 {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            letter-spacing: 2px;
            margin-top: 16px;
            margin-bottom: 4px;
            text-decoration: underline;
        }

        .subjudul {
            text-align: center;
            font-size: 12pt;
            font-weight: bold;
            margin-bottom: 18px;
        }

        /* INFO KEGIATAN */
        .info-table {
            width: 100%;
            margin-bottom: 18px;
            font-size: 11pt;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        .info-table td:first-child { width: 165px; }
        .info-table td:nth-child(2) { width: 12px; }

        /* PARAGRAF */
        .paragraf {
            text-align: justify;
            line-height: 1.65;
            margin-bottom: 18px;
            text-indent: 40px;
            font-size: 11pt;
        }

        /* TTD SECTION */
        .ttd-section {
            margin-top: 10px;
        }

        .ttd-row-top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 24px;
        }

        .ttd-box {
            width: 47%;
            text-align: center;
        }

        .ttd-label {
            font-size: 11pt;
            margin-bottom: 2px;
        }

        .ttd-jabatan {
            font-size: 10.5pt;
            margin-bottom: 8px;
        }

        .verified-badge {
            display: inline-block;
            border: 1.5px solid #2e7d32;
            color: #2e7d32;
            padding: 4px 14px;
            border-radius: 5px;
            font-size: 10pt;
            font-weight: bold;
            margin: 8px 0;
            letter-spacing: 0.5px;
        }

        .verified-badge .check {
            font-size: 12pt;
            margin-right: 4px;
        }

        .nama-terang {
            font-size: 11pt;
            font-weight: bold;
            text-decoration: underline;
            margin-top: 4px;
        }

        .nip-line {
            font-size: 10pt;
            margin-top: 2px;
        }

        .ttd-row-bottom {
            text-align: center;
            margin-top: 16px;
        }

        .ttd-row-bottom .ttd-box {
            width: 60%;
            margin: 0 auto;
        }

        /* TOMBOL PRINT */
        .print-bar {
            position: fixed;
            top: 20px;
            right: 20px;
            display: flex;
            gap: 8px;
            z-index: 100;
        }

        .btn-print {
            background: linear-gradient(135deg, #ff7a00, #e65100);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255,122,0,0.4);
            font-family: inherit;
        }

        .btn-print:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255,122,0,0.5);
        }

        .btn-back {
            background: white;
            color: #666;
            border: 2px solid #ddd;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-family: inherit;
        }

        /* ============================================
           PRINT MODE — fix jadi 1 halaman A4
           ============================================ */
        @media print {
            body {
                background: white;
                padding: 0;
                margin: 0;
                font-size: 11pt;
            }

            .paper {
                box-shadow: none;
                padding: 0;
                width: auto;
                min-height: auto;
                margin: 0;
            }

            .print-bar { display: none; }

            /* Rapatkan semua spacing biar cukup 1 halaman */
            h1 { margin-top: 10px; margin-bottom: 2px; font-size: 13.5pt; }
            .subjudul { margin-bottom: 14px; font-size: 11.5pt; }
            .info-table { margin-bottom: 14px; }
            .paragraf { margin-bottom: 14px; line-height: 1.55; }
            .ttd-section { margin-top: 6px; }
            .ttd-row-top { margin-bottom: 20px; }
            .ttd-row-bottom { margin-top: 12px; }
            .verified-badge { padding: 3px 12px; margin: 6px 0; }
            .kop { padding-bottom: 5px; }
            .kop-logo { width: 78px; height: 78px; }
        }
    </style>
</head>
<body>

<div class="print-bar">
    <button class="btn-print" onclick="window.print()">
        🖨️ Cetak / Simpan PDF
    </button>
    <a href="javascript:window.close()" class="btn-back">✕ Tutup</a>
</div>

<div class="paper">

    <!-- KOP SURAT -->
    <div class="kop">
        <img src="<?= base_url('assets/images/logo-polinela.png') ?>" alt="Logo Polinela" class="kop-logo">
        <div class="kop-text">
            <div class="k1">KEMENTERIAN PENDIDIKAN TINGGI, SAINS, DAN TEKNOLOGI</div>
            <div class="k2">POLITEKNIK NEGERI LAMPUNG</div>
            <div class="k3">Jl. Soekarno-Hatta No. 10, Rajabasa Raya, Bandar Lampung 35144</div>
            <div class="k4">Telepon (0721) 703-995 | Website: polinela.ac.id | Email: info@polinela.ac.id</div>
        </div>
    </div>

    <!-- JUDUL -->
    <h1>LEMBAR PENGESAHAN</h1>
    <div class="subjudul">LAPORAN PERTANGGUNGJAWABAN KEGIATAN</div>

    <!-- INFO KEGIATAN -->
    <table class="info-table">
        <tr>
            <td>Nama Kegiatan</td>
            <td>:</td>
            <td><strong><?= esc($report['nama_event']) ?></strong></td>
        </tr>
        <tr>
            <td>Penyelenggara</td>
            <td>:</td>
            <td><?= esc($report['nama_ormawa']) ?></td>
        </tr>
        <tr>
            <td>Tanggal Pelaksanaan</td>
            <td>:</td>
            <td><?= date('d F Y', strtotime($report['tanggal'])) ?></td>
        </tr>
        <tr>
            <td>Waktu</td>
            <td>:</td>
            <td><?= esc($report['waktu']) ?> WIB</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td><?= esc($report['gedung']) ?></td>
        </tr>
    </table>

    <!-- PARAGRAF -->
    <p class="paragraf">
        Yang bertanda tangan di bawah ini menyatakan bahwa Laporan Pertanggungjawaban (LPJ)
        kegiatan tersebut di atas telah <strong>diverifikasi</strong> dan <strong>disetujui</strong>
        melalui sistem informasi EventNela Politeknik Negeri Lampung. Laporan ini menjadi bukti sah
        pertanggungjawaban kegiatan yang telah dilaksanakan.
    </p>

    <!-- TTD ATAS: PEMBINA + KETUA -->
    <div class="ttd-section">
        <div class="ttd-row-top">

            <!-- PEMBINA -->
            <div class="ttd-box">
                <div class="ttd-label">Menyetujui,</div>
                <div class="ttd-jabatan">Pembina <?= esc($report['nama_ormawa']) ?></div>

                <div class="verified-badge">
                    <span class="check">✓</span>TELAH DIVERIFIKASI
                </div>

                <div class="nama-terang">
                    <?= esc($pembina_data['nama_dosen'] ?? $report['pembina'] ?? '____________') ?>
                </div>
                <div class="nip-line">
                    NIP. <?= esc($pembina_data['nip'] ?? '____________________') ?>
                </div>
            </div>

            <!-- KETUA -->
            <div class="ttd-box">
                <div class="ttd-label">&nbsp;</div>
                <div class="ttd-jabatan">Ketua Umum <?= esc($report['nama_ormawa']) ?></div>

                <div class="verified-badge">
                    <span class="check">✓</span>TELAH DIVERIFIKASI
                </div>

                <div class="nama-terang">
                    <?= esc($ketua['nama'] ?? '____________') ?>
                </div>
                <div class="nip-line">
                NPM. <?= esc($ketua['npm'] ?? '____________________') ?>
                </div>
            </div>

        </div>

        <!-- TTD BAWAH: WADIR -->
        <div class="ttd-row-bottom">
            <div class="ttd-box">
                <div class="ttd-label">
                    Bandar Lampung, <?= date('d F Y') ?><br>
                    Wakil Direktur III Bidang Kemahasiswaan
                </div>

                <div class="verified-badge" style="margin-top: 12px;">
                    <span class="check">✓</span>TELAH DIVERIFIKASI
                </div>

                <div class="nama-terang">Agung Adi Candra, S.Kh., M.Si</div>
                <div class="nip-line">NIP. 198110212003121002</div>
            </div>
        </div>

    </div>

</div>

</body>
</html>