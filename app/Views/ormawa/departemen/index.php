<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-diagram-3-fill me-2" style="color: var(--en-primary);"></i> Departemen / Divisi</h3>
            <p>Kelola departemen atau divisi dalam ormawa kamu</p>
        </div>
        <a href="<?= site_url('ormawa/departemen/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Departemen
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
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Departemen (<?= count($departemen ?? []) ?>)</h3>
    </div>

    <?php if (!empty($departemen)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Departemen</th>
                        <th>Deskripsi / Tugas Pokok</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($departemen as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <?php
                                        $warna = !empty($d['warna']) ? $d['warna'] : '#FF7A00';
                                        $ikon  = !empty($d['ikon']) ? $d['ikon'] : 'diagram-3-fill';
                                    ?>
                                    <div style="width: 40px; height: 40px; border-radius: 10px;
                                                background: <?= $warna ?>; color: white;
                                                display: flex; align-items: center; justify-content: center;
                                                font-size: 18px;">
                                        <i class="bi bi-<?= esc($ikon) ?>"></i>
                                    </div>
                                    <strong style="color: var(--en-dark);"><?= esc($d['nama_departemen']) ?></strong>
                                </div>
                            </td>
                            <td style="color: var(--en-text); font-size: 13px;"><?= esc($d['deskripsi'] ?? '-') ?></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('ormawa/departemen/edit/' . $d['id_departemen']) ?>"
                                   class="en-btn en-btn-light en-btn-sm"><i class="bi bi-pencil"></i></a>
                                <a href="<?= site_url('ormawa/departemen/hapus/' . $d['id_departemen']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus departemen ini?')"
                                   class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);">
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
            <i class="bi bi-diagram-3"></i>
            <h5>Belum Ada Departemen</h5>
            <p>Tambahkan departemen atau divisi untuk melengkapi struktur ormawa.</p>
            <a href="<?= site_url('ormawa/departemen/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Tambah Departemen Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>