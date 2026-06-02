<?php
$bulan_id = [
    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
];
function tgl_id($ts, $bulan_id) {
    return date('d', $ts) . ' ' . $bulan_id[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

$now     = time();
$tgl_str = ($profil->tanggal_pengumuman ?? '2099-01-01') . ' ' . ($profil->jam_pengumuman ?? '00:00:00');
$tgl_ts  = strtotime($tgl_str);
$is_open = $now >= $tgl_ts;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($profil->nama_aplikasi ?? 'Sistem Pengumuman Kelulusan') ?> — <?= htmlspecialchars($profil->nama_sekolah ?? 'SMK') ?></title>
<link rel="icon" type="image/png" href="<?= base_url('uploads/pbr.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
#cek-status-section {
  scroll-margin-top: 80px;
}

  :root {
    --bg:         #0f172a;
    --surface:    rgba(255,255,255,.07);
    --surface-solid: #1e293b;
    --border:     rgba(255,255,255,.1);
    --border-md:  rgba(255,255,255,.18);
    --text:       #f1f5f9;
    --text-dark:  #111827;
    --muted:      #94a3b8;
    --hint:       #64748b;
    --accent:     #3b82f6;
    --accent-light: #60a5fa;
    --accent-bg:  rgba(59,130,246,.15);
    --green:      #22c55e;
    --green-bg:   rgba(34,197,94,.15);
    --green-bdr:  rgba(34,197,94,.3);
    --warn:       #f59e0b;
    --warn-bg:    rgba(245,158,11,.15);
    --warn-bdr:   rgba(245,158,11,.3);
    --red:        #ef4444;
    --red-bg:     rgba(239,68,68,.15);
    --red-bdr:    rgba(239,68,68,.3);
    --radius-sm:  8px;
    --radius:     12px;
    --radius-lg:  16px;
    --radius-xl:  20px;
    --blur:       blur(20px);
  }

  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  html { scroll-behavior: smooth; }

  body {
    font-family: 'Poppins', sans-serif;
    background: var(--bg);
    color: var(--text);
    font-size: 14px;
    line-height: 1.6;
    min-height: 100vh;
    overflow-x: hidden;
  }
  a { text-decoration: none; color: inherit; }

  /* ── NAVBAR ── */
  .navbar {
    position: fixed; top: 0; left: 0; right: 0;
    z-index: 100;
    padding: 0 32px;
    height: 64px;
    display: flex; align-items: center; justify-content: space-between;
    background: rgba(15,23,42,.7);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border-bottom: 1px solid var(--border);
    transition: background .3s;
  }
  .nav-brand { display: flex; align-items: center; gap: 12px; }
  .nav-logo-wrap {
    width: 38px; height: 38px; border-radius: 10px;
    overflow: hidden; flex-shrink: 0;
    border: 1px solid var(--border-md);
  }
  .nav-logo-wrap img { width: 100%; height: 100%; object-fit: contain; background: #fff; padding: 3px; }
  .nav-school { font-size: 13.5px; font-weight: 700; color: var(--text); line-height: 1.2; }
  .nav-year   { font-size: 11px; color: var(--muted); font-weight: 400; }
  .nav-right  { display: flex; align-items: center; gap: 10px; }

  .badge {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600;
  }
  .badge-dot {
    width: 7px; height: 7px; border-radius: 50%;
    background: currentColor;
    animation: pulse-dot 2s infinite;
  }
  @keyframes pulse-dot {
    0%,100%{ opacity:1; transform:scale(1) }
    50%{ opacity:.5; transform:scale(.8) }
  }
  .badge-open   { background: var(--green-bg); color: var(--green); border: 1px solid var(--green-bdr); }
  .badge-closed { background: var(--warn-bg); color: var(--warn); border: 1px solid var(--warn-bdr); }

  .btn-admin {
    display: flex; align-items: center; gap: 6px;
    padding: 7px 16px; border-radius: var(--radius-sm);
    font-size: 12.5px; font-weight: 600;
    background: var(--surface);
    border: 1px solid var(--border-md);
    color: var(--text); cursor: pointer;
    font-family: inherit;
    transition: all .2s;
    backdrop-filter: var(--blur);
  }
  .btn-admin:hover { background: var(--border-md); border-color: var(--accent); color: var(--accent-light); }

  /* ── HERO ── */
  .hero {
    position: relative;
    min-height: 100vh;
    min-height: 100svh;
    min-height: -webkit-fill-available;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 120px 24px 60px;
    overflow: hidden;
    isolation: isolate;
}
  .hero-bg {
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    min-height: inherit;          
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    background-attachment: scroll;
    z-index: 0;
}
  .hero-bg::after {
    content: '';
    position: absolute; inset: 0;
    background: linear-gradient(
      to bottom,
      rgba(15,23,42,.75) 0%,
      rgba(15,23,42,.6) 40%,
      rgba(15,23,42,.85) 100%
    );
  }
  .hero-content {
    position: relative; z-index: 1;
    max-width: 700px; width: 100%;
  }
  .hero-chip {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 6px 16px; border-radius: 20px;
    font-size: 11.5px; font-weight: 600;
    background: var(--accent-bg);
    color: var(--accent-light);
    border: 1px solid rgba(59,130,246,.3);
    margin-bottom: 24px;
    letter-spacing: .3px;
    animation: fadeUp .6s ease both;
  }
  .hero-title {
    font-size: clamp(32px, 6vw, 64px);
    font-weight: 800;
    color: #fff;
    line-height: 1.1;
    letter-spacing: -.03em;
    margin-bottom: 18px;
    animation: fadeUp .6s .1s ease both;
  }
  .hero-title em { font-style: normal; color: var(--accent-light); }
  .hero-desc {
    font-size: clamp(13px, 2vw, 15px);
    color: rgba(255,255,255,.7);
    max-width: 480px; margin: 0 auto 32px;
    line-height: 1.9;
    animation: fadeUp .6s .2s ease both;
  }
  .hero-meta {
    display: flex; justify-content: center;
    gap: 6px; flex-wrap: wrap;
    margin-bottom: 44px;
    animation: fadeUp .6s .3s ease both;
  }
  .hero-meta-item {
    display: flex; align-items: center; gap: 7px;
    padding: 6px 14px; border-radius: 20px;
    font-size: 12px; color: rgba(255,255,255,.75);
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.12);
    backdrop-filter: blur(8px);
    font-weight: 500;
  }
  .hero-meta-item svg { width: 12px; height: 12px; opacity: .7; }

  /* countdown */
  .countdown-wrap { animation: fadeUp .6s .4s ease both; }
  .cd-label-top { font-size: 11.5px; color: rgba(255,255,255,.5); margin-bottom: 14px; letter-spacing: .5px; text-transform: uppercase; }
  .countdown { display: inline-flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
  .cd-unit {
    background: rgba(255,255,255,.08);
    border: 1px solid rgba(255,255,255,.15);
    backdrop-filter: blur(12px);
    border-radius: var(--radius);
    padding: 16px 20px; min-width: 74px; text-align: center;
  }
  .cd-num { font-size: 32px; font-weight: 700; color: #fff; line-height: 1; font-variant-numeric: tabular-nums; }
  .cd-lbl { font-size: 9.5px; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,.45); margin-top: 6px; }
  .cd-sep { display: flex; align-items: center; font-size: 24px; font-weight: 300; color: rgba(255,255,255,.3); padding-bottom: 14px; align-self: flex-end; }

  .hero-open {
    display: inline-flex; align-items: center; gap: 10px;
    padding: 14px 28px; border-radius: var(--radius);
    background: var(--green-bg);
    border: 1px solid var(--green-bdr);
    color: var(--green); font-size: 14px; font-weight: 600;
    animation: fadeUp .6s .4s ease both;
  }

  /* scroll indicator */
  .scroll-hint {
    position: absolute; bottom: 28px; left: 50%; transform: translateX(-50%);
    z-index: 1; display: flex; flex-direction: column; align-items: center; gap: 6px;
    color: rgba(255,255,255,.35); font-size: 10.5px; letter-spacing: 1px; text-transform: uppercase;
    animation: bounce 2s infinite;
  }
  @keyframes bounce { 0%,100%{ transform:translateX(-50%) translateY(0) } 50%{ transform:translateX(-50%) translateY(6px) } }

  /* ── MAIN ── */
  .main-wrap {
    max-width: 1080px; margin: 0 auto;
    padding: 60px 24px 80px;
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 28px;
    align-items: start;
  }

  /* ── GLASS CARD ── */
  .glass-card {
    background: rgba(30,41,59,.8);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border-radius: var(--radius-xl);
    border: 1px solid var(--border);
    overflow: hidden;
  }
  .card-head {
    padding: 22px 26px 20px;
    border-bottom: 1px solid var(--border);
  }
  .card-head-top { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
  .card-head-icon {
    width: 32px; height: 32px; border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .card-head h2 { font-size: 15px; font-weight: 700; color: var(--text); }
  .card-head p  { font-size: 12.5px; color: var(--muted); }
  .card-body { padding: 24px 26px; }

  /* form */
  .field-label { display: block; font-size: 12px; font-weight: 600; color: var(--muted); margin-bottom: 8px; letter-spacing: .3px; text-transform: uppercase; }
  .field-input {
    width: 100%; padding: 14px 18px;
    background: rgba(255,255,255,.05);
    border: 1px solid var(--border-md);
    border-radius: var(--radius-sm);
    font-size: 20px; font-weight: 700;
    letter-spacing: 6px; text-align: center;
    color: var(--text); outline: none;
    font-family: inherit;
    transition: border-color .2s, background .2s, box-shadow .2s;
  }
  .field-input:focus {
    border-color: var(--accent);
    background: rgba(59,130,246,.08);
    box-shadow: 0 0 0 3px rgba(59,130,246,.2);
  }
  .field-input::placeholder { letter-spacing: normal; font-weight: 400; font-size: 13px; color: var(--hint); }
  .field-hint { text-align: center; font-size: 11.5px; color: var(--hint); margin-top: 8px; }

  .btn-submit {
    width: 100%; margin-top: 16px; padding: 14px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff; border: none;
    border-radius: var(--radius-sm);
    font-size: 14px; font-weight: 700;
    font-family: inherit; cursor: pointer;
    display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all .2s;
    box-shadow: 0 4px 20px rgba(59,130,246,.35);
    letter-spacing: .3px;
  }
  .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(59,130,246,.5); }
  .btn-submit:active { transform: translateY(0); }
  .btn-submit:disabled { opacity: .5; cursor: not-allowed; transform: none; }

  .alert {
    display: flex; align-items: flex-start; gap: 10px;
    padding: 12px 16px; border-radius: var(--radius-sm);
    font-size: 13px; margin-bottom: 16px;
  }
  .alert-error { background: var(--red-bg); color: #fca5a5; border: 1px solid var(--red-bdr); }

  .divider { height: 1px; background: var(--border); margin: 20px 0; }
  .privacy-note {
    display: flex; align-items: flex-start; gap: 8px;
    font-size: 11.5px; color: var(--hint); line-height: 1.7;
  }
  .privacy-note svg { width: 13px; height: 13px; margin-top: 2px; flex-shrink: 0; opacity: .4; }

  /* locked */
  .locked-state { display: flex; flex-direction: column; align-items: center; text-align: center; }
  .locked-icon {
    width: 56px; height: 56px; border-radius: 50%;
    background: var(--warn-bg); border: 1px solid var(--warn-bdr);
    display: flex; align-items: center; justify-content: center; margin-bottom: 16px;
  }
  .locked-title { font-size: 17px; font-weight: 700; margin-bottom: 6px; }
  .locked-desc { font-size: 13px; color: var(--muted); line-height: 1.7; margin-bottom: 18px; max-width: 280px; }
  .date-pill {
    background: rgba(255,255,255,.06); border: 1px solid var(--border-md);
    border-radius: var(--radius-sm);
    padding: 10px 20px; font-size: 13px; font-weight: 600;
    display: inline-flex; align-items: center; gap: 8px; margin-bottom: 20px; color: var(--text);
  }
  .mini-cd { display: flex; gap: 8px; justify-content: center; margin-bottom: 18px; }
  .mini-unit {
    background: rgba(255,255,255,.06); border: 1px solid var(--border-md);
    border-radius: var(--radius-sm); padding: 10px 12px; min-width: 56px; text-align: center;
  }
  .mini-num { font-size: 22px; font-weight: 700; font-variant-numeric: tabular-nums; color: var(--text); line-height: 1; }
  .mini-lbl { font-size: 9.5px; text-transform: uppercase; letter-spacing: 1px; color: var(--hint); margin-top: 4px; }

  .notify-title { font-size: 13px; font-weight: 600; margin-bottom: 4px; }
  .notify-sub   { font-size: 12px; color: var(--muted); margin-bottom: 12px; }
  .notify-row   { display: flex; flex-direction: column; gap: 8px; }
.notify-input {
  width: 100%; padding: 10px 14px;
  background: rgba(255,255,255,.05);
  border: 1px solid var(--border-md); border-radius: var(--radius-sm);
  font-size: 13px; font-family: inherit; color: var(--text); outline: none;
  transition: border-color .2s;
}
.notify-input:focus { border-color: var(--accent); }
.notify-input::placeholder { color: var(--hint); }
.btn-notify {
  width: 100%; padding: 11px 18px;
  background: rgba(255,255,255,.07); border: 1px solid var(--border-md);
  border-radius: var(--radius-sm);
  font-size: 13px; font-weight: 600; font-family: inherit; color: var(--text);
  cursor: pointer; white-space: nowrap; transition: all .2s;
  display: flex; align-items: center; justify-content: center; gap: 6px;
}
.btn-notify:hover { background: var(--accent-bg); border-color: var(--accent); color: var(--accent-light); }
  .notify-ok {
    display: none; align-items: center; gap: 8px; padding: 10px 14px;
    background: var(--green-bg); border: 1px solid var(--green-bdr);
    border-radius: var(--radius-sm); font-size: 13px; color: var(--green);
  }

  /* left col */
  .left-col { display: flex; flex-direction: column; gap: 20px; }

  /* stat */
  .stat-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 12px; margin-bottom: 24px; }
  .stat {
    background: rgba(255,255,255,.04); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 16px; text-align: center;
  }
  .stat-num { font-size: 24px; font-weight: 800; color: var(--text); }
  .stat-num.green { color: var(--green); }
  .stat-lbl { font-size: 11px; color: var(--hint); margin-top: 3px; }

  .info-card { padding: 24px 26px; }
  .info-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 4px; }
  .info-card-sub { font-size: 12.5px; color: var(--muted); margin-bottom: 20px; }

  .features { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
  .feat {
    background: rgba(255,255,255,.04); border: 1px solid var(--border);
    border-radius: var(--radius); padding: 16px;
    transition: border-color .2s, background .2s;
  }
  .feat:hover { border-color: var(--border-md); background: rgba(255,255,255,.07); }
  .feat-icon { width: 32px; height: 32px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; margin-bottom: 10px; }
  .feat-name { font-size: 13px; font-weight: 600; margin-bottom: 3px; }
  .feat-desc { font-size: 11.5px; color: var(--muted); line-height: 1.6; }

  /* timeline */
  .timeline-card h3 { font-size: 15px; font-weight: 700; margin-bottom: 18px; }
  .tl-item { display: flex; gap: 14px; padding-bottom: 18px; }
  .tl-item:last-child { padding-bottom: 0; }
  .tl-left { display: flex; flex-direction: column; align-items: center; }
  .tl-dot { width: 10px; height: 10px; border-radius: 50%; flex-shrink: 0; margin-top: 4px; }
  .tl-dot.done     { background: var(--accent); }
  .tl-dot.active   { background: var(--warn); box-shadow: 0 0 0 3px var(--warn-bg); }
  .tl-dot.upcoming { background: var(--hint); }
  .tl-line { width: 1px; background: var(--border); flex: 1; margin-top: 4px; min-height: 18px; }
  .tl-date { font-size: 11px; color: var(--hint); margin-bottom: 2px; }
  .tl-name { font-size: 13px; font-weight: 600; }
  .tl-name.active { color: var(--warn); }
  .tl-note { font-size: 11.5px; color: var(--muted); margin-top: 2px; }

  /* notice */
  .notice {
    background: rgba(245,158,11,.1); border: 1px solid var(--warn-bdr);
    border-radius: var(--radius-lg); padding: 18px 20px;
    font-size: 12.5px; color: rgba(253,230,138,.9); line-height: 1.8;
  }
  .notice strong { font-weight: 700; color: #fde68a; }

  /* footer */
  footer {
    background: rgba(15,23,42,.95);
    border-top: 1px solid var(--border);
    text-align: center; padding: 28px 24px;
    font-size: 12.5px; color: var(--hint); line-height: 2;
  }
  footer strong { font-weight: 700; color: var(--muted); }

  /* animations */
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-in { animation: fadeUp .5s ease both; }

  /* responsive */
  @media (max-width: 900px) {
    .main-wrap { grid-template-columns: 1fr; gap: 20px; padding: 40px 20px 60px; }
    .left-col { order: 2; }
    .form-card { order: 1; }
  }
  @media (max-width: 600px) {
    .navbar { padding: 0 14px; height: 58px; flex-wrap: nowrap; }
    .nav-brand { flex: 1; min-width: 0; overflow: hidden; }
    .nav-school { font-size: 12.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .nav-year { font-size: 10.5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .nav-right { flex-shrink: 0; }
    .badge { padding: 6px 8px; }
    .badge span:last-child { display: none; }
    .btn-admin { display: none; }
    .hero { 
    padding: 90px 20px 50px;
    min-height: 100vh;
    min-height: 100svh;
    min-height: -webkit-fill-available;
}
    .cd-unit { min-width: 60px; padding: 12px 14px; }
    .cd-num { font-size: 26px; }
    .cd-sep { display: none; }
    .features { grid-template-columns: 1fr; }
    .stat-row { grid-template-columns: 1fr; }
    .notify-row { flex-direction: column; }
    .main-wrap { padding: 32px 16px 60px; }
    .card-body, .info-card { padding: 18px 20px; }
    .card-head { padding: 18px 20px 16px; }
    .card-head p { text-align: center; }
    .card-head-top { justify-content: center; }
    .field-label { text-align: center; }
    .field-hint { text-align: center; }
    .privacy-note { justify-content: center; text-align: center; }
    .info-card h3 { text-align: center; }
    .info-card-sub { text-align: center; }
    .feat { text-align: center; }
    .feat-icon { margin: 0 auto 10px; }
    .notice { text-align: center; }
    footer { padding: 20px 28px; font-size: 10.5px; line-height: 1.9; }
  }
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a href="<?= site_url('/') ?>" class="nav-brand">
    <div class="nav-logo-wrap">
      <img src="<?= base_url('uploads/pbr.png') ?>" alt="Logo">
    </div>
    <div>
      <div class="nav-school"><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></div>
      <div class="nav-year">Pengumuman Kelulusan <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>
  </a>
  <div class="nav-right">
    <div class="badge <?= $is_open ? 'badge-open' : 'badge-closed' ?>">
      <span class="badge-dot"></span>
      <span><?= $is_open ? 'Pengumuman Terbuka' : 'Belum Dibuka' ?></span>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg" style="background-image:url('<?= base_url('uploads/bg-hero.jpeg') ?>')"></div>
  <div class="hero-content">
    <div class="hero-chip">
      <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>
      </svg>
      Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '2024/2025') ?>
    </div>
    <h1 class="hero-title">Pengumuman<br><em>Kelulusan Siswa</em></h1>
    <p class="hero-desc">
      <?= $is_open
        ? 'Portal resmi pengecekan kelulusan ' . htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') . '. Masukkan NISN untuk melihat status kelulusan Kamu.'
        : 'Portal resmi pengecekan kelulusan ' . htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') . '. Pengumuman akan dibuka sesuai jadwal.'
      ?>
    </p>
    <div class="hero-meta">
      <?php if ($profil->tanggal_pengumuman): ?>
      <span class="hero-meta-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
        </svg>
        <?= tgl_id(strtotime($profil->tanggal_pengumuman), $bulan_id) ?>
      </span>
      <?php endif; ?>
      <?php if ($profil->jam_pengumuman): ?>
      <span class="hero-meta-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>
        </svg>
        Pukul <?= date('H:i', strtotime($profil->jam_pengumuman)) ?> WIB
      </span>
      <?php endif; ?>
      <?php if ($profil->alamat_sekolah): ?>
      <span class="hero-meta-item">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
          <circle cx="12" cy="10" r="3"/>
        </svg>
        <?= htmlspecialchars($profil->alamat_sekolah) ?>
      </span>
      <?php endif; ?>
    </div>

    <?php if (!$is_open): ?>
    <div class="countdown-wrap">
      <div class="cd-label-top">Pengumuman dibuka dalam</div>
      <div class="countdown">
        <div class="cd-unit"><div class="cd-num" id="cd-d">00</div><div class="cd-lbl">Hari</div></div>
        <div class="cd-sep">:</div>
        <div class="cd-unit"><div class="cd-num" id="cd-h">00</div><div class="cd-lbl">Jam</div></div>
        <div class="cd-sep">:</div>
        <div class="cd-unit"><div class="cd-num" id="cd-m">00</div><div class="cd-lbl">Menit</div></div>
        <div class="cd-sep">:</div>
        <div class="cd-unit"><div class="cd-num" id="cd-s">00</div><div class="cd-lbl">Detik</div></div>
      </div>
    </div>
    <?php else: ?>
    <div class="hero-open">
      <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Pengumuman Resmi Telah Dibuka
    </div>
    <?php endif; ?>
  </div>

  <div class="scroll-hint">
    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
      <polyline points="6 9 12 15 18 9"/>
    </svg>
    Scroll
  </div>
</section>

<!-- MAIN GRID -->
<div class="main-wrap">

  <!-- KIRI -->
  <div class="left-col">

    <?php if (!$is_open): ?>
    <div class="glass-card info-card timeline-card fade-in">
      <h3>Jadwal Kegiatan</h3>
      <div class="tl-item">
        <div class="tl-left"><div class="tl-dot done"></div><div class="tl-line"></div></div>
        <div>
          <div class="tl-date">Selesai</div>
          <div class="tl-name">Ujian Selesai</div>
          <div class="tl-note">Seluruh rangkaian ujian telah terlaksana</div>
        </div>
      </div>
      <div class="tl-item">
        <div class="tl-left"><div class="tl-dot active"></div><div class="tl-line"></div></div>
        <div>
          <div class="tl-date">Sedang Berlangsung</div>
          <div class="tl-name active">Proses Verifikasi Kelulusan</div>
          <div class="tl-note">Rekapitulasi dan finalisasi nilai akhir</div>
        </div>
      </div>
      <div class="tl-item">
        <div class="tl-left"><div class="tl-dot upcoming"></div><div class="tl-line"></div></div>
        <div>
          <div class="tl-date">
            <?= $profil->tanggal_pengumuman ? tgl_id(strtotime($profil->tanggal_pengumuman), $bulan_id) : '-' ?>
            · <?= $profil->jam_pengumuman ? date('H:i', strtotime($profil->jam_pengumuman)) : '-' ?> WIB
          </div>
          <div class="tl-name">Pengumuman Kelulusan Dibuka</div>
          <div class="tl-note">Portal aktif, siswa dapat mengecek hasil</div>
        </div>
      </div>
      <div class="tl-item">
        <div class="tl-left"><div class="tl-dot upcoming"></div></div>
        <div>
          <div class="tl-date">Menyusul</div>
          <div class="tl-name">Pengambilan Ijazah</div>
          <div class="tl-note">Sesuai jadwal yang ditetapkan sekolah</div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="glass-card info-card fade-in">
      <!--<div class="stat-row">
        <div class="stat"><div class="stat-num"><?= $total_siswa ?? 0 ?></div><div class="stat-lbl">Total siswa</div></div>
        <div class="stat"><div class="stat-num green"><?= $total_lulus ?? 0 ?></div><div class="stat-lbl">Lulus</div></div>
        <div class="stat">
          <div class="stat-num"><?= ($total_siswa ?? 0) > 0 ? number_format(($total_lulus / $total_siswa) * 100, 1) : '0' ?>%</div>
          <div class="stat-lbl">Kelulusan</div>
        </div>
      </div>-->
      <h3>Tentang Portal Ini</h3>
      <p class="info-card-sub">Platform resmi pengecekan kelulusan yang dikelola sekolah</p>
      <div class="features">
        <div class="feat">
          <div class="feat-icon" style="background:var(--accent-bg)">
            <svg width="13" height="13" fill="none" stroke="var(--accent-light)" stroke-width="2" viewBox="0 0 24 24">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            </svg>
          </div>
          <div class="feat-name">Data Terverifikasi</div>
          <div class="feat-desc">Dikelola langsung oleh pihak sekolah</div>
        </div>
        <div class="feat">
          <div class="feat-icon" style="background:var(--green-bg)">
            <svg width="13" height="13" fill="none" stroke="var(--green)" stroke-width="2" viewBox="0 0 24 24">
              <polyline points="6 9 6 2 18 2 18 9"/>
              <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/>
              <rect x="6" y="14" width="12" height="8"/>
            </svg>
          </div>
          <div class="feat-name">Cetak Bukti</div>
          <div class="feat-desc">Unduh surat undangan koordinasi</div>
        </div>
        <div class="feat">
          <div class="feat-icon" style="background:var(--warn-bg)">
            <svg width="13" height="13" fill="none" stroke="var(--warn)" stroke-width="2" viewBox="0 0 24 24">
              <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/>
            </svg>
          </div>
          <div class="feat-name">Akses Real-Time</div>
          <div class="feat-desc">Tersedia sejak jadwal dibuka</div>
        </div>
        <div class="feat">
          <div class="feat-icon" style="background:rgba(255,255,255,.06)">
            <svg width="13" height="13" fill="none" stroke="var(--muted)" stroke-width="2" viewBox="0 0 24 24">
              <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
            </svg>
          </div>
          <div class="feat-name">Aman & Privat</div>
          <div class="feat-desc">Hanya bisa diakses dengan NISN sendiri</div>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <div class="notice fade-in">
      <strong>⚠ Catatan penting —</strong> Jika terdapat perbedaan antara pengumuman online dan dokumen manual,
      yang menjadi acuan adalah <strong>dokumen asli kelulusan</strong> yang telah disahkan, ditandatangani
      Kepala Sekolah <strong><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></strong> dan diberi cap basah sekolah.
    </div>

  </div>

  <!-- KANAN: FORM -->
  <div class="glass-card form-card fade-in" style="order:1">
    <div class="card-head" id="cek-status-section">
      <div class="card-head-top">
        <div class="card-head-icon" style="background:<?= $is_open ? 'var(--accent-bg)' : 'var(--warn-bg)' ?>">
          <?php if ($is_open): ?>
          <svg width="14" height="14" fill="none" stroke="var(--accent-light)" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          <?php else: ?>
          <svg width="14" height="14" fill="none" stroke="var(--warn)" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <?php endif; ?>
        </div>
        <h2>Cek Status Kelulusan</h2>
      </div>
      <p><?= $is_open ? 'Masukkan NISN untuk melihat hasil kelulusan Kamu' : 'Pengumuman belum dibuka — silakan kembali sesuai jadwal' ?></p>
    </div>
    <div class="card-body">

      <?php if ($is_open): ?>
      <form action="<?= site_url('cek') ?>" method="POST" id="formCek">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
        <label class="field-label" for="nisn">Nomor Induk Siswa Nasional</label>
        <input type="text" name="nisn" id="nisn" class="field-input"
          placeholder="0000000000" maxlength="10" pattern="[0-9]{10}"
          inputmode="numeric" autocomplete="off" required>
        <div class="field-hint">NISN terdiri dari 10 digit angka</div>
        <button type="submit" class="btn-submit" id="btnCek">
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          Cek Kelulusan Saya
        </button>
      </form>
      <div class="divider"></div>
      <div class="privacy-note">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        </svg>
        Data yang Kamu masukkan hanya digunakan untuk keperluan pengecekan kelulusan dan tidak disimpan.
      </div>

      <?php else: ?>
      <div class="locked-state">
        <div class="locked-icon">
          <svg width="24" height="24" fill="none" stroke="var(--warn)" stroke-width="1.8" viewBox="0 0 24 24">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </div>
        <div class="locked-title">Pengumuman Belum Dibuka</div>
        <div class="locked-desc">Portal akan aktif mulai tanggal berikut:</div>
        <div class="date-pill">
          <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>
          </svg>
          <?= $profil->tanggal_pengumuman ? tgl_id(strtotime($profil->tanggal_pengumuman), $bulan_id) : '-' ?>
          &nbsp;·&nbsp; <?= $profil->jam_pengumuman ? date('H:i', strtotime($profil->jam_pengumuman)) : '-' ?> WIB
        </div>
        <div class="mini-cd">
          <div class="mini-unit"><div class="mini-num" id="m-d">00</div><div class="mini-lbl">Hari</div></div>
          <div class="mini-unit"><div class="mini-num" id="m-h">00</div><div class="mini-lbl">Jam</div></div>
          <div class="mini-unit"><div class="mini-num" id="m-m">00</div><div class="mini-lbl">Menit</div></div>
          <div class="mini-unit"><div class="mini-num" id="m-s">00</div><div class="mini-lbl">Detik</div></div>
        </div>
      </div>
      <div class="divider"></div>
      <div class="notify-title">Ingatkan Saya Saat Dibuka</div>
      <div class="notify-sub">Masukkan nomor WhatsApp kamu</div>
      <div class="notify-ok" id="notify-ok">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
        Berhasil! Kamu akan diingatkan via WhatsApp.
      </div>
      <div class="notify-row" id="notify-form">
        <input type="tel" class="notify-input" id="notif-wa" 
          placeholder="08xxxxxxxxxx" inputmode="numeric" maxlength="15"
          required minlength="10">
        <button class="btn-notify" id="btn-notify">
          <svg width="13" height="13" fill="currentColor" viewBox="0 0 24 24" style="margin-right:4px">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.123.553 4.116 1.522 5.847L.057 23.882l6.197-1.424A11.945 11.945 0 0 0 12 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.818a9.818 9.818 0 0 1-5.001-1.366l-.36-.213-3.68.845.872-3.579-.234-.368A9.774 9.774 0 0 1 2.182 12C2.182 6.58 6.58 2.182 12 2.182S21.818 6.58 21.818 12 17.42 21.818 12 21.818z"/>
          </svg>
          Daftarkan
        </button>
      </div>
      <?php endif; ?>

    </div>
  </div>

</div>

<!-- FOOTER -->
<footer>
  <strong><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></strong><br>
  <?= htmlspecialchars($profil->alamat_sekolah ?? '') ?><br>
  &copy; <?= date('Y') ?> <?= htmlspecialchars($profil->nama_aplikasi ?? 'Sistem Pengumuman Kelulusan') ?>. Hak cipta dilindungi.<br>
  <span style="font-size:11.5px;color:var(--hint)">Developed by <strong style="color:var(--muted)">Ivan Zaka Mubarok</strong> &nbsp;·&nbsp; Version 1.0.0</span>
</footer>

<script>
(function () {
  var nisnEl = document.getElementById('nisn');
  if (nisnEl) {
    nisnEl.addEventListener('input', function () {
      this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });
  }
  var notifWaEl = document.getElementById('notif-wa');
    if (notifWaEl) {
        notifWaEl.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 15);
        });
    }
  var formCek = document.getElementById('formCek');
  if (formCek) {
    formCek.addEventListener('submit', function () {
      var btn = document.getElementById('btnCek');
      btn.disabled = true;
      btn.innerHTML = '<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Mencari data...';
    });
  }

  <?php if (!$is_open): ?>
  var cdTarget = new Date('<?= $profil->tanggal_pengumuman ?? '2099-01-01' ?>T<?= $profil->jam_pengumuman ?? '00:00:00' ?>').getTime();
  function pad(n) { return String(n).padStart(2, '0'); }
  function cdTick() {
    var diff = cdTarget - Date.now();
    if (diff <= 0) { location.reload(); return; }
    var d = Math.floor(diff / 86400000);
    var h = Math.floor((diff % 86400000) / 3600000);
    var m = Math.floor((diff % 3600000) / 60000);
    var s = Math.floor((diff % 60000) / 1000);
    ['cd-d','cd-h','cd-m','cd-s'].forEach(function(id, i) {
      var el = document.getElementById(id);
      if (el) el.textContent = pad([d,h,m,s][i]);
    });
    ['m-d','m-h','m-m','m-s'].forEach(function(id, i) {
      var el = document.getElementById(id);
      if (el) el.textContent = pad([d,h,m,s][i]);
    });
  }
  cdTick(); setInterval(cdTick, 1000);

  var btnNotify = document.getElementById('btn-notify');
  if (btnNotify) {
      btnNotify.addEventListener('click', function () {
         var wa = document.getElementById('notif-wa').value.trim().replace(/\D/g, '');
        var inputEl = document.getElementById('notif-wa');
        if (!wa || wa.length < 10) {
            inputEl.focus();
            inputEl.style.borderColor = 'var(--red)';
            inputEl.style.boxShadow   = '0 0 0 3px var(--red-bg)';
            setTimeout(function() {
                inputEl.style.borderColor = '';
                inputEl.style.boxShadow   = '';
            }, 2000);
            return;
        }

          btnNotify.disabled = true;
          btnNotify.textContent = 'Mendaftarkan...';

          fetch('<?= site_url('admin/daftar_notif') ?>', {
              method: 'POST',
              headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
              body: '<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>&nomor=' + encodeURIComponent(wa)
          })
          .then(r => r.json())
          .then(res => {
              document.getElementById('notify-form').style.display = 'none';
              document.getElementById('notify-ok').style.display   = 'flex';
          })
          .catch(() => {
              btnNotify.disabled    = false;
              btnNotify.textContent = 'Daftarkan';
          });
      });
  }
  <?php endif; ?>
})();
</script>
<!-- POPUP ALERT -->
<div id="popup-overlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);backdrop-filter:blur(4px);z-index:999;align-items:center;justify-content:center;">
  <div style="background:#1e293b;border:1px solid rgba(239,68,68,.3);border-radius:16px;padding:32px 28px;max-width:360px;width:90%;text-align:center;animation:fadeUp .3s ease both">
    <div style="width:52px;height:52px;border-radius:50%;background:rgba(239,68,68,.15);border:1px solid rgba(239,68,68,.3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px">
      <svg width="22" height="22" fill="none" stroke="#ef4444" stroke-width="2" viewBox="0 0 24 24">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
    </div>
    <div style="font-size:16px;font-weight:700;color:#f1f5f9;margin-bottom:8px">NISN Tidak Ditemukan</div>
    <div style="font-size:13px;color:#94a3b8;line-height:1.7;margin-bottom:24px">Periksa kembali NISN yang Kamu masukkan dan pastikan sudah benar.</div>
    <button onclick="
      document.getElementById('popup-overlay').style.display='none';
      document.getElementById('cek-status-section').scrollIntoView({behavior:'smooth', block:'start'});
    " style="width:100%;padding:12px;background:linear-gradient(135deg,#dc2626,#ef4444);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit">
      Coba Lagi
    </button>
  </div>
</div>

<?php if ($this->session->flashdata('error')): ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var overlay = document.getElementById('popup-overlay');
    overlay.style.display = 'flex';
  });
</script>
<?php endif; ?>
</body>
</html>