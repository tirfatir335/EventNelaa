<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
/* ============================================
   UKM DETAIL — RICH SECTIONS
   ============================================ */
.ukmd-page { background: #FFFBF5; }

/* HERO */
.ukmd-hero {
    position: relative;
    padding: 70px 24px 100px;
    background:
        linear-gradient(135deg, rgba(15,23,42,.92) 0%, rgba(30,41,59,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.ukmd-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -15%;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(255,122,0,.3), transparent 60%);
    border-radius: 50%;
    pointer-events: none;
    animation: ukmdGlow 12s ease-in-out infinite;
}
.ukmd-hero::after {
    content: '';
    position: absolute;
    bottom: -40%; left: -10%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(59,130,246,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
    animation: ukmdGlow 15s ease-in-out infinite reverse;
}
@keyframes ukmdGlow {
    0%, 100% { transform: translate(0,0); }
    50% { transform: translate(30px, -20px); }
}
.ukmd-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1100px;
    margin: 0 auto;
}
.ukmd-breadcrumb {
    display: flex; gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.65);
    margin-bottom: 30px;
    flex-wrap: wrap;
}
.ukmd-breadcrumb a { color: rgba(255,255,255,.85); text-decoration: none; transition: .2s; }
.ukmd-breadcrumb a:hover { color: #FF7A00; }

.ukmd-hero-grid {
    display: flex;
    align-items: center;
    gap: 36px;
    flex-wrap: wrap;
}
.ukmd-logo-wrap { position: relative; flex-shrink: 0; }
.ukmd-logo-wrap::before {
    content: '';
    position: absolute;
    inset: -14px;
    border-radius: 50%;
    background: conic-gradient(from 0deg, #FF7A00, #FFD700, #FF7A00);
    animation: ukmdSpin 8s linear infinite;
    z-index: 0;
}
@keyframes ukmdSpin { to { transform: rotate(360deg); } }
.ukmd-logo-wrap::after {
    content: '';
    position: absolute;
    inset: -6px;
    border-radius: 50%;
    background: #0F172A;
    z-index: 1;
}
.ukmd-logo {
    position: relative;
    z-index: 2;
    width: 150px; height: 150px;
    border-radius: 50%;
    object-fit: cover;
    background: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 58px; color: #FF7A00;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
}
.ukmd-hero-info { flex: 1; min-width: 260px; }
.ukmd-cat-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    padding: 7px 18px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    margin-bottom: 16px;
    box-shadow: 0 8px 25px rgba(255,122,0,.4);
}
.ukmd-hero-info h1 {
    font-size: clamp(26px, 4vw, 44px);
    font-weight: 900;
    line-height: 1.15;
    letter-spacing: -1.2px;
    margin: 0 0 16px;
    color: white;
}
.ukmd-pembina {
    display: flex; align-items: center; gap: 10px;
    color: rgba(255,255,255,.9);
    font-size: 15px;
    margin-bottom: 22px;
}
.ukmd-pembina i { color: #FFD700; font-size: 18px; }

.ukmd-contacts { display: flex; flex-wrap: wrap; gap: 10px; }
.ukmd-contact {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.2);
    color: white;
    padding: 9px 18px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: .3s;
    backdrop-filter: blur(10px);
}
.ukmd-contact:hover {
    background: rgba(255,122,0,.25);
    border-color: #FF7A00;
    color: white;
    transform: translateY(-2px);
}
.ukmd-contact i { color: #FFD700; }

/* STATS FLOATING */
.ukmd-stats {
    max-width: 1100px;
    margin: -60px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}
.ukmd-stat {
    background: white;
    border-radius: 20px;
    padding: 24px 18px;
    text-align: center;
    box-shadow: 0 15px 50px rgba(15,23,42,.12);
    transition: .35s;
    border: 1px solid #F1F5F9;
}
.ukmd-stat:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 25px 70px rgba(255,122,0,.2);
}
.ukmd-stat-ico {
    width: 54px; height: 54px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 12px;
    font-size: 24px; color: white;
    box-shadow: 0 8px 20px rgba(0,0,0,.12);
}
.ukmd-stat-num { font-size: 28px; font-weight: 900; color: #0F172A; line-height: 1; letter-spacing: -1px; }
.ukmd-stat-lbl { font-size: 11.5px; color: #64748B; font-weight: 800; text-transform: uppercase; letter-spacing: .8px; margin-top: 8px; }

/* SECTIONS */
.ukmd-section { padding: 70px 24px; }
.ukmd-section-white { background: white; }
.ukmd-section-cream { background: #FFFBF5; }
.ukmd-inner { max-width: 1100px; margin: 0 auto; }

.ukmd-section-head {
    text-align: center;
    margin-bottom: 44px;
}
.ukmd-kicker {
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
.ukmd-section-head h2 {
    font-size: clamp(24px, 3.2vw, 38px);
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -1.2px;
    margin: 0 0 10px;
    line-height: 1.15;
}
.ukmd-section-head h2 span { color: #FF7A00; }
.ukmd-section-head p {
    font-size: 15px;
    color: #64748B;
    max-width: 560px;
    margin: 0 auto;
    line-height: 1.65;
}

/* TENTANG */
.ukmd-about {
    background: white;
    border-radius: 24px;
    padding: 36px 40px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    border-left: 6px solid #FF7A00;
    position: relative;
    overflow: hidden;
}
.ukmd-about::before {
    content: '';
    position: absolute;
    top: -50px; right: -50px;
    width: 200px; height: 200px;
    background: radial-gradient(circle, rgba(255,122,0,.08), transparent 65%);
    border-radius: 50%;
}
.ukmd-about p {
    font-size: 15.5px;
    color: #334155;
    line-height: 1.9;
    margin: 0;
    position: relative;
    z-index: 2;
}

/* VISI MISI */
.ukmd-vm-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
}
.ukmd-vm-card {
    background: white;
    border-radius: 24px;
    padding: 36px 32px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    transition: .4s;
    border: 1px solid #F1F5F9;
}
.ukmd-vm-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 20px 60px rgba(255,122,0,.15);
}
.ukmd-vm-card.visi::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(255,122,0,.15), transparent 70%);
    border-radius: 50%;
}
.ukmd-vm-card.misi::before {
    content: '';
    position: absolute;
    top: -40px; right: -40px;
    width: 160px; height: 160px;
    background: radial-gradient(circle, rgba(34,197,94,.15), transparent 70%);
    border-radius: 50%;
}
.ukmd-vm-icon {
    width: 64px; height: 64px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 28px;
    margin-bottom: 20px;
    position: relative; z-index: 2;
    box-shadow: 0 10px 25px rgba(0,0,0,.12);
}
.ukmd-vm-card.visi .ukmd-vm-icon { background: linear-gradient(135deg, #FF7A00, #E65100); }
.ukmd-vm-card.misi .ukmd-vm-icon { background: linear-gradient(135deg, #22C55E, #15803D); }
.ukmd-vm-card h3 {
    font-size: 20px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 14px;
    letter-spacing: -.3px;
    position: relative; z-index: 2;
}
.ukmd-vm-card p {
    font-size: 14.5px;
    color: #475569;
    line-height: 1.85;
    margin: 0;
    position: relative; z-index: 2;
}

/* PENGURUS */
.ukmd-pengurus-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
}
.ukmd-pen-card {
    background: white;
    border-radius: 22px;
    padding: 26px 18px;
    text-align: center;
    box-shadow: 0 10px 35px rgba(15,23,42,.06);
    transition: .4s cubic-bezier(.34,1.56,.64,1);
    border: 2px solid transparent;
}
.ukmd-pen-card:hover {
    transform: translateY(-8px);
    border-color: #FFE0B2;
    box-shadow: 0 25px 70px rgba(255,122,0,.2);
}
.ukmd-pen-foto {
    width: 90px; height: 90px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    margin: 0 auto 14px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    font-size: 34px;
    line-height: 90px;
    text-align: center;
    border: 4px solid #FFF3E0;
    box-shadow: 0 8px 25px rgba(255,122,0,.2);
}
.ukmd-pen-nama {
    font-size: 15px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 6px;
    line-height: 1.3;
}
.ukmd-pen-jabatan {
    display: inline-block;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 10.5px;
    font-weight: 800;
    letter-spacing: .5px;
    text-transform: uppercase;
    box-shadow: 0 4px 12px rgba(255,122,0,.3);
    margin-bottom: 8px;
}
.ukmd-pen-dept {
    display: block;
    font-size: 11.5px;
    color: #E65100;
    font-weight: 700;
    margin-top: 6px;
}
.ukmd-pen-npm {
    display: block;
    font-size: 11px;
    color: #94A3B8;
    font-weight: 600;
    margin-top: 4px;
}

/* DEPARTEMEN */
.ukmd-dept-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}
.ukmd-dept-card {
    background: white;
    border-radius: 20px;
    padding: 32px 24px;
    text-align: center;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    transition: .4s;
    border: 1px solid #F1F5F9;
    position: relative;
    overflow: hidden;
}
.ukmd-dept-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 5px;
    background: linear-gradient(90deg, #FF7A00, #FFD700);
    opacity: 0;
    transition: .4s;
}
.ukmd-dept-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 70px rgba(255,122,0,.18);
}
.ukmd-dept-card:hover::before { opacity: 1; }
.ukmd-dept-icon {
    width: 70px; height: 70px;
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
    color: white;
    font-size: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,.15);
}
.ukmd-dept-card h4 {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 10px;
    letter-spacing: -.3px;
}
.ukmd-dept-card p {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.65;
    margin: 0;
}

/* GALERI */
.ukmd-galeri {
    columns: 4;
    column-gap: 16px;
}
.ukmd-galeri-item {
    break-inside: avoid;
    margin-bottom: 16px;
    border-radius: 18px;
    overflow: hidden;
    position: relative;
    cursor: pointer;
    transition: .4s;
    box-shadow: 0 8px 30px rgba(15,23,42,.08);
}
.ukmd-galeri-item:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 20px 60px rgba(255,122,0,.25);
    z-index: 2;
}
.ukmd-galeri-item img {
    width: 100%;
    display: block;
    transition: .5s;
}
.ukmd-galeri-item:hover img { transform: scale(1.05); }
.ukmd-galeri-caption {
    position: absolute;
    bottom: 0; left: 0; right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,.85));
    color: white;
    padding: 40px 18px 16px;
    font-size: 13px;
    font-weight: 700;
    opacity: 0;
    transition: .3s;
}
.ukmd-galeri-item:hover .ukmd-galeri-caption { opacity: 1; }

/* PROGJA */
.ukmd-progja-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}
.ukmd-progja-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    transition: .4s;
    display: flex;
    flex-direction: column;
    border: 1px solid #F1F5F9;
}
.ukmd-progja-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 70px rgba(255,122,0,.18);
}
.ukmd-progja-img {
    height: 180px;
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    position: relative;
    overflow: hidden;
}
.ukmd-progja-img img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: .5s;
}
.ukmd-progja-card:hover .ukmd-progja-img img { transform: scale(1.08); }
.ukmd-progja-no-img {
    height: 100%;
    display: flex; align-items: center; justify-content: center;
    font-size: 55px; color: #FF7A00; opacity: .4;
}
.ukmd-progja-body { padding: 22px; flex: 1; display: flex; flex-direction: column; }
.ukmd-progja-body h4 {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 12px;
    line-height: 1.4;
    letter-spacing: -.3px;
}
.ukmd-progja-meta {
    display: flex; gap: 12px; flex-wrap: wrap;
    font-size: 12px; color: #64748B;
    margin-bottom: 12px;
}
.ukmd-progja-meta span {
    display: inline-flex; align-items: center; gap: 5px;
}
.ukmd-progja-meta i { color: #FF7A00; }
.ukmd-progja-desc {
    font-size: 13.5px;
    color: #475569;
    line-height: 1.7;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* EVENT TIMELINE */
.ukmd-timeline {
    display: flex;
    flex-direction: column;
    gap: 20px;
    position: relative;
}
.ukmd-timeline::before {
    content: '';
    position: absolute;
    left: 32px;
    top: 20px; bottom: 20px;
    width: 3px;
    background: linear-gradient(180deg, #FF7A00, #FFD700, #FF7A00);
    border-radius: 2px;
    opacity: .3;
}
.ukmd-event-row {
    display: flex;
    gap: 24px;
    align-items: center;
    background: white;
    border-radius: 20px;
    padding: 20px 24px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 8px 30px rgba(15,23,42,.05);
    transition: .4s;
    position: relative;
    border: 1px solid #F1F5F9;
}
.ukmd-event-row:hover {
    transform: translateX(8px);
    box-shadow: 0 15px 45px rgba(255,122,0,.2);
    border-color: #FFE0B2;
    color: inherit;
}
.ukmd-event-date {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border-radius: 16px;
    padding: 14px 16px;
    text-align: center;
    min-width: 80px;
    flex-shrink: 0;
    box-shadow: 0 8px 25px rgba(255,122,0,.35);
    position: relative;
    z-index: 2;
}
.ukmd-event-date .day { font-size: 26px; font-weight: 900; line-height: 1; }
.ukmd-event-date .month { font-size: 11px; text-transform: uppercase; font-weight: 800; letter-spacing: 1px; margin-top: 4px; opacity: .95; }
.ukmd-event-date .year { font-size: 10px; opacity: .85; margin-top: 2px; }
.ukmd-event-info { flex: 1; min-width: 0; }
.ukmd-event-info h4 {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 8px;
    line-height: 1.4;
}
.ukmd-event-info .meta {
    display: flex; gap: 16px; flex-wrap: wrap;
    font-size: 12.5px;
    color: #64748B;
}
.ukmd-event-info .meta i { color: #FF7A00; margin-right: 4px; }
.ukmd-event-arrow {
    font-size: 20px;
    color: #FF7A00;
    transition: .3s;
    flex-shrink: 0;
}
.ukmd-event-row:hover .ukmd-event-arrow { transform: translateX(4px); }

/* EMPTY */
.ukmd-empty {
    text-align: center;
    padding: 50px 20px;
    background: white;
    border-radius: 22px;
    border: 2px dashed #F1F5F9;
}
.ukmd-empty i { font-size: 55px; color: #E2E8F0; display: block; margin-bottom: 12px; }
.ukmd-empty h5 { font-size: 16px; font-weight: 800; color: #0F172A; margin: 0 0 6px; }
.ukmd-empty p { font-size: 13.5px; color: #64748B; margin: 0; }

@media (max-width: 992px) {
    .ukmd-vm-grid { grid-template-columns: 1fr; }
    .ukmd-galeri { columns: 3; }
}
@media (max-width: 768px) {
    .ukmd-hero { padding: 50px 18px 80px; }
    .ukmd-hero-grid { flex-direction: column; text-align: center; }
    .ukmd-hero-info h1 { font-size: 24px; }
    .ukmd-logo, .ukmd-logo-wrap::before, .ukmd-logo-wrap::after { width: 120px; height: 120px; }
    .ukmd-logo { font-size: 46px; }
    .ukmd-contacts { justify-content: center; }
    .ukmd-stats { grid-template-columns: repeat(2, 1fr); gap: 10px; margin-top: -40px; }
    .ukmd-section { padding: 50px 18px; }
    .ukmd-about { padding: 24px 20px; }
    .ukmd-vm-card { padding: 24px 20px; }
    .ukmd-pengurus-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .ukmd-pen-foto { width: 70px; height: 70px; font-size: 26px; line-height: 70px; }
    .ukmd-dept-grid { grid-template-columns: 1fr; }
    .ukmd-galeri { columns: 2; column-gap: 10px; }
    .ukmd-progja-grid { grid-template-columns: 1fr; }
    .ukmd-event-row { padding: 16px; gap: 14px; }
    .ukmd-event-date { min-width: 60px; padding: 10px 12px; }
    .ukmd-event-date .day { font-size: 20px; }
}
</style>

<div class="ukmd-page">

    <!-- HERO -->
    <section class="ukmd-hero">
        <div class="ukmd-hero-inner">

            <div class="ukmd-breadcrumb">
                <a href="<?= base_url('/') ?>">Home</a>
                <span>/</span>
                <a href="<?= base_url('ukm') ?>">UKM & Ormawa</a>
                <span>/</span>
                <span><?= esc($ormawa['nama_ormawa']) ?></span>
            </div>

            <div class="ukmd-hero-grid">
                <div class="ukmd-logo-wrap">
                    <?php if (!empty($ormawa['logo']) && file_exists('uploads/logo/' . $ormawa['logo'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $ormawa['logo']) ?>" class="ukmd-logo" alt="">
                    <?php else: ?>
                        <div class="ukmd-logo"><i class="bi bi-building"></i></div>
                    <?php endif; ?>
                </div>

                <div class="ukmd-hero-info">
                    <div class="ukmd-cat-badge">
                        <i class="bi bi-award-fill"></i>
                        <?= esc($ormawa['kategori'] ?? 'UKM') ?>
                    </div>

                    <h1><?= esc($ormawa['nama_ormawa']) ?></h1>

                    <div class="ukmd-pembina">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Pembina: <?= esc($ormawa['pembina'] ?? 'Belum ada pembina') ?></span>
                    </div>

                    <div class="ukmd-contacts">
                        <?php if (!empty($ormawa['email'])): ?>
                            <a href="mailto:<?= esc($ormawa['email']) ?>" class="ukmd-contact">
                                <i class="bi bi-envelope-fill"></i> <?= esc($ormawa['email']) ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($ormawa['no_telp'])): ?>
                            <a href="tel:<?= esc($ormawa['no_telp']) ?>" class="ukmd-contact">
                                <i class="bi bi-telephone-fill"></i> <?= esc($ormawa['no_telp']) ?>
                            </a>
                        <?php endif; ?>
                        <?php if (!empty($ormawa['instagram'])): ?>
                            <a href="https://instagram.com/<?= esc($ormawa['instagram']) ?>" target="_blank" class="ukmd-contact">
                                <i class="bi bi-instagram"></i> @<?= esc($ormawa['instagram']) ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- STATS -->
    <div class="ukmd-stats">
        <div class="ukmd-stat">
            <div class="ukmd-stat-ico" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                <i class="bi bi-calendar-event-fill"></i>
            </div>
            <div class="ukmd-stat-num"><?= count($events ?? []) ?></div>
            <div class="ukmd-stat-lbl">Event</div>
        </div>
        <div class="ukmd-stat">
            <div class="ukmd-stat-ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="ukmd-stat-num"><?= count($semua_pengurus ?? []) ?></div>
            <div class="ukmd-stat-lbl">Pengurus</div>
        </div>
        <div class="ukmd-stat">
            <div class="ukmd-stat-ico" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                <i class="bi bi-diagram-3-fill"></i>
            </div>
            <div class="ukmd-stat-num"><?= count($departemen_list ?? []) ?></div>
            <div class="ukmd-stat-lbl">Departemen</div>
        </div>
        <div class="ukmd-stat">
            <div class="ukmd-stat-ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                <i class="bi bi-images"></i>
            </div>
            <div class="ukmd-stat-num"><?= count($galeri_ormawa ?? []) ?></div>
            <div class="ukmd-stat-lbl">Foto</div>
        </div>
    </div>

    <!-- TENTANG -->
    <?php if (!empty($ormawa['deskripsi'])): ?>
    <section class="ukmd-section ukmd-section-white">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-info-circle-fill"></i> Tentang</div>
                <h2>Kenali <span><?= esc($ormawa['nama_ormawa']) ?></span></h2>
                <p>Mengenal lebih dekat organisasi kami</p>
            </div>
            <div class="ukmd-about">
                <p><?= nl2br(esc($ormawa['deskripsi'])) ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- VISI MISI -->
    <?php if (!empty($ormawa['visi']) || !empty($ormawa['misi'])): ?>
    <section class="ukmd-section ukmd-section-cream">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-bullseye"></i> Arah Gerak</div>
                <h2>Visi & <span>Misi</span></h2>
                <p>Komitmen kami untuk berkontribusi</p>
            </div>

            <div class="ukmd-vm-grid">
                <?php if (!empty($ormawa['visi'])): ?>
                <div class="ukmd-vm-card visi">
                    <div class="ukmd-vm-icon"><i class="bi bi-eye-fill"></i></div>
                    <h3>Visi</h3>
                    <p><?= nl2br(esc($ormawa['visi'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if (!empty($ormawa['misi'])): ?>
                <div class="ukmd-vm-card misi">
                    <div class="ukmd-vm-icon"><i class="bi bi-list-check"></i></div>
                    <h3>Misi</h3>
                    <p><?= nl2br(esc($ormawa['misi'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- PENGURUS -->
    <?php if (!empty($semua_pengurus)): ?>
    <section class="ukmd-section ukmd-section-white">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-people-fill"></i> Struktur</div>
                <h2>Struktur <span>Kepengurusan</span></h2>
                <p>Tim yang menggerakkan organisasi kami</p>
            </div>

            <div class="ukmd-pengurus-grid">
                <?php foreach ($semua_pengurus as $p): ?>
                    <div class="ukmd-pen-card">
                        <?php if (!empty($p['foto']) && file_exists('uploads/pengurus/' . $p['foto'])): ?>
                            <img src="<?= base_url('uploads/pengurus/' . $p['foto']) ?>"
                                 class="ukmd-pen-foto" alt="">
                        <?php else: ?>
                            <div class="ukmd-pen-foto"><i class="bi bi-person-fill"></i></div>
                        <?php endif; ?>

                        <div class="ukmd-pen-nama"><?= esc($p['nama']) ?></div>
                        <div class="ukmd-pen-jabatan"><?= esc($p['jabatan']) ?></div>

                        <?php if (!empty($p['nama_departemen'])): ?>
                            <div class="ukmd-pen-dept">
                                <i class="bi bi-diagram-3"></i> <?= esc($p['nama_departemen']) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($p['npm'])): ?>
                            <div class="ukmd-pen-npm">NPM. <?= esc($p['npm']) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- DEPARTEMEN -->
    <?php if (!empty($departemen_list)): ?>
    <section class="ukmd-section ukmd-section-cream">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-diagram-3-fill"></i> Divisi</div>
                <h2>Departemen <span>& Divisi</span></h2>
                <p>Bidang-bidang yang ada di organisasi kami</p>
            </div>

            <div class="ukmd-dept-grid">
                <?php foreach ($departemen_list as $d):
                    $warna = !empty($d['warna']) ? $d['warna'] : '#FF7A00';
                    $ikon  = !empty($d['ikon']) ? $d['ikon'] : 'diagram-3-fill';
                ?>
                    <div class="ukmd-dept-card">
                        <div class="ukmd-dept-icon" style="background: linear-gradient(135deg, <?= $warna ?>, <?= $warna ?>cc);">
                            <i class="bi bi-<?= esc($ikon) ?>"></i>
                        </div>
                        <h4><?= esc($d['nama_departemen']) ?></h4>
                        <?php if (!empty($d['deskripsi'])): ?>
                            <p><?= esc($d['deskripsi']) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- PROGRAM KERJA -->
    <?php if (!empty($progja)): ?>
    <section class="ukmd-section ukmd-section-white">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-clipboard-check-fill"></i> Rencana</div>
                <h2>Program <span>Kerja</span></h2>
                <p>Agenda dan rencana kegiatan kami</p>
            </div>

            <div class="ukmd-progja-grid">
                <?php foreach ($progja as $p): ?>
                    <div class="ukmd-progja-card">
                        <div class="ukmd-progja-img">
                            <?php if (!empty($p['foto']) && file_exists('uploads/progja/' . $p['foto'])): ?>
                                <img src="<?= base_url('uploads/progja/' . $p['foto']) ?>" alt="">
                            <?php else: ?>
                                <div class="ukmd-progja-no-img"><i class="bi bi-clipboard-check"></i></div>
                            <?php endif; ?>
                        </div>
                        <div class="ukmd-progja-body">
                            <h4><?= esc($p['nama_progja']) ?></h4>
                            <div class="ukmd-progja-meta">
                                <span><i class="bi bi-calendar3"></i> <?= esc($p['semester'] ?? '-') ?></span>
                                <?php if (!empty($p['target_peserta'])): ?>
                                    <span><i class="bi bi-people"></i> <?= esc($p['target_peserta']) ?> peserta</span>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($p['deskripsi'])): ?>
                                <p class="ukmd-progja-desc"><?= esc($p['deskripsi']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- GALERI -->
    <?php if (!empty($galeri_ormawa)): ?>
    <section class="ukmd-section ukmd-section-cream">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-camera-fill"></i> Dokumentasi</div>
                <h2>Galeri <span>Kegiatan</span></h2>
                <p>Momen-momen berharga dari kegiatan kami</p>
            </div>

            <div class="ukmd-galeri">
                <?php foreach ($galeri_ormawa as $g): ?>
                    <div class="ukmd-galeri-item"
                         onclick="window.open('<?= base_url('uploads/galeri_ormawa/' . $g['foto']) ?>', '_blank')">
                        <img src="<?= base_url('uploads/galeri_ormawa/' . $g['foto']) ?>" alt="">
                        <?php if (!empty($g['judul_foto'])): ?>
                            <div class="ukmd-galeri-caption"><?= esc($g['judul_foto']) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- EVENT -->
    <?php if (!empty($events)): ?>
    <section class="ukmd-section ukmd-section-white">
        <div class="ukmd-inner">
            <div class="ukmd-section-head">
                <div class="ukmd-kicker"><i class="bi bi-calendar-event-fill"></i> Jejak</div>
                <h2>Event yang Pernah <span>Dilaksanakan</span></h2>
                <p>Kegiatan yang sudah kami selenggarakan</p>
            </div>

            <div class="ukmd-timeline">
                <?php foreach ($events as $e): ?>
                    <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" class="ukmd-event-row">
                        <div class="ukmd-event-date">
                            <div class="day"><?= date('d', strtotime($e['tanggal'])) ?></div>
                            <div class="month"><?= date('M', strtotime($e['tanggal'])) ?></div>
                            <div class="year"><?= date('Y', strtotime($e['tanggal'])) ?></div>
                        </div>
                        <div class="ukmd-event-info">
                            <h4><?= esc($e['nama_event']) ?></h4>
                            <div class="meta">
                                <span><i class="bi bi-clock-fill"></i><?= esc($e['waktu'] ?? '-') ?> WIB</span>
                                <span><i class="bi bi-geo-alt-fill"></i><?= esc($e['gedung'] ?? '-') ?></span>
                            </div>
                        </div>
                        <i class="bi bi-chevron-right ukmd-event-arrow"></i>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>