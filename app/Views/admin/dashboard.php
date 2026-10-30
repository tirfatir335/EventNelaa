<?= $this->extend('layout/en_layout') ?>
<?= $this->section('content') ?>

<!-- WELCOME -->
<div class="en-welcome">
    <div class="en-welcome__top">
        <div>
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;
                        background: rgba(255,255,255,.2); border: 1px solid rgba(255,255,255,.3);
                        padding: 5px 14px; border-radius: 20px; width: fit-content; font-size: 11px;
                        font-weight: 700; letter-spacing: .5px;">
                <i class="bi bi-building-fill-check"></i> PANEL PENGELOLA GEDUNG
            </div>
            <h2>Selamat Datang!</h2>
        </div>
        <span class="date"><i class="bi bi-calendar3"></i> <?= date('d F Y') ?></span>
    </div>

    <div class="en-welcome__stats">
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-building"></i></div>
            <div class="lbl">Total Gedung</div>
            <div class="val"><?= $total_gedung ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="lbl">Butuh Validasi</div>
            <div class="val"><?= $total_pending_gedung ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-calendar-check"></i></div>
            <div class="lbl">Booking Hari Ini</div>
            <div class="val"><?= $booking_hari_ini ?? 0 ?></div>
        </div>
        <div class="en-welcome__stat">
            <div class="ico"><i class="bi bi-calendar3"></i></div>
            <div class="lbl">Bulan Ini</div>
            <div class="val"><?= $booking_bulan_ini ?? 0 ?></div>
        </div>
    </div>
</div>

<!-- STAT CARDS -->
<div class="en-stat-grid">
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: var(--en-grad-primary);"><i class="bi bi-building"></i></div>
        </div>
        <div class="en-stat__val"><?= $total_gedung ?? 0 ?></div>
        <div class="en-stat__lbl">Total Gedung</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #EF4444, #B91C1C);"><i class="bi bi-shield-check"></i></div>
            <span class="en-stat__trend" style="background: var(--en-danger-soft); color: #B91C1C;">Aksi</span>
        </div>
        <div class="en-stat__val" style="color: #B91C1C;"><?= $total_pending_gedung ?? 0 ?></div>
        <div class="en-stat__lbl">Butuh Validasi</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #3B82F6, #1D4ED8);"><i class="bi bi-calendar-check"></i></div>
        </div>
        <div class="en-stat__val"><?= $booking_hari_ini ?? 0 ?></div>
        <div class="en-stat__lbl">Booking Hari Ini</div>
    </div>
    <div class="en-stat">
        <div class="en-stat__top">
            <div class="en-stat__ico" style="background: linear-gradient(135deg, #22C55E, #15803D);"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
        <div class="en-stat__val"><?= $booking_bulan_ini ?? 0 ?></div>
        <div class="en-stat__lbl">Bulan Ini</div>
    </div>
</div>

<!-- CHART + BOOKING TERBARU -->
<div class="row g-4 mb-4">
    <div class="col-lg-6">
        <div class="en-card h-100">
            <div class="en-card__head">
                <div>
                    <h3>Jadwal Booking Gedung</h3>
                    <p><?= date('F Y') ?></p>
                </div>
            </div>
            <div id="kalenderAdmin" style="padding: 8px 16px; max-width: 560px; margin: 0 auto;"></div>

            <!-- PANEL DETAIL EVENT (muncul saat tanggal diklik) -->
            <div id="detailBooking" style="display:none; margin-top: 18px; padding-top: 16px;
                                           border-top: 2px solid var(--en-border); animation: fadeIn .25s;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 12px;">
                    <h4 id="detailTanggal" style="font-size: 14px; font-weight: 800; color: var(--en-dark); margin:0;"></h4>
                    <button onclick="tutupDetail()" class="en-btn en-btn-light en-btn-sm" title="Tutup">×</button>
                </div>
                <div id="detailList"></div>
            </div>

            <style>
                @keyframes fadeIn {
                    from { opacity: 0; transform: translateY(8px); }
                    to   { opacity: 1; transform: translateY(0); }
                }
                .en-booking-item {
                    display: flex; gap: 12px; align-items: center;
                    background: var(--en-bg-alt); padding: 12px 14px;
                    border-radius: 12px; margin-bottom: 8px;
                    border-left: 4px solid var(--en-primary);
                    transition: .2s;
                }
                .en-booking-item:hover {
                    background: var(--en-primary-soft);
                    transform: translateX(4px);
                }
                .en-booking-item .time {
                    background: var(--en-grad-primary); color: white;
                    padding: 8px 12px; border-radius: 10px;
                    font-weight: 800; font-size: 12px; flex-shrink: 0;
                    display: flex; align-items: center; gap: 4px;
                }
                .en-booking-item .info h6 {
                    font-size: 14px; font-weight: 800; color: var(--en-dark);
                    margin: 0 0 4px;
                }
                .en-booking-item .info small {
                    font-size: 11.5px; color: var(--en-muted);
                    display: block; line-height: 1.5;
                }
            </style>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="en-card h-100">
            <div class="en-card__head">
                <h3>Booking Terbaru</h3>
                <a href="<?= site_url('admin/validasi') ?>" class="en-btn en-btn-outline en-btn-sm">Lihat Semua</a>
            </div>

            <?php if (!empty($booking_terbaru)): ?>
                <div class="en-feed">
                    <?php foreach (array_slice($booking_terbaru, 0, 5) as $b): ?>
                        <div class="en-feed__item">
                            <div class="en-feed__ico" style="background: var(--en-grad-primary);">
                                <i class="bi bi-calendar-event-fill"></i>
                            </div>
                            <div class="en-feed__body">
                                <h6><?= esc($b['nama_event']) ?></h6>
                                <small>
                                    <i class="bi bi-building"></i> <?= esc($b['nama_ormawa'] ?? '-') ?>
                                    • <?= date('d M Y', strtotime($b['tanggal'])) ?>
                                </small>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="en-empty" style="padding: 30px 10px;">
                    <i class="bi bi-calendar-x" style="font-size: 40px;"></i>
                    <p>Belum ada booking.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- QUICK ACTION -->
<div class="en-card">
    <div class="en-card__head">
        <h3>Aksi Cepat</h3>
    </div>
    <div class="en-qa-grid">
        <a href="<?= site_url('admin/validasi') ?>" class="en-qa en-qa-1">
            <i class="bi bi-shield-check"></i>
            <h5>Validasi Gedung</h5>
            <small><?= $total_pending_gedung ?? 0 ?> menunggu</small>
        </a>
        <a href="<?= site_url('admin/gedung/tambah') ?>" class="en-qa en-qa-2">
            <i class="bi bi-plus-circle-fill"></i>
            <h5>Tambah Gedung</h5>
            <small>Daftarkan gedung baru</small>
        </a>
        <a href="<?= site_url('admin/gedung') ?>" class="en-qa en-qa-3">
            <i class="bi bi-building"></i>
            <h5>Kelola Gedung</h5>
            <small><?= $total_gedung ?? 0 ?> gedung terdaftar</small>
        </a>
        <a href="<?= site_url('admin/profil') ?>" class="en-qa en-qa-4">
            <i class="bi bi-person-circle"></i>
            <h5>Profil Saya</h5>
            <small>Kelola akun admin</small>
        </a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const eventsByDate = <?= json_encode($eventsByDate ?? []) ?>;

const monthNames = ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];
const hariNames = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

const now = new Date();
let currentYear  = now.getFullYear();
let currentMonth = now.getMonth();

function renderMiniCalendar() {
    const wrap = document.getElementById('kalenderAdmin');
    if (!wrap) return;

    function draw(y, m) {
        const firstDay = new Date(y, m, 1).getDay();
        const offset = (firstDay === 0) ? 6 : firstDay - 1;
        const daysInMonth = new Date(y, m + 1, 0).getDate();
        const todayStr = new Date().toISOString().slice(0, 10);

        let html = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                <button class="en-btn en-btn-light en-btn-sm" onclick="window._navCal(-1)">‹</button>
                <strong style="font-size: 14px; color: var(--en-dark);">${monthNames[m]} ${y}</strong>
                <button class="en-btn en-btn-light en-btn-sm" onclick="window._navCal(1)">›</button>
            </div>
            <div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px; margin-bottom: 6px;">
        `;
        ['Sen','Sel','Rab','Kam','Jum','Sab','Min'].forEach(d => {
            html += `<div style="text-align: center; font-size: 11px; font-weight: 800; color: var(--en-muted);">${d}</div>`;
        });
        html += `</div><div style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 5px;">`;

        for (let i = 0; i < offset; i++) html += `<div></div>`;

        for (let d = 1; d <= daysInMonth; d++) {
            const dateStr = `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
            const events = eventsByDate[dateStr] || [];
            const isToday = dateStr === todayStr;
            const hasEvent = events.length > 0;

            const bg = hasEvent ? 'var(--en-grad-primary)' : (isToday ? 'var(--en-primary-soft)' : 'var(--en-bg-alt)');
            const color = hasEvent ? 'white' : 'var(--en-text)';
            const border = isToday ? '2px solid var(--en-primary-light)' : '2px solid transparent';

            html += `
                <div style="min-height: 48px; padding: 6px 4px; border-radius: 10px; display: flex; flex-direction: column;
                            align-items: center; justify-content: center; background: ${bg}; color: ${color};
                            border: ${border}; font-weight: 700; font-size: 13px; position: relative;
                            cursor: ${hasEvent ? 'pointer' : 'default'};"
                     ${hasEvent ? `onclick="tampilDetail('${dateStr}')"` : ''}>
                    ${d}
                    ${hasEvent ? `<span style="position: absolute; top: 3px; right: 3px;
                                            background: #FCD34D; color: #0F172A; font-size: 9px;
                                            font-weight: 800; padding: 1px 5px; border-radius: 6px;
                                            min-width: 14px; text-align: center;">${events.length}</span>` : ''}
                </div>
            `;
        }

        html += `</div>`;
        wrap.innerHTML = html;
    }

    window._navCal = function(dir) {
        currentMonth += dir;
        if (currentMonth < 0) { currentMonth = 11; currentYear--; }
        if (currentMonth > 11) { currentMonth = 0; currentYear++; }
        tutupDetail();
        draw(currentYear, currentMonth);
    };

    draw(currentYear, currentMonth);
}

function tampilDetail(dateStr) {
    const events = eventsByDate[dateStr] || [];
    if (!events.length) return;

    const d = new Date(dateStr + 'T00:00:00');
    document.getElementById('detailTanggal').innerHTML =
        '📅 ' + hariNames[d.getDay()] + ', ' + d.getDate() + ' ' + monthNames[d.getMonth()] + ' ' + d.getFullYear();

    const list = events.map(e => `
        <div class="en-booking-item">
            <div class="time"><i class="bi bi-clock-fill"></i> ${(e.waktu || '00:00').substring(0,5)}</div>
            <div class="info" style="flex:1; min-width:0;">
                <h6>${e.nama_event}</h6>
                <small>
                    <i class="bi bi-people-fill"></i> <strong>${e.nama_ormawa || '-'}</strong>
                    &nbsp;•&nbsp;
                    <i class="bi bi-geo-alt-fill"></i> ${e.gedung || '-'}
                </small>
                <small style="margin-top:3px;">
                    <span style="color:#15803D; font-weight:800;">● ${e.status || '-'}</span>
                </small>
            </div>
        </div>
    `).join('');

    document.getElementById('detailList').innerHTML = list;
    document.getElementById('detailBooking').style.display = 'block';
}

function tutupDetail() {
    const el = document.getElementById('detailBooking');
    if (el) el.style.display = 'none';
}

renderMiniCalendar();
</script>
<?= $this->endSection() ?>