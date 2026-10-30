<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
$isOpen = ($recruitment['status'] ?? '') === 'open';
$hasLogo = !empty($recruitment['logo']) && file_exists('uploads/logo/' . $recruitment['logo']);
?>

<style>
.rcd-page { background: #FFFBF5; }

.rcd-hero {
    position: relative;
    padding: 70px 24px 80px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.9) 0%, rgba(230,81,0,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.rcd-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.rcd-hero-inner {
    position: relative; z-index: 2;
    max-width: 1000px; margin: 0 auto;
}
.rcd-breadcrumb {
    display: flex; gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.75);
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.rcd-breadcrumb a { color: rgba(255,255,255,.9); text-decoration: none; }
.rcd-breadcrumb a:hover { color: #FFD700; }

.rcd-hero-header {
    display: flex;
    align-items: center;
    gap: 26px;
    flex-wrap: wrap;
}
.rcd-logo {
    width: 120px; height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 5px solid rgba(255,255,255,.4);
    box-shadow: 0 15px 40px rgba(0,0,0,.3);
    background: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 48px; color: #FF7A00;
    flex-shrink: 0;
}
.rcd-hero-text { flex: 1; min-width: 260px; }
.rcd-status-pill {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(34,197,94,.25);
    color: #4ADE80;
    padding: 7px 18px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    margin-bottom: 14px;
    border: 1px solid rgba(74,222,128,.4);
    text-transform: uppercase;
    letter-spacing: 1px;
}
.rcd-status-pill.closed {
    background: rgba(200,200,200,.25);
    color: #E2E8F0;
    border-color: rgba(226,232,240,.4);
}
.rcd-hero-text h1 {
    font-size: clamp(24px, 3.5vw, 40px);
    font-weight: 900;
    line-height: 1.2;
    letter-spacing: -1px;
    margin: 0 0 14px;
    color: white;
}
.rcd-hero-org {
    display: flex; align-items: center; gap: 10px;
    font-size: 15px;
    color: rgba(255,255,255,.95);
    font-weight: 600;
}
.rcd-hero-org i { color: #FFD700; font-size: 18px; }

/* QUICK INFO */
.rcd-quick {
    max-width: 1000px;
    margin: -50px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.rcd-quick-card {
    background: white;
    border-radius: 20px;
    padding: 24px 20px;
    text-align: center;
    box-shadow: 0 15px 50px rgba(15,23,42,.12);
    transition: .3s;
    border: 1px solid #F1F5F9;
}
.rcd-quick-card:hover { transform: translateY(-4px); }
.rcd-quick-ico {
    width: 50px; height: 50px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 22px; color: white;
    box-shadow: 0 8px 20px rgba(0,0,0,.12);
}
.rcd-quick-lbl {
    font-size: 11px;
    color: #94A3B8;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-bottom: 4px;
}
.rcd-quick-val {
    font-size: 16px;
    font-weight: 800;
    color: #0F172A;
}

/* SECTIONS */
.rcd-section { padding: 60px 24px; }
.rcd-section-cream { background: #FFFBF5; }
.rcd-section-white { background: white; }
.rcd-inner { max-width: 1000px; margin: 0 auto; }

.rcd-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 22px;
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -.5px;
    margin-bottom: 22px;
    padding-bottom: 16px;
    border-bottom: 3px solid #F1F5F9;
}
.rcd-title i { color: #FF7A00; font-size: 24px; }

.rcd-desc-card {
    background: white;
    border-radius: 20px;
    padding: 28px 32px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    border-left: 5px solid #FF7A00;
    font-size: 15.5px;
    color: #334155;
    line-height: 1.9;
}

.rcd-info-tambahan {
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-radius: 18px;
    padding: 22px 26px;
    margin-top: 24px;
    display: flex;
    gap: 14px;
    align-items: flex-start;
    border-left: 5px solid #FF7A00;
}
.rcd-info-tambahan i {
    font-size: 24px;
    color: #FF7A00;
    flex-shrink: 0;
    margin-top: 2px;
}
.rcd-info-tambahan h6 {
    font-size: 13px;
    font-weight: 800;
    color: #E65100;
    margin: 0 0 6px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.rcd-info-tambahan p {
    font-size: 14px;
    color: #475569;
    margin: 0;
    line-height: 1.7;
}
.rcd-info-tambahan a {
    color: #E65100;
    font-weight: 800;
    text-decoration: underline;
}

/* ALUR */
.rcd-alur-wrap {
    background: white;
    border-radius: 22px;
    padding: 40px 32px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
}
.rcd-alur {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    position: relative;
    flex-wrap: wrap;
}
.rcd-step {
    flex: 1;
    min-width: 130px;
    text-align: center;
    position: relative;
    z-index: 2;
}
.rcd-step-circle {
    width: 66px; height: 66px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 14px;
    font-size: 26px;
    border: 5px solid white;
    box-shadow: 0 8px 25px rgba(255,122,0,.3);
}
.rcd-step h6 {
    font-size: 14px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 4px;
}
.rcd-step p {
    font-size: 12px;
    color: #94A3B8;
    margin: 0;
}

/* CTA */
.rcd-cta {
    border-radius: 24px;
    padding: 50px 40px;
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(255,122,0,.25);
}
.rcd-cta.daftar { background: linear-gradient(135deg, #FF7A00, #E65100); }
.rcd-cta.login {
    background: white;
    color: #0F172A;
    border: 2px solid #FFE0B2;
    box-shadow: 0 10px 40px rgba(15,23,42,.08);
}
.rcd-cta.success {
    background: linear-gradient(135deg, #22C55E, #15803D);
}
.rcd-cta::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 400px; height: 400px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
}
.rcd-cta > * { position: relative; z-index: 2; }
.rcd-cta-icon {
    width: 80px; height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 40px;
    backdrop-filter: blur(10px);
}
.rcd-cta.login .rcd-cta-icon {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
}
.rcd-cta h3 {
    font-size: 24px;
    font-weight: 900;
    letter-spacing: -.8px;
    margin: 0 0 12px;
}
.rcd-cta p {
    font-size: 15px;
    opacity: .95;
    margin: 0 auto 28px;
    max-width: 500px;
    line-height: 1.6;
}
.rcd-cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.rcd-btn {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 15px 34px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 15px;
    text-decoration: none;
    transition: .3s;
    border: none;
    cursor: pointer;
    font-family: inherit;
}
.rcd-btn-primary {
    background: white;
    color: #E65100;
    box-shadow: 0 12px 30px rgba(0,0,0,.15);
}
.rcd-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 45px rgba(0,0,0,.2);
    color: #E65100;
}
.rcd-btn-orange {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 12px 30px rgba(255,122,0,.4);
}
.rcd-btn-orange:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 18px 45px rgba(255,122,0,.5);
}
.rcd-btn-outline {
    background: transparent;
    color: #FF7A00;
    border: 2px solid #FF7A00;
}
.rcd-btn-outline:hover {
    background: #FF7A00;
    color: white;
}

@media (max-width: 768px) {
    .rcd-hero { padding: 40px 18px 60px; }
    .rcd-hero-header { flex-direction: column; text-align: center; }
    .rcd-logo { width: 90px; height: 90px; font-size: 36px; }
    .rcd-hero-org { justify-content: center; }
    .rcd-quick { grid-template-columns: 1fr; gap: 10px; margin-top: -40px; }
    .rcd-section { padding: 40px 18px; }
    .rcd-desc-card { padding: 20px; }
    .rcd-alur-wrap { padding: 24px 20px; }
    .rcd-alur { flex-direction: column; gap: 22px; }
    .rcd-cta { padding: 40px 24px; }
}
</style>

<div class="rcd-page">

    <section class="rcd-hero">
        <div class="rcd-hero-inner">
            <div class="rcd-breadcrumb">
                <a href="<?= base_url('/') ?>">Home</a>
                <span>/</span>
                <a href="<?= base_url('recruitment') ?>">Open Recruitment</a>
                <span>/</span>
                <span><?= esc(substr($recruitment['judul'], 0, 30)) ?>...</span>
            </div>

            <div class="rcd-hero-header">
                <?php if ($hasLogo): ?>
                    <img src="<?= base_url('uploads/logo/' . $recruitment['logo']) ?>" class="rcd-logo" alt="">
                <?php else: ?>
                    <div class="rcd-logo"><i class="bi bi-building"></i></div>
                <?php endif; ?>

                <div class="rcd-hero-text">
                    <div class="rcd-status-pill <?= $isOpen ? '' : 'closed' ?>">
                        <i class="bi bi-<?= $isOpen ? 'unlock-fill' : 'lock-fill' ?>"></i>
                        <?= $isOpen ? 'Sedang Buka' : 'Sudah Ditutup' ?>
                    </div>
                    <h1><?= esc($recruitment['judul']) ?></h1>
                    <div class="rcd-hero-org">
                        <i class="bi bi-building-fill"></i>
                        <span><?= esc($recruitment['nama_ormawa']) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- QUICK INFO -->
    <div class="rcd-quick">
        <div class="rcd-quick-card">
            <div class="rcd-quick-ico" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                <i class="bi bi-tag-fill"></i>
            </div>
            <div class="rcd-quick-lbl">Posisi</div>
            <div class="rcd-quick-val"><?= esc($recruitment['posisi'] ?? 'Anggota') ?></div>
        </div>
        <div class="rcd-quick-card">
            <div class="rcd-quick-ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <i class="bi bi-calendar3"></i>
            </div>
            <div class="rcd-quick-lbl">Periode</div>
            <div class="rcd-quick-val"><?= esc($recruitment['periode'] ?? 'TBA') ?></div>
        </div>
        <div class="rcd-quick-card">
            <div class="rcd-quick-ico" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                <i class="bi bi-building-fill"></i>
            </div>
            <div class="rcd-quick-lbl">Ormawa</div>
            <div class="rcd-quick-val"><?= esc(substr($recruitment['nama_ormawa'], 0, 22)) ?></div>
        </div>
    </div>

    <!-- DESKRIPSI -->
    <section class="rcd-section rcd-section-white">
        <div class="rcd-inner">
            <div class="rcd-title"><i class="bi bi-file-text-fill"></i> Deskripsi Recruitment</div>

            <div class="rcd-desc-card">
                <?= nl2br(esc($recruitment['deskripsi'] ?? 'Belum ada deskripsi.')) ?>
            </div>

            <?php if (!empty($recruitment['link_pendaftaran'])): ?>
                <div class="rcd-info-tambahan">
                    <i class="bi bi-info-circle-fill"></i>
                    <div>
                        <h6>Info Tambahan</h6>
                        <p>
                            Jika ingin melihat panduan/materi rekrutmen, kunjungi
                            <a href="<?= esc($recruitment['link_pendaftaran']) ?>" target="_blank">
                                tautan berikut <i class="bi bi-box-arrow-up-right" style="font-size: 11px;"></i>
                            </a>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- ALUR SELEKSI -->
    <section class="rcd-section rcd-section-cream">
        <div class="rcd-inner">
            <div class="rcd-title"><i class="bi bi-diagram-3-fill"></i> Alur Seleksi</div>

            <div class="rcd-alur-wrap">
                <?php
                $pakaiTes = !empty($recruitment['pakai_tes_tertulis']);
                $pakaiWawancara = !empty($recruitment['pakai_wawancara']) || !isset($recruitment['pakai_wawancara']);

                $steps = [];
                $steps[] = ['icon' => 'pencil-square',      'title' => 'Pendaftaran',    'desc' => 'Isi form online'];
                $steps[] = ['icon' => 'file-earmark-check', 'title' => 'Seleksi Berkas', 'desc' => 'Review data'];
                if ($pakaiTes) $steps[] = ['icon' => 'pencil-fill', 'title' => 'Tes Tertulis', 'desc' => 'Ujian tulis'];
                if ($pakaiWawancara) $steps[] = ['icon' => 'chat-dots-fill', 'title' => 'Wawancara', 'desc' => 'Interview'];
                $steps[] = ['icon' => 'trophy-fill', 'title' => 'Pengumuman', 'desc' => 'Hasil akhir'];
                ?>

                <div class="rcd-alur">
                    <?php foreach ($steps as $s): ?>
                        <div class="rcd-step">
                            <div class="rcd-step-circle"><i class="bi bi-<?= $s['icon'] ?>"></i></div>
                            <h6><?= $s['title'] ?></h6>
                            <p><?= $s['desc'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="rcd-section rcd-section-white">
        <div class="rcd-inner">
            <?php if (session()->get('logged_in') && session()->get('role') === 'mahasiswa'): ?>

                <?php if ($sudah_daftar): ?>
                    <div class="rcd-cta success">
                        <div class="rcd-cta-icon"><i class="bi bi-check-circle-fill"></i></div>
                        <h3>Kamu Sudah Mendaftar! 🎉</h3>
                        <p>Pantau status pendaftaranmu di menu "Pendaftaran Saya" untuk melihat hasil seleksi.</p>
                        <div class="rcd-cta-btns">
                            <a href="<?= site_url('recruitment/riwayat') ?>" class="rcd-btn rcd-btn-primary">
                                <i class="bi bi-clock-history"></i> Lihat Status
                            </a>
                        </div>
                    </div>
                <?php elseif (!$isOpen): ?>
                    <div class="rcd-cta login">
                        <div class="rcd-cta-icon"><i class="bi bi-lock-fill"></i></div>
                        <h3>Recruitment Sudah Ditutup</h3>
                        <p>Pendaftaran untuk recruitment ini sudah ditutup. Silakan lihat recruitment lain yang masih dibuka.</p>
                        <div class="rcd-cta-btns">
                            <a href="<?= base_url('recruitment') ?>" class="rcd-btn rcd-btn-orange">
                                <i class="bi bi-search"></i> Cari Recruitment Lain
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="rcd-cta daftar">
                        <div class="rcd-cta-icon"><i class="bi bi-pencil-square"></i></div>
                        <h3>Mau Gabung Jadi Anggota? 🚀</h3>
                        <p>Isi form pendaftaran online sekarang. Tidak perlu Google Form, semua di website!</p>
                        <div class="rcd-cta-btns">
                            <a href="<?= site_url('recruitment/form-daftar/' . $recruitment['id_recruitment']) ?>"
                               class="rcd-btn rcd-btn-primary">
                                <i class="bi bi-send-fill"></i> Daftar Sekarang
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            <?php elseif (!session()->get('logged_in')): ?>
                <div class="rcd-cta login">
                    <div class="rcd-cta-icon"><i class="bi bi-person-lock"></i></div>
                    <h3>Ingin Mendaftar?</h3>
                    <p>Silakan login atau daftar akun terlebih dahulu untuk mendaftar recruitment ini.</p>
                    <div class="rcd-cta-btns">
                        <a href="<?= site_url('login?redirect=' . urlencode(current_url())) ?>" class="rcd-btn rcd-btn-orange">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </a>
                        <a href="<?= site_url('register?redirect=' . urlencode(current_url())) ?>" class="rcd-btn rcd-btn-outline">
                            <i class="bi bi-person-plus"></i> Daftar Akun
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="rcd-cta login">
                    <div class="rcd-cta-icon"><i class="bi bi-info-circle-fill"></i></div>
                    <h3>Akses Terbatas</h3>
                    <p>Anda login sebagai <strong><?= session()->get('role') ?></strong>. Untuk mendaftar recruitment, gunakan akun mahasiswa.</p>
                    <div class="rcd-cta-btns">
                        <a href="<?= base_url('recruitment') ?>" class="rcd-btn rcd-btn-orange">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?= $this->endSection() ?>