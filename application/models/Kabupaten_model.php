<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kabupaten_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all()
    {
        $this->db->order_by('nama_kabupaten', 'ASC');
        return $this->db->get('kabupaten')->result();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_kabupaten', $id);
        return $this->db->get('kabupaten')->row();
    }

    public function create($data)
    {
        $this->db->insert('kabupaten', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_kabupaten', $id);
        return $this->db->update('kabupaten', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_kabupaten', $id);
        return $this->db->delete('kabupaten');
    }

    public function nama_exists($nama_kabupaten, $exclude_id = null)
    {
        $this->db->where('nama_kabupaten', $nama_kabupaten);
        if ($exclude_id) {
            $this->db->where('id_kabupaten !=', $exclude_id);
        }
        return $this->db->count_all_results('kabupaten') > 0;
    }

    public function count_all()
    {
        return $this->db->count_all_results('kabupaten');
    }
}

