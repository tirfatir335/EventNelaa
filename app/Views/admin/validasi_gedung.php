<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-check2-square me-2" style="color: var(--en-primary);"></i> Validasi Gedung</h3>
            <p>Cek ketersediaan gedung sebelum event diteruskan ke Validator</p>
        </div>
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
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= count($pending ?? []) ?></div>
        <div class="en-stat__lbl">Menunggu Validasi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= count($selesai ?? []) ?></div>
        <div class="en-stat__lbl">Selesai Divalidasi</div>
    </div>
</div>

<!-- PENDING -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-exclamation-triangle-fill me-2" style="color: var(--en-primary);"></i> Menunggu Validasi (<?= count($pending ?? []) ?>)</h3>
    </div>

    <?php if (!empty($pending)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Event</th>
                        <th>Ormawa</th>
                        <th style="width: 120px;">Tanggal</th>
                        <th style="width: 80px;">Waktu</th>
                        <th style="width: 150px;">Gedung</th>
                        <th style="text-align: center; width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($pending as $e): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="color: var(--en-dark);"><?= esc($e['nama_event']) ?></strong></td>
                            <td style="font-size: 13px;"><?= esc($e['nama_ormawa'] ?? '-') ?></td>
                            <td style="font-size: 13px;"><?= date('d M Y', strtotime($e['tanggal'])) ?></td>
                            <td style="font-size: 13px;"><?= esc($e['waktu'] ?? '-') ?></td>
                            <td><strong style="font-size: 13px;"><?= esc($e['gedung'] ?? '-') ?></strong></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('admin/validasi/detail/' . $e['id_event']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('admin/validasi/approve/' . $e['id_event']) ?>"
                                   onclick="return confirm('Setujui gedung & teruskan ke Validator?')"
                                   class="en-btn en-btn-primary en-btn-sm" title="Setuju">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                                <a href="<?= site_url('admin/validasi/reject/' . $e['id_event']) ?>"
                                   onclick="return confirm('Tolak event ini?')"
                                   class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);" title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-check2-circle"></i>
            <h5>Tidak Ada Event Pending</h5>
            <p>Semua event sudah divalidasi gedungnya.</p>
        </div>
    <?php endif; ?>
</div>

<!-- SELESAI -->
<div class="en-card">
    <div class="en-card__head">
        <h3><i class="bi bi-clock-history me-2" style="color: var(--en-primary);"></i> Riwayat Validasi Gedung</h3>
    </div>

    <?php if (!empty($selesai)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Event</th>
                        <th>Ormawa</th>
                        <th style="width: 120px;">Tanggal</th>
                        <th style="width: 150px;">Gedung</th>
                        <th style="text-align: center; width: 130px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($selesai as $e):
                        $status = $e['status'];
                        $badgeMap = [
                            'Published'          => ['cls' => 'en-badge-success', 'lbl' => 'Published'],
                            'Pending Validator'  => ['cls' => 'en-badge-info',    'lbl' => 'Diteruskan'],
                            'Rejected Admin'     => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak Admin'],
                            'Rejected Validator' => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak Validator'],
                        ];
                        $b = $badgeMap[$status] ?? ['cls' => 'en-badge-muted', 'lbl' => $status];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="color: var(--en-dark);"><?= esc($e['nama_event']) ?></strong></td>
                            <td style="font-size: 13px;"><?= esc($e['nama_ormawa'] ?? '-') ?></td>
                            <td style="font-size: 13px;"><?= date('d M Y', strtotime($e['tanggal'])) ?></td>
                            <td style="font-size: 13px;"><?= esc($e['gedung'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-inbox"></i>
            <h5>Belum Ada Riwayat</h5>
            <p>Belum ada event yang divalidasi.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>