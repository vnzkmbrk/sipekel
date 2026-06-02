# 🎓 Sistem Pengumuman Kelulusan SMK
### Berbasis CodeIgniter 3

---

## 📋 Daftar Isi
1. [Persyaratan Sistem](#persyaratan)
2. [Instalasi Cepat](#instalasi-cepat)
3. [Konfigurasi Database](#konfigurasi-database)
4. [Konfigurasi Aplikasi](#konfigurasi-aplikasi)
5. [Default Login](#default-login)
6. [Panduan Penggunaan](#panduan-penggunaan)
7. [Fitur Lengkap](#fitur)
8. [Troubleshooting](#troubleshooting)

---

## ✅ Persyaratan Sistem {#persyaratan}

| Komponen | Versi Minimum |
|----------|--------------|
| PHP | 7.4 atau lebih tinggi |
| MySQL / MariaDB | 5.7 / 10.3 |
| Apache | 2.4 (dengan mod_rewrite) |
| XAMPP / Laragon | Terbaru |
| Browser | Chrome, Firefox, Edge (modern) |

---

## 🚀 Instalasi Cepat {#instalasi-cepat}

### Langkah 1 — Download & Ekstrak CodeIgniter 3

```bash
# Download CodeIgniter 3 dari: https://codeigniter.com/download
# Ekstrak ke folder htdocs (XAMPP) atau www (Laragon)
```

### Langkah 2 — Salin File Proyek

```
htdocs/
└── smk_kelulusan/          ← Folder aplikasi
    ├── application/        ← Semua file dari folder ini
    ├── system/             ← System CI (dari download CI3)
    ├── assets/             ← CSS, JS, Gambar
    ├── uploads/
    │   └── excel/          ← Buat folder ini (permission 755)
    ├── index.php
    └── .htaccess
```

> **Penting:** Folder `system/` diambil dari paket CodeIgniter 3 yang Anda download. Tidak disertakan dalam proyek ini.

### Langkah 3 — Setup Database

1. Buka **phpMyAdmin** (http://localhost/phpmyadmin)
2. Buat database baru: `smk_kelulusan`
3. Import file **`database.sql`** yang ada di root proyek
4. Selesai! Data contoh sudah otomatis terisi

```sql
-- Atau jalankan via command line:
mysql -u root -p < database.sql
```

### Langkah 4 — Konfigurasi Database

Edit file: `application/config/database.php`

```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',        // ← Ganti username MySQL Anda
    'password' => '',            // ← Ganti password MySQL Anda
    'database' => 'smk_kelulusan',
    // ... sisanya biarkan default
);
```

### Langkah 5 — Konfigurasi Base URL

Edit file: `application/config/config.php`

```php
// Untuk XAMPP:
$config['base_url'] = 'http://localhost/smk_kelulusan/';

// Untuk domain live:
$config['base_url'] = 'https://namadomainanda.com/';
```

### Langkah 6 — Buat Tabel Session

Jalankan SQL berikut di phpMyAdmin:

```sql
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id`         varchar(128) NOT NULL,
  `ip_address` varchar(45)  NOT NULL,
  `timestamp`  int(10) unsigned DEFAULT 0 NOT NULL,
  `data`       blob NOT NULL,
  PRIMARY KEY (`id`),
  KEY `ci_sessions_timestamp` (`timestamp`)
);
```

### Langkah 7 — Akses Aplikasi

```
Halaman Siswa : http://localhost/smk_kelulusan/
Panel Admin   : http://localhost/smk_kelulusan/login
```

---

## 🔑 Default Login {#default-login}

| Role | Username | Password |
|------|----------|----------|
| **Admin** | `admin` | `password` |
| **Petugas** | `petugas` | `password` |

> ⚠️ **WAJIB** ganti password setelah pertama kali login!

---

## ⚙️ Konfigurasi Aplikasi {#konfigurasi-aplikasi}

### Pengaturan Profil Sekolah
1. Login sebagai Admin
2. Klik menu **"Profil Sekolah"**
3. Isi semua informasi sekolah
4. **Atur Tanggal & Jam Pengumuman** — ini menentukan kapan siswa bisa mengakses pengumuman
5. Klik **Simpan Perubahan**

### Import Data Siswa via CSV
Format CSV yang diperlukan:
```
NISN,Nama Siswa,Tempat Lahir,Tanggal Lahir (YYYY-MM-DD),Kelas,Jurusan,Status Kelulusan
1234567890,Ahmad Fauzi,Banjarnegara,2007-03-15,XII TO 1,Teknik Otomotif,Lulus
0987654321,Siti Rahayu,Purbalingga,2007-07-22,XII TKJ 1,Teknik Jaringan Komputer dan Telekomunikasi,Lulus Bersyarat
```

> Download template CSV di: **Admin → Data Siswa → Template CSV**

---

## 📖 Panduan Penggunaan {#panduan-penggunaan}

### Role Admin
- ✅ Dashboard statistik real-time
- ✅ Kelola profil & jadwal pengumuman sekolah
- ✅ CRUD data siswa + import massal via CSV
- ✅ Kelola akun pengguna (admin & petugas)
- ✅ Lihat statistik & grafik kelulusan
- ✅ Monitor log aktivitas sistem

### Role Petugas
- ✅ Sama seperti admin, kecuali manajemen pengguna

### Role Siswa (Publik)
1. Buka halaman utama
2. Tunggu hingga jadwal pengumuman tiba (countdown otomatis)
3. Masukkan NISN (10 digit angka)
4. Lihat hasil: **LULUS** atau **LULUS BERSYARAT**
5. Cetak surat/bukti jika diperlukan

---

## 🌟 Fitur Lengkap {#fitur}

### Halaman Siswa
- 🕐 Countdown timer menuju waktu pengumuman
- 🔒 Akses dikunci otomatis sebelum jadwal
- 📱 Responsive mobile & desktop
- 🎓 Tampilan hasil lulus dengan animasi
- 📋 Undangan resmi untuk Lulus Bersyarat
- 🖨️ Fitur cetak surat/bukti kelulusan

### Panel Admin
- 📊 Dashboard dengan statistik & grafik
- 🏫 Pengaturan profil sekolah lengkap
- 👩‍🎓 CRUD data siswa dengan filter & pencarian
- 📥 Import data massal via CSV
- 👤 Manajemen pengguna multi-role
- 📈 Statistik kelulusan dengan Chart.js
- 📋 Log aktivitas sistem

---

## 🔧 Troubleshooting {#troubleshooting}

### Error 404 / Halaman tidak ditemukan
```apache
# Pastikan mod_rewrite aktif di Apache
# Uncomment di httpd.conf:
LoadModule rewrite_module modules/mod_rewrite.so

# Dan di virtual host:
AllowOverride All
```

### Error Session
```php
// Pastikan tabel ci_sessions sudah dibuat (lihat Langkah 6)
// Atau ganti driver session ke file:
$config['sess_driver'] = 'files';
$config['sess_save_path'] = APPPATH.'cache/';
```

### Error Database Connection
- Pastikan MySQL berjalan (cek XAMPP Control Panel)
- Periksa username/password di `database.php`
- Pastikan database `smk_kelulusan` sudah dibuat

### Import CSV Gagal
- Pastikan format NISN 10 digit angka
- Gunakan template CSV resmi
- Encoding file harus UTF-8

### Gambar/CSS tidak muncul
- Pastikan `base_url` di `config.php` sudah benar
- Periksa folder `assets/` ada di root proyek

---

## 📁 Struktur Proyek

```
smk_kelulusan/
├── application/
│   ├── config/
│   │   ├── config.php          ← Konfigurasi utama
│   │   ├── database.php        ← Koneksi database
│   │   ├── routes.php          ← Routing URL
│   │   └── autoload.php        ← Library otomatis
│   ├── controllers/
│   │   ├── Auth.php            ← Login/logout
│   │   ├── Beranda.php         ← Halaman siswa
│   │   └── Admin.php           ← Panel admin
│   ├── core/
│   │   └── MY_Controller.php   ← Base controller
│   ├── models/
│   │   ├── Profil_model.php
│   │   ├── Siswa_model.php
│   │   ├── Pengguna_model.php
│   │   └── Log_model.php
│   └── views/
│       ├── auth/login.php
│       ├── admin/              ← Semua view admin
│       ├── siswa/              ← Halaman publik siswa
│       └── templates/          ← Header & footer
├── system/                     ← CI3 Core (download sendiri)
├── uploads/excel/              ← Upload file import
├── database.sql                ← Script database
├── index.php
└── .htaccess
```

---

## 🛡️ Keamanan

- Password di-hash menggunakan `password_hash()` (BCrypt)
- CSRF Protection aktif pada semua form
- Session berbasis database
- Input sanitization & validation
- XSS filtering aktif
- Log seluruh aktivitas admin

---

## 📞 Informasi

Sistem Pengumuman Kelulusan  
Tahun Pelajaran 2024/2025

---

Dibuat dengan ❤️ oleh [Ivan Zaka Mubarok](https://github.com/vnzkmbrk) menggunakan CodeIgniter 3
