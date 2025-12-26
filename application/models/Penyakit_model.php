<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penyakit_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all diseases
     */
    public function get_all($limit = null, $offset = null) {
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('nama_penyakit', 'ASC');
        return $this->db->get('penyakit')->result();
    }

    /**
     * Get disease by ID
     */
    public function get_by_id($id) {
        $this->db->where('id_penyakit', $id);
        return $this->db->get('penyakit')->row();
    }

    /**
     * Search diseases
     */
    public function search($keyword) {
        $this->db->like('nama_penyakit', $keyword);
        $this->db->or_like('penyebab', $keyword);
        $this->db->or_like('gejala', $keyword);
        $this->db->order_by('nama_penyakit', 'ASC');
        return $this->db->get('penyakit')->result();
    }

    /**
     * Count total records
     */
    public function count_all() {
        return $this->db->count_all_results('penyakit');
    }
}

