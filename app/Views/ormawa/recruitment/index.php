<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-megaphone-fill me-2" style="color: var(--en-primary);"></i> Open Recruitment</h3>
            <p>Kelola pengumuman rekrutmen anggota baru ormawa</p>
        </div>
        <a href="<?= site_url('ormawa/recruitment/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Buat Recruitment
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
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
$totalRec = count($recruitments ?? []);
$cntOpen = count(array_filter($recruitments ?? [], fn($r) => ($r['status'] ?? '') === 'open'));
$cntClosed = $totalRec - $cntOpen;
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-megaphone-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalRec ?></div>
        <div class="en-stat__lbl">Total Recruitment</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-unlock-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntOpen ?></div>
        <div class="en-stat__lbl">Sedang Buka</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #999, #666);"><i class="bi bi-lock-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $cntClosed ?></div>
        <div class="en-stat__lbl">Sudah Tutup</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="en-stat__val">-</div>
        <div class="en-stat__lbl">Total Pendaftar</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Recruitment</h3>
    </div>

    <?php if (!empty($recruitments)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Judul Recruitment</th>
                        <th style="width: 130px;">Posisi</th>
                        <th style="width: 130px;">Periode</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($recruitments as $r): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color: var(--en-dark); font-size: 14px;"><?= esc($r['judul']) ?></strong>
                            </td>
                            <td><span class="en-badge en-badge-info"><?= esc($r['posisi'] ?? '-') ?></span></td>
                            <td style="color: var(--en-text); font-size: 13px;"><?= esc($r['periode'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <?php if ($r['status'] === 'open'): ?>
                                    <span class="en-badge en-badge-success"><i class="bi bi-unlock-fill"></i> Open</span>
                                <?php else: ?>
                                    <span class="en-badge en-badge-muted"><i class="bi bi-lock-fill"></i> Closed</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('ormawa/recruitment/pendaftar/' . $r['id_recruitment']) ?>"
                                   class="en-btn en-btn-primary en-btn-sm" title="Lihat Pendaftar">
                                    <i class="bi bi-people-fill"></i>
                                </a>
                                <a href="<?= site_url('recruitment/detail/' . $r['id_recruitment']) ?>"
                                   target="_blank" class="en-btn en-btn-light en-btn-sm" title="Preview">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('ormawa/recruitment/edit/' . $r['id_recruitment']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('ormawa/recruitment/hapus/' . $r['id_recruitment']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus recruitment ini?')"
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
            <i class="bi bi-megaphone"></i>
            <h5>Belum Ada Recruitment</h5>
            <p>Buat pengumuman rekrutmen anggota baru untuk ormawa kamu.</p>
            <a href="<?= site_url('ormawa/recruitment/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Buat Recruitment Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>