<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tanah_model extends CI_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all (): array
    {
        $this->db->order_by('nama_tanah', 'ASC');
        return $this->db->get('jenis_tanah')->result();
    }

    public function get_by_id ($id): mixed
    {
        $this->db->where('id_tanah', $id);
        return $this->db->get('jenis_tanah')->row();
    }

    public function create ($data): int
    {
        $this->db->insert('jenis_tanah', $data);
        return $this->db->insert_id();
    }

    public function update ($id, $data): bool
    {
        $this->db->where('id_tanah', $id);
        return $this->db->update('jenis_tanah', $data);
    }

    public function delete ($id): bool
    {
        $this->db->where('id_tanah', $id);
        return $this->db->delete('jenis_tanah');
    }

    public function nama_exists ($nama_tanah, $exclude_id = null): bool
    {
        $this->db->where('nama_tanah', $nama_tanah);
        if ($exclude_id) {
            $this->db->where('id_tanah !=', $exclude_id);
        }
        return $this->db->count_all_results('jenis_tanah') > 0;
    }
}

