<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Program Kerja</h3>
            <p>Perbarui data program kerja ormawa</p>
        </div>
        <a href="<?= site_url('ormawa/program-kerja') ?>" class="en-btn en-btn-light">
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

<form action="<?= site_url('ormawa/program-kerja/update/' . $progja['id_progja']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Program Kerja <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="nama_progja" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($progja['nama_progja']) ?>">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Semester <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="semester" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($progja['semester'] ?? '') ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Bulan <span style="color: var(--en-danger);">*</span>
                    </label>
                    <select name="bulan" required class="form-select"
                            style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                        <?php foreach (['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i => $nm): ?>
                            <option value="<?= $i + 1 ?>" <?= (int)($progja['bulan'] ?? 0) === ($i + 1) ? 'selected' : '' ?>>
                                <?= $nm ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Target Peserta
                </label>
                <input type="number" name="target_peserta" min="0" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($progja['target_peserta'] ?? '') ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi
                </label>
                <textarea name="deskripsi" rows="4" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"><?= esc($progja['deskripsi'] ?? '') ?></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Foto <span style="color: var(--en-muted); font-weight: 400;">(kosongkan jika tidak diganti)</span>
                </label>
                <?php if (!empty($progja['foto']) && file_exists('uploads/progja/' . $progja['foto'])): ?>
                    <img src="<?= base_url('uploads/progja/' . $progja['foto']) ?>"
                         style="max-height: 120px; border-radius: var(--en-r); border: 2px solid var(--en-border-strong); margin-bottom: 10px;">
                <?php endif; ?>
                <input type="file" name="foto" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Progja
        </button>
        <a href="<?= site_url('ormawa/program-kerja') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>