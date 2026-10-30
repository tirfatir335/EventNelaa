<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-plus-circle-fill me-2" style="color: var(--en-primary);"></i> Tambah Gedung</h3>
            <p>Tambahkan data gedung/fasilitas baru</p>
        </div>
        <a href="<?= site_url('admin/gedung') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('admin/gedung/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div>
            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                Nama Gedung <span style="color: var(--en-danger);">*</span>
            </label>
            <input type="text" name="nama_gedung" required class="form-control"
                   style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                   placeholder="Contoh: Gedung Serba Guna (GSG)">
            <small style="color: var(--en-muted); font-size: 11px; display: block; margin-top: 6px;">
                <i class="bi bi-info-circle"></i> Sertakan singkatan jika ada, misal (GSG)
            </small>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Gedung
        </button>
        <a href="<?= site_url('admin/gedung') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>