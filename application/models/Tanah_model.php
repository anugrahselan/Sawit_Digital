<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tanah_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Get all tanah types
     */
    public function get_all() {
        $this->db->order_by('nama_tanah', 'ASC');
        return $this->db->get('tanah')->result();
    }

    /**
     * Get tanah by ID
     */
    public function get_by_id($id) {
        $this->db->where('id_tanah', $id);
        return $this->db->get('tanah')->row();
    }
}

