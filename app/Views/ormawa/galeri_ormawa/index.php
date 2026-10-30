<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-images me-2" style="color: var(--en-primary);"></i> Galeri Dokumentasi</h3>
            <p>Kelola foto dokumentasi kegiatan ormawa kamu</p>
        </div>
        <a href="<?= site_url('ormawa/galeri-ormawa/tambah') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-cloud-upload-fill"></i> Upload Foto
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

<div class="en-card">
    <div class="en-card__head">
        <h3><i class="bi bi-collection-fill me-2" style="color: var(--en-primary);"></i> Total: <?= count($foto ?? []) ?> Foto</h3>
    </div>

    <?php if (!empty($foto)): ?>
        <div class="row g-3">
            <?php foreach ($foto as $f): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div style="background: var(--en-bg-alt); border-radius: var(--en-r);
                                overflow: hidden; border: 1px solid var(--en-border); transition: .3s;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='var(--en-sh-md)';"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">

                        <a href="<?= base_url('uploads/galeri_ormawa/' . $f['foto']) ?>" target="_blank">
                            <img src="<?= base_url('uploads/galeri_ormawa/' . $f['foto']) ?>"
                                 style="width: 100%; height: 170px; object-fit: cover; display: block;">
                        </a>

                        <div style="padding: 12px;">
                            <?php if (!empty($f['judul_foto'])): ?>
                                <h6 style="font-size: 13px; font-weight: 700; color: var(--en-dark);
                                           margin: 0 0 8px; overflow: hidden; text-overflow: ellipsis;
                                           white-space: nowrap;">
                                    <?= esc($f['judul_foto']) ?>
                                </h6>
                            <?php endif; ?>

                            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px;">
                                <small style="color: var(--en-muted); font-size: 11px;">
                                    <i class="bi bi-calendar3"></i>
                                    <?= date('d M Y', strtotime($f['created_at'])) ?>
                                </small>
                                <a href="<?= site_url('ormawa/galeri-ormawa/hapus/' . $f['id_galeri']) ?>"
                                   onclick="return confirm('Yakin ingin menghapus foto ini?')"
                                   class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="en-empty">
            <i class="bi bi-images"></i>
            <h5>Belum Ada Foto</h5>
            <p>Mulai dokumentasikan kegiatan ormawa kamu dengan mengupload foto.</p>
            <a href="<?= site_url('ormawa/galeri-ormawa/tambah') ?>" class="en-btn en-btn-primary">
                <i class="bi bi-cloud-upload-fill"></i> Upload Foto Sekarang
            </a>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>