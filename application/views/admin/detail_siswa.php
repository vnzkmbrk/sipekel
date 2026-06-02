<?php
function bulan_id($tanggal) {
    $bulan = ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    return date('d', strtotime($tanggal)) . ' ' . $bulan[(int)date('n', strtotime($tanggal))] . ' ' . date('Y', strtotime($tanggal));
}
?>

<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><a href="<?= site_url('admin/siswa') ?>">Data Siswa</a><span>/</span><span>Detail</span></div>
  <div class="page-title">Detail Siswa</div>
  <div class="page-subtitle">Lihat detail data peserta didik kelas XII</div>
</div>

<style>
.detail-layout {
  display: grid;
  grid-template-columns: 2fr 1fr;
  grid-template-areas:
    "main meta"
    "main aksi"
    "main .";
  grid-template-rows: auto auto 1fr;
  gap: 20px;
  align-items: start;
}
.detail-main        { grid-area: main; }
.detail-meta        { grid-area: meta; align-self: start; }
.detail-actions-card { grid-area: aksi; align-self: start; }

.detail-info-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}
.detail-card-header {
  display: flex;
  align-items: center;
  gap: 12px;
  flex-wrap: wrap;
}
.detail-actions .btn {
  width: 100%;
  justify-content: center;
  margin-bottom: 8px;
}
.detail-actions .btn:last-child {
  margin-bottom: 0;
}

@media (max-width: 900px) {
  .detail-layout {
    grid-template-columns: 1fr;
    grid-template-areas:
      "meta"
      "main"
      "aksi";
  }
  .detail-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 8px;
  }
  .detail-actions .btn {
    margin-bottom: 0;
  }
}
@media (max-width: 600px) {
  .detail-info-grid {
    grid-template-columns: 1fr;
  }
  .detail-actions {
    grid-template-columns: 1fr;
  }
  .detail-card-header .badge {
    width: 100%;
    text-align: center;
    justify-content: center;
  }
}
</style>

<div class="detail-layout">

<!-- Kiri: Konten Utama -->
<div class="detail-main">
  <!-- Identitas -->
  <div class="card" style="margin-bottom:20px">
    <div class="card-header">
      <div class="detail-card-header" style="width:100%">
        <div style="width:42px;height:42px;background:var(--primary);border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:16px;flex-shrink:0">
          <?= strtoupper(substr($siswa->nama_siswa, 0, 1)) ?>
        </div>
        <div style="flex:1;min-width:0">
          <div class="card-title" style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($siswa->nama_siswa) ?></div>
          <div style="font-size:12px;color:var(--text-muted)">NISN: <?= $siswa->nisn ?></div>
        </div>
        <?php if ($siswa->kelulusan == 'Lulus'): ?>
        <span class="badge badge-success" style="font-size:13px;padding:6px 14px;display:inline-flex;align-items:center;gap:6px"><i class="fas fa-check-circle"></i> LULUS</span>
        <?php else: ?>
        <span class="badge badge-warning" style="font-size:13px;padding:6px 14px;display:inline-flex;align-items:center;gap:6px"><i class="fas fa-exclamation-triangle"></i> BERSYARAT</span>
        <?php endif; ?>
      </div>
    </div>
    <div class="card-body">
      <div class="detail-info-grid">
        <?php
        $items = [
          ['label'=>'NISN','value'=>$siswa->nisn,'icon'=>'id-card'],
          ['label'=>'Nama Lengkap','value'=>$siswa->nama_siswa,'icon'=>'user'],
          ['label'=>'Tempat Lahir','value'=>$siswa->tempat_lahir,'icon'=>'map-marker-alt'],
          ['label'=>'Tanggal Lahir','value'=>bulan_id($siswa->tanggal_lahir),'icon'=>'birthday-cake'],
          ['label'=>'Kelas','value'=>$siswa->kelas,'icon'=>'chalkboard'],
          ['label'=>'Jurusan','value'=>$siswa->jurusan,'icon'=>'tools'],
        ];
        foreach ($items as $item): ?>
        <div style="padding:12px;background:var(--bg);border-radius:10px">
          <div style="font-size:11px;color:var(--text-muted);margin-bottom:4px"><i class="fas fa-<?= $item['icon'] ?>" style="width:14px;margin-right:4px"></i><?= $item['label'] ?></div>
          <div style="font-size:14px;font-weight:600;color:var(--text);word-break:break-word"><?= htmlspecialchars($item['value']) ?></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>

  <!-- Jadwal Bersyarat -->
  <?php if ($siswa->kelulusan == 'Lulus Bersyarat' && $siswa->tanggal_hadir): ?>
  <div class="card" style="margin-bottom:20px;border:2px solid #fde68a">
    <div class="card-header" style="background:#fffbeb">
      <i class="fas fa-calendar-check" style="color:var(--warning)"></i>
      <span class="card-title" style="color:#a16207">Jadwal Koordinasi Pemenuhan Syarat</span>
    </div>
    <div class="card-body">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <div style="padding:14px;background:#fffbeb;border-radius:10px;border:1px solid #fde68a">
          <div style="font-size:11px;color:#a16207;margin-bottom:4px">Tanggal Hadir</div>
          <div style="font-size:15px;font-weight:700;color:#a16207"><?= bulan_id($siswa->tanggal_hadir) ?></div>
        </div>
        <div style="padding:14px;background:#fffbeb;border-radius:10px;border:1px solid #fde68a">
          <div style="font-size:11px;color:#a16207;margin-bottom:4px">Pukul</div>
          <div style="font-size:15px;font-weight:700;color:#a16207"><?= $siswa->pukul_hadir ? date('H:i', strtotime($siswa->pukul_hadir)) : '-' ?> WIB</div>
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- Catatan -->
  <?php if ($siswa->catatan): ?>
  <div class="card">
    <div class="card-header"><i class="fas fa-sticky-note" style="color:var(--info)"></i><span class="card-title">Catatan</span></div>
    <div class="card-body" style="color:var(--text-muted);font-size:13.5px;line-height:1.7"><?= nl2br(htmlspecialchars($siswa->catatan)) ?></div>
  </div>
  <?php endif; ?>
</div>

<!-- Kanan: Meta -->
<div class="card detail-meta" style="align-self:start">
  <div class="card-body" style="font-size:12px;color:var(--text-muted)">
    <div style="margin-bottom:8px"><i class="fas fa-clock" style="width:16px"></i> Ditambahkan: <?= bulan_id($siswa->created_at) . ' ' . date('H:i', strtotime($siswa->created_at)) ?></div>
    <div><i class="fas fa-edit" style="width:16px"></i> Diperbarui: <?= bulan_id($siswa->updated_at) . ' ' . date('H:i', strtotime($siswa->updated_at)) ?></div>
  </div>
</div>

<!-- Kanan: Aksi -->
<div class="card detail-actions-card" style="align-self:start">
  <div class="card-body">
    <div class="detail-actions">
      <a href="<?= site_url('admin/siswa/edit/'.$siswa->id) ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Edit Data</a>
      <a href="<?= site_url('cetak/'.$siswa->nisn) ?>" class="btn btn-info" target="_blank"><i class="fas fa-print"></i> Cetak Surat</a>
      <button onclick="konfirmHapus('<?= site_url('admin/siswa/hapus/'.$siswa->id) ?>','<?= htmlspecialchars($siswa->nama_siswa) ?>')" class="btn btn-danger"><i class="fas fa-trash"></i> Hapus Data</button>
      <a href="<?= site_url('admin/siswa') ?>" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>
  </div>
</div>

</div>