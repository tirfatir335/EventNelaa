<?php
$uri = service('uri');
$seg1 = $uri->getSegment(1) ?? '';
$isLoggedIn = session()->get('logged_in');
$role = session()->get('role');

$menu = [
    ['url' => base_url(),               'label' => 'Beranda',       'icon' => 'house-door-fill',   'key' => ''],
    ['url' => base_url('event'),        'label' => 'Event',         'icon' => 'calendar-event-fill','key' => 'event'],
    ['url' => base_url('ukm'),          'label' => 'UKM & Ormawa',  'icon' => 'people-fill',       'key' => 'ukm'],
    ['url' => base_url('berita'),       'label' => 'Berita',        'icon' => 'newspaper',         'key' => 'berita'],
    ['url' => base_url('recruitment'),  'label' => 'Recruitment',   'icon' => 'megaphone-fill',    'key' => 'recruitment'],
    ['url' => base_url('chatbot'),      'label' => 'EventNela AI',  'icon' => 'robot',             'key' => 'chatbot'],
    ['url' => base_url('panduan'),      'label' => 'Panduan',       'icon' => 'book-fill',         'key' => 'panduan'],
    ['url' => base_url('tentang'),      'label' => 'Tentang',       'icon' => 'info-circle-fill',  'key' => 'tentang'],
];

$dashUrl = match ($role) {
    'admin', 'super_admin' => 'admin/dashboard',
    'organisasi'           => 'ormawa/dashboard',
    'staf_ormawa'          => function_exists('get_first_module_url') ? get_first_module_url() : 'ormawa/dashboard',
    'pembina'              => 'pembina/dashboard',
    'validator'            => 'validator/dashboard',
    'mahasiswa'            => 'mahasiswa/dashboard',
    default                => '',
};
?>
<nav class="pub-navbar">
    <div class="pub-navbar-inner">
        <a href="<?= base_url() ?>" class="pub-brand">
            <img src="<?= base_url('assets/images/logo eventnela.png') ?>" alt="EventNela">
        </a>
        <div class="pub-nav-actions">
            <button class="pub-hamburger" id="pubHamburger" onclick="pubToggleMenu()" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</nav>

<!-- OVERLAY + SLIDE PANEL (kode sama persis kayak sebelumnya, gak berubah) -->
<div class="pub-menu-overlay" id="pubMenuOverlay" onclick="pubToggleMenu()"></div>

<div class="pub-menu-panel" id="pubMenuPanel">
    <div class="pub-menu-header">
        <div class="pub-menu-header-top">
            <div class="pub-menu-header-title">
                <i class="bi bi-grid-3x3-gap-fill"></i> Menu
            </div>
            <div class="pub-menu-close" onclick="pubToggleMenu()">
                <i class="bi bi-x-lg"></i>
            </div>
        </div>
        <p>Jelajahi semua fitur EventNela</p>
    </div>

    <div class="pub-menu-body">
        <?php foreach ($menu as $m): ?>
            <a href="<?= $m['url'] ?>" class="pub-menu-item <?= $seg1 === $m['key'] ? 'active' : '' ?>">
                <div class="pub-menu-icon"><i class="bi bi-<?= $m['icon'] ?>"></i></div>
                <span><?= $m['label'] ?></span>
                <i class="bi bi-chevron-right pub-menu-arrow"></i>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="pub-menu-footer">
        <?php if ($isLoggedIn && $dashUrl && $dashUrl !== 'logout'): ?>
            <div class="pub-menu-user">
                <?php
                    $foto = session('foto');
                    $fotoUrl = !empty($foto) && file_exists('uploads/profil/' . $foto)
                        ? base_url('uploads/profil/' . $foto) : null;
                ?>
                <?php if ($fotoUrl): ?>
                    <img src="<?= $fotoUrl ?>" class="pub-menu-avatar" alt="">
                <?php else: ?>
                    <div class="pub-menu-avatar"><?= strtoupper(substr(session('username') ?? 'U', 0, 1)) ?></div>
                <?php endif; ?>
                <div style="flex:1;min-width:0;">
                    <div class="pub-menu-user-name"><?= esc(session('username')) ?></div>
                    <div class="pub-menu-user-role"><?= ucfirst(str_replace('_', ' ', $role)) ?></div>
                </div>
            </div>
            <a href="<?= site_url($dashUrl) ?>" class="pub-menu-btn pub-menu-btn-primary">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="<?= base_url('logout') ?>" class="pub-menu-btn pub-menu-btn-logout">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        <?php else: ?>
            <a href="<?= base_url('login') ?>" class="pub-menu-btn pub-menu-btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> Login
            </a>
            <a href="<?= base_url('register') ?>" class="pub-menu-btn pub-menu-btn-outline">
                <i class="bi bi-person-plus"></i> Daftar Akun
            </a>
        <?php endif; ?>
    </div>
</div>

<script>
function pubToggleMenu() {
    const panel = document.getElementById('pubMenuPanel');
    const overlay = document.getElementById('pubMenuOverlay');
    const burger = document.getElementById('pubHamburger');
    panel.classList.toggle('active');
    overlay.classList.toggle('active');
    burger.classList.toggle('active');
    const isOpen = panel.classList.contains('active');
    document.body.style.overflow = isOpen ? 'hidden' : '';
    document.body.classList.toggle('pub-menu-open', isOpen);
}
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') {
        const p = document.getElementById('pubMenuPanel');
        if (p.classList.contains('active')) pubToggleMenu();
    }
});
</script>