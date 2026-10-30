<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<?php
$ai = $ai_result ?? [];
$hasAI = !empty($ai);
?>

<!-- HEADER -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-plus-circle-fill me-2" style="color: var(--en-primary);"></i> Tambah Event</h3>
            <p>Isi detail event & perencanaan biaya</p>
        </div>
        <div style="display: flex; gap: 8px;">
            <a href="<?= site_url('ormawa/kegiatan') ?>" class="en-btn en-btn-light">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <?php if (!$hasAI): ?>
                <a href="<?= site_url('ormawa/kegiatan/generate-ai') ?>" class="en-btn en-btn-primary">
                    <i class="bi bi-robot"></i> Generate dengan AI
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php if ($hasAI): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 12px; color: #15803D;">
        <i class="bi bi-robot" style="font-size: 28px;"></i>
        <div>
            <strong style="display: block;">✨ Data sudah diisi otomatis oleh EventNela AI</strong>
            <small>Silakan cek & lengkapi poster (wajib), lalu submit.</small>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<form action="<?= site_url('ormawa/kegiatan/simpan') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <!-- INFORMASI EVENT -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Informasi Event</h3>
        </div>

        <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Event <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="nama_event" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       placeholder="Contoh: Workshop Coding 2026"
                       value="<?= old('nama_event', $ai['nama_event'] ?? '') ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Poster <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="file" name="poster" accept="image/*" required class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                <small style="color: var(--en-muted); font-size: 11px;">Format: JPG / PNG (maks. 2MB)</small>
            </div>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Tanggal <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggalInput" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= old('tanggal', $ai['tanggal'] ?? '') ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Waktu <span style="color: var(--en-danger);">*</span>
                    </label>
                    <input type="time" name="waktu" id="waktuInput" required class="form-control"
                           style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                           value="<?= old('waktu', $ai['waktu'] ?? '') ?>">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                        Gedung <span style="color: var(--en-danger);">*</span>
                    </label>
                    <?php
                        $gedungAI = old('gedung', $ai['gedung'] ?? '');
                        $gedungAda = false;
                        foreach ($gedung as $g) {
                            if (strcasecmp(trim($g['nama_gedung']), trim($gedungAI)) === 0) {
                                $gedungAda = true;
                                $gedungAI = $g['nama_gedung'];
                                break;
                            }
                        }
                        $gedungValue = $gedungAda ? $gedungAI : (!empty($gedungAI) ? 'lainnya' : '');
                    ?>
                    <select name="gedung" id="gedungSelect" required class="form-select"
                            style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                        <option value="">-- Pilih Gedung --</option>
                        <?php foreach ($gedung as $g): ?>
                            <option value="<?= esc($g['nama_gedung']) ?>" <?= $gedungValue === $g['nama_gedung'] ? 'selected' : '' ?>>
                                <?= esc($g['nama_gedung']) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="lainnya" <?= $gedungValue === 'lainnya' ? 'selected' : '' ?>>Lainnya...</option>
                    </select>
                </div>
            </div>

            <div id="gedungLainnya" style="display: <?= $gedungValue === 'lainnya' ? 'block' : 'none' ?>;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Nama Gedung Lainnya <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="text" name="gedung_lainnya" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= old('gedung_lainnya', !$gedungAda && !empty($gedungAI) ? $gedungAI : '') ?>">
            </div>

            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Deskripsi Event <span style="color: var(--en-danger);">*</span>
                </label>
                <textarea name="deskripsi" rows="4" required class="form-control"
                          style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                          placeholder="Jelaskan gambaran event, tujuan, dan benefit..."><?= old('deskripsi', $ai['deskripsi'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- PESERTA -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Data Peserta</h3>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Peserta Siapa? <span style="color: var(--en-danger);">*</span>
                </label>
                <?php $pesertaTipe = old('peserta_tipe', $ai['peserta_tipe'] ?? ''); ?>
                <select name="peserta_tipe" required class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="">-- Pilih --</option>
                    <option value="Mahasiswa Internal"  <?= $pesertaTipe === 'Mahasiswa Internal' ? 'selected' : '' ?>>Mahasiswa Internal</option>
                    <option value="Mahasiswa + Dosen"   <?= $pesertaTipe === 'Mahasiswa + Dosen' ? 'selected' : '' ?>>Mahasiswa + Dosen</option>
                    <option value="Umum / Eksternal"    <?= $pesertaTipe === 'Umum / Eksternal' ? 'selected' : '' ?>>Umum / Eksternal</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Jumlah Peserta <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="number" name="peserta_jumlah" id="pesertaJumlah" required min="1" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= old('peserta_jumlah', $ai['peserta_jumlah'] ?? '') ?>">
            </div>
        </div>
    </div>

    <!-- BIAYA -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-cash-coin me-2" style="color: var(--en-primary);"></i> Perencanaan Biaya</h3>
        </div>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 14px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Durasi (hari) <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="number" name="durasi_hari" id="durasiHari" required min="1" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= old('durasi_hari', $ai['durasi_hari'] ?? 1) ?>">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Konsumsi <span style="color: var(--en-danger);">*</span>
                </label>
                <?php $konsumsiTipe = old('konsumsi_tipe', $ai['konsumsi_tipe'] ?? 'Tanpa Konsumsi'); ?>
                <select name="konsumsi_tipe" required class="form-select"
                        style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);">
                    <option value="Tanpa Konsumsi"       <?= $konsumsiTipe === 'Tanpa Konsumsi' ? 'selected' : '' ?>>Tanpa Konsumsi</option>
                    <option value="Snack Saja"           <?= $konsumsiTipe === 'Snack Saja' ? 'selected' : '' ?>>Snack Saja</option>
                    <option value="Snack + Makan Siang"  <?= $konsumsiTipe === 'Snack + Makan Siang' ? 'selected' : '' ?>>Snack + Makan Siang</option>
                </select>
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Konsumsi / Orang (Rp) <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="number" name="konsumsi_per_orang" id="konsumsiPerOrang" required min="0" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= old('konsumsi_per_orang', $ai['konsumsi_per_orang'] ?? 0) ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Biaya Lain-lain (Rp) <span style="color: var(--en-danger);">*</span>
                </label>
                <input type="number" name="biaya_lain" id="biayaLain" required min="0" class="form-control"
                       style="height: 46px; border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                       value="<?= old('biaya_lain', $ai['biaya_lain'] ?? 0) ?>">
            </div>
            <div>
                <label style="display: block; font-size: 13px; font-weight: 700; color: var(--en-dark); margin-bottom: 6px;">
                    Total Biaya (Otomatis)
                </label>
                <input type="text" id="totalBiaya" readonly class="form-control"
                       style="height: 46px; border-radius: var(--en-r); background: var(--en-primary-soft);
                              border: 2px solid var(--en-primary-light); font-weight: 800; color: var(--en-primary-dark);"
                       value="Rp 0">
            </div>
        </div>
    </div>

    <!-- RUNDOWN -->
    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-list-check me-2" style="color: var(--en-primary);"></i> Rundown / Susunan Acara</h3>
        </div>
        <?php
            $rundownText = '';
            if (!empty($ai['rundown'])) {
                $rundownText = is_array($ai['rundown']) ? implode("\n", $ai['rundown']) : $ai['rundown'];
            }
        ?>
        <textarea name="rundown" rows="6" class="form-control"
                  style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                  placeholder="08:00 - Pembukaan&#10;08:30 - Sambutan&#10;09:00 - Acara Inti"><?= old('rundown', $rundownText) ?></textarea>
        <small style="color: var(--en-muted); font-size: 11px; display: block; margin-top: 6px;">
            <i class="bi bi-info-circle"></i> Tulis satu item per baris
        </small>
    </div>

    <!-- TOMBOL -->
    <div class="en-card" style="display: flex; gap: 12px;">
        <button type="submit" class="en-btn en-btn-primary en-btn-lg">
            <i class="bi bi-save-fill"></i> Simpan Event
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