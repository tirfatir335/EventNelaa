<?php 
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $uri = $request->getUri()->getPath();
        
        // =====================================================
        // CEK 1: Kalau sudah login & buka /login atau /register
        // → redirect ke dashboard/home sesuai role
        // =====================================================
        if (session()->get('logged_in')) {
            if (strpos($uri, 'login') !== false || strpos($uri, 'register') !== false) {
                $role = session()->get('role');
                
                if ($role === 'super_admin' || $role === 'admin') {
                    return redirect()->to('admin/dashboard');
                } elseif ($role === 'organisasi') {
                    return redirect()->to('ormawa/dashboard');
                } elseif ($role === 'staf_ormawa') {
                    $firstUrl = get_first_module_url();
                    if ($firstUrl === 'logout') {
                        return redirect()->to('logout');
                    }
                    return redirect()->to($firstUrl);
                } elseif ($role === 'validator') {
                    return redirect()->to('validator/dashboard');
                } elseif ($role === 'pembina') {
                    return redirect()->to('pembina/dashboard');
                } else {
                    return redirect()->to('/'); // mahasiswa → homepage
                }
            }
        }
        
        // =====================================================
        // CEK 2: Kalau belum login → redirect ke login
        // =====================================================
        if (!session()->get('logged_in')) {
            return redirect()->to('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // =====================================================
        // CEK 3: Permission staf_ormawa per modul
        // =====================================================
        if (session()->get('role') === 'staf_ormawa') {
            $segments = explode('/', trim($uri, '/'));
            $module = $segments[1] ?? '';

            // Mapping URL → nama modul
            $urlToModule = [
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
            ];

            // Kalau akses dashboard → redirect ke modul pertama
            if ($module === 'dashboard' || $module === '') {
                $firstUrl = get_first_module_url();
                if ($firstUrl === 'logout') {
                    return redirect()->to('logout');
                }
                return redirect()->to($firstUrl);
            }

            $moduleName = $urlToModule[$module] ?? null;

            // Cek akses modul
            if ($moduleName) {
                $permissionModel = new \App\Models\PermissionModel();
                $hasAccess = $permissionModel->hasAccess(
                    session()->get('user_id'),
                    $moduleName,
                    'view'
                );

                if (!$hasAccess) {
                    $firstUrl = get_first_module_url();
                    return redirect()->to($firstUrl)
                        ->with('error', 'Anda tidak memiliki akses ke modul ini.');
                }
            } else {
                $firstUrl = get_first_module_url();
                return redirect()->to($firstUrl)
                    ->with('error', 'Akses ditolak.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Kosong
    }
}