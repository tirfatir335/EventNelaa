<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PendaftarModel;
use CodeIgniter\Email\Email;

class Auth extends BaseController
{
    // ================= HALAMAN LOGIN =================
    public function index()
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role');

            if ($role === 'mahasiswa') {
                return redirect()->to('mahasiswa/dashboard');
            } elseif (in_array($role, ['super_admin', 'admin'])) {
                return redirect()->to('admin/dashboard');
            } elseif ($role === 'organisasi') {
                return redirect()->to('ormawa/dashboard');
            } elseif ($role === 'staf_ormawa') {
                return redirect()->to(get_first_module_url());
            } elseif ($role === 'validator') {
                return redirect()->to('validator/dashboard');
            } elseif ($role === 'pembina') {
                return redirect()->to('pembina/dashboard');
            }
        }

        $redirect = $this->request->getGet('redirect');

        if ($redirect) {
            session()->set('intended_url', $redirect);
        } else {
            $referer = $this->request->getServer('HTTP_REFERER');

            //  Jangan simpan referer dari halaman auth (login, register, dll)
            if ($referer
                && strpos($referer, 'login') === false
                && strpos($referer, 'register') === false
                && strpos($referer, 'resetPassword') === false
                && strpos($referer, 'forgotPassword') === false
                && strpos($referer, '/auth') === false
                && rtrim($referer, '/') !== rtrim(base_url(), '/')
            ) {
                session()->set('intended_url', $referer);
            } else {
                session()->remove('intended_url');
            }
        }

        return view('auth/login');
    }

    // ================= PROSES LOGIN =================
    public function login()
    {
        $session   = session();
        $userModel = new UserModel();

        $username      = $this->request->getPost('username');
        $inputPassword = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan!');
        }

        $dbPassword  = $user['password'];
        $md5Password = md5($inputPassword);

        if ($dbPassword !== $md5Password && !password_verify($inputPassword, $dbPassword)) {
            return redirect()->back()->with('error', 'Password salah!');
        }

        $session->set([
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'role'      => $user['role'],
            'id_ormawa' => $user['id_ormawa'],
            'id_dosen'  => $user['id_dosen'] ?? null,
            'foto'      => $user['foto'] ?: 'default.png',
            'logged_in' => true,
        ]);

        $intended = session()->get('intended_url');
        $role     = $user['role'];

        // Hapus intended_url kalau BUKAN mahasiswa
        if ($role !== 'mahasiswa' && $intended) {
            session()->remove('intended_url');
            $intended = null;
        }

        // Hapus intended_url kalau mengarah ke halaman internal
        if ($intended && (
            strpos($intended, '/admin/') !== false ||
            strpos($intended, '/ormawa/') !== false ||
            strpos($intended, '/validator/') !== false ||
            strpos($intended, '/pembina/') !== false
        )) {
            session()->remove('intended_url');
            $intended = null;
        }

        // =====================================================
        // REDIRECT BERDASARKAN ROLE
        // =====================================================
        if ($role === 'super_admin') {
            return redirect()->to('admin/dashboard');
        } elseif ($role === 'admin') {
            return redirect()->to('admin/dashboard');
        } elseif ($role === 'organisasi') {
            return redirect()->to('ormawa/dashboard');
        } elseif ($role === 'staf_ormawa') {
            $firstUrl = get_first_module_url();
            return redirect()->to($firstUrl);
        } elseif ($role === 'validator') {
            return redirect()->to('validator/dashboard');
        } elseif ($role === 'pembina') {
            return redirect()->to('pembina/dashboard');
        } elseif ($role === 'mahasiswa') {

            //  Daftar halaman umum — JANGAN redirect ke sini setelah login
            //    (biar langsung ke dashboard mahasiswa)
            $halamanUmum = [
                '/recruitment/riwayat',
                '/recruitment',
                '/mahasiswa/dashboard',
                '/event',
                '/ukm',
                '/berita',
                '/panduan',
                '/tentang',
            ];

            $isHomepage = $intended && rtrim($intended, '/') === rtrim(base_url(), '/');
            $isHalamanUmum = false;

            if ($intended) {
                foreach ($halamanUmum as $path) {
                    if (strpos($intended, $path) !== false) {
                        $isHalamanUmum = true;
                        break;
                    }
                }
            }

            // Kalau intended_url spesifik (misal detail_event), redirect ke situ
            if ($intended
                && !$isHomepage
                && !$isHalamanUmum
            ) {
                session()->remove('intended_url');
                return redirect()->to($intended);
            }

            // Kalau bukan, langsung ke dashboard mahasiswa
            session()->remove('intended_url');
            return redirect()->to('mahasiswa/dashboard');
        }

        return redirect()->to('/');
    }

    // ================= LOGOUT =================
    public function logout()
    {
        session()->remove('intended_url');
        session()->destroy();
        return redirect()->to('login');
    }

    // ================= HALAMAN REGISTER =================
    public function register()
    {
        $redirect = $this->request->getGet('redirect');
        if ($redirect) {
            session()->set('intended_url', $redirect);
        }

        return view('auth/register');
    }

    // ================= PROSES REGISTER =================
    public function doRegister()
    {
        $userModel = new UserModel();

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');

        if ($password !== $confirm) {
            return redirect()->back()->withInput()->with('error', 'Password dan konfirmasi tidak sama.');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->withInput()->with('error', 'Password minimal 6 karakter.');
        }

        if ($userModel->where('username', $username)->first()) {
            return redirect()->back()->withInput()->with('error', 'Username sudah terdaftar.');
        }

        if ($userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        $userModel->insert([
            'username'   => $username,
            'email'      => $email,
            'password'   => password_hash($password, PASSWORD_DEFAULT),
            'role'       => 'mahasiswa',
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // ================= LUPA PASSWORD =================
    public function forgotPassword()
    {
        return view('auth/forgot_password');
    }

    // ================= KIRIM LINK RESET =================
    public function sendResetLink()
    {
        $email     = $this->request->getPost('email');
        $userModel = new UserModel();

        $user = $userModel->where('email', $email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Email tidak ditemukan!');
        }

        $token = bin2hex(random_bytes(50));
        log_message('debug', 'Generated reset token: ' . $token);

        try {
            $updated = $userModel->update($user['id'], ['reset_token' => $token]);

            if (!$updated) {
                return redirect()->back()->with('error', 'Gagal memperbarui token reset password!');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error updating reset token: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui token reset password!');
        }

        $terkirim = $this->sendResetEmail($email, $token);

        if ($terkirim) {
            return redirect()->back()->with('success', 'Link reset password telah dikirim ke email Anda.');
        } else {
            return redirect()->back()->with('error', 'Gagal mengirim email. Cek konfigurasi SMTP atau coba lagi nanti.');
        }
    }

    // ================= KIRIM EMAIL RESET =================
    private function sendResetEmail($email, $token)
    {
        $emailService = \Config\Services::email();

        $resetLink = base_url('auth/resetPassword/' . $token);

        $emailService->setTo($email);
        $emailService->setSubject('Reset Password - EventNela');

        $message = '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;">
                <div style="text-align: center; padding: 20px 0; border-bottom: 3px solid #ff7a00;">
                    <h1 style="color: #ff7a00; margin: 0;">EventNela</h1>
                    <p style="color: #888; font-size: 13px; margin: 5px 0 0;">Politeknik Negeri Lampung</p>
                </div>

                <div style="padding: 30px 20px;">
                    <h2 style="color: #1a1a2e; margin-top: 0;">Reset Password</h2>
                    <p style="color: #555; line-height: 1.7;">
                        Halo! Kami menerima permintaan untuk reset password akun EventNela kamu.
                        Klik tombol di bawah ini untuk membuat password baru.
                    </p>

                    <div style="text-align: center; margin: 30px 0;">
                        <a href="' . $resetLink . '"
                           style="display: inline-block; background: linear-gradient(135deg, #ff7a00, #e65100);
                                  color: white; padding: 14px 32px; border-radius: 25px;
                                  text-decoration: none; font-weight: bold; font-size: 15px;">
                            Reset Password Sekarang
                        </a>
                    </div>

                    <p style="color: #888; font-size: 13px; line-height: 1.6;">
                        Kalau tombol di atas tidak bisa diklik, copy link berikut ke browser:<br>
                        <a href="' . $resetLink . '" style="color: #ff7a00; word-break: break-all;">' . $resetLink . '</a>
                    </p>

                    <p style="color: #888; font-size: 13px;">
                        Kalau kamu tidak meminta reset password, abaikan email ini. Password kamu tidak akan berubah.
                    </p>
                </div>

                <div style="text-align: center; padding: 20px; background: #fafbfc; color: #999; font-size: 12px;">
                    © ' . date('Y') . ' EventNela — Politeknik Negeri Lampung
                </div>
            </div>
        ';

        $emailService->setMessage($message);

        if (!$emailService->send()) {
            log_message('error', 'Gagal kirim email reset: ' . $emailService->printDebugger(['headers']));
            return false;
        }

        return true;
    }

    // ================= HALAMAN RESET PASSWORD =================
    public function resetPassword($token)
    {
        $userModel = new UserModel();
        $user      = $userModel->where('reset_token', $token)->first();

        if (!$user) {
            log_message('error', 'Invalid token: ' . $token);
            return redirect()->to('login')->with('error', 'Token tidak valid!');
        }

        return view('auth/reset_password', ['token' => $token]);
    }

    // ================= UPDATE PASSWORD BARU =================
    public function updatePassword()
    {
        $token     = $this->request->getPost('token');
        $password  = $this->request->getPost('password');
        $userModel = new UserModel();

        $user = $userModel->where('reset_token', $token)->first();

        if (!$user) {
            return redirect()->to('login')->with('error', 'Token tidak valid!');
        }

        if (strlen($password) < 6) {
            return redirect()->back()->with('error', 'Password minimal 6 karakter.');
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $userModel->update($user['id'], [
            'password'    => $hashedPassword,
            'reset_token' => null,
        ]);

        // Bersihkan semua session biar login fresh
        session()->remove('intended_url');
        session()->remove('logged_in');
        session()->remove('user_id');
        session()->remove('username');
        session()->remove('role');
        session()->remove('id_ormawa');
        session()->remove('id_dosen');
        session()->remove('foto');

        return redirect()->to('login')->with('success', 'Password berhasil diubah. Silakan login dengan password baru.');
    }
}