<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna_model extends CI_Model {
    protected $table = 'pengguna';

    public function get_all() {
        $this->db->order_by('nama_lengkap', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function cek_login($username, $password) {
        $user = $this->db->get_where($this->table, ['username' => $username, 'is_active' => 1])->row();
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return FALSE;
    }

    public function update_last_login($id) {
        $this->db->update($this->table, ['last_login' => date('Y-m-d H:i:s')], ['id' => $id]);
    }

    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data) {
        return $this->db->update($this->table, $data, ['id' => $id]);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}