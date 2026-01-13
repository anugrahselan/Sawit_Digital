<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit_model extends CI_Model
{
    private $_table = 'jenis_penyakit';

    public function get_all()
    {
        $this->db->order_by('id_penyakit', 'ASC');
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_penyakit', $id);
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
        $this->db->where('id_penyakit', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($id)
    {
        $this->db->delete($this->_table, array('id_penyakit' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function cari($kata_kunci)
    {
        $this->db->like('nama_penyakit', $kata_kunci);
        $this->db->or_like('penyebab', $kata_kunci);
        $this->db->or_like('gejala', $kata_kunci);
        return $this->db->get($this->_table)->result_array();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }
}
