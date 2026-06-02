<?php
function tgl_indonesia($tanggal) {
    $bulan = [
        1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
        5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
        9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
    ];
    $t = strtotime($tanggal);
    return date('d', $t) . ' ' . $bulan[(int)date('n', $t)] . ' ' . date('Y', $t);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hasil Kelulusan — <?= htmlspecialchars($profil->nama_sekolah ?? 'SMK') ?></title>
<link rel="icon" type="image/png" href="<?= base_url('uploads/pbr.png') ?>">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Poppins',sans-serif;background:#f1f5f9;color:#1e293b;min-height:100vh}

/* NAVBAR */
.navbar{background:rgba(255,255,255,.95);backdrop-filter:blur(12px);border-bottom:1px solid #e2e8f0;padding:12px 0;position:sticky;top:0;z-index:50}
.nav-inner{max-width:800px;margin:0 auto;padding:0 20px;display:flex;align-items:center;gap:12px}
.nav-logo{display:flex;align-items:center;gap:10px;text-decoration:none}
.nav-logo img{width:34px;height:34px;border-radius:8px;object-fit:contain}
.nav-logo-name{font-size:13px;font-weight:700;color:#0f172a}
.back-btn{display:flex;align-items:center;gap:6px;padding:7px 14px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;color:#64748b;text-decoration:none;font-size:12.5px;font-weight:600;margin-left:auto;transition:all .2s}
.back-btn:hover{background:#fff;color:#1e293b}

/* WRAP */
.result-wrap{max-width:680px;margin:0 auto;padding:28px 16px 60px}

/* CARD */
.card{background:#fff;border-radius:16px;overflow:hidden;border:1px solid #e2e8f0;box-shadow:0 2px 16px rgba(0,0,0,.07);margin-bottom:16px}

/* STATUS BANNER */
.status-banner{padding:28px 24px;text-align:center;position:relative}
.status-banner.lulus{background:linear-gradient(135deg,#064e3b 0%,#065f46 50%,#047857 100%)}
.status-banner.bersyarat{background:linear-gradient(135deg,#78350f,#92400e,#b45309)}
.status-label{font-size:10px;letter-spacing:2px;text-transform:uppercase;color:rgba(255,255,255,.7);margin-bottom:8px}
.status-text{font-size:clamp(22px,5vw,32px);font-weight:800;color:#fff;letter-spacing:2px;line-height:1.2}
.status-sub{font-size:12px;color:rgba(255,255,255,.65);margin-top:8px;line-height:1.6}
.status-badge{display:inline-block;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);color:#fff;font-size:10px;font-weight:700;letter-spacing:1px;padding:3px 12px;border-radius:20px;margin-top:10px}

/* SECTION TITLE */
.section-title{font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#64748b;padding:14px 20px 8px;border-bottom:1px solid #f1f5f9}

/* ID TABLE */
.id-table{width:100%;border-collapse:collapse;font-size:13px}
.id-table tr{border-bottom:1px solid #f1f5f9}
.id-table tr:last-child{border-bottom:none}
.id-table td{padding:10px 20px;vertical-align:top}
.id-table .lbl{color:#94a3b8;white-space:nowrap;font-size:12px;padding-right:4px;vertical-align:top}
.id-table .sep{color:#cbd5e1;padding:10px 4px;white-space:nowrap;vertical-align:top}
.id-table .val{font-weight:600;color:#1e293b;font-size:13px}

/* KELULUSAN BOX */
.kelulusan-box{padding:20px 24px;text-align:center}
.kelulusan-box.lulus{background:#f0fdf4;border-top:1px solid #d1fae5}
.kelulusan-box.bersyarat{background:#fffbeb;border-top:1px solid #fde68a}
.kelulusan-big{font-size:clamp(32px,8vw,42px);font-weight:800;letter-spacing:4px;line-height:1}
.kelulusan-big.lulus{color:#059669}
.kelulusan-big.bersyarat{color:#d97706}
.kelulusan-tp{font-size:11.5px;color:#6b7280;margin-top:6px}

/* MSG BOX */
.msg-box{margin:12px 16px;padding:12px 16px;border-radius:10px;font-size:12.5px;line-height:1.8;text-align:center}
.msg-box.lulus{background:#ecfdf5;border:1px solid #a7f3d0;border-top:3px solid #10b981;color:#065f46}
.msg-box.bersyarat{background:#fffbeb;border:1px solid #fde68a;border-top:3px solid #f59e0b;color:#92400e}

/* NOTE BOX */
.note-box{margin:0 16px 16px;background:#fafafa;border:1px solid #e2e8f0;border-radius:10px;padding:12px 16px;font-size:11.5px;color:#64748b;line-height:1.8;text-align:center}
.note-box strong{color:#475569}

/* UNDANGAN CARD */
.undangan-card{background:#fff;border-radius:16px;overflow:hidden;border:2px solid #fde68a;box-shadow:0 2px 16px rgba(245,158,11,.1);margin-bottom:16px}
.undangan-header{background:linear-gradient(135deg,#fffbeb,#fef3c7);padding:14px 20px;border-bottom:1px solid #fde68a;display:flex;align-items:center;gap:10px}
.undangan-title{font-size:12px;font-weight:800;color:#a16207;text-transform:uppercase;letter-spacing:.5px}
.undangan-body{padding:16px 20px}
.undangan-intro{font-size:13px;color:#1e293b;line-height:1.8;margin-bottom:16px;padding:12px 14px;background:#fffbeb;border-radius:8px;border-left:3px solid #f59e0b;text-align:center}
.jadwal-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px}
.jadwal-item{background:#f8fafc;border-radius:10px;padding:12px 14px;border:1px solid #e2e8f0}
.jadwal-item.highlight{background:#fffbeb;border-color:#fde68a}
.jadwal-item.full{grid-column:1/-1}
.jadwal-label{font-size:10px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.5px;margin-bottom:4px}
.jadwal-value{font-size:13.5px;font-weight:700;color:#1e293b}
.jadwal-item.highlight .jadwal-value{color:#a16207}
.wajib-badge{display:inline-flex;align-items:center;gap:5px;background:#fef2f2;color:#dc2626;border:1px solid #fecaca;padding:3px 10px;border-radius:6px;font-size:11px;font-weight:700}
.undangan-footer{font-size:12px;color:#64748b;padding:12px 14px;background:#f8fafc;border-radius:8px;border:1px solid #e2e8f0;line-height:1.7;font-style:italic;text-align:center}

/* BUTTONS */
.btn-row{display:flex;gap:10px;padding:0 16px 16px;flex-wrap:wrap}
.btn{flex:1;min-width:140px;display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:700;text-decoration:none;border:none;cursor:pointer;font-family:inherit;transition:all .2s}
.btn-primary{background:linear-gradient(135deg,#059669,#10b981);color:#fff}
.btn-primary:hover{transform:translateY(-1px);box-shadow:0 6px 16px rgba(16,185,129,.35)}
.btn-secondary{background:#f8fafc;border:1.5px solid #e2e8f0;color:#64748b}
.btn-secondary:hover{background:#fff;color:#1e293b}

@media(max-width:480px){
  .id-table .lbl{width:32%;font-size:11px}
  .id-table .sep{width:6%;padding-left:0;padding-right:0}
  .id-table .val{font-size:12px}
  .jadwal-grid{grid-template-columns:1fr}
  .jadwal-item.full{grid-column:1}
  .result-wrap{padding:20px 12px 40px}
}
</style>
</head>
<body>

<nav class="navbar">
  <div class="nav-inner">
    <a href="<?= site_url('/') ?>" class="nav-logo">
      <img src="<?= base_url('uploads/pbr.png') ?>" alt="Logo">
      <span class="nav-logo-name"><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK') ?></span>
    </a>
    <a href="<?= site_url('/') ?>" class="back-btn"><i class="fas fa-arrow-left"></i> Kembali</a>
  </div>
</nav>

<div class="result-wrap">

  <!-- STATUS BANNER -->
  <div class="card">
    <?php if ($siswa->kelulusan == 'Lulus'): ?>
    <div class="status-banner lulus">
      <div class="status-label">Pengumuman Resmi Kelulusan</div>
      <div style="font-size:35px;margin-bottom:5px">🎉</div>
      <div class="status-text">SELAMAT, KAMU LULUS!</div>
      <div class="status-sub">Tetap semangat dan optimis dalam menjalani kehidupan ke depan!</div>
      <div class="status-badge">✓ &nbsp;Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>
    <?php else: ?>
    <div class="status-banner bersyarat">
      <div class="status-label">Pengumuman Resmi Kelulusan</div>
      <div style="font-size:35px;margin-bottom:5px">📋</div>
      <div class="status-text">SURAT UNDANGAN</div>
      <div class="status-sub">Undangan Koordinasi Kelulusan</div>
      <div class="status-badge">✓ &nbsp;Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>
    <?php endif; ?>

    <!-- IDENTITAS -->
    <div class="section-title">Identitas Peserta Didik</div>
    <?php if ($siswa->kelulusan == 'Lulus Bersyarat'): ?>
    <p style="font-size:12.5px;color:#64748b;padding:8px 20px;border-bottom:1px solid #f1f5f9">
        Mengundang dengan hormat siswa dengan identitas sebagai berikut:
    </p>
    <?php endif; ?>
    <table class="id-table">
      <tr>
        <td class="lbl">Nama Lengkap</td>
        <td class="sep">:</td>
        <td class="val"><?= htmlspecialchars($siswa->nama_siswa) ?></td>
      </tr>
      <tr>
        <td class="lbl">NISN</td>
        <td class="sep">:</td>
        <td class="val"><?= htmlspecialchars($siswa->nisn) ?></td>
      </tr>
      <tr>
        <td class="lbl">Kelas</td>
        <td class="sep">:</td>
        <td class="val"><?= htmlspecialchars($siswa->kelas) ?></td>
      </tr>
      <tr>
        <td class="lbl">Tempat / Tgl. Lahir</td>
        <td class="sep">:</td>
        <td class="val"><?= htmlspecialchars($siswa->tempat_lahir) ?>, <?= tgl_indonesia($siswa->tanggal_lahir) ?></td>
      </tr>
      <tr>
        <td class="lbl">Jurusan</td>
        <td class="sep">:</td>
        <td class="val"><?= htmlspecialchars($siswa->jurusan) ?></td>
      </tr>
      <tr>
        <td class="lbl">Asal Sekolah</td>
        <td class="sep">:</td>
        <td class="val"><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></td>
      </tr>
    </table>

    <!-- STATUS KELULUSAN -->
    <?php if ($siswa->kelulusan == 'Lulus'): ?>
    <div class="section-title">Status Kelulusan Dinyatakan</div>
    <div class="kelulusan-box lulus">
      <div class="kelulusan-big lulus">LULUS</div>
      <div class="kelulusan-tp">Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>
    <div class="msg-box lulus">
      Apapun hasil yang didapat, semoga ini adalah yang terbaik, tetap semangat dan optimis dalam menjalani kehidupan ke depan!
    </div>
    <?php else: ?>
    <div class="kelulusan-box bersyarat">
      <div style="font-size:15px;font-weight:800;color:#b45309">
        <i class="fas fa-exclamation-triangle" style="margin-right:8px"></i>WAJIB HADIR BESERTA ORANG TUA / WALI
      </div>
    </div>
    <?php endif; ?>

  <!-- UNDANGAN BERSYARAT -->
  <?php if ($siswa->kelulusan == 'Lulus Bersyarat'): ?>
  <div style="border-top:1px solid #fde68a;margin-top:4px">
    <div class="section-title">
      Detail Undangan
    </div>
    <div class="undangan-body">
      <table class="id-table">
        <tr>
          <td class="lbl" style="width:38%">Hari / Tanggal</td>
          <td class="sep">:</td>
          <td class="val">
            <?php
            if ($siswa->tanggal_hadir) {
              $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
              echo $hari[date('w', strtotime($siswa->tanggal_hadir))] . ', ' . tgl_indonesia($siswa->tanggal_hadir);
            } else {
              echo 'Akan dikonfirmasi';
            }
            ?>
          </td>
        </tr>
        <tr>
          <td class="lbl">Pukul</td>
          <td class="sep">:</td>
          <td class="val"><?= $siswa->pukul_hadir ? date('H:i', strtotime($siswa->pukul_hadir)) . ' WIB' : 'Akan dikonfirmasi' ?></td>
        </tr>
        <tr>
          <td class="lbl">Tempat</td>
          <td class="sep">:</td>
          <td class="val"><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></td>
        </tr>
        <tr>
          <td class="lbl">Agenda</td>
          <td class="sep">:</td>
          <td class="val">Koordinasi Pemenuhan Syarat Kelulusan</td>
        </tr>
        <tr>
          <td class="lbl">Sifat</td>
          <td class="sep">:</td>
          <td class="val">
            <span class="wajib-badge"><i class="fas fa-exclamation-circle"></i> WAJIB HADIR</span>
          </td>
        </tr>
      </table>
      <div class="undangan-footer">
        <i class="fas fa-info-circle" style="color:#f59e0b;margin-right:4px"></i>
        Karena pentingnya agenda tersebut dimohon untuk hadir tepat waktu. Ketidakhadiran tanpa keterangan yang jelas dapat mempengaruhi proses pemenuhan syarat kelulusan.
      </div>
    </div>
  </div>
  <?php endif; ?>
  </div>
  <!-- MSG & NOTE untuk Lulus -->
  <?php if ($siswa->kelulusan == 'Lulus'): ?>
  <div class="note-box" style="margin:0 0 16px">
    <strong><i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:4px"></i> Catatan Penting:</strong>
    Jika ada perbedaan data pengumuman online dan manual, maka yang menjadi acuan adalah
    <strong>dokumen asli Kelulusan</strong> yang telah disahkan, ditandatangani oleh Kepala Sekolah
    <strong><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></strong> dan diberi cap basah sekolah.
  </div>
  <?php endif; ?>
  <!-- NOTE BOX di luar card -->
  <?php if ($siswa->kelulusan == 'Lulus Bersyarat'): ?>
  <div class="note-box" style="margin:0 0 16px">
    <strong><i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:4px"></i> Catatan Penting:</strong>
    Jika ada perbedaan data pengumuman online dan manual, maka yang menjadi acuan adalah
    <strong>dokumen asli Kelulusan</strong> yang telah disahkan, ditandatangani oleh Kepala Sekolah
    <strong><?= htmlspecialchars($profil->nama_sekolah ?? 'SMK Panca Bhakti Rakit') ?></strong> dan diberi cap basah sekolah.
  </div>
  <?php endif; ?>

  <!-- BUTTONS -->
<div class="card">
  <div style="display:flex;flex-direction:column;gap:10px;padding:16px">
    <?php if ($siswa->kelulusan == 'Lulus Bersyarat'): ?>
    <a href="<?= site_url('cetak/'.$siswa->nisn) ?>" class="btn btn-primary" target="_blank" style="width:100%">
      <i class="fas fa-print"></i> Cetak Surat Undangan
    </a>
    <?php else: ?>
    <a href="<?= site_url('cetak/'.$siswa->nisn) ?>" class="btn btn-primary" target="_blank" style="width:100%">
      <i class="fas fa-print"></i> Cetak Bukti Kelulusan
    </a>
    <?php endif; ?>
    <a href="<?= site_url('/') ?>" class="btn btn-secondary" style="width:100%">
      <i class="fas fa-home"></i> Kembali
    </a>
  </div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const elements = document.querySelectorAll('.card, .undangan-card');
  elements.forEach((el, i) => {
    el.style.opacity = '0';
    el.style.transform = 'translateY(16px)';
    el.style.transition = 'opacity .35s ease, transform .35s ease';
    setTimeout(() => {
      el.style.opacity = '1';
      el.style.transform = 'translateY(0)';
    }, i * 80 + 50);
  });
});
</script>
</body>
</html>