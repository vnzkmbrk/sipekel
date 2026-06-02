<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Profil_model');
    }

    protected function get_profil() {
        return $this->Profil_model->get_profil();
    }
}

class Admin_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
        }
    }

    protected function only_admin() {
        if ($this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Akses ditolak. Fitur ini hanya untuk Admin.');
            redirect('admin/dashboard');
        }
    }

    protected function render($view, $data = array()) {
        $profil = $this->get_profil();
        $data['profil'] = $profil;
        $data['user'] = $this->session->userdata();
        $this->load->view('templates/header_admin', $data);
        $this->load->view($view, $data);
        $this->load->view('templates/footer_admin', $data);
    }

    protected function log_aksi($aksi, $keterangan = '') {
        $this->load->model('Log_model');
        $this->Log_model->catat($this->session->userdata('id'), $aksi, $keterangan);
    }
}