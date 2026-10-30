<?php

namespace App\Controllers;

use App\Models\UserModel;

class MyProfile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ==================== TAMPIL HALAMAN PROFIL SAYA ====================
    public function index()
    {
        // Cek login
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $id_user = session()->get('user_id');
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()->to('/')->with('error', 'User tidak ditemukan.');
        }

        return view('my_profile', [
            'title' => 'Profil Saya',
            'user' => $user
        ]);
    }

    // ==================== UPDATE FOTO PROFIL ====================
    public function updateFoto()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('login');
        }

        $id_user = session()->get('user_id');
        $user = $this->userModel->find($id_user);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Validasi ukuran (max 2MB) & tipe
            if ($foto->getSize() > 2048000) {
                return redirect()->back()->with('error', 'Ukuran foto maksimal 2MB.');
            }

            $allowedMime = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!in_array($foto->getMimeType(), $allowedMime)) {
                return redirect()->back()->with('error', 'Format foto harus JPG, PNG, atau WEBP.');
            }

            // Hapus foto lama (kalau bukan default)
            if (!empty($user['foto']) 
                && $user['foto'] !== 'default.png' 
                && file_exists('uploads/profil/' . $user['foto'])) {
                unlink('uploads/profil/' . $user['foto']);
            }

            // Simpan foto baru
            $newName = $foto->getRandomName();
            $foto->move('uploads/profil', $newName);

            // Update database
            $this->userModel->update($id_user, ['foto' => $newName]);

            // Update session
            session()->set('foto', $newName);

            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Pilih file foto terlebih dahulu.');
    }
}