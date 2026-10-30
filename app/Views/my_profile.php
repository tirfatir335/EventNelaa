<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$foto = !empty($user['foto']) && file_exists('uploads/profil/' . $user['foto'])
    ? base_url('uploads/profil/' . $user['foto'])
    : base_url('uploads/profil/default.png');
?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-person-circle me-2" style="color: var(--en-primary);"></i> Profil Saya</h3>
            <p>Kelola foto profil dan informasi akun kamu</p>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill"></i><strong><?= session()->getFlashdata('success') ?></strong>
    </div>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<div class="row g-4">
    <!-- FOTO -->
    <div class="col-md-4">
        <div class="en-card h-100" style="text-align: center;">
            <img src="<?= $foto ?>" id="previewFoto"
                 style="width: 160px; height: 160px; border-radius: 50%; object-fit: cover;
                        border: 5px solid var(--en-primary-soft); margin: 0 auto 16px; display: block;">
            <h4 style="font-weight: 800; color: var(--en-dark); margin: 0 0 6px;"><?= esc($user['username']) ?></h4>
            <span class="en-badge <?= session('role') === 'staf_ormawa' ? 'en-badge-warning' : 'en-badge-primary' ?>">
                <?= session('role') === 'staf_ormawa' ? 'STAF UKM' : strtoupper(session('role')) ?>
            </span>
        </div>
    </div>

    <!-- FORM GANTI FOTO + INFO -->
    <div class="col-md-8">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3><i class="bi bi-image me-2" style="color: var(--en-primary);"></i> Ganti Foto Profil</h3>
            </div>

            <form action="<?= site_url('my-profile/update-foto') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div style="margin-bottom: 14px;">
                    <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/png,image/jpg,image/webp"
                           required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <small style="color: var(--en-muted); font-size: 11px;">Format: JPG, PNG, WEBP (maks. 2MB)</small>
                </div>
                <button type="submit" class="en-btn en-btn-primary">
                    <i class="bi bi-save"></i> Simpan Foto
                </button>
            </form>

            <hr style="border: none; border-top: 1px solid var(--en-border); margin: 24px 0;">

            <div class="en-card__head">
                <h3><i class="bi bi-info-circle me-2" style="color: var(--en-primary);"></i> Informasi Akun</h3>
            </div>

            <div style="display: grid; gap: 12px;">
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--en-border);">
                    <span style="color: var(--en-muted); font-size: 13px;">Username</span>
                    <strong style="color: var(--en-dark); font-size: 13px;"><?= esc($user['username']) ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid var(--en-border);">
                    <span style="color: var(--en-muted); font-size: 13px;">Email</span>
                    <strong style="color: var(--en-dark); font-size: 13px;"><?= esc($user['email'] ?? '-') ?></strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 10px 0;">
                    <span style="color: var(--en-muted); font-size: 13px;">No. Telp</span>
                    <strong style="color: var(--en-dark); font-size: 13px;"><?= esc($user['no_telp'] ?? '-') ?></strong>
                </div>
            </div>

            <div class="en-card" style="background: var(--en-warning-soft); border-left: 4px solid var(--en-warning); margin-top: 16px;">
                <div style="display: flex; gap: 10px; align-items: flex-start;">
                    <i class="bi bi-info-circle-fill" style="color: #B45309; font-size: 18px;"></i>
                    <small style="color: var(--en-text); font-size: 12.5px; line-height: 1.6;">
                        Untuk mengubah <strong>email</strong> atau <strong>password</strong>,
                        silakan hubungi <strong>Admin UKM</strong> kamu.
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.getElementById('fotoInput')?.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('previewFoto').src = ev.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>
<?= $this->endSection() ?>