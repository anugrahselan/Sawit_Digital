<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Perusahaan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($limit = null, $offset = null)
    {
        $this->db->select('perusahaan.*, kabupaten.nama_kabupaten');
        $this->db->from('perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = perusahaan.id_kabupaten', 'left');
        $this->db->order_by('perusahaan.nama_perusahaan', 'ASC');
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('perusahaan.*, kabupaten.nama_kabupaten');
        $this->db->from('perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = perusahaan.id_kabupaten', 'left');
        $this->db->where('perusahaan.id_perusahaan', $id);
        return $this->db->get()->row();
    }

    public function create($data)
    {
        $this->db->insert('perusahaan', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_perusahaan', $id);
        return $this->db->update('perusahaan', $data);
    }

    public function delete($id)
    {
        $this->db->where('id_perusahaan', $id);
        return $this->db->delete('perusahaan');
    }

    public function count_all()
    {
        return $this->db->count_all('perusahaan');
    }

    public function nama_exists_in_kabupaten($nama_perusahaan, $id_kabupaten, $exclude_id = null)
    {
        $this->db->where('nama_perusahaan', $nama_perusahaan);
        $this->db->where('id_kabupaten', $id_kabupaten);
        if ($exclude_id) {
            $this->db->where('id_perusahaan !=', $exclude_id);
        }
        return $this->db->count_all_results('perusahaan') > 0;
    }
    
    /**
     * Ambil perusahaan berdasarkan kabupaten
     */
    public function get_by_kabupaten($id_kabupaten)
    {
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->order_by('nama_perusahaan', 'ASC');
        return $this->db->get('perusahaan')->result();
    }
}

