<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Staf</h3>
            <p>Perbarui data dan hak akses staf</p>
        </div>
        <a href="<?= site_url('ormawa/staf') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/staf/update/' . $staf['id']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="en-card h-100">
                <div class="en-card__head">
                    <h3><i class="bi bi-person-badge-fill me-2" style="color: var(--en-primary);"></i> Data Akun Staf</h3>
                </div>

                <div style="display: grid; gap: 14px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Username</label>
                        <input type="text" class="form-control" value="<?= esc($staf['username']) ?>" readonly
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong); background: var(--en-bg-alt);">
                        <small style="color: var(--en-muted); font-size: 11px;"><i class="bi bi-lock-fill"></i> Username tidak dapat diubah</small>
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Email <span style="color: var(--en-danger);">*</span>
                        </label>
                        <input type="email" name="email" required class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               value="<?= esc($staf['email']) ?>">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                            Password Baru <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                        </label>
                        <input type="password" name="password" minlength="6" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               placeholder="Kosongkan jika tidak ingin mengganti">
                    </div>

                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">No. Telp</label>
                        <input type="text" name="no_telp" class="form-control"
                               style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                               value="<?= esc($staf['no_telp'] ?? '') ?>">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="en-card h-100">
                <div class="en-card__head">
                    <h3><i class="bi bi-shield-lock-fill me-2" style="color: var(--en-primary);"></i> Hak Akses Modul</h3>
                </div>

                <p style="font-size: 13px; color: var(--en-muted); margin-bottom: 14px;">Centang modul yang boleh diakses:</p>

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
                    <?php $perm = $permissionMap[$key] ?? null; ?>
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
                                           <?= !empty($perm['can_'.$act]) ? 'checked' : '' ?>
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
            <i class="bi bi-save-fill"></i> Update Staf
        </button>
        <a href="<?= site_url('ormawa/staf') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>