<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.reg-page {
    min-height: calc(100vh - 200px);
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: white;
}
.reg-left {
    padding: 60px 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
.reg-form-wrap {
    max-width: 420px;
    width: 100%;
    margin: 0 auto;
}
.reg-logo { margin-bottom: 28px; }
.reg-logo img { height: 50px; }
.reg-form-wrap h1 {
    font-size: 30px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 8px;
    letter-spacing: -1px;
}
.reg-form-wrap .subtitle {
    font-size: 14.5px;
    color: #64748B;
    margin: 0 0 30px;
    line-height: 1.6;
}

.reg-alert {
    border-radius: 14px;
    padding: 14px 18px;
    font-size: 13.5px;
    display: flex; align-items: flex-start; gap: 10px;
    margin-bottom: 20px;
    font-weight: 600;
}
.reg-alert.danger { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
.reg-alert i { font-size: 18px; flex-shrink: 0; margin-top: 1px; }

.reg-group { margin-bottom: 18px; }
.reg-group label {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 8px;
}
.reg-input-wrap { position: relative; }
.reg-input-wrap i.input-icon {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
    transition: .25s;
    z-index: 1;
}
.reg-group input {
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
.reg-group input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.reg-input-wrap:focus-within i.input-icon { color: #FF7A00; }
.toggle-eye {
    position: absolute;
    right: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
    cursor: pointer;
    transition: .25s;
    z-index: 1;
}
.toggle-eye:hover { color: #FF7A00; }
.pass-hint {
    font-size: 11.5px;
    color: #94A3B8;
    margin-top: 6px;
    display: flex; align-items: center; gap: 4px;
}

.reg-btn {
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
    margin-top: 8px;
}
.reg-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 35px rgba(255,122,0,.4);
    color: white;
}

.reg-cta {
    text-align: center;
    font-size: 14px;
    color: #64748B;
    margin-top: 22px;
}
.reg-cta a {
    color: #E65100;
    font-weight: 800;
    text-decoration: none;
}
.reg-cta a:hover { text-decoration: underline; }

.reg-footer {
    text-align: center;
    margin-top: 26px;
    font-size: 12.5px;
    color: #94A3B8;
}

.reg-right {
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
.reg-right::before {
    content: '';
    position: absolute;
    top: -30%; right: -20%;
    width: 500px; height: 500px;
    background: rgba(255,255,255,.08);
    border-radius: 50%;
}
.reg-right-content {
    position: relative; z-index: 2;
    max-width: 420px;
}
.reg-right-icon {
    width: 100px; height: 100px;
    border-radius: 26px;
    background: rgba(255,255,255,.15);
    backdrop-filter: blur(10px);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 28px;
    font-size: 46px;
    border: 2px solid rgba(255,255,255,.25);
}
.reg-right h2 {
    font-size: 30px;
    font-weight: 900;
    margin: 0 0 16px;
    line-height: 1.3;
    letter-spacing: -.8px;
}
.reg-right p {
    font-size: 15.5px;
    opacity: .95;
    line-height: 1.7;
    margin: 0 0 32px;
}
.reg-benefits {
    text-align: left;
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.reg-benefit {
    display: flex; align-items: center; gap: 12px;
    font-size: 14px;
}
.reg-benefit i {
    width: 34px; height: 34px;
    border-radius: 10px;
    background: rgba(255,255,255,.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}

@media (max-width: 900px) {
    .reg-page { grid-template-columns: 1fr; }
    .reg-right { display: none; }
    .reg-left { padding: 40px 24px; }
    .reg-form-wrap h1 { font-size: 24px; }
}
</style>

<div class="reg-page">

    <div class="reg-left">
        <div class="reg-form-wrap">

            <div class="reg-logo">
                <img src="<?= base_url('assets/images/logo eventnela.png') ?>" alt="EventNela">
            </div>

            <h1>Buat Akun Baru ✨</h1>
            <p class="subtitle">Daftar gratis dan mulai jelajahi UKM, Ormawa, event, dan peluang recruitment di Polinela.</p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="reg-alert danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <form method="post" action="<?= site_url('auth/doRegister') ?>">
                <?= csrf_field() ?>

                <div class="reg-group">
                    <label>Username</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-person-fill input-icon"></i>
                        <input type="text" name="username" placeholder="Pilih username unik"
                               autocomplete="username" required>
                    </div>
                </div>

                <div class="reg-group">
                    <label>Email</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-envelope-fill input-icon"></i>
                        <input type="email" name="email" placeholder="contoh@email.com"
                               autocomplete="email" required>
                    </div>
                </div>

                <div class="reg-group">
                    <label>Password</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="regPass" name="password" placeholder="Minimal 6 karakter"
                               minlength="6" autocomplete="new-password" required>
                        <i class="bi bi-eye-fill toggle-eye" id="regEye1" onclick="regToggle('regPass','regEye1')"></i>
                    </div>
                    <div class="pass-hint"><i class="bi bi-info-circle"></i> Minimal 6 karakter</div>
                </div>

                <div class="reg-group">
                    <label>Konfirmasi Password</label>
                    <div class="reg-input-wrap">
                        <i class="bi bi-lock-fill input-icon"></i>
                        <input type="password" id="regConfirm" name="confirm_password" placeholder="Ulangi password"
                               minlength="6" autocomplete="new-password" required>
                        <i class="bi bi-eye-fill toggle-eye" id="regEye2" onclick="regToggle('regConfirm','regEye2')"></i>
                    </div>
                </div>

                <button type="submit" class="reg-btn">
                    <i class="bi bi-person-plus-fill"></i> Daftar Sekarang
                </button>
            </form>

            <div class="reg-cta">
                Sudah punya akun?
                <a href="<?= site_url('login') ?>">Login di sini</a>
            </div>

            <div class="reg-footer">
                © <?= date('Y') ?> EventNela — Politeknik Negeri Lampung
            </div>

        </div>
    </div>

    <div class="reg-right">
        <div class="reg-right-content">
            <div class="reg-right-icon">
                <i class="bi bi-person-plus-fill"></i>
            </div>
            <h2>Gabung Komunitas Kampus!</h2>
            <p>Dengan akun EventNela, kamu bisa mengakses semua fitur untuk mengeksplorasi UKM dan kegiatan kampus.</p>

            <div class="reg-benefits">
                <div class="reg-benefit">
                    <i class="bi bi-star-fill"></i>
                    <span>Beri ulasan & rating event</span>
                </div>
                <div class="reg-benefit">
                    <i class="bi bi-send-fill"></i>
                    <span>Daftar open recruitment online</span>
                </div>
                <div class="reg-benefit">
                    <i class="bi bi-clock-history"></i>
                    <span>Pantau status pendaftaranmu</span>
                </div>
                <div class="reg-benefit">
                    <i class="bi bi-robot"></i>
                    <span>Akses AI Assistant 24/7</span>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function regToggle(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
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