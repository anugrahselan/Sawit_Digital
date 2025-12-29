<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi_tambahan_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = null): array {
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('informasi_tambahan')->result();
    }

    public function get_by_id($id) {
        $this->db->where('id_info', $id);
        return $this->db->get('informasi_tambahan')->row();
    }

    public function get_latest($limit = 5): array {
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('informasi_tambahan')->result();
    }

    public function search($keyword): array {
        $this->db->like('judul', $keyword);
        $this->db->or_like('konten', $keyword);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get('informasi_tambahan')->result();
    }

    public function count_all(): int {
        return $this->db->count_all_results('informasi_tambahan');
    }

    public function create($data): int {
        $this->db->insert('informasi_tambahan', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data): bool {
        $this->db->where('id_info', $id);
        return $this->db->update('informasi_tambahan', $data);
    }

    public function delete($id): bool {
        $this->db->where('id_info', $id);
        return $this->db->delete('informasi_tambahan');
    }
}

