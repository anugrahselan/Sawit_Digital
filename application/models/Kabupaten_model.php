<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kabupaten_model extends CI_Model
{
    private $_table = 'kabupaten';

    public function get_all()
    {
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_kabupaten', $id);
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
        $this->db->where('id_kabupaten', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($id)
    {
        $this->db->delete($this->_table, array('id_kabupaten' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function nama_ada($nama, $kecuali_id = null)
    {
        $this->db->where('nama_kabupaten', $nama);
        if ($kecuali_id) {
            $this->db->where('id_kabupaten !=', $kecuali_id);
        }
        return $this->db->count_all_results($this->_table) > 0;
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }
}
