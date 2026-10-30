<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.tt-page { background: #FFFBF5; }

.tt-hero {
    position: relative;
    padding: 70px 24px 90px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.88) 0%, rgba(230,81,0,.82) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.tt-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.tt-hero-inner {
    position: relative; z-index: 2;
    max-width: 800px; margin: 0 auto; text-align: center;
}
.tt-hero h1 {
    font-size: clamp(30px, 4.5vw, 52px);
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0 0 14px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.tt-hero p {
    font-size: 16.5px;
    color: rgba(255,255,255,.95);
    max-width: 640px;
    margin: 0 auto;
    line-height: 1.7;
    font-weight: 500;
}

.tt-section { padding: 70px 24px; }
.tt-section-white { background: white; }
.tt-section-cream { background: #FFFBF5; }
.tt-inner { max-width: 1000px; margin: 0 auto; }

/* INTRO */
.tt-intro {
    display: flex;
    gap: 50px;
    align-items: center;
    flex-wrap: wrap;
}
.tt-intro-logo {
    flex: 0 0 280px;
    text-align: center;
}
.tt-intro-logo img {
    width: 100%;
    max-width: 280px;
    border-radius: 22px;
    box-shadow: 0 20px 60px rgba(255,122,0,.25);
}
.tt-intro-text { flex: 1; min-width: 300px; }
.tt-intro-text h2 {
    font-size: 28px;
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -.8px;
    margin: 0 0 20px;
}
.tt-intro-text p {
    font-size: 15px;
    color: #475569;
    line-height: 1.85;
    margin: 0 0 16px;
}
.tt-intro-text p strong { color: #FF7A00; font-weight: 800; }

/* INFO CARD */
.tt-card {
    background: white;
    border-radius: 22px;
    padding: 32px 36px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    margin-bottom: 24px;
    border-left: 5px solid #FF7A00;
}
.tt-card h3 {
    font-size: 20px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 16px;
    letter-spacing: -.3px;
    display: flex; align-items: center; gap: 10px;
}
.tt-card h3 i { color: #FF7A00; font-size: 24px; }
.tt-card p,
.tt-card li {
    font-size: 15px;
    color: #475569;
    line-height: 1.85;
}
.tt-card ul { padding-left: 22px; margin: 0; }
.tt-card ul li { margin-bottom: 8px; }

/* FITUR */
.tt-fitur-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 18px;
}
.tt-fitur {
    background: #FAFBFC;
    border-radius: 18px;
    padding: 26px 18px;
    text-align: center;
    transition: .35s;
    border: 2px solid transparent;
}
.tt-fitur:hover {
    background: white;
    border-color: #FFE0B2;
    transform: translateY(-6px);
    box-shadow: 0 15px 40px rgba(255,122,0,.15);
}
.tt-fitur i {
    font-size: 34px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: block;
    margin-bottom: 12px;
}
.tt-fitur h5 {
    font-size: 14.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 6px;
}
.tt-fitur p {
    font-size: 12.5px;
    color: #94A3B8;
    margin: 0;
    line-height: 1.5;
}

/* KONTAK */
.tt-kontak-list {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.tt-kontak-item {
    display: flex;
    align-items: center;
    gap: 14px;
    font-size: 14.5px;
    color: #475569;
}
.tt-kontak-item i {
    width: 44px; height: 44px;
    background: #FFF3E0;
    color: #FF7A00;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}
.tt-kontak-item strong {
    color: #0F172A;
    font-weight: 800;
    display: block;
    margin-bottom: 2px;
}
.tt-kontak-item a {
    color: #E65100;
    text-decoration: none;
    font-weight: 700;
}
.tt-kontak-item a:hover { text-decoration: underline; }

@media (max-width: 768px) {
    .tt-hero { padding: 50px 18px 70px; }
    .tt-section { padding: 50px 18px; }
    .tt-intro { flex-direction: column; gap: 30px; }
    .tt-intro-logo { flex: 1; }
    .tt-intro-text h2 { font-size: 22px; }
    .tt-card { padding: 24px 22px; }
    .tt-fitur-grid { grid-template-columns: repeat(2, 1fr); }
}
</style>

<div class="tt-page">

    <!-- HERO -->
    <section class="tt-hero">
        <div class="tt-hero-inner">
            <h1>Tentang EventNela</h1>
            <p>Platform Digital Politeknik Negeri Lampung untuk Pusat Informasi UKM, Ormawa & Kegiatan Kampus</p>
        </div>
    </section>

    <!-- INTRO -->
    <section class="tt-section tt-section-white">
        <div class="tt-inner">
            <div class="tt-intro">
                <div class="tt-intro-logo">
                    <img src="<?= base_url('assets/images/3.png'); ?>" alt="Logo EventNela">
                </div>
                <div class="tt-intro-text">
                    <h2>Apa itu EventNela?</h2>
                    <p>
                        Logo EventNela dengan huruf <strong>"e" tidur berwarna oranye</strong> melambangkan
                        energi, kreativitas, dan keterhubungan antar kegiatan kampus. Posisi horizontal
                        huruf "e" mencerminkan kestabilan dan semangat kolaborasi.
                    </p>
                    <p>
                        <strong>EventNela</strong> adalah platform digital Politeknik Negeri Lampung yang
                        memudahkan mahasiswa, dosen, dan civitas akademika untuk mengakses informasi
                        kegiatan kampus seperti seminar, lomba, dan workshop dengan cepat dan mudah.
                    </p>
                    <p>
                        Platform ini juga membantu organisasi kampus mempromosikan event mereka,
                        meningkatkan partisipasi mahasiswa, dan menciptakan budaya kampus yang
                        <strong>kreatif, inklusif, dan kolaboratif</strong>.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- TUJUAN -->
    <section class="tt-section tt-section-cream">
        <div class="tt-inner">
            <div class="tt-card">
                <h3><i class="bi bi-bullseye"></i> Tujuan EventNela</h3>
                <ul>
                    <li>Mempermudah penyebaran informasi kegiatan UKM & Ormawa</li>
                    <li>Menyediakan profil lengkap setiap organisasi kemahasiswaan</li>
                    <li>Mendokumentasikan kegiatan organisasi secara digital</li>
                    <li>Memfasilitasi open recruitment anggota baru secara online</li>
                    <li>Menyediakan analisis berbasis AI untuk mendukung kegiatan organisasi</li>
                </ul>
            </div>

            <div class="tt-card">
                <h3><i class="bi bi-info-circle-fill"></i> Pengembangan Sistem</h3>
                <p>
                    EventNela awalnya dikembangkan sebagai <strong>media publikasi event</strong> kampus.
                    Seiring perkembangan kebutuhan, sistem ini dikembangkan lebih lanjut menjadi
                    <strong>pusat informasi UKM & Ormawa</strong> yang terintegrasi dengan berbagai fitur modern,
                    termasuk <strong>AI Assistant</strong> untuk membantu pengguna menemukan informasi dan
                    rekomendasi kegiatan secara cepat.
                </p>
            </div>
        </div>
    </section>

    <!-- FITUR -->
    <section class="tt-section tt-section-white">
        <div class="tt-inner">
            <div style="text-align:center;margin-bottom:40px;">
                <h2 style="font-size:28px;font-weight:900;color:#0F172A;letter-spacing:-.8px;margin:0 0 8px;">Fitur Unggulan</h2>
                <p style="color:#64748B;font-size:15px;margin:0;">Berbagai fitur yang tersedia di EventNela</p>
            </div>

            <div class="tt-fitur-grid">
                <div class="tt-fitur">
                    <i class="bi bi-people-fill"></i>
                    <h5>Profil UKM & Ormawa</h5>
                    <p>Kenali semua organisasi kampus</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-clipboard-check-fill"></i>
                    <h5>Program Kerja</h5>
                    <p>Ajukan & validasi progja ormawa</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-file-earmark-text-fill"></i>
                    <h5>Proposal Kegiatan</h5>
                    <p>Upload & verifikasi proposal</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-calendar-event-fill"></i>
                    <h5>Event Kegiatan</h5>
                    <p>Info acara terkini kampus</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-file-earmark-check-fill"></i>
                    <h5>Report / LPJ</h5>
                    <p>Pertanggungjawaban digital</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-megaphone-fill"></i>
                    <h5>Open Recruitment</h5>
                    <p>Daftar jadi anggota baru</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-images"></i>
                    <h5>Galeri Digital</h5>
                    <p>Dokumentasi kegiatan UKM</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-newspaper"></i>
                    <h5>Berita Terbaru</h5>
                    <p>Update kegiatan kampus</p>
                </div>
                <div class="tt-fitur">
                    <i class="bi bi-robot"></i>
                    <h5>AI Assistant</h5>
                    <p>Asisten pintar 24/7</p>
                </div>
            </div>
        </div>
    </section>

    <!-- KONTAK -->
    <section class="tt-section tt-section-cream">
        <div class="tt-inner">
            <div class="tt-card">
                <h3><i class="bi bi-geo-alt-fill"></i> Kontak & Alamat</h3>

                <div class="tt-kontak-list">
                    <div class="tt-kontak-item">
                        <i class="bi bi-building"></i>
                        <div>
                            <strong>Politeknik Negeri Lampung</strong>
                            Jl. Soekarno Hatta No.10, Rajabasa Raya
                        </div>
                    </div>

                    <div class="tt-kontak-item">
                        <i class="bi bi-geo-alt"></i>
                        <div>
                            Kec. Rajabasa, Kota Bandar Lampung<br>
                            Lampung 35144
                        </div>
                    </div>

                    <div class="tt-kontak-item">
                        <i class="bi bi-telephone"></i>
                        <div>
                            <strong>Telepon</strong>
                            (0721) 703-995
                        </div>
                    </div>

                    <div class="tt-kontak-item">
                        <i class="bi bi-globe"></i>
                        <div>
                            <strong>Website</strong>
                            <a href="https://polinela.ac.id" target="_blank">polinela.ac.id</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>

<?= $this->endSection() ?>