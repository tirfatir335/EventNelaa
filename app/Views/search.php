<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.sc-page { background: #FFFBF5; padding-bottom: 80px; min-height: 60vh; }

/* ============================================
   HERO
   ============================================ */
.sc-hero {
    position: relative;
    padding: 70px 24px 90px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.92) 0%, rgba(230,81,0,.88) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.sc-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.sc-hero-inner {
    max-width: 700px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    text-align: center;
}
.sc-hero h1 {
    font-size: clamp(28px, 4vw, 44px);
    font-weight: 900;
    letter-spacing: -1.2px;
    margin: 0 0 10px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.sc-hero p {
    font-size: 15.5px;
    opacity: .95;
    margin: 0;
    font-weight: 500;
}

/* SEARCH BAR */
.sc-search-bar {
    max-width: 720px;
    margin: -36px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
}
.sc-search-form {
    background: white;
    border-radius: 24px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 25px 70px rgba(15,23,42,.18);
}
.sc-search-form .icon {
    width: 48px; height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #FF7A00;
    font-size: 20px;
    flex-shrink: 0;
}
.sc-search-form input {
    flex: 1;
    height: 52px;
    border: none;
    outline: none;
    font-size: 15.5px;
    font-family: inherit;
    background: transparent;
    color: #0F172A;
    min-width: 0;
}
.sc-search-form button {
    height: 52px;
    padding: 0 32px;
    border-radius: 50px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border: none;
    font-weight: 800;
    font-size: 14.5px;
    cursor: pointer;
    font-family: inherit;
    box-shadow: 0 10px 25px rgba(255,122,0,.35);
    transition: .25s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    flex-shrink: 0;
}
.sc-search-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(255,122,0,.45);
}

/* ============================================
   RESULT INFO BAR
   ============================================ */
.sc-result-info {
    max-width: 1100px;
    margin: 40px auto 0;
    padding: 0 24px;
}
.sc-info-card {
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-left: 5px solid #FF7A00;
    border-radius: 18px;
    padding: 20px 28px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.sc-info-card .ico {
    width: 52px; height: 52px;
    border-radius: 14px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(255,122,0,.35);
}
.sc-info-card .txt {
    flex: 1;
    min-width: 200px;
}
.sc-info-card .lbl {
    font-size: 11.5px;
    color: #94A3B8;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}
.sc-info-card .val {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    letter-spacing: -.3px;
}
.sc-info-card .val em {
    font-style: normal;
    color: #E65100;
}
.sc-info-card .count {
    background: white;
    color: #E65100;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 900;
    box-shadow: 0 4px 12px rgba(0,0,0,.06);
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

/* ============================================
   SECTION
   ============================================ */
.sc-section {
    padding: 50px 24px 10px;
}
.sc-inner { max-width: 1100px; margin: 0 auto; }

.sc-section-head {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 26px;
    padding-bottom: 16px;
    border-bottom: 3px solid #F1F5F9;
}
.sc-section-head .ico {
    width: 50px; height: 50px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 8px 20px rgba(0,0,0,.12);
}
.sc-section-head h2 {
    font-size: 22px;
    font-weight: 900;
    color: #0F172A;
    margin: 0;
    letter-spacing: -.5px;
}
.sc-section-head .count {
    background: #F1F5F9;
    color: #64748B;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 12.5px;
    font-weight: 800;
    margin-left: auto;
}

/* ============================================
   GRID & CARDS
   ============================================ */
.sc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}

.sc-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 15px rgba(15,23,42,.05);
    transition: .35s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
}
.sc-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(255,122,0,.18);
    border-color: #FFE0B2;
    color: inherit;
}

/* IMG */
.sc-card-img {
    height: 170px;
    position: relative;
    overflow: hidden;
    background: linear-gradient(135deg, #FF7A00, #E65100);
}
.sc-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .5s;
}
.sc-card:hover .sc-card-img img { transform: scale(1.06); }
.sc-card-img .no-img {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.5); font-size: 48px;
}

/* Org logo bulat */
.sc-card-img.centered {
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #F1F5F9;
}

/* BODY */
.sc-card-body {
    padding: 18px 20px 20px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.sc-card-org {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 11.5px;
    color: #E65100;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 10px;
    overflow: hidden;
}
.sc-card-org img {
    width: 22px; height: 22px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}
.sc-card-org span {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.sc-card-body h3 {
    font-size: 15.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 12px;
    line-height: 1.4;
    letter-spacing: -.3px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 44px;
}

.sc-card-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 12px;
    color: #64748B;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #F1F5F9;
    font-weight: 600;
}
.sc-card-meta span {
    display: inline-flex;
    align-items: center;
    gap: 5px;
}
.sc-card-meta i { color: #FF7A00; font-size: 12px; }

/* ============================================
   EMPTY / HINT
   ============================================ */
.sc-empty {
    text-align: center;
    padding: 70px 24px;
    background: white;
    border-radius: 24px;
    border: 1px dashed #E2E8F0;
    max-width: 600px;
    margin: 40px auto 0;
}
.sc-empty .ico {
    width: 90px; height: 90px;
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-radius: 22px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 42px;
    color: #FF7A00;
}
.sc-empty h3 {
    font-size: 20px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 10px;
    letter-spacing: -.3px;
}
.sc-empty p {
    font-size: 14.5px;
    color: #64748B;
    margin: 0;
    line-height: 1.6;
}
.sc-empty p strong {
    color: #E65100;
    font-weight: 800;
}

.sc-hint {
    text-align: center;
    padding: 40px 20px;
    max-width: 700px;
    margin: 0 auto;
}
.sc-hint .ico {
    width: 80px; height: 80px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    border-radius: 22px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 20px;
    font-size: 36px;
    color: white;
    box-shadow: 0 15px 40px rgba(255,122,0,.3);
}
.sc-hint h3 {
    font-size: 22px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 10px;
    letter-spacing: -.5px;
}
.sc-hint p {
    color: #64748B;
    font-size: 14.5px;
    margin: 0 0 26px;
    line-height: 1.6;
}
.sc-hint-chips {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}
.sc-hint-chip {
    background: white;
    border: 2px solid #F1F5F9;
    color: #334155;
    padding: 12px 22px;
    border-radius: 50px;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: .25s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.sc-hint-chip:hover {
    border-color: #FF7A00;
    color: #E65100;
    background: #FFF3E0;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255,122,0,.15);
}

@media (max-width: 768px) {
    .sc-hero { padding: 50px 18px 80px; }
    .sc-search-bar { padding: 0 18px; }
    .sc-search-form { flex-wrap: wrap; }
    .sc-search-form .icon { display: none; }
    .sc-search-form input { width: 100%; text-align: center; }
    .sc-search-form button { width: 100%; justify-content: center; }
    .sc-section { padding: 40px 18px 10px; }
    .sc-grid { grid-template-columns: 1fr; gap: 16px; }
    .sc-section-head h2 { font-size: 18px; }
    .sc-info-card { padding: 16px 20px; }
    .sc-info-card .count { width: 100%; justify-content: center; }
}
</style>

<div class="sc-page">

    <!-- HERO -->
    <section class="sc-hero">
        <div class="sc-hero-inner">
            <h1>Pencarian</h1>
            <p>Cari event, UKM, berita, dan recruitment sekaligus</p>
        </div>
    </section>

    <!-- SEARCH BAR -->
    <div class="sc-search-bar">
        <form action="<?= base_url('search') ?>" method="get" class="sc-search-form">
            <div class="icon"><i class="bi bi-search"></i></div>
            <input type="text" name="q" placeholder="Ketik kata kunci..."
                   value="<?= esc($q ?? '') ?>" autofocus>
            <button type="submit">
                <i class="bi bi-search"></i> Cari
            </button>
        </form>
    </div>

    <?php if (empty($q)): ?>

        <!-- HINT -->
        <div class="sc-hint">
            <div class="ico"><i class="bi bi-lightbulb-fill"></i></div>
            <h3>Mulai Cari Sesuatu</h3>
            <p>Ketik kata kunci di atas, atau coba salah satu rekomendasi di bawah:</p>
            <div class="sc-hint-chips">
                <a href="<?= base_url('search?q=workshop') ?>" class="sc-hint-chip">🎓 Workshop</a>
                <a href="<?= base_url('search?q=seminar') ?>" class="sc-hint-chip">📢 Seminar</a>
                <a href="<?= base_url('search?q=HMJ') ?>" class="sc-hint-chip">🏛️ HMJ</a>
                <a href="<?= base_url('search?q=UKM') ?>" class="sc-hint-chip">👥 UKM</a>
                <a href="<?= base_url('search?q=lomba') ?>" class="sc-hint-chip">🏆 Lomba</a>
                <a href="<?= base_url('search?q=recruitment') ?>" class="sc-hint-chip">🎯 Recruitment</a>
            </div>
        </div>

    <?php elseif ($total === 0): ?>

        <!-- NO RESULT -->
        <div class="sc-empty">
            <div class="ico"><i class="bi bi-search"></i></div>
            <h3>Tidak Ada Hasil</h3>
            <p>Tidak ditemukan apapun untuk kata kunci "<strong><?= esc($q) ?></strong>".<br>Coba kata kunci lain atau lebih pendek.</p>
        </div>

    <?php else: ?>

        <!-- INFO BAR -->
        <div class="sc-result-info">
            <div class="sc-info-card">
                <div class="ico"><i class="bi bi-search"></i></div>
                <div class="txt">
                    <div class="lbl">Hasil Pencarian</div>
                    <div class="val">"<em><?= esc($q) ?></em>"</div>
                </div>
                <div class="count">
                    <i class="bi bi-check-circle-fill"></i> <?= $total ?> hasil
                </div>
            </div>
        </div>

        <!-- EVENTS -->
        <?php if (!empty($events)): ?>
        <div class="sc-section">
            <div class="sc-inner">
                <div class="sc-section-head">
                    <div class="ico" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <h2>Event Kampus</h2>
                    <span class="count"><?= count($events) ?> hasil</span>
                </div>
                <div class="sc-grid">
                    <?php foreach ($events as $e): ?>
                        <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" class="sc-card">
                            <div class="sc-card-img">
                                <?php if (!empty($e['poster']) && file_exists('uploads/poster/' . $e['poster'])): ?>
                                    <img src="<?= base_url('uploads/poster/' . $e['poster']) ?>" alt="">
                                <?php else: ?>
                                    <div class="no-img"><i class="bi bi-image"></i></div>
                                <?php endif; ?>
                            </div>
                            <div class="sc-card-body">
                                <div class="sc-card-org">
                                    <?php if (!empty($e['ormawa_logo']) && file_exists('uploads/logo/' . $e['ormawa_logo'])): ?>
                                        <img src="<?= base_url('uploads/logo/' . $e['ormawa_logo']) ?>" alt="">
                                    <?php endif; ?>
                                    <span><?= esc($e['nama_ormawa'] ?? '-') ?></span>
                                </div>
                                <h3><?= esc($e['nama_event']) ?></h3>
                                <div class="sc-card-meta">
                                    <span><i class="bi bi-calendar3"></i><?= date('d M Y', strtotime($e['tanggal'])) ?></span>
                                    <span><i class="bi bi-geo-alt-fill"></i><?= esc(substr($e['gedung'] ?? '-', 0, 18)) ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- UKM -->
        <?php if (!empty($ormawa)): ?>
        <div class="sc-section">
            <div class="sc-inner">
                <div class="sc-section-head">
                    <div class="ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h2>UKM & Ormawa</h2>
                    <span class="count"><?= count($ormawa) ?> hasil</span>
                </div>
                <div class="sc-grid">
                    <?php foreach ($ormawa as $o): ?>
                        <a href="<?= base_url('ukm/detail/' . $o['id_ormawa']) ?>" class="sc-card">
                            <div class="sc-card-img centered">
                                <?php if (!empty($o['logo']) && file_exists('uploads/logo/' . $o['logo'])): ?>
                                    <img src="<?= base_url('uploads/logo/' . $o['logo']) ?>"
                                         style="width: 90px; height: 90px; border-radius: 50%; object-fit: cover;
                                                border: 4px solid #FFF3E0;">
                                <?php else: ?>
                                    <div style="width: 90px; height: 90px; border-radius: 50%;
                                                background: linear-gradient(135deg, #FF7A00, #E65100);
                                                color: white; display: flex; align-items: center;
                                                justify-content: center; font-size: 38px;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="sc-card-body" style="text-align: center;">
                                <h3 style="text-align: center; min-height: auto; margin-bottom: 8px;">
                                    <?= esc($o['nama_ormawa']) ?>
                                </h3>
                                <div class="sc-card-meta" style="justify-content: center;">
                                    <span><i class="bi bi-tag-fill"></i><?= esc($o['kategori'] ?? 'UKM') ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- RECRUITMENT -->
        <?php if (!empty($recruitments)): ?>
        <div class="sc-section">
            <div class="sc-inner">
                <div class="sc-section-head">
                    <div class="ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <h2>Open Recruitment</h2>
                    <span class="count"><?= count($recruitments) ?> hasil</span>
                </div>
                <div class="sc-grid">
                    <?php foreach ($recruitments as $r): ?>
                        <a href="<?= base_url('recruitment/detail/' . $r['id_recruitment']) ?>" class="sc-card">
                            <div class="sc-card-body">
                                <div class="sc-card-org">
                                    <?php if (!empty($r['logo']) && file_exists('uploads/logo/' . $r['logo'])): ?>
                                        <img src="<?= base_url('uploads/logo/' . $r['logo']) ?>" alt="">
                                    <?php endif; ?>
                                    <span><?= esc($r['nama_ormawa']) ?></span>
                                </div>
                                <h3><?= esc($r['judul']) ?></h3>
                                <div class="sc-card-meta">
                                    <span><i class="bi bi-tag-fill"></i><?= esc($r['posisi'] ?? '-') ?></span>
                                    <span><i class="bi bi-calendar3"></i><?= esc($r['periode'] ?? '-') ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- BERITA -->
        <?php if (!empty($berita)): ?>
        <div class="sc-section">
            <div class="sc-inner">
                <div class="sc-section-head">
                    <div class="ico" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                        <i class="bi bi-newspaper"></i>
                    </div>
                    <h2>Berita</h2>
                    <span class="count"><?= count($berita) ?> hasil</span>
                </div>
                <div class="sc-grid">
                    <?php foreach ($berita as $b): ?>
                        <a href="<?= base_url('berita/detail/' . $b['id_berita']) ?>" class="sc-card">
                            <div class="sc-card-img">
                                <?php if (!empty($b['foto']) && file_exists('uploads/berita/' . $b['foto'])): ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['foto']) ?>" alt="">
                                <?php else: ?>
                                    <div class="no-img"><i class="bi bi-newspaper"></i></div>
                                <?php endif; ?>
                            </div>
                            <div class="sc-card-body">
                                <div class="sc-card-org">
                                    <span><?= esc($b['nama_ormawa']) ?></span>
                                </div>
                                <h3><?= esc($b['judul']) ?></h3>
                                <div class="sc-card-meta">
                                    <span><i class="bi bi-calendar3"></i><?= date('d M Y', strtotime($b['created_at'])) ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <?php endif; ?>

    <?php endif; ?>

</div>

<?= $this->endSection() ?>