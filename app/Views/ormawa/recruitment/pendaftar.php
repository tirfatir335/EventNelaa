<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Pendaftar Recruitment</h3>
            <p><?= esc($recruitment['judul']) ?></p>
        </div>
        <a href="<?= site_url('ormawa/recruitment') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill"></i>
        <strong><?= session()->getFlashdata('success') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid #DC2626; background: #FEE2E2;">
    <div style="display: flex; align-items: center; gap: 10px; color: #991B1B;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
$cntPending = count(array_filter($pendaftar ?? [], fn($p) => ($p['status_pendaftaran'] ?? '') === 'pending'));
$cntTes     = count(array_filter($pendaftar ?? [], fn($p) => ($p['status_pendaftaran'] ?? '') === 'tes_tertulis'));
$cntWaw     = count(array_filter($pendaftar ?? [], fn($p) => ($p['status_pendaftaran'] ?? '') === 'wawancara'));
$cntTerima  = count(array_filter($pendaftar ?? [], fn($p) => ($p['status_pendaftaran'] ?? '') === 'diterima'));
$cntTolak   = count(array_filter($pendaftar ?? [], fn($p) => ($p['status_pendaftaran'] ?? '') === 'ditolak'));
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= count($pendaftar ?? []) ?></div>
        <div class="en-stat__lbl">Total Pendaftar</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntPending ?></div>
        <div class="en-stat__lbl">Pending</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-pencil-square"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntTes + $cntWaw ?></div>
        <div class="en-stat__lbl">Proses Seleksi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-trophy-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntTerima ?></div>
        <div class="en-stat__lbl">Diterima</div>
    </div>
</div>

<!-- FORM BULK: di luar tabel, checkbox-nya ikut form ini lewat atribut form="bulkForm" -->
<form id="bulkForm" action="<?= site_url('ormawa/recruitment/update-bulk') ?>" method="post">
    <?= csrf_field() ?>

    <div class="en-card mb-4">
        <div class="en-card__head">
            <h3><i class="bi bi-lightning-charge-fill me-2" style="color: var(--en-primary);"></i> Aksi Massal</h3>
        </div>

        <div style="background: var(--en-primary-soft); padding: 16px 20px; display: flex; gap: 12px; flex-wrap: wrap; align-items: flex-end;">
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Ubah Status Menjadi:</label>
                <select name="status_bulk" class="form-select form-select-sm" style="min-width: 180px;" required>
                    <option value="">-- Pilih Status --</option>
                    <option value="pending">⏳ Pending</option>
                    <option value="tes_tertulis">📝 Tes Tertulis</option>
                    <option value="wawancara">💬 Wawancara</option>
                    <option value="diterima">✅ Diterima</option>
                    <option value="ditolak">❌ Ditolak</option>
                </select>
            </div>

            <div style="flex: 1; min-width: 200px;">
                <label style="display: block; font-size: 12px; font-weight: 700; margin-bottom: 4px;">Catatan Tambahan (Opsional):</label>
                <input type="text" name="catatan_bulk" class="form-control form-control-sm"
                       placeholder="Misal: Jadwal tes Senin, 9 Pagi">
            </div>

            <div>
                <button type="submit" class="en-btn en-btn-primary"
                        onclick="return confirm('Yakin ingin mengubah status pendaftar yang dicentang?')">
                    <i class="bi bi-lightning-charge-fill"></i> Terapkan ke yang Dipilih
                </button>
            </div>
        </div>
    </div>
</form>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Pendaftar</h3>
    </div>

    <?php if (!empty($pendaftar)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px; text-align: center;">
                            <input type="checkbox" id="selectAll"
                                   style="width: 16px; height: 16px; accent-color: var(--en-primary); cursor: pointer;">
                        </th>
                        <th style="width: 40px;">#</th>
                        <th>Nama</th>
                        <th>NIM</th>
                        <th>Prodi</th>
                        <th>Kontak</th>
                        <th style="width: 240px;">Status & Catatan (Individu)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pendaftar as $p): ?>
                        <tr>
                            <td style="text-align: center;">
                                <!-- checkbox ikut form bulk di atas -->
                                <input type="checkbox"
                                       name="ids[]"
                                       value="<?= $p['id_pendaftar'] ?>"
                                       form="bulkForm"
                                       class="row-checkbox"
                                       style="width: 16px; height: 16px; accent-color: var(--en-primary); cursor: pointer;">
                            </td>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color: var(--en-dark); font-size: 14px;"><?= esc($p['nama_lengkap']) ?></strong>
                                <?php if (!empty($p['alasan'])): ?>
                                    <br>
                                    <small style="color: var(--en-muted); font-size: 11px;">
                                        <i class="bi bi-chat-left-text"></i>
                                        <?= esc(substr($p['alasan'], 0, 50)) ?>...
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td><?= esc($p['nim']) ?></td>
                            <td><?= esc($p['prodi'] ?? '-') ?></td>
                            <td>
                                <a href="https://wa.me/<?= str_replace(['+', ' ', '-'], '', $p['no_hp'] ?? '') ?>"
                                   target="_blank" style="color: #25d366; text-decoration: none; font-weight: 600; font-size: 13px;">
                                    <i class="bi bi-whatsapp"></i> <?= esc($p['no_hp'] ?? '-') ?>
                                </a>
                                <div style="font-size: 11px; color: var(--en-muted);"><?= esc($p['email']) ?></div>
                            </td>
                            <td>
                                <!-- form individu tetap aman, tidak nested dengan form bulk -->
                                <form action="<?= site_url('ormawa/recruitment/update-status/' . $p['id_pendaftar']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <select name="status_pendaftaran" class="form-select form-select-sm"
                                            style="font-size: 12px; margin-bottom: 6px; border-radius: 8px;">
                                        <option value="pending"      <?= $p['status_pendaftaran'] == 'pending'      ? 'selected' : '' ?>>⏳ Pending</option>
                                        <option value="tes_tertulis" <?= $p['status_pendaftaran'] == 'tes_tertulis' ? 'selected' : '' ?>>📝 Tes Tertulis</option>
                                        <option value="wawancara"    <?= $p['status_pendaftaran'] == 'wawancara'    ? 'selected' : '' ?>>💬 Wawancara</option>
                                        <option value="diterima"     <?= $p['status_pendaftaran'] == 'diterima'     ? 'selected' : '' ?>>✅ Diterima</option>
                                        <option value="ditolak"      <?= $p['status_pendaftaran'] == 'ditolak'      ? 'selected' : '' ?>>❌ Ditolak</option>
                                    </select>
                                    <textarea name="catatan_admin" class="form-control form-control-sm"
                                              rows="2" style="font-size: 11px; margin-bottom: 6px; border-radius: 8px;"
                                              placeholder="Catatan (jadwal tes, CP, dll)"><?= esc($p['catatan_admin'] ?? '') ?></textarea>
                                    <button type="submit" class="en-btn en-btn-primary en-btn-sm" style="width: 100%;">
                                        <i class="bi bi-save"></i> Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-person-x"></i>
            <h5>Belum Ada Pendaftar</h5>
            <p>Belum ada mahasiswa yang mendaftar pada recruitment ini.</p>
        </div>
    <?php endif; ?>
</div>

<script>
document.getElementById('selectAll')?.addEventListener('change', function () {
    document.querySelectorAll('.row-checkbox').forEach(cb => {
        cb.checked = this.checked;
    });
});
</script>

<?= $this->endSection() ?>