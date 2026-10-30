<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<div class="en-welcome">
    <div class="en-welcome__top">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;
                        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
                        padding: 5px 14px; border-radius: 20px; width: fit-content; font-size: 11px;
                        font-weight: 700; letter-spacing: .5px;">
                <i class="bi bi-shield-fill-check"></i> PANEL VALIDATOR (WADIR III)
            </div>
            <h2>Selamat Datang, Validator! 👋</h2>
        </div>
        <span class="date"><i class="bi bi-calendar3"></i> <?= date('d F Y') ?></span>
    </div>

    <div class="en-welcome__stats">
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div class="lbl">Total Event</div>
            <div class="val"><?= $total_all ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-hourglass-split"></i></div>
            <div class="lbl">Pending Validasi</div>
            <div class="val"><?= $total_pending ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-check-circle-fill"></i></div>
            <div class="lbl">Published</div>
            <div class="val"><?= $total_publish ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-x-circle-fill"></i></div>
            <div class="lbl">Ditolak</div>
            <div class="val"><?= $total_reject ?? 0 ?></div>
        </div>
    </div>
</div>

<?php if (!empty($belum_verifikasi) && $belum_verifikasi > 0): ?>
<div class="en-card mb-4" style="border-left: 5px solid var(--en-primary); background: var(--en-grad-primary-soft);">
    <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
        <div style="width: 48px; height: 48px; border-radius: 12px;
                    background: var(--en-grad-primary); color: white;
                    display: flex; align-items: center; justify-content: center; font-size: 22px;">
            <i class="bi bi-bell-fill"></i>
        </div>
        <div style="flex: 1; min-width: 200px;">
            <div style="font-weight: 800; color: var(--en-primary-dark); font-size: 14px;">
                🔔 <?= $belum_verifikasi ?> LPJ menunggu verifikasi akhir Anda
            </div>
            <div style="color: var(--en-text); font-size: 13px; margin-top: 2px;">
                LPJ sudah diverifikasi Ketua & Pembina, siap verifikasi akhir.
            </div>
        </div>
        <a href="<?= site_url('validator/report') ?>" class="en-btn en-btn-primary">
            <i class="bi bi-eye"></i> Lihat
        </a>
    </div>
</div>
<?php endif; ?>

<!-- STAT CARDS -->
<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-file-earmark-text-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_all ?? 0 ?></div>
        <div class="en-stat__lbl">Total Event</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-hourglass-split"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_pending ?? 0 ?></div>
        <div class="en-stat__lbl">Pending Validasi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-check-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_publish ?? 0 ?></div>
        <div class="en-stat__lbl">Dipublikasikan</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-x-circle-fill"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_reject ?? 0 ?></div>
        <div class="en-stat__lbl">Ditolak</div>
    </div>
</div>

<!-- CHART + LPJ PENDING -->
<div class="row g-4 mb-4">
    <div class="col-lg-7">
        <div class="en-card h-100">
            <div class="en-card__head">
                <div>
                    <h3>Aktivitas Validasi <?= $chartYear ?? date('Y') ?></h3>
                    <p>Event divalidasi per bulan</p>
                </div>
            </div>
            <div style="position: relative; height: 280px;">
                <canvas id="validatorChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3>LPJ Menunggu Verifikasi</h3>
                <?php if (!empty($reportPendingList)): ?>
                    <span class="en-badge en-badge-warning"><?= count($reportPendingList) ?> pending</span>
                <?php endif; ?>
            </div>

            <?php if (!empty($reportPendingList)): ?>
                <div class="en-feed">
                    <?php foreach (array_slice($reportPendingList, 0, 5) as $r): ?>
                        <a href="<?= site_url('validator/report/detail/' . $r['id_report']) ?>"
                           class="en-feed__item" style="text-decoration: none; color: inherit;">
                            <div class="en-feed__ico" style="background: linear-gradient(135deg, #F59E0B, #B45309);">
                                <i class="bi bi-file-earmark-check-fill"></i>
                            </div>
                            <div class="en-feed__body">
                                <h6><?= esc($r['nama_event'] ?? '-') ?></h6>
                                <small>
                                    <i class="bi bi-building"></i> <?= esc($r['nama_ormawa'] ?? '-') ?>
                                    <?php if (!empty($r['tanggal'])): ?>
                                        • <?= date('d M Y', strtotime($r['tanggal'])) ?>
                                    <?php endif; ?>
                                </small>
                            </div>
                            <i class="bi bi-chevron-right" style="color: var(--en-primary);"></i>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="en-empty" style="padding: 30px 10px;">
                    <i class="bi bi-check2-circle" style="font-size: 40px;"></i>
                    <p>Mantap! Tidak ada LPJ pending.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- PROGRESS UKM -->
<?php
$listUKM = array_values(array_filter($progressOrmawa ?? [], fn($x) => ($x['ormawa']['kategori'] ?? '') === 'UKM'));
$listHMJ = array_values(array_filter($progressOrmawa ?? [], fn($x) => ($x['ormawa']['kategori'] ?? '') === 'HMJ'));
?>

<?php if (!empty($listUKM)): ?>
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-people-fill me-2" style="color: var(--en-primary);"></i> Progress UKM (<?= count($listUKM) ?>)</h3>
    </div>
    <div class="table-responsive">
        <table class="en-table">
            <thead>
                <tr>
                    <th style="min-width: 200px;">Ormawa</th>
                    <th style="text-align: center;">Progja</th>
                    <th style="text-align: center;">Proposal</th>
                    <th style="text-align: center;">Report / LPJ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listUKM as $p): $o = $p['ormawa']; ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <?php if (!empty($o['logo']) && file_exists('uploads/logo/' . $o['logo'])): ?>
                                    <img src="<?= base_url('uploads/logo/' . $o['logo']) ?>"
                                         style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 36px; height: 36px; border-radius: 50%;
                                                background: var(--en-grad-primary); color: white;
                                                display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <strong style="color: var(--en-dark); font-size: 13px;"><?= esc($o['nama_ormawa']) ?></strong>
                                    <div style="font-size: 10.5px; color: var(--en-muted); font-weight: 600;">UKM</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; color: var(--en-dark); line-height: 1;"><?= $p['progja_total'] ?></div>
                            <div style="font-size: 10.5px; color: var(--en-muted); margin-bottom: 6px;">program kerja</div>
                            <div style="display: flex; gap: 4px; justify-content: center; flex-wrap: wrap;">
                                <?php if ($p['progja_approved'] > 0): ?>
                                    <span class="en-badge en-badge-success" style="font-size: 10px;">✅ <?= $p['progja_approved'] ?></span>
                                <?php endif; ?>
                                <?php if ($p['progja_pending'] > 0): ?>
                                    <span class="en-badge en-badge-warning" style="font-size: 10px;">⏳ <?= $p['progja_pending'] ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; color: var(--en-dark); line-height: 1;">
                                <?= $p['proposal_total'] ?>
                                <span style="font-size: 13px; color: var(--en-muted); font-weight: 600;">/<?= $p['progja_approved'] ?></span>
                            </div>
                            <div style="background: var(--en-border); border-radius: 10px; height: 6px; overflow: hidden; margin-top: 8px;">
                                <div style="width: <?= $p['progress_proposal'] ?>%; height: 100%; background: linear-gradient(90deg, #22C55E, #15803D);"></div>
                            </div>
                            <div style="font-size: 10px; color: var(--en-muted); font-weight: 700; margin-top: 4px;"><?= $p['progress_proposal'] ?>%</div>
                        </td>
                        <td style="text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; color: var(--en-dark); line-height: 1;">
                                <?= $p['report_total'] ?>
                                <span style="font-size: 13px; color: var(--en-muted); font-weight: 600;">/<?= $p['proposal_approved'] ?></span>
                            </div>
                            <div style="background: var(--en-border); border-radius: 10px; height: 6px; overflow: hidden; margin-top: 8px;">
                                <div style="width: <?= $p['progress_report'] ?>%; height: 100%; background: linear-gradient(90deg, #3B82F6, #1D4ED8);"></div>
                            </div>
                            <div style="font-size: 10px; color: var(--en-muted); font-weight: 700; margin-top: 4px;"><?= $p['progress_report'] ?>%</div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php if (!empty($listHMJ)): ?>
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-mortarboard-fill me-2" style="color: var(--en-primary);"></i> Progress HMJ (<?= count($listHMJ) ?>)</h3>
    </div>
    <div class="table-responsive">
        <table class="en-table">
            <thead>
                <tr>
                    <th style="min-width: 200px;">Ormawa</th>
                    <th style="text-align: center;">Progja</th>
                    <th style="text-align: center;">Proposal</th>
                    <th style="text-align: center;">Report / LPJ</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($listHMJ as $p): $o = $p['ormawa']; ?>
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <?php if (!empty($o['logo']) && file_exists('uploads/logo/' . $o['logo'])): ?>
                                    <img src="<?= base_url('uploads/logo/' . $o['logo']) ?>"
                                         style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">
                                <?php else: ?>
                                    <div style="width: 36px; height: 36px; border-radius: 50%;
                                                background: var(--en-grad-primary); color: white;
                                                display: flex; align-items: center; justify-content: center; font-size: 14px;">
                                        <i class="bi bi-building"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <strong style="color: var(--en-dark); font-size: 13px;"><?= esc($o['nama_ormawa']) ?></strong>
                                    <div style="font-size: 10.5px; color: var(--en-muted); font-weight: 600;">HMJ</div>
                                </div>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; color: var(--en-dark); line-height: 1;"><?= $p['progja_total'] ?></div>
                            <div style="font-size: 10.5px; color: var(--en-muted); margin-bottom: 6px;">program kerja</div>
                        </td>
                        <td style="text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; color: var(--en-dark); line-height: 1;">
                                <?= $p['proposal_total'] ?> <span style="font-size: 13px; color: var(--en-muted);">/<?= $p['progja_approved'] ?></span>
                            </div>
                            <div style="background: var(--en-border); border-radius: 10px; height: 6px; overflow: hidden; margin-top: 8px;">
                                <div style="width: <?= $p['progress_proposal'] ?>%; height: 100%; background: linear-gradient(90deg, #22C55E, #15803D);"></div>
                            </div>
                            <div style="font-size: 10px; color: var(--en-muted); font-weight: 700; margin-top: 4px;"><?= $p['progress_proposal'] ?>%</div>
                        </td>
                        <td style="text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; color: var(--en-dark); line-height: 1;">
                                <?= $p['report_total'] ?> <span style="font-size: 13px; color: var(--en-muted);">/<?= $p['proposal_approved'] ?></span>
                            </div>
                            <div style="background: var(--en-border); border-radius: 10px; height: 6px; overflow: hidden; margin-top: 8px;">
                                <div style="width: <?= $p['progress_report'] ?>%; height: 100%; background: linear-gradient(90deg, #3B82F6, #1D4ED8);"></div>
                            </div>
                            <div style="font-size: 10px; color: var(--en-muted); font-weight: 700; margin-top: 4px;"><?= $p['progress_report'] ?>%</div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- EVENT PENDING -->
<div class="en-card mb-4">
    <div class="en-card__head">
        <h3><i class="bi bi-exclamation-triangle-fill me-2" style="color: var(--en-primary);"></i> Event Pending Validasi (<?= $total_pending ?? 0 ?>)</h3>
    </div>

    <?php if (!empty($data_pending)): ?>
        <div class="table-responsive">
            <table class="en-table">
                <thead>
                    <tr>
                        <th style="width: 40px;">#</th>
                        <th>Nama Event</th>
                        <th>Ormawa</th>
                        <th>Tanggal</th>
                        <th>Gedung</th>
                        <th style="text-align: center;">RAB</th>
                        <th style="text-align: center; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($data_pending as $e): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong style="color: var(--en-dark);"><?= esc($e['nama_event']) ?></strong></td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <?php if (!empty($e['ormawa_logo']) && file_exists('uploads/logo/' . $e['ormawa_logo'])): ?>
                                        <img src="<?= base_url('uploads/logo/' . $e['ormawa_logo']) ?>"
                                             style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover;">
                                    <?php endif; ?>
                                    <span style="font-size: 13px;"><?= esc($e['nama_ormawa'] ?? '-') ?></span>
                                </div>
                            </td>
                            <td style="font-size: 13px;"><?= date('d M Y', strtotime($e['tanggal'])) ?></td>
                            <td style="font-size: 13px;"><?= esc($e['gedung'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <?php if (!empty($e['total_biaya'])): ?>
                                    <span class="en-badge en-badge-primary">
                                        Rp <?= number_format($e['total_biaya'], 0, ',', '.') ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: var(--en-muted); font-size: 11px;">Belum ada RAB</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="<?= site_url('validator/approve/' . $e['id_event']) ?>"
                                   onclick="return confirm('Setujui dan publikasikan event ini?')"
                                   class="en-btn en-btn-primary en-btn-sm" title="Setujui">
                                    <i class="bi bi-check-lg"></i>
                                </a>
                                <a href="<?= site_url('validator/reject/' . $e['id_event']) ?>"
                                   onclick="return confirm('Tolak event ini?')"
                                   class="en-btn en-btn-light en-btn-sm" style="color: var(--en-danger);" title="Tolak">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                                <a href="<?= base_url('detail_event/' . $e['id_event']) ?>" target="_blank"
                                   class="en-btn en-btn-light en-btn-sm" title="Lihat">
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
            <i class="bi bi-check2-circle"></i>
            <h5>Mantap! Tidak ada event yang menunggu validasi. 🎉</h5>
        </div>
    <?php endif; ?>
</div>

<!-- QUICK ACTION -->
<div class="en-card">
    <div class="en-card__head">
        <h3>Aksi Cepat</h3>
    </div>
    <div class="en-qa-grid" style="grid-template-columns: repeat(4, 1fr);">
        <a href="<?= site_url('validator/progja') ?>" class="en-qa en-qa-1">
            <i class="bi bi-clipboard-check"></i>
            <h5>Program Kerja</h5>
            <small>Validasi progja</small>
        </a>
        <a href="<?= site_url('validator/proposal') ?>" class="en-qa en-qa-2">
            <i class="bi bi-file-earmark-text-fill"></i>
            <h5>Proposal</h5>
            <small>Verifikasi</small>
        </a>
        <a href="<?= site_url('validator/report') ?>" class="en-qa en-qa-3">
            <i class="bi bi-file-earmark-check-fill"></i>
            <h5>Verifikasi LPJ</h5>
            <small><?= $belum_verifikasi ?? 0 ?> pending</small>
        </a>
        <a href="<?= site_url('validator/ormawa') ?>" class="en-qa en-qa-4">
            <i class="bi bi-people-fill"></i>
            <h5>Kelola Ormawa</h5>
            <small>Manajemen akun</small>
        </a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const canvas = document.getElementById('validatorChart');
    if (!canvas || typeof Chart === 'undefined') return;

    const chartData = <?= json_encode($chartData ?? [0,0,0,0,0,0,0,0,0,0,0,0]) ?>;
    const adaData = chartData.some(v => v > 0);

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                data: chartData,
                backgroundColor: 'rgba(255,122,0,0.7)',
                borderColor: '#FF7A00',
                borderWidth: 2,
                borderRadius: 8,
                hoverBackgroundColor: 'rgba(230,81,0,0.9)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, suggestedMax: adaData ? undefined : 5, ticks: { stepSize: 1, precision: 0, color: '#64748B' }, grid: { color: '#F1F5F9' }, border: { display: false } },
                x: { ticks: { color: '#64748B' }, grid: { display: false }, border: { display: false } }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>