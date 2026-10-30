<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.rw-page { background: #FFFBF5; }

.rw-hero {
    position: relative;
    padding: 60px 24px 80px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.9) 0%, rgba(230,81,0,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.rw-hero::before {
    content: '';
    position: absolute;
    top: -40%; right: -10%;
    width: 550px; height: 550px;
    background: radial-gradient(circle, rgba(255,255,255,.15), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.rw-hero-inner {
    position: relative; z-index: 2;
    max-width: 1000px; margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 24px;
    flex-wrap: wrap;
}
.rw-greeting {
    display: flex; align-items: center; gap: 18px;
    flex: 1; min-width: 260px;
}
.rw-avatar {
    width: 78px; height: 78px;
    border-radius: 50%;
    border: 4px solid rgba(255,255,255,.4);
    object-fit: cover;
    background: white;
    flex-shrink: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 32px; color: #FF7A00; font-weight: 800;
}
.rw-greeting h1 {
    font-size: clamp(22px, 3vw, 32px);
    font-weight: 900;
    letter-spacing: -.8px;
    margin: 0 0 6px;
    color: white;
}
.rw-greeting p {
    font-size: 14px;
    color: rgba(255,255,255,.9);
    margin: 0;
}
.rw-btn-cari {
    display: inline-flex; align-items: center; gap: 8px;
    background: rgba(255,255,255,.2);
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,.4);
    color: white;
    padding: 13px 26px;
    border-radius: 50px;
    font-weight: 800; font-size: 14px;
    text-decoration: none;
    transition: .3s;
}
.rw-btn-cari:hover {
    background: white;
    color: #E65100;
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,.2);
}

.rw-stats {
    max-width: 1000px;
    margin: -50px auto 0;
    padding: 0 24px;
    position: relative;
    z-index: 10;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}
.rw-stat {
    background: white;
    border-radius: 18px;
    padding: 22px 18px;
    text-align: center;
    box-shadow: 0 15px 40px rgba(15,23,42,.1);
    border: 1px solid #F1F5F9;
}
.rw-stat-ico {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 22px; color: white;
}
.rw-stat-num { font-size: 26px; font-weight: 900; color: #0F172A; line-height: 1; letter-spacing: -.5px; }
.rw-stat-lbl { font-size: 11.5px; color: #64748B; font-weight: 800; text-transform: uppercase; letter-spacing: .6px; margin-top: 6px; }

.rw-section { padding: 50px 24px 80px; background: #FFFBF5; }
.rw-inner { max-width: 1000px; margin: 0 auto; }

.rw-title {
    font-size: 22px;
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -.5px;
    margin: 0 0 24px;
    display: flex; align-items: center; gap: 10px;
    padding-bottom: 16px;
    border-bottom: 3px solid #F1F5F9;
}
.rw-title i { color: #FF7A00; }

.rw-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(460px, 1fr));
    gap: 22px;
}

.rw-card {
    background: white;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    border: 1px solid #F1F5F9;
    transition: .35s;
}
.rw-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 50px rgba(255,122,0,.15);
    border-color: #FFE0B2;
}
.rw-card-header {
    padding: 22px 26px;
    background: linear-gradient(135deg, #FFF3E0, #FFE0B2);
    border-bottom: 3px solid #FF7A00;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 14px;
}
.rw-rec-info { flex: 1; min-width: 0; }
.rw-rec-info h4 {
    font-size: 16px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 6px;
    line-height: 1.4;
    letter-spacing: -.3px;
}
.rw-rec-info .org {
    font-size: 12.5px;
    color: #E65100;
    font-weight: 800;
    display: flex; align-items: center; gap: 6px;
}
.rw-status-pill {
    padding: 6px 16px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .8px;
    white-space: nowrap;
    flex-shrink: 0;
}
.rw-status-pill.warning { background: #FEF3C7; color: #B45309; }
.rw-status-pill.info    { background: #DBEAFE; color: #1D4ED8; }
.rw-status-pill.primary { background: #E0E7FF; color: #4338CA; }
.rw-status-pill.success { background: #DCFCE7; color: #15803D; }
.rw-status-pill.danger  { background: #FEE2E2; color: #B91C1C; }

.rw-card-body { padding: 26px; }

.rw-progress {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 24px;
    position: relative;
    padding: 0 4px;
}
.rw-progress::before {
    content: '';
    position: absolute;
    top: 18px;
    left: 12%; right: 12%;
    height: 3px;
    background: #F1F5F9;
    border-radius: 2px;
    z-index: 0;
}
.rw-step {
    text-align: center;
    flex: 1;
    position: relative;
    z-index: 1;
}
.rw-step-circle {
    width: 38px; height: 38px;
    border-radius: 50%;
    background: #F1F5F9;
    color: #94A3B8;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 8px;
    font-size: 15px;
    font-weight: 800;
    border: 3px solid white;
    transition: .3s;
}
.rw-step.done .rw-step-circle {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 4px 12px rgba(255,122,0,.3);
}
.rw-step.current .rw-step-circle {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    box-shadow: 0 0 0 5px rgba(255,122,0,.2);
    animation: rwPulse 1.6s infinite;
}
@keyframes rwPulse {
    0%, 100% { box-shadow: 0 0 0 5px rgba(255,122,0,.2); }
    50%      { box-shadow: 0 0 0 10px rgba(255,122,0,.08); }
}
.rw-step.rejected .rw-step-circle {
    background: linear-gradient(135deg, #EF4444, #B91C1C);
    color: white;
}
.rw-step-lbl {
    font-size: 10.5px;
    color: #94A3B8;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.rw-step.done .rw-step-lbl,
.rw-step.current .rw-step-lbl {
    color: #E65100;
}

.rw-desc-box {
    background: #FAFBFC;
    border-radius: 14px;
    padding: 14px 18px;
    font-size: 13.5px;
    color: #475569;
    line-height: 1.65;
    margin-bottom: 16px;
    display: flex;
    gap: 10px;
    align-items: flex-start;
    border-left: 4px solid #FF7A00;
}
.rw-desc-box i {
    color: #FF7A00;
    font-size: 18px;
    flex-shrink: 0;
    margin-top: 2px;
}

.rw-catatan {
    background: #FEF3C7;
    border-left: 4px solid #F59E0B;
    border-radius: 12px;
    padding: 14px 18px;
    margin-bottom: 16px;
}
.rw-catatan.danger {
    background: #FEE2E2;
    border-left-color: #EF4444;
}
.rw-catatan.success {
    background: #DCFCE7;
    border-left-color: #22C55E;
}
.rw-catatan .lbl {
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: .5px;
    color: #B45309;
    margin-bottom: 6px;
    display: flex; align-items: center; gap: 6px;
}
.rw-catatan.danger .lbl { color: #B91C1C; }
.rw-catatan.success .lbl { color: #15803D; }
.rw-catatan p {
    font-size: 13.5px;
    color: #475569;
    margin: 0;
    line-height: 1.65;
}

.rw-card-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    padding-top: 16px;
    border-top: 1px solid #F1F5F9;
}
.rw-btn-wa {
    background: linear-gradient(135deg, #25D366, #128C7E);
    color: white;
    padding: 10px 22px;
    border-radius: 50px;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
    display: inline-flex; align-items: center; gap: 6px;
    transition: .3s;
    box-shadow: 0 6px 18px rgba(37,211,102,.3);
}
.rw-btn-wa:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 12px 30px rgba(37,211,102,.4);
}
.rw-time {
    font-size: 11.5px;
    color: #94A3B8;
    display: flex; align-items: center; gap: 4px;
}

.rw-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 24px;
    border: 1px dashed #E2E8F0;
}
.rw-empty i { font-size: 80px; color: #E2E8F0; display: block; margin-bottom: 14px; }
.rw-empty h3 { font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 8px; }
.rw-empty p { font-size: 14px; color: #64748B; margin: 0 auto 20px; max-width: 400px; }
.rw-empty-btn {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 15px 32px;
    border-radius: 50px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    font-weight: 800; font-size: 14.5px;
    text-decoration: none;
    box-shadow: 0 12px 30px rgba(255,122,0,.35);
    transition: .3s;
}
.rw-empty-btn:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 18px 45px rgba(255,122,0,.45);
}

@media (max-width: 768px) {
    .rw-hero { padding: 40px 18px 70px; }
    .rw-hero-inner { flex-direction: column; align-items: flex-start; text-align: left; }
    .rw-greeting { flex-direction: column; align-items: flex-start; gap: 14px; }
    .rw-avatar { width: 62px; height: 62px; font-size: 26px; }
    .rw-btn-cari { width: 100%; justify-content: center; }
    .rw-stats { grid-template-columns: 1fr; gap: 10px; margin-top: -40px; }
    .rw-grid { grid-template-columns: 1fr; }
    .rw-card-header { flex-direction: column; gap: 10px; }
    .rw-section { padding: 30px 18px 50px; }
    .rw-step-circle { width: 32px; height: 32px; font-size: 13px; }
    .rw-step-lbl { font-size: 9.5px; }
}
</style>

<div class="rw-page">

    <section class="rw-hero">
        <div class="rw-hero-inner">
            <div class="rw-greeting">
                <?php
                $foto = session('foto');
                $fotoUrl = !empty($foto) && file_exists('uploads/profil/' . $foto)
                    ? base_url('uploads/profil/' . $foto)
                    : null;
                ?>
                <?php if ($fotoUrl): ?>
                    <img src="<?= $fotoUrl ?>" class="rw-avatar" alt="">
                <?php else: ?>
                    <div class="rw-avatar"><?= strtoupper(substr(session('username') ?? 'U', 0, 1)) ?></div>
                <?php endif; ?>
                <div>
                    <h1>Halo, <?= esc(session('username')) ?>! 👋</h1>
                    <p>Pantau status pendaftaran UKM/Ormawa kamu di sini</p>
                </div>
            </div>

            <a href="<?= site_url('recruitment') ?>" class="rw-btn-cari">
                <i class="bi bi-plus-circle"></i> Cari Recruitment
            </a>
        </div>
    </section>

    <?php
    $total = count($pendaftaran ?? []);
    $pending = count(array_filter($pendaftaran ?? [], fn($p) => in_array($p['status_pendaftaran'] ?? '', ['pending', 'tes_tertulis', 'wawancara'])));
    $selesai = count(array_filter($pendaftaran ?? [], fn($p) => in_array($p['status_pendaftaran'] ?? '', ['diterima', 'ditolak'])));
    ?>
    <div class="rw-stats">
        <div class="rw-stat">
            <div class="rw-stat-ico" style="background: linear-gradient(135deg, #FF7A00, #E65100);">
                <i class="bi bi-file-earmark-text-fill"></i>
            </div>
            <div class="rw-stat-num"><?= $total ?></div>
            <div class="rw-stat-lbl">Total Pendaftaran</div>
        </div>
        <div class="rw-stat">
            <div class="rw-stat-ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="rw-stat-num"><?= $pending ?></div>
            <div class="rw-stat-lbl">Sedang Proses</div>
        </div>
        <div class="rw-stat">
            <div class="rw-stat-ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                <i class="bi bi-check-circle-fill"></i>
            </div>
            <div class="rw-stat-num"><?= $selesai ?></div>
            <div class="rw-stat-lbl">Selesai</div>
        </div>
    </div>

    <section class="rw-section">
        <div class="rw-inner">
            <div class="rw-title">
                <i class="bi bi-file-earmark-text-fill"></i> Pendaftaran Saya
            </div>

            <?php if (!empty($pendaftaran)): ?>
                <div class="rw-grid">
                    <?php foreach ($pendaftaran as $p):
                        $statusKey = $p['status_pendaftaran'] ?? 'pending';

                        $statusInfo = [
                            'pending'      => ['label' => 'Menunggu',     'color' => 'warning', 'icon' => 'hourglass-split', 'desc' => 'Pendaftaranmu sudah masuk. Menunggu proses seleksi berkas.'],
                            'tes_tertulis' => ['label' => 'Tes Tertulis', 'color' => 'info',    'icon' => 'pencil-square',   'desc' => 'Selamat! Kamu lolos seleksi berkas. Siapkan diri untuk tes tertulis.'],
                            'wawancara'    => ['label' => 'Wawancara',    'color' => 'primary', 'icon' => 'chat-dots-fill',  'desc' => 'Hebat! Kamu lolos tes sebelumnya. Bersiap untuk tahap wawancara.'],
                            'diterima'     => ['label' => 'DITERIMA',     'color' => 'success', 'icon' => 'trophy-fill',     'desc' => 'Selamat! Kamu resmi diterima sebagai anggota. 🎉'],
                            'ditolak'      => ['label' => 'Ditolak',      'color' => 'danger',  'icon' => 'x-circle-fill',   'desc' => 'Maaf, kamu belum lolos seleksi kali ini. Tetap semangat!'],
                        ];
                        $info = $statusInfo[$statusKey] ?? $statusInfo['pending'];

                        $steps = ['pending' => 1, 'tes_tertulis' => 2, 'wawancara' => 3, 'diterima' => 4, 'ditolak' => -1];
                        $currentStep = $steps[$statusKey] ?? 1;
                        $isRejected = ($statusKey === 'ditolak');
                    ?>
                        <div class="rw-card">

                            <div class="rw-card-header">
                                <div class="rw-rec-info">
                                    <h4><?= esc($p['judul'] ?? '-') ?></h4>
                                    <div class="org">
                                        <i class="bi bi-building-fill"></i>
                                        <?= esc($p['nama_ormawa'] ?? '-') ?>
                                    </div>
                                </div>
                                <span class="rw-status-pill <?= $info['color'] ?>">
                                    <i class="bi bi-<?= $info['icon'] ?> me-1"></i><?= $info['label'] ?>
                                </span>
                            </div>

                            <div class="rw-card-body">

                                <?php if (!$isRejected): ?>
                                    <div class="rw-progress">
                                        <div class="rw-step <?= $currentStep >= 1 ? 'done' : '' ?> <?= $currentStep == 1 ? 'current' : '' ?>">
                                            <div class="rw-step-circle"><i class="bi bi-send-fill"></i></div>
                                            <div class="rw-step-lbl">Daftar</div>
                                        </div>
                                        <div class="rw-step <?= $currentStep >= 2 ? 'done' : '' ?> <?= $currentStep == 2 ? 'current' : '' ?>">
                                            <div class="rw-step-circle"><i class="bi bi-pencil-fill"></i></div>
                                            <div class="rw-step-lbl">Tes</div>
                                        </div>
                                        <div class="rw-step <?= $currentStep >= 3 ? 'done' : '' ?> <?= $currentStep == 3 ? 'current' : '' ?>">
                                            <div class="rw-step-circle"><i class="bi bi-chat-dots-fill"></i></div>
                                            <div class="rw-step-lbl">Wawancara</div>
                                        </div>
                                        <div class="rw-step <?= $currentStep >= 4 ? 'done' : '' ?> <?= $currentStep == 4 ? 'current' : '' ?>">
                                            <div class="rw-step-circle"><i class="bi bi-trophy-fill"></i></div>
                                            <div class="rw-step-lbl">Diterima</div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="rw-progress">
                                        <div class="rw-step done">
                                            <div class="rw-step-circle"><i class="bi bi-send-fill"></i></div>
                                            <div class="rw-step-lbl">Daftar</div>
                                        </div>
                                        <div class="rw-step rejected">
                                            <div class="rw-step-circle"><i class="bi bi-x-lg"></i></div>
                                            <div class="rw-step-lbl">Ditolak</div>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="rw-desc-box">
                                    <i class="bi bi-info-circle-fill"></i>
                                    <span><?= $info['desc'] ?></span>
                                </div>

                                <?php if (!empty($p['catatan_admin'])): ?>
                                    <div class="rw-catatan <?= $statusKey === 'ditolak' ? 'danger' : ($statusKey === 'diterima' ? 'success' : '') ?>">
                                        <div class="lbl">
                                            <i class="bi bi-chat-left-text-fill"></i> Catatan Admin
                                        </div>
                                        <p><?= nl2br(esc($p['catatan_admin'])) ?></p>
                                    </div>
                                <?php endif; ?>

                                <div class="rw-card-footer">
                                    <?php if (in_array($statusKey, ['tes_tertulis', 'wawancara', 'diterima']) && !empty($p['link_wa'])): ?>
                                        <a href="<?= esc($p['link_wa']) ?>" target="_blank" class="rw-btn-wa">
                                            <i class="bi bi-whatsapp"></i> Join Grup WA
                                        </a>
                                    <?php else: ?>
                                        <span></span>
                                    <?php endif; ?>
                                    <span class="rw-time">
                                        <i class="bi bi-clock"></i>
                                        <?= date('d M Y, H:i', strtotime($p['updated_at'] ?? $p['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="rw-empty">
                    <i class="bi bi-inbox"></i>
                    <h3>Belum Ada Pendaftaran</h3>
                    <p>Kamu belum pernah mendaftar ke UKM/Ormawa manapun. Yuk cari recruitment yang cocok buat kamu!</p>
                    <a href="<?= site_url('recruitment') ?>" class="rw-empty-btn">
                        <i class="bi bi-search"></i> Cari Open Recruitment
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

</div>

<?= $this->endSection() ?>