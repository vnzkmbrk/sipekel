<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — <?= htmlspecialchars($profil->nama_aplikasi ?? 'Sistem Kelulusan') ?></title>
<link rel="icon" type="image/png" href="<?= base_url('uploads/pbr.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{min-height:100vh;font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#0f172a 0%,#1a56db 50%,#0f172a 100%);display:flex;align-items:flex-start;justify-content:center;padding:24px 16px;position:relative;overflow-y:auto}
body::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.03'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")}
.particles{position:absolute;inset:0;overflow:hidden;pointer-events:none}
.particle{position:absolute;border-radius:50%;background:rgba(255,255,255,.06);animation:float linear infinite}
@keyframes float{0%{transform:translateY(100vh) rotate(0deg);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-100px) rotate(720deg);opacity:0}}
.login-wrap{width:100%;max-width:420px;position:relative;z-index:10}
.school-badge{text-align:center;margin-bottom:24px}
.school-icon{width:88px;height:88px;background:rgba(255,255,255,.12);backdrop-filter:blur(12px);border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:32px;margin:0 auto 12px;border:1px solid rgba(255,255,255,.2);color:#fff}
.school-name{font-size:16px;font-weight:700;color:#fff;font-family:'Poppins',sans-serif}
.school-sub{font-size:12px;color:rgba(255,255,255,.55);margin-top:2px}
.login-card{background:rgba(255,255,255,.95);backdrop-filter:blur(20px);border-radius:20px;padding:36px 32px;box-shadow:0 20px 60px rgba(0,0,0,.3),0 0 0 1px rgba(255,255,255,.2)}
.login-title{font-size:22px;font-weight:800;color:#0f172a;margin-bottom:4px;text-align: center;font-family:'Poppins',sans-serif}
.login-sub{font-size:13px;text-align: center;color:#64748b;margin-bottom:28px}
.alert{padding:12px 14px;border-radius:10px;font-size:13px;margin-bottom:18px;display:flex;align-items:center;gap:10px}
.alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#7f1d1d}
.alert-success{background:#f0fdf4;border:1px solid #86efac;color:#14532d}
.form-group{margin-bottom:16px}
label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
.input-wrap{position:relative}
.input-wrap i.icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:15px}
.input-wrap input{width:100%;padding:11px 14px 11px 40px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;color:#0f172a;background:#fff;outline:none;transition:all .2s}
.input-wrap input:focus{border-color:#1a56db;box-shadow:0 0 0 3px rgba(26,86,219,.12)}
.toggle-pass{position:absolute;right:13px;top:50%;transform:translateY(-50%);background:none;border:none;color:#9ca3af;cursor:pointer;font-size:14px;padding:2px}
.btn-login{width:100%;padding:13px;background:#1a56db;color:#fff;border:none;border-radius:10px;font-size:15px;font-weight:700;cursor:pointer;font-family:'Poppins', inherit;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:20px}
.btn-login:hover{background:#1340a8;transform:translateY(-1px);box-shadow:0 8px 24px rgba(26,86,219,.4)}
.login-footer{text-align:center;margin-top:20px;font-size:12px;color:#94a3b8}
.back-link{display:inline-flex;align-items:center;gap:6px;margin-top:16px;font-size:13px;color:rgba(255,255,255,.7);text-decoration:none;transition:color .2s}
.back-link:hover{color:#fff}
@media(max-width:480px){.login-card{padding:24px 20px}}
</style>
</head>
<body>
<div class="particles" id="particles"></div>
<div class="login-wrap">
  <div class="school-badge">
    <div class="school-icon">
      <img src="<?= base_url('uploads/pbr.png') ?>" alt="Logo" style="width:65px;height:65px;object-fit:contain">
    </div>
    <div class="school-sub">SIPEKEL</div>
    <div class="school-sub">Sistem Pengumuman Kelulusan</div>
    <div class="school-name"><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></div>
  </div>

  <div class="login-card">
    <div class="login-title">Masuk Akun Panel</div>
    <div class="login-sub">Masukkan kredensial untuk melanjutkan</div>

    <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><i class="fas fa-check-circle"></i><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <form action="<?= site_url('proses_login') ?>" method="POST">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
      <div class="form-group">
        <label>Username <span style="color:#ef4444">*</span></label>
        <div class="input-wrap">
          <i class="fas fa-user icon"></i>
          <input type="text" name="username" placeholder="Masukkan Username" autocomplete="username" required>
        </div>
      </div>
      <div class="form-group">
        <label>Password <span style="color:#ef4444">*</span></label>
        <div class="input-wrap">
          <i class="fas fa-lock icon"></i>
          <input type="password" name="password" id="password" placeholder="Masukkan Password" autocomplete="current-password" required>
          <button type="button" class="toggle-pass" onclick="togglePass('password')"><i class="fas fa-eye"></i></button>
        </div>
      </div>
      <div class="form-group">
        <label>Verifikasi <span style="color:#ef4444">*</span></label>
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px">
          <div style="background:#f1f5f9;border:1.5px solid #e5e7eb;border-radius:10px;padding:10px 16px;font-size:16px;font-weight:700;color:#0f172a;letter-spacing:2px;user-select:none;min-width:120px;text-align:center">
            <?php
              $a = rand(1, 9);
              $b = rand(1, 9);
              $this->session->set_userdata('captcha_answer', $a + $b);
              echo $a . ' + ' . $b . ' = ?';
            ?>
          </div>
          <div class="input-wrap" style="flex:1">
            <i class="fas fa-calculator icon"></i>
            <input type="number" name="captcha" placeholder="Jawaban" required autocomplete="off" min="0">
          </div>
        </div>
      </div>
      <button type="submit" class="btn-login"><i class="fas fa-sign-in-alt"></i> Masuk Sistem</button>
    </form>
  </div>

  <div style="text-align:center;margin-top:16px">
    <a href="<?= site_url('/') ?>" class="back-link"><i class="fas fa-arrow-left"></i> Kembali ke Halaman Siswa</a>
  </div>
  <div style="text-align:center;margin-top:12px;font-size:12px;color:#fff;">
    Developed by <strong style="color:#fff;">Ivan Zaka Mubarok</strong> &nbsp;·&nbsp; Version 1.0.0
  </div>
</div>

<script>
// Generate particles
const container = document.getElementById('particles');
for (let i = 0; i < 15; i++) {
  const p = document.createElement('div');
  p.className = 'particle';
  const size = Math.random() * 30 + 10;
  p.style.cssText = `width:${size}px;height:${size}px;left:${Math.random()*100}%;animation-duration:${Math.random()*15+10}s;animation-delay:${Math.random()*10}s`;
  container.appendChild(p);
}
function togglePass(id) {
  const el = document.getElementById(id);
  const icon = event.currentTarget.querySelector('i');
  if (el.type === 'password') { el.type = 'text'; icon.className = 'fas fa-eye-slash'; }
  else { el.type = 'password'; icon.className = 'fas fa-eye'; }
}
</script>
</body>
</html>