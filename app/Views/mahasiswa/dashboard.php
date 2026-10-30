<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$fotoUrl = !empty(session('foto')) && file_exists('uploads/profil/' . session('foto'))
    ? base_url('uploads/profil/' . session('foto'))
    : 'https://ui-avatars.com/api/?name=' . urlencode(session('username')) . '&background=fff&color=FF7A00&bold=true&size=200';
?>

<div class="en-welcome">
    <div class="en-welcome__top">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;
                        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
                        padding: 5px 14px; border-radius: 20px; width: fit-content; font-size: 11px;
                        font-weight: 700; letter-spacing: .5px;">
                <i class="bi bi-mortarboard-fill"></i> DASHBOARD MAHASISWA
            </div>
            <h2>Halo, <?= esc(session('username')) ?>! 👋</h2>
        </div>
        <span class="date"><i class="bi bi-calendar3"></i> <?= date('d F Y') ?></span>
    </div>

    <div class="en-welcome__stats">
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div class="lbl">Pendaftaran</div>
            <div class="val"><?= $total_pendaftaran ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-check-circle-fill"></i></div>
            <div class="lbl">Diterima</div>
            <div class="val"><?= $total_diterima ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-star-fill"></i></div>
            <div class="lbl">Ulasan</div>
            <div class="val"><?= $total_ulasan ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-graph-up-arrow"></i></div>
            <div class="lbl">Rating Rata</div>
            <div class="val"><?= $avg_rating ?? 0 ?></div>
        </div>
    </div>
</div>

<!-- PENDAFTARAN -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Pendaftaran Saya</h3>
            <p>Status pendaftaran recruitment kamu</p>
        </div>
        <a href="<?= site_url('recruitment/riwayat') ?>" class="en-btn en-btn-outline en-btn-sm">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <?php if (!empty($pendaftaran_terbaru)): ?>
        <?php foreach ($pendaftaran_terbaru as $p):
            $statusMap = [
                'pending'      => ['cls' => 'en-badge-warning', 'lbl' => 'Menunggu'],
                'tes_tertulis' => ['cls' => 'en-badge-info',    'lbl' => 'Tes Tertulis'],
                'wawancara'    => ['cls' => 'en-badge-primary', 'lbl' => 'Wawancara'],
                'diterima'     => ['cls' => 'en-badge-success', 'lbl' => 'Diterima'],
                'ditolak'      => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
            ];
            $st = $statusMap[$p['status_pendaftaran']] ?? $statusMap['pending'];
        ?>
            <a href="<?= site_url('recruitment/riwayat') ?>"
               style="display: flex; gap: 14px; align-items: center; padding: 14px;
                      border-bottom: 1px solid var(--en-border); text-decoration: none; color: inherit; transition: .2s;"
               onmouseover="this.style.background='var(--en-primary-soft)';"
               onmouseout="this.style.background='';">
                <?php if (!empty($p['logo']) && file_exists('uploads/logo/' . $p['logo'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $p['logo']) ?>"
                         style="width: 50px; height: 50px; border-radius: 12px; object-fit: cover;">
                <?php else: ?>
                    <div style="width: 50px; height: 50px; border-radius: 12px;
                                background: var(--en-grad-primary); color: white;
                                display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="bi bi-building"></i>
                    </div>
                <?php endif; ?>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 800; color: var(--en-dark); font-size: 14px;"><?= esc($p['judul']) ?></div>
                    <div style="font-size: 12px; color: var(--en-muted); margin-top: 2px;">
                        <i class="bi bi-building"></i> <?= esc($p['nama_ormawa']) ?>
                        • <?= esc($p['posisi'] ?? '-') ?>
                    </div>
                </div>
                <span class="en-badge <?= $st['cls'] ?>"><?= $st['lbl'] ?></span>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="en-empty" style="padding: 30px;">
            <i class="bi bi-inbox" style="font-size: 40px;"></i>
            <p>Belum ada pendaftaran. <a href="<?= site_url('recruitment') ?>" style="color: var(--en-primary); font-weight: 700;">Cari recruitment →</a></p>
        </div>
    <?php endif; ?>
</div>

<!-- EVENT BISA DIULAS -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-star-fill me-2" style="color: var(--en-primary);"></i> Event yang Bisa Kamu Ulas</h3>
            <p>Bagikan pengalamanmu setelah mengikuti event</p>
        </div>
        <a href="<?= site_url('event') ?>" class="en-btn en-btn-outline en-btn-sm">Lihat Semua</a>
    </div>

    <!-- SEARCH -->
    <div style="position: relative; margin-bottom: 16px; max-width: 380px;">
        <input type="text" id="searchEvent" placeholder="Cari event..."
               style="width: 100%; height: 42px; border-radius: 50px; border: 1px solid var(--en-border-strong);
                      background: var(--en-bg-alt); padding-left: 42px; font-size: 14px; outline: none;">
        <i class="bi bi-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%);
                                       color: var(--en-primary); font-size: 15px;"></i>
    </div>

    <?php if (!empty($event_bisa_diulas)): ?>
        <!-- GRID PAKAI CSS GRID -->
        <div id="eventGrid" style="display: grid;
                                   grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                                   gap: 14px;">
            <?php foreach ($event_bisa_diulas as $e): ?>
                <div class="event-item"
                     data-search="<?= strtolower(esc($e['nama_event'] . ' ' . ($e['nama_ormawa'] ?? ''))) ?>"
                     style="background: white; border-radius: 14px; overflow: hidden;
                            border: 1px solid var(--en-border); display: flex;
                            flex-direction: column; transition: .3s;"
                     onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 12px 30px rgba(255,122,0,.15)';"
                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">

                    <!-- POSTER 120px -->
                    <div style="height: 120px; background: var(--en-grad-primary);
                                position: relative; overflow: hidden;">
                        <?php if (!empty($e['poster']) && file_exists('uploads/poster/' . $e['poster'])): ?>
                            <img src="<?= base_url('uploads/poster/' . $e['poster']) ?>"
                                 style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <div style="display: flex; align-items: center; justify-content: center;
                                        height: 100%; color: rgba(255,255,255,.5); font-size: 32px;">
                                <i class="bi bi-image"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- BODY -->
                    <div style="padding: 14px 16px; flex: 1; display: flex; flex-direction: column;">
                        <div style="font-weight: 800; color: var(--en-dark); font-size: 13.5px;
                                    margin-bottom: 6px; line-height: 1.4;
                                    display: -webkit-box; -webkit-line-clamp: 2; line-clamp: 2;
                                    -webkit-box-orient: vertical; overflow: hidden; min-height: 38px;">
                            <?= esc($e['nama_event']) ?>
                        </div>

                        <div style="font-size: 11.5px; color: var(--en-muted); margin-bottom: 12px; line-height: 1.5;">
                            <div><i class="bi bi-building"></i> <?= esc($e['nama_ormawa'] ?? '-') ?></div>
                            <div style="margin-top: 2px;">
                                <i class="bi bi-calendar3"></i>
                                <?= date('d M Y', strtotime($e['tanggal'])) ?>
                            </div>
                        </div>

                        <?php if (in_array($e['id_event'], $sudah_diulas)): ?>
                            <span class="en-badge en-badge-success"
                                  style="margin-top: auto; justify-content: center; padding: 8px;">
                                <i class="bi bi-check-circle-fill"></i> Sudah Diulas
                            </span>
                        <?php else: ?>
                            <a href="<?= site_url('detail_event/' . $e['id_event']) ?>"
                               class="en-btn en-btn-primary en-btn-sm"
                               style="margin-top: auto; justify-content: center;">
                                <i class="bi bi-pencil-square"></i> Kasih Ulasan
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="noResult" class="en-empty" style="display: none; padding: 30px;">
            <i class="bi bi-search" style="font-size: 40px;"></i>
            <p>Tidak ada event yang cocok. Coba kata kunci lain.</p>
        </div>
    <?php else: ?>
        <div class="en-empty" style="padding: 30px;">
            <i class="bi bi-calendar-x" style="font-size: 40px;"></i>
            <p>Belum ada event yang bisa diulas.</p>
        </div>
    <?php endif; ?>
</div>

<!-- ULASAN SAYA -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-chat-quote-fill me-2" style="color: var(--en-primary);"></i> Ulasan Saya</h3>
    </div>

    <?php if (!empty($ulasan_terbaru)): ?>
        <?php foreach ($ulasan_terbaru as $u): ?>
            <div style="display: flex; gap: 14px; align-items: center; padding: 12px; border-bottom: 1px solid var(--en-border);">
                <?php if (!empty($u['poster']) && file_exists('uploads/poster/' . $u['poster'])): ?>
                    <img src="<?= base_url('uploads/poster/' . $u['poster']) ?>"
                         style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover;">
                <?php else: ?>
                    <div style="width: 50px; height: 50px; border-radius: 10px; background: var(--en-primary-soft);
                                color: var(--en-primary); display: flex; align-items: center; justify-content: center;">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                <?php endif; ?>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 700; color: var(--en-dark); font-size: 13.5px;"><?= esc($u['nama_event']) ?></div>
                    <div style="color: #F59E0B; font-size: 12px; margin-top: 2px;">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi bi-star<?= $i <= $u['rating'] ? '-fill' : '' ?>"></i>
                        <?php endfor; ?>
                        <span style="color: var(--en-muted);">(<?= $u['rating'] ?>/5)</span>
                    </div>
                    <?php if (!empty($u['komentar'])): ?>
                        <div style="font-size: 12px; color: var(--en-text); margin-top: 4px;">
                            "<?= esc(substr($u['komentar'], 0, 80)) ?>..."
                        </div>
                    <?php endif; ?>
                </div>
                <span class="en-badge en-badge-muted"><?= date('d M', strtotime($u['created_at'])) ?></span>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="en-empty" style="padding: 30px;">
            <i class="bi bi-chat-square" style="font-size: 40px;"></i>
            <p>Belum ada ulasan. Beri ulasan event pertamamu!</p>
        </div>
    <?php endif; ?>
</div>

<!-- RECRUITMENT AKTIF -->
<div class="en-card">
    <div class="en-card__head">
        <h3><i class="bi bi-megaphone-fill me-2" style="color: var(--en-primary);"></i> Rekomendasi Recruitment</h3>
        <a href="<?= site_url('recruitment') ?>" class="en-btn en-btn-outline en-btn-sm">Lihat Semua</a>
    </div>

    <?php if (!empty($recruitment_aktif)): ?>
        <?php foreach ($recruitment_aktif as $r): ?>
            <a href="<?= site_url('recruitment/detail/' . $r['id_recruitment']) ?>"
               style="display: flex; gap: 14px; align-items: center; padding: 14px;
                      border-bottom: 1px solid var(--en-border); text-decoration: none; color: inherit;">
                <?php if (!empty($r['logo']) && file_exists('uploads/logo/' . $r['logo'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $r['logo']) ?>"
                         style="width: 50px; height: 50px; border-radius: 12px; object-fit: cover;">
                <?php else: ?>
                    <div style="width: 50px; height: 50px; border-radius: 12px;
                                background: var(--en-grad-primary); color: white;
                                display: flex; align-items: center; justify-content: center; font-size: 20px;">
                        <i class="bi bi-megaphone"></i>
                    </div>
                <?php endif; ?>
                <div style="flex: 1; min-width: 0;">
                    <div style="font-weight: 800; color: var(--en-dark); font-size: 14px;"><?= esc($r['judul']) ?></div>
                    <div style="font-size: 12px; color: var(--en-muted); margin-top: 2px;">
                        <i class="bi bi-building"></i> <?= esc($r['nama_ormawa']) ?>
                        • <?= esc($r['posisi'] ?? '-') ?>
                    </div>
                </div>
                <span class="en-badge en-badge-success"><i class="bi bi-unlock"></i> Open</span>
            </a>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="en-empty" style="padding: 30px;">
            <i class="bi bi-megaphone" style="font-size: 40px;"></i>
            <p>Belum ada recruitment aktif.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('searchEvent')?.addEventListener('keyup', function() {
    const q = this.value.toLowerCase().trim();
    const items = document.querySelectorAll('.event-item');
    let found = 0;

    items.forEach(el => {
        const data = el.getAttribute('data-search');
        if (data.includes(q)) { el.style.display = ''; found++; }
        else { el.style.display = 'none'; }
    });

    document.getElementById('noResult').style.display = found === 0 ? 'block' : 'none';
});
</script>
<?= $this->endSection() ?>