<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kabupaten_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all(): array {
        $this->db->order_by('nama_kabupaten', 'ASC');
        return $this->db->get('kabupaten')->result();
    }

    public function get_by_id($id) {
        $this->db->where('id_kabupaten', $id);
        return $this->db->get('kabupaten')->row();
    }

    public function create($data): int {
        $this->db->insert('kabupaten', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data): bool {
        $this->db->where('id_kabupaten', $id);
        return $this->db->update('kabupaten', $data);
    }

    public function delete($id): bool {
        $this->db->where('id_kabupaten', $id);
        return $this->db->delete('kabupaten');
    }

    public function nama_exists($nama_kabupaten, $exclude_id = null): bool {
        $this->db->where('nama_kabupaten', $nama_kabupaten);
        if ($exclude_id) {
            $this->db->where('id_kabupaten !=', $exclude_id);
        }
        return $this->db->count_all_results('kabupaten') > 0;
    }

    public function count_all(): int {
        return $this->db->count_all_results('kabupaten');
    }
}

