<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.rc-page { background: #FFFBF5; }

.rc-hero {
    position: relative;
    padding: 70px 24px 80px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.88) 0%, rgba(230,81,0,.82) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.rc-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.rc-hero-inner {
    position: relative; z-index: 2;
    max-width: 900px; margin: 0 auto; text-align: center;
}
.rc-hero h1 {
    font-size: clamp(30px, 4.5vw, 54px);
    font-weight: 900;
    letter-spacing: -1.5px;
    margin: 0 0 14px;
    color: white;
    text-shadow: 0 4px 25px rgba(0,0,0,.2);
}
.rc-hero p {
    font-size: 16px;
    color: rgba(255,255,255,.95);
    max-width: 580px;
    margin: 0 auto;
    font-weight: 500;
}

.rc-stats {
    max-width: 900px;
    margin: -40px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.rc-stat {
    background: white;
    border-radius: 18px;
    padding: 22px 18px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(15,23,42,.1);
    border: 1px solid #F1F5F9;
    transition: .3s;
}
.rc-stat:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(255,122,0,.18); }
.rc-stat-ico {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 22px; color: white;
}
.rc-stat-num { font-size: 26px; font-weight: 900; color: #0F172A; line-height: 1; letter-spacing: -.5px; }
.rc-stat-lbl { font-size: 11.5px; color: #64748B; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; margin-top: 6px; }

.rc-search-section { padding: 44px 24px 20px; background: white; }
.rc-search-inner { max-width: 700px; margin: 0 auto; position: relative; }
.rc-search-inner input {
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
.rc-search-inner input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 12px 40px rgba(255,122,0,.15);
}
.rc-search-inner i {
    position: absolute;
    left: 22px; top: 50%;
    transform: translateY(-50%);
    color: #FF7A00;
    font-size: 20px;
}

.rc-list-section { padding: 20px 24px 80px; background: #FFFBF5; }
.rc-inner { max-width: 1200px; margin: 0 auto; }

.rc-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
    gap: 24px;
}

.rc-card {
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
    position: relative;
}
.rc-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(255,122,0,.18);
    border-color: #FFE0B2;
    color: inherit;
}
.rc-card-header {
    padding: 24px 22px 20px;
    background: linear-gradient(135deg, #FFF3E0 0%, #FFE0B2 100%);
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 14px;
}
.rc-card-header::before {
    content: '';
    position: absolute;
    top: -30px; right: -30px;
    width: 120px; height: 120px;
    background: radial-gradient(circle, rgba(255,122,0,.15), transparent 70%);
    border-radius: 50%;
}
.rc-logo-wrap {
    position: relative; z-index: 2;
    flex-shrink: 0;
}
.rc-logo-wrap img,
.rc-logo-wrap .fallback {
    width: 66px; height: 66px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: 0 4px 15px rgba(15,23,42,.1);
}
.rc-logo-wrap .fallback {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 26px;
}
.rc-status-badge {
    background: linear-gradient(135deg, #22C55E, #15803D);
    color: white;
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    box-shadow: 0 4px 12px rgba(34,197,94,.3);
    position: relative; z-index: 2;
    display: inline-flex; align-items: center; gap: 5px;
}
.rc-status-badge.closed {
    background: linear-gradient(135deg, #94A3B8, #64748B);
    box-shadow: 0 4px 12px rgba(100,116,139,.3);
}
.rc-card-body {
    padding: 22px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.rc-org-name {
    font-size: 12px;
    color: #E65100;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 10px;
    display: flex; align-items: center; gap: 6px;
}
.rc-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 16px;
    line-height: 1.4;
    min-height: 48px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    letter-spacing: -.3px;
}
.rc-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 16px;
}
.rc-chip {
    background: #F8FAFC;
    color: #475569;
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    display: inline-flex; align-items: center; gap: 5px;
    border: 1px solid #F1F5F9;
}
.rc-chip i { color: #FF7A00; font-size: 11px; }
.rc-period-box {
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-radius: 14px;
    padding: 14px 18px;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-left: 4px solid #FF7A00;
}
.rc-period-box .lbl {
    font-size: 11px;
    color: #94A3B8;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.rc-period-box .val {
    font-size: 15px;
    color: #E65100;
    font-weight: 800;
    margin-top: 3px;
}
.rc-period-box i {
    font-size: 24px;
    color: #FF7A00;
    opacity: .5;
}
.rc-cta {
    margin-top: auto;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.rc-cta-text {
    color: #E65100;
    font-weight: 800;
    font-size: 13.5px;
    display: inline-flex; align-items: center; gap: 6px;
}
.rc-cta i.arrow {
    color: #FF7A00;
    font-size: 18px;
    transition: .3s;
}
.rc-card:hover .rc-cta i.arrow { transform: translateX(5px); }

.rc-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 24px;
    border: 1px dashed #E2E8F0;
}
.rc-empty i { font-size: 70px; color: #E2E8F0; display: block; margin-bottom: 14px; }
.rc-empty h3 { font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px; }
.rc-empty p { font-size: 14px; color: #64748B; margin: 0 0 20px; }
.rc-empty-btn {
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
    .rc-hero { padding: 50px 18px 70px; }
    .rc-stats { grid-template-columns: 1fr; gap: 10px; margin-top: -30px; }
    .rc-grid { grid-template-columns: 1fr; gap: 16px; }
    .rc-list-section { padding: 20px 18px 50px; }
}
</style>

<div class="rc-page">

    <section class="rc-hero">
        <div class="rc-hero-inner">
            <h1>Open Recruitment</h1>
            <p>Gabung menjadi anggota baru UKM & Ormawa Politeknik Negeri Lampung</p>
        </div>
    </section>

    <?php
    $totalRec = count($recruitments ?? []);
    $cntOpen = count(array_filter($recruitments ?? [], fn($r) => ($r['status'] ?? '') === 'open'));
    $cntClosed = $totalRec - $cntOpen;
    ?>
    <div class="rc-stats">
        <div class="rc-stat">
            <div class="rc-stat-ico" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <div class="rc-stat-num"><?= $totalRec ?></div>
            <div class="rc-stat-lbl">Total Recruitment</div>
        </div>
        <div class="rc-stat">
            <div class="rc-stat-ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                <i class="bi bi-unlock-fill"></i>
            </div>
            <div class="rc-stat-num"><?= $cntOpen ?></div>
            <div class="rc-stat-lbl">Sedang Buka</div>
        </div>
        <div class="rc-stat">
            <div class="rc-stat-ico" style="background: linear-gradient(135deg, #64748B, #334155);">
                <i class="bi bi-lock-fill"></i>
            </div>
            <div class="rc-stat-num"><?= $cntClosed ?></div>
            <div class="rc-stat-lbl">Sudah Tutup</div>
        </div>
    </div>

    <section class="rc-search-section">
        <div class="rc-search-inner">
            <i class="bi bi-search"></i>
            <input type="text" id="rcSearch" placeholder="Cari recruitment atau ormawa...">
        </div>
    </section>

    <section class="rc-list-section">
        <div class="rc-inner">
            <?php if (!empty($recruitments)): ?>
                <div class="rc-grid" id="rcGrid">
                    <?php foreach ($recruitments as $r):
                        $isOpen = ($r['status'] ?? '') === 'open';
                        $hasLogo = !empty($r['logo']) && file_exists('uploads/logo/' . $r['logo']);
                    ?>
                        <a href="<?= base_url('recruitment/detail/' . $r['id_recruitment']) ?>"
                           class="rc-card"
                           data-nama="<?= strtolower(esc($r['judul'] ?? '')) ?>"
                           data-ormawa="<?= strtolower(esc($r['nama_ormawa'] ?? '')) ?>">

                            <div class="rc-card-header">
                                <div class="rc-logo-wrap">
                                    <?php if ($hasLogo): ?>
                                        <img src="<?= base_url('uploads/logo/' . $r['logo']) ?>" alt="">
                                    <?php else: ?>
                                        <div class="fallback"><i class="bi bi-building"></i></div>
                                    <?php endif; ?>
                                </div>
                                <span class="rc-status-badge <?= $isOpen ? '' : 'closed' ?>">
                                    <i class="bi bi-<?= $isOpen ? 'unlock-fill' : 'lock-fill' ?>"></i>
                                    <?= $isOpen ? 'Open' : 'Closed' ?>
                                </span>
                            </div>

                            <div class="rc-card-body">
                                <div class="rc-org-name">
                                    <i class="bi bi-building"></i> <?= esc($r['nama_ormawa']) ?>
                                </div>

                                <h3><?= esc($r['judul']) ?></h3>

                                <div class="rc-chips">
                                    <?php if (!empty($r['posisi'])): ?>
                                        <span class="rc-chip"><i class="bi bi-tag-fill"></i><?= esc($r['posisi']) ?></span>
                                    <?php endif; ?>
                                </div>

                                <div class="rc-period-box">
                                    <div>
                                        <div class="lbl">Periode</div>
                                        <div class="val"><?= esc($r['periode'] ?? 'TBA') ?></div>
                                    </div>
                                    <i class="bi bi-calendar-check"></i>
                                </div>

                                <div class="rc-cta">
                                    <span class="rc-cta-text">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <?= $isOpen ? 'Lihat & Daftar' : 'Lihat Detail' ?>
                                    </span>
                                    <i class="bi bi-arrow-right arrow"></i>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="rc-empty">
                    <i class="bi bi-megaphone"></i>
                    <h3>Belum Ada Recruitment</h3>
                    <p>Saat ini belum ada UKM/Ormawa yang membuka recruitment.</p>
                    <a href="<?= base_url('ukm') ?>" class="rc-empty-btn">
                        <i class="bi bi-people-fill"></i> Jelajahi UKM
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('rcSearch')?.addEventListener('keyup', function() {
    const key = this.value.toLowerCase().trim();
    document.querySelectorAll('#rcGrid .rc-card').forEach(card => {
        const nama = card.getAttribute('data-nama');
        const ormawa = card.getAttribute('data-ormawa');
        card.style.display = (nama.includes(key) || ormawa.includes(key)) ? 'flex' : 'none';
    });
});
</script>
<?= $this->endSection() ?>