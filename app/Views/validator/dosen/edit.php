<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Pembina</h3>
            <p>Perbarui data pembina</p>
        </div>
        <a href="<?= site_url('validator/dosen') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<form action="<?= site_url('validator/dosen/update/' . $dosen['id_dosen']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-person-badge-fill me-2" style="color: var(--en-primary);"></i> Data Dosen</h3>
        </div>

        <div style="display: grid; gap: 14px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        NIP <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="nip" required value="<?= esc($dosen['nip']) ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Nama Lengkap <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="nama_dosen" required value="<?= esc($dosen['nama_dosen']) ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Ormawa yang Dibina <span style="color: var(--en-danger);">*</span>
                </label>
                <select name="id_ormawa" required class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="">-- Pilih Ormawa --</option>
                    <?php foreach ($ormawa as $o): ?>
                        <option value="<?= $o['id_ormawa'] ?>"
                            <?= ($user['id_ormawa'] ?? '') == $o['id_ormawa'] ? 'selected' : '' ?>>
                            <?= esc($o['nama_ormawa']) ?> (<?= esc($o['kategori'] ?? '-') ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-shield-lock-fill me-2" style="color: var(--en-primary);"></i> Akun Login</h3>
        </div>

        <div style="display: grid; gap: 14px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Username</label>
                <input type="text" value="<?= esc($user['username'] ?? '-') ?>" readonly class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong); background: var(--en-bg-alt);">
                <small style="color: var(--en-muted); font-size: 11px;">Username tidak bisa diubah</small>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Email <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="email" name="email" required value="<?= esc($user['email'] ?? '') ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">No Telp</label>
                    <input type="text" name="no_telp" value="<?= esc($user['no_telp'] ?? '') ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Password Baru <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="password" name="password" minlength="6" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Kosongkan kalau tidak diganti">
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Pembina
        </button>
        <a href="<?= site_url('validator/dosen') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>