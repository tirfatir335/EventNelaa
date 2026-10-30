<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-info-circle me-2" style="color: var(--en-primary);"></i> Detail Validasi Gedung</h3>
            <p>Review event sebelum disetujui</p>
        </div>
        <a href="<?= site_url('admin/validasi') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- INFO EVENT -->
    <div class="col-md-7">
        <div class="en-card mb-4">
            <div class="en-card__head">
                <h3><i class="bi bi-file-text-fill me-2" style="color: var(--en-primary);"></i> Informasi Event</h3>
            </div>

            <div style="display: grid; gap: 0;">
                <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;">Nama Event</div>
                    <div style="flex: 1; color: var(--en-dark); font-weight: 700;"><?= esc($event['nama_event']) ?></div>
                </div>
                <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;">Ormawa</div>
                    <div style="flex: 1; color: var(--en-dark);"><?= esc($event['nama_ormawa'] ?? '-') ?></div>
                </div>
                <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;">Tanggal</div>
                    <div style="flex: 1; color: var(--en-dark);">
                        <i class="bi bi-calendar3" style="color: var(--en-primary);"></i>
                        <?= date('d F Y', strtotime($event['tanggal'])) ?>
                    </div>
                </div>
                <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;">Waktu</div>
                    <div style="flex: 1; color: var(--en-dark);">
                        <i class="bi bi-clock" style="color: var(--en-primary);"></i>
                        <?= esc($event['waktu'] ?? '-') ?> WIB
                    </div>
                </div>
                <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;">Gedung</div>
                    <div style="flex: 1; color: var(--en-dark); font-weight: 700;">
                        <i class="bi bi-geo-alt" style="color: var(--en-primary);"></i>
                        <?= esc($event['gedung'] ?? '-') ?>
                    </div>
                </div>
                <div style="display: flex; padding: 12px 0;">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px; vertical-align: top;">Deskripsi</div>
                    <div style="flex: 1; color: var(--en-text); font-size: 13px; line-height: 1.7;">
                        <?= nl2br(esc($event['deskripsi'] ?? '-')) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($event['poster']) && file_exists('uploads/poster/' . $event['poster'])): ?>
            <div class="en-card">
                <div class="en-card__head">
                    <h3><i class="bi bi-image-fill me-2" style="color: var(--en-primary);"></i> Poster</h3>
                </div>
                <img src="<?= base_url('uploads/poster/' . $event['poster']) ?>"
                     style="max-width: 100%; border-radius: var(--en-r);">
            </div>
        <?php endif; ?>
    </div>

    <!-- CEK BENTROK + FORM -->
    <div class="col-md-5">
        <?php if (!empty($bentrok)): ?>
            <div class="en-card mb-4" style="background: var(--en-danger-soft); border-left: 5px solid var(--en-danger);">
                <h3 style="font-size: 15px; font-weight: 800; color: #B91C1C; margin-bottom: 12px;">
                    <i class="bi bi-exclamation-triangle-fill"></i> BENTROK JADWAL!
                </h3>
                <p style="font-size: 13px; color: var(--en-text); margin-bottom: 12px;">
                    Ada <?= count($bentrok) ?> event lain di gedung & tanggal yang sama:
                </p>
                <?php foreach ($bentrok as $b): ?>
                    <div style="background: white; padding: 10px 14px; border-radius: 8px; margin-bottom: 8px; font-size: 12px;">
                        <strong><?= esc($b['nama_event']) ?></strong><br>
                        <small style="color: var(--en-muted);">
                            <i class="bi bi-clock"></i> <?= esc($b['waktu']) ?>
                            • Status: <?= esc($b['status']) ?>
                        </small>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="en-card mb-4" style="background: var(--en-success-soft); border-left: 5px solid var(--en-success);">
                <h3 style="font-size: 15px; font-weight: 800; color: #15803D; margin-bottom: 8px;">
                    <i class="bi bi-check-circle-fill"></i> Gedung Tersedia
                </h3>
                <p style="font-size: 13px; color: var(--en-text); margin: 0;">
                    Tidak ada bentrok jadwal di gedung ini.
                </p>
            </div>
        <?php endif; ?>

        <div class="en-card">
            <div class="en-card__head">
                <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Aksi Validasi</h3>
            </div>

            <form action="<?= site_url('admin/validasi/proses/' . $event['id_event']) ?>" method="post">
                <?= csrf_field() ?>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                        Pilih Aksi:
                    </label>

                    <label style="display: flex; align-items: center; gap: 10px; background: var(--en-success-soft);
                                  padding: 14px; border-radius: var(--en-r); margin-bottom: 8px; cursor: pointer; border: 2px solid transparent;"
                           onmouseover="this.style.borderColor='#22C55E';" onmouseout="this.style.borderColor='transparent';">
                        <input type="radio" name="valid" value="1" checked style="accent-color: var(--en-success);">
                        <span style="font-weight: 700; color: #15803D;">
                            <i class="bi bi-check-circle-fill"></i> Setujui & Teruskan ke Validator
                        </span>
                    </label>

                    <label style="display: flex; align-items: center; gap: 10px; background: var(--en-danger-soft);
                                  padding: 14px; border-radius: var(--en-r); cursor: pointer; border: 2px solid transparent;"
                           onmouseover="this.style.borderColor='#EF4444';" onmouseout="this.style.borderColor='transparent';">
                        <input type="radio" name="valid" value="0" style="accent-color: var(--en-danger);">
                        <span style="font-weight: 700; color: #B91C1C;">
                            <i class="bi bi-x-circle-fill"></i> Tolak (Gedung tidak tersedia)
                        </span>
                    </label>
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                        Catatan (wajib jika tolak):
                    </label>
                    <textarea name="catatan" rows="3" class="form-control"
                              style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                              placeholder="Contoh: Gedung sudah dipakai event lain"></textarea>
                </div>

                <button type="submit" class="en-btn en-btn-primary" style="width: 100%; justify-content: center;">
                    <i class="bi bi-save-fill"></i> Proses Validasi
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>