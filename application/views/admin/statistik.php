<div class="page-header">
  <div class="breadcrumb"><a href="<?= site_url('admin/dashboard') ?>">Dashboard</a><span>/</span><span>Statistik</span></div>
  <div class="page-title">Statistik Kelulusan</div>
  <div class="page-subtitle">Visualisasi data kelulusan siswa tahun ini</div>
</div>

<style>
.chart-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 20px;
  align-items: stretch;
}
.chart-grid .card {
  display: flex;
  flex-direction: column;
}
.chart-wrap {
  display: flex;
  align-items: center;
  justify-content: center;
  flex: 1;
  height: 320px;
  min-height: 260px;
}
@media (max-width: 640px) {
  .chart-grid {
    grid-template-columns: 1fr;
  }
  .chart-wrap {
    height: 260px;
  }
}
</style>

<div class="chart-grid">
  <!-- Chart Status -->
  <div class="card">
    <div class="card-header"><i class="fas fa-chart-pie" style="color:var(--primary)"></i><span class="card-title">Status Kelulusan</span></div>
    <div class="card-body chart-wrap">
      <canvas id="chartStatus"></canvas>
    </div>
  </div>
  <!-- Chart Jurusan -->
  <div class="card">
    <div class="card-header"><i class="fas fa-chart-bar" style="color:var(--success)"></i><span class="card-title">Per Jurusan</span></div>
    <div class="card-body chart-wrap">
      <canvas id="chartJurusan"></canvas>
    </div>
  </div>
</div>

<!-- Chart Per Kelas -->
<div class="card">
  <div class="card-header"><i class="fas fa-chart-bar" style="color:var(--warning)"></i><span class="card-title">Per Kelas & Status</span></div>
  <div class="card-body" style="height:320px">
    <canvas id="chartKelas"></canvas>
  </div>
</div>

<!-- Table Rekap Per Kelas -->
<?php
$rekap_kelas = [];
foreach ($chart_kelas as $row) {
  $rekap_kelas[$row->kelas][$row->kelulusan] = $row->total;
}
?>
<div class="card" style="margin-top:20px">
  <div class="card-header"><i class="fas fa-table" style="color:var(--info)"></i><span class="card-title">Rekapitulasi Per Kelas</span></div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th style="min-width:100px">Kelas</th><th>Lulus</th><th>Bersyarat</th><th>Total</th><th>%Lulus</th></tr>
      </thead>
      <tbody>
        <?php foreach ($rekap_kelas as $kls => $data): ?>
        <?php
          $l = $data['Lulus'] ?? 0;
          $b = $data['Lulus Bersyarat'] ?? 0;
          $total = $l + $b;
          $pct = $total > 0 ? round(($l/$total)*100) : 0;
        ?>
        <tr>
          <td style="min-width:100px;white-space:nowrap">
            <span class="badge badge-secondary"><?= htmlspecialchars($kls) ?></span>
          </td>
          <td><span class="badge badge-success"><?= $l ?></span></td>
          <td><span class="badge badge-warning"><?= $b ?></span></td>
          <td style="font-weight:700"><?= $total ?></td>
          <td>
            <div style="display:flex;align-items:center;gap:8px">
              <div style="flex:1;background:var(--bg);border-radius:99px;height:8px;min-width:60px"><div style="background:var(--success);height:100%;border-radius:99px;width:<?= $pct ?>%"></div></div>
              <span style="font-size:12px;font-weight:600;color:var(--text-muted)"><?= $pct ?>%</span>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// Status Chart
const statusData = <?= json_encode(array_values((array)$chart_status)) ?>;
const statusLabels = statusData.map(d => d.kelulusan === 'Lulus Bersyarat' ? 'Bersyarat' : d.kelulusan);
const statusValues = statusData.map(d => parseInt(d.total));
new Chart(document.getElementById('chartStatus'), {
  type: 'doughnut',
  data: {
    labels: statusLabels,
    datasets: [{data: statusValues, backgroundColor: ['#10b981','#f59e0b'], borderWidth:3, borderColor:'#fff'}]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {position:'bottom', labels:{padding:20, font:{family:'Poppins', size:13}}},
      tooltip: {callbacks:{label: ctx => ` ${ctx.label}: ${ctx.raw} siswa`}}
    }
  }
});

// Jurusan Chart
const jurusanData = <?= json_encode(array_values((array)$chart_jurusan)) ?>;
const jurusanLabels = jurusanData.map(d => d.jurusan.includes('Otomotif') ? 'TO' : 'TJKT');
const jurusanValues = jurusanData.map(d => parseInt(d.total));
new Chart(document.getElementById('chartJurusan'), {
  type: 'bar',
  data: {
    labels: jurusanLabels,
    datasets: [{label:'Jumlah Siswa', data: jurusanValues, backgroundColor:['#3b82f6','#8b5cf6'], borderRadius:8, borderSkipped:false}]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {legend:{display:false}},
    scales: {y:{beginAtZero:true, grid:{color:'rgba(0,0,0,.05)'}}, x:{grid:{display:false}}}
  }
});

// Kelas Chart
const kelasRaw = <?= json_encode(array_values((array)$chart_kelas)) ?>;
const kelasNames = [...new Set(kelasRaw.map(d => d.kelas))];
const lulusData = kelasNames.map(k => { const f=kelasRaw.find(r=>r.kelas===k&&r.kelulusan==='Lulus'); return f?parseInt(f.total):0; });
const bersyaratData = kelasNames.map(k => { const f=kelasRaw.find(r=>r.kelas===k&&r.kelulusan==='Lulus Bersyarat'); return f?parseInt(f.total):0; });
new Chart(document.getElementById('chartKelas'), {
  type: 'bar',
  data: {
    labels: kelasNames,
    datasets: [
      {label:'Lulus', data: lulusData, backgroundColor:'#10b981', borderRadius:6, borderSkipped:false},
      {label:'Bersyarat', data: bersyaratData, backgroundColor:'#f59e0b', borderRadius:6, borderSkipped:false}
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {legend:{position:'top'}},
    scales: {
      x:{stacked:false, grid:{display:false}},
      y:{stacked:false, beginAtZero:true, grid:{color:'rgba(0,0,0,.05)'}}
    }
  }
});
</script>