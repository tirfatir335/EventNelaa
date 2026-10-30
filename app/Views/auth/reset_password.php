<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.reset-wrap {
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
.reset-card {
    background: white;
    border-radius: 24px;
    padding: 44px 40px;
    max-width: 420px;
    width: 100%;
    box-shadow: 0 30px 80px rgba(0,0,0,.2);
    text-align: center;
}
.reset-icon {
    width: 80px; height: 80px;
    border-radius: 22px;
    background: linear-gradient(135deg, #FF7A00, #E65100);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    font-size: 36px; color: white;
    box-shadow: 0 15px 40px rgba(255,122,0,.35);
}
.reset-card h1 {
    font-size: 24px;
    font-weight: 900;
    color: #0F172A;
    margin: 0 0 10px;
    letter-spacing: -.6px;
}
.reset-card p {
    font-size: 14.5px;
    color: #64748B;
    line-height: 1.6;
    margin: 0 0 28px;
}
.reset-group { text-align: left; margin-bottom: 20px; }
.reset-group label {
    display: block;
    font-size: 13px;
    font-weight: 800;
    color: #0F172A;
    margin-bottom: 8px;
}
.reset-input-wrap { position: relative; }
.reset-input-wrap i.icon-left {
    position: absolute;
    left: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
}
.reset-input-wrap input {
    width: 100%;
    height: 50px;
    padding: 0 50px 0 48px;
    border: 2px solid #F1F5F9;
    border-radius: 14px;
    font-size: 14.5px;
    font-family: inherit;
    outline: none;
    transition: .25s;
    background: #FAFBFC;
    color: #0F172A;
}
.reset-input-wrap input:focus {
    border-color: #FF7A00;
    background: white;
    box-shadow: 0 0 0 4px rgba(255,122,0,.1);
}
.reset-input-wrap .toggle-eye {
    position: absolute;
    right: 18px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8;
    font-size: 17px;
    cursor: pointer;
    transition: .2s;
}
.reset-input-wrap .toggle-eye:hover { color: #FF7A00; }

.reset-btn {
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
    margin-top: 8px;
}
.reset-btn:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(255,122,0,.4); }

.reset-footer {
    text-align: center;
    margin-top: 22px;
    font-size: 12.5px;
    color: #94A3B8;
}

@media (max-width: 480px) {
    .reset-card { padding: 32px 24px; }
}
</style>

<div class="reset-wrap">
    <div class="reset-card">

        <div class="reset-icon">
            <i class="bi bi-shield-lock-fill"></i>
        </div>

        <h1>Reset Password</h1>
        <p>Masukkan password baru untuk akunmu.</p>

        <?php if (session()->getFlashdata('error')): ?>
            <div style="border-radius:14px;padding:14px 18px;font-size:13.5px;
                        background:#FEE2E2;color:#B91C1C;border:1px solid #FECACA;
                        display:flex;align-items:flex-start;gap:10px;margin-bottom:20px;
                        text-align:left;font-weight:600;">
                <i class="bi bi-exclamation-triangle-fill" style="font-size:18px;flex-shrink:0;"></i>
                <span><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= site_url('auth/updatePassword') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="token" value="<?= esc($token) ?>">

            <div class="reset-group">
                <label>Password Baru</label>
                <div class="reset-input-wrap">
                    <i class="bi bi-lock-fill icon-left"></i>
                    <input type="password" id="newPass" name="password" placeholder="Minimal 6 karakter"
                           minlength="6" required>
                    <i class="bi bi-eye-fill toggle-eye" id="eyeNew" onclick="resetToggle('newPass','eyeNew')"></i>
                </div>
            </div>

            <button type="submit" class="reset-btn">
                <i class="bi bi-check-circle-fill"></i> Reset Password
            </button>
        </form>

        <div class="reset-footer">
            © <?= date('Y') ?> EventNela — Politeknik Negeri Lampung
        </div>

    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function resetToggle(fieldId, iconId) {
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