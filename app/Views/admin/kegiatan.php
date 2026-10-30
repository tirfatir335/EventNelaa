<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-journal-text me-2" style="color: var(--en-primary);"></i> Kelola Event</h3>
            <p>Kelola dan verifikasi semua event dari UKM & Ormawa</p>
        </div>
    </div>
</div>

<?php
$totalSemua = count($total ?? []);
$totalPending = count(array_filter($total ?? [], fn($e) => $e['status'] === 'Pending Admin'));
$totalPublished = count(array_filter($total ?? [], fn($e) => $e['status'] === 'Published'));
$totalRejected = count(array_filter($total ?? [], fn($e) => in_array($e['status'], ['Rejected Admin','Rejected Validator'])));
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-journal-text"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalSemua ?></div>
        <div class="en-stat__lbl">Total Event</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalPending ?></div>
        <div class="en-stat__lbl">Pending</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalPublished ?></div>
        <div class="en-stat__lbl">Published</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalRejected ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Event</h3>
    </div>

    <?php if (!empty($total)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Event</th>
                        <th>Ormawa</th>
                        <th style="width: 120px;">Tanggal</th>
                        <th style="width: 150px;">Gedung</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($total as $e):
                        $status = $e['status'];
                        $badgeMap = [
                            'Published'          => ['cls' => 'en-badge-success', 'lbl' => 'Published'],
                            'Pending Admin'      => ['cls' => 'en-badge-warning', 'lbl' => 'Pending'],
                            'Pending Validator'  => ['cls' => 'en-badge-info',    'lbl' => 'Validasi'],
                            'Rejected Admin'     => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
                            'Rejected Validator' => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
                        ];
                        $b = $badgeMap[$status] ?? ['cls' => 'en-badge-muted', 'lbl' => $status];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong style="color: var(--en-dark); font-size: 14px;"><?= esc($e['nama_event']) ?></strong>
                                <br>
                                <small style="color: var(--en-muted); font-size: 11px;">
                                    <?= esc(substr(strip_tags($e['deskripsi'] ?? ''), 0, 50)) ?>...
                                </small>
                            </td>
                            <td><span class="en-badge en-badge-info"><?= esc($e['nama_ormawa'] ?? '-') ?></span></td>
                            <td style="font-size: 13px;">
                                <i class="bi bi-calendar3" style="color: var(--en-primary);"></i>
                                <?= date('d M Y', strtotime($e['tanggal'])) ?>
                            </td>
                            <td style="font-size: 13px;"><?= esc($e['gedung'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" target="_blank"
                                   class="en-btn en-btn-light en-btn-sm" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('admin/kegiatan/validasi/' . $e['id_event']) ?>"
                                   class="en-btn en-btn-primary en-btn-sm" title="Validasi">
                                    <i class="bi bi-check2-square"></i>
                                </a>
                                <a href="<?= site_url('admin/hapusEvent/' . $e['id_event']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus event ini?')"
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
            <i class="bi bi-journal-x"></i>
            <h5>Belum Ada Event</h5>
            <p>Belum ada event yang diajukan oleh UKM/Ormawa.</p>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>