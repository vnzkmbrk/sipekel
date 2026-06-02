<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><span>Pengguna</span></div>
  <div class="page-title">Manajemen Pengguna</div>
  <div class="page-subtitle">Kelola akun admin dan petugas sistem</div>
</div>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<style>
  .btn-tambah-pengguna {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }
  @media (max-width: 480px) {
    .btn-tambah-pengguna {
      width: 100%;
      justify-content: center;
      box-sizing: border-box;
    }
  }
</style>

<div style="margin-bottom:20px">
  <a href="<?= site_url('admin/pengguna/tambah') ?>" class="btn btn-primary btn-tambah-pengguna">
    <i class="fas fa-user-plus"></i> Tambah Pengguna
  </a>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Pengguna</th>
          <th>Username</th>
          <th>Role</th>
          <th>Status</th>
          <th>Login Terakhir</th>
          <th style="text-align:center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($list): $no = 1; foreach ($list as $p): ?>
        <tr>
          <td style="color:var(--text-muted);font-size:12px"><?= $no++ ?></td>
          <td>
            <div style="display:flex;align-items:center;gap:12px">
              <div style="width:38px;height:38px;border-radius:10px;background:<?= $p->role=='admin' ? 'var(--primary)' : '#7c3aed' ?>;color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;flex-shrink:0">
                <?= strtoupper(substr($p->nama_lengkap, 0, 1)) ?>
              </div>
              <div>
                <div style="font-weight:600;font-size:13.5px"><?= htmlspecialchars($p->nama_lengkap) ?></div>
                <div style="font-size:11.5px;color:var(--text-muted)">ID: <?= $p->id ?></div>
              </div>
            </div>
          </td>
          <td><code style="background:var(--bg);padding:3px 8px;border-radius:6px;font-size:13px"><?= htmlspecialchars($p->username) ?></code></td>
          <td>
            <?php if ($p->role == 'admin'): ?>
            <span class="badge badge-primary"><i class="fas fa-crown"></i> Admin</span>
            <?php else: ?>
            <span class="badge badge-info"><i class="fas fa-user-cog"></i> Petugas</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($p->is_active): ?>
            <span class="badge badge-success"><i class="fas fa-circle" style="font-size:8px"></i> Aktif</span>
            <?php else: ?>
            <span class="badge badge-secondary"><i class="fas fa-circle" style="font-size:8px"></i> Nonaktif</span>
            <?php endif; ?>
          </td>
          <td style="font-size:12.5px;color:var(--text-muted)">
              <?php if ($p->last_login):
                $bulan_id = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
                $ts = strtotime($p->last_login);
                echo date('d', $ts) . ' ' . $bulan_id[(int)date('n', $ts)] . ' ' . date('Y H:i', $ts);
              else: ?>
                <em>Belum pernah</em>
              <?php endif; ?>
            </td>
          <td>
            <div class="btn-group" style="justify-content:center">
              <a href="<?= site_url('admin/pengguna/edit/'.$p->id) ?>" class="btn-icon success" title="Edit"><i class="fas fa-edit"></i></a>
              <?php if ($p->id != $this->session->userdata('id')): ?>
              <button onclick="konfirmHapus('<?= site_url('admin/pengguna/hapus/'.$p->id) ?>','<?= htmlspecialchars($p->nama_lengkap) ?>')" class="btn-icon danger" title="Hapus"><i class="fas fa-trash"></i></button>
              <?php else: ?>
              <button class="btn-icon" disabled title="Tidak bisa hapus akun sendiri" style="opacity:.4;cursor:not-allowed"><i class="fas fa-trash"></i></button>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="7" style="text-align:center;padding:48px;color:var(--text-muted)">Belum ada data pengguna</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="alert alert-info" style="margin-top:16px">
  <i class="fas fa-info-circle"></i>
  <div><strong>Info:</strong> Admin memiliki akses penuh ke semua fitur. Petugas hanya bisa mengelola data siswa dan melihat laporan.</div>
</div>
