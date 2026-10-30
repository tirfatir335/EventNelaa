<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-person-badge-fill me-2" style="color: var(--en-primary);"></i> Kelola Pembina</h3>
            <p>Akun pembina UKM & Ormawa</p>
        </div>
        <a href="<?= site_url('validator/dosen/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-person-plus-fill"></i> Tambah Pembina
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

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-person-badge-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= count($pembina ?? []) ?></div>
        <div class="en-stat__lbl">Total Pembina</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= count(array_filter($pembina ?? [], fn($p) => !empty($p['nama_ormawa']))) ?></div>
        <div class="en-stat__lbl">Sudah Dapet Ormawa</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= count(array_filter($pembina ?? [], fn($p) => empty($p['nama_ormawa']))) ?></div>
        <div class="en-stat__lbl">Belum Assign</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Pembina</h3>
    </div>

    <?php if (!empty($pembina)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>NIP</th>
                        <th>Nama Pembina</th>
                        <th>Username</th>
                        <th>Ormawa Dibina</th>
                        <th>Email</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pembina as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <code style="background: var(--en-bg-alt); padding: 4px 8px;
                                             border-radius: 6px; font-size: 12px;">
                                    <?= esc($p['nip'] ?? '-') ?>
                                </code>
                            </td>
                            <td><strong style="color: var(--en-dark);"><?= esc($p['nama_dosen'] ?? '-') ?></strong></td>
                            <td style="font-size: 13px;"><?= esc($p['username']) ?></td>
                            <td>
                                <?php if (!empty($p['nama_ormawa'])): ?>
                                    <span class="en-badge en-badge-primary"><?= esc($p['nama_ormawa']) ?></span>
                                <?php else: ?>
                                    <span style="color: var(--en-muted); font-size: 12px;">-</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 12.5px;"><?= esc($p['email']) ?></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('validator/dosen/edit/' . $p['id_dosen']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('validator/dosen/hapus/' . $p['id_dosen']) ?>"
                                   onclick="return confirm('Yakin hapus pembina ini? Akun login-nya juga akan dihapus.')"
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
            <i class="bi bi-person-badge"></i>
            <h5>Belum Ada Pembina</h5>
            <p>Tambahkan akun pembina untuk UKM/Ormawa.</p>
            <a href="<?= site_url('validator/dosen/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-person-plus-fill"></i> Tambah Pembina
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>