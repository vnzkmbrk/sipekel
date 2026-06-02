<style>
ul.pagination {
  display: flex;
  align-items: center;
  gap: 4px;
  list-style: none;
  margin: 0;
  padding: 0;
  flex-wrap: wrap;
}
ul.pagination li a,
ul.pagination li span {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 34px;
  height: 34px;
  padding: 0 10px;
  border-radius: 8px;
  font-size: 13px;
  font-weight: 500;
  color: var(--text);
  background: #fff;
  border: 1px solid var(--border);
  text-decoration: none;
  transition: all .15s;
}
ul.pagination li a:hover {
  background: var(--bg);
  border-color: var(--primary);
  color: var(--primary);
}
ul.pagination li.active span {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
  font-weight: 700;
}
@media (max-width: 600px) {
  .log-pagination-container {
    flex-direction: column;
    align-items: center;
  }
  .log-pagination-wrap {
    width: 100%;
    display: flex;
    justify-content: center;
  }
}
</style>

<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><span>Log Aktivitas</span></div>
  <div class="page-title">Log Aktivitas Sistem</div>
  <div class="page-subtitle">Rekam jejak seluruh aktivitas pengguna dalam sistem</div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Pengguna</th>
          <th>Aksi</th>
          <th>Keterangan</th>
          <th>IP Address</th>
          <th>Waktu</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($logs): $no = $page + 1; foreach ($logs as $l): ?>
        <tr>
          <td style="color:var(--text-muted);font-size:12px"><?= $no++ ?></td>
          <td>
            <div style="font-weight:600;font-size:13px"><?= htmlspecialchars($l->nama_lengkap ?? 'Sistem') ?></div>
            <div style="font-size:11px;color:var(--text-muted)"><?= htmlspecialchars($l->username ?? '-') ?></div>
          </td>
          <td>
            <?php
            $badge_class = 'badge-secondary';
            if (strpos($l->aksi, 'Login') !== false) $badge_class = 'badge-success';
            elseif (strpos($l->aksi, 'Logout') !== false) $badge_class = 'badge-info';
            elseif (strpos($l->aksi, 'Hapus') !== false) $badge_class = 'badge-danger';
            elseif (strpos($l->aksi, 'Tambah') !== false || strpos($l->aksi, 'Import') !== false) $badge_class = 'badge-primary';
            elseif (strpos($l->aksi, 'Edit') !== false || strpos($l->aksi, 'Update') !== false) $badge_class = 'badge-warning';
            ?>
            <span class="badge <?= $badge_class ?>"><?= htmlspecialchars($l->aksi) ?></span>
          </td>
          <td style="font-size:12.5px;color:var(--text-muted);max-width:260px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($l->keterangan ?? '-') ?></td>
          <td><code style="font-size:11.5px;background:var(--bg);padding:2px 6px;border-radius:4px"><?= $l->ip_address ?></code></td>
          <td style="font-size:12px;color:var(--text-muted);white-space:nowrap"><?php
            $bulan_id = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
            $ts = strtotime($l->created_at);
            echo date('d', $ts) . ' ' . $bulan_id[(int)date('n', $ts)] . ' ' . date('Y H:i:s', $ts);
            ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="6" style="text-align:center;padding:48px;color:var(--text-muted)">Belum ada log aktivitas</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if ($total > $per_page): ?>
  <div class="log-pagination-container" style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px">
    <div style="font-size:12.5px;color:var(--text-muted)">
      Menampilkan <?= $page + 1 ?>–<?= min($page + $per_page, $total) ?> dari <?= $total ?> log
    </div>
    <div class="log-pagination-wrap"><?= $pagination ?></div>
  </div>
  <?php endif; ?>
</div>