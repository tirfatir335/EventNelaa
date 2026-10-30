<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-calendar-event-fill me-2" style="color: var(--en-primary);"></i> Kelola Event</h3>
            <p>Kelola dan pantau semua event ormawa kamu</p>
        </div>
        <a href="<?= site_url('ormawa/kegiatan/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-plus-circle-fill"></i> Tambah Event
        </a>
    </div>
</div>

<!-- FLASH -->
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

<!-- STATISTIK MINI -->
<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);">
                <i class="bi bi-calendar-event-fill"></i>
            </div>
        </div>
        <div class="en-stat__val"><?= $total_event ?? 0 ?></div>
        <div class="en-stat__lbl">Total Event</div>
    </div>

    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>
        <div class="en-stat__val"><?= $total_published ?? 0 ?></div>
        <div class="en-stat__lbl">Published</div>
    </div>

    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <i class="bi bi-hourglass-split"></i>
            </div>
        </div>
        <div class="en-stat__val"><?= $total_pending ?? 0 ?></div>
        <div class="en-stat__lbl">Pending</div>
    </div>

    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);">
                <i class="bi bi-x-circle-fill"></i>
            </div>
        </div>
        <div class="en-stat__val"><?= $total_rejected ?? 0 ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
</div>

<!-- TABEL EVENT -->
<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Event</h3>
    </div>

    <?php if (!empty($events)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Event</th>
                        <th>Tanggal</th>
                        <th>Gedung</th>
                        <th>Status</th>
                        <th style="text-align: center; width: 180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($events as $e): ?>
                        <?php
                            $status = $e['status'];
                            $badgeMap = [
                                'Published'          => ['cls' => 'en-badge-success', 'lbl' => 'Published'],
                                'Pending Admin'      => ['cls' => 'en-badge-warning', 'lbl' => 'Pending Admin'],
                                'Pending Validator'  => ['cls' => 'en-badge-info',    'lbl' => 'Menunggu Validator'],
                                'Rejected Admin'     => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak Admin'],
                                'Rejected Validator' => ['cls' => 'en-badge-danger',  'lbl' => 'Ditolak Validator'],
                            ];
                            $badge = $badgeMap[$status] ?? ['cls' => 'en-badge-muted', 'lbl' => $status];
                            $perluReport = ($status === 'Published' && $e['tanggal'] <= date('Y-m-d'));
                        ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <?php if (!empty($e['poster']) && file_exists('uploads/poster/' . $e['poster'])): ?>
                                        <img src="<?= base_url('uploads/poster/' . $e['poster']) ?>"
                                             style="width: 42px; height: 42px; border-radius: 10px; object-fit: cover;">
                                    <?php else: ?>
                                        <div style="width: 42px; height: 42px; border-radius: 10px;
                                                    background: var(--en-primary-soft); color: var(--en-primary);
                                                    display: flex; align-items: center; justify-content: center;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <strong style="color: var(--en-dark); display: block;"><?= esc($e['nama_event']) ?></strong>
                                        <small style="color: var(--en-muted); font-size: 11px;">
                                            <?= esc(substr(strip_tags($e['deskripsi'] ?? ''), 0, 45)) ?>...
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <i class="bi bi-calendar3" style="color: var(--en-primary);"></i>
                                <?= date('d M Y', strtotime($e['tanggal'])) ?>
                            </td>
                            <td><?= esc($e['gedung'] ?? '-') ?></td>
                            <td><span class="en-badge <?= $badge['cls'] ?>"><?= $badge['lbl'] ?></span></td>
                            <td style="text-align: center;">
                                <?php if ($perluReport): ?>
                                    <a href="<?= site_url('ormawa/report/isi/'.$e['id_event']) ?>"
                                       class="en-btn en-btn-primary en-btn-sm" title="Isi Report">
                                        <i class="bi bi-file-earmark-plus"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?= site_url('detail_event/'.$e['id_event']) ?>"
                                   target="_blank" class="en-btn en-btn-light en-btn-sm" title="Lihat Publik">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('ormawa/kegiatan/edit/'.$e['id_event']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('ormawa/kegiatan/delete/'.$e['id_event']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus event ini?')"
                                   class="en-btn en-btn-light en-btn-sm"
                                   style="color: var(--en-danger);" title="Hapus">
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
            <i class="bi bi-calendar-x"></i>
            <h5>Belum Ada Event</h5>
            <p>Mulai buat event pertama kamu — manual atau dengan bantuan AI.</p>
            <a href="<?= site_url('ormawa/kegiatan/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-plus-circle-fill"></i> Tambah Event Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>