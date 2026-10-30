<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OrganisasiModel;

class OrmawaProfil extends BaseController
{
    protected $userModel;
    protected $ormawaModel;

    public function __construct()
    {
        $this->userModel   = new UserModel();
        $this->ormawaModel = new OrganisasiModel();
    }

    public function index()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login')->with('error', 'Akses ditolak!');
        }

        $id_user = session()->get('user_id');
        $user = $this->userModel->find($id_user);

        if (!$user || empty($user['id_ormawa'])) {
            return redirect()->back()->with('error', 'Data ormawa tidak ditemukan.');
        }

        $profil = $this->ormawaModel
            ->select('ormawa.*, users.email, users.no_telp, users.foto as foto_user')
            ->join('users', 'users.id_ormawa = ormawa.id_ormawa', 'left')
            ->where('ormawa.id_ormawa', $user['id_ormawa'])
            ->first();

        return view('ormawa/profil', [
            'profil' => $profil,
            'user'   => $user
        ]);
    }

    public function update()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'organisasi') {
            return redirect()->to('login')->with('error', 'Akses ditolak!');
        }

        $id_user   = session()->get('user_id');
        $user      = $this->userModel->find($id_user);
        $id_ormawa = $user['id_ormawa'];

        if (!$user || empty($id_ormawa)) {
            return redirect()->back()->with('error', 'Data ormawa tidak ditemukan.');
        }

        
        // 1. AMBIL SEMUA DATA DARI FORM (TERMASUK VISI & MISI)
        $dataOrmawa = [
            'nama_ormawa' => $this->request->getPost('nama_ormawa'),
            'pembina'     => $this->request->getPost('pembina'),
            'visi'        => $this->request->getPost('visi'),        // ← PASTIKAN ADA
            'misi'        => $this->request->getPost('misi'),        // ← PASTIKAN ADA
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'instagram'   => $this->request->getPost('instagram'),
        ];

        // Hapus field yang kosong agar tidak menimpa dengan nilai kosong
        $dataOrmawa = array_filter($dataOrmawa, function($value) {
            return $value !== null && $value !== '';
        });

        
        // 2. UPLOAD LOGO
        $logo = $this->request->getFile('logo');
        if ($logo && $logo->isValid() && !$logo->hasMoved()) {
            $ormawaLama = $this->ormawaModel->find($id_ormawa);
            if (!empty($ormawaLama['logo']) && file_exists(FCPATH . 'uploads/logo/' . $ormawaLama['logo'])) {
                unlink(FCPATH . 'uploads/logo/' . $ormawaLama['logo']);
            }
            $newName = $logo->getRandomName();
            $logo->move(FCPATH . 'uploads/logo', $newName);
            $dataOrmawa['logo'] = $newName;
        }

        
        // 3. SIMPAN DATA ORMAWA (TERMASUK VISI & MISI)
        if (!empty($dataOrmawa)) {
            $this->ormawaModel->update($id_ormawa, $dataOrmawa);
        }

        
        // 4. UPDATE DATA USER
        $dataUser = [
            'email'   => $this->request->getPost('email'),
            'no_telp' => $this->request->getPost('no_telp'),
        ];
        $dataUser = array_filter($dataUser, function($value) {
            return $value !== null && $value !== '';
        });

        $foto = $this->request->getFile('foto');
        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if (!empty($user['foto']) && file_exists(FCPATH . 'uploads/profil/' . $user['foto'])) {
                unlink(FCPATH . 'uploads/profil/' . $user['foto']);
            }
            $newName = $foto->getRandomName();
            $foto->move(FCPATH . 'uploads/profil', $newName);
            $dataUser['foto'] = $newName;
            session()->set('foto', $newName);
        }

        if (!empty($dataUser)) {
            $this->userModel->update($id_user, $dataUser);
        }

        
        // 5. UPDATE SESSION
        session()->set('nama_ormawa', $this->request->getPost('nama_ormawa'));
        session()->set('email', $this->request->getPost('email'));

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}