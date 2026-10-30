<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-clipboard-check-fill me-2" style="color: var(--en-primary);"></i> Program Kerja</h3>
            <p>Kelola rencana program kerja ormawa per bulan</p>
        </div>
        <a href="<?= site_url('ormawa/program-kerja/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Progja
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
        <strong><?= session()->getFlashdata('success') ?></strong>
    </div>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
    $bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $total = count($progja ?? []);
    $cntPending  = count(array_filter($progja ?? [], fn($p) => ($p['status'] ?? '') === 'pending'));
    $cntApproved = count(array_filter($progja ?? [], fn($p) => ($p['status'] ?? '') === 'approved'));
    $cntRejected = count(array_filter($progja ?? [], fn($p) => ($p['status'] ?? '') === 'rejected'));
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-clipboard-check-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total ?></div>
        <div class="en-stat__lbl">Total Progja</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntPending ?></div>
        <div class="en-stat__lbl">Pending</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntApproved ?></div>
        <div class="en-stat__lbl">Disetujui</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntRejected ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
</div>

<?php if (!empty($progja)): ?>
<div class="row g-4">
    <?php foreach ($progja as $p):
        $status = $p['status'] ?? 'draft';
        $badgeMap = [
            'draft'    => ['cls' => 'en-badge-muted',   'lbl' => '📝 Draft'],
            'pending'  => ['cls' => 'en-badge-warning', 'lbl' => '⏳ Menunggu'],
            'approved' => ['cls' => 'en-badge-success', 'lbl' => '✅ Disetujui'],
            'rejected' => ['cls' => 'en-badge-danger',  'lbl' => '❌ Ditolak'],
        ];
        $b = $badgeMap[$status] ?? $badgeMap['draft'];
        $hasProposal = !empty($p['proposal']);
        $proposalApproved = $hasProposal
            && ($p['proposal']['status_ketua'] ?? '') === 'approved'
            && ($p['proposal']['status_pembina'] ?? '') === 'approved'
            && ($p['proposal']['status_wadir'] ?? '') === 'approved';
    ?>
        <div class="col-md-6 col-lg-4">
            <div class="en-card" style="height: 100%; display: flex; flex-direction: column;">
                <?php if (!empty($p['foto']) && file_exists('uploads/progja/' . $p['foto'])): ?>
                    <img src="<?= base_url('uploads/progja/' . $p['foto']) ?>"
                         style="width: 100%; height: 150px; object-fit: cover; border-radius: var(--en-r); margin-bottom: 14px;">
                <?php else: ?>
                    <div style="width: 100%; height: 150px; background: var(--en-grad-primary-soft);
                                border-radius: var(--en-r); display: flex; align-items: center;
                                justify-content: center; color: var(--en-primary); font-size: 42px; margin-bottom: 14px;">
                        <i class="bi bi-clipboard-check"></i>
                    </div>
                <?php endif; ?>

                <span class="en-badge <?= $b['cls'] ?>" style="align-self: flex-start; margin-bottom: 10px;">
                    <?= $b['lbl'] ?>
                </span>

                <h4 style="font-size: 15px; font-weight: 800; color: var(--en-dark); margin: 0 0 8px; line-height: 1.4;">
                    <?= esc($p['nama_progja']) ?>
                </h4>

                <div style="display: flex; flex-wrap: wrap; gap: 10px; font-size: 12px; color: var(--en-muted); margin-bottom: 12px;">
                    <span><i class="bi bi-calendar3" style="color: var(--en-primary);"></i> <?= esc($p['semester'] ?? '-') ?></span>
                    <?php if (!empty($p['bulan'])): ?>
                        <span><i class="bi bi-calendar-week" style="color: var(--en-primary);"></i> <?= $bulanList[$p['bulan'] - 1] ?></span>
                    <?php endif; ?>
                    <span><i class="bi bi-people-fill" style="color: var(--en-primary);"></i> <?= esc($p['target_peserta'] ?? '-') ?> peserta</span>
                </div>

                <?php if (!empty($p['deskripsi'])): ?>
                    <p style="font-size: 13px; color: var(--en-text); line-height: 1.6;
                              display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
                              overflow: hidden; margin-bottom: 12px;">
                        <?= esc($p['deskripsi']) ?>
                    </p>
                <?php endif; ?>

                <?php if ($status === 'rejected' && !empty($p['catatan_validator'])): ?>
                    <div style="background: var(--en-danger-soft); border-left: 3px solid var(--en-danger);
                                border-radius: 8px; padding: 10px 12px; margin-bottom: 12px;">
                        <div style="font-size: 10px; color: #B91C1C; font-weight: 800; text-transform: uppercase; margin-bottom: 4px;">
                            Catatan Wadir
                        </div>
                        <div style="font-size: 12px; color: var(--en-text);"><?= esc($p['catatan_validator']) ?></div>
                    </div>
                <?php endif; ?>

                <div style="margin-top: auto; display: flex; gap: 6px; padding-top: 12px;
                            border-top: 1px solid var(--en-border); flex-wrap: wrap;">
                    <?php if ($status === 'draft'): ?>
                        <a href="<?= site_url('ormawa/program-kerja/ajukan/' . $p['id_progja']) ?>"
                           onclick="return confirm('Ajukan progja ini ke Wadir?')"
                           class="en-btn en-btn-primary en-btn-sm">
                            <i class="bi bi-send-fill"></i> Ajukan
                        </a>
                    <?php endif; ?>
                    <?php if ($status === 'rejected'): ?>
                        <a href="<?= site_url('ormawa/program-kerja/ajukan/' . $p['id_progja']) ?>"
                           onclick="return confirm('Ajukan ulang progja ini?')"
                           class="en-btn en-btn-primary en-btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> Ajukan Ulang
                        </a>
                    <?php endif; ?>
                    <?php if ($status === 'approved' && !$proposalApproved): ?>
                        <a href="<?= site_url('ormawa/proposal/isi/' . $p['id_progja']) ?>"
                           class="en-btn en-btn-primary en-btn-sm">
                            <i class="bi bi-file-earmark-arrow-up-fill"></i>
                            <?= $hasProposal ? 'Lihat' : 'Upload Proposal' ?>
                        </a>
                    <?php endif; ?>
                    <a href="<?= site_url('ormawa/program-kerja/edit/' . $p['id_progja']) ?>"
                       class="en-btn en-btn-light en-btn-sm" title="Edit"><i class="bi bi-pencil"></i></a>
                    <a href="<?= site_url('ormawa/program-kerja/hapus/' . $p['id_progja']) ?>"
                       onclick="return confirm('Yakin ingin hapus program kerja ini?')"
                       class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php else: ?>
<div class="en-card">
    <div class="en-empty">
        <i class="bi bi-clipboard-check"></i>
        <h5>Belum Ada Program Kerja</h5>
        <p>Mulai rencanakan program kerja ormawa untuk semester ini.</p>
        <a href="<?= site_url('ormawa/program-kerja/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Progja Pertama
        </a>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>