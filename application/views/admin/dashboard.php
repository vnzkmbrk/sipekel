<?php
$profil = isset($profil) ? $profil : null;
$bulan_id = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
$tgl = '-';
if ($profil && $profil->tanggal_pengumuman) {
    $ts  = strtotime($profil->tanggal_pengumuman);
    $tgl = date('d', $ts) . ' ' . $bulan_id[(int) date('n', $ts)] . ' ' . date('Y', $ts);
}
$jam = $profil && $profil->jam_pengumuman ? date('H:i', strtotime($profil->jam_pengumuman)) : '-';
?>

<div class="page-header">
  <div class="breadcrumb">
    <a href="<?= site_url('admin/dashboard') ?>">Home</a>
    <span>/</span>
    <span>Dashboard</span>
  </div>
  <div class="page-title">Dashboard</div>
  <div class="page-subtitle">
    Selamat datang, <?= htmlspecialchars($user['nama_lengkap'] ?? '') ?>!
    Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?>
  </div>
</div>

<!-- ===== BLAST WA ===== -->
<div style="margin-top:20px;margin-bottom:20px;padding:20px;background:rgba(34,197,94,.08);border:1px solid rgba(34,197,94,.2);border-radius:12px;">
  <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
    <div>
      <div style="font-weight:700;font-size:14px;margin-bottom:4px">📢 Kirim Pengumuman via WhatsApp</div>
      <div style="font-size:12px;color:#64748b" id="info-notif">Memuat jumlah pendaftar...</div>
    </div>
    <button onclick="blastWA()" id="btn-blast" style="padding:10px 20px;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;font-family:inherit">
      🚀 Kirim Blast WA Sekarang
    </button>
  </div>
</div>

<script>
var _blastTotal = 0;

fetch('<?= site_url('admin/list_notif') ?>')
  .then(r => r.json())
  .then(res => {
    _blastTotal = res.total;
    document.getElementById('info-notif').textContent = res.total + ' nomor WA terdaftar';
  });

function blastWA() {
    document.getElementById('popup-blast-total').textContent = _blastTotal;
    document.getElementById('popup-blast').style.display = 'flex';
}

function konfirmasiBlast() {
    document.getElementById('popup-blast').style.display = 'none';
    var btn = document.getElementById('btn-blast');
    btn.disabled    = true;
    btn.textContent = '⏳ Mengirim...';

    fetch('<?= site_url('admin/blast_wa') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: '<?= $this->security->get_csrf_token_name() ?>=<?= $this->security->get_csrf_hash() ?>'
    })
    .then(r => r.json())
    .then(res => {
        btn.disabled    = false;
        btn.textContent = '🚀 Kirim Blast WA Sekarang';
        document.getElementById('popup-blast-msg').textContent = res.message;
        document.getElementById('popup-blast-result').style.display = 'flex';
    })
    .catch(() => {
        btn.disabled    = false;
        btn.textContent = '🚀 Kirim Blast WA Sekarang';
        document.getElementById('popup-blast-msg').textContent = 'Terjadi kesalahan saat blast.';
        document.getElementById('popup-blast-result').style.display = 'flex';
    });
}
</script>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success">
  <i class="fas fa-check-circle"></i>
  <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<!-- ===== STYLES ===== -->
<style>
/* ---------- Countdown Banner ---------- */
.countdown-banner {
  background: linear-gradient(135deg, #1a56db, #0f172a);
  border-radius: 14px;
  padding: 20px 24px;
  margin-bottom: 24px;
  color: #fff;
  display: flex;
  align-items: center;
  gap: 20px;
  flex-wrap: wrap;
}
.cd-info {
  flex: 1;
  min-width: 160px;
}
.cd-info .cd-eyebrow {
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 1px;
  color: rgba(255,255,255,.6);
  margin-bottom: 4px;
}
.cd-info .cd-date {
  font-size: 20px;
  font-weight: 800;
  font-family: 'Poppins', sans-serif;
}
.cd-info .cd-time {
  font-size: 13px;
  color: rgba(255,255,255,.7);
  margin-top: 2px;
}
.cd-boxes {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}
.cd-box {
  background: rgba(255,255,255,.1);
  border-radius: 10px;
  padding: 10px 14px;
  text-align: center;
  border: 1px solid rgba(255,255,255,.2);
  min-width: 58px;
}
.cd-box .cd-num {
  display: block;
  font-size: 24px;
  font-weight: 800;
  font-family: 'Poppins', sans-serif;
  line-height: 1;
}
.cd-box .cd-lbl {
  font-size: 10px;
  color: rgba(255,255,255,.6);
  text-transform: uppercase;
  letter-spacing: .5px;
  margin-top: 3px;
  display: block;
}
.cd-btn {
  background: rgba(255,255,255,.15);
  color: #fff;
  border: 1px solid rgba(255,255,255,.3);
  padding: 8px 16px;
  border-radius: 8px;
  font-size: 13px;
  text-decoration: none;
  white-space: nowrap;
  display: inline-flex;
  align-items: center;
  gap: 6px;
  align-self: center;
  transition: background .2s;
}
.cd-btn:hover {
  background: rgba(255,255,255,.25);
  color: #fff;
  text-decoration: none;
}

/* ---------- Stats Grid ---------- */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 14px;
  margin-bottom: 24px;
}
.stat-card {
  background: var(--white, #fff);
  border: 1px solid var(--border, #e2e8f0);
  border-radius: 12px;
  padding: 16px;
  display: flex;
  align-items: center;
  gap: 12px;
  min-width: 0;
}
.stat-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  flex-shrink: 0;
}
.stat-icon.blue   { background: #eff6ff; color: #1d4ed8; }
.stat-icon.green  { background: #f0fdf4; color: #15803d; }
.stat-icon.orange { background: #fff7ed; color: #c2410c; }
.stat-icon.purple { background: #f5f3ff; color: #7c3aed; }
.stat-icon.red    { background: #fff1f2; color: #be123c; }
.stat-info { min-width: 0; }
.stat-value {
  font-size: 22px;
  font-weight: 800;
  line-height: 1.1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.stat-label {
  font-size: 12px;
  color: var(--text-muted, #64748b);
  margin-top: 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* ---------- Progress Card ---------- */
.progress-card {
  background: var(--white, #fff);
  border: 1px solid var(--border, #e2e8f0);
  border-radius: 12px;
  padding: 16px 20px;
  margin-bottom: 24px;
}
.progress-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
  flex-wrap: wrap;
  gap: 6px;
}
.progress-header span {
  font-size: 13px;
  font-weight: 700;
}
.progress-header .pct {
  font-size: 13px;
  color: var(--text-muted, #64748b);
}
.progress-track {
  background: #f1f5f9;
  border-radius: 99px;
  height: 12px;
  overflow: hidden;
}
.progress-fill {
  background: linear-gradient(90deg, #10b981, #3b82f6);
  height: 100%;
  border-radius: 99px;
  transition: width 1s ease;
}
.progress-legend {
  display: flex;
  gap: 16px;
  margin-top: 10px;
  font-size: 12px;
  flex-wrap: wrap;
}
.progress-legend span {
  display: flex;
  align-items: center;
  gap: 5px;
}

/* ---------- Bottom Two-Column ---------- */
.bottom-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}

/* ---------- Card (generic) ---------- */
.card {
  background: var(--white, #fff);
  border: 1px solid var(--border, #e2e8f0);
  border-radius: 12px;
  overflow: hidden;
}
.card-header {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 14px 18px;
  border-bottom: 1px solid var(--border, #e2e8f0);
  flex-wrap: wrap;
}
.card-title {
  font-size: 14px;
  font-weight: 700;
  flex: 1;
  min-width: 0;
}
.btn-sm {
  font-size: 12px;
  padding: 5px 12px;
  border: 1px solid var(--border, #e2e8f0);
  border-radius: 7px;
  background: transparent;
  color: var(--text-muted, #64748b);
  cursor: pointer;
  text-decoration: none;
  white-space: nowrap;
}
.btn-sm:hover { background: #f8fafc; color: #334155; text-decoration: none; }

/* ---------- Table ---------- */
.table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
.table-wrap table {
  width: 100%;
  border-collapse: collapse;
  font-size: 13px;
  min-width: 280px;
}
.table-wrap th {
  text-align: left;
  padding: 10px 14px;
  font-size: 11px;
  font-weight: 600;
  color: var(--text-muted, #64748b);
  text-transform: uppercase;
  letter-spacing: .4px;
  border-bottom: 1px solid var(--border, #e2e8f0);
  white-space: nowrap;
}
.table-wrap td {
  padding: 10px 14px;
  border-bottom: 1px solid #f1f5f9;
  vertical-align: middle;
}
.table-wrap tr:last-child td { border-bottom: none; }
.student-name { font-weight: 600; font-size: 13px; }
.student-nisn  { font-size: 11px; color: var(--text-muted, #64748b); margin-top: 1px; }

/* ---------- Badges ---------- */
.badge {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  font-size: 11px;
  padding: 3px 8px;
  border-radius: 99px;
  font-weight: 600;
  white-space: nowrap;
}
.badge-success  { background: #dcfce7; color: #166534; }
.badge-warning  { background: #fef9c3; color: #854d0e; }
.badge-secondary{ background: #f1f5f9; color: #475569; }

/* ---------- Activity Log ---------- */
.log-list { padding: 0; }
.log-item {
  padding: 12px 18px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  gap: 12px;
  align-items: flex-start;
}
.log-item:last-child { border-bottom: none; }
.log-avatar {
  width: 34px;
  height: 34px;
  border-radius: 9px;
  background: #eff6ff;
  color: #1d4ed8;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 13px;
  flex-shrink: 0;
}
.log-body { flex: 1; min-width: 0; }
.log-name  { font-size: 13px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.log-aksi  { font-size: 12px; color: var(--text-muted, #64748b); margin-top: 1px; }
.log-time  { font-size: 11px; color: #b0bec5; margin-top: 3px; }

/* =============================================
   RESPONSIVE BREAKPOINTS
   ============================================= */

/* Tablet landscape (≤ 1200px) — 4 kolom stat */
@media (max-width: 1200px) {
  .stats-grid {
    grid-template-columns: repeat(4, 1fr);
  }
}

/* Tablet portrait (≤ 900px) — 3 kolom stat, bottom grid masih 2 col */
@media (max-width: 900px) {
  .stats-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

/* Tablet kecil / phablet (≤ 768px) — bottom grid jadi 1 kolom */
@media (max-width: 768px) {
  .bottom-grid {
    grid-template-columns: 1fr;
  }
  .countdown-banner {
    padding: 16px 18px;
    gap: 14px;
  }
  .cd-info .cd-date {
    font-size: 17px;
  }
  .cd-box .cd-num {
    font-size: 20px;
  }
}

/* Mobile (≤ 600px) — 2 kolom stat, layout vertikal penuh */
@media (max-width: 600px) {
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
  }
  .stat-card.full-width {
    grid-column: 1 / -1;
  }
  .stat-card {
    padding: 12px;
    gap: 10px;
  }
  .stat-icon {
    width: 34px;
    height: 34px;
    font-size: 14px;
  }
  .stat-value {
    font-size: 18px;
  }
  .stat-label {
    font-size: 11px;
  }

  /* Countdown: susun vertikal */
  .countdown-banner {
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
    padding: 14px 16px;
  }
  .cd-boxes {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 8px;
  }
  .cd-box {
    min-width: 0;
    padding: 8px 6px;
  }
  .cd-box .cd-num {
    font-size: 18px;
  }
  .cd-btn {
    justify-content: center;
    width: 100%;
  }

  /* Progress */
  .progress-card {
    padding: 14px 16px;
  }
  .progress-header {
    flex-direction: row;
    align-items: center;
    justify-content: space-between;
    gap: 6px;
  }
}

/* Mobile kecil (≤ 400px) — stat 1 kolom */
@media (max-width: 400px) {
  .stats-grid {
    grid-template-columns: 1fr 1fr;
  }
  .stat-value {
    font-size: 16px;
  }
}
</style>

<!-- ===== COUNTDOWN BANNER ===== -->
<div class="countdown-banner">
  <div class="cd-info">
    <div class="cd-eyebrow">Pengumuman Kelulusan</div>
    <div class="cd-date"><?= $tgl ?></div>
    <div class="cd-time">Pukul <?= $jam ?> WIB</div>
  </div>

  <div id="countdown" class="cd-boxes">
    <div class="cd-box"><span class="cd-num" id="cd-d">00</span><span class="cd-lbl">Hari</span></div>
    <div class="cd-box"><span class="cd-num" id="cd-h">00</span><span class="cd-lbl">Jam</span></div>
    <div class="cd-box"><span class="cd-num" id="cd-m">00</span><span class="cd-lbl">Menit</span></div>
    <div class="cd-box"><span class="cd-num" id="cd-s">00</span><span class="cd-lbl">Detik</span></div>
  </div>

  <a href="<?= site_url('admin/profil') ?>" class="cd-btn">
    <i class="fas fa-cog"></i> Atur Jadwal
  </a>
</div>

<!-- ===== STATS GRID ===== -->
<div class="stats-grid">
  <div class="stat-card full-width">
    <div class="stat-icon blue"><i class="fas fa-users"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= number_format($total_siswa) ?></div>
      <div class="stat-label">Total Siswa</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= number_format($total_lulus) ?></div>
      <div class="stat-label">Lulus</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-exclamation-circle"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= number_format($total_bersyarat) ?></div>
      <div class="stat-label">Bersyarat</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="fas fa-car"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= number_format($total_to) ?></div>
      <div class="stat-label">TO</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red"><i class="fas fa-network-wired"></i></div>
    <div class="stat-info">
      <div class="stat-value"><?= number_format($total_tkj) ?></div>
      <div class="stat-label">TJKT</div>
    </div>
  </div>
</div>

<!-- ===== PROGRESS BAR ===== -->
<?php if ($total_siswa > 0): ?>
<?php $pct = round(($total_lulus / $total_siswa) * 100, 1); ?>
<div class="progress-card">
  <div class="progress-header">
    <span>Persentase Kelulusan</span>
    <span class="pct"><?= $pct ?>% Lulus</span>
  </div>
  <div class="progress-track">
    <div class="progress-fill" style="width:<?= $pct ?>%"></div>
  </div>
  <div class="progress-legend">
    <span><i class="fas fa-circle" style="color:#10b981;font-size:9px"></i> Lulus: <?= number_format($total_lulus) ?></span>
    <span><i class="fas fa-circle" style="color:#f59e0b;font-size:9px"></i> Bersyarat: <?= number_format($total_bersyarat) ?></span>
  </div>
</div>
<?php endif; ?>

<!-- ===== BOTTOM GRID ===== -->
<div class="bottom-grid">

  <!-- Siswa Terbaru -->
  <div class="card">
    <div class="card-header">
      <i class="fas fa-clock" style="color:var(--primary,#1a56db)"></i>
      <span class="card-title">Data Siswa Terbaru</span>
      <a href="<?= site_url('admin/siswa') ?>" class="btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($siswa_terbaru): foreach ($siswa_terbaru as $s): ?>
          <tr>
            <td>
              <div class="student-name"><?= htmlspecialchars($s->nama_siswa) ?></div>
              <div class="student-nisn"><?= htmlspecialchars($s->nisn) ?></div>
            </td>
            <td><span class="badge badge-secondary"><?= htmlspecialchars($s->kelas) ?></span></td>
            <td>
              <?php if ($s->kelulusan == 'Lulus'): ?>
                <span class="badge badge-success"><i class="fas fa-check"></i> Lulus</span>
              <?php else: ?>
                <span class="badge badge-warning"><i class="fas fa-exclamation"></i> Bersyarat</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; else: ?>
          <tr>
            <td colspan="3" style="text-align:center;color:var(--text-muted,#64748b);padding:28px 14px">
              Belum ada data
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Log Aktivitas -->
  <div class="card">
    <div class="card-header">
      <i class="fas fa-history" style="color:var(--primary,#1a56db)"></i>
      <span class="card-title">Aktivitas Terakhir</span>
      <a href="<?= site_url('admin/log') ?>" class="btn-sm">Lihat Semua</a>
    </div>
    <div class="log-list">
      <?php if ($log_terbaru): foreach ($log_terbaru as $l): ?>
      <div class="log-item">
        <div class="log-avatar"><i class="fas fa-user"></i></div>
        <div class="log-body">
          <div class="log-name"><?= htmlspecialchars($l->nama_lengkap ?? 'Sistem') ?></div>
          <div class="log-aksi"><?= htmlspecialchars($l->aksi) ?></div>
          <div class="log-time">
            <i class="fas fa-clock" style="font-size:10px"></i>
            <?php
              $ts_log = strtotime($l->created_at);
              echo date('d', $ts_log) . ' ' . $bulan_id[(int) date('n', $ts_log)] . ' ' . date('Y H:i', $ts_log);
              ?>
          </div>
        </div>
      </div>
      <?php endforeach; else: ?>
      <div style="text-align:center;color:var(--text-muted,#64748b);padding:36px 18px">
        Belum ada aktivitas
      </div>
      <?php endif; ?>
    </div>
  </div>

</div><!-- /bottom-grid -->

<!-- POPUP KONFIRMASI BLAST WA -->
<div id="popup-blast" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);z-index:999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:16px;padding:32px 28px;max-width:360px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.15);">
    <div style="width:52px;height:52px;border-radius:50%;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;">
      📲
    </div>
    <div style="font-size:16px;font-weight:700;color:#111827;margin-bottom:8px">Kirim Blast WhatsApp?</div>
    <div style="font-size:13px;color:#64748b;line-height:1.7;margin-bottom:24px">Notifikasi akan dikirim ke <strong id="popup-blast-total">0</strong> nomor WA terdaftar.</div>
    <div style="display:flex;gap:10px;">
      <button onclick="konfirmasiBlast()" style="flex:1;padding:11px;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;">
        Kirim
      </button>
      <button onclick="document.getElementById('popup-blast').style.display='none'" style="flex:1;padding:11px;background:#f1f5f9;color:#475569;border:none;border-radius:8px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;">
        Batal
      </button>
    </div>
  </div>
</div>

<!-- POPUP HASIL BLAST WA -->
<div id="popup-blast-result" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);z-index:999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:16px;padding:32px 28px;max-width:360px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.15);">
    <div style="width:52px;height:52px;border-radius:50%;background:#f0fdf4;border:1px solid #bbf7d0;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:22px;">
      ✅
    </div>
    <div style="font-size:16px;font-weight:700;color:#111827;margin-bottom:8px">Blast Selesai!</div>
    <div style="font-size:13px;color:#64748b;line-height:1.7;margin-bottom:24px" id="popup-blast-msg">-</div>
    <button onclick="document.getElementById('popup-blast-result').style.display='none'" style="width:100%;padding:12px;background:linear-gradient(135deg,#16a34a,#22c55e);color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit">
      OK
    </button>
  </div>
</div>

<!-- ===== COUNTDOWN SCRIPT ===== -->
<script>
(function () {
  var targetDate = new Date(
    '<?= $profil->tanggal_pengumuman ?? '2025-05-02' ?>T<?= $profil->jam_pengumuman ?? '10:00:00' ?>'
  ).getTime();

  function pad(n) { return String(n).padStart(2, '0'); }

  function tick() {
    var diff = targetDate - Date.now();
    if (diff <= 0) {
      document.getElementById('countdown').innerHTML =
        '<div style="font-size:16px;font-weight:700;color:#4ade80;padding:4px 0">🎉 Pengumuman Telah Dibuka!</div>';
      return;
    }
    var d = Math.floor(diff / 86400000);
    var h = Math.floor((diff % 86400000) / 3600000);
    var m = Math.floor((diff % 3600000) / 60000);
    var s = Math.floor((diff % 60000) / 1000);
    document.getElementById('cd-d').textContent = pad(d);
    document.getElementById('cd-h').textContent = pad(h);
    document.getElementById('cd-m').textContent = pad(m);
    document.getElementById('cd-s').textContent = pad(s);
  }

  tick();
  setInterval(tick, 1000);
})();
</script>
<!-- POPUP SELAMAT DATANG -->
<div id="popup-welcome" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);backdrop-filter:blur(4px);z-index:999;align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:20px;padding:36px 32px;max-width:380px;width:90%;text-align:center;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:fadeUp .4s ease both">
    <div style="width:64px;height:64px;border-radius:50%;background:linear-gradient(135deg,#eff6ff,#dbeafe);border:2px solid #bfdbfe;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px">
      👋
    </div>
    <div style="font-size:13px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:1px;margin-bottom:6px">Selamat Datang</div>
    <div style="font-size:22px;font-weight:800;color:#0f172a;margin-bottom:4px"><?= htmlspecialchars($user['nama_lengkap'] ?? '') ?></div>
    <div style="font-size:13px;color:#64748b;margin-bottom:6px">
      <span style="display:inline-flex;align-items:center;gap:5px;background:#f1f5f9;padding:3px 12px;border-radius:20px;font-size:12px;font-weight:600;color:#475569">
        <i class="fas fa-shield-alt" style="color:#1a56db;font-size:11px"></i>
        <?= ucfirst($user['role'] ?? '') ?>
      </span>
    </div>
    <div style="font-size:12.5px;color:#94a3b8;margin-top:10px;margin-bottom:24px">
      Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?>
    </div>
    <button onclick="tutupWelcome()" style="width:100%;padding:13px;background:linear-gradient(135deg,#1a56db,#3b82f6);color:#fff;border:none;border-radius:10px;font-size:14px;font-weight:700;cursor:pointer;font-family:inherit;transition:all .2s">
      <i class="fas fa-sign-in-alt"></i> Mulai Kelola
    </button>
  </div>
</div>

<style>
@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to   { opacity: 1; transform: translateY(0); }
}
</style>

<script>
function tutupWelcome() {
  document.getElementById('popup-welcome').style.display = 'none';
}

var justLoggedIn = <?= $this->session->flashdata('just_logged_in') ? 'true' : 'false' ?>;
if (justLoggedIn) {
  document.getElementById('popup-welcome').style.display = 'flex';
}
</script>