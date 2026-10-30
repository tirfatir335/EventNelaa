<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Panduan Lengkap EventNela</title>
<style>
    @page {
        size: A4 portrait;
        margin: 20mm 18mm 22mm 18mm;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
        font-family: 'Times New Roman', Georgia, serif;
        font-size: 11.5pt;
        color: #000;
        background: #e0e0e0;
        padding: 20px;
        line-height: 1.6;
    }

    .content-page {
        width: 210mm;
        margin: 0 auto 20px;
        background: white;
        padding: 15mm 18mm;
        box-shadow: 0 6px 30px rgba(0,0,0,0.15);
    }

    /* COVER */
       /* COVER */
    .cover-page {
        width: 210mm;
        height: 297mm;
        margin: 0 auto 20px;
        background: white;
        box-shadow: 0 6px 30px rgba(0,0,0,0.15);
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
    }

    /* Pita atas & bawah */
    .cover-band-top {
        height: 16mm;
        background: linear-gradient(135deg, #ff7a00 0%, #e65100 100%);
        position: relative;
        flex-shrink: 0;
    }
    .cover-band-top::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 4mm;
        background: #1a1a2e;
    }

    .cover-band-bottom {
        height: 16mm;
        background: linear-gradient(135deg, #e65100 0%, #ff7a00 100%);
        position: relative;
        flex-shrink: 0;
    }
    .cover-band-bottom::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4mm;
        background: #1a1a2e;
    }

    .cover-body {
        flex: 1;
        padding: 14mm 22mm 12mm;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    /* Logos */
    .cover-logos {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 4mm;
        margin-bottom: 4mm;
    }
    .cover-logos img {
        height: 105px;
        width: auto;
        object-fit: contain;
    }

    .cover-divider-line {
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #1a1a2e, transparent);
        margin: 2mm 0 22mm;
    }

    /* Title section */
    .cover-label-top {
        font-size: 11pt;
        letter-spacing: 8px;
        color: #e65100;
        font-weight: bold;
        margin-bottom: 10mm;
        text-transform: uppercase;
        font-family: 'Times New Roman', serif;
    }

    .cover-title {
        font-size: 56pt;
        font-weight: 900;
        color: #1a1a2e;
        letter-spacing: 6px;
        line-height: 1;
        margin-bottom: 6mm;
        font-family: 'Georgia', 'Times New Roman', serif;
    }

    .cover-title-accent {
        width: 200px;
        height: 5px;
        background: linear-gradient(90deg, #ff7a00, #e65100);
        margin: 0 auto 7mm;
        border-radius: 3px;
    }

    .cover-subtitle {
        font-size: 15pt;
        color: #333;
        margin-bottom: 22mm;
        font-style: italic;
        font-family: 'Times New Roman', serif;
    }

    /* Deskripsi box */
    .cover-desc-box {
        background: #f8f9fa;
        border-left: 5px solid #ff7a00;
        border-radius: 8px;
        padding: 16px 22px;
        text-align: left;
        font-size: 11pt;
        line-height: 1.75;
        color: #333;
        max-width: 150mm;
        font-family: 'Times New Roman', serif;
    }

    /* Role chips */
    .cover-roles {
        display: flex;
        justify-content: center;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 12mm;
    }
    .cover-role-chip {
        display: inline-block;
        padding: 6px 16px;
        background: white;
        border: 2px solid #ff7a00;
        color: #e65100;
        border-radius: 20px;
        font-size: 9.5pt;
        font-weight: bold;
        font-family: 'Times New Roman', serif;
    }

    /* Footer */
    .cover-footer {
        text-align: center;
        padding-top: 8mm;
        border-top: 2px solid #1a1a2e;
        width: 100%;
        margin-top: auto;
    }
    .cover-footer .inst {
        font-size: 14pt;
        font-weight: 900;
        color: #1a1a2e;
        letter-spacing: 3px;
        margin-bottom: 3mm;
        font-family: 'Times New Roman', serif;
    }
    .cover-footer .addr {
        font-size: 10pt;
        color: #555;
        margin-bottom: 5mm;
    }
    .cover-footer .version {
        display: inline-block;
        background: #1a1a2e;
        color: white;
        padding: 5px 20px;
        border-radius: 14px;
        font-size: 9.5pt;
        font-weight: bold;
        letter-spacing: 2px;
    }

    /* DAFTAR ISI */
    .toc-title {
        font-size: 24pt;
        font-weight: bold;
        text-align: center;
        margin-bottom: 30px;
        color: #000;
        letter-spacing: 2px;
    }
    .toc-list { list-style: none; padding: 0; }
    .toc-list li {
        padding: 6px 0;
        font-size: 11.5pt;
        color: #000;
    }
    .toc-list li.bab {
        font-weight: bold;
        color: #000;
        font-size: 12.5pt;
        margin-top: 10px;
        padding-top: 8px;
        border-top: 1px solid #ccc;
    }
    .toc-list li.bab:first-child { border-top: none; margin-top: 0; }
    .toc-list li.sub {
        padding-left: 24px;
        color: #000;
        font-size: 11pt;
    }

    /* BAB HEADER */
    .bab-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 12px;
        margin-bottom: 22px;
        border-bottom: 3px double #000;
        page-break-after: avoid;
        page-break-inside: avoid;
    }
    .bab-num {
        width: 58px;
        height: 58px;
        border-radius: 50%;
        background: #000;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22pt;
        font-weight: bold;
        flex-shrink: 0;
    }
    .bab-header-text h2 {
        font-size: 20pt;
        color: #000;
        margin: 0;
        font-weight: bold;
    }
    .bab-header-text small {
        font-size: 11pt;
        color: #000;
        font-style: italic;
    }

    /* KONTEN */
    .bab-content h3 {
        font-size: 14pt;
        color: #000;
        font-weight: bold;
        margin: 20px 0 10px;
        padding-bottom: 6px;
        border-bottom: 1px solid #ccc;
        page-break-after: avoid;
    }
    .bab-content h4 {
        font-size: 12pt;
        color: #000;
        font-weight: bold;
        margin: 14px 0 8px;
        page-break-after: avoid;
    }
    .bab-content p {
        font-size: 11.5pt;
        color: #000;
        line-height: 1.75;
        margin-bottom: 10px;
        text-align: justify;
    }
    .bab-content ul,
    .bab-content ol {
        padding-left: 22px;
        margin-bottom: 12px;
    }
    .bab-content li {
        font-size: 11.5pt;
        color: #000;
        line-height: 1.75;
        margin-bottom: 4px;
    }
    .bab-content strong { color: #000; font-weight: bold; }
    .bab-content code {
        background: #f0f0f0;
        padding: 1px 5px;
        border-radius: 3px;
        font-family: 'Courier New', monospace;
        font-size: 10.5pt;
        color: #000;
    }

    /* TABEL */
    table.info {
        width: 100%;
        border-collapse: collapse;
        margin: 12px 0 18px;
        font-size: 10.5pt;
        page-break-inside: avoid;
    }
    table.info th {
        background: #333;
        color: white;
        padding: 9px 12px;
        text-align: left;
        font-weight: bold;
    }
    table.info td {
        padding: 8px 12px;
        border-bottom: 1px solid #ccc;
        vertical-align: top;
        color: #000;
    }
    table.info tr:nth-child(even) td { background: #f7f7f7; }
    table.info td.center { text-align: center; }

    /* BOX */
    .box-info, .box-tip, .box-warn {
        border-radius: 10px;
        padding: 12px 16px;
        margin: 12px 0;
        font-size: 11pt;
        line-height: 1.7;
        color: #000;
        page-break-inside: avoid;
    }
    .box-info { background: #e3f2fd; border-left: 4px solid #1565c0; }
    .box-tip  { background: #e8f5e9; border-left: 4px solid #2e7d32; }
    .box-warn { background: #fff3e0; border-left: 4px solid #e65100; }

    /* FLOW CHART */
    .flow-chart {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 18px 22px;
        margin: 14px 0;
        font-family: 'Courier New', monospace;
        font-size: 10pt;
        line-height: 1.7;
        color: #000;
        border: 1px solid #ddd;
        white-space: pre;
        page-break-inside: avoid;
    }

    /* FAQ */
    .faq-item {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 8px;
        border-left: 3px solid #333;
        page-break-inside: avoid;
    }
    .faq-item .q {
        font-weight: bold;
        color: #000;
        font-size: 11pt;
        margin-bottom: 4px;
    }
    .faq-item .a {
        color: #000;
        font-size: 10.5pt;
        line-height: 1.65;
    }

    /* PRINT BAR */
    .print-bar {
        position: fixed;
        top: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
        z-index: 1000;
    }
    .btn-pdf {
        background: linear-gradient(135deg, #ff7a00, #e65100);
        color: white;
        border: none;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0 6px 20px rgba(255,122,0,0.4);
        font-family: inherit;
    }
    .btn-pdf:hover { transform: translateY(-2px); }
    .btn-close-pdf {
        background: white;
        color: #666;
        border: 2px solid #ddd;
        padding: 14px 28px;
        border-radius: 12px;
        font-weight: bold;
        font-size: 14px;
        cursor: pointer;
        text-decoration: none;
        font-family: inherit;
    }

    /* PRINT MODE */
    @media print {
        body {
            background: white;
            padding: 0;
            font-size: 11pt;
        }
        .content-page {
            box-shadow: none;
            width: auto;
            margin: 0;
            padding: 0;
        }
            .cover-page {
            box-shadow: none;
            width: auto;
            height: 100vh;
            margin: 0;
            padding: 0;
            page-break-after: always;
        }
        .toc-page { page-break-after: always; }
        .bab-page { page-break-before: always; }
        .bab-page:first-of-type { page-break-before: auto; }
        .print-bar { display: none; }
        table.info,
        .box-info,
        .box-tip,
        .box-warn,
        .flow-chart,
        .faq-item { page-break-inside: avoid; }
        .bab-header { page-break-after: avoid; }
        h3, h4 { page-break-after: avoid; }
        p, li { page-break-inside: avoid; }
    }
</style>
</head>
<body>

<!-- PRINT BAR -->
<div class="print-bar">
    <button class="btn-pdf" onclick="window.print()">Cetak / Simpan PDF</button>
    <a href="javascript:window.close()" class="btn-close-pdf">Tutup</a>
</div>

<!-- COVER -->
<div class="cover-page">
    <div class="cover-band-top"></div>

    <div class="cover-body">

        <!-- Logos -->
        <div class="cover-logos">
            <img src="<?= base_url('assets/images/logo-polinela.png') ?>" alt="Logo Polinela">
            <img src="<?= base_url('assets/images/logo eventnela.png') ?>" alt="Logo EventNela">
        </div>

        <div class="cover-divider-line"></div>

        <!-- Title -->
        <div class="cover-label-top">Panduan Lengkap</div>
        <div class="cover-title">EVENTNELA</div>
        <div class="cover-title-accent"></div>
        <div class="cover-subtitle">Platform Informasi UKM, Ormawa &amp; Event Polinela</div>

        <!-- Deskripsi -->
        <div class="cover-desc-box">
            Panduan lengkap penggunaan sistem <strong>EventNela</strong> &mdash; mulai dari mengajukan program kerja,
            upload proposal, mengelola event, menyusun laporan pertanggungjawaban, sampai verifikasi LPJ.
        </div>

        <!-- Role chips -->
        <div class="cover-roles">
            <span class="cover-role-chip">Mahasiswa</span>
            <span class="cover-role-chip">Ormawa</span>
            <span class="cover-role-chip">Pembina</span>
            <span class="cover-role-chip">Admin Gedung</span>
            <span class="cover-role-chip">Validator</span>
        </div>

        <!-- Footer -->
        <div class="cover-footer">
            <div class="inst">POLITEKNIK NEGERI LAMPUNG</div>
            <div class="addr">Jl. Soekarno-Hatta No. 10, Rajabasa, Bandar Lampung 35144</div>
            <div class="version">VERSI 2.0 &mdash; <?= date('Y') ?></div>
        </div>

    </div>

    <div class="cover-band-bottom"></div>
</div>

<!-- DAFTAR ISI -->
<div class="content-page toc-page">
    <div class="toc-title">DAFTAR ISI</div>

    <ul class="toc-list">
        <li class="bab">BAB 1 &mdash; Tentang EventNela</li>
        <li class="sub">1.1 Apa itu EventNela</li>
        <li class="sub">1.2 Tujuan Sistem</li>
        <li class="sub">1.3 Fitur Utama</li>

        <li class="bab">BAB 2 &mdash; Role &amp; Hak Akses</li>
        <li class="sub">2.1 Daftar Role</li>
        <li class="sub">2.2 Tabel Hak Akses</li>

        <li class="bab">BAB 3 &mdash; Panduan Pengunjung (Publik)</li>
        <li class="sub">3.1 Menjelajah UKM &amp; Ormawa</li>
        <li class="sub">3.2 Melihat Event Kampus</li>
        <li class="sub">3.3 Membaca Berita</li>
        <li class="sub">3.4 Melihat Open Recruitment</li>
        <li class="sub">3.5 EventNela AI Chatbot</li>

        <li class="bab">BAB 4 &mdash; Panduan Mahasiswa</li>
        <li class="sub">4.1 Registrasi &amp; Login</li>
        <li class="sub">4.2 Memberi Ulasan Event</li>
        <li class="sub">4.3 Mendaftar Open Recruitment</li>
        <li class="sub">4.4 Memantau Status Pendaftaran</li>
        <li class="sub">4.5 Dashboard Mahasiswa</li>

        <li class="bab">BAB 5 &mdash; Panduan Ormawa / Admin UKM</li>
        <li class="sub">5.1 Login &amp; Dashboard</li>
        <li class="sub">5.2 Program Kerja (Progja)</li>
        <li class="sub">5.3 Upload Proposal</li>
        <li class="sub">5.4 Cetak Lembar Pengesahan Proposal</li>
        <li class="sub">5.5 Kelola Event (Manual &amp; AI)</li>
        <li class="sub">5.6 Report / LPJ</li>
        <li class="sub">5.7 Cetak Lembar Pengesahan LPJ</li>
        <li class="sub">5.8 Pengurus</li>
        <li class="sub">5.9 Departemen</li>
        <li class="sub">5.10 Galeri Dokumentasi</li>
        <li class="sub">5.11 Berita</li>
        <li class="sub">5.12 Open Recruitment</li>
        <li class="sub">5.13 Kelola Staf</li>
        <li class="sub">5.14 Ulasan Event</li>
        <li class="sub">5.15 Profil Ormawa</li>

        <li class="bab">BAB 6 &mdash; Panduan Staf Ormawa</li>
        <li class="sub">6.1 Hak Akses Modular</li>
        <li class="sub">6.2 Profil Saya</li>

        <li class="bab">BAB 7 &mdash; Panduan Pembina</li>
        <li class="sub">7.1 Login Pembina</li>
        <li class="sub">7.2 Verifikasi Proposal</li>
        <li class="sub">7.3 Verifikasi LPJ</li>
        <li class="sub">7.4 Profil Pembina</li>

        <li class="bab">BAB 8 &mdash; Panduan Admin (Pengelola Gedung)</li>
        <li class="sub">8.1 Dashboard</li>
        <li class="sub">8.2 Validasi Gedung</li>
        <li class="sub">8.3 Kelola Gedung</li>

        <li class="bab">BAB 9 &mdash; Panduan Validator (Wadir)</li>
        <li class="sub">9.1 Dashboard Validator</li>
        <li class="sub">9.2 Validasi Program Kerja</li>
        <li class="sub">9.3 Verifikasi Proposal</li>
        <li class="sub">9.4 Validasi Event</li>
        <li class="sub">9.5 Verifikasi LPJ</li>
        <li class="sub">9.6 Kelola Ormawa</li>
        <li class="sub">9.7 Kelola Pembina</li>
        <li class="sub">9.8 Backup Data</li>

        <li class="bab">BAB 10 &mdash; Fitur AI EventNela</li>
        <li class="sub">10.1 EventNela AI Chatbot</li>
        <li class="sub">10.2 AI Event Generator</li>

        <li class="bab">BAB 11 &mdash; Alur Lengkap</li>
        <li class="sub">11.1 Alur Program Kerja &amp; Proposal</li>
        <li class="sub">11.2 Alur Pengajuan Event</li>
        <li class="sub">11.3 Alur LPJ</li>
        <li class="sub">11.4 Alur Open Recruitment</li>

        <li class="bab">BAB 12 &mdash; FAQ</li>
    </ul>
</div>

<!-- BAB 1 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">1</div>
        <div class="bab-header-text">
            <h2>Tentang EventNela</h2>
            <small>Mengenal platform informasi kampus</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>1.1 Apa itu EventNela</h3>
        <p>
            <strong>EventNela</strong> adalah platform digital Politeknik Negeri Lampung yang menjadi pusat
            informasi Unit Kegiatan Mahasiswa (UKM), Organisasi Mahasiswa (Ormawa), event kegiatan,
            berita, dan open recruitment. Platform ini dirancang untuk mempermudah mahasiswa, dosen,
            dan civitas akademika dalam mengakses semua informasi kegiatan kampus.
        </p>

        <h3>1.2 Tujuan Sistem</h3>
        <ul>
            <li>Mempermudah penyebaran informasi kegiatan UKM &amp; Ormawa</li>
            <li>Menyediakan profil digital setiap organisasi kemahasiswaan</li>
            <li>Mendokumentasikan kegiatan organisasi secara online</li>
            <li>Memfasilitasi open recruitment anggota baru secara digital</li>
            <li>Mengelola Laporan Pertanggungjawaban (LPJ) secara paperless</li>
            <li>Menyediakan analisis berbasis AI untuk mendukung kegiatan organisasi</li>
        </ul>

        <h3>1.3 Fitur Utama</h3>
        <table class="info">
            <thead>
                <tr>
                    <th style="width: 28%;">Fitur</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Profil UKM</strong></td>
                    <td>Setiap UKM/Ormawa punya halaman publik berisi profil, visi misi, struktur pengurus, departemen, program kerja, galeri, dan event.</td>
                </tr>
                <tr>
                    <td><strong>Program Kerja</strong></td>
                    <td>Ormawa mengajukan program kerja per semester, divalidasi oleh Validator (Wadir) sebelum bisa diajukan proposal.</td>
                </tr>
                <tr>
                    <td><strong>Proposal Kegiatan</strong></td>
                    <td>Upload proposal untuk setiap progja approved, dengan verifikasi berlapis (Ketua, Pembina, Wadir) dan lembar pengesahan otomatis.</td>
                </tr>
                <tr>
                    <td><strong>Event Kampus</strong></td>
                    <td>Daftar semua event yang telah dipublikasikan, lengkap dengan poster, tanggal, waktu, gedung, dan ulasan dari pengunjung.</td>
                </tr>
                <tr>
                    <td><strong>Open Recruitment</strong></td>
                    <td>Pendaftaran anggota baru UKM/Ormawa secara online, lengkap dengan tahapan seleksi.</td>
                </tr>
                <tr>
                    <td><strong>Berita</strong></td>
                    <td>Publikasi berita dan pengumuman dari UKM/Ormawa.</td>
                </tr>
                <tr>
                    <td><strong>Report / LPJ</strong></td>
                    <td>Sistem pertanggungjawaban kegiatan dengan verifikasi berlapis dan generate lembar pengesahan otomatis.</td>
                </tr>
                <tr>
                    <td><strong>EventNela AI</strong></td>
                    <td>Asisten pintar 24/7 yang membantu mencari informasi dan merancang event.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- BAB 2 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">2</div>
        <div class="bab-header-text">
            <h2>Role &amp; Hak Akses</h2>
            <small>Siapa saja pengguna EventNela</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>2.1 Daftar Role</h3>
        <p>EventNela memiliki 7 role pengguna dengan hak akses yang berbeda:</p>

        <table class="info">
            <thead>
                <tr>
                    <th style="width: 28%;">Role</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Publik</strong></td>
                    <td>Pengunjung tanpa login. Bisa lihat semua konten publik.</td>
                </tr>
                <tr>
                    <td><strong>Mahasiswa</strong></td>
                    <td>Mahasiswa Polinela yang sudah registrasi. Bisa ulas event &amp; daftar recruitment.</td>
                </tr>
                <tr>
                    <td><strong>Ormawa / Admin UKM</strong></td>
                    <td>Pengurus inti UKM yang mengelola seluruh data organisasi.</td>
                </tr>
                <tr>
                    <td><strong>Staf Ormawa</strong></td>
                    <td>Anggota UKM dengan akses terbatas sesuai izin dari admin UKM.</td>
                </tr>
                <tr>
                    <td><strong>Pembina</strong></td>
                    <td>Dosen pembina yang memverifikasi proposal &amp; LPJ UKM yang dibina.</td>
                </tr>
                <tr>
                    <td><strong>Admin</strong></td>
                    <td>Pengelola gedung. Validasi ketersediaan gedung untuk event.</td>
                </tr>
                <tr>
                    <td><strong>Validator</strong></td>
                    <td>Wakil Direktur III Bidang Kemahasiswaan. Validasi progja, proposal, event &amp; LPJ.</td>
                </tr>
            </tbody>
        </table>

        <h3>2.2 Tabel Hak Akses</h3>
        <table class="info">
            <thead>
                <tr>
                    <th>Fitur</th>
                    <th class="center">Publik</th>
                    <th class="center">Mhs</th>
                    <th class="center">Ormawa</th>
                    <th class="center">Pembina</th>
                    <th class="center">Admin</th>
                    <th class="center">Validator</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Jelajah UKM &amp; Event</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&#10003;</td>
                </tr>
                <tr>
                    <td>Ulas Event</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Daftar Recruitment</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Kelola Progja</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Upload Proposal</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Kelola Event</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Isi Report / LPJ</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Verifikasi Proposal (Pembina)</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Verifikasi LPJ (Pembina)</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Validasi Gedung</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                    <td class="center">&mdash;</td>
                </tr>
                <tr>
                    <td>Validasi Progja (Wadir)</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                </tr>
                <tr>
                    <td>Verifikasi Proposal (Wadir)</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                </tr>
                <tr>
                    <td>Validasi Event (Final)</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                </tr>
                <tr>
                    <td>Verifikasi LPJ (Wadir)</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                </tr>
                <tr>
                    <td>Kelola Ormawa &amp; Pembina</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                </tr>
                <tr>
                    <td>Backup Data</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&mdash;</td>
                    <td class="center">&#10003;</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- BAB 3 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">3</div>
        <div class="bab-header-text">
            <h2>Panduan Pengunjung (Publik)</h2>
            <small>Untuk pengunjung tanpa akun</small>
        </div>
    </div>

    <div class="bab-content">
        <p>
            Siapa saja bisa mengakses konten publik EventNela tanpa perlu login.
            Cukup buka <strong>localhost:8080</strong> (atau domain resmi EventNela).
        </p>

        <h3>3.1 Menjelajah UKM &amp; Ormawa</h3>
        <ol>
            <li>Klik menu <strong>UKM / Ormawa</strong> di navbar, atau tombol <strong>"Jelajahi UKM"</strong> di halaman utama.</li>
            <li>Filter berdasarkan kategori: <strong>Semua</strong>, <strong>HMJ</strong>, atau <strong>UKM</strong>.</li>
            <li>Klik salah satu card UKM untuk membuka profil lengkapnya.</li>
            <li>Di halaman profil UKM kamu bisa melihat: profil, visi misi, struktur kepengurusan, departemen, program kerja, galeri dokumentasi, dan event yang pernah dilaksanakan.</li>
        </ol>

        <h3>3.2 Melihat Event Kampus</h3>
        <ol>
            <li>Klik menu <strong>Event</strong> di navbar.</li>
            <li>Gunakan tab filter: <strong>Semua</strong>, <strong>Akan Datang</strong>, atau <strong>Selesai</strong>.</li>
            <li>Gunakan search bar untuk mencari event tertentu.</li>
            <li>Klik card event untuk melihat detail lengkap (poster, deskripsi, rundown, dan ulasan).</li>
        </ol>

        <h3>3.3 Membaca Berita</h3>
        <ol>
            <li>Klik menu <strong>Berita</strong> di navbar.</li>
            <li>Berita terbaru akan tampil sebagai featured di atas.</li>
            <li>Klik card berita untuk membaca selengkapnya.</li>
            <li>Setiap berita bisa dibagikan ke WhatsApp, Facebook, atau Twitter.</li>
        </ol>

        <h3>3.4 Melihat Open Recruitment</h3>
        <ol>
            <li>Klik menu <strong>Open Recruitment</strong> di navbar.</li>
            <li>Lihat daftar UKM/Ormawa yang sedang membuka rekrutmen.</li>
            <li>Klik card untuk melihat detail, posisi yang dibuka, dan periode.</li>
            <li>Untuk mendaftar, kamu <strong>wajib login</strong> terlebih dahulu.</li>
        </ol>

        <h3>3.5 EventNela AI Chatbot</h3>
        <p>
            Tombol <strong>AI</strong> akan muncul di pojok kanan bawah setiap halaman. Klik untuk membuka chatbot
            dan tanyakan apapun tentang UKM, event, gedung, atau rekomendasi kegiatan.
        </p>
        <div class="box-tip">
            <strong>Contoh pertanyaan:</strong> "UKM apa yang paling aktif?", "Event apa yang ratingnya tertinggi?", "Rekomendasi kegiatan untuk semester depan?"
        </div>
    </div>
</div>

<!-- BAB 4 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">4</div>
        <div class="bab-header-text">
            <h2>Panduan Mahasiswa</h2>
            <small>Registrasi, ulas event, daftar recruitment</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>4.1 Registrasi &amp; Login</h3>
        <p><strong>Registrasi akun mahasiswa:</strong></p>
        <ol>
            <li>Klik tombol <strong>Login</strong> di pojok kanan atas.</li>
            <li>Klik link <strong>"Daftar di sini"</strong>.</li>
            <li>Isi form: username, email, password, dan konfirmasi password.</li>
            <li>Klik <strong>"Daftar Sekarang"</strong>.</li>
            <li>Kamu akan diarahkan ke halaman login. Login pakai akun yang baru dibuat.</li>
        </ol>

        <h3>4.2 Memberi Ulasan Event</h3>
        <ol>
            <li>Buka halaman <strong>Event</strong> &rarr; pilih event yang sudah selesai.</li>
            <li>Scroll ke bagian <strong>Ulasan &amp; Rating</strong>.</li>
            <li>Pilih rating (1-5 bintang) dan tulis komentar.</li>
            <li>Klik <strong>"Kirim Ulasan"</strong>.</li>
            <li>Satu mahasiswa hanya boleh memberi 1 ulasan per event.</li>
        </ol>

        <h3>4.3 Mendaftar Open Recruitment</h3>
        <ol>
            <li>Buka menu <strong>Open Recruitment</strong>.</li>
            <li>Pilih UKM yang ingin kamu ikuti.</li>
            <li>Klik <strong>"Daftar Sekarang"</strong>.</li>
            <li>Isi form pendaftaran: nama lengkap, NIM, prodi, no HP, email, dan alasan bergabung.</li>
            <li>Klik <strong>"Kirim Pendaftaran"</strong>.</li>
        </ol>

        <h3>4.4 Memantau Status Pendaftaran</h3>
        <ol>
            <li>Buka menu <strong>Riwayat</strong> atau <strong>Pendaftaran Saya</strong>.</li>
            <li>Setiap pendaftaran punya progress bar: <strong>Daftar &rarr; Tes &rarr; Wawancara &rarr; Diterima</strong>.</li>
            <li>Kalau lolos tahap tertentu, tombol <strong>"Join Grup WhatsApp"</strong> akan muncul (kalau admin UKM menyertakan link WA).</li>
        </ol>

        <h3>4.5 Dashboard Mahasiswa</h3>
        <p>Setelah login, mahasiswa diarahkan ke <strong>Dashboard Mahasiswa</strong> yang berisi:</p>
        <ul>
            <li><strong>Statistik</strong>: total pendaftaran, diterima, ulasan, rata-rata rating yang diberikan.</li>
            <li><strong>Pendaftaran terbaru</strong>: 5 pendaftaran terakhir.</li>
            <li><strong>Event yang bisa diulas</strong>: event yang sudah selesai, dengan search bar.</li>
            <li><strong>Ulasan saya</strong>: riwayat ulasan yang pernah dibuat.</li>
            <li><strong>Rekomendasi recruitment</strong> aktif.</li>
        </ul>
    </div>
</div>

<!-- BAB 5 Part 1 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">5</div>
        <div class="bab-header-text">
            <h2>Panduan Ormawa / Admin UKM</h2>
            <small>Kelola seluruh data organisasi</small>
        </div>
    </div>

    <div class="bab-content">
        <div class="box-info">
            Role <strong>Ormawa</strong> adalah pengurus inti UKM/Ormawa. Role ini punya akses paling luas untuk mengelola organisasi.
        </div>

        <h3>5.1 Login &amp; Dashboard</h3>
        <p>Login pakai akun yang diberikan validator. Setelah login, kamu akan diarahkan ke <strong>Dashboard Ormawa</strong>.</p>

        <h3>5.2 Program Kerja (Progja)</h3>
        <p>Program kerja adalah rencana kegiatan ormawa per semester yang harus disetujui Validator (Wadir) sebelum bisa diajukan proposalnya.</p>
        <p><strong>Cara tambah progja:</strong></p>
        <ol>
            <li>Menu <strong>Progja</strong> &rarr; klik <strong>"Tambah Progja"</strong>.</li>
            <li>Isi: nama progja, semester, bulan rencana, target peserta, deskripsi, foto.</li>
            <li>Klik <strong>"Simpan"</strong>. Status awalnya <strong>Draft</strong>.</li>
            <li>Klik <strong>"Ajukan"</strong> untuk kirim ke Validator.</li>
            <li>Tunggu Validator approve. Kalau ditolak, cek catatan lalu revisi dan ajukan ulang.</li>
        </ol>

        <div class="box-info">
            Progja harus <strong>approved Validator</strong> dulu sebelum bisa upload proposal.
        </div>

        <h3>5.3 Upload Proposal</h3>
        <p>Proposal <strong>wajib diupload</strong> untuk setiap progja yang sudah disetujui Validator, sebagai syarat pengajuan event.</p>
        <p><strong>Cara upload proposal:</strong></p>
        <ol>
            <li>Buka menu <strong>Proposal</strong> di sidebar.</li>
            <li>Di section biru paling atas, akan muncul daftar progja yang <strong>sudah approved tapi belum ada proposal</strong>.</li>
            <li>Klik tombol <strong>"Buat Proposal"</strong> di progja yang mau diajukan.</li>
            <li>Upload <strong>File Proposal</strong> (PDF/DOC/DOCX, maks 5 MB).</li>
            <li>Isi <strong>Deskripsi Kegiatan</strong> &mdash; latar belakang, tujuan, gambaran umum.</li>
            <li>Isi <strong>Rundown</strong> &mdash; tulis 1 baris per item (jam + acara).</li>
            <li>Isi <strong>Total Anggaran</strong> (Rp).</li>
            <li>Isi <strong>Catatan</strong> (opsional).</li>
            <li>Klik <strong>"Kirim Proposal"</strong>.</li>
        </ol>

        <p><strong>Setelah dikirim, proposal diverifikasi 3 pihak berurutan:</strong></p>
        <ol>
            <li><strong>Ketua Umum</strong> (auto-approved karena kamu yang submit).</li>
            <li><strong>Pembina</strong>.</li>
            <li><strong>Validator (Wadir III)</strong>.</li>
        </ol>

        <div class="box-tip">
            Status proposal bisa dipantau di menu <strong>Proposal</strong>. Kalau salah satu pihak menolak, catatan alasan bisa dibaca di halaman detail.
        </div>

        <h3>5.4 Cetak Lembar Pengesahan Proposal</h3>
        <p>Kalau 3 pihak sudah menyetujui proposal, kamu bisa cetak lembar pengesahannya:</p>
        <ol>
            <li>Buka menu <strong>Proposal</strong> &rarr; klik tombol <strong>"Detail"</strong> (ikon mata) pada proposal yang sudah approved.</li>
            <li>Klik tombol hijau <strong>"Cetak Lembar Pengesahan"</strong>.</li>
            <li>Halaman akan terbuka di tab baru.</li>
            <li>Klik <strong>"Cetak / Simpan PDF"</strong> atau tekan <strong>Ctrl + P</strong>.</li>
            <li>Pilih kertas <strong>A4</strong>, simpan sebagai PDF.</li>
        </ol>

        <p>Lembar pengesahan otomatis berisi:</p>
        <ul>
            <li>Kop surat Polinela dengan logo</li>
            <li>Info proposal kegiatan (nama, penyelenggara, semester, bulan, anggaran)</li>
            <li>Tanda tangan <strong>Pembina</strong> + <strong>Ketua Umum</strong> (sejajar, atas) dengan NIP/NPM masing-masing</li>
            <li>Tanda tangan <strong>Wadir III</strong> (tengah, bawah)</li>
            <li>Badge "Telah Diverifikasi" di setiap kolom TTD</li>
        </ul>

        <h3>5.5 Kelola Event (Manual &amp; AI)</h3>
        <p>Ada <strong>2 cara</strong> membuat event:</p>

        <h4>A. Cara Manual</h4>
        <ol>
            <li>Menu <strong>Event</strong> &rarr; klik <strong>"Tambah Event"</strong>.</li>
            <li>Isi form: nama event, poster, tanggal, waktu, gedung, deskripsi.</li>
            <li>Isi data peserta: tipe peserta, jumlah, durasi.</li>
            <li>Isi perencanaan biaya: konsumsi per orang, biaya lain.</li>
            <li>Isi rundown (1 baris = 1 item).</li>
            <li>Klik <strong>"Simpan Event"</strong>.</li>
        </ol>

        <h4>B. Cara AI (Generate dengan AI)</h4>
        <ol>
            <li>Di form tambah event, klik tombol <strong>"Generate dengan AI"</strong> (di header atau banner).</li>
            <li>Kamu akan diarahkan ke halaman chatbot EventNela AI.</li>
            <li>Ceritakan event yang mau kamu bikin &mdash; bebas, gak usah pakai format.</li>
            <li>AI akan tanya detailnya satu-satu: nama event, tanggal, waktu, gedung, peserta, konsumsi, dll.</li>
            <li>Setelah data lengkap, AI akan kasih preview event.</li>
            <li>Mau revisi? Ketik langsung, misal: "ganti tanggal jadi 20 Oktober".</li>
            <li>Kalau sudah oke, klik <strong>"Setuju, Lanjut Isi Form"</strong>.</li>
            <li>Form akan <strong>otomatis terisi</strong> dengan data dari AI.</li>
            <li>Kamu tinggal lengkapi <strong>poster</strong> (wajib) dan klik <strong>"Simpan Event"</strong>.</li>
        </ol>

        <div class="box-tip">
            Fitur AI sangat membantu kalau kamu bingung bikin rundown atau biaya. AI bisa kasih saran otomatis.
        </div>

        <h3>5.6 Report / LPJ</h3>
        <p>Setelah event selesai (H+1), kamu wajib isi LPJ. Sistem akan otomatis memberi notifikasi di dashboard.</p>

        <p><strong>Cara isi LPJ:</strong></p>
        <ol>
            <li>Buka menu <strong>Report / LPJ</strong>.</li>
            <li>Klik tombol <strong>"Isi Report"</strong> di event yang belum di-report.</li>
            <li>Upload <strong>File Laporan</strong> (PDF/DOC, maks 5MB).</li>
            <li>Isi <strong>Link Google Drive Keuangan</strong> (SPJ, nota, kwitansi) &mdash; pastikan link bisa diakses publik.</li>
            <li>Isi <strong>Link Google Drive Bukti</strong> (foto dokumentasi).</li>
            <li>Klik <strong>"Kirim Report"</strong>.</li>
        </ol>

        <p><strong>Setelah dikirim, LPJ akan diverifikasi 3 pihak:</strong></p>
        <ol>
            <li><strong>Ketua UKM</strong> (otomatis disetujui karena kamu yang submit).</li>
            <li><strong>Pembina UKM</strong>.</li>
            <li><strong>Validator (Wadir III)</strong>.</li>
        </ol>

        <h3>5.7 Cetak Lembar Pengesahan LPJ</h3>
        <p>Kalau 3 pihak sudah menyetujui, kamu bisa cetak lembar pengesahan:</p>
        <ol>
            <li>Buka <strong>Report / LPJ</strong> &rarr; detail report.</li>
            <li>Klik tombol <strong>"Cetak Lembar Pengesahan"</strong>.</li>
            <li>Halaman akan terbuka di tab baru.</li>
            <li>Klik <strong>"Cetak / Simpan PDF"</strong> atau tekan <strong>Ctrl + P</strong>.</li>
            <li>Pilih <strong>"Save as PDF"</strong>, kertas A4, margin default.</li>
            <li>Simpan file PDF di komputer.</li>
        </ol>

        <p>Lembar pengesahan otomatis berisi:</p>
        <ul>
            <li>Kop surat Polinela dengan logo</li>
            <li>Info kegiatan</li>
            <li>Tanda tangan <strong>Pembina</strong> + <strong>Ketua Umum</strong> (sejajar, atas)</li>
            <li>Tanda tangan <strong>Wadir III</strong> (tengah, bawah)</li>
            <li>Badge "Telah Diverifikasi" di setiap kolom TTD</li>
        </ul>
    </div>
</div>

<!-- BAB 5 Part 2 -->
<div class="content-page bab-page">
    <div class="bab-content" style="padding-top: 10px;">
        <h3>5.8 Pengurus</h3>
        <ol>
            <li>Menu <strong>Pengurus</strong> &rarr; klik <strong>"Tambah Pengurus"</strong>.</li>
            <li>Isi: nama lengkap, NPM, jabatan, level hierarki, departemen (opsional), periode, foto.</li>
            <li>Level hierarki menentukan posisi di struktur:
                <ul>
                    <li><strong>1</strong> = Ketua Umum</li>
                    <li><strong>2</strong> = Wakil Ketua Umum</li>
                    <li><strong>3</strong> = Sekretaris / Bendahara</li>
                    <li><strong>4</strong> = Kepala Departemen</li>
                    <li><strong>5</strong> = Wakil Kepala Departemen</li>
                    <li><strong>6</strong> = Staf / Anggota</li>
                </ul>
            </li>
            <li>Klik <strong>"Simpan"</strong>.</li>
        </ol>

        <div class="box-tip">
            Kalau level dibiarkan kosong, sistem akan <strong>auto-deteksi</strong> dari nama jabatan.
        </div>

        <h3>5.9 Departemen</h3>
        <ol>
            <li>Menu <strong>Departemen</strong> &rarr; klik <strong>"Tambah Departemen"</strong>.</li>
            <li>Isi: nama departemen, ikon (nama icon Bootstrap Icons), warna aksen, deskripsi.</li>
            <li>Contoh ikon: <code>cash-coin</code> (keuangan), <code>people-fill</code> (SDM), <code>megaphone-fill</code> (media).</li>
            <li>Klik <strong>"Simpan"</strong>.</li>
        </ol>

        <h3>5.10 Galeri Dokumentasi</h3>
        <ol>
            <li>Menu <strong>Galeri</strong> &rarr; klik <strong>"Upload Foto"</strong>.</li>
            <li>Pilih judul dan deskripsi (opsional).</li>
            <li>Pilih file foto (bisa multiple). Maks 2MB per foto.</li>
            <li>Klik <strong>"Upload Sekarang"</strong>.</li>
        </ol>

        <h3>5.11 Berita</h3>
        <ol>
            <li>Menu <strong>Berita</strong> &rarr; klik <strong>"Tulis Berita"</strong>.</li>
            <li>Isi: judul, konten, foto cover, status (draft/published).</li>
            <li>Klik <strong>"Simpan Berita"</strong>.</li>
        </ol>

        <h3>5.12 Open Recruitment</h3>
        <ol>
            <li>Menu <strong>Recruitment</strong> &rarr; klik <strong>"Buat Recruitment"</strong>.</li>
            <li>Isi: judul, deskripsi, posisi, periode, link grup WA.</li>
            <li>Pilih tahapan seleksi: tes tertulis dan/atau wawancara.</li>
            <li>Klik <strong>"Simpan"</strong>.</li>
            <li>Pantau pendaftar di menu <strong>Pendaftar</strong>. Ubah status mereka (Pending &rarr; Tes &rarr; Wawancara &rarr; Diterima/Ditolak).</li>
        </ol>

        <h3>5.13 Kelola Staf</h3>
        <ol>
            <li>Menu <strong>Kelola Staf</strong> &rarr; klik <strong>"Tambah Staf"</strong>.</li>
            <li>Isi data akun staf (username, email, password, no telp).</li>
            <li>Centang hak akses modul yang boleh diakses staf.</li>
            <li>Klik <strong>"Simpan Staf"</strong>.</li>
            <li>Berikan username &amp; password ke staf yang bersangkutan.</li>
        </ol>

        <h3>5.14 Ulasan Event</h3>
        <p>Lihat semua ulasan dari pengunjung. Bisa hapus ulasan yang tidak pantas.</p>

        <h3>5.15 Profil Ormawa</h3>
        <ol>
            <li>Menu <strong>Profil</strong> &rarr; isi nama ormawa, pembina, visi, misi, deskripsi, Instagram.</li>
            <li>Upload logo ormawa (maks 2MB).</li>
            <li>Ganti foto profil pengguna (opsional).</li>
            <li>Klik <strong>"Simpan Perubahan"</strong>.</li>
        </ol>
    </div>
</div>

<!-- BAB 6 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">6</div>
        <div class="bab-header-text">
            <h2>Panduan Staf Ormawa</h2>
            <small>Akses modular</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>6.1 Hak Akses Modular</h3>
        <p>Staf Ormawa adalah user yang membantu admin UKM. Setiap staf punya hak akses terbatas sesuai modul yang diizinkan admin.</p>
        <p>Contoh: kalau admin kasih akses <strong>"Galeri"</strong>, staf cuma bisa upload foto galeri. Tidak bisa akses ke event atau recruitment.</p>

        <h3>6.2 Profil Saya</h3>
        <ol>
            <li>Klik menu <strong>Profil Saya</strong>.</li>
            <li>Ganti foto profil (maks 2MB).</li>
            <li>Untuk edit email/password, hubungi admin UKM.</li>
        </ol>
    </div>
</div>

<!-- BAB 7 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">7</div>
        <div class="bab-header-text">
            <h2>Panduan Pembina</h2>
            <small>Verifikasi proposal &amp; LPJ</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>7.1 Login Pembina</h3>
        <p>Login pakai akun pembina yang dibuat oleh validator. Kamu akan diarahkan ke Dashboard Pembina.</p>

        <h3>7.2 Verifikasi Proposal</h3>
        <ol>
            <li>Buka menu <strong>Verifikasi Proposal</strong>.</li>
            <li>Lihat daftar proposal dari ormawa yang kamu bina.</li>
            <li>Klik <strong>"Lihat Detail"</strong> pada proposal yang mau diverifikasi.</li>
            <li>Cek: file proposal, deskripsi kegiatan, rundown, dan anggaran.</li>
            <li>Pilih <strong>"Setujui"</strong> atau <strong>"Tolak"</strong>.</li>
            <li>Kalau tolak, wajib isi <strong>catatan alasan</strong>.</li>
            <li>Klik <strong>"Proses Verifikasi"</strong>.</li>
        </ol>

        <div class="box-info">
            Kalau proposal disetujui Pembina, otomatis diteruskan ke Wadir (Validator) untuk verifikasi akhir.
        </div>

        <h3>7.3 Verifikasi LPJ</h3>
        <ol>
            <li>Buka menu <strong>Verifikasi LPJ</strong>.</li>
            <li>Klik <strong>"Lihat Detail"</strong> pada LPJ yang mau diverifikasi.</li>
            <li>Cek: file laporan, link keuangan, link bukti dokumentasi.</li>
            <li>Pilih <strong>"Setujui"</strong> atau <strong>"Tolak"</strong>.</li>
            <li>Kalau tolak, wajib isi <strong>catatan alasan</strong>.</li>
            <li>Klik <strong>"Proses Verifikasi"</strong>.</li>
        </ol>

        <h3>7.4 Profil Pembina</h3>
        <p>Edit email, no telp, dan foto profil di menu <strong>Profil</strong>.</p>
    </div>
</div>

<!-- BAB 8 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">8</div>
        <div class="bab-header-text">
            <h2>Panduan Admin (Pengelola Gedung)</h2>
            <small>Validasi ketersediaan gedung</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>8.1 Dashboard</h3>
        <p>Menampilkan statistik gedung, booking hari ini, booking bulan ini, dan booking terbaru.</p>

        <h3>8.2 Validasi Gedung</h3>
        <ol>
            <li>Buka menu <strong>Validasi Gedung</strong>.</li>
            <li>Lihat daftar event pending yang butuh validasi gedung.</li>
            <li>Klik <strong>"Lihat Detail"</strong> untuk cek ketersediaan.</li>
            <li>Pilih aksi: <strong>Setujui</strong> (teruskan ke Validator) atau <strong>Tolak</strong> (isi catatan).</li>
        </ol>

        <h3>8.3 Kelola Gedung</h3>
        <p>Tambah, edit, atau hapus data master gedung yang tersedia di kampus.</p>
    </div>
</div>

<!-- BAB 9 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">9</div>
        <div class="bab-header-text">
            <h2>Panduan Validator (Wadir III)</h2>
            <small>Validasi progja, proposal, event &amp; LPJ</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>9.1 Dashboard Validator</h3>
        <p>Dashboard menampilkan:</p>
        <ul>
            <li><strong>Statistik event</strong>: total, pending, published, rejected.</li>
            <li><strong>Chart aktivitas validasi</strong> per bulan.</li>
            <li><strong>Progress per ormawa</strong>: terbagi jadi 2 section &mdash; <strong>Progress UKM</strong> dan <strong>Progress HMJ</strong>. Setiap ormawa menampilkan jumlah progja, proposal (dengan progress bar %), dan report (dengan progress bar %).</li>
            <li><strong>LPJ menunggu verifikasi</strong>: list LPJ yang sudah diverifikasi Ketua &amp; Pembina, siap verifikasi akhir Wadir.</li>
        </ul>

        <h3>9.2 Validasi Program Kerja</h3>
        <ol>
            <li>Buka menu <strong>Program Kerja</strong> di sidebar.</li>
            <li>Halaman menampilkan semua progja dari setiap UKM/HMJ yang dikelompokkan per ormawa.</li>
            <li>Setiap card ormawa menampilkan: logo, nama, kategori, statistik badge (pending/approved/ditolak/draft).</li>
            <li>Klik tombol <strong>"Detail"</strong> pada progja yang mau divalidasi.</li>
            <li>Cek info progja: nama, semester, bulan rencana, target peserta, deskripsi, foto.</li>
            <li>Pilih aksi: <strong>"Setujui Program Kerja"</strong> atau <strong>"Tolak Program Kerja"</strong>.</li>
            <li>Kalau tolak, wajib isi <strong>catatan alasan</strong>.</li>
            <li>Klik <strong>"Proses Validasi"</strong>.</li>
        </ol>

        <div class="box-tip">
            Progja yang approved otomatis muncul di menu Proposal ormawa, siap untuk diupload proposalnya.
        </div>

        <h3>9.3 Verifikasi Proposal</h3>
        <ol>
            <li>Buka menu <strong>Proposal</strong> di sidebar.</li>
            <li>Lihat daftar semua proposal dari UKM/HMJ.</li>
            <li>Klik <strong>"Detail"</strong> pada proposal yang mau diverifikasi.</li>
            <li>Cek: file proposal, deskripsi, rundown, anggaran, dan status verifikasi Ketua + Pembina.</li>
            <li>Pilih <strong>"Setujui"</strong> atau <strong>"Tolak"</strong>.</li>
            <li>Kalau tolak, wajib isi <strong>catatan alasan</strong>.</li>
            <li>Klik <strong>"Proses Verifikasi"</strong>.</li>
        </ol>

        <div class="box-info">
            Kalau Wadir sudah approve, ormawa otomatis bisa cetak lembar pengesahan proposal dari menu Proposal.
        </div>

        <h3>9.4 Validasi Event</h3>
        <ol>
            <li>Dashboard &rarr; section <strong>"Event Pending Validasi"</strong>.</li>
            <li>Klik <strong>Setujui</strong> (publish) atau <strong>Tolak</strong>.</li>
        </ol>

        <h3>9.5 Verifikasi LPJ</h3>
        <p>Sama seperti pembina, tapi ini verifikasi <strong>akhir</strong>. Kalau Wadir setuju, lembar pengesahan otomatis bisa dicetak oleh ormawa.</p>

        <h3>9.6 Kelola Ormawa</h3>
        <p>Tambah akun UKM/HMJ baru. Isi: nama ormawa, kategori (HMJ/UKM), pembina, username &amp; password admin ormawa.</p>

        <h3>9.7 Kelola Pembina</h3>
        <ol>
            <li>Menu <strong>Kelola Pembina</strong> &rarr; klik <strong>"Tambah Pembina"</strong>.</li>
            <li>Isi: NIP, nama dosen, ormawa yang dibina, username, password, email, no telp.</li>
            <li>Klik <strong>"Simpan Pembina"</strong>.</li>
            <li>Berikan username &amp; password ke pembina.</li>
        </ol>

        <h3>9.8 Backup Data</h3>
        <p>Menu <strong>Backup Data</strong> punya 2 tombol:</p>
        <ul>
            <li><strong>Rekap Data (CSV)</strong> &rarr; download ZIP berisi 4 CSV (event, LPJ, ormawa, pengurus). Bisa dibuka di Excel.</li>
            <li><strong>Backup Uploads (ZIP)</strong> &rarr; download semua file uploads (poster, laporan, galeri, dll) dalam 1 ZIP.</li>
        </ul>
    </div>
</div>

<!-- BAB 10 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">10</div>
        <div class="bab-header-text">
            <h2>Fitur AI EventNela</h2>
            <small>Asisten pintar 24/7</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>10.1 EventNela AI Chatbot</h3>
        <p><strong>Akses:</strong> Publik &mdash; bisa dipakai tanpa login.</p>
        <p><strong>Cara pakai:</strong></p>
        <ol>
            <li>Klik tombol <strong>AI</strong> di pojok kanan bawah.</li>
            <li>Ketik pertanyaanmu di kolom chat.</li>
            <li>AI akan menjawab dengan data <strong>realtime</strong> dari database EventNela.</li>
        </ol>

        <p><strong>Yang bisa ditanyakan:</strong></p>
        <ul>
            <li>Daftar UKM &amp; kategori</li>
            <li>Event terbaru dan rating</li>
            <li>Open recruitment aktif</li>
            <li>Info gedung di Polinela</li>
            <li>Rekomendasi kegiatan</li>
            <li>Statistik UKM terpopuler</li>
        </ul>

        <h3>10.2 AI Event Generator</h3>
        <p><strong>Akses:</strong> Ormawa (perlu login).</p>
        <p><strong>Cara pakai:</strong></p>
        <ol>
            <li>Buka <strong>Event</strong> &rarr; <strong>Tambah Event</strong>.</li>
            <li>Klik tombol <strong>"Generate dengan AI"</strong>.</li>
            <li>Ceritakan event bebas: "aku mau bikin seminar teknologi".</li>
            <li>AI tanya detail satu-satu. Jawab aja.</li>
            <li>Setelah lengkap, AI kasih preview.</li>
            <li>Klik <strong>"Setuju, Lanjut Isi Form"</strong>.</li>
            <li>Form <strong>otomatis terisi</strong> dengan data dari AI.</li>
        </ol>

        <div class="box-tip">
            <strong>Tips revisi:</strong> Sebelum klik "Setuju", kamu masih bisa ngobrol lagi dengan AI untuk revisi.
            Contoh: "ganti tanggal jadi 20 Oktober", "gedungnya pindah ke Gedung A", "peserta jadi 150 orang".
            AI akan update preview otomatis.
        </div>
    </div>
</div>

<!-- BAB 11 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">11</div>
        <div class="bab-header-text">
            <h2>Alur Lengkap</h2>
            <small>Flow proses utama di EventNela</small>
        </div>
    </div>

    <div class="bab-content">
        <h3>11.1 Alur Program Kerja &amp; Proposal</h3>
        <div class="flow-chart">
+----------------------+
|  ORMAWA buat progja  |
|  status: DRAFT       |
+----------+-----------+
           |
           v
+----------------------+
|  ORMAWA klik "Ajukan"|
|  status: PENDING     |
+----------+-----------+
           |
     [Validator approve?]
           |
   +-------+--------+
   |                |
  NO                YES
   |                |
   v                v
+-----------+  +----------------------+
| REJECTED  |  |  Status: APPROVED    |
| revisi &  |  |  Ormawa bisa upload  |
| ajukan    |  |  PROPOSAL            |
| ulang     |  +----------+-----------+
+-----------+             |
                          v
               +----------------------+
               |  ORMAWA upload       |
               |  PROPOSAL            |
               |  - file PDF          |
               |  - deskripsi         |
               |  - rundown           |
               |  - anggaran          |
               +----------+-----------+
                          |
                          v
               +----------------------+
               |  KETUA (auto approve)|
               +----------+-----------+
                          |
                          v
               +----------------------+
               |  PEMBINA verifikasi  |
               +----------+-----------+
                          |
                          v
               +----------------------+
               |  WADIR verifikasi    |
               +----------+-----------+
                          |
                          v
               +----------------------+
               |  LEMBAR PENGESAHAN   |
               |  PROPOSAL bisa       |
               |  dicetak!            |
               +----------+-----------+
                          |
                          v
               +----------------------+
               |  ORMAWA bisa lanjut  |
               |  AJUKAN EVENT        |
               +----------------------+</div>

        <h3>11.2 Alur Pengajuan Event</h3>
        <div class="flow-chart">
+----------------------+
|  ORMAWA AJUKAN EVENT |
|  (Manual / AI)       |
+----------+-----------+
           |
           v
+----------------------+
|  Status: PENDING     |
|  ADMIN (Validasi     |
|  gedung oleh Admin)  |
+----------+-----------+
           |
     [Setujui?] --- NO ---> [REJECTED ADMIN]
           |
          YES
           v
+----------------------+
|  Status: PENDING     |
|  VALIDATOR (Wadir)   |
+----------+-----------+
           |
     [Setujui?] --- NO ---> [REJECTED VALIDATOR]
           |
          YES
           v
+----------------------+
|  Status: PUBLISHED   |
|  Tampil di publik    |
+----------------------+</div>

        <h3>11.3 Alur LPJ (Laporan Pertanggungjawaban)</h3>
        <div class="flow-chart">
+----------------------+
|  Event Selesai (H+1) |
+----------+-----------+
           |
           v
+----------------------+
|  ORMAWA ISI REPORT   |
|  - Upload laporan    |
|  - Link keuangan     |
|  - Link bukti        |
+----------+-----------+
           |
           v
+----------------------+
|  KETUA (auto approve)|
|  karena yang submit  |
+----------+-----------+
           |
           v
+----------------------+
|  PEMBINA verifikasi  |
+----------+-----------+
           |
           v
+----------------------+
|  WADIR verifikasi    |
|  (final)             |
+----------+-----------+
           |
           v
+----------------------+
|  LEMBAR PENGESAHAN   |
|  bisa dicetak!       |
+----------------------+</div>

        <h3>11.4 Alur Open Recruitment</h3>
        <div class="flow-chart">
+----------------------+
|  ORMAWA buka         |
|  recruitment         |
+----------+-----------+
           |
           v
+----------------------+
|  MAHASISWA lihat &   |
|  isi form daftar     |
+----------+-----------+
           |
           v
+----------------------+
|  Status: PENDING     |
+----------+-----------+
           |
           v
   [Admin UKM ubah status]
           |
   +-------+--------+
   |                |
   v                v
[TES TERTULIS]  [WAWANCARA]
   |                |
   +-------+--------+
           |
   +-------+--------+
   |                |
   v                v
[DITERIMA]      [DITOLAK]</div>
    </div>
</div>

<!-- BAB 12 -->
<div class="content-page bab-page">
    <div class="bab-header">
        <div class="bab-num">12</div>
        <div class="bab-header-text">
            <h2>FAQ</h2>
            <small>Pertanyaan yang sering ditanyakan</small>
        </div>
    </div>

    <div class="bab-content">
        <div class="faq-item">
            <div class="q">1. Apakah harus login untuk melihat UKM &amp; Event?</div>
            <div class="a">Tidak. Kamu bisa jelajah UKM, event, berita, dan open recruitment tanpa login. Login hanya diperlukan untuk memberi ulasan event dan mendaftar recruitment.</div>
        </div>

        <div class="faq-item">
            <div class="q">2. Bagaimana cara mendaftar jadi anggota UKM?</div>
            <div class="a">Buka menu <strong>Open Recruitment</strong>, pilih UKM, klik "Daftar Sekarang", isi form, dan pantau status di menu <strong>Riwayat</strong>.</div>
        </div>

        <div class="faq-item">
            <div class="q">3. Apakah AI Assistant bisa diakses tanpa login?</div>
            <div class="a">Ya. Klik tombol AI di pojok kanan bawah. Bisa dipakai siapa saja.</div>
        </div>

        <div class="faq-item">
            <div class="q">4. Kenapa halaman UKM saya masih kosong?</div>
            <div class="a">Karena data belum diisi. Login sebagai admin UKM, lengkapi profil, pengurus, departemen, progja, dan galeri. Section akan muncul otomatis di halaman publik kalau datanya sudah ada.</div>
        </div>

        <div class="faq-item">
            <div class="q">5. Kenapa progja saya ditolak Validator?</div>
            <div class="a">Cek catatan Validator di detail progja. Biasanya karena target peserta tidak realistis, anggaran tidak wajar, atau deskripsi kurang jelas. Revisi lalu klik "Ajukan" ulang.</div>
        </div>

        <div class="faq-item">
            <div class="q">6. Kenapa proposal saya ditolak?</div>
            <div class="a">Cek catatan verifikator (Ketua, Pembina, atau Wadir) di detail proposal. Bisa jadi file tidak lengkap, rundown kurang detail, atau anggaran melebihi batas. Perbaiki lalu submit ulang.</div>
        </div>

        <div class="faq-item">
            <div class="q">7. Kenapa LPJ saya ditolak?</div>
            <div class="a">Cek catatan verifikator di detail report. Biasanya karena file laporan kurang lengkap, link tidak bisa diakses, atau data tidak sesuai. Perbaiki dan submit ulang.</div>
        </div>

        <div class="faq-item">
            <div class="q">8. Lembar pengesahan saya tidak muncul, kenapa?</div>
            <div class="a">Lembar pengesahan hanya muncul kalau <strong>3 pihak</strong> (Ketua, Pembina, Wadir) sudah menyetujui. Cek status verifikasi di detail proposal atau report.</div>
        </div>

        <div class="faq-item">
            <div class="q">9. Fitur AI Event Generator kadang lambat, kenapa?</div>
            <div class="a">Karena AI memproses data dalam jumlah besar. Tunggu 5-20 detik. Kalau lebih dari 60 detik, coba refresh dan kirim ulang.</div>
        </div>

        <div class="faq-item">
            <div class="q">10. Bagaimana cara reset password?</div>
            <div class="a">Klik "Lupa Password?" di halaman login, masukkan email, cek inbox untuk link reset.</div>
        </div>

        <div class="faq-item">
            <div class="q">11. Apakah bisa pakai EventNela di HP?</div>
            <div class="a">Bisa. Tampilan EventNela sudah <em>responsive</em> &mdash; nyaman dibuka di desktop, tablet, maupun HP.</div>
        </div>

        <div class="faq-item">
            <div class="q">12. Kalau lupa akun pembina, bagaimana?</div>
            <div class="a">Hubungi <strong>Validator (Wadir III)</strong>. Beliau bisa reset password atau buat akun baru untuk pembina.</div>
        </div>
    </div>

    <div style="margin-top: 50px; text-align: center; padding-top: 26px; border-top: 3px double #000; page-break-inside: avoid;">
        <div style="font-size: 14pt; font-weight: bold; color: #000; margin-bottom: 8px;">
            &mdash; SELESAI &mdash;
        </div>
        <p style="font-size: 11pt; color: #000; line-height: 1.8; max-width: 130mm; margin: 0 auto;">
            Terima kasih sudah menggunakan EventNela.<br>
            Semoga platform ini mempermudah kegiatan UKM &amp; Ormawa Politeknik Negeri Lampung.
        </p>
        <div style="margin-top: 26px; font-size: 11pt; color: #000;">
            <strong>POLITEKNIK NEGERI LAMPUNG</strong><br>
            Jl. Soekarno-Hatta No. 10, Rajabasa, Bandar Lampung 35144<br>
            polinela.ac.id
        </div>
    </div>
</div>

</body>
</html>