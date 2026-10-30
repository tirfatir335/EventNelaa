<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-check-fill me-2" style="color: var(--en-primary);"></i> Report / LPJ</h3>
            <p>Kelola laporan pertanggungjawaban event ormawa kamu</p>
        </div>
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

<?php if (!empty($belum_report)): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-primary); background: var(--en-grad-primary-soft);">
    <div style="display: flex; gap: 14px; margin-bottom: 14px;">
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 28px; color: var(--en-primary-dark);"></i>
        <div>
            <strong style="color: var(--en-primary-dark); font-size: 15px;">
                ⚠️ <?= count($belum_report) ?> event belum di-report
            </strong>
            <div style="font-size: 13px; color: var(--en-text); margin-top: 2px;">
                Segera isi LPJ setelah event selesai
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: column; gap: 8px;">
        <?php foreach ($belum_report as $b): ?>
            <div style="display: flex; justify-content: space-between; align-items: center;
                        background: white; padding: 12px 16px; border-radius: var(--en-r);">
                <div>
                    <strong style="font-size: 13px; color: var(--en-dark);"><?= esc($b['nama_event']) ?></strong>
                    <div style="font-size: 11px; color: var(--en-muted);">
                        <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($b['tanggal'])) ?>
                    </div>
                </div>
                <a href="<?= site_url('ormawa/report/isi/' . $b['id_event']) ?>" class="en-btn en-btn-primary en-btn-sm">
                    <i class="bi bi-pencil-square"></i> Isi Report
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="en-card">
    <div class="en-card__head">
        <h3><i class="bi bi-file-earmark-check-fill me-2" style="color: var(--en-primary);"></i> Riwayat Report (<?= count($reports ?? []) ?>)</h3>
    </div>

    <?php if (!empty($reports)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Event</th>
                        <th style="width: 130px;">Tanggal</th>
                        <th style="text-align: center;">Status Verifikasi</th>
                        <th style="text-align: center; width: 160px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($reports as $r):
                        $s = [$r['status_ketua'], $r['status_pembina'], $r['status_wadir']];
                        if (in_array('rejected', $s)) {
                            $badgeMap = ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'];
                        } elseif ($s[0] === 'approved' && $s[1] === 'approved' && $s[2] === 'approved') {
                            $badgeMap = ['cls' => 'en-badge-success', 'lbl' => 'Disetujui'];
                        } else {
                            $badgeMap = ['cls' => 'en-badge-warning', 'lbl' => 'Menunggu'];
                        }
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color: var(--en-dark);"><?= esc($r['nama_event'] ?? '-') ?></strong>
                            </td>
                            <td>
                                <i class="bi bi-calendar3" style="color: var(--en-primary);"></i>
                                <?= date('d M Y', strtotime($r['tanggal'])) ?>
                            </td>
                            <td style="text-align: center;">
                                <span class="en-badge <?= $badgeMap['cls'] ?>"><?= $badgeMap['lbl'] ?></span>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('ormawa/report/detail/' . $r['id_report']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                
                                <?php if ($badgeMap['lbl'] === 'Disetujui'): ?>
                                    <a href="<?= site_url('ormawa/report/pengesahan/' . $r['id_report']) ?>"
                                       target="_blank" class="en-btn en-btn-primary en-btn-sm" title="Cetak">
                                        <i class="bi bi-printer"></i>
                                    </a>
                                <?php elseif ($badgeMap['lbl'] === 'Ditolak'): ?>
                                    <a href="<?= site_url('ormawa/report/isi/' . $r['id_event']) ?>"
                                       class="en-btn en-btn-sm" style="background:#F59E0B; color:white;" title="Revisi">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                <?php endif; ?>

                                <!-- TOMBOL HAPUS -->
                                <a href="<?= site_url('ormawa/report/hapus/' . $r['id_report']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus report ini secara permanen?')"
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
            <h5>Belum Ada Report</h5>
            <p>Isi report event yang sudah selesai untuk melihat riwayat di sini.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>