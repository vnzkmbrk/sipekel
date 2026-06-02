<?php
function tgl_indonesia($tanggal) {
    $bulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
        4 => 'April',   5 => 'Mei',      6 => 'Juni',
        7 => 'Juli',    8 => 'Agustus',  9 => 'September',
        10 => 'Oktober',11 => 'November',12 => 'Desember'
    ];
    $ts = strtotime($tanggal);
    return date('d', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}
?>
<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><span>Profil Sekolah</span></div>
  <div class="page-title">Profil Sekolah</div>
  <div class="page-subtitle">Kelola informasi dan jadwal pengumuman sekolah</div>
</div>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<style>
.form-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.form-actions .btn {
  width: 100%;
  justify-content: center;
  text-align: center;
}
@media (max-width: 600px) {
  .form-actions {
    flex-direction: column;
  }
  .form-actions .btn {
    flex: 1; /* full-width hanya di mobile */
  }
}
  
.profil-layout {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 20px;
}
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}
.form-group.form-full {
  grid-column: 1 / -1;
}
@media (max-width: 900px) {
  .profil-layout {
    grid-template-columns: 1fr;
  }
}
@media (max-width: 600px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
  .form-group.form-full {
    grid-column: 1;
  }
  .profil-layout {
    gap: 14px;
  }
}
</style>

<form action="<?= site_url('admin/profil/update') ?>" method="POST">
<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

<div class="profil-layout">

<!-- Kiri: Form -->
<div>
  <!-- Info Sekolah -->
  <div class="card" style="margin-bottom:20px">
    <div class="card-header">
      <i class="fas fa-school" style="color:var(--primary)"></i>
      <span class="card-title">Informasi Sekolah</span>
    </div>
    <div class="card-body">
      <div class="form-grid">
        <div class="form-group form-full">
          <label>Nama Sekolah <span class="req">*</span></label>
          <input type="text" name="nama_sekolah" class="form-control" value="<?= htmlspecialchars($profil->nama_sekolah ?? '') ?>" placeholder="Contoh: SMK Panca Bhakti Rakit" required>
        </div>
        <div class="form-group form-full">
          <label>Nama Aplikasi <span class="req">*</span></label>
          <input type="text" name="nama_aplikasi" class="form-control" value="<?= htmlspecialchars($profil->nama_aplikasi ?? '') ?>" placeholder="Contoh: Sistem Pengumuman Kelulusan" required>
        </div>
        <div class="form-group">
          <label>Tahun Pelajaran <span class="req">*</span></label>
          <input type="text" name="tahun_pelajaran" class="form-control" value="<?= htmlspecialchars($profil->tahun_pelajaran ?? '') ?>" placeholder="2024/2025" required>
        </div>
        <div class="form-group">
          <label>NPSN</label>
          <input type="text" name="npsn" class="form-control" value="<?= htmlspecialchars($profil->npsn ?? '') ?>" placeholder="Nomor Pokok Sekolah Nasional">
        </div>
        <div class="form-group form-full">
          <label>Alamat Sekolah</label>
          <textarea name="alamat_sekolah" class="form-control" rows="2" placeholder="Alamat lengkap sekolah"><?= htmlspecialchars($profil->alamat_sekolah ?? '') ?></textarea>
        </div>
        <div class="form-group">
          <label>Nama Kepala Sekolah</label>
          <input type="text" name="kepala_sekolah" class="form-control" value="<?= htmlspecialchars($profil->kepala_sekolah ?? '') ?>" placeholder="Nama lengkap beserta gelar">
        </div>
        <div class="form-group">
          <label>NIY Kepala Sekolah</label>
          <input type="text" name="nip_kepala_sekolah" class="form-control" value="<?= htmlspecialchars($profil->nip_kepala_sekolah ?? '') ?>" placeholder="NIY">
        </div>
      </div>
    </div>
  </div>

  <!-- Jadwal Pengumuman -->
  <div class="card" style="margin-bottom:20px">
    <div class="card-header">
      <i class="fas fa-calendar-alt" style="color:var(--warning)"></i>
      <span class="card-title">Jadwal Pengumuman Kelulusan</span>
    </div>
    <div class="card-body">
      <div class="alert alert-info" style="margin-bottom:16px"><i class="fas fa-info-circle"></i> Siswa hanya bisa mengakses pengumuman setelah tanggal dan jam yang ditentukan.</div>
      <div class="form-grid">
        <div class="form-group">
          <label>Tanggal Pengumuman <span class="req">*</span></label>
          <input type="date" name="tanggal_pengumuman" class="form-control" value="<?= $profil->tanggal_pengumuman ?? '' ?>" required>
        </div>
        <div class="form-group">
          <label>Jam Pengumuman <span class="req">*</span></label>
          <input type="time" name="jam_pengumuman" class="form-control" value="<?= $profil->jam_pengumuman ?? '10:00' ?>" required>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Kanan: Info -->
<div>
  <div class="card" style="margin-bottom:20px">
    <div class="card-header"><i class="fas fa-info-circle" style="color:var(--info)"></i><span class="card-title">Status Saat Ini</span></div>
    <div class="card-body">
      <?php
      $now = time();
      $tgl_umum = strtotime(($profil->tanggal_pengumuman ?? '2099-01-01') . ' ' . ($profil->jam_pengumuman ?? '00:00:00'));
      $is_open = $now >= $tgl_umum;
      ?>
      <div style="text-align:center;padding:16px 0">
        <div style="width:60px;height:60px;border-radius:50%;background:<?= $is_open ? '#dcfce7' : '#fef3c7' ?>;display:flex;align-items:center;justify-content:center;font-size:24px;margin:0 auto 12px">
          <?= $is_open ? '🟢' : '🔒' ?>
        </div>
        <div style="font-size:16px;font-weight:700;color:<?= $is_open ? '#15803d' : '#a16207' ?>">
          <?= $is_open ? 'PENGUMUMAN TERBUKA' : 'BELUM DIBUKA' ?>
        </div>
        <div style="font-size:12px;color:var(--text-muted);margin-top:6px">
          <?= tgl_indonesia(date('Y-m-d', $tgl_umum)) ?> · Pukul <?= date('H:i', $tgl_umum) ?> WIB
        </div>
      </div>
      <div style="background:var(--bg);border-radius:8px;padding:12px;font-size:12px">
        <div style="margin-bottom:6px;font-weight:600;color:var(--text-muted)">Keterangan Status:</div>
        <div>🔒 Belum Dibuka — Siswa tidak bisa cek kelulusan</div>
        <div style="margin-top:4px">🟢 Terbuka — Siswa bisa cek kelulusan dengan NISN</div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><i class="fas fa-shield-alt" style="color:var(--success)"></i><span class="card-title">Catatan Penting</span></div>
    <div class="card-body" style="font-size:12.5px;color:var(--text-muted);line-height:1.7">
      <p>Jika ada perbedaan data pengumuman online dan manual, maka yang menjadi acuan adalah <strong style="color:var(--text)">dokumen asli Kelulusan</strong> yang telah disahkan, ditandatangani oleh Kepala Sekolah dan diberi cap basah sekolah.</p>
    </div>
  </div>
  <div class="card" style="margin-top:12px">
  <div class="card-body">
    <div class="form-actions">
      <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Perubahan</button>
      <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
    </div>
  </div>
</div>
</div>

</div>
</form>