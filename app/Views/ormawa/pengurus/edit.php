<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Pengurus</h3>
            <p>Perbarui data pengurus ormawa</p>
        </div>
        <a href="<?= site_url('ormawa/pengurus') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/pengurus/update/' . $pengurus['id_pengurus']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Lengkap <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="nama" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($pengurus['nama']) ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    NPM
                </label>
                <input type="text" name="npm" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($pengurus['npm'] ?? '') ?>">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Jabatan <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="jabatan" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($pengurus['jabatan']) ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Level <span style="color: var(--en-danger);">*</span>
                    </label>
                    <select name="level" required class="form-select"
                            style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                        <option value="">-- Pilih Level --</option>
                        <option value="1" <?= ($pengurus['level'] ?? '') == 1 ? 'selected' : '' ?>>1 — Ketua Umum</option>
                        <option value="2" <?= ($pengurus['level'] ?? '') == 2 ? 'selected' : '' ?>>2 — Wakil Ketua Umum</option>
                        <option value="3" <?= ($pengurus['level'] ?? '') == 3 ? 'selected' : '' ?>>3 — Sekretaris / Bendahara</option>
                        <option value="4" <?= ($pengurus['level'] ?? '') == 4 ? 'selected' : '' ?>>4 — Kepala Departemen</option>
                        <option value="5" <?= ($pengurus['level'] ?? '') == 5 ? 'selected' : '' ?>>5 — Wakil Kepala Departemen</option>
                        <option value="6" <?= ($pengurus['level'] ?? '') == 6 ? 'selected' : '' ?>>6 — Staf / Anggota</option>
                    </select>
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Departemen
                </label>
                <select name="id_departemen" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="">-- Tidak di departemen (Pimpinan Inti) --</option>
                    <?php foreach ($departemen as $d): ?>
                        <option value="<?= $d['id_departemen'] ?>"
                            <?= ($pengurus['id_departemen'] ?? '') == $d['id_departemen'] ? 'selected' : '' ?>>
                            <?= esc($d['nama_departemen']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Periode
                </label>
                <input type="text" name="periode" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($pengurus['periode'] ?? '') ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Foto <span style="color: var(--en-muted); font-weight: 400;">(kosongkan jika tidak diganti)</span>
                </label>
                <?php if (!empty($pengurus['foto']) && file_exists('uploads/pengurus/' . $pengurus['foto'])): ?>
                    <img src="<?= base_url('uploads/pengurus/' . $pengurus['foto']) ?>"
                         style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;
                                border: 3px solid var(--en-primary-light); margin-bottom: 10px; display: block;">
                <?php endif; ?>
                <input type="file" name="foto" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Pengurus
        </button>
        <a href="<?= site_url('ormawa/pengurus') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>