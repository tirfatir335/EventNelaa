<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Kelola Ormawa</h3>
            <p>Kelola akun UKM & HMJ di Polinela</p>
        </div>
        <a href="<?= site_url('validator/ormawa/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Ormawa
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-success); background: var(--en-success-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #15803D;">
        <i class="bi bi-check-circle-fill"></i><strong><?= session()->getFlashdata('success') ?></strong>
    </div>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
$total = count($organisasi ?? []);
$cntAktif = count(array_filter($organisasi ?? [], fn($o) => ($o['status'] ?? '') === 'Aktif'));
$cntHMJ = count(array_filter($organisasi ?? [], fn($o) => ($o['kategori'] ?? '') === 'HMJ'));
$cntUKM = count(array_filter($organisasi ?? [], fn($o) => ($o['kategori'] ?? '') === 'UKM'));
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total ?></div>
        <div class="en-stat__lbl">Total Ormawa</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntAktif ?></div>
        <div class="en-stat__lbl">Aktif</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-mortarboard-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntHMJ ?></div>
        <div class="en-stat__lbl">HMJ</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-award-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntUKM ?></div>
        <div class="en-stat__lbl">UKM</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Ormawa (<?= $total ?>)</h3>
    </div>

    <?php if (!empty($organisasi)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Ormawa</th>
                        <th style="width: 90px;">Kategori</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Pembina</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($organisasi as $o): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <?php if (!empty($o['logo']) && file_exists('uploads/logo/' . $o['logo'])): ?>
                                        <img src="<?= base_url('uploads/logo/' . $o['logo']) ?>"
                                             style="width: 38px; height: 38px; border-radius: 50%; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 38px; height: 38px; border-radius: 50%;
                                                    background: var(--en-grad-primary); color: white;
                                                    display: flex; align-items: center; justify-content: center; font-size: 15px;">
                                            <i class="bi bi-building"></i>
                                        </div>
                                    <?php endif; ?>
                                    <strong style="color: var(--en-dark); font-size: 13.5px;"><?= esc($o['nama_ormawa']) ?></strong>
                                </div>
                            </td>
                            <td>
                                <span class="en-badge en-badge-primary"><?= esc($o['kategori'] ?? '-') ?></span>
                            </td>
                            <td style="font-size: 13px;"><?= esc($o['username'] ?? '-') ?></td>
                            <td style="font-size: 12.5px;"><?= esc($o['email'] ?? '-') ?></td>
                            <td style="font-size: 12.5px;"><?= esc($o['pembina'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <?php if (($o['status'] ?? '') === 'Aktif'): ?>
                                    <span class="en-badge en-badge-success">Aktif</span>
                                <?php else: ?>
                                    <span class="en-badge en-badge-danger">Tidak Aktif</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('validator/ormawa/edit/' . $o['id_ormawa']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('validator/ormawa/hapus/' . $o['id_ormawa']) ?>"
                                   onclick="return confirm('Yakin ingin hapus ormawa ini?')"
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
            <i class="bi bi-people"></i>
            <h5>Belum Ada Ormawa</h5>
            <p>Mulai tambahkan akun UKM/HMJ baru.</p>
            <a href="<?= site_url('validator/ormawa/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Tambah Ormawa Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>