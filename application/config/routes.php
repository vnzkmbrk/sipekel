<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Beranda';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Auth routes
$route['login'] = 'Auth/login';
$route['logout'] = 'Auth/logout';
$route['proses_login'] = 'Auth/proses_login';

// Siswa - cek kelulusan
$route['cek'] = 'Beranda/cek';
$route['cek/(:any)'] = 'Beranda/cek/$1';
$route['cetak/(:any)'] = 'Beranda/cetak/$1';

// Siswa - hasil & notif
$route['hasil/(:any)'] = 'Beranda/hasil/$1';

// Admin - notifikasi WA
$route['admin/blast_wa'] = 'Admin/blast_wa';
$route['admin/daftar_notif'] = 'Admin/daftar_notif';
$route['admin/list_notif'] = 'Admin/list_notif';

// Admin routes
$route['admin'] = 'Admin/dashboard';
$route['admin/dashboard'] = 'Admin/dashboard';
$route['admin/profil'] = 'Admin/profil';
$route['admin/profil/update'] = 'Admin/update_profil';

$route['admin/siswa'] = 'Admin/siswa';
$route['admin/siswa/tambah'] = 'Admin/tambah_siswa';
$route['admin/siswa/simpan'] = 'Admin/simpan_siswa';
$route['admin/siswa/edit/(:num)'] = 'Admin/edit_siswa/$1';
$route['admin/siswa/update/(:num)'] = 'Admin/update_siswa/$1';
$route['admin/siswa/hapus/(:num)'] = 'Admin/hapus_siswa/$1';
$route['admin/siswa/detail/(:num)'] = 'Admin/detail_siswa/$1';
$route['admin/siswa/import'] = 'Admin/import_siswa';
$route['admin/siswa/template_excel'] = 'Admin/template_excel';
$route['admin/siswa/hapus_massal'] = 'Admin/hapus_massal';
$route['admin/siswa/hapus_semua'] = 'Admin/hapus_semua';

$route['admin/pengguna'] = 'Admin/pengguna';
$route['admin/pengguna/tambah'] = 'Admin/tambah_pengguna';
$route['admin/pengguna/simpan'] = 'Admin/simpan_pengguna';
$route['admin/pengguna/edit/(:num)'] = 'Admin/edit_pengguna/$1';
$route['admin/pengguna/update/(:num)'] = 'Admin/update_pengguna/$1';
$route['admin/pengguna/hapus/(:num)'] = 'Admin/hapus_pengguna/$1';

$route['admin/log'] = 'Admin/log_aktivitas';
$route['admin/statistik'] = 'Admin/statistik';