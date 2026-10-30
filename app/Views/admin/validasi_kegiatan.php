<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-check2-square me-2" style="color: var(--en-primary);"></i> Validasi Event</h3>
            <p>Review dan validasi event yang diajukan</p>
        </div>
        <a href="<?= site_url('admin/kegiatan') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- DETAIL EVENT -->
    <div class="col-md-7">
        <div class="en-card mb-4">
            <div class="en-card__head">
                <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Detail Event</h3>
            </div>

            <div style="display: grid; gap: 0;">
                <?php
                $rows = [
                    'Nama Event' => esc($event['nama_event']),
                    'Ormawa'     => esc($event['nama_ormawa'] ?? '-'),
                    'Tanggal'    => date('d F Y', strtotime($event['tanggal'])),
                    'Waktu'      => esc($event['waktu'] ?? '-') . ' WIB',
                    'Gedung'     => esc($event['gedung'] ?? '-'),
                ];
                foreach ($rows as $label => $val):
                ?>
                    <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                        <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;"><?= $label ?></div>
                        <div style="flex: 1; color: var(--en-dark); font-size: 14px;"><?= $val ?></div>
                    </div>
                <?php endforeach; ?>
                <div style="display: flex; padding: 12px 0;">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;">Deskripsi</div>
                    <div style="flex: 1; color: var(--en-text); font-size: 13px; line-height: 1.7;">
                        <?= nl2br(esc($event['deskripsi'] ?? 'Belum ada deskripsi')) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($event['poster']) && file_exists('uploads/poster/' . $event['poster'])): ?>
            <div class="en-card">
                <div class="en-card__head">
                    <h3><i class="bi bi-image-fill me-2" style="color: var(--en-primary);"></i> Poster Event</h3>
                </div>
                <div style="text-align: center;">
                    <img src="<?= base_url('uploads/poster/' . $event['poster']) ?>"
                         style="max-width: 100%; border-radius: var(--en-r);">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- FORM VALIDASI -->
    <div class="col-md-5">
        <div class="en-card" style="position: sticky; top: 90px;">
            <div class="en-card__head">
                <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Aksi Validasi</h3>
            </div>

            <div style="background: var(--en-primary-soft); padding: 14px; border-radius: var(--en-r);
                        border-left: 4px solid var(--en-primary); margin-bottom: 20px;">
                <div style="font-size: 11px; font-weight: 800; color: var(--en-muted);
                            text-transform: uppercase; letter-spacing: .5px; margin-bottom: 6px;">
                    Status Saat Ini
                </div>
                <div style="font-size: 14px; font-weight: 700; color: var(--en-dark);">
                    <?= esc($event['status']) ?>
                </div>
            </div>

            <form action="<?= site_url('admin/kegiatan/prosesValidasi/' . $event['id_event']) ?>" method="post">
                <?= csrf_field() ?>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                        Pilih Aksi <span style="color: var(--en-danger);">*</span>
                    </label>

                    <label style="display: flex; align-items: center; gap: 10px; background: var(--en-success-soft);
                                  border: 2px solid transparent; padding: 14px 16px; border-radius: var(--en-r);
                                  cursor: pointer; margin-bottom: 10px; transition: .2s;"
                           onmouseover="this.style.borderColor='#22C55E';" onmouseout="this.style.borderColor='transparent';">
                        <input type="radio" name="valid" value="1" required style="accent-color: var(--en-success);">
                        <div>
                            <div style="font-weight: 800; color: #15803D; font-size: 14px;">
                                <i class="bi bi-check-circle-fill"></i> Setujui Event
                            </div>
                            <div style="font-size: 12px; color: var(--en-text); margin-top: 4px;">
                                Kirim ke validator untuk proses selanjutnya
                            </div>
                        </div>
                    </label>

                    <label style="display: flex; align-items: center; gap: 10px; background: var(--en-danger-soft);
                                  border: 2px solid transparent; padding: 14px 16px; border-radius: var(--en-r);
                                  cursor: pointer; transition: .2s;"
                           onmouseover="this.style.borderColor='#EF4444';" onmouseout="this.style.borderColor='transparent';">
                        <input type="radio" name="valid" value="0" required style="accent-color: var(--en-danger);">
                        <div>
                            <div style="font-weight: 800; color: #B91C1C; font-size: 14px;">
                                <i class="bi bi-x-circle-fill"></i> Tolak Event
                            </div>
                            <div style="font-size: 12px; color: var(--en-text); margin-top: 4px;">
                                Event akan dikembalikan ke ormawa
                            </div>
                        </div>
                    </label>
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                        Catatan <span style="color: var(--en-muted); font-weight: 400;">(wajib jika tolak)</span>
                    </label>
                    <textarea name="catatan" rows="4" class="form-control"
                              style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                              placeholder="Berikan alasan penolakan atau catatan tambahan..."></textarea>
                    <small style="color: var(--en-muted); font-size: 11px; display: block; margin-top: 6px;">
                        <i class="bi bi-info-circle"></i> Catatan akan dilihat oleh ormawa pengaju
                    </small>
                </div>

                <button type="submit" class="en-btn en-btn-primary en-btn-lg" style="width: 100%; justify-content: center;">
                    <i class="bi bi-save-fill"></i> Proses Validasi
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>