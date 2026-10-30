<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Recruitment</h3>
            <p>Perbarui data pengumuman rekrutmen</p>
        </div>
        <a href="<?= site_url('ormawa/recruitment') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/recruitment/update/' . $recruitment['id_recruitment']) ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Judul Recruitment <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="judul" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($recruitment['judul']) ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="deskripsi" rows="5" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"><?= esc($recruitment['deskripsi']) ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Posisi</label>
                    <input type="text" name="posisi" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($recruitment['posisi'] ?? '') ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Periode <span style="color: var(--en-danger);">*</span></label>
                    <input type="text" name="periode" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($recruitment['periode']) ?>">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Link Pendaftaran / GForm</label>
                <input type="url" name="link_pendaftaran" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($recruitment['link_pendaftaran'] ?? '') ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Link Grup WhatsApp</label>
                <input type="url" name="link_wa" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($recruitment['link_wa'] ?? '') ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Status</label>
                <select name="status" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="open" <?= $recruitment['status'] === 'open' ? 'selected' : '' ?>>🟢 Open</option>
                    <option value="closed" <?= $recruitment['status'] === 'closed' ? 'selected' : '' ?>>🔴 Closed</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Tahapan Seleksi</label>
                <div style="background: var(--en-bg-alt); border: 1px solid var(--en-border-strong);
                            border-radius: var(--en-r); padding: 16px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <input type="checkbox" name="pakai_tes_tertulis" value="1"
                               <?= !empty($recruitment['pakai_tes_tertulis']) ? 'checked' : '' ?>
                               style="width: 18px; height: 18px; accent-color: var(--en-primary);">
                        <label style="font-size: 13px; font-weight: 600;">Pakai Tes Tertulis?</label>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="pakai_wawancara" value="1"
                               <?= !empty($recruitment['pakai_wawancara']) ? 'checked' : '' ?>
                               style="width: 18px; height: 18px; accent-color: var(--en-primary);">
                        <label style="font-size: 13px; font-weight: 600;">Pakai Wawancara?</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Recruitment
        </button>
        <a href="<?= site_url('ormawa/recruitment') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>