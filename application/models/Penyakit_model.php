<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penyakit_model extends CI_Model
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
        $this->db->order_by('nama_penyakit', 'ASC');
        return $this->db->get('jenis_penyakit')->result();
    }

    public function get_by_id ($id): mixed
    {
        $this->db->where('id_penyakit', $id);
        return $this->db->get('jenis_penyakit')->row();
    }

    public function search ($keyword): array
    {
        $this->db->like('nama_penyakit', $keyword);
        $this->db->or_like('penyebab', $keyword);
        $this->db->or_like('gejala', $keyword);
        $this->db->order_by('nama_penyakit', 'ASC');
        return $this->db->get('jenis_penyakit')->result();
    }

    public function count_all (): int
    {
        return $this->db->count_all_results('jenis_penyakit');
    }

    public function create ($data): int
    {
        $this->db->insert('jenis_penyakit', $data);
        return $this->db->insert_id();
    }

    public function update ($id, $data): bool
    {
        $this->db->where('id_penyakit', $id);
        return $this->db->update('jenis_penyakit', $data);
    }

    public function delete ($id): bool
    {
        $this->db->where('id_penyakit', $id);
        return $this->db->delete('jenis_penyakit');
    }
}

