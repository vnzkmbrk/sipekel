<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {
    protected $table = 'siswa';

    public function get_all($limit = NULL) {
        $this->db->order_by('created_at', 'DESC');
        if ($limit) $this->db->limit($limit);
        return $this->db->get($this->table)->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_by_nisn($nisn) {
        return $this->db->get_where($this->table, ['nisn' => $nisn])->row();
    }

    public function get_filter($search='', $jurusan='', $status='', $kelas='', $limit=10, $offset=0, $sort='') {
        $this->_apply_filter($search, $jurusan, $status, $kelas, $sort);
        $this->db->limit($limit, $offset);
        return $this->db->get($this->table)->result();
    }

    public function count_filter($search='', $jurusan='', $status='', $kelas='', $sort='') {
    $this->_apply_filter($search, $jurusan, $status, $kelas, $sort);
        return $this->db->count_all_results($this->table);
    }

    private function _apply_filter($search, $jurusan, $status, $kelas, $sort='') {
    if ($search) {
            $this->db->group_start();
            $this->db->like('nama_siswa', $search);
            $this->db->or_like('nisn', $search);
            $this->db->group_end();
        }

        if ($jurusan) $this->db->where('jurusan', $jurusan);
        if ($status)  $this->db->where('kelulusan', $status);
        if ($kelas)   $this->db->where('kelas', $kelas);

        switch ($sort) {
            case 'terbaru':
                $this->db->order_by('created_at', 'DESC');
                break;
            case 'terlama':
                $this->db->order_by('created_at', 'ASC');
                break;
            case 'jurusan_to':
                $this->db->order_by("FIELD(jurusan, 'Teknik Otomotif')", 'DESC', FALSE);
                $this->db->order_by('nama_siswa', 'ASC');
                break;
            case 'jurusan_tjkt':
                $this->db->order_by("FIELD(jurusan, 'Teknik Jaringan Komputer dan Telekomunikasi')", 'DESC', FALSE);
                $this->db->order_by('nama_siswa', 'ASC');
                break;
            case 'lulus':
                $this->db->order_by("FIELD(kelulusan, 'Lulus')", 'DESC', FALSE);
                $this->db->order_by('nama_siswa', 'ASC');
                break;
            case 'bersyarat':
                $this->db->order_by("FIELD(kelulusan, 'Lulus Bersyarat')", 'DESC', FALSE);
                $this->db->order_by('nama_siswa', 'ASC');
                break;
            default:
                $this->db->order_by('nama_siswa', 'ASC');
                break;
        }
    }

    public function count_all() {
        return $this->db->count_all($this->table);
    }

    public function count_by_status($status) {
        return $this->db->where('kelulusan', $status)->count_all_results($this->table);
    }

    public function count_by_jurusan($jurusan) {
        return $this->db->where('jurusan', $jurusan)->count_all_results($this->table);
    }

    public function get_kelas() {
        $this->db->select('kelas');
        $this->db->distinct();
        $this->db->order_by('kelas', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function chart_by_jurusan() {
        $this->db->select('jurusan, COUNT(*) as total');
        $this->db->group_by('jurusan');
        return $this->db->get($this->table)->result();
    }

    public function chart_by_kelas() {
        $this->db->select('kelas, kelulusan, COUNT(*) as total');
        $this->db->group_by(['kelas', 'kelulusan']);
        $this->db->order_by('kelas', 'ASC');
        return $this->db->get($this->table)->result();
    }

    public function chart_by_status() {
        $this->db->select('kelulusan, COUNT(*) as total');
        $this->db->group_by('kelulusan');
        return $this->db->get($this->table)->result();
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