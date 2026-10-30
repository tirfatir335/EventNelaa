<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.ev-page-hero {
    position: relative;
    padding: 70px 24px 90px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.9) 0%, rgba(230,81,0,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.ev-page-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 100%, rgba(255,255,255,.15), transparent 60%);
    pointer-events: none;
}
.ev-page-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
}
.ev-page-hero h1 {
    font-size: clamp(30px, 4.5vw, 52px);
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0 0 14px;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.ev-page-hero p {
    font-size: 16px;
    color: rgba(255,255,255,.95);
    max-width: 580px;
    margin: 0 auto;
    font-weight: 500;
}

.ev-stat-strip {
    max-width: 900px;
    margin: -40px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.ev-stat-card {
    background: white;
    border-radius: 18px;
    padding: 22px 18px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(15,23,42,.1);
    border: 1px solid #F1F5F9;
}
.ev-stat-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 22px; color: white;
}
.ev-stat-num { font-size: 26px; font-weight: 900; color: #0F172A; line-height: 1; letter-spacing: -.5px; }
.ev-stat-lbl { font-size: 11.5px; color: #64748B; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; margin-top: 6px; }

.ev-filter-section { padding: 40px 24px 20px; }
.ev-filter-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    gap: 14px;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.ev-tabs {
    display: flex;
    gap: 8px;
    background: white;
    padding: 6px;
    border-radius: 50px;
    box-shadow: 0 4px 15px rgba(15,23,42,.05);
    border: 1px solid #F1F5F9;
}
.ev-tab {
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    color: #64748B;
    transition: .25s;
    display: inline-flex; align-items: center; gap: 6px;
}
.ev-tab:hover { background: #FFF3E0; color: #E65100; }
.ev-tab.active {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 6px 20px rgba(255,122,0,.3);
}
.ev-search {
    position: relative;
    flex: 1;
    max-width: 380px;
    min-width: 250px;
}
.ev-search input {
    width: 100%;
    height: 48px;
    padding: 0 20px 0 48px;
    border-radius: 50px;
    border: 1px solid #E2E8F0;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    background: white;
    transition: .2s;
}
.ev-search input:focus {
    border-color: #FF7A00;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.ev-search i {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 16px;
}

.ev-list-section { padding: 20px 24px 60px; }
.ev-list-inner { max-width: 1200px; margin: 0 auto; }
.ev-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
.ev-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .35s;
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: inherit;
}
.ev-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    border-color: #FFE0B2;
    color: inherit;
}
.ev-poster {
    height: 200px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    position: relative;
    overflow: hidden;
}
.ev-poster img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: .5s;
}
.ev-card:hover .ev-poster img { transform: scale(1.06); }
.ev-poster .no-img {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.5); font-size: 50px;
}
.ev-date-badge {
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
.ev-status-badge {
    position: absolute;
    top: 14px; right: 14px;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 10.5px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
    backdrop-filter: blur(10px);
}
.ev-status-badge.akan-datang {
    background: rgba(34,197,94,.95);
    color: white;
}
.ev-status-badge.selesai {
    background: rgba(100,116,139,.9);
    color: white;
}
.ev-body {
    padding: 22px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.ev-org {
    display: flex; align-items: center; gap: 8px;
    font-size: 12.5px;
    font-weight: 700;
    color: #E65100;
    margin-bottom: 12px;
}
.ev-org img { width: 22px; height: 22px; border-radius: 50%; object-fit: cover; }
.ev-org .fallback {
    width: 22px; height: 22px; border-radius: 50%;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 10px;
}
.ev-card h3 {
    font-size: 16.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 14px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 46px;
    letter-spacing: -.3px;
}
.ev-meta {
    display: flex; flex-direction: column; gap: 6px;
    font-size: 12.5px;
    color: #64748B;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #F1F5F9;
}
.ev-meta span { display: flex; align-items: center; gap: 6px; }
.ev-meta i { color: #FF7A00; width: 14px; }

.ev-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 24px;
    border: 1px dashed #E2E8F0;
}
.ev-empty i { font-size: 70px; color: #E2E8F0; display: block; margin-bottom: 14px; }
.ev-empty h3 { font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px; }
.ev-empty p { font-size: 14px; color: #64748B; margin: 0 0 20px; }

@media (max-width: 1024px) {
    .ev-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .ev-page-hero { padding: 50px 18px 70px; }
    .ev-stat-strip { grid-template-columns: 1fr; gap: 10px; margin-top: -30px; }
    .ev-filter-inner { flex-direction: column; align-items: stretch; }
    .ev-tabs { overflow-x: auto; }
    .ev-tab { white-space: nowrap; padding: 8px 16px; font-size: 13px; }
    .ev-search { max-width: 100%; }
    .ev-grid { grid-template-columns: 1fr; gap: 16px; }
    .ev-list-section { padding: 20px 18px 40px; }
}
</style>

<!-- HERO -->
<section class="ev-page-hero">
    <div class="ev-page-hero-inner">
        <h1>Event Kegiatan</h1>
        <p>Temukan semua kegiatan seru dari UKM & Ormawa Politeknik Negeri Lampung</p>
    </div>
</section>

<!-- STATS -->
<div class="ev-stat-strip">
    <div class="ev-stat-card">
        <div class="ev-stat-icon" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
            <i class="bi bi-calendar-event-fill"></i>
        </div>
        <div class="ev-stat-num"><?= $total_event ?? 0 ?></div>
        <div class="ev-stat-lbl">Total Event</div>
    </div>
    <div class="ev-stat-card">
        <div class="ev-stat-icon" style="background: linear-gradient(135deg, #22C55E, #15803D);">
            <i class="bi bi-calendar-check-fill"></i>
        </div>
        <div class="ev-stat-num"><?= $event_akan_datang ?? 0 ?></div>
        <div class="ev-stat-lbl">Akan Datang</div>
    </div>
    <div class="ev-stat-card">
        <div class="ev-stat-icon" style="background: linear-gradient(135deg, #64748B, #334155);">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="ev-stat-num"><?= $event_selesai ?? 0 ?></div>
        <div class="ev-stat-lbl">Sudah Selesai</div>
    </div>
</div>

<!-- FILTER -->
<section class="ev-filter-section">
    <div class="ev-filter-inner">
        <div class="ev-tabs">
            <a href="<?= base_url('event') ?>"
               class="ev-tab <?= ($filter_aktif ?? 'semua') == 'semua' ? 'active' : '' ?>">
                <i class="bi bi-grid-fill"></i> Semua
            </a>
            <a href="<?= base_url('event?filter=akan_datang') ?>"
               class="ev-tab <?= ($filter_aktif ?? '') == 'akan_datang' ? 'active' : '' ?>">
                <i class="bi bi-calendar-check"></i> Akan Datang
            </a>
            <a href="<?= base_url('event?filter=selesai') ?>"
               class="ev-tab <?= ($filter_aktif ?? '') == 'selesai' ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i> Selesai
            </a>
        </div>

        <form method="get" action="<?= base_url('event') ?>" class="ev-search">
            <?php if (!empty($filter_aktif) && $filter_aktif !== 'semua'): ?>
                <input type="hidden" name="filter" value="<?= esc($filter_aktif) ?>">
            <?php endif; ?>
            <i class="bi bi-search"></i>
            <input type="text" name="search" placeholder="Cari event, ormawa, gedung..."
                   value="<?= esc($search ?? '') ?>">
        </form>
    </div>
</section>

<!-- LIST -->
<section class="ev-list-section">
    <div class="ev-list-inner">
        <?php if (!empty($events)): ?>
            <div class="ev-grid">
                <?php foreach ($events as $e):
                    $hasPoster = !empty($e['poster']) && file_exists('uploads/poster/' . $e['poster']);
                    $isAkanDatang = strtotime($e['tanggal']) >= strtotime(date('Y-m-d'));
                ?>
                    <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" class="ev-card">
                        <div class="ev-poster">
                            <?php if ($hasPoster): ?>
                                <img src="<?= base_url('uploads/poster/' . $e['poster']) ?>" alt="">
                            <?php else: ?>
                                <div class="no-img"><i class="bi bi-image"></i></div>
                            <?php endif; ?>
                            <div class="ev-date-badge">
                                <i class="bi bi-calendar-event"></i>
                                <?= date('d M Y', strtotime($e['tanggal'])) ?>
                            </div>
                            <div class="ev-status-badge <?= $isAkanDatang ? 'akan-datang' : 'selesai' ?>">
                                <?= $isAkanDatang ? 'Akan Datang' : 'Selesai' ?>
                            </div>
                        </div>
                        <div class="ev-body">
                            <div class="ev-org">
                                <?php if (!empty($e['ormawa_logo']) && file_exists('uploads/logo/' . $e['ormawa_logo'])): ?>
                                    <img src="<?= base_url('uploads/logo/' . $e['ormawa_logo']) ?>" alt="">
                                <?php else: ?>
                                    <div class="fallback"><i class="bi bi-building"></i></div>
                                <?php endif; ?>
                                <?= esc($e['nama_ormawa'] ?? '-') ?>
                            </div>
                            <h3><?= esc($e['nama_event']) ?></h3>
                            <div class="ev-meta">
                                <span><i class="bi bi-clock-fill"></i> <?= esc($e['waktu'] ?? '-') ?></span>
                                <span><i class="bi bi-geo-alt-fill"></i> <?= esc($e['gedung'] ?? '-') ?></span>
                                <?php if (!empty($e['rating_avg']) && $e['rating_avg'] > 0): ?>
                                    <span>
                                        <i class="bi bi-star-fill" style="color: #F59E0B;"></i>
                                        <?= number_format($e['rating_avg'], 1) ?>/5 (<?= $e['jumlah_ulasan'] ?> ulasan)
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="ev-empty">
                <i class="bi bi-calendar-x"></i>
                <h3>Belum Ada Event</h3>
                <p>
                    <?php if (!empty($search)): ?>
                        Tidak ditemukan event dengan kata kunci "<strong><?= esc($search) ?></strong>".
                    <?php else: ?>
                        Belum ada event yang dipublikasikan untuk filter ini.
                    <?php endif; ?>
                </p>
                <a href="<?= base_url('event') ?>"
                   style="display:inline-flex;align-items:center;gap:8px;padding:14px 30px;
                          border-radius:50px;background:linear-gradient(135deg,#FF7A00,#E65100);
                          color:white;font-weight:800;font-size:14px;text-decoration:none;
                          box-shadow:0 12px 30px rgba(255,122,0,.35);">
                    <i class="bi bi-arrow-left"></i> Lihat Semua Event
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?= $this->endSection() ?>