<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
/* ============================================
   BERITA LIST — MAGAZINE STYLE
   ============================================ */
.news-page { background: #FFFBF5; }

.news-hero {
    position: relative;
    padding: 70px 24px 80px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.88) 0%, rgba(230,81,0,.82) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.news-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.news-hero-inner {
    position: relative; z-index: 2;
    max-width: 900px; margin: 0 auto; text-align: center;
}
.news-hero h1 {
    font-size: clamp(30px, 4.5vw, 54px);
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0 0 14px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.news-hero p {
    font-size: 16px;
    color: rgba(255,255,255,.95);
    max-width: 580px;
    margin: 0 auto;
    font-weight: 500;
}

/* SEARCH */
.news-search-section {
    padding: 44px 24px 20px;
    background: white;
}
.news-search-inner {
    max-width: 700px;
    margin: 0 auto;
    position: relative;
}
.news-search-inner input {
    width: 100%; height: 56px;
    padding: 0 24px 0 56px;
    border-radius: 50px;
    border: 2px solid #F1F5F9;
    background: #FFFBF5;
    font-size: 15px;
    font-family: inherit;
    outline: none;
    transition: .25s;
    box-shadow: 0 8px 25px rgba(15,23,42,.05);
}
.news-search-inner input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 12px 40px rgba(255,122,0,.15);
}
.news-search-inner i {
    position: absolute;
    left: 22px; top: 50%;
    transform: translateY(-50%);
    color: #FF7A00;
    font-size: 20px;
}

/* FEATURED */
.news-featured-section {
    padding: 20px 24px 50px;
    background: white;
}
.news-featured-inner { max-width: 1200px; margin: 0 auto; }

.news-featured {
    display: grid;
    grid-template-columns: 1.2fr 1fr;
    background: white;
    border-radius: 28px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(15,23,42,.1);
    text-decoration: none;
    color: inherit;
    transition: .4s;
    border: 1px solid #F1F5F9;
}
.news-featured:hover {
    transform: translateY(-6px);
    box-shadow: 0 30px 80px rgba(255,122,0,.2);
    color: inherit;
}
.news-featured-img {
    height: 420px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #FF7A00, #E65100);
}
.news-featured-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: .6s;
}
.news-featured:hover .news-featured-img img { transform: scale(1.05); }
.news-featured-img .no-img {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.5); font-size: 80px;
}
.news-featured-badge {
    position: absolute;
    top: 22px; left: 22px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0 8px 20px rgba(255,122,0,.4);
    display: inline-flex; align-items: center; gap: 6px;
}
.news-featured-body {
    padding: 44px 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.news-featured-org {
    display: flex; align-items: center; gap: 10px;
    margin-bottom: 18px;
    font-size: 13px;
    font-weight: 700;
    color: #E65100;
}
.news-featured-org img,
.news-featured-org .fallback {
    width: 32px; height: 32px;
    border-radius: 50%;
    object-fit: cover;
}
.news-featured-org .fallback {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
}
.news-featured-body h2 {
    font-size: 26px;
    font-weight: 900;
    color: #0F172A;
    line-height: 1.25;
    letter-spacing: -.8px;
    margin: 0 0 16px;
}
.news-featured-body p {
    font-size: 15px;
    color: #64748B;
    line-height: 1.75;
    margin: 0 0 24px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-featured-meta {
    display: flex;
    gap: 20px;
    font-size: 13px;
    color: #94A3B8;
    margin-bottom: 22px;
    flex-wrap: wrap;
}
.news-featured-meta span {
    display: inline-flex; align-items: center; gap: 6px;
}
.news-featured-meta i { color: #FF7A00; }
.news-read-more {
    display: inline-flex; align-items: center; gap: 8px;
    color: #E65100;
    font-weight: 800;
    font-size: 14px;
    margin-top: auto;
}
.news-featured:hover .news-read-more i { transform: translateX(5px); }
.news-read-more i { transition: .3s; }

/* GRID */
.news-list-section {
    padding: 20px 24px 80px;
    background: #FFFBF5;
}
.news-list-inner { max-width: 1200px; margin: 0 auto; }

.news-section-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 22px;
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -.5px;
    margin-bottom: 26px;
}
.news-section-title i { color: #FF7A00; font-size: 24px; }

.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 26px;
}
.news-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .4s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
}
.news-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    border-color: #FFE0B2;
    color: inherit;
}
.news-card-img {
    height: 200px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #FF7A00, #E65100);
}
.news-card-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: .5s;
}
.news-card:hover .news-card-img img { transform: scale(1.06); }
.news-card-img .no-img {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.5); font-size: 55px;
}
.news-date-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: white;
    color: #E65100;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
    display: inline-flex; align-items: center; gap: 5px;
}
.news-card-body {
    padding: 22px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.news-card-org {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 12px;
    font-size: 12px;
    font-weight: 700;
    color: #E65100;
}
.news-card-org img,
.news-card-org .fallback {
    width: 22px; height: 22px;
    border-radius: 50%;
    object-fit: cover;
}
.news-card-org .fallback {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
}
.news-card h3 {
    font-size: 16.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 10px;
    line-height: 1.4;
    letter-spacing: -.3px;
    min-height: 46px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-card p {
    font-size: 13.5px;
    color: #64748B;
    line-height: 1.6;
    margin: 0 0 16px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.news-card-footer {
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.news-card-read {
    color: #E65100;
    font-weight: 800;
    font-size: 13px;
    display: inline-flex; align-items: center; gap: 6px;
}
.news-card:hover .news-card-read i { transform: translateX(4px); }
.news-card-read i { transition: .3s; }

/* EMPTY */
.news-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 24px;
    border: 1px dashed #E2E8F0;
}
.news-empty i { font-size: 70px; color: #E2E8F0; display: block; margin-bottom: 14px; }
.news-empty h3 { font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px; }
.news-empty p { font-size: 14px; color: #64748B; margin: 0 0 20px; }
.news-empty-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 30px;
    border-radius: 50px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    font-weight: 800; font-size: 14px;
    text-decoration: none;
    box-shadow: 0 12px 30px rgba(255,122,0,.35);
}

@media (max-width: 1024px) {
    .news-featured { grid-template-columns: 1fr; }
    .news-featured-img { height: 320px; }
}
@media (max-width: 768px) {
    .news-hero { padding: 50px 18px 70px; }
    .news-featured-body { padding: 28px 24px; }
    .news-featured-body h2 { font-size: 20px; }
    .news-grid { grid-template-columns: 1fr; gap: 18px; }
    .news-list-section { padding: 20px 18px 50px; }
    .news-featured-img { height: 220px; }
}
</style>

<div class="news-page">

    <!-- HERO -->
    <section class="news-hero">
        <div class="news-hero-inner">
            <h1>Berita & Pengumuman</h1>
            <p>Update terbaru kegiatan, prestasi, dan pengumuman dari UKM & Ormawa Politeknik Negeri Lampung</p>
        </div>
    </section>

    <!-- SEARCH -->
    <section class="news-search-section">
        <div class="news-search-inner">
            <i class="bi bi-search"></i>
            <input type="text" id="newsSearch" placeholder="Cari berita atau ormawa...">
        </div>
    </section>

    <?php if (!empty($berita)): ?>

        <!-- FEATURED -->
        <?php
            $featured = $berita[0];
            $hasImg = !empty($featured['foto']) && file_exists('uploads/berita/' . $featured['foto']);
            $hasLogo = !empty($featured['logo']) && file_exists('uploads/logo/' . $featured['logo']);
        ?>
        <section class="news-featured-section">
            <div class="news-featured-inner">
                <a href="<?= base_url('berita/detail/' . $featured['id_berita']) ?>" class="news-featured">
                    <div class="news-featured-img">
                        <span class="news-featured-badge">
                            <i class="bi bi-star-fill"></i> Terbaru
                        </span>
                        <?php if ($hasImg): ?>
                            <img src="<?= base_url('uploads/berita/' . $featured['foto']) ?>" alt="">
                        <?php else: ?>
                            <div class="no-img"><i class="bi bi-newspaper"></i></div>
                        <?php endif; ?>
                    </div>

                    <div class="news-featured-body">
                        <div class="news-featured-org">
                            <?php if ($hasLogo): ?>
                                <img src="<?= base_url('uploads/logo/' . $featured['logo']) ?>" alt="">
                            <?php else: ?>
                                <div class="fallback"><i class="bi bi-building"></i></div>
                            <?php endif; ?>
                            <?= esc($featured['nama_ormawa']) ?>
                        </div>

                        <h2><?= esc($featured['judul']) ?></h2>

                        <p><?= esc(substr(strip_tags($featured['konten']), 0, 200)) ?>...</p>

                        <div class="news-featured-meta">
                            <span><i class="bi bi-calendar3"></i><?= date('d M Y', strtotime($featured['created_at'])) ?></span>
                            <span><i class="bi bi-clock"></i><?= date('H:i', strtotime($featured['created_at'])) ?> WIB</span>
                        </div>

                        <div class="news-read-more">
                            Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                        </div>
                    </div>
                </a>
            </div>
        </section>

        <!-- GRID -->
        <?php if (count($berita) > 1): ?>
            <section class="news-list-section">
                <div class="news-list-inner">
                    <div class="news-section-title">
                        <i class="bi bi-newspaper"></i> Semua Berita
                    </div>

                    <div class="news-grid" id="newsGrid">
                        <?php foreach (array_slice($berita, 1) as $b):
                            $hasImgCard = !empty($b['foto']) && file_exists('uploads/berita/' . $b['foto']);
                            $hasLogoCard = !empty($b['logo']) && file_exists('uploads/logo/' . $b['logo']);
                        ?>
                            <a href="<?= base_url('berita/detail/' . $b['id_berita']) ?>"
                               class="news-card"
                               data-judul="<?= strtolower(esc($b['judul'])) ?>"
                               data-ormawa="<?= strtolower(esc($b['nama_ormawa'])) ?>">

                                <div class="news-card-img">
                                    <span class="news-date-badge">
                                        <i class="bi bi-calendar3"></i>
                                        <?= date('d M Y', strtotime($b['created_at'])) ?>
                                    </span>
                                    <?php if ($hasImgCard): ?>
                                        <img src="<?= base_url('uploads/berita/' . $b['foto']) ?>" alt="">
                                    <?php else: ?>
                                        <div class="no-img"><i class="bi bi-newspaper"></i></div>
                                    <?php endif; ?>
                                </div>

                                <div class="news-card-body">
                                    <div class="news-card-org">
                                        <?php if ($hasLogoCard): ?>
                                            <img src="<?= base_url('uploads/logo/' . $b['logo']) ?>" alt="">
                                        <?php else: ?>
                                            <div class="fallback"><i class="bi bi-building"></i></div>
                                        <?php endif; ?>
                                        <?= esc($b['nama_ormawa']) ?>
                                    </div>

                                    <h3><?= esc($b['judul']) ?></h3>
                                    <p><?= esc(substr(strip_tags($b['konten']), 0, 120)) ?>...</p>

                                    <div class="news-card-footer">
                                        <span class="news-card-read">
                                            Baca <i class="bi bi-arrow-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    <?php else: ?>
        <section class="news-list-section" style="padding-top: 40px;">
            <div class="news-list-inner">
                <div class="news-empty">
                    <i class="bi bi-newspaper"></i>
                    <h3>Belum Ada Berita</h3>
                    <p>Belum ada berita yang dipublikasikan oleh UKM/Ormawa.</p>
                    <a href="<?= base_url('ukm') ?>" class="news-empty-btn">
                        <i class="bi bi-people-fill"></i> Jelajahi UKM
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('newsSearch')?.addEventListener('keyup', function() {
    const key = this.value.toLowerCase().trim();
    document.querySelectorAll('#newsGrid .news-card').forEach(card => {
        const judul = card.getAttribute('data-judul');
        const ormawa = card.getAttribute('data-ormawa');
        card.style.display = (judul.includes(key) || ormawa.includes(key)) ? 'flex' : 'none';
    });
});
</script>
<?= $this->endSection() ?>