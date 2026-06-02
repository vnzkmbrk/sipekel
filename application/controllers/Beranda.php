<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Beranda extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Siswa_model');
    }

    public function index() {
        $profil = $this->get_profil();
        $now = strtotime('now');
        $tgl_pengumuman = strtotime($profil->tanggal_pengumuman . ' ' . $profil->jam_pengumuman);
        $data = [
            'profil'         => $profil,
            'bisa_cek'       => ($now >= $tgl_pengumuman),
            'tgl_pengumuman' => $tgl_pengumuman,
            'total_siswa'    => $this->Siswa_model->count_all(),
            'total_lulus'    => $this->Siswa_model->count_by_status('Lulus'),
        ];
        $this->load->view('siswa/beranda', $data);
    }

    public function cek() {
        $profil = $this->get_profil();
        $now = strtotime('now');
        $tgl_pengumuman = strtotime($profil->tanggal_pengumuman . ' ' . $profil->jam_pengumuman);

        if ($now < $tgl_pengumuman) {
            $this->session->set_flashdata('error', 'Pengumuman belum dibuka. Harap tunggu sesuai jadwal.');
            redirect('/');
        }

        $nisn = $this->input->post('nisn', TRUE);
        if (!$nisn) {
            redirect('/');
        }

        $siswa = $this->Siswa_model->get_by_nisn($nisn);
        if (!$siswa) {
            $this->session->set_flashdata('error', 'NISN tidak ditemukan. Periksa kembali NISN Anda.');
            redirect('/');
        }

        $data = [
            'profil' => $profil,
            'siswa'  => $siswa,
        ];
        $this->load->view('siswa/hasil', $data);
    }

    public function cetak($nisn) {
        $profil = $this->get_profil();

        // ── Cek waktu pengumuman (kecuali admin & petugas) ──
        $role = $this->session->userdata('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            $now            = strtotime('now');
            $tgl_pengumuman = strtotime($profil->tanggal_pengumuman . ' ' . $profil->jam_pengumuman);

            if ($now < $tgl_pengumuman) {
                redirect('/');
            }
        }
        // ────────────────────────────────────────────────────

        $siswa = $this->Siswa_model->get_by_nisn($nisn);
        if (!$siswa) show_404();

        $data = ['profil' => $profil, 'siswa' => $siswa];
        $this->load->view('siswa/cetak', $data);
    }

    public function hasil($nisn) {
        $profil = $this->get_profil();

        // ── Cek waktu pengumuman (kecuali admin & petugas) ──
        $role = $this->session->userdata('role');
        if (!in_array($role, ['admin', 'petugas'])) {
            $now            = strtotime('now');
            $tgl_pengumuman = strtotime($profil->tanggal_pengumuman . ' ' . $profil->jam_pengumuman);

            if ($now < $tgl_pengumuman) {
                redirect('/');
            }
        }
        // ────────────────────────────────────────────────────

        $siswa = $this->Siswa_model->get_by_nisn($nisn);
        if (!$siswa) show_404();

        $data = ['profil' => $profil, 'siswa' => $siswa];
        $this->load->view('siswa/hasil', $data);
    }
}