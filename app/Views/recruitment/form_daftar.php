<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.rf-page { background: #FFFBF5; padding: 40px 24px 80px; }

.rf-hero {
    max-width: 800px;
    margin: 0 auto 30px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    border-radius: 24px;
    padding: 40px 40px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(255,122,0,.3);
}
.rf-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 400px; height: 400px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
}
.rf-hero > * { position: relative; z-index: 2; }
.rf-hero .breadcrumb {
    display: flex; gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.8);
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.rf-hero .breadcrumb a {
    color: rgba(255,255,255,.9);
    text-decoration: none;
}
.rf-hero h1 {
    font-size: 28px;
    font-weight: 900;
    letter-spacing: -.8px;
    margin: 0 0 10px;
}
.rf-hero p {
    font-size: 14.5px;
    opacity: .95;
    margin: 0;
    line-height: 1.6;
}

.rf-form-wrap {
    max-width: 800px;
    margin: 0 auto;
    background: white;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    border: 1px solid #F1F5F9;
}
.rf-section-title {
    font-size: 14px;
    font-weight: 800;
    color: #FF7A00;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 0 0 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #F1F5F9;
    display: flex; align-items: center; gap: 8px;
}
.rf-section-title i { font-size: 16px; }

.rf-group { margin-bottom: 20px; }
.rf-group label {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 8px;
}
.rf-group label .req { color: #EF4444; }
.rf-group input,
.rf-group textarea {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #F1F5F9;
    border-radius: 14px;
    font-size: 14.5px;
    font-family: inherit;
    outline: none;
    transition: .25s;
    background: #FAFBFC;
    color: #0F172A;
}
.rf-group input:focus,
.rf-group textarea:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.rf-group textarea {
    resize: vertical;
    min-height: 110px;
    line-height: 1.6;
}
.rf-group .hint {
    font-size: 12px;
    color: #94A3B8;
    margin-top: 6px;
    display: flex; align-items: center; gap: 4px;
}

.rf-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}
.rf-row .rf-group { margin-bottom: 0; }

.rf-buttons {
    display: flex;
    gap: 12px;
    margin-top: 30px;
    padding-top: 26px;
    border-top: 2px solid #F1F5F9;
    flex-wrap: wrap;
}
.rf-btn {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 14.5px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    font-family: inherit;
    transition: .3s;
}
.rf-btn-primary {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 12px 30px rgba(255,122,0,.35);
}
.rf-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 45px rgba(255,122,0,.45);
    color: white;
}
.rf-btn-light {
    background: white;
    color: #64748B;
    border: 2px solid #E2E8F0;
}
.rf-btn-light:hover {
    border-color: #FF7A00;
    color: #E65100;
}

@media (max-width: 768px) {
    .rf-page { padding: 24px 18px 60px; }
    .rf-hero { padding: 28px 24px; }
    .rf-hero h1 { font-size: 22px; }
    .rf-form-wrap { padding: 24px; }
    .rf-row { grid-template-columns: 1fr; }
    .rf-buttons { flex-direction: column; }
    .rf-btn { justify-content: center; width: 100%; }
}
</style>

<div class="rf-page">

    <div class="rf-hero">
        <div class="breadcrumb">
            <a href="<?= base_url('/') ?>">Home</a>
            <span>/</span>
            <a href="<?= base_url('recruitment') ?>">Recruitment</a>
            <span>/</span>
            <a href="<?= base_url('recruitment/detail/'.$recruitment['id_recruitment']) ?>"><?= esc(substr($recruitment['judul'], 0, 25)) ?>...</a>
            <span>/</span>
            <span>Form Pendaftaran</span>
        </div>
        <h1>📝 Form Pendaftaran</h1>
        <p><strong><?= esc($recruitment['judul']) ?></strong> — <?= esc($recruitment['nama_ormawa']) ?> (<?= esc($recruitment['posisi'] ?? 'Anggota') ?>)</p>
    </div>

    <div class="rf-form-wrap">
        <form action="<?= site_url('recruitment/simpan-pendaftaran') ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="id_recruitment" value="<?= $recruitment['id_recruitment'] ?>">

            <div class="rf-section-title">
                <i class="bi bi-person-fill"></i> Data Diri
            </div>

            <div class="rf-group">
                <label>Nama Lengkap <span class="req">*</span></label>
                <input type="text" name="nama_lengkap" required placeholder="Sesuai KTM">
            </div>

            <div class="rf-row">
                <div class="rf-group">
                    <label>NIM <span class="req">*</span></label>
                    <input type="text" name="nim" required placeholder="Contoh: 2317051001">
                </div>
                <div class="rf-group">
                    <label>Program Studi</label>
                    <input type="text" name="prodi" placeholder="Contoh: D3 Manajemen Informatika">
                </div>
            </div>

            <div class="rf-row">
                <div class="rf-group">
                    <label>No. HP / WA</label>
                    <input type="text" name="no_hp" placeholder="08123456789">
                </div>
                <div class="rf-group">
                    <label>Email <span class="req">*</span></label>
                    <input type="email" name="email" required placeholder="nama@student.polinela.ac.id">
                </div>
            </div>

            <div class="rf-section-title" style="margin-top: 30px;">
                <i class="bi bi-chat-quote-fill"></i> Motivasi
            </div>

            <div class="rf-group">
                <label>Alasan Bergabung</label>
                <textarea name="alasan" placeholder="Ceritakan mengapa kamu ingin bergabung dengan UKM/Ormawa ini..."></textarea>
                <div class="hint">
                    <i class="bi bi-info-circle"></i>
                    Jawaban yang jelas dan tulus akan meningkatkan peluang lolos seleksi
                </div>
            </div>

            <div class="rf-buttons">
                <button type="submit" class="rf-btn rf-btn-primary">
                    <i class="bi bi-send-fill"></i> Kirim Pendaftaran
                </button>
                <a href="<?= site_url('recruitment/detail/'.$recruitment['id_recruitment']) ?>" class="rf-btn rf-btn-light">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </form>
    </div>

</div>

<?= $this->endSection() ?>