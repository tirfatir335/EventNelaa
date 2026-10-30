<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-card mb-4">
    <div class="en-card__head">
        <div>
            <h3><i class="bi bi-clipboard-check-fill me-2" style="color: var(--en-primary);"></i> Detail Program Kerja</h3>
            <p><?= esc($progja['nama_progja']) ?></p>
        </div>
        <a href="<?= site_url('validator/progja') ?>" class="en-btn en-btn-light">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<?php if (session()->getFlashdata('error')): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-danger); background: var(--en-danger-soft);">
    <div style="display: flex; align-items: center; gap: 10px; color: #B91C1C;">
        <i class="bi bi-exclamation-triangle-fill"></i><strong><?= session()->getFlashdata('error') ?></strong>
    </div>
</div>
<?php endif; ?>

<?php
$bulanList = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$status = $progja['status'] ?? 'draft';
$badgeMap = [
    'draft'    => ['cls' => 'en-badge-muted',   'lbl' => '📝 Draft'],
    'pending'  => ['cls' => 'en-badge-warning', 'lbl' => '⏳ Menunggu Validasi'],
    'approved' => ['cls' => 'en-badge-success', 'lbl' => '✅ Disetujui'],
    'rejected' => ['cls' => 'en-badge-danger',  'lbl' => '❌ Ditolak'],
];
$b = $badgeMap[$status] ?? $badgeMap['draft'];
?>

<!-- INFO ORMAWA -->
<div class="en-card mb-4" style="background: var(--en-grad-primary-soft); border-left: 5px solid var(--en-primary);">
    <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
        <?php if (!empty($progja['ormawa_logo']) && file_exists('uploads/logo/' . $progja['ormawa_logo'])): ?>
            <img src="<?= base_url('uploads/logo/' . $progja['ormawa_logo']) ?>"
                 style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover;
                        border: 3px solid white;">
        <?php else: ?>
            <div style="width: 54px; height: 54px; border-radius: 50%;
                        background: var(--en-grad-primary); color: white;
                        display: flex; align-items: center; justify-content: center; font-size: 22px;">
                <i class="bi bi-building"></i>
            </div>
        <?php endif; ?>
        <div style="flex: 1;">
            <div style="font-weight: 800; color: var(--en-dark); font-size: 15px;"><?= esc($progja['nama_ormawa']) ?></div>
            <div style="font-size: 12px; color: var(--en-muted);">Semester <?= esc($progja['semester'] ?? '-') ?></div>
        </div>
        <span class="en-badge <?= $b['cls'] ?>"><?= $b['lbl'] ?></span>
    </div>
</div>

<div class="row g-4">
    <!-- INFO PROGJA -->
    <div class="col-md-7">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3><i class="bi bi-info-circle-fill me-2" style="color: var(--en-primary);"></i> Informasi Program Kerja</h3>
            </div>

            <div style="display: grid; gap: 0;">
                <?php
                $rows = [
                    'Nama Program'  => esc($progja['nama_progja']),
                    'Semester'      => esc($progja['semester'] ?? '-'),
                    'Bulan Rencana' => $bulanList[($progja['bulan'] ?? 1) - 1],
                    'Target Peserta' => esc($progja['target_peserta'] ?? '-') . ' orang',
                ];
                foreach ($rows as $label => $val):
                ?>
                    <div style="display: flex; padding: 12px 0; border-bottom: 1px solid var(--en-border);">
                        <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px;"><?= $label ?></div>
                        <div style="flex: 1; color: var(--en-dark); font-weight: 700;"><?= $val ?></div>
                    </div>
                <?php endforeach; ?>
                <div style="display: flex; padding: 12px 0;">
                    <div style="width: 35%; font-weight: 700; color: var(--en-muted); font-size: 13px; vertical-align: top;">Deskripsi</div>
                    <div style="flex: 1; color: var(--en-text); line-height: 1.7;"><?= nl2br(esc($progja['deskripsi'] ?? '-')) ?></div>
                </div>
            </div>

            <?php if (!empty($progja['foto']) && file_exists('uploads/progja/' . $progja['foto'])): ?>
                <div style="margin-top: 20px;">
                    <img src="<?= base_url('uploads/progja/' . $progja['foto']) ?>"
                         style="max-width: 100%; border-radius: var(--en-r);">
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- VALIDASI -->
    <div class="col-md-5">
        <?php if ($status === 'pending'): ?>
            <div class="en-card" style="position: sticky; top: 90px;">
                <div class="en-card__head">
                    <h3><i class="bi bi-shield-check me-2" style="color: var(--en-primary);"></i> Validasi Program Kerja</h3>
                </div>

                <form action="<?= site_url('validator/progja/proses/' . $progja['id_progja']) ?>" method="post">
                    <?= csrf_field() ?>

                    <div style="margin-bottom: 16px;">
                        <label style="display: flex; align-items: center; gap: 10px; background: var(--en-success-soft);
                                      padding: 14px; border-radius: var(--en-r); margin-bottom: 8px; cursor: pointer;
                                      border: 2px solid transparent; transition: .2s;"
                               onmouseover="this.style.borderColor='#22C55E';" onmouseout="this.style.borderColor='transparent';">
                            <input type="radio" name="aksi" value="approve" checked style="accent-color: var(--en-success);">
                            <span style="font-weight: 700; color: #15803D;">
                                <i class="bi bi-check-circle-fill"></i> Setujui Program Kerja
                            </span>
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; background: var(--en-danger-soft);
                                      padding: 14px; border-radius: var(--en-r); cursor: pointer;
                                      border: 2px solid transparent; transition: .2s;"
                               onmouseover="this.style.borderColor='#EF4444';" onmouseout="this.style.borderColor='transparent';">
                            <input type="radio" name="aksi" value="reject" style="accent-color: var(--en-danger);">
                            <span style="font-weight: 700; color: #B91C1C;">
                                <i class="bi bi-x-circle-fill"></i> Tolak Program Kerja
                            </span>
                        </label>
                    </div>

                    <div style="margin-bottom: 16px;">
                        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">
                            Catatan <span style="color: var(--en-muted); font-weight: 400;">(wajib jika tolak)</span>
                        </label>
                        <textarea name="catatan" rows="3" class="form-control"
                                  style="border-radius: var(--en-r); border: 1px solid var(--en-border-strong);"
                                  placeholder="Contoh: Target peserta tidak realistis"></textarea>
                    </div>

                    <button type="submit" class="en-btn en-btn-primary en-btn-lg" style="width: 100%; justify-content: center;">
                        <i class="bi bi-save-fill"></i> Proses Validasi
                    </button>
                </form>
            </div>

        <?php elseif ($status === 'rejected'): ?>
            <div class="en-card" style="background: var(--en-danger-soft); border-left: 5px solid var(--en-danger);">
                <div style="font-weight: 800; color: #B91C1C; margin-bottom: 8px;">
                    <i class="bi bi-x-circle-fill"></i> Program Kerja Ditolak
                </div>
                <p style="font-size: 13px; color: var(--en-text); margin: 0;">
                    <?= nl2br(esc($progja['catatan_validator'] ?? 'Tidak ada catatan.')) ?>
                </p>
                <div style="font-size: 11px; color: var(--en-muted); margin-top: 12px;">
                    <?= !empty($progja['validated_at']) ? date('d M Y, H:i', strtotime($progja['validated_at'])) : '' ?>
                </div>
            </div>

        <?php elseif ($status === 'approved'): ?>
            <div class="en-card" style="background: var(--en-success-soft); border-left: 5px solid var(--en-success);">
                <div style="font-weight: 800; color: #15803D; margin-bottom: 8px;">
                    <i class="bi bi-check-circle-fill"></i> Program Kerja Disetujui
                </div>
                <p style="font-size: 13px; color: var(--en-text); margin: 0;">
                    Ormawa bisa upload proposal untuk kegiatan ini.
                </p>
                <div style="font-size: 11px; color: var(--en-muted); margin-top: 12px;">
                    <?= !empty($progja['validated_at']) ? date('d M Y, H:i', strtotime($progja['validated_at'])) : '' ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>