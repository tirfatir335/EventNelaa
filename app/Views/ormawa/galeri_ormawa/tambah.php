<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-cloud-upload-fill me-2" style="color: var(--en-primary);"></i> Upload Foto Baru</h3>
            <p>Tambahkan dokumentasi kegiatan ke galeri ormawa</p>
        </div>
        <a href="<?= site_url('ormawa/galeri-ormawa') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/galeri-ormawa/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Judul Foto <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="text" name="judul" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: Kegiatan Bakti Sosial 2025">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <textarea name="deskripsi" rows="3" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Deskripsi singkat tentang foto ini"></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Pilih Foto <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="file" name="foto[]" accept="image/*" multiple required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 2px dashed var(--en-primary-light); background: var(--en-grad-primary-soft);">
                <small style="color: var(--en-muted); font-size: 11px;">
                    <i class="bi bi-info-circle"></i> Bisa pilih banyak foto sekaligus (tahan Ctrl saat memilih). Format: JPG, PNG (maks. 2MB per foto)
                </small>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-cloud-upload-fill"></i> Upload Sekarang
        </button>
        <a href="<?= site_url('ormawa/galeri-ormawa') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>