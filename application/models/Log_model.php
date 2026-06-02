<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {
    protected $table = 'log_aktivitas';

    public function catat($pengguna_id, $aksi, $keterangan = '') {
        $data = [
            'pengguna_id' => $pengguna_id,
            'aksi'        => $aksi,
            'keterangan'  => $keterangan,
            'ip_address'  => $this->input->ip_address(),
        ];
        return $this->db->insert($this->table, $data);
    }

    public function get_recent($limit = 10) {
        $this->db->select('log_aktivitas.*, pengguna.nama_lengkap, pengguna.username');
        $this->db->join('pengguna', 'pengguna.id = log_aktivitas.pengguna_id', 'left');
        $this->db->order_by('log_aktivitas.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }

    public function get_all() {
        $this->db->select('log_aktivitas.*, pengguna.nama_lengkap, pengguna.username');
        $this->db->join('pengguna', 'pengguna.id = log_aktivitas.pengguna_id', 'left');
        $this->db->order_by('log_aktivitas.created_at', 'DESC');
        $this->db->limit(500);
        return $this->db->get($this->table)->result();
    }

    public function count_all() {
    return $this->db->count_all('log_aktivitas');
    }

    public function get_paged($limit, $offset) {
        $this->db->select('log_aktivitas.*, pengguna.nama_lengkap, pengguna.username');
        $this->db->join('pengguna', 'pengguna.id = log_aktivitas.pengguna_id', 'left');
        $this->db->order_by('log_aktivitas.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }
}