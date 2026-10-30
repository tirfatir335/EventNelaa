<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$foto_form_url = (!empty($user['foto']))
    ? base_url('uploads/profil/' . $user['foto'])
    : base_url('uploads/profil/default.png');

$namaOrmawa = $profil['nama_ormawa'] ?? '';
$pembina    = $profil['pembina'] ?? '';
$email      = $user['email'] ?? '';
$no_telp    = $user['no_telp'] ?? '';
?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-building me-2" style="color: var(--en-primary);"></i> Profil Ormawa</h3>
            <p>Kelola informasi dan identitas ormawa kamu</p>
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

<form action="<?= base_url('ormawa/profil/update') ?>" method="POST" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- FOTO PROFIL USER -->
        <div class="col-md-4">
            <div class="en-card h-100" style="text-align: center;">
                <div class="en-card__head" style="justify-content: center;">
                    <h3><i class="bi bi-person-circle me-2" style="color: var(--en-primary);"></i> Foto Profil</h3>
                </div>
                <img src="<?= $foto_form_url ?>" id="previewFoto"
                     style="width: 160px; height: 160px; border-radius: 50%; object-fit: cover;
                            border: 5px solid var(--en-primary-soft); margin: 0 auto 16px; display: block;">
                <input type="file" name="foto" id="fotoInput" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                <small style="color: var(--en-muted); font-size: 11px; display: block; margin-top: 8px;">
                    Foto Profil User (JPG/PNG — Maks 2MB)
                </small>
            </div>
        </div>

        <!-- DATA -->
        <div class="col-md-8">
            <div class="en-card h-100">
                <div class="en-card__head">
                    <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Data Ormawa</h3>
                </div>

                <div style="display: grid; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Nama Ormawa <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="text" name="nama_ormawa" required maxlength="60" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               value="<?= esc($namaOrmawa) ?>">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Pembina Ormawa <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="text" name="pembina" required maxlength="50" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               value="<?= esc($pembina) ?>">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                                Email <span style="color: var(--en-danger);">*</span>
                            </label>
                            <input type="email" name="email" required maxlength="50" class="form-control"
                                   style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                                   value="<?= esc($email) ?>">
                        </div>
                        <div>
                            <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                                No. Telp
                            </label>
                            <input type="text" name="no_telp" maxlength="15" class="form-control"
                                   style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                                   value="<?= esc($no_telp) ?>">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- VISI MISI -->
    <div class="en-card mt-4">
        <div class="en-card__head">
            <h3><i class="bi bi-eye-fill me-2" style="color: var(--en-primary);"></i> Visi & Misi</h3>
        </div>

        <div style="display: grid; gap: 14px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Visi</label>
                <textarea name="visi" rows="3" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Tuliskan visi ormawa..."><?= esc($profil['visi'] ?? '') ?></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Misi</label>
                <textarea name="misi" rows="3" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Tuliskan misi ormawa..."><?= esc($profil['misi'] ?? '') ?></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Deskripsi singkat tentang ormawa..."><?= esc($profil['deskripsi'] ?? '') ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Instagram <span style="color: var(--en-muted); font-weight: 400;">(tanpa @)</span>
                    </label>
                    <input type="text" name="instagram" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($profil['instagram'] ?? '') ?>" placeholder="contoh: polinela">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Logo Ormawa <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                    </label>
                    <?php if (!empty($profil['logo']) && file_exists('uploads/logo/' . $profil['logo'])): ?>
                        <div style="margin-bottom: 8px;">
                            <img src="<?= base_url('uploads/logo/' . $profil['logo']) ?>"
                                 style="max-height: 60px; border: 1px solid var(--en-border); border-radius: 8px; padding: 4px;">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="logo" accept="image/*" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <small style="color: var(--en-muted); font-size: 11px;">Format: JPG, PNG (maks. 2MB)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="en-card mt-4">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Perubahan
        </button>
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