<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><span>Data Siswa</span></div>
  <div class="page-title">Data Siswa</div>
  <div class="page-subtitle">Kelola data peserta didik kelas XII</div>
</div>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert alert-success"><i class="fas fa-check-circle"></i> <?= $this->session->flashdata('success') ?></div>
<?php endif; ?>
<?php if ($this->session->flashdata('error')): ?>
<div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<style>
@media (max-width: 600px) {
  .pagination-wrap {
    width: 100%;
    display: flex;
    justify-content: center;
  }
}

@media (max-width: 600px) {
  #btnHapusSemua {
    flex: 1 1 100%;
    justify-content: center;
    text-align: center;
  }
}

@media (max-width: 600px) {
  #btnHapusTerpilih {
    flex: 1 1 100%;
    justify-content: center;
    text-align: center;
  }
}

.cb-all, .cb-row { cursor: pointer; width: 16px; height: 16px; }
#btnHapusTerpilih { display: none; }

/* Action Bar */
.action-bar {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: center;
  margin-bottom: 20px;
}
.action-bar .action-total {
  margin-left: auto;
  font-size: 13px;
  color: var(--text-muted);
}
@media (max-width: 600px) {
  .action-bar .action-total {
    margin-left: 0;
    width: 100%;
    order: 4;
  }
  .action-bar .btn:nth-child(1) {
    flex: 1 1 100%;
    justify-content: center;
    text-align: center;
  }
  .action-bar .btn:nth-child(2),
  .action-bar .btn:nth-child(3) {
    flex: 1 1 calc(50% - 5px);
    justify-content: center;
    text-align: center;
  }
}

/* Filter */
.filter-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  align-items: flex-end;
}
.filter-search { flex: 2; min-width: 200px; }
.filter-jurusan { min-width: 160px; flex: 1; }
.filter-status  { min-width: 140px; flex: 1; }
.filter-kelas   { min-width: 120px; flex: 1; }
.filter-btn {
  display: flex;
  gap: 6px;
  align-items: flex-end;
}
.filter-btn .btn-sm {
  height: 42px;
  padding: 0 16px;
  display: flex;
  align-items: center;
  gap: 6px;
}
@media (max-width: 600px) {
  .filter-search,
  .filter-jurusan,
  .filter-status,
  .filter-kelas { width: 100%; flex: unset; min-width: unset; }
  .filter-btn { width: 100%; }
  .filter-btn .btn { flex: 1; justify-content: center; }
}

/* Modal */
.modal-actions {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  margin-top: 16px;
}
@media (max-width: 600px) {
  .modal-actions {
    flex-direction: column-reverse;
  }
  .modal-actions .btn {
    width: 100%;
    justify-content: center;
    text-align: center;
  }
}
/* Table Responsive */
.table-wrap {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}
@media (max-width: 600px) {
  .table-wrap table {
    min-width: 600px;
  }
  .badge {
    white-space: nowrap;
  }
  .btn-icon {
    width: 28px;
    height: 28px;
    font-size: 12px;
  }
}
/* Pagination */
.pagination-wrap .pagination {
  display: flex;
  gap: 4px;
  list-style: none;
  padding: 0;
  margin: 0;
  flex-wrap: wrap;
}
.pagination-wrap .pagination li a,
.pagination-wrap .pagination li span {
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 34px;
  height: 34px;
  padding: 0 10px;
  border-radius: 8px;
  border: 1px solid var(--border);
  font-size: 13px;
  font-weight: 500;
  text-decoration: none;
  color: var(--text);
  background: #fff;
  transition: all .15s;
}
.pagination-wrap .pagination li a:hover {
  background: var(--bg);
  border-color: var(--primary);
  color: var(--primary);
}
.pagination-wrap .pagination li.active span {
  background: var(--primary);
  color: #fff;
  border-color: var(--primary);
  font-weight: 700;
}
</style>

<!-- Action Bar -->
<div class="action-bar">
  <a href="<?= site_url('admin/siswa/tambah') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Siswa</a>
  <button type="button" class="btn btn-success" onclick="document.getElementById('modalImport').style.display='flex'">
    <i class="fas fa-file-import"></i> Import Excel
  </button>
  <a href="<?= site_url('admin/siswa/template_excel') ?>" class="btn btn-outline"><i class="fas fa-file-download"></i> Template</a>
  <button type="button" id="btnHapusTerpilih" class="btn btn-danger" onclick="hapusTerpilih()">
    <i class="fas fa-trash"></i> Hapus Terpilih (<span id="jumlahCeklist">0</span>)
  </button>
  <button type="button" id="btnHapusSemua" class="btn btn-outline" onclick="hapusSemua()" style="border-color:#dc2626;color:#dc2626">
    <i class="fas fa-trash-alt"></i> Hapus Semua
  </button>
  <span class="action-total">Total: <strong style="color:var(--text)"><?= $total ?></strong> siswa</span>
</div>

<!-- Filter & Search -->
<div class="card" style="margin-bottom:20px">
  <div class="card-body" style="padding:16px 20px">
    <form method="GET" action="<?= site_url('admin/siswa') ?>">
      <div class="filter-grid">
        <div class="filter-search">
          <label style="font-size:12px;margin-bottom:4px;display:block">Cari Nama / NISN</label>
          <div style="position:relative">
            <i class="fas fa-search" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:var(--text-muted);font-size:13px"></i>
            <input type="text" name="search" class="form-control" style="padding-left:36px" placeholder="Ketik nama atau NISN..." value="<?= htmlspecialchars($search ?? '') ?>">
          </div>
        </div>
        <div class="filter-jurusan">
          <label style="font-size:12px;margin-bottom:4px;display:block">Jurusan</label>
          <select name="jurusan" class="form-control">
            <option value="">Semua Jurusan</option>
            <option value="Teknik Otomotif" <?= $jurusan=='Teknik Otomotif'?'selected':'' ?>>TO</option>
            <option value="Teknik Jaringan Komputer dan Telekomunikasi" <?= $jurusan=='Teknik Jaringan Komputer dan Telekomunikasi'?'selected':'' ?>>TJKT</option>
          </select>
        </div>
        <div class="filter-status">
          <label style="font-size:12px;margin-bottom:4px;display:block">Status</label>
          <select name="status" class="form-control">
            <option value="">Semua Status</option>
            <option value="Lulus" <?= $status=='Lulus'?'selected':'' ?>>Lulus</option>
            <option value="Lulus Bersyarat" <?= $status=='Lulus Bersyarat'?'selected':'' ?>>Bersyarat</option>
          </select>
        </div>
        <div class="filter-kelas">
          <label style="font-size:12px;margin-bottom:4px;display:block">Kelas</label>
          <select name="kelas" class="form-control">
            <option value="">Semua Kelas</option>
            <?php foreach ($list_kelas as $k): ?>
            <option value="<?= $k->kelas ?>" <?= $kelas==$k->kelas?'selected':'' ?>><?= $k->kelas ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="filter-btn">
          <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i> Filter</button>
          <a href="<?= site_url('admin/siswa') ?>" class="btn btn-outline btn-sm"><i class="fas fa-sync"></i></a>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Tambahkan di antara card filter dan card tabel -->
<div style="display:flex;justify-content:flex-end;align-items:center;gap:8px;margin-bottom:10px">
  <label style="font-size:12px;color:var(--text-muted)">Urutkan:</label>
  <select id="sortSelect" class="form-control" style="width:auto;min-width:160px" onchange="applySort(this.value)">
    <option value="">Default</option>
    <option value="terbaru"   <?= ($sort ?? '') == 'terbaru'   ? 'selected' : '' ?>>Terbaru</option>
    <option value="terlama"   <?= ($sort ?? '') == 'terlama'   ? 'selected' : '' ?>>Terlama</option>
    <option value="jurusan_to"   <?= ($sort ?? '') == 'jurusan_to'   ? 'selected' : '' ?>>Jurusan TO</option>
    <option value="jurusan_tjkt" <?= ($sort ?? '') == 'jurusan_tjkt' ? 'selected' : '' ?>>Jurusan TJKT</option>
    <option value="lulus"     <?= ($sort ?? '') == 'lulus'     ? 'selected' : '' ?>>Lulus</option>
    <option value="bersyarat" <?= ($sort ?? '') == 'bersyarat' ? 'selected' : '' ?>>Bersyarat</option>
  </select>
</div>

<script>
function applySort(val) {
  const url = new URL(window.location.href);
  if (val) {
    url.searchParams.set('sort', val);
  } else {
    url.searchParams.delete('sort');
  }
  url.searchParams.delete('page'); // reset ke halaman 1
  window.location.href = url.toString();
}
function toggleAll(cb) {
  document.querySelectorAll('.cb-row').forEach(c => c.checked = cb.checked);
  updateHapusBtn();
}
document.addEventListener('change', function(e) {
  if (e.target.classList.contains('cb-row')) updateHapusBtn();
});
function updateHapusBtn() {
  const checked = document.querySelectorAll('.cb-row:checked').length;
  const btn = document.getElementById('btnHapusTerpilih');
  btn.style.display = checked > 0 ? 'inline-flex' : 'none';
  document.getElementById('jumlahCeklist').textContent = checked;
  document.getElementById('cbAll').indeterminate =
    checked > 0 && checked < document.querySelectorAll('.cb-row').length;
}
function hapusTerpilih() {
  const ids = [...document.querySelectorAll('.cb-row:checked')].map(c => c.value);
  if (!ids.length) return;
  bukaModalHapus(
    'Hapus Data Terpilih?',
    `Yakin ingin menghapus <strong style="color:#0f172a">${ids.length} siswa</strong> yang dipilih?<br>Tindakan ini tidak dapat dibatalkan.`,
    `Hapus ${ids.length} Siswa`,
    () => {
      fetch('<?= site_url('admin/siswa/hapus_massal') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({ ids, '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>' })
      }).then(r => r.json()).then(res => {
        if (res.success) window.location.reload();
        else alert('Gagal menghapus data.');
      });
    }
  );
}

function hapusSemua() {
  const total = <?= $total ?>;
  const url   = new URL(window.location.href);
  bukaModalHapus(
    'Hapus Semua Data?',
    `Yakin ingin menghapus <strong style="color:#0f172a">semua ${total} siswa</strong> pada daftar ini?<br>Tindakan ini tidak dapat dibatalkan.`,
    'Hapus Semua',
    () => {
      fetch('<?= site_url('admin/siswa/hapus_semua') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify({
          search:  url.searchParams.get('search')  || '',
          jurusan: url.searchParams.get('jurusan') || '',
          status:  url.searchParams.get('status')  || '',
          kelas:   url.searchParams.get('kelas')   || '',
          '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        })
      }).then(r => r.json()).then(res => {
        if (res.success) window.location.href = '<?= site_url('admin/siswa') ?>';
        else alert('Gagal menghapus data: ' + (res.message || ''));
      });
    }
  );
}
</script>

<!-- Table -->
<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th style="width:36px"><input type="checkbox" class="cb-all" id="cbAll" onclick="toggleAll(this)"></th>
          <th style="width:40px">No</th>
          <th>NISN</th>
          <th>Siswa</th>
          <th>Kelas</th>
          <th>Jurusan</th>
          <th>Status Kelulusan</th>
          <th style="text-align:center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($list_siswa): $no = ($page ?? 0) + 1; foreach ($list_siswa as $s): ?>
        <tr>
          <td><input type="checkbox" class="cb-row" value="<?= $s->id ?>"></td>
          <td style="color:var(--text-muted);font-size:12px"><?= $no++ ?></td>
          <td><span class="td-nisn"><?= $s->nisn ?></span></td>
          <td>
            <div style="font-weight:600;font-size:13.5px"><?= htmlspecialchars($s->nama_siswa) ?></div>
            <div style="font-size:11.5px;color:var(--text-muted)"><?= htmlspecialchars($s->tempat_lahir) ?>, <?php
                $bulan_id = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                $tgl = $s->tanggal_lahir ? date('d', strtotime($s->tanggal_lahir)) : '';
                $bln = $s->tanggal_lahir ? (int) date('n', strtotime($s->tanggal_lahir)) : 0;
                $thn = $s->tanggal_lahir ? date('Y', strtotime($s->tanggal_lahir)) : '';
                echo $s->tanggal_lahir ? $tgl . ' ' . $bulan_id[$bln] . ' ' . $thn : '-';
                ?></div>
          </td>
          <td><span class="badge badge-secondary"><?= htmlspecialchars($s->kelas) ?></span></td>
          <td>
            <?php if (strpos($s->jurusan, 'Otomotif') !== false): ?>
            <span class="badge badge-primary"><i class="fas fa-car fa-xs"></i> TO</span>
            <?php else: ?>
            <span class="badge badge-info"><i class="fas fa-network-wired fa-xs"></i> TJKT</span>
            <?php endif; ?>
          </td>
          <td>
            <?php if ($s->kelulusan == 'Lulus'): ?>
            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Lulus</span>
            <?php else: ?>
            <span class="badge badge-warning"><i class="fas fa-exclamation-triangle"></i> Bersyarat</span>
            <?php endif; ?>
          </td>
          <td>
            <div class="btn-group" style="justify-content:center">
              <a href="<?= site_url('admin/siswa/detail/'.$s->id) ?>" class="btn-icon" title="Detail"><i class="fas fa-eye"></i></a>
              <a href="<?= site_url('admin/siswa/edit/'.$s->id) ?>" class="btn-icon success" title="Edit"><i class="fas fa-edit"></i></a>
              <button onclick="konfirmHapus('<?= site_url('admin/siswa/hapus/'.$s->id) ?>','<?= htmlspecialchars($s->nama_siswa) ?>')" class="btn-icon danger" title="Hapus"><i class="fas fa-trash"></i></button>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr><td colspan="8" style="text-align:center;padding:48px;color:var(--text-muted)">
          <i class="fas fa-search" style="font-size:32px;display:block;margin-bottom:12px;opacity:.3"></i>
          Tidak ada data siswa ditemukan
        </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
  <?php if ($pagination): ?>
<div style="padding:14px 20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
  <div style="font-size:12.5px;color:var(--text-muted)">
    Menampilkan <?= ($page ?? 0) + 1 ?>–<?= min(($page ?? 0) + 10, $total) ?> dari <?= $total ?> siswa
  </div>
  <div class="pagination-wrap"><?= $pagination ?></div>
</div>
<?php endif; ?>
</div>

<!-- Modal Import -->
<div id="modalImport" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:16px">
  <div style="background:#fff;border-radius:16px;padding:28px;max-width:480px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3)">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
      <div>
        <h3 style="font-size:16px;font-weight:800">Import Data Siswa</h3>
        <p style="font-size:12px;color:var(--text-muted);margin-top:2px">Upload file CSV/Excel sesuai template</p>
      </div>
      <button onclick="document.getElementById('modalImport').style.display='none'" style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--text-muted)">×</button>
    </div>
    <div class="alert alert-warning" style="margin-bottom:16px">
      <i class="fas fa-exclamation-triangle"></i>
      <div><strong>Perhatian!</strong> Format NISN harus 10 digit angka. Data duplikat akan dilewati otomatis.</div>
    </div>
    <form action="<?= site_url('admin/siswa/import') ?>" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
      <div class="form-group">
        <label>Pilih File (CSV, XLS, XLSX) <span class="req">*</span></label>
        <input type="file" name="file_excel" class="form-control" accept=".csv,.xls,.xlsx" required>
        <div class="form-hint">Gunakan template yang telah disediakan</div>
      </div>
      <div class="modal-actions">
        <button type="button" onclick="document.getElementById('modalImport').style.display='none'" class="btn btn-outline">Batal</button>
        <button type="submit" class="btn btn-success"><i class="fas fa-upload"></i> Upload & Import</button>
      </div>
    </form>
  </div>
</div>