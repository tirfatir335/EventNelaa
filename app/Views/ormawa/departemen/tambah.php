<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-plus-circle-fill me-2" style="color: var(--en-primary);"></i> Tambah Departemen</h3>
            <p>Tambahkan departemen atau divisi baru</p>
        </div>
        <a href="<?= site_url('ormawa/departemen') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/departemen/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Departemen / Divisi <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="nama_departemen" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: Departemen Keuangan, Divisi Kaderisasi">
            </div>


            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi / Tugas Pokok
                </label>
                <textarea name="deskripsi" rows="4" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Jelaskan tugas dan tanggung jawab departemen ini"></textarea>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Departemen
        </button>
        <a href="<?= site_url('ormawa/departemen') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>