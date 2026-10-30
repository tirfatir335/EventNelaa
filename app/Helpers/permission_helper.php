<?php

use App\Models\PermissionModel;

if (!function_exists('can_access')) {
    function can_access($module, $action = 'view')
    {
        $session = session();
        $role = $session->get('role');

        if (in_array($role, ['super_admin', 'admin', 'organisasi'])) {
            return true;
        }

        if ($role === 'staf_ormawa') {
            $permissionModel = new PermissionModel();
            return $permissionModel->hasAccess($session->get('user_id'), $module, $action);
        }

        return false;
    }
}

if (!function_exists('get_user_modules')) {
    function get_user_modules()
    {
        $session = session();
        $role = $session->get('role');

        // Admin = semua modul
        if (in_array($role, ['super_admin', 'admin', 'organisasi'])) {
            return [
                'dashboard', 'profil', 'progja', 'pengurus',
                'departemen', 'galeri', 'berita', 'recruitment',
                'event', 'riwayat', 'staf',
                'ulasan'   
            ];
        }

        // Staf = sesuai permission
        if ($role === 'staf_ormawa') {
            $permissionModel = new PermissionModel();
            $modules = $permissionModel->getModules($session->get('user_id'));
            array_unshift($modules, 'dashboard');
            return $modules;
        }

        return ['dashboard'];
    }
}

if (!function_exists('get_first_module_url')) {
    /**
     * Ambil URL modul pertama yang bisa diakses staf.
     * Dipakai untuk redirect setelah login staf.
     */
    function get_first_module_url()
    {
        $modules = get_user_modules();

        // Mapping modul → URL
        $moduleUrl = [
            'profil'      => 'ormawa/profil',
            'progja'      => 'ormawa/program-kerja',
            'pengurus'    => 'ormawa/pengurus',
            'departemen'  => 'ormawa/departemen',
            'galeri'      => 'ormawa/galeri-ormawa',
            'berita'      => 'ormawa/berita',
            'recruitment' => 'ormawa/recruitment',
            'event'       => 'ormawa/kegiatan',
            'staf'        => 'ormawa/staf',
        ];

        // Return URL modul pertama yang ada
        foreach ($modules as $m) {
            if (isset($moduleUrl[$m])) {
                return $moduleUrl[$m];
            }
        }

        // Fallback kalau tidak punya akses apapun
        return 'logout';
    }
}

if (!function_exists('is_super_admin')) {
    function is_super_admin()
    {
        return session()->get('role') === 'super_admin';
    }
}

if (!function_exists('is_admin_ormawa')) {
    function is_admin_ormawa()
    {
        return in_array(session()->get('role'), ['organisasi', 'admin']);
    }
}

if (!function_exists('is_staf')) {
    function is_staf()
    {
        return session()->get('role') === 'staf_ormawa';
    }
}