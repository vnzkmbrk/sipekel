<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($title) ? $title . ' — ' : '' ?><?= $profil->nama_aplikasi ?? 'Sistem Kelulusan' ?></title>
<link rel="icon" type="image/png" href="<?= base_url('uploads/pbr.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root {
  --primary: #1a56db;
  --primary-dark: #1340a8;
  --primary-light: #e8f0fd;
  --secondary: #0f172a;
  --accent: #f59e0b;
  --success: #10b981;
  --danger: #ef4444;
  --warning: #f59e0b;
  --info: #3b82f6;
  --bg: #f1f5f9;
  --card: #ffffff;
  --border: #e2e8f0;
  --text: #1e293b;
  --text-muted: #64748b;
  --sidebar-w: 260px;
  --header-h: 64px;
  --radius: 12px;
  --shadow: 0 1px 3px rgba(0,0,0,.08), 0 4px 16px rgba(0,0,0,.06);
  --shadow-lg: 0 8px 32px rgba(0,0,0,.12);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'Poppins',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;display:flex;flex-direction:column}

/* ── SIDEBAR ── */
.sidebar{position:fixed;top:0;left:0;width:var(--sidebar-w);height:100vh;background:var(--secondary);display:flex;flex-direction:column;z-index:200;transition:transform .3s ease;overflow-y:auto}
.sidebar-brand{display:flex;align-items:center;gap:12px;padding:20px 20px 16px;border-bottom:1px solid rgba(255,255,255,.08)}
.brand-icon{width:40px;height:40px;background:var(--primary);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;color:#fff;flex-shrink:0}
.brand-text{flex:1;min-width:0}
.brand-title{font-size:13px;font-weight:700;color:#fff;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.brand-sub{font-size:11px;color:rgba(255,255,255,.4);font-weight:400;margin-top:2px}
.sidebar-section{padding:16px 12px 4px;font-size:10px;font-weight:700;letter-spacing:1.2px;color:rgba(255,255,255,.3);text-transform:uppercase}
.nav-item{display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:8px;margin:2px 8px;text-decoration:none;color:rgba(255,255,255,.65);font-size:13.5px;font-weight:500;transition:all .2s}
.nav-item i{width:18px;text-align:center;font-size:14px;flex-shrink:0}
.nav-item:hover{background:rgba(255,255,255,.08);color:#fff}
.nav-item.active{background:var(--primary);color:#fff;box-shadow:0 4px 12px rgba(26,86,219,.4)}
.nav-item .badge{margin-left:auto;background:var(--danger);color:#fff;font-size:10px;padding:2px 6px;border-radius:20px}
.sidebar-footer{margin-top:auto;padding:12px 8px 24px;border-top:1px solid rgba(255,255,255,.08);flex-shrink:0}
/* ── SIDEBAR COLLAPSE (desktop) ── */
.sidebar { transition: transform .3s ease; }
.main-wrap { transition: margin-left .3s ease; }
.topbar { transition: left .3s ease; }

.sidebar.collapsed { transform: translateX(-100%); }
.main-wrap.expanded { margin-left: 0; }
.topbar.expanded { left: 0; }

/* ── TOPBAR ── */
.topbar {
  position: fixed;
  top: 0;
  left: var(--sidebar-w);
  right: 0;
  height: var(--header-h);
  background: var(--card);
  border-bottom: 1px solid var(--border);
  display: flex;
  align-items: center;
  padding: 0 20px;
  gap: 12px;
  z-index: 100;
  box-shadow: 0 1px 0 var(--border);
}
.topbar-toggle {
  display: flex;
  background: none;
  border: none;
  font-size: 20px;
  color: var(--text);
  cursor: pointer;
  padding: 8px;
  border-radius: 8px;
  flex-shrink: 0;
}
.topbar-toggle:hover { background: var(--bg); }
.topbar-title {
  font-size: 15px;
  font-weight: 700;
  color: var(--text);
  flex: 1;
  min-width: 0;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Topbar actions — kanan */
.topbar-actions {
  display: flex;
  align-items: center;
  gap: 8px;
  flex-shrink: 0;
}

/* Tombol Lihat Halaman Siswa */
.btn-view-siswa {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 7px 14px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: var(--bg);
  font-size: 13px;
  font-weight: 500;
  color: var(--text-muted);
  font-family: inherit;
  text-decoration: none;
  white-space: nowrap;
  transition: all .2s;
  flex-shrink: 0;
}
.btn-view-siswa:hover {
  background: var(--primary-light);
  color: var(--primary);
  border-color: var(--primary);
  text-decoration: none;
}
/* Desktop: tampilkan teks panjang, sembunyikan teks pendek */
.btn-label-short { display: none; }
.btn-label-full  { display: inline; }

/* User chip */
.topbar-user {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 5px 10px 5px 6px;
  border-radius: 10px;
  border: 1px solid var(--border);
  background: var(--bg);
  flex-shrink: 0;
}
.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 8px;
  background: var(--primary);
  color: #fff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  font-weight: 700;
  flex-shrink: 0;
}
.user-info { line-height: 1.3; }
.user-name { font-size: 12px; font-weight: 600; color: var(--text); white-space: nowrap; }
.user-role { font-size: 11px; color: var(--text-muted); text-transform: capitalize; white-space: nowrap; }

/* ── MAIN ── */
.main-wrap{margin-left:var(--sidebar-w);padding-top:var(--header-h);min-height:100vh;display:flex;flex-direction:column}
.main-content{padding:24px;flex:1}
.page-header{margin-bottom:24px}
.page-title{font-size:22px;font-weight:800;color:var(--text);font-family:'Poppins',sans-serif}
.page-subtitle{font-size:13px;color:var(--text-muted);margin-top:4px}
.breadcrumb{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);margin-bottom:6px}
.breadcrumb a{color:var(--primary);text-decoration:none}
.breadcrumb span{color:var(--text-muted)}

/* ── CARDS ── */
.card{background:var(--card);border-radius:var(--radius);box-shadow:var(--shadow);border:1px solid var(--border);overflow:hidden}
.card-header{padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px}
.card-title{font-size:15px;font-weight:700;color:var(--text);flex:1}
.card-body{padding:20px}

/* ── STAT CARDS ── */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px;margin-bottom:24px}
.stat-card{background:var(--card);border-radius:var(--radius);padding:20px;border:1px solid var(--border);box-shadow:var(--shadow);display:flex;align-items:center;gap:16px;transition:transform .2s,box-shadow .2s}
.stat-card:hover{transform:translateY(-2px);box-shadow:var(--shadow-lg)}
.stat-icon{width:52px;height:52px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0}
.stat-icon.blue{background:#eff6ff;color:var(--primary)}
.stat-icon.green{background:#f0fdf4;color:var(--success)}
.stat-icon.orange{background:#fffbeb;color:var(--warning)}
.stat-icon.red{background:#fef2f2;color:var(--danger)}
.stat-icon.purple{background:#faf5ff;color:#7c3aed}
.stat-value{font-size:28px;font-weight:800;color:var(--text);line-height:1;font-family:'Poppins',sans-serif}
.stat-label{font-size:12px;color:var(--text-muted);margin-top:4px}

/* ── TABLE ── */
.table-wrap{overflow-x:auto;border-radius:0 0 var(--radius) var(--radius)}
table{width:100%;border-collapse:collapse;font-size:13.5px}
thead th{background:var(--bg);padding:12px 16px;text-align:left;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);white-space:nowrap;border-bottom:2px solid var(--border)}
tbody tr{border-bottom:1px solid var(--border);transition:background .15s}
tbody tr:hover{background:#f8fafc}
tbody tr:last-child{border-bottom:none}
tbody td{padding:13px 16px;vertical-align:middle}
.td-nisn{font-family:'Poppins',sans-serif;font-weight:600;color:var(--primary);font-size:13px;letter-spacing:.5px}

/* ── BADGES ── */
.badge{display:inline-flex;align-items:center;gap:4px;padding:4px 10px;border-radius:20px;font-size:11.5px;font-weight:600}
.badge-success{background:#dcfce7;color:#15803d}
.badge-warning{background:#fef9c3;color:#a16207}
.badge-primary{background:#dbeafe;color:#1d4ed8}
.badge-info{background:#e0f2fe;color:#0369a1}
.badge-danger{background:#fee2e2;color:#b91c1c}
.badge-secondary{background:#f1f5f9;color:#475569}

/* ── BUTTONS ── */
.btn{display:inline-flex;align-items:center;gap:7px;padding:9px 16px;border-radius:8px;font-size:13.5px;font-weight:600;cursor:pointer;border:none;font-family:inherit;text-decoration:none;transition:all .2s;white-space:nowrap}
.btn-sm{padding:6px 12px;font-size:12px;border-radius:7px}
.btn-xs{padding:4px 9px;font-size:11px;border-radius:6px}
.btn-primary{background:var(--primary);color:#fff}
.btn-primary:hover{background:var(--primary-dark);transform:translateY(-1px)}
.btn-success{background:var(--success);color:#fff}
.btn-success:hover{background:#059669}
.btn-warning{background:var(--warning);color:#fff}
.btn-warning:hover{background:#d97706}
.btn-danger{background:var(--danger);color:#fff}
.btn-danger:hover{background:#dc2626}
.btn-outline{background:transparent;color:var(--text-muted);border:1px solid var(--border)}
.btn-outline:hover{background:var(--bg);color:var(--text)}
.btn-info{background:var(--info);color:#fff}
.btn-icon{padding:8px;border-radius:7px;background:var(--bg);border:1px solid var(--border);color:var(--text-muted);cursor:pointer;font-size:14px;transition:all .2s;display:inline-flex;align-items:center;justify-content:center}
.btn-icon:hover{background:var(--primary-light);color:var(--primary);border-color:var(--primary)}
.btn-icon.danger:hover{background:#fef2f2;color:var(--danger);border-color:var(--danger)}
.btn-icon.success:hover{background:#f0fdf4;color:var(--success);border-color:var(--success)}
.btn-group{display:flex;gap:4px}

/* ── FORMS ── */
.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.form-grid-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px}
.form-group{margin-bottom:16px}
.form-full{grid-column:1/-1}
label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px}
label span.req{color:var(--danger);margin-left:3px}
.form-control{width:100%;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;font-size:13.5px;font-family:inherit;color:var(--text);background:var(--card);transition:border-color .2s,box-shadow .2s;outline:none}
.form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(26,86,219,.12)}
.form-control::placeholder{color:#b0bec5}
select.form-control{cursor:pointer}
textarea.form-control{resize:vertical;min-height:90px}
.form-hint{font-size:11.5px;color:var(--text-muted);margin-top:5px}

/* ── SEARCH BAR ── */
.search-bar{display:flex;gap:10px;flex-wrap:wrap;align-items:center}
.search-input-wrap{position:relative;flex:1;min-width:200px}
.search-input-wrap i{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:14px}
.search-input-wrap input{padding-left:36px}

/* ── ALERTS ── */
.alert{padding:14px 16px;border-radius:9px;font-size:13.5px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start}
.alert i{flex-shrink:0;margin-top:1px}
.alert ul{margin:4px 0 0 16px;padding:0}
.alert-success{background:#f0fdf4;border:1px solid #a7f3d0;color:#064e3b}
.alert-error{background:#fef2f2;border:1px solid #fca5a5;color:#7f1d1d}
.alert-warning{background:#fffbeb;border:1px solid #fde68a;color:#713f12}
.alert-info{background:#eff6ff;border:1px solid #bfdbfe;color:#1e3a8a}

/* ── OVERLAY (mobile sidebar) ── */
.sidebar-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:150;opacity:0;transition:opacity .3s}
.sidebar-overlay.show{display:block;opacity:1}

/* ══════════════════════════════
   RESPONSIVE
══════════════════════════════ */

/* Tablet landscape ≤ 1024px */
@media (max-width: 1024px) {
  .stats-grid { grid-template-columns: repeat(3, 1fr); }
  .form-grid-3 { grid-template-columns: 1fr 1fr; }
}

/* Tablet portrait ≤ 768px — sidebar disembunyikan, topbar full-width */
@media (max-width: 768px) {
  .sidebar { transform: translateX(-100%); }
  .sidebar.open { transform: translateX(0); }
  
  .sidebar {
    height: 100dvh;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
  }

  .main-wrap { margin-left: 0; }
  .topbar { left: 0; padding: 0 12px; gap: 8px; }
  .topbar-toggle { display: flex; }
  .btn-label-full  { display: none; }
  .btn-label-short { display: inline; }
  .btn-view-siswa  { padding: 7px 10px; }
  .topbar-user .user-info { display: none; }
  .topbar-user { padding: 5px 6px; }
  .main-content { padding: 14px; }
  .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
  .form-grid, .form-grid-3 { grid-template-columns: 1fr; }
  .search-bar { flex-direction: column; align-items: stretch; }
  .page-title { font-size: 18px; }
}

/* Mobile ≤ 480px */
@media (max-width: 480px) {
  .stats-grid { grid-template-columns: 1fr 1fr; gap: 8px; }
  .stat-card { padding: 12px; gap: 10px; }
  .stat-icon { width: 40px; height: 40px; font-size: 17px; }
  .stat-value { font-size: 20px; }
  .topbar { padding: 0 12px; gap: 8px; }
}
</style>
</head>
<body>

<!-- Sidebar Overlay -->
<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-icon">
      <?php if (file_exists(FCPATH . 'uploads/pbr.png')): ?>
      <img src="<?= base_url('uploads/pbr.png') ?>" alt="Logo" style="width:28px;height:28px;object-fit:contain">
      <?php else: ?>
      <i class="fas fa-graduation-cap"></i>
      <?php endif; ?>
    </div>
    <div class="brand-text">
      <div class="brand-title">SIPEKEL</div>
      <div class="brand-sub">Sistem Pengumuman Kelulusan</div>
    </div>
  </div>

  <div class="sidebar-section">Utama</div>
  <a href="<?= site_url('admin/dashboard') ?>" class="nav-item <?= uri_string() == 'admin/dashboard' || uri_string() == 'admin' ? 'active' : '' ?>">
    <i class="fas fa-chart-pie"></i> Dashboard
  </a>

  <div class="sidebar-section">Manajemen</div>
  <a href="<?= site_url('admin/profil') ?>" class="nav-item <?= strpos(uri_string(), 'admin/profil') === 0 ? 'active' : '' ?>">
    <i class="fas fa-school"></i> Profil Sekolah
  </a>
  <a href="<?= site_url('admin/siswa') ?>" class="nav-item <?= strpos(uri_string(), 'admin/siswa') === 0 ? 'active' : '' ?>">
    <i class="fas fa-users"></i> Data Siswa
  </a>
  <?php if ($user['role'] === 'admin'): ?>
  <a href="<?= site_url('admin/pengguna') ?>" class="nav-item <?= strpos(uri_string(), 'admin/pengguna') === 0 ? 'active' : '' ?>">
      <i class="fas fa-user-shield"></i> Pengguna
  </a>
  <?php endif; ?>

  <div class="sidebar-section">Laporan</div>
  <a href="<?= site_url('admin/statistik') ?>" class="nav-item <?= strpos(uri_string(), 'admin/statistik') === 0 ? 'active' : '' ?>">
      <i class="fas fa-chart-bar"></i> Statistik
  </a>

  <?php if ($user['role'] === 'admin'): ?>
  <a href="<?= site_url('admin/log') ?>" class="nav-item <?= strpos(uri_string(), 'admin/log') === 0 ? 'active' : '' ?>">
      <i class="fas fa-history"></i> Log Aktivitas
  </a>
  <?php endif; ?>

  <div class="sidebar-footer">
    <a href="javascript:void(0)" onclick="konfirmLogout()" class="nav-item" style="color:#ef4444">
      <i class="fas fa-sign-out-alt"></i> Keluar
    </a>
  </div>
</aside>

<!-- ── TOPBAR ── -->
<div class="topbar">
  <button class="topbar-toggle" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
  </button>

  <span class="topbar-title"><?= isset($title) ? htmlspecialchars($title) : 'Dashboard' ?></span>

  <div class="topbar-actions">
    <!-- Desktop: "Halaman Siswa" | Mobile: "Halaman Siswa" -->
    <a href="<?= site_url('/') ?>" class="btn-view-siswa" target="_blank" title="Halaman Siswa">
      <i class="fas fa-eye"></i>
      <span class="btn-label-full">Halaman Siswa</span>
      <span class="btn-label-short">Halaman Siswa</span>
    </a>

    <!-- User chip: avatar + nama/role (nama hilang di mobile) -->
    <div class="topbar-user">
      <div class="user-avatar"><?= strtoupper(substr($user['nama_lengkap'] ?? 'A', 0, 1)) ?></div>
      <div class="user-info">
        <div class="user-name"><?= htmlspecialchars($user['nama_lengkap'] ?? '') ?></div>
        <div class="user-role"><?= htmlspecialchars($user['role'] ?? '') ?></div>
      </div>
    </div>
  </div>
</div>

<!-- ── MAIN WRAPPER ── -->
<div class="main-wrap">
<div class="main-content">