<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_model extends CI_Model {
    protected $table = 'profil_sekolah';

    public function get_profil() {
        return $this->db->get($this->table)->row();
    }

    public function update($data) {
        $profil = $this->get_profil();
        if ($profil) {
            $this->db->update($this->table, $data, ['id' => $profil->id]);
        } else {
            $this->db->insert($this->table, $data);
        }
    }
}