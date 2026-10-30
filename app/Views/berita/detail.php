<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
$hasImg = !empty($berita['foto']) && file_exists('uploads/berita/' . $berita['foto']);
$hasLogo = !empty($berita['logo']) && file_exists('uploads/logo/' . $berita['logo']);
?>

<style>
/* ============================================
   BERITA DETAIL
   ============================================ */
.nbd-page { background: #FFFBF5; }

/* HERO */
.nbd-hero {
    position: relative;
    padding: 60px 24px 70px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.9) 0%, rgba(230,81,0,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.nbd-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.nbd-hero-inner {
    position: relative; z-index: 2;
    max-width: 1000px; margin: 0 auto;
}
.nbd-breadcrumb {
    display: flex; gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.75);
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.nbd-breadcrumb a { color: rgba(255,255,255,.9); text-decoration: none; transition: .2s; }
.nbd-breadcrumb a:hover { color: #FFD700; }

.nbd-hero-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.3);
    padding: 7px 16px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.nbd-hero h1 {
    font-size: clamp(24px, 4vw, 40px);
    font-weight: 900;
    line-height: 1.2;
    letter-spacing: -1.2px;
    margin: 0 0 20px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.nbd-hero-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    font-size: 14px;
    color: rgba(255,255,255,.95);
}
.nbd-hero-meta span {
    display: inline-flex; align-items: center; gap: 6px;
}
.nbd-hero-meta i { color: #FFD700; }

/* COVER */
.nbd-cover-wrap {
    max-width: 1000px;
    margin: -30px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 5;
}
.nbd-cover {
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 25px 70px rgba(15,23,42,.2);
    aspect-ratio: 16/9;
    background: linear-gradient(135deg, #FF7A00, #E65100);
}
.nbd-cover img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
}
.nbd-cover .no-cover {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.5); font-size: 100px;
}

/* CONTENT */
.nbd-section {
    padding: 60px 24px 80px;
}
.nbd-inner {
    max-width: 1000px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 40px;
}

/* ARTICLE */
.nbd-article {
    background: white;
    border-radius: 22px;
    padding: 40px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    border: 1px solid #F1F5F9;
}
.nbd-org-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 20px;
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-radius: 16px;
    margin-bottom: 30px;
    border-left: 5px solid #FF7A00;
}
.nbd-org-card img,
.nbd-org-card .logo-default {
    width: 56px; height: 56px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid white;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    flex-shrink: 0;
}
.nbd-org-card .logo-default {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
.nbd-org-card-info { flex: 1; }
.nbd-org-card-info small {
    font-size: 11px;
    color: #94A3B8;
    text-transform: uppercase;
    font-weight: 800;
    letter-spacing: 1px;
}
.nbd-org-card-info h5 {
    margin: 4px 0 0;
    font-size: 16px;
    font-weight: 800;
    color: #0F172A;
}
.nbd-org-link {
    color: #E65100;
    font-weight: 800;
    font-size: 12px;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 4px;
    transition: .2s;
    flex-shrink: 0;
}
.nbd-org-link:hover { transform: translateX(3px); color: #E65100; }

.nbd-content {
    font-size: 16px;
    color: #334155;
    line-height: 1.9;
}
.nbd-content p { margin-bottom: 18px; }
.nbd-content a { color: #FF7A00; font-weight: 600; text-decoration: underline; }

/* SHARE */
.nbd-footer {
    margin-top: 36px;
    padding-top: 26px;
    border-top: 2px solid #F1F5F9;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 16px;
}
.nbd-footer .label {
    font-size: 13px;
    color: #64748B;
    font-weight: 800;
    display: inline-flex; align-items: center; gap: 6px;
}
.nbd-footer .label i { color: #FF7A00; }
.nbd-share {
    display: flex; gap: 8px;
}
.nbd-share-btn {
    width: 42px; height: 42px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 16px;
    text-decoration: none;
    transition: .3s;
    border: none;
    cursor: pointer;
}
.nbd-share-btn:hover { transform: translateY(-3px) scale(1.1); color: white; }
.nbd-share-btn.wa { background: #25D366; }
.nbd-share-btn.fb { background: #1877F2; }
.nbd-share-btn.tw { background: #1DA1F2; }
.nbd-share-btn.copy { background: linear-gradient(135deg, #FF7A00, #E65100); }

/* SIDEBAR */
.nbd-sidebar {
    display: flex;
    flex-direction: column;
    gap: 24px;
}
.nbd-sidebar-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(15,23,42,.06);
    border: 1px solid #F1F5F9;
}
.nbd-sidebar-header {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    padding: 16px 22px;
    font-size: 13.5px;
    font-weight: 800;
    display: flex; align-items: center; gap: 10px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.nbd-sidebar-header i { font-size: 18px; }
.nbd-sidebar-body { padding: 16px; }

.nbd-other-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    text-decoration: none;
    color: inherit;
    transition: .3s;
    margin-bottom: 4px;
}
.nbd-other-item:hover {
    background: #FFF3E0;
    color: inherit;
    transform: translateX(3px);
}
.nbd-other-img,
.nbd-other-img-default {
    width: 62px; height: 62px;
    border-radius: 10px;
    object-fit: cover;
    flex-shrink: 0;
}
.nbd-other-img-default {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
}
.nbd-other-info { flex: 1; min-width: 0; }
.nbd-other-info h6 {
    font-size: 13px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 6px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.nbd-other-info small {
    font-size: 11px;
    color: #94A3B8;
    display: inline-flex; align-items: center; gap: 4px;
}
.nbd-other-info small i { color: #FF7A00; }

.nbd-org-sidebar-body {
    padding: 24px 20px;
    text-align: center;
}
.nbd-org-sidebar-body img,
.nbd-org-sidebar-body .logo-default {
    width: 84px; height: 84px;
    border-radius: 50%;
    object-fit: cover;
    margin: 0 auto 14px;
    border: 4px solid #FFF3E0;
    display: block;
}
.nbd-org-sidebar-body .logo-default {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 32px;
}
.nbd-org-sidebar-body h6 {
    font-size: 15px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 6px;
    line-height: 1.4;
}
.nbd-org-sidebar-body p {
    font-size: 12.5px;
    color: #94A3B8;
    margin: 0 0 18px;
}
.nbd-btn-lihat {
    display: inline-flex; align-items: center; gap: 6px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    padding: 11px 22px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    transition: .3s;
    box-shadow: 0 8px 20px rgba(255,122,0,.3);
}
.nbd-btn-lihat:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(255,122,0,.45);
    color: white;
}

/* BACK */
.nbd-back-wrap {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 24px 40px;
}
.nbd-back {
    display: inline-flex; align-items: center; gap: 8px;
    background: white;
    color: #E65100;
    border: 2px solid #FFE0B2;
    padding: 13px 26px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    transition: .3s;
}
.nbd-back:hover {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border-color: transparent;
    transform: translateX(-5px);
}

@media (max-width: 992px) {
    .nbd-inner { grid-template-columns: 1fr; gap: 30px; }
}
@media (max-width: 768px) {
    .nbd-hero { padding: 40px 18px 60px; }
    .nbd-hero h1 { font-size: 22px; }
    .nbd-hero-meta { font-size: 12px; gap: 14px; }
    .nbd-cover { aspect-ratio: 4/3; }
    .nbd-article { padding: 24px 20px; }
    .nbd-content { font-size: 15px; }
    .nbd-section { padding: 40px 18px 60px; }
    .nbd-footer { flex-direction: column; align-items: flex-start; }
}
</style>

<div class="nbd-page">

    <!-- HERO -->
    <section class="nbd-hero">
        <div class="nbd-hero-inner">

            <div class="nbd-breadcrumb">
                <a href="<?= base_url('/') ?>">Home</a>
                <span>/</span>
                <a href="<?= base_url('berita') ?>">Berita</a>
                <span>/</span>
                <span><?= esc(substr($berita['judul'], 0, 30)) ?>...</span>
            </div>

            <div class="nbd-hero-badge">
                <i class="bi bi-newspaper"></i> Berita UKM / Ormawa
            </div>

            <h1><?= esc($berita['judul']) ?></h1>

            <div class="nbd-hero-meta">
                <span><i class="bi bi-building-fill"></i><?= esc($berita['nama_ormawa']) ?></span>
                <span><i class="bi bi-calendar3"></i><?= date('d F Y', strtotime($berita['created_at'])) ?></span>
                <span><i class="bi bi-clock-fill"></i><?= date('H:i', strtotime($berita['created_at'])) ?> WIB</span>
            </div>

        </div>
    </section>

    <!-- COVER -->
    <?php if ($hasImg): ?>
        <div class="nbd-cover-wrap">
            <div class="nbd-cover">
                <img src="<?= base_url('uploads/berita/' . $berita['foto']) ?>" alt="">
            </div>
        </div>
    <?php endif; ?>

    <!-- CONTENT -->
    <section class="nbd-section">
        <div class="nbd-inner">

            <!-- ARTIKEL -->
            <article class="nbd-article">

                <div class="nbd-org-card">
                    <?php if ($hasLogo): ?>
                        <img src="<?= base_url('uploads/logo/' . $berita['logo']) ?>" alt="">
                    <?php else: ?>
                        <div class="logo-default"><i class="bi bi-building"></i></div>
                    <?php endif; ?>
                    <div class="nbd-org-card-info">
                        <small>Dipublikasikan oleh</small>
                        <h5><?= esc($berita['nama_ormawa']) ?></h5>
                    </div>
                    <a href="<?= base_url('ukm/detail/' . $berita['id_ormawa']) ?>" class="nbd-org-link">
                        Profil <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="nbd-content">
                    <?= nl2br(esc($berita['konten'])) ?>
                </div>

                <div class="nbd-footer">
                    <div class="label">
                        <i class="bi bi-share-fill"></i>
                        Bagikan berita ini:
                    </div>
                    <div class="nbd-share">
                        <a href="https://wa.me/?text=<?= urlencode($berita['judul'] . ' - ' . current_url()) ?>"
                           target="_blank" class="nbd-share-btn wa" title="WhatsApp">
                            <i class="bi bi-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(current_url()) ?>"
                           target="_blank" class="nbd-share-btn fb" title="Facebook">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($berita['judul']) ?>&url=<?= urlencode(current_url()) ?>"
                           target="_blank" class="nbd-share-btn tw" title="Twitter">
                            <i class="bi bi-twitter-x"></i>
                        </a>
                        <button onclick="nbdCopyLink()" class="nbd-share-btn copy" title="Copy Link">
                            <i class="bi bi-link-45deg"></i>
                        </button>
                    </div>
                </div>

            </article>

            <!-- SIDEBAR -->
            <aside class="nbd-sidebar">

                <?php if (!empty($berita_lain)): ?>
                    <div class="nbd-sidebar-card">
                        <div class="nbd-sidebar-header">
                            <i class="bi bi-newspaper"></i>
                            Berita Lainnya
                        </div>
                        <div class="nbd-sidebar-body">
                            <?php
                            $count = 0;
                            foreach ($berita_lain as $bl):
                                if ($bl['id_berita'] == $berita['id_berita']) continue;
                                if ($count >= 4) break;
                                $count++;
                                $hasThumb = !empty($bl['foto']) && file_exists('uploads/berita/' . $bl['foto']);
                            ?>
                                <a href="<?= base_url('berita/detail/' . $bl['id_berita']) ?>" class="nbd-other-item">
                                    <?php if ($hasThumb): ?>
                                        <img src="<?= base_url('uploads/berita/' . $bl['foto']) ?>" class="nbd-other-img" alt="">
                                    <?php else: ?>
                                        <div class="nbd-other-img-default"><i class="bi bi-newspaper"></i></div>
                                    <?php endif; ?>
                                    <div class="nbd-other-info">
                                        <h6><?= esc($bl['judul']) ?></h6>
                                        <small>
                                            <i class="bi bi-calendar3"></i>
                                            <?= date('d M Y', strtotime($bl['created_at'])) ?>
                                        </small>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="nbd-sidebar-card">
                    <div class="nbd-sidebar-header">
                        <i class="bi bi-building"></i>
                        Tentang Ormawa
                    </div>
                    <div class="nbd-org-sidebar-body">
                        <?php if ($hasLogo): ?>
                            <img src="<?= base_url('uploads/logo/' . $berita['logo']) ?>" alt="">
                        <?php else: ?>
                            <div class="logo-default"><i class="bi bi-building"></i></div>
                        <?php endif; ?>
                        <h6><?= esc($berita['nama_ormawa']) ?></h6>
                        <p>Lihat profil lengkap, pengurus, program kerja, dan kegiatan lainnya</p>
                        <a href="<?= base_url('ukm/detail/' . $berita['id_ormawa']) ?>" class="nbd-btn-lihat">
                            <i class="bi bi-eye-fill"></i> Lihat Profil
                        </a>
                    </div>
                </div>

            </aside>

        </div>
    </section>

    <!-- BACK -->
    <div class="nbd-back-wrap">
        <a href="<?= base_url('berita') ?>" class="nbd-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar Berita
        </a>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function nbdCopyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        alert('Link berita berhasil dicopy! 📋');
    }).catch(() => {
        const temp = document.createElement('input');
        temp.value = url;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand('copy');
        document.body.removeChild(temp);
        alert('Link berita berhasil dicopy! 📋');
    });
}
</script>
<?= $this->endSection() ?>