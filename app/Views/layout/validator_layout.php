<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Validator' ?></title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico'); ?>">
    <style>
        :root{
            --sidebar:#D4E2FF;
            --accent:#FF8800;
        }

        html, body { height:100%; }

        body{
            margin:0;
            background:url('<?= base_url('assets/images/bg.jpg') ?>') no-repeat center center fixed;
            background-size:cover;
            overflow:hidden;
        }

        /* ===== LAYOUT ===== */
        .app-wrapper{
            display:flex;
            height:100vh;
            width:100vw;
        }

        /* ===== SIDEBAR ===== */
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
        }

        .sidebar .nav-link:hover{
            background:#FFBB66;
            color:#fff;
        }

        .sidebar .nav-link.active{
            background:var(--accent)!important;
            color:#fff!important;
        }

        /* ===== MAIN ===== */
        .main-area{
            flex:1;
            display:flex;
            flex-direction:column;
            height:100vh;
        }

        /* ===== TOPBAR MOBILE ===== */
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
            overflow-y:auto;
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
        body.modal-open{
            overflow:hidden!important;
        }

        body.modal-open .content-wrapper{
            backdrop-filter:none!important;
        }

        .modal{z-index:1060;}
        .modal-backdrop{z-index:1055;}
    </style>
</head>
<body>

<?php
$uri = service('uri');
$current = $uri->getSegment(2) ?? 'dashboard';
$menu = [
    ['link'=>'dashboard', 'icon'=>'house-door',          'label'=>'Dashboard'],
    ['link'=>'progja',    'icon'=>'clipboard-check',     'label'=>'Program Kerja'],
    ['link'=>'proposal',  'icon'=>'file-earmark-text',   'label'=>'Proposal'],
    ['link'=>'report',    'icon'=>'file-earmark-check',  'label'=>'Verifikasi LPJ'],
    ['link'=>'profil',    'icon'=>'person',              'label'=>'Profil'],
    ['link'=>'ormawa',    'icon'=>'people-fill',         'label'=>'Kelola Ormawa'],
    ['link'=>'dosen',     'icon'=>'person-badge',        'label'=>'Kelola Pembina'],
    ['link'=>'backup',    'icon'=>'download',            'label'=>'Backup Data'],
];
?>

<div class="app-wrapper">

    <!-- SIDEBAR DESKTOP (TANPA LOGOUT) -->
    <aside class="sidebar d-none d-md-block">
        <div class="p-3">
            <a href="<?= base_url('validator/dashboard') ?>" class="d-flex align-items-center mb-4">
                <img src="<?= base_url('assets/images/logo eventnela.png') ?>" height="40">
            </a>

            <div class="nav nav-pills flex-column">
                <?php foreach($menu as $m): ?>
                <a href="<?= site_url('validator/'.$m['link']) ?>"
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

        <!-- TOPBAR MOBILE -->
        <div class="topbar d-md-none">
            <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-3"></i>
            </button>
            <strong><?= $title ?? 'Dashboard' ?></strong>
        </div>

        <!-- CONTENT -->
        <div class="content-scroll">
            <div class="content-wrapper shadow">

                <!-- HEADER CONTENT -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="search-box flex-grow-1 me-2">
                        <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                    </div>

                    <!-- PROFIL (ADA LOGOUT) -->
                    <div class="dropdown text-center">
                        <button class="btn p-0" data-bs-toggle="dropdown">
                            <img src="<?= base_url('uploads/profil/'.(session('foto')??'default.png')) ?>" class="profile-img">
                            <div class="small"><?= session('username') ?></div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?= base_url('validator/profil') ?>">
                                    <i class="bi bi-person me-2"></i> Profil
                                </a>
                            </li>
                            <li><hr></li>
                            <li>
                                <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
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

<!-- SIDEBAR MOBILE (TANPA LOGOUT) -->
<div class="offcanvas offcanvas-start" id="mobileSidebar">
    <div class="offcanvas-header" style="background:#D4E2FF">
        <h5 class="fw-bold">EventNela</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="nav nav-pills flex-column">
            <?php foreach($menu as $m): ?>
            <a href="<?= site_url('validator/'.$m['link']) ?>"
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
