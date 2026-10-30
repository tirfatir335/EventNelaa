<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Ormawa</h3>
            <p>Perbarui data ormawa</p>
        </div>
        <a href="<?= site_url('validator/ormawa') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('validator/ormawa/update/' . $row['id_ormawa']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-building-fill me-2" style="color: var(--en-primary);"></i> Data Ormawa</h3>
        </div>

        <div style="display: grid; gap: 16px;">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Nama Ormawa <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="nama_ormawa" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($row['nama_ormawa'] ?? '') ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Kategori <span style="color: var(--en-danger);">*</span>
                    </label>
                    <select name="kategori" required class="form-select"
                            style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                        <option value="HMJ" <?= ($row['kategori'] ?? '') === 'HMJ' ? 'selected' : '' ?>>HMJ</option>
                        <option value="UKM" <?= ($row['kategori'] ?? '') === 'UKM' ? 'selected' : '' ?>>UKM</option>
                        <option value="Lainnya" <?= ($row['kategori'] ?? '') === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                    </select>
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Pembina <span style="color: var(--en-danger);">*</span>
                </label>
                <select name="pembina" required class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <?php foreach ($dosen as $d): ?>
                        <option value="<?= esc($d['nama_dosen']) ?>"
                            <?= ($row['pembina'] ?? '') === $d['nama_dosen'] ? 'selected' : '' ?>>
                            <?= esc($d['nama_dosen']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Status</label>
                <select name="status" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="Aktif" <?= ($row['status'] ?? '') === 'Aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="Tidak Aktif" <?= ($row['status'] ?? '') === 'Tidak Aktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>
        </div>
    </div>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-person-badge-fill me-2" style="color: var(--en-primary);"></i> Akun Login</h3>
        </div>

        <div style="display: grid; gap: 14px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Username</label>
                    <input type="text" readonly value="<?= esc($row['username'] ?? '') ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong); background: var(--en-bg-alt);">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Password Baru (opsional)</label>
                    <input type="password" name="password" minlength="6" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           placeholder="Kosongkan jika tidak diubah">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Email <span style="color: var(--en-danger);">*</span></label>
                    <input type="email" name="email" required value="<?= esc($row['email'] ?? '') ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">No Telp <span style="color: var(--en-danger);">*</span></label>
                    <input type="text" name="no_telp" required pattern="^(\+62|08)[0-9]{8,13}$"
                           value="<?= esc($row['no_telp'] ?? '') ?>" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                </div>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Ormawa
        </button>
        <a href="<?= site_url('validator/ormawa') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>