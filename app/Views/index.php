<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.home-hero {
    position: relative;
    padding: 90px 24px 120px;
    overflow: hidden;
    background:
        linear-gradient(135deg, rgba(255, 122, 0, .85) 0%, rgba(230, 81, 0, .75) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
}
.home-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at 50% 100%, rgba(255,255,255,.15) 0%, transparent 60%);
    pointer-events: none;
}
.home-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
    color: white;
}
.home-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.3);
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 24px;
}
.home-hero h1 {
    font-size: clamp(34px, 5.5vw, 62px);
    font-weight: 900;
    line-height: 1.08;
    letter-spacing: -2px;
    margin: 0 0 20px;
    text-shadow: 0 4px 30px rgba(0,0,0,.2);
}
.home-hero h1 span { color: #FFD700; text-shadow: 0 0 40px rgba(255,215,0,.4); }
.home-hero p {
    font-size: 17px;
    color: rgba(255,255,255,.95);
    max-width: 620px;
    margin: 0 auto 36px;
    line-height: 1.7;
    font-weight: 500;
}
.home-hero-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.home-btn-hero {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 34px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 15px;
    text-decoration: none;
    transition: .3s;
}
.home-btn-hero-primary {
    background: white;
    color: #E65100;
    box-shadow: 0 12px 30px rgba(0,0,0,.2);
}
.home-btn-hero-primary:hover { transform: translateY(-4px); box-shadow: 0 20px 45px rgba(0,0,0,.25); color: #E65100; }
.home-btn-hero-outline {
    background: rgba(255,255,255,.15);
    color: white;
    border: 2px solid rgba(255,255,255,.5);
    backdrop-filter: blur(10px);
}
.home-btn-hero-outline:hover { background: rgba(255,255,255,.25); color: white; transform: translateY(-4px); }

.home-search {
    max-width: 780px;
    margin: -32px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
}
.home-search-card {
    background: white;
    border-radius: 22px;
    padding: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
    box-shadow: 0 20px 60px rgba(0,0,0,.15);
}
.home-search-card .icon {
    width: 48px; height: 48px;
    display: flex; align-items: center; justify-content: center;
    color: #FF7A00;
    font-size: 20px;
}
.home-search-card input {
    flex: 1;
    height: 52px;
    border: none;
    outline: none;
    font-size: 15px;
    font-family: inherit;
    background: transparent;
    color: #0F172A;
}
.home-search-card .btn {
    height: 52px;
    padding: 0 30px;
    border-radius: 50px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border: none;
    font-weight: 800;
    font-size: 14px;
    font-family: inherit;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(255,122,0,.35);
    transition: .25s;
}
.home-search-card .btn:hover { transform: translateY(-2px); }

/* SECTION */
.home-stats-section { padding: 70px 24px 40px; }
.home-stats-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}
.home-stat-card {
    background: white;
    border-radius: 20px;
    padding: 28px 22px;
    text-align: center;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .3s;
}
.home-stat-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 50px rgba(255,122,0,.15);
    border-color: #FFE0B2;
}
.home-stat-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 24px;
    color: white;
}
.home-stat-num {
    font-size: 34px;
    font-weight: 900;
    color: #0F172A;
    line-height: 1;
    letter-spacing: -1px;
}
.home-stat-lbl {
    font-size: 12px;
    color: #64748B;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-top: 8px;
}

.home-section { padding: 70px 24px; }
.home-container { max-width: 1200px; margin: 0 auto; }
.home-section-head { text-align: center; margin-bottom: 46px; }
.home-kicker {
    display: inline-flex;
    align-items: center;
    gap: 6px;
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
.home-section-head h2 {
    font-size: clamp(26px, 3.5vw, 42px);
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -1.2px;
    margin: 0 0 12px;
    line-height: 1.15;
}
.home-section-head h2 span { color: #FF7A00; }
.home-section-head p {
    font-size: 15px;
    color: #64748B;
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.65;
}

.home-cat-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
}
.home-cat-card {
    background: white;
    border-radius: 22px;
    padding: 30px 24px;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .35s;
    display: block;
    text-decoration: none;
    color: inherit;
}
.home-cat-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    border-color: #FFE0B2;
    color: inherit;
}
.home-cat-icon {
    width: 64px; height: 64px;
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    font-size: 28px;
    color: white;
    margin-bottom: 22px;
}
.home-cat-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 8px;
    letter-spacing: -.3px;
}
.home-cat-card p { font-size: 13.5px; color: #64748B; margin: 0 0 16px; line-height: 1.55; }
.home-cat-count {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #FFF3E0;
    color: #E65100;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 800;
}

.home-grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
.home-grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

.home-event-card {
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
.home-event-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    color: inherit;
}
.home-event-poster {
    height: 190px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    position: relative;
    overflow: hidden;
}
.home-event-poster img { width: 100%; height: 100%; object-fit: cover; transition: .5s; }
.home-event-card:hover .home-event-poster img { transform: scale(1.06); }
.home-event-poster .no-img {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.5); font-size: 48px;
}
.home-event-badge {
    position: absolute;
    top: 14px; left: 14px;
    background: white;
    color: #E65100;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    box-shadow: 0 4px 12px rgba(0,0,0,.15);
}
.home-event-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
.home-event-org {
    display: flex; align-items: center; gap: 8px;
    font-size: 12.5px;
    font-weight: 700;
    color: #E65100;
    margin-bottom: 12px;
}
.home-event-org img { width: 22px; height: 22px; border-radius: 50%; object-fit: cover; }
.home-event-card h3 {
    font-size: 16.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 14px;
    line-height: 1.4;
    letter-spacing: -.3px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 46px;
}
.home-event-meta {
    display: flex; gap: 14px;
    flex-wrap: wrap;
    font-size: 12.5px;
    color: #64748B;
    margin-top: auto;
    padding-top: 14px;
    border-top: 1px solid #F1F5F9;
}
.home-event-meta i { color: #FF7A00; margin-right: 4px; }

.home-org-card {
    background: white;
    border-radius: 22px;
    padding: 28px 20px;
    text-align: center;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .35s;
    text-decoration: none;
    color: inherit;
}
.home-org-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    color: inherit;
}
.home-org-logo {
    width: 86px; height: 86px;
    border-radius: 50%;
    margin: 0 auto 16px;
    border: 4px solid #FFF3E0;
    object-fit: cover;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 34px;
}
.home-org-name {
    font-size: 15px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 8px;
    line-height: 1.35;
    min-height: 40px;
}
.home-org-cat {
    display: inline-block;
    background: #FFF3E0;
    color: #E65100;
    padding: 4px 14px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 12px;
}
.home-org-stats {
    display: flex;
    justify-content: center;
    gap: 14px;
    font-size: 12px;
    color: #64748B;
    font-weight: 600;
    padding-top: 12px;
    border-top: 1px solid #F1F5F9;
}

.home-kalender-wrap {
    max-width: 720px;
    margin: 0 auto;
    background: white;
    border-radius: 24px;
    padding: 28px;
    box-shadow: 0 10px 40px rgba(15,23,42,.08);
    border: 1px solid #F1F5F9;
}
.home-kal-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 22px;
}
.home-kal-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 900;
    color: #0F172A;
    text-transform: capitalize;
    letter-spacing: -.5px;
}
.home-kal-nav {
    width: 40px; height: 40px;
    border-radius: 50%;
    background: #FFF3E0;
    color: #FF7A00;
    border: none;
    font-size: 18px;
    cursor: pointer;
    transition: .2s;
    display: flex; align-items: center; justify-content: center;
}
.home-kal-nav:hover { background: #FF7A00; color: white; transform: scale(1.05); }
.home-kal-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 6px;
    margin-bottom: 10px;
}
.home-kal-days > div {
    text-align: center;
    font-size: 12px;
    font-weight: 800;
    color: #64748B;
    padding: 8px 0;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.home-kal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 6px;
}
.home-kal-cell {
    aspect-ratio: 1;
    border-radius: 12px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: .25s;
    background: #F8FAFC;
    border: 2px solid transparent;
    position: relative;
    font-weight: 700;
    color: #334155;
    font-size: 14px;
}
.home-kal-cell.empty { background: transparent; cursor: default; }
.home-kal-cell:not(.empty):not(.has-event):hover { background: #FFF3E0; border-color: #FF7A00; }
.home-kal-cell.has-event {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 4px 12px rgba(255,122,0,.35);
}
.home-kal-cell.has-event:hover { transform: scale(1.08); }
.home-kal-cell .count {
    position: absolute;
    top: 3px; right: 3px;
    background: #FFD700;
    color: #0F172A;
    font-size: 9px;
    font-weight: 800;
    padding: 1px 5px;
    border-radius: 8px;
    min-width: 14px;
    text-align: center;
}
.home-kal-cell.today {
    border-color: #FFD700;
    box-shadow: 0 0 0 3px rgba(255,215,0,.25);
}
.home-kal-legend {
    display: flex;
    justify-content: center;
    gap: 24px;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
    font-size: 12px;
    color: #475569;
    font-weight: 600;
}
.home-kal-legend .dot {
    display: inline-block;
    width: 12px; height: 12px;
    border-radius: 4px;
    margin-right: 6px;
    vertical-align: middle;
}
.dot-event { background: linear-gradient(135deg, #FF7A00, #E65100); }
.dot-today { background: #FFD700; }

.home-cta {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    border-radius: 32px;
    padding: 70px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    color: white;
    box-shadow: 0 30px 80px rgba(255,122,0,.3);
}
.home-cta::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 400px; height: 400px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
}
.home-cta::after {
    content: '';
    position: absolute;
    bottom: -40%; left: -10%;
    width: 350px; height: 350px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
}
.home-cta > * { position: relative; z-index: 2; }
.home-cta h2 {
    font-size: clamp(24px, 3.2vw, 38px);
    font-weight: 900;
    letter-spacing: -1.2px;
    margin: 0 0 14px;
}
.home-cta p {
    font-size: 16px;
    color: rgba(255,255,255,.9);
    max-width: 520px;
    margin: 0 auto 30px;
}
.home-cta .btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 34px;
    border-radius: 50px;
    background: white;
    color: #E65100;
    font-weight: 800;
    font-size: 15px;
    text-decoration: none;
    box-shadow: 0 12px 30px rgba(0,0,0,.15);
    transition: .3s;
}
.home-cta .btn:hover { transform: translateY(-4px); color: #E65100; }

@media (max-width: 1024px) {
    .home-cat-grid { grid-template-columns: repeat(2, 1fr); }
    .home-stats-inner { grid-template-columns: repeat(2, 1fr); }
    .home-grid-3, .home-grid-4 { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 768px) {
    .home-hero { padding: 60px 18px 100px; }
    .home-section { padding: 50px 18px; }
    .home-cat-grid, .home-grid-3, .home-grid-4 { grid-template-columns: 1fr; }
    .home-stats-inner { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .home-stat-card { padding: 20px 14px; }
    .home-stat-num { font-size: 26px; }
    .home-stat-icon { width: 46px; height: 46px; font-size: 20px; margin-bottom: 10px; }
    .home-search { margin-top: -25px; padding: 0 18px; }
    .home-search-card { flex-wrap: wrap; padding: 14px; }
    .home-search-card .icon { display: none; }
    .home-search-card input { width: 100%; text-align: center; padding: 0; }
    .home-search-card .btn { width: 100%; }
    .home-kalender-wrap { padding: 18px; }
    .home-kal-header h3 { font-size: 17px; }
    .home-kal-cell { font-size: 12px; border-radius: 8px; }
    .home-cta { padding: 50px 24px; border-radius: 24px; }
}

.home-kal-detail {
    margin-top: 20px; padding-top: 18px;
    border-top: 2px solid #F1F5F9;
    animation: fadeInKal .25s ease;
}
@keyframes fadeInKal {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
}
.home-kal-detail-head {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 14px;
}
.home-kal-detail-head h4 {
    font-size: 15px; font-weight: 800; color: #0F172A;
    margin: 0; letter-spacing: -.3px;
}
.home-kal-close {
    width: 32px; height: 32px; border-radius: 50%;
    background: #FFF3E0; color: #FF7A00; border: none;
    font-size: 18px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center;
}
.home-kal-close:hover { background: #FF7A00; color: white; }
.home-kal-event {
    display: flex; gap: 12px; align-items: center;
    background: #F8FAFC; padding: 12px 14px;
    border-radius: 12px; margin-bottom: 8px;
    border-left: 4px solid #FF7A00;
    text-decoration: none; color: inherit; transition: .2s;
}
.home-kal-event:hover {
    background: #FFF3E0; transform: translateX(4px); color: inherit;
}
.home-kal-event .time {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white; padding: 8px 12px; border-radius: 10px;
    font-weight: 800; font-size: 12px; flex-shrink: 0;
    display: flex; align-items: center; gap: 4px;
}
.home-kal-event .info { flex: 1; min-width: 0; }
.home-kal-event .info h6 {
    font-size: 14px; font-weight: 800; color: #0F172A;
    margin: 0 0 4px; line-height: 1.3;
}
.home-kal-event .info small {
    font-size: 11.5px; color: #64748B;
    display: block; line-height: 1.5;
}
</style>

<!-- HERO -->
<section class="home-hero">
    <div class="home-hero-inner">
        <div class="home-hero-badge">
            <i class="bi bi-stars"></i>
            Pusat Informasi UKM & Ormawa Polinela
        </div>

        <h1>
            Temukan <span>Event Kampus</span><br>
            dan Komunitas Impianmu
        </h1>

        <p>
            Semua info tentang UKM, Ormawa, event, dan open recruitment UKM & Ormawa
            Politeknik Negeri Lampung dalam satu platform.
        </p>

        <div class="home-hero-actions">
            <a href="<?= base_url('event') ?>" class="home-btn-hero home-btn-hero-primary">
                <i class="bi bi-calendar-event-fill"></i> Jelajahi Event
            </a>
            <a href="<?= base_url('ukm') ?>" class="home-btn-hero home-btn-hero-outline">
                <i class="bi bi-people-fill"></i> Lihat UKM
            </a>
        </div>
    </div>
</section>

<!-- SEARCH -->
<div class="home-search">
    <form action="<?= base_url('search') ?>" method="get" class="home-search-card">
        <div class="icon"><i class="bi bi-search"></i></div>
        <input type="text" name="q" placeholder="Cari event, UKM, berita, recruitment...">
        <button type="submit" class="btn">Cari <i class="bi bi-arrow-right ms-1"></i></button>
    </form>
</div>

<!-- ⬇️ WRAPPER ORANGE DIMULAI ⬇️ -->
<div class="pub-body-orange">

    <i class="bi bi-stars spark spark-1"></i>
    <i class="bi bi-stars spark spark-2"></i>
    <i class="bi bi-star-fill spark spark-3"></i>
    <i class="bi bi-stars spark spark-4"></i>
    <i class="bi bi-star-fill spark spark-5"></i>

    <div class="ball ball-1"></div>
    <div class="ball ball-2"></div>
    <div class="ball ball-3"></div>
    <div class="ball ball-4"></div>
    <div class="ball ball-5"></div>

    <div class="pub-body-inner">

        <!-- STATISTIK -->
        <section class="home-stats-section">
            <div class="home-stats-inner">
                <div class="home-stat-card">
                    <div class="home-stat-icon" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="home-stat-num"><?= $total_ukm ?? 0 ?></div>
                    <div class="home-stat-lbl">UKM & Ormawa</div>
                </div>
                <div class="home-stat-card">
                    <div class="home-stat-icon" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <div class="home-stat-num"><?= $total_event ?? 0 ?></div>
                    <div class="home-stat-lbl">Event Aktif</div>
                </div>
                <div class="home-stat-card">
                    <div class="home-stat-icon" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                        <i class="bi bi-megaphone-fill"></i>
                    </div>
                    <div class="home-stat-num"><?= $total_recruitment ?? 0 ?></div>
                    <div class="home-stat-lbl">Recruitment</div>
                </div>
                <div class="home-stat-card">
                    <div class="home-stat-icon" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="home-stat-num"><?= $total_ulasan ?? 0 ?></div>
                    <div class="home-stat-lbl">Ulasan</div>
                </div>
            </div>
        </section>

        <!-- KATEGORI -->
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-grid-3x3-gap-fill"></i> Jelajahi</div>
                    <h2>Mulai dari <span>Sini</span></h2>
                    <p>Pilih kategori untuk mulai menjelajahi semua yang ada di EventNela.</p>
                </div>

                <div class="home-cat-grid">
                    <a href="<?= base_url('event') ?>" class="home-cat-card">
                        <div class="home-cat-icon" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                            <i class="bi bi-calendar-event-fill"></i>
                        </div>
                        <h3>Event Kegiatan</h3>
                        <p>Seminar, workshop, lomba, dan acara seru kampus</p>
                        <span class="home-cat-count"><?= $total_event ?? 0 ?> event</span>
                    </a>

                    <a href="<?= base_url('ukm') ?>" class="home-cat-card">
                        <div class="home-cat-icon" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h3>UKM & Ormawa</h3>
                        <p>Kenali semua organisasi kemahasiswaan di Polinela</p>
                        <span class="home-cat-count"><?= $total_ukm ?? 0 ?> organisasi</span>
                    </a>

                    <a href="<?= base_url('recruitment') ?>" class="home-cat-card">
                        <div class="home-cat-icon" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                            <i class="bi bi-megaphone-fill"></i>
                        </div>
                        <h3>Open Recruitment</h3>
                        <p>Gabung jadi anggota baru UKM / Ormawa</p>
                        <span class="home-cat-count"><?= $total_recruitment ?? 0 ?> aktif</span>
                    </a>

                    <a href="<?= base_url('berita') ?>" class="home-cat-card">
                        <div class="home-cat-icon" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                            <i class="bi bi-newspaper"></i>
                        </div>
                        <h3>Berita Terbaru</h3>
                        <p>Update kegiatan dan prestasi mahasiswa</p>
                        <span class="home-cat-count"><?= $total_berita ?? 0 ?> berita</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- UKM POPULER -->
        <?php if (!empty($ukm_populer)): ?>
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-trophy-fill"></i> Trending</div>
                    <h2>UKM & Ormawa <span>Terpopuler</span></h2>
                    <p>Organisasi paling aktif di Politeknik Negeri Lampung</p>
                </div>

                <div class="home-grid-4">
                    <?php foreach ($ukm_populer as $u): ?>
                        <a href="<?= base_url('ukm/detail/' . $u['id_ormawa']) ?>" class="home-org-card">
                            <?php if (!empty($u['logo']) && file_exists('uploads/logo/' . $u['logo'])): ?>
                                <img src="<?= base_url('uploads/logo/' . $u['logo']) ?>" class="home-org-logo" alt="">
                            <?php else: ?>
                                <div class="home-org-logo"><i class="bi bi-building"></i></div>
                            <?php endif; ?>
                            <div class="home-org-name"><?= esc($u['nama_ormawa']) ?></div>
                            <span class="home-org-cat"><?= esc($u['kategori'] ?? 'UKM') ?></span>
                            <div class="home-org-stats">
                                <span><i class="bi bi-calendar-check"></i> <?= $u['total_event'] ?> event</span>
                                <?php if (($u['rata_rating'] ?? 0) > 0): ?>
                                    <span><i class="bi bi-star-fill text-warning"></i> <?= number_format($u['rata_rating'], 1) ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- EVENT TERBARU -->
        <?php if (!empty($events)): ?>
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-calendar-event-fill"></i> Baru</div>
                    <h2>Event <span>Terbaru</span></h2>
                    <p>Kegiatan terkini dari UKM & Ormawa Polinela</p>
                </div>

                <div class="home-grid-3">
                    <?php foreach ($events as $e): ?>
                        <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" class="home-event-card">
                            <div class="home-event-poster">
                                <?php if (!empty($e['poster']) && file_exists('uploads/poster/' . $e['poster'])): ?>
                                    <img src="<?= base_url('uploads/poster/' . $e['poster']) ?>" alt="">
                                <?php else: ?>
                                    <div class="no-img"><i class="bi bi-image"></i></div>
                                <?php endif; ?>
                                <span class="home-event-badge">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    <?= date('d M Y', strtotime($e['tanggal'])) ?>
                                </span>
                            </div>
                            <div class="home-event-body">
                                <div class="home-event-org">
                                    <?php if (!empty($e['ormawa_logo']) && file_exists('uploads/logo/' . $e['ormawa_logo'])): ?>
                                        <img src="<?= base_url('uploads/logo/' . $e['ormawa_logo']) ?>" alt="">
                                    <?php endif; ?>
                                    <?= esc($e['nama_ormawa'] ?? '-') ?>
                                </div>
                                <h3><?= esc($e['nama_event']) ?></h3>
                                <div class="home-event-meta">
                                    <span><i class="bi bi-clock"></i><?= esc($e['waktu'] ?? '-') ?></span>
                                    <span><i class="bi bi-geo-alt"></i><?= esc(substr($e['gedung'] ?? '-', 0, 20)) ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div style="text-align: center; margin-top: 40px;">
                    <a href="<?= base_url('event') ?>"
                       style="display:inline-flex;align-items:center;gap:8px;padding:14px 30px;
                              border-radius:50px;background:white;color:#0F172A;font-weight:800;
                              font-size:14px;text-decoration:none;border:1px solid #E2E8F0;transition:.25s;">
                        Lihat Semua Event <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- KALENDER -->
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-calendar3"></i> Jadwal</div>
                    <h2>Kalender <span>Kegiatan</span></h2>
                    <p>Lihat jadwal event kampus dalam tampilan kalender</p>
                </div>

                <div class="home-kalender-wrap">
                    <div class="home-kal-header">
                        <button class="home-kal-nav" onclick="homePrevMonth()"><i class="bi bi-chevron-left"></i></button>
                        <h3 id="homeMonthLabel">Memuat...</h3>
                        <button class="home-kal-nav" onclick="homeNextMonth()"><i class="bi bi-chevron-right"></i></button>
                    </div>

                    <div class="home-kal-days">
                        <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div>
                        <div>Jum</div><div>Sab</div><div>Min</div>
                    </div>

                    <div class="home-kal-grid" id="homeKalGrid"></div>

<!-- PANEL DETAIL EVENT -->
<div class="home-kal-detail" id="homeKalDetail" style="display:none;">
    <div class="home-kal-detail-head">
        <h4 id="homeKalDetailTanggal"></h4>
        <button class="home-kal-close" onclick="homeTutupDetail()">×</button>
    </div>
    <div id="homeKalDetailList"></div>
</div>

<div class="home-kal-legend">
    <span><span class="dot dot-event"></span> Ada Kegiatan</span>
    <span><span class="dot dot-today"></span> Hari Ini</span>
</div>
                </div>
            </div>
        </section>

        <!-- RECRUITMENT -->
        <?php if (!empty($recruitments)): ?>
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-megaphone-fill"></i> Sedang Buka</div>
                    <h2>Open <span>Recruitment</span></h2>
                    <p>Gabung jadi anggota baru UKM/Ormawa favoritmu</p>
                </div>

                <div class="home-grid-3">
                    <?php foreach ($recruitments as $r): ?>
                        <a href="<?= base_url('recruitment/detail/' . $r['id_recruitment']) ?>" class="home-event-card">
                            <div class="home-event-poster" style="height: 150px; background: white; border-bottom: 1px solid #F1F5F9;">
                                <?php if (!empty($r['logo']) && file_exists('uploads/logo/' . $r['logo'])): ?>
                                    <img src="<?= base_url('uploads/logo/' . $r['logo']) ?>"
                                         alt="" style="object-fit: contain; padding: 20px;">
                                <?php else: ?>
                                    <div class="no-img" style="color: #FFB74D;">
                                        <i class="bi bi-megaphone"></i>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="home-event-body">
                                <div class="home-event-org">
                                    <i class="bi bi-building"></i>
                                    <?= esc($r['nama_ormawa']) ?>
                                </div>
                                <h3><?= esc($r['judul']) ?></h3>
                                <div class="home-event-meta">
                                    <span><i class="bi bi-tag-fill"></i><?= esc($r['posisi'] ?? '-') ?></span>
                                    <span><i class="bi bi-calendar3"></i><?= esc($r['periode'] ?? '-') ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- BERITA -->
        <?php if (!empty($berita_terbaru)): ?>
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-newspaper"></i> Info</div>
                    <h2>Berita <span>Terbaru</span></h2>
                    <p>Update kegiatan kampus dan prestasi mahasiswa</p>
                </div>

                <div class="home-grid-3">
                    <?php foreach ($berita_terbaru as $b): ?>
                        <a href="<?= base_url('berita/detail/' . $b['id_berita']) ?>" class="home-event-card">
                            <div class="home-event-poster" style="height: 180px;">
                                <?php if (!empty($b['foto']) && file_exists('uploads/berita/' . $b['foto'])): ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['foto']) ?>" alt="">
                                <?php else: ?>
                                    <div class="no-img"><i class="bi bi-newspaper"></i></div>
                                <?php endif; ?>
                            </div>
                            <div class="home-event-body">
                                <div class="home-event-org">
                                    <?php if (!empty($b['ormawa_logo']) && file_exists('uploads/logo/' . $b['ormawa_logo'])): ?>
                                        <img src="<?= base_url('uploads/logo/' . $b['ormawa_logo']) ?>" alt="">
                                    <?php endif; ?>
                                    <?= esc($b['nama_ormawa']) ?>
                                </div>
                                <h3><?= esc($b['judul']) ?></h3>
                                <div class="home-event-meta">
                                    <span><i class="bi bi-calendar3"></i><?= date('d M Y', strtotime($b['created_at'])) ?></span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- STATISTIK PENGUNJUNG -->
        <section class="home-section">
            <div class="home-container">
                <div class="home-section-head">
                    <div class="home-kicker"><i class="bi bi-graph-up-arrow"></i> Statistik</div>
                    <h2>Pengunjung <span>EventNela</span></h2>
                    <p>Data kunjungan website EventNela tahun <?= date('Y') ?></p>
                </div>

                <div class="home-grid-3" style="margin-bottom: 30px;">
                    <div class="home-stat-card">
                        <div class="home-stat-icon" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                            <i class="bi bi-eye-fill"></i>
                        </div>
                        <div class="home-stat-num"><?= number_format($totalVisitor ?? 0) ?></div>
                        <div class="home-stat-lbl">Total Pengunjung</div>
                    </div>
                    <div class="home-stat-card">
                        <div class="home-stat-icon" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                            <i class="bi bi-calendar-day"></i>
                        </div>
                        <div class="home-stat-num"><?= number_format($today ?? 0) ?></div>
                        <div class="home-stat-lbl">Hari Ini</div>
                    </div>
                    <div class="home-stat-card">
                        <div class="home-stat-icon" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                            <i class="bi bi-graph-up-arrow"></i>
                        </div>
                        <div class="home-stat-num"><?= array_sum($chartData ?? []) ?></div>
                        <div class="home-stat-lbl">Tahun <?= date('Y') ?></div>
                    </div>
                </div>

                <div style="background: white; border-radius: 24px; padding: 28px;
                            box-shadow: 0 10px 40px rgba(15,23,42,.06); border: 1px solid #F1F5F9;">
                    <div style="position: relative; height: 320px;">
                        <canvas id="homeVisitorChart"></canvas>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="home-section" style="padding-bottom: 60px;">
            <div class="home-container">
                <div class="home-cta">
                    <h2>Bingung Mau Mulai dari Mana?</h2>
                    <p>Tanya EventNela AI tentang UKM, event, atau rekomendasi kegiatan. Jawaban real-time dari database kampus.</p>
                    <a href="<?= base_url('chatbot') ?>" class="btn">
                        <i class="bi bi-robot"></i> Tanya AI Sekarang
                    </a>
                </div>
            </div>
        </section>

    </div> <!-- /pub-body-inner -->
</div> <!-- /pub-body-orange -->
<!-- ⬆️ WRAPPER ORANGE SELESAI ⬆️ -->

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
(function() {
    function renderVisitorChart() {
        const canvas = document.getElementById('homeVisitorChart');
        if (!canvas) return;
        if (typeof Chart === 'undefined') return;

        const chartData = <?= json_encode($chartData ?? [0,0,0,0,0,0,0,0,0,0,0,0]) ?>;
        const adaData = chartData.some(v => v > 0);

        new Chart(canvas, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                datasets: [{
                    label: 'Pengunjung',
                    data: chartData,
                    borderColor: '#FF7A00',
                    backgroundColor: 'rgba(255,122,0,0.12)',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#FF7A00',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 3,
                    pointRadius: adaData ? 5 : 0,
                    pointHoverRadius: 8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { backgroundColor: '#0F172A', padding: 12, cornerRadius: 10, displayColors: false }
                },
                scales: {
                    y: { beginAtZero: true, suggestedMax: adaData ? undefined : 5, ticks: { stepSize: 1, precision: 0, color: '#64748B' }, grid: { color: '#F1F5F9' }, border: { display: false } },
                    x: { ticks: { color: '#64748B' }, grid: { display: false }, border: { display: false } }
                }
            }
        });
    }
    if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', renderVisitorChart);
    else setTimeout(renderVisitorChart, 100);
})();
</script>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const eventsByDate = <?= json_encode($eventsByDate ?? []) ?>;
let homeCalYear, homeCalMonth;
const homeMonthNames = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const homeHariNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

function homeRenderKalender(year, month) {
    document.getElementById('homeMonthLabel').textContent = homeMonthNames[month] + ' ' + year;
    const grid = document.getElementById('homeKalGrid');
    grid.innerHTML = '';

    let firstDay = new Date(year, month, 1).getDay();
    firstDay = (firstDay === 0) ? 6 : firstDay - 1;
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        const cell = document.createElement('div');
        cell.className = 'home-kal-cell empty';
        grid.appendChild(cell);
    }

    const today = new Date();
    const todayStr = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0') + '-' + String(today.getDate()).padStart(2, '0');

    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
        const cell = document.createElement('div');
        cell.className = 'home-kal-cell';
        if (dateStr === todayStr) cell.classList.add('today');

        const events = eventsByDate[dateStr] || [];
        if (events.length > 0) {
            cell.classList.add('has-event');
            cell.innerHTML = `${day}<span class="count">${events.length}</span>`;
            cell.style.cursor = 'pointer';
            cell.onclick = () => homeTampilDetail(dateStr);
        } else {
            cell.textContent = day;
        }
        grid.appendChild(cell);
    }
}

function homeTampilDetail(dateStr) {
    const events = eventsByDate[dateStr] || [];
    if (!events.length) return;

    const d = new Date(dateStr + 'T00:00:00');
    document.getElementById('homeKalDetailTanggal').innerHTML =
        '📅 ' + homeHariNames[d.getDay()] + ', ' + d.getDate() + ' ' + homeMonthNames[d.getMonth()] + ' ' + d.getFullYear();

    const list = events.map(e => `
        <a href="<?= base_url('detail_event/') ?>${e.id_event || ''}" class="home-kal-event">
            <div class="time"><i class="bi bi-clock-fill"></i> ${(e.waktu || '00:00').substring(0,5)}</div>
            <div class="info">
                <h6>${e.nama_event}</h6>
                <small>
                    <i class="bi bi-people-fill"></i> <strong>${e.nama_ormawa || '-'}</strong>
                    &nbsp;•&nbsp;
                    <i class="bi bi-geo-alt-fill"></i> ${e.gedung || '-'}
                </small>
                <small style="margin-top:3px;">
                    <span style="color:#15803D; font-weight:800;">● ${e.status || 'Published'}</span>
                </small>
            </div>
        </a>
    `).join('');

    document.getElementById('homeKalDetailList').innerHTML = list;
    document.getElementById('homeKalDetail').style.display = 'block';
}

function homeTutupDetail() {
    const el = document.getElementById('homeKalDetail');
    if (el) el.style.display = 'none';
}

function homePrevMonth() {
    homeCalMonth--;
    if (homeCalMonth < 0) { homeCalMonth = 11; homeCalYear--; }
    homeTutupDetail();
    homeRenderKalender(homeCalYear, homeCalMonth);
}
function homeNextMonth() {
    homeCalMonth++;
    if (homeCalMonth > 11) { homeCalMonth = 0; homeCalYear++; }
    homeTutupDetail();
    homeRenderKalender(homeCalYear, homeCalMonth);
}

document.addEventListener('DOMContentLoaded', () => {
    const now = new Date();
    homeCalYear = now.getFullYear();
    homeCalMonth = now.getMonth();
    homeRenderKalender(homeCalYear, homeCalMonth);
});
</script>
<?= $this->endSection() ?>