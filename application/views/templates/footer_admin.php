</div><!-- main-content -->

<!-- ── FOOTER ── -->
<footer style="background:var(--secondary);color:#fff;padding:48px 32px 0;margin-top:auto">
  <div style="display:grid;grid-template-columns:1.6fr 1fr 1.3fr;gap:48px;padding-bottom:36px;border-bottom:1px solid rgba(255,255,255,.1)">

    <!-- Kolom 1: Nama Aplikasi -->
    <div>
      <div style="display:flex;align-items:center;gap:14px;margin-bottom:14px">
        <div style="width:64px;height:64px;background:rgba(255,255,255,.08);border-radius:16px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:1px solid rgba(255,255,255,.12)">
          <?php if (file_exists(FCPATH . 'uploads/pbr.png')): ?>
          <img src="<?= base_url('uploads/pbr.png') ?>" alt="Logo" style="width:44px;height:44px;object-fit:contain">
          <?php else: ?>
          <i class="fas fa-graduation-cap" style="font-size:26px;color:#fff"></i>
          <?php endif; ?>
        </div>
        <div style="font-size:20px;font-weight:800;color:#fff;letter-spacing:-.3px">
          SIPEKEL
        </div>
      </div>
      <p style="font-size:13px;color:rgba(255,255,255,.5);line-height:1.75;margin:0;max-width:300px">
        <?= htmlspecialchars($profil->deskripsi ?? 'Sistem Pengumuman Kelulusan') ?>
      </p>
    </div>

    <!-- Kolom 2: Tautan Cepat -->
    <div>
      <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:18px">Tautan Cepat</div>
      <ul style="list-style:none;padding:0;margin:0">
        <?php
          $footerLinks = [
            ['url' => 'admin/dashboard', 'label' => 'Dashboard',     'icon' => 'fa-chart-pie'],
            ['url' => 'admin/profil',    'label' => 'Profil Sekolah', 'icon' => 'fa-school'],
            ['url' => 'admin/siswa',     'label' => 'Data Siswa',     'icon' => 'fa-users'],
            ['url' => 'admin/statistik', 'label' => 'Statistik',      'icon' => 'fa-chart-bar'],
          ];
          foreach ($footerLinks as $fl): ?>
        <li style="margin-bottom:12px">
          <a href="<?= site_url($fl['url']) ?>"
             style="font-size:13.5px;color:rgba(255,255,255,.55);text-decoration:none;display:flex;align-items:center;gap:10px;transition:color .2s"
             onmouseover="this.style.color='#fff'" onmouseout="this.style.color='rgba(255,255,255,.55)'">
            <i class="fas <?= $fl['icon'] ?>" style="font-size:12px;width:16px;text-align:center"></i>
            <?= $fl['label'] ?>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Kolom 3: Developed By -->
    <div>
      <div style="font-size:14px;font-weight:700;color:#fff;margin-bottom:18px">Developed By</div>

      <!-- Dev Card -->
      <div style="background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);border-radius:14px;padding:16px 18px;margin-bottom:16px">
        <div style="display:flex;align-items:center;gap:13px">
          <div style="width:46px;height:46px;background:var(--primary);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <span style="font-size:14px;font-weight:700;color:#fff;font-family:monospace">&lt;/&gt;</span>
          </div>
          <div>
            <div style="font-size:15px;font-weight:700;color:#fff">Ivan Zaka Mubarok</div>
            <div style="font-size:12px;color:rgba(255,255,255,.5);margin-top:3px">Full Stack Developer</div>
          </div>
        </div>
      </div>

      <!-- Social Icons -->
      <div style="display:flex;gap:10px">
        <a href="https://github.com/vnzkmbrk" target="_blank"
           style="width:38px;height:38px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:background .2s"
           onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
          <i class="fab fa-github" style="font-size:15px"></i>
        </a>
        <a href="https://www.linkedin.com/in/IvanZakaM" target="_blank"
           style="width:38px;height:38px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:background .2s"
           onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
          <i class="fab fa-linkedin" style="font-size:15px"></i>
        </a>
        <a href="https://instagram.com/vnzkmbrk" target="_blank"
           style="width:38px;height:38px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:background .2s"
           onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
          <i class="fab fa-instagram" style="font-size:15px"></i>
        </a>
        <a href="mailto:ivanzakamubarok@gmail.com"
           style="width:38px;height:38px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;transition:background .2s"
           onmouseover="this.style.background='rgba(255,255,255,.2)'" onmouseout="this.style.background='rgba(255,255,255,.08)'">
          <i class="fas fa-envelope" style="font-size:15px"></i>
        </a>
      </div>
    </div>
  </div>

  <!-- Bottom bar -->
  <div style="display:flex;align-items:center;justify-content:space-between;padding:16px 0;font-size:12.5px;color:rgba(255,255,255,.35);flex-wrap:wrap;gap:8px">
    <span>&copy; <?= date('Y') ?> <?= htmlspecialchars($profil->nama_aplikasi ?? 'Sistem Kelulusan') ?>. Seluruh Hak Cipta Dilindungi.</span>
    <span style="background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);padding:4px 12px;border-radius:20px;font-size:12px;color:rgba(255,255,255,.5)">Version 1.0.0</span>
  </div>
</footer>

<style>
@media (max-width: 768px) {

  /* Grid jadi 1 kolom */
  footer > div:first-child {
    grid-template-columns: 1fr !important;
    gap: 28px !important;
    text-align: center;
  }

  /* Khusus konten tiap kolom */
  footer > div:first-child > div {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  /* Link rata tengah */
  footer ul li a {
    justify-content: center;
  }

  /* Logo + nama */
  footer > div:first-child > div:first-child > div {
    justify-content: center !important;
  }

  /* Social icon */
  footer div[style*="display:flex;gap:10px"] {
    justify-content: center !important;
  }

  /* Bottom bar */
  footer > div:last-child {
    flex-direction: column;
    text-align: center;
    gap: 6px;
  }
}
</style>

</div><!-- main-wrap -->

<!-- Modal Konfirmasi Hapus -->
<!-- Modal Konfirmasi Hapus -->
<div id="modalHapus" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(4px)">
  <div style="background:#fff;border-radius:16px;padding:28px;max-width:380px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);animation:modalIn .2s ease">
    <div style="width:56px;height:56px;background:#fef2f2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px;color:#ef4444">
      <i class="fas fa-trash"></i>
    </div>
    <div style="text-align:center;margin-bottom:20px">
      <div id="modalHapusTitle" style="font-size:17px;font-weight:700;color:#0f172a;margin-bottom:6px">Hapus Data?</div>
      <div id="modalHapusMsg" style="font-size:13px;color:#64748b;line-height:1.6"></div>
    </div>
    <div style="display:flex;gap:10px">
      <button id="modalHapusBtn" style="flex:1;padding:11px;border-radius:10px;border:none;background:#ef4444;font-size:14px;font-weight:600;color:#fff;cursor:pointer;font-family:inherit;transition:all .2s" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
        <i class="fas fa-trash"></i> <span id="modalHapusBtnLabel">Hapus</span>
      </button>
      <button onclick="tutupModalHapus()" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;font-size:14px;font-weight:600;color:#64748b;cursor:pointer;font-family:inherit;transition:all .2s" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
        Batal
      </button>
    </div>
  </div>
</div>

<!-- Modal Konfirmasi Logout -->
<div id="modalLogout" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:9999;align-items:center;justify-content:center;padding:16px;backdrop-filter:blur(4px)">
  <div style="background:#fff;border-radius:16px;padding:28px;max-width:380px;width:100%;box-shadow:0 20px 60px rgba(0,0,0,.3);animation:modalIn .2s ease">
    <div style="width:56px;height:56px;background:#fef2f2;border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:24px;color:#ef4444">
      <i class="fas fa-sign-out-alt"></i>
    </div>
    <div style="text-align:center;margin-bottom:20px">
      <div style="font-size:17px;font-weight:700;color:#0f172a;margin-bottom:6px">Keluar dari Sistem?</div>
      <div style="font-size:13px;color:#64748b;line-height:1.6">Sesi Anda akan diakhiri. Anda perlu login kembali untuk mengakses panel.</div>
    </div>
    <div style="display:flex;gap:10px">
      <a href="<?= site_url('logout') ?>" style="flex:1;padding:11px;border-radius:10px;border:none;background:#ef4444;font-size:14px;font-weight:600;color:#fff;cursor:pointer;font-family:inherit;transition:all .2s;display:flex;align-items:center;justify-content:center;gap:6px;text-decoration:none" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
        <i class="fas fa-sign-out-alt"></i> Keluar
      </a>
      <button onclick="tutupModalLogout()" style="flex:1;padding:11px;border-radius:10px;border:1.5px solid #e2e8f0;background:#fff;font-size:14px;font-weight:600;color:#64748b;cursor:pointer;font-family:inherit;transition:all .2s" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#fff'">
        Batal
      </button>
    </div>
  </div>
</div>

<style>
@keyframes modalIn {
  from { transform: scale(.95); opacity: 0; }
  to   { transform: scale(1);   opacity: 1; }
}
</style>

<script>
let _hapusUrl = '';

// Fungsi inti — dipakai semua aksi hapus
function bukaModalHapus(title, msg, btnLabel, onConfirm) {
  document.getElementById('modalHapusTitle').textContent   = title;
  document.getElementById('modalHapusMsg').innerHTML       = msg;
  document.getElementById('modalHapusBtnLabel').textContent = btnLabel;
  document.getElementById('modalHapusBtn').onclick = function() {
    tutupModalHapus();
    onConfirm();
  };
  document.getElementById('modalHapus').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

// Hapus per baris (sudah ada, sekarang pakai bukaModalHapus)
function konfirmHapus(url, nama) {
  bukaModalHapus(
    'Hapus Data?',
    `Yakin ingin menghapus <strong style="color:#0f172a">${nama}</strong>?<br>Tindakan ini tidak dapat dibatalkan.`,
    'Hapus',
    () => { window.location.href = url; }
  );
}

function tutupModalHapus() {
  document.getElementById('modalHapus').style.display = 'none';
  document.body.style.overflow = '';
}

function konfirmLogout() {
  document.getElementById('modalLogout').style.display = 'flex';
  document.body.style.overflow = 'hidden';
}

function tutupModalLogout() {
  document.getElementById('modalLogout').style.display = 'none';
  document.body.style.overflow = '';
}

document.getElementById('modalHapus').addEventListener('click', function(e) {
  if (e.target === this) tutupModalHapus();
});

document.getElementById('modalLogout').addEventListener('click', function(e) {
  if (e.target === this) tutupModalLogout();
});

function toggleSidebar() {
  const sb = document.getElementById('sidebar');
  const ov = document.getElementById('sidebarOverlay');
  const mw = document.querySelector('.main-wrap');
  const tb = document.querySelector('.topbar');
  const isMobile = window.innerWidth <= 768;

  if (isMobile) {
    const isOpen = sb.classList.contains('open');
    sb.classList.toggle('open');
    ov.classList.toggle('show');
    document.body.style.overflow = isOpen ? '' : 'hidden';
  } else {
    sb.classList.toggle('collapsed');
    mw.classList.toggle('expanded');
    tb.classList.toggle('expanded');
  }
}

document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    if (document.getElementById('modalHapus').style.display === 'flex') {
      tutupModalHapus();
    } else if (document.getElementById('modalLogout').style.display === 'flex') {
      tutupModalLogout();
    } else if (document.getElementById('sidebar').classList.contains('open')) {
      toggleSidebar();
    }
  }
});

document.querySelectorAll('.alert').forEach(a => {
  setTimeout(() => {
    a.style.transition = 'opacity .5s';
    a.style.opacity = '0';
    setTimeout(() => a.remove(), 500);
  }, 5000);
});

function togglePass(id) {
  const el = document.getElementById(id);
  const icon = event.currentTarget.querySelector('i');
  if (el.type === 'password') {
    el.type = 'text';
    icon.className = 'fas fa-eye-slash';
  } else {
    el.type = 'password';
    icon.className = 'fas fa-eye';
  }
}
</script>
</body>
</html>