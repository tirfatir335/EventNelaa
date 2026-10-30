<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $id = session()->get('user_id'); // SESUAIKAN DENGAN LOGIN

        if (!$id || !session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->to('/login')->with('error', 'User tidak ditemukan.');
        }

        return view('admin/profil', ['user' => $user]);
    }

    public function update()
    {
        $id = session()->get('user_id');

        if (!$id || !session()->get('logged_in')) {
            return redirect()->back()->with('error', 'User tidak ditemukan atau belum login.');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $data = [];

        // update field dasar
        if ($this->request->getPost('username')) $data['username'] = $this->request->getPost('username');
        if ($this->request->getPost('email'))    $data['email'] = $this->request->getPost('email');
        if ($this->request->getPost('no_telp'))  $data['no_telp'] = $this->request->getPost('no_telp');

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // upload foto
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // hapus foto lama
            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/profil/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/profil/' . $user['foto']);
            }

            $newName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/profil', $newName);

            $data['foto'] = $newName;

            // update session
            session()->set('foto', $newName);
        }

        if (!empty($data)) {
            $this->userModel->update($id, $data);
            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        }

        return redirect()->back()->with('info', 'Tidak ada perubahan data.');
    }
}
