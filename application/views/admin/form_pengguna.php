<?php $is_edit = isset($pengguna) && $pengguna; ?>
<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><a href="<?= site_url('admin/pengguna') ?>">Pengguna</a><span>/</span><span><?= $is_edit ? 'Edit' : 'Tambah' ?></span></div>
  <div class="page-title"><?= $is_edit ? 'Edit Pengguna' : 'Tambah Pengguna Baru' ?></div>
  <div class="page-subtitle"><?= $is_edit ? 'Perbarui data akun pengguna sistem' : 'Buat akun admin atau petugas baru' ?></div>
</div>

<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
  <div><strong>Terjadi kesalahan:</strong><ul><?= $this->session->flashdata('error') ?></ul></div>
</div>
<?php endif; ?>

<style>
.pengguna-wrap {
  width: 100%;
}
.pengguna-actions {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-top: 24px;
}
.pengguna-actions .btn {
  width: 100%;
  justify-content: center;
  text-align: center;
}
</style>

<div class="pengguna-wrap">
<form action="<?= $is_edit ? site_url('admin/pengguna/update/'.$pengguna->id) : site_url('admin/pengguna/simpan') ?>" method="POST">
<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">

<div class="card">
  <div class="card-header"><i class="fas fa-user-cog" style="color:var(--primary)"></i><span class="card-title"><?= $is_edit ? 'Edit Data Pengguna' : 'Data Pengguna Baru' ?></span></div>
  <div class="card-body">
    <div class="form-group">
      <label>Nama Lengkap <span class="req">*</span></label>
      <input type="text" name="nama_lengkap" class="form-control" value="<?= $is_edit ? htmlspecialchars($pengguna->nama_lengkap) : '' ?>" placeholder="Nama lengkap pengguna" required>
    </div>
    <div class="form-group">
      <label>Username <span class="req">*</span></label>
      <input type="text" name="username" class="form-control" value="<?= $is_edit ? htmlspecialchars($pengguna->username) : '' ?>" placeholder="Username (huruf & angka)" required autocomplete="username">
      <div class="form-hint">Min. 4 karakter, hanya huruf dan angka</div>
    </div>
    <div class="form-group">
      <label>Role <span class="req">*</span></label>
      <select name="role" class="form-control" required>
        <option value="">-- Pilih Role --</option>
        <option value="admin" <?= ($is_edit && $pengguna->role=='admin') ? 'selected' : '' ?>>Admin (Akses Penuh)</option>
        <option value="petugas" <?= ($is_edit && $pengguna->role=='petugas') ? 'selected' : '' ?>>Petugas (Akses Terbatas)</option>
      </select>
    </div>

    <div style="border-top:1px dashed var(--border);margin:20px 0;padding-top:20px">
      <div style="font-size:13px;font-weight:700;color:var(--text);margin-bottom:4px">
        <?= $is_edit ? '🔑 Ubah Password (kosongkan jika tidak diubah)' : '🔑 Password' ?>
      </div>
      <?php if ($is_edit): ?>
      <div class="alert alert-info" style="margin:10px 0 14px"><i class="fas fa-info-circle"></i> Kosongkan field password jika tidak ingin mengubah password.</div>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label>Password <?= !$is_edit ? '<span class="req">*</span>' : '' ?></label>
      <div style="position:relative">
        <input type="password" name="password" id="password" class="form-control" placeholder="<?= $is_edit ? 'Kosongkan jika tidak diubah' : 'Min. 6 karakter' ?>" <?= !$is_edit ? 'required' : '' ?> autocomplete="new-password">
        <button type="button" onclick="togglePass('password')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer"><i class="fas fa-eye"></i></button>
      </div>
    </div>

    <?php if (!$is_edit): ?>
    <div class="form-group">
      <label>Konfirmasi Password <span class="req">*</span></label>
      <div style="position:relative">
        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" placeholder="Ulangi password" required autocomplete="new-password">
        <button type="button" onclick="togglePass('konfirmasi_password')" style="position:absolute;right:12px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--text-muted);cursor:pointer"><i class="fas fa-eye"></i></button>
      </div>
    </div>
    <?php endif; ?>

    <!-- Tombol Aksi -->
    <div class="pengguna-actions">
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-<?= $is_edit ? 'save' : 'user-plus' ?>"></i> <?= $is_edit ? 'Simpan Perubahan' : 'Tambah Pengguna' ?>
      </button>
      <a href="<?= site_url('admin/pengguna') ?>" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar
      </a>
    </div>

  </div>
</div>

</form>
</div>