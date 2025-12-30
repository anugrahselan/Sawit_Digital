<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perusahaan_model extends CI_Model
{
    public function __construct ()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all ($limit = null, $offset = null): array
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

    public function get_by_id ($id): mixed
    {
        $this->db->select('perusahaan.*, kabupaten.nama_kabupaten');
        $this->db->from('perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = perusahaan.id_kabupaten', 'left');
        $this->db->where('perusahaan.id_perusahaan', $id);
        return $this->db->get()->row();
    }

    public function create ($data): int
    {
        $this->db->insert('perusahaan', $data);
        return $this->db->insert_id();
    }

    public function update ($id, $data): bool
    {
        $this->db->where('id_perusahaan', $id);
        return $this->db->update('perusahaan', $data);
    }

    public function delete ($id): bool
    {
        $this->db->where('id_perusahaan', $id);
        return $this->db->delete('perusahaan');
    }

    public function count_all (): int
    {
        return $this->db->count_all('perusahaan');
    }

    public function nama_exists_in_kabupaten ($nama_perusahaan, $id_kabupaten, $exclude_id = null): bool
    {
        $this->db->where('nama_perusahaan', $nama_perusahaan);
        $this->db->where('id_kabupaten', $id_kabupaten);
        if ($exclude_id) {
            $this->db->where('id_perusahaan !=', $exclude_id);
        }
        return $this->db->count_all_results('perusahaan') > 0;
    }
    
    // Ambil perusahaan berdasarkan kabupaten
    public function get_by_kabupaten ($id_kabupaten): array
    {
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->order_by('nama_perusahaan', 'ASC');
        return $this->db->get('perusahaan')->result();
    }
    
    // Dapatkan atau buat record "Mitra" untuk kabupaten tertentu
    public function get_or_create_mitra ($id_kabupaten): int
    {
        // Cek apakah sudah ada record "Mitra" untuk kabupaten ini
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('nama_perusahaan', 'Mitra');
        $mitra = $this->db->get('perusahaan')->row();
        
        if ($mitra) {
            return $mitra->id_perusahaan;
        }
        
        // Jika belum ada, buat record "Mitra" baru
        $data = [
            'id_kabupaten' => (int) $id_kabupaten,
            'nama_perusahaan' => 'Mitra',
            'alamat' => null,
            'kontak' => null
        ];
        
        $this->db->insert('perusahaan', $data);
        return $this->db->insert_id();
    }
}

