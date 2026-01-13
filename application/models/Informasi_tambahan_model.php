<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Informasi_tambahan_model extends CI_Model
{
    private $_table = 'informasi_tambahan';

    public function get_all()
    {
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_info', $id);
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
        $this->db->where('id_info', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($id)
    {
        $this->db->delete($this->_table, array('id_info' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function get_terbaru($batas = 5)
    {
        $this->db->limit($batas);
        return $this->db->get($this->_table)->result_array();
    }

    public function cari($kata_kunci)
    {
        $this->db->like('judul', $kata_kunci);
        $this->db->or_like('konten', $kata_kunci);
        return $this->db->get($this->_table)->result_array();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }
}
