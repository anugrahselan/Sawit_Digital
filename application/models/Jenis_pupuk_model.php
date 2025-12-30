<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_pupuk_model extends CI_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all ($limit = null, $offset = null): array
    {
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('nama_pupuk', 'ASC');
        return $this->db->get('jenis_pupuk')->result();
    }

    public function get_by_id ($id): mixed
    {
        $this->db->where('id_pupuk', $id);
        return $this->db->get('jenis_pupuk')->row();
    }

    public function search ($keyword): array
    {
        $this->db->like('nama_pupuk', $keyword);
        $this->db->or_like('kandungan', $keyword);
        $this->db->or_like('fungsi', $keyword);
        $this->db->order_by('nama_pupuk', 'ASC');
        return $this->db->get('jenis_pupuk')->result();
    }

    public function get_dosis ($id_pupuk, $id_tanah, $usia_tanaman = null): array
    {
        $this->db->where('id_pupuk', $id_pupuk);
        $this->db->where('id_tanah', $id_tanah);
        if ($usia_tanaman !== null) {
            $this->db->where('usia_tanaman_min <=', $usia_tanaman);
            $this->db->where('usia_tanaman_max >=', $usia_tanaman);
        }
        return $this->db->get('dosis_pupuk')->result();
    }

    public function count_all (): int
    {
        return $this->db->count_all_results('jenis_pupuk');
    }

    public function create ($data): int
    {
        $this->db->insert('jenis_pupuk', $data);
        return $this->db->insert_id();
    }

    public function update ($id, $data): bool
    {
        $this->db->where('id_pupuk', $id);
        return $this->db->update('jenis_pupuk', $data);
    }

    public function delete ($id): bool
    {
        $this->db->where('id_pupuk', $id);
        return $this->db->delete('jenis_pupuk');
    }
}

