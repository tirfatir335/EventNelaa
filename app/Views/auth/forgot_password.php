<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.forgot-wrap {
    min-height: calc(100vh - 200px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 24px;
    background:
        linear-gradient(135deg, rgba(255,122,0,.9) 0%, rgba(230,81,0,.85) 100%),
        url('<?= base_url('assets/images/bg-kampus.jpg') ?>') center/cover no-repeat;
    background-blend-mode: multiply;
}
.forgot-card {
    background: white;
    border-radius: 24px;
    padding: 44px 40px;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 30px 80px rgba(0,0,0,.2);
    text-align: center;
}
.forgot-icon {
    width: 80px; height: 80px;
    border-radius: 22px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    font-size: 36px;
    color: white;
    box-shadow: 0 15px 40px rgba(255,122,0,.35);
}
.forgot-card h1 {
    font-size: 24px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 10px;
    letter-spacing: -.6px;
}
.forgot-card p {
    font-size: 14.5px;
    color: #64748B;
    line-height: 1.6;
    margin: 0 0 28px;
}
.forgot-group { text-align: left; margin-bottom: 20px; }
.forgot-group label {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 8px;
}
.forgot-input-wrap { position: relative; }
.forgot-input-wrap i {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
}
.forgot-input-wrap input {
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
.forgot-input-wrap input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.forgot-btn {
    width: 100%;
    height: 52px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 800;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-family: inherit;
    box-shadow: 0 10px 25px rgba(255,122,0,.3);
    transition: .3s;
}
.forgot-btn:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(255,122,0,.4); }
.forgot-back {
    display: inline-flex; align-items: center; gap: 8px;
    margin-top: 22px;
    color: #64748B;
    font-size: 13.5px;
    font-weight: 700;
    text-decoration: none;
    transition: .2s;
}
.forgot-back:hover { color: #E65100; }

@media (max-width: 480px) {
    .forgot-card { padding: 32px 24px; }
}
</style>

<div class="forgot-wrap">
    <div class="forgot-card">

        <div class="forgot-icon">
            <i class="bi bi-key-fill"></i>
        </div>

        <h1>Lupa Password?</h1>
        <p>Masukkan email terdaftar, kami akan kirim link untuk reset password.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="reg-alert danger" style="border-radius:14px;padding:14px 18px;font-size:13.5px;
                        background:#FEE2E2;color:#B91C1C;border:1px solid #FECACA;
                        display:flex;align-items:flex-start;gap:10px;margin-bottom:20px;
                        text-align:left;font-weight:600;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:18px;flex-shrink:0;"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div style="border-radius:14px;padding:14px 18px;font-size:13.5px;
                        background:#DCFCE7;color:#15803D;border:1px solid #BBF7D0;
                        display:flex;align-items:flex-start;gap:10px;margin-bottom:20px;
                        text-align:left;font-weight:600;">
                <i class="bi bi-check-circle-fill" style="font-size:18px;flex-shrink:0;"></i>
                <span><?= session()->getFlashdata('success') ?></span>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/sendResetLink') ?>">
            <?= csrf_field() ?>

            <div class="forgot-group">
                <label>Email Terdaftar</label>
                <div class="forgot-input-wrap">
                    <i class="bi bi-envelope-fill"></i>
                    <input type="email" name="email" placeholder="nama@email.com" required>
                </div>
            </div>

            <button type="submit" class="forgot-btn">
                <i class="bi bi-send-fill"></i> Kirim Link Reset
            </button>
        </form>

        <a href="<?= site_url('login') ?>" class="forgot-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Login
        </a>

    </div>
</div>

<?= $this->endSection() ?>