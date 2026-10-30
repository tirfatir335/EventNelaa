<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-pencil-square me-2" style="color: var(--en-primary);"></i> Edit Event</h3>
            <p>Perbarui detail event & perencanaan biaya</p>
        </div>
        <a href="<?= site_url('ormawa/kegiatan') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<form action="<?= site_url('ormawa/kegiatan/update/' . $event['id_event']) ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Informasi Event</h3>
        </div>

        <div style="display: grid; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Event <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="nama_event" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($event['nama_event']) ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Poster <span style="color: var(--en-muted); font-weight: 400;">(kosongkan jika tidak diganti)</span>
                </label>
                <?php if (!empty($event['poster']) && file_exists('uploads/poster/' . $event['poster'])): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="<?= base_url('uploads/poster/' . $event['poster']) ?>"
                             style="max-height: 140px; border-radius: var(--en-r); border: 2px solid var(--en-border-strong);">
                    </div>
                <?php endif; ?>
                <input type="file" name="poster" accept="image/*" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Tanggal <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="date" name="tanggal" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($event['tanggal']) ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Waktu <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="time" name="waktu" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= esc($event['waktu']) ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Gedung <span style="color: var(--en-danger);">*</span>
                    </label>
                    <select name="gedung" id="gedungSelect" required class="form-select"
                            style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                        <?php foreach ($gedung as $g): ?>
                            <option value="<?= esc($g['nama_gedung']) ?>"
                                <?= trim($event['gedung']) === trim($g['nama_gedung']) ? 'selected' : '' ?>>
                                <?= esc($g['nama_gedung']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="lainnya">Lainnya...</option>
                    </select>
                </div>
            </div>

            <div id="gedungLainnya" style="display: none;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Gedung Lainnya
                </label>
                <input type="text" name="gedung_lainnya" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="deskripsi" rows="4" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"><?= esc($event['deskripsi']) ?></textarea>
            </div>
        </div>
    </div>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Data Peserta</h3>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Peserta Siapa?
                </label>
                <select name="peserta_tipe" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="">-- Pilih --</option>
                    <option value="Mahasiswa Internal" <?= ($event['peserta_tipe'] ?? '') === 'Mahasiswa Internal' ? 'selected' : '' ?>>Mahasiswa Internal</option>
                    <option value="Mahasiswa + Dosen" <?= ($event['peserta_tipe'] ?? '') === 'Mahasiswa + Dosen' ? 'selected' : '' ?>>Mahasiswa + Dosen</option>
                    <option value="Umum / Eksternal" <?= ($event['peserta_tipe'] ?? '') === 'Umum / Eksternal' ? 'selected' : '' ?>>Umum / Eksternal</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Jumlah Peserta
                </label>
                <input type="number" name="peserta_jumlah" id="pesertaJumlah" min="1" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($event['peserta_jumlah'] ?? '') ?>">
            </div>
        </div>
    </div>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-cash-coin me-2" style="color: var(--en-primary);"></i> Perencanaan Biaya</h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 14px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Durasi (hari)</label>
                <input type="number" name="durasi_hari" id="durasiHari" min="1" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($event['durasi_hari'] ?? 1) ?>">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Konsumsi</label>
                <select name="konsumsi_tipe" class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="Tanpa Konsumsi" <?= ($event['konsumsi_tipe'] ?? '') === 'Tanpa Konsumsi' ? 'selected' : '' ?>>Tanpa Konsumsi</option>
                    <option value="Snack Saja" <?= ($event['konsumsi_tipe'] ?? '') === 'Snack Saja' ? 'selected' : '' ?>>Snack Saja</option>
                    <option value="Snack + Makan Siang" <?= ($event['konsumsi_tipe'] ?? '') === 'Snack + Makan Siang' ? 'selected' : '' ?>>Snack + Makan Siang</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Konsumsi / Orang (Rp)</label>
                <input type="number" name="konsumsi_per_orang" id="konsumsiPerOrang" min="0" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($event['konsumsi_per_orang'] ?? 0) ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Biaya Lain-lain (Rp)</label>
                <input type="number" name="biaya_lain" id="biayaLain" min="0" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= esc($event['biaya_lain'] ?? 0) ?>">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">Total Biaya (Otomatis)</label>
                <input type="text" id="totalBiaya" readonly class="form-control"
                       style="height: 46px; border-radius: var(--en-r); background: var(--en-primary-soft);
                              border: 2px solid var(--en-primary-light); font-weight: 800; color: var(--en-primary-dark);">
            </div>
        </div>
    </div>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-list-check me-2" style="color: var(--en-primary);"></i> Rundown</h3>
        </div>
        <?php
            $rundownText = '';
            if (!empty($event['rundown'])) {
                $arr = json_decode($event['rundown'], true);
                $rundownText = is_array($arr) ? implode("\n", $arr) : $event['rundown'];
            }
        ?>
        <textarea name="rundown" rows="6" class="form-control"
                  style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                  placeholder="08:00 - Pembukaan"><?= esc($rundownText) ?></textarea>
    </div>

    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Update Event
        </button>
        <a href="<?= site_url('ormawa/kegiatan') ?>" class="en-btn en-btn-light en-btn-lg">
            <i class="bi bi-x-lg"></i> Batal
        </a>
    </div>
</form>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const pesertaJumlah    = document.getElementById('pesertaJumlah');
const konsumsiPerOrang = document.getElementById('konsumsiPerOrang');
const durasiHari       = document.getElementById('durasiHari');
const biayaLain        = document.getElementById('biayaLain');
const totalBiaya       = document.getElementById('totalBiaya');

function hitungTotal() {
    const p = parseInt(pesertaJumlah.value) || 0;
    const k = parseInt(konsumsiPerOrang.value) || 0;
    const d = parseInt(durasiHari.value) || 1;
    const l = parseInt(biayaLain.value) || 0;
    totalBiaya.value = 'Rp ' + ((p * k * d) + l).toLocaleString('id-ID');
}
[pesertaJumlah, konsumsiPerOrang, durasiHari, biayaLain].forEach(el => {
    el?.addEventListener('input', hitungTotal);
});
hitungTotal();

document.getElementById('gedungSelect')?.addEventListener('change', function() {
    document.getElementById('gedungLainnya').style.display = this.value === 'lainnya' ? 'block' : 'none';
});
</script>
<?= $this->endSection() ?>