<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Tulis Berita Baru</h3>
            <p>Buat berita atau pengumuman untuk dipublikasikan</p>
        </div>
        <a href="<?= site_url('ormawa/berita') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/berita/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Judul Berita <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="judul" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: Kegiatan Bakti Sosial 2025">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Konten Berita <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="konten" rows="10" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Tulis isi berita dengan jelas. Bisa menggunakan enter untuk baris baru..."></textarea>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Foto Cover <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="file" name="foto" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                <small style="color: var(--en-muted); font-size: 11px;">Format: JPG, PNG (maks. 2MB)</small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Status Publikasi <span style="color: var(--en-danger);">*</span>
                </label>
                <select name="status" required class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="draft">📝 Draft — Simpan dulu, belum tampil di publik</option>
                    <option value="published">✅ Published — Langsung tampil di publik</option>
                </select>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Berita
        </button>
        <a href="<?= site_url('ormawa/berita') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>