<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-building-fill me-2" style="color: var(--en-primary);"></i> Kelola Gedung</h3>
            <p>Kelola data gedung/fasilitas untuk kegiatan</p>
        </div>
        <a href="<?= site_url('admin/gedung/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Gedung
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill" style="font-size: 20px;"></i>
        <strong><?= session()->getFlashdata('success') ?></strong>
    </div>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-building"></i></div>
        </div>
        <div class="en-stat__val"><?= count($gedung ?? []) ?></div>
        <div class="en-stat__lbl">Total Gedung</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_pending ?? 0 ?></div>
        <div class="en-stat__lbl">Butuh Validasi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-calendar-check"></i></div>
        </div>
        <div class="en-stat__val"><?= $booking_hari_ini ?? 0 ?></div>
        <div class="en-stat__lbl">Booking Hari Ini</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #A855F7, #7E22CE);"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
        <div class="en-stat__val"><?= $booking_bulan_ini ?? 0 ?></div>
        <div class="en-stat__lbl">Bulan Ini</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Gedung (<?= count($gedung ?? []) ?>)</h3>
    </div>

    <?php if (!empty($gedung)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 60px;">#</th>
                        <th>Nama Gedung</th>
                        <th style="text-align: center; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($gedung as $g): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 42px; height: 42px; border-radius: 11px;
                                                background: var(--en-grad-primary); color: white;
                                                display: flex; align-items: center; justify-content: center; font-size: 18px;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                    <strong style="color: var(--en-dark); font-size: 14px;">
                                        <?= esc($g['nama_gedung']) ?>
                                    </strong>
                                </div>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('admin/gedung/edit/' . $g['id_gedung']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('admin/gedung/hapus/' . $g['id_gedung']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus gedung ini?')"
                                   class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);" title="Hapus">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-building"></i>
            <h5>Belum Ada Gedung</h5>
            <p>Mulai tambahkan data gedung/fasilitas untuk kegiatan.</p>
            <a href="<?= site_url('admin/gedung/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Tambah Gedung Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>