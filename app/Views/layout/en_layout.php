
<?php
$role = session()->get('role');
$current = service('uri')->getSegment(2) ?? 'dashboard';
$username = session('username');
$foto = session('foto');

// Mapping role → prefix URL
$menus = [
    'admin'        => 'admin',
    'super_admin'  => 'admin',
    'organisasi'   => 'ormawa',
    'staf_ormawa'  => 'ormawa',
    'pembina'      => 'pembina',
    'validator'    => 'validator',
    'mahasiswa'    => 'mahasiswa',
];

$roleKey = $menus[$role] ?? 'admin';

$nav = [
    'admin' => [
        ['section' => 'Utama'],
        ['link'=>'dashboard', 'icon'=>'house-door-fill', 'label'=>'Dashboard'],
        ['link'=>'validasi',  'icon'=>'check2-square',   'label'=>'Validasi Gedung'],
        ['link'=>'gedung',    'icon'=>'building',        'label'=>'Kelola Gedung'],
        ['section' => 'Akun'],
        ['link'=>'profil',    'icon'=>'person-circle',   'label'=>'Profil'],
    ],
    'ormawa' => [
        ['section' => 'Utama'],
        ['link'=>'dashboard',      'icon'=>'house-door-fill',    'label'=>'Dashboard'],
        ['link'=>'kegiatan',       'icon'=>'calendar-event-fill','label'=>'Event'],
        ['link'=>'program-kerja',  'icon'=>'clipboard-check',    'label'=>'Program Kerja'],
        ['link'=>'proposal',       'icon'=>'file-earmark-text',  'label'=>'Proposal'],
        ['link'=>'report',         'icon'=>'file-earmark-check', 'label'=>'Report / LPJ'],
        ['section' => 'Organisasi'],
        ['link'=>'pengurus',       'icon'=>'people-fill',        'label'=>'Pengurus'],
        ['link'=>'departemen',     'icon'=>'diagram-3-fill',     'label'=>'Departemen'],
        ['link'=>'galeri-ormawa',  'icon'=>'images',             'label'=>'Galeri'],
        ['link'=>'berita',         'icon'=>'newspaper',          'label'=>'Berita'],
        ['link'=>'recruitment',    'icon'=>'megaphone-fill',     'label'=>'Recruitment'],
        ['link'=>'ulasan',         'icon'=>'star-fill',          'label'=>'Ulasan'],
        ['link'=>'staf',           'icon'=>'person-badge-fill',  'label'=>'Kelola Staf'],
        ['section' => 'Akun'],
        ['link'=>'profil',         'icon'=>'person-circle',      'label'=>'Profil Ormawa'],
    ],
    'pembina' => [
        ['section' => 'Verifikasi'],
        ['link'=>'dashboard', 'icon'=>'house-door-fill',    'label'=>'Dashboard'],
        ['link'=>'proposal',  'icon'=>'file-earmark-text',  'label'=>'Verifikasi Proposal'],
        ['link'=>'report',    'icon'=>'file-earmark-check', 'label'=>'Verifikasi LPJ'],
        ['section' => 'Akun'],
        ['link'=>'profil',    'icon'=>'person-circle',      'label'=>'Profil'],
    ],
    'validator' => [
        ['section' => 'Validasi'],
        ['link'=>'dashboard', 'icon'=>'house-door-fill',    'label'=>'Dashboard'],
        ['link'=>'progja',    'icon'=>'clipboard-check',    'label'=>'Program Kerja'],
        ['link'=>'proposal',  'icon'=>'file-earmark-text',  'label'=>'Proposal'],
        ['link'=>'report',    'icon'=>'file-earmark-check', 'label'=>'Verifikasi LPJ'],
        ['section' => 'Manajemen'],
        ['link'=>'ormawa',    'icon'=>'people-fill',        'label'=>'Kelola Ormawa'],
        ['link'=>'dosen',     'icon'=>'person-badge',       'label'=>'Kelola Pembina'],
        ['link'=>'backup',    'icon'=>'download',           'label'=>'Backup Data'],
        ['section' => 'Akun'],
        ['link'=>'profil',    'icon'=>'person-circle',      'label'=>'Profil'],
    ],
    'mahasiswa' => [
        ['section' => 'Utama'],
        ['link'=>'dashboard', 'icon'=>'house-door-fill', 'label'=>'Dashboard'],
        ['section' => 'Akun'],
        ['link'=>'profil',    'icon'=>'person-circle',   'label'=>'Profil Saya'],
    ],
];
$items = $nav[$roleKey] ?? $nav['admin'];

// FILTER MENU STAF ORMAWA - hanya tampil modul yang diizinkan admin
if ($role === 'staf_ormawa' && $roleKey === 'ormawa') {
    $allowedModules = get_user_modules();
    
    $linkToModule = [
        'profil'        => 'profil',
        'program-kerja' => 'progja',
        'pengurus'      => 'pengurus',
        'departemen'    => 'departemen',
        'galeri-ormawa' => 'galeri',
        'berita'        => 'berita',
        'recruitment'   => 'recruitment',
        'kegiatan'      => 'event',
        'riwayat'       => 'event',
        'staf'          => 'staf',
        'ulasan'        => 'ulasan',
    ];
    
    // Modul yang SELALU muncul untuk staf (gak peduli permission)
    $alwaysShow = ['profil'];
    
    $newItems = [];
    $pendingSection = null;
    $hasItemsInSection = false;
    
    foreach ($items as $item) {
        if (isset($item['section'])) {
            if ($pendingSection && $hasItemsInSection) {
                $newItems[] = $pendingSection;
            }
            $pendingSection = $item;
            $hasItemsInSection = false;
            continue;
        }
        
        $link = $item['link'] ?? '';
        
        // Skip dashboard
        if ($link === 'dashboard') continue;
        
        $module = $linkToModule[$link] ?? null;
        
        // Cek: apakah modul diizinkan ATAU termasuk alwaysShow
        $bolehTampil = false;
        if ($module) {
            if (in_array($module, $alwaysShow)) {
                $bolehTampil = true;
            } elseif (in_array($module, $allowedModules)) {
                $bolehTampil = true;
            }
        }
        
        if ($bolehTampil) {
            if ($pendingSection) {
                $newItems[] = $pendingSection;
                $pendingSection = null;
            }
            $newItems[] = $item;
            $hasItemsInSection = true;
        }
    }
    
    $items = $newItems;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Dashboard' ?> — EventNela</title>
<link rel="icon" href="<?= base_url('assets/images/favicon.ico') ?>">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/eventnela-ui.css') ?>?v=3">
<?= $this->renderSection('head') ?>
</head>
<body class="en-body">

<div class="en-app">

    <!-- SIDEBAR -->
    <aside class="en-sidebar" id="enSidebar">
        <div class="en-sidebar__brand">
    <a href="<?= base_url() ?>" class="d-flex align-items-center gap-2 text-decoration-none">
        <img src="<?= base_url('assets/images/logo eventnela.png') ?>" alt="EventNela">
    </a>
    <!-- Tombol X — khusus mobile -->
    <button class="en-sidebar-close d-lg-none" 
            onclick="document.getElementById('enSidebar').classList.remove('open')"
            aria-label="Tutup menu">
        <i class="bi bi-x-lg"></i>
    </button>
</div>

        <nav class="en-sidebar__nav">
            <?php foreach ($items as $m): ?>
    <?php if (isset($m['section'])): ?>
        <div class="en-sidebar__section"><?= $m['section'] ?></div>
    <?php else: ?>
        <?php
            // URL default
            $linkUrl = $roleKey.'/'.$m['link'];
            $label   = $m['label'];
            $isActive = ($current === $m['link']);

            // KHUSUS STAF: menu 'profil' arahkan ke my-profile
            if ($role === 'staf_ormawa' && $m['link'] === 'profil') {
                $linkUrl = 'my-profile';
                $label   = 'Profil Saya';
                $isActive = (service('uri')->getSegment(1) === 'my-profile');
            }
        ?>
        <a href="<?= site_url($linkUrl) ?>"
           class="en-nav-item <?= $isActive ? 'active' : '' ?>">
            <i class="bi bi-<?= $m['icon'] ?>"></i>
            <span><?= $label ?></span>
        </a>
    <?php endif; ?>
<?php endforeach; ?>
        </nav>

        <div class="en-sidebar__footer">
            <a href="<?= base_url('logout') ?>" class="en-btn en-btn-light w-100">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </aside>

    <!-- OVERLAY — klik buat nutup sidebar -->
<div class="en-sidebar-overlay" onclick="document.getElementById('enSidebar').classList.remove('open')"></div>
    <!-- MAIN -->
    <div class="en-main">

        <!-- TOPBAR -->
        <header class="en-topbar">
            <button class="en-icon-btn d-lg-none" onclick="document.getElementById('enSidebar').classList.toggle('open')">
                <i class="bi bi-list"></i>
            </button>

            <div class="en-topbar__title">
                <h1><?= $title ?? 'Dashboard' ?></h1>
                <p><?= $subtitle ?? 'Selamat datang kembali' ?></p>
            </div>

            <div class="en-topbar__spacer"></div>

            

            <div class="en-user dropdown">
                <img src="<?= base_url('uploads/profil/'.($foto ?: 'default.png')) ?>" alt="">
                <div>
                    <div class="name"><?= esc($username) ?></div>
                    <div class="role"><?= ucfirst(str_replace('_', ' ', $role)) ?></div>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <main class="en-content">
            <?= $this->renderSection('content') ?>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('enGlobalSearch')?.addEventListener('keyup', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('.en-table tbody tr').forEach(tr => {
        tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
    });
});
</script>
<?= $this->renderSection('scripts') ?>

<script>
// Auto-close sidebar saat klik menu di mobile
document.querySelectorAll('.en-nav-item').forEach(item => {
    item.addEventListener('click', () => {
        if (window.innerWidth <= 992) {
            document.getElementById('enSidebar')?.classList.remove('open');
        }
    });
});
</script>
</body>
</html>