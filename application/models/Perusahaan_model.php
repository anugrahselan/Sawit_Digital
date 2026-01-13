<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan_model extends CI_Model
{
    private $_table = 'perusahaan';

    public function get_all()
    {
        $this->db->select('perusahaan.*, kabupaten.nama_kabupaten');
        $this->db->from($this->_table);
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = perusahaan.id_kabupaten', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_perusahaan', $id);
        return $this->db->get($this->_table)->row_array();
    }

    public function create($data)
    {
        $this->db->insert($this->_table, $data);
        if ($this->db->affected_rows() != 1) {
            return false;
        }
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id_perusahaan', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($id)
    {
        $this->db->delete($this->_table, array('id_perusahaan' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }

    public function nama_ada_di_kabupaten($nama, $id_kabupaten, $kecuali_id = null)
    {
        $this->db->where('nama_perusahaan', $nama);
        $this->db->where('id_kabupaten', $id_kabupaten);
        if ($kecuali_id) {
            $this->db->where('id_perusahaan !=', $kecuali_id);
        }
        return $this->db->count_all_results($this->_table) > 0;
    }
    
    public function get_by_kabupaten($id_kabupaten)
    {
        $this->db->where('id_kabupaten', $id_kabupaten);
        return $this->db->get($this->_table)->result_array();
    }
    
    public function get_atau_buat_mitra($id_kabupaten)
    {
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('nama_perusahaan', 'Mitra');
        $mitra = $this->db->get($this->_table)->row_array();
        
        if ($mitra) {
            return $mitra['id_perusahaan'];
        }
        
        $data = array(
            'id_kabupaten' => (int) $id_kabupaten,
            'nama_perusahaan' => 'Mitra',
            'alamat' => null,
            'kontak' => null
        );
        
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }
}
