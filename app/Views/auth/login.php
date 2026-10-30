<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.auth-page {
    min-height: calc(100vh - 200px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: white;
}
.auth-left {
    padding: 60px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: white;
}
.auth-form-wrap {
    max-width: 420px;
    width: 100%;
    margin: 0 auto;
}
.auth-logo {
    margin-bottom: 32px;
}
.auth-logo img { height: 50px; }
.auth-form-wrap h1 {
    font-size: 32px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 8px;
    letter-spacing: -1px;
}
.auth-form-wrap .subtitle {
    font-size: 15px;
    color: #64748B;
    margin: 0 0 32px;
    line-height: 1.6;
}

.auth-alert {
    border-radius: 14px;
    padding: 14px 18px;
    font-size: 13.5px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 20px;
    font-weight: 600;
}
.auth-alert.danger { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
.auth-alert.success { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
.auth-alert i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }

.auth-group { margin-bottom: 20px; }
.auth-group label {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 8px;
    letter-spacing: .2px;
}
.auth-input-wrap {
    position: relative;
}
.auth-input-wrap i.input-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
    transition: .25s;
    z-index: 1;
}
.auth-group input {
    width: 100%;
    height: 50px;
    padding: 0 18px 0 48px;
    border: 2px solid #F1F5F9;
    border-radius: 14px;
    font-size: 14.5px;
    font-family: inherit;
    outline: none;
    transition: .25s;
    background: #FAFBFC;
    color: #0F172A;
}
.auth-group input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.auth-input-wrap:focus-within i.input-icon { color: #FF7A00; }
.toggle-eye {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
    cursor: pointer;
    transition: .25s;
    z-index: 1;
}
.toggle-eye:hover { color: #FF7A00; }

.auth-forgot {
    text-align: right;
    margin: -8px 0 20px;
}
.auth-forgot a {
    color: #E65100;
    font-size: 13px;
    font-weight: 800;
    text-decoration: none;
}
.auth-forgot a:hover { text-decoration: underline; }

.auth-btn {
    width: 100%;
    height: 52px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    transition: .3s;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-family: inherit;
    box-shadow: 0 10px 25px rgba(255,122,0,.3);
    letter-spacing: .3px;
}
.auth-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(255,122,0,.4);
    color: white;
}

.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 26px 0;
    color: #94A3B8;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
}
.auth-divider::before,
.auth-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #F1F5F9;
}
.auth-cta {
    text-align: center;
    font-size: 14px;
    color: #64748B;
}
.auth-cta a {
    color: #E65100;
    font-weight: 800;
    text-decoration: none;
}
.auth-cta a:hover { text-decoration: underline; }

.auth-footer {
    text-align: center;
    margin-top: 32px;
    font-size: 12.5px;
    color: #94A3B8;
}

.auth-right {
    background:
        linear-gradient(135deg, rgba(255,122,0,.92) 0%, rgba(230,81,0,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
    color: white;
    padding: 60px 50px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    position: relative;
    overflow: hidden;
}
.auth-right::before {
    content: '';
    position: absolute;
    top: -30%; right: -20%;
    width: 500px; height: 500px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
}
.auth-right::after {
    content: '';
    position: absolute;
    bottom: -30%; left: -20%;
    width: 400px; height: 400px;
    background: rgba(255,255,255,.05);
    border-radius: 50%;
}
.auth-right-content {
    position: relative;
    z-index: 2;
    max-width: 420px;
}
.auth-right-icon {
    width: 100px;
    height: 100px;
    border-radius: 26px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 28px;
    font-size: 46px;
    border: 2px solid rgba(255,255,255,.25);
}
.auth-right h2 {
    font-size: 30px;
    font-weight: 900;
    margin: 0 0 16px;
    line-height: 1.3;
    letter-spacing: -.8px;
}
.auth-right p {
    font-size: 15.5px;
    opacity: .95;
    line-height: 1.7;
    margin: 0 0 32px;
}
.auth-features {
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.auth-feature {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    font-weight: 500;
}
.auth-feature i {
    width: 34px; height: 34px;
    border-radius: 10px;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

@media (max-width: 900px) {
    .auth-page { grid-template-columns: 1fr; }
    .auth-right { display: none; }
    .auth-left { padding: 40px 24px; }
    .auth-form-wrap h1 { font-size: 26px; }
}
</style>

<div class="auth-page">

    <div class="auth-left">
        <div class="auth-form-wrap">

            <div class="auth-logo">
                <img src="<?= base_url('assets/images/logo eventnela.png') ?>" alt="EventNela">
            </div>

            <h1>Selamat Datang!</h1>
            <p class="subtitle">Login untuk mengakses EventNela — pusat informasi UKM, Ormawa, event, dan recruitment Polinela.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="auth-alert danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="auth-alert success">
                    <i class="bi bi-check-circle-fill"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('login') ?>">
                <?= csrf_field() ?>

                <div class="auth-group">
                    <label>Username</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="username" placeholder="Masukkan username"
                               autocomplete="username" required>
                    </div>
                </div>

                <div class="auth-group">
                    <label>Password</label>
                    <div class="auth-input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="authPass" name="password" placeholder="Masukkan password"
                               autocomplete="current-password" required>
                        <i class="bi bi-eye-fill toggle-eye" id="togglePass" onclick="authTogglePass()"></i>
                    </div>
                </div>

                <div class="auth-forgot">
                    <a href="<?= site_url('auth/forgotPassword') ?>">Lupa Password?</a>
                </div>

                <button type="submit" class="auth-btn">
                    <i class="bi bi-box-arrow-in-right"></i> Login Sekarang
                </button>
            </form>

            <div class="auth-divider">atau</div>

            <div class="auth-cta">
                Belum punya akun?
                <a href="<?= site_url('register') ?>">Daftar di sini</a>
            </div>

            <div class="auth-footer">
                © <?= date('Y') ?> EventNela — Politeknik Negeri Lampung
            </div>

        </div>
    </div>

    <div class="auth-right">
        <div class="auth-right-content">
            <div class="auth-right-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h2>Pusat Informasi UKM & Ormawa</h2>
            <p>Temukan semua informasi kegiatan, program kerja, dan peluang bergabung dengan organisasi kemahasiswaan di Polinela.</p>

            <div class="auth-features">
                <div class="auth-feature">
                    <i class="bi bi-people-fill"></i>
                    <span>Jelajahi semua UKM & Ormawa kampus</span>
                </div>
                <div class="auth-feature">
                    <i class="bi bi-calendar-event-fill"></i>
                    <span>Ikuti event kegiatan terbaru</span>
                </div>
                <div class="auth-feature">
                    <i class="bi bi-megaphone-fill"></i>
                    <span>Daftar open recruitment online</span>
                </div>
                <div class="auth-feature">
                    <i class="bi bi-robot"></i>
                    <span>Tanya EventNela AI kapan saja</span>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function authTogglePass() {
    const input = document.getElementById('authPass');
    const icon = document.getElementById('togglePass');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye-fill');
        icon.classList.add('bi-eye-slash-fill');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash-fill');
        icon.classList.add('bi-eye-fill');
    }
}
</script>
<?= $this->endSection() ?>