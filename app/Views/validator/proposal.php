<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Verifikasi Proposal</h3>
            <p>Daftar proposal kegiatan yang perlu diverifikasi</p>
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
$total = count($proposals ?? []);
$cntPending  = count(array_filter($proposals ?? [], fn($p) => ($p['status_wadir'] ?? '') === 'pending'));
$cntApproved = count(array_filter($proposals ?? [], fn($p) => ($p['status_wadir'] ?? '') === 'approved'));
$cntRejected = count(array_filter($proposals ?? [], fn($p) => ($p['status_wadir'] ?? '') === 'rejected'));
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-file-earmark-text-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total ?></div>
        <div class="en-stat__lbl">Total Proposal</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntPending ?></div>
        <div class="en-stat__lbl">Menunggu Verifikasi</div>
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

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Proposal</h3>
    </div>

    <?php if (!empty($proposals)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Program</th>
                        <th>Ormawa</th>
                        <th style="width: 100px;">Bulan</th>
                        <th style="text-align: center;">Status Wadir</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($proposals as $p):
                        $status = $p['status_wadir'] ?? 'pending';
                        $badgeMap = [
                            'pending'  => ['cls' => 'en-badge-warning', 'lbl' => 'Menunggu'],
                            'approved' => ['cls' => 'en-badge-success', 'lbl' => 'Disetujui'],
                            'rejected' => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
                        ];
                        $b = $badgeMap[$status] ?? $badgeMap['pending'];
                        $bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="color: var(--en-dark);"><?= esc($p['nama_progja']) ?></strong></td>
                            <td style="font-size: 13px;"><?= esc($p['nama_ormawa']) ?></td>
                            <td style="font-size: 13px;"><?= $bulanList[($p['bulan'] ?? 1) - 1] ?></td>
                            <td style="text-align: center;">
                                <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= site_url('validator/proposal/detail/' . $p['id_proposal']) ?>"
                                   class="en-btn en-btn-primary en-btn-sm" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-inbox"></i>
            <h5>Belum Ada Proposal</h5>
            <p>Belum ada proposal dari ormawa yang perlu diverifikasi.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>