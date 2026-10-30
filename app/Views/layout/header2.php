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

/* SIDEBAR */
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
</style>
</head>
<body>

<?php
$uri = service('uri');
$current = $uri->getSegment(2) ?? 'dashboard';

$menu = [
    ['link'=>'dashboard','icon'=>'house-door','label'=>'Dashboard'],
    ['link'=>'profil','icon'=>'person','label'=>'Profil'],
    ['link'=>'kegiatan','icon'=>'journal-text','label'=>'Event'],
    ['link'=>'riwayat','icon'=>'clock-history','label'=>'Riwayat'],
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

        <!-- TOPBAR MOBILE -->
        <div class="topbar d-md-none">
            <button class="btn" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-3"></i>
            </button>
            <strong><?= $title ?? 'Dashboard Ormawa' ?></strong>
        </div>

        <!-- CONTENT -->
        <div class="content-scroll">
            <div class="content-wrapper shadow">

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

</body>
</html>
