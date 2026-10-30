<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PermissionModel;

class Staf extends BaseController
{
    protected $userModel;
    protected $permissionModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->permissionModel = new PermissionModel();
    }

    // ==================== DAFTAR STAF ====================
    public function index()
    {
        // Hanya admin ormawa yang bisa akses
        if (!in_array(session()->get('role'), ['organisasi', 'admin'])) {
            return redirect()->to('login')->with('error', 'Akses ditolak.');
        }

        $id_ormawa = session()->get('id_ormawa');

        // Ambil semua staf di ormawa ini
        $staf = $this->userModel
            ->where('id_ormawa', $id_ormawa)
            ->where('role', 'staf_ormawa')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Ambil permission untuk setiap staf
        foreach ($staf as &$s) {
            $s['permissions'] = $this->permissionModel->getByUser($s['id']);
        }

        return view('ormawa/staf/index', [
            'title' => 'Kelola Staf',
            'staf' => $staf
        ]);
    }

    // ==================== FORM TAMBAH STAF ====================
    public function tambah()
    {
        if (!in_array(session()->get('role'), ['organisasi', 'admin'])) {
            return redirect()->to('login')->with('error', 'Akses ditolak.');
        }

        return view('ormawa/staf/tambah', [
            'title' => 'Tambah Staf'
        ]);
    }

    // ==================== SIMPAN STAF BARU ====================
    public function simpan()
    {
        if (!in_array(session()->get('role'), ['organisasi', 'admin'])) {
            return redirect()->to('login')->with('error', 'Akses ditolak.');
        }

        $id_ormawa = session()->get('id_ormawa');
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $no_telp = $this->request->getPost('no_telp');

        // Validasi
        if ($this->userModel->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username sudah terdaftar.');
        }
        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        // Insert user baru dengan role staf_ormawa
        $id_user = $this->userModel->insert([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'no_telp' => $no_telp,
            'role' => 'staf_ormawa',
            'id_ormawa' => $id_ormawa,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Simpan permissions
        $permissions = $this->request->getPost('permissions') ?? [];
        $this->permissionModel->simpanPermissions($id_user, $permissions);

        return redirect()->to('ormawa/staf')->with('success', 'Staf berhasil ditambahkan.');
    }

    // ==================== FORM EDIT STAF ====================
    public function edit($id)
    {
        if (!in_array(session()->get('role'), ['organisasi', 'admin'])) {
            return redirect()->to('login')->with('error', 'Akses ditolak.');
        }

        $id_ormawa = session()->get('id_ormawa');

        // Pastikan staf ini milik ormawa yang login
        $staf = $this->userModel
            ->where('id', $id)
            ->where('id_ormawa', $id_ormawa)
            ->where('role', 'staf_ormawa')
            ->first();

        if (!$staf) {
            return redirect()->to('ormawa/staf')->with('error', 'Staf tidak ditemukan.');
        }

        // Ambil permission
        $permissions = $this->permissionModel->getByUser($id);
        $permissionMap = [];
        foreach ($permissions as $p) {
            $permissionMap[$p['module']] = $p;
        }

        return view('ormawa/staf/edit', [
            'title' => 'Edit Staf',
            'staf' => $staf,
            'permissionMap' => $permissionMap
        ]);
    }

    // ==================== UPDATE STAF ====================
    public function update($id)
    {
        if (!in_array(session()->get('role'), ['organisasi', 'admin'])) {
            return redirect()->to('login')->with('error', 'Akses ditolak.');
        }

        $id_ormawa = session()->get('id_ormawa');

        $staf = $this->userModel
            ->where('id', $id)
            ->where('id_ormawa', $id_ormawa)
            ->where('role', 'staf_ormawa')
            ->first();

        if (!$staf) {
            return redirect()->to('ormawa/staf')->with('error', 'Staf tidak ditemukan.');
        }

        // Update data user
        $dataUser = [
            'email'   => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp')
        ];

        // Update password jika diisi
        if ($this->request->getPost('password')) {
            $dataUser['password'] = password_hash(
                $this->request->getPost('password'), 
                PASSWORD_DEFAULT
            );
        }

        $this->userModel->update($id, $dataUser);

        // Update permissions
        $permissions = $this->request->getPost('permissions') ?? [];
        $this->permissionModel->simpanPermissions($id, $permissions);

        return redirect()->to('ormawa/staf')->with('success', 'Data staf berhasil diperbarui.');
    }

    // ==================== HAPUS STAF ====================
    public function hapus($id)
    {
        if (!in_array(session()->get('role'), ['organisasi', 'admin'])) {
            return redirect()->to('login')->with('error', 'Akses ditolak.');
        }

        $id_ormawa = session()->get('id_ormawa');

        $staf = $this->userModel
            ->where('id', $id)
            ->where('id_ormawa', $id_ormawa)
            ->where('role', 'staf_ormawa')
            ->first();

        if (!$staf) {
            return redirect()->to('ormawa/staf')->with('error', 'Staf tidak ditemukan.');
        }

        // Hapus user (permission otomatis terhapus karena CASCADE)
        $this->userModel->delete($id);

        return redirect()->to('ormawa/staf')->with('success', 'Staf berhasil dihapus.');
    }
}