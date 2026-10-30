<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$sk = $proposal['status_ketua']   ?? 'pending';
$sp = $proposal['status_pembina'] ?? 'pending';
$sw = $proposal['status_wadir']   ?? 'pending';

if ($sk === 'rejected' || $sp === 'rejected' || $sw === 'rejected') {
    $global = 'rejected';
} elseif ($sk === 'approved' && $sp === 'approved' && $sw === 'approved') {
    $global = 'approved';
} else {
    $global = 'pending';
}

$bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Detail Proposal</h3>
            <p><?= esc($proposal['nama_progja']) ?></p>
        </div>
        <a href="<?= site_url('ormawa/proposal') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<div class="en-card mb-4" style="background: var(--en-grad-primary-soft); border-left: 5px solid var(--en-primary);">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 14px;">
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Semester</div>
            <div style="font-weight: 800; color: var(--en-dark); margin-top: 4px;"><?= esc($proposal['semester'] ?? '-') ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Bulan</div>
            <div style="font-weight: 800; color: var(--en-dark); margin-top: 4px;"><?= $bulanList[($proposal['bulan'] ?? 1) - 1] ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Anggaran</div>
            <div style="font-weight: 800; color: var(--en-primary-dark); margin-top: 4px;">
                Rp <?= number_format($proposal['anggaran'] ?? 0, 0, ',', '.') ?>
            </div>
        </div>
    </div>
</div>

<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Konten Proposal</h3>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                📄 File Proposal
            </div>
            <?php if (!empty($proposal['file_proposal']) && file_exists('uploads/proposal/' . $proposal['file_proposal'])): ?>
                <a href="<?= base_url('uploads/proposal/' . $proposal['file_proposal']) ?>" target="_blank"
                   class="en-btn en-btn-primary en-btn-sm">
                    <i class="bi bi-download"></i> Download Proposal
                </a>
            <?php else: ?>
                <span style="color: var(--en-muted);">File tidak ditemukan</span>
            <?php endif; ?>
        </div>

        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">📋 Deskripsi Kegiatan</div>
            <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.7;"><?= nl2br(esc($proposal['deskripsi_kegiatan'] ?? '-')) ?></div>
        </div>

        <?php $rundown = json_decode($proposal['rundown'] ?? '[]', true); ?>
        <?php if (!empty($rundown)): ?>
            <div>
                <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">📝 Rundown</div>
                <ul style="background: var(--en-bg-alt); border-radius: var(--en-r); padding: 12px 30px;
                           margin: 0; font-size: 13px; color: var(--en-text);">
                    <?php foreach ($rundown as $r): ?>
                        <li style="padding: 4px 0;"><?= esc($r) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($proposal['catatan'])): ?>
            <div>
                <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">📌 Catatan Ormawa</div>
                <div style="font-size: 13px; color: var(--en-text); background: var(--en-bg-alt); padding: 12px 16px; border-radius: var(--en-r);">
                    <?= nl2br(esc($proposal['catatan'])) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Status Verifikasi</h3>
    </div>

    <?php
        $verifikator = [
            ['label' => 'Ketua Umum', 'status' => $sk, 'catatan' => $proposal['catatan_ketua'],   'at' => $proposal['verified_ketua_at']],
            ['label' => 'Pembina',    'status' => $sp, 'catatan' => $proposal['catatan_pembina'], 'at' => $proposal['verified_pembina_at']],
            ['label' => 'Wadir III',  'status' => $sw, 'catatan' => $proposal['catatan_wadir'],   'at' => $proposal['verified_wadir_at']],
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
        <div style="display: flex; justify-content: space-between; align-items: flex-start; padding: 14px 0; border-bottom: 1px solid var(--en-border); gap: 12px;">
            <div style="flex: 1; min-width: 0;">
                <div style="font-weight: 700; color: var(--en-dark); font-size: 14px;"><?= $v['label'] ?></div>
                <?php if (!empty($v['catatan'])): ?>
                    <div style="font-size: 12px; color: var(--en-text); margin-top: 4px;">
                        <i class="bi bi-chat-left-text"></i> <?= esc($v['catatan']) ?>
                    </div>
                <?php endif; ?>
                <?php if (!empty($v['at'])): ?>
                    <div style="font-size: 11px; color: var(--en-muted); margin-top: 4px;">
                        <?= date('d M Y, H:i', strtotime($v['at'])) ?>
                    </div>
                <?php endif; ?>
            </div>
            <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
        </div>
    <?php endforeach; ?>
</div>

<div class="en-card" style="display: flex; gap: 12px; flex-wrap: wrap;">
    <a href="<?= site_url('ormawa/proposal') ?>" class="en-btn en-btn-light">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <?php if ($global === 'approved'): ?>
    <a href="<?= site_url('ormawa/proposal/pengesahan/' . $proposal['id_proposal']) ?>" class="en-btn en-btn-primary">
        <i class="bi bi-printer-fill"></i> Cetak Lembar Pengesahan
    </a>
<?php elseif ($global === 'rejected'): ?>
    <a href="<?= site_url('ormawa/proposal/isi/' . $proposal['id_progja']) ?>" class="en-btn" style="background:#F59E0B; color:white;">
        <i class="bi bi-pencil-square"></i> Revisi & Kirim Ulang
    </a>
<?php endif; ?>
</div>

<?= $this->endSection() ?>