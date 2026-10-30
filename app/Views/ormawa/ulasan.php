<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-star-fill me-2" style="color: var(--en-primary);"></i> Ulasan Event Saya</h3>
            <p>Lihat semua ulasan dari pengunjung event ormawa kamu</p>
        </div>
    </div>
</div>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-chat-dots-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_ulasan ?? 0 ?></div>
        <div class="en-stat__lbl">Total Ulasan</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
        <div class="en-stat__val"><?= number_format($rating_avg ?? 0, 1) ?><span style="font-size: 16px; color: var(--en-muted);">/5</span></div>
        <div class="en-stat__lbl">Rating Rata-rata</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-star-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_bintang5 ?? 0 ?></div>
        <div class="en-stat__lbl">Bintang 5</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-emoji-frown-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_rating_rendah ?? 0 ?></div>
        <div class="en-stat__lbl">Rating Rendah</div>
    </div>
</div>

<!-- FILTER -->
<div class="en-card mb-4">
    <form method="get" action="<?= base_url('ormawa/ulasan') ?>" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="<?= base_url('ormawa/ulasan') ?>" class="en-btn <?= ($filter_aktif ?? 'semua') === 'semua' ? 'en-btn-primary' : 'en-btn-light' ?> en-btn-sm">
                <i class="bi bi-grid-fill"></i> Semua
            </a>
            <a href="<?= base_url('ormawa/ulasan?filter=bintang5') ?>" class="en-btn <?= ($filter_aktif ?? '') === 'bintang5' ? 'en-btn-primary' : 'en-btn-light' ?> en-btn-sm">
                ⭐ Bintang 5
            </a>
            <a href="<?= base_url('ormawa/ulasan?filter=bintang_rendah') ?>" class="en-btn <?= ($filter_aktif ?? '') === 'bintang_rendah' ? 'en-btn-primary' : 'en-btn-light' ?> en-btn-sm">
                😟 Rating Rendah
            </a>
            <a href="<?= base_url('ormawa/ulasan?filter=ada_komentar') ?>" class="en-btn <?= ($filter_aktif ?? '') === 'ada_komentar' ? 'en-btn-primary' : 'en-btn-light' ?> en-btn-sm">
                💬 Ada Komentar
            </a>
        </div>

        <div style="flex: 1; min-width: 220px; position: relative;">
            <?php if (!empty($filter_aktif) && $filter_aktif !== 'semua'): ?>
                <input type="hidden" name="filter" value="<?= esc($filter_aktif) ?>">
            <?php endif; ?>
            <input type="text" name="search" placeholder="Cari ulasan atau nama user..."
                   value="<?= esc($search ?? '') ?>" class="form-control"
                   style="height: 40px; border-radius: var(--en-r-pill); border: 1px solid var(--en-border-strong); padding-left: 40px;">
            <i class="bi bi-search" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--en-muted);"></i>
        </div>

        <button type="submit" class="en-btn en-btn-primary en-btn-sm">
            <i class="bi bi-search"></i> Cari
        </button>
    </form>
</div>

<!-- DAFTAR ULASAN -->
<?php if (!empty($ulasanGrouped)): ?>
    <?php foreach ($ulasanGrouped as $group):
        $event = $group['event'];
        $listUlasan = $group['ulasan'];
        $totalUlasanEvent = count($listUlasan);
        $sumRating = 0;
        foreach ($listUlasan as $u) { $sumRating += (int) $u['rating']; }
        $avgRatingEvent = $totalUlasanEvent > 0 ? round($sumRating / $totalUlasanEvent, 1) : 0;
        $hasPoster = !empty($event['poster']) && file_exists('uploads/poster/' . $event['poster']);
    ?>
        <div class="en-card mb-4">
            <div class="en-card__head">
                <div style="display: flex; align-items: center; gap: 12px; flex: 1;">
                    <?php if ($hasPoster): ?>
                        <img src="<?= base_url('uploads/poster/' . $event['poster']) ?>"
                             style="width: 50px; height: 50px; border-radius: 10px; object-fit: cover;">
                    <?php else: ?>
                        <div style="width: 50px; height: 50px; border-radius: 10px;
                                    background: var(--en-grad-primary-soft); color: var(--en-primary);
                                    display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-image"></i>
                        </div>
                    <?php endif; ?>
                    <div>
                        <h3 style="font-size: 15px; margin-bottom: 2px;"><?= esc($event['nama_event']) ?></h3>
                        <small style="color: var(--en-muted); font-size: 12px;">
                            <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($event['tanggal'])) ?>
                            • <?= $totalUlasanEvent ?> ulasan
                        </small>
                    </div>
                </div>
                <span class="en-badge en-badge-primary">⭐ <?= number_format($avgRatingEvent, 1) ?>/5</span>
            </div>

            <?php foreach ($listUlasan as $u): ?>
                <?php
                    $fotoUrl = !empty($u['user_foto']) && file_exists('uploads/profil/' . $u['user_foto'])
                        ? base_url('uploads/profil/' . $u['user_foto'])
                        : null;
                ?>
                <div style="padding: 14px 0; border-bottom: 1px solid var(--en-border); display: flex; gap: 14px;">
                    <?php if ($fotoUrl): ?>
                        <img src="<?= $fotoUrl ?>" style="width: 44px; height: 44px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                    <?php else: ?>
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: var(--en-grad-primary);
                                    color: white; display: flex; align-items: center; justify-content: center;
                                    font-weight: 800; font-size: 16px; flex-shrink: 0;">
                            <?= strtoupper(substr($u['username'] ?? 'U', 0, 1)) ?>
                        </div>
                    <?php endif; ?>

                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px; flex-wrap: wrap;">
                            <div>
                                <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                    <strong style="font-size: 14px; color: var(--en-dark);"><?= esc($u['username'] ?? 'User') ?></strong>
                                    <span style="font-size: 12px; color: #F59E0B;">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $u['rating'] ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                        <span style="color: var(--en-muted);">(<?= $u['rating'] ?>/5)</span>
                                    </span>
                                </div>
                                <div style="font-size: 11px; color: var(--en-muted); margin-top: 2px;">
                                    <i class="bi bi-clock"></i> <?= date('d M Y', strtotime($u['created_at'])) ?>
                                </div>
                            </div>

                            <a href="<?= base_url('ormawa/ulasan/hapus/' . $u['id_ulasan']) ?>"
                               onclick="return confirm('Yakin ingin menghapus ulasan ini?\n\nDari: <?= esc(addslashes($u['username'] ?? 'User')) ?>')"
                               class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>

                        <?php if (!empty($u['komentar'])): ?>
                            <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.7;
                                        margin-top: 10px; padding: 10px 14px; background: var(--en-bg-alt);
                                        border-radius: 10px; border-left: 3px solid var(--en-primary);">
                                <?= nl2br(esc($u['komentar'])) ?>
                            </div>
                        <?php else: ?>
                            <div style="font-size: 12px; color: var(--en-muted); font-style: italic; margin-top: 8px;">
                                <i class="bi bi-chat-square"></i> Tidak ada komentar
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="en-card">
        <div class="en-empty">
            <i class="bi bi-chat-square-text"></i>
            <h5>Belum Ada Ulasan</h5>
            <p><?= !empty($search) ? 'Tidak ditemukan ulasan dengan kata kunci "' . esc($search) . '".' : 'Belum ada user yang memberikan ulasan pada event kamu.' ?></p>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>