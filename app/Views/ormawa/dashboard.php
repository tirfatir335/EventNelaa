<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<!-- WELCOME BANNER -->
<div class="en-welcome">
    <div class="en-welcome__top">
        <h2>Welcome back, <?= esc(session('username')) ?>! </h2>
        <span class="date"><i class="bi bi-calendar3"></i> <?= date('d F Y') ?></span>
    </div>

    <div class="en-welcome__stats">
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-calendar-event-fill"></i></div>
            <div class="lbl">Total Event</div>
            <div class="val"><?= $total_pengajuan ?? 0 ?></div>
            <div class="trend">+<?= $total_disetujui ?? 0 ?> published</div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-check-circle-fill"></i></div>
            <div class="lbl">Disetujui</div>
            <div class="val"><?= $total_disetujui ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-hourglass-split"></i></div>
            <div class="lbl">Pending</div>
            <div class="val"><?= $total_pending ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-x-circle-fill"></i></div>
            <div class="lbl">Ditolak</div>
            <div class="val"><?= $total_ditolak ?? 0 ?></div>
        </div>
    </div>
</div>

<!-- NOTIF: EVENT BELUM DI-REPORT -->
<?php if (!empty($belum_report)): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-primary); background: var(--en-grad-primary-soft);">
    <div style="display: flex; gap: 14px; align-items: flex-start;">
        <div style="width: 46px; height: 46px; border-radius: 12px; background: var(--en-grad-primary);
                    display: flex; align-items: center; justify-content: center; color: white;
                    font-size: 22px; flex-shrink: 0;">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <div style="flex: 1;">
            <h3 style="font-size: 15px; font-weight: 800; color: var(--en-primary-dark); margin: 0 0 4px;">
                ⚠️ <?= count($belum_report) ?> Event Belum Di-Report
            </h3>
            <p style="font-size: 13px; color: var(--en-muted); margin: 0 0 12px;">
                Segera isi LPJ setelah event selesai ya!
            </p>
            <div style="display: flex; flex-direction: column; gap: 6px;">
                <?php foreach (array_slice($belum_report, 0, 3) as $b): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center;
                                background: white; padding: 10px 14px; border-radius: 10px;">
                        <div>
                            <strong style="font-size: 13px; color: var(--en-dark);"><?= esc($b['nama_event']) ?></strong>
                            <div style="font-size: 11px; color: var(--en-muted);">
                                <i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($b['tanggal'])) ?>
                            </div>
                        </div>
                        <a href="<?= site_url('ormawa/report/isi/'.$b['id_event']) ?>"
                           class="en-btn en-btn-primary en-btn-sm">
                            <i class="bi bi-pencil-square"></i> Isi
                        </a>
                    </div>
                <?php endforeach; ?>
                <?php if (count($belum_report) > 3): ?>
                    <a href="<?= site_url('ormawa/report') ?>" style="text-align: center; color: var(--en-primary);
                              font-size: 12px; font-weight: 700; padding: 6px; text-decoration: none;">
                        Lihat semua (<?= count($belum_report) ?>) →
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- STAT CARDS -->
<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);">
                <i class="bi bi-clipboard-check-fill"></i>
            </div>
            <span class="en-stat__trend">+<?= $progress_progja ?? 0 ?>%</span>
        </div>
        <div class="en-stat__val"><?= $total_progja ?? 0 ?></div>
        <div class="en-stat__lbl">Program Kerja</div>
        <div class="en-stat__prog">
            <div class="bar"><span style="width: <?= $progress_progja ?? 0 ?>%"></span></div>
            <div class="info"><span>Progress</span><span><?= $progress_progja ?? 0 ?>%</span></div>
        </div>
    </div>

    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);">
                <i class="bi bi-people-fill"></i>
            </div>
            <span class="en-stat__trend">+<?= $progress_pengurus ?? 0 ?>%</span>
        </div>
        <div class="en-stat__val"><?= $total_pengurus ?? 0 ?></div>
        <div class="en-stat__lbl">Pengurus Aktif</div>
        <div class="en-stat__prog">
            <div class="bar"><span style="width: <?= $progress_pengurus ?? 0 ?>%"></span></div>
            <div class="info"><span>Progress</span><span><?= $progress_pengurus ?? 0 ?>%</span></div>
        </div>
    </div>

    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);">
                <i class="bi bi-images"></i>
            </div>
            <span class="en-stat__trend">+<?= $total_galeri ?? 0 ?></span>
        </div>
        <div class="en-stat__val"><?= $total_galeri ?? 0 ?></div>
        <div class="en-stat__lbl">Foto Galeri</div>
        <div class="en-stat__prog">
            <div class="bar"><span style="width: <?= $progress_galeri ?? 0 ?>%"></span></div>
            <div class="info"><span>Progress</span><span><?= $progress_galeri ?? 0 ?>%</span></div>
        </div>
    </div>

    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #A855F7, #7E22CE);">
                <i class="bi bi-megaphone-fill"></i>
            </div>
            <span class="en-stat__trend">+<?= $total_recruitment ?? 0 ?></span>
        </div>
        <div class="en-stat__val"><?= $total_recruitment ?? 0 ?></div>
        <div class="en-stat__lbl">Recruitment</div>
        <div class="en-stat__prog">
            <div class="bar"><span style="width: <?= $progress_recruitment ?? 0 ?>%"></span></div>
            <div class="info"><span>Progress</span><span><?= $progress_recruitment ?? 0 ?>%</span></div>
        </div>
    </div>
</div>

<!-- 2 COLUMN: ANALYTICS + ACTIVITY -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="en-card">
            <div class="en-card__head">
                <div>
                    <h3>Analitik Event <?= date('Y') ?></h3>
                    <p>Performa event per bulan</p>
                </div>
            </div>
            <div style="position: relative; height: 280px;">
                <canvas id="enChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3>Aktivitas Terbaru</h3>
                <span class="en-badge en-badge-success">
                    <i class="bi bi-circle-fill" style="font-size: 8px;"></i> Live
                </span>
            </div>
            <?php if (!empty($recent_events)): ?>
                <div class="en-feed">
                    <?php foreach (array_slice($recent_events, 0, 5) as $e): ?>
                        <div class="en-feed__item">
                            <div class="en-feed__ico" style="background: var(--en-grad-primary);">
                                <i class="bi bi-calendar-event-fill"></i>
                            </div>
                            <div class="en-feed__body">
                                <h6><?= esc($e['nama_event']) ?></h6>
                                <small><?= date('d M Y', strtotime($e['tanggal'])) ?></small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="en-empty" style="padding: 30px 10px;">
                    <i class="bi bi-inbox" style="font-size: 40px;"></i>
                    <p style="font-size: 12px;">Belum ada aktivitas</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS + TABEL -->
<div class="row g-4">
    <div class="col-lg-5">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3>Aksi Cepat</h3>
            </div>
            <div class="en-qa-grid">
                <a href="<?= site_url('ormawa/kegiatan/tambah') ?>" class="en-qa en-qa-1">
                    <i class="bi bi-plus-circle-fill"></i>
                    <h5>Ajukan Event</h5>
                    <small>Buat event baru</small>
                </a>
                <a href="<?= site_url('ormawa/program-kerja/tambah') ?>" class="en-qa en-qa-2">
                    <i class="bi bi-clipboard-plus-fill"></i>
                    <h5>Tambah Progja</h5>
                    <small>Rencana kegiatan</small>
                </a>
                <a href="<?= site_url('ormawa/pengurus/tambah') ?>" class="en-qa en-qa-3">
                    <i class="bi bi-person-plus-fill"></i>
                    <h5>Tambah Pengurus</h5>
                    <small>Struktur organisasi</small>
                </a>
                <a href="<?= site_url('ormawa/recruitment/tambah') ?>" class="en-qa en-qa-4">
                    <i class="bi bi-megaphone-fill"></i>
                    <h5>Open Recruitment</h5>
                    <small>Rekrut anggota</small>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3>Event Disetujui</h3>
                <a href="<?= site_url('ormawa/kegiatan') ?>" class="en-btn en-btn-outline en-btn-sm">Lihat Semua</a>
            </div>
            <?php if (!empty($data_disetujui)): ?>
                <div class="table-responsive">
                    <table class="en-table">
                        <thead>
                            <tr>
                                <th>Event</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($data_disetujui, 0, 5) as $row): ?>
                                <tr>
                                    <td><strong><?= esc($row['nama_event']) ?></strong></td>
                                    <td><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                    <td><span class="en-badge en-badge-success">Published</span></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="en-empty" style="padding: 40px 20px;">
                    <i class="bi bi-calendar-x"></i>
                    <h5>Belum Ada Event Disetujui</h5>
                    <p>Mulai ajukan event pertama kamu</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('enChart');
    if (!canvas || typeof Chart === 'undefined') return;

    const chartData = <?= json_encode($chartData ?? [0,0,0,0,0,0,0,0,0,0,0,0]) ?>;
    const adaData = chartData.some(v => v > 0);

    new Chart(canvas, {
        type: 'line',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                label: 'Event',
                data: chartData,
                borderColor: '#FF7A00',
                backgroundColor: 'rgba(255,122,0,0.12)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#FF7A00',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointRadius: adaData ? 5 : 0,
                pointHoverRadius: 8,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0F172A',
                    padding: 12,
                    titleFont: { size: 13, weight: 'bold' },
                    bodyFont: { size: 12 },
                    cornerRadius: 10,
                    displayColors: false,
                    callbacks: {
                        label: (ctx) => ctx.parsed.y + ' event'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: adaData ? undefined : 5,
                    ticks: { color: '#64748B', stepSize: 1, precision: 0 },
                    grid: { color: '#F1F5F9' },
                    border: { display: false }
                },
                x: {
                    ticks: { color: '#64748B' },
                    grid: { display: false },
                    border: { display: false }
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>