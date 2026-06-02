<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 Not Found — SMK Panca Bhakti Rakit</title>
<link rel="icon" type="image/png" href="https://spk.smkpabhara.sch.id/uploads/pbr.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg:         #0f172a;
    --surface:    rgba(255,255,255,.07);
    --border:     rgba(255,255,255,.1);
    --border-md:  rgba(255,255,255,.18);
    --text:       #f1f5f9;
    --muted:      #94a3b8;
    --hint:       #64748b;
    --accent:     #3b82f6;
    --accent-light: #60a5fa;
    --blue:       #3b82f6;
    --blue-bg:    rgba(59,130,246,.15);
    --blue-bdr:   rgba(59,130,246,.3);
    --warn:       #f59e0b;
    --warn-bg:    rgba(245,158,11,.15);
    --warn-bdr:   rgba(245,158,11,.3);
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
    color: var(--text);
    font-size: 14px;
    line-height: 1.6;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    overflow-x: hidden;
  }

  /* NAVBAR */
  .navbar {
    width: 100%; padding: 0 32px; height: 64px;
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(15,23,42,.9);
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
  }
  .nav-brand { display: flex; align-items: center; gap: 12px; }
  .nav-logo-wrap {
    width: 38px; height: 38px; border-radius: 10px;
    overflow: hidden; flex-shrink: 0;
    border: 1px solid var(--border-md);
    background: #fff;
    display: flex; align-items: center; justify-content: center;
  }
  .nav-logo-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 3px; }
  .nav-school { font-size: 13.5px; font-weight: 700; color: var(--text); line-height: 1.2; }
  .nav-year   { font-size: 11px; color: var(--muted); }

  .badge-err {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600;
    background: var(--blue-bg); color: var(--blue);
    border: 1px solid var(--blue-bdr);
  }
  .badge-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: currentColor;
    animation: pdot 2s infinite;
  }
  @keyframes pdot {
    0%,100%{ opacity:1; transform:scale(1) }
    50%{ opacity:.5; transform:scale(.8) }
  }

  /* PAGE */
  .page {
    flex: 1;
    display: flex; align-items: center; justify-content: center;
    padding: 60px 24px 80px;
    position: relative; overflow: hidden;
  }
  .page::before {
    content: ''; position: absolute; inset: 0;
    background: radial-gradient(ellipse 700px 400px at 50% 40%, rgba(59,130,246,.05) 0%, transparent 70%);
    pointer-events: none;
  }

  /* GLASS CARD */
  .glass-card {
    background: rgba(30,41,59,.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: 20px;
    border: 1px solid var(--border);
    overflow: hidden;
    width: 100%; max-width: 460px;
    position: relative; z-index: 1;
    animation: fadeUp .5s ease both;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  .card-head {
    padding: 30px 28px 24px;
    border-bottom: 1px solid var(--border);
    text-align: center;
  }
  .err-icon {
    width: 64px; height: 64px; border-radius: 50%;
    background: var(--blue-bg); border: 1px solid var(--blue-bdr);
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 18px;
  }
  .err-code {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 4px 14px; border-radius: 20px;
    font-size: 11px; font-weight: 700; letter-spacing: .8px;
    background: var(--blue-bg); color: var(--blue);
    border: 1px solid var(--blue-bdr);
    margin-bottom: 14px;
  }
  .card-head h1 {
    font-size: 26px; font-weight: 800; color: var(--text);
    letter-spacing: -.03em; margin-bottom: 8px;
  }
  .card-head p {
    font-size: 13px; color: var(--muted);
    line-height: 1.8; max-width: 320px; margin: 0 auto;
  }

  .card-body { padding: 24px 28px; }

  .info-row {
    display: flex; align-items: center; gap: 10px;
    padding: 14px 16px; border-radius: 12px;
    background: var(--warn-bg); border: 1px solid var(--warn-bdr);
    font-size: 12.5px; color: rgba(253,230,138,.9);
    line-height: 1.8; margin-bottom: 20px;
    word-break: break-word; text-align: center;
    flex-direction: column;
  }
  .info-row svg { flex-shrink: 0; }

  .divider { height: 1px; background: var(--border); margin: 20px 0; }

  .btn-group { display: flex; gap: 10px; }

  .btn-primary {
    flex: 1; padding: 13px; border: none;
    border-radius: 8px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff; font-family: 'Poppins', sans-serif;
    font-size: 13.5px; font-weight: 700; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: all .2s; text-decoration: none;
    box-shadow: 0 4px 16px rgba(59,130,246,.3);
  }
  .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(59,130,246,.45); }

  .btn-ghost {
    flex: 1; padding: 13px; border-radius: 8px;
    background: var(--surface); border: 1px solid var(--border-md);
    color: var(--text); font-family: 'Poppins', sans-serif;
    font-size: 13.5px; font-weight: 600; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    transition: all .2s; text-decoration: none;
  }
  .btn-ghost:hover { background: var(--border-md); border-color: var(--accent); color: var(--accent-light); }

  .privacy-note {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    font-size: 11.5px; color: var(--hint);
    line-height: 1.7; margin-top: 16px;
    text-align: center;
  }
  .privacy-note svg { flex-shrink: 0; opacity: .4; }

  /* FOOTER */
  footer {
    background: rgba(15,23,42,.95);
    border-top: 1px solid var(--border);
    text-align: center; padding: 24px;
    font-size: 12px; color: var(--hint); line-height: 2;
    flex-shrink: 0;
  }
  footer strong { font-weight: 700; color: var(--muted); }

  @media (max-width: 600px) {
    .navbar { padding: 0 16px; }
    .badge-err span:last-child { display: none; }
    .page { padding: 40px 16px 60px; }
    .card-head { padding: 24px 20px 20px; }
    .card-body { padding: 20px; }
    .btn-group { flex-direction: column; }
    footer { font-size: 11px; padding: 20px 16px; }
  }
</style>
</head>
<body>

<nav class="navbar">
  <div class="nav-brand">
    <div class="nav-logo-wrap">
      <img src="https://spk.smkpabhara.sch.id/uploads/pbr.png" alt="Logo Sekolah">
    </div>
    <div>
      <div class="nav-school" id="nama-sekolah">SMK Panca Bhakti Rakit</div>
      <div class="nav-year" id="nama-tahun">Pengumuman Kelulusan</div>
    </div>
  </div>
  <div class="badge-err">
    <span class="badge-dot"></span>
    <span>Halaman Tidak Ditemukan</span>
  </div>
</nav>

<div class="page">
  <div class="glass-card">
    <div class="card-head">
      <div class="err-icon">
        <svg width="28" height="28" fill="none" stroke="#3b82f6" stroke-width="1.8" viewBox="0 0 24 24">
          <circle cx="11" cy="11" r="8"/>
          <line x1="21" y1="21" x2="16.65" y2="16.65"/>
          <line x1="11" y1="8" x2="11" y2="14"/>
          <line x1="8" y1="11" x2="14" y2="11"/>
        </svg>
      </div>
      <div class="err-code">
        <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <line x1="12" y1="8" x2="12" y2="12"/>
          <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        404 NOT FOUND
      </div>
      <h1>Halaman Tidak Ditemukan</h1>
      <p>Halaman yang kamu cari tidak ada, sudah dipindahkan, atau URL yang kamu masukkan tidak valid.</p>
    </div>
    <div class="card-body">
      <div class="info-row">
        <svg width="14" height="14" fill="none" stroke="#f59e0b" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0">
          <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
          <line x1="12" y1="9" x2="12" y2="13"/>
          <line x1="12" y1="17" x2="12.01" y2="17"/>
        </svg>
        <span>Periksa kembali URL yang kamu masukkan atau kembali ke halaman utama untuk melanjutkan.</span>
      </div>

      <div class="btn-group">
        <a href="/" class="btn-ghost">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
            <polyline points="9 22 9 12 15 12 15 22"/>
          </svg>
          Beranda
        </a>
        <a href="javascript:history.back()" class="btn-primary">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <polyline points="15 18 9 12 15 6"/>
          </svg>
          Kembali
        </a>
      </div>

      <div class="divider"></div>

      <div class="privacy-note">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        Portal ini hanya dapat diakses oleh pengguna yang memiliki izin. Data yang tersimpan di sistem dilindungi dan tidak dapat diakses secara umum.
      </div>
    </div>
  </div>
</div>

<footer>
  <strong id="footer-sekolah">SMK Panca Bhakti Rakit</strong><br>
  <span id="footer-alamat">Rakit, Banjarnegara, Jawa Tengah</span><br>
  &copy; <span id="footer-tahun"></span> <span id="footer-app">Sistem Pengumuman Kelulusan</span>. Hak cipta dilindungi.<br>
  <span style="font-size:11px;color:#64748b">Developed by <strong style="color:#94a3b8">Ivan Zaka Mubarok</strong> &nbsp;·&nbsp; Version 1.0.0</span>
</footer>

<script>
document.getElementById('footer-tahun').textContent = new Date().getFullYear();
fetch('/profil.json')
  .then(function(r){ return r.json(); })
  .then(function(d){
    if (d.nama_sekolah)    document.getElementById('nama-sekolah').textContent   = d.nama_sekolah;
    if (d.tahun_pelajaran) document.getElementById('nama-tahun').textContent     = 'Pengumuman Kelulusan ' + d.tahun_pelajaran;
    if (d.nama_sekolah)    document.getElementById('footer-sekolah').textContent = d.nama_sekolah;
    if (d.alamat_sekolah)  document.getElementById('footer-alamat').textContent  = d.alamat_sekolah;
    if (d.nama_aplikasi)   document.getElementById('footer-app').textContent     = d.nama_aplikasi;
  })
  .catch(function(){});
</script>
</body>
</html>