<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ------------------ HOME ------------------
$routes->get('/', 'Home::index');
$routes->get('event', 'EventController::index');
$routes->get('detail_event/(:num)', 'EventController::detail/$1');
$routes->get('/panduan',      'Home::panduan');
$routes->get('/panduan/pdf',  'Home::panduanPdf');
$routes->get('tentang', 'Home::tentang');
$routes->get('search', 'SearchController::index');


// ------------------ AUTH ------------------
$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->get('logout', 'Auth::logout');
$routes->get('auth/forgotPassword', 'Auth::forgotPassword');
$routes->post('auth/sendResetLink', 'Auth::sendResetLink');
$routes->get('auth/resetPassword/(:segment)', 'Auth::resetPassword/$1');
$routes->post('auth/updatePassword', 'Auth::updatePassword');
$routes->get('register', 'Auth::register');
$routes->post('auth/doRegister', 'Auth::doRegister');


// ================== ADMIN (Pengelola Gedung) ==================
$routes->get('admin', 'Admin::dashboard');
$routes->get('admin/dashboard', 'Admin::dashboard');

// ===== GEDUNG =====
$routes->get('admin/gedung', 'Admin\Gedung::index');
$routes->get('admin/gedung/tambah', 'Admin\Gedung::tambah');
$routes->post('admin/gedung/simpan', 'Admin\Gedung::simpan');
$routes->get('admin/gedung/edit/(:num)', 'Admin\Gedung::edit/$1');
$routes->post('admin/gedung/update/(:num)', 'Admin\Gedung::update/$1');
$routes->get('admin/gedung/hapus/(:num)', 'Admin\Gedung::hapus/$1');

// ===== VALIDASI GEDUNG (BARU) =====
$routes->get('admin/validasi', 'Admin::validasiGedung');
$routes->get('admin/validasi/approve/(:num)', 'Admin::approveGedung/$1');
$routes->get('admin/validasi/reject/(:num)', 'Admin::rejectGedung/$1');
$routes->get('admin/validasi/detail/(:num)', 'Admin::detailValidasi/$1');
$routes->post('admin/validasi/proses/(:num)', 'Admin::prosesValidasi/$1');

// Admin Profil
$routes->get('admin/profil', 'Profile::index');
$routes->post('admin/profil/update', 'Profile::update');


// ------------------ ORMAWA ------------------
$routes->get('ormawa/dashboard', 'Ormawa::dashboard');

// ===== ORMAWA - KELOLA ULASAN =====
$routes->get('ormawa/ulasan', 'Ormawa::ulasan');
$routes->get('ormawa/ulasan/hapus/(:num)', 'Ormawa::hapusUlasan/$1');

// Ormawa Profil
$routes->get('ormawa/profil', 'OrmawaProfil::index');
$routes->post('ormawa/profil/update', 'OrmawaProfil::update');

// Ormawa – Kegiatan
$routes->get('ormawa/kegiatan', 'KegiatanOrmawa::index');
$routes->get('ormawa/kegiatan/tambah', 'KegiatanOrmawa::tambah');
$routes->post('ormawa/kegiatan/simpan', 'KegiatanOrmawa::simpan');
$routes->get('ormawa/kegiatan/edit/(:segment)', 'KegiatanOrmawa::edit/$1');
$routes->post('ormawa/kegiatan/update/(:segment)', 'KegiatanOrmawa::update/$1');
$routes->get('ormawa/kegiatan/delete/(:segment)', 'KegiatanOrmawa::delete/$1');
$routes->get('ormawa/kegiatan/ajukan/(:segment)', 'KegiatanOrmawa::ajukan/$1');
$routes->get('ormawa/riwayat', 'RiwayatOrmawa::index');
$routes->get('ormawa/kegiatan/cekGedung', 'KegiatanOrmawa::cekGedung');
$routes->post('ormawa/kegiatan/generateAI', 'KegiatanOrmawa::generateAI');
$routes->get('ormawa/kegiatan/generate-ai', 'KegiatanOrmawa::generateAIPage');
$routes->post('ormawa/kegiatan/proses-ai', 'KegiatanOrmawa::prosesAI');

// ===== ORMAWA - REPORT / LPJ =====
$routes->get('ormawa/report',                    'ReportOrmawa::index');
$routes->get('ormawa/report/isi/(:num)',         'ReportOrmawa::isi/$1');
$routes->post('ormawa/report/simpan',            'ReportOrmawa::simpan');
$routes->get('ormawa/report/detail/(:num)',      'ReportOrmawa::detail/$1');
$routes->get('ormawa/report/pengesahan/(:num)',  'ReportOrmawa::pengesahan/$1');

// ===== PEMBINA - VERIFIKASI REPORT =====
$routes->get('pembina/report',                   'Pembina::report');
$routes->get('pembina/report/detail/(:num)',     'Pembina::detailReport/$1');
$routes->post('pembina/report/verifikasi/(:num)','Pembina::verifikasiReport/$1');

// ===== VALIDATOR (WADIR) - VERIFIKASI REPORT =====
$routes->get('validator/report',                 'ValidatorController::report');
$routes->get('validator/report/detail/(:num)',   'ValidatorController::detailReport/$1');
$routes->post('validator/report/verifikasi/(:num)', 'ValidatorController::verifikasiReport/$1');

// Ormawa – Program Kerja
$routes->get('ormawa/program-kerja', 'ProgramKerja::index');
$routes->get('ormawa/program-kerja/tambah', 'ProgramKerja::tambah');
$routes->post('ormawa/program-kerja/simpan', 'ProgramKerja::simpan');
$routes->get('ormawa/program-kerja/edit/(:segment)', 'ProgramKerja::edit/$1');
$routes->post('ormawa/program-kerja/update/(:segment)', 'ProgramKerja::update/$1');
$routes->get('ormawa/program-kerja/hapus/(:segment)', 'ProgramKerja::hapus/$1');
$routes->get('ormawa/program-kerja/ajukan/(:segment)', 'ProgramKerja::ajukan/$1');

// Ormawa – Proposal
$routes->get('ormawa/proposal', 'ProposalOrmawa::index');
$routes->get('ormawa/proposal/isi/(:num)', 'ProposalOrmawa::isi/$1');
$routes->post('ormawa/proposal/simpan', 'ProposalOrmawa::simpan');
$routes->get('ormawa/proposal/detail/(:num)', 'ProposalOrmawa::detail/$1');
$routes->get('ormawa/proposal/pengesahan/(:num)', 'ProposalOrmawa::pengesahan/$1');
$routes->get('ormawa/proposal/hapus/(:num)', 'ProposalOrmawa::hapus/$1');
$routes->get('ormawa/report/hapus/(:num)', 'ReportOrmawa::hapus/$1');

// Ormawa – Pengurus
$routes->get('ormawa/pengurus', 'Pengurus::index');
$routes->get('ormawa/pengurus/tambah', 'Pengurus::tambah');
$routes->post('ormawa/pengurus/simpan', 'Pengurus::simpan');
$routes->get('ormawa/pengurus/edit/(:segment)', 'Pengurus::edit/$1');
$routes->post('ormawa/pengurus/update/(:segment)', 'Pengurus::update/$1');
$routes->get('ormawa/pengurus/hapus/(:segment)', 'Pengurus::hapus/$1');

// Ormawa – Departemen / Divisi
$routes->get('ormawa/departemen', 'Departemen::index');
$routes->get('ormawa/departemen/tambah', 'Departemen::tambah');
$routes->post('ormawa/departemen/simpan', 'Departemen::simpan');
$routes->get('ormawa/departemen/edit/(:segment)', 'Departemen::edit/$1');
$routes->post('ormawa/departemen/update/(:segment)', 'Departemen::update/$1');
$routes->get('ormawa/departemen/hapus/(:segment)', 'Departemen::hapus/$1');

// Ormawa – Galeri Dokumentasi
$routes->get('ormawa/galeri-ormawa', 'GaleriOrmawa::index');
$routes->get('ormawa/galeri-ormawa/tambah', 'GaleriOrmawa::tambah');
$routes->post('ormawa/galeri-ormawa/simpan', 'GaleriOrmawa::simpan');
$routes->get('ormawa/galeri-ormawa/hapus/(:num)', 'GaleriOrmawa::hapus/$1');

// Ormawa – Recruitment (Kelola)
$routes->get('ormawa/recruitment', 'Recruitment::kelola');
$routes->get('ormawa/recruitment/tambah', 'Recruitment::tambah');
$routes->post('ormawa/recruitment/simpan', 'Recruitment::simpan');
$routes->get('ormawa/recruitment/edit/(:num)', 'Recruitment::edit/$1');
$routes->post('ormawa/recruitment/update/(:num)', 'Recruitment::update/$1');
$routes->get('ormawa/recruitment/hapus/(:num)', 'Recruitment::hapus/$1');
$routes->get('ormawa/recruitment/pendaftar/(:num)', 'Recruitment::pendaftar/$1');
$routes->post('ormawa/recruitment/update-status/(:num)', 'Recruitment::updateStatusPendaftar/$1');
$routes->post('ormawa/recruitment/update-bulk', 'Recruitment::updateBulkStatus');

// Ormawa – Kelola Staf
$routes->get('ormawa/staf', 'Staf::index');
$routes->get('ormawa/staf/tambah', 'Staf::tambah');
$routes->post('ormawa/staf/simpan', 'Staf::simpan');
$routes->get('ormawa/staf/edit/(:num)', 'Staf::edit/$1');
$routes->post('ormawa/staf/update/(:num)', 'Staf::update/$1');
$routes->get('ormawa/staf/hapus/(:num)', 'Staf::hapus/$1');

// Ormawa – Kelola Berita
$routes->get('ormawa/berita', 'Berita::kelola');
$routes->get('ormawa/berita/tambah', 'Berita::tambah');
$routes->post('ormawa/berita/simpan', 'Berita::simpan');
$routes->get('ormawa/berita/edit/(:num)', 'Berita::edit/$1');
$routes->post('ormawa/berita/update/(:num)', 'Berita::update/$1');
$routes->get('ormawa/berita/hapus/(:num)', 'Berita::hapus/$1');


// ------------------ VALIDATOR (Wadir Kemahasiswaan) ------------------
$routes->get('validator/dashboard', 'ValidatorController::dashboard');

// Validasi Event
$routes->get('validator/approve/(:num)', 'ValidatorController::approve/$1');
$routes->get('validator/reject/(:num)', 'ValidatorController::reject/$1');
$routes->get('validator/hapus/(:num)', 'ValidatorController::hapus/$1');

// Profil Validator
$routes->get('validator/profil', 'ValidatorProfil::index');
$routes->post('validator/profil/update', 'ValidatorProfil::update');

// ===== VALIDATOR - PROGRAM KERJA =====
$routes->get('validator/progja', 'ValidatorController::progja');
$routes->get('validator/progja/detail/(:num)', 'ValidatorController::detailProgja/$1');
$routes->post('validator/progja/proses/(:num)', 'ValidatorController::prosesProgja/$1');

// ===== VALIDATOR - PROPOSAL =====
$routes->get('validator/proposal', 'ValidatorController::proposal');
$routes->get('validator/proposal/detail/(:num)', 'ValidatorController::detailProposal/$1');
$routes->post('validator/proposal/verifikasi/(:num)', 'ValidatorController::verifikasiProposal/$1');

// ===== KELOLA ORMAWA (BARU - pindah dari Admin) =====
$routes->get('validator/ormawa', 'ValidatorController::ormawa');
$routes->get('validator/ormawa/tambah', 'ValidatorController::tambahOrmawa');
$routes->post('validator/ormawa/simpan', 'ValidatorController::simpanOrmawa');
$routes->get('validator/ormawa/edit/(:num)', 'ValidatorController::editOrmawa/$1');
$routes->post('validator/ormawa/update/(:num)', 'ValidatorController::updateOrmawa/$1');
$routes->get('validator/ormawa/hapus/(:num)', 'ValidatorController::hapusOrmawa/$1');

// ===== KELOLA DOSEN (pindah dari Admin) =====
$routes->get('validator/dosen', 'ValidatorController::dosen');
$routes->get('validator/dosen/tambah', 'ValidatorController::tambahDosen');
$routes->post('validator/dosen/simpan', 'ValidatorController::simpanDosen');
$routes->get('validator/dosen/edit/(:num)', 'ValidatorController::editDosen/$1');
$routes->post('validator/dosen/update/(:num)', 'ValidatorController::updateDosen/$1');
$routes->get('validator/dosen/hapus/(:num)', 'ValidatorController::hapusDosen/$1');


// ------------------ UKM PUBLIK ------------------
$routes->get('ukm', 'OrmawaPublic::index');
$routes->get('ukm/detail/(:num)', 'OrmawaPublic::detail/$1');

// ===== ULASAN EVENT =====
$routes->post('event/simpanUlasan', 'EventController::simpanUlasan');
$routes->get('event/hapusUlasan/(:num)', 'EventController::hapusUlasan/$1');

// ===== OPEN RECRUITMENT (PUBLIK) =====
$routes->get('recruitment', 'Recruitment::index');
$routes->get('recruitment/detail/(:num)', 'Recruitment::detail/$1');
$routes->get('recruitment/form-daftar/(:num)', 'Recruitment::formDaftar/$1');
$routes->post('recruitment/simpan-pendaftaran', 'Recruitment::simpanPendaftaran');
$routes->get('recruitment/riwayat', 'Recruitment::riwayat');

// ===== PROFIL SAYA (Semua User Login) =====
$routes->get('my-profile', 'MyProfile::index');
$routes->post('my-profile/update-foto', 'MyProfile::updateFoto');

// ===== BERITA (PUBLIK) =====
$routes->get('berita', 'Berita::index');
$routes->get('berita/detail/(:num)', 'Berita::detail/$1');

// ===== CHATBOT AI =====
$routes->get('chatbot', 'Chatbot::index');
$routes->post('chatbot/ask', 'Chatbot::ask');
$routes->post('chatbot/clear', 'Chatbot::clear');

// ===== DASHBOARD MAHASISWA =====
$routes->get('mahasiswa/dashboard', 'Mahasiswa::dashboard');

$routes->post('ormawa/kegiatan/chat-ai', 'KegiatanOrmawa::chatAi');

// ===== PEMBINA =====
$routes->get('pembina/dashboard',     'Pembina::dashboard');
$routes->get('pembina/profil',        'Pembina::profil');
$routes->post('pembina/update-profil','Pembina::updateProfil');

// ===== PEMBINA - PROPOSAL =====
$routes->get('pembina/proposal', 'Pembina::proposal');
$routes->get('pembina/proposal/detail/(:num)', 'Pembina::detailProposal/$1');
$routes->post('pembina/proposal/verifikasi/(:num)', 'Pembina::verifikasiProposal/$1');

// ===== BACKUP DATA (VALIDATOR) =====
$routes->get('validator/backup',           'BackupController::index');
$routes->get('validator/backup/rekap',     'BackupController::rekapData');
$routes->get('validator/backup/uploads',   'BackupController::backupUploads');



