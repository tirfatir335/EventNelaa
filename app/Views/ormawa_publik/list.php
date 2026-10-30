<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
/* ============================================
   UKM LIST — CLEAN MODERN
   ============================================ */
.ukml-page {
    background: #FFFBF5;
}

/* HERO */
.ukml-hero {
    position: relative;
    padding: 70px 24px 80px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.88) 0%, rgba(230,81,0,.82) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.ukml-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.ukml-hero::after {
    content: '';
    position: absolute;
    bottom: -50%; left: -10%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(255,255,255,.08), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.ukml-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 900px;
    margin: 0 auto;
    text-align: center;
}
.ukml-hero h1 {
    font-size: clamp(30px, 4.5vw, 54px);
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0 0 14px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.ukml-hero p {
    font-size: 16px;
    color: rgba(255,255,255,.95);
    max-width: 580px;
    margin: 0 auto;
    font-weight: 500;
}

/* STAT STRIP */
.ukml-stats {
    max-width: 900px;
    margin: -40px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.ukml-stat {
    background: white;
    border-radius: 18px;
    padding: 22px 18px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(15,23,42,.1);
    border: 1px solid #F1F5F9;
    transition: .3s;
}
.ukml-stat:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(255,122,0,.18); }
.ukml-stat-ico {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 22px; color: white;
}
.ukml-stat-num { font-size: 26px; font-weight: 900; color: #0F172A; line-height: 1; letter-spacing: -.5px; }
.ukml-stat-lbl { font-size: 11.5px; color: #64748B; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; margin-top: 6px; }

/* FILTER */
.ukml-filter {
    padding: 44px 24px 20px;
    background: white;
}
.ukml-filter-inner {
    max-width: 1100px;
    margin: 0 auto;
    display: flex;
    gap: 14px;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
}
.ukml-tabs {
    display: flex;
    gap: 8px;
    background: #FFFBF5;
    padding: 6px;
    border-radius: 50px;
    border: 1px solid #F1F5F9;
}
.ukml-tab {
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 14px;
    font-weight: 700;
    color: #64748B;
    transition: .25s;
    display: inline-flex; align-items: center; gap: 6px;
    text-decoration: none;
}
.ukml-tab:hover { background: #FFF3E0; color: #E65100; }
.ukml-tab.active {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 6px 20px rgba(255,122,0,.3);
}
.ukml-tab .count {
    background: rgba(255,255,255,.25);
    padding: 2px 9px;
    border-radius: 12px;
    font-size: 11px;
}
.ukml-tab:not(.active) .count {
    background: #FFF3E0;
    color: #E65100;
}
.ukml-search {
    position: relative;
    flex: 1;
    max-width: 380px;
    min-width: 250px;
}
.ukml-search input {
    width: 100%; height: 48px;
    padding: 0 20px 0 48px;
    border-radius: 50px;
    border: 1px solid #E2E8F0;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    background: #FFFBF5;
    transition: .2s;
}
.ukml-search input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.ukml-search i {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 16px;
}

/* LIST SECTION — KREM */
.ukml-section {
    padding: 30px 24px 80px;
    background: #FFFBF5;
}
.ukml-inner {
    max-width: 1200px;
    margin: 0 auto;
}
.ukml-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

/* CARD */
.ukml-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    border: 1px solid #F1F5F9;
    box-shadow: 0 4px 20px rgba(15,23,42,.05);
    transition: .35s;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    position: relative;
}
.ukml-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    border-color: #FFE0B2;
    color: inherit;
}
.ukml-card-header {
    height: 110px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    position: relative;
}
.ukml-card-header::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 200px; height: 200px;
    background: rgba(255,255,255,.1);
    border-radius: 50%;
}
.ukml-card-logo {
    position: absolute;
    bottom: -45px; left: 50%;
    transform: translateX(-50%);
    width: 90px; height: 90px;
    border-radius: 50%;
    background: white;
    border: 5px solid white;
    box-shadow: 0 10px 30px rgba(15,23,42,.15);
    object-fit: cover;
    display: flex; align-items: center; justify-content: center;
    font-size: 38px; color: #FF7A00;
}
.ukml-card-cat {
    position: absolute;
    top: 14px; right: 14px;
    background: rgba(255,255,255,.95);
    color: #E65100;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.ukml-card-body {
    padding: 60px 22px 24px;
    text-align: center;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.ukml-card h3 {
    font-size: 16.5px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 8px;
    line-height: 1.35;
    letter-spacing: -.3px;
    min-height: 46px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.ukml-card-pembina {
    font-size: 12.5px;
    color: #94A3B8;
    margin-bottom: 16px;
    min-height: 32px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
}
.ukml-card-stats {
    display: flex;
    justify-content: center;
    gap: 24px;
    padding: 16px 0;
    border-top: 1px solid #F1F5F9;
    border-bottom: 1px solid #F1F5F9;
    margin-bottom: 16px;
}
.ukml-stat-item { text-align: center; }
.ukml-stat-val {
    font-size: 18px;
    font-weight: 900;
    color: #FF7A00;
    line-height: 1;
}
.ukml-stat-lbl2 {
    font-size: 10.5px;
    color: #94A3B8;
    text-transform: uppercase;
    letter-spacing: .8px;
    margin-top: 4px;
    font-weight: 700;
}
.ukml-card-cta {
    color: #E65100;
    font-weight: 800;
    font-size: 13.5px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    margin-top: auto;
    padding-top: 6px;
}
.ukml-card:hover .ukml-card-cta i { transform: translateX(4px); }
.ukml-card-cta i { transition: .3s; }

/* EMPTY */
.ukml-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 24px;
    border: 1px dashed #E2E8F0;
}
.ukml-empty i { font-size: 70px; color: #E2E8F0; display: block; margin-bottom: 14px; }
.ukml-empty h3 { font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px; }
.ukml-empty p { font-size: 14px; color: #64748B; margin: 0 0 20px; }
.ukml-empty-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 14px 30px;
    border-radius: 50px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    font-weight: 800; font-size: 14px;
    text-decoration: none;
    box-shadow: 0 12px 30px rgba(255,122,0,.35);
}

@media (max-width: 768px) {
    .ukml-hero { padding: 50px 18px 70px; }
    .ukml-stats { grid-template-columns: 1fr; gap: 10px; margin-top: -30px; }
    .ukml-filter-inner { flex-direction: column; align-items: stretch; }
    .ukml-tabs { overflow-x: auto; }
    .ukml-tab { white-space: nowrap; padding: 8px 16px; font-size: 13px; }
    .ukml-search { max-width: 100%; }
    .ukml-grid { grid-template-columns: 1fr; gap: 16px; }
    .ukml-section { padding: 20px 18px 50px; }
    .ukml-filter { padding: 30px 18px 16px; }
}
</style>

<div class="ukml-page">

    <!-- HERO -->
    <section class="ukml-hero">
        <div class="ukml-hero-inner">
            <h1>UKM & Ormawa Polinela</h1>
            <p>Temukan komunitas dan organisasi kemahasiswaan di Politeknik Negeri Lampung</p>
        </div>
    </section>

    <!-- STATS -->
    <?php
    $totalOrmawa = count($ormawa_list ?? []);
    $cntHMJ = count(array_filter($ormawa_list ?? [], fn($o) => ($o['kategori'] ?? '') === 'HMJ'));
    $cntUKM = count(array_filter($ormawa_list ?? [], fn($o) => ($o['kategori'] ?? '') === 'UKM'));
    ?>
    <div class="ukml-stats">
        <div class="ukml-stat">
            <div class="ukml-stat-ico" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                <i class="bi bi-people-fill"></i>
            </div>
            <div class="ukml-stat-num"><?= $totalOrmawa ?></div>
            <div class="ukml-stat-lbl">Total Ormawa</div>
        </div>
        <div class="ukml-stat">
            <div class="ukml-stat-ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <div class="ukml-stat-num"><?= $cntHMJ ?></div>
            <div class="ukml-stat-lbl">HMJ</div>
        </div>
        <div class="ukml-stat">
            <div class="ukml-stat-ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                <i class="bi bi-award-fill"></i>
            </div>
            <div class="ukml-stat-num"><?= $cntUKM ?></div>
            <div class="ukml-stat-lbl">UKM</div>
        </div>
    </div>

    <!-- FILTER -->
    <section class="ukml-filter">
        <div class="ukml-filter-inner">
            <div class="ukml-tabs">
                <a href="<?= base_url('ukm') ?>"
                   class="ukml-tab <?= empty($kategori_aktif) ? 'active' : '' ?>">
                    <i class="bi bi-grid-fill"></i> Semua
                    <span class="count"><?= $totalOrmawa ?></span>
                </a>
                <a href="<?= base_url('ukm?kategori=HMJ') ?>"
                   class="ukml-tab <?= ($kategori_aktif ?? '') == 'HMJ' ? 'active' : '' ?>">
                    <i class="bi bi-mortarboard-fill"></i> HMJ
                </a>
                <a href="<?= base_url('ukm?kategori=UKM') ?>"
                   class="ukml-tab <?= ($kategori_aktif ?? '') == 'UKM' ? 'active' : '' ?>">
                    <i class="bi bi-award-fill"></i> UKM
                </a>
            </div>

            <div class="ukml-search">
                <i class="bi bi-search"></i>
                <input type="text" id="ukmlSearch" placeholder="Cari UKM atau Ormawa...">
            </div>
        </div>
    </section>

    <!-- LIST -->
    <section class="ukml-section">
        <div class="ukml-inner">
            <?php if (!empty($ormawa_list)): ?>
                <div class="ukml-grid" id="ukmlGrid">
                    <?php
                    $db = \Config\Database::connect();
                    foreach ($ormawa_list as $o):
                        $hasLogo = !empty($o['logo']) && file_exists('uploads/logo/' . $o['logo']);
                        $totalEvent = $db->table('events')
                            ->where('id_ormawa', $o['id_ormawa'])
                            ->where('status', 'Published')
                            ->countAllResults();
                    ?>
                        <a href="<?= base_url('ukm/detail/' . $o['id_ormawa']) ?>"
                           class="ukml-card"
                           data-nama="<?= strtolower(esc($o['nama_ormawa'])) ?>"
                           data-pembina="<?= strtolower(esc($o['pembina'] ?? '')) ?>">

                            <div class="ukml-card-header">
                                <span class="ukml-card-cat"><?= esc($o['kategori'] ?? 'UKM') ?></span>
                                <?php if ($hasLogo): ?>
                                    <img src="<?= base_url('uploads/logo/' . $o['logo']) ?>"
                                         class="ukml-card-logo" alt="">
                                <?php else: ?>
                                    <div class="ukml-card-logo">
                                        <i class="bi bi-building"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="ukml-card-body">
                                <h3><?= esc($o['nama_ormawa']) ?></h3>
                                <div class="ukml-card-pembina">
                                    <i class="bi bi-person-badge me-1"></i>
                                    <?= esc($o['pembina'] ?? 'Belum ada pembina') ?>
                                </div>

                                <div class="ukml-card-stats">
                                    <div class="ukml-stat-item">
                                        <div class="ukml-stat-val"><?= $totalEvent ?></div>
                                        <div class="ukml-stat-lbl2">Event</div>
                                    </div>
                                    <div class="ukml-stat-item">
                                        <div class="ukml-stat-val"><?= $o['kategori'] == 'HMJ' ? 'HMJ' : 'UKM' ?></div>
                                        <div class="ukml-stat-lbl2">Kategori</div>
                                    </div>
                                </div>

                                <div class="ukml-card-cta">
                                    Lihat Profil Lengkap <i class="bi bi-arrow-right"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="ukml-empty">
                    <i class="bi bi-inbox"></i>
                    <h3>Belum Ada Data UKM</h3>
                    <p>Belum ada UKM/Ormawa yang terdaftar di kategori ini.</p>
                    <a href="<?= base_url('ukm') ?>" class="ukml-empty-btn">
                        <i class="bi bi-arrow-left"></i> Lihat Semua UKM
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('ukmlSearch')?.addEventListener('keyup', function() {
    const key = this.value.toLowerCase().trim();
    document.querySelectorAll('#ukmlGrid .ukml-card').forEach(card => {
        const nama = card.getAttribute('data-nama');
        const pembina = card.getAttribute('data-pembina');
        card.style.display = (nama.includes(key) || pembina.includes(key)) ? 'flex' : 'none';
    });
});
</script>
<?= $this->endSection() ?>