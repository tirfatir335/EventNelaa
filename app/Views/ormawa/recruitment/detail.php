<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('recruitment') ?>">Open Recruitment</a></li>
            <li class="breadcrumb-item active"><?= esc($recruitment['judul']) ?></li>
        </ol>
    </nav>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0 fw-bold"><i class="bi bi-megaphone-fill me-2"></i> <?= esc($recruitment['judul']) ?></h4>
        </div>
        <div class="card-body">

            <!-- INFO ORMAWA -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <?php if (!empty($recruitment['logo']) && file_exists('uploads/logo/' . $recruitment['logo'])): ?>
                    <img src="<?= base_url('uploads/logo/' . $recruitment['logo']) ?>" style="width:60px;height:60px;object-fit:cover;border-radius:50%;">
                <?php endif; ?>
                <div>
                    <h5 class="mb-0 fw-bold"><?= esc($recruitment['nama_ormawa']) ?></h5>
                    <small class="text-muted">Pembina: <?= esc($recruitment['pembina'] ?? '-') ?></small>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-8">
                    <h6 class="fw-bold"><i class="bi bi-info-circle me-1"></i> Deskripsi</h6>
                    <p><?= nl2br(esc($recruitment['deskripsi'])) ?></p>
                </div>
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body">
                            <p><strong><i class="bi bi-tag me-1"></i> Posisi:</strong> <?= esc($recruitment['posisi'] ?? '-') ?></p>
                            <p><strong><i class="bi bi-calendar me-1"></i> Periode:</strong> <?= esc($recruitment['periode']) ?></p>
                            <p><strong><i class="bi bi-circle-fill me-1" style="color:#28a745;"></i> Status:</strong> 
                                <span class="badge bg-success">Open</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- PENGUMUMAN LOLOS (PUBLIK) -->
            <?php if (!empty($lolos_tes) || !empty($lolos_wawancara) || !empty($diterima)): ?>
                <div class="mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-megaphone-fill text-success me-2"></i> Pengumuman Seleksi
                    </h5>

                    <?php if (!empty($diterima)): ?>
                        <div class="card border-success mb-3">
                            <div class="card-header bg-success text-white">
                                <strong>🎉 Selamat! Anggota Baru yang DITERIMA:</strong>
                            </div>
                            <div class="card-body">
                                <ol class="mb-0">
                                    <?php foreach ($diterima as $d): ?>
                                        <li><strong><?= esc($d['nama_lengkap']) ?></strong> (<?= esc($d['nim']) ?>) - <?= esc($d['prodi'] ?? '-') ?></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lolos_wawancara) && empty($diterima)): ?>
                        <div class="card border-primary mb-3">
                            <div class="card-header bg-primary text-white">
                                <strong>💬 Lolos ke Tahap Wawancara:</strong>
                            </div>
                            <div class="card-body">
                                <ol class="mb-0">
                                    <?php foreach ($lolos_wawancara as $w): ?>
                                        <li><?= esc($w['nama_lengkap']) ?> (<?= esc($w['nim']) ?>)</li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lolos_tes) && empty($lolos_wawancara) && empty($diterima)): ?>
                        <div class="card border-info mb-3">
                            <div class="card-header bg-info text-white">
                                <strong>📝 Lolos ke Tahap Tes Tertulis:</strong>
                            </div>
                            <div class="card-body">
                                <ol class="mb-0">
                                    <?php foreach ($lolos_tes as $t): ?>
                                        <li><?= esc($t['nama_lengkap']) ?> (<?= esc($t['nim']) ?>)</li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                        </div>
                    <?php endif; ?>

                    <p class="text-muted small">
                        <i class="bi bi-info-circle me-1"></i>
                        Cek status lengkap kamu di 
                        <a href="<?= site_url('recruitment/riwayat') ?>">Riwayat Pendaftaran</a>.
                    </p>
                </div>

                <hr>
            <?php endif; ?>

            <!-- TOMBOL AKSI -->
            <?php if (session()->get('logged_in') && session()->get('role') === 'mahasiswa'): ?>
                
                <?php if ($sudah_daftar): ?>
                    <?php
                        $statusInfo = [
                            'pending'      => ['label' => 'Pendaftaran Diterima', 'icon' => 'hourglass-split', 'color' => 'warning', 'desc' => 'Menunggu proses seleksi berkas.'],
                            'tes_tertulis' => ['label' => 'Lolos Berkas',         'icon' => 'pencil-square',   'color' => 'info',    'desc' => 'Siapkan diri untuk tes tertulis.'],
                            'wawancara'    => ['label' => 'Lolos Tes Tertulis',   'icon' => 'chat-dots-fill',  'color' => 'primary', 'desc' => 'Bersiap untuk tahap wawancara.'],
                            'diterima'     => ['label' => 'DITERIMA',             'icon' => 'trophy-fill',     'color' => 'success', 'desc' => 'Selamat! Kamu resmi diterima.'],
                            'ditolak'      => ['label' => 'Belum Beruntung',      'icon' => 'x-circle-fill',   'color' => 'danger',  'desc' => 'Maaf, kamu belum lolos seleksi kali ini.'],
                        ];
                        $info = $statusInfo[$pendaftaran_user['status_pendaftaran']] ?? $statusInfo['pending'];
                        
                        $steps = ['pending', 'tes_tertulis', 'wawancara', 'diterima'];
                        $currentStep = array_search($pendaftaran_user['status_pendaftaran'], $steps);
                        if ($pendaftaran_user['status_pendaftaran'] === 'ditolak') $currentStep = -1;
                        $progress = $currentStep === false ? 0 : (($currentStep + 1) / count($steps)) * 100;
                    ?>

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="bi bi-<?= $info['icon'] ?> text-<?= $info['color'] ?>" style="font-size: 50px;"></i>
                                <h4 class="fw-bold mt-2 mb-1"><?= $info['label'] ?></h4>
                                <p class="text-muted mb-0"><?= $info['desc'] ?></p>
                            </div>

                            <?php if ($pendaftaran_user['status_pendaftaran'] !== 'ditolak'): ?>
                                <div class="d-flex justify-content-between small text-muted mb-1 mt-3">
                                    <span>Daftar</span>
                                    <span>Tes</span>
                                    <span>Wawancara</span>
                                    <span>Diterima</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-<?= $info['color'] ?>" style="width: <?= $progress ?>%"></div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($pendaftaran_user['catatan_admin'])): ?>
                                <div class="alert alert-<?= $info['color'] ?> mt-3 mb-2">
                                    <small>
                                        <strong>Catatan Admin:</strong><br>
                                        <?= nl2br(esc($pendaftaran_user['catatan_admin'])) ?>
                                    </small>
                                </div>
                            <?php endif; ?>

                            <?php if (in_array($pendaftaran_user['status_pendaftaran'], ['tes_tertulis', 'wawancara', 'diterima']) 
                                       && !empty($recruitment['link_wa'])): ?>
                                <a href="<?= esc($recruitment['link_wa']) ?>" 
                                   target="_blank" 
                                   class="btn btn-success w-100 mt-2">
                                    <i class="bi bi-whatsapp me-1"></i> JOIN GRUP WHATSAPP
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="card border-0 shadow-sm" style="background:linear-gradient(135deg,#ff7a00,#e65100);">
                        <div class="card-body text-center text-white py-4">
                            <h5 class="fw-bold mb-2"><i class="bi bi-pencil-square me-2"></i> Mau gabung jadi anggota?</h5>
                            <p class="mb-3" style="opacity:0.9;">Isi form pendaftaran online di bawah ini</p>
                            <a href="<?= site_url('recruitment/form-daftar/'.$recruitment['id_recruitment']) ?>" 
                               class="btn btn-light btn-lg fw-bold px-4">
                                <i class="bi bi-send me-2"></i> Daftar Sekarang
                            </a>
                        </div>
                    </div>
                <?php endif; ?>

            <?php elseif (!session()->get('logged_in')): ?>
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-4">
                        <i class="bi bi-lock-fill fs-1 text-warning mb-3"></i>
                        <h5 class="fw-bold">Ingin mendaftar?</h5>
                        <p class="text-muted">Silakan login atau daftar akun terlebih dahulu.</p>
                        <a href="<?= site_url('login?redirect=' . urlencode(current_url())) ?>" class="btn btn-primary me-2">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a href="<?= site_url('register?redirect=' . urlencode(current_url())) ?>" class="btn btn-outline-primary">
                            <i class="bi bi-person-plus me-1"></i> Daftar Akun
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?= $this->endSection() ?>