<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-plus-circle-fill me-2" style="color: var(--en-primary);"></i> Buat Open Recruitment</h3>
            <p>Buat pengumuman rekrutmen anggota baru</p>
        </div>
        <a href="<?= site_url('ormawa/recruitment') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="<?= site_url('ormawa/recruitment/simpan') ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Informasi Recruitment</h3>
        </div>

        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Judul Recruitment <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="judul" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: Open Recruitment Anggota Baru 2026">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="deskripsi" rows="5" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Jelaskan tentang rekrutmen, persyaratan, dan benefit bergabung..."></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Posisi yang Dibuka
                    </label>
                    <input type="text" name="posisi" class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           placeholder="Contoh: Anggota, Staff Divisi">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Periode <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="text" name="periode" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           placeholder="Contoh: 2026/2027">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Link Pendaftaran / GForm <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="url" name="link_pendaftaran" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="https://forms.google.com/...">
                <small style="color: var(--en-muted); font-size: 11px;">
                    <i class="bi bi-info-circle"></i> Link info tambahan. Pendaftaran utama lewat form internal.
                </small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Link Grup WhatsApp <span style="color: var(--en-muted); font-weight: 400;">(opsional)</span>
                </label>
                <input type="url" name="link_wa" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="https://chat.whatsapp.com/...">
                <small style="color: var(--en-muted); font-size: 11px;">
                    <i class="bi bi-info-circle"></i> Link grup WA untuk peserta yang lolos seleksi
                </small>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Status
                </label>
                <select name="status" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="open">🟢 Open — Sedang menerima pendaftar</option>
                    <option value="closed">🔴 Closed — Sudah ditutup</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Tahapan Seleksi
                </label>
                <div style="background: var(--en-bg-alt); border: 1px solid var(--en-border-strong);
                            border-radius: var(--en-r); padding: 16px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 12px;">
                        <input type="checkbox" name="pakai_tes_tertulis" value="1" id="pakai_tes_tertulis"
                               style="width: 18px; height: 18px; accent-color: var(--en-primary);">
                        <label for="pakai_tes_tertulis" style="cursor: pointer;">
                            <strong style="font-size: 13px;">Pakai Tes Tertulis?</strong>
                            <div style="font-size: 11px; color: var(--en-muted);">Centang jika ada tahap tes tertulis</div>
                        </label>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="checkbox" name="pakai_wawancara" value="1" id="pakai_wawancara" checked
                               style="width: 18px; height: 18px; accent-color: var(--en-primary);">
                        <label for="pakai_wawancara" style="cursor: pointer;">
                            <strong style="font-size: 13px;">Pakai Wawancara?</strong>
                            <div style="font-size: 11px; color: var(--en-muted);">Centang jika ada tahap wawancara</div>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Recruitment
        </button>
        <a href="<?= site_url('ormawa/recruitment') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>