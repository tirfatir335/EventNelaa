<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-welcome">
    <div class="en-welcome__top">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;
                        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
                        padding: 5px 14px; border-radius: 20px; width: fit-content; font-size: 11px;
                        font-weight: 700; letter-spacing: .5px;">
                <i class="bi bi-person-badge-fill"></i> PANEL PEMBINA
            </div>
            <h2>Selamat Datang, <?= esc(session('username')) ?>! 👋</h2>
        </div>
        <span class="date"><i class="bi bi-calendar3"></i> <?= date('d F Y') ?></span>
    </div>

    <div class="en-welcome__stats">
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-hourglass-split"></i></div>
            <div class="lbl">Menunggu Verifikasi</div>
            <div class="val"><?= $total_pending ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-check-circle-fill"></i></div>
            <div class="lbl">Disetujui</div>
            <div class="val"><?= $total_approved ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-x-circle-fill"></i></div>
            <div class="lbl">Ditolak</div>
            <div class="val"><?= $total_rejected ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-clipboard-check"></i></div>
            <div class="lbl">Total LPJ</div>
            <div class="val"><?= ($total_pending + $total_approved + $total_rejected) ?></div>
        </div>
    </div>
</div>

<?php if (!empty($belum_verifikasi) && $belum_verifikasi > 0): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-primary); background: var(--en-grad-primary-soft);">
    <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
        <div style="width: 48px; height: 48px; border-radius: 12px;
                    background: var(--en-grad-primary); color: white;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 22px; flex-shrink: 0;">
            <i class="bi bi-bell-fill"></i>
        </div>
        <div style="flex: 1; min-width: 200px;">
            <div style="font-weight: 800; color: var(--en-primary-dark); font-size: 14px;">
                🔔 <?= $belum_verifikasi ?> LPJ menunggu verifikasi Anda
            </div>
            <div style="color: var(--en-text); font-size: 13px; margin-top: 2px;">
                Segera cek dan verifikasi supaya bisa dilanjutkan ke Wadir.
            </div>
        </div>
        <a href="<?= site_url('pembina/report') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-eye"></i> Lihat
        </a>
    </div>
</div>
<?php endif; ?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_pending ?? 0 ?></div>
        <div class="en-stat__lbl">Menunggu Verifikasi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_approved ?? 0 ?></div>
        <div class="en-stat__lbl">Disetujui</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_rejected ?? 0 ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-file-earmark-check-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= ($total_pending + $total_approved + $total_rejected) ?></div>
        <div class="en-stat__lbl">Total LPJ</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3><i class="bi bi-lightning-charge-fill me-2" style="color: var(--en-primary);"></i> Aksi Cepat</h3>
    </div>
    <div class="en-qa-grid" style="grid-template-columns: repeat(3, 1fr);">
        <a href="<?= site_url('pembina/proposal') ?>" class="en-qa en-qa-1">
            <i class="bi bi-file-earmark-text-fill"></i>
            <h5>Verifikasi Proposal</h5>
            <small>Cek proposal ormawa</small>
        </a>
        <a href="<?= site_url('pembina/report') ?>" class="en-qa en-qa-2">
            <i class="bi bi-file-earmark-check-fill"></i>
            <h5>Verifikasi LPJ</h5>
            <small><?= $belum_verifikasi ?? 0 ?> menunggu</small>
        </a>
        <a href="<?= site_url('pembina/profil') ?>" class="en-qa en-qa-3">
            <i class="bi bi-person-circle"></i>
            <h5>Profil Saya</h5>
            <small>Kelola akun pembina</small>
        </a>
    </div>
</div>

<?= $this->endSection() ?>