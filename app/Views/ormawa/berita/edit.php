<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Berita</h3>
            <p>Perbarui konten berita atau pengumuman</p>
        </div>
        <a href="<?= site_url('ormawa/berita') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/berita/update/' . $berita['id_berita']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Judul Berita <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="judul" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($berita['judul']) ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Konten Berita <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="konten" rows="10" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"><?= esc($berita['konten']) ?></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Foto Cover
                </label>
                <?php if (!empty($berita['foto']) && file_exists('uploads/berita/' . $berita['foto'])): ?>
                    <div style="margin-bottom: 12px;">
                        <p style="font-size: 12px; color: var(--en-muted); margin-bottom: 6px;">Foto saat ini:</p>
                        <img src="<?= base_url('uploads/berita/' . $berita['foto']) ?>"
                             style="max-height: 120px; border-radius: var(--en-r); border: 2px solid var(--en-border-strong);">
                    </div>
                <?php endif; ?>
                <input type="file" name="foto" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                <small style="color: var(--en-muted); font-size: 11px;">Kosongkan jika tidak ingin mengganti foto cover</small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Status Publikasi <span style="color: var(--en-danger);">*</span>
                </label>
                <select name="status" required class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="draft" <?= $berita['status'] == 'draft' ? 'selected' : '' ?>>📝 Draft</option>
                    <option value="published" <?= $berita['status'] == 'published' ? 'selected' : '' ?>>✅ Published</option>
                </select>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Berita
        </button>
        <a href="<?= site_url('ormawa/berita') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>