<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php
function auto_link_text($text) {
    $text = esc($text);
    return preg_replace(
        '~(https?://[^\s]+)~',
        '<a href="$1" target="_blank" style="color:#FF7A00;font-weight:600;">$1</a>',
        $text
    );
}
$isAkanDatang = strtotime($event['tanggal']) >= strtotime(date('Y-m-d'));
?>

<style>
.evd-hero {
    position: relative;
    padding: 60px 24px 80px;
    background:
        linear-gradient(135deg, rgba(15,23,42,.92) 0%, rgba(30,41,59,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    overflow: hidden;
}
.evd-hero::before {
    content: '';
    position: absolute;
    top: -30%; right: -10%;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(255,122,0,.25), transparent 65%);
    border-radius: 50%;
    pointer-events: none;
}
.evd-hero-inner {
    position: relative;
    z-index: 2;
    max-width: 1100px;
    margin: 0 auto;
}
.evd-breadcrumb {
    display: flex; gap: 8px;
    font-size: 13px;
    color: rgba(255,255,255,.7);
    margin-bottom: 26px;
    flex-wrap: wrap;
}
.evd-breadcrumb a { color: rgba(255,255,255,.85); text-decoration: none; transition: .2s; }
.evd-breadcrumb a:hover { color: #FF7A00; }
.evd-hero-grid {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 36px;
    align-items: center;
}
.evd-poster-wrap {
    position: relative;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0,0,0,.4);
    aspect-ratio: 3/4;
    background: linear-gradient(135deg, #FF7A00, #E65100);
}
.evd-poster-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    display: block;
    cursor: zoom-in;
    transition: .3s;
}
.evd-poster-wrap img:hover { transform: scale(1.03); }
.evd-poster-wrap .no-poster {
    display: flex; align-items: center; justify-content: center;
    height: 100%; color: rgba(255,255,255,.55); font-size: 80px;
}
.evd-status {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(34,197,94,.2);
    color: #4ADE80;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 11.5px;
    font-weight: 800;
    margin-bottom: 16px;
    border: 1px solid rgba(74,222,128,.35);
    letter-spacing: 1px;
    text-transform: uppercase;
}
.evd-status.selesai {
    background: rgba(148,163,184,.2);
    color: #CBD5E1;
    border-color: rgba(203,213,225,.3);
}
.evd-info h1 {
    font-size: clamp(24px, 3.5vw, 40px);
    font-weight: 900;
    line-height: 1.15;
    letter-spacing: -1px;
    margin: 0 0 22px;
    color: white;
}
.evd-org-box {
    display: flex; align-items: center; gap: 14px;
    padding: 14px 18px;
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 16px;
    margin-bottom: 22px;
    backdrop-filter: blur(10px);
}
.evd-org-logo {
    width: 48px; height: 48px;
    border-radius: 50%;
    object-fit: cover;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
    border: 2px solid rgba(255,255,255,.3);
}
.evd-org-box small {
    font-size: 11px;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
}
.evd-org-box h4 {
    font-size: 15px;
    font-weight: 800;
    margin: 2px 0 0;
    color: white;
}
.evd-meta-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}
.evd-meta-item {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 14px;
    padding: 14px 12px;
    text-align: center;
    backdrop-filter: blur(10px);
}
.evd-meta-item i {
    color: #FF7A00;
    font-size: 20px;
    display: block;
    margin-bottom: 6px;
}
.evd-meta-item small {
    font-size: 10.5px;
    color: rgba(255,255,255,.6);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 700;
    display: block;
    margin-bottom: 4px;
}
.evd-meta-item strong {
    font-size: 13px;
    color: white;
    font-weight: 700;
    display: block;
}

.evd-section { padding: 60px 24px 20px; }
.evd-inner { max-width: 1100px; margin: 0 auto; }
.evd-title {
    display: flex; align-items: center; gap: 12px;
    font-size: 22px;
    font-weight: 900;
    color: #0F172A;
    letter-spacing: -.5px;
    margin-bottom: 22px;
    padding-bottom: 16px;
    border-bottom: 3px solid #F1F5F9;
}
.evd-title i { color: #FF7A00; font-size: 24px; }

.evd-desc-card {
    background: white;
    border-radius: 20px;
    padding: 28px 32px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    border-left: 5px solid #FF7A00;
    font-size: 15.5px;
    color: #334155;
    line-height: 1.9;
    white-space: pre-line;
}

.evd-rating-summary {
    background: white;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    display: flex;
    align-items: center;
    gap: 30px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.evd-rating-big { text-align: center; }
.evd-rating-num {
    font-size: 56px;
    font-weight: 900;
    color: #FF7A00;
    line-height: 1;
    letter-spacing: -2px;
}
.evd-rating-max { font-size: 14px; color: #94A3B8; }
.evd-rating-stars { font-size: 18px; margin-top: 8px; }
.evd-rating-detail { flex: 1; min-width: 200px; }
.evd-rating-detail .total { font-size: 14.5px; color: #475569; margin-bottom: 6px; }

.evd-form-card {
    background: white;
    border-radius: 20px;
    padding: 28px;
    box-shadow: 0 10px 40px rgba(15,23,42,.06);
    margin-bottom: 24px;
    border-top: 5px solid #FF7A00;
}
.evd-form-card h4 {
    font-size: 17px;
    font-weight: 800;
    color: #0F172A;
    margin: 0 0 18px;
    display: flex; align-items: center; gap: 8px;
}
.evd-stars { display: flex; gap: 8px; margin-bottom: 16px; }
.evd-stars i {
    font-size: 34px;
    color: #E2E8F0;
    cursor: pointer;
    transition: .2s;
}
.evd-stars i:hover, .evd-stars i.active {
    color: #FFD700;
    transform: scale(1.15);
}
.evd-form-card textarea {
    width: 100%;
    border: 2px solid #E2E8F0;
    border-radius: 14px;
    padding: 14px 18px;
    font-size: 14px;
    resize: vertical;
    min-height: 110px;
    font-family: inherit;
    outline: none;
    transition: .3s;
}
.evd-form-card textarea:focus {
    border-color: #FF7A00;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.evd-btn-submit {
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border: none;
    padding: 13px 30px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 14px;
    cursor: pointer;
    margin-top: 14px;
    display: inline-flex; align-items: center; gap: 8px;
    box-shadow: 0 8px 20px rgba(255,122,0,.3);
    transition: .3s;
    font-family: inherit;
}
.evd-btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 28px rgba(255,122,0,.4); }

.evd-alert {
    border-radius: 14px;
    padding: 16px 20px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}
.evd-alert.info { background: #DBEAFE; color: #1D4ED8; border: 1px solid #BFDBFE; }
.evd-alert.success { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
.evd-alert.warning { background: #FEF3C7; color: #B45309; border: 1px solid #FDE68A; }
.evd-alert a { color: inherit; font-weight: 800; text-decoration: underline; }

.evd-review {
    background: white;
    border-radius: 18px;
    padding: 22px 24px;
    box-shadow: 0 4px 15px rgba(15,23,42,.04);
    margin-bottom: 16px;
    border-left: 4px solid #FF7A00;
    transition: .3s;
}
.evd-review:hover { transform: translateX(5px); box-shadow: 0 10px 30px rgba(255,122,0,.1); }
.evd-review-head {
    display: flex; justify-content: space-between;
    align-items: flex-start; margin-bottom: 12px; gap: 12px;
}
.evd-user {
    display: flex; align-items: center; gap: 12px;
}
.evd-avatar {
    width: 44px; height: 44px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #FFF3E0;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    display: flex; align-items: center; justify-content: center;
    font-weight: 800; font-size: 16px;
    flex-shrink: 0;
}
.evd-user-name { font-size: 14px; font-weight: 800; color: #0F172A; margin-bottom: 2px; }
.evd-user-stars { font-size: 12.5px; color: #FFD700; }
.evd-user-stars .muted { color: #94A3B8; font-size: 11px; margin-left: 4px; }
.evd-review-time { font-size: 11.5px; color: #94A3B8; }
.evd-review-text {
    font-size: 14.5px;
    color: #475569;
    line-height: 1.75;
    padding-left: 56px;
}

.evd-empty-review {
    text-align: center;
    padding: 50px 20px;
    background: #FAFBFC;
    border-radius: 18px;
    border: 2px dashed #E2E8F0;
}
.evd-empty-review i { font-size: 50px; color: #CBD5E1; display: block; margin-bottom: 12px; }
.evd-empty-review p { color: #94A3B8; margin: 0; font-size: 14px; }

.evd-poster-modal {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.92);
    z-index: 9999;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    cursor: zoom-out;
}
.evd-poster-modal.active { display: flex; }
.evd-poster-modal img {
    max-width: 90%; max-height: 90vh;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
}

@media (max-width: 768px) {
    .evd-hero { padding: 40px 18px 60px; }
    .evd-hero-grid { grid-template-columns: 1fr; gap: 24px; }
    .evd-poster-wrap { max-width: 240px; margin: 0 auto; aspect-ratio: 3/4; }
    .evd-meta-grid { grid-template-columns: repeat(2, 1fr); }
    .evd-section { padding: 40px 18px 20px; }
    .evd-desc-card, .evd-form-card { padding: 20px; }
    .evd-rating-summary { flex-direction: column; text-align: center; gap: 16px; }
    .evd-review-text { padding-left: 0; margin-top: 10px; }
    .evd-title { font-size: 18px; }
}
</style>

<!-- HERO -->
<section class="evd-hero">
    <div class="evd-hero-inner">

        <div class="evd-breadcrumb">
            <a href="<?= base_url('/') ?>">Home</a>
            <span>/</span>
            <a href="<?= base_url('event') ?>">Event</a>
            <span>/</span>
            <span><?= esc(substr($event['nama_event'], 0, 40)) ?>...</span>
        </div>

        <div class="evd-hero-grid">

            <!-- POSTER -->
            <div class="evd-poster-wrap">
                <?php if (!empty($event['poster']) && file_exists('uploads/poster/' . $event['poster'])): ?>
                    <img src="<?= base_url('uploads/poster/' . $event['poster']) ?>"
                         alt=""
                         onclick="evdOpenPoster('<?= base_url('uploads/poster/' . $event['poster']) ?>')">
                <?php else: ?>
                    <div class="no-poster"><i class="bi bi-image"></i></div>
                <?php endif; ?>
            </div>

            <!-- INFO -->
            <div class="evd-info">
                <div class="evd-status <?= $isAkanDatang ? '' : 'selesai' ?>">
                    <i class="bi bi-<?= $isAkanDatang ? 'calendar-check-fill' : 'check-circle-fill' ?>"></i>
                    <?= $isAkanDatang ? 'Akan Datang' : 'Sudah Selesai' ?>
                </div>

                <h1><?= esc($event['nama_event']) ?></h1>

                <div class="evd-org-box">
                    <?php if (!empty($event['ormawa_logo']) && file_exists('uploads/logo/' . $event['ormawa_logo'])): ?>
                        <img src="<?= base_url('uploads/logo/' . $event['ormawa_logo']) ?>" class="evd-org-logo" alt="">
                    <?php else: ?>
                        <div class="evd-org-logo"><i class="bi bi-building"></i></div>
                    <?php endif; ?>
                    <div>
                        <small>Diselenggarakan oleh</small>
                        <h4><?= esc($event['nama_ormawa'] ?? '-') ?></h4>
                    </div>
                </div>

                <div class="evd-meta-grid">
                    <div class="evd-meta-item">
                        <i class="bi bi-calendar-event-fill"></i>
                        <small>Tanggal</small>
                        <strong><?= date('d M Y', strtotime($event['tanggal'])) ?></strong>
                    </div>
                    <div class="evd-meta-item">
                        <i class="bi bi-clock-fill"></i>
                        <small>Waktu</small>
                        <strong><?= esc($event['waktu'] ?? '-') ?> WIB</strong>
                    </div>
                    <div class="evd-meta-item">
                        <i class="bi bi-geo-alt-fill"></i>
                        <small>Gedung</small>
                        <strong><?= esc($event['gedung'] ?? '-') ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DESKRIPSI -->
<section class="evd-section">
    <div class="evd-inner">
        <div class="evd-title"><i class="bi bi-file-text-fill"></i> Deskripsi Event</div>
        <div class="evd-desc-card">
            <?= auto_link_text($event['deskripsi'] ?? 'Belum ada deskripsi.') ?>
        </div>
    </div>
</section>

<!-- ULASAN -->
<section class="evd-section" style="padding-top: 40px; padding-bottom: 60px;">
    <div class="evd-inner">
        <div class="evd-title"><i class="bi bi-star-fill"></i> Ulasan & Rating</div>

        <div class="evd-rating-summary">
            <div class="evd-rating-big">
                <div class="evd-rating-num"><?= number_format($rating_avg ?? 0, 1) ?></div>
                <div class="evd-rating-max">dari 5.0</div>
                <div class="evd-rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="bi bi-star<?= $i <= round($rating_avg ?? 0) ? '-fill text-warning' : ' text-secondary' ?>"></i>
                    <?php endfor; ?>
                </div>
            </div>
            <div class="evd-rating-detail">
                <div class="total">
                    <i class="bi bi-chat-dots-fill me-1" style="color: #FF7A00;"></i>
                    <strong><?= $jumlah_ulasan ?? 0 ?></strong> ulasan dari pengunjung
                </div>
                <p style="font-size: 13px; color: #94A3B8; margin: 0;">
                    Bagikan pengalamanmu setelah mengikuti event ini
                </p>
            </div>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="evd-alert success">
                <i class="bi bi-check-circle-fill"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="evd-alert warning">
                <i class="bi bi-exclamation-triangle-fill"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->get('logged_in') && !$sudah_ulas): ?>
            <div class="evd-form-card">
                <h4><i class="bi bi-pencil-square" style="color: #FF7A00;"></i> Berikan Ulasanmu</h4>
                <form action="<?= site_url('event/simpanUlasan') ?>" method="post">
                    <input type="hidden" name="id_event" value="<?= $event['id_event'] ?>">
                    <input type="hidden" name="rating" id="ratingValue" value="5" required>

                    <label style="font-size:13px;font-weight:700;color:#64748B;margin-bottom:8px;display:block;">
                        Rating Kamu:
                    </label>
                    <div class="evd-stars" id="ratingStars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="bi bi-star-fill active" data-rating="<?= $i ?>" onclick="evdSetRating(<?= $i ?>)"></i>
                        <?php endfor; ?>
                    </div>

                    <label style="font-size:13px;font-weight:700;color:#64748B;margin-bottom:8px;display:block;">
                        Komentar (opsional):
                    </label>
                    <textarea name="komentar" placeholder="Ceritakan pengalamanmu mengikuti event ini..."></textarea>

                    <button type="submit" class="evd-btn-submit">
                        <i class="bi bi-send-fill"></i> Kirim Ulasan
                    </button>
                </form>
            </div>
        <?php elseif (session()->get('logged_in') && $sudah_ulas): ?>
            <div class="evd-alert info">
                <i class="bi bi-check-circle-fill"></i>
                <span>Kamu sudah memberikan ulasan untuk event ini. Terima kasih! 🎉</span>
            </div>
        <?php else: ?>
            <div class="evd-alert info">
                <i class="bi bi-lock-fill"></i>
                <span>
                    <a href="<?= site_url('login?redirect=' . urlencode(current_url())) ?>">Login</a>
                    untuk memberikan ulasan event ini.
                </span>
            </div>
        <?php endif; ?>

        <div style="margin-top: 32px;">
            <h4 style="font-size: 16px; font-weight: 800; color: #0F172A; margin-bottom: 14px; display:flex; align-items:center; gap: 8px;">
                <i class="bi bi-chat-quote-fill" style="color: #FF7A00;"></i>
                Ulasan Pengunjung (<?= count($ulasan ?? []) ?>)
            </h4>

            <?php if (!empty($ulasan)): ?>
                <?php foreach ($ulasan as $u):
                    $fotoPath = 'uploads/profil/' . ($u['foto'] ?? 'default.png');
                    $hasFoto = !empty($u['foto']) && file_exists($fotoPath);
                ?>
                    <div class="evd-review">
                        <div class="evd-review-head">
                            <div class="evd-user">
                                <?php if ($hasFoto): ?>
                                    <img src="<?= base_url($fotoPath) ?>" class="evd-avatar" alt="">
                                <?php else: ?>
                                    <div class="evd-avatar"><?= strtoupper(substr($u['username'] ?? 'U', 0, 1)) ?></div>
                                <?php endif; ?>
                                <div>
                                    <div class="evd-user-name"><?= esc($u['username']) ?></div>
                                    <div class="evd-user-stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="bi bi-star<?= $i <= $u['rating'] ? '-fill' : '' ?>"></i>
                                        <?php endfor; ?>
                                        <span class="muted">(<?= $u['rating'] ?>/5)</span>
                                    </div>
                                </div>
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="evd-review-time">
                                    <i class="bi bi-clock me-1"></i><?= date('d M Y', strtotime($u['created_at'])) ?>
                                </div>
                                <?php if (in_array(session()->get('role'), ['admin', 'super_admin']) ||
                                    (session()->get('role') === 'organisasi' && $event['id_ormawa'] == session()->get('id_ormawa'))): ?>
                                    <a href="<?= site_url('event/hapusUlasan/'.$u['id_ulasan']) ?>"
                                       onclick="return confirm('Hapus ulasan ini?')"
                                       style="background:#FEE2E2;color:#B91C1C;border:1px solid #FECACA;
                                              padding:4px 10px;border-radius:8px;font-size:12px;
                                              cursor:pointer;text-decoration:none;">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!empty($u['komentar'])): ?>
                            <div class="evd-review-text"><?= nl2br(esc($u['komentar'])) ?></div>
                        <?php else: ?>
                            <div class="evd-review-text" style="color:#94A3B8;font-style:italic;">
                                <em>Tidak ada komentar</em>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="evd-empty-review">
                    <i class="bi bi-chat-dots"></i>
                    <p>Belum ada ulasan untuk event ini. Jadilah yang pertama! 🌟</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- MODAL POSTER -->
<div class="evd-poster-modal" id="evdPosterModal" onclick="evdClosePoster()">
    <img id="evdPosterImg" src="" alt="Poster">
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function evdSetRating(rating) {
    document.getElementById('ratingValue').value = rating;
    document.querySelectorAll('#ratingStars i').forEach((star, idx) => {
        star.classList.toggle('active', idx < rating);
    });
}

function evdOpenPoster(src) {
    document.getElementById('evdPosterImg').src = src;
    document.getElementById('evdPosterModal').classList.add('active');
}

function evdClosePoster() {
    document.getElementById('evdPosterModal').classList.remove('active');
}

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') evdClosePoster();
});
</script>
<?= $this->endSection() ?>