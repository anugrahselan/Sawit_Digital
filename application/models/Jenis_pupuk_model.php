<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_pupuk_model extends CI_Model
{
    private $_table = 'jenis_pupuk';

    public function get_all()
    {
        $this->db->order_by('id_pupuk', 'ASC');
        $query = $this->db->get($this->_table);
        return $query->result_array();
    }

    public function get_by_id($id)
    {
        $this->db->where('id_pupuk', $id);
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
        $this->db->where('id_pupuk', $id);
        $this->db->update($this->_table, $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delete($id)
    {
        $this->db->delete($this->_table, array('id_pupuk' => $id));
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function cari($kata_kunci)
    {
        $this->db->like('nama_pupuk', $kata_kunci);
        $this->db->or_like('kandungan', $kata_kunci);
        $this->db->or_like('fungsi', $kata_kunci);
        return $this->db->get($this->_table)->result_array();
    }

    public function get_dosis($id_pupuk, $id_tanah, $usia = null)
    {
        $this->db->where('id_pupuk', $id_pupuk);
        $this->db->where('id_tanah', $id_tanah);
        if ($usia !== null) {
            $this->db->where('usia_tanaman_min <=', $usia);
            $this->db->where('usia_tanaman_max >=', $usia);
        }
        return $this->db->get('dosis_pupuk')->result_array();
    }

    public function count_all()
    {
        return $this->db->count_all_results($this->_table);
    }
}
