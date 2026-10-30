<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'EventNela' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="<?= base_url('assets/images/favicon.ico') ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/eventnela-public.css') ?>?v=3">
    <?= $this->renderSection('head') ?>
</head>
<body class="pub-body">

    <?= $this->include('layout/header') ?>

    <main class="pub-main">
        <?= $this->renderSection('content') ?>
    </main>

    <?= $this->include('layout/footer') ?>

    <!-- AI FAB -->
    <a href="<?= base_url('chatbot') ?>" class="pub-ai-fab" title="Tanya AI">
        <span class="pub-ai-label"><i class="bi bi-robot me-1"></i> Tanya AI</span>
        <span class="pub-ai-btn">
            <i class="bi bi-robot"></i>
            <span class="pub-ai-badge">AI</span>
        </span>
    </a>

    <style>
    /* ============================================================
       HAMBURGER + SLIDE PANEL
       ============================================================ */
    .pub-hamburger {
        width: 52px; height: 52px;
        border-radius: 16px;
        background: linear-gradient(135deg, #FF7A00, #E65100);
        border: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 4px;
        box-shadow: 0 8px 20px rgba(255,122,0,.3);
        transition: .25s;
    }
    .pub-hamburger:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(255,122,0,.45); }
    .pub-hamburger span {
        display: block;
        width: 22px; height: 2.5px;
        background: white;
        border-radius: 3px;
        transition: .3s;
    }
    .pub-hamburger.active span:nth-child(1) { transform: translateY(6.5px) rotate(135deg); }
    .pub-hamburger.active span:nth-child(2) { opacity: 0; }
    .pub-hamburger.active span:nth-child(3) { transform: translateY(-6.5px) rotate(-135deg); }

    .pub-menu-overlay {
        position: fixed; inset: 0;
        background: rgba(15,23,42,.5);
        backdrop-filter: blur(4px);
        opacity: 0; visibility: hidden;
        transition: .3s; z-index: 1040;
    }
    .pub-menu-overlay.active { opacity: 1; visibility: visible; }

    .pub-menu-panel {
    position: fixed;
    top: 0; right: -400px;
    width: 380px; max-width: 90vw;
    height: 100vh;
    height: 100dvh;              /* support HP modern */
    background: white;
    z-index: 1050;
    display: flex;
    flex-direction: column;
    box-shadow: -20px 0 60px rgba(0,0,0,.15);
    transition: right .4s cubic-bezier(.4,0,.2,1);
    overflow: hidden;
}

.pub-menu-panel.active {
    right: 0;
}

    .pub-menu-header {
        flex-shrink: 0;  
        background: linear-gradient(135deg, #FF7A00, #E65100);
        padding: 22px 22px 26px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .pub-menu-header::before {
        content: ''; position: absolute; top: -50%; right: -30%;
        width: 220px; height: 220px;
        background: rgba(255,255,255,.1);
        border-radius: 50%;
    }
    .pub-menu-header-top {
        position: relative; z-index: 2;
        display: flex; justify-content: space-between; align-items: center;
    }
    .pub-menu-header-title {
        font-size: 18px; font-weight: 800;
        display: flex; align-items: center; gap: 8px;
    }
    .pub-menu-close {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: rgba(255,255,255,.2);
        border: 1px solid rgba(255,255,255,.3);
        color: white;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        transition: .2s;
        font-size: 16px;
    }
    .pub-menu-close:hover { background: rgba(255,255,255,.35); transform: rotate(90deg); }
    .pub-menu-header p {
        font-size: 13px; opacity: .9;
        margin: 12px 0 0;
        position: relative; z-index: 2;
    }

    .pub-menu-body {
    flex: 1 1 0;                 
    min-height: 0 !important;    
    overflow-y: scroll !important;  
    overflow-x: hidden !important;
    padding: 14px 12px;
    -webkit-overflow-scrolling: touch;
}
    .pub-menu-body::-webkit-scrollbar { width: 5px; }
    .pub-menu-body::-webkit-scrollbar-thumb { background: #ddd; border-radius: 3px; }

    .pub-menu-item {
        display: flex; align-items: center; gap: 14px;
        padding: 12px 14px;
        border-radius: 14px;
        color: #334155;
        font-weight: 600;
        font-size: 14.5px;
        transition: .2s;
        margin-bottom: 4px;
    }
    .pub-menu-item:hover {
        background: #FFF3E0;
        color: #E65100;
        transform: translateX(4px);
    }
    .pub-menu-item.active {
        background: linear-gradient(135deg, #FF7A00, #E65100);
        color: white;
        box-shadow: 0 8px 20px rgba(255,122,0,.3);
    }
    .pub-menu-icon {
        width: 38px; height: 38px;
        border-radius: 10px;
        background: #F1F5F9;
        color: #FF7A00;
        display: flex; align-items: center; justify-content: center;
        font-size: 17px;
        flex-shrink: 0;
        transition: .2s;
    }
    .pub-menu-item:hover .pub-menu-icon { background: #FFE0B2; }
    .pub-menu-item.active .pub-menu-icon { background: rgba(255,255,255,.25); color: white; }
    .pub-menu-arrow { margin-left: auto; opacity: 0; transition: .2s; font-size: 14px; }
    .pub-menu-item:hover .pub-menu-arrow,
    .pub-menu-item.active .pub-menu-arrow { opacity: 1; }

    .pub-menu-footer {
    padding: 18px 20px;
    border-top: 1px solid #F1F5F9;
    background: #FAFBFC;
    flex-shrink: 0;      
    max-height: 45vh;            
    overflow-y: auto;        
}
    .pub-menu-user {
        display: flex; align-items: center; gap: 12px;
        padding: 12px;
        background: white;
        border-radius: 14px;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,.04);
    }
    .pub-menu-avatar {
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
    .pub-menu-user-name { font-size: 14px; font-weight: 800; color: #0F172A; }
    .pub-menu-user-role { font-size: 11.5px; color: #64748B; text-transform: uppercase; letter-spacing: .5px; }

    .pub-menu-btn {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%;
        padding: 13px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 8px;
        transition: .25s;
        border: none;
        cursor: pointer;
    }
    .pub-menu-btn-primary {
        background: linear-gradient(135deg, #FF7A00, #E65100);
        color: white;
        box-shadow: 0 8px 20px rgba(255,122,0,.3);
    }
    .pub-menu-btn-primary:hover { transform: translateY(-2px); color: white; box-shadow: 0 12px 28px rgba(255,122,0,.4); }
    .pub-menu-btn-outline {
        background: white;
        color: #FF7A00;
        border: 2px solid #FF7A00;
    }
    .pub-menu-btn-outline:hover { background: #FFF3E0; color: #FF7A00; }
    .pub-menu-btn-logout {
        background: linear-gradient(135deg, #EF4444, #B91C1C);
        color: white;
    }
    .pub-menu-btn-logout:hover { color: white; transform: translateY(-2px); }

    @media (max-width: 576px) {
        .pub-menu-panel { width: 100%; max-width: 100%; }
    }

    /* ============================================================
       AI FAB
       ============================================================ */
    .pub-ai-fab {
        position: fixed;
        bottom: 30px; right: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 9000;
        flex-direction: row-reverse;
        text-decoration: none;
    }
    .pub-ai-label {
        background: white;
        color: #E65100;
        padding: 10px 18px;
        border-radius: 25px;
        font-weight: 800;
        font-size: 13px;
        box-shadow: 0 6px 20px rgba(0,0,0,.1);
        border: 2px solid #FF7A00;
        white-space: nowrap;
        opacity: 0; transform: translateX(10px);
        transition: .3s;
    }
    .pub-ai-fab:hover .pub-ai-label { opacity: 1; transform: translateX(0); }
    .pub-ai-btn {
        width: 62px; height: 62px;
        background: linear-gradient(135deg, #FF7A00, #E65100);
        color: white;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 24px;
        box-shadow: 0 10px 30px rgba(255,122,0,.5);
        position: relative;
        animation: pubAiPulse 2s infinite;
    }
    .pub-ai-badge {
        position: absolute; top: -4px; right: -4px;
        background: #EF4444;
        color: white;
        font-size: 10px; font-weight: 800;
        padding: 3px 8px;
        border-radius: 12px;
        border: 2px solid white;
    }
    @keyframes pubAiPulse {
        0%, 100% { box-shadow: 0 10px 30px rgba(255,122,0,.5), 0 0 0 0 rgba(255,122,0,.6); }
        50% { box-shadow: 0 10px 30px rgba(255,122,0,.5), 0 0 0 20px rgba(255,122,0,0); }
    }
    @media (max-width: 768px) {
        .pub-ai-fab { bottom: 20px; right: 15px; }
        .pub-ai-label { opacity: 1; transform: translateX(0); font-size: 11px; padding: 6px 12px; }
        .pub-ai-btn { width: 56px; height: 56px; font-size: 22px; }
    }
        /* AI FAB sembunyikan saat menu buka */
    body.pub-menu-open .pub-ai-fab {
        opacity: 0;
        visibility: hidden;
        transform: translateX(100px);
        pointer-events: none;
    }

        body.pub-menu-open .pub-ai-fab {
        opacity: 0;
        visibility: hidden;
        transform: translateX(100px);
        pointer-events: none;
    }

    /* 
   FOOTER ORANGE SOFT — FINAL
    */
        footer,
        footer.bg-dark,
        .footer,
        .footer.bg-dark,
        .pub-footer,
        .pub-footer.bg-dark {
            background: #FFE0B2 !important;      /* orange soft */
            color: #4A2C00 !important;           /* teks coklat gelap */
            border-top: 1px solid #FFCC80 !important;
        }

        /* Semua teks di footer jadi coklat gelap */
        footer h1, footer h2, footer h3, footer h4, footer h5, footer h6,
        footer p, footer span, footer a, footer li, footer div,
        footer .text-white, footer .text-light, footer .text-muted, footer .text-white-50,
        .footer h1, .footer h2, .footer h3, .footer h4, .footer h5, .footer h6,
        .footer p, .footer span, .footer a, .footer li, .footer div,
        .footer .text-white, .footer .text-light, .footer .text-muted, .footer .text-white-50,
        .pub-footer h1, .pub-footer h2, .pub-footer h3, .pub-footer h4, .pub-footer h5, .pub-footer h6,
        .pub-footer p, .pub-footer span, .pub-footer a, .pub-footer li, .pub-footer div,
        .pub-footer .text-white, .pub-footer .text-light, .pub-footer .text-muted, .pub-footer .text-white-50 {
            color: #4A2C00 !important;
        }

        /* Link hover */
        footer a:hover,
        .footer a:hover,
        .pub-footer a:hover {
            color: #E65100 !important;
        }

        /* Ikon default */
        footer i,
        .footer i,
        .pub-footer i {
            color: #E65100 !important;
        }

        /* Ikon sosial media bulat */
        footer .social-icon,
        footer .btn-social,
        footer .rounded-circle,
        .footer .social-icon,
        .footer .btn-social,
        .footer .rounded-circle,
        .pub-footer .social-icon,
        .pub-footer .btn-social,
        .pub-footer .rounded-circle {
            background: #FFCC80 !important;
            border: none !important;
        }

        footer .social-icon i,
        footer .btn-social i,
        footer .rounded-circle i,
        .footer .social-icon i,
        .footer .btn-social i,
        .footer .rounded-circle i,
        .pub-footer .social-icon i,
        .pub-footer .btn-social i,
        .pub-footer .rounded-circle i {
            color: #FFFFFF !important;
        }

        /* Garis copyright */
        footer hr,
        .footer hr,
        .pub-footer hr {
            border-color: #FFCC80 !important;
            opacity: .6 !important;
        }

        /* Logo teks di footer */
        footer .logo,
        footer .brand,
        .footer .logo,
        .footer .brand,
        .pub-footer .logo,
        .pub-footer .brand {
            color: #E65100 !important;
        }
    </style>

    <?= $this->renderSection('scripts') ?>
</body>
</html>