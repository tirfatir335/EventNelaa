<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Isi Report</h3>
            <p><?= esc($event['nama_event']) ?></p>
        </div>
        <a href="<?= site_url('ormawa/report') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="en-card mb-4" style="background: var(--en-grad-primary-soft); border-left: 5px solid var(--en-primary);">
    <div style="display: flex; flex-wrap: wrap; gap: 20px; font-size: 13px;">
        <div>
            <div style="color: var(--en-muted); font-size: 11px; text-transform: uppercase; font-weight: 700;">Tanggal</div>
            <div style="font-weight: 700; color: var(--en-dark);"><?= date('d M Y', strtotime($event['tanggal'])) ?></div>
        </div>
        <div>
            <div style="color: var(--en-muted); font-size: 11px; text-transform: uppercase; font-weight: 700;">Waktu</div>
            <div style="font-weight: 700; color: var(--en-dark);"><?= esc($event['waktu']) ?> WIB</div>
        </div>
        <div>
            <div style="color: var(--en-muted); font-size: 11px; text-transform: uppercase; font-weight: 700;">Gedung</div>
            <div style="font-weight: 700; color: var(--en-dark);"><?= esc($event['gedung']) ?></div>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<form action="<?= site_url('ormawa/report/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id_event" value="<?= $event['id_event'] ?>">

        <?php if ($is_revision): ?>
        <div class="en-card mb-4" style="border-left: 5px solid var(--en-warning); background: var(--en-warning-soft);">
            <div style="display: flex; gap: 10px; color: #B45309;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px; margin-top: 2px;"></i>
                <div style="flex: 1;">
                    <strong>Mode Revisi</strong><br>
                    Report sebelumnya ditolak. Silakan perbaiki data/file di bawah ini, lalu kirim ulang.
                    
                    <!-- TAMBAHAN CATATAN PENOLAKAN -->
                    <div style="margin-top: 12px; background: white; padding: 12px 16px; border-radius: 8px; border: 1px solid #FDE68A;">
                        <div style="font-size: 12px; font-weight: 800; color: #B91C1C; margin-bottom: 6px;">
                            <i class="bi bi-chat-left-text-fill"></i> Catatan Penolakan:
                        </div>
                        <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: var(--en-dark); line-height: 1.6;">
                            <?php if (($report['status_pembina'] ?? '') === 'rejected' && !empty($report['catatan_pembina'])): ?>
                                <li><strong>Pembina:</strong> <?= esc($report['catatan_pembina']) ?></li>
                            <?php endif; ?>
                            <?php if (($report['status_wadir'] ?? '') === 'rejected' && !empty($report['catatan_wadir'])): ?>
                                <li><strong>Wadir (Validator):</strong> <?= esc($report['catatan_wadir']) ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- 1. LAPORAN -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> 1. Laporan Kegiatan</h3>
        </div>
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                Upload File Laporan (PDF/DOC) <?= !$is_revision ? '<span style="color: var(--en-danger);">*</span>' : '' ?>
            </label>
            <?php if ($is_revision && !empty($report['laporan_file'])): ?>
                <div style="margin-bottom: 8px; font-size: 12px; color: var(--en-muted);">
                    File saat ini: <a href="<?= base_url('uploads/report/' . $report['laporan_file']) ?>" target="_blank">Lihat File Lama</a>
                </div>
            <?php endif; ?>
            <input type="file" name="laporan_file" accept=".pdf,.doc,.docx" <?= !$is_revision ? 'required' : '' ?> class="form-control"
                   style="height: 46px; border-radius: var(--en-r); border: 2px dashed var(--en-primary-light); background: var(--en-grad-primary-soft);">
            <small style="color: var(--en-muted); font-size: 11px;">Format: PDF, DOC, DOCX — Maks 5MB. (Biarkan kosong jika tidak diganti).</small>
        </div>
    </div>

    <!-- 2. KEUANGAN -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-cash-coin me-2" style="color: var(--en-primary);"></i> 2. Laporan Keuangan (SPJ)</h3>
        </div>
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                Link Google Drive (Nota, Kwitansi, SPJ) <span style="color: var(--en-danger);">*</span>
            </label>
            <input type="url" name="keuangan_link" required class="form-control"
                   style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                   value="<?= old('keuangan_link', $is_revision ? $report['keuangan_link'] : '') ?>" placeholder="https://drive.google.com/...">
        </div>
    </div>

    <!-- 3. BUKTI -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-images me-2" style="color: var(--en-primary);"></i> 3. Bukti / Dokumentasi</h3>
        </div>
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                Link Google Drive (Foto Dokumentasi) <span style="color: var(--en-danger);">*</span>
            </label>
            <input type="url" name="bukti_link" required class="form-control"
                   style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                   value="<?= old('bukti_link', $is_revision ? $report['bukti_link'] : '') ?>" placeholder="https://drive.google.com/...">
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-send-fill"></i> <?= $is_revision ? 'Kirim Ulang Report' : 'Kirim Report' ?>
        </button>
        <a href="<?= site_url('ormawa/report') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>