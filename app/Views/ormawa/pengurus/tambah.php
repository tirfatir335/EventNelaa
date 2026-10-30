<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-person-plus-fill me-2" style="color: var(--en-primary);"></i> Tambah Pengurus</h3>
            <p>Tambahkan data pengurus baru ke struktur ormawa</p>
        </div>
        <a href="<?= site_url('ormawa/pengurus') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/pengurus/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Lengkap <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="nama" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: Ahmad Fauzi">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    NPM <span style="color: var(--en-muted); font-weight: 400;">(wajib untuk Ketua Umum)</span>
                </label>
                <input type="text" name="npm" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: 2317051001">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Jabatan <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="jabatan" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           placeholder="Contoh: Ketua Umum, Sekretaris">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Level Hierarki <span style="color: var(--en-danger);">*</span>
                    </label>
                    <select name="level" required class="form-select"
                            style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                        <option value="">-- Pilih Level --</option>
                        <option value="1">1 — Ketua Umum</option>
                        <option value="2">2 — Wakil Ketua Umum</option>
                        <option value="3">3 — Sekretaris / Bendahara</option>
                        <option value="4">4 — Kepala Departemen</option>
                        <option value="5">5 — Wakil Kepala Departemen</option>
                        <option value="6">6 — Staf / Anggota</option>
                    </select>
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Departemen <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <select name="id_departemen" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="">-- Tidak di departemen (Pimpinan Inti) --</option>
                    <?php foreach ($departemen as $d): ?>
                        <option value="<?= $d['id_departemen'] ?>"><?= esc($d['nama_departemen']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Periode <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="text" name="periode" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: 2025/2026">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Foto Pengurus <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="file" name="foto" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                <small style="color: var(--en-muted); font-size: 11px;">Format: JPG, PNG (maks. 2MB). Disarankan foto persegi.</small>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Pengurus
        </button>
        <a href="<?= site_url('ormawa/pengurus') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>