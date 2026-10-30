<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-file-earmark-text-fill me-2" style="color: var(--en-primary);"></i> Detail Proposal</h3>
            <p><?= esc($proposal['nama_progja']) ?></p>
        </div>
        <a href="<?= site_url('pembina/proposal') ?>" class="en-btn en-btn-light">
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
            <div style="font-weight: 800; color: var(--en-dark); margin-top: 4px;"><?= esc($proposal['nama_ormawa']) ?></div>
        </div>
        <div>
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase;">Semester</div>
            <div style="font-weight: 700; color: var(--en-dark); margin-top: 4px;"><?= esc($proposal['semester'] ?? '-') ?></div>
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
            <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                📋 Deskripsi Kegiatan
            </div>
            <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.7;">
                <?= nl2br(esc($proposal['deskripsi_kegiatan'] ?? '-')) ?>
            </div>
        </div>

        <?php $rundown = json_decode($proposal['rundown'] ?? '[]', true); ?>
        <?php if (!empty($rundown)): ?>
            <div>
                <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                    📝 Rundown
                </div>
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
                <div style="font-size: 11px; color: var(--en-muted); font-weight: 700; text-transform: uppercase; margin-bottom: 6px;">
                    📌 Catatan Ormawa
                </div>
                <div style="font-size: 13px; color: var(--en-text); background: var(--en-bg-alt);
                            padding: 12px 16px; border-radius: var(--en-r);">
                    <?= nl2br(esc($proposal['catatan'])) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (($proposal['status_pembina'] ?? 'pending') === 'pending'): ?>
    <div class="en-card">
        <div class="en-card__head">
            <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Verifikasi Proposal</h3>
        </div>

        <form action="<?= site_url('pembina/proposal/verifikasi/' . $proposal['id_proposal']) ?>" method="post">
            <?= csrf_field() ?>

            <div style="margin-bottom: 16px;">
                <label style="display: flex; align-items: center; gap: 10px; background: var(--en-success-soft);
                              padding: 14px; border-radius: var(--en-r); margin-bottom: 8px; cursor: pointer;
                              border: 2px solid transparent;"
                       onmouseover="this.style.borderColor='#22C55E';" onmouseout="this.style.borderColor='transparent';">
                    <input type="radio" name="aksi" value="approve" checked style="accent-color: var(--en-success);">
                    <span style="font-weight: 700; color: #15803D;">
                        <i class="bi bi-check-circle-fill"></i> Setujui Proposal
                    </span>
                </label>
                <label style="display: flex; align-items: center; gap: 10px; background: var(--en-danger-soft);
                              padding: 14px; border-radius: var(--en-r); cursor: pointer;
                              border: 2px solid transparent;"
                       onmouseover="this.style.borderColor='#EF4444';" onmouseout="this.style.borderColor='transparent';">
                    <input type="radio" name="aksi" value="reject" style="accent-color: var(--en-danger);">
                    <span style="font-weight: 700; color: #B91C1C;">
                        <i class="bi bi-x-circle-fill"></i> Tolak Proposal
                    </span>
                </label>
            </div>

            <div style="margin-bottom: 16px;">
                <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                    Catatan <span style="color: var(--en-muted); font-weight: 400;">(wajib jika tolak)</span>
                </label>
                <textarea name="catatan" rows="3" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Contoh: Rundown kurang jelas"></textarea>
            </div>

            <button type="submit" class="en-btn en-btn-primary en-btn-lg" style="width: 100%; justify-content: center;">
                <i class="bi bi-save-fill"></i> Proses Verifikasi
            </button>
        </form>
    </div>
<?php else: ?>
    <div class="en-card" style="text-align: center; padding: 30px;">
        <i class="bi bi-check-circle-fill" style="font-size: 40px; color: var(--en-success);"></i>
        <div style="font-weight: 800; color: #15803D; margin-top: 10px;">Proposal Sudah Diverifikasi</div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>