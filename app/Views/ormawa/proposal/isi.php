<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-cloud-upload-fill me-2" style="color: var(--en-primary);"></i> Upload Proposal</h3>
            <p><?= esc($progja['nama_progja']) ?></p>
        </div>
        <a href="<?= site_url('ormawa/proposal') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
$bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
?>

<div class="en-card mb-4" style="background: var(--en-grad-primary-soft); border-left: 5px solid var(--en-primary);">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 14px; font-size: 13px;">
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Nama Program</div>
            <div style="font-weight: 800; color: var(--en-dark); margin-top: 4px;"><?= esc($progja['nama_progja']) ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Semester</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= esc($progja['semester'] ?? '-') ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Bulan Rencana</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= $bulanList[($progja['bulan'] ?? 1) - 1] ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Target Peserta</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= esc($progja['target_peserta'] ?? '-') ?> orang</div>
        </div>
    </div>
</div>

<form action="<?= site_url('ormawa/proposal/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <input type="hidden" name="id_progja" value="<?= (int) $progja['id_progja'] ?>">

        <?php if ($is_revision): ?>
        <div class="en-card mb-4" style="border-left: 5px solid var(--en-warning); background: var(--en-warning-soft);">
            <div style="display: flex; gap: 10px; color: #B45309;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px; margin-top: 2px;"></i>
                <div style="flex: 1;">
                    <strong>Mode Revisi</strong><br>
                    Proposal sebelumnya ditolak. Silakan perbaiki data/file di bawah ini, lalu kirim ulang.
                    
                    <!-- TAMBAHAN CATATAN PENOLAKAN -->
                    <div style="margin-top: 12px; background: white; padding: 12px 16px; border-radius: 8px; border: 1px solid #FDE68A;">
                        <div style="font-size: 12px; font-weight: 800; color: #B91C1C; margin-bottom: 6px;">
                            <i class="bi bi-chat-left-text-fill"></i> Catatan Penolakan:
                        </div>
                        <ul style="margin: 0; padding-left: 20px; font-size: 13px; color: var(--en-dark); line-height: 1.6;">
                            <?php if (($proposal['status_pembina'] ?? '') === 'rejected' && !empty($proposal['catatan_pembina'])): ?>
                                <li><strong>Pembina:</strong> <?= esc($proposal['catatan_pembina']) ?></li>
                            <?php endif; ?>
                            <?php if (($proposal['status_wadir'] ?? '') === 'rejected' && !empty($proposal['catatan_wadir'])): ?>
                                <li><strong>Wadir (Validator):</strong> <?= esc($proposal['catatan_wadir']) ?></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Detail Proposal</h3>
        </div>

        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    📄 File Proposal <?= !$is_revision ? '<span style="color: var(--en-danger);">*</span>' : '' ?>
                </label>
                <?php if ($is_revision && !empty($proposal['file_proposal'])): ?>
                    <div style="margin-bottom: 8px; font-size: 12px; color: var(--en-muted);">
                        File saat ini: <a href="<?= base_url('uploads/proposal/' . $proposal['file_proposal']) ?>" target="_blank">Lihat File Lama</a>
                    </div>
                <?php endif; ?>
                <input type="file" name="file_proposal" accept=".pdf,.doc,.docx" <?= !$is_revision ? 'required' : '' ?> class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 2px dashed var(--en-primary-light); background: var(--en-grad-primary-soft);">
                <small style="color: var(--en-muted); font-size: 11px;">Format PDF/DOC/DOCX, maksimal 5 MB. (Biarkan kosong jika tidak diganti).</small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    📋 Deskripsi Kegiatan <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="deskripsi_kegiatan" rows="5" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Jelaskan latar belakang, tujuan, dan gambaran umum kegiatan..."><?= old('deskripsi_kegiatan', $is_revision ? $proposal['deskripsi_kegiatan'] : '') ?></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    📝 Rundown Kegiatan
                </label>
                <?php 
                    $rundownText = '';
                    if ($is_revision && !empty($proposal['rundown'])) {
                        $arr = json_decode($proposal['rundown'], true);
                        $rundownText = is_array($arr) ? implode("\n", $arr) : $proposal['rundown'];
                    }
                ?>
                <textarea name="rundown" rows="6" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="08.00 - Registrasi peserta&#10;08.30 - Pembukaan"><?= old('rundown', $rundownText) ?></textarea>
                <small style="color: var(--en-muted); font-size: 11px;">Satu baris = satu item rundown.</small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    💰 Total Anggaran (Rp) <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="number" name="anggaran" min="0" step="1000" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= old('anggaran', $is_revision ? $proposal['anggaran'] : '') ?>" placeholder="0">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    📌 Catatan Tambahan
                </label>
                <textarea name="catatan" rows="3" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Catatan untuk Pembina / Wadir (opsional)..."><?= old('catatan', $is_revision ? $proposal['catatan'] : '') ?></textarea>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-send-fill"></i> <?= $is_revision ? 'Kirim Ulang Proposal' : 'Kirim Proposal' ?>
        </button>
        <a href="<?= site_url('ormawa/proposal') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</form>

<?= $this->endSection() ?>