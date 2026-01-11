<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Harga_tbs_model extends CI_Model
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
        $this->db->order_by('tanggal', 'DESC');
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        return $this->db->get('harga_tbs')->result();
    }

    public function get_by_kabupaten ($id_kabupaten): array
    {
        $this->db->where('harga_tbs.id_kabupaten', $id_kabupaten);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        return $this->db->get('harga_tbs')->result();
    }

    public function get_latest ($limit = 10): array
    {
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_kabupaten', 'ASC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $this->db->limit($limit);
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        return $this->db->get('harga_tbs')->result();
    }

    public function get_harga_sebelumnya ($id_kabupaten, $id_perusahaan, $current_date): mixed
    {
        $current_date = date('Y-m-d', strtotime($current_date));
        $yesterday = date('Y-m-d', strtotime($current_date . ' -1 day'));
        
        $sql = "SELECT * FROM harga_tbs 
                WHERE id_kabupaten = ? 
                AND id_perusahaan = ? 
                AND DATE(tanggal) = ? 
                ORDER BY tanggal DESC 
                LIMIT 1";
        
        $query = $this->db->query($sql, array($id_kabupaten, $id_perusahaan, $yesterday));
        $result = $query->row();
        
        if (!$result) {
            $sql2 = "SELECT * FROM harga_tbs 
                     WHERE id_kabupaten = ? 
                     AND id_perusahaan = ? 
                     AND tanggal = ? 
                     ORDER BY tanggal DESC 
                     LIMIT 1";
            $query2 = $this->db->query($sql2, array($id_kabupaten, $id_perusahaan, $yesterday));
            $result = $query2->row();
        }
        
        if (!$result && $this->db->table_exists('harga_tbs_backup')) {
            $backup_result = $this->get_from_backup($id_kabupaten, $id_perusahaan, $yesterday);
            if ($backup_result) {
                $result = (object) [
                    'id_harga' => $backup_result->id_harga_original,
                    'id_kabupaten' => $backup_result->id_kabupaten,
                    'id_perusahaan' => $backup_result->id_perusahaan,
                    'tanggal' => $backup_result->tanggal,
                    'harga_per_kg' => $backup_result->harga_per_kg
                ];
            }
        }
        
        if (!$result) {
            $sql3 = "SELECT * FROM harga_tbs 
                     WHERE id_kabupaten = ? 
                     AND id_perusahaan = ? 
                     AND DATE(tanggal) < ? 
                     ORDER BY tanggal DESC 
                     LIMIT 1";
            $query3 = $this->db->query($sql3, array($id_kabupaten, $id_perusahaan, $current_date));
            $result = $query3->row();
            
            if (!$result) {
                $sql4 = "SELECT * FROM harga_tbs 
                         WHERE id_kabupaten = ? 
                         AND id_perusahaan = ? 
                         AND tanggal < ? 
                         ORDER BY tanggal DESC 
                         LIMIT 1";
                $query4 = $this->db->query($sql4, array($id_kabupaten, $id_perusahaan, $current_date));
                $result = $query4->row();
            }
        }
        
        if (!$result && $this->db->table_exists('harga_tbs_backup')) {
            $backup_result = $this->get_last_from_backup($id_kabupaten, $id_perusahaan, $current_date);
            if ($backup_result) {
                $result = (object) [
                    'id_harga' => $backup_result->id_harga_original,
                    'id_kabupaten' => $backup_result->id_kabupaten,
                    'id_perusahaan' => $backup_result->id_perusahaan,
                    'tanggal' => $backup_result->tanggal,
                    'harga_per_kg' => $backup_result->harga_per_kg
                ];
            }
        }
        
        return $result;
    }
    
    public function get_last_different_price ($id_kabupaten, $id_perusahaan, $current_date): mixed
    {
        $current_date = date('Y-m-d', strtotime($current_date));
        
        $sql = "SELECT * FROM harga_tbs 
                WHERE id_kabupaten = ? 
                AND id_perusahaan = ? 
                AND DATE(tanggal) != ? 
                ORDER BY tanggal DESC 
                LIMIT 1";
        
        $query = $this->db->query($sql, array($id_kabupaten, $id_perusahaan, $current_date));
        return $query->row();
    }
    
    public function get_harga_terbaru_per_perusahaan (): array
    {
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from('harga_tbs');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $all_prices = $this->db->get()->result();
        
        $latest_prices = [];
        $seen = [];
        
        foreach ($all_prices as $price) {
            $key = $price->id_kabupaten . '_' . $price->id_perusahaan;
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $latest_prices[] = $price;
            }
        }
        
        return $latest_prices;
    }
    
    public function get_harga_hari_ini (): array
    {
        $today = date('Y-m-d');
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from('harga_tbs');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        $this->db->where("DATE(harga_tbs.tanggal) = '{$today}'", NULL, FALSE);
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        $this->db->order_by('harga_tbs.id_kabupaten', 'ASC');
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $all_today = $this->db->get()->result();
        
        $latest_prices = [];
        $seen = [];
        
        foreach ($all_today as $price) {
            $key = $price->id_kabupaten . '_' . $price->id_perusahaan;
            if (!isset($seen[$key])) {
                $seen[$key] = true;
                $latest_prices[] = $price;
            }
        }
        
        return $latest_prices;
    }

    public function get_by_id ($id): mixed
    {
        $this->db->where('harga_tbs.id_harga', $id);
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from('harga_tbs');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        return $this->db->get()->row();
    }

    public function count_all (): int
    {
        return $this->db->count_all_results('harga_tbs');
    }
    
    public function get_all_filtered ($filters = [], $limit = null, $offset = null): array
    {
        $this->db->select('harga_tbs.*, kabupaten.nama_kabupaten, perusahaan.nama_perusahaan');
        $this->db->from('harga_tbs');
        $this->db->join('kabupaten', 'kabupaten.id_kabupaten = harga_tbs.id_kabupaten', 'left');
        $this->db->join('perusahaan', 'perusahaan.id_perusahaan = harga_tbs.id_perusahaan', 'left');
        
        if (!empty($filters['kabupaten'])) {
            $this->db->where('harga_tbs.id_kabupaten', $filters['kabupaten']);
        }
        if (!empty($filters['perusahaan'])) {
            $this->db->where('harga_tbs.id_perusahaan', $filters['perusahaan']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('harga_tbs.tanggal >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('harga_tbs.tanggal <=', $filters['date_to']);
        }
        
        $this->db->order_by('harga_tbs.tanggal', 'DESC');
        $this->db->order_by('harga_tbs.id_perusahaan', 'ASC');
        
        if ($limit !== null && $offset !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }
    
    public function count_all_filtered ($filters = []): int
    {
        $this->db->from('harga_tbs');
        
        if (!empty($filters['kabupaten'])) {
            $this->db->where('id_kabupaten', $filters['kabupaten']);
        }
        if (!empty($filters['perusahaan'])) {
            $this->db->where('id_perusahaan', $filters['perusahaan']);
        }
        if (!empty($filters['date_from'])) {
            $this->db->where('tanggal >=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $this->db->where('tanggal <=', $filters['date_to']);
        }
        
        return $this->db->count_all_results();
    }
    
    public function get_by_date_and_company ($tanggal, $id_perusahaan, $exclude_id = null): mixed
    {
        $this->db->where('tanggal', $tanggal);
        $this->db->where('id_perusahaan', $id_perusahaan);
        if ($exclude_id) {
            $this->db->where('id_harga !=', $exclude_id);
        }
        return $this->db->get('harga_tbs')->row();
    }
    
    public function create ($data): int
    {
        $this->db->insert('harga_tbs', $data);
        return $this->db->insert_id();
    }
    
    public function delete_yesterday_data ($id_kabupaten, $id_perusahaan, $current_date, $deleted_by = null): int
    {
        $current_date = date('Y-m-d', strtotime($current_date));
        $yesterday = date('Y-m-d', strtotime($current_date . ' -1 day'));
        
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->where("DATE(tanggal) = '{$yesterday}'", NULL, FALSE);
        $yesterday_data = $this->db->get('harga_tbs')->result();
        
        $deleted_count = 0;
        foreach ($yesterday_data as $data) {
            if ($this->delete($data->id_harga, $deleted_by)) {
                $deleted_count++;
            }
        }
        
        return $deleted_count;
    }
    
    public function update ($id, $data): bool
    {
        $this->db->where('id_harga', $id);
        return $this->db->update('harga_tbs', $data);
    }
    
    public function delete ($id, $deleted_by = null): bool
    {
        $this->backup_before_delete($id, $deleted_by);
        
        $this->db->where('id_harga', $id);
        return $this->db->delete('harga_tbs');
    }
    
    public function backup_before_delete ($id, $deleted_by = null): bool
    {
        $data = $this->get_by_id($id);
        
        if ($data) {
            if ($this->db->table_exists('harga_tbs_backup')) {
                $backup_data = [
                    'id_harga_original' => $data->id_harga,
                    'id_kabupaten' => $data->id_kabupaten,
                    'id_perusahaan' => $data->id_perusahaan,
                    'tanggal' => $data->tanggal,
                    'harga_per_kg' => $data->harga_per_kg,
                    'deleted_at' => date('Y-m-d H:i:s'),
                    'deleted_by' => $deleted_by
                ];
                
                $this->db->insert('harga_tbs_backup', $backup_data);
                return true;
            }
        }
        return false;
    }
    
    public function get_from_backup ($id_kabupaten, $id_perusahaan, $date): mixed
    {
        if (!$this->db->table_exists('harga_tbs_backup')) {
            return null;
        }
        
        $date = date('Y-m-d', strtotime($date));
        
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->where('DATE(tanggal)', $date);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get('harga_tbs_backup')->row();
    }
    
    public function get_last_from_backup ($id_kabupaten, $id_perusahaan, $current_date): mixed
    {
        if (!$this->db->table_exists('harga_tbs_backup')) {
            return null;
        }
        
        $current_date = date('Y-m-d', strtotime($current_date));
        
        $this->db->where('id_kabupaten', $id_kabupaten);
        $this->db->where('id_perusahaan', $id_perusahaan);
        $this->db->where('DATE(tanggal) <', $current_date);
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        
        return $this->db->get('harga_tbs_backup')->row();
    }
}

