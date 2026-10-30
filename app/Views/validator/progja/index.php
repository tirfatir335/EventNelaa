<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-clipboard-check-fill me-2" style="color: var(--en-primary);"></i> Program Kerja Ormawa</h3>
            <p>Validasi program kerja seluruh UKM & HMJ</p>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill"></i><strong><?= session()->getFlashdata('success') ?></strong>
    </div>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
$bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
$totalAll = 0;
foreach ($grouped ?? [] as $g) { $totalAll += count($g['progja']); }

$totalPending = 0; $totalApproved = 0; $totalRejected = 0;
foreach ($grouped ?? [] as $g) {
    foreach ($g['progja'] as $p) {
        if (($p['status'] ?? '') === 'pending')  $totalPending++;
        if (($p['status'] ?? '') === 'approved') $totalApproved++;
        if (($p['status'] ?? '') === 'rejected') $totalRejected++;
    }
}
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-clipboard-check-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalAll ?></div>
        <div class="en-stat__lbl">Total Progja</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalPending ?></div>
        <div class="en-stat__lbl">Menunggu Validasi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalApproved ?></div>
        <div class="en-stat__lbl">Disetujui</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalRejected ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
</div>

<?php if ($totalAll === 0): ?>
    <div class="en-card">
        <div class="en-empty">
            <i class="bi bi-clipboard-x"></i>
            <h5>Belum Ada Program Kerja</h5>
            <p>Belum ada ormawa yang mengajukan program kerja.</p>
        </div>
    </div>
<?php else: ?>

    <?php foreach ($grouped as $g):
        $ormawa = $g['ormawa'];
        $progjaList = $g['progja'];
        if (empty($progjaList)) continue;

        $total = count($progjaList);
        $pending = 0; $approved = 0; $rejected = 0; $draft = 0;
        foreach ($progjaList as $p) {
            if (($p['status'] ?? '') === 'pending')  $pending++;
            if (($p['status'] ?? '') === 'approved') $approved++;
            if (($p['status'] ?? '') === 'rejected') $rejected++;
            if (($p['status'] ?? '') === 'draft')    $draft++;
        }
    ?>
        <div class="en-card mb-4">
            <!-- HEADER ORMAWA -->
            <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;
                        padding-bottom: 16px; border-bottom: 2px solid var(--en-border); margin-bottom: 16px;">
                <?php if (!empty($ormawa['logo']) && file_exists('uploads/logo/' . $ormawa['logo'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $ormawa['logo']) ?>"
                         style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover;
                                border: 3px solid var(--en-primary-soft);">
                <?php else: ?>
                    <div style="width: 54px; height: 54px; border-radius: 50%;
                                background: var(--en-grad-primary); color: white;
                                display: flex; align-items: center; justify-content: center; font-size: 22px;">
                        <i class="bi bi-building"></i>
                    </div>
                <?php endif; ?>
                <div style="flex: 1; min-width: 200px;">
                    <div style="font-size: 16px; font-weight: 800; color: var(--en-dark);">
                        <?= esc($ormawa['nama_ormawa']) ?>
                    </div>
                    <div style="font-size: 12px; color: var(--en-muted); font-weight: 600;">
                        <?= esc($ormawa['kategori'] ?? 'UKM') ?> • <?= $total ?> program kerja
                    </div>
                </div>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    <?php if ($pending > 0): ?>
                        <span class="en-badge en-badge-warning">⏳ <?= $pending ?> Pending</span>
                    <?php endif; ?>
                    <?php if ($approved > 0): ?>
                        <span class="en-badge en-badge-success">✅ <?= $approved ?> Approved</span>
                    <?php endif; ?>
                    <?php if ($rejected > 0): ?>
                        <span class="en-badge en-badge-danger">❌ <?= $rejected ?> Ditolak</span>
                    <?php endif; ?>
                    <?php if ($draft > 0): ?>
                        <span class="en-badge en-badge-muted">📝 <?= $draft ?> Draft</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- LIST PROGJA -->
            <?php foreach ($progjaList as $p):
                $status = $p['status'] ?? 'draft';
                $badgeMap = [
                    'draft'    => ['cls' => 'en-badge-muted',   'lbl' => '📝 Draft'],
                    'pending'  => ['cls' => 'en-badge-warning', 'lbl' => '⏳ Pending'],
                    'approved' => ['cls' => 'en-badge-success', 'lbl' => '✅ Approved'],
                    'rejected' => ['cls' => 'en-badge-danger',  'lbl' => '❌ Ditolak'],
                ];
                $b = $badgeMap[$status] ?? $badgeMap['draft'];

                $hasProposal = !empty($p['id_proposal']);
                $proposalApproved = $hasProposal
                    && ($p['status_ketua'] ?? '') === 'approved'
                    && ($p['status_pembina'] ?? '') === 'approved'
                    && ($p['status_wadir'] ?? '') === 'approved';
            ?>
                <div style="display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
                            padding: 14px 0; border-bottom: 1px solid var(--en-border);">
                    <div style="width: 46px; height: 46px; border-radius: 12px;
                                background: var(--en-grad-primary); color: white;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 12px; font-weight: 800; text-transform: uppercase; flex-shrink: 0;">
                        <?= $bulanList[($p['bulan'] ?? 1) - 1] ?>
                    </div>

                    <div style="flex: 1; min-width: 200px;">
                        <div style="font-size: 14px; font-weight: 800; color: var(--en-dark); margin-bottom: 4px;">
                            <?= esc($p['nama_progja']) ?>
                        </div>
                        <div style="font-size: 12px; color: var(--en-muted); font-weight: 600;">
                            <i class="bi bi-calendar3"></i> <?= esc($p['semester'] ?? '-') ?>
                            <?php if (!empty($p['target_peserta'])): ?>
                                • <i class="bi bi-people-fill"></i> <?= esc($p['target_peserta']) ?> peserta
                            <?php endif; ?>
                        </div>
                    </div>

                    <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>

                    <?php if ($proposalApproved): ?>
                        <span class="en-badge en-badge-success" style="background: linear-gradient(135deg, #22C55E, #15803D); color: white;">
                            📄 Proposal OK
                        </span>
                    <?php elseif ($hasProposal): ?>
                        <span class="en-badge en-badge-info">📄 Proposal Pending</span>
                    <?php endif; ?>

                    <a href="<?= site_url('validator/progja/detail/' . $p['id_progja']) ?>"
                       class="en-btn en-btn-primary en-btn-sm">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>

<?php endif; ?>

<?= $this->endSection() ?>