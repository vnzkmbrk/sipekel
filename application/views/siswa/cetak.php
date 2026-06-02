<!DOCTYPE html>
<html lang="id">
<head>
<?php
function tgl_indonesia($tanggal) {
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];
    $ts = strtotime($tanggal);
    return date('d', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cetak — <?= htmlspecialchars($siswa->nama_siswa) ?></title>
<link rel="icon" type="image/png" href="<?= base_url('uploads/pbr.png') ?>">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Poppins',sans-serif;background:#f1f5f9;padding:24px 16px;min-height:100vh}

/* Toolbar */
.toolbar{max-width:720px;margin:0 auto 20px;display:flex;align-items:center;gap:10px;flex-wrap:wrap;background:transparent}
.btn-print{display:inline-flex;align-items:center;gap:8px;padding:10px 22px;background:#1a56db;color:#fff;border:none;border-radius:10px;font-size:13.5px;font-weight:700;cursor:pointer;font-family:inherit;transition:all .2s;box-shadow:0 4px 12px rgba(26,86,219,.3)}
.btn-print:hover{background:#1340a8;transform:translateY(-1px)}
.btn-back{display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:#fff;color:#374151;border:1.5px solid #e2e8f0;border-radius:10px;font-size:13px;font-weight:600;text-decoration:none;font-family:inherit;transition:all .2s}
.btn-back:hover{background:#f8fafc;border-color:#cbd5e1}
.toolbar-note{font-size:11.5px;color:#94a3b8;margin-left:auto;display:flex;align-items:center;gap:6px}

/* Paper */
.paper{max-width:720px;margin:0 auto;background:#fff;border-radius:16px;box-shadow:0 8px 40px rgba(0,0,0,.1)}

/* KOP */
.kop-wrap{background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 100%);padding:28px 36px;display:flex;align-items:center;justify-content:center;gap:28px;border-radius:16px 16px 0 0;overflow:hidden}
.kop-logo-wrap{width:88px;height:88px;border-radius:50%;background:#fff;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:3px solid rgba(255,255,255,.2);overflow:hidden;box-shadow:0 4px 16px rgba(0,0,0,.3)}
.kop-logo-wrap img{width:76px;height:76px;object-fit:contain}
.kop-info{color:#fff;text-align:center;flex:1;max-width:500px}
.kop-yayasan{font-size:10.5px;font-weight:500;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px}
.kop-nama{font-size:18px;font-weight:800;color:#fff;line-height:1.25;text-transform:uppercase;letter-spacing:.3px}
.kop-divider{width:40px;height:2px;background:#1a56db;border-radius:2px;margin:10px auto}
.kop-detail{font-size:11px;color:rgba(255,255,255,.65);line-height:1.8}
.kop-detail span{margin-right:12px}

/* Paper Inner */
.paper-inner{padding:32px 36px}

/* Doc Title */
.doc-title{text-align:center;margin-bottom:28px;padding-bottom:20px;border-bottom:1px solid #f1f5f9}
.doc-title-badge{display:inline-flex;align-items:center;gap:6px;background:#eff6ff;color:#1d4ed8;padding:5px 14px;border-radius:20px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.8px;margin-bottom:10px}
.doc-title h2{font-size:17px;font-weight:800;color:#0f172a;margin-bottom:4px}
.doc-title .tpl{font-size:12px;color:#64748b}

/* Section Title */
.section-label{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.section-label-text{font-size:10.5px;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:.8px;white-space:nowrap}
.section-label-line{flex:1;height:1px;background:#e2e8f0}

/* ID Table */
.id-card{background:#f8fafc;border-radius:12px;padding:16px 20px;margin-bottom:24px;border:1px solid #e2e8f0}
.id-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
.id-row{display:flex;padding:6px 0;border-bottom:1px solid #e2e8f0}
.id-row:last-child{border-bottom:none}
.id-row-full{grid-column:1/-1}
.id-label{font-size:11px;color:#64748b;font-weight:500;width:130px;flex-shrink:0}
.id-sep{color:#94a3b8;margin:0 8px}
.id-value{font-size:12.5px;font-weight:700;color:#0f172a}

/* Status */
.status-lulus{background:linear-gradient(135deg,#f0fdf4,#dcfce7);border:1.5px solid #86efac;border-radius:14px;padding:24px;text-align:center;margin:20px 0}
.status-lulus-icon{width:56px;height:56px;background:#22c55e;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:24px;color:#fff;box-shadow:0 4px 16px rgba(34,197,94,.4)}
.status-lulus-text{font-size:26px;font-weight:900;color:#15803d;letter-spacing:2px;text-transform:uppercase}
.status-lulus-sub{font-size:12px;color:#16a34a;margin-top:4px}

.status-bersyarat{background:linear-gradient(135deg,#fffbeb,#fef9c3);border:1.5px solid #fde68a;border-radius:14px;padding:24px;text-align:center;margin:20px 0}
.status-bersyarat-icon{width:56px;height:56px;background:#f59e0b;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:24px;color:#fff;box-shadow:0 4px 16px rgba(245,158,11,.4)}
.status-bersyarat-text{font-size:22px;font-weight:900;color:#a16207;letter-spacing:1.5px;text-transform:uppercase}
.status-bersyarat-sub{font-size:12px;color:#b45309;margin-top:4px}

/* Undangan Table */
.undangan-table{width:100%;border-collapse:collapse;font-size:12.5px;margin:12px 0;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0}
.undangan-table td{padding:10px 14px;border-bottom:1px solid #e2e8f0;vertical-align:top}
.undangan-table tr:last-child td{border-bottom:none}
.undangan-table td:first-child{width:38%;background:#f8fafc;font-weight:600;color:#374151;font-size:12px}
.undangan-table td:nth-child(2){width:20px;background:#f8fafc;color:#94a3b8;padding-left:0;padding-right:0;text-align:center;font-weight:500}
.undangan-wajib{display:inline-flex;align-items:center;gap:4px;background:#fee2e2;color:#dc2626;font-weight:700;padding:3px 10px;border-radius:6px;font-size:11.5px}

/* Pesan */
.pesan{position:relative;font-size:12px;color:#475569;line-height:1.9;font-style:italic;text-align:center;padding:16px 24px;background:#f8fafc;border-radius:12px;border:1px solid #e2e8f0;margin:20px 0}
.pesan::before{content:'\201C';font-size:48px;color:#e2e8f0;font-family:Georgia,serif;position:absolute;top:-4px;left:12px;line-height:1;font-style:normal}

/* TTD */
.ttd-section{display:flex;justify-content:flex-end;margin-top:28px}
.ttd-box{text-align:center;min-width:220px;background:#f8fafc;border:1px solid #e2e8f0;border-radius:12px;padding:16px 24px}
.ttd-kota{font-size:12px;color:#64748b;margin-bottom:2px}
.ttd-jabatan{font-size:12.5px;font-weight:700;color:#0f172a;margin-bottom:8px}
.ttd-nama{font-size:13px;font-weight:800;color:#0f172a;border-bottom:2px solid #0f172a;padding-bottom:2px;display:inline-block;margin-bottom:4px}
.ttd-nip{font-size:11px;color:#64748b}
.ttd-img{height:70px;display:flex;align-items:center;justify-content:center;margin:8px auto}
.ttd-img img{height:70px;width:auto;max-width:150px;object-fit:contain}

/* Disclaimer */
.disclaimer{margin-top:20px;padding:12px 16px;background:#fffbeb;border:1px solid #fde68a;border-radius:8px;font-size:10.5px;color:#78350f;text-align:center;line-height:1.7}

/* Paper Footer */
.paper-footer{background:#0f172a;padding:12px 36px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;border-radius:0 0 16px 16px}
.paper-footer span{font-size:10.5px;color:rgba(255,255,255,.5)}
.paper-footer .footer-brand{display:flex;align-items:center;gap:8px}
.paper-footer .footer-dot{width:4px;height:4px;background:#1a56db;border-radius:50%}

.status-bersyarat { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 10px; padding: 10px 16px; margin: 12px 0; display: flex; align-items: center; justify-content: center; gap: 8px }
.status-bersyarat-icon,
.status-bersyarat-text { display: none }
.status-bersyarat-sub { font-size: 13px; font-weight: 700; color: #b45309; margin: 0; font-style: normal }
/* PRINT */
@page{margin:10mm}

@media print {
  body{background:#fff;padding:0}
  .toolbar{display:none}
  .paper{box-shadow:none;border-radius:0;max-width:none}
  .paper-inner{padding:6mm 14mm}
  .kop-wrap{padding:10px 14mm;-webkit-print-color-adjust:exact;print-color-adjust:exact;border-radius:0}
  .paper-footer{padding:6px 14mm;-webkit-print-color-adjust:exact;print-color-adjust:exact;border-radius:0}
  .status-lulus,.status-bersyarat,.id-card,.pesan,.disclaimer,.ttd-box{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .undangan-table td:first-child{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .ttd-section,.disclaimer{page-break-inside:avoid;break-inside:avoid}
  .pesan{page-break-inside:avoid;break-inside:avoid}
  .ttd-img{-webkit-print-color-adjust:exact;print-color-adjust:exact}
  .ttd-jabatan{margin-bottom:8px}

  /* Kurangi space antar elemen */
  .doc-title{margin-bottom:8px;padding-bottom:8px}
  .doc-title h2{font-size:14px}
  .doc-title-badge{font-size:10px;padding:3px 10px;margin-bottom:6px}
  .doc-title .tpl{font-size:11px}
  .id-card{margin-bottom:8px;padding:8px 14px}
  .id-row{padding:3px 0}
  .id-label{font-size:10px}
  .id-value{font-size:11px}
  .status-lulus,.status-bersyarat{margin:6px 0;padding:10px}
  .status-lulus-icon,.status-bersyarat-icon{width:36px;height:36px;font-size:16px;margin-bottom:6px}
  .status-lulus-text{font-size:18px}
  .status-lulus-sub,.status-bersyarat-sub{font-size:10px;margin-top:2px}
  .pesan{margin:8px 0;padding:10px 18px;font-size:11px}
  .ttd-section{margin-top:6px}
  .ttd-jabatan{margin-bottom:24px}
  .ttd-box{padding:10px 16px}
  .disclaimer{margin-top:6px;padding:8px 12px;font-size:9.5px;line-height:1.5}
  .section-label{margin-bottom:6px}
  .kop-detail{font-size:10px;line-height:1.6}
  .status-bersyarat { display: none }
}

/* Tablet */
@media (max-width: 768px) {
  .id-grid{grid-template-columns:1fr}
  .paper-inner{padding:24px 20px}
  .kop-wrap{padding:24px 20px;gap:20px}
}

/* Mobile */
@media (max-width: 600px) {
  body{padding:10px 6px}

  /* Toolbar */
  .toolbar{gap:8px;margin-bottom:14px}
  .btn-print{padding:9px 16px;font-size:12.5px}
  .btn-back{padding:9px 14px;font-size:12px}
  .toolbar-note{display:none}
  .btn-print,.btn-back{flex:1;justify-content:center}

  /* KOP */
  .kop-wrap{padding:20px 16px;gap:14px;flex-direction:column;align-items:center;text-align:center}
  .kop-logo-wrap{width:80px;height:80px}
  .kop-logo-wrap img{width:68px;height:68px}
  .kop-yayasan{font-size:9px;letter-spacing:.6px;margin-bottom:4px}
  .kop-nama{font-size:14px;line-height:1.35}
  .kop-divider{margin:8px auto}
  .kop-detail{font-size:10px;line-height:1.9}
  .kop-detail span{display:inline;margin-right:6px}

  /* Paper Inner */
  .paper-inner{padding:18px 14px}

  /* Doc Title */
  .doc-title{margin-bottom:20px;padding-bottom:16px}
  .doc-title h2{font-size:15px}
  .doc-title-badge{font-size:10px;padding:4px 11px}

  /* ID Card */
  .id-card{padding:12px 14px}
  .id-grid{grid-template-columns:1fr}
  .id-row-full{grid-column:1}
  .id-label{width:110px;font-size:10.5px}
  .id-value{font-size:12px}

  /* Status */
  .status-lulus,.status-bersyarat{padding:18px 14px}
  .status-lulus-icon,.status-bersyarat-icon{width:46px;height:46px;font-size:20px}
  .status-lulus-text{font-size:22px}
  .status-bersyarat-text{font-size:18px}

  /* Undangan Table */
  .undangan-table td{padding:8px 10px;font-size:11.5px}
  .undangan-table td:first-child{width:42%}

  /* Pesan */
  .pesan{padding:14px 16px 14px 20px;font-size:11.5px}
  .pesan::before{font-size:32px;top:-2px;left:8px}

  /* TTD */
  .ttd-section{justify-content:center}
  .ttd-box{min-width:0;width:100%;max-width:240px;padding:14px 18px}
  .ttd-jabatan{margin-bottom:15px}
  .ttd-nama{font-size:12px}

  /* Disclaimer */
  .disclaimer{font-size:10px;padding:10px 12px}

  /* Footer */
  .paper-footer{padding:10px 14px;flex-direction:column;align-items:center;gap:4px;text-align:center}
  .paper-footer span{font-size:10px}
}

/* Mobile XS */
@media (max-width: 360px) {
  .kop-nama{font-size:12px}
  .id-label{width:95px}
  .status-lulus-text{font-size:19px}
  .status-bersyarat-text{font-size:16px}
  .doc-title h2{font-size:13.5px}
}
/* ===== PDF EXPORT MODE ===== */
.pdf-mode .paper-inner        { padding: 14px 32px }
.pdf-mode .doc-title          { margin-bottom: 10px; padding-bottom: 10px }
.pdf-mode .id-card            { margin-bottom: 10px; padding: 8px 14px }
.pdf-mode .id-row             { padding: 3px 0 }
.pdf-mode .status-lulus,
.pdf-mode .status-bersyarat   { margin: 10px 0; padding: 14px }
.pdf-mode .status-lulus-icon,
.pdf-mode .status-bersyarat-icon { width: 40px; height: 40px; font-size: 18px; margin-bottom: 6px }
.pdf-mode .status-lulus-text  { font-size: 22px }
.pdf-mode .pesan              { margin: 10px 0; padding: 12px 18px; font-size: 11.5px }
.pdf-mode .ttd-section        { margin-top: 12px }
.pdf-mode .ttd-jabatan        { margin-bottom: 8px }
.pdf-mode .disclaimer         { margin-top: 10px; padding: 8px 12px }
.pdf-mode .section-label      { margin-bottom: 5px }
.pdf-mode .status-bersyarat   { background: #fffbeb; border: 1.5px solid #fde68a; border-radius: 10px; padding: 10px 16px; margin: 8px 0; display: flex; align-items: center; justify-content: center }
.pdf-mode .status-bersyarat-icon,
.pdf-mode .status-bersyarat-text { display: none }
.pdf-mode .status-bersyarat-sub { font-size: 13px; font-weight: 700; color: #b45309; margin: 0 }
.pdf-mode .undangan-table td  { padding: 6px 10px; font-size: 11.5px }
.pdf-mode .section-label[style] { margin-top: 8px !important }
.pdf-mode p[style]            { margin-bottom: 6px !important; font-size: 11.5px }
.pdf-mode .paper-footer       { padding: 7px 32px }
.pdf-mode .paper              { display: block; overflow: visible }
/* Force desktop layout saat export */
.pdf-mode .kop-wrap           { flex-direction: row !important; padding: 28px 36px !important; gap: 28px !important; align-items: center !important; }
.pdf-mode .kop-logo-wrap      { width: 88px !important; height: 88px !important; flex-shrink: 0 !important; }
.pdf-mode .kop-logo-wrap img  { width: 76px !important; height: 76px !important; }
.pdf-mode .kop-info           { text-align: center !important; flex: 1 !important; max-width: 500px !important; }
.pdf-mode .kop-yayasan        { font-size: 10.5px !important; letter-spacing: 1px !important; margin-bottom: 6px !important; }
.pdf-mode .kop-nama           { font-size: 18px !important; line-height: 1.25 !important; }
.pdf-mode .kop-divider        { margin: 10px auto !important; }
.pdf-mode .kop-detail         { font-size: 11px !important; line-height: 1.8 !important; }
.pdf-mode .kop-detail span    { display: inline !important; margin-right: 12px !important; }
.pdf-mode .paper-inner        { padding: 32px 36px !important; }
.pdf-mode .id-grid            { grid-template-columns: 1fr 1fr !important; }
.pdf-mode .id-row-full        { grid-column: 1 / -1 !important; }
.pdf-mode .id-label           { width: 130px !important; font-size: 11px !important; }
.pdf-mode .id-value           { font-size: 12.5px !important; }
.pdf-mode .ttd-section        { justify-content: flex-end !important; }
.pdf-mode .ttd-box            { width: auto !important; max-width: none !important; min-width: 220px !important; }
.pdf-mode .paper-footer       { flex-direction: row !important; align-items: center !important; justify-content: space-between !important; padding: 12px 36px !important; flex-wrap: wrap !important; }
.pdf-mode .toolbar            { display: none !important; }
</style>
<?php
$prefix = ($siswa->kelulusan == 'Lulus') ? 'Kelulusan' : 'Surat_Undangan';
$filename = $prefix . "_" . str_replace(" ", "_", $siswa->nama_siswa) . "_" . $siswa->nisn . ".pdf";
?>
</head>
<body class="<?= $siswa->kelulusan != 'Lulus' ? 'is-bersyarat' : '' ?>">

<!-- Toolbar -->
<div class="toolbar">
  <button onclick="exportPDF()" class="btn-print">
    <i class="fas fa-file-pdf"></i> Export PDF
  </button>
  <?php
  $role = $this->session->userdata('role');
  if ($role === 'admin' || $role === 'petugas') {
      $back = site_url('admin/siswa');
  } else {
      $back = site_url('hasil/' . $siswa->nisn);
  }
  ?>
  <a href="<?= $back ?>" class="btn-back">
    <i class="fas fa-arrow-left"></i> Kembali
  </a>
  <span class="toolbar-note">
    <i class="fas fa-shield-alt" style="color:#1a56db"></i>
    Berlaku jika ada tanda tangan & cap basah sekolah
  </span>
</div>

<!-- Paper -->
<div class="paper">

  <!-- KOP -->
  <div class="kop-wrap">
    <div class="kop-logo-wrap">
      <img src="<?= base_url('uploads/pbr.png') ?>" alt="Logo SMK">
    </div>
    <div class="kop-info">
      <div class="kop-yayasan">Yayasan Pendidikan dan Teknologi Panca Bhakti</div>
      <div class="kop-nama">Sekolah Menengah Kejuruan (SMK)<br>Panca Bhakti Rakit</div>
      <div class="kop-divider"></div>
      <div class="kop-detail">
          <div>
            <span>NIS: 400190</span>
            <span>NSS: 342030411619</span>
            <span>NPSN: 20362369</span>
          </div>
          <div style="margin-right:0">Jl. Raya Rakit Km. 2,7 Ds. Adipasir, Kec. Rakit, Kab. Banjarnegara 53463</div>
          <div style="margin-right:0">Telp. 085329699994 &nbsp;|&nbsp; E-mail: smk_pabhara@yahoo.com</div>
        </div>
    </div>
  </div>

  <div class="paper-inner">

    <?php if ($siswa->kelulusan == 'Lulus'): ?>
    <!-- ===== LULUS ===== -->
    <div class="doc-title">
      <div class="doc-title-badge"><i class="fas fa-file-alt"></i> Dokumen Kelulusan</div>
      <h2>Pengumuman Kelulusan</h2>
      <div class="tpl">Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>

    <div class="section-label">
      <span class="section-label-text">Identitas Peserta Didik</span>
      <div class="section-label-line"></div>
    </div>
    <div class="id-card">
      <div class="id-grid">
        <div class="id-row id-row-full">
          <span class="id-label">Nama Lengkap</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->nama_siswa) ?></span>
        </div>
        <div class="id-row">
          <span class="id-label">NISN</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= $siswa->nisn ?></span>
        </div>
        <div class="id-row">
          <span class="id-label">Kelas</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->kelas) ?></span>
        </div>
        <div class="id-row id-row-full">
          <span class="id-label">Tempat / Tgl. Lahir</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->tempat_lahir) ?>, <?= tgl_indonesia($siswa->tanggal_lahir) ?></span>
        </div>
        <div class="id-row id-row-full">
          <span class="id-label">Jurusan</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->jurusan) ?></span>
        </div>
        <div class="id-row id-row-full">
          <span class="id-label">Asal Sekolah</span>
          <span class="id-sep">:</span>
          <span class="id-value">SMK Panca Bhakti Rakit</span>
        </div>
      </div>
    </div>

    <div class="section-label">
      <span class="section-label-text">Status Kelulusan</span>
      <div class="section-label-line"></div>
    </div>
    <div class="status-lulus">
      <div class="status-lulus-icon"><i class="fas fa-check"></i></div>
      <div class="status-lulus-text">LULUS</div>
      <div class="status-lulus-sub">Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>

    <div class="pesan">
      Apapun hasil yang didapat, semoga ini adalah yang terbaik, tetap semangat dan optimis.
      Selamat atas kelulusan Kamu. Jadilah insan yang bermanfaat bagi bangsa dan negara.
    </div>

    <?php else: ?>
    <!-- ===== LULUS BERSYARAT ===== -->
    <div class="doc-title">
      <div class="doc-title-badge"><i class="fas fa-envelope"></i> Surat Undangan</div>
      <h2>Undangan Koordinasi Kelulusan</h2>
      <div class="tpl">Tahun Pelajaran <?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?></div>
    </div>

    <div class="section-label">
      <span class="section-label-text">Identitas Peserta Didik</span>
      <div class="section-label-line"></div>
    </div>
    <p style="font-size:12.5px;color:#475569;margin-bottom:12px">Mengundang dengan hormat siswa dengan identitas sebagai berikut:</p>
    <div class="id-card">
      <div class="id-grid">
        <div class="id-row id-row-full">
          <span class="id-label">Nama Lengkap</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->nama_siswa) ?></span>
        </div>
        <div class="id-row">
          <span class="id-label">NISN</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= $siswa->nisn ?></span>
        </div>
        <div class="id-row">
          <span class="id-label">Kelas</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->kelas) ?></span>
        </div>
        <div class="id-row id-row-full">
          <span class="id-label">Tempat / Tgl. Lahir</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->tempat_lahir) ?>, <?= tgl_indonesia($siswa->tanggal_lahir) ?></span>
        </div>
        <div class="id-row id-row-full">
          <span class="id-label">Jurusan</span>
          <span class="id-sep">:</span>
          <span class="id-value"><?= htmlspecialchars($siswa->jurusan) ?></span>
        </div>
        <div class="id-row id-row-full">
          <span class="id-label">Asal Sekolah</span>
          <span class="id-sep">:</span>
          <span class="id-value">SMK Panca Bhakti Rakit</span>
        </div>
      </div>
    </div>

    <div class="status-bersyarat">
      <div class="status-bersyarat-icon"><i class="fas fa-exclamation"></i></div>
      <div class="status-bersyarat-text">LULUS BERSYARAT</div>
      <div class="status-bersyarat-sub">
        <i class="fas fa-exclamation-triangle" style="margin-right:6px"></i>WAJIB HADIR BESERTA ORANG TUA / WALI
      </div>
    </div>

    <div class="section-label" style="margin-top:20px">
      <span class="section-label-text">Detail Undangan</span>
      <div class="section-label-line"></div>
    </div>
    <table class="undangan-table">
      <tr>
        <td><i class="fas fa-calendar" style="color:#1a56db;margin-right:6px"></i>Hari / Tanggal</td><td>:</td>
        <td>
          <?php
          if ($siswa->tanggal_hadir) {
            $hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            echo '<strong>' . $hari[date('w', strtotime($siswa->tanggal_hadir))] . ', ' . tgl_indonesia($siswa->tanggal_hadir) . '</strong>';
          } else { echo '<em style="color:#94a3b8">Akan Dikonfirmasi</em>'; }
          ?>
        </td>
      </tr>
      <tr>
        <td><i class="fas fa-clock" style="color:#1a56db;margin-right:6px"></i>Pukul</td><td>:</td>
        <td><strong><?= $siswa->pukul_hadir ? date('H:i', strtotime($siswa->pukul_hadir)) . ' WIB' : '<em style="color:#94a3b8">Akan Dikonfirmasi</em>' ?></strong></td>
      </tr>
      <tr>
        <td><i class="fas fa-map-marker-alt" style="color:#1a56db;margin-right:6px"></i>Tempat</td><td>:</td>
        <td><strong>SMK Panca Bhakti Rakit</strong></td>
      </tr>
      <tr>
        <td><i class="fas fa-tasks" style="color:#1a56db;margin-right:6px"></i>Agenda</td><td>:</td>
        <td><strong>Koordinasi Pemenuhan Syarat Kelulusan</strong></td>
      </tr>
      <tr>
        <td><i class="fas fa-exclamation-circle" style="color:#dc2626;margin-right:6px"></i>Sifat</td><td>:</td>
        <td><span class="undangan-wajib"><i class="fas fa-exclamation-circle"></i> WAJIB HADIR</span></td>
      </tr>
    </table>

    <div class="pesan">
      Karena pentingnya agenda tersebut dimohon untuk hadir tepat waktu.
      Apapun hasil yang didapat, semoga ini adalah yang terbaik, tetap semangat dan optimis.
    </div>
    <?php endif; ?>

    <!-- TTD -->
    <div class="ttd-section">
      <div class="ttd-box">
        <div class="ttd-kota">Rakit, <?= tgl_indonesia($profil->tanggal_pengumuman ?? date('Y-m-d')) ?></div>
        <div class="ttd-jabatan">Kepala Sekolah</div>

        <?php
          $ttd_path = FCPATH . 'uploads/ttdks.png';
          $ttd_url  = base_url('uploads/ttdks.png');
        ?>
        <?php if (file_exists($ttd_path)): ?>
          <div class="ttd-img">
            <img src="<?= $ttd_url ?>" alt="Tanda Tangan">
          </div>
        <?php else: ?>
          <div style="height:70px"></div>
        <?php endif; ?>

        <div class="ttd-nama"><?= htmlspecialchars($profil->kepala_sekolah ?? 'Nama Kepala Sekolah') ?></div>
        <div class="ttd-nip">NIY. <?= htmlspecialchars($profil->nip_kepala_sekolah ?? '-') ?></div>
      </div>
    </div>

    <!-- Disclaimer -->
    <div class="disclaimer">
      <i class="fas fa-info-circle" style="color:#f59e0b;margin-right:6px"></i>
      Jika ada perbedaan data pengumuman online dan manual, yang menjadi acuan adalah dokumen asli yang telah disahkan dan ditandatangani oleh Kepala Sekolah serta diberi cap basah sekolah.
    </div>

  </div><!-- paper-inner -->

  <!-- Paper Footer -->
  <div class="paper-footer">
    <div class="footer-brand">
      <div class="footer-dot"></div>
      <span>SMK Panca Bhakti Rakit — SIPEKEL Developed by Ivan Zaka Mubarok</span>
    </div>
    <span><i class="fas fa-print" style="margin-right:4px;opacity:.4"></i>Dicetak: <?= date('d/m/Y H:i') ?></span>
  </div>

</div><!-- paper -->

<script>
function exportPDF() {
  const element = document.querySelector('.paper');
  const btn = document.querySelector('.btn-print');

  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Membuat PDF...';
  btn.disabled = true;

  window.scrollTo(0, 0);

  const isMobile = window.innerWidth < 768;
  const PDF_WIDTH = 794;

  document.body.classList.add('pdf-mode');
  document.body.style.margin = '0';
  document.body.style.padding = '0';
  document.body.style.background = '#fff';
  document.body.style.minHeight = 'auto';
  document.documentElement.style.background = '#fff';

  element.style.maxWidth = 'none';
  element.style.borderRadius = '0';
  element.style.boxShadow = 'none';

  if (isMobile) {
    document.body.style.overflow = 'hidden';
    document.documentElement.style.overflow = 'hidden';
    element.style.width = PDF_WIDTH + 'px';
    element.style.margin = '0';
    element.style.paddingBottom = '0';
  } else {
    element.style.paddingBottom = '40px';
  }

  void element.offsetHeight;

  setTimeout(() => {
    // Gunakan getBoundingClientRect untuk tinggi yang lebih akurat
    const rect = element.getBoundingClientRect();
    const contentHeight = isMobile ? Math.ceil(rect.height): element.scrollHeight;

    const pdfHeightMm = isMobile
      ? Math.ceil(((contentHeight + 10) / 96) * 25.4)
      : Math.ceil((contentHeight / 96) * 25.4);

    const html2canvasOpt = {
      scale: 2,
      useCORS: true,
      allowTaint: true,
      logging: false,
      scrollX: 0,
      scrollY: 0,
      height: contentHeight,
      backgroundColor: '#ffffff'
    };

    if (isMobile) {
      html2canvasOpt.windowWidth = PDF_WIDTH;
      html2canvasOpt.width = PDF_WIDTH;
      html2canvasOpt.height = contentHeight + 10.9;  // ← tanpa tambahan
    } else {
      html2canvasOpt.windowWidth = document.documentElement.scrollWidth;
    }

    const opt = {
      margin: 0,
      filename: '<?= $filename ?>',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: html2canvasOpt,
      jsPDF: { unit: 'mm', format: [210, pdfHeightMm], orientation: 'portrait' }
    };

    html2pdf().set(opt).from(element).save().then(() => {
      element.style.paddingBottom = '';
      element.style.maxWidth = '';
      element.style.width = '';
      element.style.borderRadius = '';
      element.style.boxShadow = '';
      element.style.margin = '';
      document.body.style.padding = '';
      document.body.style.background = '';
      document.body.style.margin = '';
      document.body.style.minHeight = '';
      document.body.style.overflow = '';
      document.documentElement.style.background = '';
      document.documentElement.style.overflow = '';
      document.body.classList.remove('pdf-mode');
      btn.innerHTML = '<i class="fas fa-file-pdf"></i> Export PDF';
      btn.disabled = false;
    });
  }, 400);
}
</script>
</body>
</html>