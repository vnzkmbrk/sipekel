<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pengguna_model');
    }

    public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('admin/dashboard');
        }
        $profil = $this->get_profil();
        $this->load->view('auth/login', ['profil' => $profil]);
    }

    public function proses_login() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->session->set_flashdata('error', 'Username dan password wajib diisi.');
            redirect('login');
        }

        // ── Verifikasi Captcha ────────────────────────────────────
        $captcha_input  = (int) $this->input->post('captcha');
        $captcha_answer = (int) $this->session->userdata('captcha_answer');

        if ($captcha_input !== $captcha_answer) {
            $this->session->set_flashdata('error', 'Jawaban verifikasi salah. Silakan coba lagi.');
            redirect('login');
        }
        $this->session->unset_userdata('captcha_answer');
        // ─────────────────────────────────────────────────────────

        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        $user = $this->Pengguna_model->cek_login($username, $password);
        if ($user) {
            $sess = [
                'logged_in'    => TRUE,
                'id'           => $user->id,
                'nama_lengkap' => $user->nama_lengkap,
                'username'     => $user->username,
                'role'         => $user->role,
            ];
            $this->session->set_userdata($sess);
            $this->Pengguna_model->update_last_login($user->id);
            $this->load->model('Log_model');
            $this->Log_model->catat($user->id, 'Login', 'Login berhasil dari IP: ' . $this->input->ip_address());
            $this->session->set_flashdata('just_logged_in', true);
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Username atau Password Salah!');
            redirect('login');
        }
    }

    public function logout() {
        if ($this->session->userdata('logged_in')) {
            $this->load->model('Log_model');
            $this->Log_model->catat($this->session->userdata('id'), 'Logout', 'Logout dari sistem');
        }
        $this->session->sess_destroy();
        redirect('login');
    }
}