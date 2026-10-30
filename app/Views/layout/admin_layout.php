<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?></title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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
            overflow: hidden; /* BODY TIDAK SCROLL */
        }

        /* ===== LAYOUT UTAMA ===== */
        .app-wrapper{
            display:flex;
            height:100vh;
            width:100vw;
        }

        /* ===== SIDEBAR DESKTOP ===== */
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

        /* ===== MAIN AREA ===== */
        .main-area{
            flex:1;
            display:flex;
            flex-direction:column;
            height:100vh;
        }

        /* ===== TOPBAR ===== */
        .topbar{
            height:64px;
            background:#D4E2FF;
            display:flex;
            align-items:center;
            justify-content:space-between;
            padding:0 16px;
            flex-shrink:0;
        }

        /* ===== CONTENT ===== */
        .content-scroll{
            flex:1;
            overflow-y:auto; /* HANYA KONTEN SCROLL */
            padding:15px;
        }

        .content-wrapper{
            backdrop-filter: blur(4px);
            background: rgba(255,255,255,.55);
            border-radius:12px;
            padding:20px;
        }

        /* ===== PROFILE ===== */
        .profile-img{
            width:48px;
            height:48px;
            border-radius:50%;
            object-fit:cover;
            border:2px solid #fff;
        }

        /* ===== SEARCH ===== */
        .search-box input{
            border-radius:50px;
        }

        /* ===== MOBILE ===== */
        @media(max-width:768px){
            .sidebar{display:none;}
        }

        /* ===== FIX MODAL ===== */
        body.modal-open .content-wrapper{
            backdrop-filter:none!important;
        }

        .modal{z-index:1060;}
        .modal-backdrop{z-index:1055;}


    /* ---------- PAGE HEADER ---------- */
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
        top: -50%;
        right: -20%;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.08);
        border-radius: 50%;
    }

    .page-header-admin::after {
        content: '';
        position: absolute;
        bottom: -40%;
        left: -10%;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .page-header-content-admin {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .page-header-text-admin h2 {
        font-size: 24px;
        font-weight: 800;
        margin-bottom: 6px;
        letter-spacing: -0.3px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .page-header-text-admin p {
        font-size: 14px;
        opacity: 0.9;
        margin: 0;
    }

    .page-header-icon-admin {
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
    .btn-add-admin {
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

    .btn-add-admin:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        color: #ff7a00;
    }

    /* ---------- TABEL MODERN ADMIN ---------- */
    .table-admin-wrap {
        background: white;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .table-admin-modern {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .table-admin-modern thead th {
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

    .table-admin-modern thead th:first-child {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    .table-admin-modern thead th:last-child {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    }

    .table-admin-modern tbody td {
        padding: 14px 14px;
        font-size: 13.5px;
        color: #333;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }

    .table-admin-modern tbody tr:hover {
        background: #fffbf5;
    }

    .table-admin-modern tbody tr:last-child td {
        border-bottom: none;
    }

    /* ---------- TOMBOL AKSI ---------- */
    .btn-action-admin {
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

    .btn-action-admin.warning { background: #ffb74d; }
    .btn-action-admin.danger  { background: #e53e3e; }
    .btn-action-admin.success { background: #43e97b; }
    .btn-action-admin.info    { background: #4facfe; }
    .btn-action-admin.primary { background: linear-gradient(135deg, #ff7a00, #e65100); }

    .btn-action-admin:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        color: white;
    }

    /* ---------- BADGE ---------- */
    .badge-admin {
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

    .badge-admin.success { background: #e8f5e9; color: #2e7d32; }
    .badge-admin.danger { background: #ffebee; color: #c62828; }
    .badge-admin.warning { background: #fff3e0; color: #e65100; }
    .badge-admin.info { background: #e3f2fd; color: #1565c0; }
    .badge-admin.secondary { background: #f5f5f5; color: #666; }

    /* ---------- FORM MODERN ADMIN ---------- */
    .form-admin {
        background: white;
        border-radius: 18px;
        padding: 32px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }

    .form-group-admin {
        margin-bottom: 22px;
    }

    .form-group-admin label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        letter-spacing: 0.3px;
    }

    .form-group-admin label .required {
        color: #e53e3e;
        margin-left: 2px;
    }

    .form-control-admin {
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

    .form-control-admin:focus {
        border-color: #ff7a00;
        background: white;
        box-shadow: 0 0 0 4px rgba(255, 122, 0, 0.1);
    }

    .form-hint-admin {
        font-size: 11px;
        color: #999;
        margin-top: 6px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* ---------- BUTTON GROUP ---------- */
    .form-buttons-admin {
        display: flex;
        gap: 12px;
        margin-top: 28px;
        padding-top: 24px;
        border-top: 2px solid #f0f0f0;
        flex-wrap: wrap;
    }

    .btn-primary-admin {
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

    .btn-primary-admin:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(255, 122, 0, 0.4);
        color: white;
    }

    .btn-secondary-admin {
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

    .btn-secondary-admin:hover {
        border-color: #ff7a00;
        color: #ff7a00;
        transform: translateY(-3px);
    }

    /* ---------- ALERT ---------- */
    .alert-admin {
        border-radius: 12px;
        padding: 16px 20px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        font-weight: 500;
    }

    .alert-admin.success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
    .alert-admin.danger  { background: #ffebee; color: #c62828; border: 1px solid #ffcdd2; }
    .alert-admin.info    { background: #e3f2fd; color: #1565c0; border: 1px solid #bbdefb; }

    .alert-admin i {
        font-size: 20px;
        flex-shrink: 0;
    }

    /* ---------- EMPTY STATE ---------- */
    .empty-admin {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-admin i {
        font-size: 70px;
        color: #ddd;
        display: block;
        margin-bottom: 16px;
    }

    .empty-admin h5 {
        color: #666;
        font-weight: 800;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .empty-admin p {
        color: #999;
        margin-bottom: 20px;
        font-size: 14px;
    }

    /* ---------- RESPONSIVE ---------- */
    @media (max-width: 768px) {
        .page-header-admin { padding: 22px 20px; }
        .page-header-text-admin h2 { font-size: 18px; }
        .page-header-icon-admin { width: 55px; height: 55px; font-size: 24px; }
        .form-admin { padding: 22px 20px; }
        .table-admin-wrap { padding: 16px; }
        .table-admin-modern thead th,
        .table-admin-modern tbody td { padding: 10px 8px; font-size: 12px; }
        .form-buttons-admin { flex-direction: column; }
        .btn-primary-admin,
        .btn-secondary-admin { width: 100%; justify-content: center; }
    }
    </style>
</head>
<body>

<?php
$uri = service('uri');
$current = $uri->getSegment(2) ?? 'dashboard';


$menu = [
    ['link'=>'dashboard', 'icon'=>'house-door',     'label'=>'Dashboard'],
    ['link'=>'validasi',  'icon'=>'check2-square',  'label'=>'Validasi Gedung'],
    ['link'=>'gedung',    'icon'=>'building',       'label'=>'Gedung'],
    ['link'=>'profil',    'icon'=>'person',         'label'=>'Profil'],
];
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
                <a href="<?= site_url('admin/'.$m['link']) ?>"
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
            <strong><?= $title ?? 'Dashboard' ?></strong>
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
                            <div class="small"><?= session('username') ?></div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= base_url('admin/profil') ?>"><i class="bi bi-person"></i> Profil</a></li>
                            <li><hr></li>
                            <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
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
            <a href="<?= site_url('admin/'.$m['link']) ?>"
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