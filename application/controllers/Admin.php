<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Siswa_model', 'Pengguna_model', 'Profil_model', 'Log_model']);
        $this->load->library('form_validation');
    }

    // =============================================
    // DASHBOARD
    // =============================================
    public function dashboard() {
        $data = [
            'title'              => 'Dashboard',
            'user'            => $this->session->userdata(),
            'total_siswa'        => $this->Siswa_model->count_all(),
            'total_lulus'        => $this->Siswa_model->count_by_status('Lulus'),
            'total_bersyarat'    => $this->Siswa_model->count_by_status('Lulus Bersyarat'),
            'total_to'           => $this->Siswa_model->count_by_jurusan('Teknik Otomotif'),
            'total_tkj'          => $this->Siswa_model->count_by_jurusan('Teknik Jaringan Komputer dan Telekomunikasi'),
            'siswa_terbaru'      => $this->Siswa_model->get_all(5),
            'log_terbaru'        => $this->Log_model->get_recent(5),
        ];
        $this->render('admin/dashboard', $data);
    }

    // =============================================
    // PROFIL SEKOLAH
    // =============================================
    public function profil() {
        $data = ['title' => 'Profil Sekolah'];
        $this->render('admin/profil', $data);
    }

    public function update_profil() {
        $this->form_validation->set_rules('nama_sekolah', 'Nama Sekolah', 'required|trim', [
            'required' => 'Nama Sekolah wajib diisi.',
        ]);
        $this->form_validation->set_rules('nama_aplikasi', 'Nama Aplikasi', 'required|trim', [
            'required' => 'Nama Aplikasi wajib diisi.',
        ]);
        $this->form_validation->set_rules('tahun_pelajaran', 'Tahun Pelajaran', 'required|trim', [
            'required' => 'Tahun Pelajaran wajib diisi.',
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect('admin/profil');
        }

        $data = [
            'nama_sekolah'         => $this->input->post('nama_sekolah', TRUE),
            'nama_aplikasi'        => $this->input->post('nama_aplikasi', TRUE),
            'tahun_pelajaran'      => $this->input->post('tahun_pelajaran', TRUE),
            'tanggal_pengumuman'   => $this->input->post('tanggal_pengumuman', TRUE),
            'jam_pengumuman'       => $this->input->post('jam_pengumuman', TRUE),
            'alamat_sekolah'       => $this->input->post('alamat_sekolah', TRUE),
            'kepala_sekolah'       => $this->input->post('kepala_sekolah', TRUE),
            'nip_kepala_sekolah'   => $this->input->post('nip_kepala_sekolah', TRUE),
            'npsn'                 => $this->input->post('npsn', TRUE),
        ];

        $this->Profil_model->update($data);
        $this->_generate_profil_json();
        $this->log_aksi('Update Profil', 'Update profil sekolah');
        $this->session->set_flashdata('success', 'Profil sekolah berhasil diperbarui!');
        redirect('admin/profil');
    }

    // =============================================
    // NOTIFIKASI WA - FONNTE
    // =============================================
    public function daftar_notif() {
        $this->output->set_content_type('application/json');

        $nomor = $this->input->post('nomor', TRUE);
        $nomor = preg_replace('/\D/', '', $nomor);

        // Konversi 08xx → 628xx
        if (substr($nomor, 0, 1) === '0') {
            $nomor = '62' . substr($nomor, 1);
        }

        if (strlen($nomor) < 10) {
            echo json_encode(['success' => false, 'message' => 'Nomor tidak valid']);
            return;
        }

        // Cek duplikat
        $cek = $this->db->where('nomor', $nomor)->get('notif_wa')->row();
        if ($cek) {
            echo json_encode(['success' => true, 'message' => 'Nomor sudah terdaftar']);
            return;
        }

        $this->db->insert('notif_wa', [
            'nomor'      => $nomor,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        echo json_encode(['success' => true, 'message' => 'Berhasil didaftarkan']);
    }

    public function blast_wa() {
        //$this->only_admin();
        $this->output->set_content_type('application/json');

        $profil = $this->Profil_model->get_profil();
        $list   = $this->db->get('notif_wa')->result();

        if (empty($list)) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada nomor terdaftar']);
            return;
        }

        // Sesudah
        $bulan_id = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        $tgl = '-';
        if ($profil->tanggal_pengumuman) {
            $ts  = strtotime($profil->tanggal_pengumuman);
            $tgl = date('d', $ts) . ' ' . $bulan_id[(int) date('n', $ts)] . ' ' . date('Y', $ts);
        }
        $jam = $profil->jam_pengumuman
            ? date('H:i', strtotime($profil->jam_pengumuman))
            : '-';

        // Tambahkan ini sebelum $pesan
        $hari_id = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        $hari = $profil->tanggal_pengumuman 
            ? $hari_id[date('w', strtotime($profil->tanggal_pengumuman))] 
            : '-';

        $pesan = "🎉 *PENGUMUMAN KELULUSAN RESMI*\n"
            . "*" . ($profil->nama_sekolah ?? 'SMK') . "*\n"
            . "Tahun Pelajaran " . ($profil->tahun_pelajaran ?? '') . "\n"
            . "Assalamu'alaikum Wr. Wb.\n\n"
            . "Dengan hormat, kami informasikan bahwa *Pengumuman Kelulusan* siswa/i "
            . ($profil->nama_sekolah ?? 'SMK') . " Tahun Pelajaran "
            . ($profil->tahun_pelajaran ?? '') . " telah resmi dibuka.\n\n"
            . "📅 *Hari/Tanggal :* {$hari}, {$tgl}\n"
            . "⏰ *Pukul        :* {$jam} WIB\n\n"
            . "Silakan cek status kelulusan melalui portal resmi kami di:\n"
            . "🔗 " . site_url('/') . "\n\n"
            . "Masukkan *NISN* (10 digit) untuk melihat hasil kelulusan.\n\n"
            . "Wassalamu'alaikum Wr. Wb.\n\n"
            . "_" . ($profil->nama_sekolah ?? 'SMK') . "_\n"
            . "_" . ($profil->alamat_sekolah ?? '') . "_\n\n"
            . "_Pesan ini dikirim otomatis oleh sistem. Mohon tidak membalas pesan ini._\n\n"
            . "_Developed by Ivan Zaka Mubarok · v1.0.0_";

        $sukses = 0;
        $gagal  = 0;

        foreach ($list as $row) {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => [
                    'target'  => $row->nomor,
                    'message' => $pesan,
                ],
                CURLOPT_HTTPHEADER => [
                    'Authorization: NqQL5JXUDcDrzyrPT7zF',
                ],
            ]);
            $response = curl_exec($ch);
            curl_close($ch);

            $res = json_decode($response, true);
            if (isset($res['status']) && $res['status'] === true) {
                $sukses++;
            } else {
                $gagal++;
            }
        }

        $this->log_aksi('Blast WA', "Blast notifikasi ke {$sukses} nomor, gagal: {$gagal}");
        echo json_encode([
            'success' => true,
            'message' => "Blast selesai! Berhasil: {$sukses}, Gagal: {$gagal}",
            'sukses'  => $sukses,
            'gagal'   => $gagal,
        ]);
    }

    public function list_notif() {
        //$this->only_admin();
        $total = $this->db->count_all('notif_wa');
        $this->output->set_content_type('application/json');
        echo json_encode(['total' => $total]);
    }

    // =============================================
    // DATA SISWA
    // =============================================
    public function siswa() {
        $search  = $this->input->get('search', TRUE);
        $jurusan = $this->input->get('jurusan', TRUE);
        $status  = $this->input->get('status', TRUE);
        $kelas   = $this->input->get('kelas', TRUE);
        $sort    = $this->input->get('sort', TRUE); // <-- tambah ini

        $per_page   = 10;
        $total_rows = $this->Siswa_model->count_filter($search, $jurusan, $status, $kelas, $sort);
        $page       = $this->input->get('page') !== NULL ? (int)$this->input->get('page') : 0;

        $query_filter = http_build_query(array_filter([
            'search'  => $search,
            'jurusan' => $jurusan,
            'status'  => $status,
            'kelas'   => $kelas,
            'sort'    => $sort, // <-- tambah ini
        ]));

        $this->load->library('pagination');
        $config = [
            'base_url'             => site_url('admin/siswa') . ($query_filter ? '?' . $query_filter . '&' : '?'),
            'total_rows'           => $total_rows,
            'per_page'             => $per_page,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'page',
            'use_page_numbers'     => FALSE,
            'reuse_query_string'   => TRUE,
            'full_tag_open'        => '<ul class="pagination">',
            'full_tag_close'       => '</ul>',
            'num_tag_open'         => '<li>',
            'num_tag_close'        => '</li>',
            'cur_tag_open'         => '<li class="active"><span>',
            'cur_tag_close'        => '</span></li>',
            'prev_link'            => '&lsaquo;',
            'prev_tag_open'        => '<li>',
            'prev_tag_close'       => '</li>',
            'next_link'            => '&rsaquo;',
            'next_tag_open'        => '<li>',
            'next_tag_close'       => '</li>',
            'first_link'           => FALSE,
            'last_link'            => FALSE,
        ];
        $this->pagination->initialize($config);

        $data = [
            'title'      => 'Data Siswa',
            'list_siswa' => $this->Siswa_model->get_filter($search, $jurusan, $status, $kelas, $per_page, $page, $sort),
            'total'      => $total_rows,
            'pagination' => $this->pagination->create_links(),
            'search'     => $search,
            'jurusan'    => $jurusan,
            'status'     => $status,
            'kelas'      => $kelas,
            'sort'       => $sort,
            'page'       => $page,
            'list_kelas' => $this->Siswa_model->get_kelas(),
        ];
        $this->render('admin/siswa', $data);
    }

    public function tambah_siswa() {
        $data = ['title' => 'Tambah Siswa'];
        $this->render('admin/form_siswa', $data);
    }

    public function simpan_siswa() {
        $this->form_validation->set_rules('nisn', 'NISN', 'required|trim|is_unique[siswa.nisn]|min_length[10]|max_length[10]|numeric', [
            'required'   => 'NISN wajib diisi.',
            'is_unique'  => 'NISN sudah terdaftar, gunakan NISN yang berbeda.',
            'min_length' => 'NISN harus 10 digit angka.',
            'max_length' => 'NISN harus 10 digit angka.',
            'numeric'    => 'NISN hanya boleh berisi angka.',
        ]);
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim|min_length[3]', [
            'required'   => 'Nama Siswa wajib diisi.',
            'min_length' => 'Nama Siswa minimal 3 karakter.',
        ]);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim', [
            'required' => 'Tempat Lahir wajib diisi.',
        ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required', [
            'required' => 'Tanggal Lahir wajib diisi.',
        ]);
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', [
            'required' => 'Kelas wajib diisi.',
        ]);
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required', [
            'required' => 'Jurusan wajib dipilih.',
        ]);
        $this->form_validation->set_rules('kelulusan', 'Status Kelulusan', 'required', [
            'required' => 'Status Kelulusan wajib dipilih.',
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect('admin/siswa/tambah');
        }

        $data = [
            'nisn'          => $this->input->post('nisn', TRUE),
            'nama_siswa'    => $this->input->post('nama_siswa', TRUE),
            'tempat_lahir'  => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
            'kelas'         => $this->input->post('kelas', TRUE),
            'jurusan'       => $this->input->post('jurusan', TRUE),
            'kelulusan'     => $this->input->post('kelulusan', TRUE),
            'tanggal_hadir' => $this->input->post('tanggal_hadir', TRUE) ?: NULL,
            'pukul_hadir'   => $this->input->post('pukul_hadir', TRUE) ?: NULL,
            'catatan'       => $this->input->post('catatan', TRUE),
        ];

        $this->Siswa_model->insert($data);
        $this->log_aksi('Tambah Siswa', 'Tambah data siswa NISN: ' . $data['nisn']);
        $this->session->set_flashdata('success', 'Data siswa berhasil ditambahkan!');
        redirect('admin/siswa');
    }

    public function edit_siswa($id) {
        $siswa = $this->Siswa_model->get_by_id($id);
        if (!$siswa) { show_404(); }
        $data = ['title' => 'Edit Data Siswa', 'siswa' => $siswa];
        $this->render('admin/form_siswa', $data);
    }

    public function update_siswa($id) {
        $siswa = $this->Siswa_model->get_by_id($id);
        if (!$siswa) { show_404(); }

        $this->form_validation->set_rules('nisn', 'NISN', "required|trim|min_length[10]|max_length[10]|numeric", [
            'required'   => 'NISN wajib diisi.',
            'min_length' => 'NISN harus 10 digit angka.',
            'max_length' => 'NISN harus 10 digit angka.',
            'numeric'    => 'NISN hanya boleh berisi angka.',
        ]);
        $this->form_validation->set_rules('nama_siswa', 'Nama Siswa', 'required|trim|min_length[3]', [
            'required'   => 'Nama Siswa wajib diisi.',
            'min_length' => 'Nama Siswa minimal 3 karakter.',
        ]);
        $this->form_validation->set_rules('tempat_lahir', 'Tempat Lahir', 'required|trim', [
            'required' => 'Tempat Lahir wajib diisi.',
        ]);
        $this->form_validation->set_rules('tanggal_lahir', 'Tanggal Lahir', 'required', [
            'required' => 'Tanggal Lahir wajib diisi.',
        ]);
        $this->form_validation->set_rules('kelas', 'Kelas', 'required|trim', [
            'required' => 'Kelas wajib diisi.',
        ]);
        $this->form_validation->set_rules('jurusan', 'Jurusan', 'required', [
            'required' => 'Jurusan wajib dipilih.',
        ]);
        $this->form_validation->set_rules('kelulusan', 'Status Kelulusan', 'required', [
            'required' => 'Status Kelulusan wajib dipilih.',
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect("admin/siswa/edit/{$id}");
        }

        // Cek NISN duplikat, kecuali milik siswa ini sendiri
        $nisn_input = $this->input->post('nisn', TRUE);
        $cek_nisn = $this->db->where('nisn', $nisn_input)->where('id !=', $id)->get('siswa')->row();
        if ($cek_nisn) {
            $this->session->set_flashdata('error', '<li>NISN sudah terdaftar, gunakan NISN yang berbeda.</li>');
            redirect("admin/siswa/edit/{$id}");
        }

        $data = [
            'nisn'          => $nisn_input,
            'nama_siswa'    => $this->input->post('nama_siswa', TRUE),
            'tempat_lahir'  => $this->input->post('tempat_lahir', TRUE),
            'tanggal_lahir' => $this->input->post('tanggal_lahir', TRUE),
            'kelas'         => $this->input->post('kelas', TRUE),
            'jurusan'       => $this->input->post('jurusan', TRUE),
            'kelulusan'     => $this->input->post('kelulusan', TRUE),
            'tanggal_hadir' => $this->input->post('tanggal_hadir', TRUE) ?: NULL,
            'pukul_hadir'   => $this->input->post('pukul_hadir', TRUE) ?: NULL,
            'catatan'       => $this->input->post('catatan', TRUE),
        ];

        $this->Siswa_model->update($id, $data);
        $this->log_aksi('Edit Siswa', 'Update data siswa NISN: ' . $data['nisn']);
        $this->session->set_flashdata('success', 'Data siswa berhasil diperbarui!');
        redirect('admin/siswa');
    }

    public function hapus_siswa($id) {
        $siswa = $this->Siswa_model->get_by_id($id);
        if (!$siswa) { show_404(); }
        $this->Siswa_model->delete($id);
        $this->log_aksi('Hapus Siswa', 'Hapus data siswa NISN: ' . $siswa->nisn . ' - ' . $siswa->nama_siswa);
        $this->session->set_flashdata('success', 'Data siswa berhasil dihapus!');
        redirect('admin/siswa');
    }

    public function detail_siswa($id) {
        $siswa = $this->Siswa_model->get_by_id($id);
        if (!$siswa) { show_404(); }
        $data = ['title' => 'Detail Siswa', 'siswa' => $siswa];
        $this->render('admin/detail_siswa', $data);
    }

    public function import_siswa() {
        if (!isset($_FILES['file_excel']) || $_FILES['file_excel']['error'] !== 0) {
            $this->session->set_flashdata('error', 'Pilih file Excel terlebih dahulu!');
            redirect('admin/siswa');
        }

        $file = $_FILES['file_excel'];
        $ext  = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, ['xlsx', 'xls', 'csv'])) {
            $this->session->set_flashdata('error', 'Format file harus .xlsx, .xls, atau .csv!');
            redirect('admin/siswa');
        }

        $upload_path = FCPATH . 'uploads/excel/';
        $filename    = 'import_' . time() . '.' . $ext;
        move_uploaded_file($file['tmp_name'], $upload_path . $filename);

        if ($ext === 'csv') {
            $result = $this->_import_csv($upload_path . $filename);
        } else {
            $result = $this->_import_excel($upload_path . $filename);
        }

        unlink($upload_path . $filename);

        $this->log_aksi('Import Siswa', "Import {$result['sukses']} data siswa dari Excel");
        $this->session->set_flashdata('success', "Import berhasil! {$result['sukses']} data ditambahkan, {$result['gagal']} data gagal/duplikat.");
        redirect('admin/siswa');
    }

    private function _import_csv($filepath) {
        $handle = fopen($filepath, 'r');
        $row    = 0;
        $sukses = 0;
        $gagal  = 0;
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            $row++;
            if ($row === 1) continue;
            if (count($data) < 7) { $gagal++; continue; }
            $insert = [
                'nisn'          => trim($data[0]),
                'nama_siswa'    => trim($data[1]),
                'tempat_lahir'  => trim($data[2]),
                'tanggal_lahir' => $this->_convert_tanggal(trim($data[3])),
                'kelas'         => trim($data[4]),
                'jurusan'       => trim($data[5]),
                'kelulusan'     => trim($data[6]),
            ];
            $cek = $this->Siswa_model->get_by_nisn($insert['nisn']);
            if ($cek || strlen($insert['nisn']) < 10) { $gagal++; continue; }
            $this->Siswa_model->insert($insert);
            $sukses++;
        }
        fclose($handle);
        return ['sukses' => $sukses, 'gagal' => $gagal];
    }

    private function _import_excel($filepath) {
        require_once FCPATH . 'vendor/autoload.php';

        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filepath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows  = $sheet->toArray();
        $sukses = 0;
        $gagal  = 0;

        foreach ($rows as $i => $data) {
            if ($i === 0) continue;
            if (empty($data[0])) continue;
            if (count($data) < 7) { $gagal++; continue; }

            $rawTanggal = $sheet->getCell('D' . ($i + 1))->getValue();

            $insert = [
                'nisn'          => trim($data[0]),
                'nama_siswa'    => trim($data[1]),
                'tempat_lahir'  => trim($data[2]),
                'tanggal_lahir' => $this->_convert_tanggal_excel($rawTanggal, trim($data[3])),
                'kelas'         => trim($data[4]),
                'jurusan'       => trim($data[5]),
                'kelulusan'     => trim($data[6]),
            ];

            $cek = $this->Siswa_model->get_by_nisn($insert['nisn']);
            if ($cek || strlen($insert['nisn']) < 10) { $gagal++; continue; }

            $this->Siswa_model->insert($insert);
            $sukses++;
        }

        return ['sukses' => $sukses, 'gagal' => $gagal];
    }

    public function template_excel() {
        require_once FCPATH . 'vendor/autoload.php';

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // =====================
        // SHEET 1: Template
        // =====================
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Template Siswa');

        $headers = ['NISN', 'Nama Siswa', 'Tempat Lahir', 'Tanggal Lahir (DD/MM/YYYY)', 'Kelas', 'Jurusan', 'Status Kelulusan'];
        $cols    = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];

        $headerStyle = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2563EB']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB0C4DE']]],
        ];
        $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

        foreach ($headers as $i => $h) {
            $sheet->setCellValue($cols[$i] . '1', $h);
        }

        // Lebar kolom manual
        $sheet->getColumnDimension('A')->setWidth(18);  // NISN
        $sheet->getColumnDimension('B')->setWidth(28);  // Nama Siswa
        $sheet->getColumnDimension('C')->setWidth(20);  // Tempat Lahir
        $sheet->getColumnDimension('D')->setWidth(26);  // Tanggal Lahir
        $sheet->getColumnDimension('E')->setWidth(14);  // Kelas
        $sheet->getColumnDimension('F')->setWidth(48);  // Jurusan
        $sheet->getColumnDimension('G')->setWidth(20);  // Status Kelulusan

        // Format kolom A (NISN) sebagai teks agar tidak jadi scientific
        $sheet->getStyle('A2:A1000')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        // Format kolom D (Tanggal Lahir) sebagai teks agar tidak auto-convert
        $sheet->getStyle('D2:D1000')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $dataStyle = [
            'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFB0C4DE']]],
        ];
        for ($row = 2; $row <= 50; $row++) {
            $sheet->getStyle("A{$row}:G{$row}")->applyFromArray($dataStyle);
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        $sheet->freezePane('A2');

        // =====================
        // SHEET 2: Petunjuk
        // =====================
        $guide = $spreadsheet->createSheet();
        $guide->setTitle('Petunjuk Pengisian');

        // Judul
        $guide->setCellValue('A1', 'PETUNJUK PENGISIAN TEMPLATE IMPORT SISWA');
        $guide->mergeCells('A1:C1');
        $guide->getStyle('A1')->applyFromArray([
            'font'      => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FF1E40AF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT],
        ]);
        $guide->getRowDimension(1)->setRowHeight(28);

        // Header tabel petunjuk
        $guide->setCellValue('A3', 'Kolom');
        $guide->setCellValue('B3', 'Format / Aturan');
        $guide->setCellValue('C3', 'Contoh');
        $guide->getStyle('A3:C3')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E40AF']],
            'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        // Isi petunjuk
        $petunjuk = [
            ['NISN',             '10 digit angka, wajib unik',                                  '1234567890'],
            ['Nama Siswa',       'Nama lengkap siswa, minimal 3 karakter',                       'Ahmad Fauzi'],
            ['Tempat Lahir',     'Nama kota/kabupaten tempat lahir',                             'Banjarnegara'],
            ['Tanggal Lahir',    'Format DD/MM/YYYY',                                            '15/03/2007'],
            ['Kelas',            'Format: XII [Jurusan] [Nomor]',                                'XII TO 1'],
            ['Jurusan',          'Harus salah satu: "Teknik Otomotif" atau "Teknik Jaringan Komputer dan Telekomunikasi"', 'Teknik Otomotif'],
            ['Status Kelulusan', 'Harus salah satu: "Lulus" atau "Lulus Bersyarat"',             'Lulus'],
        ];

        $rowStyle = [
            'borders'   => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN, 'color' => ['argb' => 'FFCBD5E1']]],
            'alignment' => ['vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER, 'wrapText' => true],
        ];
        $altStyle = array_merge_recursive($rowStyle, [
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF0F7FF']],
        ]);

        foreach ($petunjuk as $i => $p) {
            $r = $i + 4;
            $guide->setCellValue("A{$r}", $p[0]);
            $guide->setCellValue("B{$r}", $p[1]);
            $guide->setCellValue("C{$r}", $p[2]);
            $guide->getStyle("A{$r}:C{$r}")->applyFromArray($i % 2 === 0 ? $rowStyle : $altStyle);
            $guide->getStyle("A{$r}")->getFont()->setBold(true);
            $guide->getRowDimension($r)->setRowHeight(30);
            $guide->getStyle("C{$r}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }

        // Catatan penting
        $noteRow = count($petunjuk) + 5;
        $guide->setCellValue("A{$noteRow}", '⚠ Catatan Penting:');
        $guide->getStyle("A{$noteRow}")->getFont()->setBold(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('FFDC2626'));

        $notes = [
            '• Baris pertama (header) jangan dihapus atau diubah.',
            '• Data duplikat (NISN sama) akan dilewati otomatis saat import.',
            '• Pastikan format tanggal DD/MM/YYYY, contoh: 15/03/2007.',
            '• Kolom Jurusan dan Status Kelulusan harus persis seperti contoh (huruf kapital diperhatikan).',
        ];
        foreach ($notes as $j => $note) {
            $nr = $noteRow + 1 + $j;
            $guide->setCellValue("A{$nr}", $note);
            $guide->mergeCells("A{$nr}:C{$nr}");
            $guide->getStyle("A{$nr}")->getFont()->setSize(10);
            $guide->getStyle("A{$nr}")->getAlignment()->setWrapText(true);
            $guide->getRowDimension($nr)->setRowHeight(18);
        }

        // Credit
        $creditRow = $noteRow + 1 + count($notes) + 1;
        $guide->setCellValue("A{$creditRow}", 'Developed by Ivan Zaka Mubarok');
        $guide->mergeCells("A{$creditRow}:C{$creditRow}");
        $guide->getStyle("A{$creditRow}")->applyFromArray([
            'font'      => ['italic' => true, 'size' => 10, 'color' => ['argb' => 'FF64748B']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT],
        ]);
        $guide->getRowDimension($creditRow)->setRowHeight(20);

        $guide->getColumnDimension('A')->setWidth(22);
        $guide->getColumnDimension('B')->setWidth(55);
        $guide->getColumnDimension('C')->setWidth(40);

        // Set sheet aktif ke template
        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="template_import_siswa_sipekel_developed_by_ivan_zaka_mubarok.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    // =============================================
    // PENGGUNA
    // =============================================
    public function pengguna() {
        $this->only_admin();
        $data = [
            'title' => 'Data Pengguna',
            'list'  => $this->Pengguna_model->get_all(),
        ];
        $this->render('admin/pengguna', $data);
    }

    public function tambah_pengguna() {
        $this->only_admin();
        $data = ['title' => 'Tambah Pengguna'];
        $this->render('admin/form_pengguna', $data);
    }

    public function simpan_pengguna() {
        $this->only_admin();
        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|min_length[3]', [
            'required'   => 'Nama Lengkap wajib diisi.',
            'min_length' => 'Nama Lengkap minimal 3 karakter.',
        ]);
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[pengguna.username]|min_length[4]|alpha_numeric', [
            'required'      => 'Username wajib diisi.',
            'is_unique'     => 'Username sudah digunakan, pilih username lain.',
            'min_length'    => 'Username minimal 4 karakter.',
            'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
            'required'   => 'Password wajib diisi.',
            'min_length' => 'Password minimal 6 karakter.',
        ]);
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'required|matches[password]', [
            'required' => 'Konfirmasi Password wajib diisi.',
            'matches'  => 'Konfirmasi Password tidak cocok.',
        ]);
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,petugas]', [
            'required' => 'Role wajib dipilih.',
            'in_list'  => 'Role tidak valid.',
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect('admin/pengguna/tambah');
        }

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'username'     => $this->input->post('username', TRUE),
            'password'     => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'role'         => $this->input->post('role', TRUE),
        ];

        $this->Pengguna_model->insert($data);
        $this->log_aksi('Tambah Pengguna', 'Tambah pengguna: ' . $data['username']);
        $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan!');
        redirect('admin/pengguna');
    }

    public function edit_pengguna($id) {
        $this->only_admin();
        $pengguna = $this->Pengguna_model->get_by_id($id);
        if (!$pengguna) { show_404(); }
        $data = ['title' => 'Edit Pengguna', 'pengguna' => $pengguna];
        $this->render('admin/form_pengguna', $data);
    }

    public function update_pengguna($id) {
        $this->only_admin();
        $pengguna = $this->Pengguna_model->get_by_id($id);
        if (!$pengguna) { show_404(); }

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required|trim|min_length[3]', [
            'required'   => 'Nama Lengkap wajib diisi.',
            'min_length' => 'Nama Lengkap minimal 3 karakter.',
        ]);
        $this->form_validation->set_rules('username', 'Username', "required|trim|min_length[4]|alpha_numeric", [
            'required'      => 'Username wajib diisi.',
            'min_length'    => 'Username minimal 4 karakter.',
            'alpha_numeric' => 'Username hanya boleh berisi huruf dan angka.',
        ]);
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,petugas]', [
            'required' => 'Role wajib dipilih.',
            'in_list'  => 'Role tidak valid.',
        ]);

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', validation_errors('<li>', '</li>'));
            redirect("admin/pengguna/edit/{$id}");
        }

        // Cek username duplikat, kecuali milik pengguna ini sendiri
        $username_input = $this->input->post('username', TRUE);
        $cek_username = $this->db->where('username', $username_input)
                                ->where('id !=', $id)
                                ->get('pengguna')->row();
        if ($cek_username) {
            $this->session->set_flashdata('error', '<li>Username sudah digunakan, pilih username lain.</li>');
            redirect("admin/pengguna/edit/{$id}");
        }

        $data = [
            'nama_lengkap' => $this->input->post('nama_lengkap', TRUE),
            'username'     => $this->input->post('username', TRUE),
            'role'         => $this->input->post('role', TRUE),
        ];

        $new_pass = $this->input->post('password');
        if (!empty($new_pass)) {
            $data['password'] = password_hash($new_pass, PASSWORD_BCRYPT);
        }

        $this->Pengguna_model->update($id, $data);
        $this->log_aksi('Edit Pengguna', 'Update pengguna: ' . $data['username']);
        $this->session->set_flashdata('success', 'Data pengguna berhasil diperbarui!');
        redirect('admin/pengguna');
    }

    public function hapus_pengguna($id) {
        $this->only_admin();
        if ($id == $this->session->userdata('id')) {
            $this->session->set_flashdata('error', 'Tidak bisa menghapus akun sendiri!');
            redirect('admin/pengguna');
        }
        $pengguna = $this->Pengguna_model->get_by_id($id);
        if (!$pengguna) { show_404(); }
        $this->Pengguna_model->delete($id);
        $this->log_aksi('Hapus Pengguna', 'Hapus pengguna: ' . $pengguna->username);
        $this->session->set_flashdata('success', 'Pengguna berhasil dihapus!');
        redirect('admin/pengguna');
    }

    // =============================================
    // LOG AKTIVITAS
    // =============================================
    public function log_aktivitas() {
        $this->only_admin();
        $per_page = 10;
        $total    = $this->Log_model->count_all();
        $page     = $this->input->get('page') !== NULL ? (int)$this->input->get('page') : 0;

        $this->load->library('pagination');
        $config = [
            'base_url'             => site_url('admin/log'),
            'total_rows'           => $total,
            'per_page'             => $per_page,
            'page_query_string'    => TRUE,
            'query_string_segment' => 'page',
            'use_page_numbers'     => FALSE,
            'full_tag_open'        => '<ul class="pagination">',
            'full_tag_close'       => '</ul>',
            'num_tag_open'         => '<li>',
            'num_tag_close'        => '</li>',
            'cur_tag_open'         => '<li class="active"><span>',
            'cur_tag_close'        => '</span></li>',
            'prev_link'            => '&lsaquo;',
            'prev_tag_open'        => '<li>',
            'prev_tag_close'       => '</li>',
            'next_link'            => '&rsaquo;',
            'next_tag_open'        => '<li>',
            'next_tag_close'       => '</li>',
            'first_link'           => FALSE,
            'last_link'            => FALSE,
        ];
        $this->pagination->initialize($config);

        $data = [
            'title'      => 'Log Aktivitas',
            'logs'       => $this->Log_model->get_paged($per_page, $page),
            'pagination' => $this->pagination->create_links(),
            'total'      => $total,
            'page'       => $page,
            'per_page'   => $per_page,
        ];
        $this->render('admin/log', $data);
    }

    // =============================================
    // STATISTIK
    // =============================================
    public function statistik() {
        $data = [
            'title'         => 'Statistik Kelulusan',
            'chart_jurusan' => $this->Siswa_model->chart_by_jurusan(),
            'chart_kelas'   => $this->Siswa_model->chart_by_kelas(),
            'chart_status'  => $this->Siswa_model->chart_by_status(),
        ];
        $this->render('admin/statistik', $data);
    }

    private function _convert_tanggal($tanggal) {
        // Konversi DD/MM/YYYY ke YYYY-MM-DD
        if (preg_match('/^(\d{2})\/(\d{2})\/(\d{4})$/', $tanggal, $m)) {
            return $m[3] . '-' . $m[2] . '-' . $m[1];
        }
        return $tanggal; // kembalikan apa adanya jika format lain
    }

    private function _convert_tanggal_excel($raw, $formatted) {
        // Jika nilai raw adalah angka (serial date Excel)
        if (is_numeric($raw) && $raw > 0) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($raw)->format('Y-m-d');
        }
        // Jika sudah string DD/MM/YYYY
        return $this->_convert_tanggal($formatted);
    }

    public function hapus_massal() {
        // Nonaktifkan CSRF check untuk AJAX request ini
        $this->output->set_content_type('application/json');

        // Ambil raw input
        $input = json_decode(file_get_contents('php://input'), true);
        $ids   = $input['ids'] ?? [];

        if (empty($ids)) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada data']);
            return;
        }

        foreach ($ids as $id) {
            $siswa = $this->Siswa_model->get_by_id((int)$id);
            if ($siswa) {
                $this->Siswa_model->delete((int)$id);
            }
        }

        $this->log_aksi('Hapus Massal', 'Hapus ' . count($ids) . ' data siswa');
        echo json_encode(['success' => true]);
    }

    public function hapus_semua() {
        $this->output->set_content_type('application/json');

        $input   = json_decode(file_get_contents('php://input'), true);
        $search  = $input['search']  ?? '';
        $jurusan = $input['jurusan'] ?? '';
        $status  = $input['status']  ?? '';
        $kelas   = $input['kelas']   ?? '';

        $list = $this->Siswa_model->get_filter($search, $jurusan, $status, $kelas, 99999, 0);

        if (empty($list)) {
            echo json_encode(['success' => false, 'message' => 'Tidak ada data']);
            return;
        }

        $count = 0;
        foreach ($list as $siswa) {
            $this->Siswa_model->delete($siswa->id);
            $count++;
        }

        $this->log_aksi('Hapus Semua', 'Hapus ' . $count . ' data siswa');
        echo json_encode(['success' => true, 'deleted' => $count]);
    }

    private function _generate_profil_json()
    {
        $profil = $this->db->get('profil_sekolah')->row();
        if ($profil) {
            $data = [
                'nama_sekolah'    => $profil->nama_sekolah ?? '',
                'nama_aplikasi'   => $profil->nama_aplikasi ?? '',
                'tahun_pelajaran' => $profil->tahun_pelajaran ?? '',
                'alamat_sekolah'  => $profil->alamat_sekolah ?? '',
            ];
            file_put_contents(FCPATH . 'profil.json', json_encode($data));
        }
    }
}