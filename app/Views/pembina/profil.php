<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$fotoUrl = (!empty($pembina['foto']) && file_exists('uploads/profil/' . $pembina['foto']))
    ? base_url('uploads/profil/' . $pembina['foto'])
    : base_url('uploads/profil/default.png');
?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-person-badge-fill me-2" style="color: var(--en-primary);"></i> Profil Pembina</h3>
            <p>Kelola informasi akun pembina UKM</p>
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

<form action="<?= base_url('pembina/update-profil') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="en-card h-100" style="text-align: center;">
                <div class="en-card__head" style="justify-content: center;">
                    <h3><i class="bi bi-person-circle me-2" style="color: var(--en-primary);"></i> Foto Profil</h3>
                </div>
                <img src="<?= $fotoUrl ?>" id="previewFoto"
                     style="width: 160px; height: 160px; border-radius: 50%; object-fit: cover;
                            border: 5px solid var(--en-primary-soft); margin: 0 auto 16px; display: block;">
                <input type="file" name="foto" id="fotoInput" accept="image/jpeg,image/png,image/jpg" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                <small style="color: var(--en-muted); font-size: 11px; display: block; margin-top: 8px;">
                    Format: JPG/PNG — Maks 2MB
                </small>
            </div>
        </div>

        <div class="col-md-8">
            <div class="en-card h-100">
                <div class="en-card__head">
                    <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Data Akun</h3>
                </div>

                <div style="display: grid; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Username</label>
                        <input type="text" value="<?= esc($pembina['username'] ?? '') ?>" readonly class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong); background: var(--en-bg-alt);">
                        <small style="color: var(--en-muted); font-size: 11px;">Username tidak dapat diubah</small>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Email <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="email" name="email" required value="<?= esc($pembina['email'] ?? '') ?>" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">No. Telepon</label>
                        <input type="text" name="no_telp" value="<?= esc($pembina['no_telp'] ?? '') ?>" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               placeholder="Contoh: 08123456789">
                    </div>

                    <div>
                        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
                            <i class="bi bi-save-fill"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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