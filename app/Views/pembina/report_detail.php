<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-text me-2" style="color: var(--en-primary);"></i> Detail LPJ</h3>
            <p><?= esc($report['nama_event']) ?></p>
        </div>
        <a href="<?= site_url('pembina/report') ?>" class="en-btn en-btn-light">
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
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Ormawa</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= esc($report['nama_ormawa']) ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Tanggal</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= date('d M Y', strtotime($report['tanggal'])) ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Gedung</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= esc($report['gedung']) ?></div>
        </div>
    </div>
</div>

<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Konten LPJ</h3>
    </div>

    <div style="display: flex; flex-direction: column; gap: 16px;">
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                📄 File Laporan
            </div>
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
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                💰 Link Keuangan
            </div>
            <a href="<?= esc($report['keuangan_link']) ?>" target="_blank" class="en-btn en-btn-primary en-btn-sm">
                <i class="bi bi-box-arrow-up-right"></i> Buka Link
            </a>
        </div>

        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                📸 Link Bukti / Dokumentasi
            </div>
            <a href="<?= esc($report['bukti_link']) ?>" target="_blank" class="en-btn en-btn-primary en-btn-sm">
                <i class="bi bi-box-arrow-up-right"></i> Buka Link
            </a>
        </div>
    </div>
</div>

<?php if ($report['status_pembina'] === 'pending'): ?>
    <div class="en-card">
        <div class="en-card__head">
            <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Verifikasi</h3>
        </div>

        <form action="<?= site_url('pembina/report/verifikasi/' . $report['id_report']) ?>" method="post">
            <?= csrf_field() ?>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">Pilih Aksi:</label>
                <label style="display: flex; align-items: center; gap: 10px; background: var(--en-success-soft);
                              padding: 14px; border-radius: var(--en-r); margin-bottom: 8px; cursor: pointer;
                              border: 2px solid transparent;"
                       onmouseover="this.style.borderColor='#22C55E';" onmouseout="this.style.borderColor='transparent';">
                    <input type="radio" name="aksi" value="approve" checked style="accent-color: var(--en-success);">
                    <span style="font-weight: 700; color: #15803D;">
                        <i class="bi bi-check-circle-fill"></i> Setujui LPJ
                    </span>
                </label>
                <label style="display: flex; align-items: center; gap: 10px; background: var(--en-danger-soft);
                              padding: 14px; border-radius: var(--en-r); cursor: pointer;
                              border: 2px solid transparent;"
                       onmouseover="this.style.borderColor='#EF4444';" onmouseout="this.style.borderColor='transparent';">
                    <input type="radio" name="aksi" value="reject" style="accent-color: var(--en-danger);">
                    <span style="font-weight: 700; color: #B91C1C;">
                        <i class="bi bi-x-circle-fill"></i> Tolak LPJ
                    </span>
                </label>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                    Catatan <span style="color: var(--en-muted); font-weight: 400;">(wajib jika tolak)</span>
                </label>
                <textarea name="catatan" rows="3" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Contoh: Laporan keuangan kurang lengkap"></textarea>
            </div>

            <button type="submit" class="en-btn en-btn-primary en-btn-lg" style="width: 100%; justify-content: center;">
                <i class="bi bi-save-fill"></i> Proses Verifikasi
            </button>
        </form>
    </div>
<?php else: ?>
    <div class="en-card">
        <div class="en-card__head">
            <h3><i class="bi bi-check-circle-fill me-2" style="color: var(--en-success);"></i> Status Verifikasi Anda</h3>
        </div>
        <div style="padding: 14px; border-radius: var(--en-r);
                    background: <?= $report['status_pembina'] === 'approved' ? 'var(--en-success-soft)' : 'var(--en-danger-soft)' ?>;">
            <strong style="color: <?= $report['status_pembina'] === 'approved' ? '#15803D' : '#B91C1C' ?>;">
                <?= $report['status_pembina'] === 'approved' ? 'Disetujui' : 'Ditolak' ?>
            </strong>
            <?php if (!empty($report['catatan_pembina'])): ?>
                <p style="margin: 6px 0 0; font-size: 13px; color: var(--en-text);">
                    <i class="bi bi-chat-left-text"></i> <?= esc($report['catatan_pembina']) ?>
                </p>
            <?php endif; ?>
            <div style="font-size: 11px; color: var(--en-muted); margin-top: 6px;">
                <?= !empty($report['verified_pembina_at']) ? date('d M Y, H:i', strtotime($report['verified_pembina_at'])) : '' ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>