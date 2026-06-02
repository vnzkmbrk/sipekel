<?php $is_edit = isset($siswa) && $siswa; ?>
<div class="page-header">
  <div class="breadcrumb">
    <a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span>
    <a href="<?= site_url('admin/siswa') ?>">Data Siswa</a><span>/</span>
    <span><?= $is_edit ? 'Edit' : 'Tambah' ?> Siswa</span>
  </div>
  <div class="page-title"><?= $is_edit ? 'Edit Data Siswa' : 'Tambah Siswa Baru' ?></div>
  <div class="page-subtitle"><?= $is_edit ? 'Perbarui informasi data siswa' : 'Masukkan data peserta didik kelas XII' ?></div>
</div>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
  <div><strong>Terjadi kesalahan:</strong><ul><?= $this->session->flashdata('error') ?></ul></div>
</div>
<?php endif; ?>

<style>
.siswa-layout {
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
.radio-group {
  display: flex;
  gap: 12px;
  flex-wrap: wrap;
}
.radio-label {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 12px 18px;
  border: 2px solid var(--border);
  border-radius: 10px;
  cursor: pointer;
  flex: 1;
  min-width: 140px;
  transition: all .2s;
}
.siswa-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
}
.siswa-actions .btn {
  width: 100%;
  justify-content: center;
}
@media (max-width: 900px) {
  .siswa-layout {
    grid-template-columns: 1fr;
  }
  /* Panduan & tombol aksi pindah ke bawah, ubah jadi horizontal */
  .siswa-actions {
    flex-direction: row;
  }
}
@media (max-width: 600px) {
  .form-grid {
    grid-template-columns: 1fr;
  }
  .form-group.form-full {
    grid-column: 1;
  }
  .radio-group {
    flex-direction: column;
  }
  .radio-label {
    min-width: unset;
  }
  .siswa-actions {
    flex-direction: column;
  }
}
</style>

<?php
$action = $is_edit ? site_url('admin/siswa/update/'.$siswa->id) : site_url('admin/siswa/simpan');
?>

<form action="<?= $action ?>" method="POST">
<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
<div class="siswa-layout">

<!-- Kiri -->
<div>
  <!-- Identitas -->
  <div class="card" style="margin-bottom:20px">
    <div class="card-header"><i class="fas fa-id-card" style="color:var(--primary)"></i><span class="card-title">Identitas Siswa</span></div>
    <div class="card-body">
      <div class="form-grid">
        <div class="form-group form-full">
          <label>NISN (Nomor Induk Siswa Nasional) <span class="req">*</span></label>
          <input type="text" name="nisn" class="form-control" value="<?= $is_edit ? $siswa->nisn : set_value('nisn') ?>" placeholder="10 digit angka" maxlength="10" pattern="[0-9]{10}" required>
          <div class="form-hint">NISN terdiri dari 10 digit angka</div>
        </div>
        <div class="form-group form-full">
          <label>Nama Siswa <span class="req">*</span></label>
          <input type="text" name="nama_siswa" class="form-control" value="<?= $is_edit ? htmlspecialchars($siswa->nama_siswa) : set_value('nama_siswa') ?>" placeholder="Nama lengkap siswa" required>
        </div>
        <div class="form-group">
          <label>Tempat Lahir <span class="req">*</span></label>
          <input type="text" name="tempat_lahir" class="form-control" value="<?= $is_edit ? htmlspecialchars($siswa->tempat_lahir) : set_value('tempat_lahir') ?>" placeholder="Kota/Kabupaten" required>
        </div>
        <div class="form-group">
          <label>Tanggal Lahir <span class="req">*</span></label>
          <input type="date" name="tanggal_lahir" class="form-control" value="<?= $is_edit ? $siswa->tanggal_lahir : set_value('tanggal_lahir') ?>" required>
        </div>
        <div class="form-group">
          <label>Kelas <span class="req">*</span></label>
          <input type="text" name="kelas" class="form-control" value="<?= $is_edit ? htmlspecialchars($siswa->kelas) : set_value('kelas') ?>" placeholder="Contoh: XII TO 1" required>
          <div class="form-hint">Contoh: XII TO 1, XII TKJ 1, XII TKJ 2</div>
        </div>
        <div class="form-group">
          <label>Jurusan <span class="req">*</span></label>
          <select name="jurusan" class="form-control" required onchange="toggleBersyarat()">
            <option value="">-- Pilih Jurusan --</option>
            <option value="Teknik Otomotif" <?= ($is_edit && $siswa->jurusan=='Teknik Otomotif') ? 'selected' : '' ?>>Teknik Otomotif</option>
            <option value="Teknik Jaringan Komputer dan Telekomunikasi" <?= ($is_edit && $siswa->jurusan=='Teknik Jaringan Komputer dan Telekomunikasi') ? 'selected' : '' ?>>Teknik Jaringan Komputer dan Telekomunikasi</option>
          </select>
        </div>
      </div>
    </div>
  </div>

  <!-- Status & Jadwal -->
  <div class="card">
    <div class="card-header"><i class="fas fa-clipboard-check" style="color:var(--success)"></i><span class="card-title">Status Kelulusan</span></div>
    <div class="card-body">
      <div class="form-group">
        <label>Status Kelulusan <span class="req">*</span></label>
        <div class="radio-group">
          <label class="radio-label" id="lbl-lulus">
            <input type="radio" name="kelulusan" value="Lulus" <?= ($is_edit && $siswa->kelulusan=='Lulus') || !$is_edit ? 'checked' : '' ?> onchange="toggleBersyarat()" style="accent-color:var(--success)">
            <span>
              <span style="display:block;font-weight:700;color:var(--success)">✓ Lulus</span>
              <span style="font-size:11px;color:var(--text-muted)">Memenuhi semua syarat</span>
            </span>
          </label>
          <label class="radio-label" id="lbl-bersyarat">
            <input type="radio" name="kelulusan" value="Lulus Bersyarat" <?= ($is_edit && $siswa->kelulusan=='Lulus Bersyarat') ? 'checked' : '' ?> onchange="toggleBersyarat()" style="accent-color:var(--warning)">
            <span>
              <span style="display:block;font-weight:700;color:var(--warning)">⚠ Bersyarat</span>
              <span style="font-size:11px;color:var(--text-muted)">Perlu pemenuhan syarat</span>
            </span>
          </label>
        </div>
      </div>

      <!-- Jadwal Hadir -->
      <div id="jadwalBersyarat" style="display:none;margin-top:8px">
        <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:10px;padding:16px;margin-bottom:16px">
          <div style="font-size:13px;font-weight:700;color:#a16207;margin-bottom:4px"><i class="fas fa-calendar-check"></i> Jadwal Koordinasi Pemenuhan Syarat</div>
          <div style="font-size:12px;color:#92400e">Isi jadwal untuk undangan hadir siswa dan orang tua</div>
        </div>
        <div class="form-grid">
          <div class="form-group">
            <label>Tanggal Hadir <span class="req">*</span></label>
            <input type="date" name="tanggal_hadir" class="form-control" value="<?= $is_edit ? ($siswa->tanggal_hadir ?? '') : '' ?>">
          </div>
          <div class="form-group">
            <label>Pukul <span class="req">*</span></label>
            <input type="time" name="pukul_hadir" class="form-control" value="<?= $is_edit ? ($siswa->pukul_hadir ?? '09:00') : '09:00' ?>">
          </div>
        </div>
      </div>

      <div class="form-group" style="margin-top:8px">
        <label>Catatan Tambahan</label>
        <textarea name="catatan" class="form-control" rows="3" placeholder="Catatan khusus untuk siswa ini (opsional)"><?= $is_edit ? htmlspecialchars($siswa->catatan ?? '') : '' ?></textarea>
      </div>
    </div>
  </div>
</div>

<!-- Kanan -->
<div>
  <div class="card" style="margin-bottom:20px">
    <div class="card-header"><i class="fas fa-question-circle" style="color:var(--info)"></i><span class="card-title">Panduan Pengisian</span></div>
    <div class="card-body" style="font-size:12.5px;color:var(--text-muted);line-height:1.8">
      <p style="margin-bottom:8px"><strong style="color:var(--text)">NISN</strong> — 10 digit angka unik setiap siswa</p>
      <p style="margin-bottom:8px"><strong style="color:var(--text)">Kelas</strong> — Format: XII [jurusan] [nomor], contoh: XII TO 1</p>
      <p style="margin-bottom:8px"><strong style="color:var(--text)">Lulus</strong> — Siswa telah memenuhi semua syarat kelulusan</p>
      <p><strong style="color:var(--text)">Bersyarat</strong> — Siswa perlu memenuhi syarat tambahan, isi jadwal koordinasi</p>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="siswa-actions">
        <button type="submit" class="btn btn-primary">
          <i class="fas fa-<?= $is_edit ? 'save' : 'plus-circle' ?>"></i>
          <?= $is_edit ? 'Simpan Perubahan' : 'Tambah Siswa' ?>
        </button>
        <a href="<?= site_url('admin/siswa') ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali ke Daftar</a>
      </div>
    </div>
  </div>
</div>

</div>
</form>

<script>
function toggleBersyarat() {
  const isBersyarat = document.querySelector('input[name="kelulusan"]:checked')?.value === 'Lulus Bersyarat';
  document.getElementById('jadwalBersyarat').style.display = isBersyarat ? 'block' : 'none';

  const tanggalHadir = document.querySelector('input[name="tanggal_hadir"]');
  const pukulHadir   = document.querySelector('input[name="pukul_hadir"]');

  if (tanggalHadir) tanggalHadir.required = isBersyarat;
  if (pukulHadir)   pukulHadir.required   = isBersyarat;
}
toggleBersyarat();

// NISN hanya angka
const nisnInput = document.querySelector('input[name="nisn"]');
if (nisnInput) {
  nisnInput.addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
  });
  nisnInput.addEventListener('keypress', function(e) {
    if (!/[0-9]/.test(e.key)) e.preventDefault();
  });
  nisnInput.addEventListener('paste', function(e) {
    e.preventDefault();
    const text = (e.clipboardData || window.clipboardData).getData('text');
    this.value = text.replace(/[^0-9]/g, '').slice(0, 10);
  });
}
</script>