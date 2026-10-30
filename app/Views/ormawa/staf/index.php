<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Kelola Staf</h3>
            <p>Tambah staf untuk membantu mengelola ormawa kamu</p>
        </div>
        <a href="<?= site_url('ormawa/staf/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-person-plus-fill"></i> Tambah Staf
        </a>
    </div>
</div>

<div class="en-card mb-4" style="background: var(--en-info-soft); border-left: 4px solid var(--en-info);">
    <div style="display: flex; gap: 12px;">
        <i class="bi bi-info-circle-fill" style="font-size: 22px; color: #1D4ED8;"></i>
        <div style="font-size: 13.5px; color: var(--en-text); line-height: 1.6;">
            <strong>Tentang Staf:</strong> Staf adalah user yang membantu mengelola ormawa kamu.
            Kamu bisa mengatur modul apa saja yang boleh mereka akses (galeri, berita, progja, dll).
        </div>
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
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Staf (<?= count($staf ?? []) ?>)</h3>
    </div>

    <?php if (!empty($staf)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Modul Akses</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($staf as $s): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 38px; height: 38px; border-radius: 50%;
                                                background: var(--en-grad-primary); color: white;
                                                display: flex; align-items: center; justify-content: center;
                                                font-size: 15px; font-weight: 800;">
                                        <?= strtoupper(substr($s['username'], 0, 1)) ?>
                                    </div>
                                    <strong style="color: var(--en-dark);"><?= esc($s['username']) ?></strong>
                                </div>
                            </td>
                            <td style="font-size: 13px;"><?= esc($s['email']) ?></td>
                            <td style="font-size: 13px;"><?= esc($s['no_telp'] ?? '-') ?></td>
                            <td>
                                <?php if (!empty($s['permissions'])): ?>
                                    <div style="display: flex; flex-wrap: wrap; gap: 4px;">
                                        <?php foreach ($s['permissions'] as $p): ?>
                                            <span class="en-badge en-badge-info"><?= ucfirst($p['module']) ?></span>
                                        <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: var(--en-muted); font-style: italic; font-size: 12px;">Belum ada akses</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('ormawa/staf/edit/' . $s['id']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('ormawa/staf/hapus/' . $s['id']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus staf ini?')"
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
            <h5>Belum Ada Staf</h5>
            <p>Tambahkan staf untuk membantu mengelola ormawa kamu.</p>
            <a href="<?= site_url('ormawa/staf/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-person-plus-fill"></i> Tambah Staf Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>