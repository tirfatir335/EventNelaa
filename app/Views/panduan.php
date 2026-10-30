<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.pd-page { background: #FFFBF5; }

.pd-hero {
    position: relative;
    padding: 70px 24px 90px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.88) 0%, rgba(230,81,0,.82) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.pd-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.pd-hero-inner {
    position: relative; z-index: 2;
    max-width: 800px; margin: 0 auto; text-align: center;
}
.pd-hero h1 {
    font-size: clamp(30px, 4.5vw, 52px);
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0 0 14px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.pd-hero p {
    font-size: 16.5px;
    color: rgba(255,255,255,.95);
    max-width: 620px;
    margin: 0 auto 30px;
    line-height: 1.7;
    font-weight: 500;
}
.pd-download-btn {
    display: inline-flex; align-items: center; gap: 10px;
    background: white;
    color: #E65100;
    padding: 16px 36px;
    border-radius: 50px;
    font-size: 15px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 15px 40px rgba(0,0,0,.2);
    transition: .3s;
}
.pd-download-btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 25px 55px rgba(0,0,0,.3);
    color: #E65100;
}

.pd-section { padding: 70px 24px; }
.pd-section-white { background: white; }
.pd-section-cream { background: #FFFBF5; }
.pd-inner { max-width: 1000px; margin: 0 auto; }

.pd-section-head {
    text-align: center;
    margin-bottom: 46px;
}
.pd-kicker {
    display: inline-flex; align-items: center; gap: 6px;
    background: #FFF3E0;
    color: #E65100;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 14px;
}
.pd-section-head h2 {
    font-size: clamp(26px, 3.5vw, 40px);
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -1.2px;
    margin: 0 0 12px;
    line-height: 1.15;
}
.pd-section-head h2 span { color: #FF7A00; }
.pd-section-head p {
    font-size: 15px;
    color: #64748B;
    max-width: 580px;
    margin: 0 auto;
    line-height: 1.65;
}

/* ROLE CARDS */
.pd-role-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}
.pd-role-card {
    background: white;
    border-radius: 22px;
    padding: 30px 24px;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .35s;
    border: 1px solid #F1F5F9;
    border-top: 5px solid #FF7A00;
}
.pd-role-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
}
.pd-role-icon {
    width: 60px; height: 60px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 26px;
    margin-bottom: 20px;
    box-shadow: 0 10px 25px rgba(0,0,0,.12);
}
.pd-role-card h4 {
    font-size: 17px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 8px;
    letter-spacing: -.3px;
}
.pd-role-card p {
    font-size: 13.5px;
    color: #64748B;
    line-height: 1.65;
    margin: 0;
}

/* INFO DOWNLOAD */
.pd-info-box {
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-left: 5px solid #FF7A00;
    border-radius: 20px;
    padding: 28px 32px;
    margin-top: 50px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}
.pd-info-box i {
    font-size: 36px;
    color: #FF7A00;
    flex-shrink: 0;
}
.pd-info-box h5 {
    font-size: 15.5px;
    font-weight: 800;
    color: #E65100;
    margin: 0 0 8px;
}
.pd-info-box p {
    font-size: 14px;
    color: #475569;
    line-height: 1.75;
    margin: 0;
}
.pd-info-box strong { color: #E65100; }

@media (max-width: 768px) {
    .pd-hero { padding: 50px 18px 70px; }
    .pd-section { padding: 50px 18px; }
    .pd-role-grid { grid-template-columns: 1fr; }
    .pd-info-box { flex-direction: column; gap: 14px; padding: 22px; }
    .pd-download-btn { padding: 14px 28px; font-size: 14px; }
}
</style>

<div class="pd-page">

    <!-- HERO -->
    <section class="pd-hero">
        <div class="pd-hero-inner">
            <h1>Panduan Penggunaan EventNela</h1>
            <p>Pelajari semua fitur EventNela dari A sampai  Z untuk semua role: Mahasiswa, Ormawa, Pembina, Admin, dan Validator.</p>

            <a href="<?= base_url('panduan/pdf') ?>" target="_blank" class="pd-download-btn">
                <i class="bi bi-file-earmark-pdf-fill"></i>
                Download Panduan Lengkap (PDF)
            </a>
        </div>
    </section>

    <!-- ROLE -->
    <section class="pd-section pd-section-white">
        <div class="pd-inner">
            <div class="pd-section-head">
                <div class="pd-kicker"><i class="bi bi-people-fill"></i> Pengguna</div>
                <h2>Siapa Saja Pengguna <span>EventNela</span>?</h2>
                <p>Setiap role punya fitur dan tanggung jawab yang berbeda</p>
            </div>

            <div class="pd-role-grid">
                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                        <i class="bi bi-globe"></i>
                    </div>
                    <h4>Publik / Pengunjung</h4>
                    <p>Lihat event, UKM, berita, dan recruitment tanpa perlu login.</p>
                </div>

                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <h4>Mahasiswa</h4>
                    <p>Beri ulasan event, daftar open recruitment, dan pantau status pendaftaran.</p>
                </div>

                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h4>Ormawa / Admin UKM</h4>
                    <p>Kelola progja, upload proposal, event, report LPJ, pengurus, recruitment, dan lainnya.</p>
                </div>

                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <h4>Staf Ormawa</h4>
                    <p>Akses modular sesuai izin dari admin UKM.</p>
                </div>

                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #EC4899, #BE185D);">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h4>Pembina UKM</h4>
                    <p>Verifikasi proposal dan LPJ dari UKM yang dibina.</p>
                </div>

                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #14B8A6, #0F766E);">
                        <i class="bi bi-building-gear"></i>
                    </div>
                    <h4>Admin (Pengelola Gedung)</h4>
                    <p>Validasi ketersediaan gedung dan kelola master gedung.</p>
                </div>

                <div class="pd-role-card">
                    <div class="pd-role-icon" style="background: linear-gradient(135deg, #F59E0B, #B45309);">
                        <i class="bi bi-shield-fill-check"></i>
                    </div>
                    <h4>Validator (Wadir)</h4>
                    <p>Validasi progja dan event, verifikasi proposal dan LPJ, kelola ormawa, backup data.</p>
                </div>
            </div>

            <div class="pd-info-box">
                <i class="bi bi-info-circle-fill"></i>
                <div>
                    <h5>Ingin panduan lengkap?</h5>
                    <p>
                        Klik tombol <strong>"Download Panduan Lengkap"</strong> di atas untuk membuka versi cetak.
                        Di sana kamu bisa klik <strong>"Cetak / Simpan PDF"</strong> atau tekan
                        <strong>Ctrl + P</strong> untuk menyimpan sebagai file PDF.
                    </p>
                </div>
            </div>
        </div>
    </section>

</div>

<?= $this->endSection() ?>