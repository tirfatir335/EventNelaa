<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$s = [$report['status_ketua'], $report['status_pembina'], $report['status_wadir']];
$isRejected = in_array('rejected', $s);
$isApproved = $s[0] === 'approved' && $s[1] === 'approved' && $s[2] === 'approved';
?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-check-fill me-2" style="color: var(--en-primary);"></i> Detail Report</h3>
            <p><?= esc($report['nama_event'] ?? '-') ?></p>
        </div>
        <a href="<?= site_url('ormawa/report') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if ($isRejected): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-x-circle-fill" style="font-size: 22px;"></i>
        <span>Report ini <strong>ditolak</strong>. Silakan cek catatan verifikator di bawah, lalu klik tombol <strong>Revisi</strong>.</span>
    </div>
</div>
<?php elseif ($isApproved): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill" style="font-size: 22px;"></i>
        <span>Report <strong>disetujui</strong>! Lembar pengesahan siap dicetak.</span>
    </div>
</div>
<?php else: ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-info); background: var(--en-info-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #1D4ED8;">
        <i class="bi bi-hourglass-split" style="font-size: 22px;"></i>
        <span>Report sedang <strong>menunggu verifikasi</strong>.</span>
    </div>
</div>
<?php endif; ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Konten LPJ</h3>
    </div>

    <div style="display: grid; gap: 16px;">
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">📄 File Laporan</div>
            <?php if (!empty($report['laporan_file']) && file_exists('uploads/report/' . $report['laporan_file'])): ?>
                <a href="<?= base_url('uploads/report/' . $report['laporan_file']) ?>" target="_blank"
                   class="en-btn en-btn-primary en-btn-sm">
                    <i class="bi bi-download"></i> Download Laporan
                </a>
            <?php else: ?>
                <span style="color: var(--en-muted);">File tidak ditemukan</span>
            <?php endif; ?>
        </div>

        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">💰 Link Keuangan</div>
            <?php if (!empty($report['keuangan_link'])): ?>
                <a href="<?= esc($report['keuangan_link']) ?>" target="_blank" class="en-btn en-btn-primary en-btn-sm">
                    <i class="bi bi-box-arrow-up-right"></i> Buka Link
                </a>
            <?php else: ?>
                <span style="color: var(--en-muted);">-</span>
            <?php endif; ?>
        </div>

        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">📸 Link Bukti / Dokumentasi</div>
            <?php if (!empty($report['bukti_link'])): ?>
                <a href="<?= esc($report['bukti_link']) ?>" target="_blank" class="en-btn en-btn-primary en-btn-sm">
                    <i class="bi bi-box-arrow-up-right"></i> Buka Link
                </a>
            <?php else: ?>
                <span style="color: var(--en-muted);">-</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Status Verifikasi</h3>
    </div>

    <?php
        $verifikator = [
            ['label' => 'Ketua UKM',        'status' => $report['status_ketua'],   'catatan' => $report['catatan_ketua'],   'at' => $report['verified_ketua_at']],
            ['label' => 'Pembina UKM',      'status' => $report['status_pembina'], 'catatan' => $report['catatan_pembina'], 'at' => $report['verified_pembina_at']],
            ['label' => 'Wadir (Validator)', 'status' => $report['status_wadir'],  'catatan' => $report['catatan_wadir'],   'at' => $report['verified_wadir_at']],
        ];
    ?>

    <?php foreach ($verifikator as $v):
        $badgeMap = [
            'pending'  => ['cls' => 'en-badge-warning', 'lbl' => 'Menunggu'],
            'approved' => ['cls' => 'en-badge-success', 'lbl' => 'Disetujui'],
            'rejected' => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
        ];
        $b = $badgeMap[$v['status']] ?? $badgeMap['pending'];
    ?>
        <div style="display: flex; justify-content: space-between; align-items: flex-start;
                    padding: 14px 0; border-bottom: 1px solid var(--en-border); gap: 12px;">
            <div style="flex: 1;">
                <div style="font-weight: 700; color: var(--en-dark); font-size: 14px;"><?= $v['label'] ?></div>
                <?php if (!empty($v['catatan'])): ?>
                    <div style="font-size: 12px; color: var(--en-text); margin-top: 4px;">
                        <i class="bi bi-chat-left-text"></i> <?= esc($v['catatan']) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($v['at'])): ?>
                    <div style="font-size: 11px; color: var(--en-muted); margin-top: 2px;">
                        <?= date('d M Y, H:i', strtotime($v['at'])) ?>
                    </div>
                <?php endif; ?>
            </div>
            <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<!-- TOMBOL AKSI DI BAWAH -->
<div class="en-card" style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;">
    <?php if ($isApproved): ?>
        <a href="<?= site_url('ormawa/report/pengesahan/' . $report['id_report']) ?>" target="_blank"
           class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-printer-fill"></i> Cetak Lembar Pengesahan
        </a>
    <?php elseif ($isRejected): ?>
        <!-- TOMBOL REVISI BARU -->
        <a href="<?= site_url('ormawa/report/isi/' . $report['id_event']) ?>"
           class="en-btn en-btn-lg" style="background:#F59E0B; color:white;">
            <i class="bi bi-pencil-square"></i> Revisi & Kirim Ulang
        </a>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>