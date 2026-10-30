<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-person-plus-fill me-2" style="color: var(--en-primary);"></i> Tambah Staf Baru</h3>
            <p>Buat akun staf baru dan atur hak aksesnya</p>
        </div>
        <a href="<?= site_url('ormawa/staf') ?>" class="en-btn en-btn-light">
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

<form action="<?= site_url('ormawa/staf/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- DATA AKUN -->
        <div class="col-md-6">
            <div class="en-card h-100">
                <div class="en-card__head">
                    <h3><i class="bi bi-person-badge-fill me-2" style="color: var(--en-primary);"></i> Data Akun Staf</h3>
                </div>

                <div style="display: grid; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Username <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="text" name="username" required class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               placeholder="Pilih username unik">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Email <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="email" name="email" required class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               placeholder="contoh@email.com">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Password <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="password" name="password" required minlength="6" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               placeholder="Minimal 6 karakter">
                        <small style="color: var(--en-muted); font-size: 11px;">
                            <i class="bi bi-info-circle"></i> Berikan password ke staf setelah dibuat
                        </small>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            No. Telp <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                        </label>
                        <input type="text" name="no_telp" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               placeholder="Contoh: 08123456789">
                    </div>
                </div>
            </div>
        </div>

        <!-- HAK AKSES -->
        <div class="col-md-6">
            <div class="en-card h-100">
                <div class="en-card__head">
                    <h3><i class="bi bi-shield-lock-fill me-2" style="color: var(--en-primary);"></i> Hak Akses Modul</h3>
                </div>

                <p style="font-size: 13px; color: var(--en-muted); margin-bottom: 14px;">
                    Centang modul yang boleh diakses oleh staf ini:
                </p>

                <?php
                $modules = [
                    'profil'      => ['label' => 'Profil Ormawa',   'icon' => 'person-fill'],
                    'progja'      => ['label' => 'Program Kerja',   'icon' => 'clipboard-check'],
                    'pengurus'    => ['label' => 'Pengurus',        'icon' => 'people-fill'],
                    'departemen'  => ['label' => 'Departemen',      'icon' => 'diagram-3-fill'],
                    'galeri'      => ['label' => 'Galeri',          'icon' => 'images'],
                    'berita'      => ['label' => 'Berita',          'icon' => 'newspaper'],
                    'recruitment' => ['label' => 'Recruitment',     'icon' => 'megaphone-fill'],
                    'event'       => ['label' => 'Event',           'icon' => 'journal-text'],
                ];
                ?>

                <?php foreach ($modules as $key => $mod): ?>
                    <div style="background: var(--en-bg-alt); border: 1px solid var(--en-border-strong);
                                border-radius: var(--en-r); padding: 12px 14px; margin-bottom: 8px;">
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <i class="bi bi-<?= $mod['icon'] ?>" style="color: var(--en-primary); font-size: 16px;"></i>
                            <strong style="font-size: 13px; color: var(--en-dark);"><?= $mod['label'] ?></strong>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 14px;">
                            <?php foreach (['view' => 'Lihat', 'create' => 'Tambah', 'edit' => 'Edit', 'delete' => 'Hapus'] as $act => $lbl): ?>
                                <label style="display: flex; align-items: center; gap: 6px; font-size: 12px; cursor: pointer;">
                                    <input type="checkbox" name="permissions[<?= $key ?>][<?= $act ?>]" value="1"
                                           <?= $act === 'view' ? 'checked' : '' ?>
                                           style="width: 16px; height: 16px; accent-color: var(--en-primary);">
                                    <?= $lbl ?>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px; margin-top: 24px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Staf
        </button>
        <a href="<?= site_url('ormawa/staf') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>