<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Pengurus Ormawa</h3>
            <p>Kelola struktur kepengurusan ormawa kamu</p>
        </div>
        <a href="<?= site_url('ormawa/pengurus/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-person-plus-fill"></i> Tambah Pengurus
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

<?php
$pimpinanInti = array_filter($pengurus ?? [], fn($p) => in_array($p['level'] ?? 0, [1,2,3]));
$kadep = array_filter($pengurus ?? [], fn($p) => ($p['level'] ?? 0) == 4);
$total = count($pengurus ?? []);
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-people-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total ?></div>
        <div class="en-stat__lbl">Total Pengurus</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-star-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= count($pimpinanInti) ?></div>
        <div class="en-stat__lbl">Pimpinan Inti</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-diagram-3-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= count($kadep) ?></div>
        <div class="en-stat__lbl">Kadep</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #A855F7, #7E22CE);"><i class="bi bi-person-badge"></i></div>
        </div>
        <div class="en-stat__val"><?= $total - count($pimpinanInti) - count($kadep) ?></div>
        <div class="en-stat__lbl">Staf / Anggota</div>
    </div>
</div>

<?php if (!empty($pimpinanInti)): ?>
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3>⭐ Pimpinan Inti</h3>
    </div>
    <div class="row g-3">
        <?php foreach ($pimpinanInti as $p): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div style="background: var(--en-grad-primary-soft); border-radius: var(--en-r);
                            padding: 20px 14px; text-align: center; height: 100%;
                            border: 2px solid var(--en-primary-light);">
                    <?php if (!empty($p['foto']) && file_exists('uploads/pengurus/' . $p['foto'])): ?>
                        <img src="<?= base_url('uploads/pengurus/' . $p['foto']) ?>"
                             style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;
                                    border: 4px solid white; margin-bottom: 12px;">
                    <?php else: ?>
                        <div style="width: 80px; height: 80px; border-radius: 50%;
                                    background: var(--en-grad-primary); color: white;
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: 32px; margin: 0 auto 12px; border: 4px solid white;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    <?php endif; ?>

                    <h5 style="font-size: 14px; font-weight: 800; color: var(--en-dark); margin: 0 0 6px;">
                        <?= esc($p['nama']) ?>
                    </h5>
                    <span class="en-badge en-badge-primary"><?= esc($p['jabatan']) ?></span>

                    <div style="display: flex; justify-content: center; gap: 6px;
                                margin-top: 12px; padding-top: 12px; border-top: 1px solid var(--en-primary-light);">
                        <a href="<?= site_url('ormawa/pengurus/edit/' . $p['id_pengurus']) ?>"
                           class="en-btn en-btn-light en-btn-sm" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="<?= site_url('ormawa/pengurus/hapus/' . $p['id_pengurus']) ?>"
                           onclick="return confirm('Hapus pengurus ini?')"
                           class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($kadep)): ?>
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3>🏢 Kepala Departemen</h3>
    </div>
    <div class="row g-3">
        <?php foreach ($kadep as $p): ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="en-card" style="text-align: center; padding: 18px 14px;">
                    <?php if (!empty($p['foto']) && file_exists('uploads/pengurus/' . $p['foto'])): ?>
                        <img src="<?= base_url('uploads/pengurus/' . $p['foto']) ?>"
                             style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; margin-bottom: 10px;">
                    <?php else: ?>
                        <div style="width: 70px; height: 70px; border-radius: 50%;
                                    background: var(--en-primary-soft); color: var(--en-primary);
                                    display: flex; align-items: center; justify-content: center;
                                    font-size: 28px; margin: 0 auto 10px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                    <?php endif; ?>
                    <h5 style="font-size: 13.5px; font-weight: 700; color: var(--en-dark); margin: 0 0 4px;">
                        <?= esc($p['nama']) ?>
                    </h5>
                    <small style="color: var(--en-primary); font-weight: 700; font-size: 11px;">
                        <?= esc($p['jabatan']) ?>
                    </small>
                    <div style="display: flex; justify-content: center; gap: 6px;
                                margin-top: 10px; padding-top: 10px; border-top: 1px solid var(--en-border);">
                        <a href="<?= site_url('ormawa/pengurus/edit/' . $p['id_pengurus']) ?>"
                           class="en-btn en-btn-light en-btn-sm"><i class="bi bi-pencil"></i></a>
                        <a href="<?= site_url('ormawa/pengurus/hapus/' . $p['id_pengurus']) ?>"
                           onclick="return confirm('Hapus pengurus ini?')"
                           class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="en-card">
    <div class="en-card__head">
        <h3>📋 Semua Pengurus (<?= $total ?>)</h3>
    </div>

    <?php if (!empty($pengurus)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama</th>
                        <th>NPM</th>
                        <th>Jabatan</th>
                        <th>Level</th>
                        <th style="text-align: center; width: 100px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $no = 1;
                        $levelLabel = [1=>'Ketum', 2=>'Waketum', 3=>'Sekum/Bendum', 4=>'Kadep', 5=>'Wakadep', 6=>'Staf'];
                        foreach ($pengurus as $p):
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="color: var(--en-dark);"><?= esc($p['nama']) ?></strong></td>
                            <td><?= esc($p['npm'] ?? '-') ?></td>
                            <td><?= esc($p['jabatan']) ?></td>
                            <td><span class="en-badge en-badge-primary"><?= $levelLabel[$p['level'] ?? 0] ?? '-' ?></span></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('ormawa/pengurus/edit/' . $p['id_pengurus']) ?>"
                                   class="en-btn en-btn-light en-btn-sm"><i class="bi bi-pencil"></i></a>
                                <a href="<?= site_url('ormawa/pengurus/hapus/' . $p['id_pengurus']) ?>"
                                   onclick="return confirm('Hapus pengurus ini?')"
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
            <i class="bi bi-people"></i>
            <h5>Belum Ada Pengurus</h5>
            <p>Mulai tambahkan pengurus untuk melengkapi struktur ormawa.</p>
            <a href="<?= site_url('ormawa/pengurus/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-person-plus-fill"></i> Tambah Pengurus Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>