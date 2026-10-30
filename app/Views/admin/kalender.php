<?= $this->extend('layout/admin_layout'); ?>
<?= $this->section('content'); ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .page-header-admin {
        background: linear-gradient(135deg, #ff7a00 0%, #e65100 100%);
        color: white;
        border-radius: 20px;
        padding: 30px 32px;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(255, 122, 0, 0.25);
    }
    .page-header-admin::before {
        content: '';
        position: absolute;
        top: -50%; right: -20%;
        width: 400px; height: 400px;
        background: rgba(255,255,255,0.08);
        border-radius: 50%;
    }
    .page-header-content-admin {
        position: relative; z-index: 2;
    }
    .page-header-content-admin h2 {
        font-size: 24px; font-weight: 800; margin-bottom: 6px;
    }
    .page-header-content-admin p {
        font-size: 14px; opacity: 0.9; margin: 0;
    }

    .kalender-wrap {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        margin-bottom: 24px;
    }
    .kalender-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }
    .kalender-header h3 {
        font-size: 20px; font-weight: 800; color: #1a1a2e;
        margin: 0; text-transform: capitalize;
    }
    .nav-btn {
        background: #fff3e0; color: #ff7a00; border: none;
        width: 40px; height: 40px; border-radius: 50%;
        font-size: 18px; cursor: pointer; transition: 0.2s;
        display: flex; align-items: center; justify-content: center;
    }
    .nav-btn:hover {
        background: #ff7a00; color: white; transform: scale(1.05);
    }
    .kalender-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
        margin-bottom: 10px;
    }
    .kalender-days > div {
        text-align: center; font-size: 12px; font-weight: 800;
        color: #888; padding: 8px 0; text-transform: uppercase;
    }
    .kalender-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 6px;
    }
    .kalender-cell {
        aspect-ratio: 1;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.25s;
        background: #f8f9fa;
        border: 2px solid transparent;
        position: relative;
        font-weight: 600;
        color: #333;
    }
    .kalender-cell.empty {
        background: transparent;
        cursor: default;
    }
    .kalender-cell:not(.empty):not(.has-event):hover {
        background: #fff3e0;
        border-color: #ff7a00;
    }
    .kalender-cell .date-num {
        font-size: 15px; line-height: 1;
    }
    .kalender-cell.has-event {
        background: linear-gradient(135deg, #ff7a00, #e65100);
        color: white;
        box-shadow: 0 4px 12px rgba(255, 122, 0, 0.35);
    }
    .kalender-cell.has-event:hover {
        transform: scale(1.08);
        box-shadow: 0 8px 25px rgba(255, 122, 0, 0.5);
    }
    .kalender-cell .event-count {
        position: absolute; top: 3px; right: 3px;
        background: #ffd700; color: #1a1a2e;
        font-size: 9px; font-weight: 800;
        padding: 1px 5px; border-radius: 8px;
        min-width: 14px; text-align: center; line-height: 1.4;
    }
    .kalender-cell.today {
        border-color: #ffd700;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.25);
    }
    .kalender-cell.today.has-event {
        border-color: #ffd700;
        box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.4), 0 4px 12px rgba(255, 122, 0, 0.35);
    }
    .kalender-legend {
        display: flex; gap: 24px; justify-content: center;
        margin-top: 20px; padding-top: 16px;
        border-top: 1px solid #f0f0f0;
        font-size: 12px; color: #666; font-weight: 500;
    }
    .kalender-legend .dot {
        display: inline-block; width: 12px; height: 12px;
        border-radius: 4px; margin-right: 6px; vertical-align: middle;
    }
    .dot-event { background: linear-gradient(135deg, #ff7a00, #e65100); }
    .dot-today { background: #ffd700; }

    .kalender-event-panel {
        background: white;
        border-radius: 20px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        border-left: 5px solid #ff7a00;
        animation: slideUp 0.3s;
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(15px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .panel-header {
        display: flex; justify-content: space-between;
        align-items: center; margin-bottom: 16px;
    }
    .panel-header h4 {
        font-size: 17px; font-weight: 800; color: #1a1a2e; margin: 0;
    }
    .close-panel {
        background: #fff3e0; border: none; color: #ff7a00;
        width: 32px; height: 32px; border-radius: 50%;
        font-size: 20px; font-weight: 700; cursor: pointer;
        display: flex; align-items: center; justify-content: center;
    }
    .close-panel:hover { background: #ff7a00; color: white; }
    .event-item-kalender {
        display: flex; gap: 14px;
        padding: 14px 16px; border-radius: 12px;
        background: #f8f9fa; margin-bottom: 10px;
        text-decoration: none; color: inherit;
        transition: 0.2s; border-left: 4px solid #ff7a00;
        align-items: center;
    }
    .event-item-kalender:hover {
        background: #fff3e0; color: inherit; transform: translateX(4px);
    }
    .event-item-kalender .time-badge {
        background: linear-gradient(135deg, #ff7a00, #e65100);
        color: white; padding: 8px 14px; border-radius: 10px;
        font-weight: 700; font-size: 13px; flex-shrink: 0;
        display: flex; align-items: center; gap: 4px;
    }
    .event-item-kalender .info { flex: 1; }
    .event-item-kalender .info h6 {
        font-size: 15px; font-weight: 700; margin: 0 0 4px; color: #1a1a2e;
    }
    .event-item-kalender .info small { font-size: 12px; color: #888; }
</style>

<div class="page-header-admin">
    <div class="page-header-content-admin">
        <h2><i class="bi bi-calendar3"></i> Kalender Gedung</h2>
        <p>Pantau jadwal booking gedung tanpa catat manual</p>
    </div>
</div>

<div class="kalender-wrap">
    <div class="kalender-header">
        <button class="nav-btn" onclick="prevMonth()">
            <i class="bi bi-chevron-left"></i>
        </button>
        <h3 id="currentMonthLabel">Memuat...</h3>
        <button class="nav-btn" onclick="nextMonth()">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="kalender-days">
        <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div>
        <div>Jum</div><div>Sab</div><div>Min</div>
    </div>

    <div class="kalender-grid" id="kalenderGrid"></div>

    <div class="kalender-legend">
        <span><span class="dot dot-event"></span> Ada Booking</span>
        <span><span class="dot dot-today"></span> Hari Ini</span>
    </div>
</div>

<div class="kalender-event-panel" id="kalenderEventPanel" style="display:none;">
    <div class="panel-header">
        <h4 id="selectedDateLabel"></h4>
        <button class="close-panel" onclick="hideEventPanel()">×</button>
    </div>
    <div id="selectedDateEvents"></div>
</div>

<script>
const eventsByDate = <?= json_encode($eventsByDate ?? []) ?>;

let currentDate  = new Date();
let currentYear  = currentDate.getFullYear();
let currentMonth = currentDate.getMonth();

const monthNames = ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];

function renderKalender(year, month) {
    document.getElementById('currentMonthLabel').textContent = monthNames[month] + ' ' + year;

    const grid = document.getElementById('kalenderGrid');
    grid.innerHTML = '';

    let firstDay = new Date(year, month, 1).getDay();
    firstDay = (firstDay === 0) ? 6 : firstDay - 1;

    const daysInMonth = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        const cell = document.createElement('div');
        cell.className = 'kalender-cell empty';
        grid.appendChild(cell);
    }

    const today = new Date();
    const todayStr = today.getFullYear() + '-'
        + String(today.getMonth() + 1).padStart(2, '0') + '-'
        + String(today.getDate()).padStart(2, '0');

    for (let day = 1; day <= daysInMonth; day++) {
        const dateStr = year + '-'
            + String(month + 1).padStart(2, '0') + '-'
            + String(day).padStart(2, '0');

        const cell = document.createElement('div');
        cell.className = 'kalender-cell';

        if (dateStr === todayStr) cell.classList.add('today');

        const events = eventsByDate[dateStr] || [];

        if (events.length > 0) {
            cell.classList.add('has-event');
            cell.innerHTML = `
                <span class="date-num">${day}</span>
                <span class="event-count">${events.length}</span>
            `;
            cell.onclick = () => showEvents(dateStr);
            cell.title = events.length + ' booking';
        } else {
            cell.innerHTML = `<span class="date-num">${day}</span>`;
        }

        grid.appendChild(cell);
    }
}

function prevMonth() {
    currentMonth--;
    if (currentMonth < 0) { currentMonth = 11; currentYear--; }
    renderKalender(currentYear, currentMonth);
    hideEventPanel();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) { currentMonth = 0; currentYear++; }
    renderKalender(currentYear, currentMonth);
    hideEventPanel();
}

function showEvents(dateStr) {
    const events = eventsByDate[dateStr] || [];
    const dateObj = new Date(dateStr + 'T00:00:00');
    const hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][dateObj.getDay()];

    document.getElementById('selectedDateLabel').textContent =
        '📅 ' + hari + ', ' + dateObj.getDate() + ' ' + monthNames[dateObj.getMonth()] + ' ' + dateObj.getFullYear();

    const container = document.getElementById('selectedDateEvents');
    container.innerHTML = events.map(e => `
        <div class="event-item-kalender">
            <div class="time-badge">
                <i class="bi bi-clock"></i> ${(e.waktu || '00:00').substring(0,5)}
            </div>
            <div class="info">
                <h6>${e.nama_event}</h6>
                <small>
                    <i class="bi bi-building me-1"></i>${e.nama_ormawa || '-'}
                    &nbsp;•&nbsp;
                    <i class="bi bi-geo-alt me-1"></i>${e.gedung || '-'}
                    &nbsp;•&nbsp;
                    <span style="color:#43a047; font-weight:700;">${e.status}</span>
                </small>
            </div>
        </div>
    `).join('');

    document.getElementById('kalenderEventPanel').style.display = 'block';
    document.getElementById('kalenderEventPanel').scrollIntoView({
        behavior: 'smooth', block: 'nearest'
    });
}

function hideEventPanel() {
    document.getElementById('kalenderEventPanel').style.display = 'none';
}

document.addEventListener('DOMContentLoaded', () => {
    renderKalender(currentYear, currentMonth);
});
</script>

<?= $this->endSection(); ?>