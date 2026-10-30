<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-download me-2" style="color: var(--en-primary);"></i> Backup Data</h3>
            <p>Download rekap data & file uploads EventNela</p>
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

<div class="row g-4">
    <!-- REKAP DATA -->
    <div class="col-md-6">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3><i class="bi bi-file-earmark-spreadsheet-fill me-2" style="color: var(--en-primary);"></i> Rekap Data (CSV)</h3>
            </div>

            <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                <div style="width: 60px; height: 60px; border-radius: 16px;
                            background: linear-gradient(135deg, #3B82F6, #1D4ED8); color: white;
                            display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                    <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                </div>
                <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.6;">
                    Download rekap data dalam 1 file ZIP berisi 4 CSV:
                </div>
            </div>

            <ul style="font-size: 13px; color: var(--en-text); padding-left: 24px; margin-bottom: 20px; line-height: 1.9;">
                <li>Daftar Event</li>
                <li>Daftar LPJ / Report</li>
                <li>Daftar Ormawa</li>
                <li>Daftar Pengurus</li>
            </ul>

            <div style="background: var(--en-info-soft); border-left: 4px solid var(--en-info);
                        border-radius: var(--en-r); padding: 12px 16px; font-size: 12.5px; color: var(--en-text);
                        margin-bottom: 20px;">
                <i class="bi bi-info-circle-fill" style="color: #1D4ED8;"></i>
                File CSV bisa dibuka di Excel / Google Sheets
            </div>

            <a href="<?= site_url('validator/backup/rekap') ?>" class="en-btn en-btn-primary en-btn-lg" style="width: 100%; justify-content: center;">
                <i class="bi bi-download"></i> Download Rekap
            </a>
        </div>
    </div>

    <!-- BACKUP UPLOADS -->
    <div class="col-md-6">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3><i class="bi bi-file-zip-fill me-2" style="color: var(--en-primary);"></i> Backup File Uploads</h3>
            </div>

            <div style="display: flex; gap: 14px; margin-bottom: 16px;">
                <div style="width: 60px; height: 60px; border-radius: 16px;
                            background: var(--en-grad-primary); color: white;
                            display: flex; align-items: center; justify-content: center; font-size: 28px; flex-shrink: 0;">
                    <i class="bi bi-file-zip-fill"></i>
                </div>
                <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.6;">
                    Download semua file uploads dalam 1 ZIP:
                </div>
            </div>

            <ul style="font-size: 13px; color: var(--en-text); padding-left: 24px; margin-bottom: 20px; line-height: 1.9;">
                <li>Poster event</li>
                <li>File laporan LPJ</li>
                <li>Foto galeri ormawa</li>
                <li>Logo & foto profil</li>
            </ul>

            <div style="background: var(--en-warning-soft); border-left: 4px solid var(--en-warning);
                        border-radius: var(--en-r); padding: 12px 16px; font-size: 12.5px; color: var(--en-text);
                        margin-bottom: 20px;">
                <i class="bi bi-exclamation-triangle" style="color: #B45309;"></i>
                Ukuran file bisa besar, tunggu sampai selesai
            </div>

            <a href="<?= site_url('validator/backup/uploads') ?>"
               onclick="return confirm('Backup semua file uploads? Proses mungkin memakan waktu beberapa saat.')"
               class="en-btn en-btn-primary en-btn-lg" style="width: 100%; justify-content: center;">
                <i class="bi bi-download"></i> Download ZIP
            </a>
        </div>
    </div>
</div>

<div class="en-card mt-4" style="background: var(--en-info-soft); border-left: 5px solid var(--en-info);">
    <div style="display: flex; gap: 12px;">
        <i class="bi bi-info-circle-fill" style="color: #1D4ED8; font-size: 22px; flex-shrink: 0; margin-top: 2px;"></i>
        <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.7;">
            <strong>Catatan:</strong> Backup ini berguna untuk:
            <ul style="padding-left: 20px; margin-top: 6px; margin-bottom: 0;">
                <li>Restore data kalau ada masalah</li>
                <li>Rekap laporan ke pihak kampus</li>
                <li>Arsip digital kegiatan</li>
            </ul>
        </div>
    </div>
</div>

<?= $this->endSection() ?>