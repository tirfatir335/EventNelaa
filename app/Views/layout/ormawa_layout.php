<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Dashboard Ormawa' ?></title>

<!-- BOOTSTRAP -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico'); ?>">

<style>
:root{
    --sidebar:#D4E2FF;
    --accent:#FF8800;
}

html, body {
    height: 100%;
}

body {
    margin:0;
    background: url('<?= base_url('assets/images/bg.jpg') ?>') no-repeat center center fixed;
    background-size: cover;
    overflow: hidden;
}

/* LAYOUT UTAMA */
.app-wrapper{
    display:flex;
    height:100vh;
    width:100vw;
}

/* SIDEBAR DESKTOP */
.sidebar{
    width:240px;
    background:var(--sidebar);
    height:100vh;
    position:sticky;
    top:0;
    overflow-y:auto;
}
.sidebar .nav-link{
    font-weight:600;
    color:#333;
    transition:.2s;
}
.sidebar .nav-link:hover{
    background:#FFBB66;
    color:#fff;
}
.sidebar .nav-link.active{
    background:var(--accent)!important;
    color:#fff!important;
}

/* MAIN AREA */
.main-area{
    flex:1;
    display:flex;
    flex-direction:column;
    height:100vh;
}

/* TOPBAR */
.topbar{
    height:64px;
    background:#D4E2FF;
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:0 16px;
    flex-shrink:0;
}

/* CONTENT */
.content-scroll{
    flex:1;
    overflow-y:auto;
    padding:15px;
}
.content-wrapper{
    backdrop-filter: blur(4px);
    background: rgba(255,255,255,.55);
    border-radius:12px;
    padding:20px;
}

/* PROFILE */
.profile-img{
    width:48px;
    height:48px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #fff;
}

/* SEARCH */
.search-box input{
    border-radius:50px;
}

/* MOBILE */
@media(max-width:768px){
    .sidebar{display:none;}
}

/* FIX MODAL */
body.modal-open .content-wrapper{
    backdrop-filter:none!important;
}
.modal{z-index:1060;}
.modal-backdrop{z-index:1055;}

    /* ============================================
       SHARED COMPONENTS — EVENTNELA ORMAWA
       ============================================ */

    /* ---------- PAGE HEADER ---------- */
    .page-header-ormawa {
        background: linear-gradient(135deg, #ff7a00 0%, #e65100 100%);
        color: white;
        border-radius: 20px;
        padding: 30px 32px;
        position: relative;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 10px 30px rgba(255, 122, 0, 0.25);
    }

    .page-header-ormawa::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .page-header-ormawa::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .page-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-header-text h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 6px;
        letter-spacing: -0.3px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-text p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    .page-header-icon {
        width: 70px;
        height: 70px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        border: 2px solid rgba(255, 255, 255, 0.2);
        flex-shrink: 0;
    }

    /* ---------- TOMBOL TAMBAH ---------- */
    .btn-add-modern {
        background: white;
        color: #ff7a00;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        cursor: pointer;
    }

    .btn-add-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        color: #ff7a00;
    }

    /* ---------- CARD ---------- */
    .card-modern {
        background: white;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 24px;
    }

    .card-modern-header {
        padding: 20px 24px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
    }

    .card-modern-header h4 {
        font-size: 17px;
        font-weight: 800;
        color: #1a1a2e;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-modern-header h4 i {
        color: #ff7a00;
    }

    .card-modern-body {
        padding: 24px;
    }

    /* ---------- TABEL MODERN ---------- */
    .table-modern-wrap {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .table-modern thead th {
        background: #f8f9fa;
        color: #666;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 14px;
        text-align: left;
        border-bottom: 2px solid #f0f0f0;
        white-space: nowrap;
    }

    .table-modern thead th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .table-modern thead th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .table-modern tbody td {
        padding: 14px 14px;
        font-size: 13.5px;
        color: #333;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table-modern tbody tr:hover {
        background: #fffbf5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* ---------- THUMBNAIL ---------- */
    .thumb-modern {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        border: 2px solid #f0f0f0;
        cursor: pointer;
        transition: 0.3s;
    }

    .thumb-modern:hover {
        transform: scale(1.1);
        border-color: #ff7a00;
    }

    .thumb-modern-rounded {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #fff3e0;
    }

    .thumb-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 10px;
        background: linear-gradient(135deg, #f0f4ff, #e0e7ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ff7a00;
        font-size: 22px;
        border: 2px solid #f0f0f0;
    }

    /* ---------- BADGE STATUS ---------- */
    .badge-modern {
        padding: 6px 14px;
        border-radius: 15px;
        font-size: 11px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge-modern.success { background: #e8f5e9; color: #2e7d32; }
    .badge-modern.danger { background: #ffebee; color: #c62828; }
    .badge-modern.warning { background: #fff3e0; color: #e65100; }
    .badge-modern.info { background: #e3f2fd; color: #1565c0; }
    .badge-modern.secondary { background: #f5f5f5; color: #666; }

    /* ---------- TOMBOL AKSI ---------- */
    .btn-action {
        width: 34px;
        height: 34px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        margin: 0 2px;
        transition: 0.3s;
        text-decoration: none;
        border: none;
        cursor: pointer;
        color: white;
    }

    .btn-action.warning { background: #ffb74d; }
    .btn-action.danger  { background: #e53e3e; }
    .btn-action.success { background: #43e97b; }
    .btn-action.info    { background: #4facfe; }
    .btn-action.primary { background: linear-gradient(135deg, #ff7a00, #e65100); }

    .btn-action:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: white;
    }

    /* ---------- FORM ---------- */
    .form-modern {
        background: white;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .form-group-modern {
        margin-bottom: 22px;
    }

    .form-group-modern label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .form-group-modern label .required {
        color: #e53e3e;
        margin-left: 2px;
    }

    .form-control-modern {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e8ecf1;
        border-radius: 12px;
        font-size: 14px;
        font-family: inherit;
        outline: none;
        transition: 0.3s;
        background: #fafbfc;
        color: #333;
    }

    .form-control-modern:focus {
        border-color: #ff7a00;
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 122, 0, 0.1);
    }

    .form-control-modern::placeholder {
        color: #bbb;
    }

    textarea.form-control-modern {
        resize: vertical;
        min-height: 100px;
    }

    .form-hint {
        font-size: 11px;
        color: #999;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ---------- BUTTON GROUP FORM ---------- */
    .form-buttons {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 2px solid #f0f0f0;
        flex-wrap: wrap;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, #ff7a00, #e65100);
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 15px rgba(255, 122, 0, 0.3);
    }

    .btn-primary-modern:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 122, 0, 0.4);
        color: white;
    }

    .btn-secondary-modern {
        background: white;
        color: #666;
        border: 2px solid #e8ecf1;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-secondary-modern:hover {
        border-color: #ff7a00;
        color: #ff7a00;
        transform: translateY(-3px);
    }

    /* ---------- ALERT ---------- */
    .alert-modern {
        border-radius: 12px;
        padding: 16px 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-modern.success {
        background: #e8f5e9;
        color: #2e7d32;
        border: 1px solid #c8e6c9;
    }

    .alert-modern.danger {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ffcdd2;
    }

    .alert-modern.info {
        background: #e3f2fd;
        color: #1565c0;
        border: 1px solid #bbdefb;
    }

    .alert-modern i {
        font-size: 20px;
        flex-shrink: 0;
    }

    /* ---------- EMPTY STATE ---------- */
    .empty-modern {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-modern i {
        font-size: 70px;
        color: #ddd;
        display: block;
        margin-bottom: 16px;
    }

    .empty-modern h5 {
        color: #666;
        font-weight: 800;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .empty-modern p {
        color: #999;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* ---------- PREVIEW IMAGE ---------- */
    .preview-img {
        max-height: 100px;
        border-radius: 10px;
        border: 2px solid #f0f0f0;
        padding: 4px;
        margin-bottom: 12px;
        display: block;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 768px) {
        .page-header-ormawa {
            padding: 22px 20px;
        }

        .page-header-text h2 {
            font-size: 18px;
        }

        .page-header-icon {
            width: 55px;
            height: 55px;
            font-size: 24px;
        }

        .form-modern {
            padding: 22px 20px;
        }

        .card-modern-body {
            padding: 18px;
        }

        .table-modern-wrap {
            padding: 16px;
        }

        .table-modern thead th,
        .table-modern tbody td {
            padding: 10px 8px;
            font-size: 12px;
        }

        .form-buttons {
            flex-direction: column;
        }

        .btn-primary-modern,
        .btn-secondary-modern {
            width: 100%;
            justify-content: center;
        }
    }
</style>
</head>
<body>

<?php
$uri = service('uri');
$current = $uri->getSegment(2) ?? 'dashboard';

// ===== SIDEBAR DINAMIS BERDASARKAN ROLE & PERMISSION =====
$role = session()->get('role');
$allowedModules = get_user_modules(); // dari helper permission_helper

// Paksa admin ormawa punya akses ke menu Report + Proposal
if (in_array($role, ['organisasi', 'admin', 'super_admin'])) {
    if (!in_array('report', $allowedModules)) {
        $allowedModules[] = 'report';
    }
    if (!in_array('proposal', $allowedModules)) {
        $allowedModules[] = 'proposal';
    }
}

// Daftar semua menu yang mungkin tampil
$allMenus = [
    'dashboard'     => ['link'=>'dashboard',      'icon'=>'house-door',         'label'=>'Dashboard'],
    'profil'        => ['link'=>'profil',         'icon'=>'person',             'label'=>'Profil'],
    'progja'        => ['link'=>'program-kerja',  'icon'=>'clipboard',          'label'=>'Progja'],
    'proposal'      => ['link'=>'proposal',       'icon'=>'file-earmark-text',  'label'=>'Proposal'],
    'pengurus'      => ['link'=>'pengurus',       'icon'=>'people-fill',        'label'=>'Pengurus'],
    'event'         => ['link'=>'kegiatan',       'icon'=>'journal-text',       'label'=>'Event'],
    'report'        => ['link'=>'report',         'icon'=>'file-earmark-check', 'label'=>'Report/LPJ'],
    'galeri'        => ['link'=>'galeri-ormawa',  'icon'=>'images',             'label'=>'Galeri'],
    'berita'        => ['link'=>'berita',         'icon'=>'newspaper',          'label'=>'Berita'],
    'recruitment'   => ['link'=>'recruitment',    'icon'=>'megaphone-fill',     'label'=>'Recruitment'],
    'riwayat'       => ['link'=>'riwayat',        'icon'=>'clock-history',      'label'=>'Riwayat'],
    'departemen'    => ['link'=>'departemen',     'icon'=>'diagram-3',          'label'=>'Departemen'],
    'staf'          => ['link'=>'staf',           'icon'=>'person-badge-fill',  'label'=>'Kelola Staf'],
    'ulasan'        => ['link'=>'ulasan',         'icon'=>'star-fill',          'label'=>'Ulasan'],
];

// Filter menu sesuai akses
$menu = [];
foreach ($allMenus as $key => $m) {
    // Untuk staf: skip dashboard
    if ($key === 'dashboard' && session()->get('role') === 'staf_ormawa') {
        continue;
    }

    // Untuk admin ormawa: dashboard selalu tampil
    if ($key === 'dashboard' && in_array(session()->get('role'), ['organisasi', 'admin', 'super_admin'])) {
        $menu[] = $m;
        continue;
    }

    // Cek akses modul lainnya
    if (in_array($key, $allowedModules)) {
        $menu[] = $m;
    }
}
?>

<div class="app-wrapper">

    <!-- SIDEBAR DESKTOP -->
    <aside class="sidebar d-none d-md-block">
        <div class="p-3">
            <a href="<?= base_url() ?>" class="d-flex align-items-center mb-4 text-decoration-none">
                <img src="<?= base_url('assets/images/logo eventnela.png') ?>" height="40">
            </a>

            <div class="nav nav-pills flex-column">
                <?php foreach($menu as $m): ?>
                <a href="<?= site_url('ormawa/'.$m['link']) ?>"
                   class="nav-link py-3 <?= $current==$m['link']?'active':'' ?>">
                    <i class="bi bi-<?= $m['icon'] ?> me-2"></i>
                    <?= $m['label'] ?>
                </a>
                <?php endforeach ?>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main-area">

        <!-- TOPBAR -->
        <div class="topbar d-md-none">
            <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-3"></i>
            </button>
            <strong><?= $title ?? 'Dashboard Ormawa' ?></strong>
        </div>

        <!-- CONTENT -->
        <div class="content-scroll">
            <div class="content-wrapper shadow">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="search-box flex-grow-1 me-2">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                    </div>

                    <div class="dropdown text-center">
                        <button class="btn p-0" data-bs-toggle="dropdown">
                            <img src="<?= base_url('uploads/profil/'.(session('foto')??'default.png')) ?>" class="profile-img">
                            <div class="small">
                                <?= session('username') ?>
                                <?php if (session('role') === 'staf_ormawa'): ?>
                                    <span class="badge bg-warning text-dark" style="font-size:9px;">STAF</span>
                                <?php endif; ?>
                            </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
    <?php if (session('role') === 'staf_ormawa'): ?>
        <!-- Staf: hanya Profil Saya -->
        <li>
            <a class="dropdown-item" href="<?= base_url('my-profile') ?>">
                <i class="bi bi-person-circle"></i> Profil Saya
            </a>
        </li>
    <?php else: ?>
        <!-- Admin UKM: hanya Profil Ormawa -->
        <li>
            <a class="dropdown-item" href="<?= base_url('ormawa/profil') ?>">
                <i class="bi bi-building"></i> Profil Ormawa
            </a>
        </li>
    <?php endif; ?>
    <li><hr></li>
    <li>
        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </li>
</ul>
                    </div>
                </div>

                <?= $this->renderSection('content') ?>

            </div>
        </div>

    </div>
</div>

<!-- SIDEBAR MOBILE -->
<div class="offcanvas offcanvas-start" id="mobileSidebar">
    <div class="offcanvas-header" style="background:#D4E2FF">
        <h5 class="fw-bold">EventNela</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="nav nav-pills flex-column">
            <?php foreach($menu as $m): ?>
            <a href="<?= site_url('ormawa/'.$m['link']) ?>"
               class="nav-link py-3 <?= $current==$m['link']?'active':'' ?>">
                <i class="bi bi-<?= $m['icon'] ?> me-2"></i>
                <?= $m['label'] ?>
            </a>
            <?php endforeach ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById("searchInput")?.addEventListener("keyup", function(){
        let key = this.value.toLowerCase();
        document.querySelectorAll("table tbody tr").forEach(tr=>{
            tr.style.display = tr.innerText.toLowerCase().includes(key) ? "" : "none";
        });
    });
</script>

</body>
</html>