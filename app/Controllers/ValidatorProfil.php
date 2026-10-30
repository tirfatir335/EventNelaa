<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ValidatorProfil extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * ===============================
     * TAMPIL PROFIL VALIDATOR
     * ===============================
     */
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $id = session()->get('user_id');
        $validator = $this->userModel->find($id);

        if (!$validator) {
            return redirect()->to('/login')
                ->with('error', 'Data user tidak ditemukan.');
        }

        return view('validator/profil', [
            'validator' => $validator
        ]);
    }

    /**
     * ===============================
     * UPDATE PROFIL VALIDATOR
     * ===============================
     */
    public function update()
    {
        if (!session()->get('logged_in')) {
            return redirect()->back()
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $id = session()->get('user_id');
        $validator = $this->userModel->find($id);

        if (!$validator) {
            return redirect()->back()
                ->with('error', 'Data user tidak ditemukan.');
        }

        // ================= VALIDASI =================
        $rules = [
            'email' => 'required|valid_email',
            'no_telp' => 'permit_empty',
            'foto' => [
                'rules' => 'if_exist|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB',
                    'is_image' => 'File harus berupa gambar',
                    'mime_in'  => 'Format foto harus JPG atau PNG'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', $this->validator->listErrors());
        }

        // ================= DATA =================
        $data = [
            'email'   => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp'),
        ];

        // ================= FOTO =================
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {

            // hapus foto lama
            if (!empty($validator['foto']) &&
                file_exists(FCPATH . 'uploads/profil/' . $validator['foto'])) {
                unlink(FCPATH . 'uploads/profil/' . $validator['foto']);
            }

            $newName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/profil', $newName);

            $data['foto'] = $newName;

            // update session foto
            session()->set('foto', $newName);
        }

        // UPDATE DATABASE
        $this->userModel->update($id, $data);

        return redirect()->back()
            ->with('success', 'Profil validator berhasil diperbarui.');
    }
}
