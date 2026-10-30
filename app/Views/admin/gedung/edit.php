<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Gedung</h3>
            <p>Perbarui data gedung/fasilitas</p>
        </div>
        <a href="<?= site_url('admin/gedung') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('admin/gedung/update/' . $gedung['id_gedung']) ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="en-card mb-4">
        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
            Nama Gedung <span style="color: var(--en-danger);">*</span>
        </label>
        <input type="text" name="nama_gedung" required class="form-control"
               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
               value="<?= esc($gedung['nama_gedung']) ?>">
    </div>
    
    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Gedung
        </button>
        <a href="<?= site_url('admin/gedung') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>