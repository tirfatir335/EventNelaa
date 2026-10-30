
<?= $this->extend('layout/en_layout'); ?>
<?= $this->section('content'); ?>

<div style="background:linear-gradient(135deg,#ff7a00,#e65100);color:white;border-radius:20px;padding:30px 32px;margin-bottom:24px;">
    <h2 style="font-size:24px;font-weight:800;margin-bottom:6px;">
        <i class="bi bi-person-plus-fill"></i> Tambah Ormawa
    </h2>
    <p style="font-size:14px;opacity:.9;margin:0;">Buat akun UKM/HMJ baru</p>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<div style="background:white;border-radius:18px;padding:32px;box-shadow:0 4px 20px rgba(0,0,0,.05);">
    <form action="<?= site_url('validator/ormawa/simpan') ?>" method="post">
        <?= csrf_field() ?>

        <h5 style="font-size:15px;font-weight:800;margin-bottom:20px;padding-bottom:12px;border-bottom:2px solid #f0f0f0;">
            <i class="bi bi-building-fill" style="color:#ff7a00;"></i>
            Data Ormawa
        </h5>

        <div class="row">
            <div class="col-md-8 mb-3">
                <label class="form-label fw-bold">Nama Ormawa *</label>
                <input type="text" name="nama_ormawa" class="form-control"
                       value="<?= esc(old('nama_ormawa') ?? '') ?>"
                       placeholder="Contoh: Himpunan Mahasiswa Jurusan TI"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label class="form-label fw-bold">Kategori *</label>
                <select name="kategori" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="HMJ" <?= old('kategori') === 'HMJ' ? 'selected' : '' ?>>HMJ</option>
                    <option value="UKM" <?= old('kategori') === 'UKM' ? 'selected' : '' ?>>UKM</option>
                    <option value="Lainnya" <?= old('kategori') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                </select>
            </div>
        </div>

        <h5 style="font-size:15px;font-weight:800;margin:28px 0 20px;padding-bottom:12px;border-bottom:2px solid #f0f0f0;">
            <i class="bi bi-person-badge-fill" style="color:#ff7a00;"></i>
            Akun Login
        </h5>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Username *</label>
                <input type="text" name="username" class="form-control"
                       value="<?= esc(old('username') ?? '') ?>"
                       placeholder="Contoh: hmjti" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Password *</label>
                <input type="password" name="password" class="form-control"
                       placeholder="Minimal 6 karakter"
                       minlength="6" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Email *</label>
                <input type="email" name="email" class="form-control"
                       value="<?= esc(old('email') ?? '') ?>"
                       placeholder="hmjti@gmail.com" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">No. Telepon *</label>
                <input type="text" name="no_telp" class="form-control"
                       value="<?= esc(old('no_telp') ?? '') ?>"
                       pattern="(\+62|08)[0-9]{8,13}"
                       placeholder="08xxxxxxxxxx" required>
            </div>
        </div>

        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:28px;padding-top:24px;border-top:2px solid #f0f0f0;">
            <button type="submit"
                    style="background:linear-gradient(135deg,#ff7a00,#e65100);color:white;border:none;padding:12px 28px;border-radius:12px;font-weight:700;cursor:pointer;">
                <i class="bi bi-save-fill"></i> Simpan Ormawa
            </button>

            <a href="<?= site_url('validator/ormawa') ?>"
               style="background:white;color:#666;border:2px solid #e8ecf1;padding:12px 28px;border-radius:12px;font-weight:700;text-decoration:none;">
                <i class="bi bi-x-lg"></i> Batal
            </a>
        </div>
    </form>
</div>

<?= $this->endSection(); ?>
