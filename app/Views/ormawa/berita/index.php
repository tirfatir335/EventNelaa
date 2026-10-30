<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-newspaper me-2" style="color: var(--en-primary);"></i> Kelola Berita</h3>
            <p>Publikasikan berita dan pengumuman ormawa kamu</p>
        </div>
        <a href="<?= site_url('ormawa/berita/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-pencil-square"></i> Tulis Berita
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
        <i class="bi bi-exclamation-triangle-fill" style="font-size: 20px;"></i>
        <strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<div class="en-card">
    <div class="en-card__head">
        <h3>Daftar Berita (<?= count($berita ?? []) ?>)</h3>
    </div>

    <?php if (!empty($berita)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th style="width: 80px;">Foto</th>
                        <th>Judul Berita</th>
                        <th style="width: 120px;">Tanggal</th>
                        <th style="text-align: center;">Status</th>
                        <th style="text-align: center; width: 130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($berita as $b): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php if (!empty($b['foto']) && file_exists('uploads/berita/' . $b['foto'])): ?>
                                    <img src="<?= base_url('uploads/berita/' . $b['foto']) ?>"
                                         style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 60px; height: 60px; border-radius: 10px;
                                                background: var(--en-primary-soft); color: var(--en-primary);
                                                display: flex; align-items: center; justify-content: center; font-size: 22px;">
                                        <i class="bi bi-newspaper"></i>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong style="color: var(--en-dark); font-size: 14px;"><?= esc($b['judul']) ?></strong>
                                <br>
                                <small style="color: var(--en-muted); font-size: 12px;">
                                    <?= esc(substr(strip_tags($b['konten']), 0, 60)) ?>...
                                </small>
                            </td>
                            <td>
                                <small style="color: var(--en-text);">
                                    <i class="bi bi-calendar3" style="color: var(--en-primary);"></i>
                                    <?= date('d M Y', strtotime($b['created_at'])) ?>
                                </small>
                            </td>
                            <td style="text-align: center;">
                                <?php if ($b['status'] === 'published'): ?>
                                    <span class="en-badge en-badge-success"><i class="bi bi-check-circle-fill"></i> Published</span>
                                <?php else: ?>
                                    <span class="en-badge en-badge-muted"><i class="bi bi-file-earmark"></i> Draft</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('berita/detail/' . $b['id_berita']) ?>" target="_blank"
                                   class="en-btn en-btn-light en-btn-sm" title="Lihat">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="<?= site_url('ormawa/berita/edit/' . $b['id_berita']) ?>"
                                   class="en-btn en-btn-light en-btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <a href="<?= site_url('ormawa/berita/hapus/' . $b['id_berita']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus berita ini?')"
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
            <i class="bi bi-newspaper"></i>
            <h5>Belum Ada Berita</h5>
            <p>Mulai publikasikan berita atau pengumuman ormawa kamu.</p>
            <a href="<?= site_url('ormawa/berita/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-pencil-square"></i> Tulis Berita Pertama
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>