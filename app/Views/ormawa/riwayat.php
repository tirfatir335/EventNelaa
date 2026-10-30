<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-clock-history me-2" style="color: var(--en-primary);"></i> Riwayat Kegiatan</h3>
            <p>Lihat riwayat semua pengajuan event ormawa kamu</p>
        </div>
    </div>
</div>

<?php
    $totalSemua     = count($total_pengajuan ?? []);
    $totalDisetujui = count($disetujui ?? []);
    $totalDitolak   = count($ditolak ?? []);
    $totalPending   = $totalSemua - $totalDisetujui - $totalDitolak;
?>

<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-file-earmark-text-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalSemua ?></div>
        <div class="en-stat__lbl">Total Pengajuan</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalDisetujui ?></div>
        <div class="en-stat__lbl">Disetujui</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalDitolak ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $totalPending ?></div>
        <div class="en-stat__lbl">Sedang Proses</div>
    </div>
</div>

<div class="en-card">
    <div class="en-card__head">
        <h3>Semua Riwayat</h3>
    </div>

    <?php if (!empty($total_pengajuan)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Event</th>
                        <th style="width: 130px;">Tanggal</th>
                        <th style="width: 180px;">Gedung</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 80px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($total_pengajuan as $e):
                        $status = $e['status'];
                        $badgeMap = [
                            'Published'          => ['cls' => 'en-badge-success', 'lbl' => 'Disetujui'],
                            'Rejected Admin'     => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
                            'Rejected Validator' => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak'],
                            'Pending Admin'      => ['cls' => 'en-badge-warning', 'lbl' => 'Pending'],
                            'Pending Validator'  => ['cls' => 'en-badge-warning', 'lbl' => 'Pending'],
                        ];
                        $b = $badgeMap[$status] ?? ['cls' => 'en-badge-muted', 'lbl' => $status];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="color: var(--en-dark);"><?= esc($e['nama_event']) ?></strong></td>
                            <td>
                                <i class="bi bi-calendar3" style="color: var(--en-primary);"></i>
                                <?= date('d M Y', strtotime($e['tanggal'])) ?>
                            </td>
                            <td><?= esc($e['gedung'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" target="_blank"
                                   class="en-btn en-btn-light en-btn-sm" title="Lihat Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-clock-history"></i>
            <h5>Belum Ada Riwayat</h5>
            <p>Belum ada riwayat pengajuan event dari ormawa kamu.</p>
            <a href="<?= site_url('ormawa/kegiatan/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Ajukan Event Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>