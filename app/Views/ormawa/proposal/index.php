<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Proposal Kegiatan</h3>
            <p>Upload dan kelola proposal kegiatan ormawa kamu</p>
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

<?php if (!empty($belum_proposal)): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-info); background: var(--en-info-soft);">
    <div style="display: flex; gap: 12px; margin-bottom: 14px;">
        <i class="bi bi-lightbulb-fill" style="font-size: 26px; color: #1D4ED8;"></i>
        <div>
            <strong style="color: #1D4ED8; font-size: 14px;"><?= count($belum_proposal) ?> program kerja siap dibuat proposal</strong>
            <div style="font-size: 12.5px; color: var(--en-text); margin-top: 2px;">
                Program kerja di bawah sudah disetujui Wadir. Segera upload proposalnya.
            </div>
        </div>
    </div>

    <div class="row g-3">
        <?php
        $bulanList = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        foreach ($belum_proposal as $p): ?>
            <div class="col-md-6">
                <div style="background: white; border-radius: var(--en-r); padding: 16px;
                            border: 2px dashed var(--en-primary-light); display: flex;
                            align-items: center; gap: 14px;">
                    <div style="width: 48px; height: 48px; border-radius: 12px;
                                background: var(--en-grad-primary); color: white;
                                display: flex; align-items: center; justify-content: center;
                                font-size: 12px; font-weight: 800; text-transform: uppercase; flex-shrink: 0;">
                        <?= $bulanList[($p['bulan'] ?? 1) - 1] ?>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-weight: 800; color: var(--en-dark); font-size: 14px; margin-bottom: 2px;">
                            <?= esc($p['nama_progja']) ?>
                        </div>
                        <div style="font-size: 11.5px; color: var(--en-muted);"><?= esc($p['semester'] ?? '-') ?></div>
                    </div>
                    <a href="<?= site_url('ormawa/proposal/isi/' . $p['id_progja']) ?>"
                       class="en-btn en-btn-primary en-btn-sm">
                        <i class="bi bi-cloud-upload-fill"></i> Buat
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="en-card">
    <div class="en-card__head">
        <h3>Proposal yang Sudah Dibuat</h3>
    </div>

    <?php if (!empty($proposals)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Program</th>
                        <th style="text-align: center;">Pembina</th>
                        <th style="text-align: center;">Wadir</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($proposals as $p):
                        $sk = $p['status_pembina'] ?? 'pending';
                        $sw = $p['status_wadir']   ?? 'pending';

                        if ($sk === 'rejected' || $sw === 'rejected') {
                            $global = 'rejected';
                        } elseif ($sk === 'approved' && $sw === 'approved') {
                            $global = 'approved';
                        } else {
                            $global = 'pending';
                        }

                        $badgeMap = [
                            'pending'  => ['cls' => 'en-badge-warning', 'lbl' => '⏳ Menunggu'],
                            'approved' => ['cls' => 'en-badge-success', 'lbl' => '✅ Disetujui'],
                            'rejected' => ['cls' => 'en-badge-danger',  'lbl' => '❌ Ditolak'],
                        ];
                        $gb = $badgeMap[$global];

                        $miniBadge = function($st) use ($badgeMap) {
                            $b = $badgeMap[$st] ?? $badgeMap['pending'];
                            return '<span class="en-badge '.$b['cls'].'">'.$b['lbl'].'</span>';
                        };
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color: var(--en-dark);"><?= esc($p['nama_progja'] ?? '-') ?></strong>
                                <div style="font-size: 11px; color: var(--en-muted); margin-top: 2px;">
                                    Semester <?= esc($p['semester'] ?? '-') ?>
                                </div>
                            </td>
                            <td style="text-align: center;"><?= $miniBadge($sk) ?></td>
                            <td style="text-align: center;"><?= $miniBadge($sw) ?></td>
                            <td style="text-align: center;"><span class="en-badge <?= $gb['cls'] ?>"><?= $gb['lbl'] ?></span></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('ormawa/proposal/detail/' . $p['id_proposal']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <?php if ($global === 'approved'): ?>
                                    <a href="<?= site_url('ormawa/proposal/pengesahan/' . $p['id_proposal']) ?>"
                                       class="en-btn en-btn-primary en-btn-sm" title="Cetak">
                                        <i class="bi bi-printer-fill"></i>
                                    </a>
                                <?php elseif ($global === 'rejected'): ?>
                                    <a href="<?= site_url('ormawa/proposal/isi/' . $p['id_progja']) ?>"
                                       class="en-btn en-btn-sm" style="background:#F59E0B; color:white;" title="Revisi">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- TOMBOL HAPUS -->
                                <a href="<?= site_url('ormawa/proposal/hapus/' . $p['id_proposal']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus proposal ini secara permanen?')"
                                   class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-file-earmark-x"></i>
            <h5>Belum Ada Proposal</h5>
            <p><?= !empty($belum_proposal) ? 'Pilih program kerja di atas untuk mulai membuat proposal.' : 'Belum ada program kerja yang disetujui Wadir.' ?></p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>